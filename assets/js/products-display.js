var urllink = UrlLink;
$(document).ready( function () {
			$(".loader").html(' <center><img src="assets/img/loading.gif"></center> ');
			var category          = $("#category").val();
			var subcategory       = $("#subcategory").val();
			setTimeout(function() {
			$.ajax({
				type: "POST",
			    url:urllink+'/getproducts',
			    data : {'display' : 'products','category':category , 'subcategory':subcategory},
				   success: function(data)
				   {
					   $(".loader").hide();
						$.each(data, function (index, itemData) {
							 if(itemData.product_image ==''){
								 productimage = '<img src="assets/png/del2home.png" class=" img-responsive " loading="lazy">';
							 } else {
								 productimage = '<img src="assets/png/'+itemData.product_image+'" class=" img-responsive " loading="lazy">';
							 }
							 results = '<div class="col-12 col-md-6 col-sm-6 col-lg-4 mt-4"><a href="products/viewproducts?data='+encodeURI(btoa(itemData.productID))+'&category='+encodeURI(btoa(itemData.product_category))+'&pid='+encodeURI(btoa(itemData.productID))+'"><div class="bbb_deals"><div class="bbb_deals_slider_container"><div class=" bbb_deals_item"><div class="bbb_deals_image">'+ productimage + '</div> <div class="bbb_deals_content"><div class="bbb_deals_info_line d-flex flex-row justify-content-start"><div class="bbb_deals_item_name"> '+itemData.product_name.substr(0, 15)+'... </div></div><div class="available"><div class="available_line d-flex flex-row justify-content-start"><div class="sold_stars"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div><div class="available_title  ml-auto"><div class=" ml-auto">₱ '+itemData.product_price+'</div></div></div><div class="available_bar"><span style="width:17%"></span></div></div></div></div></div></div></div></a>';
							 $('.results').append(results);
						});
				  }
				});
		}, 100);
} );
