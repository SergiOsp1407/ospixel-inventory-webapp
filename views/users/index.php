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
                <form class="p-4" id="form" autocomplete="off">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <label>Nombres</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                <input type="text" id="names" name="names" class="form-control" placeholder="Nombres">
                            </div>
                            <span id="errorNames" class="text-danger"></span>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <label>Apellidos</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Apellidos">
                            </div>
                            <span id="errorLastname" class="text-danger"></span>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <label>Correo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Correo">
                            </div>
                            <span id="errorEmail" class="text-danger"></span>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <label>Teléfono</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="number" id="phone" name="phone" class="form-control" placeholder="Teléfono">
                            </div>
                            <span id="errorPhone" class="text-danger"></span>
                        </div>
                        <div class="col-lg-8 col-sm-6 mb-2">
                            <label>Dirección</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                <input type="text" id="address" name="address" class="form-control" placeholder="Dirección">
                            </div>
                            <span id="errorAddress" class="text-danger"></span>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <label>Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
                            </div>
                            <span id="errorPassword" class="text-danger"></span>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <label>Rol</label>
                            <div class="input-group">
                                <label class="input-group-text" for="inputGroupSelect01"><i class="fas fa-id-card"></i></label>
                                <select class="form-select" id="rol" name="rol">
                                    <option value="" selected>Seleccionar</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Empleado</option>
                                </select>
                            </div>
                            <span id="errorRol" class="text-danger"></span>
                        </div>
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