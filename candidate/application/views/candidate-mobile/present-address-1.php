<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-present-address';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Present Address</div>
         <div class="pg-rgt">Step <?php echo array_search('8',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <div class="pg-frm">
         <div class="full-bx">
            <label>House/Flat No. <span>(Required)</span></label>
            <input name="" class="fld" value="<?php echo isset($table['present_address']['flat_no'])?$table['present_address']['flat_no']:''; ?>" id="house-flat" type="text">
            <input name="" class="fld" value="<?php echo isset($table['present_address']['present_address_id'])?$table['present_address']['present_address_id']:''; ?>" id="present_address_id" type="hidden">
            <div id="house-flat-error"></div>
         </div>

         <div class="full-bx">
            <label>Street/Road <span>(Required)</span></label>
            <input name="" class="fld" value="<?php echo isset($table['present_address']['street'])?$table['present_address']['street']:''; ?>" id="street" type="text">
            <div id="street-error"></div>
         </div>

         <div class="full-bx">
            <label>Area <span>(Required)</span></label>
            <input name="" class="fld" value="<?php echo isset($table['present_address']['area'])?$table['present_address']['area']:''; ?>" id="area" type="text">
            <div id="area-error"></div>
         </div>

         <div class="full-bx">
            <label>Pin Code <span>(Required)</span></label>
            <input name="" class="fld" id="pincode" value="<?php echo isset($table['present_address']['pin_code'])?$table['present_address']['pin_code']:''; ?>" type="text">
            <div id="pincode-error"></div>
         </div>

         <div class="full-bx">
            <label>Nearest Landmark</label>
            <input name="" class="fld" id="land-mark" value="<?php echo isset($table['present_address']['nearest_landmark'])?$table['present_address']['nearest_landmark']:''; ?>" type="text">
            <div id="land-mark-error"></div>
         </div>

         <div class="full-bx">
            <label>Country <span>(Required)</span></label>
            <select class="fld country select2" id="country">
               <option selected value=''>Select Country</option>
               <?php // $get_country = isset($table['present_address']['country'])?$table['present_address']['country']:'India';
               $get_country = isset($table['present_address']['country'])?$table['present_address']['country']:'';
               $c_id = '';
               foreach ($country as $key1 => $val) {
                  if ($get_country == $val['name']) {
                     $c_id = $val['id'];
                     echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                  } else {
                     echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                  }
               } ?>
            </select> 
            <div id="country-error"></div>
         </div>

         <div class="full-bx">
            <label>State <span>(Required)</span></label>
            <?php if ($c_id != '') {
               $state = $this->candidateModel->get_all_states($c_id);  
               }
               $city_id ='';
            ?>
            <select class="fld form-control state select2" id="state">
               <option selected value=''>Select State</option>
               <?php $get_state = isset($table['present_address']['state'])?$table['present_address']['state']:'';
               $get = isset($table['present_address']['state'])?$table['present_address']['state']:'Karnataka';
               foreach ($state as $key1 => $val) {
                  if ($get_state == $val['name']) {
                     $city_id = $val['id'];
                     echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                  } else {
                     if ($get == $val['name']) {
                        $city_id = $val['id'];
                     }
                     echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                  }
               } ?>
            </select> 
            <div id="state-error"></div>
         </div>

         <div class="full-bx">
            <label>City/Town <span>(Required)</span></label>
            <select class="fld city select2" id="city" >
               <option selected value=''>Select City/Town</option>
               <?php $get_city = isset($table['present_address']['city'])?$table['present_address']['city']:'';
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
            <label>Duration of Stay <span>(Required)</span></label>
            <label>From</label>
            <?php
               $exploded_from_date = isset($table['present_address']['duration_of_stay_start'])?explode('-',$table['present_address']['duration_of_stay_start']):'';
            ?>
            <div class="row">
               <div class="col-md-6 w-50">
                  <label>Month</label>
                  <select class="fld select2" id="duration-of-stay-from-month">
                     <option selected value=''>Select Month</option>
                     <?php 
                     $months = $this->config->item('month_names');
                     $num = 0;
                     for ($i = 1; $i < $this->config->item('duration_of_stay_end_month'); $i++) {
                        $selected = '';
                        if ($exploded_from_date != '') {
                           if ($exploded_from_date[1] == $i) {
                              $selected = 'selected';
                           }
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $i;?>"><?php echo $months[$num];?></option>
                     <?php $num++; } ?>
                  </select> 
                  <div id="duration-of-stay-from-month-error"></div>
               </div>
               <div class="col-md-6 w-50">
                  <label>Year</label>
                  <select class="fld select2" id="duration-of-stay-from-year">
                     <option selected value=''>Select year</option>
                     <?php 
                     for ($i = $this->config->item('duration_of_stay_start_year'); $i <= $this->config->item('current_year'); $i++) {
                        $selected = '';
                        if ($exploded_from_date[0] == $i) {
                           $selected = 'selected';
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $i;?>"><?php echo $i;?></option>
                     <?php } ?>
                  </select> 
                  <div id="duration-of-stay-from-year-error"></div>
               </div>
            </div>
         </div>
         <div class="full-bx mt-3">
            <label>To</label>
            <?php
               $exploded_to_date = isset($table['present_address']['duration_of_stay_end'])?explode('-',$table['present_address']['duration_of_stay_end']):'';
            ?>
            <div class="row">
               <div class="col-md-6 w-50">
                  <label>Month</label>
                  <select class="fld select2" id="duration-of-stay-to-month">
                     <option selected value=''>Select Month</option>
                     <?php 
                     $num = 0;
                     for ($i = 1; $i < $this->config->item('duration_of_stay_end_month'); $i++) {
                        $selected = '';
                        if ($exploded_to_date != '') {
                           if ($exploded_to_date[1] == $i) {
                              $selected = 'selected';
                           }
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $i;?>"><?php echo $months[$num];?></option>
                     <?php $num++; } ?>
                  </select> 
                  <div id="duration-of-stay-to-month-error"></div>
               </div>
                <div class="col-md-6 w-50">
                  <label>Year</label>
                  <select class="fld select2" id="duration-of-stay-to-year">
                     <option selected value=''>Select year</option>
                     <?php for ($i = $this->config->item('duration_of_stay_start_year'); $i <= $this->config->item('current_year'); $i++) {
                        $selected = '';
                        if ($exploded_to_date[0] == $i) {
                           $selected = 'selected';
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $i;?>"><?php echo $i;?></option>
                     <?php } ?>
                  </select> 
                  <div id="duration-of-stay-to-year-error"></div>
               </div>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline mrg-btm d-none">
               <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck1">
               <label class="custom-control-label pt-1" for="customCheck1">Present</label>
            </div>
         </div>

         <div class="full-bx">
            <label>Contact Person</label>
            <label>Name <span>(Required)</span></label>
            <input name="" class="fld" id="contact-person-name" value="<?php echo isset($table['present_address']['contact_person_name'])?$table['present_address']['contact_person_name']:''; ?>" type="text">
            <div id="contact-person-name-error"></div>
         </div>

         <div class="full-bx">
            <label>Relationship <span>(Required)</span></label>
            <?php
            $Self = '';
            $Parent = '';
            $Spouse = '';
            $Friend = '';
            $Relative = '';
            $House_Owner = '';
            $Neighbor = '';
            $Security_Guard = '';
            $Landlord = '';
            $Cousin = '';
            if (isset($table['present_address']['contact_person_relationship'])) {
               if ($table['present_address']['contact_person_relationship']=='Self') {
                  $Self = 'selected';
               } else if ($table['present_address']['contact_person_relationship']=='Parent') {
                  $Parent = 'selected';
               } else if ($table['present_address']['contact_person_relationship']=='Spouse') {
                  $Spouse = 'selected';
               } else if ($table['present_address']['contact_person_relationship']=='Friend') {
                  $Friend = 'selected';
               } else if ($table['present_address']['contact_person_relationship']=='Relative') {
                  $Relative = 'selected';
               } else if ($table['present_address']['contact_person_relationship']=='Neighbor') {
                  $Neighbor = 'selected';
               } else if ($table['present_address']['contact_person_relationship']=='Security Guard') {
                  $Security_Guard = 'selected';
               } else if ($table['present_address']['contact_person_relationship']=='Landlord') {
                  $Landlord = 'selected';
               } else if ($table['present_address']['contact_person_relationship']=='House Owner') {
                  $House_Owner = 'selected';
               } else if ($table['present_address']['contact_person_relationship']=='Cousin') {
                  $Cousin = 'selected';
               }
            } ?>
            <select name="" class="fld" id="relationship" >
               <option value="">Select Relationship</option>
               <option <?php echo $Self; ?> value="Self">Self</option>
               <option <?php echo $Parent; ?> value="Parent">Parent</option>
               <option <?php echo $Spouse; ?> value="Spouse">Spouse</option>
               <option <?php echo $Friend; ?> value="Friend">Friend</option>
               <option <?php echo $Relative; ?> value="Relative">Relative</option>
               <option <?php echo $Neighbor; ?> value="Neighbor">Neighbor</option>
               <option <?php echo $Security_Guard; ?> value="Security Guard">Security Guard</option>
               <option <?php echo $Landlord; ?> value="Landlord">Landlord</option>
               <option <?php echo $House_Owner; ?> value="House Owner">House Owner</option>
               <option <?php echo $Cousin; ?> value="Cousin">Cousin</option>
            </select>
            <div id="relationship-error"></div>
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
               <select class="fld code" id="contact-person-contact-code">
                  <?php
                  $ccode = isset($table['present_address']['code'])?$table['present_address']['code']:'';
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
               <input name="" class="fld" id="contact-person-contact-no" value="<?php echo isset($table['present_address']['contact_person_mobile_number'])?$table['present_address']['contact_person_mobile_number']:''; ?>" type="text">
               <div id="contact-person-contact-no-error"></div>
            </div>
            <div class="clr"></div>
         </div>
      </div>
      </div>
      <div id="save-data-error-msg"></div>
      <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/present-address-1.js" ></script>