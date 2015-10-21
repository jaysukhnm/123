<!-- Map Canvas-->
<div class="map-canvas list-solid">
    <!-- Map -->
    <div class="map">
        <div class="toggle-navigation">
            <div class="icon">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </div>
        <!--/.toggle-navigation-->
        <div id="map" class="has-parallax"></div>
    </div>
    <!-- end Map -->
    <!--Items List-->
    <div class="items-list">
        <div class="inner">
            <div class="filter">
                <form class="main-search" role="form" method="post" action="?">
                    <header class="clearfix">
                        <h3 class="pull-left"><?php echo __('Search'); ?> </h3>                       
                    </header>                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type"><?php echo __('Name'); ?></label>
                                <select name="type" multiple title="All" data-live-search="true" id="type">
                                    <option value="1">Automobile</option>
                                    <option value="2" class="sub-category">Apparel</option>
                                    <option value="3" class="sub-category">Computers</option>
                                    <option value="4" class="sub-category">Nature</option>                                    
                                    <option value="6">Restaurant & Bars</option>
                                    <option value="7" class="sub-category">Bars</option>
                                    <option value="8" class="sub-category">Vegetarian</option>
                                    <option value="9" class="sub-category">Steak & Grill</option>
                                    <option value="10">Sports</option>
                                    <option value="11" class="sub-category">Cycling</option>
                                    <option value="12" class="sub-category">Water Sports</option>
                                    <option value="13" class="sub-category">Winter Sports</option>
                                </select>
                            </div>                           
                        </div>
                        <!--/.col-md-6-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="open"><?php echo __('Open Only'); ?></label>
                                <div>
                                    <input type="checkbox" class="switch" checked />
                                </div>  
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!--/.col-md-3-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="bathrooms"><?php echo __('Challenge Only'); ?></label>
                                <div>
                                    <input type="checkbox" class="switch" />
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!--/.col-md-3-->
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="location"><?php echo __('Location'); ?></label>
                                <div class="input-group location">
                                    <input type="text" class="form-control" id="location" placeholder="Enter Location">
                                    <span class="input-group-addon"><i class="fa fa-map-marker geolocation" data-toggle="tooltip" data-placement="bottom" title="Find my position"></i></span>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo __('Radious'); ?></label>
                                <div class="ui-slider" id="price-slider" data-value-min="0.1" data-value-max="100" data-value-type="radious" data-currency="km" data-currency-placement="after">
                                    <div class="values clearfix">
                                        <input class="value-min" name="value-min[]" readonly>
                                        <input class="value-max" name="value-max[]" readonly>
                                    </div>
                                    <div class="element"></div>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!--/.col-md-6-->
                    </div>
                    <!--/.row-->
                </form>
                <!-- /.main-search -->
            </div>
            <!--end Filter-->
            <header class="clearfix">
                <h3 class="pull-left">Results</h3>
                <div class="buttons pull-right">
                    <span>Display:</span>
                    <span class="icon active" id="display-grid"><i class="fa fa-th"></i></span>
                    <span class="icon" id="display-list"><i class="fa fa-th-list"></i></span>
                </div>
            </header>
            <ul class="results grid">

            </ul>
        </div>
        <!--results-->
    </div>
    <!--end Items List-->
</div>

<!--Featured-->
<section id="featured" class="block background-color-white">
    <div class="container">
        <header><h2><?php echo __('Coupons'); ?></h2></header>
        <div class="row coupons">
            <?php
            if (!empty($coupons)):
                foreach ($coupons as $c):
                    ?>
                    <div class="col-md-3 col-sm-3">
                        <div class="item featured equal-height">
                            <div class="image">
                                <div class="quick-view"><i class="fa fa-eye"></i><span><?php echo __('Quick View'); ?></span></div>
                                <a href="real-estate-item-detail.html">

                                    <div class="overlay">
                                        <div class="inner">
                                            <div class="content">

                                                <div class="couponsContent left">
                                                    <div class="block">
                                                        <div class="icon"><i class="fa fa-th-list"></i></div>
                                                        <div class="text"><?php echo isset($c['Coupon']['quantity']) ? $c['Coupon']['quantity'] : '0'; ?> <?php echo __('coupons available'); ?></div>
                                                    </div>
                                                    <div class="block">
                                                        <div class="icon"><i class="fa fa-clock-o"></i></div>
                                                        <div class="text">
                                                            <?php
                                                            $startTimeStamp = strtotime(date('Y-m-d H:i:s'));
                                                            $endTimeStamp = strtotime($c['Coupon']['end_date']);
                                                            $time = $endTimeStamp - $startTimeStamp;
                                                            if ($time < 0):
                                                                $time = 0;
                                                            endif;
                                                            $numberDays = $time / 86400;  // 86400 seconds in one day
                                                            echo intval($numberDays) . " " . __('days left');
                                                            ?>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="coupon-address">
                                                    <h4><?php echo __('Address'); ?></h4>
                                                    <?php
                                                    if (strlen($c['Coupon']['address']) <= 150) {
                                                        echo $c['Coupon']['address'];
                                                    } else {
                                                        echo substr($c['Coupon']['address'], 0, 150) . '...';
                                                    }
                                                    ?>
                                                </div>

                                                <div class="coupon-description">
                                                    <h4><?php echo __('Description'); ?></h4>
                                                    <?php
                                                    if (strlen($c['Coupon']['description']) <= 150) {
                                                        echo $c['Coupon']['description'];
                                                    } else {
                                                        echo substr($c['Coupon']['description'], 0, 150) . '...';
                                                    }
                                                    ?>
                                                </div>


                                            </div>
                                        </div>
                                    </div>                           

                                    <?php
//                                $image_path = $back_end_webroot_path . 'uploads/' . $c['Coupon']['app_id'] . '/' . 'coupons' . '/' . $c['Coupon']['store_id'] . '/' . $c['Coupon']['id'] . '/' . $value['name'];
//				echo $this->Html->image('load.gif', array('data-src' => $image_path, 'alt' => __('coupons'), 'class' => 'coupon_image img-responsive img-bordered'));
                                    ?>
                                    <img src="img/items/real-estate/6.jpg" alt="">
                                </a>
                            </div>
                            <div class="wrapper">

                                <div class="coupon-price price">
                                    <div class="pull-right rounded priceBox">					    
                                        <label class="label-danger label-block"><?php echo!empty($c['Coupon']['discount_price']) ? $c['Coupon']['discount_price'] : '0'; ?> &euro;</label> 
                                        <label class="label-block line-through font-color-grey"><?php echo!empty($c['Coupon']['product_price']) ? $c['Coupon']['product_price'] : '0'; ?> &euro;</label>
                                    </div>
                                </div>

                                <div class="discount-amount">
                                    <?php
                                    $discount = isset($c['Coupon']['final_discounted_price']) ? $c['Coupon']['final_discounted_price'] : '0';
                                    if ($discount < 0):
                                        $sign = "+";
                                    else:
                                        $sign = "-";
                                    endif;
                                    if (isset($c['Coupon']['discount_type']) && $c['Coupon']['discount_type'] == '1'):
                                        echo $sign . round($discount) . " %" . ' &euro;';
                                    else:
                                        echo $sign . $discount . ' &euro;';
                                    endif;
                                    ?>
                                </div>

                                <a href="real-estate-item-detail.html">
                                    <h3 class="coupon-name">
                                        <?php
                                        //echo $c['Coupon']['name'];
                                        if (strlen($c['Coupon']['name']) <= 40) {
                                            echo $c['Coupon']['name'];
                                        } else {
                                            $s = substr($c['Coupon']['name'], 0, 40);
                                            $result = substr($c['Coupon']['name'], 0, strrpos($c['Coupon']['name'], ' '));
                                            echo $result . '...';
                                        }
                                        ?>
                                    </h3>
                                </a>
                                <figure>
                                    <?php
                                    //echo $c['Store']['name']; 
                                    if (strlen($c['Store']['name']) <= 35) {
                                        echo $c['Store']['name'];
                                    } else {
                                        $s = substr($c['Store']['name'], 0, 35);
                                        $result = substr($c['Store']['name'], 0, strrpos($c['Store']['name'], ' '));
                                        echo $result . '...';
                                    }
                                    ?>
                                </figure>
                                <!--                                <div class="price">$42.000</div>-->

                            </div>
                        </div>              
                    </div>   
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
<!--end Featured-->
<!--Recent-->
<section id="recent" class="block">
    <div class="container">
        <header><h2>Recent</h2></header>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="item list">
                    <div class="image">
                        <div class="quick-view" id='1'><i class="fa fa-eye"></i><span>Quick View</span></div>
                        <a href="real-estate-item-detail.html">
                            <div class="overlay">
                                <div class="inner">
                                    <div class="content">
                                        <h4>Description</h4>
                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item-specific">
                                <span title="Bedrooms"><img src="img/bedrooms.png" alt="">2</span>
                                <span title="Bathrooms"><img src="img/bathrooms.png" alt="">2</span>
                                <span title="Area"><img src="img/area.png" alt="">240m<sup>2</sup></span>
                                <span title="Garages"><img src="img/garages.png" alt="">1</span>
                            </div>
                            <img src="img/items/real-estate/10.jpg" alt="">
                        </a>
                    </div>
                    <div class="wrapper">
                        <a href="real-estate-item-detail.html"><h3>431 Hardman Road</h3></a>
                        <figure>Brattleboro</figure>
                        <div class="price">$82.000</div>
                        <div class="info">
                            <div class="type">
                                <i><img src="img/icons/real-estate/apartment-3.png" alt=""></i>
                                <span>Apartment</span>
                            </div>
                            <div class="rating" data-rating="4"></div>
                        </div>
                    </div>
                </div>
                <!-- /.item-->
            </div>
            <!--/.col-md-6-->
            <div class="col-md-6 col-sm-6">
                <div class="item list">
                    <div class="image">
                        <div class="quick-view coupon-quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                        <a href="real-estate-item-detail.html">
                            <div class="overlay">
                                <div class="inner">
                                    <div class="content">
                                        <h4>Description</h4>
                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item-specific">
                                <span title="Bedrooms"><img src="img/bedrooms.png" alt="">2</span>
                                <span title="Bathrooms"><img src="img/bathrooms.png" alt="">2</span>
                                <span title="Area"><img src="img/area.png" alt="">240m<sup>2</sup></span>
                                <span title="Garages"><img src="img/garages.png" alt="">1</span>
                            </div>
                            <img src="img/items/real-estate/7.jpg" alt="">
                        </a>
                    </div>
                    <div class="wrapper">
                        <a href="real-estate-item-detail.html"><h3>4282 River Road</h3></a>
                        <figure>Springfield</figure>
                        <div class="price">$57.000</div>
                        <div class="info">
                            <div class="type">
                                <i><img src="img/icons/real-estate/apartment-3.png" alt=""></i>
                                <span>Apartment</span>
                            </div>
                            <div class="rating" data-rating="4"></div>
                        </div>
                    </div>
                </div>
                <!-- /.item-->
            </div>
            <!--/.col-md-6-->
            <div class="col-md-6 col-sm-6">
                <div class="item list">
                    <div class="image">
                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                        <a href="real-estate-item-detail.html">
                            <div class="overlay">
                                <div class="inner">
                                    <div class="content">
                                        <h4>Description</h4>
                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item-specific">
                                <span title="Bedrooms"><img src="img/bedrooms.png" alt="">2</span>
                                <span title="Bathrooms"><img src="img/bathrooms.png" alt="">2</span>
                                <span title="Area"><img src="img/area.png" alt="">240m<sup>2</sup></span>
                                <span title="Garages"><img src="img/garages.png" alt="">1</span>
                            </div>
                            <img src="img/items/real-estate/9.jpg" alt="">
                        </a>
                    </div>
                    <div class="wrapper">
                        <a href="real-estate-item-detail.html"><h3>2543 Fairfax Drive</h3></a>
                        <figure>Elizabeth</figure>
                        <div class="price">$486.000</div>
                        <div class="info">
                            <div class="type">
                                <i><img src="img/icons/real-estate/apartment-3.png" alt=""></i>
                                <span>Apartment</span>
                            </div>
                            <div class="rating" data-rating="4"></div>
                        </div>
                    </div>
                </div>
                <!-- /.item-->
            </div>
            <!--/.col-md-6-->
            <div class="col-md-6 col-sm-6">
                <div class="item list">
                    <div class="image">
                        <div class="quick-view"><i class="fa fa-eye"></i><span>Quick View</span></div>
                        <a href="real-estate-item-detail.html">
                            <div class="overlay">
                                <div class="inner">
                                    <div class="content">
                                        <h4>Description</h4>
                                        <p>Curabitur odio nibh, luctus non pulvinar a, ultricies ac diam. Donec neque massa</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item-specific">
                                <span title="Bedrooms"><img src="img/bedrooms.png" alt="">2</span>
                                <span title="Bathrooms"><img src="img/bathrooms.png" alt="">2</span>
                                <span title="Area"><img src="img/area.png" alt="">240m<sup>2</sup></span>
                                <span title="Garages"><img src="img/garages.png" alt="">1</span>
                            </div>
                            <img src="img/items/real-estate/11.jpg" alt="">
                        </a>
                    </div>
                    <div class="wrapper">
                        <a href="real-estate-item-detail.html"><h3>3295 Valley Street</h3></a>
                        <figure>Collingswood</figure>
                        <div class="price">$42.000</div>
                        <div class="info">
                            <div class="type">
                                <i><img src="img/icons/real-estate/apartment-3.png" alt=""></i>
                                <span>Apartment</span>
                            </div>
                            <div class="rating" data-rating="4"></div>
                        </div>
                    </div>
                </div>
                <!-- /.item-->
            </div>
            <!--/.col-md-6-->
        </div>
        <!--/.row-->
    </div>
    <!--/.container-->
</section>
<!--end Recent-->
<!--Promotion-->
<section class="block banner center">
    <div class="container">
        <h2 class="big">Submit Your Property Today!</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum molestie ex vulputate, fermentum ipsum eget</p>
        <a href="submit.html" class="btn btn-default">Submit now</a>
    </div>
    <div class="background">
        <img src="img/real-estate-bg.png" alt="">
    </div>
</section>
<!--end Promotion-->



<?php
$this->start('footer_js');
echo $this->Html->script('views/stores.js');
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        $("input.switch").bootstrapSwitch();
        var _latitude = 45.7611;
        var _longitude = 4.83509;
//    var jsonPath = 'js/json/real-estate.json.txt';
        var jsonPath = '/homes/index.json';

        // Load JSON data and create Google Maps

        $.getJSON(jsonPath)
                .done(function (json) {
                    createHomepageGoogleMap(_latitude, _longitude, json);
                })
                .fail(function (jqxhr, textStatus, error) {
                    console.log(error);
                })
                ;

        // Set if language is RTL and load Owl Carousel

        $(window).load(function () {
            var rtl = false; // Use RTL
            initializeOwl(rtl);
        });

        autoComplete();

    });


</script>
<?php $this->end(); ?>
