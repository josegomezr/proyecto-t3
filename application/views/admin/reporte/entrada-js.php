<?php $this->load->view('admin/layout/header'); ?>
<?php $this->load->view('admin/layout/sidebar'); ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">

        <h3>Datos de la salida</h3>
        <table width="100%">
            <tr>
                <td>
                    <p>
                        <?php if ($entrada->id_conductor): ?>
                            <?php if(isset($acompaniante)): ?>
                                <strong>Conductores: </strong>
                            <?php else: ?>
                                <strong>Conductor: </strong>
                            <?php endif; ?>
                            <span><?php echo $conductor->nombre_conductor ?> <?php echo $conductor->apellido_conductor ?></span>
                            <?php if(isset($acompaniante)): ?>
                                <span>y <?php echo $acompaniante->nombre_conductor ?> <?php echo $acompaniante->apellido_conductor ?></span>
                            <?php endif; ?>
                        <?php else: ?>
                            <strong>Conductor:</strong> N/A <strong class="text-danger">¡SALIDA NO NOTIFICADA!</strong>
                        <?php endif ?>
                    </p>
                    <p>
                        <strong>Unidad: </strong> <span><?php echo $entrada->modelo_unidad?> (<?php echo $entrada->placa_unidad ?>)</span>
                    </p>
                    <p>
                        <strong>Recorrido: </strong> <span><?php echo $entrada->nombre_recorrido; ?></span>
                    </p>
<?php 
$salidaDate = DateTime::createFromFormat('Y-m-d H:i:s', $entrada->fecha_salida . ' ' . $entrada->hora_salida);
$entradaDate = DateTime::createFromFormat('Y-m-d H:i:s', $entrada->fecha_entrada . ' ' . $entrada->hora_entrada);
 ?>

                    <p>
                        <strong>Partida: </strong> <span><?php echo $salidaDate->format('d/m/Y - H:i A') ?></span>
                    </p>
                    <p>
                        <strong>Llegada: </strong> <span><?php echo $entradaDate->format('d/m/Y - H:i A')  ?></span>
                    </p>
                    <p>
                        <strong>Duración del Recorrido: </strong> <span><?php echo $entradaDate->diff($salidaDate)->format('%D %H:%I');  ?></span>
                    </p>
                </td>
                <td>
                    <?php if ($incidencia_salida): ?>
                    <p>
                        <strong>Incidencias al partir:</strong><br>
                        <?php echo $incidencia_salida->descripcion_tipo_incidencia ?> - <?php echo $incidencia_salida->descripcion_incidencia ?>
                        <?php if ($entrada->comentario_salida_incidencia): ?>
                        	<p><?php echo $entrada->comentario_salida_incidencia; ?></p>
                        <?php endif ?>
                    </p>
                    <?php endif ?>
                    <?php if ($incidencia_entrada): ?>
                    <p>
                        <strong>Observaciones al llegar:</strong><br>
                        <?php echo $incidencia_entrada->descripcion_tipo_incidencia ?> - <?php echo $incidencia_entrada->descripcion_incidencia ?>
                        <?php if ($entrada->comentario_entrada_incidencia): ?>
                        	<p><?php echo $entrada->comentario_entrada_incidencia; ?></p>
                        <?php endif ?>
                    </p>
                    <?php endif ?>
                </td>
            </tr>
        </table>
        
        <?php if (count($puntos) == 0): ?>
            <h3>No hay recorrido guardado para esta salida</h3>
        <?php else: ?>
            <h3>
                Mapa del Recorrido 
                <small class="pull-right">
                    <span class="map-legend">
                        <i class="fa fa-dot-circle-o"></i> Inicio del Recorrido
                    </span>
                    |
                    <span class="map-legend">
                        <i class="fa fa-circle"></i> Fin del Recorrido
                    </span>
                    |
                    <span class="map-legend line-red">
                        <i class="fa fa-stop"></i> Recorrido Realizado
                    </span>
                     | 
                    <span class="map-legend line-blue">
                        <i class="fa fa-stop"></i> Recorrido Planificado
                    </span>
                </small>
            </h3>
            <div class="clearfix"></div>
            <div class="embed-responsive embed-responsive-16by9">
                <div id="map-canvas"></div>
            </div>
        <?php endif ?>
        
    </div>
</div>
<?php if (count($puntos) > 0): ?>
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDSdgFMoTaquUeNJDfP-dKglPX_OehjSK0&sensor=true"></script>
    <script src="<?php echo base_url('assets/js/gmaps.js') ?>"></script>
    <?php 

    ?>

    <script type="text/javascript">
    var center = <?php echo json_encode($route_center) ?>;
    // -------------------------------------------------
    var routePath = <?php echo json_encode($route_pairs);?>;
    // -------------------------------------------------
    var markers = <?php echo json_encode($markers); ?>;
    // -------------------------------------------------
    var radioAccion = <?php echo $radioAccion; ?>;
    // -------------------------------------------------

    var ruta_preestablecida = <?php echo json_encode($defaultRoute); ?> || [];
    </script>

    <script type="text/javascript">
//  jQuery(function ($) {
        window.map = new GMaps({
          div: '#map-canvas',
          lat: center.latitud,
          lng: center.longitud,
          scrollwheel: false,
          panControl: false,
          streetViewControl: false,
          mapTypeControl: true,
          mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
            position: google.maps.ControlPosition.TOP_RIGHT
          }
        });

        map.addControl({
          position: 'top_right',
          content: 'Centrar mapa',
          style: {
            margin: '1.15em',
            padding: '1px 6px',
            border: 'solid 2px white',
            background: 'white'
          },
          events: {
            click: function(){
              map.fitZoom();
            }
          }
        });

        var ruta_planificada = map.drawPolyline({
          path: ruta_preestablecida, // pre-defined polygon shape
          strokeColor: 'blue',
          strokeOpacity: .75,
          strokeWeight: 3
        });

        var ruta_recorrida = map.drawPolyline({
          path: routePath, // pre-defined polygon shape
          strokeColor: 'red',
          strokeOpacity: .75,
          strokeWeight: 2
        });

        if(GPS.enable.routeStart){
            var start = routePath[0];
            map.addMarker({
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 4,
                    strokeColor: "black",
                    fillColor: 'white',
                    fillOpacity: .75
                },
                lat: start[0],
                lng: start[1],
                zIndex: 0
            });
        }
        if(GPS.enable.routeEnd){
            var end = routePath[routePath.length -1];
            map.addMarker({
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 5,
                    fillColor: 'black',
                    strokeOpacity: 0,
                    fillOpacity: .75
                },
                lat: end[0],
                lng: end[1],
                zIndex: 0
            });
        }

        if(GPS.enable.routeOffRoad){
            function getAdjacentPoints(coord, routePath){
                return routePath.filter(function (e) {
                    return (Math.pow(e[0]-coord[0], 2) + Math.pow(e[1]-coord[1], 2)) < Math.pow(radioAccion, 2);
                });
            }
            routePath.forEach(function (e) {
                var adjacent = getAdjacentPoints(e, ruta_preestablecida);
                if(adjacent.length == 0){
                    map.drawCircle({
                        lat: e[0],
                        lng: e[1],
                        radius: radioAccion*25*2500,
                        fillColor: 'red',
                        strokeColor: 'red',
                        strokeOpacity: .3,
                        fillOpacity: .35
                    });
                }
            })
        }

        if(GPS.enable.routeMarkers){
            markers.forEach(function(e, k){
                map.addMarker({
                  lat: e.latitud,
                  lng: e.longitud,
                  infoWindow: {
                    content:  '<strong>Fecha: </strong> ' + e.fecha_punto.split('-').reverse().join('/') 
                            + '<br><strong>Hora:</strong> '+ e.hora_punto 
                            + '<br><strong>Velocidad</strong>: ' + e.velocidad.toFixed(2) + 'Km/h'
                            + '<br><strong>N&uacute;mero de Sat&eacute;lites</strong>: ' + e.num_satelites
                  },
                  visible: GPS.enable.routeMarkers,
                  zIndex: 1
                });

                if(GPS.enable.routeMarkersArea){
                    map.drawCircle({
                      lat: e.latitud,
                      lng: e.longitud,
                      radius: 100 - (e.num_satelites*4),
                      fillColor: (e.num_satelites > 0 ? 'green' : 'orange'),
                      strokeColor: (e.num_satelites > 0 ? 'green' : 'orange'),
                      strokeOpacity: 0.15,
                      fillOpacity: .25,
                      visible: GPS.enable.routeMarkersArea
                    });
                }
            });
        }
//  })
    </script>
<?php endif ?>
<?php $this->load->view('admin/layout/footer'); ?>