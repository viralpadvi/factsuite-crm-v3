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
  $analyst_status =  isset($componentData['analyst_status'])?$componentData['analyst_status']:"0";
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
          /* $analyst_specialist_status_date_splitted = explode('-',$analyst_specialist_status_date_time_splitted);
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
  <input type="hidden" value="<?php echo $priority ?>" id="priority" name="priority">
  <input type="hidden" value="<?php echo $componentData['landload_id']; ?>" id="landload_id" name="landload_id">

<input type="hidden" id="selected-hidden-candidate-id" value="<?php echo $candidateIdLink;?>">
  <input type="hidden" id="selected-hidden-component-id" value="<?php echo $component_id;?>">
  <input type="hidden" id="selected-hidden-component-index" value="<?php echo $index;?>">
  <input type="hidden" id="selected-hidden-user-component-form-filled-id" value="<?php echo $componentData['landload_id']; ?>">
  <input type="hidden" value="<?php echo $componentData['candidate_id']?>" id="candidate_id_hidden" name="">
  
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-analyst">
         <!-- <h3>Case Detail</h3> -->
          
          <a class="btn bg-blu btn-submit-cancel" id="back-btn" href="<?php echo $this->config->item('my_base_url').$backLink?>" ><span class="text-white"><i class="fas fa-angle-left"></i>&nbsp;Back</span></a>

          <h3 class="mt-3">Landlord Reference Form Detail(Form<?php echo $num = ($index+1) ?>)</h3>
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
          <section id="componentData-allcase">
            <div class="container">
                <div class="detail mb-5">
                  <div class="row hd">
                  </div>
      <?php 
           
        $j =1;
          // print_r($componentData);
        if (isset($componentData['landload_id'])) {
             $tenant_name = json_decode($componentData['tenant_name'],true);
$case_contact_no = json_decode($componentData['case_contact_no'],true);
$landlord_name = json_decode($componentData['landlord_name'],true);


$tenancy_period = json_decode($componentData['tenancy_period'],true);
$tenancy_period_comment = json_decode($componentData['tenancy_period_comment'],true);
$monthly_rental_amount = json_decode($componentData['monthly_rental_amount'],true);
$monthly_rental_amount_comment = json_decode($componentData['monthly_rental_amount_comment'],true);
$occupants_property = json_decode($componentData['occupants_property'],true);
$occupants_property_comment = json_decode($componentData['occupants_property_comment'],true);
$tenant_consistently_pay_rent_on_time = json_decode($componentData['tenant_consistently_pay_rent_on_time'],true);
$tenant_consistently_pay_rent_on_time_comment = json_decode($componentData['tenant_consistently_pay_rent_on_time_comment'],true);
$utility_bills_paid_on_time = json_decode($componentData['utility_bills_paid_on_time'],true);
$utility_bills_paid_on_time_comment = json_decode($componentData['utility_bills_paid_on_time_comment'],true);
$rental_property = json_decode($componentData['rental_property'],true);
$rental_property_comment = json_decode($componentData['rental_property_comment'],true);
$maintenance_issues = json_decode($componentData['maintenance_issues'],true);
$maintenance_issues_comment = json_decode($componentData['maintenance_issues_comment'],true);
$tenant_leave = json_decode($componentData['tenant_leave'],true);
$tenant_leave_comment = json_decode($componentData['tenant_leave_comment'],true);
$tenant_rent_again = json_decode($componentData['tenant_rent_again'],true);
$complaints_from_neighbors = json_decode($componentData['complaints_from_neighbors'],true);
$complaints_from_neighbors_comment = json_decode($componentData['complaints_from_neighbors_comment'],true);

$tenant_rent_again_comment = json_decode($componentData['tenant_rent_again_comment'],true);
$any_pets = json_decode($componentData['any_pets'],true);
$any_pets_comment = json_decode($componentData['any_pets_comment'],true);
$food_preference = json_decode($componentData['food_preference'],true);
$food_preference_comment = json_decode($componentData['food_preference_comment'],true);
$spare_time = json_decode($componentData['spare_time'],true);
$spare_time_comment = json_decode($componentData['spare_time_comment'],true);
$overall_character = json_decode($componentData['overall_character'],true);
$overall_character_comment   = json_decode($componentData['overall_character_comment'],true);

           
            $in_progress_remarks = json_decode($componentData['in_progress_remarks'],true);
            $insuff_remarks = json_decode($componentData['insuff_remarks'],true);
            $verification_remarks = json_decode($componentData['verification_remarks'],true);
            $verified_by = json_decode($componentData['verified_by'],true);
            $insuff_closure_remarks = json_decode($componentData['insuff_closure_remarks'],true);
            $approved_doc = json_decode($componentData['approved_doc'],true);
            
            $ouputqc_comment = json_decode($componentData['ouputqc_comment'],true);
            $verified_date = json_decode($componentData['verified_date'],true);
                    // echo "<br>address:".count($address);  
                    $i=$index;
                    $key = $index;
                    ?>
                    <input type="hidden" value="" id="countOfCompanyName" name="countOfCompanyName">
                    <?php 
                    // foreach ($company_name as $key => $value) { 
                    ?>
                   
                    <div>
                      <h3 class="permt mt-4">Landlord Reference Details <?php echo $i?> </h3>
                      <div class="row mt-3"> 
                          <div class="col-md-2 lft-p-det">
                            <p>Tenant Name</p>
                            <p>Landlord Contact Number</p>
                            <p>Landlord Name</p> 
                          
                          </div>
                          <div class="col-md-1 pr-0">
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              
                         </div>
                         <div class="col-md-3 ryt-p pl-0">
                            <p><?php echo isset($tenant_name[$key]['tenant_name'])?$tenant_name[$key]['tenant_name']:'Did not provided';?></p>
                            <p><?php echo isset($case_contact_no[$key]['case_contact_no'])?$case_contact_no[$key]['case_contact_no']:'Did not provided';?></p>
                            <p><?php echo isset($landlord_name[$key]['landlord_name'])?$landlord_name[$key]['landlord_name']:'Did not provided'?></p>
                             
                           
                         </div>
                             
                      </div>
                    </div>
                    <h3 class="permt mt-4">Landlord Reference verification Details <?php echo $i?></h3>

                    <h6 class="full-nam2">Tenancy Details</h6>
         <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>How long was the tenancy?</label>
                  <input name="tenancy_period" class="fld form-control tenancy_period" value="<?php echo isset($tenancy_period[$key]['tenancy_period'])?$tenancy_period[$key]['tenancy_period']:''; ?>" id="tenancy_period" type="text">
                  <div id="tenancy_period-error"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Comment</label>
                  <input name="tenancy_period_comment" class="fld form-control tenancy_period_comment" value="<?php echo isset($tenancy_period_comment[$key]['tenancy_period_comment'])?$tenancy_period_comment[$key]['tenancy_period_comment']:''; ?>" id="tenancy_period_comment" type="text">
                  <div id="tenancy_period_comment-error"></div>
               </div>
            </div>
             
         </div>

         <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>What was the Monthly rental amount?</label>
                  <input name="monthly_rental_amount" class="fld form-control monthly_rental_amount" value="<?php echo isset($monthly_rental_amount[$key]['monthly_rental_amount'])?$monthly_rental_amount[$key]['monthly_rental_amount']:''; ?>" id="monthly_rental_amount" type="text">
                  <div id="monthly_rental_amount-error"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Comment</label>
                  <input name="monthly_rental_amount_comment" class="fld form-control monthly_rental_amount_comment" value="<?php echo isset($monthly_rental_amount_comment[$key]['monthly_rental_amount_comment'])?$monthly_rental_amount_comment[$key]['monthly_rental_amount_comment']:''; ?>" id="monthly_rental_amount_comment" type="text">
                  <div id="monthly_rental_amount_comment-error"></div>
               </div>
            </div>
             
         </div>

         <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                  <?php $select = isset($occupants_property[$key]['occupants_property'])?$occupants_property[$key]['occupants_property']:'';
                   $Family = '';
                   $Relatives = '';
                   $Friends = '';
                   $Alone = '';
                     if ($select == 'Family') {    
                      $Family ='selected';
                     }else if ($select == 'Relatives') { 
                       $Relatives ='selected'; 
                     }else if ($select == 'Friends') { 
                       $Friends ='selected'; 
                     }else if ($select == 'Alone') { 
                       $Alone ='selected'; 
                     }
                   ?>
                  <label>Who were the occupants of the property ?</label>
                  <select class="fld occupants_property" id="occupants_property">
                     <option<?php echo $Family; ?> >Family</option>
                     <option<?php echo $Relatives; ?> >Relatives</option>
                     <option<?php echo $Friends; ?> >Friends</option>
                     <option<?php echo $Alone; ?> >Alone</option>
                  </select>
                  <div id="occupants_property-error"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Comment</label>
                  <input name="occupants_property_comment" class="fld form-control occupants_property_comment" value="<?php echo isset($occupants_property_comment[$key]['occupants_property_comment'])?$occupants_property_comment[$key]['occupants_property_comment']:''; ?>" id="occupants_property_comment" type="text">
                  <div id="occupants_property_comment-error"></div>
               </div>
            </div>
             
         </div>

        <h6 class="full-nam2">Tenant's Conduct</h6>
         <div class="row">
            <div class="col-md-6">
               <?php $consistently = isset($tenant_consistently_pay_rent_on_time[$key]['tenant_consistently_pay_rent_on_time'])?$tenant_consistently_pay_rent_on_time[$key]['tenant_consistently_pay_rent_on_time']:'';
                  $consistentlys = '';
                  if ($consistently=='No') {
                     $consistentlys = 'selected';
                  }
                ?>
               <div class="pg-frm">
                  <label>Did the tenant consistently pay rent on time?</label>
                  <select class="fld tenant_consistently_pay_rent_on_time" id="tenant_consistently_pay_rent_on_time">
                     <option>Yes</option>
                     <option <?php echo $consistentlys; ?> >No</option> 
                  </select>
                  <div id="tenant_consistently_pay_rent_on_time-error"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Comment</label>
                  <input name="tenant_consistently_pay_rent_on_time_comment" class="fld form-control tenant_consistently_pay_rent_on_time_comment" value="<?php echo isset($tenant_consistently_pay_rent_on_time_comment[$key]['tenant_consistently_pay_rent_on_time_comment'])?$tenant_consistently_pay_rent_on_time_comment[$key]['tenant_consistently_pay_rent_on_time_comment']:''; ?>" id="tenant_consistently_pay_rent_on_time_comment" type="text">
                  <div id="tenant_consistently_pay_rent_on_time_comment-error"></div>
               </div>
            </div>
             
         </div>
         <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                  <?php $utility = isset($utility_bills_paid_on_time[$key]['utility_bills_paid_on_time'])?$utility_bills_paid_on_time[$key]['utility_bills_paid_on_time']:'';
                  $utilitys = '';
                  if ($utility=='No') {
                     $utilitys = 'selected';
                  }
                ?>
                  <label>Was the utility bills paid on time?</label>
                  <select class="fld utility_bills_paid_on_time" id="utility_bills_paid_on_time">
                     <option>Yes</option>
                     <option <?php echo $utilitys; ?> >No</option> 
                  </select>
                  <div id="utility_bills_paid_on_time-error"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Comment</label>
                  <input name="utility_bills_paid_on_time_comment" class="fld form-control utility_bills_paid_on_time_comment" value="<?php echo isset($utility_bills_paid_on_time_comment[$key]['utility_bills_paid_on_time_comment'])?$utility_bills_paid_on_time_comment[$key]['utility_bills_paid_on_time_comment']:''; ?>" id="utility_bills_paid_on_time_comment" type="text">
                  <div id="utility_bills_paid_on_time_comment-error"></div>
               </div>
            </div>
             
         </div>
         <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                   <?php $maintain = isset($rental_property[$key]['rental_property'])?$rental_property[$key]['rental_property']:'';
                  $maintains = '';
                  if ($maintain=='No') {
                     $maintains = 'selected';
                  }
                ?>
                  <label>Did the tenant maintain the rental property well?</label>
                  <select class="fld rental_property" id="rental_property">
                     <option>Yes</option>
                     <option <?php echo $maintains; ?> >No</option> 
                  </select>
                  <div id="rental_property-error"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Comment</label>
                  <input name="rental_property_comment" class="fld form-control rental_property_comment" value="<?php echo isset($rental_property_comment[$key]['rental_property_comment'])?$rental_property_comment[$key]['rental_property_comment']:''; ?>" id="rental_property_comment" type="text">
                  <div id="rental_property_comment-error"></div>
               </div>
            </div>
             
         </div>

         <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                   <?php $major = isset($maintenance_issues[$key]['maintenance_issues'])?$maintenance_issues[$key]['maintenance_issues']:'';
                  $majors = '';
                  if ($major=='No') {
                     $majors = 'selected';
                  }
                ?>
                  <label>Were there any major damages or maintenance issues?</label>
                  <select class="fld maintenance_issues" id="maintenance_issues">
                     <option>Yes</option>
                     <option <?php echo $majors; ?> >No</option> 
                  </select>
                  <div id="maintenance_issues-error"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Comment</label>
                  <input name="maintenance_issues_comment" class="fld form-control maintenance_issues_comment" value="<?php echo isset($maintenance_issues_comment[$key]['maintenance_issues_comment'])?$maintenance_issues_comment[$key]['maintenance_issues_comment']:''; ?>" id="maintenance_issues_comment" type="text">
                  <div id="maintenance_issues_comment-error"></div>
               </div>
            </div>
             
         </div>
         <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Why did the tenant leave?</label>
                  <input name="tenant_leave" class="fld form-control tenant_leave" value="<?php echo isset($tenant_leave[$key]['tenant_leave'])?$tenant_leave[$key]['tenant_leave']:''; ?>" id="tenant_leave" type="text">
                  <div id="tenant_leave-error"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Comment</label>
                  <input name="" class="fld form-control tenant_leave_comment" value="<?php echo isset($tenant_leave_comment[$key]['tenant_leave_comment'])?$tenant_leave_comment[$key]['tenant_leave_comment']:''; ?>" id="tenant_leave_comment" type="text">
                  <div id="tenant_leave_comment-error"></div>
               </div>
            </div>
             
         </div>


         <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                   <?php $rent = isset($tenant_rent_again[$key]['tenant_rent_again'])?$tenant_rent_again[$key]['tenant_rent_again']:'';
                  $rents = '';
                  if ($rent=='No') {
                     $rents = 'selected';
                  }
                ?>
                  <label>Would you rent to this tenant again?</label>
                  <select class="fld tenant_rent_again" id="tenant_rent_again">
                     <option>Yes</option>
                     <option <?php echo $rents; ?> >No</option> 
                  </select>
                  <div id="tenant_rent_again-error"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Comment</label>
                  <input name="tenant_rent_again_comment" class="fld form-control tenant_rent_again_comment" value="<?php echo isset($tenant_rent_again_comment[$key]['tenant_rent_again_comment'])?$tenant_rent_again_comment[$key]['tenant_rent_again_comment']:''; ?>" id="tenant_rent_again_comment" type="text">
                  <div id="tenant_rent_again_comment-error"></div>
               </div>
            </div>
             
         </div>

         <h6 class="full-nam2">Tenant's Behavior</h6>


         <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                  <?php $tenant = isset($any_pets[$key]['any_pets'])?$any_pets[$key]['any_pets']:'';
                  $tenants = '';
                  if ($tenant=='No') {
                     $tenants = 'selected';
                  }
                ?>
                  <label>Did the tenant have any pets?</label>
                  <select class="fld any_pets" id="any_pets">
                     <option>Yes</option>
                     <option <?php echo $tenants; ?> >No</option> 
                  </select>
                  <div id="any_pets-error"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Comment</label>
                  <input name="any_pets_comment" class="fld form-control any_pets_comment" value="<?php echo isset($any_pets_comment[$key]['any_pets_comment'])?$any_pets_comment[$key]['any_pets_comment']:''; ?>" id="any_pets_comment" type="text">
                  <div id="any_pets_comment-error"></div>
               </div>
            </div>
             
         </div>

         <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                  <?php $food = isset($complaints_from_neighbors[$key]['complaints_from_neighbors'])?$complaints_from_neighbors[$key]['complaints_from_neighbors']:'';
                  $complaints = '';
                  if ($food=='No') {
                     $complaints = 'selected';
                  }
                ?>
                  <label>Were there any complaints from neighbors or other tenants?</label>
                  <select class="fld complaints_from_neighbors" id="complaints_from_neighbors">
                     <option>Yes</option>
                     <option <?php echo $complaints; ?> >No</option> 
                  </select>
                  <div id="complaints_from_neighbors-error"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Comment</label>
                  <input name="complaints_from_neighbors_comment" class="fld form-control complaints_from_neighbors_comment" value="<?php echo isset($complaints_from_neighbors_comment[$key]['complaints_from_neighbors_comment'])?$complaints_from_neighbors_comment[$key]['complaints_from_neighbors_comment']:''; ?>" id="food_preference_comment" type="text">
                  <div id="complaints_from_neighbors_comment-error"></div>
               </div>
            </div>
             
         </div>

         <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                  <?php $food = isset($food_preference[$key]['food_preference'])?$food_preference[$key]['food_preference']:'';
                  $foods = '';
                  if ($food=='Non-Veg') {
                     $foods = 'selected';
                  }
                ?>
                  <label>What was the food preference of the Tenant?</label>
                  <select class="fld food_preference" id="food_preference">
                     <option>Veg</option>
                     <option <?php echo $foods; ?> >Non-Veg</option> 
                  </select>
                  <div id="food_preference-error"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Comment</label>
                  <input name="food_preference_comment" class="fld form-control food_preference_comment" value="<?php echo isset($food_preference_comment[$key]['food_preference_comment'])?$food_preference_comment[$key]['food_preference_comment']:''; ?>" id="food_preference_comment" type="text">
                  <div id="food_preference_comment-error"></div>
               </div>
            </div>
             
         </div>

           <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>How did the tenant spend their spare time?</label>
                  <input name="spare_time" class="fld form-control spare_time" value="<?php echo isset($spare_time[$key]['spare_time'])?$spare_time[$key]['spare_time']:''; ?>" id="spare_time" type="text">
                  <div id="spare_time-error"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Comment</label>
                  <input name="spare_time_comment" class="fld form-control spare_time_comment" value="<?php echo isset($spare_time_comment[$key]['spare_time_comment'])?$spare_time_comment[$key]['spare_time_comment']:''; ?>" id="spare_time_comment" type="text">
                  <div id="name-error"></div>
               </div>
            </div>
             
         </div>

     <div class="row">
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Describe the tenant’s overall character</label>
                  <input name="overall_character" class="fld form-control overall_character" value="<?php echo isset($overall_character[$key]['overall_character'])?$overall_character[$key]['overall_character']:''; ?>" id="overall_character" type="text">
                  <div id="overall_character-error"></div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="pg-frm">
                  <label>Comment</label>
                  <input name="overall_character_comment" class="fld form-control overall_character_comment" value="<?php echo isset($overall_character_comment[$key]['overall_character_comment'])?$overall_character_comment[$key]['overall_character_comment']:''; ?>" id="overall_character_comment" type="text">
                  <div id="overall_character_comment-error"></div>
               </div>
            </div>
             
         </div>
         <div class="row">
          <div class="col-md-6">
             <div class="row mt-2">
                            <div class="col-md-3">
                             <p>In Progress Remarks</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">  
                               <input name="" class="fld form-control progress_remarks" id="progress_remarks<?php echo $i; ?>" value="<?php echo isset($in_progress_remarks[$key]['progress_remarks'])?$in_progress_remarks[$key]['progress_remarks']:''?>"  type="text">
                               <div id="progress_remarks-error<?php echo $i;?>"></div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Insuff Remarks</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                                
                                <textarea class="fld form-control insuff_remarks" id="insuff_remarks<?php echo $i; ?>" ><?php echo isset($insuff_remarks[$key]['insuff_remarks'])?$insuff_remarks[$key]['insuff_remarks']:''?></textarea>
                               <div id="insuff_remarks-error<?php echo $i;?>"></div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Insuff Closure Remarks</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8"> 
                                  <textarea class="fld form-control closure_remarks"  id="closure_remarks<?php echo $i; ?>" ><?php echo isset($insuff_closure_remarks[$key]['closure_remarks'])?$insuff_closure_remarks[$key]['closure_remarks']:''?></textarea>
                                 <div id="closure_remarks-error<?php echo $i;?>"></div>
                            </div>
                          </div>
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
                                    <div id="criminal-upoad-docs-error-msg-div"><?php
                               $pan_card_doc = '';
                                 if (isset($approved_doc[$key])) {
                                 if (!in_array('no-file',$approved_doc[$key])) {
                                   foreach ($approved_doc[$key] as $key1 => $val) {
                                      if ($val !='') {
                                        $url = base_url()."../uploads/remarks-docs/".$val;
                                        echo "<div class='image-selected-div'><span>{$val}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a> <a href='{$url}' download >  <i class='fa fa-download'></i></a> </span></div>";
                                    }
                                   }
                                 $pan_card_doc = $approved_doc[$key];
                                 }} 
                                 ?></div>
                                 </li> 
                              </ul>
                              <div class="row" id="selected-criminal-docs-li"></div>
                           </div>
                          </div>

                        </div> 
                         <div class="col-md-6">
                             <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Verification Remarks</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                             
                             <textarea class="fld form-control verification_remarks"  id="verification_remarks<?php echo $i; ?>"  
                             onkeyup="varificationRemarks(<?php echo $i; ?>)"><?php echo isset($verification_remarks[$key]['verification_remarks'])?$verification_remarks[$key]['verification_remarks']:''?></textarea>
                             <div id="verification_remarks-error<?php echo $i;?>"></div> 
                            </div>
                          </div>
                          <!-- Verification date -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Verified Date</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <!-- <input name="" class="fld form-control verified_date" value="<?php echo isset($verified_date[$key]['verified_date'])?date($php_code_selected_datetime_format[0],strtotime($verified_date[$key]['verified_date'])):date($php_code_selected_datetime_format[0]); ?>" id="verified_date<?php echo $i; ?>" type="text">  -->
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
                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Verified by</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                             <input name="" class="fld form-control verified_by"  id="verified_by<?php echo $i; ?>" 
                             value="<?php echo isset($verified_by[$key]['verified_by'])?$verified_by[$key]['verified_by']:''?>"
                             type="text">

                             <!-- onkeyup="varificationRemarks(<?php //echo $i; ?>)" -->
                             <div id="verified_by-error<?php echo $i;?>"></div>
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
                        // echo "analyst_status:".$analyst_status;
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
                      <!-- id="submit-reference" -->
                      <button class="update-bt" data-toggle="modal" data-target="#conformtionReferance">Update</button></a>                       
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




<!-- Conformation popup -->
<div id="conformtionReferance" class="modal fade">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-pending-bx">
        <h3 class="snd-mail-pop">Do you want to Confirm?</h3>
        <div class="row mt-3">
          <div class="col-md-4">
            <p class="pa-pop">Case ID :  <?php echo $componentData['candidate_id']?></p>
          </div>
          <div class="col-md-8">
            <p  class="pa-pop">Candidate Name : <?php echo $candidateName = $componentData['first_name']." ".$componentData['last_name'];?></p>
          </div>
        </div>
        <p class="pa-pop text-warning" id="wait-message"></p>
        <button class="btn bg-blu text-white" id="cancle-data-btn" data-dismiss="modal">Close</button>
        <button class="btn bg-blu float-right text-white" id="submit-reference-data">Confirm</button>
        <div class="clr">
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

 
<?php
  include APPPATH.'views/analyst/assigned-case/component-pages/view_image_model.php';
?>

<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/remark-landlord-reference.js"></script>
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