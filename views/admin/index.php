<?php include_once 'views/templates/header.php'; ?>
<div class="card">
    <div class="card-body">
        <!-- <h5 class="card-title text-center">Información de la empresa</h5>
        <hr>-->
        <form class="p-4" id="form" autocomplete="off">
            <input type="hidden" id="id" name="id" value="<?php echo $data['company']['id']; ?>">
            <div class="row">
                <div class="col-lg-4 col-sm-6 mb-2">
                    <label>NIT <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                        <input type="text" id="nit" name="nit" class="form-control" value="<?php echo $data['company']['nit']; ?>" placeholder="NIT">
                    </div>
                    <span id="errorNit" class="text-danger"></span>
                </div>
                <div class="col-lg-4 col-sm-6 mb-2">
                    <label>Nombre empresa <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-building"></i></span>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo $data['company']['name']; ?>" placeholder="Nombre empresa">
                    </div>
                    <span id="errorName" class="text-danger"></span>
                </div>
                <div class="col-lg-4 col-sm-6 mb-2">
                    <label>Teléfono <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="number" id="phone" name="phone" class="form-control" value="<?php echo $data['company']['phone']; ?>" placeholder="Teléfono">
                    </div>
                    <span id="errorPhone" class="text-danger"></span>
                </div>
                <div class="col-lg-4 col-sm-6 mb-2">
                    <label>Correo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-at"></i></span>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $data['company']['email']; ?>" placeholder="Correo">
                    </div>
                    <span id="errorEmail" class="text-danger"></span>
                </div>
                <div class="col-lg-8 col-sm-6 mb-2">
                    <label>Dirección <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                        <input type="text" id="address" name="address" class="form-control" value="<?php echo $data['company']['address']; ?>" placeholder="Dirección">
                    </div>
                    <span id="errorAddress" class="text-danger"></span>
                </div>
                <div class="col-lg-4 col-sm-6 mb-2">
                    <label>Impuestos</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                        <input type="number" id="tax" name="tax" class="form-control" value="<?php echo $data['company']['tax']; ?>" placeholder="Impuestos">
                    </div>
                </div>
                <div class="col-lg-8 col-sm-6 mb-2">
                    <div class="form-group">
                        <label for="message">Mensaje</label>
                        <textarea id="message" class="form-control" name="message" rows="3" placeholder="Mensaje"><?php echo $data['company']['message']; ?></textarea>
                    </div>
                    <span id="errorMessage" class="text-danger"></span>
                </div>
            </div>
            <div class="text-end">
                <button class="btn btn-primary" type="submit" id="btnAction">Actualizar</button>
            </div>
        </form>
    </div>
</div>



<?php include_once 'views/templates/footer.php'; ?>