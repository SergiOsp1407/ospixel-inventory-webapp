<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL . 'assets/css/receipt.css'; ?>">
</head>

<body>
    <!-- <div class="container"></div>     -->
    <img class="img-logo" src="<?php echo BASE_URL . 'assets/images/logo_os.png'; ?>">
    <div class="data-company">
        <p><?php echo $data['company']['name']; ?></p>
        <p>Teléfono: <?php echo $data['company']['phone']; ?></p>
        <p>Dirección: <?php echo $data['company']['address']; ?></p>
    </div>
    <h5 class="title">Datos del Cliente</h5>
    <div class="data-info">
        <p><strong><?php echo $data['quote']['identity_type']; ?>:</strong><?php echo $data['quote']['client_identity']; ?></p>
        <p><strong>Nombre: </strong><?php echo $data['quote']['name']; ?></p>
        <p><strong>Teléfono: </strong><?php echo $data['quote']['phone']; ?></p>
    </div>
    <h5 class="title">Detalle de los productos</h5>
    <table>
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
            $products = json_decode($data['quote']['products'], true);
            foreach ($products as $product) { ?>
                <tr class="products-tr">
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo number_format($product['quantity'] * $product['price'], 2); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td class="text-right" colspan="3">Descuento</td>
                <td class="text-left"><?php echo number_format($data['quote']['discount'], 2); ?></td>
            </tr>
            <tr>
                <td class="text-right" colspan="3">Total con descuento</td>
                <td class="text-left"><?php echo number_format($data['quote']['total'] - $data['quote']['discount'], 2); ?></td>
            </tr>
        </tbody>
    </table>
    <div class="paymentMethod">
        <p><strong>Método: </strong><?php echo $data['quote']['method']; ?></p>
        <p><strong>Validez: </strong><?php echo $data['quote']['validity']; ?> días</p>
    </div>
    <div class="message">
        <?php echo $data['company']['message']; ?>
    </div>
</body>

</html>