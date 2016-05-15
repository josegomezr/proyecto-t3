<?php $this->load->view('reporte/layout/header') ?>
<?php $this->load->view('reporte/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
	<h2>Listado de conductores</h2>

	<table width="100%" border="1" cellspacing="0" cellpadding="2">
	<thead>
	    <tr>
		<th width="100">Cedula</th>
		<th>Nombre</th>
	    </tr>
	</thead>
	<tbody>
	<?php if ( count($conductores) > 0 ): ?>
	<?php foreach($conductores as $conductor):?>
	    <tr>
		<td><?php echo $conductor->cedula_conductor;?></td>
		<td><?php echo $conductor->nombre_conductor;?> <?php echo $conductor->apellido_conductor;?></td>

	    </tr>
	<?php endforeach;?>
	<?php else:?>
	    <tr>
	        <td colspan="3">
	            <p class="text-center">
	                No hay conductores registrados
	            </p>
	        </td>
	    </tr>
	<?php endif;?>
	</tbody>
	</table>

	<div class="clearfix"></div>
</div> <!-- /#main_content -->
</div> <!-- /.row -->

<?php $this->load->view('reporte/layout/footer') ?>