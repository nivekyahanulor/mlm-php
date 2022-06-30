	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
				  <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link " href="<?php echo site_url("administrator/reports/sales");?>"  >PRODUCT SALES REPORT</a>
                      </li>
					  <li class="nav-item">
                        <a class="nav-link active" href="<?php echo site_url("administrator/reports/packages");?>"  >PACKAGE SALES REPORT</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url("administrator/reports/declined");?>" >DECLINE PURCHASE</a>
                      </li>
                     
                    </ul>
                  <div class="card-header">
                    <h4>PACKAGE SALES RECORDS (APPROVED) </h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="sales-report-data">
                        <thead>
                          <tr>
                            <th class="text-center"> MEMBER    </th>
                            <th class="text-center"> PACKAGE        </th>
                            <th class="text-center"> PRICE             </th>
                            <th class="text-center"> DATE PURCHASED       </th>
                          </tr>
                        </thead>
						<tbody>
						<?php foreach ($sales as $row => $val){ ?>
							<tr>
								<td><?php echo $val->firstname .' '. $val->lastname;?> </td>
								<td><?php echo $val->package_name;?> </td>
								<td><?php echo $val->package_price;?> </td>
								<td><?php echo $val->date_added;?> </td>
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
	  	