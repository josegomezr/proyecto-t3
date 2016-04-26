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
		<a class="btn btn-xs btn-info" href="<?php echo site_url('admin/dispositivo/crear') ?>"><i class="glyphicon glyphicon-new-window"></i> Crear</a>
	</div>
	<div class="clearfix"></div>
	<br>
	<table class="table table-bordered table-condensed table-striped table-hover">
	<thead>
	    <tr>
		<th>ID</th>
		<th>Recorrido</th>
		<th>Unidad</th>
		<?php if($auth->nivel == 1): ?>
			<th width="80"></th>
		<?php endif; ?>
	    </tr>
	</thead>
	<tbody>
	<?php if ( count($dispositivos) > 0 ): ?>
	<?php foreach($dispositivos as $dispositivo):?>
	    <tr>
	    <td><?php echo str_pad($dispositivo->id_dispositivo, 3, '0', STR_PAD_LEFT)?></td>	
	    <td><?php echo $dispositivo->nombre_recorrido; ?></td>	
		<td>
			<?php echo $dispositivo->modelo_unidad ?> (<?php echo $dispositivo->placa_unidad ?>)
		</td>
		<?php if($auth->nivel == 1): ?>
			<td>
			        <a class="btn btn-xs btn-warning" href="<?php echo site_url('admin/dispositivo/editar/' . $dispositivo->id_dispositivo); ?>"><i class="glyphicon glyphicon-edit"></i></a>
			        <a class="btn btn-xs btn-danger" href="<?php echo site_url('admin/dispositivo/eliminar/' . $dispositivo->id_dispositivo); ?>"><i class="glyphicon glyphicon-remove"></i></a>
			</td>
		<?php endif; ?>
	    </tr>
	<?php endforeach;?>
	<?php else:?>
	    <tr>
	        <td colspan="4">
	            <p class="text-center">
	                No hay dispositivos registrados
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