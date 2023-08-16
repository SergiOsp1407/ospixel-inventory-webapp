<?php include_once 'views/templates/header.php'; ?>


<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
	<div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-secondary">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Usuarios</p>
						<h4 class="my-1 text-info"><?php echo $data['users']['totals']; ?></h4>
						<a class="mb-0 font-13" href="<?php echo BASE_URL . 'users'; ?>">Ver</a>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
						<i class="fa-solid fa-users"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-secondary">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Clientes</p>
						<h4 class="my-1 text-info"><?php echo $data['clients']['totals']; ?></h4>
						<a class="mb-0 font-13" href="<?php echo BASE_URL . 'clients'; ?>">Ver</a>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
						<!-- <i class='bx bxs-wallet'></i> -->
						<i class="fa-solid fa-users-rays"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-secondary">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Proveedores</p>
						<h4 class="my-1 text-info"><?php echo $data['suppliers']['totals']; ?></h4>
						<a class="mb-0 font-13" href="<?php echo BASE_URL . 'suppliers'; ?>">Ver</a>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
						<!-- <i class='bx bxs-bar-chart-alt-2'></i> -->
						<i class="fa-solid fa-truck-field"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-secondary">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Productos</p>
						<h4 class="my-1 text-info"><?php echo $data['products']['totals']; ?></h4>
						<a class="mb-0 font-13" href="<?php echo BASE_URL . 'products'; ?>">Ver</a>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto">
						<!-- <i class='bx bxs-group'></i> -->
						<i class="bi bi-box-seam-fill"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card radius-10 border-start border-0 border-3 border-secondary">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<p class="mb-0 text-secondary">Ventas</p>
						<h4 class="my-1 text-info"><?php echo $data['sales']['totals']; ?></h4>
						<a class="mb-0 font-13" href="<?php echo BASE_URL . 'sales'; ?>">Ver</a>
					</div>
					<div class="widgets-icons-2 rounded-circle bg-gradient-deepblue text-white ms-auto">
						<!-- <i class='bx bxs-group'></i> -->
						<i class="fa-solid fa-money-bill-trend-up"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--end row-->

<div class="row">
	<div class="col-12 col-lg-8">
		<div class="card radius-10">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0">Compras y Ventas</h6>
					</div>
					<div class="dropdown ms-auto">
						<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
						</a>
						<!-- <ul class="dropdown-menu">
							<li><a class="dropdown-item" href="javascript:;">Action</a>
							</li>
							<li><a class="dropdown-item" href="javascript:;">Another action</a>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="javascript:;">Something else here</a>
							</li>
						</ul> -->
					</div>
				</div>
				<div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
					<span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #14abef"></i>Ventas</span>
					<span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #ffc107"></i>Compras</span>
				</div>
				<div class="chart-container-1">
					<canvas id="chart1"></canvas>
				</div>
			</div>
			<div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 g-0 row-group text-center border-top">
				<div class="col">
					<div class="p-3">
						<h5 class="mb-0">000</h5>
						<small class="mb-0">Ventas Totales </small>
					</div>
				</div>
				<div class="col">
					<div class="p-3">
						<h5 class="mb-0">000</h5>
						<small class="mb-0">Compras Totales </small>
					</div>
				</div>
				<!-- <div class="col">
					<div class="p-3">
						<h5 class="mb-0">639.82</h5>
						<small class="mb-0">Pages/Visit <span> <i class="bx bx-up-arrow-alt align-middle"></i> 5.62%</span></small>
					</div>
				</div> -->
			</div>
		</div>
	</div>
	<div class="col-12 col-lg-4">
		<div class="card radius-10">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0">Productos más vendidos</h6>
					</div>
					<div class="dropdown ms-auto">
						<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="javascript:;">Action</a>
							</li>
							<li><a class="dropdown-item" href="javascript:;">Another action</a>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="javascript:;">Something else here</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="chart-container-2 mt-4">
					<canvas id="chart2"></canvas>
				</div>
			</div>
			<ul class="list-group list-group-flush">
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
					Jeans <span class="badge bg-success rounded-pill">25</span>
				</li>
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
					T-Shirts <span class="badge bg-danger rounded-pill">10</span>
				</li>
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
					Shoes <span class="badge bg-primary rounded-pill">65</span>
				</li>
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
					Lingerie <span class="badge bg-warning text-dark rounded-pill">14</span>
				</li>
			</ul>
		</div>
	</div>
</div>
<!--end row-->

<div class="card radius-10">
	<div class="card-body">
		<div class="d-flex align-items-center">
			<div>
				<h6 class="mb-0">Productos Recientes</h6>
			</div>
			<div class="dropdown ms-auto">
				<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
				</a>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="javascript:;">Action</a>
					</li>
					<li><a class="dropdown-item" href="javascript:;">Another action</a>
					</li>
					<li>
						<hr class="dropdown-divider">
					</li>
					<li><a class="dropdown-item" href="javascript:;">Something else here</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table align-middle mb-0">
				<thead class="table-light">
					<tr>
						<th>Producto</th>
						<th>Foto</th>
						<th>Precio Compra</th>
						<th>Precio Venta</th>
						<th>Fecha</th>
						<th>Categoria</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Iphone 5</td>
						<td><img src="<?php echo BASE_URL; ?>assets/images/products/01.png" class="product-img-2" alt="product img"></td>
						<td><span class="badge bg-gradient-quepal text-white shadow-sm w-100">Paid</span>
						</td>
						<td>$1250.00</td>
						<td>03 Feb 2020</td>
						<td>
							<div class="progress" style="height: 6px;">
								<div class="progress-bar bg-gradient-quepal" role="progressbar" style="width: 100%"></div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- <div class="card radius-10">
	<div class="card-body">
		<div class="d-flex align-items-center">
			<div>
				<h6 class="mb-0">Recent Orders</h6>
			</div>
			<div class="dropdown ms-auto">
				<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
				</a>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="javascript:;">Action</a>
					</li>
					<li><a class="dropdown-item" href="javascript:;">Another action</a>
					</li>
					<li>
						<hr class="dropdown-divider">
					</li>
					<li><a class="dropdown-item" href="javascript:;">Something else here</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table align-middle mb-0">
				<thead class="table-light">
					<tr>
						<th>Product</th>
						<th>Photo</th>
						<th>Product ID</th>
						<th>Status</th>
						<th>Amount</th>
						<th>Date</th>
						<th>Shipping</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Iphone 5</td>
						<td><img src="<?php echo BASE_URL; ?>assets/images/products/01.png" class="product-img-2" alt="product img"></td>
						<td>#9405822</td>
						<td><span class="badge bg-gradient-quepal text-white shadow-sm w-100">Paid</span>
						</td>
						<td>$1250.00</td>
						<td>03 Feb 2020</td>
						<td>
							<div class="progress" style="height: 6px;">
								<div class="progress-bar bg-gradient-quepal" role="progressbar" style="width: 100%"></div>
							</div>
						</td>
					</tr>

					<tr>
						<td>Earphone GL</td>
						<td><img src="<?php echo BASE_URL; ?>assets/images/products/02.png" class="product-img-2" alt="product img"></td>
						<td>#8304620</td>
						<td><span class="badge bg-gradient-blooker text-white shadow-sm w-100">Pending</span>
						</td>
						<td>$1500.00</td>
						<td>05 Feb 2020</td>
						<td>
							<div class="progress" style="height: 6px;">
								<div class="progress-bar bg-gradient-blooker" role="progressbar" style="width: 60%"></div>
							</div>
						</td>
					</tr>

					<tr>
						<td>HD Hand Camera</td>
						<td><img src="<?php echo BASE_URL; ?>assets/images/products/03.png" class="product-img-2" alt="product img"></td>
						<td>#4736890</td>
						<td><span class="badge bg-gradient-bloody text-white shadow-sm w-100">Failed</span>
						</td>
						<td>$1400.00</td>
						<td>06 Feb 2020</td>
						<td>
							<div class="progress" style="height: 6px;">
								<div class="progress-bar bg-gradient-bloody" role="progressbar" style="width: 70%"></div>
							</div>
						</td>
					</tr>

					<tr>
						<td>Clasic Shoes</td>
						<td><img src="<?php echo BASE_URL; ?>assets/images/products/04.png" class="product-img-2" alt="product img"></td>
						<td>#8543765</td>
						<td><span class="badge bg-gradient-quepal text-white shadow-sm w-100">Paid</span>
						</td>
						<td>$1200.00</td>
						<td>14 Feb 2020</td>
						<td>
							<div class="progress" style="height: 6px;">
								<div class="progress-bar bg-gradient-quepal" role="progressbar" style="width: 100%"></div>
							</div>
						</td>
					</tr>
					<tr>
						<td>Sitting Chair</td>
						<td><img src="<?php echo BASE_URL; ?>assets/images/products/06.png" class="product-img-2" alt="product img"></td>
						<td>#9629240</td>
						<td><span class="badge bg-gradient-blooker text-white shadow-sm w-100">Pending</span>
						</td>
						<td>$1500.00</td>
						<td>18 Feb 2020</td>
						<td>
							<div class="progress" style="height: 6px;">
								<div class="progress-bar bg-gradient-blooker" role="progressbar" style="width: 60%"></div>
							</div>
						</td>
					</tr>
					<tr>
						<td>Hand Watch</td>
						<td><img src="<?php echo BASE_URL; ?>assets/images/products/05.png" class="product-img-2" alt="product img"></td>
						<td>#8506790</td>
						<td><span class="badge bg-gradient-bloody text-white shadow-sm w-100">Failed</span>
						</td>
						<td>$1800.00</td>
						<td>21 Feb 2020</td>
						<td>
							<div class="progress" style="height: 6px;">
								<div class="progress-bar bg-gradient-bloody" role="progressbar" style="width: 40%"></div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div> -->

<!--end row-->

<div class="row row-cols-1 row-cols-lg-2">
	<div class="col d-flex">
		<div class="card radius-10 w-100">
			<div class="card-body">
				<p class="font-weight-bold mb-1 text-secondary">Gastos Mensuales</p>
				<div class="d-flex align-items-center mb-4">
					<div>
						<h4 class="mb-0">$89,540</h4>
					</div>
					<div class="">
						<p class="mb-0 align-self-center font-weight-bold text-success ms-2">4.4% <i class="bx bxs-up-arrow-alt mr-2"></i>
						</p>
					</div>
				</div>
				<div class="chart-container-0">
					<canvas id="chart3"></canvas>
				</div>
			</div>
		</div>
	</div>
	<div class="col d-flex">
		<div class="card radius-10 w-100">
			<div class="card-header bg-transparent">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0">Productos con bajas unidades</h6>
					</div>
					<div class="dropdown ms-auto">
						<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="javascript:;">Action</a>
							</li>
							<li><a class="dropdown-item" href="javascript:;">Another action</a>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="javascript:;">Something else here</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="chart-container-1">
					<canvas id="chart4"></canvas>
				</div>
			</div>
			<ul class="list-group list-group-flush">
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
					Completed <span class="badge bg-gradient-quepal rounded-pill">25</span>
				</li>
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
					Pending <span class="badge bg-gradient-ibiza rounded-pill">10</span>
				</li>
				<li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
					Process <span class="badge bg-gradient-deepblue rounded-pill">65</span>
				</li>
			</ul>
		</div>
	</div>
	<!-- <div class="col d-flex">
		<div class="card radius-10 w-100">
			<div class="card-header bg-transparent">
				<div class="d-flex align-items-center">
					<div>
						<h6 class="mb-0">Top Selling Categories</h6>
					</div>
					<div class="dropdown ms-auto">
						<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="javascript:;">Action</a>
							</li>
							<li><a class="dropdown-item" href="javascript:;">Another action</a>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="javascript:;">Something else here</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="chart-container-0">
					<canvas id="chart5"></canvas>
				</div>
			</div>
			<div class="row row-group border-top g-0">
				<div class="col">
					<div class="p-3 text-center">
						<h4 class="mb-0 text-danger">$45,216</h4>
						<p class="mb-0">Clothing</p>
					</div>
				</div>
				<div class="col">
					<div class="p-3 text-center">
						<h4 class="mb-0 text-success">$68,154</h4>
						<p class="mb-0">Electronic</p>
					</div>
				</div>
			</div>
			<!--end row-->
		<!--</div>
	</div> -->
</div>
<!--end row-->

<?php include_once 'views/templates/footer.php'; ?>