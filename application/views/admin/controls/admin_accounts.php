	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>ADMIN ACCOUNTS </h4><a href="" class="float-right btn btn-outline-primary" data-toggle="modal" data-target="#addadminuser"><i class="fa fa-plus"></i> ADD USER</a>
                  </div>
                  <div class="card-body">

                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="admin-data">
                        <thead>
                          <tr>
                            <th class="text-center">            </th>
                            <th class="text-center">            </th>
                            <th class="text-center">            </th>
                            <th class="text-center">            </th>
                            <th class="text-center">            </th>
                            <th class="text-center"> NAME       </th>
                            <th class="text-center"> USER NAME  </th>
                            <th class="text-center"> LAST LOGIN </th>
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
	  		<button class="btn btn-warning btn-sm" data-toggle="modal" id="updateadmininfo" data-target="#updateadmininfos" style="display:none;">  </button>
	  		<button class="btn btn-warning btn-sm" data-toggle="modal" id="deleteadmininfo" data-target="#deleteadmininfos" style="display:none;">  </button>
			<div class="modal fade" id="deleteadmininfos" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
						  <div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="deleteModalLabel">Delete  Admin Account</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
							</div>
							<div class="modal-body">
									<form action="<?php echo site_url('deleteadminaccount');?>" method="post" enctype="multipart/form-data">
											<input type="hidden" name="adminID"  id="adminID" class="form-control" placeholder="">
											<strong>ARE YOUR SURE TO DELETE THIS DATA ?</strong>
											<div class="modal-footer">
											<button type="submit" class="btn btn-primary">Yes</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
											</div>
									</form>
							</div>
					  </div>
				</div>
			</div>  
			<div class="modal fade" id="updateadmininfos" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
						  <div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="deleteModalLabel">UPDATE PAYMENT METHOD</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
							</div>
							<div class="modal-body">
								<form action="<?php echo site_url('updateadminuser');?>" method="post" enctype="multipart/form-data">
								<input type="hidden" class="form-control" id="adminID" name="adminID" required>
								 <div class="row">
								  <div class="form-group  col-md-6">
									<label> FIRST NAME : </label>
									<div class="input-group ">
									  <input type="text" class="form-control" name="firstname" id="firstname" required>
									</div>
								  </div> 
								   <div class="form-group  col-md-6">
									<label> LAST NAME : </label>
									<div class="input-group ">
									  <input type="text" class="form-control" name="lastname" id="lastname" required>
									</div>
								  </div>   
								  </div>   
								 <div class="row">
								  <div class="form-group  col-md-6">
									<label> USER NAME : </label>
									<div class="input-group ">
									  <input type="text" class="form-control" name="username"  id="username"  required>
									</div>
								  </div> 
								   <div class="form-group  col-md-6">
									<label> PASSWORD  : </label>
									<div class="input-group ">
									  <input type="password" class="form-control" name="password" id="password" required>
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
			
			