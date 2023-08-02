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
            <td class="info-reservation">
                <div class="cointainer-invoice">
                    <span class="invoice"><strong>Reserva</strong></span>
                    <p><strong>N°: </strong><?php echo $data['reservation']['id']; ?></p>
                    <p><strong>Fecha y Hora: </strong><?php echo $data['reservation']['date_reservation']; ?></p>
                </div>
            </td>
        </tr>
    </table>


    <h5 class="title">Datos del Cliente</h5>
    <table id="container-info">
        <tr>
            <td>
                <strong><?php echo $data['reservation']['identity_type']; ?> :</strong>
                <p><?php echo $data['reservation']['client_identity']; ?></p>
            </td>
            <td>
                <strong>Nombre: </strong>
                <p><?php echo $data['reservation']['name']; ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Teléfono: </strong>
                <p><?php echo $data['reservation']['phone']; ?></p>
            </td>
            <td>
                <strong>Dirección: </strong>
                <p><?php echo $data['reservation']['address']; ?></p>
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
            $products = json_decode($data['reservation']['products'], true);

            foreach ($products as $product) { ?>
                <tr class="products-tr">
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo number_format($product['quantity'] * $product['price'], 2); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td class="text-right" colspan="3">Total</td>
                <td class="text-left"><?php echo number_format($data['reservation']['total'], 2); ?></td>
            </tr>
        </tbody>
    </table>
    <div class="message">
        <?php if ($data['reservation']['status'] == 0) { ?>
            <h1 style="color: red;">Productos entregados</h1>
        <?php } else { ?> 
            <h1 style="color: red;">Productos pendientes por recoger</h1>
        <?php } ?>

        <?php echo $data['company']['message']; ?>
    </div>
</body>

</html>