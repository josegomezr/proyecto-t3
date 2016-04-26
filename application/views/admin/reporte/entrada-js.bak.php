<?php $this->load->view('admin/layout/header'); ?>
<?php $this->load->view('admin/layout/sidebar'); ?>
<style>
  #map-canvas {
    height: 500px;
    margin: 0px;
    padding: 0px
  }
</style>

<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">

		<h3>Datos de la salida</h3>
		<table width="100%">
			<tr>
				<td>
					<p>
						<?php if(isset($acompaniante)): ?>
							<strong>Choferes: </strong>
						<?php else: ?>
							<strong>Chofer: </strong>
						<?php endif; ?>
						<span><?php echo $chofer->nombre_chofer ?> <?php echo $chofer->apellido_chofer ?></span>
						<?php if(isset($acompaniante)): ?>
							<span>y <?php echo $acompaniante->nombre_chofer ?> <?php echo $acompaniante->apellido_chofer ?></span>
						<?php endif; ?>
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
				</td>
				<td>
					<p>
						<strong>Observaciones al partir:</strong><br>
						<?php echo $entrada->observacion_salida == "" ? 'N/A' : $entrada->observacion_salida; ?>
					</p>
					<p>
						<strong>Observaciones al llegar:</strong><br>
						<?php echo $entrada->observacion_entrada == "" ? 'N/A' : $entrada->observacion_entrada; ?>
					</p>
				</td>
			</tr>
		</table>
		
		<?php if (count($puntos) == 0): ?>
			<h3>No hay recorrido guardado para esta salida</h3>
		<?php else: ?>
			<h3>
				Mapa del Recorrido 
				<small class="pull-right">
					<span class="line-red">
						<i class="fa fa-stop"></i> Ruta Trazada
					</span>
					 | 
					<span class="line-blue">
						<i class="fa fa-stop"></i> Ruta Preestablecida
					</span>
				</small>
			</h3>
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

	$radioAccion = 25 * 0.000025;

	function isAdjacent($pointA, $pointB)
	{
		$radioAccion = 25 * 0.000025;
		return (pow($pointA->latitud-$pointB->latitud, 2) + pow($pointA->longitud-$pointB->longitud, 2)) < pow($radioAccion, 2);
	}

	
	$primero = reset($puntos);
	$pathPairs = array();
	$minLat = 360;
	$minLong = INF;
	$maxLat = -180;
	$maxLong = -180;

	$prevTime = DateTime::createFromFormat('H:i:s', $primero->hora_punto);
	$prevPunto = $primero;

	$markers = array($primero);
	foreach($puntos as $k=>&$punto){
		$punto->latitud = (float)$punto->latitud;
		$punto->longitud = (float)$punto->longitud;
		$punto->velocidad = (float)$punto->velocidad;
		$minLat = min($minLat, $punto->latitud);
		$minLong = min($minLong, $punto->longitud);

		$maxLat = max($punto->latitud, $maxLat);
		$maxLong = max($punto->longitud, $maxLong);
		$pathPairs[] = array($punto->latitud, $punto->longitud);

		$time = DateTime::createFromFormat('H:i:s', $punto->hora_punto);
		$diff = $prevTime->diff($time);

		if((int)$diff->format("%i") > 1 && !isAdjacent($punto, $prevPunto)){
			$ref = $punto;
			$angle = atan2($prevPunto->latitud - $punto->latitud, $prevPunto->longitud - $punto->longitud) * 180 / M_PI;

			$ref->angulo_punto = $angle;
			
			$markers[] = $ref;

			$prevTime = $time;
			$prevPunto = $punto;
		}
	}

	$polyArea = array(
		array($minLat, $minLong),
		array($minLat, $maxLong),
		array($maxLat, $maxLong),
		array($maxLat, $minLong),
		);

	$center = array(
		'latitud' => ($minLat+$maxLat)/2,
		'longitud' => ($minLong+$maxLong)/2
	);
	?>

	<script type="text/javascript">
	var center = <?php echo json_encode($center) ?>;
	// -------------------------------------------------
	var routePath = <?php echo json_encode($pathPairs);?>;
	// -------------------------------------------------
	var polyArea = <?php echo json_encode($polyArea); ?>;
	// -------------------------------------------------
	var markers = <?php echo json_encode($markers); ?>;
	// -------------------------------------------------
	var radioAccion = <?php echo $radioAccion; ?>;
	// -------------------------------------------------

	var ruta_preestablecida = [[10.448580724853267,-64.14820164442062],[10.448506868326765,-64.14814800024033],[10.448443562718644,-64.14807826280594],[10.448311675993642,-64.14796561002731],[10.448185064684974,-64.14782613515854],[10.448021525001552,-64.14765983819962],[10.447815781406636,-64.1474774479866],[10.447610037675465,-64.14723604917526],[10.447425395749468,-64.14711534976959],[10.447214376271107,-64.14750158786774],[10.447151070399663,-64.14760887622833],[10.447066662551002,-64.14753377437592],[10.447129968439647,-64.14728701114655],[10.447298784079655,-64.14701879024506],[10.447488701565023,-64.14665400981903],[10.447815781406636,-64.1460531949997],[10.448069004273352,-64.1454416513443],[10.448311675993642,-64.14514124393463],[10.448670407754712,-64.14447605609894],[10.448870875323134,-64.14402544498444],[10.449081893676482,-64.14360702037811],[10.44932456460564,-64.14317786693573],[10.449577786242651,-64.14265215396881],[10.449799355005746,-64.14215862751007],[10.450126432414805,-64.14154708385468],[10.450348000786578,-64.14118230342865],[10.450643425036438,-64.1405600309372],[10.450959950706647,-64.1400557756424],[10.451181518483896,-64.13945496082306],[10.451476941941035,-64.13898289203644],[10.451687958524097,-64.13860738277435],[10.451888424145231,-64.13819968700409],[10.452099440448738,-64.13779199123383],[10.452489820232286,-64.1373199224472],[10.453112316709904,-64.13655817508698],[10.453576550558942,-64.13617193698883],[10.45399858072858,-64.13567841053009],[10.4544628132527,-64.13534581661224],[10.454990349369488,-64.13491666316986],[10.455422928316459,-64.13441240787506],[10.455813303921968,-64.13403689861298],[10.456404141742643,-64.13348972797394],[10.456805066766304,-64.13315713405609],[10.45690002261712,-64.13329660892487],[10.45690002261712,-64.13324296474457],[10.456931674560941,-64.1333931684494],[10.456551851022121,-64.13377940654755],[10.456266983063058,-64.1340047121048],[10.456013766880023,-64.13423001766205],[10.455602290142105,-64.13457334041595],[10.455317421311786,-64.13470208644867],[10.454958697227747,-64.13504540920258],[10.454832088628557,-64.13517415523529],[10.454410059591744,-64.13548529148102],[10.454072435949286,-64.13587152957916],[10.453555449035402,-64.13630068302155],[10.453871971737913,-64.13601100444794],[10.453471042926912,-64.13642942905426],[10.453143969039845,-64.13670837879181],[10.452901301094581,-64.1369765996933],[10.452532023422748,-64.13749158382416],[10.452489820232286,-64.13757741451263],[10.45219439773855,-64.13799583911896],[10.451930627417395,-64.13839280605316],[10.451740712647469,-64.13878977298737],[10.451508594437637,-64.13913309574127],[10.451276476054325,-64.13966953754425],[10.451170967640946,-64.13983047008514],[10.450959950706647,-64.14020597934723],[10.450759484486296,-64.14075314998627],[10.450580119863684,-64.14098918437958],[10.450400755137512,-64.14131104946136],[10.450210839432197,-64.14172947406769],[10.4500631271367,-64.14197623729706],[10.44991541477095,-64.14231956005096],[10.449820456784456,-64.1424697637558],[10.449641091619661,-64.14280235767365],[10.449577786242651,-64.14290964603424],[10.449366768226138,-64.1433709859848],[10.44913464824242,-64.14375722408295],[10.448976384517733,-64.14414346218109],[10.448628204039611,-64.14469063282013],[10.448955282681672,-64.14422929286957],[10.448586000318773,-64.1448837518692],[10.448396083504093,-64.14526998996735],[10.448185064684974,-64.14563477039337],[10.448090106169603,-64.1458386182785],[10.447910740005833,-64.14622485637665],[10.447794679491759,-64.14638578891754],[10.447741924698295,-64.14649307727814],[10.447583660264192,-64.14680421352386],[10.447499252533033,-64.14673984050751],[10.44744649768942,-64.1469007730484],[10.447486063822977,-64.14704695343971],[10.447557282850667,-64.14718307554722],[10.447673343453415,-64.14732925593853],[10.44790810226736,-64.14757736027241],[10.44810988919602,-64.14777182042599],[10.448253645816907,-64.14792336523533],[10.44836706842497,-64.1480628401041],[10.448480490991608,-64.1481513530016],[10.448537202259413,-64.1482063382864],[10.448582043719652,-64.14825059473515]];
	</script>

	<script type="text/javascript">
	jQuery(function ($) {
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
		
		var boundingBox = map.drawPolygon({
		  paths: polyArea, // pre-defined polygon shape
		  strokeColor: '#BBD8E9',
		  strokeOpacity: 1,
		  strokeWeight: 3,
		  fillColor: '#BBD8E9',
		  fillOpacity: 0.15,
		  visible: GPS.enable.boundingBox
		});



		var latlng = ruta_preestablecida[0];
		var lat = latlng[0], lng = latlng[1];
		
		function getAdjacentPoints(coord, routePath){
			return routePath.filter(function (e) {
				return (Math.pow(e[0]-coord[0], 2) + Math.pow(e[1]-coord[1], 2)) < Math.pow(radioAccion, 2);
			});
		}

		if(GPS.enable.routeOffRoad){
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

		markers.forEach(function(e, k){
			map.addMarker({
			  lat: e.latitud,
			  lng: e.longitud,
			  infoWindow: {
			  	content:  '<strong>Fecha: </strong> ' + e.fecha_punto.split('-').reverse().join('/') 
			  			+ '<br><strong>Hora:</strong> '+ e.hora_punto 
			  			+ '<br><strong>Velocidad</strong>: ' + e.velocidad.toFixed(2) + 'Km/h'
			  },
		  	  visible: GPS.enable.routeMarkers
			});
		});

		markers.forEach(function(e, k){
			map.drawCircle({
			  lat: e.latitud,
			  lng: e.longitud,
			  radius: 25,
			  fillColor: 'green',
			  strokeColor: 'green',
			  strokeOpacity: 0.3,
			  fillOpacity: .5,
			  visible: GPS.enable.routeMarkersArea
			});
		});

		var routePolyLine = map.drawPolyline({
		  path: routePath, // pre-defined polygon shape
		  strokeColor: 'red',
		  strokeOpacity: .75,
		  strokeWeight: 1,
		  visible: GPS.enable.routePath
		});

		var existingPolyLine = map.drawPolyline({
		  path: ruta_preestablecida, // pre-defined polygon shape
		  strokeColor: 'blue',
		  strokeOpacity: .75,
		  strokeWeight: 3
		});

	})
	</script>
<?php endif ?>
<?php $this->load->view('admin/layout/footer'); ?>