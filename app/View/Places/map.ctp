<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Bania</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />

    <style type="text/css">
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        }
    </style>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<div id="map" style="height: 100%;"><br /></div>
<script type="text/javascript">

  var From = new google.maps.LatLng(<?php echo $location_now['latitude'] ;?>, <?php echo $location_now['longitude'] ;?>); // 現在地
  var To = new google.maps.LatLng(<?php echo $location_shop['latitude'] ;?>, <?php echo $location_shop['longitude'] ;?>); // 目的地

  var myMap = new google.maps.Map(document.getElementById("map"), {
    mapTypeId: google.maps.MapTypeId.ROADMAP, 
    scrollwheel: false,
    scaleControl: true
  });

  new google.maps.DirectionsService().route({
    origin: From, 
    destination: To,
    travelMode: google.maps.DirectionsTravelMode.WALKING 
  }, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      new google.maps.DirectionsRenderer({map: myMap}).setDirections(result);
    }
  });

</script>

</script>

</head>
<body>

</body>
</html>




