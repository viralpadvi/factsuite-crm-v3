<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-criminal-check';
   }
</script>
<div class="container-fluid content-bg-color">
		<div class="content-div">
			<input type="hidden" id="criminal_checks_id" value="<?php echo isset($table['criminal_checks']['criminal_check_id'])?$table['criminal_checks']['criminal_check_id']:''; ?>" name="">
			<div class="row"></div>
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
            $criminal_status = 1;
            $j = 1;
            if (isset($form_values['criminal_status'][0])?$form_values['criminal_status'][0]:0 > 0) {
               $criminal_status = $form_values['criminal_status'][0];
	         }

	         if (isset($table['criminal_checks']['address'])) {
               $address = json_decode($table['criminal_checks']['address'],true); 
               $states = json_decode($table['criminal_checks']['state'],true);
               $pin_code = json_decode($table['criminal_checks']['pin_code'],true);
               $city = json_decode($table['criminal_checks']['city'],true);
               $countries = json_decode($table['criminal_checks']['country'],true);
               $duration_of_stay_start = json_decode($table['criminal_checks']['duration_of_stay_start'],true); 
               $duration_of_stay_end = json_decode($table['criminal_checks']['duration_of_stay_end'],true); 
            }
           	for ($i=0; $i < $criminal_status; $i++) { ?>
				<div class="row content-div-content-row-1" id="form<?php echo $i; ?>">
					<div class="col-12"><span class="input-main-hdr"><?php echo $j++; ?>. Address Details</span></div>
				</div>
				<div class="row content-div-content-row" id="form<?php echo $i; ?>">
					<div class="col-12"><span class="input-main-hdr">Address *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
							<textarea class="sign-in-input-field address" required onkeyup="valid_address(<?php echo $i; ?>)" onblur="valid_address(<?php echo $i; ?>)" rows="4" id="address<?php echo $i; ?>"><?php echo isset($address[$i]['address'])?$address[$i]['address']:''; ?></textarea>
			                <span class="input-field-txt">Address</span>
			                <div id="address-error<?php echo $i; ?>"></div>
			            </div>
					</div>
				</div>
				<div class="row content-div-content-row-2">
					<div class="col-12"><span class="input-main-hdr">Pin Code*</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
			                <input type="text" class="sign-in-input-field pincode" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" value="<?php echo isset($pin_code[$i]['pincode'])?$pin_code[$i]['pincode']:''; ?>" onkeyup="valid_pincode(<?php echo $i; ?>)" onblur="valid_pincode(<?php echo $i; ?>)" id="pincode<?php echo $i; ?>" required="">
			                <span class="input-field-txt">Enter Pin Code</span>
			                <div id="pincode-error<?php echo $i; ?>"></div>
			            </div>
					</div>
				</div>
				<div class="row content-div-content-row-2">
					<div class="col-12"><span class="input-main-hdr">Country*</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
			                <select class="sign-in-input-field country" required onchange="valid_countries(<?php echo $i; ?>)" id="country<?php echo $i; ?>">
								<option value=''>Select Country</option>
                    			<?php $get_country = 'India';
                    				if (isset($countries[$i]['country']) && $countries[$i]['country'] != '') {
                       					$get_country = $countries[$i]['country'];
                    				}
                    				$c_id = '';
                    				foreach ($country as $key1 => $val) {
                       					if ($get_country == $val['name']) {
                          					$c_id = $val['id'];
                          					echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                       					} else {
                          					echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                       					}
                    				} ?>
							</select>
			                <span class="input-field-txt">Country</span>
			                <div id="country-error<?php echo $i; ?>"></div>
			            </div>
					</div>
				</div>

				<div class="row content-div-content-row-2">
					<div class="col-12"><span class="input-main-hdr">State*</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<?php if ($c_id != '') {
                    		$state = $this->candidateModel->get_all_states($c_id);  
                 		} ?>
						<div class="input-wrap">
			                <select class="sign-in-input-field state" required onchange="valid_state(<?php echo $i; ?>)" id="state<?php echo $i; ?>">
								<option value=''>Select State</option>
                    			<?php $get_state = '';
                    			if (isset($states[$i]['state']) && $states[$i]['state'] != '') {
                       				$get_state = $states[$i]['state'];
                    			}
                    			$city_id = '';
                    			foreach ($state as $key1 => $val) {
                       				if ($get_state == $val['name']) {
                          				$city_id = $val['id'];
                          				echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                       				} else {
                          				echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                       				}
                    			} ?>
							</select>
			                <span class="input-field-txt">State</span>
			                <div id="state-error<?php echo $i; ?>"></div>
			            </div>
					</div>
				</div>

				<div class="row content-div-content-row-2">
					<div class="col-12"><span class="input-main-hdr">City/Town*</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
			                <select class="sign-in-input-field city" required onchange="valid_city(<?php echo $i; ?>)" id="city<?php echo $i; ?>">
                    			<option value=''>Select City/Town</option>
                    			<?php $get_city = '';
                    			if (isset($city[$i]['city']) && $city[$i]['city'] != '') {
                       				$get_city = $city[$i]['city'];
                    			}

                    			if ($get_city !='') { 
                    			$cities = $this->candidateModel->get_all_cities($city_id);
                    			foreach ($cities as $key2 => $val) {
                       				if ($get_city == $val['name']) { 
                          				echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                       				} else {
                          				echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                       				}
                    			}

                    			} ?>
							</select>
			                <span class="input-field-txt">City/Town</span>
			                <div id="city-error<?php echo $i; ?>"></div>
			            </div>
					</div>
				</div>
				<div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">Duration of Stay *</span></div> 
            <?php $exploded_from_date = explode('-', isset($duration_of_stay_start[$i]['duration_of_stay_start'])?$duration_of_stay_start[$i]['duration_of_stay_start']:'');
               $exploded_end_date = explode('-', isset($duration_of_stay_end[$i]['duration_of_stay_end'])?$duration_of_stay_end[$i]['duration_of_stay_end']:'');
            ?>
         </div>
         <div class="row content-div-content-row">
            <div class="col-6">
               <div class="input-wrap">
                      <select class="sign-in-input-field duration-of-stay-from-month" id="duration-of-stay-from-month" required>
                           <option selected value=''>Select Month</option>
                           <?php
                           $months = $this->config->item('month_names');
                           $num = 0;
                           for ($j = 1; $j < $this->config->item('duration_of_stay_end_month'); $j++) {
                              $selected = '';
                              if ($exploded_from_date != '') {
                                 $from_date = isset($exploded_from_date[1]) ? $exploded_from_date[1] : '';
                                 if ($from_date == $j) {
                                    $selected = 'selected';
                                 }
                              }
                           ?>
                              <option <?php echo $selected;?> value="<?php echo $j;?>"><?php echo $months[$num];?></option>
                           <?php $num++; } ?>
                        </select> 
                      <span class="input-field-txt">Select Month</span>
                     <div id="duration-of-stay-from-month-error"></div> 
                  </div>
            </div>
            <div class="col-6">
               <div class="input-wrap">
                  <select class="sign-in-input-field duration-of-stay-from-year" id="duration-of-stay-from-year" required>
                           <option selected value=''>Select year</option>
                           <?php 
                           for($j = $this->config->item('current_year'); $j >= $this->config->item('duration_of_stay_start_year'); $j--) {
                              $selected = '';
                              if ($exploded_from_date != '') {
                                 $from_year = isset($exploded_from_date[0]) ? $exploded_from_date[0] : '';
                                 if ($from_year == $j) {
                                    $selected = 'selected';
                                 }
                              }
                           ?>
                              <option <?php echo $selected;?> value="<?php echo $j;?>"><?php echo $j;?></option>
                           <?php } ?>
                        </select> 
                  <span class="input-field-txt">Year</span>
                  <div id="duration-of-stay-from-year-error"></div>
               </div>
            </div>

         </div>
         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">To *</span></div>
         </div>
         <div class="row content-div-content-row">
            <div class="col-6">
               <div class="input-wrap">
                      <select class="sign-in-input-field duration-of-stay-end-month" id="duration-of-stay-end-month" required>
                           <option selected value=''>Select Month</option>
                           <?php 
                           $num = 0;
                           for ($j = 1; $j < $this->config->item('duration_of_stay_end_month'); $j++) {
                              $selected = '';
                              if ($exploded_end_date != '') {
                                 $to_month = isset($exploded_end_date[1]) ? $exploded_end_date[1] : '';
                                 if ($to_month == $j) {
                                    $selected = 'selected';
                                 }
                              }
                           ?>
                              <option <?php echo $selected;?> value="<?php echo $j;?>"><?php echo $months[$num];?></option>
                           <?php $num++; } ?>
                        </select> 
                      <span class="input-field-txt">Month</span>
                  <div id="duration-of-stay-end-month-error"></div> 
                  </div>
            </div>

            <div class="col-6">
               <div class="input-wrap">
                      <select class="sign-in-input-field duration-of-stay-end-year" id="duration-of-stay-end-year" required>
                           <option selected value=''>Select year</option>
                           <?php for($j = $this->config->item('current_year'); $j >= $this->config->item('duration_of_stay_start_year'); $j--) {
                              $selected = '';
                              if ($exploded_end_date != '') {
                                 $to_year = isset($exploded_end_date[0]) ? $exploded_end_date[0] : '';
                                 if ($to_year == $j) {
                                    $selected = 'selected';
                                 }
                              }
                           ?>
                              <option <?php echo $selected;?> value="<?php echo $j;?>"><?php echo $j;?></option>
                           <?php } ?>
                        </select> 
                      <span class="input-field-txt">Year</span>
                     <div id="duration-of-stay-end-year-error"></div>
                  </div>
            </div>

         </div>
			<?php } ?>
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="add-criminal-check">
						Save & Continue
					</button>
				</div>
			</div>
		</div>
	</div>
	<script>
   		var states = <?php echo json_encode($state); ?>;
   		var candidate_info = <?php echo json_encode($user); ?>;
	</script>
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-criminal-check.js" ></script>