<?php $this->load->view('user/binary/binary_css'); ?>
<body translate="no" >
<div class="container-fluid main-container d- align-items-center justify-content-center" style="margin-top:20px;">
<div class="row justify-content-center">
 <div class="col-md-5" align="center">
			<form method="get" >
				<div class="form-group">
						<label> Search Binary Tree : </label>
						<div class="input-group ">
							<input type="text" class="form-control" name="data" value="" required>
							<input type="hidden" value="search" class="form-control" name="search" required>
							<button type="submit" class="btn btn-primary" >SEARCH</button>
						</div>
				</div> 
			</form>		
		</div>
		
</div>
</div>

<div class="container-fluid main-container d- align-items-center justify-content-center" style="margin-top:20px;">
	<div class="row justify-content-center text-center">
	<div class="col-sm-2 col-md-2 col-lg-2">
        <div class="card ekit"><br>
             <h4>  <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i> <br>E-KIT </h4>
		</div>
	</div>
	<div class="col-sm-2 col-md-2 col-lg-2">
        <div class="card silver"><br>
             <h4>  <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i> <br>SILVER</h4>
		</div>
	</div>
	<div class="col-sm-2 col-md-2 col-lg-2">
        <div class="card gold"><br>
             <h4>  <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i> <br>GOLD</h4>
		</div>
	</div>
	<div class="col-sm-2 col-md-2 col-lg-2">
        <div class="card platinum"><br>
             <h4>  <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i> <br>PLATINUM</h4>
		</div>
	</div>
	<div class="col-sm-2 col-md-2 col-lg-2">
        <div class="card available"><br>
             <h4>  <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i> <br>AVAILABLE</h4>
		</div>
	</div>
	</div>
</div>


<div class="container-fluid main-container d-flex align-items-center justify-content-center" style="margin-top:20px;">

    <div class="row">

        <div class="col-md-12" align="center">
			<?php 
				$userid      = $this->session->userdata['logged_in']['userid'];
				$getflushout = $this->db->query("select * from biowash_members where memberID='$userid'");  
				$flushresult = $getflushout->result();
				if( $flushresult[0]->flashOut==0){
				
				}
			?>
			
            <div class="tree">
                <ul>
                    <li> 
					<?php 
					$sdata      = $_GET['data'];
					$counttree  = $this->db->query("select * from biowash_binary_process where directMemberCode='$sdata'");  
					$cntresults = $counttree->result();

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
					
					if($sdata !="Empathy-Admin"){
						$position   = $cntresults[0]->position;
					}
					?>
                       <strong>
					   <?php if($cntresults[0]->count_left ==0){ ?>
					   <button href="#" class="btn btn-md" data-toggle="modal" data-target="#autoleft" disabled>
						<font size="4"><?php echo $cntresults[0]->count_left;?> </font> </button>
					   <?php } else { ?>
					  <button href="#" class="btn btn-md" data-toggle="modal" data-target="#autoleft" ><font size="4">  <?php echo $cntresults[0]->count_left;?> </font></button>
					   <?php } ?>
					   </strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="#">
                            <div class="container-fluid <?php echo $pack;?>">
								<center><div style="height:2px;"></div>
									<i class="fa fa-user-circle fa-6x" aria-hidden="true"></i>
									<br>
									<?php echo $_GET['data'];?>
								<center>
                            </div>
                        </a> 
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
						<strong>
						<?php if($cntresults[0]->count_right ==0){ ?>
						<button href="#" data-toggle="modal" data-target="#autoright" class="btn btn-md" disabled><font size="4">  <?php echo $cntresults[0]->count_right;?></font></button>   </font> 
						<?php } else { ?>
						<button href="#" data-toggle="modal" data-target="#autoright" class="btn btn-md" ><font size="4">  <?php echo $cntresults[0]->count_right;?>  </button>    
						<?php } ?>
						</font></strong>
							<?php //** For Level 1 LEFT--> ** //
								if(isset($_GET['search'])){
								$data               = $_GET['data'];
								$checkbinary        = $this->db->query("select * from biowash_binary_process where directMemberCode='$data'"); 
								} else {
									$code               = $this->session->userdata['logged_in']['code'];
									$data               = $_GET['data'];
									if($data == 'Empathy-Admin'){
									$checkbinary        = $this->db->query("select * from biowash_binary_process where directMemberCode='$code'"); 
									} else {
									$datas              = $_GET['data'];
									$checkbinary        = $this->db->query("select * from biowash_binary_process where directMemberCode='$datas'"); 
									}
								}
								$getcnt             = $checkbinary->num_rows();
								$getProcess         = $checkbinary->result();
								$modalID            = $getProcess[0]->bpID;
								$Level              = $getProcess[0]->level;
								$directMemberCode   = $_GET['data'];
								$underBy            = $getProcess[0]->membercode_left;
								$sponsorMemberCode  = $getProcess[0]->sponsorMemberCode;
								$modalID            = $getProcess[0]->bpID;
								if($getcnt == 0){ } else {
							?>
							<ul>
							<!-- LEF LEG --->
						
							<?php $this->load->view('user/binary/left_leg/1st_level', array("getProcess"=>$getProcess));?>
							<!-- RIGHT LEG --->
							<?php $this->load->view('user/binary/right_leg/1st_level', array("getProcess"=>$getProcess));?>
							</ul>
						<?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<!--- FOR TOP LEVEL -->
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
												<input type="hidden" value="1" class="form-control" name="cnt" required>
												<?php if($_GET['data']=='Empathy-Admin'){?>
													<input type="hidden" value="1" class="form-control" name="cnt" required>
												<?php } else { 
													if($Level ==1 && $position=='Right' || $position=='Left'){
													?>
													<input type="hidden" value="1" class="form-control" name="cnt" required>
												<?php } ?>
												<?php } ?>
											    <input type="hidden" class="form-control" name="bpID" value="<?php echo $modalID;?>" required>
												<input type="hidden" class="form-control" name="level" value="<?php echo $Level;?>" required>
												<input type="hidden" class="form-control" name="directMemberCode" value="<?php echo $directMemberCode;?>" >
												<input type="hidden" class="form-control" name="underBy" value="<?php echo $underBy;?>" >
												<input type="hidden" class="form-control" name="sponsorMemberCode" value="<?php echo $sponsorMemberCode;?>" >
												<?php if($sdata =="Empathy-Admin"){?>
												<input type="hidden" class="form-control" name="position" value="Left" required>
												<?php } else { ?>
												<input type="hidden" class="form-control" name="position" value="<?php echo $position;?>" required>
												<?php } ?>
												<input type="hidden" class="form-control" name="secondaryPosition" value="Left" >
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
											    <?php if($_GET['data']=='Empathy-Admin'){?>
													<input type="hidden" value="1" class="form-control" name="cnt" required>
												<?php } else { 
													if($Level ==1 && $position=='Right' || $position=='Left'){
													?>
													<input type="hidden" value="2" class="form-control" name="cnt" required>
												<?php } ?>
												<?php } ?>
												<?php if($sdata =="Empathy-Admin"){?>
											    <input type="hidden" class="form-control" name="position" value="Right" required>
												<?php } else { ?>
												<input type="hidden" class="form-control" name="position" value="<?php echo $position;?>" required>
												<?php } ?>
										        <input type="hidden" class="form-control" name="bpID" value="<?php echo $modalID;?>" required>
											    <input type="hidden" class="form-control" name="level" value="<?php echo $Level;?>" required>
											 	<input type="hidden" class="form-control" name="directMemberCode" value="<?php echo $directMemberCode;?>" >
												<input type="hidden" class="form-control" name="underBy" value="<?php echo $underBy;?>" >
												<input type="hidden" class="form-control" name="sponsorMemberCode" value="<?php echo $sponsorMemberCode;?>" >
												<input type="hidden" class="form-control" name="secondaryPosition" value="Right" >
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
							
							<div class="modal fade " id="autoleft" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog" role="document">
									<div class="modal-content">
									  <div class="modal-header bg-whitesmoke">
										<h5 class="modal-title" id="exampleModalLabel">BINARY DATA</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									  </div>
									  <div class="modal-body">
										<form action="<?php echo site_url('process-binary-auto');?>" method="post" enctype="multipart/form-data">
										  <div class="form-group">
											<label> BINARY CODE : </label>
											<div class="input-group ">
											    <input type="text" class="form-control" name="binarycode" required>
												<?php if($sdata =="Empathy-Admin"){?>
												<input type="hidden" class="form-control" name="position" value="Left" required>
												<?php } else { ?>
												<input type="hidden" class="form-control" name="position" value="<?php echo $position;?>" required>
												<?php } ?>
												<input type="hidden" class="form-control" name="package_type" value="<?php echo $this->session->userdata['logged_in']['package_type'];?>">
												<input type="hidden" class="form-control" name="callback" value="<?php echo $_GET['data'];?>">
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

							<div class="modal fade " id="autoright" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog" role="document">
									<div class="modal-content">
									  <div class="modal-header bg-whitesmoke">
										<h5 class="modal-title" id="exampleModalLabel">BINARY DATA</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									  </div>
									  <div class="modal-body">
										<form action="<?php echo site_url('process-binary-auto');?>" method="post" enctype="multipart/form-data">
										  <div class="form-group">
											<label> BINARY CODE : </label>
											<div class="input-group ">
											    <input type="text" class="form-control" name="binarycode" required>
												<?php if($sdata =="Empathy-Admin"){?>
											    <input type="hidden" class="form-control" name="position" value="Right" required>
												<?php } else { ?>
												<input type="hidden" class="form-control" name="position" value="<?php echo $position;?>" required>
												<?php } ?>
												<input type="hidden" class="form-control" name="package_type" value="<?php echo $this->session->userdata['logged_in']['package_type'];?>">
												<input type="hidden" class="form-control" name="callback" value="<?php echo $_GET['data'];?>">
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

