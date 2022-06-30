	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>EXPENSES RECORDS </h4><a href="" class="float-right btn btn-outline-primary" data-toggle="modal" data-target="#addexpenses"><i class="fa fa-plus"></i> ADD RECORD</a>
                  </div>
                  <div class="card-body">

                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="expenses-data">
                        <thead>
                          <tr>
                            <th class="text-center">                </th>
                            <th class="text-center">                </th>
                            <th class="text-center"> EXPENSES DETAILS    </th>
                            <th class="text-center"> QUANITY  </th>
                            <th class="text-center"> EXPENSES AMOUNT   </th>
                            <th class="text-center"> EXPENSES BY        </th>
                            <th class="text-center"> EXPENSES DATE        </th>
                            <th class="text-center"> DATE ADDED      </th>
                            <th class="text-center"> ACTION    </th>
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
	  		<button class="btn btn-warning btn-sm" data-toggle="modal" id="updateexpenses" data-target="#updateexpenses_1" style="display:none;">  </button>
	  		<button class="btn btn-warning btn-sm" data-toggle="modal" id="deleteexpenses" data-target="#deleteexpenses_1" style="display:none;">  </button>
			
			<div class="modal fade" id="deleteexpenses_1" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
						  <div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="deleteModalLabel">Delete Product</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
							</div>
							<div class="modal-body">
									<form  method="post" action="<?php echo site_url('deleteexpenses');?>">
											<input type="hidden" class="form-control" name="expensesID" id="expensesID" required>
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
			
				<div class="modal fade" id="updateexpenses_1" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
						  <div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="deleteModalLabel">UPDATE EXPENSES </h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
							</div>
							<div class="modal-body">
								<form action="<?php echo site_url('updateexpenses');?>" method="post" enctype="multipart/form-data">
								 <div class="row">
								  <div class="form-group  col-md-6">
									<label> EXPENSES AMOUNT : </label>
									<div class="input-group ">
									  <input type="text" class="form-control" name="expensesamount" id="expeamount" required>
									  <input type="hidden" class="form-control" name="expensesID" id="expensesIDs" required>
									</div>
								  </div> 
								   <div class="form-group  col-md-6">
									<label> EXPENSES DETAILS : </label>
									<div class="input-group ">
									  <input type="text" class="form-control" name="expensesdetails" id="expedetails" required>
									</div>
								  </div>   
								  </div>   
								 <div class="row">
								  <div class="form-group  col-md-6">
									<label> EXPENSES DATE : </label>
									<div class="input-group ">
									  <input type="date" class="form-control" name="expensesdate"  id="expedate"  required>
									</div>
								  </div> 
								   <div class="form-group  col-md-6">
									<label> EXPENSES BY  : </label>
									<div class="input-group ">
									  <input type="text" class="form-control" name="expensesdateby" id="expeby" required>
									</div>
								  </div>   
								   <div class="form-group  col-md-6">
									<label> QUANITY   : </label>
									<div class="input-group ">
									  <input type="text" class="form-control" name="quantity" id="quantity" required>
									</div>
								  </div> 
								  </div> 
							  <div class="modal-footer bg-whitesmoke br">
								<button type="submit" class="btn btn-primary" >UPDATE</button>
								<button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
							  </div>
							  </div>
							  </form>
							</div>
					  </div>
				</div>
			
			