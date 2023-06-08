<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/icon_logo_os.png" type="image/png" />
    <link href="<?php echo BASE_URL; ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="<?php echo BASE_URL; ?>assets/css/pace.min.css" rel="stylesheet" />
    <script src="<?php echo BASE_URL; ?>assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/app.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/dark-theme.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/semi-dark.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/header-colors.css" />
    <title><?php echo TITLE . ' | ' . $data['title']; ?></title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="<?php echo BASE_URL; ?>assets/images/icon_logo_os.png" class="logo-icon" alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text">Ospixel</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li>
                    <a href="javascript:;">
                        <div class="parent-icon"><i class="fas fa-tachometer-alt"></i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="bi bi-gear-wide-connected"></i>
                        </div>
                        <div class="menu-title">Administración</div>
                    </a>
                    <ul>
                        <li> <a href="<?php echo BASE_URL.'users'; ?>"><i class="bx bx-right-arrow-alt"></i>Usuarios</a>
                        </li>
                        <li> <a href="app-chat-box.html"><i class="bx bx-right-arrow-alt"></i>Categorías</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="fab fa-hubspot"></i>
                        </div>
                        <div class="menu-title">Mantenimiento</div>
                    </a>
                    <ul>
                        <li> <a href="app-emailbox.html"><i class="bx bx-right-arrow-alt"></i>Medidas/Dimensiones</a>
                        </li>
                        <li> <a href="app-chat-box.html"><i class="bx bx-right-arrow-alt"></i>Categorías</a>
                        </li>
                        <li> <a href="app-chat-box.html"><i class="bx bx-right-arrow-alt"></i>Productos</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-label">Módulos</li>
                <li>
                    <a href="widgets.html">
                        <div class="parent-icon"><i class="fa-solid fa-users-rectangle"></i>
                        </div>
                        <div class="menu-title">Clientes</div>
                    </a>
                </li>
                <li>
                    <a href="widgets.html">
                        <div class="parent-icon"><i class="fa-solid fa-truck-field"></i>
                        </div>
                        <div class="menu-title">Proveedores</div>
                    </a>
                </li>
                <li>
                    <a href="widgets.html">
                        <div class="parent-icon"><i class="bi bi-plus-slash-minus"></i>
                        </div>
                        <div class="menu-title">Cajas/Balances</div>
                    </a>
                </li>
                <li>
                    <a href="widgets.html">
                        <div class="parent-icon"><i class="fa-solid fa-dolly"></i>
                        </div>
                        <div class="menu-title">Compras</div>
                    </a>
                </li>
                <li>
                    <a href="widgets.html">
                        <div class="parent-icon"><i class="fa-solid fa-cash-register"></i>
                        </div>
                        <div class="menu-title">Ventas</div>
                    </a>
                </li>
                <li>
                    <a href="widgets.html">
                        <div class="parent-icon"><i class="bi bi-credit-card"></i>
                        </div>
                        <div class="menu-title">Administrar creditos</div>
                    </a>
                </li>
                <li>
                    <a href="widgets.html">
                        <div class="parent-icon"><i class="bi bi-list-columns"></i>
                        </div>
                        <div class="menu-title">Cotizaciones</div>
                    </a>
                </li>
                <li>
                    <a href="widgets.html">
                        <div class="parent-icon"><i class="fa-solid fa-cart-arrow-down"></i>
                        </div>
                        <div class="menu-title">Apartados</div>
                    </a>
                </li>
                <li>
                    <a href="widgets.html">
                        <div class="parent-icon"><i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <div class="menu-title">Inventario</div>
                    </a>
                </li>

            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
        <!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    <div class="search-bar flex-grow-1">
                        <div class="position-relative">
                            <h6><?php echo $data['title']; ?></h6>
                        </div>
                    </div>
                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo BASE_URL; ?>assets/images/avatars/avatar-2.png" class="user-img" alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0">Pauline Seitz</p>
                                <p class="designattion mb-0">Web Designer</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="javascript:;"><i class="bx bx-user"></i><span>Profile</span></a>
                            </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">