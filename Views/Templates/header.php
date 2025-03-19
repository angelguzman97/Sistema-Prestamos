<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?php echo base_url; ?></title>
    
    <link href="<?php echo base_url; ?>Assets/logo.png" rel="icon"/>
    <link href="<?php echo base_url; ?>Assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet" />
    
<link href="<?php echo base_url; ?>Assets/dataTable/jquery.dataTables.min.css" rel="stylesheet" />
    <script src="<?php echo base_url; ?>Assets/js/all.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url; ?>Assets/js/salir.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed" style="background: lightskyblue;">
    <nav class="sb-topnav navbar navbar-expand"  style="background: white;">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html" style="color: black">Prestamos</a>
        <!-- Sidebar Toggle-->
        <button style="color: black" class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-3 me-lg-4" >
            <li class="nav-item dropdown">
                <a style="color: black;" class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php echo base_url; ?>Perfil">Perfil</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <!--En el href se abre la locación raíz abriendo el controlador Usuario con el método salir creado en el controlador Usuarios-->
                   <li><a class="dropdown-item" href="<?php echo base_url; ?>Rutas/salir">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion"  style="background: white;" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <?php if ($_SESSION['id_ruta']==1) { ?>
                        <!--------------------------Administración-------------------------------------->
                        <a style="color: black" class="nav-link" href="<?php echo base_url; ?>Cantidades"><i class="fas fa-sack-dollar me-2 fs-2"></i>Créditos</a>
                        <a style="color: black" class="nav-link" href="<?php echo base_url; ?>Grupos"><i class="fas fa-layer-group me-2 fs-2"></i>Grupos</a>
                                <a style="color: black" class="nav-link" href="<?php echo base_url; ?>Rutas"><i class="fas fa-motorcycle me-2 fs-2"></i>Rutas</a>
                                <a style="color: black" class="nav-link" href="<?php echo base_url; ?>ClientesG"><i class="fas fa-users me-2 fs-2"></i>Clientes</a>
                                <a style="color: black" class="nav-link" href="<?php echo base_url; ?>CuadresG"><i class="fas fa-plus me-2 fs-2"></i>Cuadre semanal</a>
                                <a style="color: black" class="nav-link" href="<?php echo base_url; ?>CuadresG/listaCuadres"><i class="fas fa-list me-2 fs-2"></i>Cuadres generales</a>
                        <?php } ?>

                        <?php if ($_SESSION['id_ruta']!=1) { ?>
                        <div class="nav">
                        <!---------------------------Clientes----------------------------------------------->
                        <a style="color: black" class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseClientes" aria-expanded="false" aria-controls="collapseClientes">
                            <div class="sb-nav-link-icons me-2"><i class="fas fa-user fs-2"></i></div>
                            Clientes
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseClientes" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a style="color: black" class="nav-link" href="<?php echo base_url; ?>Clientes"><i class="fas fa-user-plus me-2 fs-2"></i></i>Agregar</a>
                                <a style="color: black" class="nav-link" href="<?php echo base_url; ?>Clientes/listaClientes"><i class="fas fa-list me-2 fs-2"></i>Lista</a>
                            </nav>
                        </div>
                        <!---------------------------Prestamos---------------------------------------------->
                        <a style="color: black" class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePrestamos" aria-expanded="false" aria-controls="collapsePrestamos">
                            <div class="sb-nav-link-icons me-2"><i class="fas fa-sack-dollar fs-2"></i></div>
                            Prestamos
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePrestamos" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a style="color: black" class="nav-link" href="<?php echo base_url; ?>Prestamos"><i class="fas fa-plus me-2  fs-2"></i></i>Agregar</a>
                                <a style="color: black" class="nav-link" href="<?php echo base_url; ?>Prestamos/listaPrestamos"><i class="fas fa-list me-2 fs-2"></i>Lista</a>
                            </nav>
                        </div>
                        <!--------------------------------PAGOS------------------------------------------->
                        <a style="color: black" class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePagos" aria-expanded="false" aria-controls="collapsePagos">
                            <div class="sb-nav-link-icons me-2"><i class="fas fa-sack-dollar fs-2"></i></div>
                            Pagos del cliente
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePagos" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a style="color: black" class="nav-link" href="<?php echo base_url; ?>Pagos"><i class="fas fa-plus me-2  fs-2"></i></i>Agregar</a>
                                <a style="color: black" class="nav-link" href="<?php echo base_url; ?>Pagos/pagosHoy"><i class="fas fa-dollar me-2  fs-2"></i></i>Pagos de hoy</a>
                                <a style="color: black" class="nav-link" href="<?php echo base_url; ?>Pagos/listaPagos"><i class="fas fa-list me-2 fs-2"></i>Lista</a>
                            </nav>
                        </div>
                        <a style="color: black" class="nav-link" href="<?php echo base_url; ?>Reportes"><i class="fas fa-file-invoice-dollar me-2 fs-2"></i>Pagos del día</a>
                        <a style="color: black" class="nav-link" href="<?php echo base_url; ?>Reportes/listaReportes"><i class="fas fa-list me-2 fs-2"></i>Lista de reportes</a>

                    </div>
                    <?php } ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 mt-2">
                   