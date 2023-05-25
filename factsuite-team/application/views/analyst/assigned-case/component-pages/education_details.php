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
  $education_details_id =  isset($componentData['education_details_id'])?$componentData['education_details_id']:"0";
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

<script>
  function getYearList(year='',id = '') {
    // alert(year)
  n =  new Date(); 
  var minYear = 1900; 
  html = '';
  for(minYear;minYear <= n.getFullYear();minYear++){
    if(year == minYear){
      html += '<option selected value="'+minYear+'">'+minYear+'</option>'
    }else{
      html += '<option value="'+minYear+'">'+minYear+'</option>'
    }
  }
   html += '<option value="NA">NA</option>'

  $('#year_of_education'+id).html(html)
}

</script>

<input type="hidden" value="<?php echo $component_id?> " id="component_id" name="component_id">
  <input type="hidden" value="<?php echo $userID?> " id="userID" name="userID">
  <input type="hidden" value="<?php echo $userRole ?>" id="userRole" name="userRole">
  <input type="hidden" value="<?php echo $index ?>" id="componentIndex" name="componentIndex">
  <input type="hidden" value="<?php echo $priority ?>" id="priority" name="priority">
  <input type="hidden" value="<?php echo $education_details_id ?>" id="education_details_id" name="education_details_id">

  <input type="hidden" id="selected-hidden-candidate-id" value="<?php echo $candidateIdLink;?>">
  <input type="hidden" id="selected-hidden-component-id" value="<?php echo $componentIdLink;?>">
  <input type="hidden" id="selected-hidden-component-index" value="<?php echo $index;?>">
  <input type="hidden" id="selected-hidden-user-component-form-filled-id" value="<?php echo $education_details_id;?>">
  <input type="hidden" value="<?php echo $componentData['candidate_id']?>" id="candidate_id_hidden" name="">
  
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-analyst">
         <!-- <h3>Case Detail</h3> -->
          
          <a class="btn bg-blu btn-submit-cancel" id="back-btn" href="<?php echo $this->config->item('my_base_url').$backLink?>" ><span class="text-white"><i class="fas fa-angle-left"></i>&nbsp;Back</span></a>

          <h3 class="mt-3">Education Form Detail</h3>
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
              <div class="col-md-2 lft-p-det ">
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
           
          <section id="table-allcase">
            <div class="container">
                <div class="detail mb-5">
                  <div class="row hd"> 
                  </div>
                  <?php 
                    // print_r($componentData);
                    // print_r($componentData['type_of_degree']);
                  // echo $componentData['type_of_degree'];
                    // exit();
    			            $type_of_degrees = json_decode(isset($componentData['type_of_degree'])?$componentData['type_of_degree']:0,true);
                    if (isset($type_of_degrees[0]['type_of_degree'])) {

                      // echo count($type_of_degree);
    			            $major = json_decode($componentData['major'],true);
    			            $university_board = json_decode($componentData['university_board'],true);
    			            $college_school = json_decode($componentData['college_school'],true);
    			            $address_of_college_school = json_decode($componentData['address_of_college_school'],true);
    			            $course_start_date = json_decode($componentData['course_start_date'],true);
    			            $course_end_date = json_decode($componentData['course_end_date'],true);
    			            $type_of_course = json_decode($componentData['type_of_course'],true);
                      $registration_roll_number = json_decode($componentData['registration_roll_number'],true);
    			            
                      $roll_number = json_decode($componentData['remark_roll_no'],true);
                      $remark_type_of_dgree = json_decode($componentData['remark_type_of_dgree'],true);
                      $institute_name = json_decode($componentData['remark_institute_name'],true);
                      $university_name = json_decode($componentData['remark_university_name'],true);
                      $year_of_education = json_decode($componentData['remark_year_of_graduation'],true);
                      $result_grade = json_decode($componentData['remark_result'],true);
                      $verifier_name = json_decode($componentData['remark_verifier_name'],true);
                      $verifier_designation = json_decode($componentData['remark_verifier_designation'],true);
                      $verifier_contact = json_decode($componentData['remark_verifier_contact'],true);
                      $verifier_email = json_decode($componentData['remark_verifier_email'],true);
                      $physical_visit = json_decode($componentData['remark_physical_visit'],true);
                      $verification_remarks = json_decode($componentData['verification_remarks'],true);
                      $verifier_fee = json_decode($componentData['verification_fee'],true);
                      $insuff_remarks = json_decode($componentData['insuff_remarks'],true);
                      $closure_remarks = json_decode($componentData['insuff_closure_remarks'],true);
                      $progress_remark = json_decode($componentData['in_progress_remarks'],true);
                      $approved_doc = json_decode($componentData['approved_doc'],true);

                      $all_sem_marksheet = json_decode($componentData['all_sem_marksheet'],true);
                      $convocation = json_decode($componentData['convocation'],true);
                      $marksheet_provisional_certificate = json_decode($componentData['marksheet_provisional_certificate'],true);
                      $ten_twelve_mark_card_certificate = json_decode($componentData['ten_twelve_mark_card_certificate'],true); 
                      $ouputqc_comment = json_decode($componentData['ouputqc_comment'],true);

                      $verified_date = json_decode($componentData['verified_date'],true);

                      // echo "<br>address:".count($address); 

                      $i=$index;
                      $key = $index;

                       
                      ?>
                      <input name="" class="fld form-control each_count_of_detail" value="<?php echo count($type_of_degrees) ?>" id="each_count_of_detail"  type="hidden">
                      <?php 
                        // foreach($type_of_degrees as $key => $value) { 

                    ?>
                   
                    <div>
                      <?php 
                         $disabledMajor = '';
                         $university = '';
                         if($type_of_degrees[$i]['type_of_degree'] == '10th'){
                            $disabledMajor = 'd-none';
                         }

                         if($type_of_degrees[$i]['type_of_degree'] == '10th' || $type_of_degrees[$i]['type_of_degree'] == '12th'){
                          $university = 'Board';
                          $collage_name  = 'School Name'; 
                         }else{
                          $university = 'University';
                          $collage_name  = 'College Name';
                         }
                      ?>
                      <h3 class="permt mt-4"> <?php echo $type_of_degrees[$i]['type_of_degree']?> Education Details</h3>
                      <div class="row mt-3"> 
                          <div class="col-md-2 lft-p-det">
                            <p>Type Of Qualification</p>
                            <p class="<?php echo $disabledMajor?>">Major</p>
                            <p><?php echo $university ?></p>
                            <p><?php echo $collage_name ?></p>
                          </div>
                          <div class="col-md-1 pr-0">
                              <p>:</p>
                              <p class="<?php echo $disabledMajor?>">:</p>
                              <p>:</p>
                              <p>:</p>
                         </div>
                         <div class="col-md-3 ryt-p pl-0">
                            <p><?php echo isset($type_of_degrees[$i]['type_of_degree'])?$type_of_degrees[$i]['type_of_degree']:'value not found';?></p>
                            <p class="<?php echo $disabledMajor?>"><?php echo isset($major[$key]['major'])?$major[$key]['major']:'value not found'?></p>
                            <p><?php echo isset($university_board[$key]['university_board'])?$university_board[$key]['university_board']:'value not found'?></p> 
                            <p><?php echo isset($college_school[$key]['college_school'])?$college_school[$key]['college_school']:'value not found'?></p> 
                         </div>
                          <div class="col-md-2 lft-p-det">
                            <p>Address</p>
                            <p>DURATION OF COURSE</p>
                            <p>Type Of Course</p>
                            <p>Registration / Roll Number</p>
                          </div>
                          <div class="col-md-1 pr-0">
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                         </div>
                         <div class="col-md-3 ryt-p pl-0">
                            <p><?php echo isset($address_of_college_school[$key]['address_of_college_school'])?$address_of_college_school[$key]['address_of_college_school']:'value not found';?></p>
                            <p><?php echo isset($course_start_date[$key]['course_start_date'])?date('m/y',strtotime($course_start_date[$key]['course_start_date'])):'value not found'?> TO <?php echo isset($course_end_date[$key]['course_end_date'])?date('m/y',strtotime($course_end_date[$key]['course_end_date'])):'value not found'?></p>
                            <p><?php echo isset($type_of_course[$key]['type_of_course'])?$type_of_course[$key]['type_of_course']:'value not found'?></p> 
                            <p><?php echo isset($registration_roll_number[$key]['registration_roll_number'])?$registration_roll_number[$key]['registration_roll_number']:'value not found'?></p> 
                         </div>
                      </div>
                    </div>


                    <hr>




                    <div class="row">
                      <div class="col-md-3">
                        <label class="permt mt-4">All Sem Marksheets</label>
                        <?php

                        /* `all_sem_marksheet`, `convocation`, `marksheet_provisional_certificate`, `ten_twelve_mark_card_certificate`*/

                               
                                if (isset($all_sem_marksheet[$key])) {
                                 // if (!in_array('no-file',$all_sem_marksheet[$key])) {
                                   foreach ($all_sem_marksheet[$key] as $key1 => $value) {
                                      if ($value !='' && $value !='no-file') {
                                        $url = base_url()."../uploads/all-marksheet-docs/".$value;
                                        echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a> <a href='{$url}' download >  <i class='fa fa-download'></i></a> </span></div>";
                                      }
                                   }
                                  
                                 // }
                               } 
                                 ?> 
                      </div>

                       <div class="col-md-3">
                        <label class="permt mt-4">Convocation</label>
                        <?php
                               // $rental_agreement = '';
                                 if (isset($convocation[$key])) {
                                 // if (!in_array('no-file',$convocation[$key])) {
                                   foreach ($convocation[$key] as $key1 => $value) {
                                      if ($value !='' && $value !='no-file') {
                                        $convocation_url = base_url()."../uploads/convocation-docs/".$value;
                                        echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$convocation_url}\")' >  <i class='fa fa-eye'></i></a> <a href='{$convocation_url}' download >  <i class='fa fa-download'></i></a> </span></div>";
                                      }
                                   }
                                 
                                 // }
                               } 
                                 ?> 
                      </div>

                      <div class="col-md-3">
                        <label class="permt mt-4">Marksheet / Provisional Certificate</label>
                        <?php
                               // $rental_agreement = '';
                                 if (isset($marksheet_provisional_certificate[$key])) {
                                 // if (!in_array('no-file',$marksheet_provisional_certificate[$key])) {
                                   foreach ($marksheet_provisional_certificate[$key] as $key1 => $value) {
                                      if ($value !='' && $value !='no-file') {
                                        $marksheet_url = base_url()."../uploads/marksheet-certi-docs/".$value;
                                        echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$marksheet_url}\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                      }
                                   }
                                  
                                 // }
                               } 
                                 ?> 
                      </div>

                      <div class="col-md-3">
                        <label class="permt mt-4">Ten / Twelve Marks Certificate</label>
                        <?php
                              
                                 if (isset($ten_twelve_mark_card_certificate[$key])) {
                                 // if (!in_array('no-file',$ten_twelve_mark_card_certificate[$key])) {
                                   foreach ($ten_twelve_mark_card_certificate[$key] as $key1 => $value) {
                                      if ($value !='' && $value !='no-file') {
                                        $twelve_url = base_url()."../uploads/ten-twelve-docs/".$value;
                                        echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$twelve_url}\")' >  <i class='fa fa-eye'></i></a>   <a href='{$twelve_url}' download >  <i class='fa fa-download'></i></a> </span></div>";
                                      }
                                   }
                                 
                                 // }
                               } 
                                 ?> 
                      </div>
                      
                    </div>

                    <hr>




                    <h3 class="permt mt-4"><?php echo $type_of_degrees[$i]['type_of_degree']?> Education verification information</h3>
                      <div class="row mt-3"> 
                        <div class="col-md-6">
                          <div class="row mt-2">
                            <div class="col-md-3">
                               <p>Reg/Roll No.</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                               <input name="" class="fld form-control roll_number" value="<?php echo isset($roll_number[$key]['roll_number'])?$roll_number[$key]['roll_number']:''?>" id="roll_number<?php echo $i; ?>"
                                onkeyup = "valid_roll_number(<?php echo $i; ?>)"
                                type="text">
                		          <div id="roll_number-error<?php echo $i; ?>"></div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p>Institute Name</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                               <input name="" class="fld form-control institute_name" value="<?php echo isset($institute_name[$key]['institute_name'])?$institute_name[$key]['institute_name']:''?>" id="institute_name<?php echo $i; ?>" 
                               onkeyup = "valid_institute_name(<?php echo $i; ?>)" type="text">
                 			          <div id="institute_name-error<?php echo $i; ?>"></div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p>Year of Graduation</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                               <!-- <input name="" class="fld form-control year_of_education" value="<?php //echo isset($year_of_education[$key]['year_of_education'])?$year_of_education[$key]['year_of_education']:''?>" id="year_of_education<?php //echo $i; ?>" 
                               onkeyup = "valid_year_of_education(<?php //echo $i; ?>)"type="text" id="year_of_education<?php //echo $i; ?>" > -->
                   				     <?php 
                                  $year = isset($year_of_education[$key]['year_of_education'])?$year_of_education[$key]['year_of_education']:'';
                                  // echo $year.strlen($year);
                                  if($year == '' || 4 <strlen($year)){
                                      // echo 'if';
                                      $year = date('Y');
                                  }
                                ?>

                                <select class="fld form-control year_of_education select2" onchange = "valid_year_of_education(<?php echo $i; ?>)" id="year_of_education<?php echo $i; ?>">
                                    
                                </select>
                                <div id="year_of_education-error<?php echo $i; ?>"></div>
                                <script>
                                    getYearList(<?php echo $year ?>,<?php echo $i; ?>)
                                </script>
                            </div>
                          </div>

                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p>Physical Visit</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <!-- <div class="col-md-8">
                              <div class=" custom-control custom-checkbox custom-control-inline">
                                  <?php
                                  $checked = '';
                                  $status = 'No';
                                  $pv = isset($physical_visit[$key]['physical_visit'])?$physical_visit[$key]['physical_visit']:'';
                                  // echo "pv : ".$pv;
                                  if($pv == '1') {
                                      $checked = 'checked';
                                      $status = 'Yes';
                                  }  
                                  ?>
                                  <input type="checkbox" <?php echo $checked ;?> class="custom-control-input physical_visit" name="physical_visit<?php echo $i; ?>" 
                                  value="1" id="physical_visit<?php echo $i; ?>"
                                  onclick="checkedBox(<?php echo $i; ?>)">
                                  <label id="physical-visit-label<?php echo $i; ?>"class="custom-control-label" for="physical_visit<?php echo $i; ?>"><?php echo $status; ?></label> 
                              </div>
                   			      <div id="physical_visit-error<?php echo $i; ?>"></div>
                            </div> -->
                            <?php 
                              $pv = isset($physical_visit[$key]['physical_visit'])?$physical_visit[$key]['physical_visit']:'';
                              $yes= "";
                              $no = "";
                              $selecet_pv = "";
                              if($pv == 'yes'){
                                $yes= "selected";
                              }else if($pv == "no"){
                                $no = "selected";
                              }else{
                                $selecet_pv = "selected";
                              }
                            ?>
                            <div class="col-md-8">
                              <select class="fld form-control physical_visit" id="physical_visit<?php echo $i?>">
                                <option <?php echo $selecet_pv; ?> selected value="">Select PV</option>
                                <option <?php echo $yes; ?> value="yes">Yes</option>
                                <option <?php echo $no; ?> value="no">No</option>
                              </select>
                            </div>
                            <div id="physical_visit-error<?php echo $i; ?>"></div>
                          </div> 
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p>Verifier Name</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <input name="" class="fld form-control verifier_name" value="<?php echo isset($verifier_name[$key]['verifier_name'])?$verifier_name[$key]['verifier_name']:''?>"  id="verifier_name<?php echo $i; ?>" type="text">
                   			      <div id="verifier_name-error<?php echo $i; ?>"></div>
                            </div>
                          </div>

                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p>Verifier Contact</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <input name="" class="fld form-control verifier_contact" value="<?php echo isset($verifier_contact[$key]['verifier_contact'])?$verifier_contact[$key]['verifier_contact']:''?>"  id="verifier_contact<?php echo $i; ?>" type="text">
                   			 <div id="verifier_contact-error<?php echo $i; ?>"></div>
                            </div>
                          </div> 
                           <div class="row mt-2">
                            <div class="col-md-3">
                              <p>Verifier Fee</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <input name="" class="fld form-control verifier_fee" value="<?php echo isset($verifier_fee[$key]['verifier_fee'])?$verifier_fee[$key]['verifier_fee']:''?>"  id="verifier_fee<?php echo $i; ?>" type="text">
                   			      <div id="verifier_fee-error<?php echo $i; ?>"></div>
                            </div>
                          </div> 
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Insuff Remarks</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <input name="" class="fld form-control insuff_remarks" value="<?php echo isset($insuff_remarks[$key]['insuff_remarks'])?$insuff_remarks[$key]['insuff_remarks']:''?>" id="insuff_remarks<?php echo $i; ?>" type="text">
                            </div>
                            <div id="insuff_remarks-error<?php echo $i; ?>"></div>
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
                              <p class="det">Type of Qualification</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                               <input name="" class="fld type_of_degree form-control" value="<?php echo isset($remark_type_of_dgree[$i]['type_of_degree'])?$remark_type_of_dgree[$i]['type_of_degree']:''?>" id="type_of_degree<?php echo $i; ?>" type="text">
                 			        <div id="type_of_degree-error<?php echo $i; ?>"></div>
                            </div>
                          </div>
                           
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">University Name</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                               <input name="" class="fld university_name form-control" value="<?php echo isset($university_name[$key]['university_name'])?$university_name[$key]['university_name']:''?>" id="university_name<?php echo $i; ?>" 
                               onkeyup="valid_university_name(<?php $i; ?>)" type="text">
                 				     <div id="university_name-error<?php $i; ?>"></div>
                            </div>
                          </div>

                           <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Result / Grade</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <input name="" class="fld form-control result_grade" value="<?php echo isset($result_grade[$key]['result_grade'])?$result_grade[$key]['result_grade']:''?>" id="result_grade<?php echo $i; ?>" type="text">
                            </div>
                          </div>

                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">In Progress Remarks</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8"> 
                              <textarea class="fld form-control progress_remark" id="progress_remark<?php echo $i; ?>" ><?php echo isset($progress_remark[$i]['in_progress_remarks'])?$progress_remark[$i]['in_progress_remarks']:''?></textarea>
                            </div>
                          </div>

                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Verifier Designation</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8"> 
                              <textarea class="fld form-control verifier_designation" id="verifier_designation<?php echo $i; ?>" ><?php echo isset($verifier_designation[$key]['verifier_designation'])?$verifier_designation[$key]['verifier_designation']:''?></textarea>
                            </div>
                          </div>

                            <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Verifier Email</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <input name="" class="fld form-control verifier_email" value="<?php echo isset($verifier_email[$key]['verifier_email'])?$verifier_email[$key]['verifier_email']:''?>" id="verifier_email<?php echo $i; ?>" type="text">
                            </div>
                          </div>

                            <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Verifier Remark</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
 
                                <textarea class="fld form-control verifier_remark" id="verifier_remark<?php echo $i; ?>" 
                                onkeyup = "valid_verifier_remark(<?php echo $i; ?>)"><?php echo isset($verification_remarks[$i]['verification_remarks'])?$verification_remarks[$i]['verification_remarks']:''?></textarea>
                                <div id="verifier_remark-error<?php echo $i; ?>"></div>
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
                              <?php 
                                $verified = isset($verified_date[$i]['verified_date'])?$verified_date[$i]['verified_date']:'';
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
                              <p class="det">Insuff Closure Remarks</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8"> 
                              <textarea class="fld form-control closure_remarks" id="closure_remarks<?php echo $i; ?>"><?php echo isset($closure_remarks[$i]['insuff_closure_remarks'])?$closure_remarks[$i]['insuff_closure_remarks']:''?></textarea>
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
                        $analyst_status = $analyst_status[$index]; 

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
                       <div id="action_status_error<?php echo $i; ?>"></div>
                    </div>
                  </div>
                  <?php $data['vendor'] = $vendor;
                  $this->load->view('vendor/vendor-assign-to-component-form',$data); ?>
                  <?php $for_next_release = 1;
                  if ($for_next_release == 1) { ?>
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
                <?php } ?>
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
                      <button class="update-bt" data-toggle="modal" data-target="#conformtionEdu">Update</button></a>   
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
<div id="conformtionEdu" class="modal fade">
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
        <button class="btn bg-blu text-white" data-dismiss="modal" id="edu-cancle">Close</button>
        <button class="btn bg-blu float-right text-white" id="submit-edu-data">Confirm</button>
        <div class="clr">
        </div>
      </div>
    </div>
  </div>
</div>

 
<?php
  include APPPATH.'views/analyst/assigned-case/component-pages/view_image_model.php';
?>

<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/remark-education.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/commonImageView.js"></script>

<?php if ($for_next_release == 1) { ?>
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
<?php } } ?>

<script type="text/javascript">
  phpData(<?php echo json_encode($componentData)?>)
</script>