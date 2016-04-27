<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo isset($title) ? '- ' . $title : '' ?> UPTOS GPS</title>

	<!-- <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet"> -->
	<link href="http://bootswatch.com/cosmo/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet">

	<link href="" rel="stylesheet" id="theme-switcher">

	<link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet">
	
	<link href="<?php echo base_url('assets/css/datepicker.css') ?>" rel="stylesheet">

	<!-- por cuestiones de manejo de plantillas, los scripts irán en <head> -->
	<!-- en vez de lo usual, antes de </body> -->
	<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap-datepicker.es.js') ?>"></script>
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
				<?php if ($auth->nivel < 4): ?>
					<li class="<?php echo $_controller == "home" ? 'active' : '' ?>"><a href="<?php echo site_url('/admin/home/') ?>">Inicio</a></li>
					<li class="<?php echo $_controller == "chofer" ? 'active' : '' ?>"><a href="<?php echo site_url('/admin/chofer/') ?>">Choferes</a></li>
					<?php if ($auth->nivel == 1): ?>
					<li class="<?php echo $_controller == "dispositivo" ? 'active' : '' ?>"><a href="<?php echo site_url('/admin/dispositivo/') ?>">Dispositivos</a></li>
					<?php endif ?>
					<li class="<?php echo $_controller == "unidad" ? 'active' : '' ?>"><a href="<?php echo site_url('/admin/unidad/') ?>">Unidades</a></li>
					<li class="<?php echo $_controller == "recorrido" ? 'active' : '' ?>"><a href="<?php echo site_url('/admin/recorrido/') ?>">Recorridos</a></li>
					<li class="<?php echo in_array($_controller, array('salida', 'entrada')) ? 'active' : '' ?>"><a href="<?php echo site_url('/admin/salida/') ?>">Salidas</a></li>
					<li class="<?php echo $_controller == "usuario" ? 'active' : '' ?>"><a href="<?php echo site_url('/admin/usuario/') ?>">Usuario</a></li>

				<?php endif ?>
					<li class="<?php echo $_controller == "reporte" ? 'active' : '' ?>">
						<a href="#" data-toggle="dropdown">Reportes <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo site_url('admin/reporte/lista_choferes') ?>" target="_blank">Imprimir Listado de Choferes</a>
							</li>
							<li>
								<a href="<?php echo site_url('admin/reporte/lista_unidades') ?>" target="_blank">Imprimir Listado de Unidades</a>
							</li>
							<li>
								<a href="<?php echo site_url('admin/reporte/lista_recorridos') ?>" target="_blank">Imprimir Listado de Recorridos</a>
							</li>
							<li>
								<a href="<?php echo site_url('admin/reporte/lista_salidas') ?>">Listar Salidas</a>
							</li>
						</ul>

					</li>
				</ul>
				
				<a href="<?php echo site_url('admin/home/logout') ?>" class="btn btn-default navbar-btn navbar-right">Salir</a>
			</div><!--/.nav-collapse -->
		</div>
	</div>
	<div class="container-fluid">

		