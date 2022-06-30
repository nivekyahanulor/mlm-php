	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>SYSTEM SETTINGS </h4>
                  </div>
                  <div class="card-body">
				  <?php if(isset($_GET['updated'])){ echo '<div class="alert alert-success">  Successfully change !</div>';}?>
						<form action="<?php echo site_url('updatesettings');?>" method="post" enctype="multipart/form-data">
								<div class="row">
								  <div class="form-group col-6">
									<label> TAX DEDUCTION (%) : </label>
									<div class="input-group ">
									  <input type="text" class="form-control" value="<?php echo $settings[0]->tax_deduction;?>" id="paymentmethod" name="textdeduction" required>
									</div>
								  </div>  
								  <div class="form-group col-6">
									<label> PROCESSING FEE : </label>
									<div class="input-group ">
									  <input type="text" class="form-control" value="<?php echo $settings[0]->processing_fee;?>" id="paymentmethod" name="processingfee" required>
									</div>
								  </div> 
								</div>
								<div class="row">
								  <div class="form-group col-6">
									<label> WITHDRAWAL MINIMUM AMOUNT : </label>
									<div class="input-group ">
									  <input type="text" class="form-control" value="<?php echo $settings[0]->withdrawal_amount;?>"  id="paymentmethod" name="withamount" required>
									</div>
								  </div>  
								   <div class="form-group col-md-6">
									<label> EARNING LIMIT : </label>
									<div class="input-group">
									  <input type="text" class="form-control" name="earn_limit" value="<?php echo $settings[0]->earn_limit;?>"  required>
									</div>
								  </div>  
								</div>
								  <hr> BINARY PAIRING BUNOS <hr>
								<div class="row">
									<div class="form-group col-md-6">
									<label> STARTER  PAIRING EARNING : </label>
									<div class="input-group">
									  <input type="text" class="form-control" name="starter_pairing_earning" value="<?php echo $settings[0]->starter_pairing_earning;?>"  required>
									</div>
								  </div>  
									<div class="form-group col-md-6">
									<label> FLASHOUT LIMIT: </label>
									<div class="input-group">
									  <input type="text" class="form-control" name="starter_flushout" value="<?php echo $settings[0]->starter_flushout;?>"  required>
									</div>
								  </div> 
								  <div class="form-group col-md-6">
									<label> SILVER  PAIRING EARNING : </label>
									<div class="input-group">
									  <input type="text" class="form-control" name="silver_pairing_bunos" value="<?php echo $settings[0]->silver_pairing_bunos;?>"  required>
									</div>
								  </div>  
									<div class="form-group col-md-6">
									<label> FLASHOUT LIMIT: </label>
									<div class="input-group">
									  <input type="text" class="form-control" name="silver_flushout" value="<?php echo $settings[0]->silver_flushout;?>"  required>
									</div>
								  </div> 
								  <div class="form-group col-md-6">
									<label> GOLD  PAIRING EARNING : </label>
									<div class="input-group">
									  <input type="text" class="form-control" name="gold_pairing_bunos" value="<?php echo $settings[0]->gold_pairing_bunos;?>"  required>
									</div>
								  </div>  
									<div class="form-group col-md-6">
									<label> FLASHOUT LIMIT: </label>
									<div class="input-group">
									  <input type="text" class="form-control" name="gold_flushout" value="<?php echo $settings[0]->gold_flushout;?>"  required>
									</div>
								  </div> 
								  <div class="form-group col-md-6">
									<label> PREMUIM  PAIRING EARNING : </label>
									<div class="input-group">
									  <input type="text" class="form-control" name="premuim_pairing_bunos" value="<?php echo $settings[0]->premuim_pairing_bunos;?>"  required>
									</div>
								  </div>  
									<div class="form-group col-md-6">
									<label> FLASHOUT LIMIT: </label>
									<div class="input-group">
									  <input type="text" class="form-control" name="premuim_flushout" value="<?php echo $settings[0]->premuim_flushout;?>"  required>
									</div>
								  </div> 
								</div>	

								<hr> OUTRIGHT EARNINGS <hr>
								<div class="row">
								
								  <div class="form-group col-md-6">
									<label>  DIRECT REFERRAL EARNING : </label>
									<div class="input-group">
									  <input type="text" class="form-control" name="binary_direct_earn" value="<?php echo $settings[0]->binary_direct_earn;?>"  required>
									</div>
								  </div>  
								  <div class="form-group col-md-6">
									<label>  DIRECT PRODUCT EARNING : </label>
									<div class="input-group">
									  <input type="text" class="form-control" name="binary_product_earn" value="<?php echo $settings[0]->binary_product_earn;?>"  required>
									</div>
								  </div> 
								 </div>
								<!--<hr> MEMBERS PRODUCTS DISCOUNTS  <hr>
								<div class="row">
								  <div class="form-group col-md-6">
									<label> PRODUCT DISCOUNT : (Percentage) </label>
									<div class="input-group">
									  <input type="text" class="form-control" name="product_discount" value="<?php echo $settings[0]->product_discount;?>"  required>
									</div>
								  </div>  
								</div>
								--->
								<!--<hr> MEGA PRODUCTS DISCOUNTS  <hr>
								<div class="row">
								  <div class="form-group col-md-6">
									<label> E-KIT </label>
									<div class="input-group">
									  <input type="text" class="form-control" name="product_discount" value="<?php echo $settings[0]->product_discount;?>"  required>
									</div>
								  </div>  
								  <div class="form-group col-md-6">
									<label> SILVER </label>
									<div class="input-group">
									  <input type="text" class="form-control" name="product_discount" value="<?php echo $settings[0]->product_discount;?>"  required>
									</div>
								  </div>  
								</div>--->
							  </div>
							   <div class="modal-footer bg-whitesmoke br">
								<button type="submit" class="btn btn-primary" >UPDATE</button>
								<button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
							  </div>
							  </form>
                  </div>
                  </div>
                </div>
              </div>
            </div>
         </div>
      </div>  
	  	