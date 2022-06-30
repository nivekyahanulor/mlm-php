	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
			  	<div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>MY PRODUCTS INFORMATION </h4>
                  </div>
                  <div class="card-body">
                   
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="genealogy-table">
                        <thead>
                          <tr>
                            <th class="text-center">                    </th>
                            <th class="text-center"> PRODUCT NAME       </th>
                            <th class="text-center"> QUANTITY  			</th>
                            <th class="text-center"> TOTAL AMOUNT       </th>
                            <th class="text-center"> PURCHASED DATE     </th>
                          </tr>
                        </thead>
						<tbody>
							<?php foreach($genealogy as $val => $row){?>
							<tr>
							<td class="text-center"><a href="<?php echo site_url('user/referrals?code='.$row->member_code);?>"><img src="<?php echo base_url()."assets/img/icon.png";?>"  width="70"></a></td>
							<td class="text-center"><?php echo $row->firstname .' '. $row->lastname;?></td>
							<td class="text-center"><?php echo $row->emailaddress;?></td>
							<td class="text-center"><?php echo $row->contactnumber;?></td>
							<td class="text-center"><?php echo $row->username;?></td>
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
      </div>  
	  		