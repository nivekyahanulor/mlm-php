      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row ">
              <div class="col-12 col-md-12 col-lg-4">
                <div class="card author-box">
                  <div class="card-body">
                    <div class="author-box-center">
                      <img src="<?php echo base_url();?>assets/products/<?php echo $product[0]->product_image;?>" width="280px">
                      <div class="clearfix"></div>
                      <div class="author-box-name">
                        <a href="#"><?php echo $product[0]->product_name;?></a>
                      </div>
                      <div class="author-box-job">Price :<?php echo number_format($product[0]->product_price,2);?></div>
                       <div class="author-box-job">Stack Qty :<?php echo number_format($product[0]->product_qty,0);?></div>
                       <div class="author-box-job">Sold Qty :<?php echo number_format($product[0]->qtySold,0);?></div>
                    </div>
                    <div class="text-center">
                      <div class="author-box-description">
                        <p>
                        <?php echo $product[0]->product_description;?>
                        </p>
                      </div>
                   
                      <div class="w-100 d-sm-none"></div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="col-12 col-md-12 col-lg-8">
                <div class="card">
                  <div class="padding-20">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                          aria-selected="true">Product Information</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                          aria-selected="false">Update Product Image</a>
                      </li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                      <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                  			<form action="<?php echo site_url('updateproduct');?>" method="post">
										<input type="hidden" name="productID" value="<?php echo $product[0]->productID;?>" class="form-control" placeholder="">
										<div class="form-group row mb-4">
										<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> PRODUCT NAME : </label>
										  <div class="col-sm-12 col-md-7">
											<input type="text" class="form-control" name="productname" value="<?php echo $product[0]->product_name;?>" required>
										  </div>
										</div> 
										<div class="form-group row mb-4">
										 <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> PRODUCT PRICE : </label>
										 <div class="col-sm-12 col-md-7">
											<input type="text" class="form-control" name="productprice" value="<?php echo $product[0]->product_price;?>" required>
										  </div>
										</div>  
										<div class="form-group row mb-4">
										 <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> PRODUCT QUANTITY : </label>
										 <div class="col-sm-12 col-md-7">
											<input type="text" class="form-control" name="product_qty" value="<?php echo $product[0]->product_qty;?>" required>
										  </div>
										</div> 
										<div class="form-group row mb-4">
										 <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> PRODUCT POINTS : </label>
										 <div class="col-sm-12 col-md-7">
											<input type="text" class="form-control" name="points" value="<?php echo $product[0]->points;?>" required>
										  </div>
										</div> 
										<div class="form-group row mb-4">
										 <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> PRODUCT DESCRIPTION : </label>
										  <div class="col-sm-12 col-md-7">
											<textarea type="text" class="form-control" name="productdescription" required><?php echo $product[0]->product_description;?></textarea>
										  </div>
										</div>
										<!--<div class="form-group row mb-4">
										 <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> PRODUCT QTY : </label>
										  <div class="col-sm-12 col-md-7">
											<input type="text" class="form-control" name="productqty" value="<?php echo $product[0]->product_qty;?>" readonly required>
										  </div>
										</div>  -->
										
										<!---
										<hr><strong>EARNING LEVELS </strong>
										<div class="row mb-4">
										  <div class="col-sm-12 col-md-6">
										  <label class="col-form-label col-12 col-md-12 col-lg-12"> EARNING LEVEL 1 : </label>
											<input type="text" class="form-control" name="earn_lvl_1" value="<?php echo $product[0]->earning_lvl_one;?>" required>
										  </div>
										  <div class="col-sm-12 col-md-6">
										  <label class="col-form-label col-12 col-md-12 col-lg-12"> EARNING LEVEL 2 : </label>
											<input type="text" class="form-control" name="earn_lvl_2" value="<?php echo $product[0]->earning_lvl_two;?>" required>
										  </div>
										</div>    
										<div class="row mb-4">
										 <div class="col-sm-12 col-md-6">
										 <label class="col-form-label col-12 col-md-12 col-lg-12"> EARNING LEVEL 3 : </label>
											<input type="text" class="form-control" name="earn_lvl_3" value="<?php echo $product[0]->earning_lvl_three;?>" required>
										  </div>
										 <div class="col-sm-12 col-md-6">
										 <label class="col-form-label  col-12 col-md-12 col-lg-12"> EARNING LEVEL 4 : </label>
											<input type="text" class="form-control" name="earn_lvl_4" value="<?php echo $product[0]->earning_lvl_four;?>" required>
										  </div>
										</div> 
										<div class="row mb-4">
										<div class="col-sm-12 col-md-6">
										 <label class="col-form-label  col-12 col-md-12 col-lg-12"> EARNING LEVEL 5 : </label>
											<input type="text" class="form-control" name="earn_lvl_5" value="<?php echo $product[0]->earning_lvl_five;?>" required>
										  </div>
										<div class="col-sm-12 col-md-6">
										 <label class="col-form-label col-12 col-md-12 col-lg-12"> EARNING LEVEL 6 : </label>
											<input type="text" class="form-control" name="earn_lvl_6" value="<?php echo $product[0]->earning_lvl_six;?>" required>
										  </div>
										</div> 
										<div class="row mb-4">
										 <div class="col-sm-12 col-md-6">
										 <label class="col-form-label  col-12 col-md-12 col-lg-12"> EARNING LEVEL 7 : </label>
											<input type="text" class="form-control" name="earn_lvl_7"  value="<?php echo $product[0]->earning_lvl_seven;?>" required>
										  </div>
										
										  <div class="col-sm-12 col-md-6">
										 <label class="col-form-label col-12 col-md-12 col-lg-12"> EARNING LEVEL 8 : </label>
											<input type="text" class="form-control" name="earn_lvl_8" value="<?php echo $product[0]->earning_lvl_eight;?>" required>
										  </div>
										</div> 
										<div class="row mb-4">
										 <div class="col-sm-12 col-md-6">
										 <label class="col-form-label col-12 col-md-12 col-lg-12"> EARNING LEVEL 9 : </label>
											<input type="text" class="form-control" name="earn_lvl_9" value="<?php echo $product[0]->earning_lvl_nine;?>" required>
										  </div>
										  <div class="col-sm-12 col-md-6">
										 <label class="col-form-label col-12 col-md-12 col-lg-12"> EARNING LEVEL 10 : </label>
											<input type="text" class="form-control" name="earn_lvl_10" value="<?php echo $product[0]->earning_lvl_ten;?>" required>
										  </div>
										</div> 	
										<!--<div class="form-group row mb-4">
										 <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> EARNING LIMIT  : </label>
										  <div class="col-sm-12 col-md-7">
											<input type="text" class="form-control" name="earn_limit" value="<?php echo $product[0]->earnlimit;?>" required>
										  </div>
										</div> -->
									<div class="modal-footer bg-whitesmoke br">
									  <button type="submit" class="btn btn-primary" > <i class="fas fa-save"></i> UPDATE</button>
									</div>
									<div id="processproductupdate"></div>
						  </form>
                      </div>
                      <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                        <form method="post" action="<?php echo site_url('updateproductimage');?>" class="needs-validation" enctype="multipart/form-data">
                          <div class="card-header">
                            <h4>Edit Product Image</h4>
                          </div>
                          <div class="card-body">
							<input type="hidden" name="productID" value="<?php echo $product[0]->productID;?>" class="form-control" placeholder="">
							<input type="hidden" name="productimage" value="<?php echo $product[0]->product_image;?>" class="form-control" placeholder="">

                           	<div class="form-group row mb-4">
							  <div class="col-sm-12 col-md-7">
								<div id="image-preview" class="image-preview">
								  <label for="image-upload" id="image-label">Choose File</label>
								  <input type="file" name="image" id="image-upload" required />
								</div>
							  </div>
							</div>
                          </div>
							  <button type="submit" class="btn btn-primary" > <i class="fas fa-save"></i> UPDATE</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
</div>
