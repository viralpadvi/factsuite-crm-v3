<?php 
  $candidateId =  isset($componentData['candidate_id'])?$componentData['candidate_id']:"2";
  $candidateName =  $componentData['first_name']." ".$componentData['last_name'];
  $candidateClinetName =  isset($componentData['client_name'])?$componentData['client_name']:"2";
  $candidatePhoneNumber =  isset($componentData['phone_number'])?$componentData['phone_number']:"1234567890";
  $candidatePackageName =  isset($componentData['package_name'])?$componentData['package_name']:"2";
  $candidateEmail =  isset($componentData['email_id'])?$componentData['email_id']:"2";
  $candidateDob =  isset($componentData['date_of_birth'])?$componentData['date_of_birth']:"34-13-2050";
 
  $courtRecordStatus = '';
// $componentData['analyst_status']
  $backLink = '';
  $userRole = '';
  $userID = '';

  $outputQCStatus = '';



  if($this->session->userdata('logged-in-specialist')){

    $backLink = 'factsuite-specialist/view-case-detail/'.$candidateId;
    $specialistUser = $this->session->userdata('logged-in-specialist');
    $userID =$specialistUser['team_id'];
    $userRole =$specialistUser['role'];
  
  }else if($this->session->userdata('logged-in-outputqc')){
    // echo $statusLink;
    $outputQCStatus = 'disabled';
    $status = isset($status)?$status:0;
    if($status == 1){

      $backLink = 'factsuite-outputqc/view-case-detail/'.$candidateId.'/1';
    }else{

      $backLink = 'factsuite-outputqc/assigned-view-case-detail/'.$candidateId;
    }

    // $backLink = 'factsuite-outputqc/assigned-view-case-detail/'.$candidateId;
    $outputqcUser = $this->session->userdata('logged-in-outputqc');
    $userID =$outputqcUser['team_id'];
    $userRole =$outputqcUser['role'];
  
  }else if($this->session->userdata('logged-in-inputqc')){
  
    $backLink = 'factsuite-inputqc/assigned-view-case-detail/'.$candidateId;
    $inputqcUser = $this->session->userdata('logged-in-inputqc');
    $userID =$inputqcUser['team_id'];
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
         <!-- <h3><?php //echo $statusLink; ?></h3> -->
          
          <a class="btn bg-blu btn-submit-cancel" id="back-btn" href="<?php echo $this->config->item('my_base_url').$backLink?>" ><span class="text-white"><i class="fas fa-angle-left"></i>&nbsp;Back</span></a>

          <h3 class="mt-3">Court record Check Detail</h3>
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
          <!-- <div class="table-responsive mt-3" id="">
          <table class="table table-striped">
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
            <tbody class="tbody-datatable" id="get-case-data"> 
            </tbody>
          </table>
        </div> -->
        <!--Content-->
          <section id="table-allcase">
            <div class="container">
                <div class="detail mb-5">
                  <div class="row hd">
                      
                      <!-- <div class="col-md-6"><a href="./allcase2.html"><button class="close-bt">Close</button></a></div> -->
                  </div>
                 <input type="hidden" name="court_records_id" value="<?php echo $componentData['court_records_id']; ?>" id="court_records_id">
                  <?php 
                    // print_r($componentData);
                    $address = json_decode($componentData['address'],true);
                    $city = json_decode($componentData['city'],true); 
                    $pincode = json_decode($componentData['pin_code'],true); 
                    $state = json_decode($componentData['state'],true); 
                    // $state = json_decode($componentData['state'],true); 
                    // echo "<br>address:".count($address);  
                    $remark_address= json_decode($componentData['remark_address'],true);//$this->input->post('address'),
                    $remark_pin_code= json_decode($componentData['remark_pin_code'],true);//$this->input->post('pincode'),
                    $remark_city= json_decode($componentData['remark_city'],true);//$this->input->post('city'),
                    $remark_state= json_decode($componentData['remark_state'],true);//$this->input->post('state'),
                    $insuff_remarks= json_decode($componentData['insuff_remarks'],true);//$this->input->post('insuff_remarks'),
                    $in_progress_remarks= json_decode($componentData['in_progress_remarks'],true);//$this->input->post('progress_remarks'),
                    $verification_remarks= json_decode($componentData['verification_remarks'],true);//$this->input->post('verification_remarks'),
                    $Insuff_closure_remarks= json_decode($componentData['Insuff_closure_remarks'],true);
                    $approved_doc= json_decode($componentData['approved_doc'],true);
                    //$this->input->post('closure_remarks'),
                    $j=1;
                    for ($i=0; $i < count($address) ; $i++) { ?>
                   
                    <div>
                      <h3 class="permt mt-4">Address Details <?php echo $j?></h3>
                      <div class="row mt-3"> 
                          <div class="col-md-2 lft-p-det">
                            <p>Address</p>
                            <p>City/Town</p>
                            <p>Pin Code</p>
                            <p>State</p>
                          </div>
                          <div class="col-md-1 pr-0">
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                         </div>
                         <div class="col-md-4 ryt-p pl-0">
                            <p><?php echo $address[$i]['address'];?></p>
                            <p><?php echo isset($city[$i]['city'])?$city[$i]['city']:"No data found"?></p>
                            <p><?php echo isset($pincode[$i]['pincode'])?$pincode[$i]['pincode']:"No data found"?></p>
                            <p><?php echo isset($state[$i]['state'])?$state[$i]['state']:"No data found"?></p>
                         </div>
                      </div>
                    </div>
                    <h3 class="permt mt-4">Address Verification Information <?php echo $j?></h3>
                      <div class="row mt-3"> 
                        <div class="col-md-6">
                          <!-- Address -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Address</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <textarea class="fld form-control address" onkeyup="valid_address(<?php echo $j; ?>)" onblur="valid_address(<?php echo $j; ?>)" rows="4" id="address<?php echo $j; ?>" spellcheck="false"><?php echo isset($remark_address[$i]['address'])?$remark_address[$i]['address']:''; ?></textarea>
                              <div id="address-error<?php echo $j; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <!-- city -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">City/Town</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control city" value="<?php echo isset($remark_city[$i]['city'])?$remark_city[$i]['city']:''; ?>" onkeyup="valid_city(<?php echo $j; ?>)" onblur="valid_city(<?php echo $j; ?>)" id="city<?php echo $j; ?>" type="text">
                              <div id="city-error<?php echo $j; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <!-- pincode -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Pin Code</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control pincode" value="<?php echo isset($remark_pin_code[$i]['pincode'])?$remark_pin_code[$i]['pincode']:''; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeyup="valid_pincode(<?php echo $j; ?>)" onblur="valid_pincode(<?php echo $j; ?>)" id="pincode<?php echo $j; ?>" type="text">
                              <div id="p54 number is new feature incode-error<?php echo $j; ?>">&nbsp;</div>
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
                              <input name="" class="fld form-control state" value="<?php echo isset($remark_state[$i]['state'])?$remark_state[$i]['state']:''; ?>" onkeyup="valid_state(<?php echo $j; ?>)" onblur="valid_state(<?php echo $j; ?>)" id="state<?php echo $j; ?>" type="text">
                               <div id="state-error<?php echo $j; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <!-- file uoload -->
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
                          <!-- Insuff Remarks -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Insuff Remarks</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control insuff_remarks" value="<?php echo isset($insuff_remarks[$i]['insuff_remarks'])?$insuff_remarks[$i]['insuff_remarks']:''; ?>"  onkeyup="valid_insuff_remarks(<?php echo $j; ?>)" onblur="valid_insuff_remarks(<?php echo $j; ?>)" id="insuff_remarks<?php echo $j; ?>" type="text">
                              <div id="insuff_remarks-error<?php echo $j; ?>">&nbsp;</div>
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
                              <input name="" class="fld form-control progress_remarks" value="<?php echo isset($in_progress_remarks[$i]['progress_remarks'])?$in_progress_remarks[$i]['progress_remarks']:''; ?>" onkeyup="valid_progress_remarks(<?php echo $j; ?>)" onblur="valid_progress_remarks(<?php echo $j; ?>)" id="progress_remarks<?php echo $j; ?>" type="text">
                              <div id="progress_remarks-error<?php echo $j; ?>">&nbsp;</div>
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
                              <input name="" class="fld form-control verification_remarks" value="<?php echo isset($verification_remarks[$i]['verification_remarks'])?$verification_remarks[$i]['verification_remarks']:''; ?>" onkeyup="valid_verification_remarks(<?php echo $j; ?>)" onblur="valid_verification_remarks(<?php echo $j; ?>)" id="verification_remarks<?php echo $j; ?>" type="text">
                              <div id="verification_remarks-error<?php echo $j; ?>">&nbsp;</div>
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
                              <input name="" class="fld form-control closure_remarks" value="<?php echo isset($Insuff_closure_remarks[$i]['closure_remarks'])?$Insuff_closure_remarks[$i]['closure_remarks']:''; ?>" onkeyup="valid_closure_remarks(<?php echo $j; ?>)" onblur="valid_closure_remarks(<?php echo $j; ?>)" id="closure_remarks<?php echo $j; ?>" type="text">
                              <div id="closure_remarks-error<?php echo $j; ?>">&nbsp;</div>
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
                      <input type="hidden" value="<?php echo $componentData['candidate_id']?>" id="candidate_id_hidden"name="">
                      <a href="<?php echo $this->config->item('my_base_url').$backLink?>"><button class="close-bt">Close</button></a>
                      <!-- <button id="add-court-record" class="update-bt">Update</button> -->
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
                <button class="btn bg-blu float-right text-white" id="add-court-record">Confirm</button>
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

<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/remark-court-record.js"></script> 