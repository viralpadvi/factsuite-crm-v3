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
   $output_status=  explode(',',$componentData['output_status']);
                    $ouputqc_comment = json_decode($componentData['ouputqc_comment'],true);
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
  <input type="hidden" value="<?php echo $userID?> " id="userID" name="userID">
  <input type="hidden" value="<?php echo $userRole ?>" id="userRole" name="userRole">

<div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
         <!-- <h3>Case Detail</h3> -->
          
          <a class="btn bg-blu btn-submit-cancel" id="back-btn" href="<?php echo $this->config->item('my_base_url').$backLink?>" ><span class="text-white"><i class="fas fa-angle-left"></i>&nbsp;Back</span></a>

          <h3 class="mt-3">Previous Employment Check Detail</h3>
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
                      
                      <!-- <div class="col-md-6"><a href="./allcase2.html"><button class="close-bt">Close</button></a></div> -->
                  </div>
                  <?php 
                    // print_r($componentData);
                    $currency_decod = json_decode($currency,true); 
                    $company_name = json_decode($componentData['company_name'],true);
                    $desigination = json_decode($componentData['desigination'],true);
                    $department = json_decode($componentData['department'],true);
                    $employee_id = json_decode($componentData['employee_id'],true);
                    $address = json_decode($componentData['address'],true);
                    $annual_ctc = json_decode($componentData['annual_ctc'],true);
                    $reason_for_leaving = json_decode($componentData['reason_for_leaving'],true);
                    // $reason_for_leaving = json_decode($componentData['reason_for_leaving'],true);
                    $joining_date = json_decode($componentData['joining_date'],true);
                    $relieving_date = json_decode($componentData['relieving_date'],true);
                    $reporting_manager_name = json_decode($componentData['reporting_manager_name'],true);
                    $reporting_manager_desigination = json_decode($componentData['reporting_manager_desigination'],true);
                    $reporting_manager_desigination = json_decode($componentData['reporting_manager_desigination'],true);
                    $code = json_decode($componentData['code'],true);
                    $reporting_manager_contact_number = json_decode($componentData['reporting_manager_contact_number'],true);
                    $hr_name = json_decode($componentData['hr_name'],true);
                    $hr_contact_number = json_decode($componentData['hr_contact_number'],true);
                    $hr_code = json_decode($componentData['hr_code'],true);
                    $appointment_letter = json_decode($componentData['appointment_letter'],true);
                    $experience_relieving_letter = json_decode($componentData['experience_relieving_letter'],true);
                    $bank_statement_resigngation_acceptance = json_decode($componentData['bank_statement_resigngation_acceptance'],true);

                    $remarks_emp_id = json_decode($componentData['remarks_emp_id'],true);
                    $remarks_designation = json_decode($componentData['remarks_designation'],true);
                    $remark_department = json_decode($componentData['remark_department'],true);
                    $remark_date_of_joining = json_decode($componentData['remark_date_of_joining'],true);
                    $remark_date_of_relieving = json_decode($componentData['remark_date_of_relieving'],true);
                    $remark_currency = json_decode($componentData['remark_currency'],true);
                    $remark_salary_lakhs = json_decode($componentData['remark_salary_lakhs'],true);
                    $remark_salary_type = json_decode($componentData['remark_salary_type'],true);

                    // $remark_salary_thousands = json_decode($componentData['remark_salary_thousands'],true);
                    $remark_managers_designation = json_decode($componentData['remark_managers_designation'],true);
                    $remark_managers_contact = json_decode($componentData['remark_managers_contact'],true);
                    $remark_physical_visit = json_decode($componentData['remark_physical_visit'],true);
                    $remark_hr_name = json_decode($componentData['remark_hr_name'],true);
 

                    $remarks_hr_email = json_decode($componentData['remark_hr_email'],true);
                    $remark_hr_phone_no = json_decode($componentData['remark_hr_phone_no'],true);
                    $remark_reason_for_leaving = json_decode($componentData['remark_reason_for_leaving'],true);
                    $remark_eligible_for_re_hire = json_decode($componentData['remark_eligible_for_re_hire'],true);
                    $remark_attendance_punctuality = json_decode($componentData['remark_attendance_punctuality'],true);
                    $remark_job_performance = json_decode($componentData['remark_job_performance'],true);
                    $remark_exit_status = json_decode($componentData['remark_exit_status'],true);
                    $remark_disciplinary_issues = json_decode($componentData['remark_disciplinary_issues'],true);
                    $Insuff_remarks = json_decode($componentData['Insuff_remarks'],true);
                    $Insuff_closure_remarks = json_decode($componentData['Insuff_closure_remarks'],true); 
                    $verification_remarks = json_decode($componentData['verification_remarks'],true); 
                    $approved_doc = json_decode($componentData['approved_doc'],true);
                    $verification_fee = json_decode($componentData['verification_fee'],true);
                    $company_url = json_decode($componentData['company_url'],true);
                    
                    // print_r($componentData);
                    // echo "<br>";
                    // print_r($joining_date);
                    $ouputqc_comment = json_decode($componentData['ouputqc_comment'],true);
                    $analyst_status=  explode(',',$componentData['analyst_status']);
                    $output_status=  explode(',',$componentData['output_status']);
                    $j =1;
                    if(count($desigination) > 0){?>
                      <input type="hidden" value="<?php echo count($desigination) ?>" id="countOfCompanyName" name="countOfCompanyName">
	                    <?php foreach ($desigination as $key => $componentDataValue) {
	                    	// echo $desigination[$key]['desigination'];
	                    ?>
	                   	<div>
	                      <h3 class="hd-h6">Previous Employment Details (Candidate Filled) <?php echo $j?></h3>
	                      <div class="row mt-3">  
	                        <div class="col-md-6">
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Company name</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($company_name[$key]['company_name'])?$company_name[$key]['company_name']:"No data found";?></p>
	                       			</div>
	                       		</div>
                             <div class="row mt-2">
                              <div class="col-md-3 lft-p-det">
                                <p>Company Website</p>
                              </div>
                              <div class="col-md-2 ryt-p">
                                <p>:</p>
                              </div>
                              <div class="col-md-7 ryt-p">
                                <p><?php echo isset($company_url[$key]['company_url'])?$company_url[$key]['company_url']:"No data found";?></p>
                              </div>
                            </div>
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Desigination</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($desigination[$key]['desigination'])?$desigination[$key]['desigination']:"No data found";?></p>
	                       			</div>
	                       		</div>
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Department</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($department[$key]['department'])?$department[$key]['department']:"No data found";?></p>
	                       			</div>
	                       		</div>
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Employee id</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($employee_id[$key]['employee_id'])?$employee_id[$key]['employee_id']:"No data found";?></p>
	                       			</div>
	                       		</div>
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Address</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($address[$key]['address'])?$address[$key]['address']:"No data found";?></p>
	                       			</div>
	                       		</div>
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Annual CTC</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($annual_ctc[$key]['annual_ctc'])?$annual_ctc[$key]['annual_ctc']:"No data found";?></p>
	                       			</div>
	                       		</div>
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Reason for leaving</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($reason_for_leaving[$key]['reason_for_leaving'])?$reason_for_leaving[$key]['reason_for_leaving']:"No data found";?></p>
	                       			</div>
	                       		</div>
	                        </div> 
	                        <div class="col-md-6">
	                        	<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Joining date</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($joining_date[$key]['joining_date'])?date($php_code_selected_datetime_format[0],strtotime($joining_date[$key]['joining_date'])):"No data found";?></p>
	                       			</div>
	                       		</div>
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Relieving_date</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($relieving_date[$key]['relieving_date'])?date($php_code_selected_datetime_format[0],strtotime($relieving_date[$key]['relieving_date'])):"relieving_date";?></p>
	                       			</div>
	                       		</div>
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Reporting manager name</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($reporting_manager_name[$key]['reporting_manager_name'])?$reporting_manager_name[$key]['reporting_manager_name']:"No data found";?></p>
	                       			</div>
	                       		</div>
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Reporting manager contact number</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($reporting_manager_contact_number[$key]['reporting_manager_contact_number'])?$reporting_manager_contact_number[$key]['reporting_manager_contact_number']:"No data found";?></p>
	                       			</div>
	                       		</div>
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Hr name</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($hr_name[$key]['hr_name'])?$hr_name[$key]['hr_name']:"No data found";?></p>
	                       			</div>
	                       		</div>
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Hr contact number</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php 
                                $hr = isset($hr_contact_number[$key]['hr_contact_number'])?$hr_contact_number[$key]['hr_contact_number']:'No data found';
                                $hrcode = isset($hr_code[$key]['hr_code'])?$hr_code[$key]['hr_code']:'';

                                echo $hrcode." ".$hr;?></p>
	                       			</div>
	                       		</div>
	                        </div> 
	                      </div>
	                    </div>
                      <!-- candidate uploaded document view -->
                      <div class="candidate-document-view">
                        <div class="detail mt-2">
                          <h3 class="permt mt-4">Uploded Document By Candidate</h3>
                          <?php
                            $appointment_letter = json_decode($componentData['appointment_letter'],true); 
                            // print_r($appointment_letter);
                            $experience_relieving_letter = json_decode($componentData['experience_relieving_letter'],true); 
                            $last_month_pay_slip = json_decode($componentData['last_month_pay_slip'],true); 
                            // print_r($last_month_pay_slip);
                            $bank_statement_resigngation_acceptance = json_decode($componentData['bank_statement_resigngation_acceptance'],true);
                            // print_r($bank_statement_resigngation_acceptance); 
                            if(count($appointment_letter)  > 0){ ?> 
                              <div class="row mt-3"> 
                                <div class="col-md-6">
                                  <div class="col-md-4 lft-p-det">
                                    <p>Appointment letter</p>
                                  </div> 
                                </div> 
                              </div>
                              <div class="row ">
                                <?php 
                                if(isset($appointment_letter[$key])){
                                  foreach ($appointment_letter[$key] as $appointment_letter_key => $value){ 
                                      $ext = pathinfo($value, PATHINFO_EXTENSION);
                                      $url = base_url()."../uploads/appointment_letter/".$value;
                                      // echo $url;
                                      if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){
                                ?>
                                  <div class="col-md-4">
                                    <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">
                                      <div class="image-selected-div">
                                        <ul class="p-0 mb-0">
                                          <li class="image-selected-name pb-0"><?php echo $value ?></li>
                                          <li class="image-name-delete pb-0">
                                            <a id="docs_modal_file<?php echo $candidateId ?>" onclick="view_document_modal('<?php echo $url ?>')" 
                                                class="image-name-delete-a">
                                              <i class="fa fa-eye text-primary"></i>
                                            </a>
                                            <?php echo "<a href='{$url}' download >  <i class='fa fa-download'></i></a>"; ?>
                                          </li>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>   
                                  <?php 
                                  }else if($ext == 'pdf'){ ?>
                                  <div class="col-md-6">
                                    <div class="col-md-12  pl-0 pr-0" id="file_vendor_documents_0">
                                      <div class="image-selected-div">
                                        <ul class="p-0 mb-0">
                                          <li class="image-selected-name pb-0"><?php echo $value ?></li>
                                          <li class="image-name-delete pb-0">
                                            <a download id="docs_modal_file<?php echo $candidateId ?>" 
                                                href="<?php echo  $url?>" class="image-name-delete-a">
                                              <i class="fa fa-arrow-down text-primary"></i>
                                            </a>
                                            <a target="_blank" id="docs_modal_file<?php echo $candidateId ?>" 
                                                href="<?php echo  $url?>" class="image-name-delete-a">
                                              <i class="fa fa-eye text-primary"></i>
                                            </a>
                                          </li>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                  <?php
                                  }else{
                                  ?>
                                  <!-- <div class="row mt-2"> -->
                                    <div class="col-md-6 lft-p-det">
                                      <p>No files available.</p>
                                    </div> 
                                  <!-- </div>  -->
                                  <?php   
                                      }
                                    }
                                  }
                                  }else{?> 
                                  <!-- <div class="row mt-2"> -->
                                    <div class="col-md-6 lft-p-det">
                                      <p>No data found.</p>
                                    </div> 
                                  <!-- </div>  -->
                                  <?php 
                                      }
                                  ?>
                                </div>
                                <?php if(count($experience_relieving_letter)  > 0){ ?> 
                                <div class="row mt-3"> 
                                  <div class="col-md-6">                                    
                                    <div class="col-md-5 lft-p-det">
                                      <p>Experience/relieving letter</p>
                                    </div>                                        
                                  </div> 
                                </div>
                                <div class="row">
                                <?php 
                                  // print_r($experience_relieving_letter[$key]);
                                 if(isset($experience_relieving_letter[$key])){
                                  foreach ($experience_relieving_letter[$key] as $experience_relieving_letter_key => $value) { 
                                    $ext = pathinfo($value, PATHINFO_EXTENSION);
                                    $url = base_url()."../uploads/experience_relieving_letter/".$value;
                                    
                                    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){?>
                                  <div class="col-md-4">
                                    <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">
                                      <div class="image-selected-div">
                                        <ul class="p-0 mb-0">
                                          <li class="image-selected-name pb-0"><?php echo $value ?></li>
                                          <li class="image-name-delete pb-0">
                                            <a id="docs_modal_file<?php echo $candidateId ?>" onclick="view_document_modal('<?php echo $url ?>')"
                                              class="image-name-delete-a">
                                              <i class="fa fa-eye text-primary"></i>
                                            </a>
                                            <?php echo "<a href='{$url}' download >  <i class='fa fa-download'></i></a>"; ?>
                                          </li>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                  <?php 
                                  }else if($ext == 'pdf'){ ?>
                                  <div class="col-md-6">
                                    <div class="col-md-12  pl-0 pr-0" id="file_vendor_documents_0">
                                      <div class="image-selected-div">
                                        <ul class="p-0 mb-0">
                                          <li class="image-selected-name pb-0"><?php echo $value ?></li>
                                          <li class="image-name-delete pb-0">
                                            <a id="docs_modal_file<?php echo $candidateId ?>" 
                                                href="<?php echo  $url?>" class="image-name-delete-a" download>
                                              <i class="fa fa-arrow-down text-primary"></i>
                                            </a>
                                            <a id="docs_modal_file<?php echo $candidateId ?>" 
                                                href="<?php echo  $url?>" class="image-name-delete-a" target="_blank">
                                              <i class="fa fa-eye text-primary"></i>
                                            </a>
                                          </li>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                  <?php
                                  }else{ ?>
                                  <!-- <div class="row mt-2"> -->
                                    <div class="col-md-6 lft-p-det">
                                      <p>No files available.</p>
                                    </div> 
                                  <!-- </div>  -->
                                  <?php   
                                      }
                                    }
                                  }
                                  }else{?> 
                                  <!-- <div class="row mt-2"> -->
                                    <div class="col-md-6 lft-p-det">
                                      <p>No data found.</p>
                                    </div> 
                                  <!-- </div>  -->
                                  <?php } ?> 
                                </div>
                                <?php if(count($last_month_pay_slip)  > 0){ ?> 
                                <div class="row mt-3"> 
                                  <div class="col-md-6">
                                    <div class=" lft-p-det">
                                      <p>Last month pay slip</p>
                                    </div> 
                                  </div> 
                                </div>
                                <div class="row ">
                                  <?php 
                                    // print_r($last_month_pay_slip[$key]);
                                   if(isset($last_month_pay_slip[$key])){
                                    foreach ($last_month_pay_slip[$key] as $last_month_pay_slip_key => $value) { 
                                    $ext = pathinfo($value, PATHINFO_EXTENSION);
                                    $url = base_url()."../uploads/last_month_pay_slip/".$value;
                                    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){?>
                                  <div class="col-md-4">
                                    <div class="col-md-12  pl-0 pr-0" id="file_vendor_documents_0">
                                      <div class="image-selected-div">
                                        <ul class="p-0 mb-0">
                                          <li class="image-selected-name pb-0"><?php echo $value ?></li>
                                            <li class="image-name-delete pb-0">
                                              <a id="docs_modal_file<?php echo $candidateId ?>" 
                                                  onclick="view_document_modal('<?php echo $url ?>')" class="image-name-delete-a">
                                                <i class="fa fa-eye text-primary"></i>
                                              </a>
                                              <?php echo "<a href='{$url}' download >  <i class='fa fa-download'></i></a>"; ?>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                    <?php 
                                    }else if($ext == 'pdf'){ ?>
                                    <div class="col-md-6">
                                    <div class="col-md-12  pl-0 pr-0" id="file_vendor_documents_0">
                                      <div class="image-selected-div">
                                        <ul class="p-0 mb-0">
                                          <li class="image-selected-name pb-0"><?php echo $value ?></li>
                                          <li class="image-name-delete pb-0">
                                            <a  id="docs_modal_file<?php echo $candidateId ?>" 
                                                href="<?php echo  $url?>" 
                                                class="image-name-delete-a" download>
                                              <i class="fa fa-arrow-down text-primary"></i>
                                            </a>
                                             <a  id="docs_modal_file<?php echo $candidateId ?>" 
                                                href="<?php echo  $url?>" 
                                                class="image-name-delete-a" target="_blank">
                                              <i class="fa fa-eye text-primary"></i>
                                            </a>
                                          </li>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                  <?php }else{ ?>
                                  <!-- <div class="row mt-2"> -->
                                    <div class="col-md-3 lft-p-det">
                                      <p>No files available.</p>
                                    </div> 
                                  <!-- </div>  -->
                                  <?php   
                                      }
                                    }
                                  }
                                  }else{?> 
                                  <!-- <div class="row mt-2"> -->
                                    <div class="col-md-3 lft-p-det">
                                      <p>No data found.</p>
                                    </div> 
                                  <!-- </div>  -->
                                  <?php } ?> 
                                </div>
                                <?php if(count($bank_statement_resigngation_acceptance)  > 0){ ?> 
                                <div class="row mt-3"> 
                                  <div class="col-md-6">
                                    <div class="row mt-2">
                                      <div class="col-md-8 lft-p-det">
                                        <p>Bank statement resigngation acceptance</p>
                                      </div> 
                                    </div> 
                                  </div> 
                                </div>
                                <div class="row ">
                                <?php
                                  // print_r($bank_statement_resigngation_acceptance[$key]);
                                 if(isset($bank_statement_resigngation_acceptance[$key])){
                                  if($bank_statement_resigngation_acceptance[$key] != null && $bank_statement_resigngation_acceptance[$key] != ''){
                                    foreach ($bank_statement_resigngation_acceptance[$key] as $bsra_key => $value) { 
                                      $ext = pathinfo($value, PATHINFO_EXTENSION);
                                      $url = base_url()."../uploads/bank_statement_resigngation_acceptance/".$value;
                                      if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){?>
                                    <div class="col-md-4">
                                      <div class="col-md-12  pl-0 pr-0" id="file_vendor_documents_0">
                                        <div class="image-selected-div">
                                          <ul class="p-0 mb-0">
                                            <li class="image-selected-name pb-0"><?php echo $value ?></li>
                                            <li class="image-name-delete pb-0">
                                              <a id="docs_modal_file<?php echo $candidateId ?>" 
                                                onclick="view_document_modal('<?php echo $url ?>')" class="image-name-delete-a">
                                                <i class="fa fa-eye text-primary"></i>
                                              </a>
                                              <?php echo "<a href='{$url}' download >  <i class='fa fa-download'></i></a>"; ?>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                    <?php }else if($ext == 'pdf'){ ?>
                                    <div class="col-md-6">
                                      <div class="col-md-12  pl-0 pr-0" id="file_vendor_documents_0">
                                        <div class="image-selected-div">
                                          <ul class="p-0 mb-0">
                                            <li class="image-selected-name pb-0"><?php echo $value ?></li>
                                            <li class="image-name-delete pb-0">
                                              <a download id="docs_modal_file<?php echo $candidateId ?>"
                                                  href="<?php echo  $url?>" class="image-name-delete-a">
                                                <i class="fa fa-arrow-down text-primary"></i>
                                              </a>
                                              <a target="_blank" id="docs_modal_file<?php echo $candidateId ?>"
                                                  href="<?php echo  $url?>" class="image-name-delete-a">
                                                <i class="fa fa-eye text-primary"></i>
                                              </a>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                    <?php }else{ ?>
                                    <!-- <div class="row mt-2"> -->
                                      <div class="col-md-6 lft-p-det">
                                        <p>No files available.</p>
                                      </div> 
                                    <!-- </div> -->
                                    <?php
                                        }
                                      }
                                    }
                                    }else{?> 
                                    <!-- <div class="row mt-2"> -->
                                      <div class="col-md-6 lft-p-det">
                                        <p>No data found.</p>
                                      </div> 
                                    <!-- </div>  -->
                                  <?php } }?>
                                </div>
                              </div>
                          </div> 
                        <hr> 
                      </div>
	                    <h3 class="permt mt-4">Previous Employment Verification Details <?php echo $j?></h3>
	                      <div class="row mt-3"> 
	                        <div class="col-md-6">
	                        	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Employee Id</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>	
		                            </div>
		                            <div class="col-md-7">
		                              <input name="employee_id_<?php echo $j ?>" class="fld form-control remarks_emp_id" value="<?php echo  isset($remarks_emp_id[$key]['remarks_emp_id'])?$remarks_emp_id[$key]['remarks_emp_id']:'' ?>" id="employee_id_<?php echo $j ?>" type="text">
		                            </div>
	                        	</div>
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Designation</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <input name="designation_<?php echo $j ?>" class="fld form-control remarks_designation" id="designation_<?php echo $j ?>" 
		                              value="<?php echo  isset($remarks_designation[$key]['remarks_designation'])?$remarks_designation[$key]['remarks_designation']:'' ?>"
                                  onkeyup="valid_designation(<?php echo $j ?>)" 
		                              type="text">
                                  <div id="designation-error_<?php echo $j ?>">&nbsp;</div>
		                            </div>
	                          	</div>
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Department</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <input name="department_<?php echo $j ?>" class="fld form-control remark_department" id="department_<?php echo $j ?>" 
		                              value="<?php echo  isset($remark_department[$key]['remark_department'])?$remark_department[$key]['remark_department']:'' ?>" 
		                              type="text">
		                            </div>
	                          	</div>
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Date of Joining</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <input name="date_of_joining_<?php echo $j ?>" class="fld form-control date-for-candidate-aggreement-start-date remark_date_of_joining" id="date_of_joining_<?php echo $j ?>" 
		                              value="<?php echo  isset($remark_date_of_joining[$key]['remark_date_of_joining'])?$remark_date_of_joining[$key]['remark_date_of_joining']:'' ?>" 
                                  onchange="valid_date_of_joining(<?php echo $j ?>)" onblur="valid_date_of_joining(<?php echo $j ?>)"
		                              type="text" data-dtp="dtp_vOoRp">
                                  <div id="date_of_joining-error_<?php echo $j ?>">&nbsp;</div>
		                            </div>
	                          	</div>
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Date of Relieving</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <input name="date_of_relieving_<?php echo $j ?>" disabled class="fld form-control date-for-candidate-aggreement-end-date remark_date_of_relieving" id="date_of_relieving_<?php echo $j ?>" 
		                              value="<?php echo  isset($remark_date_of_relieving[$key]['remark_date_of_relieving'])?$remark_date_of_relieving[$key]['remark_date_of_relieving']:'' ?>"
                                  onchange="valid_date_of_relieving(<?php echo $j ?>)" onblur="valid_date_of_relieving(<?php echo $j ?>)"
		                              type="text" data-dtp="dtp_vOoRp">
                                  <div id="date_of_relieving_-error_<?php echo $j ?>">&nbsp;</div>
		                            </div>
	                          	</div>
                              <div class="row mt-2">
                                <div class="col-md-3">
                                  <p class="det">Currency</p>
                                </div>
                                <div class="col-md-2 pr-0">
                                  <p>:</p>
                                </div>
                                <div class="col-md-7">
                                  <!-- <input name="currency" class="fld form-control Currency" id="currency" value="<?php //echo $componentData['remark_currency']?$componentData['remark_currency']:""?>" type="text"> -->
                                  <?php 
                                    $currency_info = isset($remark_currency[$key]['remark_currency'])?$remark_currency[$key]['remark_currency']:'';
                                  ?>
                                  <select class="fld form-control Currency select2" id="currency_<?php echo $j ?>">
                                    <?php 
                                      // echo count($currency_decod);
                                      foreach ($currency_decod as $keyCurrency => $currencyValue) {
                                          // echo  $currencyValue['']

                                        if($currency_info == $currencyValue['cc']){
                                          echo '<option selected value="'.$currencyValue['cc'].'">'.$currencyValue['cc'].'</option>';
                                        }else{
                                        echo '<option value="'.$currencyValue['cc'].'">'.$currencyValue['cc'].'</option>';
                                        }
                                      }
                                    ?>                                  
                                  </select>
                                  <div id="currency-error_<?php echo $j ?>">&nbsp;</div>
                                </div>
                              </div> 
                              <div class="row mt-2">
                                <div class="col-md-3">
                                  <p class="det">Salary Type</p>
                                </div>
                                <div class="col-md-2 pr-0">
                                  <p>:</p>
                                </div>
                                <div class="col-md-7">

                                   <select class="fld form-control remark_salary_type" id="remark_salary_type_<?php echo $j ?>">
                                    <?php 
                                      $yearly = '';
                                      $montly = '';
                                      $salaryType = isset($remark_salary_type[$key]['remark_salary_type'])?$remark_salary_type[$key]['remark_salary_type']:'';

                                      if($salaryType  == 'yearly'){
                                        $yearly = 'selected';
                                      }else if($salaryType  == 'monthly'){
                                        $montly = 'selected';
                                      }
                                    ?>
                                     <option <?php echo $yearly ?> selected value="yearly">Yearly</option>
                                     <option <?php echo $montly ?> value="monthly">Monthly</option>
                                   </select>
                                   <div id="remark_salary_type-error_<?php echo $j ?>">&nbsp;</div>
                                </div>
                              </div>
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Salary</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <input name="salary_lakhs_<?php echo $j ?>" class="fld form-control remark_salary_lakhs" id="salary_lakhs_<?php echo $j ?>"
                                  onkeyup = "valid_salary_lakhs(<?php echo $j ?>)"
                                  onkeypress="return isNumberKey(event)"
		                              value="<?php echo  isset($remark_salary_lakhs[$key]['remark_salary_lakhs'])?$remark_salary_lakhs[$key]['remark_salary_lakhs']:'' ?>" 
		                              type="text">
                                  <div id="remark_salary_lakhs-error_<?php echo $j ?>">&nbsp;</div>
		                            </div>

	                          	</div>

	                          <!-- 	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Salary(Thousands)</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <input name="salary_thousands_<?php// echo $j ?>" class="fld form-control remark_salary_thousands" id="salary_thousands_<?php //echo $j ?>" value="<?php //echo  isset($remark_salary_thousands[$key]['remark_salary_thousands'])?$remark_salary_thousands[$key]['remark_salary_thousands']:'' ?>" 
		                              type="text">
		                            </div>
	                          	</div> -->
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Manager's Designation</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <input name="managers_designation_<?php echo $j ?>" class="fld form-control remark_managers_designation" id="managers_designation_<?php echo $j ?>" value="<?php echo  isset($remark_managers_designation[$key]['remark_managers_designation'])?$remark_managers_designation[$key]['remark_managers_designation']:'' ?>" 
		                              type="text">
		                            </div>
	                          	</div>
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Manager's Contact</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <input name="managers_contact_<?php echo $j ?>" class="fld form-control remark_managers_contact" 
		                               id="managers_contact_<?php echo $j ?>" 
		                               value="<?php echo  isset($remark_managers_contact[$key]['remark_managers_contact'])?$remark_managers_contact[$key]['remark_managers_contact']:'' ?>" 
                                   onkeyup=" mangerContectNuber(<?php echo $j ?>)"
		                              type="text">
                                  <div id="managers_contact_-error_<?php echo $j ?>">&nbsp;</div>
		                            </div>
	                          	</div>
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Physical Visit</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                             
                                  <?php 
                                  $pv = isset($remark_physical_visit[$key]['remark_physical_visit'])?$remark_physical_visit[$key]['remark_physical_visit']:"";
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
                                <div class="col-md-7">
                                  <select class="fld form-control remark_physical_visit" id="remark_physical_visit_<?php echo $j?>">
                                    <option <?php echo $selecet_pv; ?> selected value="">Select PV</option>
                                    <option <?php echo $yes; ?> value="yes">Yes</option>
                                    <option <?php echo $no; ?> value="no">No</option>
                                  </select>
                                </div>
                                <div id="remark_physical_visit-error<?php echo $j; ?>"></div>
		                             
	                          	</div> 
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Verified By(HR Name)</p>

		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">

		                              <input name="remark_hr_name_<?php echo $j ?>" class="fld form-control remark_hr_name" id="remark_hr_name_<?php echo $j ?>" 
                                  value="<?php echo  isset($remark_hr_name[$key]['remark_hr_name'])?$remark_hr_name[$key]['remark_hr_name']:'';
                                  //isset($remark_hr_name[$key]['remark_hr_name'])?$remark_hr_name[$key]['remark_hr_name']:'' 
                                  // echo "<br>";
                                  // print_r($remark_hr_name[$key]['remark_hr_name']);
                                  ?>"
                                  onkeyup="valid_remark_hr_name(<?php echo $j ?>)"
		                              type="text">
                                  <div id="remark_hr_name_error_<?php echo $j ?>">&nbsp;</div>
		                            </div>
	                          	</div>
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Verifier(HR) Email</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7"> 
		                              	<input name="remark_hr_email_<?php echo $j ?>" class="fld form-control remark_hr_email" id="remark_hr_email_<?php echo $j ?>" 
                                    value="<?php echo  isset($remarks_hr_email[$key]['remark_hr_email'])?$remarks_hr_email[$key]['remark_hr_email']:'' ?>" 
		                                type="text">
                                  <div id="remark_hr_email_-error_<?php echo $j ?>">&nbsp;</div>
		                            </div>
	                          	</div>
	                          	<div class="row mt2">
                                
                                 <!-- approve / reject -->
                                
                                <!-- approve / reject -->
                                <div class="add-vendor-bx2 ">
                                  <h3 class="m-0">&nbsp;</h3>
                                  <ul>
                                    <li class="vendor-wdt2">
                                      <p class="lft-p-det">Verification Proof Upload Section</p>
                                      <div class="form-group mb-0 d-none">
                                        <input type="file" class="client-documents" id="client-documents<?php echo $j; ?>" name="criminal-documents[]" multiple="multiple">
                                        <label class="btn upload-btn" for="client-documents<?php echo $j; ?>">Upload</label>
                                      </div>
                                      <div id="criminal-upoad-docs-error-msg-div<?php echo $j; ?>">
                                        <?php
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
                                            }
                                          } 
                                        ?>
                                      </div>
                                    </li> 
                                  </ul>
                                  <div class="row" id="selected-criminal-docs-li<?php echo $j; ?>"></div>
                                </div>
                              </div>

	                        </div>
	                        <div class="col-md-6">
	                        	
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Verifier(HR) Phone</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <input name="remark_hr_phone_<?php echo $j ?>" class="fld form-control remark_hr_phone_no" id="remark_hr_phone_<?php echo $j ?>" value="<?php echo  isset($remark_hr_phone_no[$key]['remark_hr_phone_no'])?$remark_hr_phone_no[$key]['remark_hr_phone_no']:'' ?>" 
                                  onkeyup=" contactNumeber(<?php echo $j ?>)"
		                              type="text">
                                  <div id="remark_hr_phone-error_<?php echo $j ?>">&nbsp;</div>
		                            </div>
	                          	</div>
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Reason for Leaving</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <input name="remarks_reason_for_leaving_<?php echo $j ?>" class="fld form-control remark_reason_for_leaving" id="remarks_reason_for_leaving_<?php echo $j ?>" 
		                              value="<?php echo  isset($remark_reason_for_leaving[$key]['remark_reason_for_leaving'])?$remark_reason_for_leaving[$key]['remark_reason_for_leaving']:'' ?>" 
		                              type="text">
		                            </div>
	                          	</div>
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Eligible for Re-Hire</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <!-- <input name="eligible_for_re_hire_<?php //echo $j ?>" class="fld form-control remark_eligible_for_re_hire" id="eligible_for_re_hire_<?php //echo $j ?>" value="<?php // echo  isset($remark_eligible_for_re_hire[$key]['remark_eligible_for_re_hire'])?$remark_eligible_for_re_hire[$key]['remark_eligible_for_re_hire']:'' ?>" 
		                              type="text"> -->
                                  <select class="fld form-control remark_eligible_for_re_hire" id="eligible_for_re_hire_<?php echo $j ?>">
                                  <?php 
                                    $yes = '';
                                    $no = '';
                                    $no_comment = '';
                                    $remark_eligible = isset($remark_eligible_for_re_hire[$key]['remark_eligible_for_re_hire'])?$remark_eligible_for_re_hire[$key]['remark_eligible_for_re_hire']:'';
                                    if($remark_eligible  == 'yes'){
                                      $yes = 'selected';
                                    }else if($remark_eligible  == 'no'){
                                      $no = 'selected';
                                    }else if($remark_eligible  == 'did_not_comment'){
                                      $no_comment = 'selected';
                                    }
                                  ?>
                                   <option <?php echo $yearly ?> selected value="yes">Yes</option>
                                   <option <?php echo $no ?> value="no">No</option>
                                   <option <?php echo $no_comment ?> value="did_not_comment">Did not Comment</option>
                                 </select>
                                  <div id="eligible_for_re_hire_error_<?php echo $j ?>">&nbsp;</div>
		                            </div>
	                          	</div> 
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Attendance & Punctuality</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <!-- <input name="attendance_punctuality_<?php //echo $j ?>" class="fld form-control remark_attendance_punctuality" id="attendance_punctuality_<?php //echo $j ?>" value="<?php //echo  isset($remark_attendance_punctuality[$key]['remark_attendance_punctuality'])?$remark_attendance_punctuality[$key]['remark_attendance_punctuality']:'' ?>" 
		                              type="text"> -->
                                  <?php
                                  $zero_punctuality_selected='';
                                  $one_punctuality_selected='';
                                  $two_punctuality_selected='';
                                  $three_punctuality_selected='';
                                  $four_punctuality_selected='';
                                  $five_punctuality_selected='';
                                  $punctuality_did_not_comment = '' ;
                                  $target = isset($remark_attendance_punctuality[$key]['remark_attendance_punctuality'])?$remark_attendance_punctuality[$key]['remark_attendance_punctuality']:'did_not_comment';

                                  if($target== '1'){
                                    $one_punctuality_selected='selected';
                                  }else if($target == '2'){
                                    $two_punctuality_selected='selected';
                                  }else if($target == '3'){
                                    $three_punctuality_selected='selected';
                                  }else if($target == '4'){
                                    $four_punctuality_selected='selected';
                                  }else if($target == '5'){
                                    $five_punctuality_selected='selected';
                                  }else if($target == 'did_not_comment'){
                                    $punctuality_did_not_comment='selected';
                                  }else{
                                    $zero_punctuality_selected='selected';
                                  }
                                  ?>
                                  <select class="fld form-control remark_attendance_punctuality" id="attendance_punctuality_<?php echo $j ?>"  >
                                    <option <?php echo $zero_punctuality_selected; ?> value="0">0</option>
                                    <option <?php echo $one_punctuality_selected; ?> value="1" >1</option>
                                    <option <?php echo $two_punctuality_selected; ?> value="2" >2</option>
                                    <option <?php echo $three_punctuality_selected; ?> value="3" >3</option>
                                    <option <?php echo $four_punctuality_selected; ?> value="4" >4</option>
                                    <option <?php echo $five_punctuality_selected; ?> value="5" >5</option>
                                    <option <?php echo $punctuality_did_not_comment; ?> value="did_not_comment" >Did not Comment</option>
                                  </select> 
		                            </div>
	                          	</div>
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Job Performance ( On scale of 1 -5)</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <!-- <input name="job_performance_<?php //echo $j ?>" class="fld form-control remark_job_performance" id="job_performance_<?php //echo $j ?>" value="<?php //echo  isset($remark_job_performance[$key]['remark_job_performance'])?$remark_job_performance[$key]['remark_job_performance']:'' ?>" 
		                              type="text"> -->
		                            <select class="fld form-control remark_job_performance" id="job_performance_<?php echo $j ?>">
                                  <?php 
                                    $one = '';
                                    $two = '';
                                    $three = '';
                                    $four = '';
                                    $five = ''; 
                                    $remark_eligible = isset($remark_job_performance[$key]['remark_job_performance'])?$remark_job_performance[$key]['remark_job_performance']:'';
                                    if($remark_eligible  == '1'){
                                      $one = 'selected';
                                    }else if($remark_eligible  == '2'){
                                      $two = 'selected';
                                    }else if($remark_eligible  == '3'){
                                      $three = 'selected';
                                    }else if($remark_eligible  == '4'){
                                      $four = 'selected';
                                    }else if($remark_eligible  == '5'){
                                      $five = 'selected';
                                    } 
                                  ?>
                                   <option <?php echo $one ?> selected value="1">1</option>
                                   <option <?php echo $two ?> value="2">2</option>
                                   <option <?php echo $three ?> value="3">3</option>
                                   <option <?php echo $four ?> value="4">4</option>
                                   <option <?php echo $five ?> value="5">5</option> 
                                 </select>
                                 <div class="warning-h6">1 is the lowest and 5 is the highest rating.</div>
                                 <div id="job_performance-error_<?php echo $j ?>">&nbsp;</div>
                                </div>
	                          	</div>
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Exit Status</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                             <!--  <input name="exit_status_<?php //echo $j ?>" class="fld form-control remark_exit_status" id="exit_status_<?php //echo $j ?>" value="<?php //echo  isset($remark_exit_status[$key]['remark_exit_status'])?$remark_exit_status[$key]['remark_exit_status']:'' ?>" 
		                              type="text"> -->

                                  <?php
                                  $pendig_selected='';
                                  $completed_selected='';
                                  $exit_did_not_comment = '' ;
                                  $target = isset($remark_attendance_punctuality[$key]['remark_attendance_punctuality'])?$remark_attendance_punctuality[$key]['remark_attendance_punctuality']:'did_not_comment';

                                  if($target== 'pending'){
                                    $pendig_selected='selected';
                                  }else if($target == 'completed'){
                                    $completed_selected='selected';
                                  }else if($target == 'did_not_comment'){
                                    $exit_did_not_comment='selected';
                                  }

                                  ?>
                                  <select class="fld form-control remark_exit_status"  id="exit_status_<?php echo $j ?>" >
                                    <option <?php echo $zero_punctuality_selected; ?> value="pending">Pending</option>
                                    <option <?php echo $one_punctuality_selected; ?> value="completed" >Completed</option>
                                    <option <?php echo $punctuality_did_not_comment; ?> value="did_not_comment" >Did not Comment</option>
                                  </select> 
                                
                                  <div id="exit_status_-error_<?php echo $j ?>">&nbsp;</div>
		                            </div>
	                          	</div>
	                          	<div class="row mt-2">
		                            <div class="col-md-3">
		                              <p class="det">Disciplinary Issues</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <!-- <input name="disciplinary_issues_<?php //echo $j ?>" class="fld form-control remark_disciplinary_issues"  id="disciplinary_issues_<?php //echo $j ?>" value="<?php //echo  isset($remark_disciplinary_issues[$key]['remark_disciplinary_issues'])?$remark_disciplinary_issues[$key]['remark_disciplinary_issues']:'' ?>" 
		                              type="text"> -->
                                  <select class="fld form-control remark_disciplinary_issues" id="disciplinary_issues_<?php echo $j ?>">
                                  <?php 
                                    $yes_disciplinary = '';
                                    $no_disciplinary = '';
                                    $no_comment_disciplinary = '';

                                    $remark_disciplinary = isset($remark_disciplinary_issues[$key]['remark_disciplinary_issues'])?$remark_disciplinary_issues[$key]['remark_disciplinary_issues']:'did_not_comment';

                                    if($remark_disciplinary  == 'yes'){
                                      $yes_disciplinary = 'selected';
                                    }else if($remark_disciplinary  == 'no'){
                                      $no_disciplinary = 'selected';
                                    }else if($remark_disciplinary  == 'did_not_comment'){
                                      $no_comment_disciplinary = 'selected';
                                    }

                                  ?>
                                   <option <?php echo $yes_disciplinary ?> selected value="yes">Yes</option>
                                   <option <?php echo $no_disciplinary ?> value="no">No</option>
                                   <option <?php echo $no_comment_disciplinary ?> value="did_not_comment">Did not Comment</option>
                                 </select>
                                  <div id="disciplinary_issues-error_<?php echo $j ?>">&nbsp;</div>
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
		                            	 
		                            <textarea name="verification_remarks_<?php echo $j ?>" class="fld form-control verification_remarks" id="verification_remarks_<?php echo $j ?>"><?php echo  isset($verification_remarks[$key]['verification_remarks'])?$verification_remarks[$key]['verification_remarks']:'' ?></textarea>
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
		                            	 
		                              <textarea name="insuff_remarks_<?php echo $j ?>" class="fld form-control Insuff_remarks"  id="insuff_remarks_<?php echo $j ?>" ><?php echo  isset($Insuff_remarks[$key]['insuff_remarks'])?$Insuff_remarks[$key]['insuff_remarks']:'' ?></textarea>
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
		                              <textarea name="insuff_closure_remarks_<?php echo $j ?>" class="fld form-control Insuff_closure_remarks" id="insuff_closure_remarks_<?php echo $j ?>"><?php echo  isset($Insuff_closure_remarks[$key]['insuff_closure_remarks'])?$Insuff_closure_remarks[$key]['insuff_closure_remarks']:'' ?></textarea>
		                            </div>
	                          	</div>
                              <div class="row mt-2">
                                <div class="col-md-3">
                                  <p class="det">Verification Fee</p>
                                </div>
                                <div class="col-md-2 pr-0">
                                  <p>:</p>
                                </div>
                                <div class="col-md-7">
                                  <input name="verification_fee" class="fld form-control verification_fee" id="verification_fee" value="<?php echo  isset($verification_fee[$key]['verification_fee'])?$verification_fee[$key]['verification_fee']:'' ?>" 
                                  onkeypress="return isNumberKey(event)"  type="text">
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
                                  <input type="hidden" 
                                    name="analyst_status_<?php echo $key ?>"
                                    class="analyst_status" 
                                    value="<?php echo $an_status ?>">
                                </div>
                              <div class="col-md-6">
                                  <label class="det">Select component status</label>
                                  <?php 
                                      // echo 'output_status: '.$componentData['output_status'] ;
                                      $op_status = isset($output_status[$key])?$output_status[$key]:'0';
                                      $approveOpStatus = '';
                                      $rejectOpStatus = '';
                                      $defaultOpStatus = '';
                                      if($op_status == 1){
                                        $approveOpStatus = 'selected';
                                      }else if($op_status == 2){
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
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                  <p class="det">Qc Comment:</p>
                                  <textarea 
                                    class="fld form-control ouputQcComment"
                                    id="ouputQcComment"  
                                    rows="3" ><?php echo isset($ouputqc_comment[$key]['ouputQcComment'])?$ouputqc_comment[$key]['ouputQcComment']:'' ?></textarea>
                                  <div id="address-error"></div>
                                </div>
                              </div>
	                  <?php  
	                    $j++;
	                    } 
	                   }else{
	                   		echo '<div class="row mt-2">';
	                   			echo '<div class="row mt-2">';
	                   				echo "<p>No Data Found.</p>";
	                   			echo  '</div>';
	                   		echo  '</div>';
	                   }
               		?>
               	 
		        	
                  
                </div>
               <!--  <hr> -->
                  <div class="row mt-2">
                    <div class="col-md-6">
                      
                    </div>
                    <div class="col-md-6 text-right">
                    	<input type="hidden" value="<?php echo $componentData['candidate_id']?>" id="candidate_id_hidden"name="">
                      	<a href="<?php echo $this->config->item('my_base_url').$backLink?>"><button class="close-bt">Close</button></a>
                      	<!-- <button class="update-bt" id="submit-previous-emp">Update</button> -->
                         <button class="update-bt" data-toggle="modal" data-backdrop="static" data-keyboard="false"data-target="#previous-emp-conformtion">Update</button> 
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
<div id="previous-emp-conformtion" class="modal fade">
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
                <p id="previous-emp-warning-message"></p>
                <button class="btn bg-blu text-white" id="cancle-previous-emp" data-dismiss="modal">Close</button>
                <button class="btn bg-blu float-right text-white" id="submit-previous-emp">Confirm</button>
             <div class="clr"></div>
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

<div class="modal fade" id="view_image_modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-view-collection-category">
        <div class="modal-header border-0">
          <h3 id="">View Document</h4>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row mt-2"> 
            <div class="col-md-3"></div>
            <div class="col-sm-6">
              <!-- <span>Sector Thumbnail Image: </span> -->
              <img class="w-100" id="view-image">
            </div> 
          </div>
          <div class="row p-5 mt-2">
              <div class="col-md-6" id="setupDownloadBtn">
                
              </div>
              <div id="view-edit-cancel-btn-div" class="col-md-6  text-right">
                <button class="btn bg-blu text-white" data-dismiss="modal">Close</button>
              </div>
            </div>
        </div>
        <div class="modal-footer border-0"></div>
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


<script>
	// $('#physical-visit').click(function(){
	// 	// alert("click")
	// 	if($('#physical-visit').prop('checked') == true) { 
 //    		$('#physical-visit-label').html('Yes')
	// 	} else {
	// 		$('#physical-visit-label').html('No')
	// 	}
	// })
</script>
<script>
 // load_case(<?php //echo $candidate_id;?>);
function view_document_modal(url){ 
    // var image = $('#docs_modal_file'+documentName).data('view_docs');
    $('#view-image').attr("src",url);

    let html = '';
     
    html += '<a download class="btn bg-blu text-white" href="'+url+'">'
    html += '<i class="fa fa-download" aria-hidden="true"> Dwonload Document</i>'
    html += '</a>';
    html += '<a class="btn bg-blu text-white mt-2" target="_blank" href="'+url+'">'
    html += '<i class="fa fa-eye" aria-hidden="true"> View Document with new Tab</i>'
    html += '</a>';
    $('#setupDownloadBtn').html(html)
    $('#view_image_modal').modal('show');
}

</script>
<?php
  include APPPATH.'views/analyst/assigned-case/component-pages/view_image_model.php';
?>
<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/commonImageView.js"></script>

<script src="<?php echo base_url() ?>assets/custom-js/outputqc/remarks/remark-previous-employee.js"></script>
