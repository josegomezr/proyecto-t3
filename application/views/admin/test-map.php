<?php $this->load->view('admin/layout/header'); ?>
<?php $this->load->view('admin/layout/sidebar'); ?>
<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
			<h3> Recorrido Trazado </h3>
			<div class="embed-responsive embed-responsive-16by9">
				<div id="map-canvas"></div>
			</div>
	</div>
</div>
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDSdgFMoTaquUeNJDfP-dKglPX_OehjSK0&sensor=true"></script>
	<script src="<?php echo base_url('assets/js/gmaps.js') ?>"></script>
	<script type="text/javascript">

	// -------------------------------------------------
	var routePath = <?php echo json_encode($route_pairs);?>;
	</script>

	<script type="text/javascript">
//	jQuery(function ($) {
		var map = new GMaps({
		  div: '#map-canvas',
		  lat: 10.438084,
          lng: -64.1412109,
		  scrollwheel: false,
		  panControl: false,
		  streetViewControl: false,
		  mapTypeControl: true,
		  mapTypeControlOptions: {
		  	style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
		  	position: google.maps.ControlPosition.TOP_RIGHT
		  }
		});
		
		routePath.forEach(function (e) {
			map.addMarker({
			  lat: e[0], 
			  lng: e[1]
			});
		})


//	})
	</script>

<?php $this->load->view('admin/layout/footer'); ?>