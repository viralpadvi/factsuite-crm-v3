<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-court-record-1';
   }
</script>
					<input type="hidden" id="court_records_id" value="<?php echo isset($table['court_records']['court_records_id'])?$table['court_records']['court_records_id']:''; ?>" name="">

					<?php 
                  $form_values = json_decode($user['form_values'],true);
                   $form_values = json_decode($form_values,true);
                   // echo $form_values['reference'][0];
                   // echo $form_values['previous_address'][0];
                   // echo json_encode($form_values['drug_test']);
                   // echo $user['form_values'];
                   $court_record = 1;
                   $j =1;
                  if (isset($form_values['court_record'][0])?$form_values['court_record'][0]:0 > 0) {
                     $court_record = $form_values['court_record'][0];
                  }
                  if (isset($table['court_records']['address'])) {
                     $address = json_decode($table['court_records']['address'],true); 
                     $states = json_decode($table['court_records']['state'],true);
                     $countries = json_decode($table['court_records']['country'],true);
                     $pin_code = json_decode($table['court_records']['pin_code'],true);
                     $city = json_decode($table['court_records']['city'],true);
                     $address_proof_doc = json_decode($table['court_records']['address_proof_doc'],true);
                  }
                      for ($i=0; $i < $court_record; $i++) { 
                        // echo $value['address']; 

                       ?>
                <h2 class="component-name"><?php echo $j++; ?>. Address Details</h2>
					<div class="row">
						<div class="col-md-12">
						<label class="custom-checkbox">Copy details mentioned in personal details
						  	<input type="checkbox" id="addresses">
						  	<span class="checkmark" for="addresses"></span>
						</label>
					</div>
						 <div class="col-md-8">
							<div class="input-wrap">
				                 <textarea class="sign-in-input-field address" onblur="valid_address(<?php echo $i; ?>)" onkeyup="valid_address(<?php echo $i; ?>)" rows="1" id="address<?php echo $i; ?>"><?php echo isset($address[$i]['address'])?$address[$i]['address']:''; ?></textarea> 
				                <span class="input-field-txt">Address </span>
                  				<div id="address-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						<div class="col-md-4">
							<div class="input-wrap"> 
                                 <input name="" class="sign-in-input-field pincode" value="<?php echo isset($pin_code[$i]['pincode'])?$pin_code[$i]['pincode']:''; ?>"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onblur="valid_pincode(<?php echo $i; ?>)" onkeyup="valid_pincode(<?php echo $i; ?>)" id="pincode<?php echo $i; ?>" type="text">
				                <span class="input-field-txt">Pin Code </span> 
                                  <div id="pincode-error<?php echo $i; ?>">&nbsp;</div>
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <select class="sign-in-input-field country " onchange="valid_countries(<?php echo $i; ?>)" id="country<?php echo $i; ?>" >
                                    <?php
                                    $get_country = isset($countries[$i]['country'])?$countries[$i]['country']:'India';
                                    $c_id = '';
                                    foreach ($country as $key1 => $val) {
                                       if ($get_country == $val['name']) {
                                        $c_id = $val['id'];
                                          echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                                       }else{
                                          echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                                       }
                                    }
                                       
                                     ?>
                                 </select> 
				                <span class="input-field-txt">Country </span>

                                 <div id="country-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <?php
                                 if ($c_id !='') {
                                      $state = $this->candidateModel->get_all_states($c_id);  
                                    }
                                 ?>
                                 <select class="sign-in-input-field state " onchange="valid_state(<?php echo $i; ?>)"  id="state<?php echo $i; ?>" >
                                 	<option value="">Select State</option> 
                                    <?php 
                                    $get_state = isset($states[$i]['state'])?$states[$i]['state']:'';
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
                                 <div id="state-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>

						 <div class="col-md-4">
							<div class="input-wrap">
				                 <select class="sign-in-input-field city " onchange="valid_city(<?php echo $i; ?>)" id="city<?php echo $i; ?>" >
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
                                 <div id="city-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>

						 
					</div>

				 <?php 
				 	}
				 ?>
					<div class="row">
						 
						<div class="col-md-10">
							<div class="pg-frm-hd">Address Proof</div>
                  		<div class="row">
                  			<div class="col-8">
                  				<div class="custom-file-name file-name1"> 
				                     <?php $cv_doc = '';
				                       	if (isset($address_proof_doc)) {  
				                       		if (!in_array('no-file', $address_proof_doc)) {
				                         		foreach ($address_proof_doc as $key => $value) {
				                           		if ($value !='') {
				                             			echo "<div id='rental{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"address-docs\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/address-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
				                         		$cv_doc = $value;
				                           		}
				                         		}
				                       		}
				                       	} ?>
				                      	<input type="hidden" value="<?php echo  $cv_doc; ?>" name="court_doc" id="cv_doc">
				                  	</div>
         							<div id="file1-error">&nbsp;</div>
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
		                	</div>
							</div>
						</div>

				   
					<div class="row">
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button id="add-court-record" class="save-btn">Save &amp; Continue</button>
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
   var states = <?php echo json_encode($state); ?>;
    var candidate_info = <?php echo json_encode($user); ?>;
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-court-record.js" ></script>