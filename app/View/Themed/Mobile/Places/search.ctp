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
            echo "<a href=".$value['url_pc'].">";
            echo "<img src=".$value['url_photo_l2']." />";
            echo "<p>".$value['name']."</p>";
            echo "<p>平均予算：".$value['budget']."</p>";
            echo "<p>徒歩：".$value['transfer_time'].' ('.$value['transfer_distance'].'m)</p>';
            echo "<p>閉店まで残り：".$value['rest_time_hour']."時間".$value['rest_time_mini']."分</p>";
            echo "<p>最大席数：".$value['capacity']."</p>";
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