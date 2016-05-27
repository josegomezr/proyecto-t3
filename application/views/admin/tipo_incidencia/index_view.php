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
	<?php if ($auth->nivel == 1): ?>
	<div class="pull-right">
		<a class="btn btn-xs btn-info" href="<?php echo site_url('admin/tipo_incidencia/crear') ?>"><i class="glyphicon glyphicon-new-window"></i> Registrar Tipo Incidencia</a>
	</div>
	<?php endif; ?>
	<div class="clearfix"></div>
	<br>
	<table class="table table-bordered table-striped table-hover table-condensed">
	<thead>
	    <tr>
		<th width="300">Descripcion</th>
		<th></th>
    </tr>
	</thead>
	<tbody>
	<?php if ( count($tipo_incidencias) > 0 ): ?>
	<?php foreach($tipo_incidencias as $tipo_incidencia):?>
	    <tr>
		<td><?php echo $tipo_incidencia->descripcion_tipo_incidencia;?></td>
		<?php if ($auth->nivel == 1): ?>
		<td>
		        <a class="btn btn-xs btn-warning" href="<?php echo site_url('admin/tipo_incidencia/editar/' . $tipo_incidencia->id_tipo_incidencia); ?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
		        <a class="btn btn-xs btn-danger" href="<?php echo site_url('admin/tipo_incidencia/eliminar/' . $tipo_incidencia->id_tipo_incidencia); ?>" title="Eliminar"><i class="glyphicon glyphicon-remove"></i></a>
		</td>
		<?php endif ?>
	    </tr>
	<?php endforeach;?>
	<?php else:?>
	    <tr>
	        <td colspan="3">
	            <p class="text-center">
	                No hay tipo_incidencias registrados
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