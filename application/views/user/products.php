<style>
.qty .counts {
    color: #000;
    display: inline-block;
    vertical-align: top;
    font-size: 25px;
    font-weight: 700;
    line-height: 30px;
    padding: 0 2px
    width: 75px;
    text-align: center;
}
.qty .plus {
    cursor: pointer;
    display: inline-block;
    vertical-align: top;
    color: white;
    width: 30px;
    height: 30px;
    font: 30px/1 Arial,sans-serif;
    text-align: center;
    border-radius: 50%;
    }
.qty .minus {
    cursor: pointer;
    display: inline-block;
    vertical-align: top;
    color: white;
    width: 30px;
    height: 30px;
    font: 30px/1 Arial,sans-serif;
    text-align: center;
    border-radius: 50%;
    background-clip: padding-box;
}

.minus:hover{
    background-color: #717fe0 !important;
}
.plus:hover{
    background-color: #717fe0 !important;
}
/*Prevent text selection*/
span{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}
input{  
    border: 0;
    width: 15%;
}
nput::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input:disabled{
    background-color:white;
}
.swal-footer{
	display:none;
}
</style>
 <div class="main-content">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>EMPATHY PRODUCTS </h4>
                </div>
				<div class="card-body">
					<div class="row">
						<?php foreach($product as $row => $val){?>
						  <div class="col-12 col-sm-6 col-md-6 col-lg-4">
							<article class="article article-style-c">
							  <div class="article-header">
								<div class="article-image" data-background="<?php echo base_url();?>assets/products/<?php echo $val->product_image;?>"></div>
								<div class="article-title">
								  <h2><a href="#"><?php echo $val->product_name;?><br> 
								  <?php if($this->session->userdata['logged_in']['isActive'] ==1){?>
									<?php if($this->session->userdata['logged_in']['member_type'] ==0){?>
								   	  ₱ <?php echo number_format(($val->product_price - $val->member ),2);?>
									 <?php } if($this->session->userdata['logged_in']['member_type'] ==1) {?>
								    	 ₱ <?php echo number_format(($val->product_price -  $val->mega),2);?>
									 <?php } if($this->session->userdata['logged_in']['member_type'] ==2) {?>
								    	 ₱ <?php echo number_format(($val->product_price -  $val->stockist),2);?>
									 <?php } ?>

								  <?php }  else { ?>
								     ₱ <?php echo number_format($val->product_price,2);?>
								  <?php } ?>
								  </a></h2>
								</div>
							  </div>
							  <div class="article-details">
								<p><?php echo $val->product_description;?></p>
								<div class="article-cta">
								  <a href="#" class="btn btn-primary"  data-toggle="modal" data-target="#purchased<?php echo $val->productID;?>"><i class="fas fa-shopping-cart"></i> PURCHASE</a>
								</div>
							  </div>
							</article>
						  </div>
						  
						    <div class="modal fade bd-example-modal-lg" id="purchased<?php echo $val->productID;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
								  <div class="modal-header bg-whitesmoke">
									<h5 class="modal-title" id="exampleModalLabel"><?php echo $val->product_name;?> </h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									<form class="purchaseitem" data-prodid="<?php echo $val->productID;?>">
										<center>
										<div class="qty mt-5">
											<span class="minus bg-dark" data-prodid="<?php echo $val->productID;?>">-</span>
											<input type="text" class="count<?php echo $val->productID;?> counts " name="qty" id="qty<?php echo $val->productID;?>" value="0">
											<span class="plus bg-dark" data-prodid="<?php echo $val->productID;?>">+</span>
										</div>
									  
									  <?php if($this->session->userdata['logged_in']['isActive'] ==1){?>
										<input type="hidden"  class="price<?php echo $val->productID;?> form-control" 
										<?php if($this->session->userdata['logged_in']['member_type'] ==0){ ?>
											value="<?php echo ($val->product_price  - $val->member);?>" 
										<?php } else if($this->session->userdata['logged_in']['member_type'] ==1){ ?>
											value="<?php echo ($val->product_price  - $val->mega);?>" 
										<?php } else if($this->session->userdata['logged_in']['member_type'] ==2){ ?>
											value="<?php echo ($val->product_price  - $val->stockist);?>" 
										<?php } ?>
										>
									  <?php } else { ?>
										<input type="hidden"  class="price<?php echo $val->productID;?> form-control" value="<?php echo $val->product_price;?>" >
									  <?php } ?>
									  <input type="hidden"  class="prodid form-control" value="<?php echo $val->productID;?>">
									  <input type="hidden"  class="referral_main_code form-control" value="<?php echo $this->session->userdata['logged_in']['referral_main_code'];?>">
									  <input type="hidden"  class="referral_code form-control" value="<?php echo $this->session->userdata['logged_in']['referral_code'];?>">
									  <input type="hidden"  class="transactioncode form-control" value="<?php echo $this->session->userdata['logged_in']['transactioncode'];?>">
									  <input type="hidden"  class="userid form-control" value="<?php echo $this->session->userdata['logged_in']['userid'];?>">
									  <div style="height:40px"></div>
									  <strong>TOTAL PAY :</strong> <div id="totalpay<?php echo $val->productID;?>"></div>
									  <div class="form-group">
										<div class="input-group">
										  <input type="hidden"  name="total" class="totalpay" id="total<?php echo $val->productID;?>" required readonly>
										</div>
									  </div>  
									<div id="purchaseprocess<?php echo $val->productID;?>"></div>
								    <div class="modal-footer bg-whitesmoke br">
										<button type="submit" class="btn btn-primary btn-purchase" ><i class="fas fa-cart-plus"></i> PURCHASE</button>
										<button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
								    </div>
								  </form>
								</div>
								</div>
							  </div>
							</div> 
						<?php } ?>
					</div>
				</div>
            </div>
          </div>
          </div>
		  <button class="btn btn-primary" id="order-success" style="display:none;"></button>
      </div>
  
  