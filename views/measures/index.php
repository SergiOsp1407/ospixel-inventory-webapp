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
                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'measures/inactives'; ?>"><i class="fas fa-trash text-danger"></i> Inactivos</a>
                    </li>
                </ul>
            </div>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-measures-tab" data-bs-toggle="tab" data-bs-target="#nav-measures" type="button" role="tab" aria-controls="nav-measures" aria-selected="true">Medidas</button>
                <button class="nav-link" id="nav-new-tab" data-bs-toggle="tab" data-bs-target="#nav-new" type="button" role="tab" aria-controls="nav-new" aria-selected="false">Nuevo</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-2" id="nav-measures" role="tabpanel" aria-labelledby="nav-measures-tab" tabindex="0">
                <h5 class="card-title  text-center"><i class="fa-solid fa-list"></i> Listado de medidas o dimensiones</h5>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover nowrap" id="tblMeasures" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Abreviación</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab" tabindex="0">
                <form id="form" autocomplete="off">
                    <input type="hidden" id="id" name="id">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="measure">Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                <input class="form-control" type="text" name="measure" id="measure" placeholder="Medida/Dimensión">
                            </div>
                            <span id="errorMeasure" class="text-danger"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="short_name">Abreviación</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                <input class="form-control" type="text" name="short_name" id="short_name" placeholder="Abreviación">
                            </div>
                            <span id="errorShortname" class="text-danger"></span>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-primary" type="submit" id="btnAction">Registrar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once 'views/templates/footer.php'; ?>