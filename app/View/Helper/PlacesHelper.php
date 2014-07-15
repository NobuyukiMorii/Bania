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
			    		echo "<div class='progress-bar' role='progressbar' aria-valuenow='60' aria-valuemin='0' aria-valuemax=".$value['rest_time_rate_max']." style='width: ".$value['rest_time_rate']."%;'>";
			    		echo "</div>";
		    		echo "</div>";

		    		echo "最大席数：".$value['capacity'];
		    		echo "<div class='progress'>";
			    		echo "<div class='progress-bar' role='progressbar' aria-valuenow=".$value['capacity']." aria-valuemin='0' aria-valuemax=".$value['capacity_max']." style='width: ".$value['capacity_rate']."%;'>";
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

}
