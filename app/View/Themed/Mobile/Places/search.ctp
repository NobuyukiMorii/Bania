<html>
<head> 
    <meta charset="UTF-8"> 
    <title><?php echo $title_for_layout; ?></title> 
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.css">
    <script src="http://code.jquery.com/jquery-1.8.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
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

.ui-grid-a.ui-block-a{
    width:6em;
}
.ui-grid-a.ui-block-b{
    min-width:12em;
}

    </style>
</head> 
<body> 
<div data-role="page">

<div data-role="header" data-position="inline">
    <h1>Bania</h1>
    <form action='/bania/places/search' id='location' method='get' accept-charset='utf-8'>
      <input type="hidden" id="latitude" name="latitude" />
      <input type="hidden" id="longitude" name="longitude" />
      <input type="submit" data-role="button" data-icon="refresh" data-mini="true" data-iconpos="right" class="ui-btn-right">
    </form>
</div>
    
    <form action="/bania/places/search" role="form" id="PlaceSearchForm" method="post" accept-charset="utf-8">
      <select name="data[Place][sort_condition]" id="PlaceSortCondition" onChange="this.form.submit()">
        <option value="distance">移動距離</option>
        <option value="open">閉店までの時間</option>
        <option value="capacity">収容人数</option>
        <option value="budget">予算</option>
      </select>
    </form>

    <div data-role="content">
        <ul data-role="listview" data-split-icon="arrow-r" data-split-theme="d">
        <?php 
        foreach ($data['shop'] as $key => $value) {
            echo "<li>";
            echo "<a href=".$value['url_mobile'].">";
            echo "<p>".$value['name']."</p>";
            echo "<img src=".$value['url_photo_l2']." />";
            echo "</a>";
            echo "</li>";
        }; ?>
        </ul>

    </div><!-- /content -->
 
    <div data-role="footer">
        <h4>Listed by <a href=<?php echo $this->Html->url(array('controller'=>'Places', 'action'=>'index')); ?>>Mory</a>.</h4>
    </div><!-- /footer -->
 
</div><!-- /page -->
</body>
</html>