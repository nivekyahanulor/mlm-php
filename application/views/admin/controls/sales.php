	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
				  <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" href="<?php echo site_url("administrator/reports/sales");?>"  >PRODUCT SALES REPORT</a>
                      </li>
					  <li class="nav-item">
                        <a class="nav-link " href="<?php echo site_url("administrator/reports/packages");?>"  >PACKAGE SALES REPORT</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url("administrator/reports/declined");?>" >DECLINE PURCHASE</a>
                      </li>
                     
                    </ul>
                  <div class="card-header">
                    <h4>SALES RECORDS (APPROVED) </h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="sales-report-data">
                        <thead>
                          <tr>
                            <th class="text-center"> PURCHASED PRODUCT    </th>
                            <th class="text-center"> PURCHASED BY         </th>
                            <th class="text-center"> QUANTITY             </th>
                            <th class="text-center"> TOTAL SALES          </th>
                            <th class="text-center"> DATE PURCHASED       </th>
                          </tr>
                        </thead>
						<tbody>
						<?php foreach ($sales as $row => $val){ ?>
							<tr>
								<td><?php echo $val->product_name;?> </td>
								<td><?php echo $val->firstname .' '. $val->lastname;?> </td>
								<td><?php echo $val->purchasedQty;?> </td>
								<td><?php echo number_format($val->purchasedTotal,2);?> </td>
								<td><?php echo $val->datepurchased;?> </td>
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
	  	