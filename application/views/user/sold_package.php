<div class="main-content">
          <div class="section-body">
        
            <div class="row">
          	
              <div class="col-12">
            
			  	<div class="col-12 col-sm-12 col-lg-12">
                
                <div class="card">
               
                  <div class="card-header">
                    <h4>PACKAGES LIST</h4>
                  </div>
                 
                  <div class="card-body">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link " href="<?php echo site_url("user/packages/mega");?>">PACKAGES</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link active" href="<?php echo site_url("user/packages/sold");?>">SOLD PACKAGES</a>
                            </li> 
                    </ul> 
					<br>
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="genealogy-table">
                        <thead>
                          <tr>
                            <th class="text-center"> PACKAGE  </th>
                            <th class="text-center"> DESCRIPTION  </th>
                            <th class="text-center"> PRICE  </th>
                            <th class="text-center"> CODE    </th>
                            <th class="text-center"> STATUS   </th>
                          </tr>
                        </thead>
                          <tbody>
                            <?php foreach($package as $val => $row){?>
                            <tr>
                                <td class="text-center"><?php echo $row->package_name;?></td>
                                <td class="text-center"><?php echo $row->package_description;?></td>
                                <td class="text-center"> PHP <?php echo $row->package_price;?></td>
                                <td class="text-center"><?php echo $row->package_code;?></td>
                                <td class="text-center">
                                    <button class="btn btn-success"  > SOLD </button>
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
      </div>  
	  		