<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-previos-employment';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Previous Employment</div>
         <div class="pg-rgt">Step <?php echo array_search('10',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <input name="" class="fld form-control" value="<?php echo isset($table['previous_employment']['previous_emp_id'])?$table['previous_employment']['previous_emp_id']:''; ?>" id="previous_emp_id" type="hidden">
      <div class="pg-frm">
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
            <div id="form<?php echo $i; ?>"></div>
            <div class="full-bx">
               <label>Previous Employment <?php echo $i+1; ?></label>
            </div>
            <div class="full-bx">
               <label>Designation <span>(Required)</span></label>
               <input name="" class="fld designation" value="<?php echo isset($desigination[$i]['desigination'])?$desigination[$i]['desigination']:''; ?>" id="designation<?php echo $i; ?>"  onkeyup="check_designation(<?php echo $i; ?>)" onblur="check_designation(<?php echo $i; ?>)" type="text">
               <div id="designation-error<?php echo $i; ?>"></div>
            </div>

            <div class="full-bx">
               <label>Department <span>(Required)</span></label>
               <input name="" class="fld department" value="<?php echo isset($department[$i]['department'])?$department[$i]['department']:''; ?>" id="department<?php echo $i; ?>"  onkeyup="check_department(<?php echo $i; ?>)" onblur="check_department(<?php echo $i; ?>)" type="text">
               <div id="department-error<?php echo $i; ?>"></div>
            </div>

            <div class="full-bx">
               <label>Employee ID <span>(Required)</span></label>
               <input name="" class="fld employee_id" value="<?php echo isset($employee_id[$i]['employee_id'])?$employee_id[$i]['employee_id']:''; ?>" id="employee_id<?php echo $i; ?>"  onkeyup="check_employee_id(<?php echo $i; ?>)" onblur="check_employee_id(<?php echo $i; ?>)" type="text">
               <div id="employee_id-error<?php echo $i; ?>"></div>
            </div>

            <div class="full-bx">
               <label>Company Name <span>(Required)</span></label>
               <input name="" class="fld company-name" value="<?php echo isset($company_name[$i]['company_name'])?$company_name[$i]['company_name']:''; ?>" id="company-name<?php echo $i; ?>"  onkeyup="check_company_name(<?php echo $i; ?>)" onblur="check_company_name(<?php echo $i; ?>)" type="text">
               <div id="company-name-error<?php echo $i; ?>"></div>
            </div>

            <div class="full-bx">
               <label>Company Website <span>(Required)</span></label>
               <input name="" class="fld company_url" value="<?php echo isset($company_url[$i]['company_url'])?$company_url[$i]['company_url']:''; ?>" id="company_url<?php echo $i; ?>"  onkeyup="valid_company_url(<?php echo $i; ?>)" onblur="valid_company_url(<?php echo $i; ?>)" type="text">
               <div id="company_url-error<?php echo $i; ?>"></div>
            </div>

            <div class="full-bx">
               <label>Address <span>(Required)</span></label>
               <textarea class="fld address" id="address<?php echo $i; ?>" onkeyup="check_address(<?php echo $i; ?>)" onblur="check_address(<?php echo $i; ?>)" type="text"><?php echo isset($address[$i]['address'])?$address[$i]['address']:'';?></textarea>
               <div id="address-error<?php echo $i; ?>"></div>
            </div>

            <div class="full-bx">
               <label>Annual CTC <span>(Required)</span></label>
               <input name="" class="fld annual-ctc" id="annual-ctc<?php echo $i; ?>" value="<?php echo isset($annual_ctc[$i]['annual_ctc'])?$annual_ctc[$i]['annual_ctc']:''; ?>"  onkeyup="check_annual_ctc(<?php echo $i; ?>)" onblur="check_annual_ctc(<?php echo $i; ?>)" type="number">
               <div id="annual-ctc-error<?php echo $i; ?>"></div>
            </div>

            <div class="full-bx">
               <label>Reason For Leaving <span>(Required)</span></label>
               <input name="" class="fld reason-of-leaving" id="reason-for-leaving<?php echo $i; ?>"  value="<?php echo isset($reason_for_leaving[$i]['reason_for_leaving'])?$reason_for_leaving[$i]['reason_for_leaving']:''; ?>" onkeyup="check_reason_of_leaving(<?php echo $i; ?>)" onblur="check_reason_of_leaving(<?php echo $i; ?>)"type="text">
               <div id="reason-for-leaving-error<?php echo $i; ?>"></div>
            </div>

            <div class="full-bx">
               <label>Joining Date <span>(Required)</span></label>
               <input name="" class="fld joining-date multi-form-date-for-candidate-aggreement-start-date" id="joining-date-<?php echo $i; ?>" value="<?php echo isset($joining_date[$i]['joining_date'])?$joining_date[$i]['joining_date']:''; ?>" onkeyup="check_joining_date(<?php echo $i; ?>)" onblur="check_joining_date(<?php echo $i; ?>)" onchange="check_joining_date(<?php echo $i; ?>)" type="text"> 
               <div id="joining-date-error<?php echo $i; ?>"></div>
            </div>

            <div class="full-bx">
               <label>Relieving Date <span>(Required)</span></label>
               <input name="" class="fld relieving-date multi-form-date-for-candidate-aggreement-end-date" disabled id="relieving-date-<?php echo $i; ?>" value="<?php echo isset($relieving_date[$i]['relieving_date'])?$relieving_date[$i]['relieving_date']:''; ?>"  onkeyup="check_relieving_date(<?php echo $i; ?>)" onblur="check_relieving_date(<?php echo $i; ?>)" onchange="check_relieving_date(<?php echo $i; ?>)" type="text"> 
                <div id="relieving-date-error<?php echo $i; ?>">&nbsp;</div>
            </div>

            <div class="full-bx">
               <label>Reporting Manager Name <span>(Required)</span></label>
               <input name="" class="fld reporting-manager-name" id="reporting-manager-name<?php echo $i; ?>" value="<?php echo isset($reporting_manager_name[$i]['reporting_manager_name'])?$reporting_manager_name[$i]['reporting_manager_name']:''; ?>"  onkeyup="check_reporting_manager_name(<?php echo $i; ?>)" onblur="check_reporting_manager_name(<?php echo $i; ?>)" type="text">
               <div id="reporting-manager-name-error<?php echo $i; ?>"></div>
            </div>

            <div class="full-bx">
               <label>Reporting Manager Designation <span>(Required)</span></label>
               <input name="" class="fld reporting-manager-designation" id="reporting-manager-designation<?php echo $i; ?>" value="<?php echo isset($reporting_manager_desigination[$i]['reporting_manager_desigination'])?$reporting_manager_desigination[$i]['reporting_manager_desigination']:''; ?>"  onkeyup="check_reporting_manager_designation(<?php echo $i; ?>)" onblur="check_reporting_manager_designation(<?php echo $i; ?>)" type="text">
               <div id="reporting-manager-designation-error<?php echo $i; ?>"></div>
            </div>

            <div class="full-bx pb-0">
               <div class="float-left wdt-27">
                  <label>Country Code</label>
               </div>
               <div class="float-right wdt-70">
                  <label>Reporting Manager Contact Number <span>(Required)</span></label>
               </div>
               <div class="clr"></div>
            </div>
            <div class="full-bx">
               <div class="float-left wdt-27">
                  <select class="fld reporting-manager-contact-code" id="code">
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
               </div>
               <div class="float-right wdt-70">
                  <input class="fld reporting-manager-contact" id="reporting-manager-contact<?php echo $i; ?>" value="<?php echo isset($reporting_manager_contact_number[$i]['reporting_manager_contact_number'])?$reporting_manager_contact_number[$i]['reporting_manager_contact_number']:''; ?>"  onkeyup="check_reporting_manager_contact(<?php echo $i; ?>)" onblur="check_reporting_manager_contact(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" type="number">
                  <div id="reporting-manager-contact-error<?php echo $i; ?>"></div>
               </div>
               <div class="clr"></div>
            </div>

            <div class="full-bx">
               <label>Reporting Manager Email ID <span>(Optional)</span></label>
               <input class="fld reporting-manager-email-id" id="reporting-manager-email-id<?php echo $i; ?>" value="<?php echo isset($reporting_manager_email_id[$i]['reporting_manager_email_id'])?$reporting_manager_email_id[$i]['reporting_manager_email_id']:''; ?>"  onkeyup="check_reporting_manager_email_id(<?php echo $i; ?>)" onblur="check_reporting_manager_email_id(<?php echo $i; ?>)" type="text">
               <div id="reporting-manager-email-id-error<?php echo $i; ?>"></div>
            </div>

            <div class="full-bx">
               <label>HR Contact Name <span>(Required)</span></label>
               <input name="" class="fld hr-name" id="hr-name<?php echo $i; ?>" value="<?php echo isset($hr_name[$i]['hr_name'])?$hr_name[$i]['hr_name']:''; ?>" onkeyup="check_hr_name(<?php echo $i; ?>)" onblur="check_hr_name(<?php echo $i; ?>)" type="text">
               <div id="hr-name-error<?php echo $i; ?>"></div>
            </div>

            <div class="full-bx pb-0">
               <div class="float-left wdt-27">
                  <label>Country Code</label>
               </div>
               <div class="float-right wdt-70">
                  <label>HR Contact Number <span>(Required)</span></label>
               </div>
               <div class="clr"></div>
            </div>
            <div class="full-bx">
               <div class="float-left wdt-27">
                  <select class="fld hr-contact-code" id="hr-code">
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
               </div>
               <div class="float-right wdt-70">
                  <input class="fld hr-contact" id="hr-contact<?php echo $i; ?>" value="<?php echo isset($hr_contact_number[$i]['hr_contact_number'])?$hr_contact_number[$i]['hr_contact_number']:''; ?>" onkeyup="check_hr_contact(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onblur="check_hr_contact(<?php echo $i; ?>)" type="number">
                  <div id="hr-contact-error<?php echo $i; ?>"></div>
               </div>
               <div class="clr"></div>
            </div>

            <div class="full-bx">
               <label>HR Email ID <span>(Required)</span></label>
               <input name="" class="fld hr-email-id" id="hr-email-id<?php echo $i; ?>" value="<?php echo isset($hr_email_id[$i]['hr_email_id'])?$hr_email_id[$i]['hr_email_id']:''; ?>" onkeyup="check_hr_email_id(<?php echo $i; ?>)" onblur="check_hr_email_id(<?php echo $i; ?>)" type="text">
               <div id="hr-email-id-error<?php echo $i; ?>"></div>
            </div>
         <?php $j++; } ?>
      </div>
      <div id="save-data-error-msg"></div>
      <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/previous-employment-1.js" ></script>