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
	<div class="pull-right">
		<a class="btn btn-xs btn-info" href="<?php echo site_url('admin/incidencia/crear') ?>"><i class="glyphicon glyphicon-new-window"></i> Crear</a>
	</div>
	<div class="clearfix"></div>
	<br>
	<table class="table table-bordered table-condensed table-striped table-hover">
	<thead>
	    <tr>
		<th>ID</th>
		<th>Descripcion</th>
		<th>Tipo</th>
		<th width="80"></th>
	    </tr>
	</thead>
	<tbody>
	<?php if ( count($incidencias) > 0 ): ?>
	<?php foreach($incidencias as $incidencia):?>
	    <tr>
	    <td><?php echo $incidencia->id_incidencia; ?></td>	
	    <td><?php echo $incidencia->descripcion_incidencia; ?></td>	
		<td><?php echo $incidencia->descripcion_tipo_incidencia ?></td>
		<td>
	        <a class="btn btn-xs btn-warning" href="<?php echo site_url('admin/incidencia/editar/' . $incidencia->id_incidencia); ?>"><i class="glyphicon glyphicon-edit"></i></a>
	        <a class="btn btn-xs btn-danger" href="<?php echo site_url('admin/incidencia/eliminar/' . $incidencia->id_incidencia); ?>"><i class="glyphicon glyphicon-remove"></i></a>
		</td>
	</tr>
	<?php endforeach;?>
	<?php else:?>
	    <tr>
	        <td colspan="4">
	            <p class="text-center">
	                No hay incidencias registrados
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