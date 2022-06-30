<div class="main-content">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>DIRECTS INFORMATION </h4>
                  </div>
				           <?php $code    	 = $this->session->userdata['logged_in']['code'];?>
                  <div class="card-body">
				
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered" id="genealogy-table">
                        <thead>
                          <tr>
                            <th class="text-center"> NAME   </th>
                            <th class="text-center"> USER NAME   </th>
                            <th class="text-center"> JOIN DATE    </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($genealogy as $a => $b){?>
                            <tr>
                              <td class="text-center"><?php echo $b->firstname . ' ' . $b->lastname;?></td>	
                              <td class="text-center"><?php echo $b->username;?></td>	
                              <td class="text-center"><?php echo $b->datgeregistered;?></td>	
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
	  		