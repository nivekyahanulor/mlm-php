var urllink = UrlLink;

// load featured product  //
$(document).ready( function () {
			$(".loadfeatured").html(' <center><img src="assets/img/loading.gif"></center> ');
			setTimeout(function() {
			$.ajax({
				type: "POST",
			    url:urllink+'/getproducts',
			    data : {'display' : 'limit',},
				   success: function(data)
				   {
					   $(".loadfeatured").hide();
					   // var jsondata = JSON.parse(data);
						$.each(data, function (index, itemData) {
							 if(itemData.product_image ==''){
								 productimage = '<img src="assets/png/del2home.png" class=" img-responsive " loading="lazy">';
							 } else {
								 productimage = '<img src="assets/png/'+itemData.product_image+'" class=" img-responsive " loading="lazy">';
							 }
							 featured_product = '<div class="col-12 col-md-4 col-sm-4 col-lg-3 mt-4"><a href="products/viewproducts?data='+encodeURI(btoa(itemData.productID))+'&category='+encodeURI(btoa(itemData.product_category))+'&pid='+encodeURI(btoa(itemData.productID))+'"><div class="bbb_deals"><div class="bbb_deals_slider_container"><div class=" bbb_deals_item"><div class="bbb_deals_image">'+ productimage + '</div> <div class="bbb_deals_content"><div class="bbb_deals_info_line d-flex flex-row justify-content-start"><div class="bbb_deals_item_name"> '+itemData.product_name.substr(0, 25)+'... </div></div><div class="available"><div class="available_line d-flex flex-row justify-content-start"><div class="sold_stars"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div><div class="available_title  ml-auto"><div class=" ml-auto">₱ '+itemData.product_price+'</div></div></div><div class="available_bar"><span style="width:17%"></span></div></div></div></div></div></div></div></a>';
							 $('.featured_product').append(featured_product);
						});
				  }
				});
			}, 100);
} );

// load promo product  //

$(document).ready( function () {
			$(".loadpromo").html(' <center><img src="assets/img/loading.gif"></center> ');
			setTimeout(function() {
			$.ajax({
				type: "POST",
			    url:urllink+'/getproducts',
			    data : {'display' : 'promo',},
				   success: function(data)
				   {
					   $(".loadpromo").hide();
					   // var jsondata = JSON.parse(data);
						$.each(data, function (index, itemData) {
							 if(itemData.product_image ==''){
								 productimage = '<img src="assets/png/del2home.png" class=" img-responsive " loading="lazy">';
							 } else {
								 productimage = '<img src="assets/png/'+itemData.product_image+'" class=" img-responsive " loading="lazy">';
							 }
							 featured_product = '<div class="col-12 col-md-4 col-sm-4 col-lg-3 mt-4"><a href="products/viewproducts?data='+encodeURI(btoa(itemData.productID))+'&category='+encodeURI(btoa(itemData.product_category))+'&pid='+encodeURI(btoa(itemData.productID))+'"><div class="bbb_deals"><div class="bbb_deals_slider_container"><div class=" bbb_deals_item"><div class="bbb_deals_image">'+ productimage + '</div> <div class="bbb_deals_content"><div class="bbb_deals_info_line d-flex flex-row justify-content-start"><div class="bbb_deals_item_name"> '+itemData.product_name.substr(0, 25)+'... </div></div><div class="available"><div class="available_line d-flex flex-row justify-content-start"><div class="sold_stars"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div><div class="available_title  ml-auto"><div class=" ml-auto">₱ '+itemData.product_price+'</div></div></div><div class="available_bar"><span style="width:17%"></span></div></div></div></div></div></div></div></a>';
							 $('.promo_product').append(featured_product);
						});
				  }
				});
			}, 100);
} );

// load sales product  //

$(document).ready( function () {
			$(".loadsales").html(' <center><img src="assets/img/loading.gif"></center> ');
			setTimeout(function() {
				$(".loadsales").hide();
				$('.sales_product').append('<center><font color="red"><b>NO PRODUCT AVAILABLE AT THE MOMENT</b></font></center>');
			}, 2010);
} );
