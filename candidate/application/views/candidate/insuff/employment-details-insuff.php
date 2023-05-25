 
   <!--Page Content-->
   <!-- <form> -->
   <div class="pg-cnt pt-3">
      <div class="pg-txt-cntr">
         <div class="pg-steps">Step <?php echo array_search('6',array_values(explode(',', $component_ids)))+1 ?>/<?php echo count(explode(',', $component_ids))+1;?></div>
         <h6 class="full-nam2">Last Employment</h6>
         <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Desigination</label>
                  <input name="" class="fld form-control" value="<?php echo isset($table['current_employment']['desigination'])?$table['current_employment']['desigination']:''; ?>" id="designation" type="text">
                  <input name="" class="fld form-control" value="<?php echo isset($table['current_employment']['current_emp_id'])?$table['current_employment']['current_emp_id']:''; ?>" id="current_emp_id" type="hidden">
                  <div id="designation-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Department</label>
                  <input name="" class="fld form-control" value="<?php echo isset($table['current_employment']['department'])?$table['current_employment']['department']:''; ?>" id="department" type="text">
                   <div id="department-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Employee ID</label>
                  <input name="" class="fld form-control" value="<?php echo isset($table['current_employment']['employee_id'])?$table['current_employment']['employee_id']:''; ?>" id="employee_id" type="text">
                   <div id="employee_id-error">&nbsp;</div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Company Name</label>
                  <input name="" class="fld form-control" value="<?php echo isset($table['current_employment']['company_name'])?$table['current_employment']['company_name']:''; ?>" id="company-name" type="text">
                   <div id="company-name-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Company Website</label>
                  <input name="" class="fld form-control company_url" value="<?php echo isset($table['current_employment']['company_url'])?$table['current_employment']['company_url']:'';?>" id="company_url"  type="text">
                  <div id="company_url-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
                <div class="pg-frm">
                   <label>Address</label>
                   <textarea class="fld form-control" id="address" type="text"> <?php echo isset($table['current_employment']['address'])?$table['current_employment']['address']:''; ?></textarea>
                    <div id="address-error">&nbsp;</div>
                </div>
             </div>
         </div>
         <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Annual CTC</label>
                  <input name="" class="fld form-control" id="annual-ctc" value="<?php echo isset($table['current_employment']['annual_ctc'])?$table['current_employment']['annual_ctc']:''; ?>" type="number">
                   <div id="annual-ctc-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-8">
                <div class="pg-frm">
                   <label>Reason For Leaving</label>
                   <input name="" class="fld form-control" id="reasion"  value="<?php echo isset($table['current_employment']['reason_for_leaving'])?$table['current_employment']['reason_for_leaving']:''; ?>" type="text">
                    <div id="reasion-error">&nbsp;</div>
                </div>
             </div>
         </div>
         <div class="row">
             <div class="col-md-4">
                <div class="pg-frm-hd">Joining Date</div>
             </div>
             <div class="col-md-4">
                <div class="pg-frm-hd">Relieving Date</div>
             </div>
         </div>
         <div class="row">
            <div class="col-md-4"> 
                <input name="" class="fld form-control date-for-candidate-aggreement-start-date" id="joining-date" value="<?php echo isset($table['current_employment']['joining_date'])?$table['current_employment']['joining_date']:''; ?>" type="text"> 
                 <div id="joining-date-error">&nbsp;</div>
            </div> 
           <div class="col-md-4"> 
                <input name="" class="fld form-control date-for-candidate-aggreement-end-date" disabled id="relieving-date" value="<?php echo isset($table['current_employment']['relieving_date'])?$table['current_employment']['relieving_date']:''; ?>" type="text"> 
                 <div id="relieving-date-error">&nbsp;</div>
         </div>
         </div>
         <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Reporting Manager Name</label>
                  <input name="" class="fld form-control" id="reporting-manager-name" value="<?php echo isset($table['current_employment']['reporting_manager_name'])?$table['current_employment']['reporting_manager_name']:''; ?>" type="text">
                   <div id="reporting-manager-name-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>Reporting Manager Designation</label>
                  <input name="" class="fld form-control" id="reporting-manager-designation" value="<?php echo isset($table['current_employment']['reporting_manager_desigination'])?$table['current_employment']['reporting_manager_desigination']:''; ?>" type="text">
                   <div id="reporting-manager-designation-error">&nbsp;</div>
               </div>
            </div>
              <div class="col-md-2">
                <div class="pg-frm">
               <label>Code</label>
              <select class="fld form-control code" id="code">
                <?php
                $ccode = isset($table['current_employment']['code'])?$table['current_employment']['code']:'';
                foreach ($code['countries'] as $key => $value) {
                   if ($ccode==$value['code']) {
                    echo "<option selected >{$value['code']}</option>";
                  }else{ 
                  echo "<option>{$value['code']}</option>";
                  }
                }
                ?>
              </select>
            </div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>Reporting Manager Contact Number</label>
                  <input name="" class="fld form-control" id="reporting-manager-contact" value="<?php echo isset($table['current_employment']['reporting_manager_contact_number'])?$table['current_employment']['reporting_manager_contact_number']:''; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  type="text">
                   <div id="reporting-manager-contact-error">&nbsp;</div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>HR Contact Name</label>
                  <input name="" class="fld form-control" id="hr-name" value="<?php echo isset($table['current_employment']['hr_name'])?$table['current_employment']['hr_name']:''; ?>" type="text">
                   <div id="hr-name-error">&nbsp;</div>
               </div>
            </div>
              <div class="col-md-2">
                <div class="pg-frm">
               <label>Code</label>
              <select class="fld form-control hr-code" id="hr-code">
                <?php
                foreach ($code['countries'] as $key => $value) {
                  echo "<option>{$value['code']}</option>";
                }
                ?>
              </select>
            </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>HR Contact Number</label>
                  <input name="" class="fld form-control" id="hr-contact" value="<?php echo isset($table['current_employment']['hr_contact_number'])?$table['current_employment']['hr_contact_number']:''; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  type="text">
                   <div id="hr-contact-error">&nbsp;</div>
               </div>
            </div>
         </div>

                 <!-- <div><button id="add-row"><i class="fa fa-plus"></i></button></div> -->

         <div class="row mt-3">
            <div class="col-md-3">
               <div class="pg-frm-hd">Appointment Letter<span>(required)</span></div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm-hd">Experience/Relieving Letter<span>(required)</span></div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm-hd">Last 3 Month Pay Slip<span>(required)</span></div> 
            </div>
            <div class="col-md-3">
               <div class="pg-frm-hd">Bank Statement/ Resignation Acceptance <span>(optional)</span></div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file1"><a class="fl-btn">Browse files</a></label>
                     <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name1"><?php
                     $appointment_letter = '';
                       if (isset($table['current_employment'])) {
                       if (!in_array('no-file', explode(',', $table['current_employment']['appointment_letter']))) {
                         foreach (explode(',', $table['current_employment']['appointment_letter']) as $key => $value) {
                           if ($value !='') {
                           
                            echo "<div id='appointment_letter{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"appointment_letter\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_appointment_letter_documents{$key}' onclick='removeFile_documents({$key},\"appointment_letter\")' data-path='appointment_letter' data-field='appointment_letter' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";

                          }
                         }
                         $appointment_letter = $table['current_employment']['appointment_letter'];
                       }}
                       ?></div>
                       <input type="hidden" id="appointment_letter" value="<?php echo $appointment_letter; ?>">
                  </div>
               </div>
               <div id="experience_relieving_letter-error">&nbsp;</div>
            </div>
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file2"><a class="fl-btn">Browse files</a></label>
                     <input id="file2" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name2"><?php
                     $experience_relieving_letter = '';
                       if (isset($table['current_employment'])) {
                       if (!in_array('no-file', explode(',', $table['current_employment']['experience_relieving_letter']))) {
                         foreach (explode(',', $table['current_employment']['experience_relieving_letter']) as $key => $value) {
                           if ($value !='') {
                           
                            echo "<div id='experience_relieving_letter{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"experience_relieving_letter\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_experience_relieving_letter_documents{$key}' onclick='removeFile_documents({$key},\"experience_relieving_letter\")' data-path='experience_relieving_letter' data-field='experience_relieving_letter' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";
                          }
                         }
                         $experience_relieving_letter = $table['current_employment']['experience_relieving_letter'];
                       }}
                       ?></div>
                       <input type="hidden" id="experience_relieving_letter" value="<?php echo $experience_relieving_letter; ?>">
                  </div>
               </div>
               <div id="pan-error">&nbsp;</div>
            </div>
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file3"><a class="fl-btn">Browse files</a></label>
                     <input id="file3" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name3"><?php
                     $last_month_pay_slip = '';
                       if (isset($table['current_employment'])) {
                       if (!in_array('no-file', explode(',', $table['current_employment']['last_month_pay_slip']))) {
                         foreach (explode(',', $table['current_employment']['last_month_pay_slip']) as $key => $value) {
                           if ($value !='') {
                           
                            echo "<div id='last_month_pay_slip{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"last_month_pay_slip\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_last_month_pay_slip_documents{$key}' onclick='removeFile_documents({$key},\"last_month_pay_slip\")' data-path='last_month_pay_slip' data-field='last_month_pay_slip' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";
                          }
                         }
                         $last_month_pay_slip = $table['current_employment']['last_month_pay_slip'];
                       }}
                       ?></div>
                       <input type="hidden" id="last_month_pay_slip" value="<?php echo $last_month_pay_slip; ?>">
                  </div>
               </div>
               <div id="proof-error">&nbsp;</div>
            </div>
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file4"><a class="fl-btn">Browse files</a></label>
                     <input id="file4" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name4"><?php
                     $bank_statement_resigngation_acceptance = '';
                       if (isset($table['current_employment'])) {
                       if (!in_array('no-file', explode(',', $table['current_employment']['bank_statement_resigngation_acceptance']))) {
                         foreach (explode(',', $table['current_employment']['bank_statement_resigngation_acceptance']) as $key => $value) {
                           if ($value !='') { 
                              echo "<div id='bank_statement_resigngation_acceptance{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"bank_statement_resigngation_acceptance\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_bank_statement_resigngation_acceptance_documents{$key}' onclick='removeFile_documents({$key},\"bank_statement_resigngation_acceptance\")' data-path='bank_statement_resigngation_acceptance' data-field='bank_statement_resigngation_acceptance' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";
                          }
                         }
                         $bank_statement_resigngation_acceptance = $table['current_employment']['bank_statement_resigngation_acceptance'];
                       }}
                       ?></div>
                  </div>
               </div>
               <div id="bank-error">&nbsp;</div>
            </div>
         </div>

         <div class="row">
          <div class="col-md-12" id="warning-msg">&nbsp;</div>
            <div class="col-md-12">
               <div class="pg-submit">
                  <button id="add_employments" class="pg-submit-btn">Save &amp; Continue</button>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- </form> -->
   <!--Page Content-->
   <div class="clr"></div>
</section>


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



<div class="modal fade " id="myModal-remove" role="dialog">
    <div class="modal-dialog modal-md">
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



<script src="<?php echo base_url(); ?>assets/custom-js/candidate/insuff/candidate-employment-insuff.js" ></script>
