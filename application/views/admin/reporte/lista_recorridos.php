<?php $this->load->view('reporte/layout/header') ?>
<?php $this->load->view('reporte/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
	<h2>Listado de Unidades</h2>

	<table width="100%" border="1" cellspacing="0" cellpadding="2">
	<thead>
	    <tr>
		<th width="30">No.</th>
		<th>Recorrido</th>
	    </tr>
	</thead>
	<tbody>
	<?php if ( count($recorridos) > 0 ): ?>
	<?php foreach($recorridos as $recorrido):?>
	    <tr>
		<td><?php echo $recorrido->id_recorrido;?></td>
		<td><?php echo $recorrido->nombre_recorrido;?></td>
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