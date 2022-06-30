$(document).ready(function() {
var urllink = UrlLink;
//** ADD MINUS ORDER CART ** //
$('.btn-number').click(function(e){
    e.preventDefault();
    id        = $(this).attr('data-id');
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
				$.ajax({
					data: {'orderID': id , 'qty':1 ,},
					type: "post",
					url:urllink+'/minusorder',
					success: function(response){
						location.reload();
					}
				});
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {
			$.ajax({
					data: {'orderID': id , 'qty':1 ,},
					type: "post",
					url:urllink+'/plusorder',
					success: function(response){
						location.reload();
					}
				});
            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
	


//*** Inc Desc ***//
$(".quantity_incs").on("click", function (e) {
        var $button = $(this);
		id        = $(this).attr('data-prodid');
        var oldValue = $('.quantity'+id).val();
        $button.parent().find('.incr-btn[data-action="decrease"]').removeClass('inactive');
        if ($button.data('action') == "increase") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below 1
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
                $button.addClass('inactive');
            }
        }
        $('.quantity'+id).val(newVal);
        e.preventDefault();
    });

//** END ** //

$(".quantity_inc").on("click", function (e) {
        var $button   = $(this);
        var oldValue  = $('.quantity').val();
        $button.parent().find('.incr-btn[data-action="decrease"]').removeClass('inactive');
        if ($button.data('action') == "increase") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below 1
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
                $button.addClass('inactive');
            }
        }
        $('.quantity').val(newVal);
        e.preventDefault();
    });


$('#register-customer').submit(function(e) {
	 $('#sendingrequest').html('<center><font size="3"><i class="fa fa-spinner fa-spin"></i> Registering Account Information ...</font></center>');
	 $('#content').hide();
	 var firtsname       = $('#firstname').val();
	 var lastname        = $('#lastname').val();
	 var emailaddress    = $('#emailaddress').val();
	 var contactnumber   = $('#contactnumber').val();
	 var username		 = $('#username').val();
	 var password    	 = $('#password').val();
	 var userip    	     = $('#userip').val();
  
		e.preventDefault();
		setTimeout(function() {
			$.ajax({
			   type: "POST",
			   url:urllink+'/api/register_customer',
			   data : {
						 'userIP'        : userip, 
						 'firtsname'     : firtsname,
						 'lastname'      : lastname,
						 'emailaddress'  : emailaddress,
						 'contactnumber' : contactnumber,
						 'username'      : username,
						 'password'      : password,
					
				},
			   success: function(data)
			   {
					$('#sendingrequest').html('<center><font size="3"><i class="fa fa-check"></i> Registering Account Success! <br><br> You may now Login using your Account Details <br><br> Thank You! <br><br> <a href="?login"><i class"fa fa-user"></i> LOGIN TO ACCOUNT </a> </font></center>');
			   }
		   });
		}, 3000);

}); 

$('#register-retailer').submit(function(e) {
	 $('#sendingrequest').html('<center><font size="3"><i class="fa fa-spinner fa-spin"></i> Registering Account Information ...</font></center>');
	 $('#content').hide();
	 var firtsname       = $('#firstname').val();
	 var lastname        = $('#lastname').val();
	 var emailaddress    = $('#emailaddress').val();
	 var contactnumber   = $('#contactnumber').val();
	 var username		 = $('#username').val();
	 var password    	 = $('#password').val();
	 var province    	 = $('#province-dropdown').val();
	 var city    	     = $('#cities-dropdown').val();
		e.preventDefault();
		setTimeout(function() {
			$.ajax({
			   type: "POST",
			   url:urllink+'/api/register_retailer',
			   data : {
						 'firtsname'     : firtsname,
						 'lastname'      : lastname,
						 'emailaddress'  : emailaddress,
						 'contactnumber' : contactnumber,
						 'username'      : username,
						 'password'      : password,
						 'province'      : province,
						 'city'          : city,
				},
			   success: function(data)
			   {
					$('#sendingrequest').html('<center><font size="3"><i class="fa fa-check"></i> Registering Account Success! <br><br> Please wait for Administrator approval! <br><br> Email Confirmation will be send to your Registered Email Address ! <br><br> Thank You!</font></center>');
			   }
		   });
		}, 3000);

}); 
$('#register-distributor').submit(function(e) {
	 $('#sendingrequest').html('<center><font size="3"><i class="fa fa-spinner fa-spin"></i> Registering Account Information ...</font></center>');
	 $('#content').hide();
	 var firtsname       = $('#firstname').val();
	 var lastname        = $('#lastname').val();
	 var emailaddress    = $('#emailaddress').val();
	 var contactnumber   = $('#contactnumber').val();
	 var username		 = $('#username').val();
	 var password    	 = $('#password').val();
	 var province    	 = $('#province-dropdown').val();
	 var city    	     = $('#cities-dropdown').val();
  
		e.preventDefault();
		setTimeout(function() {
			$.ajax({
			   type: "POST",
			   url:urllink+'/api/register_distributor',
			   data : {
						 'firtsname'     : firtsname,
						 'lastname'      : lastname,
						 'emailaddress'  : emailaddress,
						 'contactnumber' : contactnumber,
						 'username'      : username,
						 'password'      : password,
						 'province'      : province,
						 'city'          : city,
				},
			   success: function(data)
			   {
					$('#sendingrequest').html('<center><font size="3"><i class="fa fa-check"></i> Registering Account Success! <br><br> Please wait for Administrator approval! <br><br> Email Confirmation will be send to your Registered Email Address ! <br><br> Thank You!</font></center>');
			   }
		   });
		}, 3000);

}); 
$('#register-delivery').submit(function(e) {
	 $('#sendingrequest').html('<center><font size="3"><i class="fa fa-spinner fa-spin"></i> Registering Account Information ...</font></center>');
	 $('#content').hide();
	 var firtsname       = $('#firstname').val();
	 var lastname        = $('#lastname').val();
	 var emailaddress    = $('#emailaddress').val();
	 var contactnumber   = $('#contactnumber').val();
	 var username		 = $('#username').val();
	 var password    	 = $('#password').val();
	 var license    	 = $('#license').val();
	 var service    	 = $('#servicettype-dropdown').val();
	 var platenumber     = $('#platenumber').val();
	 var model           = $('#model').val();
  
		e.preventDefault();
		setTimeout(function() {
			$.ajax({
			   type: "POST",
			   url:urllink+'/api/register_delivery',
			   data : {
						 'firtsname'      : firtsname,
						 'lastname'       : lastname,
						 'emailaddress'   : emailaddress,
						 'contactnumber'  : contactnumber,
						 'username'       : username,
						 'password'       : password,
						 'service_type'   : service,
						 'license_number' : license,
						 'plate_number'   : platenumber,
						 'model'          : model,
				},
			   success: function(data)
			   {
					$('#sendingrequest').html('<center><font size="3"><i class="fa fa-check"></i> Registering Account Success! <br><br> Please wait for Administrator approval! <br><br> Email Confirmation will be send to your Registered Email Address ! <br><br> Thank You!</font></center>');
			   }
		   });
		}, 3000);

}); 


$(".addcart").click(function(e) {
	alert('test1');
	e.preventDefault();
		var prodid       = $(this).data("prodid");
		var user         = $(this).data("user");
		var name         = $(this).data("name");
		var transcode    = $(this).data("transcode");
		var qty          = $('#quantity_input').val();
		var customerid   = user; 
			$('.col-xs-6').hide();
			$('#addtocart').append('&nbsp;&nbsp;&nbsp; <font size="3"> <i class="fa fa-spinner fa-spin"></i> Adding to Cart ..</font>');
			setTimeout(function() {
				$.ajax({
				   type: "POST",
				   url:urllink+'/api/addtocart',
				   data : {
							 'transactionCode' : transcode, 
							 'customerID'      : customerid,
							 'productID'       : prodid,
							 'qty'             : qty,
					},
				   success: function(data)
				   {
						setTimeout(function() {
							$('#modalalert').trigger('click');
							setTimeout(function() {
								// location.reload();
							}, 100);
						}, 100);
				   }
			   });
			}, 100);

});

$(".addtocart").click(function(e) {
			e.preventDefault();
			var prodid       = $(this).data("prodid");
			var user         = $(this).data("user");
			var name         = $(this).data("name");
			var transcode    = $(this).data("transcode");
			var qty          = $('#quantity_input').val();
			$('#addcart'+prodid).hide();
			$('#addtocart'+prodid).html('<center><br><br><font color="blue" size="3"><i class="fa fa-spinner fa-spin"></i> Adding to Cart...</font></center>');
			setTimeout(function() {
			$.ajax({
			   type: "POST",
			   url:urllink+'/api/addtocart',
			    data : {
							 'transactionCode' : transcode, 
							 'customerID'      : user,
							 'productID'       : prodid,
							 'qty'             : qty,
				},
			   success: function(data)
			   {
					setTimeout(function() {
						$('#order-success').trigger('click');
						setTimeout(function() {
							location.reload();
						}, 2000);
					}, 1000);
			   }
		   });
		}, 1000);
});

$(".remove").click(function(e) {
	e.preventDefault();
			var prodid       = $(this).data("id");
			var code         = $(this).data("transcode");
			$('#cart-remove').trigger('click');
			$('.btn').prop('disabled', true);
			setTimeout(function() {
				$.ajax({
				   type: "POST",
				   url:urllink+'/api/removetocart',
				   data : {
							 'orderID' : prodid,
					},
				   success: function(data)
				   {
						setTimeout(function() {location.reload();}, 1000);
				   }
			   });
			}, 2000);

});


// load view product  //



});