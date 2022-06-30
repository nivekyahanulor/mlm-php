	 <?php
		foreach($purchased as $a => $b){ $totalpurchased += $b->purchasedQty;}
		foreach($purchased as $aa => $bb){ $totalsales += $bb->purchasedTotal;}
	 ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
            <div class="row">
              <div class="col-xl-3 col-lg-6">
                <div class="card">
                  <div class="card-body card-type-3">
                    <div class="row">
                      <div class="col">
                        <h6 class="text-muted mb-0"> Purchased</h6>
                        <h1 class="mb-3 font-30"><?php  if($totalpurchased==''){ echo '0'; } else { echo $totalpurchased; }?></h1>
                      </div>
                      <div class="col-auto">
                        <div class="card-circle l-bg-orange text-white">
                          <i class="fas fa-clipboard-check"></i>
                        </div>
                      </div>
                    </div>
                  
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card">
                  <div class="card-body card-type-3">
                    <div class="row">
                      <div class="col">
                        <h6 class="text-muted mb-0">Members</h6>
                        <h1 class="mb-3 font-30"><?php echo $members;?></h1>
                      </div>
                      <div class="col-auto">
                        <div class="card-circle l-bg-cyan text-white">
                          <i class="fas fa-users"></i>
                        </div>
                      </div>
                    </div>
                 
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card">
                  <div class="card-body card-type-3">
                    <div class="row">
                      <div class="col">
                        <h6 class="text-muted mb-0">Products</h6>
                        <h1 class="mb-3 font-30"><?php echo $products;?></h1>
                      </div>
                      <div class="col-auto">
                        <div class="card-circle l-bg-green text-white">
                          <i class="fas fa-certificate"></i>
                        </div>
                      </div>
                    </div>
                  
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card">
                  <div class="card-body card-type-3">
                    <div class="row">
                      <div class="col">
                        <h6 class="text-muted mb-0">Sales</h6>
                        <h1 class="mb-3 font-30"><?php echo number_format($totalsales,0);?></h1>
                      </div>
                      <div class="col-auto">
                        <div class="card-circle l-bg-purple text-white">
                          <i class="fas fa-dollar-sign"></i>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
        </section>
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>TOP 5 ENDORSER </h4> 
					<button class="float-right btn btn-outline-primary" data-toggle="modal" data-target="#settop5endorser"> Set Top 5 Endorser </button></a>
					 <div class="form-group">
                      <div class="control-label">&nbsp;</div>
                      <label class="custom-switch mt-2">
						<?php 
						if($settings[0]->isActive_Top_Fiva_Endorser ==1){
							$switch='checked';
						} else {
							$switch='';
						}
						?>
                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" <?php echo $switch;?>>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Activate / Deactivate</span>
                      </label>
                    </div>
				 </div>
                  <div class="card-body">
				   <?php
				    $date1 = new DateTime($settings[0]->top_5_endorser_start_date);
				    $date2 = new DateTime($settings[0]->top_5_endorser_end_date);
				  ?>
				  TOP ENDORSER FOR <b><u><?php echo strtoupper($date1->format('F d, Y ') .' - '. $date2->format('F d, Y '));?> </u></b>
				  <?php if(isset($_GET['updated'])){ echo '<div class="alert alert-success"> Password successfully change !</div>';}?>
                    <div class="">
                       <table class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th class="text-center"> MEMBER NAME     </th>
                            <th class="text-center"> ENDORSE COUNT   </th>
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
         </div>
      </div>
  
          <div class="modal fade bd-example-modal-lg" id="settop5endorser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-whitesmoke">
                <h5 class="modal-title" id="exampleModalLabel">SELECT DATE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
			  <div id="cbuprocess"></div>
			  <div id="cbucontent">
				<form action="<?php echo site_url('savetop5endorser');?>" method="post" enctype="multipart/form-data">
                 
				  <div class="form-group">
                    <label> DATE FROM : </label>
                    <div class="input-group ">
                      <input type="date" class="form-control" name="datestart" value="<?php echo $settings[0]->top_5_endorser_start_date;?>" required>
                    </div>
                  </div> 
				  <div class="form-group">
                    <label> DATE END : </label>
                    <div class="input-group">
                      <input type="date" class="form-control" name="dateend"  value="<?php echo $settings[0]->top_5_endorser_end_date;?>" required>
                    </div>
                  </div>  
				
              <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-primary" >SAVE</button>
                <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
              </div>
              </div>
			  </form>
            </div>
            </div>
          </div>
        </div> 