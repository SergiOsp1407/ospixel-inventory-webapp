<?php
// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;
class Cashdesk extends Controller
{

    private $id_user;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->id_user = $_SESSION['id_user'];
    }

    public function index()
    {

        $data['script'] = 'cashdesk.js';
        $data['title'] = 'Movimientos en caja';
        $data['cashdesk'] = $this->model->getCashdesk($this->id_user);
        $this->views->getView('cashdesk', 'index', $data);
    }

    public function openCashdesk()
    {

        $json = file_get_contents('php://input');
        $dataSet = json_decode($json, true);
        if (empty(['amount'])) {
            $response = array('msg' => 'El valor es requerido', 'type' => 'warning');
        } else {
            $check = $this->model->getCashdesk($this->id_user);
            if (empty($check)) {
                $opening_date = date('Y-m-d');
                $initial_value = strClean($dataSet['amount']);
                $data = $this->model->openCashdesk($initial_value, $opening_date, $this->id_user);
                if ($data > 0) {
                    $response = array('msg' => 'Caja abierta con éxito', 'type' => 'success');
                } else {
                    $response = array('msg' => 'Error al abrir la caja', 'type' => 'error');
                }
            } else {
                $response = array('msg' => 'La caja ya se encuentra abierta', 'type' => 'warning');
            }
        }
        echo json_encode($response);
        die();
    }

    public function list()
    {
        $data = $this->model->getCashdesks();
        echo json_encode($data);
        die();
    }

    public function registerExpense()
    {
        if (isset($_POST['value']) && isset($_POST['description'])) {
            if (empty($_POST['value'])) {
                $response = array('msg' => 'El valor es requerido!', 'type' => 'warning');
            } else if (empty($_POST['description'])) {
                $response = array('msg' => 'La descripción es requerida', 'type' => 'warning');
            } else {
                $value = strClean($_POST['value']);
                $checkValue = $this->getDataset();
                $income = $checkValue['remainder'];
                if ($value > $income) {
                    $response = array('msg' => 'No hay dinero disponible en caja', 'type' => 'error');
                } else {
                    $description = strClean($_POST['description']);
                    $photo = $_FILES['photo'];
                    $name = $photo['name'];
                    $tmp = $photo['tmp_name'];

                    $route = null;
                    if (!empty($name)) {
                        $date = date('YmdHis');
                        $route = 'assets/images/expenses/' . $date . '.png';
                    }
                    $data = $this->model->registerExpense($value, $description, $route, $this->id_user);
                    if ($data > 0) {
                        if (!empty($name)) {
                            move_uploaded_file($tmp, $route);
                        }
                        $response = array('msg' => 'Gasto registrado', 'type' => 'success');
                    } else {
                        $response = array('msg' => 'Error al registrar el gasto', 'type' => 'error');
                    }
                }
            }
        }
        echo json_encode($response);
        die();
    }

    public function listExpenses()
    {
        $data = $this->model->getExpenses();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['photo'] = '<a href="' . BASE_URL . $data[$i]['photo'] . '" target="_blank">
            <img class="img-thumbnail" src="' . BASE_URL . $data[$i]['photo'] . '" width="100">
            </a>';
        }
        echo json_encode($data);
        die();
    }

    public function transactions()
    {
        $data = $this->getDataset();
        $data['currency'] = CURRENCY;
        echo json_encode($data);
        die();
    }

    public function getDataset()
    {

        $querySale = $this->model->getSales('total',$this->id_user);
        $sales = ($querySale['totalSales'] != null) ? $querySale['totalSales'] : 0;

        $queryDiscount = $this->model->getSales('discount',$this->id_user);
        $discount = ($queryDiscount['totalSales'] != null) ? $queryDiscount['totalSales'] : 0;

        $queryReservation = $this->model->getReservations($this->id_user);
        $reservations = ($queryReservation['totalReservation'] != null) ? $queryReservation['totalReservation'] : 0;

        $queryCredits = $this->model->getPayments($this->id_user);
        $credits = ($queryCredits['totalPayments'] != null) ? $queryCredits['totalPayments'] : 0;

        $queryPurchase = $this->model->getPurchases($this->id_user);
        $purchases = ($queryPurchase['totalPurchases'] != null) ? $queryPurchase['totalPurchases'] : 0;

        $queryExpense = $this->model->getTotalExpenses($this->id_user);
        $expenses = ($queryExpense['totalExpenses'] != null) ? $queryExpense['totalExpenses'] : 0;

        $initialAmount = $this->model->getCashdesk($this->id_user);

        $data['outgoings'] = $purchases + $expenses;
        $data['income'] = ($sales + $reservations + $credits) - $discount;
        $data['initialValue'] = (!empty($initialAmount['initial_value'])) ? $initialAmount['initial_value'] : 0;
        $data['expenses'] = $expenses;
        $data['remainder'] = ($data['income'] + $data['initialValue']) - $data['outgoings'];

        $data['outgoingsDecimal'] = number_format($data['outgoings'], 2);
        $data['incomeDecimal'] = number_format($data['income'], 2);
        $data['initialValueDecimal'] = number_format($data['initialValue'], 2);
        $data['expensesDecimal'] = number_format($data['expenses'], 2);
        $data['remainderDecimal'] = number_format($data['remainder'], 2);

        return $data;
    }

    //Using Dompdf for reports with PDF
    public function report()
    {
        ob_start();
    
        $data['title'] = 'Reporte';
        $data['company'] = $this->model->getCompany();
        $data['transactions'] = $this->getDataset();

        $this->views->getView('cashdesk', 'report', $data);
        $html = ob_get_clean();
    
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isJavascriptEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);
    
        // (Optional) Setup the paper size and orientation
        // $dompdf->setPaper(array(0, 0, 222, 841), 'portrait');
        // $dompdf->setPaper('letter', 'portrait');
        $dompdf->setPaper('A4', 'vertical');
        
        // Render the HTML as PDF
        $dompdf->render();
    
        // Output the generated PDF to Browser
        $dompdf->stream('Reporte.pdf', array('Attachment' => false));
    }
}
