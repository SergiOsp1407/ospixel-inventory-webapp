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
    <h5 class="title">Datos del Proveedor</h5>
    <div class="data-info">
        <p><strong>NIT: </strong><?php echo $data['purchase']['nit']; ?></p>
        <p><strong>Nombre: </strong><?php echo $data['purchase']['name']; ?></p>
        <p><strong>Teléfono: </strong><?php echo $data['purchase']['phone']; ?></p>
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
            $products = json_decode($data['purchase']['products'], true);
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
                <td class="text-left"><?php echo number_format($data['purchase']['total'], 2); ?></td>
            </tr>
        </tbody>
    </table>
    <div class="message">
        <?php echo $data['company']['message']; ?>
    </div>
    <div class="cancelPurchase">
        <?php if($data['purchase']['status'] == 0) {?>
            <h1>Compra anulada</h1>
        <?php } ?>
    </div>
</body>

</html>