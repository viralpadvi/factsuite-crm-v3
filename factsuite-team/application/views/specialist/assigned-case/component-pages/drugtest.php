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
          
          <a class="btn bg-blu btn-submit-cancel" id="back-btn" href="<?php echo $this->config->item('my_base_url').$backLink;?>" ><span class="text-white"><i class="fas fa-angle-left"></i>&nbsp;Back</span></a>

          <h3 class="mt-3">Drug Test Detail</h3>
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
                    $father_name = json_decode($componentData['father_name'],true); 
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
                    // print_r($remark_address);
                    $j=1;
                    for ($i=0; $i < count($drugtestType) ; $i++) { 
                      // echo "<br>i : ".$i;
                    ?>
                      
                    <div>
	                    <h3 class="permt mt-4">Drugtest <?php echo $drugtestType[$i] ?> Details <?php echo $j?></h3>
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
	                       				<p><?php echo isset($dob[$i]['dob'])?$dob[$i]['dob']:"No data found"?></p>
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
                    <h3 class="permt mt-4">Drugtest <?php echo $drugtestType[$i] ?> Verification Information <?php echo $j?></h3>
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
                              <input name="city" value="<?php echo isset($remark_city[$i]['remarks_city'][$i])?$remark_city[$i]['remarks_city'][$i]:""?>" class="fld form-control city" id="city" type="text">
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
                                 if (isset($approved_doc[$i])) {
                                 if (!in_array('no-file',  $approved_doc[$i])) {
                                   foreach ($approved_doc[$i] as $key1 => $value) {
                                      if ($value !='') {
                                     echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"remarks-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                    }
                                   }
                                 $pan_card_doc = $approved_doc[$i];
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
                              <p class="det">Insuff Remarks</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="insuff_remarks" class="fld form-control insuff_remarks" id="insuff_remarks" value="<?php echo isset($insuff_remarks[$i]['insuff_remarks'])?$insuff_remarks[$i]['insuff_remarks']:""?>" type="text">
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
                              <input name="in_progress_remark" class="fld form-control in_progress_remark" id="in_progress_remark" value="<?php echo isset($in_progress_remarks[$i]['in_progress_remark'])?$in_progress_remarks[$i]['in_progress_remark']:""?>" type="text">
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
                              <input name="verification_remarks" class="fld form-control verification_remarks" id="verification_remarks" value="<?php echo isset($verification_remarks[$i]['verification_remarks'])?$verification_remarks[$i]['verification_remarks']:""?>" type="text">
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
                              <input name="insuff_closer_remark" class="fld form-control insuff_closer_remark" id="insuff_closer_remark"value="<?php echo isset($insuff_closure_remarks[$i]['insuff_closer_remark'])?$insuff_closure_remarks[$i]['insuff_closer_remark']:""?>" type="text">
                            </div>
                          </div>
                        </div>
                    </div>
                    <hr>
                  <?php 
                    $j++;
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
        <h3 class="snd-mail-pop">Are you confirm?</h3>
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



<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/remark-drugtest.js"></script> 