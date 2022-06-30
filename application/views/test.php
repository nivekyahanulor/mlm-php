<a href="javascript:void(0);" onclick="fbLogin();" id="fbLink"  class="btn btn-block btn-social btn-facebook"><span class="fab fa-facebook"></span> Facebook</a>
<script type="text/javascript" src="https://www.raymond-reed.com/assets/js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="https://www.raymond-reed.com/assets/js/jquery.min.js"></script>
<script>
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
				   url:urllink+'auth_fb',
				   data : {
							 'emailaddress'     : response.email, 
					},
				   success: function(data)
				   {
					if(data=='success'){
						 window.location.href = "user/index";
					} else {
						 window.location.href = "welcome?error";
					}
				   }
			   });
		});
	}

</script>