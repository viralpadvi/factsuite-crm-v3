<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-information';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Personal Information</div>
         <div class="pg-rgt">Step 1/6</div>
         <div class="clr"></div>
      </div>
      <div class="pg-frm">
         <h3>Full Name</h3>
         <div class="full-bx">
            <div class="float-left wdt-27">
               <label>Title</label>
               <?php 
                  $miss ='';
                  $mrs ='';
                  $mr ='';
                  if ($user['title']=='Miss') {
                    $miss ='selected';
                  } else if ($user['title']=='Mrs') {
                    $mrs ='selected';
                  } else {
                    $mr ='selected';
                  }
               ?>
               <select class="fld" id="title">
                  <option <?php echo $mr; ?>>Mr</option>  
                  <option <?php echo $mrs; ?>>Mrs</option>
                  <option <?php echo $miss; ?>>Miss</option>
               </select>
               <div id="title-error"></div>
            </div>
            <div class="float-right wdt-70">
               <label>First Name <span>(Required)</span></label>
               <input name="first-name" class="fld" value="<?php echo isset($user['first_name'])?$user['first_name']:''; ?>" id="first-name" type="text">
               <div id="first-name-error"></div>
            </div>
            <div class="clr"></div>
         </div>
         <div class="full-bx">
            <label>Last Name <span>(Required)</span></label>
            <input name="last-name" class="fld" value="<?php echo isset($user['last_name'])?$user['last_name']:''; ?>" id="last-name" type="text">
            <div id="last-name-error"></div>
         </div>
         <div class="full-bx">
            <label>Fathers Name <span>(Required)</span></label>
            <input name="father-name" class="fld" value="<?php echo isset($user['father_name'])?$user['father_name']:''; ?>" id="father-name" type="text">
            <div id="father-name-error"></div>
         </div>
         <div class="full-bx">
            <label>Email ID <span>(Required)</span></label>
            <input name="email-id" class="fld" value="<?php echo isset($user['email_id'])?$user['email_id']:''; ?>" id="email-id" type="text">
            <div id="email-id-error"></div>
         </div>
         <h3>Date of Birth</h3>
         <div class="full-bx">
            <input name="date-of-birth" class="fld mdate" value="<?php echo isset($user['date_of_birth'])?$user['date_of_birth']:''; ?>" id="date-of-birth" type="text">
            <div id="date-of-birth-error"></div>
         </div>
         <div class="full-bx">
            <label>Nationality</label>
            <select class="fld" id="nationality">
               <option value="">Select Nationality</option>
               <?php
               $c_id = '';
               foreach ($country as $key => $value) {
                  if ($user['nationality'] == $value['name'] ) {
                     $c_id = $value['id'];
                     echo "<option selected data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                  } else {
                     if ($value['name'] =='India') {
                        $c_id = $value['id'];
                        echo "<option selected data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                     }
                  }
               } ?>
            </select>
            <div id="nationality-error"></div>
         </div>
         <div class="full-bx">
            <label>House/Flat No.</label>
            <input class="fld" value="<?php echo isset($user['candidate_flat_no'])?$user['candidate_flat_no']:''; ?>" id="house-flat" type="text"> 
            <div id="house-flat-error"></div>
         </div>
         <div class="full-bx">
            <label>Street/Road</label>
            <input class="fld form-control" value="<?php echo isset($user['candidate_street'])?$user['candidate_street']:''; ?>" id="street" type="text">
            <div id="street-error"></div>
         </div>
         <div class="full-bx">
            <label>Area</label>
            <input class="fld form-control" value="<?php echo isset($user['candidate_area'])?$user['candidate_area']:''; ?>" id="area" type="text">
            <div id="area-error"></div>
         </div>
         <div class="full-bx">
            <label>State</label>
            <?php if ($c_id !='') {
               $state = $this->candidateModel->get_all_states($c_id);  
            }
            $city_id =''; ?>
            <select class="fld form-control state select2" id="state" >
               <option selected value=''>Select State</option>
               <?php $get = isset($user['candidate_state'])?$user['candidate_state']:'';
               $get_state = isset($user['candidate_state'])?$user['candidate_state']:'Karnataka';
               foreach ($state as $key1 => $val) {
                  if ($get == $val['name']) {
                     $city_id = $val['id'];
                     echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                  } else {
                     if ($get_state == $val['name']) {
                        $city_id = $val['id'];
                     }
                     echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                  }
               } ?>
            </select> 
            <div id="state-error"></div>
         </div>
         <div class="full-bx">
            <label>City/Town</label>
            <select class="fld form-control city select2" id="city" >
               <option selected value=''>Select City/Town</option>
               <?php $get_city = isset($user['candidate_city'])?$user['candidate_city']:''; 
               $cities = $this->candidateModel->get_all_cities($city_id);
               foreach ($cities as $key2 => $val) {
                  if ($get_city == $val['name']) { 
                     echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                  } else {
                     echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                  }
               } ?>
            </select>         
            <div id="city-error"></div>
         </div>
         <div class="full-bx">
            <label>Pin Code</label>
            <input class="fld form-control" id="pincode" value="<?php echo isset($user['candidate_pincode'])?$user['candidate_pincode']:''; ?>" type="text">
            <div id="pincode-error"></div>
         </div>
         <?php
            $male = '';
            $female = '';
            $single = '';
            $married = '';

            if (isset($user['gender'])) {
               if ($user['gender'] != 'male') {
                  $female = 'checked';
               } else {
                  $male = 'checked';
               }
            }

            if(isset($user['marital_status'])) {
               if ($user['marital_status']=='married') {
                  $married = 'checked';
               } else {
                  $single = 'checked';
               } 
            }
         ?>
         <div class="full-bx">
            <div class="float-left wdt-45">
               <div class="pg-frm-hd">Gender</div>
               <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn male active">
                     <input type="radio" <?php echo $male; ?> class="gender1" name="gender" id="male" value="male" autocomplete="off" > Male
                  </label>
                  <label class="btn female">
                     <input type="radio" <?php echo $female; ?> class="gender1" name="gender" id="female" value="female" autocomplete="off"> Female
                  </label>
               </div>
               <div id="gender-error"></div>
            </div>
            <div class="float-right wdt-45">
               <div class="pg-frm-hd">Marital Status</div>
               <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn single active">
                     <input type="radio" <?php echo $single; ?> name="marital-status" class="marital" id="single" value="single" autocomplete="off" > Single
                  </label>
                  <label class="btn married">
                     <input type="radio" <?php echo $married; ?> name="marital-status" class="marital" id="married" value="married" autocomplete="off"> Married
                  </label>
               </div>
               <div id="marital-error"></div>
            </div>
            <div class="clr"></div>
         </div>
         <div class="full-bx">
            <div class="pg-frm-hd">Preferred Contact Time & Days</div>

            <?php 

               $srt = explode(':', isset($user['contact_start_time'])?$user['contact_start_time']:'');
               $end = explode(':', isset($user['contact_end_time'])?$user['contact_end_time']:''); 

                ?>
               <div class="row">
                  <div class="col-md-6">
                     <label>Start Date</label>
                  </div> 
                  <div class="col-md-1">
                     <select id="start-hour" class="fld">
                        <?php 
                           for ($h=0; $h <= 12; $h++) { 
                              $a = $h;
                              if ($h < 10) {
                                 $a = '0'.$h;
                              }
                              $select = '';
                              if ($a ==$srt[0]) {
                                $select = 'selected';
                              }
                              echo "<option ".$select." value='".$a."'>".$a."</option>";
                           }
                        ?>
                     </select>
                  </div>
                  <div class="col-md-1">
                     <select id="start-minute" class="fld">
                        <?php 
                           for ($h=0; $h <= 60; $h++) { 
                              $a = $h;
                              if ($h < 10) {
                                 $a = '0'.$h;
                              }
                              $select = '';
                              if ($a ==$srt[1]) {
                                $select = 'selected';
                              }
                              echo "<option ".$select." value='".$a."'>".$a."</option>";
                           }
                        ?>
                     </select>
                  </div>
                  <div class="col-md-1">
                     <select id="start-type" class="fld">
                        <?php 
                          echo "<option selected value='".$srt[2]."'>".$srt[2]."</option>"; 
                        ?>
                        <option>AM</option>
                        <option>PM</option>
                     </select>
                  </div>
                  <div class="col-md-6">
                      <label>End Date</label>
                  </div>
                  <div class="col-md-1">
                     <select id="end-hour" class="fld">
                        <?php 
                           for ($h=0; $h <= 12; $h++) { 
                              $a = $h;
                              if ($h < 10) {
                                 $a = '0'.$h;
                              }
                              $select = '';
                              if ($a ==$end[0]) {
                                $select = 'selected';
                              }
                              echo "<option ".$select." value='".$a."'>".$a."</option>";
                           }
                        ?>
                     </select>
                  </div>
                  <div class="col-md-1">
                     <select id="end-minute" class="fld">
                        <?php 
                           for ($h=0; $h <= 60; $h++) { 
                              $a = $h;
                              if ($h < 10) {
                                 $a = '0'.$h;
                              }
                              $select = '';
                              if ($a ==$end[1]) {
                                $select = 'selected';
                              }
                              echo "<option ".$select." value='".$a."'>".$a."</option>";
                           }
                        ?>
                     </select>
                 
                     <select id="end-type" class="fld">
                        <?php 
                          echo "<option selected value='".$end[2]."'>".$end[2]."</option>"; 
                        ?>
                        <option>AM</option>
                        <option>PM</option>
                     </select>
                  </div>
               </div>
            <!-- <div class="float-left wdt-45">
               <input type="text" class="form-control fld" id="timepicker" disabled placeholder="Start time" value="<?php echo isset($user['contact_start_time'])?$user['contact_start_time']:''; ?>" name="pwd" >
               <div id="timepicker-error"></div>
            </div>
            <div class="float-left wdt-10">
               <div class="cntr-txt">To</div>
            </div>
            <div class="float-right wdt-45">
               <input type="text" class="form-control fld" id="timepicker2" disabled placeholder="End time" value="<?php echo isset($user['contact_start_time'])?$user['contact_start_time']:''; ?>" name="pwd" >
               <div id="timepicker2-error"></div>
            </div> -->
            <div class="clr"></div>
         </div>
         <div class="full-bx">
            <?php 
               $week = isset($user['week'])?$user['week']:'';
               $days = array(
                  'Sunday',
                  'Monday',
                  'Tuesday',
                  'Wednesday',
                  'Thursday',
                  'Friday',
                  'Saturday'
               );
               foreach ($days as $key => $value) {
                  $selected = '';
                  if (in_array($value,explode(',', $week))) { 
                     $selected = 'checked';
                  } ?>
                  <div class="custom-control custom-checkbox custom-control-inline">
                     <input <?php echo $selected; ?> type="checkbox" class="custom-control-input weeks" value="<?php echo $value; ?>" name="customCheck" id="customCheck<?php echo $key; ?>">
                     <label class="custom-control-label" for="customCheck<?php echo $key; ?>"><?php echo $value; ?></label>
                  </div>
            <?php } ?>
         </div>
      </div>
      <div id="save-data-error-msg"></div>
      <button class="pg-nxt-btn" id="save-details-btn">Save &amp; Continue</button>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/candidate-information-1.js"></script>