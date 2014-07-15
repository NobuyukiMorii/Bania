<?php
class LocationComponent extends Component {
	public $components = array('DebugKit.Toolbar');

	//都道府県コードから都道府県コードを得る関数
	public function get_prefecture_code($address) {

		switch ($address['prefecture'] ) {
			case "北海道": 
				$prefcode = "01";
				break;
			case "青森県": 
				$prefcode = "02";
				break;
			case "岩手県": 
				$prefcode = "03";
				break;
			case "宮城県": 
				$prefcode = "04";
				break;
			case "秋田県": 
				$prefcode = "05";
				break;
			case "山形県": 
				$prefcode = "06";
				break;
			case "福島県": 
				$prefcode = "07";
				break;
			case "茨城県": 
				$prefcode = "08";
				break;
			case "栃木県": 
				$prefcode = "09";
				break;
			case "群馬県": 
				$prefcode = "10";
				break;
			case "埼玉県": 
				$prefcode = "11";
				break;
			case "千葉県": 
				$prefcode = "12";
				break;
			case "東京都": 
				$prefcode = "13";
				break;
			case "神奈川県": 
				$prefcode = "14";
				break;
			case "新潟県": 
				$prefcode = "15";
				break;
			case "富山県": 
				$prefcode = "16";
				break;
			case "石川県": 
				$prefcode = "17";
				break;
			case "福井県": 
				$prefcode = "18";
				break;
			case "山梨県": 
				$prefcode = "19";
				break;
			case "長野県": 
				$prefcode = "20";
				break;
			case "岐阜県": 
				$prefcode = "21";
				break;
			case "静岡県": 
				$prefcode = "22";
				break;
			case "愛知県": 
				$prefcode = "23";
				break;
			case "三重県": 
				$prefcode = "24";
				break;
			case "滋賀県": 
				$prefcode = "25";
				break;
			case "京都府": 
				$prefcode = "26";
				break;
			case "大阪府": 
				$prefcode = "27";
				break;
			case "兵庫県": 
				$prefcode = "28";
				break;
			case "奈良県": 
				$prefcode = "29";
				break;
			case "和歌山県": 
				$prefcode = "30";
			case "鳥取県": 
				$prefcode = "31";
				break;
			case "島根県": 
				$prefcode = "32";
				break;
			case "岡山県": 
				$prefcode = "33";
				break;
			case "広島県": 
				$prefcode = "34";
				break;
			case "山口県": 
				$prefcode = "35";
				break;
			case "徳島県": 
				$prefcode = "36";
				break;
			case "香川県": 
				$prefcode = "37";
				break;
			case "愛媛県": 
				$prefcode = "38";
				break;
			case "高知県": 
				$prefcode = "39";
				break;
			case "福岡県": 
				$prefcode = "40";
				break;
			case "佐賀県": 
				$prefcode = "41";
				break;
			case "長崎県": 
				$prefcode = "42";
				break;
			case "熊本県": 
				$prefcode = "43";
				break;
			case "大分県": 
				$prefcode = "44";
				break;
			case "宮崎県": 
				$prefcode = "45";
				break;
			case "鹿児島県": 
				$prefcode = "46";
				break;
			case "沖縄県": 
				$prefcode = "47";
				break;
		}
		return $prefcode;
	}

    //郵便番号から都道府県コードを検索する
    public function get_pref_code($address) {
        //アクセスURL
        $access_url = "http://zipcloud.ibsnet.co.jp/api/search?zipcode=".$address['postal'];
        $json = file_get_contents($access_url);
        //文字化け対策
        $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        //オブジェクト毎にパースする
        $obj = json_decode($json, true);        
        // パースに失敗した時は処理終了
        if ($obj === NULL) {
            return;
        }
        $prefcode = $obj['results'][0]['prefcode'];

        return $prefcode;
    }
}














