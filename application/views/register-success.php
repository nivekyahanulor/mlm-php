<!DOCTYPE html>
<html lang="en">
	  <head>
	  <meta charset="UTF-8">
	  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	  <title>E-BLENDS SYSTEM :  Regsiter</title>
	  <!-- General CSS Files -->
	  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/app.min.css">
	  <link rel="stylesheet" href="<?php echo base_url();?>assets/bundles/jquery-selectric/selectric.css">
	  <!-- Template CSS -->
	  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
	  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/components.css">
	  <!-- Custom style CSS -->
	  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css">
	  <link rel='shortcut icon' type='image/x-icon' href='<?php echo base_url();?>assets/img/favicon.ico' />
	</head>
		<div style="height:40px"></div>
        <section class="">
          <div class="section-body">
            <div class="row  justify-content-center">
              <div class="col-10 col-md-7 col-lg-7">
                <div class="card">
                  <div class="card-header">
				  <h4>E-BLENDS SYSTEM</h4>
                  </div>
                  <div class="card-body">
				  <div class="row">
					 <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                      <center><img class="" src="<?php echo base_url();?>assets/img/logo.png" alt="Generic placeholder image" width="200px"></center>
					  </div>
					   <div class="col-12 col-sm-6 col-md-6 col-lg-6">
							<h5 class="mt-0">WELCOME TO EMPATHY BL3ND  SYSTEM</h5>
							<hr>
							<b> LOGIN DETAILS : </b><br><br>
							<p class="mb-0"> Email    : <?php echo base64_decode(urldecode($this->uri->segment(4)));?></p>
							<p class="mb-0"> Password : <?php echo base64_decode(urldecode($this->uri->segment(3)));?></p>
							<hr>
							<p class="mb-0"> Thank You for Registering in Empathy Bl3nd. <br> You can now Login using your Account Details!</p>
							
							<div style="height:50px"></div>
							<p class="mb-0"><center> <a href="<?php echo site_url('welcome');?>"><button class=" btn btn-info btn-md"><i class="fas fa-sign-out-alt"></i> LOGIN TO YOUR ACCOUNT</button></a></p>
                      </div>
                  </div>
                  </div>
                </div>
			</div>
		</div>
	 </section>
