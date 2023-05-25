<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-employment';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Current Employment</div>
         <div class="pg-rgt">Step <?php echo array_search('6',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <div class="pg-frm">
         <div class="full-bx">
            <label>Designation <span>(Required)</span></label>
           <input name="" class="fld" value="<?php echo isset($table['current_employment']['desigination'])?$table['current_employment']['desigination']:''; ?>" id="designation" type="text">
            <input name="" class="fld" value="<?php echo isset($table['current_employment']['current_emp_id'])?$table['current_employment']['current_emp_id']:''; ?>" id="current_emp_id" type="hidden">
            <div id="designation-error"></div>
         </div>

         <div class="full-bx">
            <label>Department <span>(Required)</span></label>
            <input name="" class="fld" value="<?php echo isset($table['current_employment']['department'])?$table['current_employment']['department']:''; ?>" id="department" type="text">
            <div id="department-error"></div>
         </div>

         <div class="full-bx">
            <label>Employee ID <span>(Required)</span></label>
            <input name="" class="fld" value="<?php echo isset($table['current_employment']['employee_id'])?$table['current_employment']['employee_id']:''; ?>" id="employee_id" type="text">
            <div id="employee_id-error"></div>
         </div>

         <div class="full-bx">
            <label>Company Name <span>(Required)</span></label>
            <input name="" class="fld" value="<?php echo isset($table['current_employment']['company_name'])?$table['current_employment']['company_name']:''; ?>" id="company-name" type="text">
            <div id="company-name-error"></div>
         </div>
         <div class="full-bx">
            <label>Company Website <span>(Required)</span></label>
            <input name="" class="fld" value="<?php echo isset($table['current_employment']['company_url'])?$table['current_employment']['company_url']:''; ?>" id="company_url" type="text">
            <div id="company_url-error"></div>
         </div>
         
         <div class="full-bx">
            <label>Address</label>
            <textarea class="fld" id="address" type="text"> <?php echo isset($table['current_employment']['address'])?$table['current_employment']['address']:''; ?></textarea>
            <div id="address-error"></div>
         </div>

         <div class="full-bx">
            <label>Annual CTC <span>(Required)</span></label>
            <input name="" class="fld" id="annual-ctc" value="<?php echo isset($table['current_employment']['annual_ctc'])?$table['current_employment']['annual_ctc']:''; ?>" type="number">
            <div id="annual-ctc-error"></div>
         </div>

         <div class="full-bx">
            <label>Reason For Leaving <span>(Required)</span></label>
            <input name="" class="fld" id="reason-for-leaving"  value="<?php echo isset($table['current_employment']['reason_for_leaving'])?$table['current_employment']['reason_for_leaving']:''; ?>" type="text">
            <div id="reason-for-leaving-error"></div>
         </div>

         <div class="full-bx">
            <label>Joining Date <span>(Required)</span></label>
            <input name="" class="fld date-for-candidate-aggreement-start-date" id="joining-date" value="<?php echo isset($table['current_employment']['joining_date'])?$table['current_employment']['joining_date']:''; ?>" type="text"> 
            <div id="joining-date-error"></div>
         </div>

         <div class="full-bx">
            <label>Relieving Date <span>(Required)</span></label>
            <input name="" class="fld date-for-candidate-aggreement-end-date" disabled id="relieving-date" value="<?php echo isset($table['current_employment']['relieving_date'])?$table['current_employment']['relieving_date']:''; ?>" type="text"> 
            <div id="relieving-date-error"></div>
         </div>

         <div class="full-bx">
            <label>Reporting Manager Name <span>(Required)</span></label>
            <input name="" class="fld" id="reporting-manager-name" value="<?php echo isset($table['current_employment']['reporting_manager_name'])?$table['current_employment']['reporting_manager_name']:''; ?>" type="text">
            <div id="reporting-manager-name-error"></div>
         </div>

         <div class="full-bx">
            <label>Reporting Manager Designation <span>(Required)</span></label>
            <input name="" class="fld" id="reporting-manager-designation" value="<?php echo isset($table['current_employment']['reporting_manager_desigination'])?$table['current_employment']['reporting_manager_desigination']:''; ?>" type="text">
            <div id="reporting-manager-designation-error"></div>
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
               <select class="fld code" id="reporting-manager-contact-code">
                  <?php 
                  $ccode = '+91';
                  if (isset($codes[$i]['code']) && $codes[$i]['code'] != '') {
                     $ccode = $codes[$i]['code'];
                  }
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
               <input name="" class="fld" id="reporting-manager-contact" value="<?php echo isset($table['current_employment']['reporting_manager_contact_number'])?$table['current_employment']['reporting_manager_contact_number']:''; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  type="text">
               <div id="reporting-manager-contact-error"></div>
            </div>
            <div class="clr"></div>
         </div>

         <div class="full-bx">
            <label>Reporting Manager Email ID <span>(Required)</span></label>
            <input class="fld" value="<?php echo isset($table['current_employment']['reporting_manager_email_id'])?$table['current_employment']['reporting_manager_email_id']:''; ?>" id="reporting-manager-email-id" type="text">
            <div id="reporting-manager-email-id-error"></div>
         </div>

         <div class="full-bx">
            <label>HR Contact Name <span>(Required)</span></label>
            <input name="" class="fld" id="hr-name" value="<?php echo isset($table['current_employment']['hr_name'])?$table['current_employment']['hr_name']:''; ?>" type="text">
            <div id="hr-name-error"></div>
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
               <select class="fld code" id="hr-contact-code">
                  <?php
                  foreach ($code['countries'] as $key => $value) {
                     echo "<option>{$value['code']}</option>";
                  } ?>
               </select>
            </div>
            <div class="float-right wdt-70">
               <input name="" class="fld" id="hr-contact" value="<?php echo isset($table['current_employment']['hr_contact_number'])?$table['current_employment']['hr_contact_number']:''; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  type="text">
               <div id="hr-contact-error"></div>
            </div>
            <div class="clr"></div>
         </div>

         <div class="full-bx">
            <label>HR Email ID <span>(Required)</span></label>
            <input class="fld" value="<?php echo isset($table['current_employment']['hr_email_id'])?$table['current_employment']['hr_email_id']:''; ?>" id="hr-email-id" type="text">
            <div id="hr-email-id-error"></div>
         </div>
      </div>
      <div id="save-data-error-msg"></div>
      <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/current-employment-1.js" ></script>