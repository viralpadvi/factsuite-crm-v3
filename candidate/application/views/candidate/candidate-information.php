<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-candidate-information-step-1';
   }
</script>

   <div class="pg-cnt pt-4">
      <div class="pg-txt-cntr">
         <div class="pg-steps">Step 1/ <?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="pg-frm-hd-1">Full Name</div>
         <div class="row">
            <div class="col-md-1">
               <div class="pg-frm">
                  <label>Title</label>
                  <?php 
                  $miss ='';
                  $mrs ='';
                  $mr ='';
                  if ($user['title']=='Miss') {
                    $miss ='selected';
                  }else if ($user['title']=='Mrs') {
                    $mrs ='selected';
                  }else{
                    $mr ='selected';
                  }
                  ?>
                  <select class="fld" id="title">
                     <option <?php echo $mr; ?>>Mr</option>  
                     <option <?php echo $mrs; ?>>Mrs</option>
                     <option <?php echo $miss; ?>>Miss</option>
                  </select>
               </div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>First Name<span> (Required)</span></label>
                  <input name="first-name" class="fld form-control" value="<?php echo isset($user['first_name'])?$user['first_name']:''; ?>" id="first-name" type="text">
                  <div id="first-name-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>Last Name<span> (Required)</span></label>
                  <input name="last-name" class="fld form-control" value="<?php echo isset($user['last_name'])?$user['last_name']:''; ?>" id="last-name" type="text">
                  <div id="last-name-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>Father's Name<span> (Required)</span></label>
                  <input name="father-name" class="fld form-control" value="<?php echo isset($user['father_name'])?$user['father_name']:''; ?>" id="father-name" type="text">
                  <div id="father-name-error">&nbsp;</div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>Email ID</label>
                  <input name="email-id" class="fld form-control" value="<?php echo isset($user['email_id'])?$user['email_id']:''; ?>" id="email-id" type="text">
                  <div id="email-id-error">&nbsp;</div>
               </div>
            </div>
            <?php if ($user['email_id_validated_by_candidate_status'] == 0) { ?>
               <div class="col-md-1 d-none" id="validate-email-id-otp-input-div">
                  <div class="pg-frm">
                     <label>OTP</label>
                     <input name="email-id-otp" class="fld form-control" id="email-id-otp" type="text">
                     <div id="email-id-otp-error">&nbsp;</div>
                  </div>
               </div>
               <div class="col-md-3" id="validate-email-id-otp-btn-div">
                  <div class="pg-frm">
                     <label>&nbsp;</label>
                     <button id="send-otp-email-id-btn" class="pg-submit-btn">Validate Email ID</button>
                     <button id="validate-email-id-btn" class="pg-submit-btn d-none">Submit</button>
                  </div>
               </div>
            <?php } ?>
            <div class="col-md-3">
               <div class="pg-frm">
             <label >Date of Birth</label>
               <input name="date-of-birth" class="fld form-control mdate" value="<?php echo isset($user['date_of_birth'])?$user['date_of_birth']:''; ?>" id="date-of-birth" type="text">
               <div id="date-of-birth-error">&nbsp;</div>
            </div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>House/Flat No.</label>
                  <input name="" class="fld form-control" value="<?php echo isset($user['candidate_flat_no'])?$user['candidate_flat_no']:''; ?>" id="house-flat" type="text"> 
                  <div id="house-flat-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>Street/Road</label>
                  <input name="" class="fld form-control" value="<?php echo isset($user['candidate_street'])?$user['candidate_street']:''; ?>" id="street" type="text">
                  <div id="street-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>Area</label>
                  <input name="" class="fld form-control" value="<?php echo isset($user['candidate_area'])?$user['candidate_area']:''; ?>" id="area" type="text">
                  <div id="area-error">&nbsp;</div>
               </div>
            </div>            
            <div class="col-md-3">
               <div class="pg-frm">
               <label >Nationality</label>
               <!-- <div class="pg-frm"> -->
                  <select class="fld form-control" id="nationality" >
                     <option value="">Select Nationality</option>
                     <?php
                        $c_id = '';
                      foreach ($country as $key => $value) {
                        if ($user['nationality'] == $value['name'] ) {
                           $c_id = $value['id'];
                          echo "<option selected data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                        }else{
                          if ($value['name'] =='India') {
                           $c_id = $value['id'];
                            echo "<option selected data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                          }
                          // echo "<option data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                        }
                      }
                     ?>
                  </select>
                  <div id="nationality-error">&nbsp;</div>
               </div> 
            </div>
               <div class="col-md-3">
               <div class="pg-frm">
                   <label>State</label>
                   <?php
                   if ($c_id !='') {
                        $state = $this->candidateModel->get_all_states($c_id);  
                      }
                      $city_id ='';
                   ?>
                   <select class="fld form-control state select2" onchange="valid_state()" id="state" >
                     <option selected value=''>Select State</option>
                      <?php 
                      $get = isset($user['candidate_state'])?$user['candidate_state']:'';
                      $get_state = isset($user['candidate_state'])?$user['candidate_state']:'Karnataka';
                      foreach ($state as $key1 => $val) {
                         if ($get == $val['name']) {
                          $city_id = $val['id'];
                            echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         }else{
                           if ($get_state == $val['name']) {
                           $city_id = $val['id'];
                           }
                            echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         }
                      }
                         
                       ?>
                   </select> 
                    <div id="state-error"></div>
                </div>
             </div>
              <div class="col-md-3">
                <div class="pg-frm">
                   <label>City/Town</label>
                   <!-- <input name="" class="fld form-control city" value="<?php echo isset($city[$i]['city'])?$city[$i]['city']:''; ?>"  onkeyup="valid_city()" id="city" type="text"> -->
                    <select class="fld form-control city select2" id="city" >
                     <option selected value=''>Select City/Town</option>
                     <?php 
                      $get_city = isset($user['candidate_city'])?$user['candidate_city']:''; 
                      $cities = $this->candidateModel->get_all_cities($city_id);
                      foreach ($cities as $key2 => $val) {
                         if ($get_city == $val['name']) { 
                            echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         }else{
                            echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         }
                      }
                         
                       ?>
                   </select> 
                    
                   <div id="city-error">&nbsp;</div>
                </div>
             </div>
              <div class="col-md-3">
               <div class="pg-frm">
                  <label>Pin Code</label>
                  <input name="" class="fld form-control" id="pincode" value="<?php echo isset($user['candidate_pincode'])?$user['candidate_pincode']:''; ?>" type="text">
                  <div id="pincode-error">&nbsp;</div>
               </div>
            </div>
             <div class="col-md-4 d-none">
               <div class="pg-frm"> 
                  <label>Permanent Address</label>
                  <textarea class="fld form-control address" placeholder="enter valid address" onkeyup="valid_address()" rows="4" id="address"><?php echo isset($user['candidate_address'])?$user['candidate_address']:''; ?></textarea> 
                   <div id="address-error">&nbsp;</div> 
               </div>
            </div>
         </div>

         <div class="row d-none">
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>Latest Employment Company name </label>
                  <input name="employee-company" class="fld form-control" value="<?php echo isset($user['employee_company'])?$user['employee_company']:''; ?>" id="employee-company" type="text">
                  <div id="employee-company-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>Highest Education College</label>
                  <input name="education" class="fld form-control" value="<?php echo isset($user['education'])?$user['education']:''; ?>" id="education" type="text">
                  <div id="education-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>University name</label>
                  <input name="university" class="fld form-control" value="<?php echo isset($user['university'])?$user['university']:''; ?>" id="university" type="text">
                  <div id="university-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
                  <label> Social media handles if any</label>
                  <input name="social_media" class="fld form-control" value="<?php echo isset($user['social_media'])?$user['social_media']:''; ?>" id="social_media" type="text">
                  <div id="social_media-error">&nbsp;</div>
               </div>
            </div>
         </div>
         <?php
         $male = '';
         $female = '';
         $single = '';
         $married = '';
         // echo isset($user['gender'])?$user['gender']:'';
         if (isset($user['gender'])) {
             if ($user['gender'] != 'male') {
             $female = 'checked';

             }else{
              $male = 'checked';
             }
         }

         if(isset($user['marital_status'])){
            if ($user['marital_status']=='married') {
               $married = 'checked';
             }else{
               $single = 'checked';
             } 
         }

        
         ?>
         <div class="row">
            <div class="col-md-3">
               <div class="pg-frm">
               <label>Gender</label>
               <div class="pg-frm">
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn male">
                      <input type="radio" <?php echo $male; ?> class="gender1" name="options" id="male" value="male" autocomplete="off" > Male
                    </label>
                    <label class="btn female">
                      <input type="radio" <?php echo $female; ?> class="gender1" name="options" id="female" value="female" autocomplete="off"> Female
                    </label>
                  </div>
               </div>
               </div>
               <div id="gender-error">&nbsp;</div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
               <label>Marital Status</label>
               <div class="pg-frm">
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn single">
                      <input type="radio" <?php echo $single; ?> name="options1" class="marital" id="single" value="single" autocomplete="off" > Single
                    </label>
                    <label class="btn married">
                      <input type="radio" <?php echo $married; ?> name="options1" class="marital" id="married" value="married" autocomplete="off"> Married
                    </label>
                  </div>
               </div>
               </div>
               <div id="marital-error">&nbsp;</div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
               <label> Preferred Contact Time </label>
               <?php 

               $srt = explode(':', isset($user['contact_start_time'])?$user['contact_start_time']:'');
               $end = explode(':', isset($user['contact_end_time'])?$user['contact_end_time']:''); 

                ?>
               <div class="row">
                  <div class="col-md-6">
                     <label>Start Date</label>
                  </div>
                  <div class="col-md-6">
                      <label>End Date</label>
                  </div>
                  <div class="col-md-2">
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
                  <div class="col-md-2">
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
                  <div class="col-md-2">
                     <select id="start-type" class="fld">
                        <?php 
                          echo "<option selected value='".$srt[2]."'>".$srt[2]."</option>"; 
                        ?>
                        <option>AM</option>
                        <option>PM</option>
                     </select>
                  </div>

                  <div class="col-md-2">
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
                  <div class="col-md-2">
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
                  </div>
                  <div class="col-md-2">
                     <select id="end-type" class="fld">
                        <?php 
                          echo "<option selected value='".$end[2]."'>".$end[2]."</option>"; 
                        ?>
                        <option>AM</option>
                        <option>PM</option>
                     </select>
                  </div>
                  <!-- <div class="col-md-6">
                     <div class="pg-frm">
                        <input type="text" class=" fld" id="timepicker" disabled placeholder="Start time" value="<?php echo isset($user['contact_start_time'])?$user['contact_start_time']:''; ?>" name="pwd" >
                         <div id="timepicker-error">&nbsp;</div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="pg-frm">
                        <input type="text" class=" fld" id="timepicker2" disabled placeholder="End time" value="<?php echo isset($user['contact_start_time'])?$user['contact_start_time']:''; ?>" name="pwd" >
                         <div id="timepicker2-error">&nbsp;</div>
                     </div>
                  </div> -->
                   </div>
               </div>
               
            </div>
         </div>
         <div class="row">

            <label >Preferred Contact Days : &nbsp;&nbsp;&nbsp;</label>
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
                        } 
                        ?>
                         <div class="custom-control custom-checkbox custom-control-inline">
                          <input <?php echo $selected; ?> type="checkbox" class="custom-control-input weeks" value="<?php echo $value; ?>" name="customCheck" id="customCheck<?php echo $key; ?>">
                          <label class="custom-control-label" for="customCheck<?php echo $key; ?>"><?php echo $value; ?></label>
                       </div>
                        <?php 
                     }
                  ?>
                
              
               </div>
               <div class="row">
            <label >Preferred Communication Channel : &nbsp;&nbsp;&nbsp;</label>  
           <?php 
            $comm = explode(',', $user['communications']);
           ?>

           
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input communications" name="customCheck" <?php if (in_array('Call', $comm)) {
                      echo "checked";
                    } ?> value="Call" id="customCheck14">
                    <label class="custom-control-label" for="customCheck14">Call</label>
                 </div>
               
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input communications" name="customCheck" <?php if (in_array('Email', $comm)) {
                      echo "checked";
                    } ?> value="Email" id="customCheck22">
                    <label class="custom-control-label" for="customCheck22">Email</label>
                 </div>
             
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input communications" name="customCheck" <?php if (in_array('SMS', $comm)) {
                      echo "checked";
                    } ?> value="SMS" id="customCheck33">
                    <label class="custom-control-label" for="customCheck33">SMS</label>
                 </div> 

                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input communications" name="customCheck" <?php if (in_array('Whatsapp', $comm)) {
                      echo "checked";
                    } ?> value="Whatsapp" id="customCheck11">
                    <label class="custom-control-label" for="customCheck11">Whatsapp</label>
                 </div>
               
              
               </div>
         <div class="row mt-3 d-none">
            <div class="col-md-3">
               <div class="pg-frm-hd">Aadhar</div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm-hd">Pan card</div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm-hd">ID Proof/License/Passport</div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm-hd">Bank Passbook <span>(optional)</span></div>
            </div>
         </div>
         <div class="row d-none">
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file1"><a class="fl-btn">Browse files</a></label>
                     <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name1"></div>
                  </div>
               </div>
               <div id="aadhar-error">&nbsp;</div>
            </div>
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file2"><a class="fl-btn">Browse files</a></label>
                     <input id="file2" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name2"></div>
                  </div>
               </div>
               <div id="pan-error">&nbsp;</div>
            </div>
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file3"><a class="fl-btn">Browse files</a></label>
                     <input id="file3" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name3"></div>
                  </div>
               </div>
               <div id="proof-error">&nbsp;</div>
            </div>
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file4"><a class="fl-btn">Browse files</a></label>
                     <input id="file4" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name4"></div>
                  </div>
               </div>
               <div id="bank-error">&nbsp;</div>
            </div>
         </div>
         <div class="row">
          <div class="col-md-12" id="warning-msg">&nbsp;</div>
            <div class="col-md-12">
               <div class="pg-submit" id="save-candidate-information-btn-div">
                  <?php if ($user['email_id_validated_by_candidate_status'] == 1) { ?>
                 <button id="save-candidate-information" class="pg-submit-btn">Save &amp; Continue</button>
              <?php } ?>
               </div>
            </div>
         </div>
      </div>
   </div>   
   <div class="clr"></div>

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


   <!--  -->
   <script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-information.js"></script>
   <script src="<?php echo base_url(); ?>assets/custom-js/candidate/validate-email-id.js"></script>