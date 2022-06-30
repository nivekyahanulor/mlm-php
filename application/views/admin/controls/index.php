<div class="container">
<article class="card-body mx-auto" style="max-width: 400px;">
<div style="height:40px;"></div>
			<div id="errorlogin"></div>
			<center><img src="<?php echo base_url();?>assets/images/logo.png" alt="Site title" class="logo-icon" width="150px"></center><br>
			<center>WELCOME ADMINISTRATOR</center>
			<hr>
              <form id="loginadmin">
                <div class="form-group">
                  <label for="email">User Name : </label>
                 <div class="form-group input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"> <i class="fa fa-user"></i> </span>
					 </div>
					<input id="username" class="form-control" type="text"  required autocomplete="off" style="text-align:center;">
				</div> <!-- form-group// -->
                </div>
                <div class="form-group">
                  <label for="password">Password :</label>
                    <div class="form-group input-group">
					<div class="input-group-prepend">
					<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
					 </div>
					<input id="password" class="form-control" type="password" required autocomplete="off"  style="text-align:center;">
				</div> <!-- form-group// -->
                </div>
                <button type="submit" class="btn btn-block btn-primary" tabindex="3">LOGIN</button>
                <br>
                <br>
              </form>
          </div><!--.panel-->
</article><!--.article-->
</div>
