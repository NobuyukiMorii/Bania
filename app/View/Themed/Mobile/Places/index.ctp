<!DOCTYPE html> 
<html>
    <head> 
    <meta charset="utf-8">
    <title>sample</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.1.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>

    <script>
    navigator.geolocation.getCurrentPosition(is_success,is_error);

    function is_success(position) {
      var latitude = '';
      var longitude = '';

      latitude = position.coords.latitude;
      longitude = position.coords.longitude;

      // document.getElementById('result').innerHTML = result;

      document.getElementById('latitude').value = latitude;
      document.getElementById('longitude').value = longitude;
      document.forms["location"].submit();
    }

    function is_error(error) {
      var result = "";
      switch(error.code) {
        case 1:
          result = '位置情報の取得が許可されていません';
        break;
        case 2:
          result = '位置情報の取得に失敗しました';
        break;
        case 3:
          result = 'タイムアウトしました';
        break;
      }
      // document.getElementById('result').innerHTML = result;
      document.getElementById('result').value = result;
    }

    </script>

    <style type="text/css">
    img.bg {
      /* Set rules to fill background */
      min-height: 100%;
      min-width: 1024px;
      /* Set up proportionate scaling */
      width: 100%;
      height: auto;
      /* Set up positioning */
      position: fixed;
      /* またはabsolute; */
      top: 0;
      left: 0;
    }

    @media screen and (max-width: 1024px){
      img.bg {
      left: 50%;
      margin-left: -512px; }
    }

    div#container {
      position: relative; 
    }
    </style>

    </head>
    <body>

    <form action='/bania/places/search' id='location' method='get' accept-charset='utf-8'>
      <input type="hidden" id="latitude" name="latitude" />
      <input type="hidden" id="longitude" name="longitude" />
    </form>

<!--///////トップページ///////-->
<div id="container">
<?php echo $this->Html->image('waiting.png', array('alt' => 'Waiting','class' => 'bg')); ?>
</div>
<!--///////トップページ///////-->

    </body>
</html>