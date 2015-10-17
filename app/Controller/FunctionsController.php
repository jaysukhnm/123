<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AppController', 'Controller');

class FunctionsController extends AppController {

    public $uses = array('AppInfo', 'Coupon', 'Tbluser', 'User', 'MediaCoupon', 'MmvipPageMeta', 'Store', 'StoreSetting', 'Event', 'VipCategory', 'Post');

    public function beforeFilter() {
        parent::beforeFilter();
    }

    /**
     * index method
     * Function for the home page
     * @return void
     */
    public function merge_enduser() {
        $enduser = $this->Tbluser->find('all');
        foreach ($enduser as $u):
            $user['User']['user_group_id'] = '10';
            $user['User']['password'] = $u['Tbluser']['password'];
            $user['User']['salt'] = $u['Tbluser']['salt'];
            $user['User']['email'] = $u['Tbluser']['emailId'];
            $user['User']['first_name'] = $u['Tbluser']['first_name'];
            $user['User']['last_name'] = $u['Tbluser']['last_name'];            
            $user['User']['active'] = $u['Tbluser']['active'] == 'Yes'?'1':'0';
            $user['User']['email_verified'] = '1';
            $user['User']['created'] = $u['Tbluser']['createdDate'];
            $user['User']['modified'] = $u['Tbluser']['modifiedDate'];
            $user['User']['address'] = $u['Tbluser']['address'];
            $user['User']['zip_code'] = $u['Tbluser']['zipcode'];
            $user['User']['city'] = $u['Tbluser']['city'];
            $user['User']['country_id'] = $u['Tbluser']['countryId'];
            $user['User']['telephone1'] = $u['Tbluser']['contact_no'];
            $user['User']['mangopay_userid'] = $u['Tbluser']['mangopay_userid'];
            $user['User']['qrcode_id'] = $u['Tbluser']['qrcode_id'];
            $user['User']['device_token'] = $u['Tbluser']['device_token'];
            $user['User']['device_type'] = $u['Tbluser']['device_type'];
            
            $exist_user = $this->User->findByEmail($u['Tbluser']['emailId']);
            if (empty($exist_user)):
                $this->User->create();
                $this->User->save($user['User']);
           // pr($user['User']);die;
            else:
                $u['Tbluser']['emailId']."<br/>";
            endif;           
        endforeach;
        pr($enduser);die;
        
    }
}