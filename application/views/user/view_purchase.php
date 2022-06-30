<div style="height:100px"></div>
<div class="container">
    <div class="row  justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="text-left logo p-2 px-5"> <img src="<?php echo base_url();?>/assets/img/logo.png" width="50"> </div>
                <div class="invoice p-5">
                    <h5>
					<?php if($product[0]->order_status==0){ echo 'PENDING PURCHASED';}?>
					<?php if($product[0]->order_status==1){ echo 'APPROVED PURCHASED';}?>
					<?php if($product[0]->order_status==2){ echo 'DECLINED PURCHASED';}?>
					</h5> 
					<span class="font-weight-bold d-block mt-4">Hello, <?php echo $this->session->userdata['logged_in']['name'];?></span>
					<?php if($product[0]->order_status==0){?>
					<span>You order is Pending</span>
					<?php } ?>
					<?php if($product[0]->order_status==1){?>
					<span>You order is Approved</span>
					<?php } ?>
					<?php if($product[0]->order_status==2){?>
					<span>You order is Declined</span>
					<?php } ?>
                    <div class="payment border-top mt-3 mb-3 border-bottom table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Order Date</span> <span><?php echo $product[0]->checkout_date;?></span> </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Transaction Code</span> <span><?php echo $product[0]->transcode;?></span> </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Payment</span> <span><?php  if($product[0]->deliveryoption=='cod'){ echo 'COD';} else { echo $product[0]->paymentmethod;}?></span> </div>
                                    </td>
                                    <td>
                                        <div class="py-2"> <span class="d-block text-muted">Shiping Address</span> <span><?php echo  $product[0]->deliveryaddress;?></span> </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="product border-bottom table-responsive">
                        <table class="table table-borderless">
                            <tbody>
							<?php foreach($purchased as $a => $b){ 
								$subtotal += $b->purchasedTotal;
							?>
                                <tr>
                                    <td width="20%"> <img alt="image" src="<?php echo base_url();?>assets/products/<?php echo $b->product_image;?>" style="width:100px"> </td>
                                    <td width="60%"> <span class="font-weight-bold"><?php echo $b->product_name;?></span>
                                        <div class="product-qty"> <span class="d-block">Quantity: x <?php echo $b->purchasedQty;?></span> </div>
                                    </td>
                                    <td width="20%">
                                        <div class="text-right"> <span class="font-weight-bold"> <?php echo number_format($b->purchasedTotal,2);?></span> </div>
                                    </td>
                                </tr>
							<?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row d-flex justify-content-end">
                        <div class="col-md-5">
                            <table class="table table-borderless">
                                <tbody class="totals">
                                    <tr>
                                        <td>
                                            <div class="text-left"> <span class="text-muted">Subtotal</span> </div>
                                        </td>
                                        <td>
                                            <div class="text-right"> <span><?php echo number_format($subtotal,2);?></span> </div>
                                        </td>
                                    </tr>
                                  
                                    
                                    <tr class="border-top border-bottom">
                                        <td>
                                            <div class="text-left"> <span class="font-weight-bold">Grand Total</span> </div>
                                        </td>
                                        <td>
                                            <div class="text-right"> <span><?php echo number_format($subtotal,2);?></span> </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <p>We will be sending shipping confirmation email when the item shipped successfully!</p>
                    <p class="font-weight-bold mb-0">Thanks for shopping with us!</p> <span>EMPATHY BL3ND Team</span>
                </div>
                <div class="d-flex justify-content-between footer p-3"> <span>Need Help? Email us <a href="#"> supports@empathybl3nd.com</a></span> </div>
            </div>
        </div>
    </div>
</div>