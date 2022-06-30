	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>GENEALOGY INFORMATION </h4>
                  </div>
                  <div class="card-body">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a href="<?php echo site_url("user/genealogy");?>" class="nav-link " >UNILEVEL</a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo site_url("user/genealogy/binary");?>" class="nav-link active" >BINARY</a>
                      </li>
                    </ul><br>
					<?php if(isset($_GET['errorcode'])){ echo '<center><div class="alert alert-danger"> Code not Available! Please Try Again! </div></center>';}?>
					<a href="<?php echo site_url("user/genealogy/binary_tree");?>"><button class="btn btn-info btn-md"> VIEW AS BINARY TREE </button></a>
					<br><br>
					 <center><strong>MY BINARY GENEALOGY DATA : </strong></center>
					 <?php 
					 $maincode     = $this->session->userdata['logged_in']['referral_code'];
					 $code     	   = $this->session->userdata['logged_in']['code'];
					 $get0level    = $this->db->query("select * from biowash_binary_process where underBy='$maincode' ");
					 echo "<center><strong>(". $maincode.")</center></strong>";
					 ?>
					<br><br>
                     <div class="row">
					 <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					 <center><strong>LEFT DATA </strong>
					 <?php if($code =='mell'){?>
					 <br><button class="btn btn-info btn-md " data-toggle="modal" data-target="#adddataleft"> ADD DATA </button></center><hr>
					 <?php } ?>
					 <div class="table-responsive">
                      <table class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center"> UNDER BY      </th>
                            <th class="text-center"> MEMBERCODE LEFT   </th>
                            <th class="text-center"> MEMBERCODE RIGHT   </th>
                          </tr>
                        </thead>
						<tbody>
							<?php 
							// ** First Level *** //
							$code     = $this->session->userdata['logged_in']['code'];
							if($code =='mell'){
								$leftdata = $this->db->query("select * from biowash_binary_process where mainMembercode='$code' and position='Left'");
							} else {
								$leftdata = $this->db->query("select * from biowash_binary_process where directMemberCode='$code' and underBy ='$maincode' and position='Left' ");
							}
							foreach($leftdata->result() as $val => $row){?>
							<tr>
							<td class="text-center"><button class="btn btn-md btn-primary" data-toggle="modal" data-target="#adddownlineleft<?php echo  $row->bpID;?>"><?php echo $row->directMemberCode;?></button></td>
							<td class="text-center"><?php echo $row->membercode_left ;?></td>
							<td class="text-center"><?php echo $row->membercode_right;?></td>
							</tr>
							 <div class="modal fade " id="adddownlineleft<?php echo  $row->bpID;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
									  <div class="modal-header bg-whitesmoke">
										<h5 class="modal-title" id="exampleModalLabel">BINARY DATA</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									  </div>
									  <div class="modal-body">
									  <div class="row">
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<form action="<?php echo site_url('process-binary-left');?>" method="post" enctype="multipart/form-data">
											<strong>LEFT</strong>
											<?php if($row->binary_code_left!=""){ echo "<br><br>".$row->membercode_left;} else { ?>
											  <div class="form-group">
												<label>  CODE : </label>
												<div class="input-group ">
												  <input type="text" class="form-control" name="binarycode" required>
												  <input type="hidden" class="form-control" name="bpID" value="<?php echo  $row->bpID;?>" required>
												  <input type="hidden" class="form-control" name="level" value="<?php echo $row->level;?>" required>
												  <input type="hidden" class="form-control" name="directMemberCode" value="<?php echo $row->directMemberCode;?>" required>
												  <input type="hidden" class="form-control" name="underBy" value="<?php echo $row->underBy;?>" required>
												  <input type="hidden" class="form-control" name="sponsorMemberCode" value="<?php echo $row->sponsorMemberCode;?>" required>
												  <input type="hidden" class="form-control" name="position" value="Left" required>
												  <input type="hidden" class="form-control" name="secondaryPosition" value="Left" required>
												</div>
											  </div> 
											<div class="modal-footer bg-whitesmoke br">
											<button type="submit" class="btn btn-primary" >PROCESS</button>
										  </div>
										<?php } ?>
										</form>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<form action="<?php echo site_url('process-binary-left');?>" method="post" enctype="multipart/form-data">
											<strong>RIGHT</strong>
											<?php if($row->binary_code_right!=""){ echo "<br><br>".$row->membercode_right;} else { ?>
												  <div class="form-group">
													<label>  CODE : </label>
													<div class="input-group ">
													  <input type="text" class="form-control" name="binarycode" required>
													  <input type="hidden" class="form-control" name="bpID" value="<?php echo  $row->bpID;?>" required>
													  <input type="hidden" class="form-control" name="level" value="<?php echo $row->level;?>" required>
													  <input type="hidden" class="form-control" name="directMemberCode" value="<?php echo $row->directMemberCode;?>" required>
													  <input type="hidden" class="form-control" name="underBy" value="<?php echo $row->underBy;?>" required>
													  <input type="hidden" class="form-control" name="sponsorMemberCode" value="<?php echo $row->sponsorMemberCode;?>" required>
													  <input type="hidden" class="form-control" name="position" value="Left" required>
													  <input type="hidden" class="form-control" name="secondaryPosition" value="Right" required>
													</div>
												  </div> 
												<div class="modal-footer bg-whitesmoke br">
												<button type="submit" class="btn btn-primary" >PROCESS</button>
											  </div>
											  <?php } ?>
											</form>
											
										</div>
										
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<br><br>
											<div align="right"><button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button></div>
										</div>
									</div>
									</div>
									</div>
									</div>
								  </div>
							<?php } ?>
							<?php 
							if($code =='mell'){}else {
							// ** 2nd Level *** //
							$code     = $this->session->userdata['logged_in']['code'];
							if($code =='mell'){
								$leftdata = $this->db->query("select * from biowash_binary_process where mainMembercode='$code' and position='Left'");
							} else {
								$leftdata = $this->db->query("select * from biowash_binary_process where  underBy ='$code' and position='Left' ");
							}
							foreach($leftdata->result() as $val => $row){?>
							<tr>
							<td class="text-center"><button class="btn btn-md btn-primary" data-toggle="modal" data-target="#adddownlineleft<?php echo  $row->bpID;?>"><?php echo $row->directMemberCode;?></button></td>
							<td class="text-center"><?php echo $row->membercode_left ;?></td>
							<td class="text-center"><?php echo $row->membercode_right;?></td>
							</tr>
							 <div class="modal fade " id="adddownlineleft<?php echo  $row->bpID;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
									  <div class="modal-header bg-whitesmoke">
										<h5 class="modal-title" id="exampleModalLabel">BINARY DATA</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									  </div>
									  <div class="modal-body">
									  <div class="row">
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<form action="<?php echo site_url('process-binary-left');?>" method="post" enctype="multipart/form-data">
											<strong>LEFT</strong>
											<?php if($row->binary_code_left!=""){ echo "<br><br>".$row->membercode_left;} else { ?>
											  <div class="form-group">
												<label>  CODE : </label>
												<div class="input-group ">
												  <input type="text" class="form-control" name="binarycode" required>
												  <input type="hidden" class="form-control" name="bpID" value="<?php echo  $row->bpID;?>" required>
												  <input type="hidden" class="form-control" name="level" value="<?php echo $row->level;?>" required>
												  <input type="hidden" class="form-control" name="directMemberCode" value="<?php echo $row->directMemberCode;?>" required>
												  <input type="hidden" class="form-control" name="underBy" value="<?php echo $row->underBy;?>" required>
												  <input type="hidden" class="form-control" name="sponsorMemberCode" value="<?php echo $row->sponsorMemberCode;?>" required>
												  <input type="hidden" class="form-control" name="position" value="Left" required>
												  <input type="hidden" class="form-control" name="secondaryPosition" value="Left" required>
												</div>
											  </div> 
											<div class="modal-footer bg-whitesmoke br">
											<button type="submit" class="btn btn-primary" >PROCESS</button>
										  </div>
											<?php }?>
										</form>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<form action="<?php echo site_url('process-binary-left');?>" method="post" enctype="multipart/form-data">
											<strong>RIGHT</strong>
											<?php if($row->binary_code_right!=""){ echo "<br><br>".$row->membercode_right;} else { ?>
											  <div class="form-group">
												<label>  CODE : </label>
												<div class="input-group ">
												  <input type="text" class="form-control" name="binarycode" required>
												  <input type="hidden" class="form-control" name="bpID" value="<?php echo  $row->bpID;?>" required>
												  <input type="hidden" class="form-control" name="level" value="<?php echo $row->level;?>" required>
												  <input type="hidden" class="form-control" name="directMemberCode" value="<?php echo $row->directMemberCode;?>" required>
												  <input type="hidden" class="form-control" name="underBy" value="<?php echo $row->underBy;?>" required>
												  <input type="hidden" class="form-control" name="sponsorMemberCode" value="<?php echo $row->sponsorMemberCode;?>" required>
												  <input type="hidden" class="form-control" name="position" value="Right" required>
												  <input type="hidden" class="form-control" name="secondaryPosition" value="Right" required>
												</div>
											  </div> 
											<div class="modal-footer bg-whitesmoke br">
											<button type="submit" class="btn btn-primary" >PROCESS</button>
										  </div>
											<?php } ?>
										</form>
										</div>
										
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<br><br>
											<div align="right"><button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button></div>
										</div>
									</div>
									</div>
									</div>
									</div>
								  </div>
							<?php } } ?>
						</tbody>
                      </table>
                    </div>
                    </div>
					 <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					 <center><strong>RIGHT DATA </strong>
					 <?php if($code =='mell'){?>
					 <br><button class="btn btn-info btn-md"  data-toggle="modal" data-target="#adddataright"> ADD DATA </button></center><hr>
					 <?php } ?>
										 <div class="table-responsive">
                      <table class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center"> UNDER BY      </th>
                            <th class="text-center"> MEMBERCODE LEFT   </th>
                            <th class="text-center"> MEMBERCODE RIGHT   </th>
                          </tr>
                        </thead>
						<tbody>
							<?php 
							// ** First Level *** //
							$code     = $this->session->userdata['logged_in']['code'];
							if($code =='mell'){
								$leftdata = $this->db->query("select * from biowash_binary_process where mainMembercode='$code' and position='Right'");
							} else {
								$leftdata = $this->db->query("select * from biowash_binary_process where directMemberCode='$code' and underBy ='$maincode' and position='Right' ");
							}
							foreach($leftdata->result() as $val => $row){?>
							<tr>
							<td class="text-center"><button class="btn btn-md btn-primary" data-toggle="modal" data-target="#adddownlineleft<?php echo  $row->bpID;?>"><?php echo $row->directMemberCode;?></button></td>
							<td class="text-center"><?php echo $row->membercode_left ;?></td>
							<td class="text-center"><?php echo $row->membercode_right;?></td>
							</tr>
							 <div class="modal fade " id="adddownlineleft<?php echo  $row->bpID;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
									  <div class="modal-header bg-whitesmoke">
										<h5 class="modal-title" id="exampleModalLabel">BINARY DATA</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									  </div>
									  <div class="modal-body">
									  <div class="row">
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<form action="<?php echo site_url('process-binary-left');?>" method="post" enctype="multipart/form-data">
											<strong>LEFT</strong>
											<?php if($row->binary_code_left!=""){ echo "<br><br>".$row->membercode_left;} else { ?>
											  <div class="form-group">
												<label>  CODE : </label>
												<div class="input-group ">
												  <input type="text" class="form-control" name="binarycode" required>
												  <input type="hidden" class="form-control" name="bpID" value="<?php echo  $row->bpID;?>" required>
												  <input type="hidden" class="form-control" name="level" value="<?php echo $row->level;?>" required>
												  <input type="hidden" class="form-control" name="directMemberCode" value="<?php echo $row->directMemberCode;?>" required>
												  <input type="hidden" class="form-control" name="underBy" value="<?php echo $row->underBy;?>" required>
												  <input type="hidden" class="form-control" name="sponsorMemberCode" value="<?php echo $row->sponsorMemberCode;?>" required>
												  <input type="hidden" class="form-control" name="position" value="Right" required>
												  <input type="hidden" class="form-control" name="secondaryPosition" value="Left" required>
												</div>
											  </div> 
											<div class="modal-footer bg-whitesmoke br">
											<button type="submit" class="btn btn-primary" >PROCESS</button>
										  </div>
										<?php } ?>
										</form>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<form action="<?php echo site_url('process-binary-left');?>" method="post" enctype="multipart/form-data">
											<strong>RIGHT</strong>
											<?php if($row->binary_code_right!=""){ echo "<br><br>".$row->membercode_right;} else { ?>
												  <div class="form-group">
													<label>  CODE : </label>
													<div class="input-group ">
													  <input type="text" class="form-control" name="binarycode" required>
													  <input type="hidden" class="form-control" name="bpID" value="<?php echo  $row->bpID;?>" required>
													  <input type="hidden" class="form-control" name="level" value="<?php echo $row->level;?>" required>
													  <input type="hidden" class="form-control" name="directMemberCode" value="<?php echo $row->directMemberCode;?>" required>
													  <input type="hidden" class="form-control" name="underBy" value="<?php echo $row->underBy;?>" required>
													  <input type="hidden" class="form-control" name="sponsorMemberCode" value="<?php echo $row->sponsorMemberCode;?>" required>
													  <input type="hidden" class="form-control" name="position" value="Right" required>
													  <input type="hidden" class="form-control" name="secondaryPosition" value="Right" required>
													</div>
												  </div> 
												<div class="modal-footer bg-whitesmoke br">
												<button type="submit" class="btn btn-primary" >PROCESS</button>
											  </div>
											  <?php } ?>
											</form>
											
										</div>
										
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<br><br>
											<div align="right"><button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button></div>
										</div>
									</div>
									</div>
									</div>
									</div>
								  </div>
							<?php } ?>
							<?php 
							if($code =='mell'){}else {
							// ** 2nd Level *** //
							$code     = $this->session->userdata['logged_in']['code'];
							if($code =='mell'){
								$leftdata = $this->db->query("select * from biowash_binary_process where mainMembercode='$code' and position='Right'");
							} else {
								$leftdata = $this->db->query("select * from biowash_binary_process where  underBy ='$code' and position='Right' ");
							}
							foreach($leftdata->result() as $val => $row){?>
							<tr>
							<td class="text-center"><button class="btn btn-md btn-primary" data-toggle="modal" data-target="#adddownlineleft<?php echo  $row->bpID;?>"><?php echo $row->directMemberCode;?></button></td>
							<td class="text-center"><?php echo $row->membercode_left ;?></td>
							<td class="text-center"><?php echo $row->membercode_right;?></td>
							</tr>
							 <div class="modal fade " id="adddownlineleft<?php echo  $row->bpID;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
									  <div class="modal-header bg-whitesmoke">
										<h5 class="modal-title" id="exampleModalLabel">BINARY DATA</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									  </div>
									  <div class="modal-body">
									  <div class="row">
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<form action="<?php echo site_url('process-binary-left');?>" method="post" enctype="multipart/form-data">
											<strong>LEFT</strong>
											<?php if($row->binary_code_left!=""){ echo "<br><br>".$row->membercode_left;} else { ?>
											  <div class="form-group">
												<label>  CODE : </label>
												<div class="input-group ">
												  <input type="text" class="form-control" name="binarycode" required>
												  <input type="hidden" class="form-control" name="bpID" value="<?php echo  $row->bpID;?>" required>
												  <input type="hidden" class="form-control" name="level" value="<?php echo $row->level;?>" required>
												  <input type="hidden" class="form-control" name="directMemberCode" value="<?php echo $row->directMemberCode;?>" required>
												  <input type="hidden" class="form-control" name="underBy" value="<?php echo $row->underBy;?>" required>
												  <input type="hidden" class="form-control" name="sponsorMemberCode" value="<?php echo $row->sponsorMemberCode;?>" required>
												  <input type="hidden" class="form-control" name="position" value="Right" required>
												  <input type="hidden" class="form-control" name="secondaryPosition" value="Left" required>
												</div>
											  </div> 
											<div class="modal-footer bg-whitesmoke br">
											<button type="submit" class="btn btn-primary" >PROCESS</button>
										  </div>
											<?php }?>
										</form>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<form action="<?php echo site_url('process-binary-left');?>" method="post" enctype="multipart/form-data">
											<strong>RIGHT</strong>
											<?php if($row->binary_code_right!=""){ echo "<br><br>".$row->membercode_right;} else { ?>
											  <div class="form-group">
												<label>  CODE : </label>
												<div class="input-group ">
												  <input type="text" class="form-control" name="binarycode" required>
												  <input type="hidden" class="form-control" name="bpID" value="<?php echo  $row->bpID;?>" required>
												  <input type="hidden" class="form-control" name="level" value="<?php echo $row->level;?>" required>
												  <input type="hidden" class="form-control" name="directMemberCode" value="<?php echo $row->directMemberCode;?>" required>
												  <input type="hidden" class="form-control" name="underBy" value="<?php echo $row->underBy;?>" required>
												  <input type="hidden" class="form-control" name="sponsorMemberCode" value="<?php echo $row->sponsorMemberCode;?>" required>
												  <input type="hidden" class="form-control" name="position" value="Right" required>
												  <input type="hidden" class="form-control" name="secondaryPosition" value="Right" required>
												</div>
											  </div> 
											<div class="modal-footer bg-whitesmoke br">
											<button type="submit" class="btn btn-primary" >PROCESS</button>
										  </div>
											<?php } ?>
										</form>
										</div>
										
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<br><br>
											<div align="right"><button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button></div>
										</div>
									</div>
									</div>
									</div>
									</div>
								  </div>
							<?php } } ?>
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
							<div class="modal fade " id="adddataleft" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog" role="document">
									<div class="modal-content">
									  <div class="modal-header bg-whitesmoke">
										<h5 class="modal-title" id="exampleModalLabel">BINARY DATA</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									  </div>
									  <div class="modal-body">
										<form action="<?php echo site_url('process-binary');?>" method="post" enctype="multipart/form-data">
										  <div class="form-group">
											<label> BINARY CODE : </label>
											<div class="input-group ">
											  <input type="text" class="form-control" name="binarycode" required>
											  <input type="hidden" class="form-control" name="position" value="Left" required>
											</div>
										  </div> 
									  <div class="modal-footer bg-whitesmoke br">
										<button type="submit" class="btn btn-primary" >PROCESS</button>
										<button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
									  </div>
									  </form>
									</div>
									</div>
								  </div>
							</div> 		
							<div class="modal fade " id="adddataright" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog" role="document">
									<div class="modal-content">
									  <div class="modal-header bg-whitesmoke">
										<h5 class="modal-title" id="exampleModalLabel">BINARY DATA</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									  </div>
									  <div class="modal-body">
										<form action="<?php echo site_url('process-binary');?>" method="post" enctype="multipart/form-data">
										  <div class="form-group">
											<label> BINARY CODE : </label>
											<div class="input-group ">
											  <input type="text" class="form-control" name="binarycode" required>
											  <input type="hidden" class="form-control" name="position" value="Right" required>
											</div>
										  </div> 
									  <div class="modal-footer bg-whitesmoke br">
										<button type="submit" class="btn btn-primary" >PROCESS</button>
										<button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
									  </div>
									  </form>
									</div>
									</div>
								  </div>
							</div> 	