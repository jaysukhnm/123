<?php

/*
  This file is part of UserMgmt.

  Author: Chetan Varshney (http://ektasoftwares.com)

  UserMgmt is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  UserMgmt is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 */

App::uses('UserMgmtAppController', 'Usermgmt.Controller');

class UsersController extends UserMgmtAppController {

    /**
     * This controller uses following models
     *
     * @var array
     */
    public $uses = array('Usermgmt.User', 'Usermgmt.UserGroup', 'Usermgmt.LoginToken');

    /**
     * Called before the controller action.  You can use this method to configure and customize components
     * or perform logic that needs to happen before each controller action.
     *
     * @return void
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->User->userAuth = $this->UserAuth;
    }

    /**
     * Used to display all users by Admin
     *
     * @access public
     * @return array
     */
    public function index() {
        $this->User->unbindModel(array('hasMany' => array('LoginToken')));
        $users = $this->User->find('all', array('order' => 'User.id desc'));
        $this->set('users', $users);
    }

    /**
     * Used to display detail of user by Admin
     *
     * @access public
     * @param integer $userId user id of user
     * @return array
     */
    public function viewUser($userId = null) {
        if (!empty($userId)) {
            $user = $this->User->read(null, $userId);
            $this->set('user', $user);
        } else {
            $this->redirect('/allUsers');
        }
    }

    /**
     * Used to display detail of user by user
     *
     * @access public
     * @return array
     */
    public function myprofile() {
        $userId = $this->UserAuth->getUserId();
        $user = $this->User->read(null, $userId);
        $this->set('user', $user);
    }

    /**
     * Used to logged in the site
     *
     * @access public
     * @return void
     */
    public function login() {
        $this->layout = 'ajax';
        $user_data = $status = $errorMsg = '';
        $status = 0;
        $errorMsg = '';
        if ($this->request->isPost()) {
            $this->User->set($this->data);
            if ($this->User->LoginValidate()) {
                $email = $this->data['email'];
                $password = $this->data['password'];
                $user = $this->User->findByEmail($email);
                if (empty($user)) {
                    $errorMsg = __('Incorrect Email or Password');
                    $status = 0;
                } else {
                    // check for inactive account
                    if ($user['User']['id'] != 1 and $user['User']['active'] == 0) {
                        $errorMsg = __('Sorry your account is not active, please contact to Administrator');
                        $status = 0;
                    }
                    // check for verified account
                    if ($user['User']['id'] != 1 and $user['User']['email_verified'] == 0) {
                        $errorMsg = __('Sorry your account is not active, please contact to Administrator');
                        $status = 0;
                    }
                    if (empty($user['User']['salt'])) {
                        $hashed = md5($password);
                    } else {
                        $hashed = $this->UserAuth->makePassword($password, $user['User']['salt']);
                    }
                    if ($user['User']['password'] === $hashed) {
                        if (empty($user['User']['salt'])) {
                            $salt = $this->UserAuth->makeSalt();
                            $user['User']['salt'] = $salt;
                            $user['User']['password'] = $this->UserAuth->makePassword($password, $salt);
                            $this->User->save($user, false);
                        }
                        $this->UserAuth->login($user);
                        if (isset($this->data['remember']) && $this->data['remember'] == 1) {
                            $this->UserAuth->persist('2 weeks');
                        }
                        $OriginAfterLogin = $this->Session->read('Usermgmt.OriginAfterLogin');
                        $this->Session->delete('Usermgmt.OriginAfterLogin');
                        $redirect = (!empty($OriginAfterLogin)) ? $OriginAfterLogin : LOGIN_REDIRECT_URL;
//                    $this->redirect($redirect);
                        $errorMsg = __('Login Successfull');
                        $status = 1;
                        $user_data = $user['User'];
                    } else {
                        $errorMsg = __('Incorrect Email or Password');
                        $status = 0;
                    }
                }
            } else {
                $errors = $this->User->validationErrors;
                $status = 2;
                $errorMsg = $errors;
                //var_dump($errors);
                // $this->Session->setFlash($errors);
                //die();
            }
        }
        header('Content-type: application/json');
        $data['status'] = $status;
        $data['errorMsg'] = $errorMsg;
        $data['user_data'] = $user_data;
        echo json_encode($data);        
        exit();
    }

    /**
     * Used to logged out from the site
     *
     * @access public
     * @return void
     */
    public function logout() {
        $this->UserAuth->logout();
        $this->Session->setFlash(__('You are successfully signed out'));
        $this->redirect(LOGOUT_REDIRECT_URL);
    }

    /**
     * Used to register on the site
     *
     * @access public
     * @return void
     */
    public function register() {
        $this->layout = 'ajax';
        $userId = $this->UserAuth->getUserId();
        $status = 0;
        $errorMsg = '';
        $user_data = '';
        if ($userId) {
            $this->redirect("/");
        }
        if (SITE_REGISTRATION) {
            if ($this->request->isPost()) {
//                
//                $data_parse = array();
//                parse_str($_POST['post'], $data_parse);
//                $data1 = $data_parse['data'];
//                $this->request->data = $data1;
                $this->User->set($this->request->data);
                if ($this->User->RegisterValidate()) {
                    $this->request->data['user_group_id'] = DEFAULT_GROUP_ID;
//                    if (!isset($this->data['User']['user_group_id'])) {
//                    } elseif (!$this->UserGroup->isAllowedForRegistration($this->data['User']['user_group_id'])) {
//                        $this->Session->setFlash(__('Please select correct register as'));
//                        return;
//                    }
                    $this->request->data['active'] = 1;
                    $this->request->data['email_verified'] = 1;
//                    if (!EMAIL_VERIFICATION) {
//                    }
                    $ip = '';
                    if (isset($_SERVER['REMOTE_ADDR'])) {
                        $ip = $_SERVER['REMOTE_ADDR'];
                    }

                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $randomString = '';
                    for ($i = 0; $i < 10; $i++) {
                        $randomString .= $characters[rand(0, strlen($characters) - 1)];
                    }
                    $this->request->data['qrcode_id'] = $randomString;
                    
                    $this->request->data['ip_address'] = $ip;
                    $salt = $this->UserAuth->makeSalt();
                    $this->request->data['salt'] = $salt;
                    $this->request->data['password'] = $this->UserAuth->makePassword($this->request->data['password'], $salt);

                    if ($this->User->save($this->request->data, false)) {
                        $userId = $this->User->getLastInsertID();
                        $user = $this->User->findById($userId);
                        $errorMsg = __('Registration Successfull');
                        $status = 1;
                        $user_data = $user['User'];
                    } else {
                        $errorMsg = __('Registration Error');
                        $status = 0;
                        $user_data = '';
                    }


                    if (SEND_REGISTRATION_MAIL && !EMAIL_VERIFICATION) {
                        // $this->User->sendRegistrationMail($user);
                    }
                    if (EMAIL_VERIFICATION) {
                        // $this->User->sendVerificationMail($user);
                    }
                    if (isset($this->request->data['User']['email_verified']) && $this->request->data['User']['email_verified']) {
                        $this->UserAuth->login($user);
                        // $this->redirect('/');
                    } else {
                        $this->Session->setFlash(__('Please check your mail and confirm your registration'));
                        //$this->redirect('/register');
                    }
                } else {
                    $errors = $this->User->validationErrors;
                    $status = 2;
                    $errorMsg = $errors;
                }
            }
        } else {
            $this->Session->setFlash(__('Sorry new registration is currently disabled, please try again later'));
            // $this->redirect('/login');
        }
        header('Content-type: application/json');
        $data['status'] = $status;
        $data['errorMsg'] = $errorMsg;
        $data['user_data'] = $user_data;
        echo json_encode($data);
        exit();
    }

    /**
     * Used to change the password by user
     *
     * @access public
     * @return void
     */
    public function changePassword() {
        $userId = $this->UserAuth->getUserId();
        if ($this->request->isPost()) {
            $this->User->set($this->data);
            if ($this->User->RegisterValidate()) {
                $user = array();
                $user['User']['id'] = $userId;
                $salt = $this->UserAuth->makeSalt();
                $user['User']['salt'] = $salt;
                $user['User']['password'] = $this->UserAuth->makePassword($this->request->data['User']['password'], $salt);
                $this->User->save($user, false);
                $this->LoginToken->deleteAll(array('LoginToken.user_id' => $userId), false);
                $this->Session->setFlash(__('Password changed successfully'));
                $this->redirect('/dashboard');
            }
        }
    }

    /**
     * Used to change the user password by Admin
     *
     * @access public
     * @param integer $userId user id of user
     * @return void
     */
    public function changeUserPassword($userId = null) {
        if (!empty($userId)) {
            $name = $this->User->getNameById($userId);
            $this->set('name', $name);
            if ($this->request->isPost()) {
                $this->User->set($this->data);
                if ($this->User->RegisterValidate()) {
                    $user = array();
                    $user['User']['id'] = $userId;
                    $salt = $this->UserAuth->makeSalt();
                    $user['User']['salt'] = $salt;
                    $user['User']['password'] = $this->UserAuth->makePassword($this->request->data['User']['password'], $salt);
                    $this->User->save($user, false);
                    $this->LoginToken->deleteAll(array('LoginToken.user_id' => $userId), false);
                    $this->Session->setFlash(__('Password for %s changed successfully', $name));
                    $this->redirect('/allUsers');
                }
            }
        } else {
            $this->redirect('/allUsers');
        }
    }

    /**
     * Used to add user on the site by Admin
     *
     * @access public
     * @return void
     */
    public function addUser() {
        $userGroups = $this->UserGroup->getGroups();
        $this->set('userGroups', $userGroups);
        if ($this->request->isPost()) {
            $this->User->set($this->data);
            if ($this->User->RegisterValidate()) {
                $this->request->data['User']['email_verified'] = 1;
                $this->request->data['User']['active'] = 1;
                $salt = $this->UserAuth->makeSalt();
                $this->request->data['User']['salt'] = $salt;
                $this->request->data['User']['password'] = $this->UserAuth->makePassword($this->request->data['User']['password'], $salt);
                $this->User->save($this->request->data, false);
                $this->Session->setFlash(__('The user is successfully added'));
                $this->redirect('/addUser');
            }
        }
    }

    /**
     * Used to edit user on the site by Admin
     *
     * @access public
     * @param integer $userId user id of user
     * @return void
     */
    public function editUser($userId = null) {
        if (!empty($userId)) {
            $userGroups = $this->UserGroup->getGroups();
            $this->set('userGroups', $userGroups);
            if ($this->request->isPut()) {
                $this->User->set($this->data);
                if ($this->User->RegisterValidate()) {
                    $this->User->save($this->request->data, false);
                    $this->Session->setFlash(__('The user is successfully updated'));
                    $this->redirect('/allUsers');
                }
            } else {
                $user = $this->User->read(null, $userId);
                $this->request->data = null;
                if (!empty($user)) {
                    $user['User']['password'] = '';
                    $this->request->data = $user;
                }
            }
        } else {
            $this->redirect('/allUsers');
        }
    }

    /**
     * Used to delete the user by Admin
     *
     * @access public
     * @param integer $userId user id of user
     * @return void
     */
    public function deleteUser($userId = null) {
        if (!empty($userId)) {
            if ($this->request->isPost()) {
                if ($this->User->delete($userId, false)) {
                    $this->LoginToken->deleteAll(array('LoginToken.user_id' => $userId), false);
                    $this->Session->setFlash(__('User is successfully deleted'));
                }
            }
            $this->redirect('/allUsers');
        } else {
            $this->redirect('/allUsers');
        }
    }

    /**
     * Used to show dashboard of the user
     *
     * @access public
     * @return array
     */
    public function dashboard() {
        $userId = $this->UserAuth->getUserId();
        $user = $this->User->findById($userId);
        $this->set('user', $user);
    }

    /**
     * Used to activate or deactivate user by Admin
     *
     * @access public
     * @param integer $userId user id of user
     * @param integer $active active or inactive
     * @return void
     */
    public function makeActiveInactive($userId = null, $active = 0) {
        if (!empty($userId)) {
            $user = array();
            $user['User']['id'] = $userId;
            $user['User']['active'] = ($active) ? 1 : 0;
            $this->User->save($user, false);
            if ($active) {
                $this->Session->setFlash(__('User is successfully activated'));
            } else {
                $this->Session->setFlash(__('User is successfully deactivated'));
            }
        }
        $this->redirect('/allUsers');
    }

    /**
     * Used to verify email of user by Admin
     *
     * @access public
     * @param integer $userId user id of user
     * @return void
     */
    public function verifyEmail($userId = null) {
        if (!empty($userId)) {
            $user = array();
            $user['User']['id'] = $userId;
            $user['User']['email_verified'] = 1;
            $this->User->save($user, false);
            $this->Session->setFlash(__('User email is successfully verified'));
        }
        $this->redirect('/allUsers');
    }

    /**
     * Used to show access denied page if user want to view the page without permission
     *
     * @access public
     * @return void
     */
    public function accessDenied() {
        
    }

    /**
     * Used to verify user's email address
     *
     * @access public
     * @return void
     */
    public function userVerification() {
        if (isset($_GET['ident']) && isset($_GET['activate'])) {
            $userId = $_GET['ident'];
            $activateKey = $_GET['activate'];
            $user = $this->User->read(null, $userId);
            if (!empty($user)) {
                if (!$user['User']['email_verified']) {
                    $password = $user['User']['password'];
                    $theKey = $this->User->getActivationKey($password);
                    if ($activateKey == $theKey) {
                        $user['User']['email_verified'] = 1;
                        $this->User->save($user, false);
                        if (SEND_REGISTRATION_MAIL && EMAIL_VERIFICATION) {
                            $this->User->sendRegistrationMail($user);
                        }
                        $this->Session->setFlash(__('Thank you, your account is activated now'));
                    }
                } else {
                    $this->Session->setFlash(__('Thank you, your account is already activated'));
                }
            } else {
                $this->Session->setFlash(__('Sorry something went wrong, please click on the link again'));
            }
        } else {
            $this->Session->setFlash(__('Sorry something went wrong, please click on the link again'));
        }
        $this->redirect('/login');
    }

    /**
     * Used to send forgot password email to user
     *
     * @access public
     * @return void
     */
    public function forgotPassword() {
        $this->layout = 'ajax';
        $status = '0';
        $errorMsg = '';
        $user_data = '';
        if ($this->request->isPost()) {

            $this->User->set($this->data);
            if ($this->User->LoginValidate()) {
                $email = $this->data['email'];
                $user = $this->User->findByEmail($email);

                if (empty($user)) {
                    $status = '0';
                    $errorMsg = __('No user found for this email-id');
                } else {
                    // check for inactive account
                    if ($user['User']['id'] != 1 and $user['User']['email_verified'] == 0) {
                        $status = '0';
                        $errorMsg = __('Your registration has not been confirmed yet please verify your email before reset password');
                    } else {
                        $this->User->forgotPassword($user);
                        $status = '1';
                        $errorMsg = __('Please check your mail for reset your password');
                    }
                }

                //$this->redirect('/login');
            } else {
                $errors = $this->User->validationErrors;
                $status = '2';
                $errorMsg = $errors;
            }
        }
        header('Content-type: application/json');
        $data['status'] = $status;
        $data['errorMsg'] = $errorMsg;
        $data['user_data'] = $user_data;
        echo json_encode($data);
        exit();
    }

    /**
     *  Used to reset password when user comes on the by clicking the password reset link from their email.
     *
     * @access public
     * @return void
     */
    public function activatePassword() {
        if ($this->request->isPost()) {
            if (!empty($this->data['User']['ident']) && !empty($this->data['User']['activate'])) {
                $this->set('ident', $this->data['User']['ident']);
                $this->set('activate', $this->data['User']['activate']);
                $this->User->set($this->data);
                if ($this->User->RegisterValidate()) {
                    $userId = $this->data['User']['ident'];
                    $activateKey = $this->data['User']['activate'];
                    $user = $this->User->read(null, $userId);
                    if (!empty($user)) {
                        $password = $user['User']['password'];
                        $thekey = $this->User->getActivationKey($password);
                        if ($thekey == $activateKey) {
                            $user['User']['password'] = $this->data['User']['password'];
                            $salt = $this->UserAuth->makeSalt();
                            $user['User']['salt'] = $salt;
                            $user['User']['password'] = $this->UserAuth->makePassword($user['User']['password'], $salt);
                            $this->User->save($user, false);
                            $this->Session->setFlash(__('Your password has been reset successfully'));
                            $this->redirect('/login');
                        } else {
                            $this->Session->setFlash(__('Something went wrong, please send password reset link again'));
                        }
                    } else {
                        $this->Session->setFlash(__('Something went wrong, please click again on the link in email'));
                    }
                }
            } else {
                $this->Session->setFlash(__('Something went wrong, please click again on the link in email'));
            }
        } else {
            if (isset($_GET['ident']) && isset($_GET['activate'])) {
                $this->set('ident', $_GET['ident']);
                $this->set('activate', $_GET['activate']);
            }
        }
    }

    /**
     * Used to send email verification mail to user
     *
     * @access public
     * @return void
     */
    public function emailVerification() {
        if ($this->request->isPost()) {
            $this->User->set($this->data);
            if ($this->User->LoginValidate()) {
                $email = $this->data['User']['email'];
                $user = $this->User->findByUsername($email);
                if (empty($user)) {
                    $user = $this->User->findByEmail($email);
                    if (empty($user)) {
                        $this->Session->setFlash(__('Incorrect Email/Username'));
                        return;
                    }
                }
                if ($user['User']['email_verified'] == 0) {
                    $this->User->sendVerificationMail($user);
                    $this->Session->setFlash(__('Please check your mail to verify your email'));
                } else {
                    $this->Session->setFlash(__('Your email is already verified'));
                }
                $this->redirect('/login');
            }
        }
    }

}
