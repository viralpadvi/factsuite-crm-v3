<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-information';
   }
</script> 
	<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
			<div class="row content-div-content-row-1">
				<div class="col-10"><span class="input-main-hdr">Name*</span></div>
				<div class="col-2 text-right">
					<img src="<?php echo base_url(); ?>assets/images/info-symbol.svg">
				</div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-3">
					<div class="input-wrap">
						<?php 
                  			$miss ='';
		                  	$mrs ='';
		                  	$mr ='';
		                  	if ($user['title']=='Miss') {
		                    	$miss ='selected';
		                  	} else if ($user['title']=='Mrs') {
		                    	$mrs ='selected';
		                  	} else {
		                    	$mr ='selected';
		                  	} ?>
		                <select class="sign-in-input-field" required id="title">
							<option <?php echo $mr; ?>>Mr</option>  
                     		<option <?php echo $mrs; ?>>Mrs</option>
                     		<option <?php echo $miss; ?>>Miss</option>
						</select>
		                <span class="input-field-txt">Title</span>
		                <div id="first-name-error-v2"></div>
		            </div>
				</div>
				<div class="col-9">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field" value="<?php echo isset($user['first_name'])?$user['first_name']:''; ?>" id="first-name" required="">
		                <span class="input-field-txt">Enter First Name</span>
		                <div id="first-name-error"></div>
		            </div>
				</div>
				<div class="col-6 ">
					<div class="input-wrap">
		               <input type="text" class="sign-in-input-field" value="<?php echo isset($user['father_name'])?$user['father_name']:''; ?>" id="father-name" required="">
		               <span class="input-field-txt">Middle Name</span>
		               <div id="father-name-error"></div>
		            </div>
				</div>
				<div class="col-6">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field" value="<?php echo isset($user['last_name'])?$user['last_name']:''; ?>" id="last-name" required="">
		                <span class="input-field-txt">Last Name</span>
		                <div id="last-name-error"></div>
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Email ID*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field" value="<?php echo isset($user['email_id'])?$user['email_id']:''; ?>" id="email-id" required="" disabled>
		                <span class="input-field-txt">Enter Your Email ID</span>
		                <div id="first-name-error-v2"></div>
		            </div>
				</div>
				<?php 
				if ($user['document_uploaded_by'] == 'candidate') {
					if ($user['email_id_validated_by_candidate_status'] == 0) { ?>
						<div class="col-md-12 d-none" id="validate-email-id-otp-input-div">
							<div class="input-wrap">
				                <input type="number" class="sign-in-input-field" id="email-id-otp" required="">
				                <span class="input-field-txt">OTP</span>
				                <div id="email-id-otp-error"></div>
				            </div>
		               	</div>
		               	<div class="col-md-3" id="validate-email-id-otp-btn-div">
		                  	<div class="pg-frm">
		                     	<button id="send-otp-email-id-btn" class="save-btn">Validate Email ID</button>
		                     	<button id="validate-email-id-btn" class="save-btn d-none">Submit</button>
		                  </div>
		               </div>
	         <?php } } ?>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Date of Birth*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field input-date mdate" value="<?php echo isset($user['date_of_birth'])?$user['date_of_birth']:''; ?>" id="date-of-birth" required="">
		                <span class="input-field-txt">DD/MM/YYYY</span>
		                <div id="date-of-birth-error"></div>
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">House/Flat No.*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field" value="<?php echo isset($user['candidate_flat_no'])?$user['candidate_flat_no']:''; ?>" id="house-flat" required="">
		                <span class="input-field-txt">Enter House/Flat No.</span>
		                <div id="house-flat-error"></div>
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Street/Road*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field" value="<?php echo isset($user['candidate_street'])?$user['candidate_street']:''; ?>" id="street" required="">
		                <span class="input-field-txt">Enter Street/Road</span>
		                <div id="street-error"></div>
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Area*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field" value="<?php echo isset($user['candidate_area'])?$user['candidate_area']:''; ?>" id="area" required="">
		                <span class="input-field-txt">Enter Area</span>
		                <div id="area-error"></div>
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Nationality*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <select class="sign-in-input-field" required id="nationality" onchange="valid_state()" id="state">
		                	<option value="">Select Nationality</option>
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
                          			// echo "<option data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                        		}
                      		} ?>
						</select>
		                <span class="input-field-txt">Nationality</span>
		                <div id="nationality-error"></div>
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">State*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
						<?php if ($c_id !='') {
                        	$state = $this->candidateModel->get_all_states($c_id);  
                      		}
                      		$city_id ='';
                   		?>
		                <select class="sign-in-input-field" required onchange="valid_state()" id="state">
							<option selected value=''>Select State</option>
                      		<?php 
                      		$get = isset($user['candidate_state'])?$user['candidate_state']:'';
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
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">City/Town*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <select class="sign-in-input-field" required id="city">
							<?php 
                      		$get_city = isset($user['candidate_city'])?$user['candidate_city']:''; 
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
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Pin Code*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field" id="pincode" value="<?php echo isset($user['candidate_pincode'])?$user['candidate_pincode']:''; ?>" required="">
		                <span class="input-field-txt">Enter Pin Code</span>
		                <div id="pincode-error"></div>
		            </div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-6"><span class="input-main-hdr">Gender*</span></div>
				<div class="col-6"><span class="input-main-hdr">Marital Status*</span></div>
			</div>
			<?php
         	$male = ''; $female = ''; $single = ''; $married = '';
         	// echo isset($user['gender'])?$user['gender']:'';
         	if (isset($user['gender'])) {
             	if ($user['gender'] != 'male') {
             		$female = 'selected';
             	} else {
              		$male = 'selected';
             	}
         	}

         	if(isset($user['marital_status'])){
            	if ($user['marital_status']=='married') {
               		$married = 'selected';
             	} else {
               		$single = 'selected';
             	} 
         	} ?>
			<div class="row content-div-content-row">
				<div class="col-6">
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
            	<div class="col-6">
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
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Preferred Contact Time</span></div>
				<div class="col-12"><span class="input-main-hdr">Start Date*</span></div>
			</div>
			<div class="row content-div-content-row">
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
				<div class="col-4">
					<div class="input-wrap">
		                <select id="start-hour" class="sign-in-input-field" required="">
                        <?php 
                           for ($h = 0; $h <= $hrs_formate; $h++) { 
                           	$a = $h;
                           	if ($h < 10) {
                              	$a = '0'.$h;
                           	}
                           	$select = '';
                           	if ($a ==$srt[0]) {
                             	$select = 'selected';
                           	}
                           	echo "<option ".$select." value='".$a."'>".$a."</option>";
                        	}
                        ?>
                     </select>
		                <!-- <span class="input-field-txt">Start Date*</span> -->
		            </div>
				</div>
				<div class="col-4">
					<div class="input-wrap">
		                <select id="start-minute" class="sign-in-input-field" required="">
                        <?php 
                     		for ($h = 0; $h <= 59; $h++) { 
                        		$a = $h;
                        		if ($h < 10) {
                           		$a = '0'.$h;
                        		}
                        		$select = '';
                        		if ($a ==$srt[1]) {
                          		$select = 'selected';
                        		}
                        		echo "<option ".$select." value='".$a."'>".$a."</option>";
                     		}
                        	?>
                     	</select>
		                <!-- <span class="input-field-txt">End Date*</span> -->
		            </div>
				</div>
				<?php if($hrs_formate != 24) { ?>
				<div class="col-4">
					<div class="input-wrap">
		                <select id="start-type" class="sign-in-input-field" required="">
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
		                <!-- <span class="input-field-txt">End Date*</span> -->
		            </div>
				</div>
			<?php } ?>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">End Date*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-4">
					<div class="input-wrap">
		                <select id="end-hour" class="sign-in-input-field" required="">
	                        <?php 
	                           	for ($h = 0; $h <= $hrs_formate; $h++) { 
	                              	$a = $h;
	                              	if ($h < 10) {
	                                 	$a = '0'.$h;
	                              	}
	                              	$select = '';
	                              	if ($a ==$end[0]) {
		                                $select = 'selected';
	                              	}
	                              	echo "<option ".$select." value='".$a."'>".$a."</option>";
	                           	}
	                        ?>
                     	</select>
		                <!-- <span class="input-field-txt">Start Date*</span> -->
		            </div>
				</div>
				<div class="col-4">
					<div class="input-wrap">
		                <select id="end-minute" class="sign-in-input-field" required="">
                        	<?php 
                        		for ($h = 0; $h <= 59; $h++) { 
                           		$a = $h;
                           		if ($h < 10) {
                              		$a = '0'.$h;
                           		}
                           		$select = '';
                           		if ($a ==$end[1]) {
                             		$select = 'selected';
                           		}
                           		echo "<option ".$select." value='".$a."'>".$a."</option>";
                        		}
                        	?>
                     	</select>
		                <!-- <span class="input-field-txt">End Date*</span> -->
		            </div>
				</div>
				<?php if($hrs_formate != 24) { ?>
				<div class="col-4">
					<div class="input-wrap">
		               <select id="end-type" class="sign-in-input-field" required="">
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
		                <!-- <span class="input-field-txt">End Date*</span> -->
		            </div>
				</div>
			<?php } ?>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Preferred Contact Days*</span></div>
			</div>
			<div class="row content-div-content-row">
					<?php 
                    $week = isset($user['week'])?$user['week']:'';
                              $days = array(
                                      'Sunday',
                                      'Monday',
                                      'Tuesday',
                                      'Wednesday',
                                      'Thursday',
                                      'Friday',
                                      'Saturday'
                                  );
                   	foreach ($days as $key => $value) {
                     	$selected = '';
                        if (in_array($value,explode(',', $week))) { 
                          $selected = 'checked';
                        } ?>
                        <div class="col-4">
	                        <label class="custom-checkbox"><?php echo $value; ?>
									  	<input type="checkbox" <?php echo $selected; ?> class="custom-control-input weeks" value="<?php echo $value; ?>" name="customCheck" id="customCheck<?php echo $key; ?>">
									  	<span class="checkmark" for="customCheck<?php echo $key; ?>"></span>
									</label>
								</div>
                    <?php } ?>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Preferred Communication Channel*</span></div>
			</div>
			<div class="row content-div-content-row">
					<?php 
            			$comm = explode(',', $user['communications']);
           			?>
           			<div class="col-6">
	           			<label class="custom-checkbox">Call
							  	<input type="checkbox" class="custom-control-input communications" <?php if (in_array('Call', $comm)) { echo "checked"; } ?> value="Call" id="customCheck14" name="customCheck">
							  	<span class="checkmark" for="customCheck14"></span>
							</label>
	               </div>
               	
               	<div class="col-6">
	                 	<label class="custom-checkbox">Email
							  	<input type="checkbox" class="custom-control-input communications" <?php if (in_array('Email', $comm)) { echo "checked"; } ?> value="Email" id="customCheck22" name="customCheck">
							  	<span class="checkmark" for="customCheck22"></span>
							</label>
	               </div>
             	
             		<div class="col-6">
	                 	<label class="custom-checkbox">SMS
							  	<input type="checkbox" class="custom-control-input communications" <?php if (in_array('SMS', $comm)) { echo "checked"; } ?> value="SMS" id="customCheck33" name="customCheck">
							  	<span class="checkmark" for="customCheck33"></span>
							</label>
	               </div>

	               <div class="col-6">
	                 	<label class="custom-checkbox">Whatsapp
							  	<input type="checkbox" class="custom-control-input communications" <?php if (in_array('Whatsapp', $comm)) { echo "checked"; } ?> value="Whatsapp" name="customCheck" id="customCheck11">
							  	<span class="checkmark" for="customCheck11"></span>
							</label>
	               </div>
				<!-- </div> -->
			</div>
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="save-candidate-information">
						Save & Continue
					</button>
				</div>
			</div>
		</div>
	</div>
 	<script>
		var time_formate = '<?php echo $hrs_formate;?>';
	</script>
 	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-information.js"></script>
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/validate-email-id.js"></script>