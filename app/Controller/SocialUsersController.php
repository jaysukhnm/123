<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'phpqrcode-master', array('file' => 'phpqrcode-master' . DS . 'qrlib.php'));
App::import('Vendor', 'twitteroauth', array('file' => 'twitteroauth' . DS . 'twitteroauth.php'));
App::import('Vendor', 'facebook', array('file' => 'facebook' . DS . 'facebook.php'));
App::import('Vendor', 'PushManager', array('file' => 'PushManager.php'));
App::uses('CakeTime', 'Utility');

class SocialUsersController extends AppController {

    public $uses = array('Suggestion', 'User', 'SuggestionType', 'AppInfo', 'Country', 'Cms', 'tblsubscriptiondetail', 'LevelConfiguration', 'Store', 'Employees', 'Tbluser', 'tblhistories', 'VipCustomers', 'VipCategories', 'Order', 'CatalogProduct', 'ProductOption', 'OrderItem', 'Coupon', 'UserAddress');
    public $components = array('Session', 'RequestHandler');

    //public $helpers = array('Recaptcha.Recaptcha');

    public function beforeFilter() {
        parent::beforeFilter();
        //$this->check_cart_detail();
    }

    public function index() {
        pr('test');
    }

    /**
     * Function to register new user
     */
    public function register() {
        $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }

    public function facebook() {
        $this->layout = 'ajax';
        if ($this->request->is('ajax')):
            $fb_id = $this->request->data['User']['id']; 
            $user_details = $this->tblsubscriptiondetail->find('first', array('conditions' => array('facebookUserId' => $fb_id)));
            if (!empty($user_details)) {
                $user_id = $this->User->find('first', array('conditions' => array('qrcode_id' => $user_details['tblsubscriptiondetail']['qrcode_id'])));
                if (!empty($user_id)):
                    
                    $this->User->id = $user_id['User']['id'];
		    $this->User->facebook_account='Yes';		                      
                    $this->UserAuth->login($user_id);
                    $this->UserAuth->getUser();
                    echo '1';
                else:
                    
                    if(!isset($this->request->data['User']['first_name'])&&empty($this->request->data['User']['first_name'])){
                        $name=  explode(' ',$this->request->data['User']['name']);
                        if(!empty($name)){
                            $this->request->data['User']['first_name']=@$name[0];
                            $this->request->data['User']['last_name']=@$name[1];
                        }else{                            
                            $this->request->data['User']['first_name']=@$name;
                        }
                    }
                    $user_data = $this->User->set(array(                        
                        'first_name' => isset($this->request->data['User']['first_name']) ? $this->request->data['User']['first_name'] : '',
                        'last_name' => isset($this->request->data['User']['last_name']) ? $this->request->data['User']['last_name'] : '',
                        'emailId' => isset($this->request->data['User']['email']) ? $this->request->data['User']['email'] : '',
                        'qrcode_id' => $user_details['tblsubscriptiondetail']['qrcode_id'],
                        'createdDate' => date('Y-m-d H:i:s', time()),
                        'active' => "1",
                        'user_group_id' => "10",
                        'facebook_account' => "Yes",
                        'email_verified' => "1"
                    ));

                    $this->User->save($user_data, $validate = false);
                    $last_i_id = $this->User->id;
                    $user = $this->User->findById($last_i_id);                  
                    $this->UserAuth->login($user);
                    $this->UserAuth->getUser();
                    echo '1';
                endif;
            }
            else {
                $qrcodeId = $this->getQrcode();              
                $facebookUserId = $fb_id;
                $level = 1;
                $active = "Yes";
                //Insert details in the subscription details
                $subscription_data = $this->tblsubscriptiondetail->set(array(
                    'qrcode_id' => $qrcodeId,                    
                    'facebookUserId' => $facebookUserId,
                    'level' => $level,
                    'active' => $active,
                ));

                $this->tblsubscriptiondetail->save($subscription_data);
                //Insert details in Tbluser
                
                 if(!isset($this->request->data['User']['first_name'])&&empty($this->request->data['User']['first_name'])){
                        $name=  explode(' ',$this->request->data['User']['name']);
                        if(!empty($name)){
                            $this->request->data['User']['first_name']=@$name[0];
                            $this->request->data['User']['last_name']=@$name[1];
                        }else{                            
                            $this->request->data['User']['first_name']=@$name;
                        }
                 }
                
                $user_data = $this->User->set(array(
                    'first_name' => isset($this->request->data['User']['first_name']) ? $this->request->data['User']['first_name'] : '',
                    'last_name' => isset($this->request->data['User']['last_name']) ? $this->request->data['User']['last_name'] : '',
                    'emailId' => isset($this->request->data['User']['email']) ? $this->request->data['User']['email'] : '',                  
                    'active' => "1",
                    'user_group_id' => "10",
                    'facebook_account' => "Yes",
                    'email_verified' => "1",
                    'qrcode_id' => $qrcodeId,                    
                    'createdDate' => date('Y-m-d H:i:s', time()),
                    'active' => $active
                ));

                $this->User->save($user_data, $validate = false);
                $last_i_id = $this->User->id;
                $user = $this->User->findById($last_i_id);
                $this->UserAuth->login($user);
                $this->UserAuth->getUser();
                echo '1';
            }
        endif;
        exit;
    }

    /*
     * Twitter Login
     */

    public function twitter() {
        //$acc_tk = $_SESSION['access_token'];
        //if (empty($acc_tk)):
        if (isset($this->request->named['coupon']) && !empty($this->request->named['coupon'])):
            $this->Session->write('coupon', $this->request->named['coupon']);
        endif;
        if (isset($this->request->named['s_id']) && !empty($this->request->named['s_id'])):
            $this->Session->write('store', $this->request->named['s_id']);
        endif;
        if (isset($this->request->named['store']) && !empty($this->request->named['store'])):
            $this->Session->write('loyal_store', $this->request->named['store']);
        endif;
        /* Build TwitterOAuth object with client credentials. */
        $connection = new TwitterOAuth(Configure::read('tw_settings.tw_consumer_key'), Configure::read('tw_settings.consumer_secret'));

        /* Get temporary credentials. */
        $request_token = $connection->getRequestToken(FULL_BASE_URL . '/social_users/twitter_callback');
        /* Save temporary credentials to session. */
        $this->Session->write('oauth_token', $request_token['oauth_token']);
        $token = $request_token['oauth_token'];
        $this->Session->write('oauth_token_secret', $request_token['oauth_token_secret']);
        //$this->Session->write('language', $this->request->params['lang']);
        $url = $connection->getAuthorizeURL($token);
        $this->redirect($url);
        //endif;
        //exit;
    }

    public function twitter_callback() {

        $outh_token = $this->Session->read('oauth_token');
        $outh_token_secret = $this->Session->read('oauth_token_secret');
//        $coupon_return = $this->Session->read('coupon');
//        $store_return = $this->Session->read('store');
//        $loyal_store_return = $this->Session->read('loyal_store');

        //$language = $this->Session->read('language');
        if (isset($_REQUEST['oauth_token']) && $outh_token !== $_REQUEST['oauth_token']) {
            $this->Session->write('oauth_status', 'oldtoken');
        }

        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
        $connection1 = new TwitterOAuth(Configure::read('tw_settings.tw_consumer_key'), Configure::read('tw_settings.consumer_secret'), $outh_token, $outh_token_secret);

        /* Request access tokens from twitter */
        if (isset($_REQUEST['oauth_verifier'])) {
            $access_token = $connection1->getAccessToken($_REQUEST['oauth_verifier']);

            $connection = new TwitterOAuth(Configure::read('tw_settings.tw_consumer_key'), Configure::read('tw_settings.consumer_secret'), $access_token['oauth_token'], $access_token['oauth_token_secret']);
            $response = (array) $connection->get('account/verify_credentials');

            if (isset($response['errors'])) {
                $this->Session->setFlash($response['errors'][0]->message, 'custom_flash_message', array('class' => 'alert alert-success'));
                $this->redirect('/users/login');
            }
            /* Save the access tokens. Normally these would be saved in a database for future use. */
            $this->Session->write('access_token', $access_token);
            $this->Session->write('Twitter_response', $response);

            /* Remove no longer needed request tokens */
            unset($_SESSION['oauth_token']);
            unset($_SESSION['oauth_token_secret']);
            /* If HTTP response is 200 continue otherwise send to connect page to retry */
            if ($connection->http_code == 200) {
                /* The user has been verified and the access tokens can be saved for future use */
                $this->Session->write('status', 'verified');
                $twitter_user_id = $this->Session->read('access_token.user_id');
                $twitter_oauth_token = $this->Session->read('access_token.oauth_token');
                $twitter_oauth_token_secret = $this->Session->read('access_token.oauth_token_secret');

                $user_details = $this->tblsubscriptiondetail->find('first', array('conditions' => array('twitterUserId' => $twitter_user_id)));

                if (!empty($user_details)) {
                    //$tbluser_id = $this->Tbluser->find('first', array('conditions' => array('AND' => array('qrcode_id' => $user_details['tblsubscriptiondetail']['qrcode_id'], 'app_id' => $user_details['tblsubscriptiondetail']['app_id']))));
                    $tbluser_id = $this->Tbluser->find('first', array('conditions' => array('qrcode_id' => $user_details['tblsubscriptiondetail']['qrcode_id'])));
                    if (!empty($tbluser_id)) {
                        $this->Tbluser->id = $tbluser_id['Tbluser']['userId'];
                        $this->Tbluser->saveField('twitter_link', 'Yes');
                        if (!empty($tbluser_id['Tbluser']['emailId'])):
                            $uname = $tbluser_id['Tbluser']['emailId'];
                        else:
                            $uname = $tbluser_id['Tbluser']['first_name'];
                        endif;
                        $this->Session->write('Username', $uname);
                        $user_ses = $this->Session->read('User');

                        if (empty($user_ses)) {
                            $this->Session->write('User', $tbluser_id['Tbluser']);
                        } else {
                            $this->Session->delete('User');
                            $this->Session->write('User', $tbluser_id['Tbluser']);
                        }
                        $data = $this->Session->read('cart');
                        $order_data = $this->Session->read('cart_order');
                        $slug = $this->Session->read('slug');
                        if (count($data) > 0):
                            $this->redirect(array('controller' => 'deliveries', 'action' => 'view', $slug));
                        elseif (count($order_data) > 0):
                            $this->redirect(array('controller' => 'online_orders', 'action' => 'view', $slug));
                        elseif (!empty($coupon_return)):
                            $this->redirect(array('controller' => 'coupons', 'action' => 'view', $coupon_return));
                        elseif (!empty($store_return)):
                            $this->redirect(array('controller' => 'favorites', 'action' => 'add', $store_return));
                        elseif (!empty($loyal_store_return)):
                            $this->redirect(array('controller' => 'stores', 'action' => 'confirm', $loyal_store_return));
                        else:
                            return $this->redirect(array('controller' => 'homes', 'action' => 'index'));
                        endif;
                        //return $this->redirect('/' . $language . '/homes/index/' . $tbluser_id['Tbluser']['userId'] . '/' . $this->Session->id());
                    }
                } else {
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $randomString = '';
                    for ($i = 0; $i < 10; $i++) {
                        $randomString .= $characters[rand(0, strlen($characters) - 1)];
                    }
                    $qrcodeId = $randomString;
                    $app_id = 0;
                    $twitterUserId = $twitter_user_id;
                    $level = 1;
                    $active = "Yes";

                    //Insert details in the subscription details
                    $subscription_data = $this->tblsubscriptiondetail->set(array(
                        'qrcode_id' => $qrcodeId,
                        'app_id' => $app_id,
                        'twitterUserId' => $twitterUserId,
                        'level' => $level,
                        'active' => $active,
                    ));
                    $this->tblsubscriptiondetail->save($subscription_data);

                    //Insert details in Tbluser
                    $tbluser_data = $this->Tbluser->set(array(
                        'first_name' => $this->Session->read('Twitter_response.name'),
                        'last_name' => '',
                        'gender' => '',
                        'facebook_link' => "No",
                        'twitter_link' => "Yes",
                        'app_id' => 0,
                        'qrcode_id' => $qrcodeId,
                        'isEmployee' => "No",
                        'active' => $active
                    ));
                    $data = $this->Tbluser->save($tbluser_data, $validates = false);
                    if ($data):
                        $last_i_id = $this->Tbluser->id;
                        $user = $this->Tbluser->find('first', array('conditions' => array('Tbluser.userId' => $last_i_id)));

                        $this->Session->write('Username', $user['Tbluser']['first_name']);
                        $this->Session->delete('User');
                        $this->Session->write('User', $user['Tbluser']);
                        $this->Session->setFlash(__('Login Successfully.'), 'custom_flash_message', array('class' => 'alert-success'));
                        //$this->redirect('/' . $language . '/Homes/index/' . $last_i_id);			
                        $data = $this->Session->read('cart');
                        $order_data = $this->Session->read('cart_order');
                        $slug = $this->Session->read('slug');
                        if (count($data) > 0):
                            $this->redirect(array('controller' => 'deliveries', 'action' => 'view', $slug));
                        elseif (count($order_data) > 0):
                            $this->redirect(array('controller' => 'online_orders', 'action' => 'view', $slug));
                        elseif (!empty($coupon_return)):
                            $this->redirect(array('controller' => 'coupons', 'action' => 'view', $coupon_return));
                        elseif (!empty($store_return)):
                            $this->redirect(array('controller' => 'favorites', 'action' => 'add', $store_return));
                        elseif (!empty($loyal_store_return)):
                            $this->redirect(array('controller' => 'stores', 'action' => 'confirm', $loyal_store_return));
                        else:
                            return $this->redirect(array('controller' => 'homes', 'action' => 'index'));
                        endif;

                    endif;
                }
            }
        } else {
            $this->redirect('/users/login/');
        }
    }

    public function getQrcode() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function mangopay_returns_online_order($slug, $cardRegisterId, $amount) {
        $store_id = $this->Session->read('store_id');
        $amount = $amount * 100;
        $store = $this->Store->findById($store_id);
        if (empty($store['Store']['mangopay_userid']) && empty($store['Store']['mangopay_walletid']) && empty($store['Store']['mangopay_bankaccount_id'])):
            $this->Session->setFlash('You can not place order.Please contact to Administrator.', 'custom_flash_message', array('class' => 'alert-danger'));
            $this->redirect(array('controller' => 'users', 'action' => 'purchases'));
        else:
            App::import('Vendor', 'MangoPay', array('file' => 'mangopay2-php-sdk-master' . DS . 'MangoPaySDK' . DS . 'mangoPayApi.inc'));

            $mangoPayApi = new \MangoPay\MangoPayApi();
            $mangoPayApi->Config->ClientId = Configure::read('ClientId'); //'http5000';
            $mangoPayApi->Config->ClientPassword = Configure::read('ClientPassword'); //'6dmfzNeEBGdT5sGoY1RhpjjvuAi2fRWOzYu5F0yMXTKyXosr5Z';
            $mangoPayApi->Config->TemporaryFolder = __dir__;

            try {
                // update register card with registration data from Payline service
                $cardRegister = $mangoPayApi->CardRegistrations->Get($cardRegisterId);

                $cardRegister->RegistrationData = isset($_GET['data']) ? 'data=' . $_GET['data'] : 'errorCode=' . $_GET['errorCode'];

                $updatedCardRegister = $mangoPayApi->CardRegistrations->Update($cardRegister);

                if ($updatedCardRegister->Status != 'VALIDATED' || !isset($updatedCardRegister->CardId)):
                    $this->Session->setFlash(__('Something goes wrong,Payment has not been created.Please check card Details.'), 'custom_flash_message', array('class' => 'alert-danger'));
                    $this->redirect(array('controller' => 'online_orders', 'action' => 'choose_hour', $slug));
                endif;

                // get created virtual card object
                $card = $mangoPayApi->Cards->Get($updatedCardRegister->CardId);

                // create temporary wallet for user
                $wallet = new \MangoPay\Wallet();
                $wallet->Owners = array($updatedCardRegister->UserId);
                $wallet->Currency = 'EUR';
                $wallet->Description = 'Wallet for User';
                $createdWallet = $mangoPayApi->Wallets->Create($wallet);

                // create pay-in using CARD 
                $payIn = new \MangoPay\PayIn();
                //$payIn->CreditedWalletId = $createdWallet->Id;
                //$payIn->AuthorId = $updatedCardRegister->UserId;

                $payIn->CreditedWalletId = $store['Store']['mangopay_walletid'];
                $payIn->CreditedUserId = $store['Store']['mangopay_userid'];
                $payIn->AuthorId = $updatedCardRegister->UserId;

                $payIn->DebitedFunds = new \MangoPay\Money();
                $payIn->DebitedFunds->Amount = $amount;
                $payIn->DebitedFunds->Currency = 'EUR';

                $payIn->Fees = new \MangoPay\Money();

                $payIn->Fees->Amount = $this->getComission($amount);
                $payIn->Fees->Currency = 'EUR';
                //$payIn->SecureMode = 'FORCE';
                // payment type as CARD
                $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
                if ($card->CardType == 'CB' || $card->CardType == 'VISA' || $card->CardType == 'MASTERCARD')
                    $payIn->PaymentDetails->CardType = 'CB_VISA_MASTERCARD';
                elseif ($card->CardType == 'AMEX')
                    $payIn->PaymentDetails->CardType = 'AMEX';


                // execution type as DIRECT
                $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
                $payIn->ExecutionDetails->CardId = $card->Id;
                $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';

                // create Pay-In
                $createdPayIn = $mangoPayApi->PayIns->Create($payIn);

                // if created Pay-in object has status SUCCEEDED it's mean that all is fine
                if ($createdPayIn->Status == 'SUCCEEDED') {

                    //Transfer amount to bank

                    /* $PayOut = new \MangoPay\PayOut();
                      $PayOut->AuthorId = $store['Store']['mangopay_userid'];
                      $PayOut->DebitedWalletID = $store['Store']['mangopay_walletid'];
                      $PayOut->DebitedFunds = new \MangoPay\Money();
                      $PayOut->DebitedFunds->Currency = "EUR";
                      $PayOut->DebitedFunds->Amount = $amount;
                      $PayOut->Fees = new \MangoPay\Money();
                      $PayOut->Fees->Currency = "EUR";
                      $PayOut->Fees->Amount = 0;
                      $PayOut->PaymentType = "BANK_WIRE";
                      $PayOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
                      $PayOut->MeanOfPaymentDetails->BankAccountId = $store['Store']['mangopay_bankaccount_id'];
                     */
                    //Send the request
//		    $result = $mangoPayApi->PayOuts->Create($PayOut);
//		    if ($result->Status == 'SUCCEEDED'):
                    //if (!empty($createdPayIn->Id) && !empty($store['Store']['mangopay_walletid']) && !empty($result->Id)):
                    if (!empty($createdPayIn->Id)):
                        //$order = $this->place_order($createdPayIn->Id, $store['Store']['mangopay_walletid'], $result->Id);
                        $order = $this->place_order($createdPayIn->Id, $store['Store']['mangopay_walletid']);
                        //$this->Session->setFlash(__('Order placed successfully.') . '<br>Pay-In Id =' . $createdPayIn->Id . '<br> Wallet Id =' . $store['Store']['mangopay_walletid'], 'custom_flash_message', array('class' => 'alert-success'));
                        $this->Session->setFlash(__('Order placed successfully.'), 'custom_flash_message', array('class' => 'alert-success'));
                        $this->redirect(array('controller' => 'users', 'action' => 'purchases'));
                    else:
                        $this->Session->setFlash(__('Something goes wrong,Order not placed successfully'), 'custom_flash_message', array('class' => 'alert-danger'));
                        $this->redirect(array('controller' => 'online_orders', 'action' => 'choose_hour', $slug));
                    endif;
//		    else:
//			$this->Session->setFlash(__('Something goes wrong,Order not placed successfully') . '<br> result code:' . $result->Status . ' (result: ' . $result->ResultCode . ') <br>' . ' (Error Message: ' . $result->ResultMessage . ')', 'custom_flash_message', array('class' => 'alert-danger'));
//		    //$this->redirect(array('controller' => 'users', 'action' => 'purchases'));
//		    endif;
                } else {
                    // if created Pay-in object has status different than SUCCEEDED 
                    // that occurred error and display error message
                    $this->Session->setFlash(__('Something goes wrong,Order not placed successfully') . ', Error Message: ' . $createdPayIn->ResultMessage . ')', 'custom_flash_message', array('class' => 'alert-danger'));
                    $this->redirect(array('controller' => 'online_orders', 'action' => 'choose_hour', $slug));
                }
            } catch (\MangoPay\ResponseException $e) {
                //$this->Session->setFlash(__('Something goes wrong,Order not placed successfully') . 'Code:' . $e->getCode() . '<br>Message: ' . $e->getMessage() . '<br>' . $e->GetErrorDetails(), 'custom_flash_message', array('class' => 'alert-danger'));
                $this->Session->setFlash(__('Something goes wrong,Order not placed successfully'), 'custom_flash_message', array('class' => 'alert-danger'));
                $this->redirect(array('controller' => 'online_orders', 'action' => 'choose_hour', $slug));
            }
        endif;
    }

    public function mangopay_returns_deliveries($slug, $cardRegisterId, $amount) {
        $store_id = $this->Session->read('delivery_store_id');
        $store = $this->Store->findById($store_id);
        $amount = $amount * 100;
        if (empty($store['Store']['mangopay_userid']) && empty($store['Store']['mangopay_walletid'])):
            $this->Session->setFlash('You can not place order.Please contact to Administrator.', 'custom_flash_message', array('class' => 'alert-danger'));
            $this->redirect(array('controller' => 'users', 'action' => 'purchases'));
        else:
            App::import('Vendor', 'MangoPay', array('file' => 'mangopay2-php-sdk-master' . DS . 'MangoPaySDK' . DS . 'mangoPayApi.inc'));

            $mangoPayApi = new \MangoPay\MangoPayApi();
            $mangoPayApi->Config->ClientId = Configure::read('ClientId'); //'http5000';
            $mangoPayApi->Config->ClientPassword = Configure::read('ClientPassword'); //'6dmfzNeEBGdT5sGoY1RhpjjvuAi2fRWOzYu5F0yMXTKyXosr5Z';
            $mangoPayApi->Config->TemporaryFolder = __dir__;

            try {
                // update register card with registration data from Payline service
                $cardRegister = $mangoPayApi->CardRegistrations->Get($cardRegisterId);

                $cardRegister->RegistrationData = isset($_GET['data']) ? 'data=' . $_GET['data'] : 'errorCode=' . $_GET['errorCode'];

                $updatedCardRegister = $mangoPayApi->CardRegistrations->Update($cardRegister);

                if ($updatedCardRegister->Status != 'VALIDATED' || !isset($updatedCardRegister->CardId)):
                    $this->Session->setFlash(__('Something goes wrong,Payment has not been created.Please check card Details.'), 'custom_flash_message', array('class' => 'alert-danger'));
                    $this->redirect(array('controller' => 'deliveries', 'action' => 'choose_hour', $slug));
                endif;

                // get created virtual card object
                $card = $mangoPayApi->Cards->Get($updatedCardRegister->CardId);

                // create temporary wallet for user
                $wallet = new \MangoPay\Wallet();
                $wallet->Owners = array($updatedCardRegister->UserId);
                $wallet->Currency = 'EUR';
                $wallet->Description = 'wallet for payment';
                $createdWallet = $mangoPayApi->Wallets->Create($wallet);

                // create pay-in using card
                $payIn = new \MangoPay\PayIn();
                $payIn->CreditedWalletId = $store['Store']['mangopay_walletid'];
                $payIn->CreditedUserId = $store['Store']['mangopay_userid'];
                $payIn->AuthorId = $updatedCardRegister->UserId;

                $payIn->DebitedFunds = new \MangoPay\Money();
                $payIn->DebitedFunds->Amount = $amount;
                $payIn->DebitedFunds->Currency = 'EUR';
                $payIn->Fees = new \MangoPay\Money();
                $payIn->Fees->Amount = $this->getComission($amount);
                $payIn->Fees->Currency = 'EUR';
                //$payIn->SecureMode = 'FORCE';
                // payment type as CARD
                $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
                if ($card->CardType == 'CB' || $card->CardType == 'VISA' || $card->CardType == 'MASTERCARD')
                    $payIn->PaymentDetails->CardType = 'CB_VISA_MASTERCARD';
                elseif ($card->CardType == 'AMEX')
                    $payIn->PaymentDetails->CardType = 'AMEX';

                // execution type as DIRECT
                $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
                $payIn->ExecutionDetails->CardId = $card->Id;
                $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';

                // create Pay-In
                $createdPayIn = $mangoPayApi->PayIns->Create($payIn);

                // if created Pay-in object has status SUCCEEDED it's mean that all is fine
                if ($createdPayIn->Status == 'SUCCEEDED') {
                    //Transfer amount to bank
                    /*  $PayOut = new \MangoPay\PayOut();
                      $PayOut->AuthorId = $store['Store']['mangopay_userid'];
                      $PayOut->DebitedWalletID = $store['Store']['mangopay_walletid'];
                      $PayOut->DebitedFunds = new \MangoPay\Money();
                      $PayOut->DebitedFunds->Currency = "EUR";
                      $PayOut->DebitedFunds->Amount = $amount;
                      $PayOut->Fees = new \MangoPay\Money();
                      $PayOut->Fees->Currency = "EUR";
                      $PayOut->Fees->Amount = 0;
                      $PayOut->PaymentType = "BANK_WIRE";
                      $PayOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
                      $PayOut->MeanOfPaymentDetails->BankAccountId = $store['Store']['mangopay_bankaccount_id'];

                      //Send the request
                      $result = $mangoPayApi->PayOuts->Create($PayOut);
                      if ($result->Status == 'SUCCEEDED'): */
                    //if (!empty($createdPayIn->Id) && !empty($store['Store']['mangopay_walletid']) && !empty($result->Id)):
                    if (!empty($createdPayIn->Id)):
                        $order = $this->place_delivery($createdPayIn->Id, $store['Store']['mangopay_walletid']);
                        //$this->Session->setFlash(__('Order placed successfully.') . '<br>Pay-In Id =' . $createdPayIn->Id . '<br> Wallet Id =' . $store['Store']['mangopay_walletid'], 'custom_flash_message', array('class' => 'alert-success'));
                        $this->Session->setFlash(__('Order placed successfully.'), 'custom_flash_message', array('class' => 'alert-success'));
                        $this->redirect(array('controller' => 'users', 'action' => 'purchases'));
                    else:
                        $this->Session->setFlash(__('Something goes wrong,Order not placed successfully'), 'custom_flash_message', array('class' => 'alert-danger'));
                        $this->redirect(array('controller' => 'deliveries', 'action' => 'choose_hour', $slug));
                    endif;
//		    else:
//			$this->Session->setFlash(__('Something goes wrong,Order not placed successfully') . '<br> result code:' . $result->Status . ' (result: ' . $result->ResultCode . ') <br>' . ' (Error Message: ' . $result->ResultMessage . ')', 'custom_flash_message', array('class' => 'alert-danger'));
//			$this->redirect(array('controller' => 'users', 'action' => 'purchases'));
//		    endif;		    
                } else {
                    // if created Pay-in object has status different than SUCCEEDED 
                    // that occurred error and display error message				
                    $this->Session->setFlash(__('Something goes wrong,Order not placed successfully') . ' <br> Error Message: ' . $createdPayIn->ResultMessage . ')', 'custom_flash_message', array('class' => 'alert-danger'));
                    $this->redirect(array('controller' => 'deliveries', 'action' => 'choose_hour', $slug));
                }
            } catch (\MangoPay\ResponseException $e) {
                $this->Session->setFlash(__('Something goes wrong,Order not placed successfully Code:'), 'custom_flash_message', array('class' => 'alert-danger'));
                $this->redirect(array('controller' => 'deliveries', 'action' => 'choose_hour', $slug));
            }
        endif;
    }

    public function mangopay_returns_coupons($slug, $cardRegisterId, $amount) {
        $orderdata = explode('|', $this->Session->read('custom_coupons_data'));
        $store_id = $orderdata[2];
        $store = $this->Store->findById($store_id);
        $amount = $amount * 100;
        if (empty($store['Store']['mangopay_userid']) && empty($store['Store']['mangopay_walletid'])):
            $this->Session->setFlash('You can not purchase coupons.Please contact to Administrator.', 'custom_flash_message', array('class' => 'alert-danger'));
            $this->redirect(array('controller' => 'users', 'action' => 'purchases'));
        else:
            App::import('Vendor', 'MangoPay', array('file' => 'mangopay2-php-sdk-master' . DS . 'MangoPaySDK' . DS . 'mangoPayApi.inc'));

            $mangoPayApi = new \MangoPay\MangoPayApi();
            $mangoPayApi->Config->ClientId = Configure::read('ClientId'); //'http5000';
            $mangoPayApi->Config->ClientPassword = Configure::read('ClientPassword'); //'6dmfzNeEBGdT5sGoY1RhpjjvuAi2fRWOzYu5F0yMXTKyXosr5Z';
            $mangoPayApi->Config->TemporaryFolder = __dir__;

            try {
                // update register card with registration data from Payline service
                $cardRegister = $mangoPayApi->CardRegistrations->Get($cardRegisterId);

                $cardRegister->RegistrationData = isset($_GET['data']) ? 'data=' . $_GET['data'] : 'errorCode=' . $_GET['errorCode'];

                $updatedCardRegister = $mangoPayApi->CardRegistrations->Update($cardRegister);

                if ($updatedCardRegister->Status != 'VALIDATED' || !isset($updatedCardRegister->CardId)):
                    $this->Session->setFlash(__('Something goes wrong,Payment has not been created.Please check card Details.'), 'custom_flash_message', array('class' => 'alert-danger'));
                    $this->redirect(array('controller' => 'coupons', 'action' => 'view', $slug));
                endif;

                // get created virtual card object
                $card = $mangoPayApi->Cards->Get($updatedCardRegister->CardId);

                // create temporary wallet for user
                $wallet = new \MangoPay\Wallet();
                $wallet->Owners = array($updatedCardRegister->UserId);
                $wallet->Currency = 'EUR';
                $wallet->Description = 'wallet for payment';
                $createdWallet = $mangoPayApi->Wallets->Create($wallet);

                // create pay-in using card
                $payIn = new \MangoPay\PayIn();
                $payIn->CreditedWalletId = $store['Store']['mangopay_walletid'];
                $payIn->CreditedUserId = $store['Store']['mangopay_userid'];
                $payIn->AuthorId = $updatedCardRegister->UserId;

                $payIn->DebitedFunds = new \MangoPay\Money();
                $payIn->DebitedFunds->Amount = $amount;

                $payIn->DebitedFunds->Currency = 'EUR';
                $payIn->Fees = new \MangoPay\Money();
                $payIn->Fees->Amount = $this->getComission($amount);
                $payIn->Fees->Currency = 'EUR';
                //$payIn->SecureMode = 'FORCE';
                // payment type as CARD
                $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
                if ($card->CardType == 'CB' || $card->CardType == 'VISA' || $card->CardType == 'MASTERCARD')
                    $payIn->PaymentDetails->CardType = 'CB_VISA_MASTERCARD';
                elseif ($card->CardType == 'AMEX')
                    $payIn->PaymentDetails->CardType = 'AMEX';

                // execution type as DIRECT
                $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
                $payIn->ExecutionDetails->CardId = $card->Id;
                $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';

                // create Pay-In
                $createdPayIn = $mangoPayApi->PayIns->Create($payIn);

                // if created Pay-in object has status SUCCEEDED it's mean that all is fine
                if ($createdPayIn->Status == 'SUCCEEDED') {
                    /* $PayOut = new \MangoPay\PayOut();
                      $PayOut->AuthorId = $store['Store']['mangopay_userid'];
                      $PayOut->DebitedWalletID = $store['Store']['mangopay_walletid'];
                      $PayOut->DebitedFunds = new \MangoPay\Money();
                      $PayOut->DebitedFunds->Currency = "EUR";
                      $PayOut->DebitedFunds->Amount = $amount;
                      $PayOut->Fees = new \MangoPay\Money();
                      $PayOut->Fees->Currency = "EUR";
                      $PayOut->Fees->Amount = 0;
                      $PayOut->PaymentType = "BANK_WIRE";
                      $PayOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
                      $PayOut->MeanOfPaymentDetails->BankAccountId = $store['Store']['mangopay_bankaccount_id'];

                      //Send the request
                      $result = $mangoPayApi->PayOuts->Create($PayOut);
                      if ($result->Status == 'SUCCEEDED'): */
                    //if (!empty($createdPayIn->Id) && !empty($store['Store']['mangopay_walletid']) && !empty($result->Id)):
                    if (!empty($createdPayIn->Id)):
                        $order = $this->purchase_coupon($createdPayIn->Id, $store['Store']['mangopay_walletid']);
                        $this->Session->setFlash(__('Coupon purchase successfully.'), 'custom_flash_message', array('class' => 'alert-success'));
                        $this->redirect(array('controller' => 'users', 'action' => 'purchases'));
                    else:
                        $this->Session->setFlash(__('Something goes wrong,Order not placed successfully'), 'custom_flash_message', array('class' => 'alert-danger'));
                        $this->redirect(array('controller' => 'coupons', 'action' => 'view', $slug));
                    endif;
//		    else:
//			$this->Session->setFlash(__('Something goes wrong,Order not placed successfully') . '<br> result code:' . $result->Status . ' (result: ' . $result->ResultCode . ') <br>' . ' (Error Message: ' . $result->ResultMessage . ')', 'custom_flash_message', array('class' => 'alert-danger'));
//			$this->redirect(array('controller' => 'users', 'action' => 'purchases'));
//		    endif;
                } else {
                    // if created Pay-in object has status different than SUCCEEDED 
                    // that occurred error and display error message				
                    $this->Session->setFlash(__('Something goes wrong,Coupon not purchase successfully') . __(', Error Message: ') . $createdPayIn->ResultMessage . ')', 'custom_flash_message', array('class' => 'alert-danger'));
                    $this->redirect(array('controller' => 'coupons', 'action' => 'view', $slug));
                }
            } catch (\MangoPay\ResponseException $e) {
                $this->Session->setFlash(__('Something goes wrong,Coupon not purchase successfully Code:'), 'custom_flash_message', array('class' => 'alert-danger'));
                $this->redirect(array('controller' => 'coupons', 'action' => 'view', $slug));
            }
        endif;
    }

}

?>