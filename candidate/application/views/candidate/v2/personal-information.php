<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-candidate-information-step-1';
   }
</script>
		<div class="row">
			<div class="col-md-2">
				<div class="input-wrap">
					<?php  $miss = '';
               	$mrs = '';
               	$mr = '';
               	if (isset($user['title'])) {
                  	if ($user['title'] == 'Miss') {
                    		$miss = 'selected';
                  	} else if ($user['title'] == 'Mrs') {
                    		$mrs = 'selected';
                  	} else {
                    		$mr = 'selected';
                  	}
                  } ?>
	                <select class="sign-in-input-field" required id="title">
						<option <?php echo $mr; ?>>Mr</option>  
                     	<option <?php echo $mrs; ?>>Mrs</option>
                     	<option <?php echo $miss; ?>>Miss</option>
					</select>
	                <span class="input-field-txt">Title</span>
	                <div id="title-error"></div>
	            </div>
			</div>
			<div class="col-md-5">
				<div class="input-wrap">
	                <input type="text" class="sign-in-input-field" required="" name="first-name" value="<?php echo isset($user['first_name'])?$user['first_name']:''; ?>" id="first-name">
            		<span class="input-field-txt">Enter First Name</span>
            		<div id="first-name-error"></div>
	            </div>
			</div>
			<div class="col-md-5">
				<div class="input-wrap">
	                <input type="text" class="sign-in-input-field" required="" name="last-name" value="<?php echo isset($user['last_name'])?$user['last_name']:''; ?>" id="last-name">
            		<span class="input-field-txt">Last Name</span>
            		<div id="last-name-error"></div>
	            </div>
			</div>
			<div class="col-md-6">
				<div class="input-wrap">
	                <input type="text" class="sign-in-input-field" required="" name="father-name" value="<?php echo isset($user['father_name'])?$user['father_name']:''; ?>" id="father-name">
            		<span class="input-field-txt">Father's Name</span>
            		<div id="father-name-error"></div>
	            </div>
			</div>
			<div class="col-md-6">
				<div class="input-wrap">
	                <input type="text" class="sign-in-input-field input-date mdate" required="" name="date-of-birth" value="<?php echo isset($user['date_of_birth'])?$user['date_of_birth']:''; ?>" id="date-of-birth">
            		<span class="input-field-txt">Date of Birth</span>
            		<div id="date-of-birth-error"></div>
	            </div>
			</div>
			<?php $main_div_col_type = $house_flat_no_div_col_type = '6';
			$email_id_div_col_type = '12';
			if ($user['document_uploaded_by'] == 'candidate') {
				if ($user['email_id_validated_by_candidate_status'] == 0) {
					$main_div_col_type = '7';
					$email_id_div_col_type = '9 validate-input-div';
					$house_flat_no_div_col_type = '5';
				}
			} ?>
			<div class="col-md-<?php echo $main_div_col_type;?>" id="email-id-main-div">
				<div class="row">
					<div class="col-md-<?php echo $email_id_div_col_type;?>" id="email-id-div">
						<div class="input-wrap">
			                <input type="text" class="sign-in-input-field" required="" disabled name="email-id" value="<?php echo isset($user['email_id'])?$user['email_id']:''; ?>" id="email-id">
	                		<span class="input-field-txt">Email ID</span>
	                		<div id="email-id-error"></div>
			            </div>
					</div>
					<?php if ($user['document_uploaded_by'] == 'candidate') {
					if ($user['email_id_validated_by_candidate_status'] == 0) { ?>
						<div class="col-md-3 validate-input-btn-div" id="validate-email-id-otp-btn-div">
							<div class="input-wrap-btn">
				                <button id="send-otp-email-id-btn" class="verify-input-btn">Verify</button>
				                <button id="validate-email-id-btn" class="verify-input-btn d-none">Submit</button>
				            </div>
						</div>
					<?php } } ?>
				</div>
			</div>
			<?php if ($user['document_uploaded_by'] == 'candidate') {
			if ($user['email_id_validated_by_candidate_status'] == 0) { ?>
				<div class="col-md-2 d-none" id="validate-email-id-otp-input-div">
					<div class="input-wrap">
	                	<input type="text" class="sign-in-input-field" required="" name="email-id-otp"  id="email-id-otp">
            			<span class="input-field-txt">OTP</span>
            			<div id="email-id-otp-error"></div>
	            	</div>
               </div>
            <?php } } ?>
			<div class="col-md-<?php echo $house_flat_no_div_col_type;?>" id="house-flat-no-main-div">
				<div class="input-wrap">
					<input type="text" class="sign-in-input-field" required="" value="<?php echo isset($user['candidate_flat_no'])?$user['candidate_flat_no']:''; ?>" id="house-flat">
            		<span class="input-field-txt">House/Flat No.</span>
            		<div id="house-flat-error"></div>
	            </div>
			</div>
			<div class="col-md-6">
				<div class="input-wrap">
					<input type="text" class="sign-in-input-field" required="" value="<?php echo isset($user['candidate_street'])?$user['candidate_street']:''; ?>" id="street">
            		<span class="input-field-txt">Street/Road</span>
            		<div id="street-error"></div>
	            </div>
			</div>
			<div class="col-md-6">
				<div class="input-wrap">
					<input type="text" class="sign-in-input-field" required="" value="<?php echo isset($user['candidate_area'])?$user['candidate_area']:''; ?>" id="area">
            		<span class="input-field-txt">Area</span>
            		<div id="area-error"></div>
	            </div>
			</div>
			<div class="col-md-6">
				<div class="input-wrap">
					<select class="sign-in-input-field" required id="nationality">
						<option value="">Select Country</option> 
                     	<?php $c_id = '';
                      	foreach ($country as $key => $value) {
                        	if ($user['nationality'] == $value['name'] ) {
                           	$c_id = $value['id'];
                          		echo "<option selected data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                        	} else {
                          		if ($value['name'] =='India') {
                           		$c_id = $value['id'];
                            		echo "<option selected data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                          		}
                        	}
                      	} ?>
					</select>
            		<span class="input-field-txt">Country</span>
            		<div id="nationality-error"></div>
	            </div>
			</div>
			<div class="col-md-6">
				<div class="input-wrap">
					<?php if ($c_id !='') {
                        	$state = $this->candidateModel->get_all_states($c_id);  
                      	}
                      	$city_id ='';
                   	?> 
					<select class="sign-in-input-field state" required onchange="valid_state()" id="state">
						<option value="">Select State</option> 
                     	<?php $get = isset($user['candidate_state'])?$user['candidate_state']:'';
                      	$get_state = isset($user['candidate_state'])?$user['candidate_state']:'Karnataka';
                      	foreach ($state as $key1 => $val) {
                         	if ($get == $val['name']) {
                          		$city_id = $val['id'];
                            	echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         	} else {
                           		if ($get_state == $val['name']) {
                           			$city_id = $val['id'];
                           		}
                            	echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         	}
                      	} ?>
					</select>
            		<span class="input-field-txt">State</span>
            		<div id="state-error"></div>
	            </div>
			</div>
			<div class="col-md-6">
				<div class="input-wrap">
					<select class="sign-in-input-field city" required id="city">
						<option value="">Select City/Town</option> 
                     	<?php $get_city = isset($user['candidate_city'])?$user['candidate_city']:''; 
                      	$cities = $this->candidateModel->get_all_cities($city_id);
                      	foreach ($cities as $key2 => $val) {
                         	if ($get_city == $val['name']) { 
                            	echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         	} else {
                            	echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         	}
                      	} ?>
					</select>
            		<span class="input-field-txt">City/Town</span>
            		<div id="city-error"></div>
	            </div>
			</div>
			<div class="col-md-6">
				<div class="input-wrap">
					<input type="text" class="sign-in-input-field" required="" id="pincode" value="<?php echo isset($user['candidate_pincode'])?$user['candidate_pincode']:''; ?>">
            		<span class="input-field-txt">Pin Code</span>
            		<div id="pincode-error"></div>
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
			<div class="col-md-3">
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
			<div class="col-md-3">
				<div class="pg-frm">
					<div class="input-wrap">
      				<select id="maritial-status" class="sign-in-input-field marital" required>
         				<option <?php echo $single; ?> value="single">Single</option>
         				<option <?php echo $married; ?> value="married">Married</option>
      				</select>
      				<span class="input-field-txt">Marital Status</span>
      				<div id="marital-error"></div>
      			</div>
            </div>
			</div>
			<div class="col-md-12">
				<div class="pg-frm">
               <label>Preferred Contact Time</label>
               <?php 
               $srt = explode(':', isset($user['contact_start_time'])?$user['contact_start_time']:'');
               $end = explode(':', isset($user['contact_end_time'])?$user['contact_end_time']:'');
               $hrs_formate = 13;
               if ($get_timezone_details != '') {
	               if($get_timezone_details['time_formate'] == 24) {
	               	$hrs_formate = $get_timezone_details['time_formate'];
	               	if ($user['contact_start_time'] != '') {
	               		$srt = date("H:i", strtotime($srt[0].':'.$srt[1].' '.$srt[2]));
	               		$srt = explode(':', $srt);
	               	}

	               	if ($user['contact_end_time'] != '') {
	               		$end = date("H:i", strtotime($end[0].':'.$end[1].' '.$end[2]));
	               		$end = explode(':', $end);
	               	}
	            } } ?>
               <div class="row">
            		<div class="col-md-6">
               		<label>Start Time</label>
               		<div class="row">
               			<div class="col-md-4">
               				<div class="input-wrap">
                  				<select id="start-hour" class="sign-in-input-field" required>
                     				<?php for ($h = 0; $h < $hrs_formate; $h++) { 
                           				$a = $h;
                           				if ($h < 10) {
                              				$a = '0'.$h;
                           				}
                           				$select = '';
                           				if ($a == $srt[0]) {
                             					$select = 'selected';
                           				}
                           				echo "<option ".$select." value='".$a."'>".$a."</option>";
                        				} ?>
                  				</select>
                  				<span class="input-field-txt">HH</span>
                  			</div>
               			</div>
               			<div class="col-md-4">
               				<div class="input-wrap">
                  				<select id="start-minute" class="sign-in-input-field" required>
                     				<?php for ($h = 0; $h <= 59; $h++) { 
                           				$a = $h;
                           				if ($h < 10) {
                              				$a = '0'.$h;
                           				}
                           				$select = '';
                           				if ($a == $srt[1]) {
                             					$select = 'selected';
                           				}
                           				echo "<option ".$select." value='".$a."'>".$a."</option>";
                        				} ?>
                  				</select>
                  				<span class="input-field-txt">MM</span>
                  			</div>
               			</div>
               			<?php if($hrs_formate != 24) { ?>
	               			<div class="col-md-4">
	               				<div class="input-wrap">
	                  				<select id="start-type" class="sign-in-input-field" required>
	                  					<?php $am_selected = '';
	                  					$pm_selected = '';
	                  					if (isset($srt[2]) && $srt[2] != '') {
	                  						if (strtolower($srt[2]) == 'am') {
	                  							$am_selected = ' selected';
	                  						} else {
	                  							$pm_selected = ' selected';
	                  						}
	                  					}
	                  					?>
	                     				<option<?php echo $am_selected;?>>AM</option>
	                     				<option<?php echo $pm_selected;?>>PM</option>
	                  				</select>
	                  				<span class="input-field-txt">AM/PM</span>
	                  			</div>
	               			</div>
	               		<?php } ?>
               		</div>
            		</div>
            		<div class="col-md-6">
                		<label>End Time</label>
                		<div class="row">
                			<div class="col-md-4">
                				<div class="input-wrap">
                   				<select id="end-hour" class="sign-in-input-field" required>
                     				<?php for ($h = 0; $h < $hrs_formate; $h++) { 
                           				$a = $h;
                           				if ($h < 10) {
                              				$a = '0'.$h;
                           				}
                           				$select = '';
                           				if ($a == $end[0]) {
                             				$select = 'selected';
                           				}
                           				echo "<option ".$select." value='".$a."'>".$a."</option>";
                        				} ?>
                  				</select>
                  				<span class="input-field-txt">HH</span>
                  			</div>
                			</div>
                			<div class="col-md-4">
                				<div class="input-wrap">
                  				<select id="end-minute" class="sign-in-input-field" required>
                     				<?php for ($h = 0; $h <= 59; $h++) { 
                           				$a = $h;
                           				if ($h < 10) {
                              				$a = '0'.$h;
                           				}
                           				$select = '';
                           				if ($a == $end[1]) {
                             					$select = 'selected';
                           				}
                           				echo "<option ".$select." value='".$a."'>".$a."</option>";
                        				} ?>
                  				</select>
                  				<span class="input-field-txt">MM</span>
                  			</div>
            				</div>
            				<?php if($hrs_formate != 24) { ?>
	            				<div class="col-md-4">
	            					<div class="input-wrap">
	                  				<select id="end-type" class="sign-in-input-field" required>
	                  					<?php $am_selected = '';
	                  					$pm_selected = '';
	                  					if (isset($end[2]) && $end[2] != '') {
	                  						if (strtolower($end[2]) == 'am') {
	                  							$am_selected = ' selected';
	                  						} else {
	                  							$pm_selected = ' selected';
	                  						}
	                  					}
	                  					?>
	                     				<option<?php echo $am_selected;?>>AM</option>
	                     				<option<?php echo $pm_selected;?>>PM</option>
	                  				</select>
	                  				<span class="input-field-txt">AM/PM</span>
	                  			</div>
	            				</div>
	            			<?php  } ?>
                		</div>
            		</div>
             </div>
         	</div>
			</div>
			<div class="col-md-12">
				<div class="pg-frm">
               		<label>Preferred Contact Days</label>
               		<?php $week = isset($user['week'])?$user['week']:'';
                    $days = array(
                            'Sunday',
                            'Monday',
                            'Tuesday',
                            'Wednesday',
                            'Thursday',
                            'Friday',
                            'Saturday');
                    ?>
               		<div class="row">
               			<?php foreach ($days as $key => $value) {
                     		$selected = '';
                        	if (in_array($value,explode(',', $week))) { 
                          		$selected = 'checked';
                        	} ?>
                        	<div class="col-md-3">
                        		<label class="custom-checkbox"><?php echo $value; ?>
										  	<input type="checkbox" <?php echo $selected; ?> class="custom-control-input weeks" value="<?php echo $value; ?>" name="customCheck" id="customCheck<?php echo $key; ?>">
										  	<span class="checkmark" for="customCheck<?php echo $key; ?>"></span>
										</label>
                       		</div>
                        <?php } ?>
               		</div>
               	</div>
			</div>
			<div class="col-md-12 mt-4">
				<div class="pg-frm">
               		<label>Preferred Communication Channel</label>
               		<?php $comm = explode(',', $user['communications']); ?>
               		<div class="row">
                        <div class="col-md-3">
                        	<label class="custom-checkbox">Call
									  	<input type="checkbox" class="custom-control-input communications" <?php if (in_array('Call', $comm)) { echo "checked"; } ?> value="Call" id="customCheck14" name="customCheck">
									  	<span class="checkmark" for="customCheck14"></span>
									</label>
                       	</div>
                       	<div class="col-md-3">
                       		<label class="custom-checkbox">Email
									  	<input type="checkbox" class="custom-control-input communications" <?php if (in_array('Email', $comm)) { echo "checked"; } ?> value="Email" id="customCheck22" name="customCheck">
									  	<span class="checkmark" for="customCheck22"></span>
									</label>
                       	</div>
                       	<div class="col-md-3">
                       		<label class="custom-checkbox">SMS
									  	<input type="checkbox" class="custom-control-input communications" <?php if (in_array('SMS', $comm)) { echo "checked"; } ?> value="SMS" id="customCheck33" name="customCheck">
									  	<span class="checkmark" for="customCheck33"></span>
									</label>
                       	</div>
                       	<div class="col-md-3">
                       		<label class="custom-checkbox">Whatsapp
									  	<input type="checkbox" class="custom-control-input communications" <?php if (in_array('Whatsapp', $comm)) { echo "checked"; } ?> value="Whatsapp" name="customCheck" id="customCheck11">
									  	<span class="checkmark" for="customCheck11"></span>
									</label>
                       	</div>
               		</div>
               	</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5" id="save-candidate-information-btn-div">
				<button class="save-btn" id="save-candidate-information">Save &amp; Continue</button>
			</div>
		</div>
	</div>
</div>

<script>
	var time_formate = '<?php echo $hrs_formate;?>';
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-information.js"></script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/validate-email-id.js"></script>