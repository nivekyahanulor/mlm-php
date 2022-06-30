	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>PAYMENT INFORMATIONS </h4>
                  </div>
                  <div class="card-body">
                  	<ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a href="<?php echo site_url("administrator/payments");?>" class="nav-link active" >PRODUCT</a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo site_url("administrator/payments/package");?>" class="nav-link" >PACKAGE</a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo site_url("administrator/payments/upgrades");?>" class="nav-link" >UPGRADES</a>
                      </li>
                    
                    </ul><br><br>
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="payment-data">
                        <thead>
                          <tr>
                            <th class="text-center">                     </th>
                            <th class="text-center"> TRANSACTION CODE    </th>
                            <th class="text-center"> ORDER BY            </th>
                            <th class="text-center"> CONTACT             </th>
                            <th class="text-center"> PRODUCT             </th>
                            <th class="text-center"> TOTAL PRICE         </th>
                            <th class="text-center"> DELIVERY METHOD     </th>
                            <th class="text-center"> PAYMENT DATE        </th>
                            <th class="text-center"> ACTION              </th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
         </div>
      </div>  
	  	  	<button class="btn btn-warning btn-sm" data-toggle="modal" id="approveorder" data-target="#confirmorders" style="display:none;">  </button>
	  	  	<button class="btn btn-warning btn-sm" data-toggle="modal" id="declineorder" data-target="#declinerders" style="display:none;">  </button>
	  		<div class="modal fade" id="confirmorders" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
							  <div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="deleteModalLabel">Confirm Order</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
								</div>
								<div class="modal-body">
										<form  method="post" action="<?php echo site_url('confirmpurchase');?>">
												<input type="hidden" name="code"   id="code" class="form-control" placeholder="">
												<strong>ARE YOU SURE TO  CONFIRMS THIS ORDER ?</strong>
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
												<input type="hidden" name="code" id="codes" class="form-control" placeholder="">
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