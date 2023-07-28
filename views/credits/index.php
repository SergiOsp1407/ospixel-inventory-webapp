<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div>
            </div>
            <div class="dropdown ms-auto">
                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                </a>
                <ul class="dropdown-menu">

                    <li><a class="dropdown-item" href="#" id="newPartialPayment"><i class="fas fa-dollar-sign"></i> Abonos</a>
                    </li>
                </ul>
            </div>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-credits-tab" data-bs-toggle="tab" data-bs-target="#nav-credits" type="button" role="tab" aria-controls="nav-credits" aria-selected="true">Créditos</button>
                <button class="nav-link" id="nav-partialpayment-tab" data-bs-toggle="tab" data-bs-target="#nav-partialpayment" type="button" role="tab" aria-controls="nav-partialpayment" aria-selected="false">Abonos</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-2" id="nav-credits" role="tabpanel" aria-labelledby="nav-credits-tab" tabindex="0">
                <h5 class="card-title  text-center"><i class="fa-solid fa-credit-card"></i> Listado de Créditos</h5>
                <hr>
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
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblCredits" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Fecha</th> <!-- date -->
                                <th>Monto</th> <!-- value_credit -->
                                <th>Cliente</th> <!-- client_name -->
                                <th>Saldo restante</th> <!--  -->
                                <th>Abonado</th> <!--  -->
                                <th>N° Venta / Factura</th> <!-- sale_number -->
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-partialpayment" role="tabpanel" aria-labelledby="nav-partialpayment-tab" tabindex="0">
                

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblPartialPayments" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Fecha</th> <!-- date -->
                                <th>Abono</th> <!-- partial_payment -->
                                <th>N° Crédito</th> <!-- credit -->
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

<!-- Modal for create partial payments (abonos) -->
<div id="modalPartialpayment" class="modal fade" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Abono</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Buscar Cliente</label>
                        <div class="input-group mb-2">
                            <input type="hidden" id="idCredit">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control" type="text" id="searchClient" placeholder="Buscar cliente">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label>Teléfono</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input class="form-control" type="text" id="phone" placeholder="Teléfono" disabled>
                        </div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>Dirección</label>
                        <ul class="list-group">
                            <li class="list-group-item" id="address"><i class="fas fa-home"></i></li>
                        </ul>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Abonado</label>
                        <div class="input-group">
                            <span class="input-group-text"> <i class="fas fa-dollar-sign"></i></span>
                            <input class="form-control" type="text" id="partialpayment" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Restante</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            <input class="form-control" type="text" id="remainingbalance" readonly>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="form-group">
                            <label for="date">Fecha Venta</label>
                            <input id="date" class="form-control" type="text" placeholder="Fecha Venta" readonly>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="form-group">
                            <label for="value_credit">Monto Total</label>
                            <input id="value_credit" class="form-control" type="text" placeholder="Monto Total" readonly>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="form-group">
                            <label for="paid_value">Abonar</label>
                            <input id="paid_value" class="form-control" type="number" step="0.01" min="0.01 placeholder=" Abonar">
                        </div>
                    </div>
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary" type="button" id="btnAction">Abonar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'views/templates/footer.php'; ?>