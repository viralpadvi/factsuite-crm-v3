<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-driving-licence';
   }
</script>
<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
				<?php  
            		$driving_data = isset($table['driving_licence'])?$table['driving_licence']:'';
         		?>
				<div class="row content-div-content-row-1">
					<div class="col-12"><span class="input-main-hdr">Driving Licence Number *</span></div>
				</div>
				<div class="row content-div-content-row">
					<input type="hidden"class="fld form-control" name="driving_licence_id" id="driving_licence_id" value="<?php echo isset($driving_data['licence_id'])?$driving_data['licence_id']:''; ?>" >
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field" required name="driving_licence_number" id="driving_licence_number" value="<?php echo isset($driving_data['licence_number'])?$driving_data['licence_number']:''; ?>">
			            <span class="input-field-txt">Driving Licence Number</span>
			            <div id="driving_licence_number-error"></div>
			         </div>
					</div>
				</div>

				<div class="row content-div-content-row">
					<div class="col-12">
	            		<div class="row">
	            			<div class="col-8">
	            				<span class="custom-file-name file-name file-name1">
	            					<?php $licence_doc = '';
                       			if (isset($driving_data['licence_doc'])) {
                       				if (!in_array('no-file', explode(',', $driving_data['licence_doc']))) {
                         				foreach (explode(',', $driving_data['licence_doc']) as $key => $value) {
                           				if ($value !='') {
                             					echo "<div id='rental{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"licence-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/licence-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                           				}
                         				}
                         				$licence_doc = $driving_data['licence_doc'];
                       				}
                       			} ?>
                      			<input type="hidden" name="driving_licence_doc" value="<?php echo $licence_doc; ?>" id="driving_licence_doc">
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
	            			<input type="hidden" name="driving_licence_doc" value="<?php echo $licence_doc; ?>" id="driving_licence_doc">
	            		</div>
	             	</div>
					</div>
				</div>
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="add-driving-licence">
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
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-driving-licence.js" ></script>