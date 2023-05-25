<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-cv-check';
   }
</script>
<div class="container-fluid content-bg-color">
		<div class="content-div">
			<input type="hidden" id="criminal_checks_id" value="<?php echo isset($table['criminal_checks']['criminal_check_id'])?$table['criminal_checks']['criminal_check_id']:''; ?>" name="">
			<div class="row"></div>
				<?php $cv_data =  isset($table['cv_check'])?$table['cv_check']:''; ?>
				<div class="row content-div-content-row-1">
					<div class="col-12"><span class="input-main-hdr">CV Check *</span></div>
				</div>

				<div class="row content-div-content-row">
					<div class="col-12">
	            		<div class="row">
	            			<div class="col-8">
	            				<span class="custom-file-name file-name file-name1">
	            					<?php $cv_doc = '';
                       				if (isset($cv_data['cv_doc'])) {
                       					if (!in_array('no-file', explode(',', $cv_data['cv_doc']))) {
                         					foreach (explode(',', $cv_data['cv_doc']) as $key => $value) {
                           						if ($value !='') {
                             						echo "<div id='rental{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"cv-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/cv-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                           						}
                         					}
                         					$cv_doc = $cv_data['cv_doc'];
                       					}
                       				} ?>
	            				</span>
	            			</div>
	            			<div class="col-4 custom-file-input-btn-div">
	            				<div class="custom-file-input">
	            				<input type="file" accept="image/*,application/pdf" id="file1" name="file1" class="input-file w-100" >
	            				<button class="btn btn-file-upload" for="file1">
	            					<img src="<?php echo base_url();?>assets/images/paper-clip.png">
	                    		Upload
	                  		</button>
	            			</div>
	            			<input type="hidden" value="<?php echo  $cv_doc; ?>" name="cv_doc" id="cv_doc">
	            		</div>
	             	</div>
					</div>
				</div>
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="add-cv-check">
						Save & Continue
					</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade view-document-modal" id="myModal-show" role="dialog">
	  <div class="modal-dialog modal-md modal-dialog-centered">
	      <!-- modal-content-view-collection-category -->
	      <div class="modal-content">
	          <div class="modal-header border-0">
	            <h3 id="">View Document</h4>
	          </div>
	          <div class="modal-body modal-body-edit-coupon">
	            <div class="row"> 
	            <div class="col-md-12 text-center view-img" id="view-img"></div>
	          </div>
	            <div class="row mt-3">
	                <div class="col-md-6" id="setupDownloadBtn"></div>
	                <div id="view-edit-cancel-btn-div" class="col-md-6 text-right">
	                  <button class="btn btn-close-modal" data-dismiss="modal">Close</button>
	                </div>
	            </div>
	          </div>
	      </div>
	   </div>
	</div>
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-cv-check.js" ></script>