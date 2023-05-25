<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-previous-address-1';
   }
</script>
<?php 
$months = array(
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July ',
    'August',
    'September',
    'October',
    'November',
    'December',
);
?>
   <!--Page Content-->
   <!-- <form> -->
   <div class="pg-cnt pt-3">
      <div class="pg-txt-cntr">
         <div class="pg-steps">Step <?php echo array_search('12',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         

        <!--  -->
        <div id="new_address">
                  <input name="" class="fld form-control" value="<?php echo isset($table['previous_address']['previos_address_id'])?$table['previous_address']['previos_address_id']:''; ?>" id="previos_address_id" type="hidden">
         <?php 
          $form_values = json_decode($user['form_values'],true);
             $form_values = json_decode($form_values,true);
             // echo $form_values['reference'][0];
             // echo $form_values['previous_address'][0];
             // echo json_encode($form_values['drug_test']);
             // echo $user['form_values'];
             $previous_address = 1;
            if (isset($form_values['previous_address'][0])?$form_values['previous_address'][0]:0 > 0) {
               $previous_address = $form_values['previous_address'][0];
             } 
             // echo $refrence;
             $j =1;

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

            for ($i=0; $i < $previous_address; $i++) { 


                  ?>
            <h6 class="full-nam2"><?php echo $j; ?>. Previous Address</h6>
            <div id="form<?php echo $i; ?>">
            <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">

                  <label>House/Flat No.</label>
                  <input name="" class="fld form-control permenent-house-flat" value="<?php echo isset($flat_no[$i]['flat_no'])?$flat_no[$i]['flat_no']:''; ?>"   onblur="valid_house_flat(<?php echo $i; ?>)" onkeyup="valid_house_flat(<?php echo $i; ?>)" id="permenent-house-flat<?php echo $i; ?>" type="text">
                  <div id="permenent-house-flat-error<?php echo $i; ?>"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Street/Road</label>
                  <input name="" class="fld form-control permenent-street" value="<?php echo isset($street[$i]['street'])?$street[$i]['street']:''; ?>" onblur="valid_street(<?php echo $i; ?>)" onkeyup="valid_street(<?php echo $i; ?>)" id="permenent-street<?php echo $i; ?>" type="text">
                  <div id="permenent-street-error<?php echo $i; ?>"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Area</label>
                  <input name="" class="fld form-control permenent-area" value="<?php echo isset($area[$i]['area'])?$area[$i]['area']:''; ?>"  onblur="valid_area(<?php echo $i; ?>)" onkeyup="valid_area(<?php echo $i; ?>)" id="permenent-area<?php echo $i; ?>" type="text">
                  <div id="permenent-area-error<?php echo $i; ?>"></div>
               </div>
            </div>
         </div>
         <div class="row">
          <!--   <div class="col-md-4">
               <div class="pg-frm">
                  <label>City/Town</label>
                  <input name="" class="fld form-control permenent-city" value="<?php echo isset($city[$i]['city'])?$city[$i]['city']:''; ?>"  onblur="valid_city(<?php echo $i; ?>)" onkeyup="valid_city(<?php echo $i; ?>)"  id="permenent-city<?php echo $i; ?>" type="text">
                  <div id="permenent-city-error<?php echo $i; ?>"></div>
               </div>
            </div> -->
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Pin Code</label>
                  <input name="" class="fld form-control permenent-pincode" value="<?php echo isset($pin_code[$i]['pin_code'])?$pin_code[$i]['pin_code']:''; ?>"  onblur="valid_pincode(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeyup="valid_pincode(<?php echo $i; ?>)"  id="permenent-pincode<?php echo $i; ?>" type="text">
                  <div id="permenent-pincode-error<?php echo $i; ?>"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Nearest Landmark</label>
                  <input name="" class="fld form-control permenent-land-mark" value="<?php echo isset($nearest_landmark[$i]['nearest_landmark'])?$nearest_landmark[$i]['nearest_landmark']:''; ?>" onblur="valid_land_mark(<?php echo $i; ?>)" onkeyup="valid_land_mark(<?php echo $i; ?>)"  id="permenent-land-mark<?php echo $i; ?>" type="text">
                  <div id="permenent-land-mark-error<?php echo $i; ?>"></div>
               </div>
            </div>
 
            <div class="col-md-4">
               <div class="pg-frm">
               <label>Country</label> 
                   <select class="fld form-control country" onchange="valid_countries(<?php echo $i; ?>)" id="country<?php echo $i; ?>" >
                     <option selected value=''>Select Country</option>
                      <?php
                      $get_country = isset($countries[$i]['country'])?$countries[$i]['country']:'India';
                      $c_id = '';
                      foreach ($country as $key1 => $val) {
                         if ($get_country == $val['name']) {
                          $c_id = $val['id'];
                            echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         }else{
                            echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         }
                      }
                         
                       ?>
                   </select> 
                   <div id="country-error<?php echo $i; ?>">&nbsp;</div>
            </div>
            </div>


              <div class="col-md-4">
                <div class="pg-frm">
                   <label>State</label>
                   <?php
                   if ($c_id !='') {
                        $state = $this->candidateModel->get_all_states($c_id);  
                      }
                   ?>
                   <select class="fld form-control state" onchange="valid_state(<?php echo $i; ?>)"  id="state<?php echo $i; ?>" >
                     <option selected value=''>Select State</option>
                      <?php 
                      $get_state = isset($states[$i]['state'])?$states[$i]['state']:'Karnataka';
                      $get = isset($states[$i]['state'])?$states[$i]['state']:'';
                      $city_id = '';
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
                   <div id="state-error<?php echo $i; ?>">&nbsp;</div>
                </div>
             </div>
              <div class="col-md-4">
                <div class="pg-frm">
                   <label>City/Town</label>
                   <!-- <input name="" class="fld form-control city" value="<?php echo isset($city[$i]['city'])?$city[$i]['city']:''; ?>"  onkeyup="valid_city(<?php echo $i; ?>)" id="city<?php echo $i; ?>" type="text"> -->
                    <select class="fld form-control permenent-city" onchange="valid_city(<?php echo $i; ?>)" id="permenent-city<?php echo $i; ?>" >
                     <option selected value=''>Select City/Town</option>
                      <?php 
                      $get_city = isset($city[$i]['city'])?$city[$i]['city']:'';
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
                   <div id="permenent-city-error<?php echo $i; ?>">&nbsp;</div>
                </div>
             </div>
             




         </div> 
          <div class="pg-frm-hd">Duration of Stay</div>
         <?php $exploded_from_date = explode('-', isset($duration_of_stay_start[$i]['duration_of_stay_start'])?$duration_of_stay_start[$i]['duration_of_stay_start']:''); 
         ?>
         <div class="row">
            <div class="col-md-3">
               <!--  <div>&nbsp;</div>
                <input name="" class="fld form-control date-for-candidate-aggreement-start-date" id="start-date" value="<?php echo isset($table['present_address']['duration_of_stay_start'])?$table['present_address']['duration_of_stay_start']:''; ?>" type="text"> -->
                <div class="row">
               <div class="col-md-6 w-50">
                  <label>Month</label>
                  <select class="fld select2 duration-of-stay-from-month" id="duration-of-stay-from-month">
                     <option selected value=''>Select Month</option>
                     <?php
                        $num = 0;
                      for ($a = 1; $a < $this->config->item('duration_of_stay_end_month'); $a++) {
                        $selected = '';
                        if ($exploded_from_date[1] == $a) {
                           $selected = 'selected';
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $a;?>"><?php echo $months[$num];?></option>
                     <?php
                        $num++;
                      } ?>
                  </select> 
                  <div id="duration-of-stay-from-month-error"></div>
               </div>
                <div class="col-md-6 w-50">
                  <label>Year</label>
                  <select class="fld select2 duration-of-stay-from-year" id="duration-of-stay-from-year">
                     <option selected value=''>Select year</option>
                     <?php 
                      for($a = $this->config->item('current_year'); $a >= $this->config->item('duration_of_stay_start_year'); $a--){
                        $selected = '';
                        if ($exploded_from_date[0] == $a) {
                           $selected = 'selected';
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $a;?>"><?php echo $a;?></option>
                     <?php } ?>
                  </select> 
                  <div id="duration-of-stay-from-year-error"></div>
               </div>
            </div>
                <div id="start-date-error">&nbsp;</div>
            </div> 
            <h6 class="To">TO</h6>
           <div class="col-md-4">
            <?php $exploded_end_date = explode('-', isset($duration_of_stay_end[$i]['duration_of_stay_end'])?$duration_of_stay_end[$i]['duration_of_stay_end']:''); ?>
            <!-- <div>&nbsp;</div>
             <input name="" class="fld form-control date-for-candidate-aggreement-end-date" id="end-date" value="<?php echo isset($table['present_address']['duration_of_stay_end'])?$table['present_address']['duration_of_stay_end']:''; ?>" type="text">  -->
              <div class="row">
               <div class="col-md-6 w-50">
                  <label>Month</label>
                  <select class="fld select2 duration-of-stay-end-month" id="duration-of-stay-end-month">
                     <option selected value=''>Select Month</option>
                     <?php
                        $num = 0;
                      for ($a = 1; $a < $this->config->item('duration_of_stay_end_month'); $a++) {
                        $selected = '';
                        if ($exploded_end_date[1] == $a) {
                           $selected = 'selected';
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $a;?>"><?php echo $months[$num];?></option>
                     <?php 
                        $num++;
                  } ?>
                  </select> 
                  <div id="duration-of-stay-end-month-error"></div>
               </div>
                <div class="col-md-6 w-50">
                  <label>Year</label>
                  <select class="fld select2 duration-of-stay-end-year" id="duration-of-stay-end-year">
                     <option selected value=''>Select year</option>
                     <?php 
                     for($a = $this->config->item('current_year'); $a >= $this->config->item('duration_of_stay_start_year'); $a--){
                        $selected = '';
                        if ($exploded_end_date[0] == $a) {
                           $selected = 'selected';
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $a;?>"><?php echo $a;?></option>
                     <?php } ?>
                  </select> 
                  <div id="duration-of-stay-end-year-error"></div>
               </div>
            </div>
             <div id="end-date-error">&nbsp;</div>
         </div>
         </div>
         <!-- <div class="row">
             <div class="col-md-3">
                <div>&nbsp;</div>
                <input name="" class="fld form-control end-date permenent-start-date date-for-candidate-aggreement-start-date" value="<?php echo isset($duration_of_stay_start[$i]['duration_of_stay_start'])?$duration_of_stay_start[$i]['duration_of_stay_start']:''; ?>" onblur="valid_start_date(<?php echo $i; ?>)" onchange="valid_start_date(<?php echo $i; ?>)" onkeyup="valid_start_date(<?php echo $i; ?>)"  id="permenent-start-date<?php echo $i; ?>" type="text">
            </div> 
            <h6 class="To">TO</h6>
           <div class="col-md-3">
            <div>&nbsp;</div>
             <input name="" class="fld form-control end-date permenent-end-date date-for-candidate-aggreement-end-date" value="<?php echo isset($duration_of_stay_end[$i]['duration_of_stay_end'])?$duration_of_stay_end[$i]['duration_of_stay_end']:''; ?>" onblur="valid_end_date(<?php echo $i; ?>)" onkeyup="valid_end_date(<?php echo $i; ?>)" onchange="valid_end_date(<?php echo $i; ?>)"  id="permenent-end-date<?php echo $i; ?>" type="text"> 
             <div id="permenent-end-date-error<?php echo $i; ?>"></div>
         </div>
         <div class="col-md-2 tp">
            <div class="custom-control custom-checkbox custom-control-inline mrg-btm d-none">
               <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck2">
               <label class="custom-control-label pt-1" for="customCheck2">Present</label>
            </div>
         </div>
         <div class="col-md-2 tp">
            
         </div>
         </div> -->
         <div class="pg-frm-hd">Contact Person</div>
         <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Name</label>
                  <input name="" class="fld permenent-name" id="permenent-name<?php echo $i; ?>" value="<?php echo isset($contact_person_name[$i]['contact_person_name'])?$contact_person_name[$i]['contact_person_name']:''; ?>" onblur="valid_name(<?php echo $i; ?>)" onkeyup="valid_name(<?php echo $i; ?>)" type="text">
                  <div id="permenent-name-error<?php echo $i; ?>"></div>
               </div>
            </div> 
             <div class="col-md-3">
               <div class="pg-frm">
                  <label>Relationship</label>
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
                    }else if ($relationship[$i]['contact_person_relationship']=='Parent') {
                       $Parent = 'selected';
                    }else if ($relationship[$i]['contact_person_relationship']=='Spouse') {
                       $Spouse = 'selected';
                    }else if ($relationship[$i]['contact_person_relationship']=='Friend') {
                       $Friend = 'selected';
                    }else if ($relationship[$i]['contact_person_relationship']=='Relative') {
                       $Relative = 'selected';
                    }else if ($relationship[$i]['contact_person_relationship']=='Neighbor') {
                       $Neighbor = 'selected';
                    }else if ($relationship[$i]['contact_person_relationship']=='Security Guard') {
                       $Security_Guard = 'selected';
                    }else if ($relationship[$i]['contact_person_relationship']=='Landlord') {
                       $Landlord = 'selected';
                    }else if ($relationship[$i]['contact_person_relationship']=='House Owner') {
                       $House_Owner = 'selected';
                    }else if ($relationship[$i]['contact_person_relationship']=='Cousin') {
                       $Cousin = 'selected';
                    }
                  }
                  ?>
                  <select name="" class="fld form-control relationship" onblur="valid_relationship(<?php echo $i; ?>)" onchange="valid_relationship(<?php echo $i; ?>)" id="relationship<?php echo $i; ?>" >
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
                  <div id="relationship-error<?php echo $i; ?>"></div>
               </div>
            </div>
             <div class="col-md-2">
                <div class="pg-frm">
               <label>Country Code</label>
              <select class="fld form-control code" id="code">
                <?php
                $codes = isset($codes[$i]['code'])?$codes[$i]['code']:'';
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
                  <label>Mobile Number</label>
                  <input name="" class="fld permenent-contact_no" id="permenent-contact_no<?php echo $i; ?>" value="<?php echo isset($contact_person_mobile_number[$i]['contact_person_mobile_number'])?$contact_person_mobile_number[$i]['contact_person_mobile_number']:''; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  onblur="valid_contact_no(<?php echo $i; ?>)" onkeyup="valid_contact_no(<?php echo $i; ?>)" type="text">
               </div>
            </div>
         </div>
         </div>

           <div class="row mt-3">
            <div class="col-md-3">
               <div class="pg-frm-hd">Rental Agreement/ Driving License</div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm-hd">Upload Ration Card/ Aadhar Card <span>(optional)</span></div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm-hd">Upload Government Utility Bill <span>(optional)</span></div>
            </div>
            <div class="col-md-3">
               
            </div>
         </div>
        <div class="row">

             <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="rental_agreement<?php echo $i; ?>"><a class="fl-btn ">Browse files</a></label>
                     <input id="rental_agreement<?php echo $i; ?>" type="file"  style="display:none;" class="form-control fl-btn-n rental_agreement" multiple >
                     <div id="rental_agreement-img<?php echo $i; ?>"><?php
                     $rental = '';
                       if (isset($rental_agreement[$i])) {
                       if (!in_array('no-file', $rental_agreement[$i])) {
                         foreach ($rental_agreement[$i] as $key => $value) {
                           if ($value !='') {
                            /* echo "<div id='rental{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"rental-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_rental_documents{$key}' onclick='removeFile_documents({$key},\"rental\")' data-path='rental-docs' data-field='rental_agreement' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";*/
                             echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"rental-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                           }
                         }
                         $rental = $rental_agreement[$i];
                       }}
                       ?></div>
                       <input type="hidden" class="rental" value="<?php echo json_encode($rental); ?>">
                  </div>
               </div>
               <div id="rental_agreement-error<?php echo $i; ?>">&nbsp;</div>
            </div>

            <!--  -->
            
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="ration_card<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                     <input id="ration_card<?php echo $i; ?>" type="file"  style="display:none;" class="form-control fl-btn-n ration_card" multiple >
                     <div id="ration_card-img<?php echo $i; ?>"><?php
                     $ration = '';
                       if (isset($ration_card[$i])) {
                       if (!in_array('no-file', $ration_card[$i])) {
                         foreach ($ration_card[$i] as $key => $value) { 
                           if ($value !='') {
                           /* echo "<div id='ration{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"ration-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_ration_documents{$key}' onclick='removeFile_documents({$key},\"ration\")' data-path='ration-docs' data-field='ration_card' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";*/

                            echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"ration-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                          }
                         }
                         $ration = $ration_card[$i];
                       }}
                       ?></div>
                       <input type="hidden" class="ration" value="<?php echo json_encode($ration); ?>">
                  </div>
               </div>
               <div id="ration_card-error<?php echo $i; ?>">&nbsp;</div>
            </div>


            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="gov_utility_bill<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                     <input id="gov_utility_bill<?php echo $i; ?>" type="file"  style="display:none;" class="form-control fl-btn-n gov_utility_bill" multiple >
                     <div id="gov_utility_bill-img<?php echo $i; ?>"><?php
                     $gov_utility = '';
                       if (isset($gov_utility_bill[$i])) {
                       if (!in_array('no-file',$gov_utility_bill[$i])) {
                         foreach ($gov_utility_bill[$i] as $key => $value) { 
                           if ($value !='') {
                         /*   echo "<div id='gov{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"gov-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_gov_documents{$key}' onclick='removeFile_documents({$key},\"gov\")' data-path='gov-docs' data-field='gov_utility_bill' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";*/

                            echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"gov-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                          }
                         }
                         $gov_utility = $gov_utility_bill[$i];
                       }}
                       ?></div> 
                        <input type="hidden" class="gov_utility" value="<?php echo json_encode($gov_utility); ?>">
                  </div>
               </div>
               <div id="gov_utility_bill-error<?php echo $i; ?>">&nbsp;</div>
            </div>


         </div>
         
         <hr>
         <?php
          $j++;
               }
            }else{

               for ($i=0; $i < $previous_address; $i++) { 
         ?>
          <h6 class="full-nam2"><?php echo $j; ?>. Previous Address</h6>
         <div id="form0">
         <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>House/Flat No.</label>
                  <input name="" class="fld form-control permenent-house-flat" id="permenent-house-flat<?php echo $i; ?>"  onblur="valid_house_flat(<?php echo $i; ?>)" onkeyup="valid_house_flat(<?php echo $i; ?>)" type="text">
                  <div id="permenent-house-flat-error<?php echo $i; ?>"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Street/Road</label>
                  <input name="" class="fld form-control permenent-street" onblur="valid_street(<?php echo $i; ?>)" onkeyup="valid_street(<?php echo $i; ?>)" id="permenent-street<?php echo $i; ?>" type="text">
                  <div id="permenent-street-error<?php echo $i; ?>"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Area</label>
                  <input name="" class="fld form-control permenent-area"  onblur="valid_area(<?php echo $i; ?>)" onkeyup="valid_area(<?php echo $i; ?>)" id="permenent-area<?php echo $i; ?>" type="text">
                  <div id="permenent-area-error<?php echo $i; ?>"></div>
               </div>
            </div>
         </div>


         <div class="row">
           <!--  <div class="col-md-4">
               <div class="pg-frm">
                  <label>City/Town</label>
                  <input name="" class="fld form-control permenent-city"  onblur="valid_city(<?php echo $i; ?>)" onkeyup="valid_city(<?php echo $i; ?>)"  id="permenent-city<?php echo $i; ?>" type="text">
                  <div id="permenent-city-error<?php echo $i; ?>"></div>
               </div>
            </div> -->
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Pin Code</label>
                  <input name="" class="fld form-control permenent-pincode"  onblur="valid_pincode(<?php echo $i; ?>)" onkeyup="valid_pincode(<?php echo $i; ?>)"  id="permenent-pincode<?php echo $i; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"  type="text">
                  <div id="permenent-pincode-error<?php echo $i; ?>"></div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Nearest Landmark</label>
                  <input name="" class="fld form-control permenent-land-mark" onblur="valid_land_mark(<?php echo $i; ?>)" onkeyup="valid_land_mark(<?php echo $i; ?>)"  id="permenent-land-mark<?php echo $i; ?>" type="text">
                  <div id="permenent-land-mark-error<?php echo $i; ?>"></div>
               </div>
            </div> 

             <div class="col-md-4">
               <div class="pg-frm">
               <label>Country</label> 
                   <select class="fld form-control country" onchange="valid_countries(<?php echo $i; ?>)" id="country<?php echo $i; ?>" >
                      <?php
                      $get_country = isset($countries[$i]['country'])?$countries[$i]['country']:'India';
                      $c_id = '';
                      foreach ($country as $key1 => $val) {
                         if ($get_country == $val['name']) {
                          $c_id = $val['id'];
                            echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         }else{
                            echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         }
                      }
                         
                       ?>
                   </select> 
                   <div id="country-error<?php echo $i; ?>">&nbsp;</div>
            </div>
            </div>

            

              <div class="col-md-4">
                <div class="pg-frm">
                   <label>State</label>
                   <?php
                   if ($c_id !='') {
                        $state = $this->candidateModel->get_all_states($c_id);  
                      }
                   ?>
                   <select class="fld form-control state" onchange="valid_state(<?php echo $i; ?>)"  id="state<?php echo $i; ?>" >
                      <?php 
                      $get_state = isset($states[$i]['state'])?$states[$i]['state']:'Gujarat';
                      $city_id = '';
                      foreach ($state as $key1 => $val) {
                         if ($get_state == $val['name']) {
                            $city_id = $val['id'];
                            echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         }else{
                            echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         }
                      }
                         
                       ?>
                   </select> 
                   <div id="state-error<?php echo $i; ?>">&nbsp;</div>
                </div>
             </div>
              <div class="col-md-4">
                <div class="pg-frm">
                   <label>City/Town</label>
                   <!-- <input name="" class="fld form-control city" value="<?php echo isset($city[$i]['city'])?$city[$i]['city']:''; ?>"  onkeyup="valid_city(<?php echo $i; ?>)" id="city<?php echo $i; ?>" type="text"> -->
                    <select class="fld form-control permenent-city" onchange="valid_city(<?php echo $i; ?>)" id="permenent-city<?php echo $i; ?>" >
                      <?php 
                      $get_city = isset($city[$i]['city'])?$city[$i]['city']:'';
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
                   <div id="permenent-city-error<?php echo $i; ?>">&nbsp;</div>
                </div>
             </div>
             

            <!--   <div class="col-md-4">
               <div class="pg-frm">
               <label>Country</label> 
                   <select class="fld form-control country" onchange="valid_countries(<?php echo $i; ?>)" id="country<?php echo $i; ?>" >
                      <?php
                      $get_country = isset($countries[$i]['country'])?$countries[$i]['country']:'India';
                      $c_id = '';
                      foreach ($country as $key1 => $val) {
                         if ($get_country == $val['name']) {
                          $c_id = $val['id'];
                            echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         }else{
                            echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         }
                      }
                         
                       ?>
                   </select> 
                   <div id="country-error<?php echo $i; ?>">&nbsp;</div>
            </div>
          </div>

              <div class="col-md-4">
                <div class="pg-frm">
                   <label>State</label>
                   <?php
                   if ($c_id !='') {
                        $state = $this->candidateModel->get_all_states($c_id);  
                      }
                   ?>
                   <select class="fld form-control state" onchange="valid_state(<?php echo $i; ?>)" onblur="valid_state(<?php echo $i; ?>)"  id="state<?php echo $i; ?>" >
                      <?php 
                      $get_state = isset($states[$i]['state'])?$states[$i]['state']:'';
                      foreach ($state as $key1 => $val) {
                         if ($get_state == $val['name']) {
                            echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         }else{
                            echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         }
                      }
                         
                       ?>
                   </select> 
                   <div id="state-error<?php echo $i; ?>">&nbsp;</div>
                </div>
             </div> -->

         </div>

          <div class="pg-frm-hd">Duration of Stay</div> 
         <div class="row">
            <div class="col-md-3">
               <!--  <div>&nbsp;</div>
                <input name="" class="fld form-control date-for-candidate-aggreement-start-date" id="start-date" value="<?php echo isset($table['present_address']['duration_of_stay_start'])?$table['present_address']['duration_of_stay_start']:''; ?>" type="text"> -->
                <div class="row">
               <div class="col-md-6 w-50">
                  <label>Month</label>
                  <select class="fld select2 duration-of-stay-from-month" id="duration-of-stay-from-month">
                     <option selected value=''>Select Month</option>
                     <?php
                     $num = 0;
                      for ($a = 1; $a < $this->config->item('duration_of_stay_end_month'); $a++) {
                        $selected = '';
                         
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $a;?>"><?php echo $months[$num];?></option>
                     <?php
                        $num++;
                      } ?>
                  </select> 
                  <div id="duration-of-stay-from-month-error"></div>
               </div>
                <div class="col-md-6 w-50">
                  <label>Year</label>
                  <select class="fld select2 duration-of-stay-from-year" id="duration-of-stay-from-year">
                     <option selected value=''>Select year</option>
                     <?php 
                     for ($a = $this->config->item('duration_of_stay_start_year'); $a <= $this->config->item('current_year'); $a++) {
                        $selected = '';
                        
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $a;?>"><?php echo $a;?></option>
                     <?php } ?>
                  </select> 
                  <div id="duration-of-stay-from-year-error"></div>
               </div>
            </div>
                <div id="start-date-error">&nbsp;</div>
            </div> 
            <h6 class="To">TO</h6>
           <div class="col-md-4">
            <?php $exploded_end_date = explode('-', isset($duration_of_stay_end['duration_of_stay_end'])?$duration_of_stay_end['duration_of_stay_end']:''); ?>
            <!-- <div>&nbsp;</div>
             <input name="" class="fld form-control date-for-candidate-aggreement-end-date" id="end-date" value="<?php echo isset($table['present_address']['duration_of_stay_end'])?$table['present_address']['duration_of_stay_end']:''; ?>" type="text">  -->
              <div class="row">
               <div class="col-md-6 w-50">
                  <label>Month</label>
                  <select class="fld select2 duration-of-stay-end-month" id="duration-of-stay-end-month">
                     <option selected value=''>Select Month</option>
                     <?php 
                     $num = 0;
                     for ($a = 1; $a < $this->config->item('duration_of_stay_end_month'); $a++) {
                        $selected = '';
                        if ($exploded_end_date[1] == $a) {
                           $selected = 'selected';
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $a;?>"><?php echo $months[$num];?></option>
                     <?php
                        $num++;
                      } ?>
                  </select> 
                  <div id="duration-of-stay-end-month-error"></div>
               </div>
                <div class="col-md-6 w-50">
                  <label>Year</label>
                  <select class="fld select2 duration-of-stay-end-year" id="duration-of-stay-end-year">
                     <option selected value=''>Select year</option>
                     <?php 
                     for ($a = $this->config->item('duration_of_stay_start_year'); $a <= $this->config->item('current_year'); $a++) {
                        $selected = '';
                        if ($exploded_end_date[0] == $a) {
                           $selected = 'selected';
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $a;?>"><?php echo $a;?></option>
                     <?php } ?>
                  </select> 
                  <div id="duration-of-stay-end-year-error"></div>
               </div>
            </div>
             <div id="end-date-error">&nbsp;</div>
         </div>
         </div>

         <!-- <div class="pg-frm-hd">Duration of Stay</div>
         <div class="row">
             <div class="col-md-3">
                <div>&nbsp;</div>
                <input name="" class="fld form-control end-date permenent-start-date date-for-candidate-aggreement-start-date" onblur="valid_start_date(<?php echo $i; ?>)" onkeyup="valid_start_date(<?php echo $i; ?>)" onchange="valid_start_date(<?php echo $i; ?>)"  id="permenent-start-date<?php echo $i; ?>" type="text"> 
             <div id="permenent-start-date-error<?php echo $i; ?>"></div>
            </div> 
            <h6 class="To">To</h6>
           <div class="col-md-3">
            <div>&nbsp;</div>
             <input name="" class="fld form-control end-date permenent-end-date date-for-candidate-aggreement-end-date" onblur="valid_end_date(<?php echo $i; ?>)" onchange="valid_end_date(<?php echo $i; ?>)" onkeyup="valid_end_date(<?php echo $i; ?>)"  id="permenent-end-date<?php echo $i; ?>" type="text"> 
             <div id="permenent-end-date-error<?php echo $i; ?>"></div>
         </div>
         <div class="col-md-2 tp">
            <div class="custom-control custom-checkbox custom-control-inline mrg-btm d-none">
               <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck2">
               <label class="custom-control-label pt-1" for="customCheck2">Present</label>
            </div>
         </div>
         <div class="col-md-2 tp">
            
         </div>
         </div> -->
         <div class="pg-frm-hd">Contact Person</div>
         <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Name</label>
                  <input name="" class="fld permenent-name form-control" id="permenent-name<?php echo $i; ?>" onblur="valid_name(<?php echo $i; ?>)" onkeyup="valid_name(<?php echo $i; ?>)"  type="text">
                  <div id="permenent-name-error<?php echo $i; ?>"></div>
               </div>
            </div> 
             <div class="col-md-3">
               <div class="pg-frm">
                  <label>Reletionship</label> 
                  <select name="" class="fld form-control relationship" onblur="valid_relationship(<?php echo $i; ?>)" onchange="valid_relationship(<?php echo $i; ?>)" id="relationship<?php echo $i; ?>" >
                     <option value="">Select Relationship</option>
                     <option  value="Self">Self</option>
                     <option  value="Parent">Parent</option>
                     <option  value="Spouse">Spouse</option>
                     <option value="Friend">Friend</option>
                     <option value="Relative">Relative</option>
                  </select>
                  <div id="relationship-error<?php echo $i; ?>"></div>
               </div>
            </div>
             <div class="col-md-2">
                <div class="pg-frm">
               <label>Code</label>
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
                  <label>Mobile Number</label>
                  <input name="" class="fld form-control permenent-contact_no" id="permenent-contact_no<?php echo $i; ?>" value="" onblur="valid_contact_no(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeyup="valid_contact_no(<?php echo $i; ?>)" type="text">
                  <div id="permenent-contact_no-error<?php echo $i; ?>">&nbsp;</div>
               </div>
            </div>
         </div>
      </div>

      
 
           <div class="row mt-3">
            <div class="col-md-3">
               <div class="pg-frm-hd">Rental Agreement/ Driving License</div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm-hd">Upload Ration Card <span>(optional)</span></div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm-hd">Upload Government Utility Bill <span>(optional)</span></div>
            </div>
            <div class="col-md-3">
               
            </div>
         </div>
        <div class="row">

             <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="rental_agreement<?php echo $i; ?>"><a class="fl-btn ">Browse files</a></label>
                     <input id="rental_agreement<?php echo $i; ?>" type="file"  style="display:none;" class="form-control fl-btn-n rental_agreement" multiple >
                     <div id="rental_agreement-img<?php echo $i; ?>"><?php
                     // $rental_agreement = '';
                       if (isset($rental_agreement[$i])) {
                       if (!in_array('no-file', $rental_agreement[$i])) {
                         foreach ($rental_agreement[$i] as $key => $value) {
                           if ($value !='') {
                            /* echo "<div id='rental{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"rental-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_rental_documents{$key}' onclick='removeFile_documents({$key},\"rental\")' data-path='rental-docs' data-field='rental_agreement' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";*/
                             echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"rental-docs\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/rental-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                           }
                         }
                         // $rental_agreement = $table['previous_address']['rental_agreement'];
                       }}
                       ?></div>
                       <input type="hidden" id="rental_agreement" value="<?php echo ''; ?>">
                  </div>
               </div>
               <div id="rental_agreement-error<?php echo $i; ?>">&nbsp;</div>
            </div>

            <!--  -->
            
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="ration_card<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                     <input id="ration_card<?php echo $i; ?>" type="file"  style="display:none;" class="form-control fl-btn-n ration_card" multiple >
                     <div id="ration_card-img<?php echo $i; ?>"><?php
                     // $ration_card = '';
                       if (isset($ration_card[$i])) {
                       if (!in_array('no-file', $ration_card[$i])) {
                         foreach ($ration_card[$i] as $key => $value) { 
                           if ($value !='') {
                           /* echo "<div id='ration{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"ration-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_ration_documents{$key}' onclick='removeFile_documents({$key},\"ration\")' data-path='ration-docs' data-field='ration_card' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";*/

                            echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"ration-docs\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/ration-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          }
                         }
                         // $ration_card = $table['previous_address']['ration_card'];
                       }}
                       ?></div>
                       <input type="hidden" id="ration_card" value="<?php echo ''; ?>">
                  </div>
               </div>
               <div id="ration_card-error<?php echo $i; ?>">&nbsp;</div>
            </div>


            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="gov_utility_bill<?php echo $i; ?>"><a class="fl-btn">Browse files</a></label>
                     <input id="gov_utility_bill<?php echo $i; ?>" type="file"  style="display:none;" class="form-control fl-btn-n gov_utility_bill" multiple >
                     <div id="gov_utility_bill-img<?php echo $i; ?>"><?php
                     // $gov_utility_bill = '';
                       if (isset($gov_utility_bill[$i])) {
                       if (!in_array('no-file',$gov_utility_bill[$i])) {
                         foreach ($gov_utility_bill[$i] as $key => $value) { 
                           if ($value !='') {
                         /*   echo "<div id='gov{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"gov-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_gov_documents{$key}' onclick='removeFile_documents({$key},\"gov\")' data-path='gov-docs' data-field='gov_utility_bill' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a></span></div>";*/

                            echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"gov-docs\")' >  <i class='fa fa-eye'></i></a> <a href='".base_url()."../uploads/gov-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          }
                         }
                         // $gov_utility_bill = $table['previous_address']['gov_utility_bill'];
                       }}
                       ?></div> 

                  </div>
               </div>
               <div id="gov_utility_bill-error<?php echo $i; ?>">&nbsp;</div>
            </div>


         </div>

      <hr>
         <?php 
         $j++;
       }
            }
         ?>

      </div>
       <!-- <div><button id="add-row"><i class="fa fa-plus"></i></button></div> -->

       


         <div class="row">
          <div class="col-md-12" id="warning-msg">&nbsp;</div>
            <div class="col-md-12">
               <div class="pg-submit">
                 <button id="add_address" class="pg-submit-btn">Save &amp; Continue</button> 
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- </form> -->
   <!--Page Content-->
   <div class="clr"></div>
</section>


  <div class="modal fade " id="myModal-show" role="dialog">
 <div class="modal-dialog modal-lg modal-dialog-centered">
      <!-- modal-content-view-collection-category -->
      <div class="modal-content">
        <div class="modal-header border-0">
          <h3 id="">View Document</h4>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row mt-2"> 
         <div class="col-md-12 text-center" id="view-img"></div>
    </div>
          <div class="row p-5 mt-2">
              <div class="col-md-6" id="setupDownloadBtn">
                
              </div>
              <div id="view-edit-cancel-btn-div" class="col-md-6  text-right">
                <button class="btn bg-blu text-white exit-btn" data-dismiss="modal">Close</button>
              </div>
            </div>
        </div>
        <!-- <div class="modal-footer border-0"></div> -->
      </div>
    </div>
</div>

  

<div class="modal fade " id="myModal-remove" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
        </div>
        <div class="modal-body">
         <div id="remove-caption"></div>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center" id="button-area">
              <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
           </div>
        </div>
      </div>
    </div>
  </div>


<script>
   var states = <?php echo json_encode($state); ?>;
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/previous-address.js" ></script>
 