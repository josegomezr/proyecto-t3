<?php $this->load->view('reporte/layout/header') ?>
<?php $this->load->view('reporte/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
	<h2>Listado de Unidades</h2>

	<table width="100%" border="1" cellspacing="0" cellpadding="2">

	<thead>
	    <tr>
		<th width="90">Placa</th>
		<th>Modelo</th>
		<th width="90">Dispositivo</th>
	    </tr>
	</thead>

	<tbody>
	<?php if ( count($unidades) > 0 ): ?>
	<?php foreach($unidades as $unidad):?>
	    <tr>
			<td align="center"><?php echo $unidad->placa_unidad;?></td>
			<td><?php echo $unidad->modelo_unidad;?></td>
			<td align="center"><?php echo $unidad->id_dispositivo;?></td>
	    </tr>
	<?php endforeach;?>
	<?php else:?>
	    <tr>
	        <td colspan="3">
	            <p class="text-center">
	                No hay unidades registrados
	            </p>
	        </td>
	    </tr>
	<?php endif;?>
	</tbody>
	<table>

	<div class="clearfix"></div>
</div> <!-- /#main_content -->
</div> <!-- /.row -->

<?php $this->load->view('reporte/layout/footer') ?>	