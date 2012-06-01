 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps JavaScript API Example: Map Markers</title>
    <?php
    	if($_GET["lat"]){
    ?>
    <!-- ABQIAAAAzJVB7zJ6btNKOTTq3ToGLBRB4nrBOd15Q9ov68K7sUHf5JKZLxSgSz2decvx4s7tmZdjuhWdsAFyEQ -->
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $_GET["map_api"];?>"
            type="text/javascript"></script>
    <script type="text/javascript">
    function initialize() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(<?php echo $_GET["lat"]; ?>, <?php echo $_GET["lang"]; ?>), 14);

        // Add 10 markers to the map at random locations
        var bounds = map.getBounds();
        var southWest = bounds.getSouthWest();
        var northEast = bounds.getNorthEast();
        var lngSpan = northEast.lng() - southWest.lng();
        var latSpan = northEast.lat() - southWest.lat();
          var point = new GLatLng(southWest.lat() + latSpan * Math.random(),
                                  southWest.lng() + lngSpan * Math.random());
        map.addOverlay(new GMarker(point));
		/*
        for (var i = 0; i < 10; i++) {
          var point = new GLatLng(southWest.lat() + latSpan * Math.random(),
                                  southWest.lng() + lngSpan * Math.random());
          map.addOverlay(new GMarker(point));
        }
		*/
        map.setUIToDefault();
      }
    }
	<?php
		}else{
	?>
    <script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=<?php echo $_GET["map_api"];?>" type="text/javascript"></script>	
    <script type="text/javascript">
	  var geocoder = null;
    function initialize() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map_canvas"));
       // map.setCenter(new GLatLng(37.4419, -122.1419), 14);
	  //  map.setCenter(new GLatLng(13.0649003982544, 80.2546997070313), 14);
        geocoder = new GClientGeocoder();
		//alert(geocoder);
      }
    }
	//alert('test');
	i = 1;
    function showAddress(address) {

      if (geocoder) {
        geocoder.getLatLng(
          address,
          function(point) {
          	//alert(point);
            if (!point) {
              //alert(address + " not found");
				if(i==1){
					//alert("test");
					i = i + 1;
					showAddress( '<?php echo $_GET["area"]; ?>' );
				}else{
					if(i==2){
					i = i + 1;
					showAddress( '<?php echo $_GET["city"]; ?>' );
					}
				}
		
            } else {
              map.setCenter(point, 14);
              var marker = new GMarker(point);
              map.addOverlay(marker);
              //marker.openInfoWindowHtml(address);
            }
          }
        );
      }
    }
	<?php } ?>
    </script>
  </head>
    <?php
    	if($_GET["lat"]){
    ?>
  <body onload="initialize();	" onunload="GUnload()">
  	<?php
		}else{
    ?>
   <body onload="initialize();	 showAddress('<?php echo $_GET["address"]?$_GET["address"]: $_GET["city"]; ?>');" onunload="GUnload()">
  	<?php
		}
	?>
    
    <?php 
	//Increase the width size for living social theme alone
	$current_theme_name =  $_GET["theme_name"];
	if($current_theme_name == "livingsocial_v3.1")
	{
	?>
    	<div id="map_canvas" style="width: 432px; height: 280px;_width: 430px; _height: 230px;"></div>
    <?php } else { ?>
		<div id="map_canvas" style="width: 190px; height: 280px;_width: 430px; _height: 230px;"></div>
    <?php } ?>
    
  </body>
</html>
