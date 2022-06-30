      <!-- Main Content -->
      <div class="main-content">
	  
        <section class="section">
				<?php  
						foreach($floating as $f => $ff){ $totalfloat += $ff->floatamount;}
						foreach($purchased as $p => $pp){ $totalpurchased += $pp->purchasedQty;}
						$wallets = $totalwithdraw-$totalearn;
						$totalearnings = $wallet[0]->balance - $wallet[0]->withdrawals;
						if($totalearnings<0){
							$te = 0;
						} else {
							$te = $totalearnings;
						}
						
						
				?>
		       <div class="row ">
              <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-green">
                  <div class="card-statistic-3">
                    <div class="card-icon card-icon-large"><i class="fa fa-award"></i></div>
                    <div class="card-content">
                      <h4 class="card-title">Earnings</h4>
                      <h2 class="mb-3 font-30"><b><?php  echo '₱ '. number_format($te,2);?></b></h2>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-cyan">
                  <div class="card-statistic-3">
                    <div class="card-icon card-icon-large"><i class="fa fa-briefcase"></i></div>
                    <div class="card-content">
                      <h4 class="card-title">Share Points</h4>
                      <h2 class="mb-3 font-30">
                         <b>
						 <?php 
							echo '₱ '. number_format($wallet[0]->points,2);
						 ?>
						 </b>
					  </h2>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-purple">
                  <div class="card-statistic-3">
                    <div class="card-icon card-icon-large"><i class="fa fa-globe"></i></div>
                    <div class="card-content">
                      <h4 class="card-title">Invites</h4>
                      <h2 class="mb-3 font-30"><b><?php echo $membercnt;?></b></h2>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card l-bg-orange">
                  <div class="card-statistic-3">
                    <div class="card-icon card-icon-large"><i class="fa fa-money-bill-alt"></i></div>
                    <div class="card-content">
                      <h4 class="card-title">Withdrawal</h4>
                      <h2 class="mb-3 font-30"><b><?php  echo '₱ '. number_format($wallet[0]->withdrawals,2);?></b></h2>
                     
                    </div>
                  </div>
                </div>
              </div>
            </div>
			<?php if($settings[0]->isActive_Top_Fiva_Endorser==1){?>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
				  <?php
				    $date1 = new DateTime($settings[0]->top_5_endorser_start_date);
				    $date2 = new DateTime($settings[0]->top_5_endorser_end_date);
				  ?>
                    <h4>TOP 5 ENDORSER FOR <b><u><?php echo strtoupper($date1->format('F d, Y ') .' - '. $date2->format('F d, Y '));?> </u></b></h4> 
                  </div>
                  <div class="card-body">
				  <?php if(isset($_GET['updated'])){ echo '<div class="alert alert-success"> Password successfully change !</div>';}?>
                    <div class="">
                       <table class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center"> MEMBER NAME     </th>
                            <th class="text-center"> TOTAL ENDORSE   </th>
                          </tr>
                        </thead>
						<tbody>
							<?php foreach($topfive as $val => $row){
								$refcode  = $row->referral_code;
								$getinfo  = $this->db->query("select * from biowash_members where member_code='$refcode'");
								$getres   = $getinfo->result();
								?>
							<tr>
								<td class="text-center"><?php echo $getres[0]->firstname .' '. $getres[0]->lastname;?></td>
								<td class="text-center"><?php echo $row->cnt;?></td>
							</tr>
							<?php } ?>
						</tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			<?php } ?>
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
                  </div>
                  <div class="card-body">
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
					   <?php if($userinfo[0]->isVerified ==0){ ?>
					    <div id="notverified"><font color="red" ><i class="fas fa-exclamation-circle"></i></font> Your Email is not verified click to <button id="verify" data-name="<?php echo $userinfo[0]->firstname .' '. $userinfo[0]->lastname;?>" data-email="<?php echo $userinfo[0]->emailaddress;?>"> Verify </button></div>
						<div id="sendingverification"></div>
					   <?php } else if($userinfo[0]->isVerified ==1){ ?>
						<div id="sendverification"><font color="red" ><i class="fas fa-chevron-circle-right"></i></font> Verification Link send to your Email Address <button id="resendlink" data-name="<?php echo $userinfo[0]->firstname .' '. $userinfo[0]->lastname;?>" data-email="<?php echo $userinfo[0]->emailaddress;?>"> Resend Link </button></div>
					  	<div id="resendingverification"></div>						
						<?php } else { ?>
						<font color="blue"><i class="fas fa-check-circle"></i></font> Account Verified! </a>
						 <?php } ?>
					  </div>
                    </div>
                  </div>
                </div>
                <div class="card author-box">
                  <div class="card-body">
                    <div class="author-box-center">
                      <div class="author-box-name">
						<i class="fas fa-link"></i> Referral Link : <a href="<?php echo base_url() .'referral/code/'. $userinfo[0]->member_code;?>" target="_blank"> <?php echo base_url() .'referral/code/'. $userinfo[0]->member_code;?></a>
						<br>
					   <button class="btn-clipboard btn" data-clipboard-text="<?php echo base_url() .'referral/code/'. $userinfo[0]->member_code;?>">
						<i class="far fa-copyright"> </i> Copy	</button>
						&nbsp;&nbsp;&nbsp;
						<div class="fb-share-button" data-href="<?php echo base_url() .'referral/code/'. $userinfo[0]->member_code;?>" data-type="button"></div>
					 </div>
                    </div>
                   
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Accounts Details</h4>
                  </div>
                  <div class="card-body">
                    <div class="py-1">
                      <p class="clearfix">
                        <span class="float-left">
                          <b>Invites :</b>
                        </span>
                        <span class="float-right text-muted">
                        <?php echo $membercnt;?>
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                        <b> Earning Balance</b>
                        </span>
                        <span class="float-right text-muted">
						<?php  echo '₱ '. number_format($te,2);?>
                        </span>
                      </p>
					  <p class="clearfix">
                        <span class="float-left">
                         <b>Product Purchased :</b>
						<br>
						<small> Re-purchased product to earn limit </small>
                        </span>
                        <span class="float-right text-muted">
                        <?php 
						 if($userinfo[0]->earn_level!=''){ 
							if($userinfo[0]->earn_level=='1101'){
								echo '---'; 
							} else{
								echo $userinfo[0]->earn_level; 
							}
						 }
						 else { echo '0'; };
						 ?>
                        </span>
                      </p>
					   <p class="clearfix">
                        <span class="float-left">
                        <b> Floating Earnings</b>
						<br>
						<small> Use Earn Points to claim Floating Earnings</small>
                        </span>
                        <span class="float-right text-muted">
						<?php echo '₱ '. number_format($totalfloat,2);?>
                        </span>
                      </p>
                     
                     
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
   