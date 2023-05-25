          <?php 
           $form_values = json_decode($user['form_values'],true);
             $form_values = json_decode($form_values,true);
             // echo $form_values['reference'][0];
             // echo $form_values['previous_address'][0];
             // echo json_encode($form_values['drug_test']);
             // echo $user['form_values'];
             $credit = 1;
            if (isset($form_values['credit_\/ cibil check'][0])?$form_values['credit_\/ cibil check'][0]:0 > 0) {
               $credit = $form_values['credit_\/ cibil check'][0];
             } 

          $credit_data =  isset($table['credit_cibil'])?$table['credit_cibil']:'';//$this->db->where('candidate_id',$table['credit_cibil']['credit_id'])->get('credit_cibil')->row_array();
          ?>
          <input type="hidden" name="credit_id" value="<?php echo  isset($credit_data['credit_id'])?$credit_data['credit_id']:''; ?>" id="credit_id">
          <?php
           $document_type = json_decode(isset($credit_data['document_type'])?$credit_data['document_type']:'-',true);
           $credit_number = json_decode(isset($credit_data['credit_number'])?$credit_data['credit_number']:'-',true);
           $credit_cibil_doc = json_decode(isset($credit_data['credit_cibil_doc'])?$credit_data['credit_cibil_doc']:'no-file',true);
           // echo json_encode($credit_cibil_doc);
         	for ($i=0; $i < $credit; $i++) {   
             $doc_type = isset($document_type[$i]['document_type'])?$document_type[$i]['document_type']:'-';
            $pan = '';
            $pass = '';
            $nric = '';
            if ($doc_type == 'Pan Card') {
              $pan = 'selected';
            }else if ($doc_type == 'NRIC') {
              $nric = 'selected';
            }else if ($doc_type == 'Passport') {
              $pass = 'selected';
            }
         ?>
         
					<div class="row">
						<div class="col-md-6">
							<div class="input-wrap">
				                <select class="sign-in-input-field document_type" id="document_type<?php echo $i; ?>" >
                 <option value=""> Select Document Type</option>
                 <option <?php echo $pan; ?> value="Pan Card">Pan Card</option>
                 <option <?php echo $nric; ?> value="NRIC">NRIC</option>
                 <option  <?php echo $pass; ?> value="Passport">Passport</option>
               </select>
				                <span class="input-field-txt">Document Type </span>
                <div id="document_type-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						 <div class="col-md-6">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field credit_cibil_number" name="credit_cibil_number" id="credit_cibil_number<?php echo $i; ?>" value="<?php echo isset($credit_number[$i]['credit_cibil_number'])?$credit_number[$i]['credit_cibil_number']:''; ?>" >
				                <span class="input-field-txt">Document Number </span>
               					<div id="credit_cibil_number-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>


						   <div class="col-md-4">
							<div class="input-wrap">
				                 <select class="sign-in-input-field nationality " onchange="valid_countries()" id="nationality" >
                                    <?php
                                     
                                    $c_id = '';
                                    foreach ($country as $key1 => $val) {
                                       if ($user['nationality'] == $val['name'] ) {
                                        $c_id = $val['id'];
                                          echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                                       }else{
                                          echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                                       }
                                    }
                                       
                                     ?>
                                 </select> 
				                <span class="input-field-txt">Country </span>

                                 <div id="nationality-error">&nbsp;</div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <?php
                                 if ($c_id !='') {
                                      $state = $this->candidateModel->get_all_states($c_id);  
                                    }
                                 ?>
                                 <select class="sign-in-input-field state " onchange="valid_state()"  id="state" >
                                  <option value="">Select State</option> 
                                    <?php 
                                    $get = isset($table['credit_cibil']['credit_state'])?$table['credit_cibil']['credit_state']:'';
                     						 $get_state = isset($table['credit_cibil']['credit_state'])?$table['credit_cibil']['credit_state']:'';
                                    $city_id = '';
                                    foreach ($state as $key1 => $val) {
                                       if ($get_state == $val['name']) {
                                          $city_id = $val['id'];
                                          echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                                       }else{
                                          echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                                       }
                                    }
                                       
                                     ?>
                                 </select> 
				                <span class="input-field-txt">State </span>
                                 <div id="state-error">&nbsp;</div> 
				            </div>
						</div>

						 <div class="col-md-4">
							<div class="input-wrap">
				                 <select class="sign-in-input-field city " onchange="valid_city()" id="city" >
                          <option value="">Select City/Town</option> 
                                    <?php 
                                    $get_city = isset($city[$i]['city'])?$city[$i]['city']:'';
                                    if ($get_city !='') { 
                                    $cities = $this->candidateModel->get_all_cities($city_id);
                                    foreach ($cities as $key2 => $val) {
                                       if ($get_city == $val['name']) { 
                                          echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                                       }else{
                                          echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                                       }
                                    }
                                       }
                                     ?>
                                 </select> 
				                <span class="input-field-txt">City </span>
                                 <div id="city-error">&nbsp;</div> 
				            </div>
						</div>
						<div class="col-md-4">
							<div class="input-wrap"> 
                                 <input name="" class="sign-in-input-field pincode" id="pincode" value="<?php echo isset($table['credit_cibil']['credit_pincode'])?$table['credit_cibil']['credit_pincode']:''; ?>" type="text">
				                <span class="input-field-txt">Pin Code </span> 
                                  <div id="pincode-error">&nbsp;</div>
				            </div>
						</div>

							 <div class="col-md-8">
							<div class="input-wrap">
				                 <textarea class="sign-in-input-field address" onkeyup="valid_address()" rows="1" id="address"><?php echo isset($table['credit_cibil']['credit_address'])?$table['credit_cibil']['credit_address']:''; ?></textarea> 
				                <span class="input-field-txt">Address </span>
                  				<div id="address-error">&nbsp;</div> 
				            </div>
						</div>
						


						 
					</div>
 					<?php 
         	}  
         ?>
				  
					<div class="row">
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button id="add-credit-cibil" class="save-btn">Save &amp; Continue</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>


  <div class="modal fade " id="myModal-show" role="dialog">
 <div class="modal-dialog modal-lg modal-dialog-centered">
      <!-- modal-content-view-collection-category -->
      <div class="modal-content">
        <div class="modal-header border-0">
          <h3 id="">View Document</h4>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row mt-2"> 
         <div class="col-md-12 text-center" id="view-img"></div>
    </div>
          <div class="row p-5 mt-2">
              <div class="col-md-6" id="setupDownloadBtn">
                
              </div>
              <div id="view-edit-cancel-btn-div" class="col-md-6  text-right">
                <button class="btn bg-blu text-white exit-btn" data-dismiss="modal">Close</button>
              </div>
            </div>
        </div>
        <!-- <div class="modal-footer border-0"></div> -->
      </div>
    </div>
</div>



<div class="modal fade " id="myModal-remove" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
        </div>
        <div class="modal-body">
         <div id="remove-caption"></div>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center" id="button-area">
              <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
           </div>
        </div>
      </div>
    </div>
  </div>

<script> 
    var candidate_info = <?php echo json_encode($user); ?>;
</script>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-credit-cibil.js" ></script>
