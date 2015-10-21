<!--=== Footer ===-->
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 padding-0">				
                <div class="hidden-sm hidden-md visible-lg">				    
                    <?php echo $this->Html->link('', array('controller' => 'homes', 'action' => 'index'), array('class' => 'app')) ?>
                </div>				 			
            </div>
            <div class="col-md-5 col-sm-5">
                <h3 class="padding-left-10"><?php echo __('Download the'); ?> <strong><?php echo __('Make Me VIP app'); ?></strong></h3>
                <div  class="col-md-9 col-xs-12 padding-left-0">				 
                    <div class="col-md-6 col-lg-5 col-xs-6 padding-left-0 padding-right"><?php echo $this->Html->image('qr_code_android.png', array('alt' => 'Apple', 'class' => 'img-responsive inline-block qr-code-img')); ?></div>
                    <div class="col-md-6 col-lg-5 col-xs-6 qr-links">					     
                        <?php echo $this->Html->link($this->Html->image('apple-icon.png', array('alt' => 'Apple', 'class' => 'img-responsive inline-block')), 'https://itunes.apple.com/fr/app/make-me-vip/id830236051?mt=8', array('target' => '_blank', 'escape' => false)); ?>					
                        <?php echo $this->Html->link($this->Html->image('android-icon.png', array('alt' => 'Android', 'class' => 'img-responsive inline-block')), 'https://play.google.com/store/apps/details?id=com.showup.makemevip', array('target' => '_blank', 'escape' => false)); ?>
                    </div>					
                </div>
            </div>
            <div class="visible-xs clearfix"></div>
            <div class="col-md-2 col-sm-3">
                <div class="thumb-headline"><h2><strong><?php echo __('My account'); ?></strong></h2></div>
                <ul class="list-unstyled simple-list margin-bottom-20">	
                    <li class="i-pad-lang">
                        <i class="fa fa-globe"></i>
                        <a><?php echo __('Languages'); ?></a>
                        <?php echo $this->I18n->flagSwitcher(array('class' => 'lenguages', 'id' => 'language-switcher')); ?>
                    </li>
                    <li>
                        <?php echo $this->Html->link(__('Who we are?'), array('controller' => 'users', 'action' => 'informations')) ?>
                    </li>		
                    <li>
                        <?php echo $this->Html->link(__('How it work?'), array('controller' => 'users', 'action' => 'informations')) ?>
                    </li>		
                    <li>
                        <?php echo $this->Html->link(__('Contact US'), array('controller' => 'users', 'action' => 'addresses')) ?>
                    </li>
                    <li>
                        <?php echo $this->Html->link(__('Legal mentions'), array('controller' => 'users', 'action' => 'purchases')) ?>
                    </li>
                    
                </ul>
            </div>
            <div class="col-md-3 col-sm-4  padding-0">
                <div class="fotolia center">
                    <?php echo $this->Html->image('fotolia.png', array('alt' => 'Owner', 'class' => 'img-responsive inline-block v-alignTop')); ?>
                </div>
                <div class="storeOwner">
                    <?php echo $this->Html->image('store-icon.png', array('alt' => 'Owner', 'class' => 'img-responsive pull-left')); ?>
                    <div class="inline">
                        <p class="marginBottom-0">
                            <strong><?php echo __("You’re a store owner ?"); ?></strong>
                        </p>
                        <a href="http://show-up.fr/fr/nos-distributeurs.html" target="_blank">
                            <?php echo __("Click here"); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div><!--/footer-->	

<!--=== Copyright ===-->
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-xs-6 col-lg-8">                     
                <p>
                    <?php echo date("Y"); ?> &copy; Show-Up				    
                    <a href="http://show-up.fr/images/makemevip/conditions-utilisations.html" target="_blank"><?php echo __("Privacy Policy"); ?></a>|
                    <?php //echo $this->Html->link(__("Site map"), array('controller' => 'sitemap', 'action' => 'view'), array('target' => '_blank')); ?>
                    <?php echo $this->Html->link(__("Admin"), 'https://manager.show-up.fr', array('target' => '_blank')); ?>
                </p>
            </div>
            <div class="col-md-4 col-xs-6 col-lg-4">
                <ul class="social-icons col-md-8 col-xs-8 text-right">                      
                    <li><a href="https://www.youtube.com/channel/UCBhBVr2BUtFaOVoEsVuWxZQ" data-original-title="Youtube" class="social_youtube" target="_blank"></a></li>
                    <li><a href="https://plus.google.com/u/1/b/112209755405332141290/+MakemevipInfoapp" data-original-title="Goole Plus" class="social_googleplus" target="_blank"></a></li>
                    <li><a href="https://www.facebook.com/makemevipinfo" data-original-title="Facebook" class="social_facebook" target="_blank"></a></li>
                    <li><a href="https://twitter.com/mmvipinfo" data-original-title="Twitter" class="social_twitter" target="_blank"></a></li>
                </ul>
                <div class="col-md-4 col-xs-4">
                    <?php echo $this->Html->image('show-up_logo.png', array('alt' => 'Show Up', 'class' => 'pull-right', 'id' => 'logo-footer', 'url' => array('controller' => 'homes', 'action' => 'index'))); ?>			    
                </div>
            </div>
        </div>
    </div> 
</div><!--=== / Copyright ===-->

<?php
$this->start('footer_js');?>
<script>
    $('document').ready(function(){
       $('.qr-links a').click(function(e){         
            var url = $(this).attr('href');
            $(this).attr("disabled", "disabled");
            $(this).removeAttr("href");
            window.open(url, '_blank');           
       }) 
    });
</script>

     
<?php
$this->end();
?>