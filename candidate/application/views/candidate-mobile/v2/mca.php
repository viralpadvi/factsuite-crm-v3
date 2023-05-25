<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-mca';
   }
</script>
<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
				<?php  
            		$mca = isset($table['mca'])?$table['mca']:'';
         		?>
				<div class="row content-div-content-row-1">
					<div class="col-12"><span class="input-main-hdr">Organization Name *</span></div>
				</div>
				<div class="row content-div-content-row">
					<input type="hidden"class="fld form-control" name="mca_id" id="mca_id" value="<?php echo isset($mca['licence_id'])?$mca['licence_id']:''; ?>" >
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field" required name="organization_name" id="organization_name" value="<?php echo isset($mca['organization_name'])?$mca['organization_name']:''; ?>">
			            <span class="input-field-txt">Candidate organization name</span>
			            <div id="organization_name-error"></div>
			         </div>
					</div>
				</div>

				<div class="row content-div-content-row">
					<div class="col-12">
	            		<div class="row">
	            			<div class="col-8">
	            				  <span class="input-field-txt">experiance_doc/Relieving Letter For That Company</span>
	            				<span class="custom-file-name file-name file-name1">
	            					<?php $experiance_doc = '';
                       			if (isset($mca['experiance_doc'])) {
                       				if (!in_array('no-file', explode(',', $mca['experiance_doc']))) {
                         				foreach (explode(',', $mca['experiance_doc']) as $key => $value) {
                           				if ($value !='') {
                             					echo "<div id='rental{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"mca-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/mca-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                           				}
                         				}
                         				$experiance_doc = $mca['experiance_doc'];
                       				}
                       			} ?>
                      			<input type="hidden" name="experiance_doc" value="<?php echo $experiance_doc; ?>" id="experiance_doc">
	            				</span>
	            			</div>
	            			<div class="col-4 custom-file-input-btn-div">
	            				<div class="custom-file-input">
	            				<input type="file" accept="image/*,application/pdf" id="file1" name="file1" class="input-file w-100"  multiple>
	            				<button class="btn btn-file-upload" for="file1">
	            					<img src="<?php echo base_url();?>assets/images/paper-clip.png">
	                    		Upload
	                  		</button>
	            			</div>
	            			<input type="hidden" name="experiance_doc" value="<?php echo $experiance_doc; ?>" id="experiance_doc">
	            		</div>
	             	</div>
					</div>
				</div>
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="add-mca">
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
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-mca.js" ></script>