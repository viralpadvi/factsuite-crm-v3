<?php 
  $candidateId =  isset($componentData['candidate_id'])?$componentData['candidate_id']:"2";
  $candidateName =  $componentData['first_name']." ".$componentData['last_name'];
  $candidateClinetName =  isset($componentData['client_name'])?$componentData['client_name']:"2";
  $code =  isset($componentData['country_code'])?$componentData['country_code']:"+91";
  $candidatePhoneNumber =  $code.' '.isset($componentData['phone_number'])?$componentData['phone_number']:"1234567890";
  $candidatePackageName =  isset($componentData['package_name'])?$componentData['package_name']:"2";
  $candidateEmail =  isset($componentData['email_id'])?$componentData['email_id']:"2";
  $php_code_selected_datetime_format = explode(' ',$selected_datetime_format['php_code']);
  $candidateDob = isset($componentData['date_of_birth'])?date($php_code_selected_datetime_format[0],strtotime($componentData['date_of_birth'])):"-";
  $permanent_address_id =  isset($componentData['permanent_address_id'])?$componentData['permanent_address_id']:"0";
  $candidateFatherName =  isset($componentData['father_name'])?$componentData['father_name']:"No data Found"; 
  $candidateEmployeeId =  isset($componentData['employee_id'])?$componentData['employee_id']:"No data Found";
  $priority =  isset($componentData['priority'])?$componentData['priority']:"0";

   $candidate_address =  isset($componentData['candidate_addresss'])?$componentData['candidate_addresss']:"-";
  $nationality =  isset($componentData['nationality'])?$componentData['nationality']:"-";
  $candidate_state =  isset($componentData['candidate_state'])?$componentData['candidate_state']:"-";
  $candidate_city =  isset($componentData['candidate_city'])?$componentData['candidate_city']:"-";
  $candidate_pincode =  isset($componentData['candidate_pincode'])?$componentData['candidate_pincode']:"000000";
  $remarks = isset($componentData['remark'])?$componentData['remark']:"";
  $backLink = '';
  $userRole = '';
  $userID = '';
  $outputQCStatus = '';
  if (empty($remarks)) {
  $remarks ="NA";
}
   $analyst_specialist_status_date = 'NA';
  $show_analyst_specialist_verification_days_taken = 'NA';
  $analyst_status_date_time = 'NA';
    $inputqc_status_date_time = isset($componentData['inputqc_status_date'])?$componentData['inputqc_status_date']:date('d-m-Y H:i:s');
  if ($componentData['inputqc_status_date'] !='' && $componentData['inputqc_status_date'] !='NA' && $componentData['analyst_status_date'] != '' && $componentData['analyst_status_date'] != 'NA') {
      $analyst_specialist_status_date = $componentData['analyst_status_date'];
      $analyst_specialist_status_date_time_splitted = explode(' ',$analyst_specialist_status_date)[0];
      if (!$this->utilModel->check_date_format($analyst_specialist_status_date_time_splitted,'Y-m-d')) {
          /*$analyst_specialist_status_date_splitted = explode('-',$analyst_specialist_status_date_time_splitted);
          $analyst_status_date_time = $analyst_specialist_status_date_splitted[1].'/'.$analyst_specialist_status_date_splitted[0].'/'.$analyst_specialist_status_date_splitted[2];*/
            $analyst_status_date_time = $analyst_specialist_status_date;
      } else {
          $analyst_status_date_time = $analyst_specialist_status_date_time_splitted;
      }
      $analyst_specialist_date_difference = date_diff(date_create($inputqc_status_date_time),date_create($analyst_status_date_time));
      $show_analyst_specialist_verification_days_taken = $analyst_specialist_date_difference->format("%a");
      if ($analyst_specialist_date_difference->format("%a") > 1) {
          $show_analyst_specialist_verification_days_taken .= ' days';
      } else {
          $show_analyst_specialist_verification_days_taken .= ' day';
      }
  }
                    
  if($this->session->userdata('logged-in-outputqc')){
    $outputQCStatus = 'disabled';
    $status = isset($status)?$status:0;
    if($status == 1){

      $backLink = 'factsuite-outputqc/view-case-detail/'.$candidateId.'/1';
    }else{

      $backLink = 'factsuite-outputqc/assigned-view-case-detail/'.$candidateId;
    }
    $outputqcUser = $this->session->userdata('logged-in-outputqc');
    $userID = $outputqcUser['team_id'];
    $userRole = $outputqcUser['role'];
  
  }else if($this->session->userdata('logged-in-inputqc')){
  
    $backLink = 'factsuite-inputqc/assigned-view-case-detail/'.$candidateId;
    $inputqcUser = $this->session->userdata('logged-in-inputqc');
    $userID = $inputqcUser['team_id'];
    $userRole =$inputqcUser['role'];
  
  }else if($this->session->userdata('logged-in-analyst')){ 
    $backLink = 'factsuite-analyst/assigned-case-list';
    $inputqcUser = $this->session->userdata('logged-in-analyst');
    $userID =$inputqcUser['team_id'];
    $userRole =$inputqcUser['role'];
    // $courtRecordStatus = $componentData['analyst_status'];
  }else if($this->session->userdata('logged-in-specialist')){ 
    $backLink = 'factsuite-specialist/view-all-component-list';
    $inputqcUser = $this->session->userdata('logged-in-specialist');
    $userID =$inputqcUser['team_id'];
    $userRole =$inputqcUser['role'];
    // $courtRecordStatus = $componentData['analyst_status'];
  }else if($this->session->userdata('logged-in-am')){ 
    $backLink = 'factsuite-am/view-all-case-list';
    // $backLink = 'factsuite-am/view-case-detail/'.$candidateId;
    $inputqcUser = $this->session->userdata('logged-in-am');
    $userID =$inputqcUser['team_id'];
    $userRole =$inputqcUser['role'];
    // $courtRecordStatus = $componentData['analyst_status'];
  }else if($this->session->userdata('logged-in-insuffanalyst')){ 
    $backLink = 'factsuite-analyst/assigned-insuff-component-list';
    $inputqcUser = $this->session->userdata('logged-in-insuffanalyst');
    $userID =$inputqcUser['team_id'];
    $userRole =$inputqcUser['role'];
    // $courtRecordStatus = $componentData['analyst_status'];
  }else{
    echo "<script>$('#back-btn').addClass('d-none');</script>";
  }

  $remarks_updateed_by_role = $userRole;
  if($remarks_updateed_by_role == '' || $remarks_updateed_by_role == 'null'){
    $remarks_updateed_by_role = 'pending';
  }


?>
<input type="hidden" value="<?php echo $component_id?> " id="component_id" name="component_id">
  <input type="hidden" value="<?php echo $userID?> " id="userID" name="userID">
  <input type="hidden" value="<?php echo $userRole ?>" id="userRole" name="userRole">
  <input type="hidden" value="<?php echo $priority ?>" id="priority" name="priority">
   
  <input type="hidden" id="selected-hidden-candidate-id" value="<?php echo $candidateIdLink;?>">
  <input type="hidden" id="selected-hidden-component-id" value="<?php echo $component_id;?>">
  <input type="hidden" id="selected-hidden-component-index" value="<?php echo $index;?>">
  <input type="hidden" id="selected-hidden-user-component-form-filled-id" value="<?php echo $permanent_address_id;?>">
  <input type="hidden" value="<?php echo $componentData['candidate_id']?>" id="candidate_id_hidden"name="">
  
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-analyst">
         <!-- <h3>Case Detail</h3> -->
          
          <a class="btn bg-blu btn-submit-cancel" id="back-btn" href="<?php echo $this->config->item('my_base_url').$backLink?>" ><span class="text-white"><i class="fas fa-angle-left"></i>&nbsp;Back</span></a>

          <h3 class="mt-3">Permanent Address Form Detail</h3>
          <?php //print_r($componentData); ?>
          <hr>
          <div class="container detail">
              <h6 class="hd-h6">Case Details</h6>
            <div class="row mt-4">
              <div class="col-md-2 lft-p-det">
               <p>Case ID</p>
               <p>Candidate Name</p>
               <p>Father's Name</p>
               <p>Phone Number</p>
               <p>Email ID</p>
               <!-- <p>Address</p> -->
               <p>State</p>
               <p>Zip/Pin Code</p>
               <p>Remarks</p>
               <p>Internal TAT Day</p>
              </div>
              <div class="col-md-1 pr-0 lft-p-det">
                 <p>:</p>
                 <p>:</p>
                 <p>:</p>
                 <p>:</p>
                 <p>:</p>
                 <!-- <p>:</p> -->
                 <p>:</p>
                 <p>:</p>
                 <p>:</p>
                 <p>:</p>
              </div>
              <div class="col-md-4 ryt-p pl-0 lft-p-det">
                <p><?php echo isset($candidateId)?$candidateId:'NA';?></p>
                 <p><?php echo isset($candidateName)?$candidateName:'NA';?></p>
                 <p><?php echo isset($candidateFatherName)?$candidateFatherName:'NA';?></p>
                 <p><?php echo isset($candidatePhoneNumber)?$candidatePhoneNumber:'NA';?></p>
                 <p><?php echo isset($candidateEmail)?$candidateEmail:'NA';?></p>
                  <!-- <p><?php echo $candidate_address;?></p> -->
                 <p><?php echo isset($candidate_state)?$candidate_state:'NA';?></p>
                 <p><?php echo isset($candidate_pincode)?$candidate_pincode:'NA';?></p>
                 <p><?php echo isset($remarks)?$remarks:'NA';?></p>
                 <p><?php echo $show_analyst_specialist_verification_days_taken;?></p>
              </div>
              <div class="col-md-2 lft-p-det">
                <p>Employee ID</p>
                <p>Client Name</p>
                <p>Package Name</p>
                <p>DOB(date of birth)</p>
                <p>Last Updated By :</p>
                <p>Country</p>
                <p>City</p> 
                <p>Preferred Contact Days</p>
                <p>Contact Start Time</p>
                <p>Contact End Time</p>

              </div>
              <div class="col-md-1 pr-0 lft-p-det">
                <p>:</p>
                <p>:</p>
                <p>:</p>
                <p>:</p>
                <p>:</p>
                <p>:</p>
                <p>:</p>
                <p>:</p>
                <p>:</p>
                <p>:</p>
                <p>:</p>
              </div>
              <div class="col-md-2 ryt-p pl-0 lft-p-det">
                 <p><?php echo $candidateEmployeeId;?></p>
                <p><?php echo $candidateClinetName;?></p>
                <p><?php echo $candidatePackageName;?></p>
                <p><?php echo $candidateDob;?></p>
                <p class="text-capitalize "><?php echo $remarks_updateed_by_role;?></p>
                <p ><?php echo $nationality;?></p>
                <p ><?php echo $candidate_city;?></p> 
                <p ><?php echo isset($componentData['week'])?$componentData['week']:'NA';?></p>
                <p ><?php echo isset($componentData['contact_start_time'])?$componentData['contact_start_time']:'NA';?></p>
                <p ><?php echo isset($componentData['contact_end_time'])?$componentData['contact_end_time']:'NA';?></p>
                <?php                    
                   if($document_uploaded_by != 'candidate' && $is_submitted != 0 && $signature =='1'){
                    echo '<label class="font-weight-bold">LOA &nbsp;&nbsp;&nbsp;<a target="_blank" download href="'.$base_url.'uploads/doc_signs/'.$uploaded_loa.'"><i class="fa fa-download"></i></a></label>';
                  }else if($is_submitted != 0){
                ?>
                <label class="font-weight-bold">LOA &nbsp;&nbsp;&nbsp;<a target="_blank"
                        href="<?php echo $this->config->item('my_base_url').'factsuite-admin/candidate-loa-pdf/'.md5($candidateId); ?>"><i
                            class="fa fa-file-pdf-o"></i></a></label>
                <?php } ?>
                <!-- <button class="de-vw">View Document</button> -->
              </div>
            </div>
          </div>
          <hr>
          <!-- <div class="table-responsive mt-3" id="">
          <table class="table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Component</th>  
                <th>Details</th>  
                <th>Component Status</th>  
                <th>Insufficiency</th>  
                <th>Approve</th>  
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-case-data"> 
            </tbody>
          </table>
        </div> -->
        <!--Content-->
          <section id="table-allcase">
            <div class="container">
                <div class="detail mb-5">
                  <div class="row hd">
                      
                      <!-- <div class="col-md-6"><a href="./allcase2.html"><button class="close-bt">Close</button></a></div> -->
                  </div>  
                    <div>
                      <h3 class="permt mt-4">Permanent Address Details</h3>
                       <div class="row mt-3"> 
                          <div class="col-md-2 lft-p-det">
                            <p>House/Flat No</p>
                            <p>Street/Road</p>
                            <p>Area</p>
                            <p>Country</p>
                            <p>City/Town</p>
                            <p>Contact Name</p>
                            <p>Mobile Number</p>
                          </div>
                          <div class="col-md-1 pr-0">
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                         </div>
                         <div class="col-md-3 ryt-p pl-0">
                            <p><?php echo isset($componentData['flat_no'])?$componentData['flat_no']:'value not found';?></p>
                            <p><?php echo isset($componentData['street'])?$componentData['street']:'value not found'?></p>
                            <p><?php echo isset($componentData['area'])?$componentData['area']:'value not found'?></p> 
                            <p><?php echo isset($componentData['country'])?$componentData['country']:'value not found'?></p>
                            <p><?php echo isset($componentData['city'])?$componentData['city']:'value not found'?></p> 
                            <p><?php echo isset($componentData['contact_person_name'])?$componentData['contact_person_name']:'value not found'?></p> 
                            <p><?php echo isset($componentData['contact_person_mobile_number'])?$componentData['contact_person_mobile_number']:'value not found';
                              // print_r($componentData);
                            ?></p> 
                         </div>
                          <div class="col-md-2 lft-p-det">
                            <p>Pin Code</p>
                            <p>Nearest Landmark</p>
                            <p>State</p>
                            <p>DURATION OF STAY</p>
                            <p>Relationship</p>
                          </div>
                          <div class="col-md-1 pr-0">
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                         </div>
                         <div class="col-md-3 ryt-p pl-0">

                            <p><?php echo isset($componentData['pin_code'])?$componentData['pin_code']:'value not found';?></p>
                            <p><?php echo isset($componentData['nearest_landmark'])?$componentData['nearest_landmark']:'value not found'?></p> 
                            <p><?php echo isset($componentData['state'])?$componentData['state']:'value not found'?></p> 
                            <p><?php echo isset($componentData['duration_of_stay_start'])?date('m/y',strtotime($componentData['duration_of_stay_start'])):'value not found'?> TO <?php echo isset($componentData['duration_of_stay_end'])?date('m/y',strtotime($componentData['duration_of_stay_end'])):'value not found'?></p>
                            <p><?php echo isset($componentData['contact_person_relationship'])?$componentData['contact_person_relationship']:'value not found'?></p> 
                         </div>
                      </div>
                    </div>

                    
                    <hr>

                    <div class="row">
                      <div class="col-md-4">
                        <label class="permt mt-4">Rental Docs</label>
                        <?php
                               // $rental_agreement = '';
                                 if (isset($componentData['rental_agreement'])) {
                                 if (!in_array('no-file',explode(',', $componentData['rental_agreement']))) {
                                   foreach (explode(',', $componentData['rental_agreement']) as $key1 => $value) {
                                      if ($value !='') {
                                        $url = base_url()."../uploads/rental-docs/".$value;
                                        echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a> <a href='{$url}' download >  <i class='fa fa-download'></i></a> </span></div>";
                                      }
                                   }
                                 // $rental_agreement = $rental_agreement[$key];
                                 }} 
                                 ?> <!--   rental_agreement
ration_card
gov_utility_bill -->
                      </div>

                       <div class="col-md-4">
                        <label class="permt mt-4">Ration Card Docs</label>
                        <?php
                               // $rental_agreement = '';
                                 if (isset($componentData['ration_card'])) {
                                 if (!in_array('no-file',explode(',', $componentData['ration_card']))) {
                                   foreach (explode(',', $componentData['ration_card']) as $key1 => $value) {
                                      if ($value !='') {
                                        $url = base_url()."../uploads/ration-docs/".$value;
                                        echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a> <a href='{$url}' download >  <i class='fa fa-download'></i></a></span></div>";
                                      }
                                   }
                                 // $rental_agreement = $rental_agreement[$key];
                                 }} 
                                 ?> <!--   rental_agreement
ration_card
gov_utility_bill -->
                      </div>

                       <div class="col-md-4">
                        <label class="permt mt-4">Govermet / Utility Docs</label>
                        <?php
                               // $rental_agreement = '';
                                 if (isset($componentData['gov_utility_bill'])) {
                                 if (!in_array('no-file',explode(',',$componentData['gov_utility_bill']))) {
                                   foreach (explode(',',$componentData['gov_utility_bill']) as $key1 => $value) {
                                      if ($value !='') {
                                        $url = base_url()."../uploads/gov-docs/".$value;
                                        echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a> <a href='{$url}' download >  <i class='fa fa-download'></i></a></span></div>";
                                      }
                                   }
                                 // $rental_agreement = $rental_agreement[$key];
                                 }} 
                                 ?> <!--   rental_agreement
ration_card
gov_utility_bill -->
                      </div>
                      
                    </div>

                    <hr>

                    <h3 class="permt mt-4">Permanent Address  verification Details</h3>
                      <div class="row mt-3"> 
                        <div class="col-md-6">
                          <input name="" class="fld form-control permanent_address_id" value="<?php echo $componentData['permanent_address_id']; ?>" id="permanent_address_id" type="hidden">

                          <!-- Address -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Address</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              
                              <textarea class="fld form-control address" rows="4" id="address" spellcheck="false"><?php echo $componentData['remarks_address']; ?></textarea>
                              <div id="address-error">&nbsp;</div>
                            </div>
                          </div>
                         
                          <!-- State -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">State</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <!-- <input name="" class="fld form-control state" value="<?php //echo $componentData['remarks_state']; ?>" id="state" type="text"> -->
                              <!-- states --> 
                               <select class="fld form-control state" id="state">
                                <?php
                                $city_id = '';
                                  $state = ''; 
                                  if($stateName != '' && $stateName != null){
                                    $state = isset($componentData['remarks_state'])?$componentData['remarks_state']:'Karnataka';
                                  }else{
                                    $state = 'Karnataka';
                                  }
                                  foreach ($states as $keyState => $value) {
                                    if($state == $value['name']){
                                      echo '<option data-id="'.$value['id'].'" selected value="'.$value['name'].'">'.$value['name'].'</option>';
                                      $city_id = $value['id'];
                                    }else{
                                      echo '<option data-id="'.$value['id'].'" value="'.$value['name'].'">'.$value['name'].'</option>';
                                    }
                                  }
                                ?>
                                <!--   -->
                              </select>
                              <div id="state-error">&nbsp;</div>
                            </div>
                          </div>
                          <!-- City  -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">City</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <!-- <input name="" class="fld form-control city" value="<?php echo $componentData['remarks_city']; ?>" id="city" type="text"> -->
                               <select class="fld form-control city select2" onchange="valid_city()" id="city">
                                 <?php 
                                  $get_city = isset($componentData['remarks_city'])?$componentData['remarks_city']:''; 
                                  $cities = $this->componentModel->get_all_cities($city_id);
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
                          <!-- Pin Code -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Pin Code</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control pincode" value="<?php echo $componentData['remarks_pincode']; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="pincode" type="text">
                              <div id="pincode-error">&nbsp;</div>
                            </div>
                          </div>
                          <!-- Staying with -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Staying with</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <!-- <input name="" class="fld form-control staying_with" value="<?php //echo $componentData['staying_with']; ?>" id="staying_with" type="text"> -->
                              <?php 
                                $Family = '';
                                $Friends = '';
                                $Alone = '';
                                $Relatives = '';
                                if($componentData['staying_with'] == 'Family'){
                                  $Family = 'selected';
                                }else if($componentData['staying_with'] == 'Friends'){
                                  $Friends = 'selected';
                                }else if($componentData['staying_with'] == 'Alone'){
                                  $Alone = 'selected';
                                }else if($componentData['staying_with'] == 'Relatives'){
                                  $Relatives = 'selected';
                                }
                              ?>
                              <select class="fld form-control staying_with" id="staying_with">
                                <option <?php echo $Family ?> value="Family">Family</option>
                                <option <?php echo $Friends ?> value="Friends">Friends</option>
                                <option <?php echo $Alone ?> value="Alone">Alone</option>
                                <option <?php echo $Relatives ?> value="Relatives">Relatives</option>
                              </select>
                              <div id="staying_with-error">&nbsp;</div>
                            </div>
                          </div>
                           <!-- Property Type -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Property Type</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <!-- <input name="" class="fld form-control property_type" value="<?php //echo $componentData['property_type']; ?>" id="property_type" type="text"> -->
                               <?php 
                                $Rented = '';
                                $Owned = '';
                                $others = '';
                                if($componentData['property_type'] == 'Rented'){
                                  $Rented = 'selected';
                                }else if($componentData['property_type'] == 'Owned'){
                                  $Owned = 'selected';
                                }else if($componentData['property_type'] == 'others'){
                                  $others = 'selected';
                                }
                              ?>
                              <select class="fld form-control property_type" id="property_type">
                                <option <?php echo $Rented ?> value="Rented">Rented</option>
                                <option <?php echo $Owned ?> value="Owned">Owned</option>
                                <option <?php echo $others ?> value="Others">Others</option>
                              </select>
                              <div id="property_type-error">&nbsp;</div>
                            </div>
                          </div>
                           <!-- Verifier Name  -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Verifier Name</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control verifier_name" value="<?php echo $componentData['verifier_name']; ?>" id="verifier_name" type="text">
                              <div id="verifier_name-error">&nbsp;</div>
                            </div>
                          </div>
                          <!-- Verifier Relationship -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Verifier Relationship</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <!-- <input name="" class="fld form-control relationship" value="<?php // echo $componentData['relationship']; ?>" id="relationship" type="text"> -->
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
                                $relationship = isset($componentData['relationship'])?$componentData['relationship']:'';
                                if($relationship == 'Self'){
                                  $Self = 'selected';
                                }else if($relationship == 'Parent'){
                                  $Parent = 'selected';
                                }else if($relationship == 'Spouse'){
                                  $Spouse = 'selected';
                                }else if($relationship == 'Friend'){
                                  $Friend = 'selected';
                                }else if($relationship == 'Relative'){
                                  $Relative = 'selected';
                                }else if ($relationship =='Neighbor') {
                                   $Neighbor = 'selected';
                                }else if ($relationship =='Security Guard') {
                                   $Security_Guard = 'selected';
                                }else if ($relationship =='Landlord') {
                                   $Landlord = 'selected';
                                }else if ($relationship =='House Owner') {
                                   $House_Owner = 'selected';
                                }else if ($relationship =='Cousin') {
                                   $Cousin = 'selected';
                                }
                              ?>
                              <select class="fld form-control relationship" id="relationship">
                                <option <?php echo $Self ?> value="Self">Self</option>
                                <option <?php echo $Parent ?> value="Parent">Parent</option>
                                <option <?php echo $Spouse ?> value="Spouse">Spouse</option>
                                <option <?php echo $Friend ?> value="Friend">Friend</option>
                                <option <?php echo $Relative ?> value="Relative">Relative</option>
                                <option <?php echo $Neighbor; ?> value="Neighbor">Neighbor</option>
                                <option <?php echo $Security_Guard; ?> value="Security Guard">Security Guard</option>
                                <option <?php echo $Landlord; ?> value="Landlord">Landlord</option>
                                <option <?php echo $House_Owner; ?> value="House Owner">House Owner</option>
                                <option <?php echo $Cousin; ?> value="Cousin">Cousin</option>
                              </select>
                              <div id="relationship-error">&nbsp;</div>
                            </div>
                          </div>
                          <!-- Verification Remarks -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Verification Remarks</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7"> 
                              <textarea class="fld form-control verification_remarks" id="verification_remarks"><?php echo $componentData['verification_remarks']; ?></textarea>
                              <div id="verification_remarks-error">&nbsp;</div>
                            </div>
                          </div>

                          <!-- Verification date -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Verified Date</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <?php 
                                $verified = isset($componentData['verified_date'])?$componentData['verified_date']:'';
                                if($verified == 'Invalid Date' || $verified == 'Invalid date' || $verified == 'invalid Date'){
                                  $verifieds ='';
                                }
                                $verified = $this->utilModel->get_date($verified);

                                if (strtolower($verified) !='na' && strtolower($verified) !='01-01-1970') {}else{
                                   $verified ='';
                                }
                              ?>
                              <input name="" class="fld form-control mdate verified_date" value="<?php echo $verified; ?>" id="verified_date" type="text"> 
                            </div>
                          </div>
                          
                          <!-- verification upload -->
                          <div class="row mt2">
                            <div class="add-vendor-bx2">
                              <h3 class="m-0">&nbsp;</h3>
                              <ul>
                                 <li class="vendor-wdt2">
                                    <p class="lft-p-det">Verification Proof Upload Section</p>
                                    <div class="form-group mb-0">
                                      <input type="file" id="client-documents" name="client-documents[]" multiple="multiple">
                                      <label class="btn upload-btn" for="client-documents">Upload</label>
                                    </div>
                                    <div id="client-upoad-docs-error-msg-div">
                                      <?php
                                       $pan_card_doc = '';
                                         if (isset($componentData['approved_doc'])) {
                                         if (!in_array('no-file', explode(',', $componentData['approved_doc']))) {
                                           foreach (explode(',', $componentData['approved_doc']) as $key => $value) {
                                              if ($value !='') {
                                                $url = base_url()."../uploads/remarks-docs/".$value;
                                                echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a> <a href='{$url}' download >  <i class='fa fa-download'></i></a></span></div>";
                                            }
                                           }
                                         $pan_card_doc = $componentData['approved_doc'];
                                         }} 
                                      ?>
                                 
                                    </div>
                                 </li> 
                              </ul>
                              <div class="row" id="selected-vendor-docs-li"></div>
                            </div>
                          </div>
                        </div>
                        <!-- Not Required Fields -->
                        <div class="col-md-6">
                          <!-- Period of Stay -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Duration of Stay</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control period_of_stay" value="<?php echo $componentData['period_of_stay']; ?>" id="period_of_stay" type="text">
                            <div id="period_of_stay-error">&nbsp;</div>
                            </div>
                          </div>
                          <!-- Assigned To Vendor -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Assigned To Vendor</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control assigned_to_vendor" value="<?php echo $componentData['assigned_to_vendor']; ?>" id="assigned_to_vendor" type="text">
                              <div id="assigned_to_vendor-error">&nbsp;</div>
                            </div>
                          </div>
                          <!-- Vendor Initiated Date -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Vendor Initiated Date</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control initiated_date mdate" readonly value="<?php echo $componentData['initiated_date']; ?>" id="initiated_date" type="text">
                              <div id="initiated_date-error">&nbsp;</div>
                            </div>
                          </div>
                          <!-- Vendor Closure date -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Vendor Closure date</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control closure_date mdate" readonly value="<?php echo $componentData['closure_date']; ?>" id="closure_date" type="text">
                              <div id="closure_date-error">&nbsp;</div>
                            </div>
                          </div> 
                          
                          <!-- In Progress Remarks -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">In Progress Remarks</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7"> 
                              <textarea class="fld form-control progress_remarks" id="progress_remarks"><?php echo $componentData['progress_remarks']; ?></textarea>
                              <div id="progress_remarks-error">&nbsp;</div>
                            </div>
                          </div>  
                          <!-- Insuff Remarks -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Insuff Remarks</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7"> 
                              <textarea class="fld form-control infuff_remarks" id="infuff_remarks" ><?php echo isset($componentData['insuff_remarks'])?$componentData['insuff_remarks']:'-'; ?></textarea>
                              <div id="infuff_remarks-error">&nbsp;</div>
                            </div>
                          </div>
                          
                          <!-- Insuff Closure Remarks -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Insuff Closure Remarks</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7"> 
                              <textarea class="fld form-control closure_remarks" id="closure_remarks"  >
                                <?php echo $componentData['closure_remarks']; ?>
                              </textarea>
                              <div id="closure_remarks-error">&nbsp;</div>
                            </div>
                          </div> 
                        </div>
                    </div>
                    <hr> 

                    <div class="row mt-2">
                    <div class="col-md-6">

                      
                      <?php
                        $defaultStatus = '';
                        $insuffStatus = '';
                        $verifiedclearStatus = '';
                        $stopcheckStatus = '';
                        $utv = '';
                        $vd = '';
                        $cc = '';
                        $ci ='';
                        $disabled = '';
                        $disabledOP = '';
                        $ni = '';
                       $analyst_status = $componentData['analyst_status'];
                        $progress ='';
                        if($analyst_status == 0){
                          $defaultStatus = 'selected';
                        }else if($analyst_status == 1){
                          $progress ='selected';
                        }else if($componentData['analyst_status'] == 3){
                          $insuffStatus = 'selected';
                        }else if($componentData['analyst_status'] == 4){
                          $verifiedclearStatus = 'selected';
                          // $disabled = 'disabled';
                        }else if($componentData['analyst_status'] == 5){
                          $stopcheckStatus = 'selected';
                        }else if($componentData['analyst_status'] == 6){
                          $utv = 'selected';
                        }else if($componentData['analyst_status'] == 7){
                          $vd = 'selected';
                        }else if($componentData['analyst_status'] == 8){
                          $cc = 'selected';
                        }else if($componentData['analyst_status'] == 9){
                          $ci = 'selected';
                        }else if($componentData['analyst_status'] == 11){
                          $ni = 'selected';
                        }
                        
                        $subTitle = '';
                        $selectOpStatusEnable = 'd-none';
                        if($outputQCStatus == 'disabled'){
                          $subTitle = 'Analyst component status';
                          $selectOpStatusEnable = '';
                        }else{
                          $subTitle = 'Select component status';
                        }
                         

                        $disabled = '';
                        if(($remarks_updateed_by_role == 'insuff analyst' || $remarks_updateed_by_role == 'insuff ana') && $analyst_status == 3){
                          // $disabled = 'disabled';
                        }

                      ?>
                      <p class="det"><?php echo $subTitle; ?></p>
                      <select id="action_status" <?php echo $disabled." ".$outputQCStatus; ?> name="carlist" class="sel-allcase">
                        <option class="text-capitalize" <?php echo $defaultStatus ?> value="0">Select your Action</option>
                        <?php                           
                          if($userRole != 'insuff analyst'){  ?>
                        <option class="text-capitalize" <?php echo $progress ?> value="1">In Progress</option>
                      <?php } ?>
                        <option class="text-capitalize" <?php echo $insuffStatus ?> value="3">Insufficient</option>
                       <?php 
                          if($userRole != 'insuff analyst'){  ?>
                            <option class="text-capitalize" <?php echo $verifiedclearStatus ?> value="4">Verified Clear</option>
                            <option class="text-capitalize" <?php echo $stopcheckStatus ?> value="5">Stop check</option> 
                            <option class="text-capitalize" <?php echo $utv ?> value="6">Unable to verify</option> 
                            <option class="text-capitalize" <?php echo $vd ?> value="7">Verified discrepancy</option> 
                            <option class="text-capitalize" <?php echo $cc ?> value="8">Client clarification</option> 
                            <option class="text-capitalize" <?php echo $ci ?> value="9">Closed Insufficiency</option>
                        <?php } else { ?>
                             <option class="text-capitalize" <?php echo $ni ?> value="11">Not Insufficient</option>
                        <?php }
                        
                          if($analyst_status == '10'){
                            echo '<option class="text-capitalize" selected value="10">QC Error</option>';
                          } 
                        ?>
                      </select>

                      <label class="d-block mt-3">Iverify / PV?</label>
                      <?php $pv_checked = $iverify_checked = '';
                      if ($componentData['iverify_or_pv_status'] == 1) {
                         $iverify_checked = ' checked';
                      } else if($componentData['iverify_or_pv_status'] == 2) {
                         $pv_checked = ' checked';
                      } ?>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"<?php echo $iverify_checked;?> class="custom-control-input client-iverify-or-pv-type" value="1" name="client-iverify-or-pv-type" id="iverify-client">
                            <label class="custom-control-label" for="iverify-client">Iverify</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"<?php echo $pv_checked;?> class="custom-control-input client-iverify-or-pv-type" value="2" name="client-iverify-or-pv-type" id="pv-client">
                            <label class="custom-control-label" for="pv-client">PV</label>
                          </div>
                        </div>
                        <div class="col-md-12" id="client-iverify-or-pv-type-error-msg-div"></div>
                      </div>
                    </div> 
                  </div>
                  <?php $data['vendor'] = $vendor;
                  $this->load->view('vendor/vendor-assign-to-component-form',$data); ?>
                  <div class="row d-none">
                    <div class="col-md-12 text-right">
                      <a class="btn bg-blu btn-submit mt-4" id="view-all-raised-error-log">
                        <span class="text-white">View Error Log</span>
                      </a>
                      <a class="btn bg-blu btn-submit mt-4" data-toggle="modal" data-target="#add-new-error-modal">
                        <span class="text-white">Raise Error</span>
                      </a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 text-right">
                      <a class="btn bg-blu btn-submit mt-4 d-none" data-toggle="modal" data-target="#add-new-client-clarification-modal">
                        <span class="text-white">Raise Client Clarifications</span>
                      </a>
                      <a class="btn bg-blu btn-submit mt-4" id="view-all-raised-client-clarification-log">
                        <span class="text-white">View Client Clarifications Log</span>
                      </a>
                    </div>
                  </div>
                  <div class="row mt-2 <?php echo $selectOpStatusEnable ?>">
                    <div class="col-md-6">
                      <p class="det">Select component status</p>
                      <?php 
                          // echo 'output_status: '.$componentData['output_status'] ;
                          $approveOpStatus = '';
                          $rejectOpStatus = '';
                          $defaultOpStatus = '';
                          if($componentData['output_status'] == 1){
                            $approveOpStatus = 'selected';
                          }else if($componentData['output_status'] == 2){
                            $rejectOpStatus = 'selected';
                          }else {
                            $defaultOpStatus = 'selected'; 
                          }
                      ?>
                      <select id="op_action_status" name="carlist" class="sel-allcase">
                        <option <?php echo $defaultOpStatus ?> value="0">Select your Action</option>
                        <option <?php echo $approveOpStatus ?> value="1">Approved</option>
                        <option <?php echo $rejectOpStatus ?> value="2">Rejected</option>
                      </select>
                    </div>
                  </div>
                  <?php 
                  if($analyst_status == '10'){?>
                    <div class="row mt-2"> 
                      <div class="col-md-6">
                        <p class="det">Qc Comment</p>
                        <textarea 
                          class="fld form-control ouputQcComment" 
                          id="ouputQcComment" 
                          rows="3" ><?php echo isset($componentData['ouputqc_comment'])?$componentData['ouputqc_comment']:'' ?></textarea>
                        <div id="address-error"></div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
                <hr>
                  <div class="row mt-2">
                    <div class="col-md-6">
                      
                    </div>
                    <div class="col-md-6 text-right">
                      <a href="<?php echo $this->config->item('my_base_url').$backLink?>"><button class="close-bt">Close</button></a>
                      <!-- <button id="submit-perminant-address" class="update-bt">Update</button> -->
                       <button class="update-bt" data-toggle="modal" data-target="#conformtion-pr-address" id="#update-conformtion">Update</button> 
                    </div>
                  </div>
                </div>
            </div>
          </section>
          <!--Content-->
     </div>
  </div>
</section>
<!--Content-->


<!-- Popup Content -->
<div id="conformtion-pr-address" class="modal fade">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
             <h3 class="snd-mail-pop">Do you want to Confirm?</h3>
             <div class="row mt-3">
                 <div class="col-md-4">
                     <p class="pa-pop">Case ID :  <?php echo $componentData['candidate_id']?></p>
                 </div>
                 <div class="col-md-8">
                     <p  class="pa-pop">Candidate Name  : <?php echo $candidateName =  $componentData['first_name']." ".$componentData['last_name'];?></p>
                 </div>
             </div>
            <!--  <textarea class="message">Message...</textarea>
             <div class="form-group w-100 mt-2">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
            </div> -->
                <p class="pa-pop text-warning" id="wait-message"></p>

                <button class="btn bg-blu text-white" id="cancle-data-btn" data-dismiss="modal">Close</button>
                <button class="btn bg-blu float-right text-white" id="submit-perminant-address">Confirm</button>
             <div class="clr"></div>
          </div>
       </div>
    </div>
</div>

<!-- Popup Content -->
<!-- Popup Content -->
<div id="sendMail" class="modal fade">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
             <h3 class="snd-mail-pop">Send Mail <img src="<?php echo base_url()?>assets/admin/images/email_open_100px.png" alt=""> </h3>
             <div class="row mt-3">
                 <div class="col-md-4">
                     <p class="pa-pop">Case ID : 1245DGT</p>
                 </div>
                 <div class="col-md-8">
                     <p  class="pa-pop">From : analyst@factsuite.com</p>
                 </div>
             </div>
             <textarea class="message">Message...</textarea>
             <div class="form-group w-100 mt-2">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
            </div>
                <button class="btn bg-blu btn-submit-cancel float-right text-white">Send</button>
             <div class="clr"></div>
          </div>
       </div>
    </div>
</div>
 
<?php
  include APPPATH.'views/analyst/assigned-case/component-pages/view_image_model.php';
?>

<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/remark-permanent-address.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/commonImageView.js"></script>


<?php if ($this->session->userdata('logged-in-analyst')) { ?>
  <script src="<?php echo base_url() ?>assets/custom-js/analyst/component-error/raise-error.js"></script>
  <script src="<?php echo base_url() ?>assets/custom-js/analyst/component-error/all-errors.js"></script>

  <script src="<?php echo base_url() ?>assets/custom-js/analyst/client-clarification/raise-clarification.js"></script>
  <script src="<?php echo base_url() ?>assets/custom-js/analyst/client-clarification/all-clarifications.js"></script>
<?php } else if($this->session->userdata('logged-in-specialist')) { ?>
  <script src="<?php echo base_url() ?>assets/custom-js/specialist/component-error/raise-error.js"></script>
  <script src="<?php echo base_url() ?>assets/custom-js/specialist/component-error/all-errors.js"></script>

  <script src="<?php echo base_url() ?>assets/custom-js/specialist/client-clarification/raise-clarification.js"></script>
  <script src="<?php echo base_url() ?>assets/custom-js/specialist/client-clarification/all-clarifications.js"></script>
<?php } ?>

<?php extract($_GET); 
  if (isset($view_client_clarification) && $view_client_clarification != '') {
?>
  <script>
    view_clarification_details(<?php echo $view_client_clarification;?>);
  </script>
<?php } ?>