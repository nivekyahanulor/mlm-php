	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>GENEALOGY INFORMATION </h4>
                  </div>
				  <?php $code    	 = $this->session->userdata['logged_in']['code'];?>
                  <div class="card-body">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a href="<?php echo site_url("user/genealogy");?>" class="nav-link " >DIRECT REFERRAL</a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo site_url("user/genealogy");?>" class="nav-link " >IN-DIRECT REFERRAL</a>
                      </li>
                      <li class="nav-item">
                        <a href="<?php echo site_url("user/genealogy/binary");?>" class="nav-link active" >BINARY</a>
                      </li>
                    
                    </ul><br><br>
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="genealogy-table">
                        <thead>
                          <tr>
                            <th class="text-center"> BINARY DATA     </th>
                            <th class="text-center"> DATE ADDED    </th>
                          </tr>
                        </thead>
						<tbody>
							<?php if($code=='mell'){?>
								<tr>
									<td class="text-center">
										<a href="<?php echo site_url("user/genealogy/binary_tree?data=mell");?>" target="_blank"><button class="btn btn-info btn-md">mell </button></a>
									</td>	
									<td></td>
								</tr>
							<?php }?>
							<?php 
							$binarycoder = $this->db->query("select * from biowash_binary_codes where membercode='$code' and isUsed=1");
							foreach($binarycoder->result() as $val => $row){?>
							<tr>
								<td class="text-center">
									<a href="<?php echo site_url("user/genealogy/binary_tree?data=".$code.'-'.$row->transactioncode);?>" target="_blank"><?php echo $code.'-'.$row->transactioncode;?></a>
								</td>	
								<td class="text-center">
									<?php echo $row->date_added;?>
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
	  		