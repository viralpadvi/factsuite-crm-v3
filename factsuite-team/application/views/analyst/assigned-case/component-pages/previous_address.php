<?php 
  $candidateId =  isset($componentData['candidate_id'])?$componentData['candidate_id']:"2";
  $candidateName =  $componentData['first_name']." ".$componentData['last_name'];
  $candidateClinetName =  isset($componentData['client_name'])?$componentData['client_name']:"2";
  $code =  isset($componentData['country_code'])?$componentData['country_code']:"+91";
  $candidatePhoneNumber =  $code.' '.isset($componentData['phone_number'])?$componentData['phone_number']:"1234567890";
  $candidatePackageName =  isset($componentData['package_name'])?$componentData['package_name']:"2";
  $candidateEmail =  isset($componentData['email_id'])?$componentData['email_id']:"2";
  $php_code_selected_datetime_format = explode(' ',$selected_datetime_format['php_code']);
  $candidateDob =  isset($componentData['date_of_birth'])?date($php_code_selected_datetime_format[0],strtotime($componentData['date_of_birth'])):"-";
  $previos_address_id =  isset($componentData['previos_address_id'])?$componentData['previos_address_id']:"0";$candidateFatherName =  isset($componentData['father_name'])?$componentData['father_name']:"No data Found"; 
  $candidateEmployeeId =  isset($componentData['employee_id'])?$componentData['employee_id']:"No data Found";
  $priority =  isset($componentData['priority'])?$componentData['priority']:"0";

 $candidate_address =  isset($componentData['candidate_addresss'])?$componentData['candidate_addresss']:"-";
  $nationality =  isset($componentData['nationality'])?$componentData['nationality']:"-";
  $candidate_state =  isset($componentData['candidate_state'])?$componentData['candidate_state']:"-";
  $candidate_city =  isset($componentData['candidate_city'])?$componentData['candidate_city']:"-";
  $candidate_pincode =  isset($componentData['candidate_pincode'])?$componentData['candidate_pincode']:"000000";
  $iverify_or_pv_status =  isset($componentData['iverify_or_pv_status'])?$componentData['iverify_or_pv_status']:"0";
  $remarks = isset($componentData['remark'])?$componentData['remark']:"";
  $backLink = '';
  $userRole = '';
  $userID = '';
  $outputQCStatus = ''; 
if (empty($remarks)) {
  $remarks ="NA";
}
  $inputqc_status_date = explode(',',isset($componentData['inputqc_status_date'])?$componentData['inputqc_status_date']:date('d-m-Y H:i:s'));
  $analyst_status_date = explode(',', isset($componentData['analyst_status_date'])?$componentData['analyst_status_date']:date('d-m-Y H:i:s'));

  $analyst_specialist_status_date = 'NA';
  $show_analyst_specialist_verification_days_taken = 'NA';
  $analyst_status_date_time = date('d-m-Y');
    $inputqc_status_date_time = isset($inputqc_status_date[$index])?$inputqc_status_date[$index]:date('d-m-Y H:i:s');
  if ($componentData['inputqc_status_date'] !='' && $componentData['inputqc_status_date'] !='NA' && $componentData['analyst_status_date'] != '' && $componentData['analyst_status_date'] != 'NA') {
      $analyst_specialist_status_date = isset($analyst_status_date[$index])?$analyst_status_date[$index]:date('d-m-Y H:i:s');
      $analyst_specialist_status_date_time_splitted = $analyst_specialist_status_date;
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
  <input type="hidden" value="<?php echo $index ?>" id="componentIndex" name="componentIndex">
   <input type="hidden" value="<?php echo $previos_address_id ?>" id="previos_address_id" name="previos_address_id">
  <input type="hidden" value="<?php echo $priority ?>" id="priority" name="priority">

  <input type="hidden" id="selected-hidden-candidate-id" value="<?php echo $candidateIdLink;?>">
  <input type="hidden" id="selected-hidden-component-id" value="<?php echo $component_id;?>">
  <input type="hidden" id="selected-hidden-component-index" value="<?php echo $index;?>">
  <input type="hidden" id="selected-hidden-user-component-form-filled-id" value="<?php echo $previos_address_id;?>">

  <input type="hidden" value="<?php echo $componentData['candidate_id']?>" id="candidate_id_hidden" name="">
  
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-analyst">
         <!-- <h3>Case Detail</h3> -->
          
          <a class="btn bg-blu btn-submit-cancel" id="back-btn" href="<?php echo $this->config->item('my_base_url').$backLink?>" ><span class="text-white"><i class="fas fa-angle-left"></i>&nbsp;Back</span></a>

          <h3 class="mt-3">Previous Address Form Detail (Form<?php echo $num = ($index+1) ?>)</h3>
          <hr>
          <div class="container detail">
              <!-- <h6 class="hd-h6"><p>Last Updated By :</p>
"">Personal Details</h6> -->
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
                    $insuff_remarks = json_decode($componentData['insuff_remarks'],true); 
                    $assigned_to_vendor = json_decode($componentData['assigned_to_vendor'],true); 
                    $closure_date = json_decode($componentData['closure_date'],true); 
                    $relationship = json_decode($componentData['relationship'],true); 
                    $property_type = json_decode($componentData['property_type'],true); 
                    $verification_remarks = json_decode($componentData['verification_remarks'],true); 
                    $closure_remarks = json_decode($componentData['closure_remarks'],true);  
                    $approved_doc = json_decode($componentData['approved_doc'],true); 


                    $rental_agreement = json_decode($componentData['rental_agreement'],true);  
                    $ration_card = json_decode($componentData['ration_card'],true);  
                    $gov_utility_bill = json_decode($componentData['gov_utility_bill'],true);  

                    $ouputqc_comment = json_decode($componentData['ouputqc_comment'],true);

                    $verified_date = json_decode($componentData['verified_date'],true);
                    $iverify_or_pv_status = explode(',',$iverify_or_pv_status);
                    $i=$index;
                    $key=$index;
                    $count = count($flat_no);
                    ?>


                    <input name="" class="fld form-control each_count_of_detail" value="<?php echo count($flat_no) ?>" id="each_count_of_detail"  type="hidden">
                    <?php
                    // print_r($flat_no);
                    // foreach ($flat_no as $key => $value) {  
                    ?>
                   
                    <div>
                      <h3 class="permt mt-4">Previous Address Detail (Form<?php echo $num = ($index+1) ?>)</h3>
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
                            <p><?php echo isset($flat_no[$key]['flat_no'])?$flat_no[$key]['flat_no']:'value not found';?></p>
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

                            <p><?php echo isset($pin_code[$key]['pin_code'])?$pin_code[$key]['pin_code']:'value not found';?></p>
                            <p><?php echo isset($nearest_landmark[$key]['nearest_landmark'])?$nearest_landmark[$key]['nearest_landmark']:'value not found'?></p> 
                            <p><?php echo isset($pre_states[$key]['state'])?$pre_states[$key]['state']:'value not found'?></p> 
                            <p><?php echo isset($duration_of_stay_start[$key]['duration_of_stay_start'])?date('m/Y',strtotime($duration_of_stay_start[$key]['duration_of_stay_start'])):'value not found'?> TO <?php echo isset($duration_of_stay_end[$key]['duration_of_stay_end'])?date('m/Y',strtotime($duration_of_stay_end[$key]['duration_of_stay_end'])):'value not found'?></p>
                            <p><?php echo isset($contact_person_relationship[$key]['contact_person_relationship'])?$contact_person_relationship[$key]['contact_person_relationship']:'value not found'?></p> 
                         </div>
                      </div>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-md-4">
                        <label class="permt mt-4">Rental Docs</label>
                        <?php
                               // $rental_agreement = '';
                                 if (isset($rental_agreement[$key])) {
                                 if (!in_array('no-file',$rental_agreement[$key])) {
                                   foreach ($rental_agreement[$key] as $key1 => $value) {
                                      if ($value !='') {
                                        $url = base_url()."../uploads/rental-docs/".$value;
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
                        <label class="permt mt-4">Ration Card Docs</label>
                        <?php
                               // $rental_agreement = '';
                                 if (isset($ration_card[$key])) {
                                 if (!in_array('no-file',$ration_card[$key])) {
                                   foreach ($ration_card[$key] as $key1 => $value) {
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
                                 if (isset($gov_utility_bill[$key])) {
                                 if (!in_array('no-file',$gov_utility_bill[$key])) {
                                   foreach ($gov_utility_bill[$key] as $key1 => $value) {
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
                    <h3 class="permt mt-4">Previous Address Detail (Form<?php echo $num = ($index+1) ?>) verification Details </h3>
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
                              <textarea class="fld form-control address" onkeyup="valid_address(<?php echo $i; ?>)" onblur="valid_address(<?php echo $i; ?>)" rows="4" id="address<?php echo $i; ?>" spellcheck="false"><?php echo isset($remarks_address[$key]['address'])?$remarks_address[$key]['address']:''; ?></textarea>
                              <div id="address-error<?php echo $i; ?>">&nbsp;</div>
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
                             <!--  <input name="" class="fld form-control state" value="<?php //echo isset($remarks_state[$key]['remarks_state'])?$remarks_state[$key]['remarks_state']:''; ?>" onkeyup="valid_state(<?php //echo $i; ?>)" onblur="valid_state(<?php //echo $i; ?>)"  id="state<?php //echo $i; ?>" type="text"> -->

                              <select class="fld form-control state select2" id="state<?php echo $i; ?>" onchange="valid_state(<?php echo $i; ?>)">
                                <?php
                                // print_r($states);
                                 $stateName = isset($remarks_state[$key]['remarks_state'])?$remarks_state[$key]['remarks_state']:'Karnataka';
                                  $city_id = '';
                                  $state = '';
                                  if($stateName != '' && $stateName != null){
                                    $state = $stateName;
                                  }else{
                                    $state = 'Karnataka';
                                  }
                                  foreach ($states as $keyState => $stateValue) {
                                    if($stateValue['name'] == $state){
                                      echo '<option data-id="'.$stateValue['id'].'" selected value="'.$stateValue['name'].'">'.$stateValue['name'].'</option>';
                                    $city_id = $stateValue['id'];
                                    }else{
                                      echo '<option data-id="'.$stateValue['id'].'" value="'.$stateValue['name'].'">'.$stateValue['name'].'</option>';
                                    }
                                  }
                                ?>
                                <!--   -->
                              </select>
                              <div id="state-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <!-- City -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">City</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <!-- <input name="" class="fld form-control city" value="<?php echo isset($remarks_city[$key]['city'])?$remarks_city[$key]['city']:''; ?>" onkeyup="valid_city(<?php echo $i; ?>)" onblur="valid_city(<?php echo $i; ?>)" id="city<?php echo $i; ?>" type="text"> -->
                              <select  class="fld form-control city select2" value="<?php echo isset($remarks_city[$key]['city'])?$remarks_city[$key]['city']:''; ?>" onchange="valid_city(<?php echo $i; ?>)" onblur="valid_city(<?php echo $i; ?>)" id="city<?php echo $i; ?>">
                                 <?php 
                                  $get_city = isset($remarks_city[$key]['city'])?$remarks_city[$key]['city']:''; 
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
                              <div id="city-error<?php echo $i; ?>">&nbsp;</div>
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

                              <input name="" class="fld form-control pincode" value="<?php echo isset($remarks_pincode[$key]['pincode'])?$remarks_pincode[$key]['pincode']:''; ?>" onkeyup="valid_pincode(<?php echo $i; ?>)" onblur="valid_pincode(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="pincode<?php echo $i; ?>" type="text">
                              <div id="pincode-error<?php echo $i; ?>">&nbsp;</div>
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
                            <!--   <input name="" class="fld form-control staying_with" value="<?php //echo isset($staying_with[$key]['staying_with'])?$staying_with[$key]['staying_with']:''; ?>" onkeyup="valid_staying_with(<?php //echo $i; ?>)" onblur="valid_staying_with(<?php //echo $i; ?>)"   id="staying_with<?php //echo $i; ?>" type="text"> -->
                              <?php 
                                $Family = '';
                                $Friends = '';
                                $Alone = '';
                                $Relatives = '';
                                $staying_with = isset($staying_with[$key]['staying_with'])?$staying_with[$key]['staying_with']:'';
                                if('Family' == $staying_with){
                                  $Family = 'selected';
                                }else if('Friends' == $staying_with){
                                  $Friends = 'selected';
                                }else if('Alone' == $staying_with){
                                  $Alone = 'selected';
                                }else if('Relatives' == $staying_with){
                                  $Relatives = 'selected';
                                }
                              ?>
                              <!-- <?php //echo 'key:'.$key;?> -->
                              <select class="fld form-control staying_with" id="staying_with<?php echo $i; ?>" 
                                onchange="valid_staying_with(<?php echo $i; ?>)">
                                <option <?php echo $Family ?> value="Family">Family</option>
                                <option <?php echo $Friends ?> value="Friends">Friends</option>
                                <option <?php echo $Alone ?> value="Alone">Alone</option>
                                <option <?php echo $Relatives ?> value="Relatives">Relatives</option>
                                 
                              </select>
                              <div id="staying_with-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <!-- Verifier Name -->
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
                          <!-- In Progress Remarks -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">In Progress Remarks</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7"> 
                              <textarea class="fld form-control progress_remarks" onkeyup="valid_progress_remarks(<?php echo $i; ?>)" onblur="valid_progress_remarks(<?php echo $i; ?>)" id="progress_remarks<?php echo $i; ?>"><?php echo isset($progress_remarks[$key]['progress_remarks'])?$progress_remarks[$key]['progress_remarks']:''; ?></textarea>
                              <div id="progress_remarks-error<?php echo $i; ?>">&nbsp;</div>
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
                              <textarea class="fld form-control infuff_remarks" onkeyup="valid_infuff_remarks(<?php echo $i; ?>)" onblur="valid_infuff_remarks(<?php echo $i; ?>)" id="infuff_remarks<?php echo $i; ?>"><?php echo isset($insuff_remarks[$key]['insuff_remarks'])?$insuff_remarks[$key]['insuff_remarks']:''; ?></textarea>
                              <div id="infuff_remarks-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <!-- Verification Proof Upload Section -->
                          <div class="row mt2">
                            <div class="add-vendor-bx2">
                              <h3 class="m-0">&nbsp;</h3>
                              <ul>
                                 <li class="vendor-wdt2">
                                    <p class="lft-p-det">Verification Proof Upload Section</p>
                                    <div class="form-group mb-0">
                                      <input type="file" class="client-documents" id="client-documents" name="criminal-documents[]" multiple="multiple">
                                      <label class="btn upload-btn" for="client-documents">Upload</label>
                                    </div>
                                    <div id="criminal-upoad-docs-error-msg-div">
                                      <?php
                                         $pan_card_doc = '';
                                           if (isset($approved_doc[$key])) {
                                           if (!in_array('no-file',$approved_doc[$key])) {
                                             foreach ($approved_doc[$key] as $key1 => $value) {
                                                if ($value !='') {
                                                  $url = base_url()."../uploads/remarks-docs/".$value;
                                                  echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a> <a href='{$url}' download >  <i class='fa fa-download'></i></a></span></div>";
                                                }
                                             }
                                           $pan_card_doc = $approved_doc[$key];
                                          }
                                        } 
                                      ?>
                                    </div>
                                  </li> 
                              </ul>
                              <div class="row" id="selected-criminal-docs-li"></div>
                           </div>
                          </div>
                        </div>
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
                              <input name="" class="fld form-control period_of_stay" value="<?php echo isset($period_of_stay[$key]['period_of_stay'])?$period_of_stay[$key]['period_of_stay']:''; ?>" onkeyup="valid_period_of_stay(<?php echo $i; ?>)" onblur="valid_period_of_stay(<?php echo $i; ?>)" id="period_of_stay<?php echo $i; ?>" type="text">
                            <div id="period_of_stay-error<?php echo $i; ?>">&nbsp;</div>
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
                              <input name="" class="fld form-control assigned_to_vendor" value="<?php echo isset($assigned_to_vendor[$key]['assigned_to_vendor'])?$assigned_to_vendor[$key]['assigned_to_vendor']:''; ?>" onkeyup="valid_assigned_to_vendor(<?php echo $i; ?>)" onblur="valid_assigned_to_vendor(<?php echo $i; ?>)" id="assigned_to_vendor<?php echo $i; ?>" type="text">
                              <div id="assigned_to_vendor-error<?php echo $i; ?>">&nbsp;</div>
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
                              <input name="" class="fld form-control initiated_date mdate" readonly value="<?php echo isset($initiated_date[$key]['initiated_date'])?$initiated_date[$key]['initiated_date']:''; ?>"  onchange="valid_initiated_date(<?php echo $i; ?>)" onblur="valid_initiated_date(<?php echo $i; ?>)" id="initiated_date<?php echo $i; ?>" type="text">
                              <div id="initiated_date-error<?php echo $i; ?>">&nbsp;</div>
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
                              <input name="" class="fld form-control closure_date mdate" readonly value="<?php echo isset($closure_date[$key]['closure_date'])?$closure_date[$key]['closure_date']:''; ?>" onchange="valid_closure_date(<?php echo $i; ?>)" onblur="valid_closure_date(<?php echo $i; ?>)" id="closure_date<?php echo $i; ?>" type="text">
                              <div id="closure_date-error<?php echo $i; ?>">&nbsp;</div>
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
                              <!-- <input name="" class="fld form-control relationship" value="<?php echo isset($relationship[$key]['relationship'])?$relationship[$key]['relationship']:''; ?>" onkeyup="valid_relationship(<?php echo $i; ?>)" onblur="valid_relationship(<?php echo $i; ?>)" id="relationship<?php echo $i; ?>" type="text"> -->

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
                              <select class="fld form-control relationship" id="relationship<?php echo $i; ?>" 
                                onchange="valid_relationship(<?php echo $i; ?>)">
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
                              <div id="relationship-error<?php echo $i; ?>">&nbsp;</div>
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
                          <!-- Verification Remarks -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Verification Remarks</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7"> 
                              <textarea class="fld form-control verification_remarks" onkeyup="valid_verification_remarks(<?php echo $i; ?>)" onblur="valid_verification_remarks(<?php echo $i; ?>)" id="verification_remarks<?php echo $i; ?>"><?php echo isset($verification_remarks[$key]['verification_remarks'])?$verification_remarks[$key]['verification_remarks']:''; ?></textarea> 
                              <div id="verification_remarks-error<?php echo $i; ?>">&nbsp;</div>
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
                                $verified = isset($verified_date[$key]['verified_date'])?$verified_date[$key]['verified_date']:'';
                                if($verified == 'Invalid Date' || $verified == 'Invalid date' || $verified == 'invalid Date'){
                                  $verifieds ='';
                                }
                                $verified = $this->utilModel->get_date($verified);

                                if (strtolower($verified) !='na' && strtolower($verified) !='01-01-1970') {}else{
                                   $verified ='';
                                }
                              ?>
                              <input name="" class="fld form-control mdate verified_date" value="<?php echo $verified; ?>" id="verified_date<?php echo $i; ?>" type="text"> 
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
                              <textarea class="fld form-control closure_remarks" onkeyup="valid_closure_remarks(<?php echo $i; ?>)" onblur="valid_closure_remarks(<?php echo $i; ?>)" id="closure_remarks<?php echo $i; ?>"><?php echo isset($closure_remarks[$key]['closure_remarks'])?$closure_remarks[$key]['closure_remarks']:''; ?></textarea>
                              <div id="closure_remarks-error<?php echo $i; ?>">&nbsp;</div>
                            </div>
                          </div> 
                        </div>
                    </div>
                    <hr>  
                  <?php 
                    // $i++;
                    // } 

                }
                  ?>
                    <div class="row mt-2">
                    <div class="col-md-6">

                      
                      <?php
                        $analyst_status = explode(",", $componentData['analyst_status']);
                        $analyst_status = isset($analyst_status[$index])?$analyst_status[$index]:'0';
                        $defaultStatus = '';
                        $insuffStatus = '';
                        $verifiedclearStatus = '';
                        $stopcheckStatus = '';
                        $utv = '';
                        $vd = '';
                        $cc = '';
                        $ci ='';
                        $ni ='';
                        $disabled = '';
                        $disabledOP = '';
                        $progress ='';
                        if($analyst_status == 0){
                          $defaultStatus = 'selected';
                        }else if($analyst_status == 1){
                          $progress ='selected';
                        }else if($analyst_status == 3){
                          $insuffStatus = 'selected';
                        }else if($analyst_status == 4){
                          $verifiedclearStatus = 'selected';
                          // $disabled = 'disabled';
                        }else if($analyst_status == 5){
                          $stopcheckStatus = 'selected';
                        }else if($analyst_status == 6){
                          $utv = 'selected';
                        }else if($analyst_status == 7){
                          $vd = 'selected';
                        }else if($analyst_status == 8){
                          $cc = 'selected';
                        }else if($analyst_status == 9){
                          $ci = 'selected';
                        }else if($analyst_status == 11){
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
                      $iverify_or_pv_form_status = isset($iverify_or_pv_status[$key]) ? $iverify_or_pv_status[$key] : 0;
                      if ($iverify_or_pv_form_status == 1) {
                         $iverify_checked = ' checked';
                      } else if($iverify_or_pv_form_status == 2) {
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
                          rows="3" ><?php echo isset($ouputqc_comment[$index]['ouputQcComment'])?$ouputqc_comment[$index]['ouputQcComment']:'' ?></textarea>
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
                <button class="btn bg-blu float-right text-white" id="submit-previous-address">Confirm</button>
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
<script>
  var count = <?php echo $count; ?>
</script>
<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/remark-previous-address.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/commonImageView.js"></script>

<script type="text/javascript">
  phpData(<?php echo json_encode($componentData)?>)
</script>
 

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