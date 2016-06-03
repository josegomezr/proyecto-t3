<?php $this->load->view('admin/layout/header'); ?>
<?php $this->load->view('admin/layout/sidebar'); ?>

<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
  <form>
    <h4>Criterios</h4>
    <div class="row clearfix">
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
          <label for="criteria">Agrupar por:</label>
          <select name="criteria" id="criteria" class="form-control">
            <option value="">Seleccione criterio</option>
            <option value="unidad">Unidad</option>
            <option value="conductor">Conductor</option>
            <option value="recorrido">Recorrido</option>
          </select>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
        <div class="form-group">
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
        <button class="btn btn-primary">Filtrar</button>
      </div>
    </div>
    <div class="clearfix"></div>
  </form>
  <div class="row clearfix" id="chart-area">
    <div class="col-xs-12 col-sm-6">
      <canvas id="grafica_salida" height="300"></canvas>
    </div>
    <div class="col-xs-12 col-sm-6">
      <canvas id="grafica_entrada" height="300"></canvas>
    </div>
  </div>
</div>

<script src="<?php echo base_url('components/Chart.js/dist/Chart.bundle.min.js') ?>"></script>

<script>
  var base = '<?php echo site_url(); ?>';
</script>

<script>
var $graficas = $('#chart-area');
var $valueSelect = $("#value");
var $criteria = $("#criteria");

var $grafica_salida = $("#grafica_salida")
var $grafica_entrada = $("#grafica_entrada")

$criteria.on('change', function (e) {
  if (!e.target.value) {
    $graficas.addClass('hidden');
    return;
  }

  $.getJSON(base+'/admin/reporte/json_valores_para/'+e.target.value, function (values) {
    $valueSelect.find('option').slice(1).remove();
    for(var i in values){
      var fila = values[i];
      var $opt = $("<option></option>", {value: fila.pk}).text(fila.display);
      $valueSelect.append($opt);
    }
    $valueSelect.val('').trigger('change');
  })

})


function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

$valueSelect.on('change', function ( e ) {
  var criteria = $criteria.val();
  var choices = $valueSelect.val() || 'none';

  
  $.getJSON(base+'/admin/reporte/json_incidencias/'+criteria, function (json) {
    var data = {
      labels: []
    };
    var dset1 = {
      data: [],
      backgroundColor: []
    };
    json.forEach(function (item) {
      data.labels.push(item.label);
      dset1.data.push(item.total);
      dset1.backgroundColor.push(getRandomColor());
    })

    data.datasets = [dset1];

    var chart = new Chart(grafica_salida,{
        type: 'pie',
        data: data
    });
  })


});

/*
var data = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
        {
            label: "My First dataset",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: [65, 59, 80, 81, 56, 55, 40],
        }
    ]
};

  var chartInstance = new Chart(grafica_salida, {
      type: 'line',
      data: data,
      options: {
          responsive: false
      }
  });*/
</script>
<?php $this->load->view('admin/layout/footer'); ?>