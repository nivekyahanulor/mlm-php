							<ul>

						
							<?php 
								$sdata      = $_GET['data'];
								$counttree  = $this->db->query("select * from biowash_binary_process where directMemberCode='$sdata'");  
								$cntresults = $counttree->result();
								if($sdata !="Empathy-Admin"){
									$position   = $cntresults[0]->position;
								}
				
								$modalID     		= $getLevel2[0]->bpID;
								$Level              = $getLevel2[0]->level;
								$directMemberCode   = $getLevel2[0]->directMemberCode;
								$underBy            = $getProcess[0]->membercode_left;
								$sponsorMemberCode  = $getProcess[0]->sponsorMemberCode;
							?>

							<?php	
								$sdata1 = $getLevel2[0]->membercode_left;
								$getmemberdata =  $this->db->query("select * from biowash_members where member_code='$sdata1'");  
								$memberdata = $getmemberdata->result();

								$package    = $memberdata[0]->package_type;

								if($package == 1){
									$pack = 'ekit';
								}else if($package==2){
									$pack = 'silver';
								}else if($package==3){
									$pack = 'gold';
								}else if($package==4){
									$pack = 'platinum';
								} else{
									$pack = 'available';
								}

							?>

								<?php if($getLevel2[0]->membercode_left==""){?>
									<li><a href=""" data-toggle="modal" data-target="#adddownlineleft<?php echo $modalID;?>"><div class="user available"> <i class="fa fa-user-circle fa-5x" aria-hidden="true"></i></div> </a></li>
								<?php } else { ?>
								<li>
                                    <a href="#" >
									<div class="container-fluid <?php echo $pack;?>">
										<center>
								    	<i class="fa fa-user-circle fa-5x" aria-hidden="true"></i>
											<?php echo $getLevel2[0]->membercode_left;?>
										</center>
										</div>
                                   </a>
									<?php 		// <!-- LEVEL 3 LEFT--> //
												$directcode   		 = $getLevel2[0]->membercode_left;
												$binarylevel3  		 = $this->db->query("select * from biowash_binary_process where directMemberCode='$directcode'"); 
												$getcntlevel3  		 = $binarylevel3->num_rows();
												$getLevel3    		 = $binarylevel3->result();
												
												$this->load->view('user/header');
												$this->load->view('user/binary/left_leg/3rd_level', array("getLevel3"=>$getLevel3));
									?>
								<!-- END LEVEL 3-->
                                </li>
								<?php } ?>

								<?php	
								$sdata2 = $getLevel2[0]->membercode_right;
								$getmemberdata1 =  $this->db->query("select * from biowash_members where member_code='$sdata2'");  
								$memberdata1 = $getmemberdata1->result();

								$package1    = $memberdata1[0]->package_type;

								if($package1 == 1){
									$pack1 = 'ekit';
								}else if($package1==2){
									$pack1 = 'silver';
								}else if($package1==3){
									$pack1 = 'gold';
								}else if($package1==4){
									$pack1 = 'platinum';
								} else{
									$pack1 = 'available';
								}

								?>
								<!--  RIGHT  --->
								<?php if($getLevel2[0]->membercode_right ==""){?>
									<li><a href="" data-toggle="modal" data-target="#adddownlineright<?php echo $modalID;?>"><div class="user available"> <i class="fa fa-user-circle fa-5x" aria-hidden="true"></i></div> </a></li>
								<?php } else { ?>
								<li>
									<a href="#">
									<div class="container-fluid <?php echo $pack1;?>">
										<center><div style="height:0px;"></div>
										<i class="fa fa-user-circle fa-5x" aria-hidden="true"></i>
										<?php echo $getLevel2[0]->membercode_right;?>
										</center>
									</div>
									</a>
									<?php 		// <!-- LEVEL 3 RIGHT--> //
												$directcode   		 = $getLevel2[0]->membercode_right;
												$binarylevel3  		 = $this->db->query("select * from biowash_binary_process where directMemberCode='$directcode' "); 
												$getcntlevel3  		 = $binarylevel3->num_rows();
												$getLevel3    		 = $binarylevel3->result();
												$this->load->view('user/header');
												$this->load->view('user/binary/left_leg/3rd_level_1', array("getLevel3"=>$getLevel3));
									?>
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
										   <?php if($_GET['data']=='Empathy-Admin'){?>
											<input type="hidden" value="1" class="form-control" name="cnt" required>
											<?php } else { 
												if($Level ==2 && $position=='Left'){
											?>
												<input type="hidden" value="1" class="form-control" name="cnt" required>
											<?php } else if($Level ==2 && $position=='Right'){ ?>
												<input type="hidden" value="1" class="form-control" name="cnt" required>
											<?php } ?>
											<?php } ?>
											<input type="hidden" class="form-control" name="bpID" value="<?php echo $modalID;?>" required>
											<input type="hidden" class="form-control" name="level" value="<?php echo $Level;?>" required>
											<input type="hidden" class="form-control" name="directMemberCode" value="<?php echo $directMemberCode;?>" required>
											<input type="hidden" class="form-control" name="underBy" value="<?php echo $underBy;?>" required>
											<input type="hidden" class="form-control" name="sponsorMemberCode" value="<?php echo $sponsorMemberCode;?>" required>
												<?php if($sdata =="Empathy-Admin"){?>
												<input type="hidden" class="form-control" name="position" value="Left" required>
												<?php } else { ?>
												<input type="hidden" class="form-control" name="position" value="<?php echo $position;?>" required>
												<?php } ?>
											<input type="hidden" class="form-control" name="secondaryPosition" value="Left" required>
											<input type="hidden" class="form-control" name="callback" value="<?php echo $_GET['data'];?>">
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
											<?php if($_GET['data']=='Empathy-Admin'){?>
											<input type="hidden" value="2" class="form-control" name="cnt" required>
											<?php } else { 
												if($Level ==2 && $position=='Left'){
											?>
												<input type="hidden" value="2" class="form-control" name="cnt" required>
											<?php } else if($Level ==2 && $position=='Right'){ ?>
												<input type="hidden" value="2" class="form-control" name="cnt" required>
											<?php } ?>
											<?php } ?>
											<input type="hidden" class="form-control" name="bpID" value="<?php echo $modalID;?>" required>
											<input type="hidden" class="form-control" name="level" value="<?php echo $Level;?>" required>
											<input type="hidden" class="form-control" name="directMemberCode" value="<?php echo $directMemberCode;?>" required>
											<input type="hidden" class="form-control" name="underBy" value="<?php echo $underBy;?>" required>
											<input type="hidden" class="form-control" name="sponsorMemberCode" value="<?php echo $sponsorMemberCode;?>" required>
												<?php if($sdata =="Empathy-Admin"){?>
												<input type="hidden" class="form-control" name="position" value="Left" required>
												<?php } else { ?>
												<input type="hidden" class="form-control" name="position" value="<?php echo $position;?>" required>
												<?php } ?>
											<input type="hidden" class="form-control" name="secondaryPosition" value="Right" required>
											<input type="hidden" class="form-control" name="callback" value="<?php echo $_GET['data'];?>">
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
