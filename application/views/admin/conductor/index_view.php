<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger">
			<p><?php echo lang($this->session->flashdata('error')); ?></p>
		</div>
	<?php endif ?>

	<?php if ($this->session->flashdata('success')): ?>
		<div class="alert alert-success">
			<p><?php echo lang($this->session->flashdata('success')); ?></p>
		</div>
	<?php endif ?>
	<?php if ($auth->nivel < 3): ?>
	<div class="pull-right">
		<a class="btn btn-xs btn-info" href="<?php echo site_url('admin/conductor/crear') ?>"><i class="glyphicon glyphicon-new-window"></i> Registrar Conductor</a>
	</div>
	<?php endif; ?>
	<div class="clearfix"></div>
	<br>
	<table class="table table-bordered table-striped table-hover table-condensed">
	<thead>
	    <tr>
		<th width="120">Cedula</th>
		<th>Nombre</th>
		<?php if ($auth->nivel < 3): ?>
		<th width="80"></th>
		<?php endif; ?>
    </tr>
	</thead>
	<tbody>
	<?php if ( count($conductores) > 0 ): ?>
	<?php foreach($conductores as $conductor):?>
	    <tr>
		<td><?php echo $conductor->cedula_conductor;?></td>
		<td>
			<?php echo $conductor->nombre_conductor;?> <?php echo $conductor->apellido_conductor;?>
			<?php if($conductor->temporal): ?>
				<span class="label label-primary"><i class="fa fa-clock-o"></i> temporal</span>
			<?php endif; ?>
		</td>
		<?php if ($auth->nivel < 3): ?>
		<td>
		        <a class="btn btn-xs btn-warning" href="<?php echo site_url('admin/conductor/editar/' . $conductor->cedula_conductor); ?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
		        <a class="btn btn-xs btn-danger" href="<?php echo site_url('admin/conductor/eliminar/' . $conductor->cedula_conductor); ?>" title="Eliminar"><i class="glyphicon glyphicon-remove"></i></a>
		</td>
		<?php endif ?>
	    </tr>
	<?php endforeach;?>
	<?php else:?>
	    <tr>
	        <td colspan="3">
	            <p class="text-center">
	                No hay conductores registrados.
	            </p>
	        </td>
	    </tr>
	<?php endif;?>
	</tbody>
	</table>

	<div class="clearfix"></div>
</div> <!-- /#main_content -->
</div> <!-- /.row -->

<?php $this->load->view('admin/layout/footer') ?>