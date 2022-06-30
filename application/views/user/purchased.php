	<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
			  	<div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>PURCHASED PRODUCTS INFORMATION </h4>
                  </div>
                  <div class="card-body">
                    
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="genealogy-table">
                        <thead>
                          <tr>
                            <th class="text-center"> TRANSACTION CODE  </th>
                            <th class="text-center"> DELIVERY OPTION   </th>
                            <th class="text-center"> DELIVERY ADDRESS  </th>
                            <th class="text-center"> TRANSACTION DATE  </th>
                            <th class="text-center"> STATUS            </th>
                          </tr>
                        </thead>
                          <tbody>
                            <?php foreach($product as $val => $row){?>
                            <tr>
                            <td class="text-center"><a href="<?php echo site_url('user/myproducts/view_purchased/'.$row->transcode);?>"><button class="btn btn-primary btn-md" style="width:100%"><i class="fas fa-barcode"></i> <?php echo $row->transcode;?></button></a></td>
                            <td class="text-center"><?php if($row->deliveryoption=='cod'){ echo 'Cash On Delivery'; } else { echo 'For Delivery'; };?></td>
                            <td class="text-center"><?php echo $row->deliveryaddress;?></td>
                            <td class="text-center"><?php echo $row->checkout_date;?></td>
                            <td class="text-center"><?php  if($row->order_status == 0) { echo 'PENDING'; } else if($row->order_status == 1) { echo 'APPROVED'; } else if($row->order_status == 2) { echo 'DECLINED'; } ?></td>
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
	  		