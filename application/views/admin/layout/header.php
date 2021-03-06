<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($title) ? '- ' . $title : '' ?> UPTOS GPS</title>

    <link href="<?php echo base_url('components/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">

    <link href="<?php echo base_url('components/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="" rel="stylesheet" id="theme-switcher">

    <link href="<?php echo base_url('components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
    <!-- por cuestiones de manejo de plantillas, los scripts irán en <head> -->
    <!-- en vez de lo usual, antes de </body> -->
    <script src="<?php echo base_url('components/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('components/jquery-validation/dist/jquery.validate.min.js') ?>"></script>
    <script src="<?php echo base_url('components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') ?>"></script>
    <script src="<?php echo base_url('components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') ?>"></script>

    <link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/js/setup.js') ?>"></script>
</head>
<body>
    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url('/admin/home/') ?>"><i class="fa fa-home"></i> UPTOS GPS</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="<?php echo $_controller == "home" ? 'active' : '' ?>"><a href="<?php echo site_url('/admin/home/') ?>">Inicio</a></li>
                    <?php if ($auth->nivel < 4): ?>
                    <li class="<?php echo in_array($_controller, array('salida', 'entrada')) ? 'active' : '' ?>"><a href="<?php echo site_url('/admin/salida/') ?>">Salidas</a></li>
                    <?php endif ?>
                    <?php if ($auth->nivel < 3): ?>
                    <li class="<?php echo in_array($_controller, array('conductor','dispositivo','unidad','recorrido','usuario', 'tipo_incidencia', 'incidencia')) ? 'active' : '' ?>">
                        <a href="#" data-toggle="dropdown">Mantenimiento <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('/admin/conductor/') ?>">Conductores</a>
                            </li>
                            <?php if ($auth->nivel == 1): ?>
                            <li>
                                <a href="<?php echo site_url('/admin/dispositivo/') ?>">Dispositivos</a>
                            </li>
                            <?php endif ?>
                            <li>
                                <a href="<?php echo site_url('/admin/recorrido/') ?>">Recorridos</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('/admin/unidad/') ?>">Unidades</a>
                            </li>
                            <?php if ($auth->nivel == 1): ?>
                            <li>
                                <a href="<?php echo site_url('/admin/usuario/') ?>">Usuarios</a>
                            </li>
                            <?php endif ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <li class="<?php echo $_controller == "reporte" ? 'active' : '' ?>">
                        <a href="#" data-toggle="dropdown">Reportes <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo site_url('admin/reporte/lista_conductores') ?>">Listado de Conductores</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/reporte/lista_unidades') ?>">Listado de Unidades</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/reporte/lista_recorridos') ?>">Listado de Recorridos</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/reporte/filtro_listar_salidas') ?>">Listar Salidas</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/reporte/incidencias') ?>">Incidencias</a>
                            </li>
                        </ul>

                    </li>
                </ul>
                
                <a href="<?php echo site_url('admin/home/logout') ?>" id="logout" class="btn btn-default navbar-btn navbar-right">Salir</a>
            </div><!--/.nav-collapse -->
        </div>
    </div>
    <div class="container-fluid">

        