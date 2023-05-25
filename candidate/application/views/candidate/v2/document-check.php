 <?php 
            $form_values = json_decode($user['form_values'],true);
                   $form_values = json_decode($form_values,true);
                   // echo $form_values['reference'][0];
                   // echo $form_values['previous_address'][0];
                   // echo json_encode($form_values['drug_test']);
                   // echo $user['form_values'];
                   $document_check = 1;
                   $in_array = '';
                  if (isset($form_values['document_check'][0])?$form_values['document_check'][0]:0 > 0) {
                     $document_check = count($form_values['document_check']);
                     $in_array = implode(',', isset($form_values['document_check'])?$form_values['document_check']:array());
                   } 
                   
         ?>
					<input type="hidden" id="in_array" value="<?php echo $in_array; ?>" name="">
					<input type="hidden" id="document_check_count" value="<?php echo $document_check; ?>" name="">
               <input type="hidden" id="document_check_id" value="<?php echo isset($table['document_check']['document_check_id'])?$table['document_check']['document_check_id']:''?>" name="">
             
             <?php  if (in_array(3, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?>  
					<div class="row">
						<div class="col-md-6">
							<div class="input-wrap">
				                 <input name="" required="" class="sign-in-input-field  " name="passport_number" id="passport_number" value="<?php echo isset($table['document_check']['passport_number'])?$table['document_check']['passport_number']:''?>" >
				                <span class="input-field-txt">Passport Number </span>
                  				<div id="passport_number-error">&nbsp;</div>
				            </div>
						</div>
						 <div class="col-md-10">
							<div class="pg-frm-hd">Passport Doc</div>
		                  		<div class="row">
		                  			<div class="col-8">
		                  				<div class="custom-file-name file-name1"> 
                      <?php
                       $passport_doc = '';
                       if (isset($table['document_check'])) {
                       if (!in_array('no-file', explode(',', $table['document_check']['passport_doc']))) {
                         foreach (explode(',', $table['document_check']['passport_doc']) as $key => $value) {
                          if ($value !='') {
                          	 // <a id='remove_file_proof_documents{$key}' onclick='removeFile_documents({$key},\"proof\")' data-path='proof-docs' data-field='passport_doc' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a>
                             echo "<div id='proof{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"proof-docs\")' > <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/passport_doc/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          }
                           
                         }
                          $passport_doc = $table['document_check']['passport_doc'];
                       }}
                       ?>
                     </div>
                     
                      <input type="hidden" id="passport_doc" value="<?php echo $passport_doc; ?>">
		                  			</div>
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  		<input type="file" id="file1" name="file1" class="input-file w-100" accept="image/*,application/pdf" multiple>
		                  				<button class="btn btn-file-upload" for="file1">
		                  					<img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
		                  			</div>
		                  		</div>
		                  		<div id="file1-error"></div>
		                	</div>
						</div> 
					</div>
				<?php } ?>


             <?php  if (in_array(1, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?>  
					<div class="row mt-5">
						<div class="col-md-6">
							<div class="input-wrap">
				                 <input name="" required="" class="sign-in-input-field " name="pan_number" id="pan_number" value="<?php echo isset($table['document_check']['pan_number'])?$table['document_check']['pan_number']:''?>" >
				                <span class="input-field-txt">Pan Card Number </span>
                  				<div id="pan_number-error">&nbsp;</div>
				            </div>
						</div>
						 <div class="col-md-10">
							<div class="pg-frm-hd">Pan Card Doc</div>
		                  		<div class="row">
		                  			<div class="col-8">
		                  				<div class="custom-file-name file-name2"> 
                      <?php
                     $pan_card_doc = '';
                       if (isset($table['document_check'])) {
                       if (!in_array('no-file', explode(',', $table['document_check']['pan_card_doc']))) {
                         foreach (explode(',', $table['document_check']['pan_card_doc']) as $key => $value) {
                           if ($value !='') {
                           	 // <a id='remove_file_pan_documents{$key}' onclick='removeFile_documents({$key},\"pan\")' data-path='pan-docs' data-field='pan_card_doc' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a>  
                             echo "<div id='pan{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"pan-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/pan_card_doc/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                           }
                         }
                       $pan_card_doc = $table['document_check']['pan_card_doc'];
                       }} 
                       ?></div>
                        <input type="hidden" id="pan_card_doc" value="<?php echo $pan_card_doc; ?>"> 
               				<div id="file2-error">&nbsp;</div>
		                  			</div>
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  		<input type="file" id="file2" name="file2" class="input-file w-100" accept="image/*,application/pdf" multiple>
		                  				<button class="btn btn-file-upload" for="file2">
		                  					<img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
		                  			</div>
		                  		</div>
		                	</div>
						</div> 
					</div>
				<?php } ?>



             <?php  if (in_array(2, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?>  
					<div class="row mt-5">
						<div class="col-md-6">
							<div class="input-wrap">
				                 <input name="" required="" class="sign-in-input-field " name="aadhar_number" id="aadhar_number" value="<?php echo isset($table['document_check']['aadhar_number'])?$table['document_check']['aadhar_number']:''?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  >
				                <span class="input-field-txt">Aadhar Card Number </span>
                  				<div id="aadhar_number-error">&nbsp;</div>
				            </div>
						</div>
						 <div class="col-md-10">
							<div class="pg-frm-hd">Aadhar Doc</div>
		                  		<div class="row">
		                  			<div class="col-8">
		                  				<div class="custom-file-name file-name3"> 
                      <?php
                     $adhar_doc = '';
                       if (isset($table['document_check'])) {
                       if (!in_array('no-file', explode(',', $table['document_check']['adhar_doc']))) {
                         foreach (explode(',', $table['document_check']['adhar_doc']) as $key => $value) {
                           if ($value !='') {
                           	 // <a id='remove_file_aadhar_documents{$key}' onclick='removeFile_documents({$key},\"aadhar\")' data-path='aadhar-docs' data-field='adhar_doc' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a>  
                             echo "<div id='aadhar{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"aadhar-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/adhar_doc/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          }
                         }
                         $adhar_doc = $table['document_check']['adhar_doc'];
                       }}
                       ?></div>
                       <input type="hidden" id="adhar_doc" value="<?php echo $adhar_doc; ?>"> 
               				<div id="file3-error"></div>
		                  			</div>
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  		<input type="file" id="file3" name="file3" class="input-file w-100" accept="image/*,application/pdf" multiple>
		                  				<button class="btn btn-file-upload" for="file3">
		                  					<img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
		                  			</div>
		                  		</div>
		                	</div>
						</div> 
					</div>
				<?php } ?>



             <?php  if (in_array(4, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?>  
					<div class="row mt-5">
						<div class="col-md-6">
							<div class="input-wrap">
				                 <input name="" required="" class="sign-in-input-field " name="voter_id" id="voter_id" value="<?php echo isset($table['document_check']['voter_id'])?$table['document_check']['voter_id']:''?>"   >
				                <span class="input-field-txt">Voter Id Number </span>
                  				<div id="voter_id-error"></div>
				            </div>
						</div>
						 <div class="col-md-10">
							<div class="pg-frm-hd">Voter Doc</div>
		                  		<div class="row">
		                  			<div class="col-8">
		                  				<div class="custom-file-name file-name4"> 
                     <?php
                     $voter_doc = '';
                       if (isset($table['document_check'])) {
                       if (!in_array('no-file', explode(',', $table['document_check']['voter_doc']))) {
                         foreach (explode(',', $table['document_check']['voter_doc']) as $key => $value) {
                           if ($value !='') {
                           	 // <a id='remove_file_aadhar_documents{$key}' onclick='removeFile_documents({$key},\"voter\")' data-path='voter-docs' data-field='voter_doc' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a>  
                             echo "<div id='voter{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"voter-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/voter_doc/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          }
                         }
                         $voter_doc = $table['document_check']['voter_doc'];
                       }}
                       ?></div>
                       <input type="hidden" id="voter_doc" value="<?php echo $voter_doc; ?>"> 
               				<div id="file4-error"></div>
		                  			</div>
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  		<input type="file" id="file4" name="file4" class="input-file w-100" accept="image/*,application/pdf" multiple>
		                  				<button class="btn btn-file-upload" for="file4">
		                  					<img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
		                  			</div>
		                  		</div>
		                	</div>
						</div> 
					</div>
				<?php } ?>



             <?php  if (in_array(5, isset($form_values['document_check'])?$form_values['document_check']:array())) { ?>  
					<div class="row mt-5">
						<div class="col-md-6">
							<div class="input-wrap">
				                 <input name="" required="" class="sign-in-input-field " name="ssn_number" id="ssn_number" value="<?php echo isset($table['document_check']['ssn_number'])?$table['document_check']['ssn_number']:''?>"   >
				                <span class="input-field-txt">SSN Number </span>
                  				<div id="ssn_number-error"></div>
				            </div>
						</div>
						 <div class="col-md-10">
							<div class="pg-frm-hd">SSN Doc</div>
		                  		<div class="row">
		                  			<div class="col-8">
		                  				<div class="custom-file-name file-name5"> 
	                     <?php
	                     $ssn_doc = '';
	                       if (isset($table['document_check'])) {
	                       if (!in_array('no-file', explode(',', $table['document_check']['ssn_doc']))) {
	                         foreach (explode(',', $table['document_check']['ssn_doc']) as $key => $value) {
	                           if ($value !='') {
	                           	 // <a id='remove_file_aadhar_documents{$key}' onclick='removeFile_documents({$key},\"ssn\")' data-path='ssn-docs' data-field='ssn_doc' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a>  
	                             echo "<div id='ssn{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"ssn_doc\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/ssn_doc/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
	                          }
	                         }
	                         $ssn_doc = $table['document_check']['ssn_doc'];
	                       }}
	                       ?></div>
	                       <input type="hidden" id="ssn_doc" value="<?php echo $ssn_doc; ?>"> 
               				<div id="file5-error"></div>
		                  			</div>
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  		<input type="file" id="file5" name="file5" class="input-file w-100" accept="image/*,application/pdf" multiple>
		                  				<button class="btn btn-file-upload" for="file5">
		                  					<img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
		                  			</div>
		                  		</div>
		                	</div>
						</div> 
					</div>
				<?php } ?>


					<div class="row">
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button id="add-document-check" class="save-btn">Save &amp; Continue</button>
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
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-document-check.js" ></script>
