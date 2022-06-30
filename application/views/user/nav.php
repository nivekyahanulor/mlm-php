<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li> <div style="height:10px;"></div><h5> ACCOUNTS</h5></li>
          </ul>
        </div>
		<ul class="navbar-nav navbar-right">
					 <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
					  class="nav-link nav-link-lg message-toggle"><font color="blue">CART : </font> <i data-feather="shopping-cart"></i>
					  <span class="badge headerBadge1"><?php echo $cntorders;?> </span> </a>
						<div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
						<div class="dropdown-header"> ORDER LIST</div>
					  <div class="dropdown-list-content dropdown-list-message">
					  <?php foreach($orders as $a => $b){?>
						<a href="#" class="dropdown-item"> 
							<span class="dropdown-item-avatar text-white"> 
							<img alt="image" src="<?php echo base_url();?>assets/products/<?php echo $b->product_image;?>" class="rounded-circle">
							</span> 
							<span class="dropdown-item-desc"> <span class="message-user"><?php echo $b->product_name;?></span><br>
							<span class="time messege-text">Total : x <?php echo $b->purchasedQty;?> = <?php echo number_format($b->purchasedTotal,2);?></span>
						  </span>
						</a>
					  <?php } ?>
					  </div>
					  <div class="dropdown-footer text-center">
						<a href="<?php echo site_url('user/checkout');?>">CHECKOUT <i class="fas fa-chevron-right"></i></a>
					  </div>
					</div>
				  </li>
					<li class="dropdown"><a href="#" data-toggle="dropdown"
						  class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="<?php echo base_url();?>assets/img/icon.png"
							class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
						<div class="dropdown-menu dropdown-menu-right pullDown">
						  <div class="dropdown-title">Hello <?php echo $this->session->userdata['logged_in']['name'];?></div>
						  <a href="<?php echo site_url('user/profile');?>" class="dropdown-item has-icon"><i class="far fa-user"></i> Profile
						  <div class="dropdown-divider"></div>
						  <a href="<?php echo site_url('user/logout');?>" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
							Logout
						  </a>
						</div>
					</li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="#"> <img alt="image" src="<?php echo base_url();?>/assets/img/logo.png" class="header-logo" /> <span
                class="logo-name">E-BLENDS</span>
            </a>
          </div>
          <ul class="sidebar-menu">
			<?php
			$page = $this->uri->segment(2);
			$code = $this->session->userdata['logged_in']['code'];
			if($page =='index'){ $index = 'active';}
			else if($page =='packages'){ $packages = 'active';}
			else if($page =='products'){ $products = 'active';}
			else if($page =='myproducts'){ $myproducts = 'active';}
			else if($page =='wallet'){ $wallet = 'active';}
			else if($page =='wallet'){ $wallet = 'active';}
			else if($page =='genealogy'){ $genealogy = 'active';}
			else if($page =='referrals'){ $genealogy = 'active';}
			else if($page =='profile'){ $profile = 'active';}
			
			?>
            <li class="menu-header"><center>Welcome : <?php echo $this->session->userdata['logged_in']['name'];?></center></li>
            <li class="dropdown  <?php echo $index;?>"><a href="<?php echo site_url('user/index');?>" class="nav-link"><i data-feather="monitor"></i><span>DASHBOARD</span></a></li>
		    <li class="dropdown  <?php echo $products;?>"><a href="<?php echo site_url('user/products');?>" class="nav-link"><i data-feather="shopping-bag"></i><span>PRODUCTS</span></a></li>
			<?php if($this->session->userdata['logged_in']['userid'] !=1){?>
				<?php if($this->session->userdata['logged_in']['member_type'] ==1 || $this->session->userdata['logged_in']['member_type'] ==2){?>
				<li class="dropdown  <?php echo $packages;?>"><a href="<?php echo site_url('user/packages/mega');?>" class="nav-link"><i data-feather="shopping-bag"></i><span>PACKAGES</span></a></li>
			<?php }  else {?>
				<li class="dropdown  <?php echo $packages;?>"><a href="<?php echo site_url('user/packages');?>" class="nav-link"><i data-feather="shopping-bag"></i><span>PACKAGES</span></a></li>
			<?php } } ?>
			<li class="dropdown  <?php echo $myproducts;?>"><a href="<?php echo site_url('user/myproducts/purchased');?>" class="nav-link"><i data-feather="clipboard"></i><span>  PURCHASED HISTORY </span></a></li>
			<li class="dropdown  <?php echo $wallet;?>"><a href="<?php echo site_url('user/wallet');?>" class="nav-link"><i data-feather="book"></i><span>WALLET</span></a></li>
		    <li class="dropdown  <?php echo $genealogy;?>"><a href="<?php echo site_url('user/genealogy');?>" class="menu-toggle nav-link has-dropdown"><i data-feather="users"></i><span>NETWORK</span></a>
			<ul class="dropdown-menu">
                <li><a class="nav-link" href="<?php echo site_url("user/genealogy/binary_tree?data=".$code);?>" target="_blank">BINARY TREE</a></li>
                <li><a class="nav-link" href="<?php echo site_url('user/genealogy/index');?>">DIRECT</a></li>
              </ul>
			</li>
		    <li class="dropdown  <?php echo $profile;?>"><a href="<?php echo site_url('user/profile');?>" class="nav-link"><i data-feather="user"></i><span>PROFILE</span></a></li>
		    <li class="dropdown"><a href="<?php echo site_url('user/logout');?>" class="nav-link"><i data-feather="log-out"></i>LOGOUT</a></li>
          </ul>
        </aside>
      </div>