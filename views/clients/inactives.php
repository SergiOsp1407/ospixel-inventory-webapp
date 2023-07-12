<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title text-center">Clientes inactivos</h5>
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
</div>
<?php include_once 'views/templates/footer.php'; ?>