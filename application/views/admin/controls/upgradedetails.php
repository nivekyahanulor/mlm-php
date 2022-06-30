<div style="height:130px"></div>
<div class="container">

    <div class="row  justify-content-center">
        <div class="col-md-8">
				<?php if($this->uri->segment(5) =='approved'){ echo '<div class="alert alert-success"> PURCHASED PAYMENT HAS BEEN APPROVED !</div><br>';}?>
				<?php if($this->uri->segment(5) =='declined'){ echo '<div class="alert alert-warning"> PURCHASED PAYMENT REQUEST HAS BEEN DECLINED !</div><br>';}?>
            <div class="card">
			   <div class="text-left logo p-2 px-5"> <img src="<?php echo base_url();?>/assets/img/logo.png" width="50">	
                <span style="font-size: 20px;font-weight: bolder;">PACKAGE PAYMENT</span> 
				</div>
				<div class="modal fade" id="confirmorders" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
							  <div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="deleteModalLabel">Confirm payment</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
								</div>
								<div class="modal-body">
										<form id="conf-form"  method="post" action="<?php echo site_url('administrator/api/confirmpupgradepayment');?>">
                                                <input type="hidden" name="transactioncode"  value="<?php echo $packagepayment[0]->transcode;?>" id="code" class="form-control" placeholder="">
                                                <input type="hidden" name="membercode"  value="<?php echo $packagepayment[0]->member_code;?>" id="code" class="form-control" placeholder="">
												<input type="hidden" name="uplinecode"  value="<?php echo $packagepayment[0]->referralID;?>" id="code" class="form-control" placeholder="">
												<input type="hidden" name="mainuplinecode"  value="<?php echo $packagepayment[0]->referralmainID;?>" id="code" class="form-control" placeholder="">
												<input type="hidden" name="package_id"  value="<?php echo $packagepayment[0]->package_id;?>" id="code" class="form-control" placeholder="">
												<input type="hidden" name="id"  value="<?php echo $packagepayment[0]->id;?>" id="code" class="form-control" placeholder="">
												<strong>ARE YOU SURE TO  CONFIRM THIS PAYMENT ?</strong>
												<div class="modal-footer">
												<button type="submit" class="btn btn-primary confpack" id="confpack-yes">Yes</button>
												<button type="button" class="btn btn-secondary confpack" data-dismiss="modal" id="confpack-no">No</button>
												</div>
										</form>
								</div>
						  </div>
					</div>
				</div>  

				<div class="modal fade" id="declinerders" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
							  <div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="deleteModalLabel">Decline Order</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
								</div>
								<div class="modal-body">
										<form  method="post" action="<?php echo site_url('declinepurchase');?>">
												<input type="hidden" name="code"  value="<?php echo $product[0]->transcode;?>" id="code" class="form-control" placeholder="">
												<strong>ARE YOU SURE TO DECLINE THIS ORDER ?</strong>
												<div class="modal-footer">
												<button type="submit" class="btn btn-primary">Yes</button>
												<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
												</div>
										</form>
								</div>
						  </div>
					</div>
				</div>  
                <div class="invoice">
                    
					<span class="font-weight-bold d-block mt-4">Payment By : <?php echo $packagepayment[0]->firstname . ' '. $packagepayment[0]->lastname;?></span>
					
					<span>Payment Date : <?php echo $packagepayment[0]->date_added;?></span>
			
                    <div class="payment border-top mt-3 mb-3 border-bottom table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Transaction Code</span><span><?php echo $packagepayment[0]->transcode;?></span> </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Package</span> <span><?php echo $packagepayment[0]->package_name;?></span> </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Payment ref #</span> <span><?php echo $packagepayment[0]->payment_ref_num;?></span> </div>
                                    </td>
                                </tr>
								 <tr>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Proof of payment</span><a target="_blank" href="<?php echo base_url().'assets/packages/proof/'.$packagepayment[0]->member_id.'/'.$packagepayment[0]->proof_file;?>">View</a> <span></span> </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Package Price</span> <?php echo $packagepayment[0]->package_price;?><span></span> </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Referral ID</span><?php echo $packagepayment[0]->referralID;?> <span></span> </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
					
                    <div class="row" style="text-align: right;">
				
                        <div class="col-md-12">
						<?php if($this->uri->segment(5) !='approved') {?>
                            <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#confirmorders"><i class="fas fa-check-circle"></i> CONFIRM PAYMENT </button>
                       <?php } else { ?>
						<button class="btn btn-success btn-md" ><i class="fas fa-check-circle"></i> CONFIRMED </button>
					   <?php } ?>
						</div>
				
                    </div>
                    
                </div>
                <div class="d-flex justify-content-between footer p-3"> <span>Need Help? Email us at <a href="#"> supports@empathybl3nd.com</a></span> </div>
            </div>
        </div>
    </div>
</div>
</div>d