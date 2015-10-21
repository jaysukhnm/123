<?php
//
//$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
//$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
//   
$config = $this->Session->read('Config');		
if (!empty($config['language']) && $config['language'] == "eng"):
   $lang = 'en';
elseif (!empty($config['language']) && $config['language'] == "ron"):
    $lang = 'ro';
else:
    $lang = 'fr';		    
endif;?>    

<!DOCTYPE html>
<html lang ="<?php echo $lang?>">
    <head>
	<?php //echo $this->Html->charset(); ?>
        <meta charset="UTF-8"/>

         <?php  echo $this->fetch('head_meta'); ?>

        <title>		
		<?php 
//		if(isset($meta_title)):
//		    echo $meta_title;
//		else:
//		    echo $default_meta_title;
//		endif;
		?>
        </title>
	    <?php //if (isset($meta_keywords)): ?>
        <meta name = "keywords" content="<?php //echo $meta_keywords; ?>" />
	    <?php //endif; ?>
	    <?php //if (isset($meta_description)): ?>
        <meta name = "description" content="<?php //echo $meta_description; ?>" />	   
	    <?php //endif;?>
        <!--<meta http-equiv="Cache-control" content="public">-->	    
        <meta name="DC.Language" content="<?php //echo $lang; ?>">	
        <meta name="DC.title" content="<?php //echo isset($title)?$title:$default_meta_title; ?>">	    
        <meta name="DC.description" content="<?php //echo isset($meta_description)?$meta_description:''; ?>">


        <meta name="apple-itunes-app" content="app-id=830236051">
        <meta name="google-play-app" content="app-id=com.showup.makemevip">	             
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="apple-touch-icon" href="<?php echo FULL_BASE_URL; ?>/img/appleapp.png" />

		<?php if(!isset($this->request->params['named']['lang'])):
		if($this->request->controller != 'homes'):
		?>
        <link rel="alternate" href="<?php echo $this->Html->url( null, true )."/lang:eng"; ?>" hreflang="en" />
        <link rel="alternate" href="<?php echo $this->Html->url( null, true )."/lang:fra"; ?>" hreflang="fr" />	   
	    <?php else:?>
        <link rel="alternate" href="<?php echo $this->Html->url( null, true )."/lang:eng"; ?>" hreflang="en" />
        <link rel="alternate" href="<?php echo $this->Html->url( null, true )."/lang:fra"; ?>" hreflang="fr" />		
		<?php endif;?>
	    <?php endif;?>
        <!-- Favicon -->
        <link href="/favicon.ico" type="image/x-icon" rel="icon">
        <link href="/favicon.ico" rel="shortcut icon">

        <!-- CSS Global Compulsory -->
	   <?php
           echo $this->Html->css('fonts/font-awesome.css');
           echo $this->Html->css('fonts/font_fontserrat.css');
           echo $this->Html->css('bootstrap/css/bootstrap.css');
           echo $this->Html->css('css/bootstrap-select.min.css');
           echo $this->Html->css('css/jquery.nouislider.min.css');
           echo $this->Html->css('css/jquery.mCustomScrollbar.css');
//           echo $this->Html->css('css/colors/orange.css');
           echo $this->Html->css('css/style.css');
           echo $this->Html->css('css/user.style.css');
           echo $this->Html->css('bootstrap-switch.css');          
           
           echo $this->fetch('header_css'); ?>

        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-42666207-2', 'makemevip.info');
            ga('send', 'pageview');
        </script>
        <script type="text/javascript" async defer
                src="https://apis.google.com/js/platform.js?publisherid=112209755405332141290">
        </script>
    </head>	

    
<body onunload="" class="map-fullscreen page-homepage navigation-top-header" id="page-top">

<!-- Outer Wrapper-->
<div id="outer-wrapper">
    <!-- Inner Wrapper -->
    <div id="inner-wrapper">
        <!-- Navigation-->
        <div class="header">
            <div class="wrapper">
                <div class="brand">
                     <a href="/">		
                        <?php echo $this->Html->image('logo.png', array('alt' => 'Make Me VIP', 'div' => false));?>	    
                    </a>   
                     
                </div>
                <nav class="navigation-items">
                    <?php echo $this->element('top-nav'); ?>
                </nav>
            </div>
        </div>
        
        <?php echo $this->element('sign-up-modal'); ?>
       
        <div id="page-canvas">
            <!--Off Canvas Navigation-->
<!--            <nav class="off-canvas-navigation">
                <header>Navigation</header>
                <div class="main-navigation navigation-off-canvas">                
                    
                </div>
                   
          
            </nav>-->
                </div>
                

    <nav role="navigation" class="navbar navbar-default">

        <!-- Brand and toggle get grouped for better mobile display -->

        <div class="navbar-header">

            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">

                <span class="sr-only">Toggle navigation</span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

            </button>

            <a href="#" class="navbar-brand">Navigation</a>

        </div>

        <!-- Collection of nav links and other content for toggling -->

        <div id="navbarCollapse" class="collapse navbar-collapse">

            <ul class="nav navbar-nav">                
            <!-- Home -->
            <li class="<?php if ($this->request->controller == "homes") echo "active"; ?>">
		    <?php echo $this->Html->link(__('Home'), '/')?>		   
            </li>                    
            <li class="<?php if ($this->request->controller == "posts") echo "active"; ?>">
		    <?php echo $this->Html->link(__('News'), array('controller' => 'posts', 'action' => 'index'))?>		   
            </li>
<!--                    <li class="<?php if ($this->request->controller == "online_orders") echo "active"; ?>">
		    <?php echo $this->Html->link(__('Online order'), array('controller' => 'online_orders', 'action' => 'index'))?>		    
            </li>
            <li class="<?php if ($this->request->controller == "deliveries") echo "active"; ?>">
		    <?php echo $this->Html->link(__('Delivery'), array('controller' => 'deliveries', 'action' => 'index'))?>		    
            </li>-->
            <li class="<?php if ($this->request->controller == "coupons") echo "active"; ?>">
		    <?php echo $this->Html->link(__('Coupons'), array('controller' => 'coupons', 'action' => 'index'))?>		    
            </li>
            <li class="<?php if ($this->request->controller == "events") echo "active"; ?>">
		    <?php echo $this->Html->link(__('Events'), array('controller' => 'events', 'action' => 'index'))?>		    
            </li>		
            <li class="<?php if ($this->request->controller == "contest") echo "active"; ?>">
		    <?php echo $this->Html->link(__('Challenge'), array('controller' => 'contest', 'action' => 'index'))?>		    
            </li>
            <?php 
        $user = $this->UserAuth->getUser();
        if($user):
                echo "<li>".$this->Html->link(__('Logout'), array('controller' => 'Users', 'action' => 'logout', 'plugin' => 'usermgmt'));
        else:?>
            <li><a class="" data-toggle="modal" data-target="#loginModal"><?php echo __('Sign In');?></a></li>
            <li><a class="" data-toggle="modal" data-target="#signupModal"><?php echo __('Register');?></a></li>
        <?php endif;
        ?>
        </ul>        

        </div>

    </nav>

     
            <div id="page-content">
               <!--=== Content Part ===-->
		<?php echo $this->Session->flash(); ?>		
		<?php echo $this->fetch('content'); ?>	    
		<!--=== End Content Part ===-->
            </div>           
        </div>
 
        
        <!--Page Footer-->
        <?php echo $this->element('footer');?>
        <!--end Page Footer-->
    </div>
    <!-- end Inner Wrapper -->
</div>
<!-- end Outer Wrapper-->

<!-- JS Global Compulsory -->			
<?php 
echo $this->Html->script('jquery-2.1.0.min.js');
echo $this->Html->script('before.load.js');?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;libraries=places"></script>
<?php 
echo $this->Html->script('jquery-migrate-1.2.1.min.js');
echo $this->Html->script('markerclusterer.js');
echo $this->Html->script('bootstrap.min.js');
echo $this->Html->script('richmarker-compiled.js');
echo $this->Html->script('smoothscroll.js');
echo $this->Html->script('infobox.js');
echo $this->Html->script('bootstrap-select.min.js');
echo $this->Html->script('icheck.min.js');
echo $this->Html->script('jquery.hotkeys.js');
echo $this->Html->script('jquery.mCustomScrollbar.concat.min.js');
echo $this->Html->script('jquery.nouislider.all.min.js');
echo $this->Html->script('custom.js');
echo $this->Html->script('bootstrap-switch.js');

echo $this->fetch('footer_js');
?>

<script>

</script>

<!--[if lte IE 9]>
<script type="text/javascript" src="js/ie-scripts.js"></script>
<![endif]-->
</body>
</html>