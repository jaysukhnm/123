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
class AppController extends Controller {

    var $helpers = array('Form', 'Html', 'Session', 'Js', 'Usermgmt.UserAuth');
    public $components = array('DebugKit.Toolbar', 'Session', 'RequestHandler', 'Usermgmt.UserAuth');
    public $uses = array('Country');

    function beforeFilter() {
        $this->userAuth();

        if (isset($this->params['admin']) && $this->params['admin']) {
            // check user is logged in
            $user = $this->UserAuth->getUser();
            if (empty($user) || !in_array($user['User']['user_group_id'], array('1','4','5','6','7'))):
                $this->Session->setFlash('You must be logged in for that action.');
                $this->redirect('/');
            endif;
            // change layout
            $this->layout = 'admin';
        }
        
        $countries = $this->Country->find('list', array('fields' => array('id', 'country_name')));
        $this->set(compact('countries'));
    }

    private function userAuth() {
        $this->UserAuth->beforeFilter($this);
    }

}
