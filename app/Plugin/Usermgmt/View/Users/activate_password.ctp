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
?>


<div class="modal-window fade_in reset-password-modal">
    <div class="modal-wrapper container">

        <div class="modal-header">
            <h2>Reset Password</h2>
            <img src="/img/closebtn.png" id="close-btn" aria-hidden="true" data-dismiss="modal" type="button">                  
        </div>
        
        <div class="modal-body row">
            <div class="umtop col-md-12">
                <?php echo $this->Session->flash(); ?>
                <div class="um_box_up"></div>
                <div class="um_box_mid">
                    <div class="um_box_mid_content">
                        <div class="um_box_mid_content_top">
                            <span class="umstyle1"><?php echo __('Reset Password'); ?></span>
                            <span class="umstyle2" style="float:right"><?php echo $this->Html->link(__("Home", true), "/") ?></span>
                            <div style="clear:both"></div>
                        </div>
                        <div class="umhr"></div>
                        <div class="um_box_mid_content_mid" id="login">
                            <div class="um_box_mid_content_mid_left">
                                <?php echo $this->Form->create('User', array('action' => 'activatePassword')); ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="umstyle3"><?php echo __('Password'); ?></div>
                                        <div class="umstyle4"><?php echo $this->Form->input("password", array("type" => "password", 'label' => false, 'div' => false, 'class' => "umstyle5")) ?></div>
                                    </div>
                                </div>
                                <div style="clear:both"></div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="umstyle3"><?php echo __('Confirm Password'); ?></div>
                                        <div class="umstyle4"><?php echo $this->Form->input("cpassword", array("type" => "password", 'label' => false, 'div' => false, 'class' => "umstyle5")) ?></div>
                                    </div>
                                </div>                                                  
                                <div style="clear:both"></div>


                                <div class="umstyle3"></div>
                                <div class="umstyle4">
                                    <?php
                                    if (!isset($ident)) {
                                        $ident = '';
                                    }
                                    if (!isset($activate)) {
                                        $activate = '';
                                    }
                                    ?>
                                    <?php echo $this->Form->hidden('ident', array('value' => $ident)) ?>
<?php echo $this->Form->hidden('activate', array('value' => $activate)) ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                           <?php echo $this->Form->Submit(__('Reset'),array('class' => 'btn btn-default')); ?></div>
                                        </div>                                            
                                    </div>                        

<?php echo $this->Form->end(); ?>
                            </div>
                            <div class="um_box_mid_content_mid_right" align="right"></div>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                </div>
                <div class="um_box_down"></div>
            </div>
        </div>
        <div class="modal-close"></div>
    </div>
    <div class="modal-background fade_in"></div>
</div>

<?php $this->start('footer_js'); ?>
<script>
document.getElementById("UserEmail").focus();
</script>

<script>
    // Render Owl carousel gallery

    var _rtl = false;
    drawOwlCarousel(_rtl);

    // Render Rating stars

    rating('.modal-window');

    // Remove modal element form DOM

    $('.modal-window .modal-background, .modal-close').live('click',  function(e){
        $('.modal-window').addClass('fade_out');
        setTimeout(function() {
            $('.modal-window').remove();
        }, 300);
    });
</script>
<?php $this->end(); ?>