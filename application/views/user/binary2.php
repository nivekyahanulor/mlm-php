<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<style>
* {
  margin: 0;
  padding: 0;
}

body {
  background: #22659c;
}

.org-chart {
  display: -webkit-box;
  display: flex;
  -webkit-box-pack: center;
          justify-content: center;
}
.org-chart ul {
  padding-top: 20px;
  position: relative;
  -webkit-transition: all 0.5s;
  transition: all 0.5s;
}
.org-chart ul ul::before {
  content: '';
  position: absolute;
  top: 0;
  left: 50%;
  border-left: 1px solid #ccc;
  width: 0;
}
.org-chart li {
  float: left;
  text-align: center;
  list-style-type: none;
  position: relative;
  padding: 20px 10px;
  -webkit-transition: all 0.5s;
  transition: all 0.5s;
}
.org-chart li::before, .org-chart li::after {
  content: '';
  position: absolute;
  top: 0;
  right: 50%;
  border-top: 1px solid #ccc;
  width: 50%;
  height: 20px;
}
.org-chart li::after {
  right: auto;
  left: 50%;
  border-left: 1px solid #ccc;
}
.org-chart li:only-child::after, .org-chart li:only-child::before {
  display: none;
}
.org-chart li:only-child {
  padding-top: 0;
}
.org-chart li:first-child::before, .org-chart li:last-child::after {
  border: 0 none;
}
.org-chart li:last-child::before {
  border-right: 1px solid #ccc;
  border-radius: 0 5px 0 0;
}
.org-chart li:first-child::after {
  border-radius: 5px 0 0 0;
}
.org-chart li .user {
  text-decoration: none;
  color: #666;
  display: inline-block;
  padding: 20px 10px;
  -webkit-transition: all 0.5s;
  transition: all 0.5s;
  background: #fff;
  min-width: 180px;
  border-radius: 6px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
}
.org-chart li .user:hover, .org-chart li .user:hover + ul li .user {
  background: #b5d5ef;
  color: #002A50;
  -webkit-transition: all 0.15s;
  transition: all 0.15s;
  -webkit-transform: translateY(-5px);
          transform: translateY(-5px);
  box-shadow: inset 0 0 0 3px #76b1e1, 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}
.org-chart li .user:hover img, .org-chart li .user:hover + ul li .user img {
  box-shadow: 0 0 0 5px #4c99d8;
}
.org-chart li .user:hover + ul li::after,
.org-chart li .user:hover + ul li::before,
.org-chart li .user:hover + ul::before,
.org-chart li .user:hover + ul ul::before {
  border-color: #94a0b4;
}
.org-chart li .user > div, .org-chart li .user > a {
  font-size: 12px;
}
.org-chart li .user img {
  margin: 0 auto;
  max-width: 60px;
  max-width: 60px;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  box-shadow: 0 0 0 5px #aaa;
}
.org-chart li .user .name {
  font-size: 16px;
  margin: 15px 0 0;
  font-weight: 300;
}
.org-chart li .user .role {
  font-weight: 600;
  margin-bottom: 10px;
  margin-top: 5px;
}
.org-chart li .user .manager {
  font-size: 12px;
  color: #b21e04;
}
</style>
</head>
<body translate="no" >
  <div class="pg-orgchart">
  <?php if(isset($_GET['errorcode'])){ echo '<center><div class="alert alert-danger"> Code not Found! Please Try Again! </div></center>';}?>

	<div class="org-chart">
		<ul>
      <li>
        <div class="user">
          <div class="name"><?php echo $this->session->userdata['logged_in']['name'];?></div>
          <div class="role"><a href="#" data-toggle="modal" data-target="#adddownline">(<?php echo $this->session->userdata['logged_in']['code'];?>)</a></div>

		</div>
		<?php 
		$code          = $this->session->userdata['logged_in']['code'];
		$checkbinary   = $this->db->query("select * from biowash_binary_process where directMemberCode='$code'"); 
		$getcnt        = $checkbinary->num_rows();
		$getProcess    = $checkbinary->result();
		$modalID       = $getProcess[0]->bpID;
		$Level         = $getProcess[0]->level;
		if($getcnt == 0){ } else {
		?>
        <ul>
			
			<?php if($getProcess[0]->membercode_left==""){?>
			  <li>
			    <a href="" data-toggle="modal" data-target="#adddownlineleft<?php echo $modalID;?>">
				 <div class="user"></div>
				 </a>
			  </li>
			<?php } else { ?>
			<li>
				<div class="user">
				  <div class="name"><?php echo $getProcess[0]->membercode_left;?></div>
				</div>
				<!-- LEFT LEVEL 3  -->
				<?php 
				$directcode    = $getProcess[0]->membercode_left;
				$binarylevel2  = $this->db->query("select * from biowash_binary_process where directMemberCode='$directcode'"); 
				$getcntlevel2  = $binarylevel2->num_rows();
				$getLevel2     = $binarylevel2->result();
				$modalID       = $getLevel2[0]->bpID;
				$Level         = $getLevel2[0]->level;
				?>
				<ul>
				<?php if($getLevel2[0]->membercode_left==""){?>
				 <li><a href="" data-toggle="modal" data-target="#adddownlineleft<?php echo $modalID;?>"><div class="user"></div> </a></li>
				<?php } else { ?>
					  <li>
						<div class="user">
						   <div class="name"><?php echo $getLevel2[0]->membercode_left;?></div>
						</div>
						<!-- LEFT LEVEL 4  -->
								<?php 
								$directcode4   = $getLevel2[0]->membercode_left;
								$binarylevel3  = $this->db->query("select * from biowash_binary_process where directMemberCode='$directcode4'"); 
								$getcntlevel3  = $binarylevel3->num_rows();
								$getLevel3     = $binarylevel3->result();
								$modalID       = $getLevel3[0]->bpID;
								$Level         = $getLevel3[0]->level;
								?>
								<ul>
								<?php if($getLevel3[0]->membercode_left==""){?>
								 <li><a href="" data-toggle="modal" data-target="#adddownlineleft<?php echo $modalID;?>"><div class="user"></div> </a></li>
								<?php } else { ?>
									  <li>
										<div class="user">
										   <div class="name"><?php echo $getLevel3[0]->membercode_left;?></div>
										</div>
									  </li>
								<?php }?>
								<?php if($getLevel3[0]->membercode_right==""){?>
								 <li><a href="" data-toggle="modal" data-target="#adddownlineleft<?php echo $modalID;?>"><div class="user"></div> </a></li>
								<?php } else { ?>
									  <li>
										<div class="user">
										   <div class="name"><?php echo $getLevel3[0]->membercode_right;?></div>
										</div>
									  </li>
								<?php }?>
								</ul>
					  </li>
				<?php }?>
				<?php if($getLevel2[0]->membercode_right==""){?>
				 <li><a href="" data-toggle="modal" data-target="#adddownlineleft<?php echo $modalID;?>"><div class="user"></div> </a></li>
				<?php } else { ?>
					  <li>
						<div class="user">
						   <div class="name"><?php echo $getLevel2[0]->membercode_right;?></div>
						</div>
						<!-- LEFT LEVEL 4  -->
								<?php 
								$directcode4   = $getLevel2[0]->membercode_right;
								$binarylevel3  = $this->db->query("select * from biowash_binary_process where directMemberCode='$directcode4'"); 
								$getcntlevel3  = $binarylevel3->num_rows();
								$getLevel3     = $binarylevel3->result();
								$modalID       = $getLevel3[0]->bpID;
								$Level         = $getLevel3[0]->level;
								?>
								<ul>
								<?php if($getLevel3[0]->membercode_left==""){?>
								 <li><a href="" data-toggle="modal" data-target="#adddownlineleft<?php echo $modalID;?>"><div class="user"></div> </a></li>
								<?php } else { ?>
									  <li>
										<div class="user">
										   <div class="name"><?php echo $getLevel3[0]->membercode_left;?></div>
										</div>
									  </li>
								<?php }?>
								<?php if($getLevel3[0]->membercode_right==""){?>
								 <li><a href="" data-toggle="modal" data-target="#adddownlineleft<?php echo $modalID;?>"><div class="user"></div> </a></li>
								<?php } else { ?>
									  <li>
										<div class="user">
										   <div class="name"><?php echo $getLevel3[0]->membercode_right;?></div>
										</div>
									  </li>
								<?php }?>
								</ul>
					  </li>
				<?php }?>
				</ul>
				<!-- END LEFT LEVEL 3 -->
			  </li>
			<?php } 
			// RIGTH TOP LEVEL
			if($getProcess[0]->membercode_right==""){?>
			  <li>
			    <a href="" data-toggle="modal" data-target="#adddownlineright<?php echo $getProcess[0]->bpID;?>">
				 <div class="user"></div>
				 </a>
			  </li>
			<?php } else { ?>
			  <li>
				<div class="user">
				<div class="name"><?php echo $getProcess[0]->membercode_right;?></div>
				</div>
			  </li>
			<?php } ?>
        </ul>
		<?php } ?>
      </li>
    </ul>
	</div>
</div>
  
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
				<form action="<?php echo site_url('process-binary');?>" method="post" enctype="multipart/form-data">
				  <div class="form-group">
                    <label> BINARY CODE : </label>
                    <div class="input-group ">
                      <input type="text" class="form-control" name="binarycode" required>
                      <input type="text" class="form-control" name="bpID" value="<?php echo $modalID;?>" required>
                      <input type="text" class="form-control" name="level" value="<?php echo $Level;?>" required>
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
		 <div class="modal fade " id="adddownlineright<?php echo $getProcess[0]->bpID;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                      <input type="hidden" class="form-control" name="bpID" value="<?php echo $getProcess[0]->bpID;?>" required>
                      <input type="hidden" class="form-control" name="level" value="<?php echo $getProcess[0]->level;?>" required>
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
</body>

</html>
 
