<!DOCTYPE html>
<html lang="en">
<!-- auth-login.php  August 12 , 2020 03:49:32 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>E-BLENDS : Auth Login</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/app.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bundles/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bundles/izitoast/css/iziToast.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />
</head>
<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">
			        <?php if(isset($_GET['error'])){ echo '<div class="alert alert-warning"> Error ! Account not found! <br>Please Try Again!</div>'; } ?>
                <form id="login">
                  <div class="form-group">
                    <label for="email">Email Address :</label>
                    <input id="username" type="text" class="form-control"  tabindex="1" required autofocus style="text-align:center;" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password : </label>
                      <div class="float-right">
                        <a href="auth-forgot-password.html" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="password"  type="password" class="form-control" tabindex="2" required style="text-align:center;" autocomplete="off">
                  </div>
                
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">  Login </button>
                  </div>
                </form>
              <div class="mt-5 text-muted text-center">
              Don't have an account? <a href="<?php echo site_url('register');?>">Create One</a> <br>
            </div>
          </div>
        </div>
      </div>
    </section>
  <button class="btn btn-primary" id="toastr-login" style="display:none;"></button>
  <button class="btn btn-primary" id="success-login" style="display:none;"></button>
  <button class="btn btn-primary" id="error-login" style="display:none;"></button>
  </div>
  <script>var UrlLink = <?php echo json_encode(base_url()); ?>;</script>
  <!-- General JS Scripts -->
  <script src="<?php echo base_url();?>assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <script src="<?php echo base_url();?>assets/bundles/izitoast/js/iziToast.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="<?php echo base_url();?>assets/js/page/toastr.js"></script>
  <!-- Template JS File -->
  <script src="<?php echo base_url();?>assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="<?php echo base_url();?>assets/js/auth.js"></script>

</body>
<!-- auth-login.php  August 12 , 2020 03:49:32 GMT -->
</html>