$(document).ready(function() {
var urllink = UrlLink;
  $('#login').submit(function(e) {
	 var u = $('#username').val();
	 var p = $('#password').val();
		e.preventDefault();
			$('#errorlogin').html('<br><div class="alert alert-warning"> <center><i class="fa fa-spinner fa-spin"></i> Requesting for Login ... </center></strong></center></div>');
			$('#loginform').hide();
			setTimeout(function() {
			$.ajax({
			   type: "POST",
			   url:urllink+'/api/login_user',
			   data : {
						 'u'     : u, 
						 'p'     : p,
					
				},
			   success: function(data)
			   {
				if(data=='success'){
					$('#errorlogin').html('<br><div class="alert alert-info"><strong><center>SUCCESS!</strong> <br> <i class="fa fa-spinner fa-spin"></i> Redirecting to Account ... </center></strong></div>');
					setTimeout(function() {
					  window.location.href = "admin?page=myaccount";
					}, 3000);
				} else {
					$('#errorlogin').html('<br><div class="alert alert-warning"><strong><center>ERROR!</strong> PLEASE TRY AGAIN! </center></strong></div>');
					setTimeout(function() {
					  window.location.href = "admin";
					}, 2000);
				}
			   }
		   });
		 }, 3000);

	});


});
	