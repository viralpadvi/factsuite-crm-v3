<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-drug-test';
   }
</script>

<!--Page Content-->
   <!-- <form> -->
   <div class="pg-cnt pt-3">
       <div class="pg-txt-cntr">
         <div class="pg-steps">Step <?php echo array_search('4',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <h6 class="full-nam2"> Address Details</h6>
        <input type="hidden" id="drugtest_id" value="<?php echo isset($table['drugtest']['drugtest_id'])?$table['drugtest']['drugtest_id']:''; ?>" name="">
        <div id="new_address">
            <span> <input type="checkbox" id="addresses" name=""> Copy details mentioned in personal details </span>
        <?php
        $user_session_details = $this->session->userdata('logged-in-candidate');
         $form_values = json_decode($user['form_values'],true);
             $form_values = json_decode($form_values,true); 
             $drug_test = 1;
            if (isset($form_values['drug_test'][0])?$form_values['drug_test'][0]:0 > 0) {
               $drug_test = count($form_values['drug_test']);
             }  
             $j =1;

             // var_dump($user);
             
        if (isset($table['drugtest']['candidate_name'])) {
            $candidate_name = json_decode($table['drugtest']['candidate_name'],true);
            $father_name = json_decode($table['drugtest']['father__name'],true);
            $dob = json_decode($table['drugtest']['dob'],true);
            $address = json_decode($table['drugtest']['address'],true);
            $mobile_number = json_decode($table['drugtest']['mobile_number'],true); 
            $codes = json_decode($table['drugtest']['code'],true);  
             
           for ($i=0; $i < $drug_test; $i++) { 
             $court ='';
                if (isset($form_values['drug_test'][$i])?$form_values['drug_test'][$i]:'' !='') {
                   
                $court = $this->candidateModel->drug_test_type($form_values['drug_test'][$i]);
                }

                ?>
                <h6 class="full-nam2"><?php echo isset($court['drug_test_type_name'])?$court['drug_test_type_name']:'Panel'; ?> Details</h6>
              <div id="form<?php echo $i; ?>">
               <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Candidate Name</label>
                  <input name="" class="fld form-control name" disabled  value="<?php echo isset($candidate_name[$i]['candidate_name'])?$candidate_name[$i]['candidate_name']:$user_session_details['first_name'].' '.$user_session_details['last_name']; ?>"onblur="valid_name(<?php echo $i; ?>)" onkeyup="valid_name(<?php echo $i; ?>)" id="name<?php echo $i; ?>" type="text"> 
               <div id="name-error<?php echo $i; ?>">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Father's Name</label>
                  <input name="" class="fld form-control father_name" disabled  value="<?php echo isset($father_name[$i]['father_name'])?$father_name[$i]['father_name']:$user_session_details['father_name']; ?>" onblur="valid_father_name(<?php echo $i; ?>)" onkeyup="valid_father_name(<?php echo $i; ?>)" id="father_name<?php echo $i; ?>" type="text">
               <div id="father_name-error<?php echo $i; ?>">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Date Of Birth</label>
                  <input name="" class="fld form-control mdate"  disabled value="<?php echo isset($dob[$i]['dob'])?$dob[$i]['dob']:$user_session_details['date_of_birth']; ?>" onblur="valid_date_of_birth(<?php echo $i; ?>)" onchange="valid_date_of_birth(<?php echo $i; ?>)" onkeyup="valid_date_of_birth(<?php echo $i; ?>)" id="date_of_birth<?php echo $i; ?>" type="text">
               <div id="date_of_birth-error<?php echo $i; ?>">&nbsp;</div>
               </div>
            </div> 

         </div>
         <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Address</label>
                  <textarea class="fld form-control address" onblur="valid_address(<?php echo $i; ?>)" onkeyup="valid_address(<?php echo $i; ?>)" rows="4" id="address<?php echo $i; ?>"><?php echo isset($address[$i]['address'])?$address[$i]['address']:''; ?></textarea>
               <div id="address-error<?php echo $i; ?>">&nbsp;</div>
               </div>
            </div>
              <div class="col-md-2">
                <div class="pg-frm">
               <label>Country Code</label>
              <select class="fld form-control code" id="code">
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
            </div>
            </div>

            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Contact Number</label>
                  <input name="" class="fld form-control contact_number" value="<?php echo isset($mobile_number[$i]['mobile_number'])?$mobile_number[$i]['mobile_number']:''; ?>" onblur="valid_contact_number(<?php echo $i; ?>)" onkeyup="valid_contact_number(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="contact_number<?php echo $i; ?>" type="text">
               <div id="contact_number-error<?php echo $i; ?>">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-2">
               <!-- <button onclick="remove_form(<?php echo $i; ?>)"><i class="fa fa-trash"></i></button> -->
            </div>

         </div>
      </div>
      <hr>
       
         <?php
           }
        }else{
          for ($i=0; $i < $drug_test; $i++) { 
         $court ='';
          if (isset($form_values['drug_test'][$i])?$form_values['drug_test'][$i]:'' !='') {
             
          $court = $this->candidateModel->drug_test_type($form_values['drug_test'][$i]);
          }

          ?>
          <h6 class="full-nam2"><?php echo isset($court['drug_test_type_name'])?$court['drug_test_type_name']:'Panel'; ?> Details</h6>
        <div id="form0">
          <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Candidate Name</label>
                  <input name="" class="fld form-control name candidate_name" disabled value="<?php echo $user['first_name']; ?>" onblur="valid_name(<?php echo $i; ?>)" onkeyup="valid_name(<?php echo $i; ?>)" id="name<?php echo $i; ?>" type="text">
                 
               <div id="name-error<?php echo $i; ?>">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Father's Name</label>
                  <input name="" class="fld form-control father_name" disabled value="<?php echo $user['father_name']; ?>" onblur="valid_father_name(<?php echo $i; ?>)" onkeyup="valid_father_name(<?php echo $i; ?>)" id="father_name<?php echo $i; ?>" type="text">
               <div id="father_name-error<?php echo $i; ?>">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Date Of Birth</label>
                  <input name="" class="fld form-control mdate dob date_of_birth" disabled value="<?php echo $user['date_of_birth']; ?>" onblur="valid_date_of_birth(<?php echo $i; ?>)"  onchange="valid_date_of_birth(<?php echo $i; ?>)" onkeyup="valid_date_of_birth(<?php echo $i; ?>)" id="date_of_birth<?php echo $i; ?>" type="text">
               <div id="date_of_birth-error<?php echo $i; ?>">&nbsp;</div>
               </div>
            </div> 

         </div>
         <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Address</label>
                  <textarea class="fld form-control address" onblur="valid_address(<?php echo $i; ?>)" onkeyup="valid_address(<?php echo $i; ?>)" rows="4" id="address<?php echo $i; ?>"></textarea>
               <div id="address-error<?php echo $i; ?>">&nbsp;</div>
               </div>
            </div>
              <div class="col-md-2">
                <div class="pg-frm">
               <label>Country Code</label>
              <select class="fld form-control code" id="code">
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
                  <label>Contact Number</label>
                  <input name="" class="fld form-control contact_number" value="" onblur="valid_contact_number(<?php echo $i; ?>)" onkeyup="valid_contact_number(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="contact_number<?php echo $i; ?>" type="text">
               <div id="contact_number-error<?php echo $i; ?>">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-2">
               <!-- <button onclick="remove_form(0)"><i class="fa fa-trash"></i></button> -->
            </div>

         </div>
      </div>
      <hr>
       <?php
     }
         }
       ?>
    </div>
     <!-- <div><button id="add-row"><i class="fa fa-plus"></i></button></div> -->
         
         <div class="row">
          <div class="col-md-12" id="warning-msg">&nbsp;</div>
            <div class="col-md-12">
               <div class="pg-submit">
                 <button id="add-drug-test" class="pg-submit-btn">Save &amp; Continue</button> 
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- </form> -->
   <!--Page Content-->
   <div class="clr"></div>
</section>
<script> 
    var candidate_info = <?php echo json_encode($user); ?>;
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-drug-test.js" ></script>
 