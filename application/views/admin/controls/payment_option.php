	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>PAYMENT OPTIONS </h4><a href="" class="float-right btn btn-outline-primary" data-toggle="modal" data-target="#addpayoptions"><i class="fa fa-plus"></i> ADD OPTIONS</a>
                  </div>
                  <div class="card-body">

                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="paymethod-data">
                        <thead>
                          <tr>
                            <th class="text-center">            </th>
                            <th class="text-center"> METHOD     </th>
                            <th class="text-center"> PROCEDURES </th>
                            <th class="text-center"> DATE ADDED </th>
                            <th class="text-center"></th>
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
	  		<button class="btn btn-warning btn-sm" data-toggle="modal" id="deletepaymedthodinfo" data-target="#deletepaymedthods" style="display:none;">  </button>
	  		<button class="btn btn-warning btn-sm" data-toggle="modal" id="editpaymedthodinfo" data-target="#editpaymedthods" style="display:none;">  </button>
			<div class="modal fade" id="deletepaymedthods" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
						  <div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="deleteModalLabel">Delete Payment Method</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
							</div>
							<div class="modal-body">
									<form action="<?php echo site_url('deletepaymentoption');?>" method="post" enctype="multipart/form-data">
											<input type="hidden" name="payid"  id="payid" class="form-control" placeholder="">
											<strong>ARE YOUR SURE TO DELETE THIS DATA ?</strong>
											<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
											<button type="submit" class="btn btn-primary">Yes</button>
											</div>
									</form>
							</div>
					  </div>
				</div>
			</div>  
			<div class="modal fade" id="editpaymedthods" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
						  <div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="deleteModalLabel">UPDATE PAYMENT METHOD</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
							</div>
							<div class="modal-body">
								<form action="<?php echo site_url('updatepaymentoption');?>" method="post" enctype="multipart/form-data">
									<input type="hidden" class="form-control" id="payid" name="payid" required>
								  <div class="form-group">
									<label> PAYMENT METHOD : </label>
									<div class="input-group ">
									  <input type="text" class="form-control" id="paymentmethod" name="paymentmethod" required>
									</div>
								  </div> 
								  <div class="form-group">
									<label> PAYMENT PROCEDURES : </label>
									<div class="input-group">
									<div class="col-sm-12 col-md-12">
									  <textarea class="summernote-simple"  id="paymentprocedures" name="paymentprocedures"></textarea>
									</div>
									</div>
								  </div>  
								
							  <div class="modal-footer bg-whitesmoke br">
								<button type="submit" class="btn btn-primary" >SAVE</button>
								<button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
							  </div>
							  </div>
							  </form>
							</div>
					  </div>
				</div>
			</div>  
			
			