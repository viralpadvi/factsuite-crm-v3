<?php 
  // error_reporting(E_ERROR | E_WARNING | E_PARSE);
  $candidateId =  isset($componentData['candidate_id'])?$componentData['candidate_id']:"2";
  $candidateName =  $componentData['first_name']." ".$componentData['last_name'];
  $candidateClinetName =  isset($componentData['client_name'])?$componentData['client_name']:"2";
  $candidatePhoneNumber =  isset($componentData['phone_number'])?$componentData['phone_number']:"1234567890";
  $candidatePackageName =  isset($componentData['package_name'])?$componentData['package_name']:"2";
  $candidateEmail =  isset($componentData['email_id'])?$componentData['email_id']:"2";
  $php_code_selected_datetime_format = explode(' ',$selected_datetime_format['php_code']);
  $candidateDob =  isset($componentData['date_of_birth'])?date($php_code_selected_datetime_format[0],strtotime($componentData['date_of_birth'])):"-";
  $start_date =  isset($componentData['created_date'])?date($selected_datetime_format['php_code'],strtotime($componentData['created_date'])):"-";
  $priority = $componentData['priority'];
  $candidateFatherName =  isset($componentData['father_name'])?$componentData['father_name']:"No data Found"; 
  $candidateEmployeeId =  isset($componentData['employee_id'])?$componentData['employee_id']:"No data Found";
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
   $backLink = 'factsuite-am/view-case-detail/'.$candidateId;
    $inputqcUser = $this->session->userdata('logged-in-am');
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
  <input type="hidden" value="<?php echo $userID?> " id="userID" name="userID">
  <input type="hidden" value="<?php echo $userRole ?>" id="userRole" name="userRole">


  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
         <!-- <h3>Case Detail</h3> -->
          
          <a class="btn bg-blu btn-submit-cancel" id="back-btn" href="<?php echo $this->config->item('my_base_url').$backLink?>" ><span class="text-white"><i class="fas fa-angle-left"></i>&nbsp;Back</span></a>

          <h3 class="mt-3">Education Detail</h3>
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
               <p>Address</p>
               <p>State</p>
               <p>Zip/Pin Code</p>
               <p>Remarks</p>
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
              </div>
              <div class="col-md-4 ryt-p pl-0 lft-p-det">
                 <p><?php echo $candidateId;?></p>
                 <p><?php echo $candidateName;?></p>
                 <p><?php echo $candidateFatherName;?></p>
                 <p><?php echo $candidatePhoneNumber;?></p>
                 <p><?php echo $candidateEmail;?></p>
                 <p><?php echo $candidate_address;?></p>
                 <p><?php echo $candidate_state;?></p>
                 <p><?php echo $candidate_pincode;?></p>
                 <p><?php echo $remarks;?></p>
              </div>
              <div class="col-md-2 lft-p-det">
                <p>Employee ID</p>
                <p>Client Name</p>
                <p>Package Name</p>
                <p>DOB(date of birth)</p>
                <p>Last Updated By :</p>
                <p>Country</p>
                <p>City</p>
                <p>Start Date</p>  
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
              </div>
              <div class="col-md-2 ryt-p pl-0 lft-p-det">
                 <p><?php echo $candidateEmployeeId;?></p>
                <p><?php echo $candidateClinetName;?></p>
                <p><?php echo $candidatePackageName;?></p>
                <p><?php echo $candidateDob;?></p>
                <p class="text-capitalize "><?php echo $remarks_updateed_by_role;?></p>
                <p ><?php echo $nationality;?></p>
                <p ><?php echo $candidate_city;?></p> 
                <p ><?php echo $start_date;?></p> 
                <p ><?php echo isset($componentData['week'])?$componentData['week']:'NA';?></p>
                <p ><?php echo isset($componentData['contact_start_time'])?$componentData['contact_start_time']:'NA';?></p>
                <p ><?php echo isset($componentData['contact_end_time'])?$componentData['contact_end_time']:'NA';?></p>
                <label class="font-weight-bold">LOA &nbsp;&nbsp;&nbsp;<a target="_blank" href="<?php echo $this->config->item('my_base_url').'factsuite-admin/candidate-loa-pdf/'.md5($candidateId); ?>"><i class="fa fa-file-pdf-o"></i></a></label>
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
                      $type_of_degree = json_decode($componentData['remark_type_of_dgree'],true);
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
                      $ouputqc_comment = json_decode($componentData['ouputqc_comment'],true);
                      // echo "<br>address:".count($address); 

                      // echo $type_of_degree['type_of_degree'][0];
                 
                      $analyst_status=  explode(',',$componentData['analyst_status']);
                      $output_status=  explode(',',$componentData['output_status']);
                      $all_sem_marksheet = json_decode($componentData['all_sem_marksheet'],true);
                      $convocation = json_decode($componentData['convocation'],true);
                      $marksheet_provisional_certificate = json_decode($componentData['marksheet_provisional_certificate'],true);
                      $ten_twelve_mark_card_certificate = json_decode($componentData['ten_twelve_mark_card_certificate'],true);
                      // print_r($ouputqc_comment);
                      // exit(); 
                      $i=1;?>
                      <input name="" class="fld form-control each_count_of_detail" value="<?php echo count($type_of_degrees) ?>" id="each_count_of_detail"  type="hidden">
                      <?php 
                        foreach($type_of_degrees as $key => $value) { 

                    ?>
                   
                    <div>
                      <?php 
                         $disabledMajor = '';
                         $university = '';
                         if($value['type_of_degree'] == '10th'){
                            $disabledMajor = 'd-none';
                         }

                         if($value['type_of_degree'] == '10th' || $value['type_of_degree'] == '12th'){
                          $university = 'Board';
                          $collage_name  = 'School Name'; 
                         }else{
                          $university = 'University';
                          $collage_name  = 'College Name';
                         }
                      ?>
                      <h3 class="permt mt-4"> <?php echo $value['type_of_degree']?> Education Details</h3>
                      <div class="row mt-3"> 
                          <div class="col-md-2 lft-p-det">
                            <p>Type Of Qualification</p>
                            <p class="<?php echo $disabledMajor?>">Major</p>
                            <p><?php echo $university ?></p>
                            <p><?php echo $collage_name ?></p>
                          </div>
                          <div class="col-md-1 pr-0 lft-p-det">
                              <p>:</p>
                              <p class="<?php echo $disabledMajor?>">:</p>
                              <p>:</p>
                              <p>:</p>
                         </div>
                         <div class="col-md-3 ryt-p pl-0">
                            <p><?php echo isset($value['type_of_degree'])?$value['type_of_degree']:'value not found';?></p>
                            <p class="<?php echo $disabledMajor?>"><?php echo isset($major[$key]['major'])?$major[$key]['major']:'value not found'?></p>
                            <p><?php echo isset($university_board[$key]['university_board'])?$university_board[$key]['university_board']:'value not found'?></p> 
                            <p><?php echo isset($college_school[$key]['college_school'])?$college_school[$key]['college_school']:'value not found'?></p> 
                         </div>
                          <div class="col-md-2 lft-p-det">
                            <p>Address</p>
                            <p>Duration Of Course</p>
                            <p>Type Of Course</p>
                            <p>Registration / Roll Number</p>
                          </div>
                          <div class="col-md-1 pr-0 lft-p-det">
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                         </div>
                         <div class="col-md-3 ryt-p pl-0">
                            <p><?php echo isset($address_of_college_school[$key]['address_of_college_school'])?$address_of_college_school[$key]['address_of_college_school']:'value not found';?></p>
                            <p><?php echo isset($course_start_date[$key]['course_start_date'])?date('m/Y',strtotime($course_start_date[$key]['course_start_date'])):'value not found'?> TO <?php echo isset($course_end_date[$key]['course_end_date'])?date('m/Y',strtotime($course_end_date[$key]['course_end_date'])):'value not found'?></p>
                            <p><?php echo isset($type_of_course[$key]['type_of_course'])?$type_of_course[$key]['type_of_course']:'value not found'?></p> 
                            <p><?php echo isset($registration_roll_number[$key]['registration_roll_number'])?$registration_roll_number[$key]['registration_roll_number']:'value not found'?></p> 
                         </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-3">
                        <label class="permt mt-4">All Sem Marksheets</label>
                        <?php

                        /* `all_sem_marksheet`, `convocation`, `marksheet_provisional_certificate`, `ten_twelve_mark_card_certificate`*/

                               
                                if (isset($all_sem_marksheet[$key])) {
                                 // if (!in_array('no-file',$all_sem_marksheet[$key])) {
                                   foreach ($all_sem_marksheet[$key] as $key1 => $val) {
                                      if ($val !='' && $val !='no-file') {
                                        $url = base_url()."../uploads/all-marksheet-docs/".$val;
                                        echo "<div class='image-selected-div'><span>{$val}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a></span></div>";
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
                                   foreach ($convocation[$key] as $key1 => $val) {
                                      if ($val !='' && $val !='no-file') {
                                        $convocation_url = base_url()."../uploads/convocation-docs/".$val;
                                        echo "<div class='image-selected-div'><span>{$val}</span><a onclick='view_document_modal(\"{$convocation_url}\")' >  <i class='fa fa-eye'></i></a></span></div>";
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
                                   foreach ($marksheet_provisional_certificate[$key] as $key1 => $val) {
                                      if ($val !='' && $val !='no-file') {
                                        $marksheet_url = base_url()."../uploads/marksheet-certi-docs/".$val;
                                        echo "<div class='image-selected-div'><span>{$val}</span><a onclick='view_document_modal(\"{$marksheet_url}\")' >  <i class='fa fa-eye'></i></a></span></div>";
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
                                   foreach ($ten_twelve_mark_card_certificate[$key] as $key1 => $val) {
                                      if ($val !='' && $val !='no-file') {
                                        $twelve_url = base_url()."../uploads/ten-twelve-docs/".$val;
                                        echo "<div class='image-selected-div'><span>{$val}</span><a onclick='view_document_modal(\"{$twelve_url}\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                      }
                                   }
                                 
                                 // }
                               } 
                                 ?> 
                      </div>
                      
                    </div>

                    <hr>

                    <h3 class="permt mt-4"><?php echo $value['type_of_degree']?> Education verification Details</h3>
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
                            <div class="col-md-6">
                              <label class="permt mt-4">All Sem Marksheets</label>
                              <?php 
                                if (isset($all_sem_marksheet[$key])) {
                                  if (!in_array('no-file',$all_sem_marksheet[$key])) {
                                    foreach ($all_sem_marksheet[$key] as $key1 => $value) {
                                      if ($value !='') {
                                        $url = base_url()."../uploads/all-marksheet-docs/".$value;
                                        echo "<div class='image-selected-div'>
                                                <span>{$value}</span>
                                                <a onclick='view_document_modal(\"{$url}\")' >
                                                  <i class='fa fa-eye'></i>
                                                </a>
                                              </div>";
                                      }
                                    }                                        
                                  }
                                } 
                              ?> 
                            </div>
                          </div>
                          <div class="row mt2">
                            
                          
                          </div>
                          

                            <div class="add-vendor-bx2">
                              <h3 class="m-0">&nbsp;</h3>
                              <ul>
                                <li class="vendor-wdt2">
                                  <p class="lft-p-det">Verification Proof Upload Section</p>
                                  <div class="form-group mb-0 d-none">
                                    <input type="file" class="client-documents" id="client-documents<?php echo $i; ?>" name="criminal-documents[]" multiple="multiple">
                                    <label class="btn upload-btn" for="client-documents<?php echo $i; ?>">Upload</label>
                                    </div>
                                    <div id="criminal-upoad-docs-error-msg-div<?php echo $i; ?>">
                                    <?php
                                      $pan_card_doc = '';
                                      if (isset($approved_doc[$key])) {
                                        if (!in_array('no-file',$approved_doc[$key])) {
                                          foreach ($approved_doc[$key] as $key1 => $val) {
                                            if ($val !='') {
                                              $url = base_url()."../uploads/remarks-docs/".$val;
                                              echo "<div class='image-selected-div'><span>{$val}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                            }
                                          }
                                          $pan_card_doc = $approved_doc[$key];
                                        }
                                      } 
                                    ?>
                                  </div>
                                </li> 
                              </ul>
                              <div class="row" id="selected-criminal-docs-li<?php echo $i; ?>"></div>
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
                               <input name="" class="fld type_of_degree form-control" value="<?php echo isset($type_of_degree[$key]['type_of_degree'])?$type_of_degree[$key]['type_of_degree']:''?>" id="type_of_degree<?php echo $i; ?>" type="text">
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

                     <div class="row mt-2">
                        <div class="col-md-6">
                            <?php
                                $analystStatus = '';
                                 $disabled = '';
                                $an_status = isset($analyst_status[$key])?$analyst_status[$key]:'0';
                                if($an_status == 0){
                                  $analystStatus = '<span class="text-warning">Pending<span>';
                                }else if($an_status == 3){
                                  $analystStatus = '<span class="text-danger">Insufficiency<span>';
                                }else if($an_status == 4){
                                  $analystStatus = '<span class="text-success">Verified Clear<span>';
                                          // $disabled = 'disabled';
                                }else if($an_status == 5){
                                  $analystStatus = '<span class="text-danger">Stop Check<span>';
                                }else if($an_status == 6){
                                  $analystStatus = '<span class="text-danger">Unable to verify<span>';
                                }else if($an_status == 7){
                                  $analystStatus = '<span class="text-danger">Verified discrepancy<span>';
                                }else if($an_status == 8){
                                  $analystStatus = '<span class="text-danger">Client clarification<span>';
                                }else if($an_status == 9){
                                  $analystStatus = '<span class="text-danger">Closed Insufficiency<span>';
                                }else if($an_status == 10){
                                  $analystStatus = '<span class="text-danger">Qc Error<span>';
                                   $disabled = 'disabled';
                                }else if($an_status == 11){
                                  $analystStatus = '<span class="text-warning">Pending<span>';
                                }
                              ?>
                            <label>Analyst Status: </label>
                            <span class=""><?php echo  $analystStatus?></span>
                            <input type="hidden" id="analyst_status_<?php echo $i; ?>"
                                name="analyst_status"
                                class="analyst_status" 
                                value="<?php echo $an_status ?>">
                            </div> 
                            <div class="col-md-6">
                              <p class="det">Select component status</p>
                              <?php 
                                  // echo 'output_status: '.$componentData['output_status'] ;
                                  $approveOpStatus = '';
                                  $rejectOpStatus = '';
                                  $defaultOpStatus = '';
                                  if($output_status[$key] == 1){
                                    $approveOpStatus = 'selected';
                                  }else if($output_status[$key] == 2){
                                    $rejectOpStatus = 'selected';
                                  }else {
                                    $defaultOpStatus = 'selected'; 
                                  }
                              ?>
                              <select id="op_action_status" <?php echo $disabled; ?> name="carlist" class="sel-allcase op_action_status">
                                <option <?php echo $defaultOpStatus ?> value="0">Select your Action</option>
                                <option <?php echo $approveOpStatus ?> value="1">Approved</option>
                                <option <?php echo $rejectOpStatus ?> value="2">Rejected</option>
                              </select>
                            </div>
                      </div>
                      <div class="row mt-2">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                              <p class="det">OuputQc Comment</p>
                              <textarea 
                                    class="fld form-control ouputQcComment"
                                    id="ouputQcComment"  
                                    rows="3" ><?php echo isset($ouputqc_comment[$key]['ouputQcComment'])?$ouputqc_comment[$key]['ouputQcComment']:'' ?></textarea>
                              <div id="address-error"></div>
                            </div>
                      </div>
                        
                        <hr>

                  <?php 
                    $i++;
                    } 

                }
                  ?>
                  
                </div>
                <!-- <hr> -->
                  <div class="row mt-2">
                    <div class="col-md-6">
                      
                    </div>
                    <div class="col-md-6 text-right">
                      <input type="hidden" value="<?php echo $componentData['candidate_id']?>" id="candidate_id_hidden" name="">
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

<?php
  include APPPATH.'views/analyst/assigned-case/component-pages/view_image_model.php';
?>
<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/commonImageView.js"></script>


<script src="<?php echo base_url() ?>assets/custom-js/outputqc/remarks/remark-education.js"></script>