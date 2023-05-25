 
					<?php 
            $nric = isset($table['nric'])?$table['nric']:'';// $this->db->where('candidate_id',$user['candidate_id'])->get('driving_licence')->row_array();
            ?>
					<input type="hidden"class="fld form-control" name="nric_id" id="nric_id" value="<?php echo isset($nric['nric_id'])?$nric['nric_id']:''; ?>" >
					<div class="row">
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" required="" class="sign-in-input-field" name="nric_number" id="nric_number" value="<?php echo isset($nric['nric_number'])?$nric['nric_number']:''; ?>" >
				                <span class="input-field-txt">NRIC Number </span>
                  				<div id="nric_number-error">&nbsp;</div> 
				            </div>
						</div>
 					<div class="col-md-4">
							<div class="input-wrap">
				                 <input required="" name="" class="sign-in-input-field date-for-candidate-aggreement-start-date" id="joining-date" value="<?php echo isset($table['nric']['joining_date'])?$table['nric']['joining_date']:''; ?>" type="text"> 
				                <span class="input-field-txt">Issue Date </span>
                  				<div id="joining-date-error"></div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field date-for-candidate-aggreement-end-date" disabled required id="relieving-date" value="<?php echo isset($table['nric']['end_date'])?$table['nric']['end_date']:'';?>" type="text"> 
				                <span class="input-field-txt">Expiry Date </span>
                  				<div id="relieving-date-error"></div> 
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
				<div class="col-md-4">
					<div class="pg-frm">
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
						  
					</div>
 
					<div class="row">
						<div class="col-md-10 mt-3">
							<div class="pg-frm-hd">NRIC Attachment </div>
		                  		<div class="row">
		                  			<div class="col-8">
		                  				<div class="custom-file-name file-name1"> 
                       <?php
                     $nric_docs = '';
                       if (isset($nric['nric-docs'])) {
                       if (!in_array('no-file', explode(',', $nric['nric-docs']))) {
                         foreach (explode(',', $nric['nric-docs']) as $key => $value) {
                           if ($value !='') {
                             echo "<div id='rental{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"nric-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/nric-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                           }
                         }
                         $nric_docs = $nric['nric-docs'];
                       }}
                       ?>
                      <input type="hidden" name="nric-docs" value="<?php echo $nric_docs; ?>" id="nric-docs">
                     </div>
			                      <div id="file1-error"></div>
		                  			</div>
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  				<input type="file" accept="image/*,application/pdf" id="file1" name="file1" class="input-file w-100" accept="image/*" multiple>
		                  				<button class="btn btn-file-upload" for="file1">
		                  					<img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
		                  			</div>
		                  		</div>
		                	</div>
						</div>
					 
					</div>
					<div class="row">
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button id="candidate-nric"   class="save-btn">Save &amp; Continue</button>
						</div>
					</div>

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

<script> 
    var candidate_info = <?php echo json_encode($user); ?>;
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-nric.js" ></script>