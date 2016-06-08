<?php $this->load->view('admin/layout/header'); ?>
<?php $this->load->view('admin/layout/sidebar'); ?>

<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
  <form>
    <h4>Estadist&iacute;cas de Incidencia</h4>
    <div class="row clearfix">
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label for="fecha_inicio">Fecha Inicio</label>
          <input type="text" id="fecha_inicio" class="datepicker form-control">
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label for="fecha_final">Fecha Final</label>
          <input type="text" id="fecha_inicio" class="datepicker form-control">
        </div>
      </div>
    </div>
    <div class="row clearfix">
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label for="criteria">Criterio:</label>
          <select name="criteria" id="criteria" class="form-control">
            <option value="">Seleccione criterio</option>
            <option value="unidad">Unidad</option>
            <option value="conductor">Conductor</option>
            <option value="recorrido">Recorrido</option>
          </select>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
        <div class="form-group hidden">
          <label for="value">Elementos:</label>
          <select name="value" id="value" multiple class="form-control">
            <option value="">Todos</option>
          </select>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group">
      <div class="pull-right">
        <button id="fetch_graficas" type="button" class="btn btn-primary">Filtrar</button>
      </div>
    </div>
    <div class="clearfix"></div>
  </form>
  <div class="row clearfix hidden" id="graficas-generales">
    <div class="col-xs-12 col-sm-6">
      <h3>Salidas</h3>
      <canvas id="grafica_salida" height="200"></canvas>
    </div>
    <div class="col-xs-12 col-sm-6">
      <h3>Entradas</h3>
      <canvas id="grafica_entrada" height="200"></canvas>
    </div>
  </div>

  <div id="graficas-detalladas" class="hidden">
    <div class="row clearfix">
      <div class="col-xs-12">
        <h3>Salidas</h3>
      </div>
      <div class="col-xs-12 col-sm-6 hidden">
        <canvas id="grafica_salida_conductor" height="200"></canvas>
      </div>
      <div class="col-xs-12 col-sm-6 hidden">
        <canvas id="grafica_salida_unidad" height="200"></canvas>
      </div>
      <div class="col-xs-12 col-sm-6 hidden">
        <canvas id="grafica_salida_recorrido" height="200"></canvas>
      </div>
    </div>
    <div class="row clearfix hidden">
      <div class="col-xs-12">
        <h3>Entradas</h3>
      </div>
      <div class="col-xs-12 col-sm-6 hidden">
        <canvas id="grafica_entrada_conductor" height="200"></canvas>
      </div>
      <div class="col-xs-12 col-sm-6 hidden">
        <canvas id="grafica_entrada_unidad" height="200"></canvas>
      </div>
      <div class="col-xs-12 col-sm-6 hidden">
        <canvas id="grafica_entrada_recorrido" height="200"></canvas>
      </div>
    </div>
  </div>
</div>
<p>&nbsp;</p>
<script src="<?php echo base_url('components/Chart.js/dist/Chart.bundle.min.js') ?>"></script>

<script>
  var base = '<?php echo site_url(); ?>';
</script>

<script>
var $graficas_generales = $('#graficas-generales');
var $graficas_detalladas = $('#graficas-detalladas');
var $valueSelect = $("#value");
var $criteria = $("#criteria");
var $fecha_inicio = $("#fecha_inicio");
var $fecha_final = $("#fecha_final");

var $grafica_salida = $("#grafica_salida")
var $grafica_entrada = $("#grafica_entrada")

var $grafica_salida_conductor = $("#grafica_salida_conductor")
var $grafica_salida_unidad = $("#grafica_salida_unidad")
var $grafica_salida_recorrido = $("#grafica_salida_recorrido")

var $grafica_entrada_conductor = $("#grafica_entrada_conductor")
var $grafica_entrada_unidad = $("#grafica_entrada_unidad")
var $grafica_entrada_recorrido = $("#grafica_entrada_recorrido")

var chartSalidaGeneral = new Chart($grafica_salida, genChartConfig());
var chartEntradaGeneral = new Chart($grafica_entrada, genChartConfig());

var chart_detallados = {
  salida: {
    unidad: new Chart($grafica_salida_conductor, genChartConfig()),
    conductor: new Chart($grafica_salida_unidad, genChartConfig()),
    recorrido: new Chart($grafica_salida_recorrido, genChartConfig())
  },
  entrada: {
    unidad: new Chart($grafica_entrada_conductor, genChartConfig()),
    conductor: new Chart($grafica_entrada_unidad, genChartConfig()),
    recorrido: new Chart($grafica_entrada_recorrido, genChartConfig())
  },
}


function cargar_graficas_generales(criteria, data) {
  $graficas_generales.removeClass('hidden');
  $graficas_detalladas.addClass('hidden');
  $.getJSON( base + '/admin/reporte/json_incidencias/' + criteria, data )
    .success(function (json) {
      var labelEntrada = [];
      var labelSalida = [];

      var datasetSalida = genBarChartDataset ( "Incidencias al Partir" );
      var datasetEntrada = genBarChartDataset ( "Incidencias al Partir" );

      var maxEntrada = 0, maxSalida = 0;

      json.salida.forEach(function (item) {
        labelSalida.push(item.label)
        datasetSalida.data.push(item.total);
        maxSalida = Math.max(maxSalida, item.total);
      })

      json.entrada.forEach(function (item) {
        labelEntrada.push(item.label)
        datasetEntrada.data.push(item.total);
        maxEntrada = Math.max(maxEntrada, item.total);
      })

      chartSalidaGeneral.options
        .scales.yAxes[0]
        .ticks.suggestedMax = maxSalida + 1;
      chartEntradaGeneral.options
        .scales.yAxes[0]
        .ticks.suggestedMax = maxEntrada + 1;

      chartSalidaGeneral.data.datasets = [ datasetSalida ];
      chartEntradaGeneral.data.datasets = [ datasetEntrada ];

      chartSalidaGeneral.data.labels = labelSalida;
      chartEntradaGeneral.data.labels = labelEntrada;
      
      chartSalidaGeneral.update();
      chartEntradaGeneral.update();
  })
}

function cargar_graficas_detalladas(criteria, values, data) {
    $graficas_generales.addClass('hidden');
    $graficas_detalladas.removeClass('hidden');

    data.ids = values;
    
    for(var tipo in chart_detallados){
      var group = chart_detallados[tipo];
      for(var entidad in group){
        var c = group[entidad];
        $(c.chart.canvas).parent().addClass('hidden');
      }
    }

    $.getJSON( base + '/admin/reporte/json_incidencias_detalladas/' + criteria, data )
    .success(function (json) {  

      for (entity in json.salida) {
        var data = json.salida[entity];

        var maxSalida = 0;
        var dataset = genBarChartDataset(entity);
        var labels = [];

        dataset.data = data.map(function (e) {
          labels.push(e.label);
          maxSalida = Math.max(maxSalida, e.total);
          return e.total;
        })

        chart_detallados.salida[entity].options
        .scales.yAxes[0]
        .ticks.suggestedMax = maxSalida + 1;

        chart_detallados.salida[entity].label = entity;

        chart_detallados.salida[entity].data.datasets = [dataset];
        
        chart_detallados.salida[entity].data.labels = labels;
        
        chart_detallados.salida[entity].update();
        var c = chart_detallados.salida[entity].chart.canvas
        $(c).parent().removeClass('hidden');
      }


      for (entity in json.entrada) {
        var data = json.entrada[entity];

        var maxSalida = 0;
        var dataset = genBarChartDataset(entity);
        var labels = [];

        dataset.data = data.map(function (e) {
          labels.push(e.label);
          maxSalida = Math.max(maxSalida, e.total);
          return e.total;
        })

        chart_detallados.entrada[entity].options
        .scales.yAxes[0]
        .ticks.suggestedMax = maxSalida + 1;

        chart_detallados.entrada[entity].data.datasets = [dataset];
        
        chart_detallados.entrada[entity].data.labels = labels;
        chart_detallados.entrada[entity].update();
        var c = chart_detallados.entrada[entity].chart.canvas
        $(c).parent().removeClass('hidden');
      }

      /*json.entrada.forEach(function (item) {
        labelEntrada.push(item.label)
        datasetEntrada.data.push(item.total);
        maxEntrada = Math.max(maxEntrada, item.total);
      })*/

   /*   chartSalidaGeneral.options
        .scales.yAxes[0]
        .ticks.suggestedMax = maxSalida + 1;
      chartEntradaGeneral.options
        .scales.yAxes[0]
        .ticks.suggestedMax = maxEntrada + 1;

      chartSalidaGeneral.data.datasets = [ datasetSalida ];
      chartEntradaGeneral.data.datasets = [ datasetEntrada ];

      chartSalidaGeneral.data.labels = labelSalida;
      chartEntradaGeneral.data.labels = labelEntrada;
      
      chartSalidaGeneral.update();
      chartEntradaGeneral.update();*/
  })
}

function cargar_graficas(criteria, values) {  

  var valid = values.filter(function(e){
    return !!e;
  }).length;
  
  var data = {
    fecha_inicio: $fecha_inicio.val(),
    fecha_final: $fecha_final.val(),
  };

  if (valid > 0) {
    cargar_graficas_detalladas(criteria, values, data);
  }else{
    cargar_graficas_generales(criteria, data);
  }
}

$criteria.on('change', function (e) {
  var value = e.target.value;
  
  if (!value) {
    $valueSelect.parent().addClass('hidden');
    $graficas_generales.addClass('hidden');
    $graficas_detalladas.addClass('hidden');
    return;
  }

  $valueSelect.parent().removeClass('hidden');
  $.getJSON(base+'/admin/reporte/json_valores_para/'+value, function (values) {
    $valueSelect.find('option').slice(1).remove();
    for(var i in values){
      var fila = values[i];
      var $opt = $("<option></option>", {value: fila.pk}).text(fila.display);
      $valueSelect.append($opt);
    }
    $valueSelect.val('').trigger('change');
  })
})

$("#fetch_graficas").on('click', function () {
  var criteria = $criteria.val();  
  var values = $valueSelect.val();  
  if (!criteria) {
    return;
  }
  cargar_graficas(criteria, values);
})

$(".datepicker").datepicker();

</script>
<?php $this->load->view('admin/layout/footer'); ?>