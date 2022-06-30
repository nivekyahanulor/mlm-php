<div class="modal fade " id="adddownlineleft<?php echo $modalID;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-whitesmoke">
                <h5 class="modal-title" id="exampleModalLabel">BINARY DATA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
					<form action="<?php echo site_url('process-binary-left');?>" method="post" enctype="multipart/form-data">
				   <div class="form-group">
					<label>  CODE : </label>
					<div class="input-group ">
						<input type="text" class="form-control" name="binarycode" required>
						<input type="hidden" class="form-control" name="bpID" value="<?php echo $modalID;?>" required>
						<input type="hidden" class="form-control" name="level" value="<?php echo $Level;?>" required>
						<input type="text" class="form-control" name="directMemberCode" value="<?php echo $directMemberCode;?>" required>
						<input type="text" class="form-control" name="underBy" value="<?php echo $underBy;?>" required>
						<input type="text" class="form-control" name="sponsorMemberCode" value="<?php echo $sponsorMemberCode;?>" required>
						<input type="text" class="form-control" name="position" value="Left" required>
						<input type="text" class="form-control" name="secondaryPosition" value="Left" required>
					</div>
					</div> 
              <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-primary" >PROCESS</button>
                <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
              </div>
			  </form>
            </div>
            </div>
          </div>
        </div> 
		<div class="modal fade " id="adddownlineright<?php echo $modalID;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-whitesmoke">
                <h5 class="modal-title" id="exampleModalLabel">BINARY DATA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
				<form action="<?php echo site_url('process-binary');?>" method="post" enctype="multipart/form-data">
				   <div class="form-group">
					<label>  CODE : </label>
					<div class="input-group ">
						<input type="text" class="form-control" name="binarycode" required>
						<input type="hidden" class="form-control" name="bpID" value="<?php echo $modalID;?>" required>
						<input type="hidden" class="form-control" name="level" value="<?php echo $Level;?>" required>
						<input type="text" class="form-control" name="directMemberCode" value="<?php echo $directMemberCode;?>" required>
						<input type="text" class="form-control" name="underBy" value="<?php echo $underBy;?>" required>
						<input type="text" class="form-control" name="sponsorMemberCode" value="<?php echo $sponsorMemberCode;?>" required>
						<input type="text" class="form-control" name="position" value="Left" required>
						<input type="text" class="form-control" name="secondaryPosition" value="Left" required>
					</div>
					</div> 
              <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-primary" >PROCESS</button>
                <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
              </div>
			  </form>
            </div>
            </div>
          </div>
        </div> 
