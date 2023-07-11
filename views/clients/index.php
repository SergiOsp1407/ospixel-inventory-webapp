<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-clients-tab" data-bs-toggle="tab" data-bs-target="#nav-clients" type="button" role="tab" aria-controls="nav-clients" aria-selected="true">Clientes</button>
                <button class="nav-link" id="nav-new-tab" data-bs-toggle="tab" data-bs-target="#nav-new" type="button" role="tab" aria-controls="nav-new" aria-selected="false">Nuevo</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-2" id="nav-clients" role="tabpanel" aria-labelledby="nav-clients-tab" tabindex="0">
                <h5 class="card-title  text-center"><i class="fa-solid fa-users"></i> Listado de clientes</h5>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover nowrap" id="tblClients" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Tipo de identidad</th> <!-- identity_type -->
                                <th>Nro identificación</th> <!-- client_identity -->
                                <th>Nombre</th> <!-- name -->
                                <th>Telefóno</th> <!-- phone -->
                                <th>Correo electrónico</th> <!-- email -->
                                <th>Dirección</th> <!-- address -->
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
                        <div class="col-md-12">
                            <label for="client">Clientes</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                <input class="form-control" type="text" name="client" id="client" placeholder="Cliente">
                            </div>
                            <span id="errorClient" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-danger" type="button" id="btnNew">Nuevo</button>
                        <button class="btn btn-primary" type="submit" id="btnAction">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/templates/footer.php'; ?>