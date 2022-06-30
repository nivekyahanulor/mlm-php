<div style="height:100px"></div>
<div class="container">
    <div class="row  justify-content-center">
        <div class="col-md-8">
				<?php if($this->uri->segment(5) =='approved'){ echo '<div class="alert alert-success"> PURCHASED PAYMENT HAS BEEN APPROVED !</div><br>';}?>
				<?php if($this->uri->segment(5) =='declined'){ echo '<div class="alert alert-warning"> PURCHASED PAYMENT REQUEST HAS BEEN DECLINED !</div><br>';}?>
            <div class="card">
			   <div class="text-left logo p-2 px-5"> <img src="<?php echo base_url();?>/assets/img/logo.png" width="50">	
				<?php if($package[0]->order_status ==0){ ?>
				<button class="btn btn-primary btn-md" data-toggle="modal" data-target="#confirmorders"><i class="fas fa-check-circle"></i> CONFIRM ORDERS </button>
				<button class="btn btn-warning btn-md" data-toggle="modal" data-target="#declinerders"><i class="fas fa-circle"></i> DECLINE ORDERS </button></div>
				<div class="modal fade" id="confirmorders" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
							  <div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="deleteModalLabel">Confirm Order</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
								</div>
								<div class="modal-body">
										<form  method="post" action="<?php echo site_url('confirmpurchase');?>">
												<input type="hidden" name="code"  value="<?php echo $package[0]->transcode;?>" id="code" class="form-control" placeholder="">
												<strong>ARE YOU SURE TO  CONFIRM THIS ORDER ?</strong>
												<div class="modal-footer">
												<button type="submit" class="btn btn-primary">Yes</button>
												<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
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
												<input type="hidden" name="code"  value="<?php echo $package[0]->transcode;?>" id="code" class="form-control" placeholder="">
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
				<?php } ?>
                <div class="invoice p-5">
                    <h5><?php if($package[0]->order_status==0){ echo 'PENDING ORDER';}?></h5> 
					<?php 
					$memberid   = $package[0]->memberID;
					$user       = $this->db->query("select * from biowash_members where memberID='$memberid'");
					$userresult = $user->result();
					?>
					<span class="font-weight-bold d-block mt-4">Purchased By : <?php echo $userresult[0]->firstname .' '. $userresult[0]->lastname;?></span>
					<?php if($package[0]->order_status==0){?>
					<span>Purchased Date : <?php echo  $package[0]->paydate;?></span>
					<?php } ?>
                    <div class="payment border-top mt-3 mb-3 border-bottom table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Order Date</span> <span><?php echo $package[0]->checkout_date;?></span> </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Transaction Code</span> <span><?php echo $package[0]->transcode;?></span> </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Payment</span> <span><?php  if($package[0]->deliveryoption=='cod'){ echo 'COD';} else { echo $package[0]->paymentmethod;}?></span> </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Shiping Address</span> <span><?php echo  $package[0]->deliveryaddress;?></span> </div>
                                    </td>
                                </tr>
								 <tr>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Delivery Address</span> <span><?php echo $package[0]->deliveryaddress;?></span> </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Payment Transaction Code</span> <span><?php echo $package[0]->paytranscode;?></span> </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Payment By </span> <span><?php echo $package[0]->payname;?></span> </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Pay Amount</span> <span><?php echo  $package[0]->payamount;?></span> </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="package border-bottom table-responsive">
                        <table class="table table-borderless">
                            <tbody>
							<?php foreach($purchase as $a => $b){ 
								$subtotal += $b->purchasedTotal;
							?>
                                <tr>
                                    <td width="20%"> <img alt="image" src="<?php echo base_url();?>assets/packages/<?php echo $b->package_image;?>" style="width:100px"> </td>
                                    <td width="60%"> <span class="font-weight-bold"><?php echo $b->package_name;?></span>
                                        <div class="package-qty"> <span class="d-block">Quantity: x <?php echo $b->purchasedQty;?></span> </div>
                                    </td>
                                    <td width="20%">
                                        <div class="text-right"> <span class="font-weight-bold"> <?php echo number_format($b->purchasedTotal,2);?></span> </div>
                                    </td>
                                </tr>
							<?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row d-flex justify-content-end">
                        <div class="col-md-5">
                            <table class="table table-borderless">
                                <tbody class="totals">
                                    <tr>
                                        <td>
                                            <div class="text-left"> <span class="text-muted">Subtotal</span> </div>
                                        </td>
                                        <td>
                                            <div class="text-right"> <span><?php echo number_format($subtotal,2);?></span> </div>
                                        </td>
                                    </tr>
                                 
                                    <tr class="border-top border-bottom">
                                        <td>
                                            <div class="text-left"> <span class="font-weight-bold">Grand Total</span> </div>
                                        </td>
                                        <td>
                                            <div class="text-right"> <span><?php echo number_format($subtotal,2);?></span> </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                   
                </div>
                <div class="d-flex justify-content-between footer p-3"> <span>Need Help? Email us <a href="#"> biowash2020@gmail.com</a></span> </div>
            </div>
        </div>
    </div>
</div>