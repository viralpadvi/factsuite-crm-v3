<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-permanent-address-1';
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
   <div class="pg-cnt pt-4">
      <div class="pg-txt-cntr">
         <div class="pg-steps">Step <?php echo array_search('9',array_values(explode(',', $user['component_ids'])))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         

        <!--  -->
        <h6 class="full-nam2"> Permanent Address</h6>
         <div class="row">
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>House/Flat No.</label>
                  <input name="" class="fld form-control" value="<?php echo isset($table['permanent_address']['flat_no'])?$table['permanent_address']['flat_no']:''; ?>" id="permenent-house-flat" type="text">
                  <input name="" class="fld form-control" value="<?php echo isset($table['permanent_address']['permanent_address_id'])?$table['permanent_address']['permanent_address_id']:''; ?>" id="permanent_address_id" type="hidden">
                  <div id="permenent-house-flat-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Street/Road</label>
                  <input name="" class="fld form-control" value="<?php echo isset($table['permanent_address']['street'])?$table['permanent_address']['street']:''; ?>" id="permenent-street" type="text">
                   <div id="permenent-street-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Area</label>
                  <input name="" class="fld form-control" value="<?php echo isset($table['permanent_address']['area'])?$table['permanent_address']['area']:''; ?>" id="permenent-area" type="text">
                  <div id="permenent-area-error">&nbsp;</div>
               </div>
            </div>
         </div>


         <div class="row">
           <!--  <div class="col-md-4">
               <div class="pg-frm">
                  <label>City/Town</label>
                  <input name="" class="fld form-control" value="<?php echo isset($table['permanent_address']['city'])?$table['permanent_address']['city']:''; ?>" id="city" type="text">
                  <div id="city-error">&nbsp;</div>
               </div>
            </div> -->
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Pin Code</label>
                  <input name="" class="fld form-control" value="<?php echo isset($table['permanent_address']['pin_code'])?$table['permanent_address']['pin_code']:''; ?>" id="permenent-pincode" type="text">
                  <div id="permenent-pincode-error">&nbsp;</div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Nearest Landmark</label>
                  <input name="" class="fld form-control" value="<?php echo isset($table['permanent_address']['nearest_landmark'])?$table['permanent_address']['nearest_landmark']:''; ?>" id="permenent-land-mark" type="text">
                  <div id="permenent-land-mark-error">&nbsp;</div>
               </div>
            </div>
                <div class="col-md-4">
               <div class="pg-frm">
               <label>Country</label> 
                   <select class="fld form-control country select2" id="country" >
                     <option selected value=''>Select Country</option>
                      <?php
                      // $get_country = isset($table['permanent_address']['country'])?$table['permanent_address']['country']:'India';
                      $get_country = isset($table['permanent_address']['country'])?$table['permanent_address']['country']:'';
                      $c_id = '';
                      foreach ($country as $key1 => $val) {
                         if ($get_country == $val['name']) {
                          $c_id = $val['id'];
                            echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         }else{
                           if ($val['name'] == 'India') {
                           $c_id = $val['id'];
                           }
                            echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         }
                      }
                         
                       ?>
                   </select> 
                   <div id="country-error">&nbsp;</div>
            </div>
          </div>

              <div class="col-md-4">
                <div class="pg-frm">
                   <label>State</label>
                   <?php
                   if ($c_id !='') {
                        $state = $this->candidateModel->get_all_states($c_id);  
                      }
                      $city_id ='';
                   ?>
                   <select class="fld form-control state select2"  id="state" >
                     <option selected value=''>Select State</option>
                      <?php 
                      $get_state = isset($table['permanent_address']['state'])?$table['permanent_address']['state']:'';
                      $get = isset($table['permanent_address']['state'])?$table['permanent_address']['state']:'Karnataka';
                      foreach ($state as $key1 => $val) {
                         if ($get_state == $val['name']) {
                          $city_id = $val['id'];
                            echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                         }else{
                           if ($get == $val['name']) {
                          $city_id = $val['id'];
                              }
                            echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                         }
                      }
                         
                       ?>
                   </select> 
                    <div id="permenent-state-error"></div>
                </div>
             </div>
              <div class="col-md-4">
                <div class="pg-frm">
                   <label>City/Town</label>
                   <!-- <input name="" class="fld form-control city" value="<?php echo isset($city[$i]['city'])?$city[$i]['city']:''; ?>"  onkeyup="valid_city()" id="city" type="text"> -->
                    <select class="fld form-control permenent-city select2" id="permenent-city" >
                     <option selected value=''>Select City/Town</option>
                      <?php 
                      $get_city = isset($table['permanent_address']['city'])?$table['permanent_address']['city']:'';
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
                   <div id="permenent-city-error">&nbsp;</div>
                </div>
             </div>

         </div>
 
         <div class="pg-frm-hd">Duration of Stay</div> 
         <?php $exploded_from_date = explode('-', isset($table['permanent_address']['duration_of_stay_start'])?$table['permanent_address']['duration_of_stay_start']:''); ?>
         <div class="row">
            <div class="col-md-3">
               <!--  <div>&nbsp;</div>
                <input name="" class="fld form-control date-for-candidate-aggreement-start-date" id="start-date" value="<?php echo isset($table['permanent_address']['duration_of_stay_start'])?$table['permanent_address']['duration_of_stay_start']:''; ?>" type="text"> -->
                <div class="row">
               <div class="col-md-6 w-50">
                  <label>Month</label>
                  <select class="fld select2" id="duration-of-stay-from-month">
                     <option selected value=''>Select Month</option>
                     <?php
                     $num = 0;
                      for ($i = 1; $i < $this->config->item('duration_of_stay_end_month'); $i++) {
                        $selected = '';
                        if ($exploded_from_date[1] == $i) {
                           $selected = 'selected';
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $i;?>"><?php echo $months[$num];?></option>
                     <?php 
                     $num++;
                  } ?>
                  </select> 
                  <div id="duration-of-stay-from-month-error"></div>
               </div>
                <div class="col-md-6 w-50">
                  <label>Year</label>
                  <select class="fld select2" id="duration-of-stay-from-year">
                     <option selected value=''>Select year</option>
                     <?php 
                     for($i = $this->config->item('current_year'); $i >= $this->config->item('duration_of_stay_start_year'); $i--){
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
                <div id="start-date-error">&nbsp;</div>
            </div> 
            <h6 class="To">TO</h6>
           <div class="col-md-4">
            <?php $exploded_end_date = explode('-', isset($table['permanent_address']['duration_of_stay_end'])?$table['permanent_address']['duration_of_stay_end']:''); ?>
            <!-- <div>&nbsp;</div>
             <input name="" class="fld form-control date-for-candidate-aggreement-end-date" id="end-date" value="<?php echo isset($table['permanent_address']['duration_of_stay_end'])?$table['permanent_address']['duration_of_stay_end']:''; ?>" type="text">  -->
              <div class="row">
               <div class="col-md-6 w-50">
                  <label>Month</label>
                  <select class="fld select2" id="duration-of-stay-end-month">
                     <option selected value=''>Select Month</option>
                     <?php
                     $num = 0;
                      for ($i = 1; $i < $this->config->item('duration_of_stay_end_month'); $i++) {
                        $selected = '';
                        if ($exploded_end_date[1] == $i) {
                           $selected = 'selected';
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $i;?>"><?php echo $months[$num];?></option>
                     <?php
                        $num++;
                      } ?>
                  </select> 
                  <div id="duration-of-stay-end-month-error"></div>
               </div>
                <div class="col-md-6 w-50">
                  <label>Year</label>
                  <select class="fld select2" id="duration-of-stay-end-year">
                     <option selected value=''>Select year</option>
                     <?php 
                     for($i = $this->config->item('current_year'); $i >= $this->config->item('duration_of_stay_start_year'); $i--){
                        $selected = '';
                        if ($exploded_end_date[0] == $i) {
                           $selected = 'selected';
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $i;?>"><?php echo $i;?></option>
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
                <input name="" class="fld form-control date-for-candidate-aggreement-start-date" value="<?php echo isset($table['permanent_address']['duration_of_stay_start'])?$table['permanent_address']['duration_of_stay_start']:''; ?>" id="permenent-start-date" type="text">
                <div id="permenent-start-date-error">&nbsp;</div>
            </div> 
            <h6 class="To">TO</h6>
           <div class="col-md-3">
            <div>&nbsp;</div>
             <input name="" class="fld form-control date-for-candidate-aggreement-end-date" value="<?php echo isset($table['permanent_address']['duration_of_stay_end'])?$table['permanent_address']['duration_of_stay_end']:''; ?>" id="permenent-end-date" type="text"> 
             <div id="permenent-end-date-error">&nbsp;</div>
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
                  <input name="" class="fld form-control" id="permenent-name" value="<?php echo isset($table['permanent_address']['contact_person_name'])?$table['permanent_address']['contact_person_name']:''; ?>" type="text">
                  <div id="permenent-name-error">&nbsp;</div>
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
                  if (isset($table['permanent_address']['contact_person_relationship'])) {
                    if ($table['permanent_address']['contact_person_relationship']=='Self') {
                       $Self = 'selected';
                    }else if ($table['permanent_address']['contact_person_relationship']=='Parent') {
                       $Parent = 'selected';
                    }else if ($table['permanent_address']['contact_person_relationship']=='Spouse') {
                       $Spouse = 'selected';
                    }else if ($table['permanent_address']['contact_person_relationship']=='Friend') {
                       $Friend = 'selected';
                    }else if ($table['permanent_address']['contact_person_relationship']=='Relative') {
                       $Relative = 'selected';
                    }else if ($table['permanent_address']['contact_person_relationship']=='Neighbor') {
                       $Neighbor = 'selected';
                    }else if ($table['permanent_address']['contact_person_relationship']=='Security Guard') {
                       $Security_Guard = 'selected';
                    }else if ($table['permanent_address']['contact_person_relationship']=='Landlord') {
                       $Landlord = 'selected';
                    }else if ($table['permanent_address']['contact_person_relationship']=='House Owner') {
                       $House_Owner = 'selected';
                    }else if ($table['permanent_address']['contact_person_relationship']=='Cousin') {
                       $Cousin = 'selected';
                    }
                  }
                  ?>
                  <select name="" class="fld form-control" id="relationship" >
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
                  <div id="relationship-error">&nbsp;</div>
               </div>
            </div>
              <div class="col-md-2">
                <div class="pg-frm">
               <label>Country Code</label>
              <select class="fld form-control code" id="code">
                <?php
                $ccode = isset($table['permanent_address']['code'])?$table['permanent_address']['code']:'';
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
                  <input name="" class="fld form-control" id="permenent-contact_no" value="<?php echo isset($table['permanent_address']['contact_person_mobile_number'])?$table['permanent_address']['contact_person_mobile_number']:''; ?>" type="text">
                  <div id="permenent-contact_no-error">&nbsp;</div>
               </div>
            </div>
         </div>
         <div class="row mt-3">
            <div class="col-md-3">
               <div class="pg-frm-hd">Rental Agreement/ Driving License</div>
            </div>
            <div class="col-md-3">
               <div class="pg-frm-hd">Upload Ration Card/ Aadhar Card<span>(optional)</span></div>
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
                     <label class="btn" for="file1"><a class="fl-btn">Browse files</a></label>
                     <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name1"><?php
                     $rental_agreement = '';
                       if (isset($table['permanent_address'])) {
                       if (!in_array('no-file', explode(',', $table['permanent_address']['rental_agreement']))) {
                         foreach (explode(',', $table['permanent_address']['rental_agreement']) as $key => $value) {
                           if ($value !='') {
                             echo "<div id='rental{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"rental-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_rental_documents{$key}' onclick='removeFile_documents({$key},\"rental\")' data-path='rental-docs' data-field='rental_agreement' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a>  <a href='".base_url()."../uploads/rental-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                           }
                         }
                         $rental_agreement = $table['permanent_address']['rental_agreement'];
                       }}
                       ?></div>
                        <input type="hidden" id="rental_agreement" value="<?php echo $rental_agreement; ?>">
                  </div>
               </div>
               <div id="file1-error"></div>
            </div>
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file2"><a class="fl-btn">Browse files</a></label>
                     <input id="file2" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name2"><?php
                     $ration_card = '';
                       if (isset($table['permanent_address'])) {
                       if (!in_array('no-file', explode(',', $table['permanent_address']['ration_card']))) {
                         foreach (explode(',', $table['permanent_address']['ration_card']) as $key => $value) { 
                           if ($value !='') {
                            echo "<div id='ration{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"ration-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_ration_documents{$key}' onclick='removeFile_documents({$key},\"ration\")' data-path='ration-docs' data-field='ration_card' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> <a href='".base_url()."../uploads/ration-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          }
                         }
                         $ration_card = $table['permanent_address']['ration_card'];
                       }}
                       ?></div>
                        <input type="hidden" id="ration_card" value="<?php echo $ration_card; ?>">
                  </div>
               </div>
               <div id="file2-error"></div>
            </div>
            <div class="col-md-3">
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file3"><a class="fl-btn">Browse files</a></label>
                     <input id="file3" type="file" style="display:none;" class="form-control fl-btn-n" multiple >
                     <div class="file-name3"><?php
                     $gov_utility_bill = '';
                       if (isset($table['permanent_address'])) {
                       if (!in_array('no-file', explode(',', $table['permanent_address']['gov_utility_bill']))) {
                         foreach (explode(',', $table['permanent_address']['gov_utility_bill']) as $key => $value) { 
                           if ($value !='') {
                            echo "<div id='gov{$key}'><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"gov-docs\")' >  <i class='fa fa-eye'></i></a> <a id='remove_file_gov_documents{$key}' onclick='removeFile_documents({$key},\"gov\")' data-path='gov-docs' data-field='gov_utility_bill' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> <a href='".base_url()."../uploads/gov-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          }
                         }
                         $gov_utility_bill = $table['permanent_address']['gov_utility_bill'];
                       }}
                       ?></div>
                  </div>
               </div>
               <div id="file3-error"></div>
            </div>
         </div>
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



<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-address.js" ></script>
 