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
                                        <a href="#" id="fb-login" class="btn btn-info btn-block fb-btn rounded-x"><i class="fa fa-2x fa-facebook"></i> Login with facebook</a>
                                    </li>

                                    <li>                                        
                                        <a href="#" id="twitter-login"  class="btn btn-info btn-block twitter-btn rounded-x"><i class="fa fa-2x fa-twitter"></i> Login with twitter</a>
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
                                <?php echo $this->Form->input('email', array('div' => false, 'label' => false, 'id' => 'loginemail', 'class' => 'form-control', 'placeholder' => __('EmailId'))); ?>
                                <i class="fa fa-at fa-2x"></i>
                            </div>                    
                            <div class="form-group form-group-pwd margin-bottom-20">                                		    
                                <?php echo $this->Form->input('password', array('type' => 'password', 'id' => 'loginpassword', 'div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => __('Password'))); ?>
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
                                <a href="#" id="forgetpwd" class="color-red" data-toggle="modal" data-target="#forgotpwdmodal"><?php echo __('click here'); ?></a>
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




<div id="forgotpwdmodal" class="modal fade log-in-modal forget-modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <img src="/img/closebtn.png" id="close-btn" aria-hidden="true" data-dismiss="modal" type="button">                  
            </div>
            <div class="modal-body">
                <div class="container content">		
                    <div class="row">	                        
                        <div class="col-md-12 col-sm-12 reg-page">
                            <div class="reg-block-header text-center">
                                <h1><?php echo __("Reset Password"); ?></h1>
                                <?php echo __('Enter the email address associated with your account, and we\'ll email you a link to reset your password.'); ?>
                                <?php echo $this->Form->create('Tbluser', array('id' => 'forgetpwdform', 'class' => 'forgetpwdfrm ', 'novalidate', 'controller' => 'Users', 'action' => 'forgotPassword', 'plugin' => 'Usermgmt')); ?>
                                <div class="form-group form-group-email margin-bottom-20">
                                    <?php echo $this->Form->input('emailId', array('id' => 'forgetpwdformemail', 'div' => false, 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'E-mail address')); ?>
                                    <i class="fa fa-at fa-2x"></i>
                                </div>

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
                                        <a href="#" id="fb-signup"  class="btn btn-info btn-block fb-btn rounded-x"><i class="fa fa-2x fa-facebook"></i> Signup with facebook</a>
                                    </li>

                                    <li>                                        
                                        <a href="#" id="twitter-signup"  class="btn btn-info btn-block twitter-btn rounded-x"><i class="fa fa-2x fa-twitter"></i> Signup with twitter</a>
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

                            <?php echo $this->Form->create('User', array('url' => '/register', 'class' => 'signupform ', 'novalidate', 'id' => 'signupform')); ?>
                            <div class="reg-header">
                                <h1><?php echo __('Register a new account'); ?></h1>
                <!--		<p><?php echo __('Already Signed Up? Click'); ?> 
                                <?php echo $this->Html->link('Sign In', array('controller' => 'tblusers', 'action' => 'login'), array('class' => 'color-red')) ?> <?php echo __('to login your account.'); ?></p>-->
                            </div>

<!--                            <label><?php echo __('E-mail address'); ?><span class="color-red">*</span></label>		-->
                            <div class="form-group form-group-email margin-bottom-20"> 
                                <?php echo $this->Form->input('email', array('div' => false, 'id' => 'signupemail', 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'E-mail address')); ?>
                                <i class="fa fa-at fa-2x"></i>
                            </div>

<!--<label><?php echo __('Password'); ?><span class="color-red">*</span></label>-->
                            <div class="form-group form-group-email margin-bottom-20"> 
                                <?php echo $this->Form->input('password', array('div' => false, 'id' => 'signuppassword', 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'Password')); ?>
                                <i class="fa fa-lock fa-2x"></i>
                            </div>

<!--                            <label><?php echo __('First Name'); ?><span class="color-red">*</span></label>		-->
                            <div class="form-group form-group-email margin-bottom-20"> 
                                <?php echo $this->Form->input('first_name', array('div' => false, 'id' => 'signupfirst_name', 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'First Name')); ?>
                                <i class="fa fa-user fa-2x"></i>
                            </div>

<!--                            <label><?php echo __('Last Name'); ?><span class="color-red">*</span></label>		-->
                            <div class="form-group form-group-email margin-bottom-20"> 
                                <?php echo $this->Form->input('last_name', array('div' => false, 'id' => 'signuplast_name', 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'Last Name')); ?>
                                <i class="fa fa-user fa-2x"></i>
                            </div>

<!--                            <label><?php echo __('Address'); ?><span class="color-red">*</span></label>-->
                            <div class="form-group form-group-email margin-bottom-20"> 
                                <?php echo $this->Form->input('address', array('type' => 'textarea', 'id' => 'signupaddress', 'label' => false, 'class' => 'form-control margin-bottom-10', 'rows' => 2, 'placeholder' => 'Address')) ?>
<!--                                   <i class="fa fa-user fa-2x"></i>-->
                            </div>

<!--                            <label><?php echo __('Postal code'); ?><span class="color-red">*</span></label>		-->
                            <div class="form-group form-group-email margin-bottom-20"> 
                                <?php echo $this->Form->input('zip_code', array('type' => 'text', 'id' => 'signupzipcode', 'div' => false, 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'Postal Code')); ?>
                                <i class="fa fa-lock fa-2x"></i>
                            </div>

<!--                            <label><?php echo __('City'); ?><span class="color-red">*</span></label>		-->
                            <div class="form-group form-group-email margin-bottom-20"> 
                                <?php echo $this->Form->input('city', array('div' => false, 'id' => 'signupcity', 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'City')); ?>
                                <i class="fa fa-map-marker fa-2x"></i>
                            </div>

<!--                            <label><?php echo __('Country'); ?><span class="color-red">*</span></label>		-->
                            <div class="form-group form-group-email margin-bottom-20"> 
                                <?php echo $this->Form->input('country_id', array('div' => false, 'id' => 'signupcountry', 'label' => false, 'class' => 'form-control input-lg margin-bottom-10', 'options' => $countries, 'placeholder' => 'Country')); ?>
<!--                            <i class="fa fa-flag-o fa-2x"></i>-->
                            </div>

<!--                            <label><?php echo __('Telephone'); ?><span class="color-red">*</span></label>		-->
                            <div class="form-group form-group-email margin-bottom-20"> 
                                <?php echo $this->Form->input('contact_no', array('div' => false, 'id' => 'signupcontact_no', 'label' => false, 'class' => 'form-control margin-bottom-10', 'placeholder' => 'Telephone')); ?>
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
            var email = $('#loginemail').val();
            var password = $('#loginpassword').val();
            if ($('#remember_checkbox').prop('checked') == true) {
                var remember = 1;
            } else {
                var remember = 0;
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Html->url('/'); ?>login',
                data: {email: email, password: password, remember: remember},
                success: function (response) {

                    if (response.status == '1') {
                        $('#loginModal').modal('hide');
                        $('.navigation-items .user-area').html('<?php echo "<li>" . $this->Html->link(__('Logout'), array('controller' => 'Users', 'action' => 'logout', 'plugin' => 'usermgmt')); ?>');
                    }
                    if (response.status == '2') {
                        $('#signinForm .error-message').empty();
                        validation_error(response.errorMsg.email, $('#loginemail'));
                        validation_error(response.errorMsg.password, $('#loginpassword'));
                    }

                    if (response.user_group == '1') {
                        window.location.href = "/admin";
                    } else {
                        $('#loginModal').modal('hide');
                    }

                }
            });
            return false;
        });


        $('#forgetpwd').click(function () {
            $('#loginModal').modal('hide');
        });


        $('#signupform').submit(function () {

            var email = $('#signupemail').val();
            var password = $('#signuppassword').val();
            var first_name = $('#signupfirst_name').val();
            var last_name = $('#signuplast_name').val();
            var address = $('#signupaddress').val();
            var zipcode = $('#signupzipcode').val();
            var city = $('#signupcity').val();
            var country = $('#signupcountry').val();
            var contact_number = $('#signupcontact_no').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Html->url('/'); ?>register',
                data: {
                    email: email,
                    password: password,
                    first_name: first_name,
                    last_name: last_name,
                    address: address,
                    zip_code: zipcode,
                    city: city,
                    country_id: country,
                    phone: contact_number
                },
                success: function (response) {

                    if (response.status == '1') {
                        $('#signupModal').modal('hide');
                        $('.navigation-items .user-area').html('<?php echo "<li>" . $this->Html->link(__('Logout'), array('controller' => 'Users', 'action' => 'logout', 'plugin' => 'usermgmt')); ?>');
                    }
                    if (response.status == '2') {
                        $('#signupform .error-message').empty();
                        validation_error(response.errorMsg.email, $('#signupemail'));
                        validation_error(response.errorMsg.password, $('#signuppassword'));
                        validation_error(response.errorMsg.first_name, $('#signupfirst_name'));
                        validation_error(response.errorMsg.last_name, $('#signuplast_name'));
                        validation_error(response.errorMsg.address, $('#signupaddress'));
                        validation_error(response.errorMsg.zip_code, $('#signupzipcode'));
                        validation_error(response.errorMsg.city, $('#signupcity'));
                        validation_error(response.errorMsg.country_id, $('#signupcountry .bootstrap-select'));
                        validation_error(response.errorMsg.phone, $('#signupcontact_no'));

                    }

                }
            });
            return false;
        });


        $('#forgetpwdform').submit(function () {
            var email = $('#forgetpwdformemail').val();

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Html->url('/'); ?>forgotPassword',
                data: {email: email},
                success: function (response) {
                    $('#forgotpwdmodal .error-message').empty();
                    if (response.status == '2') {
                        validation_error(response.errorMsg.email, $('#forgetpwdformemail'));
                    }
                    if (response.status == '1') {
                        success_msg(response.errorMsg, $('#forgetpwdformemail'));
                    }
                    if (response.status == '0') {
                        validation_error('No user found for this email-id', $('#forgetpwdformemail'));
                    }
                }
            });
            return false;
        });


    })

    function validation_error(rule, ele) {
        if (rule) {
            ele.after('<span class="error-message">' + rule + '</span>');
            ele.addClass('textfield-error');
        } else
            ele.removeClass('textfield-error');
    }

    function success_msg(msg, ele) {
        if (msg) {
            ele.after('<span class="success-message">' + msg + '</span>');
            ele.removeClass('textfield-error');
        }
    }
</script>
<?php $this->end(); ?>


<?php $this->start('footer_js'); ?>
<script type="text/javascript">
    // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
        if (response.status === 'connected') {
            login();
        } else if (response.status === 'not_authorized') {
            alert('Please log into this app.');
        } else {
            alert('Please log into this fb.');
        }
    }

    $("#fb-login").click(function () {
        $("#LoadingImage").show();
        FB.login(function (response) {
            statusChangeCallback(response);
        });
    });

    window.fbAsyncInit = function () {
        FB.init({
            appId: '495564667271600',
            xfbml: true,
            version: 'v2.5'
        });
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function login() {
        FB.api('/me', function (response) {
            console.log(JSON.stringify(response));
            var url = '/social_users/facebook';
            $.ajax({
                url: url,
                type: 'POST',
                data: {User: response},
                success: function (res) {
                    $("#LoadingImage").hide();
                    if (res === '1') {
                        $('.navigation-items .user-area').html('<?php echo "<li>" . $this->Html->link(__('Logout'), array('controller' => 'Users', 'action' => 'logout', 'plugin' => 'usermgmt')); ?>');
                        //window.location.replace('<?php echo FULL_BASE_URL; ?>');
                    }
                }
            });
        });
    }
</script>
<?php $this->end(); ?>