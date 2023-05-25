<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-previos-employment';
   }
</script> 
	<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>

			<input name="" class="fld form-control" value="<?php echo isset($table['previous_employment']['previous_emp_id'])?$table['previous_employment']['previous_emp_id']:''; ?>" id="previous_emp_id" type="hidden">
         
         <?php  
         $form_values = json_decode($user['form_values'],true);
         $form_values = json_decode($form_values,true);
         $previous_employment = 1;
         if (isset($form_values['previous_employment'][0])?$form_values['previous_employment'][0]:0 > 0) {
            $previous_employment = $form_values['previous_employment'][0];
         } 
         $j = 1;

         if (isset($table['previous_employment']['desigination'])) {
            $desigination = json_decode($table['previous_employment']['desigination'],true);
            $company_url = json_decode($table['previous_employment']['company_url'],true);
            $department = json_decode($table['previous_employment']['department'],true);
            $employee_id = json_decode($table['previous_employment']['employee_id'],true);
            $company_name = json_decode($table['previous_employment']['company_name'],true);
            $address = json_decode($table['previous_employment']['address'],true);
            $annual_ctc = json_decode($table['previous_employment']['annual_ctc'],true);
            $reason_for_leaving = json_decode($table['previous_employment']['reason_for_leaving'],true);
            $joining_date = json_decode($table['previous_employment']['joining_date'],true);
            $relieving_date = json_decode($table['previous_employment']['relieving_date'],true);
            $reporting_manager_name = json_decode($table['previous_employment']['reporting_manager_name'],true);
            $reporting_manager_desigination = json_decode($table['previous_employment']['reporting_manager_desigination'],true);
            $reporting_manager_contact_number = json_decode($table['previous_employment']['reporting_manager_contact_number'],true);
            $reporting_manager_email_id = json_decode($table['previous_employment']['reporting_manager_email_id'],true);
            $codes = json_decode($table['previous_employment']['code'],true);
            $hr_name = json_decode($table['previous_employment']['hr_name'],true);
            $hr_contact_number = json_decode($table['previous_employment']['hr_contact_number'],true); 
            $hr_code = json_decode($table['previous_employment']['hr_code'],true);
            $hr_email_id = json_decode($table['previous_employment']['hr_email_id'],true); 

            $appointment_letter = json_decode($table['previous_employment']['appointment_letter'],true);
            $experience_relieving_letter = json_decode($table['previous_employment']['experience_relieving_letter'],true);
            $last_month_pay_slip = json_decode($table['previous_employment']['last_month_pay_slip'],true);
            $bank_statement_resigngation_acceptance = json_decode($table['previous_employment']['bank_statement_resigngation_acceptance'],true);
         }

         for ($i = 0; $i < $previous_employment; $i++) { ?>
			<div class="row content-div-content-row-1">
				<div class="col-12"><span class="input-main-hdr">Previous Employment <?php echo $i+1; ?></span></div> 
				<div class="col-12"><span class="input-main-hdr">Designation *</span></div> 
			</div>
			<div class="row content-div-content-row">
				 
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field designation" value="<?php echo isset($desigination[$i]['desigination'])?$desigination[$i]['desigination']:''; ?>" id="designation<?php echo $i; ?>"  onkeyup="valid_designation(<?php echo $i; ?>)" onblur="valid_designation(<?php echo $i; ?>)" type="text" required>
            		
		               <span class="input-field-txt">Designation</span>
           				 <div id="designation-error<?php echo $i; ?>"></div> 
		            </div>
				</div>
				 
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Department *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field department" value="<?php echo isset($department[$i]['department'])?$department[$i]['department']:''; ?>" id="department<?php echo $i; ?>"  onkeyup="valid_department(<?php echo $i; ?>)" onblur="valid_department(<?php echo $i; ?>)" type="text" required>
		                <span class="input-field-txt">Department </span>
           				 <div id="department-error<?php echo $i; ?>"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Employee ID *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field employee_id" value="<?php echo isset($employee_id[$i]['employee_id'])?$employee_id[$i]['employee_id']:''; ?>" id="employee_id<?php echo $i; ?>"  onkeyup="valid_employee_id(<?php echo $i; ?>)" onblur="valid_employee_id(<?php echo $i; ?>)" type="text" required>
		                <span class="input-field-txt">Employee ID *</span>
           				 <div id="employee_id-error<?php echo $i; ?>"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Company Name  *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field company-name"value="<?php echo isset($company_name[$i]['company_name'])?$company_name[$i]['company_name']:''; ?>" id="company-name<?php echo $i; ?>" onkeyup="valid_company_name(<?php echo $i; ?>)" onblur="valid_company_name(<?php echo $i; ?>)" type="text" required>
		                <span class="input-field-txt">Company Name </span>
		                <div id="company-name-error<?php echo $i; ?>"></div>
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Company Website *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field company_url" value="<?php echo isset($company_url[$i]['company_url'])?$company_url[$i]['company_url']:''; ?>" id="company_url<?php echo $i; ?>" onkeyup="valid_company_url(<?php echo $i; ?>)" onblur="valid_company_url(<?php echo $i; ?>)" type="text" required>
		                <span class="input-field-txt"> Company Website</span>
		                <div id="first-name-error-v2"></div>
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Address*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap"> 
		                <textarea class="sign-in-input-field address" id="address<?php echo $i; ?>"  onkeyup="valid_address(<?php echo $i; ?>)" onblur="valid_address(<?php echo $i; ?>)" required><?php echo isset($address[$i]['address'])?$address[$i]['address']:''; ?></textarea>
		                <span class="input-field-txt">Enter Address</span>
		                <div id="address-error<?php echo $i; ?>"></div>
		            </div>
				</div>
			</div>
			  
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Annual CTC *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field annual-ctc" id="annual-ctc<?php echo $i; ?>" value="<?php echo isset($annual_ctc[$i]['annual_ctc'])?$annual_ctc[$i]['annual_ctc']:''; ?>"  onkeyup="valid_annual_ctc(<?php echo $i; ?>)" onblur="valid_annual_ctc(<?php echo $i; ?>)" type="number" required>
		                <span class="input-field-txt">Enter Annual CTC</span>
            			<div id="annual-ctc-error<?php echo $i; ?>"></div> 
		            </div>
				</div>
			</div>

			<!--  -->
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Reason For Leaving *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field reason-of-leaving reasion" id="reasion<?php echo $i; ?>"  value="<?php echo isset($reason_for_leaving[$i]['reason_for_leaving'])?$reason_for_leaving[$i]['reason_for_leaving']:''; ?>" onkeyup="valid_reasion(<?php echo $i; ?>)" onblur="valid_reasion(<?php echo $i; ?>)" type="text" required>
		                <span class="input-field-txt">Enter Reason For Leaving</span>
            			<div id="reasion-error<?php echo $i; ?>"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Joining Date *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field joining-date multi-form-date-for-candidate-aggreement-start-date" id="joining-date<?php echo $i; ?>" value="<?php echo isset($joining_date[$i]['joining_date'])?$joining_date[$i]['joining_date']:''; ?>" onkeyup="valid_joining_date(<?php echo $i; ?>)" onblur="valid_joining_date(<?php echo $i; ?>)" onchange="valid_joining_date(<?php echo $i; ?>)" type="text" required> 
		                <span class="input-field-txt">Enter Joining Date</span>
            			<div id="joining-date-error<?php echo $i; ?>"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Relieving Date *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field relieving-date multi-form-date-for-candidate-aggreement-end-date" disabled id="relieving-date<?php echo $i; ?>" value="<?php echo isset($relieving_date[$i]['relieving_date'])?$relieving_date[$i]['relieving_date']:''; ?>"  onkeyup="valid_relieving_date(<?php echo $i; ?>)" onblur="valid_relieving_date(<?php echo $i; ?>)" onchange="valid_relieving_date(<?php echo $i; ?>)" type="text" required> 
		                <span class="input-field-txt">Enter Relieving Date</span>
            		<div id="relieving-date-error<?php echo $i; ?>"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Reporting Manager Name *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field reporting-manager-name" id="reporting-manager-name<?php echo $i; ?>" value="<?php echo isset($reporting_manager_name[$i]['reporting_manager_name'])?$reporting_manager_name[$i]['reporting_manager_name']:''; ?>"  onkeyup="valid_reporting_manager_name(<?php echo $i; ?>)" onblur="valid_reporting_manager_name(<?php echo $i; ?>)" type="text" required>
		                <span class="input-field-txt">Enter Reporting Manager Name</span>
            			<div id="reporting-manager-name-error<?php echo $i; ?>"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Reporting Manager Designation *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field reporting-manager-designation" id="reporting-manager-designation<?php echo $i; ?>" value="<?php echo isset($reporting_manager_desigination[$i]['reporting_manager_desigination'])?$reporting_manager_desigination[$i]['reporting_manager_desigination']:''; ?>"  onkeyup="valid_reporting_manager_designation(<?php echo $i; ?>)" onblur="valid_reporting_manager_designation(<?php echo $i; ?>)" type="text" required>
		                <span class="input-field-txt">Enter Reporting Manager Designation</span>
            		<div id="reporting-manager-designation-error<?php echo $i; ?>"></div> 
		            </div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<!-- <div class="col-3"><span class="input-main-hdr">Country Code *</span></div> -->
				<div class="col-12"><span class="input-main-hdr">Reporting Manager Contact Number *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-3">
					<div class="input-wrap">
		                <select class="sign-in-input-field code" id="code" required>
                     <?php
                     $ccode = isset($codes[$i]['code'])?$codes[$i]['code']:'';
                     foreach ($code['countries'] as $key => $value) {
                        if ($ccode==$value['code']) {
                           echo "<option selected >{$value['code']}</option>";
                        } else { 
                           echo "<option>{$value['code']}</option>";
                        }
                     } ?>
                  </select>
		                <span class="input-field-txt">Code</span> 
		            </div>
				</div>
				<div class="col-9">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field reporting-manager-contact" id="reporting-manager-contact<?php echo $i; ?>" value="<?php echo isset($reporting_manager_contact_number[$i]['reporting_manager_contact_number'])?$reporting_manager_contact_number[$i]['reporting_manager_contact_number']:''; ?>"  onkeyup="valid_reporting_manager_contact(<?php echo $i; ?>)" onblur="valid_reporting_manager_contact(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" type="number" required>
		                <span class="input-field-txt">Contact Number</span> 
               		<div id="reporting-manager-contact-error<?php echo $i; ?>"></div>
		            </div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Reporting Manager Email ID *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field reporting-manager-email-id" id="reporting-manager-email-id<?php echo $i; ?>" value="<?php echo isset($reporting_manager_email_id[$i]['reporting_manager_email_id'])?$reporting_manager_email_id[$i]['reporting_manager_email_id']:''; ?>"  onkeyup="check_reporting_manager_email_id(<?php echo $i; ?>)" onblur="check_reporting_manager_email_id(<?php echo $i; ?>)" type="text" required>
		                <span class="input-field-txt">Reporting Manager Email ID</span>
            		<div id="reporting-manager-email-id-error<?php echo $i; ?>"></div> 
		            </div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">HR Contact Name *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field hr-name" id="hr-name<?php echo $i; ?>" value="<?php echo isset($hr_name[$i]['hr_name'])?$hr_name[$i]['hr_name']:''; ?>" onkeyup="valid_hr_name(<?php echo $i; ?>)" onblur="valid_hr_name(<?php echo $i; ?>)" type="text" required>
		                <span class="input-field-txt">HR Contact Name</span>
            		<div id="hr-name-error<?php echo $i; ?>"></div> 
		            </div>
				</div>
			</div>


			<div class="row content-div-content-row-2">
				<div class="col-3"><span class="input-main-hdr">Country Code *</span></div>
				<div class="col-9"><span class="input-main-hdr">HR Contact Number *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-3">
					<div class="input-wrap">
		                <select class="sign-in-input-field hr-code" id="hr-code" required>
                     <?php
                     $ccode = isset($hr_code[$i]['hr_code'])?$hr_code[$i]['hr_code']:'';
                     foreach ($code['countries'] as $key => $value) {
                        if ($ccode==$value['code']) {
                           echo "<option selected >{$value['code']}</option>";
                        } else {
                           echo "<option>{$value['code']}</option>";
                        }
                     } ?>
                  </select>
		                <span class="input-field-txt">Code</span> 
		            </div>
				</div>
				<div class="col-9">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field hr-contact" id="hr-contact<?php echo $i; ?>" value="<?php echo isset($hr_contact_number[$i]['hr_contact_number'])?$hr_contact_number[$i]['hr_contact_number']:''; ?>" onkeyup="valid_hr_contact(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onblur="valid_hr_contact(<?php echo $i; ?>)" type="number" required>
		                <span class="input-field-txt">HR Contact Number</span> 
               		<div id="hr-contact-error<?php echo $i; ?>"></div>
		            </div>
				</div>
			</div>


			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">HR Email ID  *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field hr-email-id" id="hr-email-id<?php echo $i; ?>" value="<?php echo isset($hr_email_id[$i]['hr_email_id'])?$hr_email_id[$i]['hr_email_id']:''; ?>" onkeyup="check_hr_email_id(<?php echo $i; ?>)" onblur="check_hr_email_id(<?php echo $i; ?>)" type="text" required>
		                <span class="input-field-txt">HR Email ID </span>
            		<div id="hr-email-id-error<?php echo $i; ?>"></div> 
		            </div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Appointment Letter  *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
                  		<div class="row">
                  			<div class="col-8">
                  				 <!-- id="appointment_letter-img<?php echo $i; ?>" -->
                  				<span class="custom-file-name" id="appointment_letter-error<?php echo $i; ?>">
                  					<?php if (isset($appointment_letter[$i])) {
	                       				if (!in_array('no-file', $appointment_letter[$i])) {
	                         				foreach ($appointment_letter[$i] as $key => $value) { 
	                           				if ($value !='') {
	                            					echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"appointment_letter\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/appointment_letter/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
	                          					}
	                         				}
	                       				}
	                       			} ?>
                  				</span>
                  				<input type="hidden" class="appointment" value="<?php echo json_encode(isset($appointment_letter[$i])?$appointment_letter[$i]:''); ?>">
                  			</div>
                  			<div class="col-4 custom-file-input-btn-div">
                  				<div class="custom-file-input">
                  					<input type="file" accept="image/*,application/pdf" id="appointment_letter<?php echo $i; ?>" name="appointment_letter<?php echo $i; ?>" class="input-file w-100 appointment_letter"  multiple>
                  				<button class="btn btn-file-upload" for="appointment_letter<?php echo $i; ?>">
                  					<img src="assets/images/paper-clip.png">
		                    		Upload
		                  		</button>
                  			</div>
                  			<div class="col-12">
                  				<div ></div>
                  			</div>
                  		</div>
                	</div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Experience/Relieving Letter  *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
                  		<div class="row">
                  			<div class="col-8">
                  				 <!-- id="experience_relieving_letter-img<?php echo $i; ?>" -->
                  				<span class="custom-file-name" id="experience_relieving_letter-error<?php echo $i; ?>">
                  					<?php $experience ='';
	                     				if (isset($experience_relieving_letter[$i])) {
	                       					if (!in_array('no-file', $experience_relieving_letter[$i])) {
	                         					foreach ($experience_relieving_letter[$i] as $key => $value) { 
	                           					if ($value !='') {
	                            						echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"experience_relieving_letter\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/experience_relieving_letter/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
	                          						}
	                         					}
	                         					$experience = $experience_relieving_letter[$i];
	                       					}
	                       				} ?>
                  				</span>
                  				<input type="hidden" class="experience" value="<?php echo  json_encode($experience); ?>">
                  			</div>
                  			<div class="col-4 custom-file-input-btn-div">
                  				<div class="custom-file-input">
                  					<input type="file" accept="image/*,application/pdf" id="experience_relieving_letter<?php echo $i; ?>" name="experience_relieving_letter<?php echo $i; ?>" class="input-file w-100 experience_relieving_letter"  multiple>
                  				<button class="btn btn-file-upload" for="experience_relieving_letter<?php echo $i; ?>">
                  					<img src="assets/images/paper-clip.png">
		                    		Upload
		                  		</button>
                  			</div>
                  			<div class="col-12">
                  				<div ></div>
                  			</div>
                  		</div>
                	</div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Last 3 Month Pay Slip  *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
                  		<div class="row">
                  			<div class="col-8">
                  				<span class="custom-file-name file-name file-name1" id="last_month_pay_slip-error<?php echo $i; ?>">
                  					<?php $last_month = '';
                    						if (isset($last_month_pay_slip[$i])) {
                       						if (!in_array('no-file', $last_month_pay_slip[$i])) {
                         						foreach ($last_month_pay_slip[$i] as $key => $value) { 
                           						if ($value !='') {
                            							echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"last_month_pay_slip\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/last_month_pay_slip/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          							}
                         						}
                         						$last_month = $last_month_pay_slip[$i];
                       						}
                       				} ?>
                  				</span>
                  				<input type="hidden" class="last_month" value="<?php echo json_encode($last_month); ?>">
                  			</div>
                  			<div class="col-4 custom-file-input-btn-div">
                  				<div class="custom-file-input">
                  					<input type="file" accept="image/*,application/pdf" id="last_month_pay_slip<?php echo $i; ?>" name="last_month_pay_slip<?php echo $i; ?>" class="input-file w-100 last_month_pay_slip"  multiple>
                  				<button class="btn btn-file-upload" for="last_month_pay_slip<?php echo $i; ?>">
                  					<img src="assets/images/paper-clip.png">
		                    		Upload
		                  		</button>
                  			</div>
                  			<div class="col-12">
                  				<div ></div>
                  			</div>
                  		</div>
                	</div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Bank Statement/ Resignation Acceptance  *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
                  		<div class="row">
                  			<div class="col-8">
                  				<span class="custom-file-name file-name file-name1" id="bank_statement_resigngation_acceptance-img<?php echo $i; ?>">
                  					<?php $bank_statement ='';
                     				if (isset($bank_statement_resigngation_acceptance[$i])) {
                       					if (!in_array('no-file', $bank_statement_resigngation_acceptance[$i])) {
                         					foreach ($bank_statement_resigngation_acceptance[$i] as $key => $value) { 
                           					if ($value !='') {
                            						echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"bank_statement_resigngation_acceptance\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/bank_statement_resigngation_acceptance/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          						}
                         					}
                        					$bank_statement = json_encode($bank_statement_resigngation_acceptance[$i]);
                       					}
                       				} ?> 
                  				</span>
                  				<input type="hidden" class="bank_statement" value="<?php echo $bank_statement; ?>" name="">
                  			</div>
                  			<div class="col-4 custom-file-input-btn-div">
                  				<div class="custom-file-input">
                  		<input type="file" accept="image/*,application/pdf" id="bank_statement_resigngation_acceptance<?php echo $i; ?>" name="bank_statement_resigngation_acceptance<?php echo $i; ?>" class="input-file w-100 bank_statement_resigngation_acceptance"  multiple>
                  				<button class="btn btn-file-upload" for="bank_statement_resigngation_acceptance<?php echo $i; ?>">
                  					<img src="assets/images/paper-clip.png">
		                    		Upload
		                  		</button>
                  			</div>
                  			<div class="col-12">
                  				<div >
               					<div id="bank_statement_resigngation_acceptance-error<?php echo $i; ?>"></div>
                  			</div>
                  		</div>
                	</div>
				</div>
			</div>
			</div>

		<?php } ?>
			
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="add_employments" onclick="add_employments()">
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

	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/present-candidate-employment.js" ></script>