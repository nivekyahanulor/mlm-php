	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>GENEALOGY INFORMATION </h4>
                  </div>
                  <div class="card-body">

                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="genealogy-table">
                        <thead>
                          <tr>
                            <th class="text-center">                 </th>
                            <th class="text-center"> FULL NAME       </th>
                            <th class="text-center"> EMAIL ADDRESS   </th>
                            <th class="text-center"> CONTACT #       </th>
                            <th class="text-center"> USER NAME       </th>
                            <th class="text-center"> REF CODE        </th>
                            <th class="text-center"> REFERRALS       </th>
                          </tr>
                        </thead>
						<tbody>
							<?php foreach($referral as $val => $row){?>
							<tr>
							<td class="text-center"><a href="<?php echo site_url('user/referrals?code='.$row->member_code);?>"><img src="<?php echo base_url()."assets/img/icon.png";?>"  width="70"></a></td>
							<td class="text-center"><?php echo $row->firstname .' '. $row->lastname;?></td>
							<td class="text-center"><?php echo $row->emailaddress;?></td>
							<td class="text-center"><?php echo $row->contactnumber;?></td>
							<td class="text-center"><?php echo $row->username;?></td>
							<td class="text-center"><?php echo $row->member_code;?></td>
							<td class="text-center"><button class="btn btn-info btn-sm"><?php echo $row->ref_cnt;?></button></td>
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
	  		