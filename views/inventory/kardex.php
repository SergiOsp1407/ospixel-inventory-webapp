<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>
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
                    <span class="invoice"><strong>Entradas - Salidas</strong></span>
                    <p><strong>Fecha y Hora: </strong><?php echo date('d-m-Y H:i:s'); ?></p>
                </div>
            </td>
        </tr>
    </table>

    <h5 class="title">Movimientos</h5>
    <table id="container-product">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Entrada</th>
                <th>Salidas</th>
                <th>Fecha y Hora</th>
                <th>Stock Actual</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($data['kardex'] as $kardex) { ?>
                <tr class="products-tr">
                    <td><?php echo $kardex['description']; ?></td>
                    <td><?php echo $kardex['input']; ?></td>
                    <td><?php echo $kardex['output']; ?></td>
                    <td><?php echo $kardex['date']; ?></td>
                    <td><?php echo $kardex['stock_actual']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>    
    <div class="message">
        <?php echo $data['company']['message']; ?>
    </div>
</body>

</html>