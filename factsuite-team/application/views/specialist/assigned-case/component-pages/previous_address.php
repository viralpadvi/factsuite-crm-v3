<?php 
  $candidateId =  isset($componentData['candidate_id'])?$componentData['candidate_id']:"2";
  $candidateName =  $componentData['first_name']." ".$componentData['last_name'];
  $candidateClinetName =  isset($componentData['client_name'])?$componentData['client_name']:"2";
  $candidatePhoneNumber =  isset($componentData['phone_number'])?$componentData['phone_number']:"1234567890";
  $candidatePackageName =  isset($componentData['package_name'])?$componentData['package_name']:"2";
  $candidateEmail =  isset($componentData['email_id'])?$componentData['email_id']:"2";
  $candidateDob =  isset($componentData['date_of_birth'])?$componentData['date_of_birth']:"34-13-2050";

  $backLink = '';
  $userRole = '';
  $userID = '';
  $outputQCStatus = ''; 
  if($this->session->userdata('logged-in-specialist')){

    $backLink = 'factsuite-specialist/view-case-detail/'.$candidateId;
    $specialistUser = $this->session->userdata('logged-in-specialist');
    $userID = $specialistUser['team_id'];
    $userRole = $specialistUser['role'];
  
  }else if($this->session->userdata('logged-in-outputqc')){
    
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
  }else{
    echo "<script>$('#back-btn').addClass('d-none');</script>";
  }


?>
  <input type="hidden" value="<?php echo $userID?> " id="userID" name="userID">
  <input type="hidden" value="<?php echo $userRole ?>" id="userRole" name="userRole">



  <div class="pg-cnt">
     <div id="FS-candidate-cnt">
         <!-- <h3>Case Detail</h3> -->
          
          <a class="btn bg-blu btn-submit-cancel" id="back-btn" href="<?php echo $this->config->item('my_base_url').$backLink?>" ><span class="text-white"><i class="fas fa-angle-left"></i>&nbsp;Back</span></a>

          <h3 class="mt-3">PREVIOUS ADDRESS Detail</h3>
          <hr>
          <div class="container detail">
              <h6 class="hd-h6">Personal Details</h6>
            <div class="row mt-4">
              <div class="col-md-2 lft-p-det">
               <p>Case ID</p>
               <p>Candidate Name</p>
               <p>Phone Number</p>
               <p>Email ID</p>
              </div>
              <div class="col-md-1 pr-0">
                 <p>:</p>
                 <p>:</p>
                 <p>:</p>
                 <p>:</p>
              </div>
              <div class="col-md-4 ryt-p pl-0">
                 <p><?php echo $candidateId;?></p>
                 <p><?php echo $candidateName;?></p>
                 <p><?php echo $candidatePhoneNumber;?></p>
                 <p><?php echo $candidateEmail;?></p>
              </div>
              <div class="col-md-2 lft-p-det">
                <p>Client Name</p>
                <p>Package Name</p>
                <p>DOB(date of birth)</p>
              </div>
              <div class="col-md-1 pr-0">
                <p>:</p>
                <p>:</p>
                <p>:</p>
              </div>
              <div class="col-md-2 ryt-p pl-0">
                <p><?php echo $candidateClinetName;?></p>
                <p><?php echo $candidatePackageName;?></p>
                <p><?php echo $candidateDob;?></p>
                <!-- <button class="de-vw">View Document</button> -->
              </div>
            </div>
          </div>
          <hr>
          <!-- <div class="componentData-responsive mt-3" id="">
          <componentData class="componentData componentData-striped">
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
            <tbody class="tbody-datacomponentData" id="get-case-data"> 
            </tbody>
          </componentData>
        </div> -->
        <!--Content-->
          <section id="componentData-allcase">
            <div class="container">
                <div class="detail mb-5">
                  <div class="row hd">
                  <input name="" class="fld form-control previos_address_id" value="<?php echo $componentData['previos_address_id']; ?>" id="previos_address_id" type="hidden">

                      <!-- <div class="col-md-6"><a href="./allcase2.html"><button class="close-bt">Close</button></a></div> -->
                  </div>
                  <?php 
                   // print_r($componentData);
                /*  $form_values = json_decode($componentData['form_values'],true);
	             $form_values = json_decode($form_values,true); 
	             $previous_address = 1;
	            if (isset($form_values[0])?$form_values[0]:0 > 0) {
	               $previous_address = $form_values[0];
	             }  */
	             $j =1;

	          if (isset($componentData['flat_no'])) {
      		          $flat_no = json_decode($componentData['flat_no'],true); 
      		          $street = json_decode($componentData['street'],true); 
      		          $area = json_decode($componentData['area'],true); 
                    $city = json_decode($componentData['city'],true); 
      		          $country = json_decode($componentData['country'],true); 
      		          $pin_code = json_decode($componentData['pin_code'],true); 
      		          $nearest_landmark = json_decode($componentData['nearest_landmark'],true); 
      		          $pre_states = json_decode($componentData['state'],true); 
      		          $contact_person_relationship = json_decode($componentData['contact_person_relationship'],true); 
      		          $duration_of_stay_start = json_decode($componentData['duration_of_stay_start'],true); 
      		          $duration_of_stay_end = json_decode($componentData['duration_of_stay_end'],true); 
      		          $contact_person_name = json_decode($componentData['contact_person_name'],true);  
      		          $contact_person_mobile_number = json_decode($componentData['contact_person_mobile_number'],true); 
      		          $codes = json_decode($componentData['code'],true); 


                    $remarks_address = json_decode($componentData['remarks_address'],true); 
                    $remarks_pincode = json_decode($componentData['remarks_pincode'],true); 
                    $remarks_city = json_decode($componentData['remarks_city'],true); 
                    $remarks_state = json_decode($componentData['remarks_state'],true); 
                    $staying_with = json_decode($componentData['staying_with'],true); 
                    $initiated_date = json_decode($componentData['initiated_date'],true); 

                     $verifier_name = json_decode($componentData['verifier_name'],true); 
                     $period_of_stay = json_decode($componentData['period_of_stay'],true); 
                     $progress_remarks = json_decode($componentData['progress_remarks'],true); 
                     $infuff_remarks = json_decode($componentData['infuff_remarks'],true); 
                     $assigned_to_vendor = json_decode($componentData['assigned_to_vendor'],true); 
                     $closure_date = json_decode($componentData['closure_date'],true); 
                     $relationship = json_decode($componentData['relationship'],true); 
                     $property_type = json_decode($componentData['property_type'],true); 
                     $verification_remarks = json_decode($componentData['verification_remarks'],true); 
                     $closure_remarks = json_decode($componentData['closure_remarks'],true);  
                     $approved_doc = json_decode($componentData['approved_doc'],true);  

                
                    $i=0;
                    $count = count($flat_no);
                    ?>


                    <input name="" class="fld form-control each_count_of_detail" value="<?php echo count($flat_no) ?>" id="each_count_of_detail"  type="hidden">
                    <?php
                    // print_r($states);
                    foreach ($flat_no as $key => $value) {  
                    ?>
                   
                    <div>
                      <h3 class="permt mt-4">PREVIOUS ADDRESS Details <?php echo $i?></h3>
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
                            <p><?php echo isset($value['flat_no'])?$value['flat_no']:'value not found';?></p>
                            <p><?php echo isset($street[$key]['street'])?$street[$key]['street']:'value not found'?></p>
                            <p><?php echo isset($area[$key]['area'])?$area[$key]['area']:'value not found'?></p> 
                            <p><?php echo isset($country[$key]['country'])?$country[$key]['country']:'value not found'?></p> 
                            <p><?php echo isset($city[$key]['city'])?$city[$key]['city']:'value not found'?></p> 
                            <p><?php echo isset($contact_person_name[$key]['contact_person_name'])?$contact_person_name[$key]['contact_person_name']:'value not found'?></p> 
                            <p><?php echo isset($contact_person_mobile_number[$key]['contact_person_mobile_number'])?$contact_person_mobile_number[$key]['contact_person_mobile_number']:'value not found'?></p> 
                         </div>
                          <div class="col-md-2 lft-p-det">
                            <p>Pin Code</p>
                            <p>Nearest Landmark</p>
                            <p>State</p>
                            <p>DURATION OF STAY</p>
                            <p>Reletionship</p>
                          </div>
                          <div class="col-md-1 pr-0">
                              <p>:</p>
                              <p>:</will you join in a connect for us to test this?p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                         </div>
                         <div class="col-md-3 ryt-p pl-0">
                            <p><?php echo isset($pin_code[$key]['pin_code'])?$pin_code[$key]['pin_code']:'value not found';?></p>
                            <p><?php echo isset($nearest_landmark[$key]['nearest_landmark'])?$nearest_landmark[$key]['nearest_landmark']:'value not found'?></p> 
                            <p><?php echo isset($pre_states[$key]['state'])?$pre_states[$key]['state']:'value not found'?></p> 
                            <p><?php echo isset($duration_of_stay_start[$key]['duration_of_stay_start'])?$duration_of_stay_start[$key]['duration_of_stay_start']:'value not found'?> TO <?php echo isset($duration_of_stay_end[$key]['duration_of_stay_end'])?$duration_of_stay_end[$key]['duration_of_stay_end']:'value not found'?></p>
                            <p><?php echo isset($contact_person_relationship[$key]['contact_person_relationship'])?$contact_person_relationship[$key]['contact_person_relationship']:'value not found'?></p> 
                         </div>
                      </div>
                    </div>
                    <h3 class="permt mt-4">PREVIOUS ADDRESS verification information <?php echo $i?></h3>
                       <div class="row mt-3"> 
                        <div class="col-md-6">
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Address</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">  
                              <textarea class="fld form-control address" onkeyup="valid_address(<?php echo $i; ?>)" onblur="valid_address(<?php echo $i; ?>)" rows="4" id="address<?php echo $i; ?>" spellcheck="false"><?php echo isset($remarks_address[$key]['remarks_address'])?$remarks_address[$key]['remarks_address']:''; ?></textarea>
                              <div id="address-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">State</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                             <!--  <input name="" class="fld form-control state" value="<?php //echo isset($remarks_state[$key]['remarks_state'])?$remarks_state[$key]['remarks_state']:''; ?>" onkeyup="valid_state(<?php //echo $i; ?>)" onblur="valid_state(<?php //echo $i; ?>)"  id="state<?php //echo $i; ?>" type="text"> -->

                              <select class="fld form-control state" id="state<?php echo $i; ?>" onchange="valid_state(<?php echo $i; ?>)">
                                <?php
                                // print_r($states);
                                 $stateName = isset($remarks_state[$key]['remarks_state'])?$remarks_state[$key]['remarks_state']:'';
                                  foreach ($states as $keyState => $stateValue) {
                                    
                                    if($stateValue['name'] == $stateName){
                                      echo '<option selected value="'.$stateValue['name'].'">'.$stateValue['name'].'</option>';
                                    }else{
                                      echo '<option value="'.$stateValue['name'].'">'.$stateValue['name'].'</option>';
                                    }
                                  }
                                ?>
                                <!--   -->
                              </select>
                              <div id="state-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Staying with</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                            <!--   <input name="" class="fld form-control staying_with" value="<?php //echo isset($staying_with[$key]['staying_with'])?$staying_with[$key]['staying_with']:''; ?>" onkeyup="valid_staying_with(<?php //echo $i; ?>)" onblur="valid_staying_with(<?php //echo $i; ?>)"   id="staying_with<?php //echo $i; ?>" type="text"> -->
                              <?php 
                                $Family = '';
                                $Friends = '';
                                $Alone = '';
                                $staying_with = isset($staying_with[$key]['staying_with'])?$staying_with[$key]['staying_with']:'';
                                if('Family' == $staying_with){
                                  $Family = 'selected';
                                }else if('Friends' == $staying_with){
                                  $Friends = 'selected';
                                }else if('Alone' == $staying_with){
                                  $Alone = 'selected';
                                }
                              ?>
                              <!-- <?php //echo 'key:'.$key;?> -->
                              <select class="fld form-control staying_with" id="staying_with<?php echo $i; ?>" 
                                onchange="valid_staying_with(<?php echo $i; ?>)">
                                <option <?php echo $Family ?> value="Family">Family</option>
                                <option <?php echo $Friends ?> value="Friends">Friends</option>
                                <option <?php echo $Alone ?> value="Alone">Alone</option>
                              </select>
                              <div id="staying_with-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Vendor Initiated Date</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control initiated_date mdate" readonly value="<?php echo isset($initiated_date[$key]['initiated_date'])?$initiated_date[$key]['initiated_date']:''; ?>"  onchange="valid_initiated_date(<?php echo $i; ?>)" onblur="valid_initiated_date(<?php echo $i; ?>)" id="initiated_date<?php echo $i; ?>" type="text">
                              <div id="initiated_date-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Vendor Closure date</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control closure_date mdate" readonly value="<?php echo isset($closure_date[$key]['closure_date'])?$closure_date[$key]['closure_date']:''; ?>" onchange="valid_closure_date(<?php echo $i; ?>)" onblur="valid_closure_date(<?php echo $i; ?>)" id="closure_date<?php echo $i; ?>" type="text">
                              <div id="closure_date-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>

                           <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Verifier Name</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control verifier_name" value="<?php echo isset($verifier_name[$key]['verifier_name'])?$verifier_name[$key]['verifier_name']:''; ?>" onkeyup="valid_verifier_name(<?php echo $i; ?>)" onblur="valid_verifier_name(<?php echo $i; ?>)" id="verifier_name<?php echo $i; ?>" type="text">
                              <div id="verifier_name-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>

                           <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Period of Stay</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control period_of_stay" value="<?php echo isset($period_of_stay[$key]['period_of_stay'])?$period_of_stay[$key]['period_of_stay']:''; ?>" onkeyup="valid_period_of_stay(<?php echo $i; ?>)" onblur="valid_period_of_stay(<?php echo $i; ?>)" id="period_of_stay<?php echo $i; ?>" type="text">
                            <div id="period_of_stay-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>

                           <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">In Progress Remarks</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control progress_remarks" value="<?php echo isset($progress_remarks[$key]['progress_remarks'])?$progress_remarks[$key]['progress_remarks']:''; ?>" onkeyup="valid_progress_remarks(<?php echo $i; ?>)" onblur="valid_progress_remarks(<?php echo $i; ?>)" id="progress_remarks<?php echo $i; ?>" type="text">
                              <div id="progress_remarks-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>

                           <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Insuff Remarks</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control infuff_remarks" value="<?php echo isset($infuff_remarks[$key]['infuff_remarks'])?$infuff_remarks[$key]['infuff_remarks']:''; ?>"  onkeyup="valid_infuff_remarks(<?php echo $i; ?>)" onblur="valid_infuff_remarks(<?php echo $i; ?>)" id="infuff_remarks<?php echo $i; ?>" type="text">
                              <div id="infuff_remarks-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>
                           <div class="row mt2">
                            <div class="add-vendor-bx2">
                              <h3 class="m-0">&nbsp;</h3>
                              <ul>
                                 <li class="vendor-wdt2">
                                    <p class="lft-p-det">Verification Proof Upload Section</p>
                                    <div class="form-group mb-0">
                                      <input type="file" class="client-documents" id="client-documents<?php echo $i; ?>" name="criminal-documents[]" multiple="multiple">
                                      <label class="btn upload-btn" for="client-documents<?php echo $i; ?>">Upload</label>
                                    </div>
                                    <div id="criminal-upoad-docs-error-msg-div<?php echo $i; ?>"><?php
                               $pan_card_doc = '';
                                 if (isset($approved_doc[$key])) {
                                 if (!in_array('no-file',$approved_doc[$key])) {
                                   foreach ($approved_doc[$key] as $key1 => $value) {
                                      if ($value !='') {
                                     echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"remarks-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                      }
                                   }
                                 $pan_card_doc = $approved_doc[$key];
                                 }} 
                                 ?></div>
                                 </li> 
                              </ul>
                              <div class="row" id="selected-criminal-docs-li<?php echo $i; ?>"></div>
                           </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">City</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control city" value="<?php echo isset($remarks_city[$key]['remarks_city'])?$remarks_city[$key]['remarks_city']:''; ?>" onkeyup="valid_city(<?php echo $i; ?>)" onblur="valid_city(<?php echo $i; ?>)" id="city<?php echo $i; ?>" type="text">
                              <div id="city-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Pin Code</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control pincode" value="<?php echo isset($remarks_pincode[$key]['remarks_pincode'])?$remarks_pincode[$key]['remarks_pincode']:''; ?>" onkeyup="valid_pincode(<?php echo $i; ?>)" onblur="valid_pincode(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="pincode<?php echo $i; ?>" type="text">
                              <div id="pincode-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Assigned To Vendor</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control assigned_to_vendor" value="<?php echo isset($assigned_to_vendor[$key]['assigned_to_vendor'])?$assigned_to_vendor[$key]['assigned_to_vendor']:''; ?>" onkeyup="valid_assigned_to_vendor(<?php echo $i; ?>)" onblur="valid_assigned_to_vendor(<?php echo $i; ?>)" id="assigned_to_vendor<?php echo $i; ?>" type="text">
                              <div id="assigned_to_vendor-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>
                          
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Verifier Relationship</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <!-- <input name="" class="fld form-control relationship" value="<?php echo isset($relationship[$key]['relationship'])?$relationship[$key]['relationship']:''; ?>" onkeyup="valid_relationship(<?php echo $i; ?>)" onblur="valid_relationship(<?php echo $i; ?>)" id="relationship<?php echo $i; ?>" type="text"> -->

                              <?php 
                                $Self = '';
                                $Parent = '';
                                $Spouse = '';
                                $Friend = '';
                                $Relative = '';
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
                                }
                              ?>
                              <select class="fld form-control relationship" id="relationship<?php echo $i; ?>" 
                                onchange="valid_relationship(<?php echo $i; ?>)">
                                <option <?php echo $Self ?> value="Self">Self</option>
                                <option <?php echo $Parent ?> value="Parent">Parent</option>
                                <option <?php echo $Spouse ?> value="Spouse">Spouse</option>
                                <option <?php echo $Friend ?> value="Friend">Friend</option>
                                <option <?php echo $Relative ?> value="Relative">Relative</option>
                              </select>
                              <div id="relationship-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Property Type</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <!-- <input name="" class="fld form-control property_type" value="<?php //echo isset($property_type[$key]['property_type'])?$property_type[$key]['property_type']:''; ?>" onkeyup="valid_property_type(<?php //echo $i; ?>)" onblur="valid_property_type(<?php //echo $i; ?>)" id="property_type<?php// echo $i; ?>" type="text"> -->
                              <?php 
                                $Rented = '';
                                $Owned = '';
                                $others = '';
                                $property_type_data = isset($property_type[$key]['property_type'])?$property_type[$key]['property_type']:'';  
                                if('Rented' == $property_type_data){
                                  $Rented = 'selected';
                                }else if('Owned' == $property_type_data){
                                  $Owned = 'selected';
                                }else if('others' == $property_type_data){
                                  $others = 'selected';
                                }
                              ?>
                              <select class="fld form-control property_type" onchange="valid_property_type(<?php echo $i; ?>)"id="property_type<?php echo $i; ?>">
                                <option <?php echo $Rented ?> value="Rented">Rented</option>
                                <option <?php echo $Owned ?> value="Owned">Owned</option>
                                <option <?php echo $others ?> value="Others">Others</option>
                              </select>
                              <div id="property_type-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Verification Remarks</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control verification_remarks" value="<?php echo isset($verification_remarks[$key]['verification_remarks'])?$verification_remarks[$key]['verification_remarks']:''; ?>" onkeyup="valid_verification_remarks(<?php echo $i; ?>)" onblur="valid_verification_remarks(<?php echo $i; ?>)" id="verification_remarks<?php echo $i; ?>" type="text">
                              <div id="verification_remarks-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>

                           <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Insuff Closure Remarks</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control closure_remarks" value="<?php echo isset($closure_remarks[$key]['closure_remarks'])?$closure_remarks[$key]['closure_remarks']:''; ?>" onkeyup="valid_closure_remarks(<?php echo $i; ?>)" onblur="valid_closure_remarks(<?php echo $i; ?>)" id="closure_remarks<?php echo $i; ?>" type="text">
                              <div id="closure_remarks-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div> 
                        </div>
                    </div>
                    <hr>  
                  <?php 
                    $i++;
                    } 

                }
                  ?>
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
                        if($componentData['analyst_status'] == 0){
                          $defaultStatus = 'selected';
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
                        }
                        
                        $subTitle = '';
                        $selectOpStatusEnable = 'd-none';
                        if($outputQCStatus == 'disabled'){
                          $subTitle = 'Analyst component status';
                          $selectOpStatusEnable = '';
                        }else{
                          $subTitle = 'Select component status';
                        }
                         

                      ?>
                      <p class="det"><?php echo $subTitle; ?></p>
                      <select id="action_status" <?php echo $disabled." ".$outputQCStatus; ?> name="carlist" class="sel-allcase">
                        <option <?php echo $defaultStatus ?> value="0">Select your Action</option>
                        <option <?php echo $insuffStatus ?> value="3">Insufficient</option>
                        <option <?php echo $verifiedclearStatus ?> value="4">Verified Clear</option>
                        <option <?php echo $stopcheckStatus ?> value="5">Stop check</option> 
                        <option <?php echo $utv ?> value="6">Unable to verify</option> 
                        <option <?php echo $vd ?> value="7">Verified discrepancy</option> 
                        <option <?php echo $cc ?> value="8">Client clarification</option> 
                        <option <?php echo $ci ?> value="9">Closed Insufficiency</option>
                        <?php 
                          if($componentData['analyst_status'] == '10'){
                            echo '<option selected value="10">QC Error</option>';
                          } 
                        ?>
                      </select>
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
                </div>
                <hr>
                  <div class="row mt-2">
                    <div class="col-md-6">
                      
                    </div>
                    <div class="col-md-6 text-right">
                      <input type="hidden" value="<?php echo $componentData['candidate_id']?>" id="candidate_id_hidden"name="">
                      <a href="<?php echo $this->config->item('my_base_url').$backLink?>"><button class="close-bt">Close</button></a>
                      <!-- <button id="submit-previous-address" class="update-bt">Update</button> -->
                       <button class="update-bt" data-toggle="modal" data-target="#conformtion">Update</button> 
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
<div id="conformtion" class="modal fade">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
             <h3 class="snd-mail-pop">Are you confirm?</h3>
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
                <button class="btn bg-blu float-right text-white" id="submit-previous-address">Confirm</button>
             <div class="clr"></div>
          </div>
       </div>
    </div>
</div>

<!-- Popup Content -->


  <div class="modal fade " id="myModal-show" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
        </div>
        <div class="modal-body">
         <div id="view-img"></div>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center">
              <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
           </div>
        </div>
      </div>
    </div>
  </div>


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
<script>
  var count = <?php echo $count; ?>
</script>
<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/remark-previous-address.js"></script>


