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
  <input type="hidden" value="<?php echo $userID?> " id="userID" name="userID">
  <input type="hidden" value="<?php echo $userRole ?>" id="userRole" name="userRole">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
         <!-- <h3>Case Detail</h3> -->
          
          <a class="btn bg-blu btn-submit-cancel" id="back-btn" href="<?php echo $this->config->item('my_base_url').$backLink;?>" ><span class="text-white"><i class="fas fa-angle-left"></i>&nbsp;Back</span></a>

          <h3 class="mt-3">Drug Test Detail</h3>
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
                    $drugtestType = json_decode($componentData['drugtestType'],true);
                    $address = json_decode($componentData['address'],true); 
                    $candidate_name = json_decode($componentData['candidate_name'],true); 
                    $father_name = json_decode($componentData['father__name'],true); 
                    $dob = json_decode($componentData['dob'],true); 
                    $code = json_decode($componentData['code'],true); 
                    $mobile_number = json_decode($componentData['mobile_number'],true); 
                    // remark  details  
                    $remark_address = json_decode($componentData['remark_address'],true); 
                    $remark_city = json_decode($componentData['remark_city'],true); 
                    $remark_state = json_decode($componentData['remark_state'],true); 
                    $remark_pin_code = json_decode($componentData['remark_pin_code'],true); 
                    $in_progress_remarks = json_decode($componentData['in_progress_remarks'],true); 
                    $verification_remarks = json_decode($componentData['verification_remarks'],true); 
                    $insuff_remarks = json_decode($componentData['insuff_remarks'],true); 
                    $insuff_closure_remarks = json_decode($componentData['insuff_closure_remarks'],true); 
                    $approved_doc = json_decode($componentData['approved_doc'],true);
                    $analyst_status=  explode(',',$componentData['analyst_status']);
                    $output_status=  explode(',',$componentData['output_status']);
                    // print_r($remark_address);
                    $j=1;
                    for ($i=0; $i < count($drugtestType) ; $i++) { 
                      // echo "<br>i : ".$i;
                    ?>
                      
                    <div>
	                    <h3 class="permt mt-4">Drugtest <?php echo $drugtestType[$i] ?> Details <?php echo $j?>  </h3>
	                    <div class="row mt-3"> 
                          	<div class="col-md-6">
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Candidate name</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($candidate_name[$i]['candidate_name'])?$candidate_name[$i]['candidate_name']:"No data found"?></p>
	                       			</div>
	                       		</div>
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Father Name</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($father_name[$i]['father_name'])?$father_name[$i]['father_name']:"No data found"?></p>
	                       			</div>
	                       		</div>
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>DOB(Date of birth)</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($dob[$i]['dob'])?date($php_code_selected_datetime_format[0],strtotime($dob[$i]['dob'])):"No data found"?></p>
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
	                       				<p><?php echo isset($address[$i]['address'])?$address[$i]['address']:"No data found";?></p>
	                       			</div>
	                       		</div>
	                       	</div> 
                      	</div>
                    </div>
                    <h3 class="permt mt-4">Drugtest <?php echo $drugtestType[$i] ?> Verification Details <?php echo $j; ?> </h3>
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
                              <textarea 
                                class="fld form-control address"
                                id="address"  
                                rows="3" ><?php echo isset($remark_address[$i]['remarks_address'])?$remark_address[$i]['remarks_address']:""?></textarea>
                              <div id="address-error"></div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">City</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="city" value="<?php echo isset($remark_city[$i]['remarks_city'])?$remark_city[$i]['remarks_city']:""; ?>" class="fld form-control city" id="city" type="text">
                              <div id="city-error"></div>
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
                              <input name="state" class="fld form-control state" id="state" value="<?php echo isset($remark_state[$i]['remarks_state'])?$remark_state[$i]['remarks_state']:""?>" type="text">
                              <div id="state-error"></div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Pin-Code</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="pincode" class="fld form-control pincode" onkeyup="valid_pincode(<?php echo $i; ?>)" onblur="valid_pincode(<?php echo $i; ?>)" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="pincode<?php echo $i; ?>" value="<?php echo isset($remark_pin_code[$i]['remarks_pincode'])?$remark_pin_code[$i]['remarks_pincode']:""?>" type="text">
                              <div id="pincode-error<?php echo $i; ?>"></div>
                            </div>
                          </div>

                           <div class="row mt2">
                             
                            <div class="add-vendor-bx2 ">
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
                                           if (isset($approved_doc[$i])) {
                                           if (!in_array('no-file',  $approved_doc[$i])) {
                                             foreach ($approved_doc[$i] as $key1 => $value) {
                                                if ($value !='') {
                                                  $url = base_url()."../uploads/remarks-docs/".$value;
                                                  echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a> <a href='{$url}' download >  <i class='fa fa-download'></i></a> </span></div>";
                                              }
                                             }
                                              $pan_card_doc = $approved_doc[$i];
                                            } 
                                          } 
                                        ?>
                                      </div>
                                 </li> 
                                </ul>
                              <div class="row" id="selected-criminal-docs-li<?php echo $i; ?>"></div>
                            </div>
                          </div>

                        </div>
                        <div class="col-md-6">
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Insuff Remarks</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <textarea  name="insuff_remarks" class="fld form-control insuff_remarks" id="insuff_remarks" ><?php echo isset($insuff_remarks[$i]['insuff_remarks'])?$insuff_remarks[$i]['insuff_remarks']:""?></textarea>
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
                              <textarea  name="in_progress_remark" class="fld form-control in_progress_remark" id="in_progress_remark" ><?php echo isset($in_progress_remarks[$i]['in_progress_remark'])?$in_progress_remarks[$i]['in_progress_remark']:""?></textarea>
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
                              <textarea name="verification_remarks" class="fld form-control verification_remarks" id="verification_remarks"><?php echo isset($verification_remarks[$i]['verification_remarks'])?$verification_remarks[$i]['verification_remarks']:""?></textarea>
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
                              <textarea name="insuff_closer_remark" class="fld form-control insuff_closer_remark" id="insuff_closer_remark">
                                <?php echo isset($insuff_closure_remarks[$i]['insuff_closer_remark'])?$insuff_closure_remarks[$i]['insuff_closer_remark']:""?>
                              </textarea>
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
                                 $an_status = isset($analyst_status[$i])?$analyst_status[$i]:'0';
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
                                name="analyst_status_<?php echo $i ?>"
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
                                  if($output_status[$i] == 1){
                                    $approveOpStatus = 'selected';
                                  }else if($output_status[$i] == 2){
                                    $rejectOpStatus = 'selected';
                                  }else {
                                    $defaultOpStatus = 'selected'; 
                                  }
                              ?>
                              <select id="output_status" <?php echo $disabled; ?> name="carlist" class="sel-allcase output_status">
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
                                    rows="3" ><?php echo isset($ouputqc_comment[$i]['ouputQcComment'])?$ouputqc_comment[$i]['ouputQcComment']:'' ?></textarea>
                              <div id="address-error"></div>
                            </div>
                      </div>
                        
                        <hr>
                  <?php 
                    $j++;
                    } 
                  ?>
                   <!-- <div class="row mt-2">
                    <div class="col-md-6">

                      
                      <?php
                        // $defaultStatus = '';
                        // $insuffStatus = '';
                        // $verifiedclearStatus = '';
                        // $stopcheckStatus = '';
                        // $utv = '';
                        // $vd = '';
                        // $cc = '';
                        // $ci ='';
                        // $disabled = '';
                        // $disabledOP = '';
                        // if($componentData['analyst_status'] == 0){
                        //   $defaultStatus = 'selected';
                        // }else if($componentData['analyst_status'] == 3){
                        //   $insuffStatus = 'selected';
                        // }else if($componentData['analyst_status'] == 4){
                        //   $verifiedclearStatus = 'selected';
                        //   // $disabled = 'disabled';
                        // }else if($componentData['analyst_status'] == 5){
                        //   $stopcheckStatus = 'selected';
                        // }else if($componentData['analyst_status'] == 6){
                        //   $utv = 'selected';
                        // }else if($componentData['analyst_status'] == 7){
                        //   $vd = 'selected';
                        // }else if($componentData['analyst_status'] == 8){
                        //   $cc = 'selected';
                        // }else if($componentData['analyst_status'] == 9){
                        //   $ci = 'selected';
                        // }
                        
                        // $subTitle = '';
                        // $selectOpStatusEnable = 'd-none';
                        // if($outputQCStatus == 'disabled'){
                        //   $subTitle = 'Analyst component status';
                        //   $selectOpStatusEnable = '';
                        // }else{
                        //   $subTitle = 'Select component status';
                        // }
                         

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
                        <option <?php echo $ci ?> value="9">Closed insufficiency</option>
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
                          // $approveOpStatus = '';
                          // $rejectOpStatus = '';
                          // $defaultOpStatus = '';
                          // if($componentData['output_status'] == 1){
                          //   $approveOpStatus = 'selected';
                          // }else if($componentData['output_status'] == 2){
                          //   $rejectOpStatus = 'selected';
                          // }else {
                          //   $defaultOpStatus = 'selected'; 
                          // }
                      ?>
                      <select id="op_action_status" name="carlist" class="sel-allcase">
                        <option <?php echo $defaultOpStatus ?> value="0">Select your Action</option>
                        <option <?php echo $approveOpStatus ?> value="1">Approved</option>
                        <option <?php echo $rejectOpStatus ?> value="2">Rejected</option>
                      </select>
                    </div>
                  </div> -->
                </div>
                <!-- <hr> -->
                  <div class="row mt-2">
                    <div class="col-md-6">
                      
                    </div>
                    <div class="col-md-6 text-right">
                      <input type="hidden" value="<?php echo $componentData['candidate_id']?>" id="candidate_id_hidden" name="">
                      <a href="<?php echo $this->config->item('my_base_url').$backLink?>"><button class="close-bt">Close</button></a>
                      <button class="update-bt" id="confirm-update">Update</button>
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
<div id="conformtionGlobalDb" class="modal fade">
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
        <button class="btn bg-blu float-right text-white" id="submit-gdb-data">Confirm</button>
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


<script src="<?php echo base_url() ?>assets/custom-js/outputqc/remarks/remark-drugtest.js"></script> 