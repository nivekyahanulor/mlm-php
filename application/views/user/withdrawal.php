	<div class="main-content">
          <div class="section-body">
            <div class="row">
				<div class="col-sm-12 col-md-12  col-lg-7">
                <div class="card">
                  <div class="card-header">
                    <h4>MY WALLET TRANSACTION </h4>
                  </div>
                  <div class="card-body">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link " href="<?php echo site_url("user/wallet");?>">WALLET</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" href="<?php echo site_url("user/wallet/withdrawal");?>">WITHDRAWAL</a>
                      </li>
                    
                    </ul> 
					<br>
					<div class="row justify-content-center">
					<div class="col-sm-12 col-md-12  col-lg-12">
					<?php
					$totalearnings = $wallet[0]->balance - $wallet[0]->withdrawals;
						if($totalearnings<0){
							$te = 0;
						} else {
							$te = $totalearnings;
						}
					?>
					
					WALLET BALANCE AMOUNT : <font size="3" color="blue"><?php  echo '₱ '. number_format($te,2);?></font>  
					</div>
					</div>
					<br><br><br>
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="genealogy-table">
                        <thead>
                          <tr>
                            <th class="text-center"> AMOUNT       </th>
                            <th class="text-center"> STATUS    </th>
                            <th class="text-center"> TRANSACTION DATE   </th>
                          </tr>
                        </thead>
						<tbody>
							<?php foreach($withdrawal as $val => $row){?>
							<tr>
								<td class="text-center"><?php echo number_format($row->totalget,2);?></td>
								<td class="text-center"><?php  if($row->approval_status==0){ echo 'PENDING'; } else if($row->approval_status==1){ echo 'APPROVED'; } else { echo 'DECLINED';}?></td>
								<td class="text-center"><?php echo $row->date_requested;?></td>
							</tr>
							<?php } ?>
						</tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
				<div class="col-sm-12 col-md-12  col-lg-5">
                <div class="card">
                  <div class="card-header">
                    <h4>REQUEST WITHDRAWAL<br> <b><i>Withdrawal Limit : <?php echo '₱ '. number_format($settings[0]->withdrawal_amount,2);?> </i></b></h4>
					  </div>
			
                  <div class="card-body">
				      <?php if($userinfo[0]->isVerified!=2){ echo '<center><font color="red" ><i class="fas fa-exclamation-circle"></i></font> Your Email is not verified </font></center>';} ?>
					  <?php if(isset($_GET['requested'])){?>
					   <div class="alert alert-primary">
						 <center>WITHDRAWAL REQUEST SEND! <br> WAIT FOR ADMINISTRATOR APPROVAL <br> THANK YOU!</center>
						</div>
					  <?php }?>
					  <?php
					  if($userinfo[0]->isVerified!=2){ $input = 'disabled';} 
					  else if($userinfo[0]->withdrawal_status==1){ $input = 'disabled';}  
					  else if(($te) >= $settings[0]->withdrawal_amount){ $input = '';}  
					  else { $input = 'disabled'; }
					  ?>
						<form action="<?php echo site_url("processwithdrawal");?>" method="post" enctype="multipart/form-data">
                        </div>
							<div class="form-group col-md-12">
								<label> WITHDRAWAL METHOD  : </label> <a href="<?php echo site_url("user/profile");?>"> Add Financial Details</a>
								<div class="input-group">
								  <select type="text" class="form-control" name="methodID"required <?php echo $input;?>>
								  <option value=""> --- </option>
								  <?php foreach($financial as $a => $b){?>
								  <?php if($b->methodname=='BANK'){?>
								  <option value="<?php echo $b->methodID;?>"> <?php echo $b->methodname. ' - '. $b->bankname;?> </option>
								  <?php } else { ?>
								  <option value="<?php echo $b->methodID;?>"> <?php echo $b->methodname. ' - '. $b->contactnumber;?> </option>
								  <?php } ?>
								  <?php } ?>
								  </select>
								</div>
							</div>  
							<div class="form-group col-md-12">
							<label> AMOUNT: </label>
							<div class="input-group">
							  <input type="text" class="form-control" name="amount" id="amounttoget" required value="<?php echo $te;?>" <?php echo $input;?> data-max="<?php echo $te;?>">
							  <input type="hidden" class="form-control" name="memberID" required value="<?php echo $this->session->userdata['logged_in']['userid'];?>" >
							</div>
							</div>
							<div class="form-group col-md-12" id="paymentmethod">
							<label> TAX DEDUCTION : </label>
							<div class="input-group">
							   <input type="text" class="form-control" name="taxdeduction"  id="taxdeduction" value="<?php echo $settings[0]->tax_deduction;?>%" readonly required <?php echo $input;?>>
							</div>
							</div>
							<div class="form-group col-md-12" id="paymentmethod">
							<label> PROCESSING FEE : </label>
							<div class="input-group">
							   <input type="text" class="form-control" name="processingfee" id="processingfee" required value="<?php echo $settings[0]->processing_fee;?>" readonly <?php echo $input;?>>
							</div>
							</div>	
							<div class="form-group col-md-12" id="paymentmethod">
							<label> TOTAL AMOUNT TO WITHDRAW: </label>
							<div class="input-group">
							   <input type="text" class="form-control" name="totalget" id="totalget" required  readonly <?php echo $input;?>>
							</div>
							</div>
		
							<div class="modal-footer bg-whitesmoke br">
									<button type="submit" class="btn btn-primary" <?php echo $input;?>>PROCESS WITHDRAWAL</button>
							 </div>
						</form>
                </div>
              </div>
            </div>
         </div>
      </div>  
	  		