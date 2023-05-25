<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-previous-address';
   }
</script> 
   <div class="container-fluid content-bg-color">
      <div class="content-div">
         <div class="row"></div>
         <input name="" class="fld form-control" value="<?php echo isset($table['previous_address']['previos_address_id'])?$table['previous_address']['previos_address_id']:''; ?>" id="previos_address_id" type="hidden">
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

         <div class="row content-div-content-row-1">
            <div class="col-12"><span class="input-main-hdr">Previous Address <?php echo $i+1; ?></span></div> 
            <div class="col-12"><span class="input-main-hdr">House/Flat No. *</span></div> 
         </div>
         <div class="row content-div-content-row">
            
            <div class="col-12">
               <div class="input-wrap">
                      <input type="text" class="sign-in-input-field permenent-house-flat" value="<?php echo isset($flat_no[$i]['flat_no'])?$flat_no[$i]['flat_no']:''; ?>"   onblur="valid_house_flat(<?php echo $i; ?>)" onkeyup="valid_house_flat(<?php echo $i; ?>)" id="permenent-house-flat<?php echo $i; ?>" type="text">
                  
                     <span class="input-field-txt">House/Flat No</span>
                      <div id="permenent-house-flat-error<?php echo $i; ?>"></div> 
                  </div>
            </div>
             
         </div>
         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">Street/Road *</span></div>
         </div>
         <div class="row content-div-content-row">
            <div class="col-12">
               <div class="input-wrap">
                      <input name="" class="sign-in-input-field permenent-street" value="<?php echo isset($street[$i]['street'])?$street[$i]['street']:''; ?>" onblur="valid_street(<?php echo $i; ?>)" onkeyup="valid_street(<?php echo $i; ?>)" id="permenent-street<?php echo $i; ?>" type="text" required>
                      <span class="input-field-txt">Street/Road </span>
                      <div id="permenent-street-error<?php echo $i; ?>"></div> 
                  </div>
            </div>
         </div>
         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">Area *</span></div>
         </div>
         <div class="row content-div-content-row">
            <div class="col-12">
               <div class="input-wrap">
                      <input type="text" class="sign-in-input-field permenent-area" value="<?php echo isset($area[$i]['area'])?$area[$i]['area']:''; ?>"  onblur="valid_area(<?php echo $i; ?>)" onkeyup="valid_area(<?php echo $i; ?>)" id="permenent-area<?php echo $i; ?>" type="text" required>
                      <span class="input-field-txt">Area</span>
                      <div id="permenent-area-error<?php echo $i; ?>"></div> 
                  </div>
            </div>
         </div>
         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">Pin Code  *</span></div>
         </div>
         <div class="row content-div-content-row">
            <div class="col-12">
               <div class="input-wrap">
                      <input type="text" class="sign-in-input-field permenent-pincode"value="<?php echo isset($pin_code[$i]['pin_code'])?$pin_code[$i]['pin_code']:''; ?>"  onblur="valid_pincode(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeyup="valid_pincode(<?php echo $i; ?>)"  id="permenent-pincode<?php echo $i; ?>" type="text" required>
                      <span class="input-field-txt">Pin Code</span>
                      <div id="permenent-pincode-error<?php echo $i; ?>"></div>
                  </div>
            </div>
         </div>
         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">Nearest Landmark *</span></div>
         </div>
         <div class="row content-div-content-row">
            <div class="col-12">
               <div class="input-wrap">
                      <input type="text" class="sign-in-input-field permenent-land-mark" value="<?php echo isset($nearest_landmark[$i]['nearest_landmark'])?$nearest_landmark[$i]['nearest_landmark']:''; ?>" onblur="valid_land_mark(<?php echo $i; ?>)" onkeyup="valid_land_mark(<?php echo $i; ?>)"  id="permenent-land-mark<?php echo $i; ?>" type="text" required>
                      <span class="input-field-txt">Nearest Landmark</span>
                      <div id="permenent-land-mark-error<?php echo $i; ?>"></div>
                  </div>
            </div>
         </div>
         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">Country*</span></div>
         </div>
         <div class="row content-div-content-row">
            <div class="col-12">
               <div class="input-wrap"> 
                  <select class="sign-in-input-field country" onchange="valid_countries(<?php echo $i; ?>)" id="country<?php echo $i; ?>" required>
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
                      <span class="input-field-txt">Country</span>
                      <div id="country-error<?php echo $i; ?>"></div>
                  </div>
            </div>
         </div>
           
         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">State *</span></div>
         </div>
         <div class="row content-div-content-row">
            <div class="col-12">
               <div class="input-wrap">
                 <?php
                   if ($c_id !='') {
                        $state = $this->candidateModel->get_all_states($c_id);  
                      }
                   ?>
                  <select class="sign-in-input-field state" onchange="valid_state(<?php echo $i; ?>)"  id="state<?php echo $i; ?>" required>
                     <option selected value=''>Select State</option>
                     <?php $get_state = isset($states[$i]['state'])?$states[$i]['state']:'';
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
                      <span class="input-field-txt">State</span>
                     <div id="state-error<?php echo $i; ?>"></div> 
                  </div>
            </div>
         </div>

         <!--  -->
         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">City/Town *</span></div>
         </div>
         <div class="row content-div-content-row">
            <div class="col-12">
               <div class="input-wrap">
                      <select class="sign-in-input-field permenent-city" onchange="valid_city(<?php echo $i; ?>)" id="permenent-city<?php echo $i; ?>" required>
                     <option selected value=''>Select City/Town</option>
                     <?php $get_city = isset($city[$i]['city'])?$city[$i]['city']:'';
                      if ($get_city !='') { 
                     $cities = $this->candidateModel->get_all_cities($city_id);
                     foreach ($cities as $key2 => $val) {
                        if ($get_city == $val['name']) { 
                           echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                        } else {
                           echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                        }}
                     } ?>
                  </select> 
                      <span class="input-field-txt">City/Town</span>
                     <div id="permenent-city-error<?php echo $i; ?>"></div> 
                  </div>
            </div>
         </div>
         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">Duration of Stay *</span></div> 
            <?php $exploded_from_date = explode('-', isset($duration_of_stay_start[$i]['duration_of_stay_start'])?$duration_of_stay_start[$i]['duration_of_stay_start']:'');
               $exploded_end_date = explode('-', isset($duration_of_stay_end[$i]['duration_of_stay_end'])?$duration_of_stay_end[$i]['duration_of_stay_end']:'');
            ?>
         </div>
         <div class="row content-div-content-row">
            <div class="col-6">
               <div class="input-wrap">
                      <select class="sign-in-input-field duration-of-stay-from-month" id="duration-of-stay-from-month" required>
                           <option selected value=''>Select Month</option>
                           <?php
                           $months = $this->config->item('month_names');
                           $num = 0;
                           for ($j = 1; $j < $this->config->item('duration_of_stay_end_month'); $j++) {
                              $selected = '';
                              if ($exploded_from_date != '') {
                                 $from_date = isset($exploded_from_date[1]) ? $exploded_from_date[1] : '';
                                 if ($from_date == $j) {
                                    $selected = 'selected';
                                 }
                              }
                           ?>
                              <option <?php echo $selected;?> value="<?php echo $j;?>"><?php echo $months[$num];?></option>
                           <?php $num++; } ?>
                        </select> 
                      <span class="input-field-txt">Select Month</span>
                     <div id="duration-of-stay-from-month-error"></div> 
                  </div>
            </div>
            <div class="col-6">
               <div class="input-wrap">
                  <select class="sign-in-input-field duration-of-stay-from-year" id="duration-of-stay-from-year" required>
                           <option selected value=''>Select year</option>
                           <?php 
                           for($j = $this->config->item('current_year'); $j >= $this->config->item('duration_of_stay_start_year'); $j--) {
                              $selected = '';
                              if ($exploded_from_date != '') {
                                 $from_year = isset($exploded_from_date[0]) ? $exploded_from_date[0] : '';
                                 if ($from_year == $j) {
                                    $selected = 'selected';
                                 }
                              }
                           ?>
                              <option <?php echo $selected;?> value="<?php echo $j;?>"><?php echo $j;?></option>
                           <?php } ?>
                        </select> 
                  <span class="input-field-txt">Year</span>
                  <div id="duration-of-stay-from-year-error"></div>
               </div>
            </div>

         </div>
         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">To *</span></div>
         </div>
         <div class="row content-div-content-row">
            <div class="col-6">
               <div class="input-wrap">
                      <select class="sign-in-input-field duration-of-stay-end-month" id="duration-of-stay-end-month" required>
                           <option selected value=''>Select Month</option>
                           <?php 
                           $num = 0;
                           for ($j = 1; $j < $this->config->item('duration_of_stay_end_month'); $j++) {
                              $selected = '';
                              if ($exploded_end_date != '') {
                                 $to_month = isset($exploded_end_date[1]) ? $exploded_end_date[1] : '';
                                 if ($to_month == $j) {
                                    $selected = 'selected';
                                 }
                              }
                           ?>
                              <option <?php echo $selected;?> value="<?php echo $j;?>"><?php echo $months[$num];?></option>
                           <?php $num++; } ?>
                        </select> 
                      <span class="input-field-txt">Month</span>
                  <div id="duration-of-stay-end-month-error"></div> 
                  </div>
            </div>

            <div class="col-6">
               <div class="input-wrap">
                      <select class="sign-in-input-field duration-of-stay-end-year" id="duration-of-stay-end-year" required>
                           <option selected value=''>Select year</option>
                           <?php for($j = $this->config->item('current_year'); $j >= $this->config->item('duration_of_stay_start_year'); $j--) {
                              $selected = '';
                              if ($exploded_end_date != '') {
                                 $to_year = isset($exploded_end_date[0]) ? $exploded_end_date[0] : '';
                                 if ($to_year == $j) {
                                    $selected = 'selected';
                                 }
                              }
                           ?>
                              <option <?php echo $selected;?> value="<?php echo $j;?>"><?php echo $j;?></option>
                           <?php } ?>
                        </select> 
                      <span class="input-field-txt">Year</span>
                     <div id="duration-of-stay-end-year-error"></div>
                  </div>
            </div>

         </div>
         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">Contact Person Name *</span></div>
         </div>
         <div class="row content-div-content-row">
            <div class="col-12">
               <div class="input-wrap">
                      <input name="" class="sign-in-input-field permenent-name" iid="permenent-name<?php echo $i; ?>" value="<?php echo isset($contact_person_name[$i]['contact_person_name'])?$contact_person_name[$i]['contact_person_name']:''; ?>" onblur="valid_name(<?php echo $i; ?>)" onkeyup="valid_name(<?php echo $i; ?>)" type="text" required>
                      <span class="input-field-txt">Enter Contact Person Name</span>
                     <div id="permenent-name-error<?php echo $i; ?>"></div> 
                  </div>
            </div>
         </div>
         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">Relationship *</span></div>
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
         </div>
         <div class="row content-div-content-row">
            <div class="col-12">
               <div class="input-wrap">
                      <select name="" class="sign-in-input-field relationship" onblur="valid_relationship(<?php echo $i; ?>)" onchange="valid_relationship(<?php echo $i; ?>)" id="relationship<?php echo $i; ?>" required>
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
                      <span class="input-field-txt">Select Relationship</span>
                  <div id="relationship-error<?php echo $i; ?>"></div> 
                  </div>
            </div>
         </div>

         <div class="row content-div-content-row-2">
            <!-- <div class="col-3"><span class="input-main-hdr">Country Code *</span></div> -->
            <div class="col-12"><span class="input-main-hdr">Mobile Number *</span></div>
         </div>
         <div class="row content-div-content-row">
            <div class="col-3">
               <div class="input-wrap">
                      <select class="sign-in-input-field code" id="code" required>
                        <?php $codes = isset($codes[$i]['code'])?$codes[$i]['code']:'';
                        foreach ($code['countries'] as $key => $value) {
                           if ($codes==$value['code']) {
                              echo "<option selected >{$value['code']}</option>";
                           } else {
                              echo "<option>{$value['code']}</option>";
                           }
                        } ?>
                     </select>
                      <span class="input-field-txt">Country Code</span> 
                  </div>
            </div>
            <div class="col-9">
               <div class="input-wrap">
                      <input name="" class="sign-in-input-field permenent-contact_no" iid="permenent-contact_no<?php echo $i; ?>" value="<?php echo isset($contact_person_mobile_number[$i]['contact_person_mobile_number'])?$contact_person_mobile_number[$i]['contact_person_mobile_number']:''; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  onblur="valid_contact_no(<?php echo $i; ?>)" onkeyup="valid_contact_no(<?php echo $i; ?>)" type="text" required>
                      <span class="input-field-txt">Mobile Number</span> 
                     <div id="permenent-contact_no-error<?php echo $i; ?>"></div>
                  </div>
            </div>
         </div>
         
         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">Rental Agreement/ Driving License</span></div>
         </div>
         <div class="row content-div-content-row">
            <div class="col-12">
                  <div class="row">
                     <div class="col-8">
                         <!-- id="rental_agreement-img<?php echo $i; ?>" -->
                        <span class="custom-file-name file-name" id="rental_agreement-error<?php echo $i; ?>">
                           <?php $rental = '';
                           if (isset($rental_agreement[$i])) {
                              if (!in_array('no-file', $rental_agreement[$i])) {
                                 foreach ($rental_agreement[$i] as $key => $value) {
                                    if ($value !='') {
                                       echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"rental-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                    }
                                 }
                                 $rental = $rental_agreement[$i];
                              }
                           } ?>
                        </span>
                        <input type="hidden" class="rental" value="<?php echo json_encode($rental); ?>">
                     </div>
                     <div class="col-4 custom-file-input-btn-div">
                        <div class="custom-file-input">
                           <input type="file" accept="image/*,application/pdf" id="rental_agreement<?php echo $i; ?>" name="rental_agreement<?php echo $i; ?>" class="input-file w-100 rental_agreement"  multiple>
                        <button class="btn btn-file-upload" for="rental_agreement<?php echo $i; ?>">
                           <img src="assets/images/paper-clip.png">
                        Upload
                        </button>
                     </div>
                     <div class="col-12">
                        <div ></div>
                     </div>
                  </div>
                </div>
            </div>
         </div>

         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">Upload Ration Card/ Aadhar Card</span></div>
         </div>
         <div class="row content-div-content-row">
            <div class="col-12">
                  <div class="row">
                     <div class="col-8">
                         <!-- id="ration_card-img<?php echo $i; ?>" -->
                        <span class="custom-file-name file-name" id="ration_card-error<?php echo $i; ?>">
                           <?php $ration = '';
                           if (isset($ration_card[$i])) {
                              if (!in_array('no-file', $ration_card[$i])) {
                                 foreach ($ration_card[$i] as $key => $value) { 
                                    if ($value !='') {
                                       echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"ration-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                    }
                                 }
                                 $ration = $ration_card[$i];
                              }
                           } ?>
                        </span>
                        <input type="hidden" class="ration" value="<?php echo json_encode($ration); ?>">
                     </div>
                     <div class="col-4 custom-file-input-btn-div">
                        <div class="custom-file-input">
                           <input type="file" accept="image/*,application/pdf" id="ration_card<?php echo $i; ?>" name="ration_card<?php echo $i; ?>" class="input-file w-100 ration_card"  multiple>
                        <button class="btn btn-file-upload" for="ration_card<?php echo $i; ?>">
                           <img src="assets/images/paper-clip.png">
                        Upload
                        </button>
                     </div>
                     <div class="col-12">
                        <div ></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="row content-div-content-row-2">
            <div class="col-12"><span class="input-main-hdr">Upload Government Utility Bill</span></div>
         </div>
         <div class="row content-div-content-row">
            <div class="col-12">
                  <div class="row">
                     <div class="col-8">
                         <!-- id="gov_utility_bill-img<?php echo $i; ?>" -->
                        <span class="custom-file-name file-name" id="gov_utility_bill-img<?php echo $i; ?>">
                           <?php $gov_utility = '';
                           if (isset($gov_utility_bill[$i])) {
                              if (!in_array('no-file',$gov_utility_bill[$i])) {
                                 foreach ($gov_utility_bill[$i] as $key => $value) { 
                                    if ($value !='') {
                                       echo "<div><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"gov-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                    }
                                 }
                                 $gov_utility = $gov_utility_bill[$i];
                              }
                           } ?>
                        </span>
                        <input type="hidden" class="gov_utility" value="<?php echo json_encode($gov_utility); ?>">
                     </div>
                     <div class="col-4 custom-file-input-btn-div">
                         <div class="custom-file-input">
                           <input type="file" accept="image/*,application/pdf" id="gov_utility_bill<?php echo $i; ?>" name="gov_utility_bill<?php echo $i; ?>" class="input-file w-100"  multiple>
                        <button class="btn btn-file-upload" for="gov_utility_bill<?php echo $i; ?>">
                           <img src="assets/images/paper-clip.png">
                        Upload
                        </button>
                     </div>
                     <div class="col-12">
                        <div ></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

   <?php } ?>
         
         <div class="row">
            <!-- disabled -->
            <div class="col-12">
               <button class="save-btn" id="add_address">
                  Save & Continue
               </button>
            </div>
         </div>
      </div>
   </div>
<div class="modal fade view-document-modal" id="myModal-show" role="dialog">
   <div class="modal-dialog modal-md modal-dialog-centered">
      <!-- modal-content-view-collection-category -->
      <div class="modal-content">
         <div class="modal-header border-0">
            <h3 id="">View Document</h4>
         </div>
         <div class="modal-body modal-body-edit-coupon">
            <div class="row"> 
               <div class="col-md-12 text-center view-img" id="view-img"></div>
            </div>
            <div class="row mt-3">
               <div class="col-md-6" id="setupDownloadBtn"></div>
               <div id="view-edit-cancel-btn-div" class="col-md-6 text-right">
                  <button class="btn btn-close-modal" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
   <script>
      var states = <?php echo json_encode($state); ?>;
      var candidate_info = <?php echo json_encode($user); ?>;
   </script>
   <script src="<?php echo base_url(); ?>assets/custom-js/candidate/previous-address.js" ></script>