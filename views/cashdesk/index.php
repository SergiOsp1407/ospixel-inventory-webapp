<?php include_once 'views/templates/header.php'; ?>


<div class="card">
    <div class="card-body">
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white"><i class='bx bxs-check-circle'></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">Success Alerts</h6>
                    <div class="text-white">A simple success alert—check it out!</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <h5 class="card-title  text-center"><i class="fa-solid fa-cash-register"></i> Historial caja</h5>
        <hr>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-opening-tab" data-bs-toggle="tab" data-bs-target="#nav-opening" type="button" role="tab" aria-controls="nav-opening" aria-selected="true">Aperturas y Cierres</button>
                <button class="nav-link" id="nav-new-tab" data-bs-toggle="tab" data-bs-target="#nav-new" type="button" role="tab" aria-controls="nav-new" aria-selected="false">Nuevo gasto</button>
                <button class="nav-link" id="nav-history-tab" data-bs-toggle="tab" data-bs-target="#nav-history" type="button" role="tab" aria-controls="nav-history" aria-selected="false">Historial gastos</button>
                <button class="nav-link" id="nav-transactions-tab" data-bs-toggle="tab" data-bs-target="#nav-transactions" type="button" role="tab" aria-controls="nav-transactions" aria-selected="false">Movimientos</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-2" id="nav-opening" role="tabpanel" aria-labelledby="nav-opening-tab" tabindex="0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblOpenCloseCash" style="width: 100%;">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab" tabindex="0">
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
                    <input class="form-control" type="text" name="" placeholder="Recipient's text">
                </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab" tabindex="0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblExpenses" style="width: 100%;">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-transactions" role="tabpanel" aria-labelledby="nav-transactions-tab" tabindex="0">
                Gráfico
            </div>
        </div>

    </div>
</div>
<?php include_once 'views/templates/footer.php'; ?>