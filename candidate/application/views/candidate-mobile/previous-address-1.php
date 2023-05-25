<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-previous-address';
   }
</script>

<div class="container">
   <div class="pg-cntr">
      <div class="pg-txt">
         <div class="pg-lft">Previous Address</div>
         <div class="pg-rgt">Step <?php echo array_search('12',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <div class="clr"></div>
      </div>
      <input class="fld form-control" value="<?php echo isset($table['previous_address']['previos_address_id'])?$table['previous_address']['previos_address_id']:''; ?>" id="previos_address_id" type="hidden">
      <?php $form_values = json_decode($user['form_values'],true);
         $form_values = json_decode($form_values,true);
         $previous_address = 1;
         if (isset($form_values['previous_address'][0])?$form_values['previous_address'][0]:0 > 0) {
            $previous_address = $form_values['previous_address'][0];
         } 
         $j = 1;
         if (isset($table['previous_address']['flat_no'])) {
            $contact_person_mobile_number = json_decode($table['previous_address']['contact_person_mobile_number'],true); 
            $flat_no = json_decode($table['previous_address']['flat_no'],true); 
            $street = json_decode($table['previous_address']['street'],true); 
            $area = json_decode($table['previous_address']['area'],true); 
            $city = json_decode($table['previous_address']['city'],true); 
            $pin_code = json_decode($table['previous_address']['pin_code'],true); 
            $nearest_landmark = json_decode($table['previous_address']['nearest_landmark'],true); 
            $states = json_decode($table['previous_address']['state'],true); 
            $countries = json_decode($table['previous_address']['country'],true); 
            $relationship = json_decode($table['previous_address']['contact_person_relationship'],true); 
            $duration_of_stay_start = json_decode($table['previous_address']['duration_of_stay_start'],true); 
            $duration_of_stay_end = json_decode($table['previous_address']['duration_of_stay_end'],true); 
            $contact_person_name = json_decode($table['previous_address']['contact_person_name'],true);  
            $codes = json_decode($table['previous_address']['code'],true);  

            $rental_agreement = json_decode($table['previous_address']['rental_agreement'],true);
            $ration_card = json_decode($table['previous_address']['ration_card'],true);
            $gov_utility_bill = json_decode($table['previous_address']['gov_utility_bill'],true);
         }
         for ($i = 0; $i < $previous_address; $i++) { ?>
            <div class="pg-frm">
               <div class="pg-txt">
                  <div class="pg-lft">Previous Address <?php echo $i+1; ?></div>
                  <div class="clr"></div>
               </div>
               <div class="full-bx">
                  <label>House/Flat No. <span>(Required)</span></label>
                  <input class="fld house-flat" value="<?php echo isset($flat_no[$i]['flat_no'])?$flat_no[$i]['flat_no']:''; ?>" onblur="check_house_flat(<?php echo $i; ?>)" onkeyup="check_house_flat(<?php echo $i; ?>)" id="house-flat-<?php echo $i; ?>" type="text">
                  <div id="house-flat-error-<?php echo $i; ?>"></div>
               </div>

               <div class="full-bx">
                  <label>Street/Road <span>(Required)</span></label>
                  <input class="fld street" value="<?php echo isset($street[$i]['street'])?$street[$i]['street']:''; ?>" onblur="check_street(<?php echo $i; ?>)" onkeyup="check_street(<?php echo $i; ?>)" id="street-<?php echo $i; ?>" type="text">
                  <div id="street-error-<?php echo $i; ?>"></div>
               </div>

               <div class="full-bx">
                  <label>Area <span>(Required)</span></label>
                  <input class="fld area" value="<?php echo isset($area[$i]['area'])?$area[$i]['area']:''; ?>" onblur="check_area(<?php echo $i; ?>)" onkeyup="check_area(<?php echo $i; ?>)" id="area-<?php echo $i; ?>" type="text">
                  <div id="area-error-<?php echo $i; ?>"></div>
               </div>

               <div class="full-bx">
                  <label>Pin Code <span>(Required)</span></label>
                  <input class="fld pincode" value="<?php echo isset($pin_code[$i]['pin_code'])?$pin_code[$i]['pin_code']:''; ?>" onblur="check_pincode(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeyup="check_pincode(<?php echo $i; ?>)" id="pincode-<?php echo $i; ?>" type="text">
                  <div id="pincode-error-<?php echo $i; ?>"></div>
               </div>

               <div class="full-bx">
                  <label>Nearest Landmark</label>
                  <input class="fld land-mark" value="<?php echo isset($nearest_landmark[$i]['nearest_landmark'])?$nearest_landmark[$i]['nearest_landmark']:''; ?>" onblur="check_land_mark(<?php echo $i; ?>)" onkeyup="check_land_mark(<?php echo $i; ?>)" id="land-mark-<?php echo $i; ?>" type="text">
                  <div id="land-mark-error-<?php echo $i; ?>"></div>
               </div>

               <div class="full-bx">
                  <label>Country <span>(Required)</span></label>
                  <select class="fld country select2" onchange="check_country(<?php echo $i; ?>)" id="country-<?php echo $i; ?>">
                     <option selected value=''>Select Country</option>
                     <?php
                     $get_country = isset($countries[$i]['country'])?$countries[$i]['country']:'India';
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
                   <div id="country-error-<?php echo $i; ?>"></div>
               </div>

               <div class="full-bx">
                  <label>State <span>(Required)</span></label>
                  <?php
                   if ($c_id !='') {
                        $state = $this->candidateModel->get_all_states($c_id);  
                      }
                   ?>
                  <select class="fld state select2" onchange="check_state(<?php echo $i; ?>)"  id="state-<?php echo $i; ?>" >
                     <option selected value=''>Select State</option>
                     <?php $get_state = isset($states[$i]['state'])?$states[$i]['state']:'Karnataka';
                     $get = isset($states[$i]['state'])?$states[$i]['state']:'';
                     $city_id = '';
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
                  <div id="state-error-<?php echo $i; ?>"></div>
               </div>

               <div class="full-bx">
                  <label>City/Town <span>(Required)</span></label>
                  <select class="fld city select2" onchange="check_city(<?php echo $i; ?>)" id="city-<?php echo $i; ?>" >
                     <option selected value=''>Select City/Town</option>
                     <?php $get_city = isset($city[$i]['city'])?$city[$i]['city']:'';
                     $cities = $this->candidateModel->get_all_cities($city_id);
                     foreach ($cities as $key2 => $val) {
                        if ($get_city == $val['name']) { 
                           echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                        } else {
                           echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                        }
                     } ?>
                  </select> 
                  <div id="city-error-<?php echo $i; ?>">&nbsp;</div>
               </div>

               <div class="full-bx">
                  <label>Duration of Stay <span>(Required)</span></label>
                  <label>From</label>
                  <?php
                     $exploded_from_date = isset($duration_of_stay_start[$i]['duration_of_stay_start'])?explode('-',$duration_of_stay_start[$i]['duration_of_stay_start']): '';
                  ?>
                  <div class="row">
                     <div class="col-md-6 w-50">
                        <label>Month</label>
                        <select class="fld select2 duration-of-stay-from-month" id="duration-of-stay-from-month-<?php echo $i; ?>" onchange="check_duration_of_stay_from_month(<?php echo $i; ?>)">
                           <option selected value=''>Select Month</option>
                           <?php
                           $months = $this->config->item('month_names');
                           $num = 0;
                           for ($j = 1; $j < $this->config->item('duration_of_stay_end_month'); $j++) {
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
                  <div class="full-bx mt-3">
                  <label>To</label>
                  <?php
                     $exploded_to_date = isset($duration_of_stay_end[$i]['duration_of_stay_end'])?explode('-',$duration_of_stay_end[$i]['duration_of_stay_end']):'';
                  ?>
                  <div class="row">
                     <div class="col-md-6 w-50">
                        <label>Month</label>
                        <select class="fld select2 duration-of-stay-to-month" id="duration-of-stay-to-month-<?php echo $i; ?>" onchange="check_duration_of_stay_to_month(<?php echo $i; ?>)">
                           <option selected value=''>Select Month</option>
                           <?php 
                           $num = 0;
                           for ($j = 1; $j < $this->config->item('duration_of_stay_end_month'); $j++) {
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
                  <div class="custom-control custom-checkbox custom-control-inline mrg-btm d-none">
                     <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck2">
                     <label class="custom-control-label pt-1" for="customCheck2">Present</label>
                  </div>
               </div>

               <div class="full-bx">
                  <label>Contact Person</label>
                  <label>Name <span>(Required)</span></label>
                  <input class="fld contact-person-name" id="contact-person-name-<?php echo $i; ?>" value="<?php echo isset($contact_person_name[$i]['contact_person_name'])?$contact_person_name[$i]['contact_person_name']:''; ?>" onblur="check_contact_person_name(<?php echo $i; ?>)" onkeyup="check_contact_person_name(<?php echo $i; ?>)" type="text">
                  <div id="contact-person-name-error-<?php echo $i; ?>"></div>
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
                  if (isset($relationship[$i]['contact_person_relationship'])) {
                     if ($relationship[$i]['contact_person_relationship']=='Self') {
                        $Self = 'selected';
                     } else if ($relationship[$i]['contact_person_relationship']=='Parent') {
                        $Parent = 'selected';
                     } else if ($relationship[$i]['contact_person_relationship']=='Spouse') {
                        $Spouse = 'selected';
                     } else if ($relationship[$i]['contact_person_relationship']=='Friend') {
                        $Friend = 'selected';
                     } else if ($relationship[$i]['contact_person_relationship']=='Relative') {
                        $Relative = 'selected';
                     } else if ($relationship[$i]['contact_person_relationship']=='Neighbor') {
                        $Neighbor = 'selected';
                     } else if ($relationship[$i]['contact_person_relationship']=='Security Guard') {
                        $Security_Guard = 'selected';
                     } else if ($relationship[$i]['contact_person_relationship']=='Landlord') {
                        $Landlord = 'selected';
                     } else if ($relationship[$i]['contact_person_relationship']=='House Owner') {
                        $House_Owner = 'selected';
                     } else if ($relationship[$i]['contact_person_relationship']=='Cousin') {
                        $Cousin = 'selected';
                     }
                  } ?>
                  <select class="fld relationship" onchange="check_relationship(<?php echo $i; ?>)" id="relationship-<?php echo $i; ?>" >
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
                  <div id="relationship-error-<?php echo $i; ?>"></div>
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
                     <select class="fld code" id="contact-person-contact-code-<?php echo $i; ?>">
                        <?php $codes = isset($codes[$i]['code'])?$codes[$i]['code']:'';
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
                     <input class="fld contact-no" id="contact-person-contact-no-<?php echo $i; ?>" value="<?php echo isset($contact_person_mobile_number[$i]['contact_person_mobile_number'])?$contact_person_mobile_number[$i]['contact_person_mobile_number']:''; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onblur="check_contact_person_contact_no(<?php echo $i; ?>)" onkeyup="check_contact_person_contact_no(<?php echo $i; ?>)" type="text">
                     <div id="contact-person-contact-no-error-<?php echo $i; ?>"></div>
                  </div>
                  <div class="clr"></div>
               </div>
            </div>
         <?php } ?>
      </div>
      <div id="save-data-error-msg"></div>
      <button id="save-details-btn" class="pg-nxt-btn">Save &amp; Continue</button>
   </div>
</div>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/mobile/previous-address-1.js" ></script>