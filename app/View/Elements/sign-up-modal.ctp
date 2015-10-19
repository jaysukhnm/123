<div id="loginModal" class="modal fade log-in-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container content">		
                    <div class="row">	                        
                        <div class="col-md-12 col-sm-12 reg-page">
                            <div class="reg-block-header text-center">
                                <h1><?php echo __("Sign In"); ?></h1>
                                <ul class="social-icons text-center">
                                    <li>                                        
                                        <a href="#" class="btn btn-info btn-block fb-btn rounded-x"><i class="fa fa-2x fa-facebook"></i> Login with facebook</a>
                                    </li>

                                    <li>                                        
                                        <a href="#" class="btn btn-info btn-block twitter-btn rounded-x"><i class="fa fa-2x fa-twitter"></i> Login with twitter</a>
                                    </li>
                                    <li>			   
                                        <?php echo $this->Html->link('', array('controller' => 'tblusers', 'action' => 'twitter'), array('class' => 'rounded-x social_twitter', 'data-original-title' => 'Twitter')); ?>
                                    </li>
                                </ul>
                                <div id="LoadingImage" class="display-none">
                                    <?php echo $this->Html->image('load1.gif'); ?>
                                </div>
                                <!--<p><?php echo __("Don't Have Account ?"); ?> <br/><?php echo $this->Html->link(__('click here'), array('controller' => 'users', 'action' => 'register'), array('class' => 'color-red')); ?> <?php echo __("to register."); ?></p>-->
                            </div>

                            <div class="divider">or</div>

                            <?php echo $this->Form->create('User', array('url' => '/login', 'id' => 'signinForm'), 'novalidate'); ?>
                            <div class="form-group form-group-email margin-bottom-20">                                		   
                                <?php echo $this->Form->input('email', array('div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => __('EmailId'))); ?>
                                <i class="fa fa-at fa-2x"></i>
                            </div>                    
                            <div class="form-group form-group-pwd margin-bottom-20">                                		    
                                <?php echo $this->Form->input('password', array('type' => 'password', 'div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => __('Password'))); ?>
                                <i class="fa fa-lock fa-2x"></i>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="checkbox">
                                        <?php echo $this->Form->input('remember', array('type' => 'checkbox', 'id' => 'remember_checkbox', 'div' => false, 'label' => false)); ?>
                                        <?php echo __("Stay signed in"); ?></label>                        
                                </div>
                                <div class="col-md-12">
                                    <button class="btn-u btn-block log-in-btn btn-default"  name="submit" value="login" type="submit"><?php echo __("Login"); ?></button>                        
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>     
                            <hr>
                            <h4><?php echo __("Forget your Password ?"); ?></h4>
                            <p><?php echo __("no worries,"); ?>
                                <a href="#" id="forgetpwd" class="color-red" data-toggle="modal" data-target="#forgot-popup"><?php echo __('click here'); ?></a>
                                <?php //echo $this->Html->link(__('click here'), array('controller' => 'users', 'action' => 'forgot_password'), array('class' => 'color-red')); ?>
                                <?php echo __("to reset your password."); ?></p>
                        </div>

                    </div><!--/row-->
                </div><!--/container-->	
            </div>
            <!--            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>-->
        </div>

    </div>
</div>




<div id="forgot-popup" class="modal fade log-in-modal forget-modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <!--      <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                  </div>-->
            <div class="modal-body">
                <div class="container content">		
                    <div class="row">	                        
                        <div class="col-md-12 col-sm-12 reg-page">
                            <div class="reg-block-header text-center">
                                <h1><?php echo __("Reset Password"); ?></h1>
                                <?php echo __('Enter the email address associated with your account, and we\'ll email you a link to reset your password.'); ?>
                                <?php echo $this->Form->create('Tbluser', array('class' => 'forgetpwdfrm ', 'novalidate','controller' => 'Users', 'action' => 'forgotPassword', 'plugin' => 'Usermgmt')); ?>
                                <?php echo $this->Form->input('emailId', array('div' => false, 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'E-mail address')); ?>
                                <i class="fa fa-at fa-2x"></i>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button class="btn-u btn-block log-in-btn btn-signup" name="submit" value="Register" type="submit"><?php echo __('Send Reset Link'); ?></button>                        
                                    </div>
                                </div>
                                <?php echo $this->Form->end(); ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--      <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>-->
        </div>

    </div>
</div>



<!--  -->
<div id="signupModal" class="modal fade log-in-modal sign-up-modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <!--            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>-->
            <div class="modal-body">
                <div class="container content">		
                    <div class="row">	                        
                        <div class="col-md-12 col-sm-12 reg-page">

                            <div class="reg-block-header text-center">
                                <h1><?php echo __("Sign Up"); ?></h1>
                                <ul class="social-icons text-center">
                                    <li>                                        
                                        <a href="#" class="btn btn-info btn-block fb-btn rounded-x"><i class="fa fa-2x fa-facebook"></i> Signup with facebook</a>
                                    </li>

                                    <li>                                        
                                        <a href="#" class="btn btn-info btn-block twitter-btn rounded-x"><i class="fa fa-2x fa-twitter"></i> Signup with twitter</a>
                                    </li>
                                    <li>			   
                                        <?php echo $this->Html->link('', array('controller' => 'tblusers', 'action' => 'twitter'), array('class' => 'rounded-x social_twitter', 'data-original-title' => 'Twitter')); ?>
                                    </li>
                                </ul>
                                <div id="LoadingImage" class="display-none">
                                    <?php echo $this->Html->image('load1.gif'); ?>
                                </div>
                                <!--<p><?php echo __("Don't Have Account ?"); ?> <br/><?php echo $this->Html->link(__('click here'), array('controller' => 'users', 'action' => 'register'), array('class' => 'color-red')); ?> <?php echo __("to register."); ?></p>-->
                            </div>

                            <div class="divider">or</div>

                            <?php echo $this->Form->create('User', array( 'url' => '/register', 'class' => 'signupform ', 'novalidate')); ?>
                            <div class="reg-header">
                                <h1><?php echo __('Register a new account'); ?></h1>
                <!--		<p><?php echo __('Already Signed Up? Click'); ?> 
                                <?php echo $this->Html->link('Sign In', array('controller' => 'tblusers', 'action' => 'login'), array('class' => 'color-red')) ?> <?php echo __('to login your account.'); ?></p>-->
                            </div>

<!--                            <label><?php echo __('E-mail address'); ?><span class="color-red">*</span></label>		-->
                              <div class="form-group form-group-email margin-bottom-20"> 
                            <?php echo $this->Form->input('emailId', array('div' => false, 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'E-mail address')); ?>
                            <i class="fa fa-at fa-2x"></i>
                              </div>
                            
<!--<label><?php echo __('Password'); ?><span class="color-red">*</span></label>-->
                              <div class="form-group form-group-email margin-bottom-20"> 
                            <?php echo $this->Form->input('password', array('div' => false, 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'Password')); ?>
                            <i class="fa fa-lock fa-2x"></i>
                              </div>

<!--                            <label><?php echo __('First Name'); ?><span class="color-red">*</span></label>		-->
                              <div class="form-group form-group-email margin-bottom-20"> 
                            <?php echo $this->Form->input('first_name', array('div' => false, 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'First Name')); ?>
                            <i class="fa fa-user fa-2x"></i>
                              </div>

<!--                            <label><?php echo __('Last Name'); ?><span class="color-red">*</span></label>		-->
                              <div class="form-group form-group-email margin-bottom-20"> 
                            <?php echo $this->Form->input('last_name', array('div' => false, 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'Last Name')); ?>
                            <i class="fa fa-user fa-2x"></i>
                              </div>

<!--                            <label><?php echo __('Address'); ?><span class="color-red">*</span></label>-->
                              <div class="form-group form-group-email margin-bottom-20"> 
                            <?php echo $this->Form->input('address', array('type' => 'textarea', 'label' => false, 'class' => 'form-control margin-bottom-10', 'rows' => 2, 'placeholder' => 'Address')) ?>
<!--                                   <i class="fa fa-user fa-2x"></i>-->
                              </div>

<!--                            <label><?php echo __('Postal code'); ?><span class="color-red">*</span></label>		-->
                              <div class="form-group form-group-email margin-bottom-20"> 
                            <?php echo $this->Form->input('zipcode', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'Postal Code')); ?>
                            <i class="fa fa-lock fa-2x"></i>
                              </div>

<!--                            <label><?php echo __('City'); ?><span class="color-red">*</span></label>		-->
                              <div class="form-group form-group-email margin-bottom-20"> 
                            <?php echo $this->Form->input('city', array('div' => false, 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'City')); ?>
                            <i class="fa fa-map-marker fa-2x"></i>
                              </div>

<!--                            <label><?php echo __('Country'); ?><span class="color-red">*</span></label>		-->
                              <div class="form-group form-group-email margin-bottom-20"> 
                            <?php echo $this->Form->input('countryId', array('div' => false, 'label' => false, 'class' => 'form-control input-lg margin-bottom-10', 'options' => $countries, 'placeholder' => 'Country')); ?>
<!--                            <i class="fa fa-flag-o fa-2x"></i>-->
                              </div>

<!--                            <label><?php echo __('Telephone'); ?><span class="color-red">*</span></label>		-->
                              <div class="form-group form-group-email margin-bottom-20"> 
                            <?php echo $this->Form->input('contact_no', array('div' => false, 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'Telephone')); ?>
                            <i class="fa fa-phone fa-2x"></i>
                              </div>


                            <?php //echo $captcha; ?>
                            <?php //if (!$recaptchaPassed): ?>
<!--                                <div class="error-message"><?php echo __('Your image verification failed. Please try again.'); ?></div>-->
                            <?php //endif; ?>


                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="checkbox padding-0">
                                        <?php echo __('By registering you agree to our'); ?> 
                                        <a class="color-red" href="http://show-up.fr/images/makemevip/conditions-utilisations.html">
                                            <?php echo __('terms and conditions.'); ?>
                                        </a> <?php echo __('Your personal information will not be disclosed to third parties.'); ?>
                                    </label>                        
                                </div>

                                <div class="col-md-12 text-right">
                                    <button class="btn-u btn-block log-in-btn btn-signup" name="submit" value="Register" type="submit"><?php echo __('Register'); ?></button>                        
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div><!--/row-->
                </div><!--/container-->	
            </div>
            <!--            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>-->
        </div>

    </div>
</div>

<?php $this->start('footer_js'); ?>
<?php
            echo $this->Html->script('jquery.validate.min.js');
        ?>
<script>
    $(document).ready(function () {
        $('#signinForm').submit(function () {
            var email = $('#UserEmail').val();
            var password = $('#UserPassword').val();
            if($('#remember_checkbox').prop('checked') == true){
                var remember = 1;
            }else{
                var remember = 0;
            }
            
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Html->url('/'); ?>login',
                data: {email:email, password:password, remember:remember},                
                success: function(resp) {				   
                    console.log(resp);
                }
            });	
            return false;
        });
        
        
        $('#forgetpwd').click(function () {
            $('#loginModal').modal('hide');
        });
        
        
    })
</script>
<?php $this->end(); ?>
