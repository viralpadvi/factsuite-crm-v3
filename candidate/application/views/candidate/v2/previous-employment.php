 
					  <input name="" class="fld form-control" value="<?php echo isset($table['previous_employment']['previous_emp_id'])?$table['previous_employment']['previous_emp_id']:''; ?>" id="previous_emp_id" type="hidden">

					  <?php  
             $form_values = json_decode($user['form_values'],true);
             $form_values = json_decode($form_values,true);
             // echo $form_values['reference'][0];
             // echo $form_values['previous_employment'][0];
             // echo json_encode($form_values['drug_test']);
             // echo $user['form_values'];
             $previous_employment = 1;
            if (isset($form_values['previous_employment'][0])?$form_values['previous_employment'][0]:0 > 0) {
               $previous_employment = $form_values['previous_employment'][0];
             } 
             // echo $refrence;
             $j =1;
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
          $codes = json_decode($table['previous_employment']['code'],true);
          $hr_name = json_decode($table['previous_employment']['hr_name'],true);
          $hr_contact_number = json_decode($table['previous_employment']['hr_contact_number'],true); 
          $hr_code = json_decode($table['previous_employment']['hr_code'],true);

          $appointment_letter = json_decode($table['previous_employment']['appointment_letter'],true);
             $experience_relieving_letter = json_decode($table['previous_employment']['experience_relieving_letter'],true);
             $last_month_pay_slip = json_decode($table['previous_employment']['last_month_pay_slip'],true);
             $bank_statement_resigngation_acceptance = json_decode($table['previous_employment']['bank_statement_resigngation_acceptance'],true);
             $reporting_manager_email_id = json_decode($table['previous_employment']['reporting_manager_email_id'],true);
         $hr_email_id = json_decode($table['previous_employment']['hr_email_id'],true); 
      }
              
           for ($i=0; $i < $previous_employment; $i++) { 
            ?>

					<h2 class="component-name"><?php echo $j; ?>. Last Employment</h2>
					<div class="row">
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field designation" value="<?php echo isset($desigination[$i]['desigination'])?$desigination[$i]['desigination']:''; ?>" id="designation<?php echo $i; ?>"  onkeyup="valid_designation(<?php echo $i; ?>)" onblur="valid_designation(<?php echo $i; ?>)" type="text">
				                <span class="input-field-txt">Designation </span>
                  				<div id="designation-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field department" value="<?php echo isset($department[$i]['department'])?$department[$i]['department']:''; ?>" id="department<?php echo $i; ?>"  onkeyup="valid_department(<?php echo $i; ?>)" onblur="valid_department(<?php echo $i; ?>)" type="text">
				                <span class="input-field-txt">Department </span>
                  				<div id="department-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field employee_id" value="<?php echo isset($employee_id[$i]['employee_id'])?$employee_id[$i]['employee_id']:''; ?>" id="employee_id<?php echo $i; ?>"  onkeyup="valid_employee_id(<?php echo $i; ?>)" onblur="valid_employee_id(<?php echo $i; ?>)" type="text">
				                <span class="input-field-txt">Employee ID </span>
                  				<div id="employee_id-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						 <!--  -->
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field company-name" value="<?php echo isset($company_name[$i]['company_name'])?$company_name[$i]['company_name']:''; ?>" id="company-name<?php echo $i; ?>"  onkeyup="valid_company_name(<?php echo $i; ?>)" onblur="valid_company_name(<?php echo $i; ?>)" type="text">
				                <span class="input-field-txt">Company Name </span>
                  				<div id="company-name-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field company_url" value="<?php echo isset($company_url[$i]['company_url'])?$company_url[$i]['company_url']:''; ?>" id="company_url<?php echo $i; ?>"  onkeyup="valid_company_url(<?php echo $i; ?>)" onblur="valid_company_url(<?php echo $i; ?>)" type="text">
				                <span class="input-field-txt">Company Website </span>
                  				<div id="company_url-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <textarea class="sign-in-input-field address" id="address<?php echo $i; ?>"  onkeyup="valid_address(<?php echo $i; ?>)" onblur="valid_address(<?php echo $i; ?>)" type="text" rows="1"><?php echo isset($address[$i]['address'])?$address[$i]['address']:''; ?></textarea>
				                <span class="input-field-txt">Address </span>
                  				<div id="address-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>

						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field annual-ctc" id="annual-ctc<?php echo $i; ?>" value="<?php echo isset($annual_ctc[$i]['annual_ctc'])?$annual_ctc[$i]['annual_ctc']:''; ?>"  onkeyup="valid_annual_ctc(<?php echo $i; ?>)" onblur="valid_annual_ctc(<?php echo $i; ?>)" type="number">
				                <span class="input-field-txt">Annual CTC </span>
                  				<div id="annual-ctc-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>

						 <div class="col-md-8">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field reasion" id="reasion<?php echo $i; ?>"  value="<?php echo isset($reason_for_leaving[$i]['reason_for_leaving'])?$reason_for_leaving[$i]['reason_for_leaving']:''; ?>" onkeyup="valid_reasion(<?php echo $i; ?>)" onblur="valid_reasion(<?php echo $i; ?>)"type="text">
				                <span class="input-field-txt">Reason For Leaving </span>
                  				<div id="reasion-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field joining-date date-for-candidate-aggreement-start-date" id="joining-date<?php echo $i; ?>" value="<?php echo isset($joining_date[$i]['joining_date'])?$joining_date[$i]['joining_date']:''; ?>" onkeyup="valid_joining_date(<?php echo $i; ?>)" onblur="valid_joining_date(<?php echo $i; ?>)" onchange="valid_joining_date(<?php echo $i; ?>)" type="text"> 
				                <span class="input-field-txt">Joining Date </span>
                  				<div id="joining-date-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						 <div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field relieving-date  date-for-candidate-aggreement-end-date" disabled id="relieving-date<?php echo $i; ?>" value="<?php echo isset($relieving_date[$i]['relieving_date'])?$relieving_date[$i]['relieving_date']:''; ?>"  onkeyup="valid_relieving_date(<?php echo $i; ?>)" onblur="valid_relieving_date(<?php echo $i; ?>)" onchange="valid_relieving_date(<?php echo $i; ?>)" type="text" required> 
				                <span class="input-field-txt">Relieving Date </span>
                  				<div id="department-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div>
						<div class="col-md-12">
							<label>Reporting Manager Details</label>
						</div>
						 <div class="col-md-6">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field  reporting-manager-name" id="reporting-manager-name<?php echo $i; ?>" value="<?php echo isset($reporting_manager_name[$i]['reporting_manager_name'])?$reporting_manager_name[$i]['reporting_manager_name']:''; ?>"  onkeyup="valid_reporting_manager_name(<?php echo $i; ?>)" onblur="valid_reporting_manager_name(<?php echo $i; ?>)" type="text">
				                <span class="input-field-txt">Name</span>
				                <div id="reporting-manager-name-error<?php echo $i; ?>">&nbsp;</div>
                  				 
				            </div>
						</div>
					  <div class="col-md-6">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field  reporting-manager-designation" id="reporting-manager-designation<?php echo $i; ?>" value="<?php echo isset($reporting_manager_desigination[$i]['reporting_manager_desigination'])?$reporting_manager_desigination[$i]['reporting_manager_desigination']:''; ?>"  onkeyup="valid_reporting_manager_designation(<?php echo $i; ?>)" onblur="valid_reporting_manager_designation(<?php echo $i; ?>)" type="text">
				                <span class="input-field-txt">Designation</span>
				                <div id="reporting-manager-designation-error<?php echo $i; ?>">&nbsp;</div>
				            </div>
						</div>
					 
						 
					</div>

					<div class="row">
						 <div class="col-md-2">
							<div class="input-wrap"> 
						              <select class="sign-in-input-field code" id="code">
						                <?php
						                $ccode = isset($codes[$i]['code'])?$codes[$i]['code']:'';
						                foreach ($code['countries'] as $key => $value) {
						                  if ($ccode==$value['code']) {
						                    echo "<option selected >{$value['code']}</option>";
						                  }else{ 
						                  echo "<option>{$value['code']}</option>";
						                  }
						                }
						                ?>
						              </select>
				                <span class="input-field-txt">Code </span>  
				            </div>
						</div> 
						<div class="col-md-4">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field reporting-manager-contact" id="reporting-manager-contact<?php echo $i; ?>" value="<?php echo isset($reporting_manager_contact_number[$i]['reporting_manager_contact_number'])?$reporting_manager_contact_number[$i]['reporting_manager_contact_number']:''; ?>"  onkeyup="valid_reporting_manager_contact(<?php echo $i; ?>)" onblur="valid_reporting_manager_contact(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" type="text">
				                <span class="input-field-txt">Contact Number</span>
                  				<div id="reporting-manager-contact-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div> 

						<div class="col-md-6">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field reporting-manager-email-id" id="reporting-manager-email-id<?php echo $i; ?>" value="<?php echo isset($reporting_manager_email_id[$i]['reporting_manager_email_id'])?$reporting_manager_email_id[$i]['reporting_manager_email_id']:''; ?>"  onkeyup="check_reporting_manager_email_id(<?php echo $i; ?>)" onblur="check_reporting_manager_email_id(<?php echo $i; ?>)" type="text">
				                <span class="input-field-txt">Email ID</span>
                  				<div id="reporting-manager-email-id-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div> 
						<div class="col-md-12">
							<label>HR Details</label>
						</div>
						<div class="col-md-5">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field hr-name" id="hr-name<?php echo $i; ?>" value="<?php echo isset($hr_name[$i]['hr_name'])?$hr_name[$i]['hr_name']:''; ?>" onkeyup="valid_hr_name(<?php echo $i; ?>)" onblur="valid_hr_name(<?php echo $i; ?>)" type="text">
				                <span class="input-field-txt">Contact Name </span>
                  				<div id="hr-name-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div> 

						<div class="col-md-2">
							<div class="input-wrap">
				                 <select class="sign-in-input-field hr-code" id="hr-code">
					                <?php
					                $ccode = isset($hr_code[$i]['hr_code'])?$hr_code[$i]['hr_code']:'';
					                foreach ($code['countries'] as $key => $value) {
					                  if ($ccode==$value['code']) {
					                    echo "<option selected >{$value['code']}</option>";
					                  }else{ 
					                  echo "<option>{$value['code']}</option>";
					                  }
					                }
					                ?>
					              </select>
				                <span class="input-field-txt">Code </span> 
				            </div>
						</div> 

						<div class="col-md-5">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field hr-contact" id="hr-contact<?php echo $i; ?>" value="<?php echo isset($hr_contact_number[$i]['hr_contact_number'])?$hr_contact_number[$i]['hr_contact_number']:''; ?>" onkeyup="valid_hr_contact(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onblur="valid_hr_contact(<?php echo $i; ?>)" type="text">
				                <span class="input-field-txt">Contact Number </span>
                  				<div id="hr-contact-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div> 

						<div class="col-md-6">
							<div class="input-wrap">
				                 <input name="" class="sign-in-input-field hr-email-id" id="hr-email-id<?php echo $i; ?>" value="<?php echo isset($hr_email_id[$i]['hr_email_id'])?$hr_email_id[$i]['hr_email_id']:''; ?>" onkeyup="check_hr_email_id(<?php echo $i; ?>)" onblur="check_hr_email_id(<?php echo $i; ?>)" type="text">
				                <span class="input-field-txt">Email ID </span>
                  				<div id="hr-email-id-error<?php echo $i; ?>">&nbsp;</div> 
				            </div>
						</div> 


					</div>


					<div class="row">
						<div class="col-md-10 mt-3">
							<div class="pg-frm-hd">Appointment Letter</div>
							
		                  		<div class="row">
		                  			<div class="col-8">
		                  			  <!-- id="appointment_letter-img<?php echo $i; ?>" -->
				                     <div class="custom-file-name" id="appointment_letter-error<?php echo $i; ?>"><?php
				                     // $appointment_letter = '';
				                       if (isset($appointment_letter[$i])) {
				                       if (!in_array('no-file', $appointment_letter[$i])) {
				                        // $appointment_letter[$i][0];
				                         foreach ($appointment_letter[$i] as $key => $value) { 
				                           if ($value !='') {
				                           
				                           /* echo "<div id='appointment_letter{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"appointment_letter\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_appointment_letter_documents{$key}' onclick='removeFile_documents({$key},\"appointment_letter\")' data-path='appointment_letter' data-field='appointment_letter' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";*/
				 
				                            echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"appointment_letter\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/appointment_letter/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";

				                          }
				                         }
				                         // $appointment = $table['previous_employment']['appointment_letter'];
				                       }}
				                       ?></div>
				                       <input type="hidden" class="appointment" value="<?php echo json_encode(isset($appointment_letter[$i])?$appointment_letter[$i]:''); ?>">
				                  
				               <div ></div>
		                  			</div>
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  		<input type="file" accept="image/*,application/pdf" id="appointment_letter<?php echo $i; ?>" name="appointment_letter<?php echo $i; ?>" class="input-file w-100 appointment_letter" accept="image/*" multiple>
		                  				<button class="btn btn-file-upload" for="appointment_letter<?php echo $i; ?>">
		                  					<img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
		                  			</div>
		                  		</div>
		                	</div>
						</div>
						<div class="col-md-10 mt-3">
							<div class="pg-frm-hd">Experience/Relieving Letter</div>
							
		                  		<div class="row">
		                  			<div class="col-8">
		                  			  <!-- id="experience_relieving_letter-img<?php echo $i; ?>" -->
			                     <div class="custom-file-name" id="experience_relieving_letter-error<?php echo $i; ?>"><?php
			                     $experience ='';
			                     if (isset($experience_relieving_letter[$i])) {
			                       if (!in_array('no-file', $experience_relieving_letter[$i])) {
			                        // $appointment_letter[$i][0];
			                         foreach ($experience_relieving_letter[$i] as $key => $value) { 
			                           if ($value !='') {
			                           
			                           /* echo "<div id='appointment_letter{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"appointment_letter\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_appointment_letter_documents{$key}' onclick='removeFile_documents({$key},\"appointment_letter\")' data-path='appointment_letter' data-field='appointment_letter' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";*/
			 
			                            echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"experience_relieving_letter\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/experience_relieving_letter/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";

			                          }
			                         }
			                         $experience = $experience_relieving_letter[$i];
			                       }}
			                       ?></div>
			                       <input type="hidden" class="experience" value="<?php echo  json_encode($experience); ?>">
			                  
			               <div ></div>
		                  			</div>
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  		<input type="file" accept="image/*,application/pdf" id="experience_relieving_letter<?php echo $i; ?>" name="experience_relieving_letter" class="input-file w-100 experience_relieving_letter" accept="image/*" multiple>
		                  				<button class="btn btn-file-upload" for="experience_relieving_letter<?php echo $i; ?>">
		                  					<img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
		                  			</div>
		                  		</div>
		                	</div>
						</div>
						<div class="col-md-10 mt-3">
							<div class="pg-frm-hd">Last 3 Month Pay Slip</div> 
							
		                  		<div class="row">
		                  			<div class="col-8">
		                  			  <!-- id="last_month_pay_slip-img<?php echo $i; ?>" -->
					                     <div class="custom-file-name" id="last_month_pay_slip-error<?php echo $i; ?>"><?php
					                     $last_month = '';
					                    if (isset($last_month_pay_slip[$i])) {
					                       if (!in_array('no-file', $last_month_pay_slip[$i])) {
					                        // $appointment_letter[$i][0];
					                         foreach ($last_month_pay_slip[$i] as $key => $value) { 
					                           if ($value !='') {
					                           
					                           /* echo "<div id='appointment_letter{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"appointment_letter\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_appointment_letter_documents{$key}' onclick='removeFile_documents({$key},\"appointment_letter\")' data-path='appointment_letter' data-field='appointment_letter' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";*/
					 
					                            echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"last_month_pay_slip\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/last_month_pay_slip/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";

					                          }
					                         }
					                         $last_month = $last_month_pay_slip[$i];
					                       }}
					                       ?></div>
					                       <input type="hidden" class="last_month" value="<?php echo json_encode($last_month); ?>">
					                   
					               <div></div>
		                  			</div>
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  		<input type="file" accept="image/*,application/pdf" id="last_month_pay_slip<?php echo $i; ?>" name="last_month_pay_slip" class="input-file w-100 last_month_pay_slip"  accept="image/*" multiple>
		                  				<button class="btn btn-file-upload" for="last_month_pay_slip">
		                  					<img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
		                  			</div>
		                  		</div>
		                	</div>
						</div>
						 <div class="col-md-10 mt-3">
							<div class="pg-frm-hd">Bank Statement/ Resignation Acceptance <span></span></div>
							
		                  		<div class="row">
		                  			<div class="col-8">
		                  				 <!-- id="bank_statement_resigngation_acceptance-img<?php echo $i; ?>" -->
		                  				<div class="custom-file-name" id="bank_statement_resigngation_acceptance-error<?php echo $i; ?>"> <?php
						                     $bank_statement ='';
						                     if (isset($bank_statement_resigngation_acceptance[$i])) {
						                       if (!in_array('no-file', $bank_statement_resigngation_acceptance[$i])) {
						                        // $appointment_letter[$i][0];
						                         foreach ($bank_statement_resigngation_acceptance[$i] as $key => $value) { 
						                           if ($value !='') {
						                           
						                           /* echo "<div id='appointment_letter{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"appointment_letter\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_appointment_letter_documents{$key}' onclick='removeFile_documents({$key},\"appointment_letter\")' data-path='appointment_letter' data-field='appointment_letter' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";*/
						                          /* 

						*/

						                            echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"bank_statement_resigngation_acceptance\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/bank_statement_resigngation_acceptance/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";

						                          }
						                         }
						                        $bank_statement = json_encode($bank_statement_resigngation_acceptance[$i]);
						                       }}
						                       ?></div>
						                       <input type="hidden" class="bank_statement" value="<?php echo $bank_statement; ?>" name="">
					               <div></div>
		                  			</div> 
		                  			<div class="col-4 custom-file-input-btn-div">
		                  				<div class="custom-file-input">
		                  		<input type="file" accept="image/*,application/pdf" id="bank_statement_resigngation_acceptance<?php echo $i; ?>" name="bank_statement_resigngation_acceptance" class="input-file w-100 bank_statement_resigngation_acceptance" accept="image/*" multiple >
		                  				<button class="btn btn-file-upload" for="bank_statement_resigngation_acceptance">
		                  					<img src="<?php echo base_url(); ?>assets/images/paper-clip.png">
				                    		Upload
				                  		</button>
		                  			</div>
		                  		</div>
		                	</div>
						</div>


					</div>



					<?php 
					$j++;
						}
					?>
					<div class="row">
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button id="add_employments" onclick="add_employments()"  class="save-btn">Save &amp; Continue</button>
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
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/present-candidate-employment.js?v=<?php echo time(); ?>" ></script>