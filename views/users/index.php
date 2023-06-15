<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-users-tab" data-bs-toggle="tab" data-bs-target="#nav-users" type="button" role="tab" aria-controls="nav-users" aria-selected="true">Usuarios</button>
                <button class="nav-link" id="nav-new-tab" data-bs-toggle="tab" data-bs-target="#nav-new" type="button" role="tab" aria-controls="nav-new" aria-selected="false">Nuevo</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-2" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab" tabindex="0">
                <h5 class="card-title  text-center"><i class="fa-solid fa-user-group"></i> Listado de usuarios</h5>
                <hr>
                <table class="table table-bordered table-striped table-hover" id="tblUsers" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Rol</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab" tabindex="0">
                <div class="row p-5">
                    <div class="col-lg-4 col-sm-6">
                        <label>Nombres</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"> <i class="fas fa-list"></i></span>
                            <input type="text" class="form-control" placeholder="Nombres">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                    <label>Apellidos</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                            <input type="text" class="form-control" placeholder="Apellidos">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                    <label>Correo</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" placeholder="Correo">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                    <label>Teléfono</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="number" class="form-control" placeholder="Teléfono">
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-6">
                    <label>Dirección</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                            <input type="text" class="form-control" placeholder="Dirección">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                    <label>Contraseña</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" placeholder="Contraseña">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                    <label>Rol</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01"><i class="fas fa-id-card"></i></label>
                            <select class="form-select" id="inputGroupSelect01">
                                <option selected>Seleccionar</option>
                                <option value="1">Administrador</option>
                                <option value="2">Empleado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button class="btn btn-primary" type="button">Registrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/templates/footer.php'; ?>