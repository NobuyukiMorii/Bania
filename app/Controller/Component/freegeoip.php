<?php
class PlacesComponent extends Component
{
    public $components = array('DebugKit.Toolbar','Session','Common');

    //現在地情報があるかを確認し、ある場合は情報を変数に格納する
    public function check_get_location() {
        //緯度
        $location['latitude'] = $_GET["lati"];
        //経度
        $location['longitude'] = $_GET["long"];
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
        //範囲（メートル指定）
        $range = '500';
        //緯度
        $lat = $location['latitude'];
        //経度
        $lng = $location['longitude'];
        //URL
        $access_url = $base_url.'key='.$key.'&url='.$self_url.'&count='.$count.'&pattern='.$pattern.'&range='.$range.'&lat='.$lat.'&lng='.$lng;

        return $access_url;

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
}






