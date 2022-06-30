	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>MEMBERS INFORMATION </h4><a href="<?php echo site_url('administrator/members/register');?>" target="blank" class="float-right btn btn-outline-primary"><i class="fa fa-plus"></i> REGISTER MEMBERS</a>
                  </div>
                  <div class="card-body">
				  <?php if(isset($_GET['updated'])){ echo '<div class="alert alert-success"> Password successfully change !</div>';}?>
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="members-table">
                        <thead>
                          <tr>
                            <th class="text-center"> </th>
                            <th class="text-center"> FULL NAME</th>
                            <th class="text-center"> EMAIL ADDRESS</th>
                            <th class="text-center"> CONTACT #</th>
                            <th class="text-center"> USER NAME</th>
                            <th class="text-center"> DATE REGISTERED</th>
                            <th class="text-center"> ISACTIVE</th>
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
	  <button class="btn btn-warning btn-sm" data-toggle="modal" id="membersinfo" data-target="#membersinfos" style="display:none;">  </button>
			<div class="modal fade" id="membersinfos" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
						  <div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="deleteModalLabel">Members Information </h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
							</div>
							<div class="modal-body">
							<hr>
									<form  method="post" action="<?php echo site_url('updatememberinfo');?>">
											<input type="hidden" name="memberid"  id="memberid" class="form-control" placeholder="">
											<div class="form-row">
											  <div class="form-group col-md-12">
												<label>Name : </label>
												<div class="input-group">
												  <div id="name" > </div>
												</div>
											  </div>
											  	<div class="form-group col-md-12">
												<label>Email Address : </label>
												<div class="input-group">
												  <div id="email" > </div>
												</div>
											  </div>
											  <div class="form-group col-md-12">
												<label> Change Password : </label>
												<div class="input-group ">
												  <input type="password" class="form-control" name="password" required>
												</div>
											  </div> 
											</div> 
											<div class="modal-footer">
											<button type="submit" class="btn btn-primary">UPDATE</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											</div>
									</form>
							</div>
					  </div>
				</div>
			</div>  