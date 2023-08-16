<?php include_once 'views/templates/header.php'; ?>
<div class="card">
    <div class="card-body">
        <div class="alert alert-<?php echo (!empty($data['cashdesk'])) ? 'success' : 'danger'; ?> border-0 bg-<?php echo (!empty($data['cashdesk'])) ? 'success' : 'danger'; ?> alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white">
                    <?php if (!empty($data['cashdesk'])) {
                        echo '<i class="fa-solid fa-lock-open"></i>';
                    } else {

                        echo '<i class="fa-solid fa-lock"></i>';
                    } ?>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">
                        <?php if (!empty($data['cashdesk'])) {
                            echo ' Caja Abierta';
                        } else {

                            echo ' Caja Cerrada';
                        } ?></h6>
                    <div class="text-white"><?php echo (!empty($data['cashdesk'])) ? 'Puedes empezar a registrar movimientos!' : 'Debes abrir la caja para poder registar movimientos'; ?></div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="d-flex align-items-center">
            <div>
                <h5 class="card-title  text-center"><i class="fa-solid fa-cash-register"></i> Historial caja</h5>
            </div>
            <div class="dropdown ms-auto">
                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                </a>
                <ul class="dropdown-menu">
                    <?php if (empty($data['cashdesk'])) { ?>
                        <li><a class="dropdown-item" href=#" data-bs-toggle="modal" data-bs-target="#modalCashdesk"><i class="fa-solid fa-box-open"></i> Apertura de caja </a>
                        </li>
                    <?php } else { ?>
                        <li><a class="dropdown-item" href=#" onclick="closeCashdesk()"><i class="fa-solid fa-lock"></i> Cerrar caja </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        
        <hr>
        <?php if (!empty($data['cashdesk'])) { ?>
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
                                    <th>Monto Inicial</th> <!--initial_value -->
                                    <th>Fecha Apertura</th> <!--opening_date -->
                                    <th>Fecha Cierre</th> <!--closing_date -->
                                    <th>Monto Final</th> <!--final_value -->
                                    <th>Total # ventas</th> <!--total_sales_quantity -->
                                    <th>Usuario</th><!-- id_user -->
                                    <th></th><!--  -->
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade p-3" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab" tabindex="0">
                    <form id="form">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="hidden" id="id">
                                <label>Monto <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
                                    <input class="form-control" id="value" type="text" name="value" placeholder="Monto">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="description">Descripción del producto <span class="text-danger">*</span></label>
                                    <textarea id="description" class="form-control" name="description" rows="3" placeholder="Descripción"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                    <label for="photo">Foto (Opcional)</label>
                                    <input id="photo" class="form-control" type="file" name="photo">
                                </div>
                                <div id="containerPreview">
                                </div>
                            </div>
                        </div>
                        <div class="float-end">
                            <button class="btn btn-primary" type="submit" id="btnRegisterExpense">Registrar</button>
                        </div>
                    </form>

                </div>
                <div class="tab-pane fade p-3" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab" tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblExpenses" style="width: 100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Monto</th>
                                    <th>Descripción</th>
                                    <th>Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade p-3" id="nav-transactions" role="tabpanel" aria-labelledby="nav-transactions-tab" tabindex="0">
                    <div class="d-flex align-items-center">
                        <div></div>
                        <div class="dropdown ms-auto">
                            <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL . 'cashdesk/report'; ?>" target="_blank"><i class="fa-solid fa-file-pdf text-danger"></i> Reporte </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="chart-container-1">
                        <canvas id="transactionReport"></canvas>
                    </div>
                    <ul class="list-group list-group-flush" id="listTransactions">
                    </ul>

                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div id="modalCashdesk" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Abrir Caja</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <label>Monto Inicial</label>
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <input class="form-control" type="text" id="initial_value" placeholder="Monto Inicial">
                </div>
                <div class="d-grid">
                    <button class="btn btn-success" type="button" id="btnOpenCashdesh">Abrir</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'views/templates/footer.php'; ?>