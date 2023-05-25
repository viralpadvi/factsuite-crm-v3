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
  $currency_decod = json_decode($currency,true); 
?>
  <input type="hidden" value="<?php echo $userID?> " id="userID" name="userID">
  <input type="hidden" value="<?php echo $userRole ?>" id="userRole" name="userRole">
<div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
         <!-- <h3>Case Detail</h3> -->
          
          <a class="btn bg-blu btn-submit-cancel" id="back-btn" href="<?php echo $this->config->item('my_base_url').$backLink?>" ><span class="text-white"><i class="fas fa-angle-left"></i>&nbsp;Back</span></a>

          <h3 class="mt-3">Current Employment Check Detail</h3>
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
                    // print_r($currency_decod);

                    ?>
                   
                    <div>
                      <h3 class="hd-h6">Current Employment Details (Candidate Filled)</h3>
                      <div class="row mt-3">  
                        <div class="col-md-6">
                       		<div class="row mt-2">
                       			<div class="col-md-3 lft-p-det">
                       				<p>Company name</p>
                       			</div>
                       			<div class="col-md-2 ryt-p lft-p-det">
                       				<p>:</p>
                       			</div>
                       			<div class="col-md-7 ryt-p lft-p-det">
                       				<p><?php echo isset($componentData['company_name'])?$componentData['company_name']:'-';?></p>
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
                              <p><?php echo $componentData['company_url'];?></p>
                            </div>
                          </div>
                       		<div class="row mt-2">
                       			<div class="col-md-3 lft-p-det">
                       				<p>Desigination</p>
                       			</div>
                       			<div class="col-md-2 ryt-p lft-p-det">
                       				<p>:</p>
                       			</div>
                       			<div class="col-md-7 ryt-p lft-p-det">
                       				<p><?php echo isset($componentData['desigination'])?$componentData['desigination']:'-';?></p>
                       			</div>
                       		</div>
                       		<div class="row mt-2">
                       			<div class="col-md-3 lft-p-det">
                       				<p>Department</p>
                       			</div>
                       			<div class="col-md-2 ryt-p lft-p-det">
                       				<p>:</p>
                       			</div>
                       			<div class="col-md-7 ryt-p lft-p-det">
                       				<p><?php echo isset($componentData['department'])?$componentData['department']:'-';?></p>
                       			</div>
                       		</div>
                       		<div class="row mt-2">
                       			<div class="col-md-3 lft-p-det">
                       				<p>Employee id</p>
                       			</div>
                       			<div class="col-md-2 ryt-p lft-p-det">
                       				<p>:</p>
                       			</div>
                       			<div class="col-md-7 ryt-p lft-p-det">
                       				<p><?php echo isset($componentData['employee_id'])?$componentData['employee_id']:'-';?></p>
                       			</div>
                       		</div>
                       		<div class="row mt-2">
                       			<div class="col-md-3 lft-p-det">
                       				<p>Address</p>
                       			</div>
                       			<div class="col-md-2 ryt-p lft-p-det">
                       				<p>:</p>
                       			</div>
                       			<div class="col-md-7 ryt-p lft-p-det">
                       				<p><?php echo isset($componentData['address'])?$componentData['address']:'-';?></p>
                       			</div>
                       		</div>
                       		<div class="row mt-2">
                       			<div class="col-md-3 lft-p-det">
                       				<p>Annual CTC</p>
                       			</div>
                       			<div class="col-md-2 ryt-p lft-p-det">
                       				<p>:</p>
                       			</div>
                       			<div class="col-md-7 ryt-p lft-p-det">
                       				<p><?php echo isset($componentData['annual_ctc'])?$componentData['annual_ctc']:'-';?></p>
                       			</div>
                       		</div>
                       		<div class="row mt-2">
                       			<div class="col-md-3 lft-p-det">
                       				<p>Reason for leaving</p>
                       			</div>
                       			<div class="col-md-2 ryt-p lft-p-det">
                       				<p>:</p>
                       			</div>
                       			<div class="col-md-7 ryt-p lft-p-det">
                       				<p><?php echo isset($componentData['reason_for_leaving'])?$componentData['reason_for_leaving']:'-';?></p>
                       			</div>
                       		</div>
                        </div> 
                        <div class="col-md-6">
                        	<div class="row mt-2">
                       			<div class="col-md-3 lft-p-det">
                       				<p>Joining date</p>
                       			</div>
                       			<div class="col-md-2 ryt-p lft-p-det">
                       				<p>:</p>
                       			</div>
                       			<div class="col-md-7 ryt-p lft-p-det">
                       				<p><?php echo isset($componentData['joining_date'])?date($php_code_selected_datetime_format[0],strtotime($componentData['joining_date'])):'-';?></p>
                       			</div>
                       		</div>
                       		<div class="row mt-2">
                       			<div class="col-md-3 lft-p-det">
                       				<p>Relieving_date</p>
                       			</div>
                       			<div class="col-md-2 ryt-p lft-p-det">
                       				<p>:</p>
                       			</div>
                       			<div class="col-md-7 ryt-p lft-p-det">
                       				<p><?php echo isset($componentData['relieving_date'])?date($php_code_selected_datetime_format[0],strtotime($componentData['relieving_date'])):'-';?></p>
                       			</div>
                       		</div>
                       		<div class="row mt-2">
                       			<div class="col-md-3 lft-p-det">
                       				<p>Reporting manager name</p>
                       			</div>
                       			<div class="col-md-2 ryt-p lft-p-det">
                       				<p>:</p>
                       			</div>
                       			<div class="col-md-7 ryt-p lft-p-det">
                       				<p><?php echo isset($componentData['reporting_manager_name'])?$componentData['reporting_manager_name']:'-';?></p>
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
                       				<p><?php echo isset($componentData['reporting_manager_contact_number'])?$componentData['reporting_manager_contact_number']:'-';?></p>
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
                       				<p><?php echo isset($componentData['hr_name'])?$componentData['hr_name']:'-';?></p>
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
                              $hr_contact = isset($componentData['hr_contact_number'])?$componentData['hr_contact_number']:'';
                               echo isset($componentData['hr_code'])?$componentData['hr_code']:''." ".$hr_contact;?></p>
                       			</div>
                       		</div>
                        </div>
                        <div class="container ">
	                        <div class="container detail mt-2">
	                        	<h3 class="permt mt-4">Uploded Document By Candidate</h3>
	                        	<!-- <div class="lft-p-det"> -->
	                        		<?php
                                $appointment_letter = explode(",",isset($componentData['appointment_letter'])?$componentData['appointment_letter']:''); 
                                $experience_relieving_letter = explode(",",isset($componentData['experience_relieving_letter'])?$componentData['experience_relieving_letter']:''); 
                                $last_month_pay_slip = explode(",",isset($componentData['last_month_pay_slip'])?$componentData['last_month_pay_slip']:''); 
                                $bank_statement_resigngation_acceptance = explode(",",isset($componentData['bank_statement_resigngation_acceptance'])?$componentData['bank_statement_resigngation_acceptance']:''); 

                                // print_r($appointment_letter);
                                // echo "<br>";
                                // print_r($experience_relieving_letter);
                                // echo "<br>";
                                // print_r($last_month_pay_slip);
                                // echo "<br>";
                                // print_r($bank_statement_resigngation_acceptance);
                                // echo "<br>";


                              if(count($appointment_letter)  > 0){ ?> 
                              <div> 
                                  <div class="row mt-3"> 
                                      <div class="col-md-6">
                                      <div class="row mt-2">
                                        <div class="col-md-4 hd-h6">
                                          <p>Appointment letter</p>
                                        </div> 
                                      </div> 
                                    </div> 
                                  </div>
                                  <div class="row ">
                                    <?php 
                                    foreach ($appointment_letter as $key => $value) { 
                                      $ext = pathinfo($value, PATHINFO_EXTENSION);
                                      $url = base_url()."../uploads/appointment_letter/".$value;
                                      
                                      if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){
                                    ?>
                                    
                                    <div class="col-md-4">
                                      <!-- <div class="pg-frm-hd"><?php //echo $documentType[$i]?></div> -->
                                        <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">
                                          <div class="image-selected-div">
                                            <ul class="p-0 mb-0">
                                              <li class="image-selected-name pb-0"><?php echo $value ?></li>
                                              <li class="image-name-delete pb-0">
                                                <a id="docs_modal_file<?php echo $candidateId ?>" onclick="view_document_modal('<?php echo $url ?>')" class="image-name-delete-a">
                                                  <i class="fa fa-eye text-primary"></i>
                                                </a>
                                                <?php echo "<a href='{$url}' download >  <i class='fa fa-download'></i></a>"; ?>
                                              </li>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    <!-- </div> -->
                                    <?php 
                                      }else if($ext == 'pdf'){ ?>
                                        <div class="col-md-6">
                                      <!-- <div class="pg-frm-hd"><?php //echo $documentType[$i]?></div> -->
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
                                      }else{ ?>
                                         
                                          <div class="col-md-6 lft-p-det">
                                            <p>No files available.</p>
                                          </div>   
                                    <?php   
                                        }
                                      }
                                    }else{?> 
                                      <!-- <div class="row mt-2"> -->
                                        <div class="col-md-6 lft-p-det">
                                          <p>No data found.</p>
                                        </div> 
                                      <!-- </div>  -->
                                   <?php }
                                    ?>
                                  </div>
                              </div>
                              <?php if(count($experience_relieving_letter)  > 0){ ?> 
                              <div> 
                                  <div class="row mt-3"> 
                                      <div class="col-md-6">
                                      <div class="row mt-2">
                                        <div class="col-md-5 hd-h6">
                                          <p>Experience relieving letter</p>
                                        </div> 
                                      </div> 
                                    </div> 
                                  </div>
                                  <div class="row">
                                    <?php 
                                    foreach ($experience_relieving_letter as $key => $value) { 
                                      $ext = pathinfo($value, PATHINFO_EXTENSION);
                                      $url = base_url()."../uploads/experience_relieving_letter/".$value;
                                      
                                      if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){
                                    ?>
                                    
                                    <div class="col-md-4">
                                      <!-- <div class="pg-frm-hd"><?php //echo $documentType[$i]?></div> -->
                                        <div class="col-md-12 pl-0 pr-0" id="file_vendor_documents_0">
                                          <div class="image-selected-div">
                                            <ul class="p-0 mb-0">
                                              <li class="image-selected-name pb-0"><?php echo $value ?></li>
                                              <li class="image-name-delete pb-0">
                                                <a id="docs_modal_file<?php echo $candidateId ?>" onclick="view_document_modal('<?php echo $url ?>')" class="image-name-delete-a">
                                                  <i class="fa fa-eye text-primary"></i>
                                                </a>
                                                <?php echo "<a href='{$url}' download >  <i class='fa fa-download'></i></a>"; ?>
                                              </li>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    <!-- </div> -->
                                    <?php 
                                      }else if($ext == 'pdf'){ ?>
                                        <div class="col-md-6">
                                      <!-- <div class="pg-frm-hd"><?php //echo $documentType[$i]?></div> -->
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
                                      }else{ ?>
                                        
                                          <div class="col-md-6 lft-p-det">
                                            <p>No files available.</p>
                                          </div> 
                                         
                                    <?php   
                                        }
                                      }
                                    }else{?> 
                                      <!-- <div class="row mt-2"> -->
                                        <div class="col-md-6 lft-p-det">
                                          <p>No data found.</p>
                                        </div> 
                                      <!-- </div>  -->
                                   <?php }
                                    ?> 
                                  </div>
                              </div>
                              <?php if(count($last_month_pay_slip)  > 0){ ?> 
                              <div> 
                                  <div class="row mt-3"> 
                                      <div class="col-md-6">
                                      <div class="row mt-2">
                                        <div class="col-md-4 hd-h6">
                                          <p>Last month pay slip</p>
                                        </div> 
                                      </div> 
                                    </div> 
                                  </div>
                                  <div class="row ">
                                    <?php 
                                    foreach ($last_month_pay_slip as $key => $value) { 
                                      $ext = pathinfo($value, PATHINFO_EXTENSION);
                                      $url = base_url()."../uploads/last_month_pay_slip/".$value;
                                      
                                      if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){
                                    ?>
                                    
                                    <div class="col-md-4">
                                      <!-- <div class="pg-frm-hd"><?php //echo $documentType[$i]?></div> -->
                                        <div class="col-md-12  pl-0 pr-0" id="file_vendor_documents_0">
                                          <div class="image-selected-div">
                                            <ul class="p-0 mb-0">
                                              <li class="image-selected-name pb-0"><?php echo $value ?></li>
                                              <li class="image-name-delete pb-0">
                                                <a id="docs_modal_file<?php echo $candidateId ?>" onclick="view_document_modal('<?php echo $url ?>')" class="image-name-delete-a">
                                                  <i class="fa fa-eye text-primary"></i>
                                                </a>
                                                <?php echo "<a href='{$url}' download >  <i class='fa fa-download'></i></a>"; ?>
                                              </li>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    <!-- </div> -->
                                    <?php 
                                      }else if($ext == 'pdf'){ ?>
                                        <div class="col-md-6">
                                      <!-- <div class="pg-frm-hd"><?php //echo $documentType[$i]?></div> -->
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
                                      }else{ ?>
                                        
                                          <div class="col-md-6 lft-p-det">
                                            <p>No files available.</p>
                                          </div> 
                                         
                                    <?php   
                                        }
                                      }
                                    }else{?> 
                                      <!-- <div class="row mt-2"> -->
                                        <div class="col-md-6 lft-p-det">
                                          <p>No data found.</p>
                                        </div> 
                                      <!-- </div>  -->
                                   <?php }
                                    ?> 
                                  </div>
                              </div>
                              <?php if(count($bank_statement_resigngation_acceptance)  > 0){ ?> 
                              <div> 
                                  <div class="row mt-3"> 
                                      <div class="col-md-6">
                                      <div class="row mt-2">
                                        <div class="col-md-8 hd-h6">
                                          <p>Bank statement resigngation acceptance</p>
                                        </div> 
                                      </div> 
                                    </div> 
                                  </div>
                                  <div class="row ">
                                    <?php 
                                    foreach ($bank_statement_resigngation_acceptance as $key => $value) { 
                                      $ext = pathinfo($value, PATHINFO_EXTENSION);
                                      $url = base_url()."../uploads/bank_statement_resigngation_acceptance/".$value;
                                      
                                      if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){
                                    ?>
                                    
                                    <div class="col-md-4">
                                      <!-- <div class="pg-frm-hd"><?php //echo $documentType[$i]?></div> -->
                                        <div class="col-md-12  pl-0 pr-0" id="file_vendor_documents_0">
                                          <div class="image-selected-div">
                                            <ul class="p-0 mb-0">
                                              <li class="image-selected-name pb-0"><?php echo $value ?></li>
                                              <li class="image-name-delete pb-0">
                                                <a id="docs_modal_file<?php echo $candidateId ?>" onclick="view_document_modal('<?php echo $url ?>')" class="image-name-delete-a">
                                                  <i class="fa fa-eye text-primary"></i>
                                                </a>
                                                <?php echo "<a href='{$url}' download >  <i class='fa fa-download'></i></a>"; ?>
                                              </li>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    <!-- </div> -->
                                    <?php 
                                      }else if($ext == 'pdf'){ ?>
                                        <div class="col-md-6">
                                      <!-- <div class="pg-frm-hd"><?php //echo $documentType[$i]?></div> -->
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
                                      }else{ ?>
                                        
                                          <div class="col-md-6 lft-p-det">
                                            <p>No files available.</p>
                                          </div> 
                                        
                                    <?php   
                                        }
                                      }
                                    }else{?> 
                                      <!-- <div class="row mt-2"> -->
                                        <div class="col-md-6 lft-p-det">
                                          <p>No data found.</p>
                                        </div> 
                                      <!-- </div>  -->
                                   <?php }
                                    ?>
                                  </div>
                              </div>
	                        	</div>
	                        </div> 
                        </div>
                      </div>
                    </div>
                    <h3 class="permt mt-4">Current Employment Verification Details</h3>
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
  	                              <input name="employee_id" class="fld form-control employee_id" id="employee_id" value="<?php echo isset($componentData['remarks_emp_id'])?$componentData['remarks_emp_id']:""?>"  type="text">
  	                            </div>
                                <div id="employee_id-error">&nbsp;</div>
                          	</div>
                          	<div class="row mt-2">
	                            <div class="col-md-3">
	                              <p class="det">Designation</p>
	                            </div>
	                            <div class="col-md-2 pr-0">
	                              <p>:</p>
	                            </div>
	                            <div class="col-md-7">
	                              <input name="designation" class="fld form-control pincode" id="designation" value="<?php echo isset($componentData['remarks_designation'])?$componentData['remarks_designation']:""?>" type="text">
                                <div id="designation-error">&nbsp;</div>
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
	                              <input name="department" class="fld form-control pincode" id="department" value="<?php echo isset($componentData['remark_department'])?$componentData['remark_department']:""?>" type="text">
	                            </div>
                              <div id="employee_id-error">&nbsp;</div>
                          	</div>
                          	<div class="row mt-2">
	                            <div class="col-md-3">
	                              <p class="det">Date of Joining</p>
	                            </div>
	                            <div class="col-md-2 pr-0">
	                              <p>:</p>
	                            </div>
	                            <div class="col-md-7">
	                              <input name="date_of_joining" class="fld form-control date-for-candidate-aggreement-start-date" id="date_of_joining" value="<?php echo isset($componentData['remark_date_of_joining'])?$componentData['remark_date_of_joining']:""?>" type="text" data-dtp="dtp_vOoRp">
                                 <div id="date_of_joining-error">&nbsp;</div>
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
	                              <input name="date_of_relieving" disabled class="fld form-control date-for-candidate-aggreement-end-date" id="date_of_relieving" value="<?php echo isset($componentData['remark_date_of_relieving'])?$componentData['remark_date_of_relieving']:""?>" type="text" data-dtp="dtp_vOoRp">
                                <div id="date_of_relieving-error">&nbsp;</div>
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
                                  $currency_info = isset($componentData['remark_currency'])?$componentData['remark_currency']:"";
                                ?>
                                <select class="fld form-control Currency select2" id="currency">
                                  <?php 
                                    // echo count($currency_decod);
                                    foreach ($currency_decod as $key => $currencyValue) {
                                        // echo  $currencyValue['']
                                      if($currency_info == $currencyValue['cc']){
                                        echo '<option selected value="'.$currencyValue['cc'].'">'.$currencyValue['cc'].'</option>';
                                      }else{
                                        echo '<option value="'.$currencyValue['cc'].'">'.$currencyValue['cc'].'</option>';
                                      }
                                     } 
                                    
                                  ?>                                  
                                </select>
                                <div id="currency-error">&nbsp;</div>
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

                                 <select class="fld form-control" id="remark_salary_type">
                                  <?php 
                                    $yearly = '';
                                    $montly = '';
                                    $salaryType = isset($componentData['remark_salary_type'])?$componentData['remark_salary_type']:"";
                                    if($salaryType  == 'yearly'){
                                      $yearly = 'selected';
                                    }else if($salaryType  == 'monthly'){
                                      $montly = 'selected';
                                    }
                                  ?>
                                   <option <?php echo $yearly ?> selected value="yearly">Yearly</option>
                                   <option <?php echo $montly ?> value="monthly">Monthly</option>
                                 </select>
                                 <div id="remark_salary_type-error">&nbsp;</div>
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
                                <input name="salary_lakhs" class="fld form-control pincode" id="salary_lakhs" value="<?php echo isset($componentData['remark_salary_lakhs'])?$componentData['remark_salary_lakhs']:""?>" onkeypress="return isNumberKey(event)" type="text">
                                <div id="salary_lakhs-error">&nbsp;</div>
                              </div>
                            </div>
                          	<div class="row mt-2">
	                            <div class="col-md-3">
	                              <p class="det">Manager's Designation</p>
	                            </div>
	                            <div class="col-md-2 pr-0">
	                              <p>:</p>
	                            </div>
	                            <div class="col-md-7">
	                              <input name="managers_designation" class="fld form-control pincode" id="managers_designation" value="<?php echo isset($componentData['remark_managers_designation'])?$componentData['remark_managers_designation']:""?>" type="text">
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
	                              <input name="managers_contact" class="fld form-control pincode" id="managers_contact" value="<?php echo isset($componentData['remark_managers_contact'])?$componentData['remark_managers_contact']:""?>" type="text">
                                <div id="managers_contact-error">&nbsp;</div>
	                            </div>
                          	</div>
                          	<div class="row mt-2">
	                            <div class="col-md-3">
	                              <p class="det">Physical Visit</p>
	                            </div>
	                            <div class="col-md-2 pr-0">
	                              <p>:</p>
	                            </div>
	                            <div class="col-md-7">
	                               <?php 
                                  $pv = isset($componentData['remark_physical_visit'])?$componentData['remark_physical_visit']:'';
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
                                <select class="fld form-control physical_visit" name="physical-visit" id="physical-visit">
                                  <option <?php echo $selecet_pv; ?> selected value="">Select PV</option>
                                  <option <?php echo $yes; ?> value="yes">Yes</option>
                                  <option <?php echo $no; ?> value="no">No</option>
                                </select>
                                <div id="physical-visit-error"></div>
	                            </div>
                          	</div>
                          	<!-- <div class="row mt-2">
	                            <div class="col-md-3">
	                              <p class="det">Manager's Contact</p>
	                            </div>
	                            <div class="col-md-2 pr-0">
	                              <p>:</p>
	                            </div>
	                            <div class="col-md-7">
	                              <input name="" class="fld form-control pincode" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeyup="valid_pincode(0)" id="pincode0" type="text">
	                            </div>
                          	</div> -->
                          	<div class="row mt-2">
	                            <div class="col-md-3">
	                              <p class="det">Verified By(HR Name)</p>
	                            </div>
	                            <div class="col-md-2 pr-0">
	                              <p>:</p>
	                            </div>
	                            <div class="col-md-7">
	                              <input name="remark_hr_name" class="fld form-control pincode" id="remark_hr_name" value="<?php echo isset($componentData['remark_hr_name'])?$componentData['remark_hr_name']:""?>" type="text">
                                <div id="remark_hr_name-error">&nbsp;</div>
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
	                              <input name="remark_hr_email" class="fld form-control pincode" id="remark_hr_email" value="<?php echo isset($componentData['remark_hr_email'])?$componentData['remark_hr_email']:""?>" type="text">
                                <div id="remark_hr_email-error">&nbsp;</div>
	                            </div>
                              
                          	</div>
                          	<div class="row mt2">
                              <div class="add-vendor-bx2 ">
                                <h3 class="m-0">&nbsp;</h3>
                                <ul>
                                   <li class="vendor-wdt2">
                                      <p class="lft-p-det">Verification Proof Upload Section</p>
                                      <div class="form-group mb-0 d-none">
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
                                            }
                                          } 
                                        ?>
                                      </div>
                                    </li> 
                                  </ul>
                                <div class="row" id="selected-vendor-docs-li"></div>
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
	                              <input name="remark_hr_phone" class="fld form-control pincode" id="remark_hr_phone" value="<?php echo isset($componentData['remark_hr_phone_no'])?$componentData['remark_hr_phone_no']:""?>" type="text">
                                <div id="remark_hr_phone-error">&nbsp;</div>
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
	                              <input name="remarks_reason_for_leaving" class="fld form-control pincode" id="remarks_reason_for_leaving" value="<?php echo isset($componentData['remark_reason_for_leaving'])?$componentData['remark_reason_for_leaving']:""?>" type="text">
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
	                              <!-- <input name="eligible_for_re_hire" class="fld form-control pincode" id="eligible_for_re_hire" value="<?php //echo $componentData['remark_eligible_for_re_hire']?$componentData['remark_eligible_for_re_hire']:""?>" type="text"> -->
                                <select class="fld form-control" id="eligible_for_re_hire">
                                  <?php 
                                    $yes = '';
                                    $no = '';
                                    $no_comment = '';
                                    $remark_eligible = isset($componentData['remark_eligible_for_re_hire'])?$componentData['remark_eligible_for_re_hire']:"";
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
	                            </div>
                              <div id="remark_eligible_for_re_hire-error">&nbsp;</div>
                          	</div> 
                          	<div class="row mt-2">
	                            <div class="col-md-3">
	                              <p class="det">Attendance & Punctuality</p>
	                            </div>
	                            <div class="col-md-2 pr-0">
	                              <p>:</p>
	                            </div>
	                            <div class="col-md-7">
	                              <!-- <input name="attendance_punctuality" class="fld form-control attendance_punctuality" id="attendance_punctuality" value="<?php //echo $componentData['remark_attendance_punctuality']?$componentData['remark_attendance_punctuality']:""?>" type="text"> -->
                                <select class="fld form-control attendance_punctuality" id="attendance_punctuality">
                                  <?php 
                                    $one_punctuality = '';
                                    $two_punctuality = '';
                                    $three_punctuality = '';
                                    $four_punctuality = '';
                                    $five_punctuality = ''; 
                                    $punctuality_did_not_comment = '';
                                    $remark_eligible = isset($componentData['remark_attendance_punctuality'])?$componentData['remark_attendance_punctuality']:"";
                                    if($remark_eligible  == '1'){
                                      $one_punctuality = 'selected';
                                    }else if($remark_eligible  == '2'){
                                      $two_punctuality = 'selected';
                                    }else if($remark_eligible  == '3'){
                                      $three_punctuality = 'selected';
                                    }else if($remark_eligible  == '4'){
                                      $four_punctuality = 'selected';
                                    }else if($remark_eligible  == '5'){
                                      $five_punctuality = 'selected';
                                    }else if($remark_eligible  == 'did_not_comment'){
                                      $punctuality_did_not_comment = 'selected';
                                    } 
                                  ?>
                                   <option <?php echo $one_punctuality ?> selected value="1">1</option>
                                   <option <?php echo $two_punctuality ?> value="2">2</option>
                                   <option <?php echo $three_punctuality ?> value="3">3</option>
                                   <option <?php echo $four_punctuality ?> value="4">4</option>
                                   <option <?php echo $five_punctuality ?> value="5">5</option> 
                                   <option <?php echo $punctuality_did_not_comment ?> value="did_not_comment">Did not Comment</option> 
                                 </select>
	                            </div>
                              <div id="attendance_punctuality-error">&nbsp;</div>
                          	</div>
                          	<div class="row mt-2">
	                            <div class="col-md-3">
	                              <p class="det">Job Performance ( On scale of 1 -5)</p>
	                            </div>
	                            <div class="col-md-2 pr-0">
	                              <p>:</p>
	                            </div>
	                            <div class="col-md-7">
	                              <!-- <input name="job_performance" class="fld form-control pincode" id="job_performance" value="<?php //echo $componentData['remark_job_performance']?$componentData['remark_job_performance']:""?>" type="text"> -->
                                <select class="fld form-control" id="job_performance">
                                  <?php 
                                    $one = '';
                                    $two = '';
                                    $three = '';
                                    $four = '';
                                    $five = ''; 
                                    $job_performance_did_not_comment = '';
                                    $remark_eligible = isset($componentData['remark_job_performance'])?$componentData['remark_job_performance']:"";
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
                                    }else if($remark_eligible  == 'did_not_comment'){
                                      $job_performance_did_not_comment = 'selected';
                                    } 
                                  ?>
                                   <option <?php echo $one ?> selected value="1">1</option>
                                   <option <?php echo $two ?> value="2">2</option>
                                   <option <?php echo $three ?> value="3">3</option>
                                   <option <?php echo $four ?> value="4">4</option>
                                   <option <?php echo $five ?> value="5">5</option> 
                                   <option <?php echo $job_performance_did_not_comment ?> value="did_not_comment">Did not Comment</option> 
                                 </select>
                                 <div class="warning-h6">1 is the lowest and 5 is the highest rating.</div>
                                 <div id="job_performance-error">&nbsp;</div>
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
	                              <!-- <input name="exit_status" class="fld form-control pincode" id="exit_status" value="<?php //echo $componentData['remark_exit_status']?$componentData['remark_exit_status']:""?>" type="text"> -->
                                <?php
                                $Pending='';
                                $Completed='';
                                 
                                $exit_status_did_not_comment = '' ;
                                $target = isset($componentData['remark_exit_status'])?$componentData['remark_exit_status']:'0';

                                if($target== 'Pending'){
                                  $Pending='selected';
                                }else if($target == 'Completed'){
                                  $Completed='selected';
                                }else if($target == 'did_not_comment'){
                                  $exit_status_did_not_comment='selected';
                                }else{
                                  $exit_status_did_not_comment='selected';
                                }
                              ?>
                              <select class="fld form-control orientation" id="orientation<?php echo $i; ?>" > 
                                <option <?php echo $Pending; ?> value="Pending" >Pending</option>
                                <option <?php echo $Completed; ?> value="Completed" >Completed</option> 
                                <option <?php echo $exit_status_did_not_comment; ?> value="did_not_comment" >Did not Comment</option>
                              </select> 
                                <div id="exit_status-error">&nbsp;</div>
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
	                              <!-- <input name="disciplinary_issues" class="fld form-control pincode" id="disciplinary_issues" value="<?php //echo $componentData['remark_disciplinary_issues']?$componentData['remark_disciplinary_issues']:""?>" type="text"> -->
                                <select class="fld form-control" id="disciplinary_issues">
                                  <?php 
                                    $yes_disciplinary = '';
                                    $no_disciplinary = '';
                                    $no_comment_disciplinary = '';

                                    $remark_disciplinary = isset($componentData['remark_disciplinary_issues'])?$componentData['remark_disciplinary_issues']:"";

                                    if($remark_disciplinary  == 'yes'){
                                      $yes_disciplinary = 'selected';
                                    }else if($remark_disciplinary  == 'no'){
                                      $no_disciplinary = 'selected';
                                    }else if($remark_disciplinary  == 'no_comment'){
                                      $no_comment_disciplinary = 'selected';
                                    }

                                  ?>
                                   <option <?php echo $yes_disciplinary ?> selected value="yes">Yes</option>
                                   <option <?php echo $no_disciplinary ?> value="no">No</option>
                                   <option <?php echo $no_comment_disciplinary ?> value="no_comment">No Comment</option>
                                 </select>
                                  <div id="disciplinary_issues-error">&nbsp;</div>
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
	                              <textarea name="verification_remarks" class="fld form-control verification_remarks" id="verification_remarks" ><?php echo $componentData['verification_remarks']?$componentData['verification_remarks']:""?></textarea>
	                            </div>
                               <div id="verification_remarks-error">&nbsp;</div>
                          	</div>
                          	<div class="row mt-2">
	                            <div class="col-md-3">
	                              <p class="det">Insuff Remarks</p>
	                            </div>
	                            <div class="col-md-2 pr-0">
	                              <p>:</p>
	                            </div>
	                            <div class="col-md-7">
	                              <textarea name="insuff_remarks" class="fld form-control pincode" id="insuff_remarks"><?php echo $componentData['Insuff_remarks']?$componentData['Insuff_remarks']:""?></textarea>
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
	                               <textarea name="insuff_closure_remarks" class="fld form-control pincode" id="insuff_closure_remarks" ><?php echo $componentData['Insuff_closure_remarks']?$componentData['Insuff_closure_remarks']:""?></textarea>
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
                                <input name="verification_fee" class="fld form-control verification_fee" id="verification_fee" value="<?php echo isset($componentData['verification_fee'])?$componentData['verification_fee']:""?>" 
                                onkeypress="return isNumberKey(event)"  type="text">
                              </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                  <!-- <?php  
                    // $j++;
                    // } 
               		?> -->
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <?php
                        $analystStatus = '';
                         $disabled = '';
                        $an_status = isset($componentData['analyst_status'])?$componentData['analyst_status']:'0';
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
                            name="analyst_status"
                            id="analyst_status"
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
                          $output_status = isset($componentData['output_status'])?$componentData['output_status']:'';
                          if($output_status == 1){
                            $approveOpStatus = 'selected';
                          }else if($output_status == 2){
                            $rejectOpStatus = 'selected';
                          }else {
                            $defaultOpStatus = 'selected'; 
                          }
                      ?>
                      <select id="op_action_status" <?php echo $disabled; ?> name="carlist" class="sel-allcase">
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
                        rows="3" ><?php echo isset($componentData['ouputqc_comment'])?$componentData['ouputqc_comment']:'' ?></textarea>
                      <div id="address-error"></div>
                    </div>
                  </div>
                </div>
                <hr>
                  <div class="row mt-2">
                    <div class="col-md-6">
                      
                    </div>
                    <div class="col-md-6 text-right">
                      <input type="hidden" value="<?php echo isset($componentData['candidate_id'])?$componentData['candidate_id']:''; ?>" id="candidate_id_hidden"name="">
                      <a href="<?php echo $this->config->item('my_base_url').$backLink?>"><button class="close-bt">Close</button></a>
                      <button id="conformtion_dialog" class="update-bt">Update</button>
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
                <button class="btn bg-blu float-right text-white" id="submit-data">Confirm</button>
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
<script>
	$('#physical-visit').click(function(){
		// alert("click")
		if($('#physical-visit').prop('checked') == true) { 
    		$('#physical-visit-label').html('Yes')
        $('#physical-visit-label').val('1')
		} else {
			$('#physical-visit-label').html('No')
      $('#physical-visit-label').val('0')
		}
	})
</script>

<!-- <script>
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

</script> -->
<?php
  include APPPATH.'views/analyst/assigned-case/component-pages/view_image_model.php';
?>
<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/commonImageView.js"></script>

<script src="<?php echo base_url() ?>assets/custom-js/outputqc/remarks/remark-current-employee.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/outputqc/remarks/commonImageView.js"></script>
