<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li> <div style="height:10px;"></div><h5> ADMINISTRATOR</h5></li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="<?php echo base_url();?>/assets/img/icon.png"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Hello <?php echo $this->session->userdata['logged_in']['name'];?></div>
              <a href="<?php echo site_url('administrator/settings/payment_options');?>" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?php echo site_url('administrator/logout');?>" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
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
            <li class="menu-header"><center>NAVIGATION MENU</center></li>
              <?php
              $page = $this->uri->segment(2);
              if($page =='index'){ $index = 'active';}
              else if($page =='packages'){ $packages = 'active';}
              else if($page =='products'){ $products = 'active';}
              else if($page =='members'){ $members = 'active';}
              else if($page =='payments'){ $payments = 'active';}
              else if($page =='withdrawal'){ $withdrawal = 'active';}
              else if($page =='reports'){ $reports = 'active';}
              else if($page =='expenses'){ $expenses = 'active';}
              else if($page =='settings'){ $settings = 'active';}
              ?>
            <li class="dropdown <?php echo $index;?>">
              <a href="<?php echo site_url('administrator/index');?>"" class="nav-link"><i data-feather="monitor"></i><span>DASHBOARD</span></a>
            </li>
			<li class="dropdown <?php echo $packages;?>">
              <a href="<?php echo site_url('administrator/packages');?>" class="nav-link"><i data-feather="shopping-bag"></i><span>PACKAGES  </span></a>
            </li>

      <li class="dropdown <?php echo $products;?>">
              <a href="<?php echo site_url('administrator/products');?>" class="nav-link"><i data-feather="shopping-bag"></i><span>PRODUCTS  </span></a>
            </li>
			<li class="dropdown <?php echo $members;?>">
              <a href="<?php echo site_url('administrator/members');?>" class="nav-link"><i data-feather="user-check"></i><span>MEMBERS</span></a>
            </li>
			<li class="dropdown <?php echo $payments;?>">
              <a href="<?php echo site_url('administrator/payments');?>" class="nav-link"><i data-feather="star"></i><span>PAYMENTS <div class="badge badge-pill badge-danger mb-1 float-right"><?php echo $paycount;?></div></span></a>
            </li>
			<li class="dropdown <?php echo $withdrawal;?>">
              <a href="<?php echo site_url('administrator/withdrawal');?>" class="nav-link"><i data-feather="flag"></i><span>WITHDRAWAL <div class="badge badge-pill badge-danger mb-1 float-right"><?php echo $wrcount;?></div></span></a>
            </li>
			<li class="dropdown <?php echo $reports;?>">
							<a href="#" class="menu-toggle nav-link has-dropdown"><i
									data-feather="monitor"></i><span>REPORTS</span></a>
							<ul class="dropdown-menu">
								<li><a class="nav-link" href="<?php echo site_url('administrator/reports/sales');?>">SALES</a></li>
								<li><a class="nav-link" href="<?php echo site_url('administrator/reports/withdrawals');?>">WITHDRAWAL</a></li>
							</ul>
						</li>
            </li>
			<li class="dropdown <?php echo $expenses;?>">
              <a href="<?php echo site_url('administrator/expenses');?>" class="nav-link"><i data-feather="clipboard"></i><span>EXPENSES</span></a>
            </li>
			<li class="dropdown <?php echo $settings;?>">
							<a href="#" class="menu-toggle nav-link has-dropdown"><i
									data-feather="settings"></i><span>SETTINGS</span></a>
							<ul class="dropdown-menu">
								<li><a class="nav-link" href="<?php echo site_url('administrator/settings/admin_accounts');?>">ADMIN ACCOUNTS</a></li>
								<li><a class="nav-link" href="<?php echo site_url('administrator/settings/payment_options');?>">PAYMENT OPTIONS</a></li>
								<li><a class="nav-link" href="<?php echo site_url('administrator/settings/system_settings');?>">SYSTEM</a></li>
							</ul>
						</li>
            </li>
			<li class="dropdown ">
              <a href="<?php echo site_url('administrator/logout');?>" class="nav-link"><i data-feather="arrow-right-circle"></i><span>LOGOUT</span></a>
            </li>
          </ul>
        </aside>
      </div>