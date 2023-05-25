<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-reference';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Reference</div>
         <div class="pg-rgt">Step <?php echo array_search('11',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
         <input type="hidden" name="" id="reference_id" value="<?php echo isset($table['reference']['reference_id'])?$table['reference']['reference_id']:''; ?>">
      </div>
      <?php $form_values = json_decode($user['form_values'],true);
         $form_values = json_decode($form_values,true);
         $refrence = 1;
         if (isset($form_values['reference'][0])?$form_values['reference'][0]:0 > 0) {
            $refrence = $form_values['reference'][0];
         }
         $j = 1;
         if (isset($table['reference']['name'])) {
            $company_name = explode(',', $table['reference']['company_name']);
            $designation = explode(',', $table['reference']['designation']);
            $contact_number = explode(',', $table['reference']['contact_number']);
            $email_id = explode(',', $table['reference']['email_id']);
            $years_of_association = explode(',', $table['reference']['years_of_association']);
            $contact_start_time = explode(',', $table['reference']['contact_start_time']);
            $contact_end_time = explode(',', $table['reference']['contact_end_time']); 
            $name = explode(',',$table['reference']['name']);
            $codes = explode(',',$table['reference']['code']);
         }

         for ($i=0; $i < $refrence; $i++) { ?>
            <div class="pg-txt">
               <div class="pg-lft">Reference <?php echo $j;?></div>
               <div class="clr"></div>
            </div>
            <div class="pg-frm">
               <div class="full-bx">
                  <label>Reference Name <span>(Required)</span></label>
                  <input class="fld reference-name" value="<?php echo isset($name[$i])?$name[$i]:''; ?>" onkeyup="check_reference_name(<?php echo $i;?>)" onblur="check_reference_name(<?php echo $i;?>)" id="reference-name-<?php echo $i; ?>" type="text">
                  <div id="reference-name-error-<?php echo $i;?>"></div>
               </div>

               <div class="full-bx">
                  <label>Company Name <span>(Required)</span></label>
                  <input class="fld company-name" value="<?php echo isset($company_name[$i])?$company_name[$i]:''; ?>" onkeyup="check_company_name(<?php echo $i;?>)" onblur="check_company_name(<?php echo $i;?>)" id="company-name-<?php echo $i; ?>" type="text">
                   <div id="company-name-error-<?php echo $i;?>"></div>
               </div>

               <div class="full-bx">
                  <label>Designation <span>(Required)</span></label>
                  <input class="fld designation" value="<?php echo isset($designation[$i])?$designation[$i]:''; ?>" onkeyup="check_designation(<?php echo $i;?>)" onblur="check_designation(<?php echo $i;?>)" id="designation-<?php echo $i; ?>" type="text">
                  <div id="designation-error-<?php echo $i;?>"></div>
               </div>

               <div class="full-bx pb-0">
                  <div class="float-left wdt-27">
                     <label>Country Code</label>
                  </div>
                  <div class="float-right wdt-70">
                     <label>Mobile Number <span>(Required)</span></label>
                  </div>
                  <div class="clr"></div>
               </div>
               <div class="full-bx">
                  <div class="float-left wdt-27">
                     <select class="fld code" id="code">
                        <?php $ccode = isset($codes[$i])?$codes[$i]:'';
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
                     <input class="fld contact" value="<?php echo isset($contact_number[$i])?$contact_number[$i]:''; ?>" onkeyup="check_contact(<?php echo $i;?>)" onblur="check_contact(<?php echo $i;?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="contact-<?php echo $i; ?>" type="text">
                     <div id="contact-error-<?php echo $i;?>"></div>
                  </div>
                  <div class="clr"></div>
               </div>

               <div class="full-bx">
                  <label>Email ID <span>(Required)</span></label>
                  <input  class="fld email" value="<?php echo isset($email_id[$i])?$email_id[$i]:''; ?>" onkeyup="check_email(<?php echo $i;?>)" onblur="check_email(<?php echo $i;?>)"  id="email-id-<?php echo $i; ?>" type="text">
                   <div id="email-id-error-<?php echo $i;?>"></div>
               </div>

               <div class="full-bx">
                  <label>Years of Association</label>
                  <input class="fld association" value="<?php echo isset($years_of_association[$i])?$years_of_association[$i]:''; ?>" onkeyup="check_years_of_association(<?php echo $i;?>)" onblur="check_years_of_association(<?php echo $i;?>)" id="association-<?php echo $i; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" type="text">
                   <div id="years-of-association-error-<?php echo $i;?>"></div>
               </div>

               <div class="full-bx">
                  <div class="pg-frm-hd">Preferred Contact Time & Week</div>
                  <div class="row">
                          <?php 

               $srt = explode(':', isset($contact_start_time[$i])?$contact_start_time[$i]:'');
               $end = explode(':', isset($contact_end_time[$i])?$contact_end_time[$i]:''); 

                ?> 
                  <div class="col-md-6">
                     <label>Start Date</label>
                  </div>
                 
                  <div class="col-md-2">
                     <select id="start-hour" class="fld start-hour">
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
                     <select id="start-minute" class="fld start-minute">
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
                     <select id="start-type" class="fld start-type">
                       
                        <option>AM</option>
                        <option>PM</option>
                     </select>
                  </div>
                  <div class="col-md-6">
                      <label>End Date</label>
                  </div>
                  <div class="col-md-2">
                     <select id="end-hour" class="fld end-hour">
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
                     <select id="end-minute" class="fld end-minute">
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
                     <select id="end-type" class="fld end-type">
                        
                        <option>AM</option>
                        <option>PM</option>
                     </select>
                  </div>
                  </div>
                 <!--  <div class="float-left wdt-45">
                     <input type="text" disabled class="fld start-time reference-start-time" id="timepicker-<?php echo $i;?>" placeholder="Start time" value="<?php echo isset($contact_start_time[$i])?$contact_start_time[$i]:''; ?>" onkeyup="check_start_time(<?php echo $i; ?>)" onblur="check_start_time(<?php echo $i; ?>)" onchange="check_start_time(<?php echo $i; ?>)">
                     <div id="timepicker-error-<?php echo $i;?>"></div>
                  </div>
                  <div class="float-left wdt-10">
                     <div class="cntr-txt">To</div>
                  </div>
                  <div class="float-right wdt-45">
                     <input type="text" class="fld end-time reference-end-time" id="timepicker2-<?php echo $i;?>" disabled placeholder="End time" value="<?php echo isset($contact_end_time[$i])?$contact_end_time[$i]:''; ?>" onkeyup="check_end_time(<?php echo $i; ?>)" onblur="check_end_time(<?php echo $i; ?>)" onchange="check_end_time(<?php echo $i; ?>)">
                     <div id="timepicker2-error-<?php echo $i;?>"></div>
                  </div> -->
                  <div class="clr"></div>
               </div>
         <?php } ?>
      </div>
      <div id="save-data-error-msg"></div>
      <div class="text-center">
         <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
      </div>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/reference.js"></script>