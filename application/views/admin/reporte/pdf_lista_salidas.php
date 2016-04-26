<?php $this->load->view('reporte/layout/header') ?>
<?php $this->load->view('reporte/layout/sidebar') ?>
<!-- cuerpo -->
<div id="main_content">
	<?php if (count($salidas_incompletas) > 0): ?>
		<h2>Salidas en proceso</h2>
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
	    <tr>
			<th align="left">No.</th>
			<th align="left">Chofer</th>
			<th align="left">Recorrido</th>
			<th align="left">Unidad</th>
			<th align="left">Fecha Salida</th>
	    </tr>

		<?php foreach($salidas_incompletas as $salida):?>

	    <tr>
		<?php 
		$fecha_salida = DateTime::createFromFormat('Y-m-d', $salida->fecha_salida);
		$hora_salida = DateTime::createFromFormat('H:i:s', $salida->hora_salida);
		 ?>
		    <td><?php echo $salida->id_salida;?></td>	
			<td>
				<?php if ($salida->cedula_chofer): ?>
					<?php echo $salida->nombre_chofer; ?> <?php echo $salida->apellido_chofer; ?>
				<?php else: ?>
					<strong class="text-danger">NO NOTIFICADA</strong>
				<?php endif ?>
			</td>
			<td><?php echo $salida->nombre_recorrido;?> </td>
			<td><?php echo $salida->modelo_unidad; ?> (<?php echo $salida->placa_unidad;?>)</td>
			<td><?php echo $fecha_salida->format('d/m/Y') ?> @ <?php echo $hora_salida->format('H:i a') ?></td>
		    </tr>
		<?php endforeach;?>
		</table>
		<p>&nbsp;</p>		
	<?php endif ?>
	<?php if (count($salidas_completas) > 0): ?>

		<h2>Salidas completadas</h2>
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
	    <tr>
			<th align="left">No.</th>
			<th align="left">Chofer</th>
			<th align="left">Recorrido</th>
			<th align="left">Unidad</th>
			<th align="left">Fecha Salida</th>
			<th align="left">Fecha Llegada</th>
	    </tr>
		
		<?php foreach($salidas_completas as $salida):?>
	    <tr>
		<?php 
		$fecha_salida = DateTime::createFromFormat('Y-m-d', $salida->fecha_salida);
		$hora_salida = DateTime::createFromFormat('H:i:s', $salida->hora_salida);

		$fecha_entrada = DateTime::createFromFormat('Y-m-d', $salida->fecha_entrada);
		$hora_entrada = DateTime::createFromFormat('H:i:s', $salida->hora_entrada);
		 ?>
		    <td><?php echo $salida->id_salida;?></td>	
			<td>
				<?php if ($salida->cedula_chofer): ?>
					<?php echo $salida->nombre_chofer; ?> <?php echo $salida->apellido_chofer; ?>
				<?php else: ?>
					<strong class="text-danger">NO NOTIFICADA</strong>
				<?php endif ?>
			</td>
			<td><?php echo $salida->nombre_recorrido;?> </td>
			<td><?php echo $salida->modelo_unidad; ?> (<?php echo $salida->placa_unidad;?>)</td>
			<td><?php echo $fecha_salida->format('d/m/Y') ?> @ <?php echo $hora_salida->format('H:i a') ?></td>
			<td><?php echo $fecha_entrada->format('d/m/Y') ?> @ <?php echo $hora_entrada->format('H:i a') ?></td>
		    </tr>
		<?php endforeach;?>

	</table>

<?php endif; ?>
<?php $this->load->view('reporte/layout/footer') ?>