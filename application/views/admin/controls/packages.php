	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>PACKAGES INFORMATION </h4><a href="" class="float-right btn btn-outline-primary" data-toggle="modal" data-target="#addpackage"><i class="fa fa-plus"></i> ADD PACKAGE</a>
                  </div>
                  <div class="card-body">
			        		<?php if(isset($_GET['deleted'])){ echo '<div class="alert alert-warning"> Package Data Information Deleted ! </div>';}?>
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="package-data">
                        <thead>
                          <tr>
                            <th class="text-center">                </th>
                            <th class="text-center">                </th>
                            <th class="text-center"> PACKAGE NAME    </th>
                            <th class="text-center"> PACKAGE PRICE   </th>
                            <th class="text-center"> DATE ADDED      </th>
                            <th></th>
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
	  		<button class="btn btn-warning btn-sm" data-toggle="modal" id="deletepackageinfo" data-target="#deletepackage" style="display:none;">  </button>
			<div class="modal fade" id="deletepackage" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
						  <div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="deleteModalLabel">Delete Package</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
							</div>
							<div class="modal-body">
									<form  method="post" action="<?php echo site_url('deletepackage');?>">
											<input type="hidden" name="packageID"  id="packageID" class="form-control" placeholder="">
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
			
			