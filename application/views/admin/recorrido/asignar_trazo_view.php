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
<style>
.delete-menu {
    position: absolute;
    background: white;
    padding: 3px;
    color: #666;
    font-weight: bold;
    border: 1px solid #999;
    font-family: sans-serif;
    font-size: 12px;
    box-shadow: 1px 3px 3px rgba(0, 0, 0, .3);
    margin-top: -10px;
    margin-left: 10px;
    cursor: pointer;
  }
  .delete-menu:hover {
    background: #eee;
  }
</style>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDSdgFMoTaquUeNJDfP-dKglPX_OehjSK0&sensor=true"></script>
<script src="<?php echo base_url('assets/js/gmaps.js') ?>"></script>

<script>
    var routePath = <?php echo json_encode($trazado_pairs) ?> || [];
</script>

<script>
    /**
 * A menu that lets a user delete a selected vertex of a path.
 * @constructor
 */
function DeleteMenu() {
  this.div_ = document.createElement('div');
  this.div_.className = 'delete-menu';
  this.div_.innerHTML = 'Eliminar Punto';

  var menu = this;
  google.maps.event.addDomListener(this.div_, 'click', function() {
    menu.removeVertex();
  });
}
DeleteMenu.prototype = new google.maps.OverlayView();

DeleteMenu.prototype.onAdd = function() {
  var deleteMenu = this;
  var map = this.getMap();
  this.getPanes().floatPane.appendChild(this.div_);

  // mousedown anywhere on the map except on the menu div will close the
  // menu.
  this.divListener_ = google.maps.event.addDomListener(map.getDiv(), 'mousedown', function(e) {
    if (e.target != deleteMenu.div_) {
      deleteMenu.close();
    }
  }, true);
};

DeleteMenu.prototype.onRemove = function() {
  google.maps.event.removeListener(this.divListener_);
  this.div_.parentNode.removeChild(this.div_);

  // clean up
  this.set('position');
  this.set('path');
  this.set('vertex');
};

DeleteMenu.prototype.close = function() {
  this.setMap(null);
};

DeleteMenu.prototype.draw = function() {
  var position = this.get('position');
  var projection = this.getProjection();

  if (!position || !projection) {
    return;
  }

  var point = projection.fromLatLngToDivPixel(position);
  this.div_.style.top = point.y + 'px';
  this.div_.style.left = point.x + 'px';
};

/**
 * Opens the menu at a vertex of a given path.
 */
DeleteMenu.prototype.open = function(map, path, vertex) {
  this.set('position', path.getAt(vertex));
  this.set('path', path);
  this.set('vertex', vertex);
  this.setMap(map);
  this.draw();
};

/**
 * Deletes the vertex from the path.
 */
DeleteMenu.prototype.removeVertex = function() {
  var path = this.get('path');
  var vertex = this.get('vertex');

  if (!path || vertex == undefined) {
    this.close();
    return;
  }

  path.removeAt(vertex);
  this.close();
};
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
        disableDoubleClickZoom: true,
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
        var deleteMenu = new DeleteMenu();
        GMaps.on('dblclick', map.map, function(event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            polydots.push(event.latLng);
            polyLine.setPath(polydots);
        });
        polyLine.addListener('rightclick', function(e) {
            // Check if click was on a vertex control point
            if (e.vertex == undefined) {
                return;
            }
            deleteMenu.open(map.map, polyLine.getPath(), e.vertex);
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