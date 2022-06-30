							<?php
							
							$sdata = $getProcess[0]->membercode_left;
							$getmemberdata =  $this->db->query("select * from biowash_members where member_code='$sdata'");  
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
							
							<?php if($getProcess[0]->membercode_left==""){?>
							 <li>
								<a href="" data-toggle="modal" data-target="#adddataleft">
								<div class="user available"> <i class="fa fa-user-circle fa-5x" aria-hidden="true"></i></div> </a></li>
								 </a>
							</li>
							<?php } else { ?>
                            <li>
                                <a href="#">
								<div class="container-fluid <?php echo $pack;?>">
								<center><div style="height:0px;"></div>
								    	<i class="fa fa-user-circle fa-5x" aria-hidden="true"></i>
											<?php echo $getProcess[0]->membercode_left;?>
                                       </center>
                                    </div>
                                </a>
							<?php 
									// -- LEVEL 2 LEFT-- //
									$directcode   		= $getProcess[0]->membercode_left;
									$binarylevel2 		= $this->db->query("select * from biowash_binary_process where directMemberCode='$directcode'"); 
									$getcntlevel2 		= $binarylevel2->num_rows();
									$getLevel2   		= $binarylevel2->result();
									
									$this->load->view('user/header');
									$this->load->view('user/binary/left_leg/2nd_level', array("getLevel2"=>$getLevel2));
							?>
                            </li>
							<?php }?>
							