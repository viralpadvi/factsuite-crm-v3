<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-drug-test';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Drug Test</div>
         <div class="pg-rgt">Step <?php echo array_search('4',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <input type="hidden" id="drugtest_id" value="<?php echo isset($table['drugtest']['drugtest_id'])?$table['drugtest']['drugtest_id']:''; ?>" name="">
      <div class="pg-frm">
         <?php
         $form_values = json_decode($user['form_values'],true);
         $form_values = json_decode($form_values,true); 
         $drug_test = 1;
         if (isset($form_values['drug_test'][0])?$form_values['drug_test'][0]:0 > 0) {
            $drug_test = count($form_values['drug_test']);
         }  
         $j = 1;

         if (isset($table['drugtest']['candidate_name'])) {
            $candidate_name = json_decode($table['drugtest']['candidate_name'],true);
            $father_name = json_decode($table['drugtest']['father__name'],true);
            $dob = json_decode($table['drugtest']['dob'],true);
            $address = json_decode($table['drugtest']['address'],true);
            $mobile_number = json_decode($table['drugtest']['mobile_number'],true); 
            $codes = json_decode($table['drugtest']['code'],true);  
             
           for ($i = 0; $i < $drug_test; $i++) { 
               $court = '';
               if (isset($form_values['drug_test'][$i])?$form_values['drug_test'][$i]:'' !='') {
                  $court = $this->candidateModel->drug_test_type($form_values['drug_test'][$i]);
               } ?>
               <div class="full-bx">
                  <label><?php echo isset($court['drug_test_type_name'])?$court['drug_test_type_name']:'Panel'; ?> Details</label>
               </div>
               <div id="form<?php echo $i; ?>"></div>
               <div class="full-bx">
                  <label>Candidate Name</label>
                  <input name="" class="fld name" disabled  value="<?php echo isset($candidate_name[$i]['candidate_name'])?$candidate_name[$i]['candidate_name']:''; ?>"onblur="valid_name(<?php echo $i; ?>)" onkeyup="valid_name(<?php echo $i; ?>)" id="name<?php echo $i; ?>" type="text"> 
                  <div id="name-error<?php echo $i; ?>"></div>
               </div>
               <div class="full-bx">
                  <label>Father's Name</label>
                  <input name="" class="fld father_name" disabled  value="<?php echo isset($father_name[$i]['father_name'])?$father_name[$i]['father_name']:''; ?>" onblur="valid_father_name(<?php echo $i; ?>)" onkeyup="valid_father_name(<?php echo $i; ?>)" id="father_name<?php echo $i; ?>" type="text">
                  <div id="father_name-error<?php echo $i; ?>"></div>
               </div>
               <div class="full-bx">
                  <label>Date Of Birth</label>
                  <input name="" class="fld mdate"  disabled value="<?php echo isset($dob[$i]['dob'])?$dob[$i]['dob']:''; ?>" onblur="valid_date_of_birth(<?php echo $i; ?>)" onchange="valid_date_of_birth(<?php echo $i; ?>)" onkeyup="valid_date_of_birth(<?php echo $i; ?>)" id="date_of_birth<?php echo $i; ?>" type="text">
                  <div id="date_of_birth-error<?php echo $i; ?>"></div>
               </div>
               <div class="full-bx">
                  <label>Address <span>(Required)</span></label>
                  <textarea class="fld address" onblur="valid_address(<?php echo $i; ?>)" onkeyup="valid_address(<?php echo $i; ?>)" rows="4" id="address<?php echo $i; ?>"><?php echo isset($address[$i]['address'])?$address[$i]['address']:''; ?></textarea>
                  <div id="address-error<?php echo $i; ?>"></div>
               </div>
               <div class="full-bx">
                  <div class="float-left wdt-27">
                     <label>Country Code</label>
                     <select class="fld code" id="code">
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
                     <label>Contact Number <span>(Required)</span></label>
                     <input name="" class="fld contact_number" value="<?php echo isset($mobile_number[$i]['mobile_number'])?$mobile_number[$i]['mobile_number']:''; ?>" onblur="valid_contact_number(<?php echo $i; ?>)" onkeyup="valid_contact_number(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="contact_number<?php echo $i; ?>" type="text">
                     <div id="contact_number-error<?php echo $i; ?>"></div>
                  </div>
                  <div class="clr"></div>
               </div>
            <?php } } else {
               for ($i=0; $i < $drug_test; $i++) { 
                  $court ='';
                  if (isset($form_values['drug_test'][$i])?$form_values['drug_test'][$i]:'' !='') {
                     $court = $this->candidateModel->drug_test_type($form_values['drug_test'][$i]);
                  } ?>
               <div class="full-bx">
                  <label><?php echo isset($court['drug_test_type_name'])?$court['drug_test_type_name']:'Panel'; ?> Details</label>
               </div>
               <div id="form0"></div>
               <div class="full-bx">
                  <label>Candidate Name</label>
                  <input name="" class="fld name candidate_name" disabled value="<?php echo $user['first_name']; ?>" onblur="valid_name(<?php echo $i; ?>)" onkeyup="valid_name(<?php echo $i; ?>)" id="name<?php echo $i; ?>" type="text">
                  <div id="name-error<?php echo $i; ?>"></div>
               </div>
               <div class="full-bx">
                  <label>Father's Name</label>
                  <input name="" class="fld father_name" disabled value="<?php echo $user['father_name']; ?>" onblur="valid_father_name(<?php echo $i; ?>)" onkeyup="valid_father_name(<?php echo $i; ?>)" id="father_name<?php echo $i; ?>" type="text">
                  <div id="father_name-error<?php echo $i; ?>"></div>
               </div>
               <div class="full-bx">
                  <label>Date Of Birth</label>
                  <input name="" class="fld mdate dob date_of_birth" disabled value="<?php echo $user['date_of_birth']; ?>" onblur="valid_date_of_birth(<?php echo $i; ?>)"  onchange="valid_date_of_birth(<?php echo $i; ?>)" onkeyup="valid_date_of_birth(<?php echo $i; ?>)" id="date_of_birth<?php echo $i; ?>" type="text">
                  <div id="date_of_birth-error<?php echo $i; ?>"></div>
               </div>
               <div class="full-bx">
                  <label>Address <span>(Required)</span></label>
                  <textarea class="fld address" onblur="valid_address(<?php echo $i; ?>)" onkeyup="valid_address(<?php echo $i; ?>)" rows="4" id="address<?php echo $i; ?>"></textarea>
                  <div id="address-error<?php echo $i; ?>"></div>
               </div>
               <div class="full-bx">
                  <div class="float-left wdt-27">
                     <label>Country Code</label>
                     <select class="fld code" id="code<?php echo $i; ?>" onchange="valid_country_code(<?php echo $i; ?>)">
                        <?php
                        foreach ($code['countries'] as $key => $value) {
                           echo "<option>{$value['code']}</option>";
                        } ?>
                     </select>
                     <div id="country-code-error<?php echo $i; ?>"></div>
                  </div>
                  <div class="float-right wdt-70">
                     <label>Contact Number <span>(Required)</span></label>
                     <input name="" class="fld contact_number" value="" onblur="valid_contact_number(<?php echo $i; ?>)" onkeyup="valid_contact_number(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="contact_number<?php echo $i; ?>" type="text">
                     <div id="contact_number-error<?php echo $i; ?>"></div>
                  </div>
                  <div class="clr"></div>
               </div>
         <?php } } ?>
      </div>
      <div id="save-data-error-msg"></div>
      <button id="add-drug-test-btn" class="pg-nxt-btn">Save &amp; Continue</button>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/drug-test.js" ></script>