						<ul>
						<?php 
						$sdata      = $_GET['data'];
						$counttree  = $this->db->query("select * from biowash_binary_process where directMemberCode='$sdata'");  
						$cntresults = $counttree->result();
						if($sdata !="Empathy-Admin"){
									$position   = $cntresults[0]->position;
						}
						$modalID     		 = $getLevel3[0]->bpID;
						$Level               = $getLevel3[0]->level;
						$directMemberCode    = $getLevel3[0]->directMemberCode;
						$sponsorMemberCode   = $getLevel2[0]->sponsorMemberCode;
						$underBy             = $getLevel2[0]->membercode_right;
						if($getLevel3[0]->membercode_left==""){?>
					
							<li><a href="" data-toggle="modal" data-target="#adddownlineleft<?php echo $modalID;?>"><div class="user available"> <i class="fa fa-user-circle fa-5x" aria-hidden="true"></i></div> </a></li>
						<?php } else { ?>
							<?php	
								$sdata1 = $getLevel3[0]->membercode_left;
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
							<li>
							<a href="#">
							<div class="container-fluid <?php echo $pack;?>">
									<center><div style="height:2px;"></div>
									<i class="fa fa-user-circle fa-5x" aria-hidden="true"></i>
									<?php echo $getLevel3[0]->membercode_left;?>
								 </center>
								</div>
							</a>
							<?php // <!-- LEVEL 4 LEFT-->//
											$directcode         = $getLevel3[0]->membercode_left;
											$binarylevel4  		 = $this->db->query("select * from biowash_binary_process where directMemberCode='$directcode'"); 
											$getcntlevel4       = $binarylevel4->num_rows();
											$getLevel4    	    = $binarylevel4->result();
											$this->load->view('user/header');
											$this->load->view('user/binary/left_leg/4th_level_2', array("getLevel4"=>$getLevel4));
							?>
							</li>
							<?php } ?>
							<?php if($getLevel3[0]->membercode_right==""){?>
								<li><a href=""  data-toggle="modal" data-target="#adddownlineright<?php echo $modalID;?>"><div class="user available"> <i class="fa fa-user-circle fa-5x" aria-hidden="true"></i></div> </a></li>
							<?php } else { ?>
								<li>
								<?php	
									$sdata2 = $getLevel3[0]->membercode_right;
									$getmemberdata2 =  $this->db->query("select * from biowash_members where member_code='$sdata2'");  
									$memberdata2 = $getmemberdata2->result();

									$package2    = $memberdata2[0]->package_type;

									if($package2 == 1){
										$pack2 = 'ekit';
									}else if($package2==2){
										$pack2 = 'silver';
									}else if($package2==3){
										$pack2 = 'gold';
									}else if($package2==4){
										$pack2 = 'platinum';
									} else{
										$pack2 = 'available';
									}
								?>
									<a href="#" >
									<div class="container-fluid <?php echo $pack2;?>">
										<center>
								    	<i class="fa fa-user-circle fa-5x" aria-hidden="true"></i>
											<?php echo $getLevel3[0]->membercode_right;?>
										</center>
									</div>
									</a>
									<?php // <!-- LEVEL 4 LEFT-->//
											$directcode         = $getLevel3[0]->membercode_right;
											$binarylevel4  		 = $this->db->query("select * from biowash_binary_process where directMemberCode='$directcode'"); 
											$getcntlevel4       = $binarylevel4->num_rows();
											$getLevel4    	    = $binarylevel4->result();
											$this->load->view('user/header');
											$this->load->view('user/binary/left_leg/4th_level_3', array("getLevel4"=>$getLevel4));
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
											<input type="hidden" value="3" class="form-control" name="cnt" required>
											<?php } else { 
												if($Level ==3 && $position=='Left'){
											?>
												<input type="hidden" value="3" class="form-control" name="cnt" required>
											<?php } else if($Level ==3 && $position=='Right'){ ?>
												<input type="hidden" value="3" class="form-control" name="cnt" required>
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
											<input type="hidden" value="4" class="form-control" name="cnt" required>
											<?php } else { 
												if($Level ==3 && $position=='Left'){
											?>
												<input type="hidden" value="4" class="form-control" name="cnt" required>
											<?php } else if($Level ==3 && $position=='Right'){ ?>
												<input type="hidden" value="4" class="form-control" name="cnt" required>
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
