<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
  <?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger">
    <p>
      <?php echo lang($this->session->flashdata('error')); ?>
    </p>
  </div>
  <?php endif ?>
  <div class="clearfix"></div>
  <form>
    <div class="filters-container">
      <div class="pull-right">
        <a href="<?php echo site_url('admin/reporte/visor_lista_salida') . "?{$_SERVER[ 'QUERY_STRING']}" ?>" class="btn btn-default">
          <i class="glyphicon glyphicon-print"></i>
        </a>
      </div>
      <h3>Filtros 
        <button type="button" class="btn btn-xs btn-info show-filters">
          <i class="glyphicon glyphicon-plus"></i>
        </button>
      </h3>
      <div class="clearfix"></div>
      <div class="filters">
        <div class="row clearfix">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="id_conductor">Conductor:</label>
              <select name="id_conductor" id="id_conductor" class="form-control">
                <option value="">Seleccione conductor</option>
                <?php foreach ($conductores as $conductor): ?>
                  <option value="<?php echo $conductor->id_conductor ?>" <?php echo $conductor_seleccionado == $conductor->id_conductor ? 'selected="selected"' : '' ?>><?php echo $conductor->nombre_conductor; ?> <?php echo $conductor->apellido_conductor; ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="id_recorrido">Recorrido:</label>
              <select name="id_recorrido" id="id_recorrido" class="form-control">
                <option value="">Seleccione Recorrido</option>
                <?php foreach ($recorridos as $recorrido): ?>
                    <option value="<?php echo $recorrido->id_recorrido ?>" <?php echo $recorrido_seleccionado == $recorrido->id_recorrido ? 'selected="selected"' : '' ?>><?php echo $recorrido->nombre_recorrido; ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="fecha_inicio">Desde:</label>
              <input type="text" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha Inicio" value="<?php echo $fecha_inicio_seleccionado; ?>" class="form-control datepicker">
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label for="fecha_inicio">Hasta:</label>
              <input type="text" name="fecha_final" id="fecha_final" placeholder="Fecha Final" value="<?php echo $fecha_final_seleccionado; ?>" class="form-control datepicker">
            </div>
          </div>
        </div>
        <div class="pull-right">
          <button type="submit" name="filtrar" class="btn btn-primary">Filtrar</button>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <br>
  </form>
  <?php if ($tiene_criteria): ?>

  <h3>Salidas en proceso</h3>
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th>No.</th>
        <th>conductor</th>
        <th>Recorrido</th>
        <th>Unidad</th>
        <th>Fecha Salida</th>
      </tr>
    </thead>
    <tbody>
      <?php if ( count($salidas_incompletas) > 0 ): ?>
      <?php foreach($salidas_incompletas as $salida):?>
      <?php 
    $fecha_salida = DateTime::createFromFormat('Y-m-d', $salida->fecha_salida);
    $hora_salida = DateTime::createFromFormat('H:i:s', $salida->hora_salida);
     ?>
      <td>
        <?php echo $salida->id_salida;?>
      </td>
      <td>
        <?php if ($salida->id_conductor): ?>
        <?php echo $salida->nombre_conductor; ?>
        <?php echo $salida->apellido_conductor; ?>
        <?php else: ?>
        <strong class="text-danger">NO NOTIFICADA</strong>
        <?php endif ?>
      </td>
      <td>
        <?php echo $salida->nombre_recorrido;?> </td>
      <td>
        <?php echo $salida->modelo_unidad; ?> (
        <?php echo $salida->placa_unidad;?>)</td>
      <td>
        <?php echo $fecha_salida->format('d/m/Y') ?> -
        <?php echo $hora_salida->format('H:i a') ?>
      </td>
      </tr>
      <?php endforeach;?>
      <?php else:?>
      <tr>
        <td colspan="5">
          <p class="text-center">
            No Hay salidas en proceso
          </p>
        </td>
      </tr>
      <?php endif;?>
    </tbody>
  </table>

  <h3>Salidas completadas</h3>
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th>No.</th>
        <th>conductor</th>
        <th>Recorrido</th>
        <th>Unidad</th>
        <th>Fecha Salida</th>
        <th>Fecha Llegada</th>
      </tr>
    </thead>
    <tbody>
      <?php if ( count($salidas_completas) > 0 ): ?>
      <?php foreach($salidas_completas as $salida):?>
      <?php 
    $fecha_salida = DateTime::createFromFormat('Y-m-d', $salida->fecha_salida);
    $hora_salida = DateTime::createFromFormat('H:i:s', $salida->hora_salida);

    $fecha_entrada = DateTime::createFromFormat('Y-m-d', $salida->fecha_entrada);
    $hora_entrada = DateTime::createFromFormat('H:i:s', $salida->hora_entrada);
     ?>
      <td>
        <?php echo $salida->id_salida;?>
      </td>
      <td>
        <?php if ($salida->id_conductor): ?>
        <?php echo $salida->nombre_conductor; ?>
        <?php echo $salida->apellido_conductor; ?>
        <?php else: ?>
        <strong class="text-danger">NO NOTIFICADA</strong>
        <?php endif ?>
      </td>
      <td>
        <?php echo $salida->nombre_recorrido;?> </td>
      <td>
        <?php echo $salida->modelo_unidad; ?> (
        <?php echo $salida->placa_unidad;?>)</td>
      <td>
        <?php echo $fecha_salida->format('d/m/Y') ?> -
        <?php echo $hora_salida->format('H:i a') ?>
      </td>
      <td>
        <?php echo $fecha_entrada->format('d/m/Y') ?> -
        <?php echo $hora_entrada->format('H:i a') ?>
      </td>
      </tr>
      <?php endforeach;?>
      <?php else:?>
      <tr>
        <td colspan="6">
          <p class="text-center">
            No Hay salidas
          </p>
        </td>
      </tr>
      <?php endif;?>
    </tbody>
  </table>
  <div class="clearfix"></div>
  <?php endif ?>
</div>
<!-- /#main_content -->
</div>
<!-- /.row -->
<script>
  $('.datepicker').datepicker();
</script>
<?php $this->load->view('admin/layout/footer') ?>