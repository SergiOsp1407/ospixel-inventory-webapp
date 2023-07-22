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
                    <span class="invoice"><strong>Factura de venta</strong></span>
                    <p><strong>N°: </strong><?php echo $data['sale']['serie']; ?></p>
                    <p><strong>Fecha: </strong><?php echo $data['sale']['date']; ?></p>
                    <p><strong>Hora: </strong><?php echo $data['sale']['time']; ?></p>
                </div>
            </td>
        </tr>
    </table>


    <h5 class="title">Datos del Cliente</h5>
    <table id="container-info">
        <tr>
            <td>
                <strong><?php echo $data['sale']['identity_type'];?> :</strong>
                <p><?php echo $data['sale']['client_identity']; ?></p>
            </td>
            <td>
                <strong>Nombre: </strong>
                <p><?php echo $data['sale']['name']; ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Teléfono: </strong>
                <p><?php echo $data['sale']['phone']; ?></p>
            </td>
            <td>
                <strong>Dirección: </strong>
                <p><?php echo $data['sale']['address']; ?></p>
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
            $products = json_decode($data['sale']['products'], true);

            // //Tax (IVA 19%) included
            // $subtotal = $data['sale']['total'] / 1.19;
            // $taxes = $data['sale']['total'] - $subtotal;
            // $totalWithoutDiscount = $data['sale']['total'] - $data['sale']['discount'];
            // $totalWithDiscount = $data['sale']['total'];

            //Tax (IVA 19%) NOT included
            $subtotal = $data['sale']['total'] - $data['sale']['discount'];
            $taxes = $subtotal * 0.19;
            $total = $subtotal + $taxes;


            foreach ($products as $product) { ?>
                <tr class="products-tr">
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo number_format($product['quantity'] * $product['price'], 2); ?></td>
                </tr>
            <?php } ?>
            <tr class="total">
                <td class="text-right" colspan="3">Descuento</td>
                <td class="text-left"><?php echo number_format($data['sale']['discount'], 2); ?></td>
            </tr>
            <tr class="total">
                <td class="text-right" colspan="3">Subtotal</td>
                <td class="text-left"><?php echo number_format($subtotal, 2); ?></td>
            </tr>
            <tr class="total">
                <td class="text-right" colspan="3">IVA 19%</td>
                <td class="text-left"><?php echo number_format($taxes, 2); ?></td>
            </tr>
            <tr class="total">
                <td class="text-right" colspan="3">Total</td>
                <td class="text-left"><?php echo number_format($total, 2); ?></td>
            </tr>

        </tbody>
    </table>
     <!-- <div class="paymentMethod">
        <p><strong>Método de pago: </strong><?php echo $data['sale']['payment_method']; ?></p>
    </div> -->
    
    <div class="message">
        <?php echo $data['company']['message']; ?>
    </div>

    <div class="cancelSale">
        <?php if($data['sale']['status'] == 0) {?>
            <h1>Venta anulada</h1>
        <?php } ?>
    </div>
</body>

</html>