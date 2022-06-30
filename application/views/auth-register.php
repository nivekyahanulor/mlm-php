<!DOCTYPE html>
<html lang="en">

<!-- auth-login.php  August 12 , 2020 03:49:32 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>E-BLENDS :  REGISTRATION FORM</title>
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
<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Register</h4>
              </div>
              <div class="card-body">
				<?php echo $error ?>
				<?php echo $error_username ?>
                <form method="POST" action="<?php echo site_url('auth_register');?>">
				  <div class="row">
				  
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                      <label for="frist_name">Referral Code :</label>
					  <?php if(isset($_GET['code'])){?>
                      <input type="text" class="form-control" name="referralcode" id="referralcode" value="<?php if(isset($_GET['code'])){ echo $_GET['code'];}?>" readonly placeholder="Please Enter Referral Code"  required> 
					  <?php } else {?>
					  <input type="text" class="form-control" name="referralcode"  id="referralcode" value="<?php if(isset($_GET['code'])){ echo $_GET['code'];}?>" readonly placeholder="Please Enter Referral Code"  required> 
					  <?php } ?>
				   </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                      <label for="frist_name">First Name :</label>
                      <input type="text" class="form-control" name="firstname" autofocus required autocomplete="off"> 
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                      <label for="last_name">Last Name : </label>
                      <input  type="text" class="form-control" name="lastname" required autocomplete="off">
                    </div>
                  </div>
				  <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <label for="email">Email Address : </label>
                    <input name="emailaddress" type="email" class="form-control" required autocomplete="off">
                    <div class="invalid-feedback">
                    </div>
                  </div> 
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <label for="email">Contact Number : </label>
                    <input name="contactnumber" type="text" class="form-control" maxlength="12" required autocomplete="off" onkeypress="return isNumber(event)" >
                    <div class="invalid-feedback">
                    </div>
                  </div>
                  </div>
				  <strong> ACCOUNT DETAILS : </strong><hr>
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                      <label for="password" class="d-block">Password :</label>
                      <input name="password" type="password" class="form-control pwstrength" id="password" data-indicator="pwindicator" required autocomplete="off">
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                      <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                      <label for="password2" class="d-block">Re-type Password : </label>
                      <input name="retype" type="password" id="retype" class="form-control"  required autocomplete="off">
					   <div id="pwmatching"></div>
                    </div>
                  </div>
                 
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="agree" class="custom-control-input" id="agree" required >
                      <label class="custom-control-label" for="agree">I agree with the <a href=""> terms and conditions </a></label>
                    </div>
                  </div>
				   <div class="row">
                
				  <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <button type="submit" class="btn btn-register btn-primary btn-lg btn-block">
                      Register
                    </button>
                  </div>
				    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <button type="button" ref="javascript:void(0);" onclick="fbLogin();" id="fbLink"  class="btn"><span class="fab fa-facebook"></span>
                      Register using Facebook
                    </button>
                  </div> 
                  </div>
                </form>
              </div>
              <div class="mb-4 text-muted text-center">
                Already Registered? <a href="<?php echo site_url('welcome');?>">Login</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script>var urllink = <?php echo json_encode(base_url()); ?>;</script>
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="<?php echo base_url();?>assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="<?php echo base_url();?>assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="<?php echo base_url();?>assets/js/page/auth-register.js"></script>
  <!-- Template JS File -->
  <script src="<?php echo base_url();?>assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="<?php echo base_url();?>assets/js/numberonly.js"></script>
  <script>
	$( "#retype" ).change(function() {
		var rtype    = $( "#retype" ).val();
		var password = $( "#password" ).val();
		if(password != rtype){
		  $("#pwmatching").html("<font color='red'>Not match to Password!</font>");
		  $("#fbLink").attr("disabled",true);
		  $(".btn-register").attr("disabled",true);
		}else {
		  $("#pwmatching").html("");
		  $("#fbLink").attr("disabled",false);
		  $(".btn-register").attr("disabled",false);
		}
	});
  var  referralcode = $("#referralcode").val();
	  if(referralcode == ''){
		  $("#fbLink").attr("disabled",true);
		  $(".btn-register").attr("disabled",true);
	  } else {
		  $("#fbLink").attr("disabled",false);
		  $(".btn-register").attr("disabled",false);
	  }
	window.fbAsyncInit = function() {
		// FB JavaScript SDK configuration and setup
		FB.init({
		  appId      : '251820659138995', // FB App ID
		  cookie     : true,  // enable cookies to allow the server to access the session
		  xfbml      : true,  // parse social plugins on this page
		  version    : 'v3.2' // use graph api version 2.8
		});
		
		// Check whether the user already logged in
		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				//display user data
				getFbUserData();
			}
		});
	};

	// Load the JavaScript SDK asynchronously
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	// Facebook login with JavaScript SDK
	function fbLogin() {
		FB.login(function (response) {
			if (response.authResponse) {
				// Get and display the user profile data
				getFbUserData();
			} else {
				document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
			}
		}, {scope: 'email'});
	}

	// Fetch the user profile data from facebook
	function getFbUserData(){
	
		FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
		function (response) {
			// document.getElementById('fbLink').setAttribute("onclick","fbLogout()");
			// document.getElementById('fbLink').innerHTML = 'Logout from Facebook';
			// document.getElementById('status').innerHTML = '<p>Thanks for logging in, ' + response.first_name + '!</p>';
			// document.getElementById('userData').innerHTML = '<h2>Facebook Profile Details</h2><p><img src="'+response.picture.data.url+'"/></p><p><b>FB ID:</b> '+response.id+'</p><p><b>Name:</b> '+response.first_name+' '+response.last_name+'</p><p><b>Email:</b> '+response.email+'</p><p><b>Gender:</b> '+response.gender+'</p><p><b>FB Profile:</b> <a target="_blank" href="'+response.link+'">click to view profile</a></p>';
			$.ajax({
				   type: "POST",
				   url:urllink+'auth_fb_register',
				   data : {
							 'emailaddress'  : response.email, 
							 'firstname'     : response.first_name, 
							 'lastname'      : response.last_name, 
							 'referralcode'  : referralcode, 
					},
				   success: function(data)
				   {
					   if(data=='erroremail'){
							window.location.href = "register?code="+referralcode + "&"+ "erroremail";
					   } else if(data=='error'){
							window.location.href = "register?code="+referralcode + "&"+"error";
					   } else {
						window.location.href = "register/success/" + data;
					   }
				   }
			   });
		});
	}

	</script>
</body>


<!-- auth-login.php  August 12 , 2020 03:49:32 GMT -->
</html>