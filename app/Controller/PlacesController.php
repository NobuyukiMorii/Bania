<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class PlacesController extends AppController {

	public $components = array('DebugKit.Toolbar','Session','Common','Places','RequestHandler','Location');
    public $name = 'Places';
    public $uses  = array('Places');
    public $helpers = array('Places');

    public function index() {
		//レイアウトは使わない
		$this->autoLayout = false;
		//ビューは表示する
        $this->autoRender = true;
        //スマートフォン判定
		if($this->RequestHandler->isMobile()) {
    		$this->theme = 'Mobile';
		}

    }

	public function search() {
		//レイアウトは使わない
		$this->autoLayout = false;
		//ビューは表示する
        $this->autoRender = true;
        //スマートフォン判定
		if($this->RequestHandler->isMobile()) {
    		$this->theme = 'Mobile';
		}

        //レクエスとデータがあれば
		if(isset($this->request->data['Place'])) {
			$location = $this->Session->read('location_now');
			$data = $this->Session->read('data');
			$order = $this->request->data['Place']['sort_condition'];
			switch ($order) {
			    case 'distance':
			    	$data = $this->Places->sort_distance_data($data);
			        break;
			    case 'open':
			    	$data = $this->Places->sort_rest_time_data($data);
			        break;
			    case 'capacity':
			    	$data = $this->Places->sort_capacity_data($data);
			        break;
			    case 'budget':
			    	$data = $this->Places->sort_budget_data($data);
			        break;
			    default:
			    	$data = $this->Places->sort_distance_data($data);
			        break;
			}
		}
		//リクエストデータがない場合
		if(empty($this->request->data['Place'])) {
	        $location = $this->Places->check_get_location();
	        //バーナビのURLにアクセス
	        $access_url = $this->Places->make_barnavi_url($location);
	        //周辺のバーのデータを受け取る
	        $data = $this->Places->download_data($access_url);
	        //もし周辺にバーがなかれば、市内のバーを検索する
	        if($data['results_available'] == 0) {
	        	//現在の都道府県、市町村、郵便番号の情報を得る
	        	$address = $this->Places->get_current_city($location);
	        	//都道府県コードを得る
	        	$prefcode = $this->Location->get_prefecture_code($address);
	        	//バーナビに住所からアクセスするURLを作成する
	        	$access_url = $this->Places->make_barnavi_url_city($address,$prefcode);
	        	//データをダウンロードする
	        	$data = $this->Places->download_data($access_url);
	        }
	        //イメージデータがなければ補完する
	        $data = $this->Places->check_image_exist($data);
	        //現在地とお店までの歩行距離・時間を計測する
	        $data = $this->Places->get_transfer_time($data,$location);
	        //閉店時間までの時間を計算する
	        $data = $this->Places->calculate_rest_time($data);
	        //予算レベルを計算する
	        $data = $this->Places->define_budget_level($data);
	        //予算レベルを定義
	        $data = $this->Places->define_capacity_rate($data);
	        //データを歩行距離順に並べ返る
	        $data = $this->Places->sort_distance_data($data);
	    }
        //現在地情報をセッションに保存する
        $this->Session->write('location_now',$location);
        $this->Session->write('data',$data);
        //ビューに変数を渡す
        $this->set(compact('location','data','self_address'));
	}

	public function map() {
		//レイアウトは使わない
		$this->autoLayout = false;
		//ビューは表示する
        $this->autoRender = true;
        //スマートフォン判定
		if($this->RequestHandler->isMobile()) {
    		$a=1;
    		var_dump($a);
    		$this->theme = 'Mobile';
		}
        //セッションから現在地情報を受け取る
        $location_now = $this->Session->read('location_now');
        //お店の緯度と経度を取得する
        $location_shop = $this->request->data;
        //変数を受け渡す
        $this->set(compact('location_now','location_shop'));
		
	}

}
