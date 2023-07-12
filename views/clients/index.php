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
                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'clients/inactives'; ?>"><i class="fas fa-trash text-danger"></i> Inactivos</a>
                    </li>
                </ul>
            </div>
        </div>
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
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblClients" style="width: 100%;">
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
                        <div class="col-md-2 mb-3">
                            <div class="form-group">
                                <label for="identity_type">T. Identificación <span class="text-danger">*</span></label>
                                <select id="identity_type" class="form-control" name="identity_type">
                                    <option value="">Seleccionar</option>
                                    <option value="NIT">NIT</option>
                                    <option value="Cedula">Cedula</option>
                                    <option value="CedulaExtranjeria">Cedula de extranjeria</option>
                                </select>
                            </div>
                            <span id="errorIdentityType" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="client_identity">Nro identificación <span class="text-danger">*</span> </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                <input class="form-control" type="number" name="client_identity" id="client_identity" placeholder="Número identificación">
                            </div>
                            <span id="errorClientIdentity" class="text-danger"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name">Nombre cliente <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                <input class="form-control" type="text" name="name" id="name" placeholder="Nombre del cliente">
                            </div>
                            <span id="errorClientName" class="text-danger"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone">Teléfono <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input class="form-control" type="number" name="phone" id="phone" placeholder="Teléfono">
                            </div>
                            <span id="errorPhone" class="text-danger"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email">Correo electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope-at-fill"></i></span>
                                <input class="form-control" type="text" name="email" id="email" placeholder="Correo electrónico">
                            </div>
                            <span id="errorEmail" class="text-danger"></span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="address">Dirección <span class="text-danger">*</span></label>
                                <textarea id="address" class="form-control" name="address" rows="3" placeholder="Dirección"></textarea>
                            </div>
                            <span id="errorAddress" class="text-danger"></span>
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