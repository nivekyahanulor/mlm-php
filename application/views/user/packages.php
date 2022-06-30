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
input::-webkit-outer-spin-button,
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
 		  <div class="row" id="package-member-con" style="display: none">
 		  	<div class="col-12">
 		  		<div class="card">
 		  			<div class="card-header">
	                  <h4> PACKAGE MEMBERSHIP </h4>
	                </div>
	                <div class="card-body" >
						<div class="row" >
							<div class="col-6 col-sm-6 col-md-6 col-lg-6">
								<article class="article article-style-c">
								  <div class="article-header" style="height: 100%">
									
									<img src="" id="package-image" style="width: 50%">
									<div class="article-title">
									  <h2><a href="#"></a></h2>
									</div>
								  </div>
								  
								</article>
							  </div>
							  <div class="col-6 col-sm-6 col-md-6 col-lg-6">
							  	<div class="card">
				                  <div class="card-header">
				                    <h4>Package Details</h4>
				                  </div>
				                  <div class="card-body">
								   <div class="py-1">
				                      <p class="clearfix">
				                        <span class="float-left">
				                         Package Name:
				                        </span>
				                        <span class="float-right text-muted" id="package-name"> </span>
				                      </p>
				                      <p class="clearfix">
				                        <span class="float-left">
				                          Package Description : 
				                        </span>
				                        <span class="float-right text-muted" id="package-description"> </span>
				                      </p>
				                      
				                      <p>
				                      	<div class="article-cta">
											<div id="package-link"></div>
										</div>
				                      </p>
				                     
				                    </div>
				                  </div>
				                </div>
							  </div>
						</div>
					</div>
 		  		</div>
 		  	</div>
 		  </div>
 		  <div class="row" id="package-pending-con" style="display: none">
 		  	<div class="col-12">
 		  		<div class="card">
 		  			<div class="card-header">
	                  <h4> PACKAGE PENDING </h4>
	                </div>
	                <div class="card-body" >
                    	Package purchase request is pending . Please wait for administrator approval.
					</div>
 		  		</div>
 		  	</div>
 		  </div>
          <div class="row" id="package-pay-con">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>EMPATHY PACKAGE </h4>
                </div>
				<div class="card-body" >
					<div class="row" >
						<?php foreach($package as $row => $val){?>

								<div class="col-12 col-md-4 col-lg-4">
								<div class="pricing pricing-highlight">
								<div class="pricing-title">
								<?php echo $val->package_name;?>
								</div>
								<div class="pricing-padding">
									<div class="pricing-price">
									<div>₱ <?php echo number_format($val->package_price,2);?></div>
									<div>MEMBERSHIP </div>
									</div>
									<div class="pricing-details">
											<p><?php echo $val->package_description;?></p>
									</div>
								</div>
								<div class="pricing-cta">
									<a href="#" onclick="openPaymentModal('<?php echo $val->packageID;?>','<?php echo $val->package_name;?>')">PURCHASE <i class="fas fa-arrow-right"></i></a>
								</div>
								</div>
								</div>

						  
						    	<div class="modal fade bd-example-modal-lg" id="paymentPackageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
								  <div class="modal-header bg-whitesmoke">
									<h5 class="modal-title" id="exampleModalLabel"> <div id="package_name"></div> </h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									<form id="payPackForm" action="" enctype="multipart/form-data" role="form">
										<input type="hidden"  class="userid form-control" value="<?php echo $this->session->userdata['logged_in']['userid'];?>" name="member_id">
										<input type="text" class="form-control" name="proof_file" id="proof_file">
										<input type="hidden" name="package_id" id="package_id">
										<input type="hidden"  class="prodid form-control" value="<?php echo $val->productID;?>">
										<input type="hidden" name="referralmainID"  class="referral_main_code form-control" value="<?php echo $this->session->userdata['logged_in']['referral_main_code'];?>">
										<input type="hidden"  name="referralID"  class="referral_code form-control" value="<?php echo $this->session->userdata['logged_in']['referral_code'];?>">
										<input type="hidden"  name="member_code"  class="member_code form-control" value="<?php echo $this->session->userdata['logged_in']['code'];?>">
										<input type="hidden"  name="transcode"  class="transactioncode form-control" value="<?php echo $this->session->userdata['logged_in']['transactioncode'];?>">
										<input type="hidden"  name="date_added"  class="transactioncode form-control" value="<?php echo date('Y-m-d h:i:s');?>">
										<input type="hidden"  name="is_upgrade"  class="transactioncode form-control" value="0">
								   
									    <div class="input-group mb-3">
										  <select class="custom-select" id="inp-sel-pay-method" name="payment_option_id">
										    <option value='' selected>Select Payment Method</option>
										    
										  </select>
										  <div class="input-group-append">
										    <label class="input-group-text" for="inputGroupSelect02">Options</label>
										  </div>
										</div>
									 
									<div class="card pay-met-con" id="pay-met-con" style="display: none;">
									  <img class="card-img-top pay-met-img" src="" alt="" id="pay-met-img">
									  <div class="card-body">
									    <h5 class="card-title">Payment Procedure</h5>
									    <div class="pay-met-pro"></div>
									    <div class="row">
									    	<div class="col-md-12">
									    		<label for="ref-num">Ref Number</label>
												<div class="input-group mb-3">
											
												  <input type="text" class="form-control" name="payment_ref_num" id="ref-num" aria-describedby="basic-addon3" required>
												</div>
									    	</div>
									    	<div class="col-md-12">
									    		<div class="mb-3">
												  <label for="formFileMultiple" class="form-label">Proof of payment file</label>
												  <input class="form-control" type="file" id="proof_inp" name="proof_inp" required>
												</div>
									    	</div>
									    </div>
									  </div>
									  <div class="card-footer text-muted">
									    <button type="submit" class="btn btn-primary submitBtn">SUBMIT</button>
									    <button type="button" class="btn btn-default">CLOSE</button>
									  </div>
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
		  <button class="btn btn-primary" id="purchase-success" style="display:none;"></button>
      </div>
  