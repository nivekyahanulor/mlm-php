<!DOCTYPE html>
<html lang="en">

<!-- auth-login.php  August 12 , 2020 03:49:32 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>EMPATHY :  REGISTRATION FORM</title>
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
                <form method="POST" action="<?php echo site_url('auth_register_v');?>">
				        <div class="row">
                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                      <label for="frist_name">Refferal Name :</label>
                      <select class="js-example-basic-single form-control" id="referralcode" name="referralcode" data-live-search="true" required>
                                                            <option value="">Select Member </option>
                                                            <?php
                                                            foreach ($members as $row) {
																if($row->memberType ==1){
																	echo '<option value="' . $row->member_code . '">' . $row->firstname .' '. $row->lastname . ' - MC</option>';
																} else if($row->memberType ==2){
																	echo '<option value="' . $row->member_code . '">' . $row->firstname .' '. $row->lastname . ' - MS</option>';
																} else {
																	echo '<option value="' . $row->member_code . '">' . $row->firstname .' '. $row->lastname . '</option>';
																}
                                                            }
                                                            ?>
                      </select>
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
                    <label for="email">Account Type  : </label>
                    <select name="membertype" class="form-control" required>
                      <option value=""> - Select Account Type - </option>
                      <option value="0"> Member </option>
                      <option value="1"> Mega </option>
                      <option value="2"> Stockist </option>
                    </select>
                    <div class="invalid-feedback">
                    </div>
                  </div>
                  </div>
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
				 
                  </div>
                </form>
              </div>
             
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script>var urllink = <?php echo json_encode(base_url()); ?>;</script>
  <script src="<?php echo base_url();?>assets/js/app.min.js"></script>
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


	</script>
</body>


<!-- auth-login.php  August 12 , 2020 03:49:32 GMT -->
</html>