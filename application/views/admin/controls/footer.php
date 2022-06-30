 <footer class="main-footer">
        <div class="footer-left">
          <a href="">E-BLENDS</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  <script>  var UrlLink = <?php echo json_encode(base_url()); ?>;</script> 
  <script src="<?php echo base_url();?>/assets/js/app.min.js"></script>
  <script src="<?php echo base_url();?>/assets/js/functions.js"></script>
  <script src="<?php echo base_url();?>/assets/bundles/apexcharts/apexcharts.min.js"></script>
  <script src="<?php echo base_url();?>/assets/js/page/index.js"></script>
  <script src="<?php echo base_url();?>assets/bundles/summernote/summernote-bs4.js"></script>
  <script src="<?php echo base_url();?>/assets/bundles/datatables/datatables.min.js"></script>
  <script src="<?php echo base_url();?>/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url();?>/assets/bundles/jquery-ui/jquery-ui.min.js"></script>
  <script src="<?php echo base_url();?>/assets/js/page/datatables.js"></script>
  <script src="<?php echo base_url();?>/assets/js/scripts.js"></script>
  <script src="<?php echo base_url();?>/assets/js/admin.js"></script>
  <script src="<?php echo base_url();?>/assets/bundles/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="<?php echo base_url();?>/assets/bundles/jquery-steps/jquery.steps.min.js"></script>
  <script src="<?php echo base_url();?>/assets/js/page/form-wizard.js"></script>
  <script src="<?php echo base_url();?>/assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
  <script src="<?php echo base_url();?>/assets/bundles/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>
  <script src="<?php echo base_url();?>/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="<?php echo base_url();?>/assets/js/page/create-post.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
		$(document).ready(function() {
			$('.js-example-basic-single').select2();
		});
  </script>
  <script>
			$(".lvl1").hide();
			$(".lvl2").hide();
			$(".lvl3").hide();
			$(".lvl4").hide();
			$(".lvl5").hide();
			$(".lvl6").hide();
			$(".lvl7").hide();
			$(".lvl8").hide();
			$(".lvl9").hide();
			$(".lvl10").hide();
		$( "#complan" ).change(function() {
	  	 var complan = $("#complan").val();
		 if(complan==2){
			$(".lvl1").hide();
			$(".lvl2").hide();
			$(".lvl3").hide();
			$(".lvl4").hide();
			$(".lvl5").hide();
			$(".lvl6").hide();
			$(".lvl7").hide();
			$(".lvl8").hide();
			$(".lvl9").hide();
			$(".lvl10").hide();
			$(".earn_lvl_1").prop('required',false);
			$(".earn_lvl_2").prop('required',false);
			$(".earn_lvl_3").prop('required',false);
			$(".earn_lvl_4").prop('required',false);
			$(".earn_lvl_5").prop('required',false);
			$(".earn_lvl_6").prop('required',false);
			$(".earn_lvl_7").prop('required',false);
			$(".earn_lvl_8").prop('required',false);
			$(".earn_lvl_9").prop('required',false);
			$(".earn_lvl_10").prop('required',false);
			
		} if(complan==1) {
			$(".lvl1").show();
			$(".lvl2").show();
			$(".lvl3").show();
			$(".lvl4").show();
			$(".lvl5").show();
			$(".lvl6").show();
			$(".lvl7").show();
			$(".lvl8").show();
			$(".lvl9").show();
			$(".lvl10").show();
			$(".earn_lvl_1").prop('required',true);
			$(".earn_lvl_2").prop('required',true);
			$(".earn_lvl_3").prop('required',true);
			$(".earn_lvl_4").prop('required',true);
			$(".earn_lvl_5").prop('required',true);
			$(".earn_lvl_6").prop('required',true);
			$(".earn_lvl_7").prop('required',true);
			$(".earn_lvl_8").prop('required',true);
			$(".earn_lvl_9").prop('required',true);
			$(".earn_lvl_10").prop('required',true);
		}
  });
  $('.custom-switch-input').click(function(){
    if($(this).prop("checked") == true){
       $.ajax({
			type: "POST",
			url:UrlLink+'status-top-five-endorser',
				data : {
					'isActive_Top_Fiva_Endorser' : 1, 
				},
			success: function(results)
				{
					location.reload();	
				}
			});
    }
    else if($(this).prop("checked") == false){
        $.ajax({
			type: "POST",
			url:UrlLink+'status-top-five-endorser',
				data : {
					'isActive_Top_Fiva_Endorser' : 0, 
				},
			success: function(results)
				{
					location.reload();	
				}
			});
    }
});
  </script>
</body>
</html>