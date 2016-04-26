<?php $this->load->view('reporte/layout/header') ?>
<?php $this->load->view('reporte/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
	<h2>Listado de Choferes</h2>

	<table width="100%" border="1" cellspacing="0" cellpadding="2">
	<thead>
	    <tr>
		<th width="100">Cedula</th>
		<th>Nombre</th>
	    </tr>
	</thead>
	<tbody>
	<?php if ( count($choferes) > 0 ): ?>
	<?php foreach($choferes as $chofer):?>
	    <tr>
		<td><?php echo $chofer->cedula_chofer;?></td>
		<td><?php echo $chofer->nombre_chofer;?> <?php echo $chofer->apellido_chofer;?></td>

	    </tr>
	<?php endforeach;?>
	<?php else:?>
	    <tr>
	        <td colspan="3">
	            <p class="text-center">
	                No hay choferes registrados
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