 <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row mt-sm-1">
			  <?php $id = $_GET['id']; $query = $this->db->query("SELECT *  from bayanihand_members where ID='$id'"); $result = $query->result();?>
              <div class="col-12 col-md-12 col-lg-4">
                <div class="card author-box">
                  <div class="card-body">
                    <div class="author-box-center">
                      <img alt="image" src="assets/img/icon.png" class="rounded-circle author-box-picture">
                      <div class="clearfix"></div>
                      <div class="author-box-name">
                        <a href="#"><?php echo $result[0]->fn . ' '. $result[0]->ln;?></a>
                      </div>
                      <div class="author-box-job"><?php echo $result[0]->occupation;?> </div>
                    </div>
					<br>
					<hr>
                    <div class="text-center">
					<strong>Personal Details</strong>
                     <div class="py-4">
                      <p class="clearfix"><span class="float-left">Birth Date : </span><span class="float-right text-muted"><?php echo $result[0]->bdate;?></span></p>
                      <p class="clearfix"><span class="float-left">Civil Status : </span><span class="float-right text-muted"><?php echo $result[0]->civil_status;?></span> </p>
                      <p class="clearfix"><span class="float-left">Contact Number : </span><span class="float-right text-muted"><?php echo $result[0]->cell_no;?></span> </p>
                      <p class="clearfix"><span class="float-left">Home Address : </span><span class="float-right text-muted"><?php echo $result[0]->home_address;?></span> </p>
                      <p class="clearfix"><span class="float-left">Registered Date : </span><span class="float-right text-muted"><?php echo $result[0]->registereddate;?></span> </p>
                    </div>
                    </div>
                  </div>
                </div>
             

              </div>
              <div class="col-12 col-md-12 col-lg-8">
                <div class="card">
                  <div class="padding-20">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#cbu" role="tab"
                          aria-selected="true">CBU</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#savings" role="tab"
                          aria-selected="false">SAVING STATUS</a>
                      </li> 
					  <li class="nav-item">
                        <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#loan" role="tab"
                          aria-selected="false">LOAN LEDGER</a>
                      </li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                      <div class="tab-pane fade show active" id="cbu" role="tabpanel" aria-labelledby="home-tab2">
							<?php   $cbutable  = $this->db->query("SELECT *  from bayanihand_members_cbu where memberID='$id'"); 
									$cburesult = $cbutable->result();
									foreach($cburesult as $rowcbu1 => $valcbu1){
										 $cbutotal += $valcbu1->capital_payment;
									}
									echo '<h5> TOTAL CAPITAL : ₱ '.number_format($cbutotal,2).' <button class="float-right btn btn-outline-primary" data-toggle="modal" data-target="#cbuaccount"><i class="fa fa-plus"></i> ADD CBU</button></h5>';
							  ?> 
							<hr>
							<div class="table-responsive">
							  <table class="table table-striped" id="tablecbu">
								<thead>
								  <tr>
									<th class="text-center">OR NUMBER</th>
									<th class="text-center">CAPITAL PAYMENT</th>
									<th class="text-center">DATE</th>
								  </tr>
								</thead>
								<tbody>
								<?php foreach($cburesult as $rowcbu => $valcbu){ ?>
								  <tr>
									<td class="text-center"><?php echo $valcbu->cbu_or;?></td>
									<td class="text-right"> ₱ <?php echo number_format($valcbu->capital_payment,2);?></td>
									<td class="text-center"><?php echo $valcbu->cbu_date;?></td>
								  </tr>
								<?php } ?>
								</tbody>
							  </table>
							</div>
                      </div>
                      <div class="tab-pane fade" id="savings" role="tabpanel" aria-labelledby="profile-tab2">
							<?php   $savetable  = $this->db->query("SELECT *  from bayanihand_member_savings where memberID='$id'"); 
									$saveresult = $savetable->result();
									foreach($saveresult as $rowsave => $valsave){
										 $savingstotal += $valsave->savings_deposit -  $valsave->savings_withdrawal;
									}
									if($savingstotal == 0){
										$current = 0;
									} else {
										$current = $savingstotal;
									}
									echo '<h5> CURRENT BALANCE : ₱ '.number_format($current,2).' </h5>';
									
							  ?> 
							<button class="btn btn-outline-success" data-toggle="modal" data-target="#savingaccount"><i class="fa fa-arrow-alt-circle-up"></i> DEPOSIT</button> 
							<?php if($savingstotal ==0){ ?>
							<button class="btn btn-outline-danger" disabled><i class="fa fa-times"></i> WITHDRAWAL</button> 
							<?php } else{ ?>
							&nbsp; <button class="btn btn-outline-warning" data-toggle="modal" data-target="#withdrawal"><i class="fa fa-arrow-alt-circle-down"></i> WITHDRAWAL</button> 
							<?php } ?>
							<hr>
							<div class="table-responsive">
							  <table class="table table-striped" id="tablesavings">
								<thead>
								  <tr>
									<th class="text-center">TRANSACTION DATE</th>
									<th class="text-center">DEPOSIT AMOUNT</th>
									<th class="text-center">WITHDRAWAL AMOUNT</th>
									<th class="text-center">TRANSACTION</th>
								  </tr>
								</thead>
								<tbody>
								<?php foreach($saveresult as $rowsave1 => $valsave1){ ?>
								  <tr>
									<td class="text-center"><?php echo $valsave1->savings_date;?></td>
									<td class="text-right">₱ <?php echo number_format($valsave1->savings_deposit,2);?></td>
									<td class="text-right">₱ <?php echo number_format($valsave1->savings_withdrawal,2);?></td>
									<td class="text-center"><?php  if($valsave1->transaction =='D') { echo 'DEPOSIT';} else { echo 'WITHDRAWAL';}?></td>
								  </tr>
								<?php } ?>
								</tbody>
							  </table>
							</div>
                      </div>                      
					  <div class="tab-pane fade" id="loan" role="tabpanel" aria-labelledby="profile-tab3">
							<?php   $loantable   = $this->db->query("SELECT *  from bayanihan_members_loan where memberID='$id'"); 
									$loanresult  = $loantable->result();
									
							  ?> 
							<div class="table-responsive">
							  <table class="table table-striped" id="tableloan">
								<thead>
								  <tr>
									<th class="text-center">LOANED DATE</th>
									<th class="text-center">LOANED AMOUNT</th>
									<th class="text-center">BALANCE AMOUNT</th>
									<th class="text-center">LOANED TYPE</th>
									<th class="text-center"></th>
								  </tr>
								</thead>
								<tbody>
								<?php foreach($loanresult as $rowloan => $valoan){ ?>
								  <tr>
									<td class="text-center"><?php   echo $valoan->loandate;?></td>
									<td class="text-right">₱ <?php echo number_format($valoan->loan_amount,2);?></td>
									<td class="text-right">₱ <?php echo number_format($valoan->current_loan_balance,2);?></td>
									<td class="text-center"><?php   echo $valoan->loan_type;?></td>
									<td class="text-center"><a href="index?page=loan&id=<?php echo $val->ID;?>" class="btn btn-primary"><i class="ion-information-circled" data-pack="default" ></i> </a></td>
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
        </section>
      </div>
       <!-- CBU modal -->
        <div class="modal fade" id="cbuaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-whitesmoke">
                <h5 class="modal-title" id="exampleModalLabel">CBU</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
			  <div id="cbuprocess"></div>
			  <div id="cbucontent">
                <form id="processcbu">
                  <div class="form-group">
                    <label>DATE : </label>
                    <div class="input-group">
                      <input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" id="date" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label> CAPITAL PAYMENT : </label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="capitalpayment" required>
                      <input type="hidden" class="form-control" id="userid" value="<?php echo $_GET['id'];?>" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label>OR # : </label>
                    <div class="input-group">
                      <input type="text" class="form-control"  id="ornumber" required>
                    </div>
                  </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-primary" id="cbubtn" >PROCESS</button>
                <button type="button" class="btn btn-secondary" id="cbuclose" data-dismiss="modal">Close</button>
              </div>
			  </form>
            </div>
            </div>
          </div>
        </div> 
		<!-- SAVINGS modal -->
        <div class="modal fade" id="savingaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-whitesmoke">
                <h5 class="modal-title" id="exampleModalLabel">DEPOSIT SAVINGS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
			  <div id="savingsprocess"></div>
			  <div id="savingscontent">
                <form id="processsavings">
                  <div class="form-group">
                    <label>DATE : </label>
                    <div class="input-group">
                      <input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" id="date" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label> AMOUNT DEPOSIT: </label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="amountdeposit" required>
                      <input type="hidden" class="form-control" id="userid" value="<?php echo $_GET['id'];?>" required>
                      <input type="hidden" class="form-control" id="balance" value="<?php echo $current;?>" required>
                    </div>
                  </div>
                 
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-primary" id="cbubtn" >PROCESS</button>
                <button type="button" class="btn btn-secondary" id="cbuclose" data-dismiss="modal">Close</button>
              </div>
			  </form>
            </div>
            </div>
          </div>
        </div>	
		<!-- WITHDRAWAL modal -->
        <div class="modal fade" id="withdrawal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-whitesmoke">
                <h5 class="modal-title" id="exampleModalLabel">WITHDRAW SAVINGS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
			  <div id="wdprocess"></div>
			  <div id="wdcontent">
                <form id="processwithdraw">
                  <div class="form-group">
                    <label>DATE : </label>
                    <div class="input-group">
                      <input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" id="date" required>
                    </div>
                  </div>
                   <div class="form-group">
                    <label> AMOUNT TO WITHDRAW: </label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="amountwd" value="<?php echo $current;?>"  required>
                      <input type="hidden" class="form-control" id="userid" value="<?php echo $_GET['id'];?>" required>
                      <input type="hidden" class="form-control" id="balance" value="<?php echo $current;?>" required>
                    </div>
                  </div>
                 
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-primary" id="cbubtn" >PROCESS</button>
                <button type="button" class="btn btn-secondary" id="cbuclose" data-dismiss="modal">Close</button>
              </div>
			  </form>
            </div>
            </div>
          </div>
        </div>