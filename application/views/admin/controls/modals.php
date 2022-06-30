<!----- PACKAGES MODAL FORM ------>
  <div class="modal fade bd-example-modal-lg" id="addpackage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header bg-whitesmoke">
                <h5 class="modal-title" id="exampleModalLabel">ADD PACKAGE DATA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
        <form action="<?php echo site_url('savepackage');?>" method="post" enctype="multipart/form-data">
    
        <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>PACKAGE IMAGE : </label>
                    <div class="input-group">
                      <input type="file" class="form-control"  name="image" required>
                    </div>
                  </div>
          <div class="form-group col-md-6">
                    <label> PACKAGE NAME : </label>
                    <div class="input-group ">
                      <input type="text" class="form-control" name="packagename" required>
                    </div>
                  </div> 
          <div class="form-group col-md-6">
                    <label> PACKAGE PRICE : </label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="packageprice" required>
                    </div>
                  </div>  
       
          <div class="form-group col-md-12">
                    <label> PACKAGE DESCRIPTION : </label>
                    <div class="input-group">
                      <textarea type="text" class="form-control" name="packagedescription" required></textarea>
                    </div>
                  </div>
                 <div class="form-group col-md-4 lvl1">
                    <label> EARNING LEVEL 1 : </label>
                    <div class="input-group">
                      <input type="text" class="form-control earn_lvl_1" name="earn_lvl_1" id="earn_lvl_1">
                    </div>
                  </div>  
          <div class="form-group col-md-4 lvl2">
                    <label> EARNING LEVEL 2 : </label>
                    <div class="input-group">
                      <input type="text" class="form-control earn_lvl_2" name="earn_lvl_2"  id="earn_lvl_2">
                    </div>
                  </div>  
          <div class="form-group col-md-4 lvl3">
                    <label> EARNING LEVEL 3 : </label>
                    <div class="input-group">
                      <input type="text" class="form-control earn_lvl_3" name="earn_lvl_3"  id="earn_lvl_3">
                    </div>
                  </div>  
          <div class="form-group col-md-4 lvl4">
                    <label> EARNING LEVEL 4 : </label>
                    <div class="input-group">
                      <input type="text" class="form-control earn_lvl_4" name="earn_lvl_4"  id="earn_lvl_4">
                    </div>
                  </div>  
          <div class="form-group col-md-4 lvl5">
                    <label> EARNING LEVEL 5 : </label>
                    <div class="input-group">
                      <input type="text" class="form-control earn_lvl_5" name="earn_lvl_5" id="earn_lvl_5">
                    </div>
                  </div>  
          <div class="form-group col-md-4 lvl6">
                    <label> EARNING LEVEL 6 : </label>
                    <div class="input-group">
                      <input type="text" class="form-control earn_lvl_6" name="earn_lvl_6" id="earn_lvl_6">
                    </div>
                  </div> 
          <div class="form-group col-md-4 lvl7">
                    <label> EARNING LEVEL 7 : </label>
                    <div class="input-group">
                      <input type="text" class="form-control earn_lvl_7" name="earn_lvl_7" id="earn_lvl_7">
                    </div>
                  </div>  
          <div class="form-group col-md-4 lvl8">
                    <label> EARNING LEVEL 8 : </label>
                    <div class="input-group">
                      <input type="text" class="form-control earn_lvl_8" name="earn_lvl_8"id="earn_lvl_8">
                    </div>
                  </div>  
          <div class="form-group col-md-4 lvl9">
                    <label> EARNING LEVEL 9 : </label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="earn_lvl_9" id="earn_lvl_9">
                    </div>
                  </div>  
          <div class="form-group col-md-4 lvl10">
                    <label> EARNING LEVEL 10 : </label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="earn_lvl_10" id="earn_lvl_10">
                    </div>
                  </div>   
        
        </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-primary" >SAVE PACKAGE</button>
                <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
              </div>
              </div>
        </form>
            </div>
            </div>
          </div>
        </div> 
<!----- PRODUCTS MODAL FORM ------>
	<div class="modal fade bd-example-modal-lg" id="addproduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header bg-whitesmoke">
                <h5 class="modal-title" id="exampleModalLabel">ADD PRODUCT DATA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              <form action="<?php echo site_url('saveproduct');?>" method="post" enctype="multipart/form-data">
                <div class="form-row">
                        <div class="form-group col-md-6">
                          <label>PRODUCT IMAGE : </label>
                          <div class="input-group">
                            <input type="file" class="form-control"  name="image" required>
                          </div>
                        </div>
                <div class="form-group col-md-6">
                          <label> PRODUCT NAME : </label>
                          <div class="input-group ">
                            <input type="text" class="form-control" name="productname" required>
                          </div>
                        </div> 
                <div class="form-group col-md-6">
                          <label> PRODUCT PRICE : </label>
                          <div class="input-group">
                            <input type="text" class="form-control" name="productprice" required>
                          </div>
                        </div>  
                <div class="form-group col-md-6">
                          <label> PRODUCT QUANTITY : </label>
                          <div class="input-group">
                            <input type="text" class="form-control" name="product_qty" required>
                          </div>
                </div>  
              
                <div class="form-group col-md-12">
                          <label> PRODUCT DESCRIPTION : </label>
                          <div class="input-group">
                            <textarea type="text" class="form-control" name="productdescription" required></textarea>
                          </div>
                  </div>
				<div class="form-group col-md-6">
                    <label> POINTS : </label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="points" required>
                    </div>
                </div>   
                  </div>
                  <hr> DISCOUNTS : </hr>
                  <div class="form-row">
               
                  <div class="form-group col-md-4">
                          <label> MEGA : </label>
                          <div class="input-group">
                          <input type="text" class="form-control" name="mega" required>
                          </div>
                  </div>
                  <div class="form-group col-md-4">
                          <label> STOCKIST : </label>
                          <div class="input-group">
                          <input type="text" class="form-control" name="stockist" required>
                          </div>
                  </div>
                  <div class="form-group col-md-4">
                          <label> MEMBER : </label>
                          <div class="input-group">
                          <input type="text" class="form-control" name="member" required>
                          </div>
                  </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-primary" >SAVE PRODUCT</button>
                <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
              </div>
              </div>
		    	  </form>
            </div>
            </div>
          </div>
        </div> 
		<!----- EXPENSES MODAL FORM ------>
        <div class="modal fade bd-example-modal-lg" id="addexpenses" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header bg-whitesmoke">
                <h5 class="modal-title" id="exampleModalLabel">ADD PRODUCT DATA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
			  <div id="cbuprocess"></div>
			  <div id="cbucontent">
				<form action="<?php echo site_url('saveexpenses');?>" method="post" enctype="multipart/form-data">
				<div class="form-row">
                 
				  <div class="form-group col-md-6">
                    <label> EXPENSES AMOUNT : </label>
                    <div class="input-group ">
                      <input type="text" class="form-control" name="expensesamount" required>
                    </div>
                  </div> 
				  <div class="form-group col-md-6">
                    <label> EXPENSES DETAILS : </label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="expensesdetails" required>
                    </div>
                  </div>  
				  <div class="form-group col-md-6">
                    <label> EXPENSES DATE : </label>
                    <div class="input-group">
                      <input type="date" class="form-control" name="expensesdate" required>
                    </div>
                  </div>  
					<div class="form-group col-md-6">
                    <label> EXPENSES BY : </label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="expensesdateby" required>
                    </div>
                  </div> 
				  <div class="form-group  col-md-6">
					<label> QUANITY   : </label>
					<div class="input-group ">
						 <input type="text" class="form-control" name="quantity" id="quantity" required>
					</div>
				 </div> 
				 
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-primary" >SAVE</button>
                <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
              </div>
              </div>
			  </form>
            </div>
            </div>
          </div>
        </div> 
<!----- PAYMENT OPTION MODAL FORM ------>
        <div class="modal fade bd-example-modal-lg" id="addpayoptions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-whitesmoke">
                <h5 class="modal-title" id="exampleModalLabel">ADD PAYMENT OPTION DATA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
			  <div id="cbuprocess"></div>
			  <div id="cbucontent">
				<form action="<?php echo site_url('savepaymentoption');?>" method="post" enctype="multipart/form-data">
                 
				  <div class="form-group">
                    <label> PAYMENT METHOD : </label>
                    <div class="input-group ">
                      <input type="text" class="form-control" name="paymentmethod" required>
                    </div>
                  </div> 
				  <div class="form-group">
                    <label> PAYMENT PROCEDURES : </label>
                    <div class="input-group">
					<div class="col-sm-12 col-md-12">
                      <textarea class="summernote-simple" name="paymentprocedures"></textarea>
                    </div>
                    </div>
                  </div>  
				
              <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-primary" >SAVE</button>
                <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
              </div>
              </div>
			  </form>
            </div>
            </div>
          </div>
        </div> 
<!----- ADMIN USER OPTION MODAL FORM ------>
        <div class="modal fade bd-example-modal-lg" id="addadminuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-whitesmoke">
                <h5 class="modal-title" id="exampleModalLabel">ADD ADMIN USER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
			  <div id="cbuprocess"></div>
			  <div id="cbucontent">
				<form action="<?php echo site_url('saveadduser');?>" method="post" enctype="multipart/form-data">
                 <div class="row">
				  <div class="form-group  col-md-6">
                    <label> FIRST NAME : </label>
                    <div class="input-group ">
                      <input type="text" class="form-control" name="firstname" required>
                    </div>
                  </div> 
				   <div class="form-group  col-md-6">
                    <label> LAST NAME : </label>
                    <div class="input-group ">
                      <input type="text" class="form-control" name="lastname" required>
                    </div>
                  </div>   
                  </div>   
				 <div class="row">
				  <div class="form-group  col-md-6">
                    <label> USER NAME : </label>
                    <div class="input-group ">
                      <input type="text" class="form-control" name="username" required>
                    </div>
                  </div> 
				   <div class="form-group  col-md-6">
                    <label> PASSWORD  : </label>
                    <div class="input-group ">
                      <input type="password" class="form-control" name="password" required>
                    </div>
                  </div>   
                  </div>   
				
              <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-primary" >SAVE</button>
                <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
              </div>
              </div>
			  </form>
            </div>
            </div>
          </div>
        </div> 
