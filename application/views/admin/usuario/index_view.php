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
		<a class="btn btn-xs btn-info" href="<?php echo site_url('admin/usuario/crear') ?>"><i class="glyphicon glyphicon-new-window"></i> Registrar usuario</a>
	</div>
	<?php endif; ?>
	<div class="clearfix"></div>
	<br>
	<table class="table table-bordered table-striped table-hover table-condensed">
	<thead>
	    <tr>
		<th width="300">Nombre de Usuario</th>
		<th>Nivel</th>
		<?php if ($auth->nivel == 1): ?>
		<th width="80"></th>
		<?php endif; ?>
    </tr>
	</thead>
	<tbody>
	<?php if ( count($usuarios) > 0 ): ?>
	<?php foreach($usuarios as $usuario):?>
	    <tr>
		<td><?php echo $usuario->login_usuario;?></td>
		<td><?php echo $niveles_usuario[$usuario->nivel_usuario];?></td>
		<?php if ($auth->nivel == 1): ?>
		<td>
		        <a class="btn btn-xs btn-warning" href="<?php echo site_url('admin/usuario/editar/' . $usuario->id_usuario); ?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
		        <a class="btn btn-xs btn-danger" href="<?php echo site_url('admin/usuario/eliminar/' . $usuario->id_usuario); ?>" title="Eliminar"><i class="glyphicon glyphicon-remove"></i></a>
		</td>
		<?php endif ?>
	    </tr>
	<?php endforeach;?>
	<?php else:?>
	    <tr>
	        <td colspan="3">
	            <p class="text-center">
	                No hay usuarios registrados
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