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
            <nav class="off-canvas-navigation">
                <header>Navigation</header>
                <div class="main-navigation navigation-off-canvas"></div>
            </nav>            
            <div id="page-content">
               <!--=== Content Part ===-->
		<?php echo $this->Session->flash(); ?>		
		<?php echo $this->fetch('content'); ?>	    
		<!--=== End Content Part ===-->
            </div>           
        </div>
        
        <!--Page Footer-->
        <footer id="page-footer">
            <div class="inner">
                <div class="footer-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <!--New Items-->
                                <section>
                                    <h2>New Items</h2>
                                    <a href="real-estate-item-detail.html" class="item-horizontal small">
                                        <h3>Cash Cow Restaurante</h3>
                                        <figure>63 Birch Street</figure>
                                        <div class="wrapper">
                                            <div class="image"><img src="img/items/1.jpg" alt=""></div>
                                            <div class="info">
                                                <div class="type">
                                                    <i><img src="img/icons/real-estate/apartment-3.png" alt=""></i>
                                                    <span>Restaurant</span>
                                                </div>
                                                <div class="rating" data-rating="4"></div>
                                            </div>
                                        </div>
                                    </a>
                                    <!--/.item-horizontal small-->
                                    <a href="real-estate-item-detail.html" class="item-horizontal small">
                                        <h3>Blue Chilli</h3>
                                        <figure>2476 Whispering Pines Circle</figure>
                                        <div class="wrapper">
                                            <div class="image"><img src="img/items/2.jpg" alt=""></div>
                                            <div class="info">
                                                <div class="type">
                                                    <i><img src="img/icons/real-estate/apartment-3.png" alt=""></i>
                                                    <span>Restaurant</span>
                                                </div>
                                                <div class="rating" data-rating="3"></div>
                                            </div>
                                        </div>
                                    </a>
                                    <!--/.item-horizontal small-->
                                </section>
                                <!--end New Items-->
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <!--Recent Reviews-->
                                <section>
                                    <h2>Recent Reviews</h2>
                                    <a href="real-estate-item-detail.html#reviews" class="review small">
                                        <h3>Max Five Lounge</h3>
                                        <figure>4365 Bruce Street</figure>
                                        <div class="info">
                                            <div class="rating" data-rating="4"></div>
                                            <div class="type">
                                                <i><img src="img/icons/restaurants-bars/restaurants/restaurant.png" alt=""></i>
                                                <span>Restaurant</span>
                                            </div>
                                        </div>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec non suscipit felis, sed sagittis tellus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras ac placerat mauris.
                                        </p>
                                    </a><!--/.review-->
                                    <a href="real-estate-item-detail.html#reviews" class="review small">
                                        <h3>Saguaro Tavern</h3>
                                        <figure>2476 Whispering Pines Circle</figure>
                                        <div class="info">
                                            <div class="rating" data-rating="5"></div>
                                            <div class="type">
                                                <i><img src="img/icons/restaurants-bars/restaurants/restaurant.png" alt=""></i>
                                                <span>Restaurant</span>
                                            </div>
                                        </div>
                                        <p>
                                            Pellentesque mauris. Proin sit amet scelerisque risus. Donec semper semper erat ut mollis curabitur
                                        </p>
                                    </a>
                                    <!--/.review-->
                                </section>
                                <!--end Recent Reviews-->
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <section>
                                    <h2>About Us</h2>
                                    <address>
                                        <div>Max Five Lounge</div>
                                        <div>63 Birch Street</div>
                                        <div>Granada Hills, CA 91344</div>
                                        <figure>
                                            <div class="info">
                                                <i class="fa fa-mobile"></i>
                                                <span>818-832-5258</span>
                                            </div>
                                            <div class="info">
                                                <i class="fa fa-phone"></i>
                                                <span>+1 123 456 789</span>
                                            </div>
                                            <div class="info">
                                                <i class="fa fa-globe"></i>
                                                <a href="#">www.maxfivelounge.com</a>
                                            </div>
                                        </figure>
                                    </address>
                                    <div class="social">
                                        <a href="#" class="social-button"><i class="fa fa-twitter"></i></a>
                                        <a href="#" class="social-button"><i class="fa fa-facebook"></i></a>
                                        <a href="#" class="social-button"><i class="fa fa-pinterest"></i></a>
                                    </div>

                                    <a href="contact.html" class="btn framed icon">Contact Us<i class="fa fa-angle-right"></i></a>
                                </section>
                            </div>
                            <!--/.col-md-4-->
                        </div>
                        <!--/.row-->
                    </div>
                    <!--/.container-->
                </div>
                <!--/.footer-top-->
                <div class="footer-bottom">
                    <div class="container">
                        <span class="left">(C) ThemeStarz, All rights reserved</span>
                            <span class="right">
                                <a href="#page-top" class="to-top roll"><i class="fa fa-angle-up"></i></a>
                            </span>
                    </div>
                </div>
                <!--/.footer-bottom-->
            </div>
        </footer>
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