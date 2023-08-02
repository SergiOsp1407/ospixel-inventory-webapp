<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-reservations-tab" data-bs-toggle="tab" data-bs-target="#nav-reservations" type="button" role="tab" aria-controls="nav-reservations" aria-selected="true">Reservaciones</button>
                <button class="nav-link" id="nav-history-tab" data-bs-toggle="tab" data-bs-target="#nav-history" type="button" role="tab" aria-controls="nav-history" aria-selected="false">Historial</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active p-3" id="nav-reservations" role="tabpanel" aria-labelledby="nav-reservations-tab" tabindex="0">
                <h5 class="card-title text-center"><i class="fa-solid fa-list-alt"></i> Reservas</h5>
                <hr>
                <div id='calendar'></div>
                <input type="hidden" id="actualDate" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="tab-pane fade p-3" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab" tabindex="0">
                <div class="d-flex justify-content-center mb-3">
                    <div class="form-group">
                        <label for="from">Desde</label>
                        <input id="from" class="form-control" type="date">
                    </div>
                    <div class="form-group">
                        <label for="until">Hasta</label>
                        <input id="until" class="form-control" type="date">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblHistory" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Fecha</th> <!-- date_create -->
                                <th>Client</th> <!-- name -->
                                <th>Abono</th> <!-- partialPayment -->
                                <th>Total</th> <!-- total -->
                                <th>Fecha reserva</th> <!-- date_reservation -->
                                <th>Fecha retiro</th> <!-- date_retirement -->
                                <th>Estado</th> <!-- status -->
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>



<div id="modalReservation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reservar Productos</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                            <label class="btn btn-dark">
                                <input type="radio" id="barCode" hidden name="searchProduct" checked><i class="fas fa-barcode"></i> Código de barras
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" id="description" hidden name="searchProduct"><i class="fas fa-list"></i> Nombre
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- Input to search by code -->
                        <div class="input-group d-none mb-2" id="containerCode">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control" type="text" id="searchByProductCode" placeholder="Ingresar código de producto" autocomplete="off">
                        </div>

                        <!-- Input to search by name -->
                        <div class="input-group mb-2" id="containerName">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control" type="text" id="searchByProductName" placeholder="Ingresar nombre del producto" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <!-- Products table -->
                            <table class="table table-bordered table-striped table-hover align-middle" id="tblNewReservation" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-between">
                    <div class="col-md-4">
                        <label>Buscar Cliente</label>
                        <div class="input-group mb-2">
                            <input type="hidden" id="idClient">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control" type="text" id="searchClient" placeholder="Buscar cliente">
                        </div>

                        <label>Teléfono</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input class="form-control" type="text" id="phone" placeholder="Teléfono" disabled>
                        </div>

                        <label>Dirección</label>
                        <ul class="list-group">
                            <li class="list-group-item" id="address"><i class="fas fa-home"></i></li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <label>Vendedor</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input class="form-control" type="text" value="<?php echo $_SESSION['name_user']; ?>" placeholder="Vendedor" disabled>
                        </div>

                        <label>Total a pagar</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            <input class="form-control" type="text" id="totalPay" placeholder="Total a pagar" disabled>
                        </div>

                        <label>Fecha Reserva</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input class="form-control" type="date" id="date_reservation" min="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label>Fecha Retiro</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input class="form-control" type="date" id="date_retirement">
                        </div>

                        <label>Abono</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            <input class="form-control" type="number" step="0.01" min="0.01" id="partialPayment" placeholder="Abono">
                        </div>

                        <label>Color</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="bi bi-palette-fill"></i></span>
                            <input class="form-control" type="color" id="color">
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-outline-success" type="button" id="btnAction">Generar reserva</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalRetirement" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Procesar entrega</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idReservation">
                <label>Cliente</label>
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input class="form-control" type="text" id="clientReservation" disabled>
                </div>

                <label>Monto abonado</label>
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <input class="form-control" type="text" id="partialPaymentRet" disabled>
                </div>

                <label>Total</label>
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <input class="form-control" type="text" id="total" disabled>
                </div>

                <label>Saldo pendiente</label>
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <input class="form-control" type="text" id="missingToPay" disabled>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary" type="button" id="btnProcess">Procesar</button>
                </div>

            </div>
        </div>
    </div>
</div>


<?php include_once 'views/templates/footer.php'; ?>