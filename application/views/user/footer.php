<?php if($this->uri->segment(3) =='binary_tree'){} else{ ?>
<footer class="main-footer">
        <div class="footer-left">
          <a href="">E-BLENDS</a></a>
        </div>
        <div class="footer-right">
        </div>
</footer>
<?php } ?>
    </div>
  </div>
  <script>  var UrlLink = <?php echo json_encode(base_url()); ?>;</script> 
  <script src="<?php echo base_url();?>assets/js/app.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/user.js"></script>
  <script src="<?php echo base_url();?>assets/bundles/datatables/datatables.min.js"></script>
  <script src="<?php echo base_url();?>assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url();?>assets/bundles/jquery-ui/jquery-ui.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/page/datatables.js"></script>
  <script src="<?php echo base_url();?>assets/bundles/sweetalert/sweetalert.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/page/sweetalert.js"></script>
  <script src="<?php echo base_url();?>assets/js/scripts.js"></script>
  <script src="<?php echo base_url();?>assets/js/clipboard.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
	  
	
	$('.modal').on('shown.bs.modal', function (e) {
    $(this).find('.js-example-basic-single').select2({
        dropdownParent: $(this).find('.modal-content')
    });
	})
	
		
  </script>
	 <script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	</script>
    <script>
		var clipboard = new ClipboardJS('.btn-clipboard');
		clipboard.on('success',function(e){
			alert('Your link is now copied. You can now paste it anywhere.');
		});
	</script>
    <script>
		
  		   $(document).ready(function(){
			$( "#verify" ).click(function() {
				var email  = $(this).attr('data-email');
				var name   = $(this).attr('data-name');
				setTimeout(function() {
				$("#notverified").hide();
				$('#sendingverification').html('<i class="fa fa-spinner fa-spin"></i> Sending Verification Link ...');
				 $.ajax({
				   type: "POST",
				   url:UrlLink+'verify-email',
				   data : {
							'email'      : email, 
							'name'       : name, 
					},
				   success: function(results)
				   {
					location.reload();	
				   }
				});
			}, 3000);
			});
			$( "#resendlink" ).click(function() {
				var email  = $(this).attr('data-email');
				var name   = $(this).attr('data-name');
				setTimeout(function() {
				$("#sendverification").hide();
				$('#resendingverification').html('<i class="fa fa-spinner fa-spin"></i> Sending Verification Link ...');
				 $.ajax({
				   type: "POST",
				   url:UrlLink+'verify-email',
				   data : {
							'email'      : email, 
							'name'       : name, 
					},
				   success: function(results)
				   {
					location.reload();	
				   }
				});
			}, 3000);
			});
		    $('.counts').prop('disabled', true);
			
   			$(document).on('click','.plus',function(){
				var prodid  = $(this).attr('data-prodid');
				var price   = $('.price'+ prodid).val();
				var qty     = $('#qty'+ prodid).val();
				var mqty    = parseInt(qty) + 1;
				var total   = price * mqty;
				var inqty   = $('.count' + prodid).val();
				
				$('.count' + prodid).val(parseInt($('.count' + prodid).val()) + 1 );
				$("#total" + prodid).val(total);
				$("#totalpay" + prodid).html('<br><strong><font size="6"> ₱ ' + total + '</font></strong>');
    		});
        	$(document).on('click','.minus',function(){
				var prodid  = $(this).attr('data-prodid');
				var price   = $('.price'+ prodid).val();
				var qty     = $('#qty'+ prodid).val();
				var mqty    = qty - 1;
				var total   = price * mqty;
				$("#total"+ prodid).val(total);
				$("#totalpay" + prodid).html('<br><strong><font size="6"> ₱ ' + total + '</font></strong>');
    			$('.count'+ prodid).val(parseInt($('.count'+ prodid).val()) - 1 );
    				if ($('.count'+ prodid).val() == 0) {
						$('.count'+ prodid).val(0);
					}
    	    	});
				
			$( "#deliveryoption" ).change(function() {
			  var deliveryoption = $("#deliveryoption").val();
			  if(deliveryoption == 'cod'){
				  $("#paymentmethod").hide();
				  $("#payinfo").hide();
				  $("#payform").hide();
				  $("#paymethod").val("");
				  //** CLEAR INPUTS**//
				  $("#paytranscode").val("");
				  $("#payname").val("");
				  $("#payamount").val("");
				  $("#image").val("");
				   //** ADD REQUIRED ATTRIBUTES **//
				  $("#paymethod").prop('required',false);
				  $("#paytranscode").prop('required',false);
				  $("#payname").prop('required',false);
				  $("#payamount").prop('required',false);
				  $("#image").prop('required',false);
			  } else {
				  $("#paymentmethod").show();
				  //** ADD REQUIRED ATTRIBUTES **//
				  $("#paymethod").prop('required',true);
				  $("#paytranscode").prop('required',true);
				  $("#payname").prop('required',true);
				  $("#payamount").prop('required',true);
				  $("#image").prop('required',true);
			  }
			});
			$( "#paymethod" ).change(function() {
			  var paymethod = $("#paymethod").val();
				 $.ajax({
				   type: "POST",
				   url:UrlLink+'get-paymethod-info',
				   data : {
							'paymethod'      : paymethod, 
					},
				   success: function(results)
				   {
						$("#payinfo").show();
						$("#payinfo").html(results);
						$("#payform").show();
				   }
				});
			});
			$( "#financialmethod" ).change(function() {
			  var financialmethod = $("#financialmethod").val();
				if(financialmethod == 'BANK'){
					$("#bank").show();
					$("#others").hide();
					$("#receivername").val("");
					$("#contactnumber").val("");
					$("#bankname").prop('required',true);
				    $("#accountname").prop('required',true);
				    $("#accountnumber").prop('required',true);
				 
				} else {
					$("#bank").hide();
					$("#others").show();
					$("#bankname").val("");
					$("#accountname").val("");
					$("#accountnumber").val("");
					$("#receivername").prop('required',true);
				    $("#contactnumber").prop('required',true);
				}
			});
			
			//** WITHDRAWL PROCESS ** //
			var amounttoget    = $("#amounttoget").val();
			var taxdeduction   = $("#taxdeduction").val();
			var processingfee  = $("#processingfee").val();
			var totaltoget     = parseInt(amounttoget) - ((parseInt(amounttoget) * (parseInt(taxdeduction) /100 )) + parseInt(processingfee));
			$("#totalget").val(totaltoget);
			$( "#amounttoget" ).change(function() {
				var maxwithdrawal  = $(this).attr('data-max');
				var amounttoget    = $("#amounttoget").val();
				var taxdeduction   = $("#taxdeduction").val();
				var processingfee  = $("#processingfee").val();
				if(parseInt(maxwithdrawal) <= parseInt(amounttoget)){
					alert('You enter invalid amount');
					$("#amounttoget").val(maxwithdrawal);
					var totaltoget     = parseInt(maxwithdrawal) - ((parseInt(maxwithdrawal) * (parseInt(taxdeduction) /100 )) + parseInt(processingfee));
					$("#totalget").val(totaltoget);
				} else {
				var totaltoget     = parseInt(amounttoget) - ((parseInt(amounttoget) * (parseInt(taxdeduction) /100 )) + parseInt(processingfee));
				$("#totalget").val(totaltoget);
				}
			});
			
			 function minmax(value, min, max)
				{
					if(parseInt(value) < min || isNaN(parseInt(value)))
						alert (0);
					else if(parseInt(value) > max)
						alert (amounttoget);
					else return value;
				}
 		});
  </script>
</body>
</html>