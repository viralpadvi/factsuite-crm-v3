<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-reference';
   }
</script>

   <!--Page Content-->
   <!-- <form> -->
   <div class="pg-cnt pt-3">
      <div class="pg-txt-cntr">
         <div class="pg-steps">Step <?php echo array_search('11',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <input type="hidden" name="" id="reference_id" value="<?php echo isset($table['reference']['reference_id'])?$table['reference']['reference_id']:''; ?>">
         <div id="new_address">
         <?php 
             $form_values = json_decode($user['form_values'],true);
             $form_values = json_decode($form_values,true);
             // echo $form_values['reference'][0];
             // echo $form_values['previous_address'][0];
             // echo json_encode($form_values['drug_test']);
             // echo $user['form_values'];
             $refrence = 1;
            if (isset($form_values['reference'][0])?$form_values['reference'][0]:0 > 0) {
               $refrence = $form_values['reference'][0];
             } 
             // echo $refrence;
             $j =1;
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


           for ($i=0; $i < $refrence; $i++) {   
              ?>
              <div id="form<?php echo $i; ?>">
              <h6 class="full-nam2">Reference <?php echo $j;?></h6>
         <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Reference Name</label>
                  <input name="" class="fld form-control name" value="<?php echo isset($name[$i])?$name[$i]:''; ?>" onkeyup="valid_name(<?php echo $i;?>)" onblur="valid_name(<?php echo $i;?>)"  id="name<?php echo $i; ?>" type="text">
                  <div id="name-error<?php echo $i;?>"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Company Name</label>
                  <input name="" class="fld form-control company-name" value="<?php echo isset($company_name[$i])?$company_name[$i]:''; ?>"  onkeyup="valid_company_name(<?php echo $i;?>)" onblur="valid_company_name(<?php echo $i;?>)"  id="company-name<?php echo $i; ?>" type="text">
                   <div id="company-name-error<?php echo $i;?>"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Designation</label>
                  <input name="" class="fld form-control designation" value="<?php echo isset($designation[$i])?$designation[$i]:''; ?>"   onkeyup="valid_designation(<?php echo $i;?>)" onblur="valid_designation(<?php echo $i;?>)"  id="designation<?php echo $i; ?>" type="text">
                   <div id="designation-error<?php echo $i;?>"></div>
               </div>
            </div>
         </div>
         <div class="row">
           <div class="col-md-2">
                <div class="pg-frm">
               <label>Country Code</label>
              <select class="fld form-control code" id="code">
                <?php
                $ccode = isset($codes[$i])?$codes[$i]:'';
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
                  <label>Contact Number</label>
                  <input name="" class="fld form-control contact" value="<?php echo isset($contact_number[$i])?$contact_number[$i]:''; ?>" onkeyup="valid_contact(<?php echo $i;?>)" onblur="valid_contact(<?php echo $i;?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="contact<?php echo $i; ?>" type="text">
                   <div id="contact-error<?php echo $i;?>"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Email ID</label>
              <input name="" class="fld form-control email" value="<?php echo isset($email_id[$i])?$email_id[$i]:''; ?>" onkeyup="valid_email(<?php echo $i;?>)" onblur="valid_email(<?php echo $i;?>)"  id="email<?php echo $i; ?>"   type="text">
                   <div id="name-error<?php echo $i;?>"></div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>Years of Association</label>
                  <input name="" class="fld form-control association" value="<?php echo isset($years_of_association[$i])?$years_of_association[$i]:''; ?>" onkeyup="valid_association(<?php echo $i;?>)" onblur="valid_association(<?php echo $i;?>)"  id="association<?php echo $i; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" type="text">
                   <div id="association-error<?php echo $i;?>"></div>
               </div>
            </div>
         </div>
          <div class="row">
            <div class="col-md-6">
               <div class="pg-frm-hd">Preferred Contact Time</div>
               <div class="row">
                   <?php 

               $srt = explode(':', isset($contact_start_time[$i])?$contact_start_time[$i]:'');
               $end = explode(':', isset($contact_end_time[$i])?$contact_end_time[$i]:''); 

                ?> 
                  <div class="col-md-6">
                     <label>Start Date</label>
                  </div>
                  <div class="col-md-6">
                      <label>End Date</label>
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
                        <?php 
                          echo "<option selected value='".$srt[2]."'>".$srt[2]."</option>"; 
                        ?>
                        <option>AM</option>
                        <option>PM</option>
                     </select>
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
                        <?php 
                          echo "<option selected value='".$end[2]."'>".$end[2]."</option>"; 
                        ?>
                        <option>AM</option>
                        <option>PM</option>
                     </select>
                  </div>
                 <!--  <div class="col-md-5">
                     <div class="pg-frm">
                        <input type="text" class="fld start-time" disabled onchange="valid_timepicker(<?php echo $i;?>)" onkeyup="valid_timepicker(<?php echo $i;?>)" onblur="valid_timepicker(<?php echo $i;?>)" id="timepicker<?php echo $i; ?>" value="<?php echo isset($contact_start_time[$i])?$contact_start_time[$i]:''; ?>" placeholder="Start time" name="pwd" >
                         <div id="timepicker-error<?php echo $i;?>"></div>
                     </div>
                  </div>
                  <div class="col-md-5">
                     <div class="pg-frm">
                        <input type="text" class="fld end-time" disabled onchange="valid_timepicker1(<?php echo $i;?>)" onkeyup="valid_timepicker1(<?php echo $i;?>)" onblur="valid_timepicker1(<?php echo $i;?>)" id="timepicker1<?php echo $i; ?>" value="<?php echo isset($contact_end_time[$i])?$contact_end_time[$i]:''; ?>" placeholder="End time" name="pwd" >
                         <div id="timepicker1-error<?php echo $i;?>"></div>
                     </div>
                  </div> -->
                  <!-- <div class="col-md-2"><button onclick="remove_form(<?php echo $i;?>)"><i class="fa fa-trash"></i></button></div> -->
               </div>
            </div>
          </div>
         <hr>
         </div>
              <?php  
              $j++;
     }

         }else{
              for ($i=0; $i < $refrence; $i++) { 
         ?>
         <div id="form0">
         <h6 class="full-nam2">Reference <?php echo $j;?></h6>
         <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Reference Name</label>
                  <input name="" class="fld form-control name"  onkeyup="valid_name(<?php echo $i;?>)" onblur="valid_name(<?php echo $i;?>)"  id="name<?php echo $i; ?>"  type="text">
                   <div id="name-error<?php echo $i;?>"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Company Name</label>
                  <input name="" class="fld form-control company-name"  onkeyup="valid_company_name(<?php echo $i;?>)" onblur="valid_company_name(<?php echo $i;?>)"  id="company-name<?php echo $i; ?>"  type="text">
                   <div id="company-name-error<?php echo $i;?>"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Designation</label>
                  <input name="" class="fld form-control designation"  onkeyup="valid_designation(<?php echo $i;?>)" onblur="valid_designation(<?php echo $i;?>)"  id="designation<?php echo $i; ?>"  type="text">
                   <div id="designation-error<?php echo $i;?>"></div>
               </div>
            </div>
         </div>
         <div class="row">
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
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>Contact Number</label>
                  <input name="" class="fld form-control contact"  onkeyup="valid_contact(<?php echo $i;?>)" onblur="valid_contact(<?php echo $i;?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  id="contact<?php echo $i; ?>"  type="text">
                   <div id="contact-error<?php echo $i;?>"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Email ID</label>
                  <input name="" class="fld form-control email"  onkeyup="valid_email(<?php echo $i;?>)" onblur="valid_email(<?php echo $i;?>)"  id="email<?php echo $i; ?>"  type="text">
                   <div id="email-error<?php echo $i;?>"></div>
               </div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>Years of Association</label>
                  <input name="" class="fld form-control association" onkeyup="valid_association(<?php echo $i;?>)" onblur="valid_association(<?php echo $i;?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="association<?php echo $i; ?>" type="text">
                   <div id="association-error<?php echo $i;?>"></div>
               </div>
            </div>
         </div>
          <div class="row">
            <div class="col-md-6">
               <div class="pg-frm-hd">Preferred Contact Time</div>
               <div class="row">
                     <?php 

               $srt = explode(':', isset($contact_start_time[$i])?$contact_start_time[$i]:'');
               $end = explode(':', isset($contact_end_time[$i])?$contact_end_time[$i]:''); 

                ?> 
                  <div class="col-md-6">
                     <label>Start Date</label>
                  </div>
                  <div class="col-md-6">
                      <label>End Date</label>
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
                  <!-- <div class="col-md-5">
                     <div class="pg-frm">
                        <input type="text" class="fld start-time" disabled onchange="valid_timepicker(<?php echo $i;?>)" onkeyup="valid_timepicker(<?php echo $i;?>)" onblur="valid_timepicker(<?php echo $i;?>)" id="timepicker<?php echo $i;?>" placeholder="Start time" name="pwd" >
                         <div id="timepicker-error<?php echo $i;?>"></div>
                     </div>
                  </div>
                  <div class="col-md-5">
                     <div class="pg-frm">
                        <input type="text" class="fld end-time" disabled onchange="valid_timepicker1(<?php echo $i;?>)" onkeyup="valid_timepicker1(<?php echo $i;?>)" onblur="valid_timepicker1(<?php echo $i;?>)" id="timepicker1<?php echo $i;?>" placeholder="End time" name="pwd" >
                         <div id="timepicker1-error<?php echo $i;?>"></div>
                     </div>
                  </div> -->
                  <!-- <div class="col-md-2"><button onclick="remove_form(0)"><i class="fa fa-trash"></i></button></ -->
               <!-- </div> -->
            </div>
          </div>
      </div>
         <hr>
      </div>
         <?php 
          $j++;
      }
            }
         ?>
      </div>
         <!-- <div><button id="add-row"><i class="fa fa-plus"></i></button></div> -->
         <!-- <h6 class="full-nam2">Reference 2</h6>
         <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Name</label>
                   <input name="" class="fld form-control name" type="text">
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Company Name</label>
                  <input name="" class="fld form-control company-name" type="text">
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Designation</label>
                   <input name="" class="fld form-control designation" type="text">
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Contact Number</label>
                  <input name="" class="fld form-control contact" type="text">
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Email ID</label>
                   <input name="" class="fld form-control email" type="text">
               </div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm">
                  <label>Years of Association</label>
                   <input name="" class="fld form-control association" type="text">
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-6">
               <div class="pg-frm-hd">Preferred contact time</div>
               <div class="row">
                  <div class="col-md-5">
                     <div class="pg-frm">
                        <input type="text" class="form-control fld start-time" id="timepicker3" placeholder="Start time" name="pwd" >
                     </div>
                  </div>
                  <div class="col-md-5">
                     <div class="pg-frm">
                        <input type="text" class="form-control fld end-time" id="timepicker4" placeholder="End time" name="pwd" >
                     </div>
                  </div>
               </div>
            </div>
          </div> -->
         <div class="row">
          <div class="col-md-12" id="warning-msg">&nbsp;</div>
            <div class="col-md-12">
               <div class="pg-submit">
                 <button id="add_reference" class="pg-submit-btn">Save &amp; Continue</button> 
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- </form> -->
   <!--Page Content-->
   <div class="clr"></div>
</section>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/reference.js" ></script>