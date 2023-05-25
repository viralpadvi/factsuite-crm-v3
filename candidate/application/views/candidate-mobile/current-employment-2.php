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
            <label>Appointment Letter</label>
            <div id="fls">
               <div class="form-group files">
                  <label class="btn" for="file1"><a class="fl-btn">Browse files</a></label>
                  <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                  <div class="file-name1">
                     <?php $appointment_letter = '';
                     if (isset($table['current_employment'])) {
                        if (!in_array('no-file', explode(',', $table['current_employment']['appointment_letter']))) {
                           foreach (explode(',', $table['current_employment']['appointment_letter']) as $key => $value) {
                              if ($value !='') {
                                 echo "<div id='appointment_letter{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"appointment_letter\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_appointment_letter_documents{$key}' onclick='removeFile_documents({$key},\"appointment_letter\")' data-path='appointment_letter' data-field='appointment_letter' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a>  <a href='".base_url()."../uploads/appointment_letter/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                              }
                           }
                           $appointment_letter = $table['current_employment']['appointment_letter'];
                        }
                     } ?>
                  </div>
                  <input type="hidden" id="appointment_letter" value="<?php echo $appointment_letter; ?>">
               </div>
            </div>
            <div id="experience_relieving_letter-error"></div>
         </div>

         <div class="full-bx">
            <label>Experience/Relieving Letter</label>
            <div id="fls">
               <div class="form-group files">
                  <label class="btn" for="file2"><a class="fl-btn">Browse files</a></label>
                  <input id="file2" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                  <div class="file-name2">
                     <?php $experience_relieving_letter = '';
                     if (isset($table['current_employment'])) {
                        if (!in_array('no-file', explode(',', $table['current_employment']['experience_relieving_letter']))) {
                           foreach (explode(',', $table['current_employment']['experience_relieving_letter']) as $key => $value) {
                              if ($value !='') {
                                 echo "<div id='experience_relieving_letter{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"experience_relieving_letter\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_experience_relieving_letter_documents{$key}' onclick='removeFile_documents({$key},\"experience_relieving_letter\")' data-path='experience_relieving_letter' data-field='experience_relieving_letter' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> <a href='".base_url()."../uploads/experience_relieving_letter/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                              }
                           }
                           $experience_relieving_letter = $table['current_employment']['experience_relieving_letter'];
                        }
                     }?>
                  </div>
                  <input type="hidden" id="experience_relieving_letter" value="<?php echo $experience_relieving_letter; ?>">
               </div>
            </div>
            <div id="pan-error"></div>
         </div>

         <div class="full-bx">
            <label>Last 3 Month Pay Slip</label>
            <div id="fls">
               <div class="form-group files">
                  <label class="btn" for="file3"><a class="fl-btn">Browse files</a></label>
                  <input id="file3" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                  <div class="file-name3">
                     <?php $last_month_pay_slip = '';
                     if (isset($table['current_employment'])) {
                        if (!in_array('no-file', explode(',', $table['current_employment']['last_month_pay_slip']))) {
                           foreach (explode(',', $table['current_employment']['last_month_pay_slip']) as $key => $value) {
                              if ($value !='') {
                                 echo "<div id='last_month_pay_slip{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"last_month_pay_slip\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_last_month_pay_slip_documents{$key}' onclick='removeFile_documents({$key},\"last_month_pay_slip\")' data-path='last_month_pay_slip' data-field='last_month_pay_slip' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> <a href='".base_url()."../uploads/last_month_pay_slip/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                              }
                           }
                           $last_month_pay_slip = $table['current_employment']['last_month_pay_slip'];
                        }
                     } ?>
                  </div>
                  <input type="hidden" id="last_month_pay_slip" value="<?php echo $last_month_pay_slip; ?>">
               </div>
            </div>
            <div id="proof-error"></div>
         </div>

         <div class="full-bx">
            <label>Bank Statement/ Resignation Acceptance</label>
            <div id="fls">
               <div class="form-group files">
                  <label class="btn" for="file4"><a class="fl-btn">Browse files</a></label>
                  <input id="file4" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                  <div class="file-name4">
                     <?php $bank_statement_resigngation_acceptance = '';
                     if (isset($table['current_employment'])) {
                        if (!in_array('no-file', explode(',', $table['current_employment']['bank_statement_resigngation_acceptance']))) {
                           foreach (explode(',', $table['current_employment']['bank_statement_resigngation_acceptance']) as $key => $value) {
                              if ($value !='') { 
                                 echo "<div id='bank_statement_resigngation_acceptance{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"bank_statement_resigngation_acceptance\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_bank_statement_resigngation_acceptance_documents{$key}' onclick='removeFile_documents({$key},\"bank_statement_resigngation_acceptance\")' data-path='bank_statement_resigngation_acceptance' data-field='bank_statement_resigngation_acceptance' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> <a href='".base_url()."../uploads/bank_statement_resigngation_acceptance/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                              }
                           }
                           $bank_statement_resigngation_acceptance = $table['current_employment']['bank_statement_resigngation_acceptance'];
                        }
                     } ?>
                  </div>
               </div>
            </div>
            <div id="bank-error"></div>
         </div>

      </div>
      <div id="save-data-error-msg"></div>
      <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
   </div>
</div>

<div class="modal fade " id="myModal-show" role="dialog">
   <div class="modal-dialog modal-md">
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

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/current-employment-2.js" ></script>