var urllink = UrlLink;
$('#login').submit(function(e) {
	$('#toastr-login').trigger('click');
	$('#content').hide();
	$('.btn').prop('disabled', true);
	 var username     = $('#username').val();
	 var password     = $('#password').val();
		e.preventDefault();
			setTimeout(function() {
			$.ajax({
			   type: "POST",
			   url:urllink+'auth',
			   data : {
						 'username'     : username, 
						 'password'     : password,
				},
			   success: function(data)
			   {
				    if(data =='user'){
					    $(".iziToast-wrapper").show();
						$('#success-login').trigger('click');
						setTimeout(function() {  window.location.href = "user/index";}, 1000);
				    } else if(data =='admin'){
						$(".iziToast-wrapper").show();
						$('#success-login').trigger('click');
						setTimeout(function() {window.location.href = "administrator/index"; }, 1000);
				    } else {
						$('#error-login').trigger('click');		
						$('.btn').prop('disabled', false);
				   }
			   }
		   });
		}, 3000);
   
}); 