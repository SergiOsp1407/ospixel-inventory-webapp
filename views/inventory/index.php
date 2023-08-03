<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-inventory-tab" data-bs-toggle="tab" data-bs-target="#nav-inventory" type="button" role="tab" aria-controls="nav-inventory" aria-selected="true">Inventario</button>
                <button class="nav-link" id="nav-kardex-tab" data-bs-toggle="tab" data-bs-target="#nav-kardex" type="button" role="tab" aria-controls="nav-kardex" aria-selected="false">Kardex</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-2" id="nav-inventory" role="tabpanel" aria-labelledby="nav-inventory-tab" tabindex="0">
                <div class="alert alert-info border-0 bg-info alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-dark"><i class='fa-solid fa-circle-check'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-dark">Movimientos de los productos</h6>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <label for="month">Mes Inventario</label>
                <div class="d-flex mb-2">
                    <div class="form-group">
                        <input id="month" class="form-control" type="month">
                    </div>
                    <div>
                        <button class="btn btn-primary" type="button" id="btnSearch"><i class="fas fa-search"></i></button>
                        <button class="btn btn-danger" type="button" id="btnReport"><i class="fas fa-file-pdf"></i></button>
                        <button class="btn btn-info" type="button"><i class="fas fa-cog"></i></button>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblInventory" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Producto</th> <!-- identity_type -->
                                <th>Movimiento | Transacción</th> <!-- client_identity -->
                                <th>Fecha</th> <!-- name -->
                                <th>Cantidad</th> <!-- phone -->
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-kardex" role="tabpanel" aria-labelledby="nav-kardex-tab" tabindex="0">
                <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                    <label class="btn btn-dark">
                        <input type="radio" id="barCode" hidden name="searchProduct" checked><i class="fas fa-barcode"></i> Código de barras
                    </label>
                    <label class="btn btn-info">
                        <input type="radio" id="description" hidden name="searchProduct"><i class="fas fa-list"></i> Nombre
                    </label>
                </div>

                <!-- Input to search by code -->
                <div class="input-group d-none mb-2" id="containerCode">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input class="form-control" type="text" id="searchByProductCode" placeholder="Ingresar código de producto" autocomplete="off">
                    <span class="input-group-text"><button class="btn btn-danger" type="button"><i class="fas fa-file-pdf"></i></button></span>
                </div>

                <!-- Input to search by name -->
                <div class="input-group mb-2" id="containerName">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input class="form-control" type="text" id="searchByProductName" placeholder="Ingresar nombre del producto" autocomplete="off">
                    <span class="input-group-text"><button class="btn btn-danger" type="button"><i class="fas fa-file-pdf"></i></button></span>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include_once 'views/templates/footer.php'; ?>