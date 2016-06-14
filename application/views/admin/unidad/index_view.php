<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger">
			<p><?php echo lang ($this->session->flashdata('error')); ?></p>
		</div>
	<?php endif ?>
	<?php if ($this->session->flashdata('success')): ?>
		<div class="alert alert-success">
			<p><?php echo lang($this->session->flashdata('success')); ?></p>
		</div>
	<?php endif ?>
	<?php if ($auth->nivel < 3): ?>
	<div class="pull-right">
		<a class="btn btn-xs btn-info" href="<?php echo site_url('admin/unidad/crear') ?>"><i class="glyphicon glyphicon-new-window"></i> Registrar Unidad</a>
	</div>
	<?php endif ?>
	<div class="clearfix"></div>
	<br>
	<table class="table table-bordered table-striped table-hover table-condensed">

	<thead>
	    <tr>
			<th width="120">Placa</th>
			<th>Modelo</th>
			<th>Dispositivo</th>
			<?php if ($auth->nivel < 3): ?>
				<th width="80"></th>
			<?php endif ?>
	    </tr>
	</thead>

	<tbody>
	<?php if ( count($unidades) > 0 ): ?>
	<?php foreach($unidades as $unidad):?>
	    <tr>
		<td><?php echo $unidad->placa_unidad;?></td>
		<td><?php echo $unidad->modelo_unidad;?></td>
		<td>
			<?php if($unidad->id_dispositivo): ?>
				<span class="label label-success"><?php echo $unidad->id_dispositivo ?></span>
			<?php else: ?>
				<span class="label label-default">N/I</span>
			<?php endif; ?>
		</td>
		<?php if ($auth->nivel < 3): ?>
		<td>
	        <a class="btn btn-xs btn-warning" href="<?php echo site_url('admin/unidad/editar/' . $unidad->id_unidad); ?>"><i class="glyphicon glyphicon-edit"></i></a>
	        <a class="btn btn-xs btn-danger" href="<?php echo site_url('admin/unidad/eliminar/' . $unidad->id_unidad); ?>"><i class="glyphicon glyphicon-remove"></i></a>
		</td>
		<?php endif ?>
	    </tr>
	<?php endforeach;?>
	<?php else:?>
	    <tr>
	        <td colspan="4">
	            <p class="text-center">
	                No hay unidades registradas.
	            </p>
	        </td>
	    </tr>
	<?php endif;?>
	</tbody>
	<table>

	<div class="clearfix"></div>
	<?php if ( count($unidades) > 0 ): ?>
	<ul class="list-unstyled">
		<li>
			<span class="label label-default">N/I</span>: No Instalado
		</li>
	</ul>
	<?php endif; ?>
</div> <!-- /#main_content -->
</div> <!-- /.row -->

<?php $this->load->view('admin/layout/footer') ?>