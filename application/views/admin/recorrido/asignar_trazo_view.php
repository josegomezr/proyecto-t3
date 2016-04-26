<?php $this->load->view('admin/layout/header') ?>
<?php $this->load->view('admin/layout/sidebar') ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
    <form method="post">

        <div class="form-group <?php echo Form\has_error('nombre_recorrido') ? 'has-error' :'' ?>">
            <label class="control-label" for="nombre_recorrido">Nombre Recorrido</label>
            <input type="text" name="nombre_recorrido" id="nombre_recorrido" class="form-control" disabled value="<?php echo Form\set_value('nombre_recorrido', $recorrido->nombre_recorrido) ?>">
        </div>

        <div class="form-group">
            <div id="map-canvas"></div>
        </div>
        <div id="points-container"></div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="reset" class="btn btn-default">Limpiar</button>
        </div>
    </form>
</div> <!-- /#main_content -->
</div> <!-- /.row -->

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDSdgFMoTaquUeNJDfP-dKglPX_OehjSK0&sensor=true"></script>
<script src="<?php echo base_url('assets/js/gmaps.js') ?>"></script>

<script>
    var routePath = <?php echo json_encode($trazado_pairs) ?> || [];
</script>

<script>
    var widgets = [];
    var polydots = new google.maps.MVCArray();

    routePath.forEach(function (e) {
        polydots.push( new google.maps.LatLng(e[0], e[1]));
    })
    var map = new GMaps({
        div: '#map-canvas',
        lat: 10.438084,
        lng: -64.1412109,
        scrollwheel: true,
        panControl: false,
        streetViewControl: false,
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
            position: google.maps.ControlPosition.TOP_RIGHT
        }
    });

    var polyLine = map.drawPolyline({
        path: [],
        strokeColor: 'blue',
        strokeOpacity: .75,
        strokeWeight: 3,
        editable: true
    });

    polyLine.setPath(polydots);

    $(document).ready(function() {
        GMaps.on('click', map.map, function(event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            polydots.push(event.latLng);
            polyLine.setPath(polydots);
        });
    });

    $('form').on('submit', function (e) {
        e.preventDefault();
        var $cont = $('#points-container');
        var arr = polydots.getArray();
        for(var i in arr){
            var coord = arr[i].toUrlValue();
            $('<input />', {name: 'puntos['+i+']', type: 'hidden'}).val(coord).appendTo($cont);
        }
        e.target.submit();
    });

    $('form').on('reset', function (e) {
        e.preventDefault();
        polydots.clear();
    });
</script>

<?php $this->load->view('admin/layout/footer') ?>