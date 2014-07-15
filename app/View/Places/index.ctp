<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Bania</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
    <?php echo $this->Html->css('bootstrap.css'); ?>
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
    <?php echo $this->Html->css('style_index.css'); ?>

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

	</head>
	<body>

    <form action='/bania/places/search' id='location' method='get' accept-charset='utf-8'>
      <input type="text" id="latitude" name="latitude" />
      <input type="text" id="longitude" name="longitude" />
    </form>

    <table border="0" width="100%" height="100%">
      <tr>
        <td align="center">
          <h2 class="text-center">お店を検索しています</h2>
        </td>
      </tr>
    </table>

	<!-- script references -->
    <?php echo $this->Html->script('jquery-2.1.1.js'); ?>
    <?php echo $this->Html->script('bootstrap.js'); ?>
	</body>
</html>