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
            <div class="row mt-3">
               <div class="col-md-12">
                  <div class="pg-frm-hd">Appointment Letter <span>(optional)</span></div>
                  <div id="fls">
                     <div class="form-group files">
                        <label class="btn" for="appointment_letter<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                        <input id="appointment_letter<?php echo $i; ?>"  type="file" style="display:none;" class="form-control fl-btn-n appointment_letter" multiple >
                        <div id="appointment_letter-img<?php echo $i; ?>"><?php
                           // $appointment_letter = '';
                           if (isset($appointment_letter[$i])) {
                              if (!in_array('no-file', $appointment_letter[$i])) {
                                 // $appointment_letter[$i][0];
                                 foreach ($appointment_letter[$i] as $key => $value) { 
                                    if ($value !='') {
                                       echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"appointment_letter\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/appointment_letter/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                    }
                                 }
                              }
                           } ?>
                        </div>
                       <input type="hidden" class="appointment" value="<?php echo json_encode(isset($appointment_letter[$i])?$appointment_letter[$i]:''); ?>">
                     </div>
                     <div id="appointment_letter-error<?php echo $i; ?>"></div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="pg-frm-hd">Experience/Relieving Letter <span>(required)</span></div>
                  <div id="fls">
                     <div class="form-group files">
                        <label class="btn" for="experience_relieving_letter<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                        <input id="experience_relieving_letter<?php echo $i; ?>"  type="file" style="display:none;" class="form-control fl-btn-n experience_relieving_letter" multiple >
                        <div id="experience_relieving_letter-img<?php echo $i; ?>"><?php
                           $experience ='';
                           if (isset($experience_relieving_letter[$i])) {
                              if (!in_array('no-file', $experience_relieving_letter[$i])) {
                                 foreach ($experience_relieving_letter[$i] as $key => $value) { 
                                    if ($value !='') {
                                       echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"experience_relieving_letter\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/experience_relieving_letter/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                    }
                                 }
                                 $experience = $experience_relieving_letter[$i];
                              }
                           } ?>
                        </div>
                        <input type="hidden" class="experience" value="<?php echo  json_encode($experience); ?>">
                     </div>
                     <div id="experience_relieving_letter-error<?php echo $i; ?>"></div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="pg-frm-hd">Last 3 Month Pay Slip <span>(optional)</span></div>
                  <div id="fls">
                     <div class="form-group files">
                        <label class="btn" for="last_month_pay_slip<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                        <input id="last_month_pay_slip<?php echo $i; ?>" type="file" style="display:none;"  class="form-control fl-btn-n last_month_pay_slip" multiple >
                        <div id="last_month_pay_slip-img<?php echo $i; ?>"><?php
                           $last_month = '';
                           if (isset($last_month_pay_slip[$i])) {
                              if (!in_array('no-file', $last_month_pay_slip[$i])) {
                                 foreach ($last_month_pay_slip[$i] as $key => $value) {
                                    if ($value !='') {
                                       echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"last_month_pay_slip\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/last_month_pay_slip/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                    }
                                 }
                                 $last_month = $last_month_pay_slip[$i];
                              }
                           } ?>
                        </div>
                        <input type="hidden" class="last_month" value="<?php echo json_encode($last_month); ?>">
                     </div>
                     <div id="last_month_pay_slip-error<?php echo $i; ?>"></div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="pg-frm-hd">Bank Statement/ Resignation Acceptance <span>(optional)</span></div>
                  <div id="fls">
                     <div class="form-group files">
                        <label class="btn" for="bank_statement_resigngation_acceptance<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                        <input id="bank_statement_resigngation_acceptance<?php echo $i; ?>" type="file" style="display:none;" class="form-control fl-btn-n bank_statement_resigngation_acceptance"  multiple >
                        <?php $bank_statement ='';
                        if (isset($bank_statement_resigngation_acceptance[$i])) {
                           if (!in_array('no-file', $bank_statement_resigngation_acceptance[$i])) {
                              foreach ($bank_statement_resigngation_acceptance[$i] as $key => $value) { 
                                 if ($value !='') {
                                    echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"bank_statement_resigngation_acceptance\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/bank_statement_resigngation_acceptance/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                 }
                              }
                              $bank_statement = json_encode($bank_statement_resigngation_acceptance[$i]);
                           }
                        } ?>
                     </div>
                     <input type="hidden" class="bank_statement" value="<?php echo $bank_statement; ?>" name="">
                     <div id="bank_statement_resigngation_acceptance-img<?php echo $i; ?>">
                     <div id="bank_statement_resigngation_acceptance-error<?php echo $i; ?>">&nbsp;</div>
                  </div>
               </div>
               </div>
            </div>
         <?php $j++; } ?>
      </div>
      <div id="save-data-error-msg"></div>
      <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
   </div>
</div>

<div class="modal fade " id="myModal-show" role="dialog">
   <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
         </div>
         <div class="modal-body">
            <div id="view-img"></div>
         </div>
         <div class="modal-footer">
            <div class="header-mn text-center">
               <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade " id="myModal-remove" role="dialog">
   <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
         </div>
         <div class="modal-body">
            <div id="remove-caption"></div>
         </div>
         <div class="modal-footer">
            <div class="header-mn text-center" id="button-area">
               <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
            </div>
         </div>
      </div>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/previous-employment-2.js" ></script>