      <!-- Main Content -->
      <div class="main-content">
          <div class="row ">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card-content">
                          <h5 class="font-15">MY ORDER LIST</h5>
                        </div>
						<div class="card-body">
						<div class="table-">
							  <table class="table table-striped table-bordered"  width="100%">
								<thead>
								  <tr>
									<th class="text-center"> ORDER   </th>
								  </tr>
								</thead>
							  <tbody>
							    <?php foreach($orders as $a => $b){ 
										$qty   += $b->purchasedQty;
										$total += $b->purchasedTotal;
								?>
								<tr>
									<td> <button class="btn btn-warning btn-sm"  data-toggle="modal" data-target="#deletepurchase<?php echo $val->orderID;?>"> <i class="fas fa-trash"></i> </button>  
										 &nbsp;&nbsp; <b><?php echo $b->product_name .' x '.  $b->purchasedQty;?> </b>
										 <div style="float:right; font-color:blue;"><?php echo number_format($b->purchasedTotal,2);?></div>
									</td>
								</tr>
								 <div class="modal fade bd-example-modal-lg" id="deletepurchase<?php echo $val->orderID;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
								  <div class="modal-header bg-whitesmoke">
									<h5 class="modal-title" id="exampleModalLabel">DELETE PURCHASE ITEM</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									<form action="<?php echo site_url("remove-purchased");?>" method="post" >
									<center>
									<br>
									DELETE THIS ITEM ?
									<input type="hidden"  class="price form-control" name="orderID" value="<?php echo $b->orderID;?>" >
									<br>
									<br>
								    <div class="modal-footer bg-whitesmoke br">
										<button type="submit" class="btn btn-warning btn-purchase" ><i class="fas fa-trash"></i> YES</button>
										<button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
								    </div>
								  </form>
								</div>
								</div>
							  </div>
							</div> 
								<?php } ?>
								<tr >
									<td bgcolor=""> <b>  TOTAL :  <div style="float:right"><?php echo number_format($total,2);?> </div></b> </td>
								</tr>
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
           
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="card-content">
						<form action="<?php echo site_url("checkoutprocess");?>" method="post" enctype="multipart/form-data">
                        <h5 class="font-15">PAYMENT DETAILS : <br> <b>GRAND TOTAL : <?php echo number_format($total,2);?></b> </h5>
                        </div>
							<div class="form-group col-md-12">
								<label> SELECT DELIVERY OPTION  : </label>
								<div class="input-group">
								  <select type="text" class="form-control" name="deliveryoption" id="deliveryoption" required>
								  <option value=""> --- </option>
								  <option value="cod"> Cash On Delivery </option>
								  <option value="delivery"> For Deliver </option>
								  </select>
								</div>
							</div>  
							<div class="form-group col-md-12">
							<label> Delivery Address : </label>
							<div class="input-group">
							  <textarea type="text" class="form-control" name="deliveryaddress" required></textarea>
							</div>
							</div>
							<div class="form-group col-md-12" id="paymentmethod">
							<label> PAYMENT METHOD : </label>
							<div class="input-group">
							   <select type="text" class="form-control" name="paymentmethod" id="paymethod" >
								  <option value=""> --- </option>
								  <?php foreach($paymethod  as $row => $pay){?>
								  <option value="<?php echo $pay->payment_type;?>"> <?php echo $pay->payment_type;?> </option>
								  <?php } ?>
								</select>
							</div>
							</div>
							<div class="row">
							
							<div class="form-group col-md-6" id="payform" style="display:none;">
								<div class="form-group col-md-12">
								<label>Payment Transcode: </label>
								<div class="input-group">
								  <input type="text" class="form-control" name="paytranscode" id="paytranscode" ></input>
								</div>
								</div>
								<div class="form-group col-md-12">
								<label>Payment Name: </label>
								<div class="input-group">
								  <input type="text" class="form-control" name="payname" id="payname" ></input>
								</div>
								</div>
								<div class="form-group col-md-12">
								<label>Payment Amount: </label>
								<div class="input-group">
								  <input type="text" class="form-control" name="payamount"  id="payamount"></input>
								</div>
								</div>
								<div class="form-group col-md-12">
								<label>Upload Receipt: </label>
								<div class="input-group">
								  <input type="file" class="form-control" name="image" id="image"></input>
								</div>
								</div>
							</div>
							<div class="form-group col-md-6">
								<p><div id="payinfo"></div><p>
							</div>
							</div>
							<div class="modal-footer bg-whitesmoke br">
									<button type="submit" class="btn btn-primary" >PROCESS CHECKOUT</button>
							 </div>
						</form>
						</div>
                      </div>
                     
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
  
  