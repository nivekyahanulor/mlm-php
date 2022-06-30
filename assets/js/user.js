var urllink = UrlLink;
var payment_method_arr = {};
$(document).ready(function() {

getPaymentMethods();
getPaymentPackageData();
$('.purchaseitem').submit(function(e) {
	 e.preventDefault();
	 var prodid   = $(this).attr('data-prodid');
	 var totalpay = $("#total" + prodid).val();
	 var qty      = $("#qty" + prodid).val();
	 var refmcode = $(".referral_main_code").val();
	 var refcodes = $(".referral_code").val();
	 var trancode = $(".transactioncode").val();
	 var userid   = $(".userid").val();
	 $('#purchaseprocess' + prodid).html('<center><font size="5" color="blue"><i class="fa fa-spinner fa-spin"></i> Processing Purchase ...</font></center>');
	 $('.modal-footer').hide();
	 $('.qty').hide();
		setTimeout(function() {
			$.ajax({
			   type: "POST",
			   url:urllink+'process-pruchase-product',
			   data : {
						'productID'      : prodid, 
						'memberID'       : userid, 
						'purchasedQty'   : qty, 
						'referralID'     : refcodes, 
						'referralmainID' : refmcode, 
						'purchasedTotal' : totalpay, 
						'transcode'      : trancode, 
				},
			   success: function(data)
			   {
						$('#order-success').trigger('click');
						setTimeout(function() {
							location.reload();
						}, 2000);
			   }
		   });
		}, 2000);
}); 

$('#inp-sel-pay-method').change(function(){
	var thisval = $(this).val();
	if($(this).val()){
		$('.pay-met-con').show();
		$.each(payment_method_arr,function(k,v){
			if(v.payID == thisval){
				$('.pay-met-img').attr('src','../assets/img/'+v.image);
				$('.pay-met-pro').html(v.payment_procedure);
			}
		});
	}else{
		$('.pay-met-con').hide();
	}
});

$('#checkoutprocess').submit(function(e) {
	 e.preventDefault();
	 alert('test');
	 // var prodid   = $(this).attr('data-prodid');
	 // var totalpay = $("#total" + prodid).val();
	 // var qty      = $("#qty" + prodid).val();
	 // var refmcode = $(".referral_main_code").val();
	 // var refcodes = $(".referral_code").val();
	 // var trancode = $(".transactioncode").val();
	 // var userid   = $(".userid").val();
	 // $('#purchaseprocess' + prodid).html('<center><font size="5" color="blue"><i class="fa fa-spinner fa-spin"></i> Processing Purchase ...</font></center>');
	 // $('.modal-footer').hide();
	 // $('.qty').hide();
		// setTimeout(function() {
			// $.ajax({
			   // type: "POST",
			   // url:urllink+'process-pruchase-product',
			   // data : {
						// 'productID'      : prodid, 
						// 'memberID'       : userid, 
						// 'purchasedQty'   : qty, 
						// 'referralID'     : refcodes, 
						// 'referralmainID' : refmcode, 
						// 'purchasedTotal' : totalpay, 
						// 'transcode'      : trancode, 
				// },
			   // success: function(data)
			   // {
						// $('#order-success').trigger('click');
						// setTimeout(function() {
							// location.reload();
						// }, 2000);
			   // }
		   // });
		// }, 2000);
}); 
$("#payPackForm").on('submit', function(e){
        e.preventDefault();
        var	formData = new FormData(this);
        console.log(formData)
        $.ajax({
            type: 'POST',
            url:'http://localhost/empathyv2/system/user/packages/submitPakagePayment',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.submitBtn').attr("disabled","disabled");
                $('#payPackForm').css("opacity",".5");
            },
            success: function(response){ 
                $('.statusMsg').html('');
                 if(response.status == 1){
					setTimeout(function() {
						$('#purchase-success').trigger('click');
						setTimeout(function() {
							window.location.href="http://localhost/empathyv2/system/user/packages";
						}, 2000);
					}, 1000);
                    $('#fupForm')[0].reset();
                    $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
               }else{
                     $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                 }
                $('#fupForm').css("opacity","");
                $(".submitBtn").removeAttr("disabled");
                console.log(response)
            }
        });
    });
	
	$("#payPackForm1").on('submit', function(e){
        e.preventDefault();
        var	formData = new FormData(this);
        console.log(formData)
        $.ajax({
            type: 'POST',
            url:'http://localhost/empathyv2/system/user/packages/submitPakagePayment',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.submitBtn').attr("disabled","disabled");
                $('#payPackForm').css("opacity",".5");
            },
            success: function(response){ 
                $('.statusMsg').html('');
                 if(response.status == 1){
					setTimeout(function() {
						$('#purchase-success').trigger('click');
						setTimeout(function() {
							window.location.href="http://localhost/empathyv2/system/user/packages";
						}, 2000);
					}, 1000);
                    $('#fupForm')[0].reset();
                    $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
               }else{
                     $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                 }
                $('#fupForm').css("opacity","");
                $(".submitBtn").removeAttr("disabled");
                console.log(response)
            }
        });
    });


	$('#proof_inp').on('change',function(){
		var fileName = $(this).val().replace('C:\\fakepath\\', "");
		$('input#proof_file').val(fileName);
	})
	

});


// $('#proof_inp').change(function() {
    // var filename = $(this).val();
    // var lastIndex = filename.lastIndexOf("\\");
    // if (lastIndex >= 0) {
        // filename = filename.substring(lastIndex + 1);
    // }
    // $('input#proof_file').val(filename);
// });

function getPaymentMethods(){
	$.ajax({
		type: "GET",
		url:'http://localhost/empathyv2/system/user/packages/getPaymentMethods',
		dataType: 'JSON',
		success: function(response){
			// console.log(response)	
			payment_method_arr = response;
			$.each(response,function(k,v){
				$('#inp-sel-pay-method').append(
					`
						<option value='`+v.payID+`'>`+v.payment_type+`</option>
					`
				)
			})
			
		}
	});
}
function openPaymentModal(id,name){
	$('#paymentPackageModal').modal('toggle');
	$('#package_id').val(id);
	$('#package_name').html(name);
}

function getPaymentPackageData(){
	$.ajax({
		type: "GET",
		url:'http://localhost/empathyv2/system/user/packages/getPaymentPackageData',
		dataType: 'JSON',
		success: function(response){
			console.log(response.length)	
			if(response.length){
				$('#package-pay-con').hide();
			}
			if(response[0].isActive == 1){
				$('#package-member-con').show();
				$('#package-image').attr('src',"../assets/packages/" + response[0].package_image);
				$('#package-name').text(response[0].package_name);
				$('#package-description').text(response[0].package_description);
				if(response[0].package_name != 'Platinum Package'){
				$('#package-link').html('<a href="http://localhost/empathyv2/system/user/packages/upgrade/'+response[0].package_name+'" class="btn btn-info"> <i class="fas fa-arrow-right"></i> UPGRADE</a>');
				}
			}else{
				$('#package-pending-con').show();
			}
			
		}
	});
}