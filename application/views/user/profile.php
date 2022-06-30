      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
         
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>MY INFORMATION </h4>
                  <div class="card-header-form">
                  </div>
                </div>
			 <div class=" mt-sm-4">
			 <div class="row justify-content-center">
              <div class="col-12 col-md-12 col-lg-4">
                <div class="card author-box">
                  <div class="card-body">
				  	 <?php if(isset($_GET['uploaded'])){ echo '<div class="alert alert-primary">Profile Picture Uploaded!</div>';}?>
					<div class="card-header">
                    <h4>Profile Picture</h4>
					<div class="card-header-action">
                      <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#updateprofilepicture"> <i class="fas fa-edit"></i></button>
                    </div>
                  </div>
                    <div class="author-box-center">
					  <?php if(!empty($userinfo[0]->profilepicture)){?>
						<img alt="image" src="<?php echo base_url() ."assets/profile/". $userinfo[0]->profilepicture;?>" class="rounded-circle author-box-picture">
					  <?php } else { ?>
						<img alt="image" src="<?php echo base_url();?>assets/img/icon.png" class="rounded-circle author-box-picture">
					  <?php } ?>
                      <div class="clearfix"></div>
                      <div class="author-box-name">
                        <a href="#"><?php echo $userinfo[0]->firstname .' '. $userinfo[0]->lastname;?></a>
                      </div>
                      <div class="author-box-job">MEMBER</div>
                    </div>
                   
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Personal Details</h4>
					<div class="card-header-action">
                      <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#updatepersonal"> <i class="fas fa-edit"></i></button>
                    </div>
                  </div>
                  <div class="card-body">
				  <?php if(isset($_GET['updated'])){ echo '<div class="alert alert-primary">Personal Details has beed updated!</div>';}?>
                    <div class="py-1">
                      <p class="clearfix">
                        <span class="float-left">
                         Full Name:
                        </span>
                        <span class="float-right text-muted">
                         <?php echo $userinfo[0]->firstname .' '. $userinfo[0]->lastname;?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          Email : 
                        </span>
                        <span class="float-right text-muted">
                         <?php echo $userinfo[0]->emailaddress;?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          Contact # :
                        </span>
                        <span class="float-right text-muted">
                         <?php echo $userinfo[0]->contactnumber;?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          TIN # :
                        </span>
                        <span class="float-right text-muted">
                         <?php echo $userinfo[0]->tinnumber;?>
                        </span>
                      </p>
                     
                    </div>
                  </div>
                </div>
              </div> 
			  <div class="col-12 col-md-12 col-lg-7">
                <div class="card author-box">
                  <div class="card-body">
                    <div class="author-box-center">
                      <div class="author-box-name">
						<i class="fas fa-link"></i> Referral Link : <a href=" <?php echo base_url() .'referral/code/'. $userinfo[0]->member_code;?>" target="_blank"> <?php echo base_url() .'referral/code/'. $userinfo[0]->member_code;?></a>
                      </div>
                    </div>
                   
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Financial Details</h4>
					<div class="card-header-action">
                      <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#adddetails"> <i class="fas fa-plus"></i> ADD DETAILS</button>
                    </div>
                  </div>
                  <div class="card-body">
				  	<?php if(isset($_GET['added'])){ echo '<div class="alert alert-primary">Financial Method Added!</div>';}?>
					<div class="table-responsive">
                      <table class="table table-striped table-bordered" id="genealogy-table">
                        <thead>
                          <tr>
                            <th class="text-center"> METHOD      </th>
                            <th class="text-center"> INFORMATION  </th>
                          </tr>
                        </thead>
						<tbody>
							<?php foreach($financial as $val => $row){?>
							<tr>
								<td class="text-center"><?php echo $row->methodname;?></td>
								<td class="text-center">
								<?php if($row->methodname=='BANK'){?> 
								BANK NAME : <?php echo $row->bankname;?><br>
								ACCOUNT NAME : <?php echo $row->accountname;?><br>
								ACCOUNT NUMBER : <?php echo $row->accountnumber;?><br>
								<?php }  else { ?>
								RECEIVER NAME : <?php echo $row->receivername;?><br>
								CONTACT NAME : <?php echo $row->contactnumber;?><br>
								<?php }?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              </div>
            </div>
          </div>
          </div>
          </div>
        </section>
      </div>
		<div class="modal fade" id="updatepersonal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
							  <div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="deleteModalLabel">UPDATE PERSONAL DETAILS</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
								</div>
								<div class="modal-body">
									<form action="<?php echo site_url("updateprofiledetails");?>" method="post" enctype="multipart/form-data">
										<div class="row">
										<div class="form-group col-md-6">
											<label>FIRST NAME  : </label>
											<div class="input-group">
											 <input type="text" class="form-control" name="firstname" required value="<?php echo $userinfo[0]->firstname;?>">
											 <input type="hidden" class="form-control" name="memberID" required value="<?php echo $userinfo[0]->memberID;?>">
											</div>
										</div>  
										<div class="form-group col-md-6">
											<label>LAST NAME  : </label>
											<div class="input-group">
											 <input type="text" class="form-control" name="lastname" required value="<?php echo $userinfo[0]->lastname;?>">
											</div>
										</div>  
										<div class="form-group col-md-6">
											<label>EMAIL ADDRESS  : </label>
											<div class="input-group">
											 <input type="text" class="form-control" name="emailaddress" required readonly value="<?php echo $userinfo[0]->emailaddress;?>">
											</div>
										</div>
										<div class="form-group col-md-6">
											<label>CONTACT NUMBER  : </label>
											<div class="input-group">
											 <input type="text" class="form-control" name="contactnumber" required value="<?php echo $userinfo[0]->contactnumber;?>">
											</div>
										</div>
										<div class="form-group col-md-6">
											<label>TIN NUMBER  : </label>
											<div class="input-group">
											 <input type="text" class="form-control" name="tinnumber" required  value="<?php echo $userinfo[0]->tinnumber;?>">
											</div>
										</div>
										</div>
										
										<div class="modal-footer bg-whitesmoke br">
												<button type="submit" class="btn btn-primary" <?php echo $input;?>>UPDATE</button>
										 </div>
									</form>
								</div>
						  </div>
					</div>
		</div>  		
		
		<div class="modal fade" id="updateprofilepicture" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
							  <div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="deleteModalLabel">PROFILE PICTURE</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
								</div>
								<div class="modal-body">
									<form action="<?php echo site_url("updateprofilepicture");?>" method="post" enctype="multipart/form-data">
										<div class="form-group col-md-12">
											<label>SELECT PHOTO  : </label>
											<div class="input-group">
											 <input type="file" class="form-control" name="image" required value="<?php echo $userinfo[0]->firstname;?>">
											 <input type="hidden" class="form-control" name="memberID" required value="<?php echo $userinfo[0]->memberID;?>">
											</div>
										</div>  
										
										<div class="modal-footer bg-whitesmoke br">
												<button type="submit" class="btn btn-primary" <?php echo $input;?>>UPDATE</button>
										 </div>
									</form>
								</div>
						  </div>
					</div>
		</div>  
		<div class="modal fade" id="adddetails" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
							  <div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="deleteModalLabel">FINANCIAL METHOD INFORMATION</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
								</div>
								<div class="modal-body">
									<form action="<?php echo site_url("savefinancialmethod");?>" method="post" enctype="multipart/form-data">
										<div class="form-group col-md-12">
											<label>SELECT METHOD  : </label>
											<div class="input-group">
											<select class="form-control" name="methodname" id="financialmethod">
												<option value=""> --- </option>
												<option value="BANK"> BANK </option>
												<option value="GCASH"> GCASH </option>
												<option value="PAYMAYA"> PAYMAYA </option>
											</select>	
											 <input type="hidden" class="form-control" name="memberID" required value="<?php echo $userinfo[0]->memberID;?>">
											</div>
										</div>  
										<div id="bank" style="display:none;">
										<div class="form-group col-md-12">
											<label>BANK NAME : </label>
											<div class="input-group">
											<input type="text" class="form-control" name="bankname" id="bankname" >
											</div>
										</div> 
										<div class="form-group col-md-12">
											<label>ACCOUNT NAME : </label>
											<div class="input-group">
											<input type="text" class="form-control" name="accountname" id="accountname">
											</div>
										</div> 
										<div class="form-group col-md-12">
											<label>ACCOUNT NUMBER : </label>
											<div class="input-group">
											<input type="text" class="form-control" name="accountnumber" id="accountnumber">
											</div>
										</div> 
										</div>
										<div id="others" style="display:none;">
										<div class="form-group col-md-12">
											<label> RECEIVER NAME : </label>
											<div class="input-group">
											<input type="text" class="form-control" name="receivername" id="receivername">
											</div>
										</div> 
										<div class="form-group col-md-12">
											<label> CONTACT NUMBER : </label>
											<div class="input-group">
											<input type="text" class="form-control" name="contactnumber" id="contactnumber">
											</div>
										</div> 
										
										</div>
										
										<div class="modal-footer bg-whitesmoke br">
												<button type="submit" class="btn btn-primary" <?php echo $input;?>>UPDATE</button>
										 </div>
									</form>
								</div>
						  </div>
					</div>
		</div>  
  