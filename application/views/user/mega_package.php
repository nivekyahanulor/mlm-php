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
                              <a class="nav-link active" href="<?php echo site_url("user/packages/mega");?>">PACKAGES</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="<?php echo site_url("user/packages/sold");?>">SOLD PACKAGES</a>
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
                            <th class="text-center"> ACTION   </th>
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
                                    <button class="btn btn-info"  data-toggle="modal" data-target="#purchased<?php echo $row->id;?>"> SELL </button>
                                </td>
                            </tr>
                            <div class="modal fade bd-example-modal-lg" style="overflow:hidden;" id="purchased<?php echo $row->id;?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
								  <div class="modal-header bg-whitesmoke">
									<h5 class="modal-title" id="exampleModalLabel"><?php echo $val->product_name;?> </h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
                                    <form method="POST" action="<?php echo site_url('mega_register_v');?>">
                                    <input type="hidden" class="form-control" name="package_id" value="<?php echo $row->package_id;?>"> 
                                    <input type="hidden" class="form-control" name="package_code" value="<?php echo $row->package_code;?>"> 
				                     <div class="row">
                                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <label for="frist_name">Refferal Name :</label>
                                            <select class="js-example-basic-single form-control" id="referralcode" name="referralcode" data-live-search="true" required>
                                                                                    <option value="">Select Member </option>
                                                                                    <?php
                                                                                    foreach ($members as $row) {
                                                                                        echo '<option value="' . $row->member_code . '">' . $row->firstname .' '. $row->lastname . '</option>';
                                                                                    }
                                                                                    ?>
                                            </select>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <label for="frist_name">First Name :</label>
                                            <input type="text" class="form-control" name="firstname" autofocus required autocomplete="off"> 
                                            </div>
                                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <label for="last_name">Last Name : </label>
                                            <input  type="text" class="form-control" name="lastname" required autocomplete="off">
                                            </div>
                                        </div>
                                                <div class="row">
                                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <label for="email">Email Address : </label>
                                            <input name="emailaddress" type="email" class="form-control" required autocomplete="off">
                                            <div class="invalid-feedback">
                                            </div>
                                        </div> 
                                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <label for="email">Contact Number : </label>
                                            <input name="contactnumber" type="text" class="form-control" maxlength="12" required autocomplete="off" onkeypress="return isNumber(event)" >
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        </div>
                                        <strong> ACCOUNT DETAILS : </strong><hr>
                                        <div class="row">
                                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <label for="password" class="d-block">Password :</label>
                                            <input name="password" type="password" class="form-control pwstrength" id="password" data-indicator="pwindicator" required autocomplete="off">
                                            <div id="pwindicator" class="pwindicator">
                                                <div class="bar"></div>
                                                <div class="label"></div>
                                            </div>
                                            </div>
                                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <label for="password2" class="d-block">Re-type Password : </label>
                                            <input name="retype" type="password" id="retype" class="form-control"  required autocomplete="off">
                                                        <div id="pwmatching"></div>
                                            </div>
                                        </div>
                                        
                                
                                      
                
								    <div class="modal-footer bg-whitesmoke br">
										<button type="submit" class="btn btn-primary btn-purchase" ><i class="fas fa-cart-plus"></i> PURCHASE</button>
										<button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
								    </div>
								  </form>
								</div>
								</div>
							  </div>
							</div> 
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
	  		