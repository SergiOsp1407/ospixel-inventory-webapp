<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-products-tab" data-bs-toggle="tab" data-bs-target="#nav-products" type="button" role="tab" aria-controls="nav-products" aria-selected="true">Productos</button>
                <button class="nav-link" id="nav-new-tab" data-bs-toggle="tab" data-bs-target="#nav-new" type="button" role="tab" aria-controls="nav-new" aria-selected="false">Nuevo</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-2" id="nav-products" role="tabpanel" aria-labelledby="nav-products-tab" tabindex="0">
                <h5 class="card-title  text-center"><i class="fa-solid fa-list"></i> Listado de Productos</h5>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover nowrap" id="tblProducts" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Precio de Compra</th>
                                <th>Precio de Venta</th>
                                <th>Cantidad</th>
                                <th>Medida</th>
                                <th>Categoría</th>
                                <th>Foto</th>
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
                        <div class="col-md-3 mb-3">
                            <label for="code">Código</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                <input class="form-control" type="text" name="code" id="code" placeholder="Código del producto">
                            </div>
                            <span id="errorCode" class="text-danger"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="description">Producto</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                <input class="form-control" type="text" name="description" id="description" placeholder="Producto">
                            </div>
                            <span id="errorDescription" class="text-danger"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="purchase_price">Precio compra</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                <input class="form-control" type="number" step="0.01" min="0.01" name="purchase_price" id="purchase_price" placeholder="Precio de compra">
                            </div>
                            <span id="errorPurchasePrice" class="text-danger"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="sale_price">Precio venta</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                <input class="form-control" type="number" step="0.01" min="0.01" name="sale_price" id="sale_price" placeholder="Precio de venta">
                            </div>
                            <span id="errorSalePrice" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="id_measure">Medida</label>
                                <select id="id_measure" class="form-control" name="id_measure">
                                    <option value="">Seleccionar:</option>
                                    <?php foreach ($data['measures'] as $measure) { ?>
                                        <option value="<?php echo $measure['id']; ?>"><?php echo $measure['measure']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <span id="errorMeasure" class="text-danger"></span>
                        </div>
                        <div class="col-md-5 mb-3">
                            <div class="form-group">
                                <label for="id_category">Categoría</label>
                                <select id="id_category" class="form-control" name="id_category">
                                    <option value="">Seleccionar:</option>
                                    <?php foreach ($data['categories'] as $category) { ?>
                                        <option value="<?php echo $category['id']; ?>"><?php echo $category['category']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <span id="errorCategory" class="text-danger"></span>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="photo">Foto (Opcional)</label>
                                <input id="photo" class="form-control" type="file" name="photo">
                            </div>
                        </div>

                    </div>
                    <div class="text-end">
                        <button class="btn btn-danger" type="button" id="btnNew">Nuevo</button>
                        <button class="btn btn-primary" type="submit" id="btnAction">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once 'views/templates/footer.php'; ?>