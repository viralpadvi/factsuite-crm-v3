<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-education';
   }
</script>
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
?>
	<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
			<div class="row content-div-content-row-1"></div>
			<div class="row content-div-content-row">
				<div class="col-12"><span class="input-main-hdr">Education Details 1</span></div>
				<input name="" class="fld form-control" id="education_details_id" value="<?php echo isset($table['education_details']['education_details_id'])?$table['education_details']['education_details_id']:''; ?>" type="hidden">
			</div>
			<?php $edu = array();
      		$form_values = json_decode($user['form_values'],true);
      		$form_values = json_decode($form_values,true); 
      		$highest_education = 1;
     
     		if (isset($form_values['highest_education'][0])?$form_values['highest_education'][0]:0 > 0) {
        		$highest_education = count($form_values['highest_education']);
      		} else if (isset($form_values['education'][0])?$form_values['education'][0]:0 > 0) {
        		$highest_education = count($form_values['education']);
      		}
      		$j = 1;
      	 
            	if (isset($table['education_details']['type_of_degree'])){ 
            		$type_of_degree = json_decode($table['education_details']['type_of_degree'],true);
            		$major = json_decode($table['education_details']['major'],true);
		            $university_board = json_decode($table['education_details']['university_board'],true);
		            $college_school = json_decode($table['education_details']['college_school'],true);
		            $address_of_college_school = json_decode($table['education_details']['address_of_college_school'],true);
		            $course_start_date = json_decode($table['education_details']['course_start_date'],true);
		            $course_end_date = json_decode($table['education_details']['course_end_date'],true);
		            $type_of_course = json_decode($table['education_details']['type_of_course'],true);
		            $registration_roll_number = json_decode($table['education_details']['registration_roll_number'],true);

		             $all_sem_marksheet = json_decode($table['education_details']['all_sem_marksheet'],true);
		            $convocation = json_decode($table['education_details']['convocation'],true);
		            $marksheet_provisional_certificate = json_decode($table['education_details']['marksheet_provisional_certificate'],true);
		            $ten_twelve_mark_card_certificate = json_decode($table['education_details']['ten_twelve_mark_card_certificate'],true);
            	}

            	for ($i=0; $i < $highest_education; $i++) {
            		$court ='';
                    if (isset($form_values['highest_education'][$i])?$form_values['highest_education'][$i]:'' !='') {
                           
                        $court = $this->candidateModel->education_type($form_values['highest_education'][$i]);
                    } else if (isset($form_values['education'][0])?$form_values['education'][0]:0 > 0) {
                        $court = $this->candidateModel->education_type($form_values['education'][$i]);
                    }
              		array_push($edu, $court['education_type_name']); ?>
	      		<div class="row content-div-content-row">
					<div class="col-12"><span class="input-main-hdr"><?php echo isset($court['education_type_name'])?$court['education_type_name']:''; ?> Details</span></div>
					<div class="col-12"><span class="input-main-hdr">Type of Qualification</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
			                <input type="text" class="sign-in-input-field type_of_degree" readonly value="<?php echo isset($type_of_degree[$i]['type_of_degree'])?$type_of_degree[$i]['type_of_degree']:$court['education_type_name']; ?>" onblur="valid_type_of_degree(<?php echo $i; ?>)" onkeyup="valid_type_of_degree(<?php echo $i; ?>)" id="type_of_degree<?php echo $i; ?>" type="text" required>
			               <span class="input-field-txt">Type of Qualification</span>
	           				<div id="type_of_degree-error<?php echo $i; ?>"></div> 
			            </div>
					</div>
				</div>
				<?php 
	            $school = 'College Name';
	            $board = 'University';
	            $class ='';
	            $school_or_college = 'college';
	            $board_or_university = 'university';
	            if ($court['education_type_name'] == '10th') {
	                $school = 'School Name';
	                $board = 'Board';   
	                $class = 'd-none';
	                $school_or_college = 'school';
	                $board_or_university = 'board';
	            }

	            if ($court['education_type_name'] == '12th') {
	                $school = 'School Name';
	                $board = 'Board';   
	                // $class = 'd-none';
	                $school_or_college = 'school';
	                $board_or_university = 'board';
	            }

	            if ($court['education_type_name'] != '10th') { ?>
	            	<div class="row content-div-content-row-2">
						<div class="col-12"><span class="input-main-hdr">Major</span></div>
					</div>
					<div class="row content-div-content-row">
						<div class="col-12">
							<div class="input-wrap">
				                <input name="" class="sign-in-input-field major" value="<?php echo isset($major[$i]['major'])?$major[$i]['major']:''; ?>" onblur="valid_major(<?php echo $i; ?>)" onkeyup="valid_major(<?php echo $i; ?>)" id="major<?php echo $i; ?>" type="text" required>
				                <span class="input-field-txt">Major</span>
		           				<div id="major-error<?php echo $i; ?>"></div> 
				            </div>
						</div>
					</div>
				<?php } else { ?>
	               	<input name="" class="fld form-control major" value="" id="major<?php echo $i; ?>" type="hidden">
	            <?php } ?>
				<div class="row content-div-content-row-2">
					<div class="col-12"><span class="input-main-hdr"><?php echo $board; ?> *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
			                <input type="text" class="sign-in-input-field university" value="<?php echo isset($university_board[$i]['university_board'])?$university_board[$i]['university_board']:''; ?>" onblur="valid_university(<?php echo $i; ?>)" onkeyup="valid_university(<?php echo $i; ?>)" id="university<?php echo $i; ?>" type="text" data-board_or_university="<?php echo $board_or_university;?>" type="text" required>
			                <span class="input-field-txt"><?php echo $board; ?></span>
	           				 <div id="university-error<?php echo $i; ?>"></div> 
			            </div>
					</div>
				</div>
				<div class="row content-div-content-row-2">
					<div class="col-12"><span class="input-main-hdr"><?php echo $school; ?>  *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
			                <input type="text" class="sign-in-input-field college_name" value="<?php echo isset($college_school[$i]['college_school'])?$college_school[$i]['college_school']:''; ?>" onblur="valid_college_name(<?php echo $i; ?>)" onkeyup="valid_college_name(<?php echo $i; ?>)" id="college_name<?php echo $i; ?>" type="text" data-school_or_college="<?php echo $school_or_college;?>" type="text" required>
			                <span class="input-field-txt"><?php echo $school; ?></span>
			                <div id="college_name-error<?php echo $i; ?>"></div>
			            </div>
					</div>
				</div>
				<div class="row content-div-content-row-2">
					<div class="col-12"><span class="input-main-hdr">Address *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
			               <textarea class="sign-in-input-field address"  onblur="valid_address(<?php echo $i; ?>)" onkeyup="valid_address(<?php echo $i; ?>)" id="address<?php echo $i; ?>"  type="text" required><?php echo isset($address_of_college_school[$i]['address_of_college_school'])?$address_of_college_school[$i]['address_of_college_school']:''; ?></textarea>
			                <span class="input-field-txt">Address</span>
	                    	<div id="address-error<?php echo $i; ?>"></div>
			            </div>
					</div>
				</div>
				<div class="row content-div-content-row-2">
					<div class="col-12"><span class="input-main-hdr">Duration of Course</span></div>
				</div>
				<div class="row content-div-content-row-2">
					<div class="col-6"><span class="input-main-hdr">Month*</span></div>
					<div class="col-6"><span class="input-main-hdr">Year*</span></div>
				</div>
				<?php $exploded_from_date = explode('-', isset($course_start_date[$i]['course_start_date'])?$course_start_date[$i]['course_start_date']:''); ?>
				<div class="row content-div-content-row">
					<div class="col-6">
						<div class="input-wrap"> 
			                <select class="sign-in-input-field duration-of-stay-from-month" id="duration-of-stay-from-month" required>
	                     		<option selected value=''>Select Month</option>
	                     		<?php $num = 0;
	                      		for ($m = 1; $m < $this->config->item('duration_of_stay_end_month'); $m++) {
	                        		$selected = '';
	                        		if ($exploded_from_date[1] == $m) {
	                           			$selected = 'selected';
	                        		} ?>
	                        		<option <?php echo $selected;?> value="<?php echo $m;?>"><?php echo $months[$num];?></option>
		                     	<?php
			                        $num++;
		                      	} ?>
		                  	</select> 
			             	<span class="input-field-txt">Month *</span>
		                  	<div id="duration-of-stay-from-month-error"></div>
			            </div>
					</div>
					<div class="col-6">
						<div class="input-wrap"> 
			                <select class="sign-in-input-field duration-of-stay-from-year" id="duration-of-stay-from-month" required>
	                     		<option selected value=''>Select Year</option>
	                     		<?php 
	                     			for($a = $this->config->item('current_year'); $a >= $this->config->item('duration_of_stay_start_year'); $a--) {
	                        			$selected = '';
	                        			if ($exploded_from_date[0] == $a) {
	                           				$selected = 'selected';
	                        			}
	                     			?>
	                        		<option <?php echo $selected;?> value="<?php echo $a;?>"><?php echo $a;?></option>
	                     		<?php } ?>
		                  	</select> 
			             	<span class="input-field-txt">Year *</span>
		                  	<div id="duration-of-stay-from-year-error"></div>
			            </div>
					</div>
					<div class="col-12">
						<div id="start-date-error"></div>
					</div>
				</div>

				<div class="row content-div-content-row">
					<div class="col-12"><span class="input-main-hdr">To</span></div>
				</div>
				<?php $exploded_end_date = explode('-', isset($course_end_date[$i]['course_end_date'])?$course_end_date[$i]['course_end_date']:'');?>
				<div class="row content-div-content-row">
					<div class="col-6"><span class="input-main-hdr">Month *</span></div>
					<div class="col-6"><span class="input-main-hdr">Year *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-6">
						<div class="input-wrap"> 
			                <select class="sign-in-input-field duration-of-stay-end-month" id="duration-of-stay-from-month" required>
	                     		<option selected value=''>Select Month</option>
	                     		<?php $num = 0;
	                     		for ($m = 1; $m < $this->config->item('duration_of_stay_end_month'); $m++) {
	                        		$selected = '';
	                        		if ($exploded_end_date[1] == $m) {
	                           			$selected = 'selected';
	                        		} ?>
	                        		<option <?php echo $selected;?> value="<?php echo $m;?>"><?php echo $months[$num];?></option>
	                     		<?php
	                        		$num++;
	                      		} ?>
		                  	</select> 
			             	<span class="input-field-txt">Month *</span>
		                  	<div id="duration-of-stay-end-month-error"></div>
			            </div>
					</div>
					<div class="col-6">
						<div class="input-wrap"> 
			                <select class="sign-in-input-field duration-of-stay-end-year" id="duration-of-stay-from-month" required>
	                     		<option selected value=''>Select Year</option>
	                     		<?php  
	                        	for($a = $this->config->item('current_year'); $a >= $this->config->item('duration_of_stay_start_year'); $a--){
	                        		$selected = '';
	                        		if ($exploded_end_date[0] == $a) {
	                           			$selected = 'selected';
	                        		} ?>
	                        		<option <?php echo $selected;?> value="<?php echo $a;?>"><?php echo $a;?></option>
	                     		<?php } ?>
		                  	</select> 
			             	<span class="input-field-txt">Year *</span>
		                  	<div id="duration-of-stay-end-year-error"></div>
			            </div>
					</div>
					<div class="col-12">
						<div id="end-date-error"></div>
					</div>
				</div>

				<?php
	            	$part_time ='';
	            	$full_time ='';
	            	$type_of_courses = isset($type_of_course[$i]['type_of_course'])?$type_of_course[$i]['type_of_course']:'';
	            	if ($type_of_courses == 'part_time') {
	               		$part_time ='checked';
	            	} else if ($type_of_courses == 'full_time') {
	               		$full_time ='checked';
	            	} else {
	               		$part_time ='checked';
	            	}
	         	?>
				<div class="row content-div-content-row-2">
					<div class="col-12"><span class="input-main-hdr">Part Time / Full Time *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-6">
						<div class="custom-control custom-radio custom-control-inline mrg-btm">
	               			<input type="radio" <?php echo $part_time; ?> class="custom-control-input part_time" value="part_time" name="customRadio<?php echo $i; ?>" id="customRadio1<?php echo $i; ?>">
	               			<label class="custom-control-label pt-1" for="customRadio1<?php echo $i; ?>">Part Time</label>
	            		</div>
					</div>
					<div class="col-6">
						<div class="custom-control custom-radio custom-control-inline mrg-btm">
	               			<input type="radio" <?php echo $full_time; ?> class="custom-control-input part_time" value="full_time" name="customRadio<?php echo $i; ?>" id="customRadio2<?php echo $i; ?>">
	               			<label class="custom-control-label pt-1" for="customRadio2<?php echo $i; ?>">Full Time</label>
	            		</div>
					</div>
				</div>
				<div class="row content-div-content-row-2">
					<div class="col-12"><span class="input-main-hdr">Registration / Roll Number / License Number *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
			                <input class="sign-in-input-field registration_roll_number" value="<?php echo isset($registration_roll_number[$i]['registration_roll_number'])?$registration_roll_number[$i]['registration_roll_number']:''; ?>" onblur="valid_registration_roll_number(<?php echo $i; ?>)" onkeyup="valid_registration_roll_number(<?php echo $i; ?>)" id="registration_roll_number<?php echo $i; ?>" type="text" required> 
			                <span class="input-field-txt">Enter Number</span>
	            			<div id="registration_roll_number-error<?php echo $i; ?>"></div> 
			            </div>
					</div>
				</div>

				<?php if (in_array(strtolower($court['education_type_name']), $this->config->item('all_sem_marksheet_list'))) { ?>
					<div class="row content-div-content-row-2">
						<div class="col-12"><span class="input-main-hdr">
							<?php if (in_array(strtolower($court['education_type_name']), $this->config->item('all_sem_marksheet_list'))) { ?>
								All Sem Marksheet / Consolidate Marksheet *
							<?php } ?>
							</span>
						</div>
					</div>
					<div class="row content-div-content-row">
						<div class="col-12">
			            		<div class="row">
			            			<div class="col-8">
			            				 <!-- id="all_sem_marksheet-img<?php echo $i; ?>" -->
			            				<span class="custom-file-name file-name" id="all_sem_marksheet-error<?php echo $i; ?>">
			            				<?php $marksheet = '';
			            				if (isset($all_sem_marksheet[$i])) {
		                       				if (!in_array('no-file',$all_sem_marksheet[$i])) {
		                         				foreach ($all_sem_marksheet[$i] as $key => $value) {
		                           					if ($value !='') {
		                             					echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"all-marksheet-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/all-marksheet-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
		                             					$marksheet = $value;
		                          					}
		                         				}
		                       				}
		                       			} ?>
		                      			<input type="hidden" class="all_sem_marksheets" id="all_sem_marksheets" value="<?php echo $marksheet; ?>">
			            				</span>
			            			</div>
			            			<div class="col-4 custom-file-input-btn-div">
			            				<div class="custom-file-input">
			            					<input type="file" accept="image/*,application/pdf" id="all_sem_marksheet<?php echo $i; ?>" name="all_sem_marksheet<?php echo $i; ?>" class="input-file w-100 all_sem_marksheet"  multiple>
			            				<button class="btn btn-file-upload" for="all_sem_marksheet<?php echo $i; ?>">
				            				<img src="<?php echo base_url();?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
			            			</div>
			            		</div>
			             	</div>
						</div>
						<div class="col-12">
							<div></div>
						</div>
					</div>
				<?php } 
				if (in_array(strtolower($court['education_type_name']), $this->config->item('transcript_of_records_list'))) { ?>
					<div class="row content-div-content-row-2">
						<div class="col-12">
							<span class="input-main-hdr">Transcript of Records *</span>
						</div>
					</div>
					<div class="row content-div-content-row">
						<div class="col-12">
			            		<div class="row">
			            			<div class="col-8">
			            				 <!-- id="marksheet_provisional_certificate-img<?php echo $i; ?>" -->
			            				<span class="custom-file-name file-name" id="marksheet_provisional_certificate-error<?php echo $i; ?>">
			            				<?php $certificate = '';
			            				if (isset($marksheet_provisional_certificate[$i])) {
	                       					if (!in_array('no-file', $marksheet_provisional_certificate[$i])) {
	                         					foreach ($marksheet_provisional_certificate[$i] as $key => $value) {
	                           						if ($value !='') {
	                           							/* echo "<div id='marksheet{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"marksheet-certi-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_marksheet_documents{$key}' onclick='removeFile_documents({$key},\"marksheet\")' data-path='marksheet-certi-docs' data-field='marksheet_provisional_certificate' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";*/
                           								echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"marksheet-certi-docs\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/rental-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                           								$certificate = $value;
	                          						}
	                         					}
	                       					}
	                       				} ?>
		                      			<input type="hidden" class="marksheet_provisional_certificates" id="marksheet_provisional_certificates" value="<?php echo $certificate; ?>">
			            				</span>
			            			</div>
			            			<div class="col-4 custom-file-input-btn-div">
			            				<div class="custom-file-input">
			            					<input type="file" accept="image/*,application/pdf" id="marksheet_provisional_certificate<?php echo $i; ?>" name="marksheet_provisional_certificate<?php echo $i; ?>" class="input-file w-100 marksheet_provisional_certificate"  multiple>
			            				<button class="btn btn-file-upload" for="marksheet_provisional_certificate<?php echo $i; ?>">
			            					<img src="<?php echo base_url();?>assets/images/paper-clip.png">
			                    			Upload
			                  			</button>
			            			</div>
			            		</div>
			             	</div>
						</div>
						<div class="col-12">
							<div></div>
						</div>
					</div>
				<?php }
				if (in_array(strtolower($court['education_type_name']), $this->config->item('professional_degree_or_degree_convocation_certificate_list'))) { ?>
					<div class="row content-div-content-row-2">
						<div class="col-12">
							<span class="input-main-hdr">Provisional Degree Certificate / Degree Convocation *</span>
						</div>
					</div>
					<div class="row content-div-content-row">
						<div class="col-12">
			            		<div class="row">
			            			<div class="col-8">
			            				 <!-- id="convocation-img<?php echo $i; ?>" -->
			            				<span class="custom-file-name file-name" id="convocation-error<?php echo $i; ?>">
			            				<?php $convocations = ''; 
			            				if (isset($convocation[$i])) {
	                       					if (!in_array('no-file', $convocation[$i])) {
	                         					foreach ($convocation[$i] as $key => $value) {
	                           						if ($value !='') {
	                             						/* echo "<div id='convocation{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"convocation-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_convocation_documents{$key}' onclick='removeFile_documents({$key},\"convocation\")' data-path='convocation-docs' data-field='convocation' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";*/
                             							echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"convocation-docs\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/convocation-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                             							$convocations = $value;
	                          						}
	                         					}
	                       					}
	                       				} ?>
		                      			<input type="hidden" class="convocations" id="convocations" value="<?php echo $convocations; ?>">
			            				</span>
			            			</div>
			            			<div class="col-4 custom-file-input-btn-div">
			            				<div class="custom-file-input">
			            					<input type="file" accept="image/*,application/pdf" id="convocation<?php echo $i; ?>" name="convocation<?php echo $i; ?>" class="input-file w-100 convocation"  multiple>
			            				<button class="btn btn-file-upload" for="convocation<?php echo $i; ?>">
			            					<img src="<?php echo base_url();?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
			            			</div>
			            		</div>
			             	</div>
						</div>
						<div class="col-12">
							<div ></div>
						</div>
					</div>
				<?php }
				if (in_array(strtolower($court['education_type_name']), $this->config->item('10_12_course_completion_certificate_list'))) { ?>
					<div class="row content-div-content-row-2">
						<div class="col-12">
							<span class="input-main-hdr">
								<?php if (in_array(strtolower($court['education_type_name']), $this->config->item('10_12_course_completion_certificate_list'))) {
			               			$upload_type_name = 'Certificate / Course Completion Certificate ';
			               			if ($court['education_type_name'] == '10th') {
			                  			$upload_type_name = '10th Certificate/ Marksheet';
			               			}

			               			if ($court['education_type_name'] == '12th') {
			                  			$upload_type_name = '12th Certificate/ Marksheet';
			               			}
			               			echo $upload_type_name.' *';
			               		} ?>
							</span>
						</div>
					</div>
					<div class="row content-div-content-row">
						<div class="col-12">
			            		<div class="row">
			            			<div class="col-8">
			            				 <!-- id="ten_twelve_mark_card_certificate-img<?php echo $i; ?>" -->
			            				<span class="custom-file-name file-name" id="ten_twelve_mark_card_certificate-error<?php echo $i; ?>">
			            				<?php $ten_val ='';
			            				if (isset($ten_twelve_mark_card_certificate[$i])) {
	                       					if (!in_array('no-file', $ten_twelve_mark_card_certificate[$i])) {
	                         					foreach ($ten_twelve_mark_card_certificate[$i] as $key => $value) {
	                           						if ($value !='') {
	                             						/* echo "<div id='ten{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"ten-twelve-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_ten_documents{$key}' onclick='removeFile_documents({$key},\"ten\")' data-path='ten-twelve-docs' data-field='ten_twelve_mark_card_certificate' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";*/
                              							echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"ten-twelve-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/ten-twelve-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                              							$ten_val = $value;
	                          						}
	                         					}
	                       					}
	                       				} ?>
		                      			<input type="hidden" class="ten" id="ten" value="<?php echo $ten_val; ?>">
			            				</span>
			            			</div>
			            			<div class="col-4 custom-file-input-btn-div">
			            				<div class="custom-file-input">
			            					<input type="file" accept="image/*,application/pdf" id="ten_twelve_mark_card_certificate<?php echo $i; ?>" name="ten_twelve_mark_card_certificate<?php echo $i; ?>" class="input-file w-100 ten_twelve_mark_card_certificate"  multiple>
			            				<button class="btn btn-file-upload" for="ten_twelve_mark_card_certificate<?php echo $i; ?>">
			            					<img src="<?php echo base_url();?>assets/images/paper-clip.png">
			                    		Upload
			                  		</button>
			            			</div>
			            		</div>
			             	</div>
						</div>
						<div class="col-12">
							<div ></div>
						</div>
					</div>
			<?php } } ?>
			<div class="row">
				<!-- disabled -->
				<div class="col-12" id="warning-msg"></div>
				<div class="col-12">
					<button class="save-btn" id="add-education-details">
						Save & Continue
					</button>
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
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-education-details.js" ></script>