<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title'] ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL . 'assets/css/invoice.css'; ?>">
</head>

<body>
    <table id="data-company">
        <tr>
            <td class="logo">
                <img class="img-logo" src="<?php echo BASE_URL . 'assets/images/logo_os.png'; ?>">
            </td>
            <td class="info-company">
                <p><?php echo $data['company']['name']; ?></p>
                <p>NIT: <?php echo $data['company']['nit']; ?></p>
                <p>Teléfono: <?php echo $data['company']['phone']; ?></p>
                <p>Dirección: <?php echo $data['company']['address']; ?></p>
            </td>
            <td class="info-quote">
                <div class="cointainer-invoice">
                    <span class="invoice"><strong>Transacciones</strong></span>
                    <!-- <p><strong>N°: </strong><?php echo $data['quote']['id']; ?></p>
                    <p><strong>Fecha: </strong><?php echo $data['quote']['date']; ?></p> -->
                    <?php if ($data['actual']) { ?>
                        <p><strong>Usuario: </strong><?php echo $_SESSION['name_user']; ?></p>
                        <!-- <p><strong>Hora: </strong><?php echo $data['quote']['time']; ?></p> -->
                    <?php } else { ?>
                        <p>Reporte N°: <strong><?php echo $data['idCashdesk'] ?></strong></p>
                    <?php } ?>
                </div>
            </td>
        </tr>
    </table>

    <table id="container-product">
        <thead>
            <tr>
                <th>Monto Inicial</th> <!--initial_value -->
                <th>Ingresos</th>
                <th>Egresos</th>
                <th>Gastos</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr class="products-tr">
                <td><?php echo $data['transactions']['initialValueDecimal']; ?></td>
                <td><?php echo $data['transactions']['incomeDecimal']; ?></td>
                <td><?php echo $data['transactions']['outgoingsDecimal']; ?></td>
                <td><?php echo $data['transactions']['expensesDecimal']; ?></td>
                <td><?php echo $data['transactions']['remainderDecimal']; ?></td>
            </tr>
        </tbody>
    </table>
    <div class="message">
        <?php echo $data['company']['message']; ?>
    </div>
</body>

</html>