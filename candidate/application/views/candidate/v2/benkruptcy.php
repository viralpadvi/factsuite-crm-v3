 
					 <input type="hidden" name="" id="landload_id" value="<?php echo isset($table['landload_reference']['landload_id'])?$table['landload_reference']['landload_id']:''; ?>">

					 <?php 
          $form_values = json_decode($user['form_values'],true);
             $form_values = json_decode($form_values,true);
             // echo $form_values['reference'][0];
             // echo $form_values['previous_address'][0];
             // echo json_encode($form_values['drug_test']);
             // echo $user['form_values'];
             $credit = 1;
            if (isset($form_values['bankruptcy_check'][0])?$form_values['bankruptcy_check'][0]:0 > 0) {
               $credit = $form_values['bankruptcy_check'][0];
             } 
          $bankruptcy = isset($table['bankruptcy'])?$table['bankruptcy']:''; // $this->db->where('candidate_id',$user['candidate_id'])->get('bankruptcy')->row_array();
          ?>
          <input type="hidden" name="bankruptcy_id" value="<?php echo  isset($bankruptcy['bankruptcy_id'])?$bankruptcy['bankruptcy_id']:''; ?>" id="bankruptcy_id">
         <?php 
          $document_type = json_decode(isset($bankruptcy['document_type'])?$bankruptcy['document_type']:'-',true);
         $bankruptcy_number = json_decode(isset($bankruptcy['bankruptcy_number'])?$bankruptcy['bankruptcy_number']:'-',true);
           $bankruptcy_doc = json_decode(isset($bankruptcy['bankruptcy_doc'])?$bankruptcy['bankruptcy_doc']:'no-file',true);
         	for ($i=0; $i < $credit; $i++) {  
            $doc_type = isset($document_type[$i]['document_type'])?$document_type[$i]['document_type']:'-';
            $pan = '';
            $nric = '';
            if ($doc_type == 'Passport') {
              $pan = 'selected';
            }else if ($doc_type == 'NRIC') {
              $nric = 'selected';
            }
         ?>
					<div class="row">
					 
						 <div class="col-md-6">
							<div class="input-wrap">
				                <select class="sign-in-input-field document_type" id="credit_type<?php echo $i; ?>" >
                 <option value=""> Select Document Type</option>
                 <option <?php echo $pan; ?> value="Passport">Passport</option>
                 <option <?php echo $nric; ?> value="NRIC">NRIC</option> 
               </select>
				                <span class="input-field-txt">Document Type</span>
                <div id="document_type-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						 <div class="col-md-6">
							<div class="input-wrap"> 
                  
                  <input type="text"class="sign-in-input-field bankruptcy" name="bankruptcy" id="bankruptcy<?php echo $i; ?>" value="<?php echo isset($bankruptcy_number[$i]['bankruptcy_number'])?$bankruptcy_number[$i]['bankruptcy_number']:''; ?>" >
				                <span class="input-field-txt">Document Number </span> 
               				<div id="bankruptcy-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						 <!--  --> 
					</div>

					<?php 
            }
         ?>

				 
					  
					<div class="row">
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button  id="add-document-check"  class="save-btn">Save &amp; Continue</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

 

<script> 
    var candidate_info = <?php echo json_encode($user); ?>;
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-bankruptcy.js" ></script>
