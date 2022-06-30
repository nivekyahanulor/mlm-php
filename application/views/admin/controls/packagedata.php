      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row ">
              <div class="col-12 col-md-12 col-lg-4">
                <div class="card author-box">
                  <div class="card-body">
                    <div class="author-box-center">
                      <img src="<?php echo base_url();?>assets/packages/<?php echo $package[0]->package_image;?>" width="280px">
                      <div class="clearfix"></div>
                      <div class="author-box-name">
                        <a href="#"><?php echo $package[0]->package_name;?></a>
                      </div>
                      <div class="author-box-job">Price :<?php echo number_format($package[0]->package_price,2);?></div>
                       <div class="author-box-job">Stack Qty :<?php echo number_format($package[0]->package_qty,0);?></div>
                       <div class="author-box-job">Sold Qty :<?php echo number_format($package[0]->qtySold,0);?></div>
                    </div>
                    <div class="text-center">
                      <div class="author-box-description">
                        <p>
                        <?php echo $package[0]->package_description;?>
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
                          aria-selected="true">Package Information</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                          aria-selected="false">Update Package Image</a>
                      </li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                      <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                  			<form action="<?php echo site_url('updatepackage');?>" method="post">
										<input type="hidden" name="packageID" value="<?php echo $package[0]->packageID;?>" class="form-control" placeholder="">
										<div class="form-group row mb-4">
										<label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> PRODUCT NAME : </label>
										  <div class="col-sm-12 col-md-7">
											<input type="text" class="form-control" name="packagename" value="<?php echo $package[0]->package_name;?>" required>
										  </div>
										</div> 
										<div class="form-group row mb-4">
										 <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> PRODUCT PRICE : </label>
										 <div class="col-sm-12 col-md-7">
											<input type="text" class="form-control" name="packageprice" value="<?php echo $package[0]->package_price;?>" required>
										  </div>
										</div>  
										<div class="form-group row mb-4">
										 <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> PRODUCT DESCRIPTION : </label>
										  <div class="col-sm-12 col-md-7">
											<textarea type="text" class="form-control" name="packagedescription" required><?php echo $package[0]->package_description;?></textarea>
										  </div>
										</div>
										<!--<div class="form-group row mb-4">
										 <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> PRODUCT QTY : </label>
										  <div class="col-sm-12 col-md-7">
											<input type="text" class="form-control" name="packageqty" value="<?php echo $package[0]->package_qty;?>" readonly required>
										  </div>
										</div>  -->
									
									<div class="modal-footer bg-whitesmoke br">
									  <button type="submit" class="btn btn-primary" > <i class="fas fa-save"></i> UPDATE</button>
									</div>
									<div id="processpackageupdate"></div>
						  </form>
                      </div>
                      <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                        <form method="post" action="<?php echo site_url('updatepackageimage');?>" class="needs-validation" enctype="multipart/form-data">
                          <div class="card-header">
                            <h4>Edit Package Image</h4>
                          </div>
                          <div class="card-body">
							<input type="hidden" name="packageID" value="<?php echo $package[0]->packageID;?>" class="form-control" placeholder="">
							<input type="hidden" name="packageimage" value="<?php echo $package[0]->package_image;?>" class="form-control" placeholder="">

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
