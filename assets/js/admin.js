$(document).ready(function() {
var urllink = UrlLink;
//** Select Category Product - Assign Inventory to retailer ** //
$('#productid').on('change', function() {
	$("#productlist").show();
});

$('.btn-approved').click(function(e) {
	 e.preventDefault();
	 // $('#confirmrequest').html('<center><font size="3"><i class="fa fa-spinner fa-spin"></i> Processing Retailer Request ...</font></center>');
	 // $('#confirmcontent').hide();
	 var retailerID     = $('.retailerID').val();
	 alert(retailerID);
			// setTimeout(function() {
			// $.ajax({
			   // type: "POST",
			   // url:urllink+'approvedreatiler',
			   // data : {
						// 'retailerID' : retailerID, 
				// },
			   // success: function(data)
			   // {
					// $('#confirmrequest').html('<center><font size="3"><i class="fa fa-check"></i> Success ! Retail Request has been Approved! </font></center>');
					// setTimeout(function() {
					  // window.location.href = "admin?page=retailer&approved";
					// }, 2000);
			   // }
		   // });
		// }, 3000);
   
}); 

$('button .btn-customer-records').click(function(e) {
	 e.preventDefault();
	 // $('#confirmrequest').html('<center><font size="3"><i class="fa fa-spinner fa-spin"></i> Processing Retailer Request ...</font></center>');
	 // $('#confirmcontent').hide();
	 alert('view');
			// setTimeout(function() {
			// $.ajax({
			   // type: "POST",
			   // url:urllink+'approvedreatiler',
			   // data : {
						// 'retailerID' : retailerID, 
				// },
			   // success: function(data)
			   // {
					// $('#confirmrequest').html('<center><font size="3"><i class="fa fa-check"></i> Success ! Retail Request has been Approved! </font></center>');
					// setTimeout(function() {
					  // window.location.href = "admin?page=retailer&approved";
					// }, 2000);
			   // }
		   // });
		// }, 3000);
   
}); 
$('#assignproductinventory').submit(function(e) {
	 e.preventDefault();
	 $('#processinventory').html('<center><font size="3"><i class="fa fa-spinner fa-spin"></i> Processing Retailer Inventory ...</font></center> <br><br>');
	 $('.modal-footer').hide();
	 var retailerID     = $('#retailerID').val();
	 var qty            = $('#qty').val();
	 var productid      = $('#productid').val();
			setTimeout(function() {
			$.ajax({
			   type: "POST",
			   url:urllink+'/retailerinventory',
			   data : {
						'productID'        : productid, 
						'quantity'         : qty, 
						'retailerID'       : retailerID, 
						'currentinventory' : qty, 
				},
			   success: function(data)
			   {
					$('#processinventory').html('<center><font size="3"><i class="fa fa-check"></i> Success ! Product Added to Retailer Inventory!</font></center><br><br>');
					setTimeout(function() {
					  window.location.href = "admin?page=retailerinventory&data"+retailerID;
					}, 2000);
			   }
		   });
		}, 3000);
   
}); 

$('#updateproduct').submit(function(e) {
	 e.preventDefault();
	 $('#processproductupdate').html('<center><font size="3"><i class="fa fa-spinner fa-spin"></i> Processing Product Update ...</font></center> <br><br>');
	 $('.modal-footer').hide();
		 var productID      = $('#productID').val();
		 var sku            = $('#sku').val();
		 var code           = $('#code').val();
		 var productname    = $('#productname').val();
		 var productprice   = $('#productprice').val();
		 var brand          = $('#brand').val();
		 var description    = $('#description').val();
		 var qty            = $('#qty').val();
		 var category       = $('#category').val();
		 var subcategory    = $('#select-subcategory').val();
		 var availability   = $('#availability').val();
		 var product_image  = $('#png').val();
			setTimeout(function() {
			$.ajax({
			   type: "POST",
			   url:urllink+'/updateproduct',
			   data : {
						'productID'            : productID, 
						'product_sku'          : sku, 
						'product_code'         : code, 
						'product_name'         : productname, 
						'product_price'        : productprice, 
						'product_brand'        : brand, 
						'product_category'     : category, 
						'product_sub_category' : subcategory, 
						'product_description'  : description, 
						'product_qty'          : qty, 
						'product_stocks'       : availability, 
						'product_image'        : product_image, 
						
				},
			   success: function(data)
			   {
					$('#processproductupdate').html('<center><font size="3"><i class="fa fa-check"></i> Success ! Product Information Updated!</font></center><br><br>');
						setTimeout(function() {
						  window.location.href = "admin?page=productdata&product="+productID;
						}, 2000);
			   }
		   });
		}, 1000);
   
}); 

$('#category').on('change', function() {
	var data = this.value;
    $("#product-subcategory").show();
	let subcategory = $('#select-subcategory');
	subcategory.empty();
	subcategory.append('<option selected="true" disabled>Choose Sub Category</option>');
	subcategory.prop('selectedIndex', 0);
	const subcat = 'http://del2home.com/api/getsubcategoryjson?catID='+data;
	$.getJSON(subcat, function (catdata) {
	  $.each(catdata, function (key, entry) {
			   subcategory.append($('<option></option>').attr('value', entry.name).text(entry.name));
	  })
	});
});
	
});

$('#confpack-yes').on("click",function(e){
	e.preventDefault();
	$('#conf-form').submit();
    $(this).text('Processing... Please Wait.');
    $(this).attr('disabled','disabled');
    $('#confpack-no').hide();
})