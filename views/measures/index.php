<?php include_once 'views/templates/header.php'; ?>


<div class="card">
    <div class="card-body">
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
            <div class="tab-pane fade" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab" tabindex="0">

            </div>
        </div>
    </div>
</div>
<?php include_once 'views/templates/footer.php'; ?>