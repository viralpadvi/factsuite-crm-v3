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


          <h3 class="mt-3">Sex Offender Form Detail</h3>
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
                   
                    // $candidate_name = json_decode($componentData['candidate_name'],true); 
                    // $father_name = json_decode($componentData['father_name'],true); 
                    // $dob = json_decode($componentData['dob'],true); 
                    
                    ?>
                   
                    <div>
	                    <h3 class="permt mt-4">Sex Offender(Candidate filled)</h3>
	                    <div class="row mt-3"> 
                          	<div class="col-md-6">
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>First name</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($componentData['first_name'])?$componentData['first_name']:"No data found"?></p>
	                       			</div>
	                       		</div>
	                       		<div class="row mt-2">
	                       			<div class="col-md-3 lft-p-det">
	                       				<p>Last Name</p>
	                       			</div>
	                       			<div class="col-md-2 ryt-p">
	                       				<p>:</p>
	                       			</div>
	                       			<div class="col-md-7 ryt-p">
	                       				<p><?php echo isset($componentData['last_name'])?$componentData['last_name']:"No data found"?></p>
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
	                       				<p><?php echo isset($componentData['dob'])?$componentData['dob']:"No data found"?></p>
	                       			</div>
	                       		</div>
                            <div class="row mt-2">
                              <div class="col-md-3 lft-p-det">
                                <p>Gender</p>
                              </div>
                              <div class="col-md-2 ryt-p">
                                <p>:</p>
                              </div>
                              <div class="col-md-7 ryt-p">
                                <p><?php echo isset($componentData['gender'])?$componentData['gender']:"No data found"?></p>
                              </div>
                            </div>
	                       	</div> 
                      	</div>
                    </div>
                    <h3 class="permt mt-4">Sex Offender Verification Details </h3>
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
                                rows="3" ><?php echo isset($componentData['remark_address'])?$componentData['remark_address']:""?></textarea>
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
                              <input name="city" value="<?php echo isset($componentData['remark_city'])?$componentData['remark_city']:""?>" class="fld form-control city" id="city" type="text">
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
                              <input name="state" class="fld form-control state" id="state" value="<?php echo isset($componentData['remark_state'])?$componentData['remark_state']:""?>" type="text">
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
                              <input name="pincode" class="fld form-control pincode" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeyup="valid_pincode(0)" id="pincode" value="<?php echo isset($componentData['remark_pin_code'])?$componentData['remark_pin_code']:""?>" type="text">
                              <div id="pincode-error"></div>
                            </div>
                          </div>

                           <div class="row mt2">
                            <div class="add-vendor-bx2">
                              <h3 class="m-0">&nbsp;</h3>
                              <ul>
                                 <li class="vendor-wdt2">
                                    <p class="lft-p-det">Verification Proof Upload Section</p>
                                   
                                    <div id="client-upoad-docs-error-msg-div"><?php
                                     $pan_card_doc = '';
                                       if (isset($componentData['approved_doc'])) {
                                       if (!in_array('no-file', explode(',', $componentData['approved_doc']))) {
                                         foreach (explode(',', $componentData['approved_doc']) as $key => $value) {
                                            if ($value !='') {
                                              $url = base_url()."../uploads/remarks-docs/".$value;
                                              echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a> <a href='{$url}' download >  <i class='fa fa-download'></i></a> </span></div>";
                                          }
                                         }
                                       $pan_card_doc = $componentData['approved_doc'];
                                       }} 
                                       ?></div>
                                 </li> 
                              </ul>
                              <div class="row" id="selected-vendor-docs-li"></div>
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
                              <textarea name="insuff_remarks" class="fld form-control insuff_remarks" id="insuff_remarks"><?php echo isset($componentData['insuff_remarks'])?$componentData['insuff_remarks']:""?></textarea>
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
                              <textarea name="in_progress_remark" class="fld form-control in_progress_remark" id="in_progress_remark"><?php echo isset($componentData['in_progress_remarks'])?$componentData['in_progress_remarks']:""?></textarea>
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
                              <textarea name="verification_remarks" class="fld form-control verification_remark" id="verification_remarks" ><?php echo isset($componentData['verification_remarks'])?$componentData['verification_remarks']:""?></textarea>
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
                              <input name="" class="fld form-control verified_date" value="<?php echo isset($componentData['verified_date'])?$componentData['verified_date']:''; ?>" id="verified_date" type="text">
                              <div id="verified_date-error">&nbsp;</div>
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
                              <textarea name="insuff_closer_remark" class="fld form-control insuff_closer_remark" id="insuff_closer_remark"><?php echo isset($componentData['insuff_closure_remarks'])?$componentData['insuff_closure_remarks']:""?></textarea>

                            </div>
                          </div>
                        </div>
                    </div>
                    <hr>
                  <?php 
                     
                  ?>
                     <div class="row mt-2">
                    <div class="col-md-6">
                      <?php
                        $analystStatus = '';
                         $disabled = '';
                        $an_status = isset($componentData['analyst_status'])?$componentData['analyst_status']:'0';
                        if($an_status == 0){
                          $analystStatus = '<span class="text-warning">Pending</span>';
                        }else if($an_status == 3){
                          $analystStatus = '<span class="text-danger">Insufficiency</span>';
                        }else if($an_status == 4){
                          $analystStatus = '<span class="text-success">Verified Clear</span>';
                                  // $disabled = 'disabled';
                        }else if($an_status == 5){
                          $analystStatus = '<span class="text-danger">Stop Check</span>';
                        }else if($an_status == 6){
                          $analystStatus = '<span class="text-danger">Unable to verify</span>';
                        }else if($an_status == 7){
                          $analystStatus = '<span class="text-danger">Verified discrepancy</span>';
                        }else if($an_status == 8){
                          $analystStatus = '<span class="text-danger">Client clarification</span>';
                        }else if($an_status == 9){
                          $analystStatus = '<span class="text-danger">Closed Insufficiency</span>';
                        }else if($an_status == 10){
                          $analystStatus = '<span class="text-danger">Qc Error</span>';
                           $disabled = 'disabled';
                        }else if($an_status == 11){
                          $analystStatus = '<span class="text-warning">Pending</span>';
                        }
                      ?>
                      <label>Analyst Status: </label>
                      <span class=""><?php echo  $analystStatus; ?></span>
                      <input type="hidden" 
                                name="analyst_status"
                                class="analyst_status" id="action_status"
                                value="<?php echo $an_status; ?>">
                    </div>
                    <!-- </div>
                    <div class="row mt-2 <?php echo $selectOpStatusEnable ?>"> -->
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

<script src="<?php echo base_url() ?>assets/custom-js/outputqc/remarks/remark-sex-offender.js"></script>