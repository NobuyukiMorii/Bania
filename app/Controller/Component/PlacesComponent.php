<?php
class PlacesComponent extends Component {
    public $components = array('DebugKit.Toolbar','Session','Common');

    //現在地情報を取得する
    public function check_get_location() {
        //緯度
        $location['latitude'] = $_GET["latitude"];
        //経度
        $location['longitude'] = $_GET["longitude"];

        return $location;
    }

    //バーナビURLを表示する
    public function make_barnavi_url($location) {
        //ベースURLの指定
        $base_url = 'http://webapi.suntory.co.jp/barnavi/v2/shops?';
        //キーの指定
        $key = 'e794e4a2eda1a70af9c71d25e9682779cdc99110ff9076c9f9e97107a08390e4';
        //緯度・経度から取得すると指定
        $pattern = '1';
        //呼び出し元のURL
        $self_url = 'http://mory.weblike.jp/bania/index';
        //最大検索結果件数
        $count = '100';
        //範囲（メートル指定1000m）
        $range = '1000';
        //緯度
        $lat = $location['latitude'];
        //経度
        $lng = $location['longitude'];
        //URL
        $access_url = $base_url.'key='.$key.'&url='.$self_url.'&count='.$count.'&pattern='.$pattern.'&range='.$range.'&lat='.$lat.'&lng='.$lng;

        return $access_url;

    }

    //バーナビURLを表示する
    public function make_barnavi_url_city($address,$prefcode) {
        //ベースURLの指定
        $base_url = 'http://webapi.suntory.co.jp/barnavi/v2/shops?';
        //キーの指定
        $key = 'e794e4a2eda1a70af9c71d25e9682779cdc99110ff9076c9f9e97107a08390e4';
        //緯度・経度から取得すると指定
        $pattern = '0';
        //呼び出し元のURL
        $self_url = 'http://mory.weblike.jp/bania/index';
        //最大検索結果件数
        $count = '100';
        //都道府県
        $pref = $prefcode;
        //市町村指定
        $address = $address['prefecture'].$address['city'];
        //URL
        $access_url = $base_url.'key='.$key.'&url='.$self_url.'&count='.$count.'&pattern='.$pattern.'&pref='.$pref.'&address='.$address;
        return $access_url;
    }

    //現在の市町村を検索する
    public function get_current_city($location) {
        //緯度経度から現在の市町村を読み出す
        $base_url = "http://geoapi.heartrails.com/api/xml?method=searchByGeoLocation&";
        //アクセスURL
        $access_url = "http://geoapi.heartrails.com/api/xml?method=searchByGeoLocation&x=".$location['longitude'].".0&y=".$location['latitude'];
        //データをダウンロードする
        $object = simplexml_load_file($access_url);
        //配列形式で取得
        $arr = get_object_vars($object);
        //残ったSimpleXMLElementオブジェクトをarrayにキャストする（json形式にして、json形式じゃなくす）
        $query = json_decode(json_encode($arr), true);
        //市の情報だけ格納
        $address['postal'] =  $query['location'][0]['postal'];
        $address['prefecture'] =  $query['location'][0]['prefecture'];
        $address['city'] =  $query['location'][0]['city'];
        return $address;
    }

    //データをダウンロードする
    public function download_data($access_url) {
        //SimpleXMLElementObjectを取得
        $object = simplexml_load_file($access_url);
        //配列形式で取得
        $arr = get_object_vars($object);
        //残ったSimpleXMLElementオブジェクトをarrayにキャストする（json形式にして、json形式じゃなくす）
        $data = json_decode(json_encode($arr), true);
        return $data;
    }

    //画像の情報を保管する
    public function check_image_exist($data) {

        foreach ($data['shop'] as $key => $value){

            if($value['url_photo_l1'] == array()) {
                $value['url_photo_l1'] = 'http://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg';
            }
            if($value['url_photo_l2'] == array()) {
                $value['url_photo_l2'] = 'http://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg';
            }
        $data['shop'][$key] = $value;
        }
        return $data;
    }

    //現在地とお店までの歩行時間を計算する
    public function get_transfer_time($data,$location) {

        foreach ($data['shop'] as $key => $value){
            //変数を定義する
            //ベース
            $base_url = 'http://maps.googleapis.com/maps/api/distancematrix/xml?';
            //出発地点
            $origin = $location['latitude'].','.$location['longitude'];
            //到着地点
            $destinations = $value['lat_world'].','.$value['lng_world'];
            //方法
            $mode = 'walk';
            //言語
            $language = 'ja';
            //モバイルかどうか
            $sensor = 'false';
            //アクセスするURLを定義する
            $access_url = $base_url.'origins='.$origin.'&destinations='.$destinations.'&'.$mode.'&language='.$language.'&sensor='.$sensor;
            //xmlデータをロードする
            $xml = simplexml_load_file($access_url);
            //取得出来ているかを確認する
            $code = $xml->status;
            //取得出来ていれば値を取得し、出来ていなければFalseを返す
            if($code == 'OK') {
                //移動時間
                $transfer_time = $xml->row->element->duration->text;
                //移動距離
                $transfer_distance =  $xml->row->element->distance->value;
            } else {
                //移動時間
                $transfer_time = false;
                //移動距離
                $transfer_distance = false;
            }
            //xmlデータを一般の配列にキャスト（一度jsonにして、そのあとjsonを解除する）
            //移動時間
            $transfer_time = json_decode(json_encode($transfer_time), true);
            //移動距離
            $transfer_distance = json_decode(json_encode($transfer_distance), true);
            //配列を変数化する
            //移動時間
            $transfer_time = $transfer_time[0];
            //移動距離
            $transfer_distance = $transfer_distance[0];
            //距離は整数化する
            $transfer_distance = intval($transfer_distance);
            //距離の割合を定義する（最大距離は1000km）
            $transfer_distance_max_rate = 1000;
            if($transfer_distance > $transfer_distance_max_rate) {
                //100kmより大きければ100%
                $transfer_distance_rate = 100;
            } else {
                //100mより小さければ、移動距離 / 最大距離
                $transfer_distance_rate = $transfer_distance / $transfer_distance_max_rate * 100;
            }
            //変数をvalueに格納する
            //移動時間
            $value['transfer_time'] = $transfer_time;
            //移動距離
            $value['transfer_distance'] = intval($transfer_distance);
            //移動距離の割合
            $value['transfer_distance_rate'] = $transfer_distance_rate;
            //最大移動距離
            $value['transfer_distance_max_rate'] = $transfer_distance_max_rate;
            //$dataに格納する
            $data['shop'][$key] = $value;

        }
        
        return $data;
    }

    //データを距離順にソートするOK
    public function sort_distance_data($data) {
        $transfer_distance = array();
        foreach ($data['shop'] as $value) $transfer_distance[] = $value['transfer_distance'];
        array_multisort($transfer_distance, SORT_ASC, SORT_NUMERIC, $data['shop']);
        return $data;
    }

    //データを収容人数順にソートするOK
    public function sort_capacity_data($data) {
        $capacity = array();
        foreach ($data['shop'] as $value) $capacity[] = $value['capacity'];
        array_multisort($capacity, SORT_DESC, SORT_NUMERIC, $data['shop']);
        return $data;
    }
    //データを予算順にソートするOK
    public function sort_budget_data($data) {
        $budget = array();
        foreach ($data['shop'] as $value) $budget[] = $value['budget_level'];
        array_multisort($budget, SORT_ASC, SORT_NUMERIC, $data['shop']);
        return $data;
    }
    //データを閉店時間までの残り時間順にソートするOK
    public function sort_rest_time_data($data) {
        $rest_time = array();
        foreach ($data['shop'] as $value) $rest_time[] = $value['rest_time'];
        array_multisort($rest_time, SORT_DESC, SORT_NUMERIC, $data['shop']);
        return $data;
    }

    //閉店までの残り時間を計算する関数
    public function calculate_rest_time($data) {

        foreach ($data['shop'] as $key => $value) {
            //閉店まで
            //時間のパターン
            $time_pattern_last= '/(?:(2[0-4])|([0-2][0-9])):([0-5][0-9])|(?:(2[0-2])|([0-2][0-9]))：([0-5][0-9])|(?:(1[0-4])|([0-2][0-9])):([0-5][0-9])|(?:(1[0-2])|([0-2][0-9]))/';
            preg_match_all($time_pattern_last, $value['open'] , $match_last);

            //キーが０だけ残す
            $match_yet = $match_last[0];
            unset($match_last);

            for($i=0; $i < count($match_yet); $i++){

                $match_yet[$i] = mb_convert_kana($match_yet[$i], "nk", "utf-8");
                //:と：を取り除く
                $match_yet[$i] = str_replace(":","",$match_yet[$i]);
                $match_yet[$i] = str_replace("：","",$match_yet[$i]);

                //時間にしたものを一度数値にする
                $match_yet[$i] = intval($match_yet[$i]);

                //600以下なら2400を加算する
                if($match_yet[$i] < 600) {
                    $match_yet[$i] = $match_yet[$i] + 2400;
                }

                //最大値を返す
                $max = max($match_yet);

                //2400以上なら2400を減算する
                if($max > 2400) {
                    $max = $max - 2400;
                }

                //もし４文字以下だったら、先頭を０で埋める
                if (mb_strlen($max) <4) {
                    $max = sprintf("%04d", $max);
                }

                //文字列に変換する
                $max = strval($max);

                //２文字目に:を挿入する
                $max = wordwrap($max, 2, ":", true);

                //現在時刻を算出する
                $now = strtotime('now');

                //閉店時間と現在時刻の差を算出する
                //もし閉店時間が６時前だったら、２４時間加算する
                if(strtotime($max) < strtotime("06:00:00")) {
                    $max = strtotime("tomorrow $max");
                } else {
                    $max = strtotime("today $max");
                }
                //閉店時間との差を計算する（秒）
                $rest_mini = $max - $now;


            }

            //もし残り時間の配列が空なら０を代入
            if(empty($rest_mini)) {
                $rest_mini = 0;
            }
            //残り時間の割合：最大(6時間)
            $rest_time_rate_max = 60*60*6;
            //残り時間の割合
            if($rest_mini > $rest_time_rate_max) {
                $rest_time_rate = 100;
            } else {
                $rest_time_rate = $rest_mini / $rest_time_rate_max * 100;
            }
            //各種変数を定義する
            $value['rest_time_rate_max'] = 100;
            $value['rest_time_rate'] = $rest_time_rate;
            $value['rest_time'] = $rest_mini;
            $value['rest_time_hour'] = floor($rest_mini / 3600);
            $value['rest_time_mini'] = floor(($rest_mini - 3600 * $value['rest_time_hour']) / 60);

            $data['shop'][$key] = $value;

        } 
        return $data;
    }

    //予算レベルを定義
    public function define_budget_level($data) {
        foreach ($data['shop'] as $key => $value){
            //平均予算
            switch ($value['budget']) {
                case "2,000円未満":
                    $value['budget_level'] = 10;
                    break;
                case "2,000円以上～3,000円未満":
                    $value['budget_level'] = 25;
                    break;
                case "3,000円以上～5,000円未満":
                     $value['budget_level'] = 40;
                    break;
                case "5,000円以上～7,000円未満":
                     $value['budget_level'] = 60;
                    break;
                case "7,000円以上～10,000円未満":
                     $value['budget_level'] = 80;
                    break;
                case "10,000円以上":
                     $value['budget_level'] = 100;
                    break;
                default;
                    $value['budget_level'] = 0;
                    break;
            }

        if($value['budget'] == Array()) {
            $value['budget'] = "不明";
            $value['budget_level'] = 100;
        }
        $data['shop'][$key] = $value;
        }
    return $data;
    }

    //収容人数を定義
    public function define_capacity_rate($data) {
        foreach ($data['shop'] as $key => $value) {
            //収容人数
            $value['capacity'] = intval($value['capacity']);
            $value['capacity_max'] = 100;
            $value['capacity_rate'] = $value['capacity'] / $value['capacity_max'] * 100;
            //収容人数が100人以上の場合
            if($value['capacity'] > $value['capacity_max']) {
                $value['capacity_rate'] = 100;                
            }
            //収容人数が0と記載の場合
            if($value['capacity'] == 0) {
                $value['capacity'] = '不明';
                $value['capacity_rate'] = 0;
            }
            $data['shop'][$key] = $value; 
        }
        return $data;
    }

}