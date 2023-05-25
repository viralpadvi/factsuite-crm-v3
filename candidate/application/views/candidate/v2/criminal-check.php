<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-criminal-check';
   }
</script>
               <input type="hidden" id="criminal_checks_id" value="<?php echo isset($table['criminal_checks']['criminal_check_id'])?$table['criminal_checks']['criminal_check_id']:''; ?>" name="">

					<?php
               $months = array(
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July ',
                'August',
                'September',
                'October',
                'November',
                'December',
               );
               $form_values = json_decode($user['form_values'],true);
               $form_values = json_decode($form_values,true);
                // echo $form_values['reference'][0];
                // echo $form_values['previous_address'][0];
                // echo json_encode($form_values['drug_test']);
                // echo $user['form_values'];
               $criminal_status = 1;
               if (isset($form_values['criminal_status'][0])?$form_values['criminal_status'][0]:0 > 0) {
                  $criminal_status = $form_values['criminal_status'][0];
               } 
                // echo $refrence;
               $j = 1;
               if (isset($table['criminal_checks']['address'])) {
                  $address = json_decode($table['criminal_checks']['address'],true); 
                  $states = json_decode($table['criminal_checks']['state'],true);
                  $pin_code = json_decode($table['criminal_checks']['pin_code'],true);
                  $city = json_decode($table['criminal_checks']['city'],true);
                  $countries = json_decode($table['criminal_checks']['country'],true);
                  $duration_of_stay_start = json_decode($table['criminal_checks']['duration_of_stay_start'],true); 
                  $duration_of_stay_end = json_decode($table['criminal_checks']['duration_of_stay_end'],true); 
               }
                for ($i = 0; $i < $criminal_status; $i++) { 
                  // echo $value['address']; ?>
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
				                 <textarea class="sign-in-input-field address" required="" onblur="valid_address(<?php echo $i; ?>)" onkeyup="valid_address(<?php echo $i; ?>)" rows="1" id="address<?php echo $i; ?>"><?php echo isset($address[$i]['address'])?$address[$i]['address']:''; ?></textarea> 
				                <span class="input-field-txt">Address </span>
                  				<div id="address-error<?php echo $i; ?>"></div> 
				            </div>
						</div>
						<div class="col-md-4">
							<div class="input-wrap"> 
                                 <input name="" class="sign-in-input-field pincode" required="" value="<?php echo isset($pin_code[$i]['pincode'])?$pin_code[$i]['pincode']:''; ?>"  oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onblur="valid_pincode(<?php echo $i; ?>)" onkeyup="valid_pincode(<?php echo $i; ?>)" id="pincode<?php echo $i; ?>" type="text">
				                <span class="input-field-txt">Pin Code </span> 
                                  <div id="pincode-error<?php echo $i; ?>"></div>
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

                                 <div id="country-error<?php echo $i; ?>"></div> 
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
                                 <div id="state-error<?php echo $i; ?>"></div> 
				            </div>
						</div>

						 <div class="col-md-4">
							<div class="input-wrap">
				                 <select class="sign-in-input-field city " required="" onchange="valid_city(<?php echo $i; ?>)" id="city<?php echo $i; ?>" >
                              <option value="">Select City/Town</option> 
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
                                 <div id="city-error<?php echo $i; ?>"></div> 
				            </div>
						</div>
                  <div class="col-md-12">
                     <?php $exploded_from_date = explode('-', isset($duration_of_stay_start[$i]['duration_of_stay_start'])?$duration_of_stay_start[$i]['duration_of_stay_start']:'');
                     $exploded_end_date = explode('-', isset($duration_of_stay_end[$i]['duration_of_stay_end'])?$duration_of_stay_end[$i]['duration_of_stay_end']:'');
                     ?>
                     <label>Duration of Stay</label>
                     <div class="row">
                        <div class="col-md-5">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="input-wrap">
                                    <select class="sign-in-input-field duration-of-stay-from-month" id="duration-of-stay-from-month" required>
                                             <option value=''>Month</option>
                                             <?php $num = 0;
                                             for ($k = 1; $k <= $this->config->item('duration_of_stay_end_month'); $k++) {
                                                $selected = '';
                                                if ($exploded_from_date != '') {
                                                   $from_date = isset($exploded_from_date[1]) ? $exploded_from_date[1] : '';
                                                   if ($from_date == $k) {
                                                         $selected = 'selected';
                                                   }
                                                }
                                             ?>
                                             <option <?php echo $selected;?> value="<?php echo $k;?>"><?php echo $months[$num];?></option>
                                             <?php $num++; } ?>
                                          </select> 
                                       <span class="input-field-txt">Month</span>
                                          <div id="duration-of-stay-from-month-error"></div>
                                    </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-wrap">
                                    <select class="sign-in-input-field duration-of-stay-from-year" id="duration-of-stay-from-year" required>
                                             <option value=''>Year</option>
                                             <?php for($k = $this->config->item('current_year'); $k >= $this->config->item('duration_of_stay_start_year'); $k--){
                                                $selected = '';
                                                if ($exploded_from_date != '') {
                                                   $from_year = isset($exploded_from_date[0]) ? $exploded_from_date[0] : '';
                                                   if ($from_year == $k) {
                                                         $selected = 'selected';
                                                   } 
                                                } ?>
                                                <option <?php echo $selected;?> value="<?php echo $k;?>"><?php echo $k;?></option>
                                             <?php } ?>
                                          </select> 
                                       <span class="input-field-txt">Year</span>
                                          <div id="duration-of-stay-from-year-error"></div>
                                    </div>
                              </div>
                           </div>
                           <div id="start-date-error"></div>
                        </div>
                        <div class="col-md-2 text-center">
                           <br>TO
                        </div>
                        <div class="col-md-5">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="input-wrap">
                                    <select class="sign-in-input-field duration-of-stay-end-month" id="duration-of-stay-end-month" required>
                                             <option value=''>Month</option>
                                             <?php $num = 0;
                                             for ($k = 1; $k <= $this->config->item('duration_of_stay_end_month'); $k++) {
                                                $selected = '';
                                                if ($exploded_end_date != '') {
                                                   $to_month = isset($exploded_end_date[1]) ? $exploded_end_date[1] : '';
                                                   if ($to_month == $k) {
                                                         $selected = 'selected';
                                                   }
                                                } ?>
                                             <option <?php echo $selected;?> value="<?php echo $k;?>"><?php echo $months[$num];?></option>
                                             <?php $num++; } ?>
                                          </select> 
                                       <span class="input-field-txt">Month</span>
                                          <div id="duration-of-stay-end-month-error"></div>
                                    </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="input-wrap">
                                    <select class="sign-in-input-field duration-of-stay-end-year" id="duration-of-stay-end-year" required>
                                             <option value=''>Year</option>
                                             <?php for($k = $this->config->item('current_year'); $k >= $this->config->item('duration_of_stay_start_year'); $k--){
                                                $selected = '';
                                                if ($exploded_end_date != '') {
                                                   $to_year = isset($exploded_end_date[0]) ? $exploded_end_date[0] : '';
                                                   if ($to_year == $k) {
                                                         $selected = 'selected';
                                                      }
                                                }
                                             ?>
                                             <option <?php echo $selected;?> value="<?php echo $k;?>"><?php echo $k;?></option>
                                             <?php } ?>
                                          </select> 
                                       <span class="input-field-txt">Year</span>
                                          <div id="duration-of-stay-end-year-error"></div>
                                    </div>
                              </div>
                           </div>
                           <div id="end-date-error"></div>
                        </div>
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
							<button id="add-criminal-check" class="save-btn">Save &amp; Continue</button>
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
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-criminal-check.js" ></script>
