<div class="wrapper">
    <div class="main-navigation navigation-top-header">
        <ul>
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
        </ul>
        <!--[if lte IE 9]>
        <script type="text/javascript" src="js/ie-scripts.js"></script>
        <![endif]-->
    </div>
    <ul class="user-area">
        <li><a href="sign-in.html">Sign In</a></li>
        <li><a href="register.html"><strong>Register</strong></a></li>
        
        <li><a class="" data-toggle="modal" data-target="#loginModal">Sign In</a></li>
        <li><a class="" data-toggle="modal" data-target="#signupModal">Register</a></li>
    </ul>
    <a href="submit.html" class="submit-item">
        <div class="content"><span>Submit Your Item</span></div>
        <div class="icon">
            <i class="fa fa-plus"></i>
        </div>
    </a>
    <div class="toggle-navigation" style="display: none;">
        <div class="icon">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </div>
</div>


