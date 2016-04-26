  <!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map_canvas { height: 100% }
    </style>
  <body>
    <div id="map_canvas" style="width:100%; height:100%"></div>
    
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDSdgFMoTaquUeNJDfP-dKglPX_OehjSK0&sensor=true"></script>
    <script src="<?php echo base_url('assets/js/gmaps.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
    <script>
    var map = new GMaps({
      div: '#map_canvas',
      lat: 10.4384416,
      lng: -64.1416600,
      scrollwheel: false,
      panControl: false,
      streetViewControl: false,
      mapTypeControl: true,
      mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
        position: google.maps.ControlPosition.TOP_RIGHT
      }
    });
    $.getJSON('/proyecto-ssh/la-llanada.json', function (data) {
      var ruta_recorrida = map.drawPolyline({
        path: data, // pre-defined polygon shape
        strokeColor: 'red',
        strokeOpacity: .75,
        strokeWeight: 2,
        editable: true
      });
    })
</script>
    </body>
</html>

