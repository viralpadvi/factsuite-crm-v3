<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-nric';
   }
</script>
<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
				<?php  
            		$nric = isset($table['nric'])?$table['nric']:'';
         		?>
				<div class="row content-div-content-row-1">
					<div class="col-12"><span class="input-main-hdr">Organization Name *</span></div>
				</div>
				<div class="row content-div-content-row">
					<input type="hidden"class="fld form-control" name="nric_id" id="nric_id" value="<?php echo isset($nric['licence_id'])?$nric['licence_id']:''; ?>" >
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field" required name="nric_number" id="nric_number" value="<?php echo isset($nric['nric_number'])?$nric['nric_number']:''; ?>">
			            <span class="input-field-txt">NRIC Number</span>
			            <div id="nric_number-error"></div>
			         </div>
					</div>
				</div>

				<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Issue Date *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field date-for-candidate-aggreement-start-date" id="joining-date" value="<?php echo isset($table['nric']['joining_date'])?$table['nric']['joining_date']:''; ?>" type="text" required> 
		                <span class="input-field-txt">Enter Issue Date</span>
            			<div id="joining-date-error"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Expiry Date *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field date-for-candidate-aggreement-end-date" disabled id="relieving-date" value="<?php echo isset($table['nric']['end_date'])?$table['nric']['end_date']:''; ?>" type="text" required> 
		                <span class="input-field-txt">Enter Expiry Date</span>
            		<div id="relieving-date-error"></div> 
		            </div>
				</div>
			</div>

			<?php
         		$male = '';
         		$female = '';
         		$single = '';
         		$married = '';
         		if (isset($user['gender'])) {
             		if ($user['gender'] != 'male') {
             			$female = 'selected';
             		} else {
              			$male = 'selected';
             		}
         		}

         		if(isset($user['marital_status'])) {
            		if ($user['marital_status']=='married') {
               			$married = 'selected';
             		} else {
               			$single = 'selected';
             		} 
         		} ?>

         		<div class="row content-div-content-row">
					<div class="col-12"><span class="input-main-hdr">Gender *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
							<select id="gender" class="sign-in-input-field gender1" required>
	         				<option <?php echo $male; ?> value="male">Male</option>
	         				<option <?php echo $female; ?> value="female">Female</option>
	      				</select>
	      				<span class="input-field-txt">Gender</span>
	      				<div id="gender-error"></div>
			         	</div>
					</div>
				</div>

				<div class="row content-div-content-row">
					<div class="col-12">
	            		<div class="row">
	            			<div class="col-8">
	            				  <span class="input-field-txt">NRIC Attachment</span>
	            				<span class="custom-file-name file-name file-name1">
	            					<?php $nric_docs = '';
                       			if (isset($nric['nric-docs'])) {
                       				if (!in_array('no-file', explode(',', $nric['nric-docs']))) {
                         				foreach (explode(',', $nric['nric-docs']) as $key => $value) {
                           				if ($value !='') {
                             					echo "<div id='rental{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"nric-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/nric-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                           				}
                         				}
                         				$nric_docs = $nric['nric-docs'];
                       				}
                       			} ?>
                      			<input type="hidden" name="nric-docs" value="<?php echo $nric_docs; ?>" id="nric-docs">
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
	            			<input type="hidden" name="nric-docs" value="<?php echo $nric_docs; ?>" id="nric-docs">
	            		</div>
	             	</div>
					</div>
				</div>
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="candidate-nric">
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
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-nric.js" ></script>