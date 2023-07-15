<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-purchases-tab" data-bs-toggle="tab" data-bs-target="#nav-purchases" type="button" role="tab" aria-controls="nav-purchases" aria-selected="true">Compras</button>
                <button class="nav-link" id="nav-history-tab" data-bs-toggle="tab" data-bs-target="#nav-history" type="button" role="tab" aria-controls="nav-history" aria-selected="false">Historial</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active p-3" id="nav-purchases" role="tabpanel" aria-labelledby="nav-purchases-tab" tabindex="0">
                <h5 class="card-title text-center"><i class="fa-solid fa-boxes-stacked"></i> Nueva Compra</h5>
                <hr>
                <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                    <label class="btn btn-dark">
                        <input type="radio" hidden><i class="fas fa-barcode"></i> Código de barras
                    </label>
                    <label class="btn btn-info">
                        <input type="radio" hidden><i class="fas fa-list"></i> Nombre
                    </label>
                </div>
                <!-- Input for search -->
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input class="form-control" type="text" id="searchProduct" placeholder="Buscar producto" aria-describedby="my-addon">
                </div>

                <!-- Products table -->
                <table class="table table-bordered table-striped table-hover" id="tblNewPurchase" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <hr>

                <div class="d-flex justify-content-between">
                    <div class="col-md-4">
                        <label>Buscar proveedor</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control" type="text" id="searchSupplier" placeholder="Buscar proveedor">
                        </div>

                        <label>Teléfono</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input class="form-control" type="text" id="phone" placeholder="Teléfono" disabled>
                        </div>

                        <label>Dirección</label>
                        <ul class="list-group">
                            <li class="list-group-item"><i class="fas fa-home"></i></span></li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <label>Comprador</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input class="form-control" type="text" placeholder="Comprador" disabled>
                        </div>

                        <label>Total a pagar</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            <input class="form-control" type="text" id="totalPay" placeholder="Total a pagar" disabled>
                        </div>

                        <label>Serie</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-spinner"></i></span>
                            <input class="form-control" type="text" id="serie" placeholder="Serie compra">
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-success" type="button">Generar compra</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab" tabindex="0">

            </div>
        </div>
    </div>
</div>
<?php include_once 'views/templates/footer.php'; ?>