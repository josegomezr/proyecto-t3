<?php $this->load->view('admin/layout/header'); ?>
<?php $this->load->view('admin/layout/sidebar'); ?>
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
	<div class="clearfix"></div>
	<div class="pull-right">
		<a class="btn btn-info btn-xs" href="<?php echo site_url('admin/salida/crear') ?>"><i class="glyphicon glyphicon-new-window"></i> Registrar Salida</a>
	</div>
	<h3>Salidas en proceso</h3>
	<table class="table table-bordered table-condensed table-striped table-hover" id="salida-proceso">
	<thead>
    <tr>
		<th>No.</th>
		<th>Conductor</th>
		<th>Recorrido</th>
		<th>Unidad</th>
		<th>Fecha Salida</th>
		<th width="100"></th>
    </tr>
	</thead>
	<tbody>
	<?php if ( count($salidas_incompletas) > 0 ): ?>
	<?php foreach($salidas_incompletas as $salida): ?>
	<?php 
	$fecha_salida = DateTime::createFromFormat('Y-m-d', $salida->fecha_salida);
	$hora_salida = DateTime::createFromFormat('H:i:s', $salida->hora_salida);
	 ?>
	    <td><?php echo $salida->id_salida;?></td>	
		<td>
			<?php if ($salida->cedula_conductor): ?>
				<?php echo $salida->nombre_conductor; ?> <?php echo $salida->apellido_conductor; ?>
			<?php else: ?>
				<strong class="text-danger">NO NOTIFICADA</strong>
			<?php endif ?>
		</td>
		<td><?php echo $salida->nombre_recorrido;?> </td>
		<td><?php echo $salida->modelo_unidad; ?> (<?php echo $salida->placa_unidad;?>)</td>
		<td><?php echo $fecha_salida->format('d/m/Y') ?> - <?php echo $hora_salida->format('h:i a') ?></td>
		<td align="right">
			<a class="btn btn-xs btn-success registrar-entrada" href="#" data-pk="<?php echo $salida->id_salida ?>"><i class="glyphicon glyphicon-log-in"></i></a>
			<?php if ($auth->nivel == 1): ?>
				<span class="text-muted">|</span>
		        <a class="btn btn-xs btn-warning" href="<?php echo site_url('admin/salida/editar/' . $salida->id_salida); ?>"><i class="glyphicon glyphicon-edit"></i></a>
		        <a class="btn btn-xs btn-danger" href="<?php echo site_url('admin/salida/eliminar/' . $salida->id_salida); ?>"><i class="glyphicon glyphicon-remove"></i></a>
			<?php endif ?>
		</td>
	</tr>

	<?php endforeach;?>
	</tbody>
</table>

	<nav align="center" class="text-center">
		  <ul class="pagination">
		    <?php if ($pagina_salida_incompleta == 1): ?>
		    	<li class="disabled">
		    		<span aria-hidden="true">&laquo;</span>
		    	<?php else: ?>
		    	<li>
		    		<a href="<?php echo site_url("admin/salida/index/" . ($pagina_salida_incompleta-1) . "/$pagina_salida_completa"); ?>" aria-label="Previous">&laquo;</a>
		    <?php endif ?>
		    </li>
		    <?php foreach (range(1, $total_paginas_incompleta) as $page): ?>
		    	<?php if ($pagina_salida_incompleta == $page): ?>
			    <li class="active">
		    	<?php else: ?>
			    <li>
		    	<?php endif ?>
			    	<a href='<?php echo site_url("admin/salida/index/$page/$pagina_salida_completa"); ?>'><?php echo $page ?></a>
			    </li>
		    <?php endforeach ?>
		    <?php if ($pagina_salida_incompleta == $total_paginas_incompleta): ?>
		    	<li class="disabled">
		      		<span aria-hidden="true">&raquo;</span>
		    	<?php else: ?>
		    	<li>
		      		<a href="<?php echo site_url("admin/salida/index/" . ($pagina_salida_incompleta+1) . "/$pagina_salida_completa"); ?>" aria-label="Next">&raquo;</a>
		    	<?php endif ?>
		    </li>
		  </ul>
		</nav>
	<?php else:?>
	    <tr>
	        <td colspan="7">
	            <p class="text-center">
	                No hay salidas en proceso
	            </p>
	        </td>
	    </tr>
	</tbody>
	</table>
	<?php endif;?>
	
	<h3>Salidas completadas</h3>
	<table class="table table-bordered table-condensed table-striped table-hover">
	<thead>
    <tr>
		<th>No.</th>
		<th>Conductor</th>
		<th>Recorrido</th>
		<th>Unidad</th>
		<th>Fecha Salida</th>
		<th>Fecha Llegada</th>
		<th width="100"></th>
    </tr>
	</thead>
	<tbody>
	<?php if ( count($salidas_completas) > 0 ): ?>
	<?php foreach($salidas_completas as $salida): ?>
	<?php 
	$fecha_salida = DateTime::createFromFormat('Y-m-d', $salida->fecha_salida);
	$hora_salida = DateTime::createFromFormat('H:i:s', $salida->hora_salida);

	$fecha_entrada = DateTime::createFromFormat('Y-m-d', $salida->fecha_entrada);
	$hora_entrada = DateTime::createFromFormat('H:i:s', $salida->hora_entrada);
	 ?>
	    <td><?php echo $salida->id_salida;?></td>	
		<td>
			<?php if ($salida->cedula_conductor): ?>
				<?php echo $salida->nombre_conductor; ?> <?php echo $salida->apellido_conductor; ?>
			<?php else: ?>
				<strong class="text-danger">NO NOTIFICADA</strong>
			<?php endif ?>
		</td>
		<td><?php echo $salida->nombre_recorrido;?> </td>
		<td><?php echo $salida->modelo_unidad; ?> (<?php echo $salida->placa_unidad;?>)</td>
		<td><?php echo $fecha_salida->format('d/m/Y') ?> - <?php echo $hora_salida->format('h:i A') ?></td>
		<td><?php echo $fecha_entrada->format('d/m/Y') ?> - <?php echo $hora_entrada->format('h:i A') ?></td>
		<td>
			<a class="btn btn-primary btn-xs" title="Reporte" href="<?php echo site_url('admin/reporte/entrada/' . $salida->id_entrada); ?>"><i class="glyphicon glyphicon-list"></i></a>
			<?php if ($auth->nivel == 1): ?>
				<span class="text-muted">|</span>
		        <a class="btn btn-xs btn-warning" href="<?php echo site_url('admin/entrada/editar/' . $salida->id_entrada); ?>" title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
		        <a class="btn btn-xs btn-danger confirmar-eliminar" href="<?php echo site_url('admin/entrada/eliminar/' . $salida->id_entrada . '/' . $salida->id_salida); ?>" title="Eliminar"><i class="glyphicon glyphicon-remove"></i></a>
			<?php endif ?>
		</td>
   	</tr>
	<?php endforeach;?>
	</tbody>
</table>
	<nav align="center" class="text-center">
		  <ul class="pagination">
		    <?php if ($pagina_salida_completa == 1): ?>
		    	<li class="disabled">
		    		<span aria-hidden="true">&laquo;</span>
		    	<?php else: ?>
		    	<li>
		    		<a href="<?php echo site_url("admin/salida/index/$pagina_salida_incompleta/" . ($pagina_salida_completa-1)); ?>" aria-label="Previous">&laquo;</a>
		    <?php endif ?>
		    </li>
		    <?php foreach (range(1, $total_paginas_completa) as $page): ?>
		    	<?php if ($pagina_salida_completa == $page): ?>
			    <li class="active">
		    	<?php else: ?>
			    <li>
		    	<?php endif ?>
			    	<a href='<?php echo site_url("admin/salida/index/$pagina_salida_incompleta/$page"); ?>'><?php echo $page ?></a>
			    </li>
		    <?php endforeach ?>
		    <?php if ($pagina_salida_completa == $total_paginas_completa): ?>
		    	<li class="disabled">
		      		<span aria-hidden="true">&raquo;</span>
		    	<?php else: ?>
		    	<li>
		      		<a href="<?php echo site_url("admin/salida/index/$pagina_salida_incompleta/" . ($pagina_salida_completa+1)); ?>" aria-label="Next">&raquo;</a>
		    	<?php endif ?>
		    </li>
		  </ul>
		</nav>
	<?php else:?>
	    <tr>
	        <td colspan="7">
	            <p class="text-center">
	                No hay salidas completadas
	            </p>
	        </td>
	    </tr>
	</tbody>
</table>
	<?php endif;?>
	<div class="clearfix"></div>
</div> <!-- /#main_content -->
</div> <!-- /.row -->

<div class="modal fade" id="modalEntrada">
  <div class="modal-dialog">
    <div class="modal-content">
		<form action="<?php echo site_url('admin/entrada/registrar_entrada'); ?>" method="post">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title">Registro de Entrada</h4>
      		</div>
      		<div class="modal-body">
        		<div class="form-group">
        			<label for="observacion" class="control-label">Observaci&oacute;n</label>
        			<textarea name="observacion" class="form-control" id="observacion" rows="5"></textarea>
        		</div>
	      </div>
	      <div class="modal-footer">
	    	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" class="btn btn-primary">Registrar Entrada</button>
	      </div>
	      <input type="hidden" name="id_salida" id="id_salida" value="-1">
      	</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	var modal = $("#modalEntrada");
	var id_salida = $("#id_salida");

	$("#salida-proceso").on('click', '.registrar-entrada', function (e) {
		id_salida.val($(e.target).closest('a').data('pk'));
		modal.modal('show');
		e.preventDefault();
	});
</script>

<?php $this->load->view('admin/layout/footer'); ?>