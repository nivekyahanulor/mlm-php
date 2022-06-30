<div style="height:60px"></div>
<div class="container mt-5 mb-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
		<?php if($this->uri->segment(5) =='approved'){ echo '<div class="alert alert-success"> WITHDRAWAL REQUEST HAS BEEN APPROVED !</div>';}?>
		<?php if($this->uri->segment(5) =='declined'){ echo '<div class="alert alert-warning"> WITHDRAWAL REQUEST HAS BEEN DECLINED !</div>';}?>
		<?php if($withdrawalinfo[0]->approval_status == 0){ ?>
		<button class="btn btn-primary btn-md" data-toggle="modal" data-target="#approveprocess"> <i class="fas fa-check-circle"></i> APPROVE </button>
		<button class="btn btn-warning btn-md" data-toggle="modal" data-target="#declineprocess"> <i class="fas fa-ban"></i> DECLINE </button>
		<div class="modal fade" id="approveprocess" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
						  <div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="deleteModalLabel">APPROVAL PROCESS</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
							</div>
							<div class="modal-body">
									<form  method="post" action="<?php echo site_url('approvewithdrawal');?>">
											<input type="hidden" name="code"  id="code" class="form-control" placeholder="">
											<strong>ARE YOUR SURE TO APPROVE THIS DATA ?</strong>
											<input type="hidden" value="<?php echo $withdrawalinfo[0]->withdrawalID;?>" name="withdrawalID">
											<input type="hidden" value="<?php echo $withdrawalinfo[0]->memberID;?>" name="memberID">
											<input type="hidden" value="<?php echo $withdrawalinfo[0]->amount;?>" name="amount">
											<div class="modal-footer">
											<button type="submit" class="btn btn-primary">Yes</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
											</div>
									</form>
							</div>
					  </div>
				</div>
			</div> 
			<div class="modal fade" id="declineprocess" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
						  <div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="deleteModalLabel">DECLINE PROCESS</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
							</div>
							<div class="modal-body">
									<form  method="post" action="<?php echo site_url('declinewithdrawal');?>">
											<input type="hidden" name="code"  id="code" class="form-control" placeholder="">
											<strong>ARE YOUR SURE TO DECLINE THIS DATA ?</strong>
											<br><br>
											<b>REASON : </b><textarea name="reason" class="form-control" required></textarea>
											<input type="hidden" value="<?php echo $withdrawalinfo[0]->withdrawalID;?>" name="withdrawalID">
											<input type="hidden" value="<?php echo $withdrawalinfo[0]->memberID;?>" name="memberID">
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
		<div style="height:20px"></div>
            <div class="card">
                <div class="upper p-4">
                    <div class="d-flex justify-content-between">
                        <div class="amount">
                            <h4><?php echo '₱ '. number_format($withdrawalinfo[0]->amount,2);?></h4> 
							<?php $date=date_create($withdrawalinfo[0]->date_requested); ?>
							<small>Request Date : <?php echo date_format($date,"F d , Y");?></small>
                        </div>
                      
                    </div>
                    <hr>
                    <div class="delivery">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row align-items-center"> <i class="fa fa-check-circle-o"></i> <span class="ml-2">Tax Deduction : </span> </div> 
							<span class="font-weight-bold"><?php echo '₱ '. number_format(($withdrawalinfo[0]->amount * ( $withdrawalinfo[0]->taxdeduction / 100)),2) .' - ('. $withdrawalinfo[0]->taxdeduction.')';?></span>
                        </div>
                    </div>
                    <div class="transaction mt-2">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row align-items-center"> <i class="fa fa-check-circle-o"></i> <span class="ml-2">Processing Fee : </span> </div> <span class="font-weight-bold"><?php echo '₱ '. number_format($withdrawalinfo[0]->processingfee,2);?></span>
                        </div>
                    </div>
                    
                    <hr>
					<b> WITHDRAWAL METHOD </b>
					<?php  if($withdrawalinfo[0]->methodname == 'BANK'){ ?>
                    <div class="transaction mt-2">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row align-items-center"> <i class="fa fa-check-circle-o"></i> <span class="ml-2">BANK NAME</span> </div> <span class="font-weight-bold"><?php echo $withdrawalinfo[0]->bankname;?></span>
                        </div>
                    </div>
                    <div class="transaction mt-2">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row align-items-center"> <i class="fa fa-check-circle-o"></i> <span class="ml-2">ACCOUNT NAME</span> </div> <span class="font-weight-bold"><?php echo $withdrawalinfo[0]->accountname;?></span>
                        </div>
                    </div>
                    <div class="transaction mt-2">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row align-items-center"> <i class="fa fa-check-circle-o"></i> <span class="ml-2">ACCOUNT NUMBER </span> </div> <span class="font-weight-bold"><?php echo $withdrawalinfo[0]->accountnumber;?></span>
                        </div>
                    </div>
					<?php } else { ?>
					  <div class="transaction mt-2">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row align-items-center"> <i class="fa fa-check-circle-o"></i> <span class="ml-2">RECEIVER NAME</span> </div> <span class="font-weight-bold"><?php echo $withdrawalinfo[0]->receivername;?></span>
                        </div>
                    </div>
                    <div class="transaction mt-2">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row align-items-center"> <i class="fa fa-check-circle-o"></i> <span class="ml-2">CONTACT NUMBER</span> </div> <span class="font-weight-bold"><?php echo $withdrawalinfo[0]->contactnumber;?></span>
                        </div>
                    </div>
                 
					<?php } ?>
                </div>
                <div class="lower bg-primary p-4 py-5 text-white d-flex justify-content-between">
                    <div class="d-flex flex-column"> <span>Cost including Service Fee Charges and Tax Deductions</span><br><small> TOTAL AMOUNT TO GET </small>  </div>
                   <h3><?php echo '₱ '. number_format($withdrawalinfo[0]->totalget,2);?></h3>

                </div>
            </div>
        </div>
    </div>
</div>