	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>MY WALLET TRANSACTION </h4>
                  </div>
                  <div class="card-body">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link " href="<?php echo site_url("user/wallet");?>">WALLET</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url("user/wallet/withdrawal");?>">WITHDRAWAL</a>
                      </li> 
				          	  <li class="nav-item">
                        <a class="nav-link active" href="<?php echo site_url("user/wallet/earnhistory");?>">EARNING HISTORY</a>
                      </li>
                     
                    </ul> 
					        <br>	
		          			<ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" href="<?php echo site_url("user/wallet/earnhistory");?>">DIRECT REFERRAL</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link " href="<?php echo site_url("user/wallet/indirect");?>">IN-DIRECT REFERRAL</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url("user/wallet/binary");?>">BINARY</a>
                      </li> 
                      <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url("user/wallet/empathy");?>">PASS UP</a>
                      </li> 
                      <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url("user/wallet/gc");?>">GIFT CERTIFICATE</a>
                      </li> 
                    </ul> 
				          	<br>	
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="genealogy-table">
                        <thead>
                          <tr>
                            <th class="text-center"> EARNING FROM     </th>
                            <th class="text-center"> EARNING AMOUNT   </th>
                            <th class="text-center"> PACKAGE AMOUNT   </th>
                            <th class="text-center"> EARN DATE        </th>
                          </tr>
                        </thead>
                      <tbody>
                        <?php foreach($earnhistory as $val => $row){?>
                        <tr>
                          <td class="text-center"><?php echo $row->earnfrom;?></td>
                          <td class="text-center"><?php echo '₱ '. number_format($row->earnamount,2);?></td>
                          <td class="text-center"><?php echo '₱ '. number_format($row->packageamount,2);?></td>
                          <td class="text-center"><?php echo $row->dateearn;?></td>
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
	  		