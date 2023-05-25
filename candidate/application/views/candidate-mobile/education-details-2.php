<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-education';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Education Details</div>
         <div class="pg-rgt">Step <?php echo array_search('7',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
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

         if (isset($table['education_details']['type_of_degree'])) {
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
         for ($i = 0; $i < $highest_education; $i++) {
            $court ='';
            if (isset($form_values['highest_education'][$i])?$form_values['highest_education'][$i]:'' !='') {               
               $court = $this->candidateModel->education_type($form_values['highest_education'][$i]);
            } else if (isset($form_values['education'][0])?$form_values['education'][0]:0 > 0) {
               $court = $this->candidateModel->education_type($form_values['education'][$i]);
            }
            array_push($edu, $court['education_type_name']);
         ?>
            <div class="pg-frm">
               <div class="pg-txt">
                  <div class="pg-lft"><?php echo isset($court['education_type_name'])?$court['education_type_name']:''; ?> Details</div>
                  <div class="clr"></div>
               </div>
               <?php if(in_array(strtolower($court['education_type_name']),$this->config->item('10_12_course_completion_certificate_list'))) {
                  $upload_type_name = 'Certificate / Course Completion Certificate ';
                  if ($court['education_type_name'] == '10th') {
                     $upload_type_name = '10th Certificate/ Marksheet';
                  }

                  if ($court['education_type_name'] == '12th') {
                     $upload_type_name = '12th Certificate/ Marksheet';
                  }
               ?>
                  <div class="full-bx">
                     <label><?php echo $upload_type_name;?> <span>(Required)</span></label>
                     <div id="fls">
                        <div class="form-group files">
                           <label class="btn" for="ten_twelve_mark_card_certificate<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                           <input id="ten_twelve_mark_card_certificate<?php echo $i; ?>" type="file" style="display:none;" class="form-control fl-btn-n ten_twelve_mark_card_certificate" multiple >
                           <div id="ten_twelve_mark_card_certificate-img<?php echo $i; ?>"><?php
                              if (isset($ten_twelve_mark_card_certificate[$i])) {
                                 if (!in_array('no-file', $ten_twelve_mark_card_certificate[$i])) {
                                    foreach ($ten_twelve_mark_card_certificate[$i] as $key => $value) {
                                       if ($value !='') {
                                          echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"ten-twelve-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/ten-twelve-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                       }
                                    }
                                 }
                              } ?>
                           </div>
                        </div>
                        <div id="ten_twelve_mark_card_certificate-error<?php echo $i; ?>"></div>
                        <input id="pre-added-ten-twelve-mark-card-certificate-<?php echo $i; ?>" type="hidden" class="pre-added-ten-twelve-mark-card-certificate" value="<?php print_r(isset($ten_twelve_mark_card_certificate[$i]) ? $ten_twelve_mark_card_certificate[$i] : '');?>">
                     </div>
                  </div>
               <?php } ?>

               <?php if (in_array(strtolower($court['education_type_name']),$this->config->item('all_sem_marksheet_list'))) { ?>
                  <div class="full-bx">
                     <label>All Sem Marksheet / Consolidate Marksheet <span>(Required)</span></label>
                     <div id="fls">
                        <div class="form-group files">
                           <label class="btn" for="all_sem_marksheet<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                           <input id="all_sem_marksheet<?php echo $i; ?>" type="file" style="display:none;" class="form-control fl-btn-n all_sem_marksheet" multiple >
                           <div id="all_sem_marksheet-img<?php echo $i; ?>">
                           <?php if (isset($all_sem_marksheet[$i])) {
                              if (!in_array('no-file',$all_sem_marksheet[$i])) {
                                 foreach ($all_sem_marksheet[$i] as $key => $value) {
                                    if ($value !='') {
                                       echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"all-marksheet-docs\")' >  <i class='fa fa-eye'></i></a>  <a href='".base_url()."../uploads/all-marksheet-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                    }
                                 }
                              }
                           } ?>
                        </div>
                        <input type="hidden" id="all_sem_marksheet" value="<?php echo ''; ?>">
                        <input type="hidden" id="pre-uploaded-all-sem-marksheet-<?php echo $i; ?>" value="<?php print_r(isset($all_sem_marksheet[$i]) ? $all_sem_marksheet[$i] : ''); ?>">
                     </div>
                     <div id="all_sem_marksheet-error<?php echo $i; ?>"></div>
                  </div>
               <?php } ?>

               <?php if (in_array(strtolower($court['education_type_name']),$this->config->item('professional_degree_or_degree_convocation_certificate_list'))) { ?>
                  <div class="full-bx">
                     <label>Provisional Degree Certificate / Degree Convocation <span>(Required)</span></label>
                     <div id="fls">
                        <div class="form-group files">
                           <label class="btn" for="convocation<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                           <input id="convocation<?php echo $i; ?>"  type="file" style="display:none;" class="form-control fl-btn-n convocation" multiple >
                           <div id="convocation-img<?php echo $i; ?>"><?php
                              if (isset($convocation[$i])) {
                                 if (!in_array('no-file', $convocation[$i])) {
                                    foreach ($convocation[$i] as $key => $value) {
                                       if ($value !='') {
                                          echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"convocation-docs\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/convocation-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                       }
                                    }
                                 }
                              } ?>
                           </div>
                           <input type="hidden" id="convocation" value="<?php echo ''; ?>">
                           <input type="hidden" id="pre-uploaded-convocation-<?php echo $i; ?>" value="<?php print_r(isset($convocation[$i]) ? $convocation[$i] : ''); ?>">
                        </div>
                        <div id="convocation-error<?php echo $i; ?>"></div>
                     </div>
                  </div>
               <?php } ?>

               <?php if (in_array(strtolower($court['education_type_name']),$this->config->item('transcript_of_records_list'))) { ?>
                  <div class="full-bx">
                     <label>Transcript of Records <span>(Optional)</span></label>
                     <div id="fls">
                        <div class="form-group files">
                           <label class="btn" for="marksheet_provisional_certificate<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                           <input id="marksheet_provisional_certificate<?php echo $i; ?>"  type="file" style="display:none;" class="form-control fl-btn-n marksheet_provisional_certificate" multiple >
                           <div id="marksheet_provisional_certificate-img<?php echo $i; ?>"><?php
                              if (isset($marksheet_provisional_certificate[$i])) {
                                 if (!in_array('no-file', $marksheet_provisional_certificate[$i])) {
                                    foreach ($marksheet_provisional_certificate[$i] as $key => $value) {
                                       if ($value !='') {
                                          echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"marksheet-certi-docs\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/rental-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                                       }
                                    }
                                 }
                              } ?>
                           </div>
                           <input type="hidden" id="marksheet_provisional_certificate" value="<?php echo ''; ?>">
                           <input type="hidden" id="pre-uploaded-marksheet-provisional-certificate-<?php echo $i; ?>" value="<?php print_r(isset($marksheet_provisional_certificate[$i]) ? $marksheet_provisional_certificate[$i] : ''); ?>">
                        </div>
                        <div id="marksheet_provisional_certificate-error<?php echo $i; ?>"></div>
                     </div>
                  </div>
               <?php } ?>
            </div>
            <?php if ($i < $highest_education - 1) { ?>
               <hr>
            <?php } ?>
         <?php } ?>
      <div id="save-data-error-msg"></div>
      <div class="text-center">
         <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
      </div>
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

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/education-details-2.js" ></script>