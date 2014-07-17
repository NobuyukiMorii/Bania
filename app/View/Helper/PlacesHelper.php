<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class PlacesHelper extends AppHelper {

	//繰り返し処理
	//リストの表示
    public function loop_data($data,$location) {

    	if (is_array($data)) {
	    	//バーのデータを繰り返す
			foreach ($data['shop'] as $key => $value){
				//htmlを表示
				$this->make_shop_html($value,$location);
			}
		}
    }

	//htmlの表示
    public function make_shop_html($value) {

    		//名称
	    	echo "<div class='row'>";
	    		//名称
	    		echo "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";
	    		echo "<h4><".$value['name']."</h4>";
	    		echo "</div>";

	    	echo "</div>";

    		//コンタクト・詳細
	    	echo "<div class='row'>";
	    		//アクセスURL
		    	echo "<div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>";
		    		echo "<a target='_blank' href=".$value['url_pc']."><button type='button' class='btn btn-default btn-block'>URL</button></a><br />";
		    	echo "</div>";
	            //地図への隠しフォーム
	            echo "<div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>";
	           	echo "<form action='/bania/places/map' id='MapForm' method='post' accept-charset='utf-8'>";
	            echo "<input type='hidden' name='latitude' value=".$value['lat_world']. ">";
	            echo "<input type='hidden' name='longitude' value=".$value['lng_world']. ">";
	            echo "<input  class='btn btn-default btn-block' type='submit' value='MAP'>";
	            echo "</form>";
	            echo "</div>";
	    	echo "</div>";

    		//営業時間
	    	echo "<div class='row'>";
	    		//リスト
	    		echo "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";

		    		echo "<ul class='list-inline'>";

		    		//営業時間
		    		echo "<li>";
		    		echo "<i class='glyphicon glyphicon-time'>";
		    		echo "</i>";
		    		echo $value['open']."（".$value['close']."）";
		    		echo "</li>";

	    		echo "</div>";

	    	echo "</div>";

    		//予算・個室
	    	echo "<div class='row'>";
	    		//リスト
	    		echo "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";

		    		echo "<ul class='list-inline'>";
		    		//予算
		    		echo "<li>";
		    		echo "<i class='glyphicon glyphicon-euro'>";
		    		echo "</i>";
		    		echo $value['budget'];
		    		echo "</li>";

		    		//個室
		    		echo "<li>";
		    		echo "<i class='glyphicon glyphicon-user'>";
		    		echo "</i>";
		    		echo "個室".$value['private_room'];
		    		echo "<li>";
		    		echo "</ul>";

	    		echo "</div>";

	    	echo "</div>";
	    	//プログレスバーと写真
	    	echo "<div class='row'>";
		    	//列１バー
		    	echo "<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>";
		    		//お店までの距離
		    		echo "徒歩：".$value['transfer_time'].' ('.$value['transfer_distance'].'m)';
		    		echo "<div class='progress'>";
			    		echo "<div class='progress-bar' role='progressbar' aria-valuenow=".$value['transfer_distance_rate']." aria-valuemin='0' aria-valuemax=".$value['transfer_distance_max_rate']." style='width: 60%;'>";
			    		echo "</div>";
		    		echo "</div>";
		    		//閉店までの時間
		    		echo "閉店まで残り：".$value['rest_time_hour']."時間".$value['rest_time_mini']."分";
		    		echo "<div class='progress'>";
			    		echo "<div class='progress-bar' role='progressbar' aria-valuenow=".$value['rest_time_rate']." aria-valuemin='0' aria-valuemax=".$value['rest_time_rate_max']." style='width: ".$value['rest_time_rate']."%;'>";
			    		echo "</div>";
		    		echo "</div>";

		    		echo "最大席数：".$value['capacity'];
		    		echo "<div class='progress'>";
			    		echo "<div class='progress-bar' role='progressbar' aria-valuenow=".$value['capacity_rate']." aria-valuemin='0' aria-valuemax=".$value['capacity_max']." style='width: ".$value['capacity_rate']."%;'>";
			    		echo "</div>";
		    		echo "</div>";
		    		//予算
		    		echo "平均予算：".$value['budget'];
		    		echo "<div class='progress'>";
			    		echo "<div class='progress-bar' role='progressbar' aria-valuenow=".$value['budget_level']." aria-valuemin='0' aria-valuemax='100' style='width: ".$value['budget_level']."%;'>";
			    		echo "</div>";
		    		echo "</div>";


		    	echo "</div>";
		    	//列２写真
		    	echo "<div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>";
		    		echo "<img src=".$value['url_photo_l2']." style='width:150px;height:150px' class='img-responsive img-circle'>";
		    	echo "</div>";
		    	//列３
		    	echo "<div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>";
		    		echo "<img src=".$value['url_photo_l1']." style='width:150px;height:150px' class='img-responsive img-circle'>";
		    	echo "</div>";
	    	echo "</div>";

	    	echo "<hr>";
    }

    //星を表示する関数
    public function star_levels($value) {

		if ($value >= 0 && $value <= 10) {
		    return "<div class='starlevel5 star05'></div>";
		} elseif ($value > 10 && $value <= 20) {
		    return "<div class='starlevel5 star10'></div>";
		} elseif ($value > 20 && $value <= 30) {
		    return "<div class='starlevel5 star15'></div>";
		} elseif ($value > 30 && $value <= 40) {
		    return "<div class='starlevel5 star20'></div>";
		} elseif ($value > 40 && $value <= 50) {
		    return "<div class='starlevel5 star25'></div>";
		} elseif ($value > 50 && $value <= 60) {
		    return "<div class='starlevel5 star30'></div>";
		} elseif ($value > 60 && $value <= 70) {
		    return "<div class='starlevel5 star35'></div>";
		} elseif ($value > 70 && $value <= 80) {
		    return "<div class='starlevel5 star40'></div>";
		} elseif ($value > 80 && $value <= 90) {
		    return "<div class='starlevel5 star45'></div>";
		} elseif ($value > 90 && $value <= 100) {
		    return "<div class='starlevel5 star50'></div>";
		} else {
			return "<div class='starlevel5 star05'></div>";
		}

    }

    //星(トータルポイント)を表示する関数
    public function star_levels_total($value) {

    	$value['total_point'] = ($value['budget_level']+$value['transfer_distance_rate']+$value['rest_time_rate']+$value['capacity_rate'])/4;    	

		if ($value['total_point'] >= 0 && $value['total_point'] <= 10) {
		    return "<div class='starlevel5 star05'></div>";
		} elseif ($value['total_point'] > 10 && $value['total_point'] <= 20) {
		    return "<div class='starlevel5 star10'></div>";
		} elseif ($value['total_point'] > 20 && $value['total_point'] <= 30) {
		    return "<div class='starlevel5 star15'></div>";
		} elseif ($value['total_point'] > 30 && $value['total_point'] <= 40) {
		    return "<div class='starlevel5 star20'></div>";
		} elseif ($value['total_point'] > 40 && $value['total_point'] <= 50) {
		    return "<div class='starlevel5 star25'></div>";
		} elseif ($value['total_point'] > 50 && $value['total_point'] <= 60) {
		    return "<div class='starlevel5 star30'></div>";
		} elseif ($value['total_point'] > 60 && $value['total_point'] <= 70) {
		    return "<div class='starlevel5 star35'></div>";
		} elseif ($value['total_point'] > 70 && $value['total_point'] <= 80) {
		    return "<div class='starlevel5 star40'></div>";
		} elseif ($value['total_point'] > 80 && $value['total_point'] <= 90) {
		    return "<div class='starlevel5 star45'></div>";
		} elseif ($value['total_point'] > 90 && $value['total_point'] <= 100) {
		    return "<div class='starlevel5 star50'></div>";
		} else {
			return "<div class='starlevel5 star05'></div>";
		}

    }

     //予算を省略表示する
    public function change_price_description($value) {

	    switch ($value) {
	        case "2,000円未満":
	            $value = "~¥2000";
	            break;
	        case "2,000円以上～3,000円未満":
	            $value = "¥2000~¥3000";
	            break;
	        case "3,000円以上～5,000円未満":
	             $value = "¥3000~¥5000";
	            break;
	        case "5,000円以上～7,000円未満":
	             $value = "¥5000~¥7000";
	            break;
	        case "7,000円以上～10,000円未満":
	             $value = "¥7000~¥10000";
	            break;
	        case "10,000円以上":
	             $value = "10000~";
	            break;
	        default;
	            $value = 0;
	            break;
	    }

    return $value;
    }

}
