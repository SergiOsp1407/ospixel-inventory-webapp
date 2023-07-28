<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
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
            <td class="info-sale">
                <div class="cointainer-invoice">
                    <span class="invoice"><strong>Crédito</strong></span>
                    <p><strong>N°: </strong><?php echo $data['credit']['id']; ?></p>
                    <p><strong>Fecha: </strong><?php echo $data['credit']['date']; ?></p>
                    <p><strong>Hora: </strong><?php echo $data['credit']['time']; ?></p>
                </div>
            </td>
        </tr>
    </table>


    <h5 class="title">Datos del Cliente</h5>
    <table id="container-info">
        <tr>
            <td>
                <strong><?php echo $data['credit']['identity_type']; ?> :</strong>
                <p><?php echo $data['credit']['client_identity']; ?></p>
            </td>
            <td>
                <strong>Nombre: </strong>
                <p><?php echo $data['credit']['name']; ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Teléfono: </strong>
                <p><?php echo $data['credit']['phone']; ?></p>
            </td>
            <td>
                <strong>Dirección: </strong>
                <p><?php echo $data['credit']['address']; ?></p>
            </td>
        </tr>
    </table>
    <h5 class="title">Detalle de los productos</h5>
    <table id="container-product">
        <thead>
            <tr>
                <th>Cantidad</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>SubTotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $products = json_decode($data['credit']['products'], true);

            foreach ($products as $product) { ?>
                <tr class="products-tr">
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo number_format($product['quantity'] * $product['price'], 2); ?></td>
                </tr>
            <?php } ?>
            <tr class="total">
                <td class="text-right" colspan="3">Valor crédito</td>
                <td class="text-left"><?php echo number_format($data['credit']['value_credit'], 2); ?></td>
            </tr>
        </tbody>
    </table>
    <!-- <div class="paymentMethod">
        <p><strong>Método de pago: </strong><?php echo $data['sale']['payment_method']; ?></p>
    </div> -->

    <h5 class="title">Detalle de los Abonos</h5>
    <table id="container-product">
        <thead>
            <tr>
                <th>Fecha</th> <!-- date -->
                <th>Abono</th> <!-- partial_payment -->
            </tr>
        </thead>
        <tbody>
            <?php
            $paid = 0;
            foreach ($data['partialpayments'] as $partialpayment) {
                $paid += $partialpayment['partial_payment'];
            ?>
                <tr class="partialpayments-tr">
                    <td class="text-center"><?php echo $partialpayment['date']; ?></td>
                    <td class="text-center"><?php echo number_format($partialpayment['partial_payment'], 2); ?></td>
                </tr>
            <?php } ?>
            <tr class="total">
                <td class="text-right">Abonado</td>
                <td class="text-right"><?php echo number_format($paid, 2); ?></td>
            </tr>
            <tr class="total">
                <td class="text-right">Restante</td>
                <td class="text-right"><?php echo number_format($data['credit']['value_credit'] - $paid, 2); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="message">
        <?php echo $data['company']['message']; ?>
    </div>

    <div class="cancelSale">
        <?php if ($data['credit']['status'] == 0) { ?>
            <h1>Crédito finalizado</h1>
        <?php } else { ?>
            <h1>Crédito pendiente</h1>
        <?php } ?>
    </div>
</body>

</html>