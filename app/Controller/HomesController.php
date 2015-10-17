<?php

App::uses('AppController', 'Controller');

class HomesController extends AppController {

    public $uses = array('AppInfo', 'Coupon', 'MediaCoupon', 'MmvipPageMeta', 'Store', 'StoreSetting', 'Event', 'VipCategory', 'Post');

    public function beforeFilter() {
        parent::beforeFilter();
    }

    /**
     * index method
     * Function for the home page
     * @return void
     */
    public function index() {
        $config = $this->Session->read('Config');
        $conditions = array();
	array_push($conditions, array('Store.payment_status' => 1));
	$location  = '';
	$radious = $latitude = $longitude = 0;
	$user_loacation = $this->Session->read('user_loacation');
//	$latitude = isset($this->request->data['lat']) ? $this->request->data['lat'] : 0;
//        $longitude = isset($this->request->data['lng']) ? $this->request->data['lng'] : 0;
//        $distance = isset($this->request->data['dist']) ? $this->request->data['dist'] : 0;
        $offset = isset($this->request->data['page']) ? $this->request->data['page']*10 : 0;
//        pr($this->request);
         $offset = isset($this->request->query['page']) ? $this->request->query['page']*10 : 0;
	
         //filter
         if(isset($this->request->query['filter_by'])):
             if($this->request->query['filter_by'] == 'category'):
                 array_push($conditions, array('Store.category_id' => $this->request->query['value']));
             endif;
             if($this->request->query['filter_by'] == 'name'):
                 array_push($conditions, array('Store.name LIKE ' => "%".$this->request->query['value']."%"));
             endif;
             if($this->request->query['filter_by'] == 'radious'):
                 array_push($conditions, array('Store.category_id' => $this->request->query['value']));
             endif;
             if($this->request->query['filter_by'] == 'open'):
                 array_push($conditions, array('Store.category_id' => $this->request->query['value']));
             endif;
             if($this->request->query['filter_by'] == 'contest'):
                 array_push($conditions, array('Store.category_id' => $this->request->query['value']));
             endif;
         endif;
         
        if (!empty($user_loacation)):
            $location = $user_loacation['user_loacation'];
            $radious = $user_loacation['radious'];
        endif;

        if (!empty($user_loacation)):
            $latitude = $user_loacation['lat'];
            $longitude = $user_loacation['lng'];
        endif;
        //if ($latitude != '' && $longitude != ''):
        $this->Store->virtualFields = array(
            'distance' => "(((acos(sin(($latitude*pi()/180)) 
						  * sin((Store.latitude*pi()/180))
						  + cos(($latitude*pi()/180)) * cos((Store.latitude*pi()/180))
						  * cos((($longitude - Store.longitude)*pi()/180))))*180/pi())*60*1.1515)",
        );
//	    $order = 'Store.distance ASC';
        $order = 'Store.id DESC';
        //else:
        //   $order = 'Store.name DESC';
        //endif;
        $stores_data = $this->Store->find('all', array('conditions' => array('Store.payment_status' => 1), 'order' => $order, 'limit' => 100, 'offset' => $offset));
//        pr($stores_data);die;
        $data = Set::extract('/Store/.', $stores_data);
        foreach ($data as $k => $d):
            $data[$k]['rating'] = rand(1, 5);
            if ($d['app_id'] == '0' && !empty($d['store_image'])):
                $data[$k]['gallery'] = array($d['store_image'] . Configure::read('google_api_key'));
            else:
                $data[$k]['gallery'] = array('../img/hotel-flight.jpg');
            endif;
            $data[$k]['type_icon'] = array('../img/icons/real-estate/apartment-3.png');
        endforeach;
        $this->set('_serialize', array('data'));
        
        
        if (!empty($user_loacation)):	    
	    $this->Coupon->virtualFields = array(
		    'distance' => "(((acos(sin(($latitude*pi()/180)) 
                                    * sin((Store.lat*pi()/180))
                                    + cos(($latitude*pi()/180)) * cos((Store.lat*pi()/180))
                                    * cos((($longitude - Store.lng)*pi()/180))))*180/pi())*60*1.1515)"
		);
	    $order = 'Coupon.distance ASC';	
	else:
	    $order = 'Coupon.name DESC';	
	endif;
        $this->Coupon->bindModel(array('belongsTo' => array('Store' => array('foreignKey' => 'store_id'))));
        $this->Coupon->bindModel(array('hasMany' => array('MediaCoupon' => array('foreignKey' => 'coupon_id'))));
	$coupons = $this->Coupon->find('all', array('recursive' => 2, 'conditions' => array('Coupon.begin_date <=' => date('Y-m-d'), 'Coupon.end_date >=' => date('Y-m-d')), 'order' => $order, 'limit' => 4));		 
        $this->set(compact('data', 'coupons'));
    }

    public function getAllCategories() {
        $categories = $this->VipCategory->find('all');
        $cat_array = array();
        if (!empty($categories)):
            foreach ($categories as $k => $c):
                $cat = json_decode($c['VipCategory']['name']);
                $cat_array['category'][$k]['id'] = $c['VipCategory']['id'];
                $cat_array['category'][$k]['name'] = $cat->eng;
            endforeach;
        endif;
        echo json_encode($cat_array);
        die;
    }

    public function validateApp($appId) {
        $app_info = $this->AppInfo->find('first', array('recursive' => -1,
            'conditions' => array(
                'AppInfo.app_type' => 3,
                'AppInfo.is_appear_in_app_website' => 1,
                'AppInfo.category_id <>' => '',
                'AppInfo.id' => $appId
            )
        ));
        if (!empty($app_info)):
            return true;
        else:
            return false;
        endif;
    }

    public function stores_locations($lat = null, $lng = null, $address = null, $name = null, $image = null, $catslug = null, $city = null, $slug = null, $category = null, $phone = null, $store_id = null) {
        $news = $coupon = $event = '';
        if ($store_id):
            $this->Post->bindModel(array('belongsTo' => array('VipCategory' => array('foreignKey' => 'category'))));
            $postdata = $this->Post->find('first', array('conditions' => array('Post.store' => $store_id, 'Post.status' => 1, 'Post.publish_date <= NOW()'), 'order' => 'publish_date Desc'));
            if (!empty($postdata)):
                $news = $postdata['VipCategory']['slug'] . '/' . $postdata['Post']['slug'] . "'>" . $postdata['Post']['title'];
            endif;

            $this->Store->BindModel(array('hasMany' => array('StoreSetting' => array(
                        'conditions' => array('StoreSetting.type' => 'coupon', 'StoreSetting.display' => 1, 'StoreSetting.active' => 1)
            ))));
            $this->Coupon->bindModel(array('belongsTo' => array('AppInfo' => array('foreignKey' => 'app_id'))));
            $coupondata = $this->Coupon->find('first', array('conditions' => array('Coupon.store_id' => $store_id, 'Coupon.begin_date <=' => date('Y-m-d'), 'Coupon.end_date >=' => date('Y-m-d'), 'AppInfo.app_type' => 3, 'AppInfo.is_appear_in_app_website' => 1, 'AppInfo.category_id <>' => '', 'Store.payment_status' => 1), 'order' => 'Coupon.id Desc'));
            if (!empty($coupondata)):
                $coupon = $coupondata['Coupon']['slug'] . "'>" . $coupondata['Coupon']['name'];
            endif;

            $this->Store->BindModel(array('hasMany' => array('StoreSetting' => array(
                        'conditions' => array('StoreSetting.type' => 'events', 'StoreSetting.display' => 1, 'StoreSetting.active' => 1)
            ))));
            $this->Event->bindModel(array('belongsTo' => array('AppInfo' => array('foreignKey' => 'app_id'))));
            $events = $this->Event->find('first', array('conditions' => array('Event.store_id' => $store_id, 'Event.status' => '1', 'Event.to_date > CURDATE()', 'AppInfo.app_type' => 3, 'AppInfo.is_appear_in_app_website' => 1, 'AppInfo.category_id <>' => '', 'Store.payment_status' => 1), 'order' => 'Event.id Desc'));
            if (!empty($events)):
                $event = $events['Event']['slug'] . "'>" . $events['Event']['title'];
            endif;
        endif;
        $stores_locations = array(
            'google_map' => array(
                'lat' => $lat,
                'lng' => $lng,
            ),
            'location_address' => $address,
            'location_name' => $name,
            'store_image' => $image,
            'store_category' => $catslug,
            'store_city' => $city,
            'store_slug' => $slug,
            'category' => $category,
            'phone' => $phone,
            'news' => $news,
            'coupon' => $coupon,
            'event' => $event,
        );
        return $stores_locations;
    }

    public function ajax_search() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $user_loacation = $this->Session->read('user_loacation');
            $config = $this->Session->read('Config');
//            $stores = $this->Store->find('all', array(
//                'conditions'=>array('Store.name LIKE' => $this->request->data['search_key'].'%'),              
//                'recursive'=>-1, 
//            ));
            $search_term = $this->request->data['search_key'];
            $this->Store->unBindModel(array('hasMany' => array('StoreSetting', 'MediaStore')));
            $this->Store->bindModel(array('belongsTo' => array('AppInfo' => array('foreignKey' => 'app_id'), 'VipCategory' => array('foreignKey' => 'category_id'))));
            $stores = $this->Store->find('all', array('recursive' => 2, 'conditions' => array(
                    'AND' => array('Store.payment_status' => 1,
                        'OR' => array(
                            'Store.app_id' => 0,
                            'AND' => array(
                                'AppInfo.app_type' => 3,
                                'AppInfo.is_appear_in_app_website' => 1,
                                'AppInfo.category_id <>' => ''
                            ),
                        )
                    ),
                    'OR' => array(
//			'AppInfo.app_name LIKE' => '%' . $search_term . '%',
                        'Store.name LIKE' => '%' . $search_term . '%',
//			'Store.address LIKE' => '%' . $search_term . '%',
//			'Store.address1 LIKE' => '%' . $search_term . '%',
//			'Store.zipcode LIKE' => '%' . $search_term . '%',
                        'Store.city LIKE' => '%' . $search_term . '%'
//			'Store.phone LIKE' => '%' . $search_term . '%'
                    )
                )
            ));
            $data = array();
            $coupons_store_arr = array();
            foreach ($stores as $s):
                $location = '';
                if (!empty($s['Store']['city'])) {
                    $location = ' - ' . $s['Store']['city'];
                }
                if (!empty($user_loacation)):
                    $km = $this->distance($user_loacation['lat'], $user_loacation['lng'], $s['Store']['lat'], $s['Store']['lng'], 'k');
                    if ($km < 1):
                        $location .= ' - ' . number_format($km * 1000, 0) . ' m';
                    else:
                        if ($km > 1 && $km < 10)
                            $location .= ' - ' . number_format($km, 1) . " km";
                        else
                            $location .= ' - ' . number_format($km, 0) . " km";
                    endif;
                endif;
                $key = __('Store');
                if ($s['Store']['app_id'] != 0):
                    $category_1 = $s['AppInfo']['VipCategory'];
                else:
                    $category_1 = $s['VipCategory'];
                endif;
                $category_slug = $category_1['slug'];
                $category_json = json_decode($category_1['name']);
                if (!empty($config['language']) && $config['language'] == "eng"):
                    $category = $category_json->eng;
                elseif (!empty($config['language']) && $config['language'] == "ron"):
                    $category = $category_json->ro;
                else:
                    $category = $category_json->fra;
                endif;

                $city_name = strtolower(Inflector::slug($s['Store']['city'], ' '));
                $data[] = array("id" => 'magasin', 'key' => $key, 'city' => $city_name, 'category' => $category, 'category_slug' => $category_slug, "name" => $s['Store']['name'], 'slug' => $s['Store']['slug'], "location" => $location);
            endforeach;

            $this->Coupon->unBindModel(array('hasMany' => array('MediaCoupon')));
            $this->AppInfo->unBindModel(array('hasMany' => array('Store')));
            $this->Store->unBindModel(array('hasMany' => array('MediaStore')));
            $this->Store->BindModel(array('hasMany' => array('StoreSetting' => array(
                        'conditions' => array('StoreSetting.type' => 'coupon', 'StoreSetting.display' => 1, 'StoreSetting.active' => 1)
            ))));
            $this->Coupon->bindModel(array('belongsTo' => array('AppInfo' => array('foreignKey' => 'app_id'))));
            $coupons = $this->Coupon->find('all', array('recursive' => 2, 'conditions' => array('Coupon.name LIKE' => '%' . $search_term . '%', 'Coupon.begin_date <=' => date('Y-m-d'), 'Coupon.end_date >=' => date('Y-m-d'), 'AppInfo.app_type' => 3, 'AppInfo.is_appear_in_app_website' => 1, 'AppInfo.category_id <>' => '', 'Store.payment_status' => 1)));

            if (!empty($coupons)):
                foreach ($coupons as $c):
                    if (!empty($c['Store']['StoreSetting'])):
                        $key = __('Coupon');
                        $location = '';
                        if (!empty($c['Store']['city'])) {
                            $location = ' - ' . $c['Store']['city'];
                        }
                        if (!empty($user_loacation)):
                            $km = $this->distance($user_loacation['lat'], $user_loacation['lng'], $c['Store']['lat'], $c['Store']['lng'], 'k');
                            if ($km < 1):
                                $location .= ' - ' . number_format($km * 1000, 0) . ' m';
                            else:
                                if ($km > 1 && $km < 10)
                                    $location .= ' - ' . number_format($km, 1) . " km";
                                else
                                    $location .= ' - ' . number_format($km, 0) . " km";
                            endif;
                        endif;

                        $category_json = json_decode($c['AppInfo']['VipCategory']['name']);
                        if (!empty($config['language']) && $config['language'] == "eng"):
                            $category = $category_json->eng;
                        elseif (!empty($config['language']) && $config['language'] == "ron"):
                            $category = $category_json->ro;
                        else:
                            $category = $category_json->fra;
                        endif;
                        $data[] = array("id" => 'coupons', 'key' => $key, 'city' => '', 'category' => $category, 'category_slug' => '', "name" => $c['Coupon']['name'], 'slug' => $c['Coupon']['slug'], "location" => $location);
                    endif;
                endforeach;
            endif;

            $this->AppInfo->unBindModel(array('hasMany' => array('Store')));
            $this->Store->unBindModel(array('hasMany' => array('MediaStore')));
            $this->Store->BindModel(array('hasMany' => array('StoreSetting' => array(
                        'conditions' => array('StoreSetting.type' => 'events', 'StoreSetting.display' => 1, 'StoreSetting.active' => 1)
            ))));
            $this->Event->bindModel(array('belongsTo' => array('AppInfo' => array('foreignKey' => 'app_id'))));
            $events = $this->Event->find('all', array('recursive' => 2, 'conditions' => array('Event.title LIKE' => '%' . $search_term . '%', 'Event.status' => '1', 'Event.to_date > CURDATE()', 'OR' => array('Event.user_id !=' => 0, 'AND' => array('AppInfo.app_type' => 3, 'AppInfo.is_appear_in_app_website' => 1, 'AppInfo.category_id <>' => '', 'Store.payment_status' => 1)))));
            if (!empty($events)):
                foreach ($events as $e):
                    if (!empty($e['Store']['StoreSetting'])):
                        $key = __('Event');
                        $location = '';
                        if (!empty($e['Store']['city'])) {
                            $location = ' - ' . $e['Store']['city'];
                        }
                        if (!empty($user_loacation)):
                            $km = $this->distance($user_loacation['lat'], $user_loacation['lng'], $e['Event']['lat'], $e['Event']['lng'], 'k');
                            if ($km < 1):
                                $location .= ' - ' . number_format($km * 1000, 0) . ' m';
                            else:
                                if ($km > 1 && $km < 10)
                                    $location .= ' - ' . number_format($km, 1) . " km";
                                else
                                    $location .= ' - ' . number_format($km, 0) . " km";
                            endif;
                        endif;

                        if (isset($e['AppInfo']['VipCategory']['name'])):
                            $category_json = json_decode($e['AppInfo']['VipCategory']['name']);
                            if (!empty($config['language']) && $config['language'] == "eng"):
                                $category = $category_json->eng;
                            elseif (!empty($config['language']) && $config['language'] == "ron"):
                                $category = $category_json->ro;
                            else:
                                $category = $category_json->fra;
                            endif;
                        else:
                            $category = __('Partner Associations');
                        endif;
                        $data[] = array("id" => 'events', 'key' => $key, 'city' => '', 'category' => $category, 'category_slug' => '', "name" => $e['Event']['title'], 'slug' => $e['Event']['slug'], "location" => $location);
                    endif;
                endforeach;
            endif;

            $this->Post->bindModel(array('belongsTo' => array('Store' => array('foreignKey' => 'store'), 'VipCategory' => array('foreignKey' => 'category'))));
            $this->Store->unBindModel(array('hasMany' => array('StoreSetting', 'MediaStore')));
            if (!empty($user_loacation)):
                $latitude = $user_loacation['lat'];
                $longitude = $user_loacation['lng'];
                $this->Post->virtualFields = array(
                    'distance' => "(((acos(sin(($latitude*pi()/180)) 
							 * sin((CASE WHEN Post.store != '' THEN Store.lat ELSE Post.lat  END *pi()/180))
							 + cos(($latitude*pi()/180)) * cos((CASE WHEN Post.store != '' THEN Store.lat ELSE Post.lat  END *pi()/180))
							 * cos((($longitude - CASE WHEN Post.store != '' THEN Store.lng ELSE Post.lng  END)*pi()/180))))*180/pi())*60*1.1515)"
                );
            endif;
            $posts = $this->Post->find('all', array('recursive' => 2, 'conditions' => array('Post.title LIKE' => '%' . $search_term . '%', 'Post.status' => 1, 'Post.publish_date <= CURDATE()')));
            if (!empty($posts)):
                foreach ($posts as $p):
                    $key = __('Post');
                    $location = '';
                    if (!empty($p['Store']['city'])) {
                        $location = ' - ' . $p['Store']['city'];
                    }
                    if (!empty($user_loacation)):
                        $km = $p['Post']['distance'] * 1.609344;
                        if ($km < 1):
                            $location .= ' - ' . number_format($km * 1000, 0) . ' m';
                        else:
                            if ($km > 1 && $km < 10)
                                $location .= ' - ' . number_format($km, 1) . " km";
                            else
                                $location .= ' - ' . number_format($km, 0) . " km";
                        endif;
                    endif;
                    $category_slug = $p['VipCategory']['slug'];
                    $category_json = json_decode($p['VipCategory']['name']);
                    if (!empty($config['language']) && $config['language'] == "eng"):
                        $category = $category_json->eng;
                    elseif (!empty($config['language']) && $config['language'] == "ron"):
                        $category = $category_json->ro;
                    else:
                        $category = $category_json->fra;
                    endif;
                    $data[] = array("id" => 'posts', 'key' => $key, 'city' => '', 'category' => $category, 'category_slug' => $category_slug, "name" => $p['Post']['title'], 'slug' => $p['Post']['slug'], "location" => $location);
                endforeach;
            endif;

            return json_encode($data);
        }
        return;
    }

}

?>