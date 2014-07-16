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
      .starlevel5 {
         background-image: url('http://kassiopeia2.net/83make/starlevels.gif'); /*星画像*/
         background-repeat: no-repeat; /* 繰り返しはナシ */
         width: 75px;                  /* 横幅は星５つ分 */
         height: 15px;                 /* 高さは星１つ分 */
      }
      .star50 { background-position: left top; }
      .star40 { background-position: -15px top; }
      .star30 { background-position: -30px top; }
      .star20 { background-position: -45px top; }
      .star10 { background-position: -60px top; }
      .star00 { background-position: -75px top; }

      .star45 { background-position: -150px top; }
      .star35 { background-position: -165px top; }
      .star25 { background-position: -180px top; }
      .star15 { background-position: -195px top; }
      .star05 { background-position: -210px top; }
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
            echo "<a href=".$value['url_pc'].">";
            echo "<div class='ui-grid-solo'>";
            echo "<div class='ui-block-a'>";
            echo "<h6 style='margin : 0px 0px 0px 0px'>".$value['name']."</h6>";
            echo "</div>";
            echo "</div>";
            echo "<div class='ui-grid-a'>";
            echo "<div class='ui-block-a'>";
            echo "<img src=".$value['url_photo_l2']." alt='サンプル' width='150' height='132'/>";
            echo "</div>";

            echo "<div class='ui-block-b'>";
            echo "<p style='margin : 0px 0px 0px 0px'>予算：".$this->Places->change_price_description($value['budget'])."</p>";
            echo $this->Places->star_levels($value['budget_level']);
            echo "<p style='margin : 0px 0px 0px 0px'>徒歩：".$value['transfer_time'].' ('.$value['transfer_distance'].'m)</p>';
            echo $this->Places->star_levels($value['transfer_distance_rate']);
            echo "<p style='margin : 0px 0px 0px 0px'>閉店まで：".$value['rest_time_hour']."時間".$value['rest_time_mini']."分</p>";
            echo $this->Places->star_levels($value['rest_time_rate']);
            echo "<p style='margin : 0px 0px 0px 0px'>席数：".$value['capacity']."席</p>";
            echo $this->Places->star_levels($value['capacity_rate']);      
            echo "</a>";
            echo "</div>";
            echo "</div>";
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