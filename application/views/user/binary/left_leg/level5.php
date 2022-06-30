									<ul>
										<?php
										$modalID     		= $getLevel5[0]->bpID;
										$Level              = $getLevel5[0]->level;
										$directMemberCode   = $getLevel5[0]->directMemberCode;
										$underBy            = $getLevel4[0]->membercode_left;
										$sponsorMemberCode  = $getLevel4[0]->sponsorMemberCode;
										if($getLevel5[0]->membercode_left==""){?>
											<li><a href="" data-toggle="modal" data-target="#adddownlineleft<?php echo $modalID;?>"><div class="user available"> <i class="fa fa-user-circle fa-5x" aria-hidden="true"></i></div> </a></li>
											<?php } else { ?>
											<li>
												  <a href="#">
													  <div class="container-fluid">
														<center><div style="height:2px;"></div>
															<?php echo str_replace("-","<br>",$getLevel5[0]->membercode_left);?>
													   </center>
													</div>
												</a>
											<?php // <!-- LEVEL 4 LEFT-->//
												// $directcode         = $getLevel5[0]->membercode_left;
												// $binarylevel5  		= $this->db->query("select * from biowash_binary_process where directMemberCode='$directcode' and level = 3 and position ='Left'"); 
												// $getcntlevel5       = $binarylevel5->num_rows();
												// $getLevel5    	    = $binarylevel5->result();
												// $this->load->view('user/header');
												// $this->load->view('user/binary/left_leg/level5', array("getLevel5"=>$getLevel5));
											?>
											</li>
											<?php } ?>
											<?php if($getLevel5[0]->membercode_right==""){?>
											<li><a href="" data-toggle="modal" data-target="#adddownlineright<?php echo $modalID;?>"><div class="user available"> <i class="fa fa-user-circle fa-5x" aria-hidden="true"></i></div> </a></li>
											<li>
												<a href="#">
													  <div class="container-fluid">
														<center><div style="height:2px;"></div>
															<?php echo str_replace("-","<br>",$getLevel5[0]->membercode_right);?>
													   </center>
													</div>
												</a>
											</li>
											<?php } ?>
										</ul>
							<div class="modal fade " id="adddownlineleft<?php echo $modalID;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header bg-whitesmoke">
									<h5 class="modal-title" id="exampleModalLabel">BINARY DATA</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
										<form action="<?php echo site_url('process-binary-left');?>" method="post" enctype="multipart/form-data">
									   <div class="form-group">
										<label>  CODE : </label>
										<div class="input-group ">
											<input type="text" class="form-control" name="binarycode" required>
											<input type="hidden" class="form-control" name="bpID" value="<?php echo $modalID;?>" required>
											<input type="hidden" class="form-control" name="level" value="<?php echo $Level;?>" required>
											<input type="text" class="form-control" name="directMemberCode" value="<?php echo $directMemberCode;?>" required>
											<input type="text" class="form-control" name="underBy" value="<?php echo $underBy;?>" required>
											<input type="text" class="form-control" name="sponsorMemberCode" value="<?php echo $sponsorMemberCode;?>" required>
											<input type="text" class="form-control" name="position" value="Left" required>
											<input type="text" class="form-control" name="secondaryPosition" value="Left" required>
											<input type="hidden" class="form-control" name="package_type" value="<?php echo $this->session->userdata['logged_in']['package_type'];?>">
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
							<div class="modal fade " id="adddownlineright<?php echo $modalID;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header bg-whitesmoke">
									<h5 class="modal-title" id="exampleModalLabel">BINARY DATA</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
										<form action="<?php echo site_url('process-binary-left');?>" method="post" enctype="multipart/form-data">
									   <div class="form-group">
										<label>  CODE : </label>
										<div class="input-group ">
											<input type="text" class="form-control" name="binarycode" required>
											<input type="hidden" class="form-control" name="bpID" value="<?php echo $modalID;?>" required>
											<input type="hidden" class="form-control" name="level" value="<?php echo $Level;?>" required>
											<input type="text" class="form-control" name="directMemberCode" value="<?php echo $directMemberCode;?>" required>
											<input type="text" class="form-control" name="underBy" value="<?php echo $underBy;?>" required>
											<input type="text" class="form-control" name="sponsorMemberCode" value="<?php echo $sponsorMemberCode;?>" required>
											<input type="text" class="form-control" name="position" value="Left" required>
											<input type="text" class="form-control" name="secondaryPosition" value="Right" required>
											<input type="hidden" class="form-control" name="package_type" value="<?php echo $this->session->userdata['logged_in']['package_type'];?>">
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
