 
					<input type="hidden" id="civil_check_id" value="<?php echo isset($table['civil_check']['civil_check_id'])?$table['civil_check']['civil_check_id']:''; ?>" name="">

					 <?php  
                      $form_values = json_decode($user['form_values'],true);
                      $form_values = json_decode($form_values,true);
                      // echo $form_values['reference'][0];
                      // echo $form_values['previous_address'][0];
                      // echo json_encode($form_values['drug_test']);
                      // echo $user['form_values'];
                      $civil_check = 1; 
                     if (isset($form_values['civil_litigation_check'][0])?$form_values['civil_litigation_check'][0]:0 > 0) {
                        $civil_check = $form_values['civil_litigation_check'][0];
                      }  
                      $j =1;
                  if (isset($table['civil_check']['civil_check_id'])) {
                     $address = json_decode($table['civil_check']['address'],true); 
                     $states = json_decode($table['civil_check']['state'],true);
                     $pin_code = json_decode($table['civil_check']['pin_code'],true);
                     $city = json_decode($table['civil_check']['city'],true);
                     $countries = json_decode($table['civil_check']['country'],true);
                  }
                      for ($i=0; $i < $civil_check; $i++) { 
                        // echo $value['address']; 
                        ?>
                <h2 class="component-name"><?php echo $j++; ?>. Address Details</h2>
					<div class="row">
						 <div class="col-md-8">
							<div class="input-wrap">
				                 <textarea class="sign-in-input-field address" required="" onblur="valid_address(<?php echo $i; ?>)" onkeyup="valid_address(<?php echo $i; ?>)" rows="1" id="address<?php echo $i; ?>"><?php echo isset($address[$i]['address'])?$address[$i]['address']:''; ?></textarea> 
				                <span class="input-field-txt">Address </span>
                  				<div id="address-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						<div class="col-md-4">
							<div class="input-wrap"> 
                                 <input name="" class="sign-in-input-field pincode" required="" value="<?php echo isset($pin_code[$i]['pincode'])?$pin_code[$i]['pincode']:''; ?>"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onblur="valid_pincode(<?php echo $i; ?>)" onkeyup="valid_pincode(<?php echo $i; ?>)" id="pincode<?php echo $i; ?>" type="text">
				                <span class="input-field-txt">Pin Code </span> 
                                  <div id="pincode-error<?php echo $i; ?>">&nbsp;</div>
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <select class="sign-in-input-field country " required="" onchange="valid_countries(<?php echo $i; ?>)" id="country<?php echo $i; ?>" >
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
                                 <select class="sign-in-input-field state " required="" onchange="valid_state(<?php echo $i; ?>)"  id="state<?php echo $i; ?>" >
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
				                 <select class="sign-in-input-field city " required="" onchange="valid_city(<?php echo $i; ?>)" id="city<?php echo $i; ?>" >
                                    <?php 
                                    $get_city = isset($city[$i]['city'])?$city[$i]['city']:'';
                                    if ($city_id !='') { 
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
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button id="add-civil-check" class="save-btn">Save &amp; Continue</button>
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
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-civil-check.js" ></script>
