<div class="row clearfix">
	<!-- sidebar -->
	<!-- cuando se ve en tlfs, abarca todo -->
	<!-- cuando se ve en 640x480, abarca 1/3 -->
	<!-- cuando se ve en >800x600, abarca 1/4 -->
	<div class="col-xs-12 col-sm-4 col-md-3 hidden-xs hidden-print" id="sidebar">
		<div class="panel-group" id="sidebar-panel">
		<?php if ($auth->nivel < 4): ?>
			<div class="panel <?php echo $_controller == "conductor" ? 'panel-primary' : 'panel-default' ?>">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#sidebar-panel" href="#conductor-collapse">
							<i class="fa fa-group"></i> Conductores
						</a>
					</h4>
				</div>
				<div id="conductor-collapse" class="panel-collapse collapse <?php echo $_controller == "conductor" ? 'in' : '' ?>">
					<div class="panel-body">
						<ul class="list-unstyled">
							<li>
								<a href="<?php echo site_url('admin/conductor') ?>">Listar</a>
							</li>
							<?php if ($auth->nivel == 1): ?>
								<li>
									<a href="<?php echo site_url('admin/conductor/crear') ?>">Registrar Conductor</a>
								</li>
							<?php endif ?>
						</ul>
					</div>
				</div>
			</div>
			<?php if ($auth->nivel == 1): ?>
			<div class="panel <?php echo $_controller == "dispositivo" ? 'panel-primary' : 'panel-default' ?>">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#sidebar-panel" href="#dispositivo-collapse">
							<i class="fa fa-rss"></i> Dispositivos
						</a>
					</h4>
				</div>
				<div id="dispositivo-collapse" class="panel-collapse collapse <?php echo $_controller == "dispositivo" ? 'in' : '' ?>">
					<div class="panel-body">
						<ul class="list-unstyled">
							<li>
								<a href="<?php echo site_url('admin/dispositivo') ?>">Listar</a>
							</li>
							<li>
								<a href="<?php echo site_url('admin/dispositivo/crear') ?>">Registrar Dispositivo</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<?php endif ?>
			<div class="panel <?php echo $_controller == "unidad" ? 'panel-primary' : 'panel-default' ?>">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#sidebar-panel" href="#unidad-collapse">
							<i class="fa fa-car"></i> Unidades
						</a>
					</h4>
				</div>
				<div id="unidad-collapse" class="panel-collapse collapse <?php echo $_controller == "unidad" ? 'in' : '' ?>">
					<div class="panel-body">
						<ul class="list-unstyled">
							<li>
								<a href="<?php echo site_url('admin/unidad') ?>">Listar</a>
							</li>
							<?php if ($auth->nivel == 1): ?>
							<li>
								<a href="<?php echo site_url('admin/unidad/crear') ?>">Registrar Unidad</a>
							</li>
							<?php endif ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="panel <?php echo $_controller == "recorrido" ? 'panel-primary' : 'panel-default' ?>">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#sidebar-panel" href="#recorrido-collapse">
							<i class="glyphicon glyphicon-road"></i> Recorrido
						</a>
					</h4>
				</div>
				<div id="recorrido-collapse" class="panel-collapse collapse <?php echo $_controller == "recorrido" ? 'in' : '' ?>">
					<div class="panel-body">
						<ul class="list-unstyled">
							<li>
								<a href="<?php echo site_url('admin/recorrido') ?>">Listar</a>
							</li>
							<?php if ($auth->nivel == 1): ?>
							<li>
								<a href="<?php echo site_url('admin/recorrido/crear') ?>">Registrar Recorrido</a>
							</li>
							<?php endif ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="panel <?php echo in_array($_controller, array('salida', 'entrada')) ? 'panel-primary' : 'panel-default' ?>">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#sidebar-panel" href="#salida-collapse">
							<i class="glyphicon glyphicon-log-out"></i> Salida
						</a>
					</h4>
				</div>
				
				<div id="salida-collapse" class="panel-collapse collapse <?php echo in_array($_controller, array('salida', 'entrada')) ? 'in' : '' ?>">
					<div class="panel-body">
						<ul class="list-unstyled">
							<li>
								<a href="<?php echo site_url('admin/salida') ?>">Listar</a>
							</li>
							<li>
								<a href="<?php echo site_url('admin/salida/crear') ?>">Registrar Salida</a>
							</li>
						</ul>
					</div>
				</div>
			</div>	
		<?php endif ?>
		<?php if ($auth->nivel == 1): ?>
				<div class="panel <?php echo $_controller == "usuario" ? 'panel-primary' : 'panel-default' ?>">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#sidebar-panel" href="#usuario-collapse">
								<i class="fa fa-user"></i> Usuarios
							</a>
						</h4>
					</div>
					<div id="usuario-collapse" class="panel-collapse collapse <?php echo $_controller == "usuario" ? 'in' : '' ?>">
						<div class="panel-body">
							<ul class="list-unstyled">
								<li>
									<a href="<?php echo site_url('admin/usuario') ?>">Listar</a>
								</li>
								<li>
									<a href="<?php echo site_url('admin/usuario/crear') ?>">Registrar Usuario</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			<?php endif ?>	
			<div class="panel <?php echo $_controller == "reporte" ? 'panel-primary' : 'panel-default' ?>">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#sidebar-panel" href="#reporte-collapse">
							<i class="fa fa-file-pdf-o"></i> Reportes
						</a>
					</h4>
				</div>
				<div id="reporte-collapse" class="panel-collapse collapse <?php echo $_controller == "reporte" ? 'in' : '' ?>">
					<div class="panel-body">
						<ul class="list-unstyled">
							<!-- <li>
								<a target="_blank" href="<?php echo site_url("admin/home/test_map");?>">DEMO MAPA RUTA</a>
							</li> -->
							<li>
								<a href="<?php echo site_url('admin/reporte/lista_conductores') ?>" target="_blank">Imprimir Listado de Conductores</a>
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
					</div>
				</div>
			</div>
		
		</div>
	</div> <!-- /#sidebar -->
