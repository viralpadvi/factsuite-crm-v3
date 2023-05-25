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
      <input class="fld" id="education_details_id" value="<?php echo isset($table['education_details']['education_details_id'])?$table['education_details']['education_details_id']:''; ?>" type="hidden">
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
         $months = $this->config->item('month_names');

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
               <div class="full-bx">
                  <label>Type of Qualification</label>
                  <input class="fld form-control type-of-degree" readonly value="<?php echo isset($type_of_degree[$i]['type_of_degree'])?$type_of_degree[$i]['type_of_degree']:$court['education_type_name']; ?>" id="type-of-degree-<?php echo $i; ?>" type="text">
                  <div id="type-of-degree-error-<?php echo $i; ?>"></div>
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
                  <div class="full-bx">
                     <label>Major <span>(Required)</span></label>
                     <input class="fld major" value="<?php echo isset($major[$i]['major'])?$major[$i]['major']:''; ?>" onblur="check_major(<?php echo $i; ?>)" onkeyup="check_major(<?php echo $i; ?>)" id="major-<?php echo $i; ?>" type="text" data-major_name="<?php echo $court['education_type_name'];?>"> 
                     <div id="major-error-<?php echo $i; ?>"></div>
                  </div>
               <?php } else { ?>
                  <input class="fld form-control major" value="-" id="major-<?php echo $i; ?>" type="hidden" data-major_name="10th">
               <?php } ?>

               <div class="full-bx">
                  <label><?php echo $board; ?> <span>(Required)</span></label>
                  <input class="fld university" value="<?php echo isset($university_board[$i]['university_board'])?$university_board[$i]['university_board']:''; ?>" onblur="check_university_name(<?php echo $i; ?>)" onkeyup="check_university_name(<?php echo $i; ?>)" id="university-<?php echo $i; ?>" type="text" data-board_or_university="<?php echo $board_or_university;?>">
                  <div id="university-error-<?php echo $i; ?>"></div>
               </div>

               <div class="full-bx">
                  <label><?php echo $school; ?> <span>(Required)</span></label>
                  <input class="fld college-name" value="<?php echo isset($college_school[$i]['college_school'])?$college_school[$i]['college_school']:''; ?>" onblur="check_college_name(<?php echo $i; ?>)" onkeyup="check_college_name(<?php echo $i; ?>)" id="college-name-<?php echo $i; ?>" type="text" data-school_or_college="<?php echo $school_or_college;?>">
                  <div id="college-name-error-<?php echo $i; ?>"></div>
               </div>

               <div class="full-bx">
                  <label>Address <span>(Required)</span></label>
                  <textarea class="fld address" onblur="check_address(<?php echo $i; ?>)" onkeyup="check_address(<?php echo $i; ?>)" id="address-<?php echo $i; ?>" type="text"><?php echo isset($address_of_college_school[$i]['address_of_college_school'])?$address_of_college_school[$i]['address_of_college_school']:''; ?></textarea>
                  <div id="address-error-<?php echo $i; ?>"></div>
               </div>

               <div class="full-bx">
                  <label>Duration of Course <span>(Required)</span></label>
                  <label>From</label>
                  <?php
                     $exploded_from_date = isset($course_start_date[$i]['course_start_date'])?explode('-',$course_start_date[$i]['course_start_date']):'';
                  ?>
                  <div class="row">
                     <div class="col-md-6 w-50">
                        <label>Month</label>
                        <select class="fld select2 duration-of-stay-from-month" id="duration-of-stay-from-month-<?php echo $i; ?>" onchange="check_duration_of_stay_from_month(<?php echo $i; ?>)">
                           <option selected value=''>Select Month</option>
                           <?php 
                           $num = 0;
                           for ($j = 1; $j <= $this->config->item('duration_of_stay_end_month'); $j++) {
                              $selected = '';
                              if ($exploded_from_date != '') {
                                 if ($exploded_from_date[1] == $j) {
                                    $selected = 'selected';
                                 }
                              }
                           ?>
                              <option <?php echo $selected;?> value="<?php echo $j;?>"><?php echo $months[$num];?></option>
                           <?php $num++; } ?>
                        </select> 
                        <div id="duration-of-stay-from-month-error-<?php echo $i; ?>"></div>
                     </div>
                     <div class="col-md-6 w-50">
                        <label>Year</label>
                        <select class="fld select2 duration-of-stay-from-year" id="duration-of-stay-from-year-<?php echo $i; ?>" onchange="check_duration_of_stay_from_year(<?php echo $i; ?>)">
                           <option selected value=''>Select year</option>
                           <?php 
                           for ($j = $this->config->item('duration_of_stay_start_year'); $j <= $this->config->item('current_year'); $j++) {
                              $selected = '';
                              if ($exploded_from_date[0] == $j) {
                                 $selected = 'selected';
                              }
                           ?>
                              <option <?php echo $selected;?> value="<?php echo $j;?>"><?php echo $j;?></option>
                           <?php } ?>
                        </select> 
                        <div id="duration-of-stay-from-year-error-<?php echo $i; ?>"></div>
                     </div>
                  </div>
               </div>

               <div class="full-bx">
                  <label>To</label>
                  <?php
                     $exploded_to_date = isset($course_end_date[$i]['course_end_date'])?explode('-',$course_end_date[$i]['course_end_date']):'';
                  ?>
                  <div class="row">
                     <div class="col-md-6 w-50">
                        <label>Month</label>
                        <select class="fld select2 duration-of-stay-to-month" id="duration-of-stay-to-month-<?php echo $i; ?>" onchange="check_duration_of_stay_to_month(<?php echo $i; ?>)">
                           <option selected value=''>Select Month</option>
                           <?php 
                           $num = 0;
                           for ($j = 1; $j <= $this->config->item('duration_of_stay_end_month'); $j++) {
                              $selected = '';
                              if ($exploded_to_date != '') {
                                 if ($exploded_to_date[1] == $j) {
                                    $selected = 'selected';
                                 }
                              }
                           ?>
                              <option <?php echo $selected;?> value="<?php echo $j;?>"><?php echo $months[$num];?></option>
                           <?php $num++; } ?>
                        </select> 
                        <div id="duration-of-stay-to-month-error-<?php echo $i; ?>"></div>
                     </div>
                      <div class="col-md-6 w-50">
                        <label>Year</label>
                        <select class="fld select2 duration-of-stay-to-year" id="duration-of-stay-to-year-<?php echo $i; ?>" onchange="check_duration_of_stay_to_year(<?php echo $i; ?>)">
                           <option selected value=''>Select year</option>
                           <?php for ($j = $this->config->item('duration_of_stay_start_year'); $j <= $this->config->item('current_year'); $j++) {
                              $selected = '';
                              if ($exploded_to_date[0] == $j) {
                                 $selected = 'selected';
                              }
                           ?>
                              <option <?php echo $selected;?> value="<?php echo $j;?>"><?php echo $j;?></option>
                           <?php } ?>
                        </select> 
                        <div id="duration-of-stay-to-year-error-<?php echo $i; ?>"></div>
                     </div>
                  </div>
               </div>

               <div class="full-bx">
                  <?php
                     $part_time ='';
                     $full_time ='';
                     $type_of_courses = isset($type_of_course[$i]['type_of_course'])?$type_of_course[$i]['type_of_course']:'';
                     if ($type_of_courses == 'part_time') {
                        $part_time ='checked';
                     } else if ($type_of_courses == 'full_time') {
                        $full_time ='checked';
                     } else{
                        $part_time ='checked';
                     }
                  ?>
                  <div class="row">
                     <div class="col-md-6 w-50">
                        <div class="custom-control custom-radio custom-control-inline mrg-btm">
                           <input type="radio" <?php echo $part_time; ?> class="custom-control-input part_time" value="part_time" name="customRadio<?php echo $i; ?>" id="customRadio1<?php echo $i; ?>">
                           <label class="custom-control-label pt-1" for="customRadio1<?php echo $i; ?>">Part Time</label>
                        </div>
                     </div>
                     <div class="col-md-6 w-50">
                        <div class="custom-control custom-radio custom-control-inline mrg-btm">
                           <input type="radio" <?php echo $full_time; ?> class="custom-control-input part_time" value="full_time" name="customRadio<?php echo $i; ?>" id="customRadio2<?php echo $i; ?>">
                           <label class="custom-control-label pt-1" for="customRadio2<?php echo $i; ?>">Full Time</label>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="full-bx">
                  <label>Registration / Roll Number <span>(Required)</span></label>
                  <input class="fld registration-roll-number" value="<?php echo isset($registration_roll_number[$i]['registration_roll_number'])?$registration_roll_number[$i]['registration_roll_number']:''; ?>" onblur="check_registration_roll_number(<?php echo $i; ?>)" onkeyup="check_registration_roll_number(<?php echo $i; ?>)" id="registration-roll-number-<?php echo $i; ?>" type="text">
                  <div id="registration-roll-number-error-<?php echo $i; ?>"></div>
               </div>
            </div>
            <?php if ($i < $highest_education - 1) { ?>
               <hr>
            <?php } ?>
         <?php } ?>
      <div id="save-data-error-msg"></div>
      <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/education-details-1.js" ></script>