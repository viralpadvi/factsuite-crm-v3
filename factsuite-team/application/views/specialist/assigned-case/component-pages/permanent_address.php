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
          
          <a class="btn bg-blu btn-submit-cancel" id="back-btn" href="<?php echo $this->config->item('my_base_url').$backLink?>" ><span class="text-white"><i class="fas fa-angle-left"></i>&nbsp;Back</span></a>

          <h3 class="mt-3">Permanent Address Check Detail</h3>
          <?php //print_r($componentData); ?>
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
                    <div>
                      <h3 class="permt mt-4">Permanent Address Details</h3>
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
                            <p><?php echo isset($componentData['flat_no'])?$componentData['flat_no']:'value not found';?></p>
                            <p><?php echo isset($componentData['street'])?$componentData['street']:'value not found'?></p>
                            <p><?php echo isset($componentData['area'])?$componentData['area']:'value not found'?></p> 
                            <p><?php echo isset($componentData['country'])?$componentData['country']:'value not found'?></p>
                            <p><?php echo isset($componentData['city'])?$componentData['city']:'value not found'?></p> 
                            <p><?php echo isset($componentData['contact_person_name'])?$componentData['contact_person_name']:'value not found'?></p> 
                            <p><?php echo isset($componentData['contact_person_mobile_number'])?$componentData['contact_person_mobile_number']:'value not found';
                              // print_r($componentData);
                            ?></p> 
                         </div>
                          <div class="col-md-2 lft-p-det">
                            <p>Pin Code</p>
                            <p>Nearest Landmark</p>
                            <p>State</p>
                            <p>DURATION OF STAY</p>
                            <p>Reletionship</p>
                          </div>
                          <div class="col-md-1 pr-0">
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                         </div>
                         <div class="col-md-3 ryt-p pl-0">

                            <p><?php echo isset($componentData['pin_code'])?$componentData['pin_code']:'value not found';?></p>
                            <p><?php echo isset($componentData['nearest_landmark'])?$componentData['nearest_landmark']:'value not found'?></p> 
                            <p><?php echo isset($componentData['state'])?$componentData['state']:'value not found'?></p> 
                            <p><?php echo isset($componentData['duration_of_stay_start'])?$componentData['duration_of_stay_start']:'value not found'?> TO <?php echo isset($componentData['duration_of_stay_end'])?$componentData['duration_of_stay_end']:'value not found'?></p>
                            <p><?php echo isset($componentData['contact_person_relationship'])?$componentData['contact_person_relationship']:'value not found'?></p> 
                         </div>
                      </div>
                    </div>

                    <h3 class="permt mt-4">Permanent Address  verification information</h3>
                      <div class="row mt-3"> 
                        <div class="col-md-6">
                          <input name="" class="fld form-control permanent_address_id" value="<?php echo $componentData['permanent_address_id']; ?>" id="permanent_address_id" type="hidden">

                          <!-- Address -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Address</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              
                              <textarea class="fld form-control address" rows="4" id="address" spellcheck="false"><?php echo $componentData['remarks_address']; ?></textarea>
                              <div id="address-error">&nbsp;</div>
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
                              <input name="" class="fld form-control pincode" value="<?php echo $componentData['remarks_pincode']; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="pincode" type="text">
                              <div id="pincode-error">&nbsp;</div>
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
                              <!-- <input name="" class="fld form-control state" value="<?php //echo $componentData['remarks_state']; ?>" id="state" type="text"> -->
                              <!-- states -->
                               <select class="fld form-control state" id="state">
                                <?php
                                  foreach ($states as $keyState => $value) {
                                    if($componentData['remarks_state'] == $value['name']){
                                      echo '<option selected value="'.$value['name'].'">'.$value['name'].'</option>';
                                    }else{
                                      echo '<option value="'.$value['name'].'">'.$value['name'].'</option>';
                                    }
                                  }
                                ?>
                                <!--   -->
                              </select>
                              <div id="state-error">&nbsp;</div>
                            </div>
                          </div>
                          <!-- City  -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">City</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control city" value="<?php echo $componentData['remarks_city']; ?>" id="city" type="text">
                              <div id="city-error">&nbsp;</div>
                            </div>
                          </div>
                          <!-- Period of Stay -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Period of Stay</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control period_of_stay" value="<?php echo $componentData['period_of_stay']; ?>" id="period_of_stay" type="text">
                            <div id="period_of_stay-error">&nbsp;</div>
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
                              <!-- <input name="" class="fld form-control staying_with" value="<?php //echo $componentData['staying_with']; ?>" id="staying_with" type="text"> -->
                              <?php 
                                $Family = '';
                                $Friends = '';
                                $Alone = '';
                                if($componentData['staying_with'] == 'Family'){
                                  $Family = 'selected';
                                }else if($componentData['staying_with'] == 'Friends'){
                                  $Friends = 'selected';
                                }else if($componentData['staying_with'] == 'Alone'){
                                  $Alone = 'selected';
                                }
                              ?>
                              <select class="fld form-control staying_with" id="staying_with">
                                <option <?php echo $Family ?> value="Family">Family</option>
                                <option <?php echo $Friends ?> value="Friends">Friends</option>
                                <option <?php echo $Alone ?> value="Alone">Alone</option>
                              </select>
                              <div id="staying_with-error">&nbsp;</div>
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
                              <!-- <input name="" class="fld form-control property_type" value="<?php //echo $componentData['property_type']; ?>" id="property_type" type="text"> -->
                               <?php 
                                $Rented = '';
                                $Owned = '';
                                $others = '';
                                if($componentData['property_type'] == 'Rented'){
                                  $Rented = 'selected';
                                }else if($componentData['property_type'] == 'Owned'){
                                  $Owned = 'selected';
                                }else if($componentData['property_type'] == 'others'){
                                  $others = 'selected';
                                }
                              ?>
                              <select class="fld form-control property_type" id="property_type">
                                <option <?php echo $Rented ?> value="Rented">Rented</option>
                                <option <?php echo $Owned ?> value="Owned">Owned</option>
                                <option <?php echo $others ?> value="Others">Others</option>
                              </select>
                              <div id="property_type-error">&nbsp;</div>
                            </div>
                          </div>
                           <!-- Verifier Name  -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Verifier Name</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control verifier_name" value="<?php echo $componentData['verifier_name']; ?>" id="verifier_name" type="text">
                              <div id="verifier_name-error">&nbsp;</div>
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
                              <!-- <input name="" class="fld form-control relationship" value="<?php // echo $componentData['relationship']; ?>" id="relationship" type="text"> -->
                              <?php 
                                $Self = '';
                                $Parent = '';
                                $Spouse = '';
                                $Friend = '';
                                $Relative = '';
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
                                }
                              ?>
                              <select class="fld form-control relationship" id="relationship">
                                <option <?php echo $Self ?> value="Self">Self</option>
                                <option <?php echo $Parent ?> value="Parent">Parent</option>
                                <option <?php echo $Spouse ?> value="Spouse">Spouse</option>
                                <option <?php echo $Friend ?> value="Friend">Friend</option>
                                <option <?php echo $Relative ?> value="Relative">Relative</option>
                              </select>
                              <div id="relationship-error">&nbsp;</div>
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
                              <input name="" class="fld form-control verification_remarks" value="<?php echo $componentData['verification_remarks']; ?>" id="verification_remarks" type="text">
                              <div id="verification_remarks-error">&nbsp;</div>
                            </div>
                          </div>
                          
                          <!-- verification upload -->
                          <div class="row mt2">
                            <div class="add-vendor-bx2">
                              <h3 class="m-0">&nbsp;</h3>
                              <ul>
                                 <li class="vendor-wdt2">
                                    <p class="lft-p-det">Verification Proof Upload Section</p>
                                    <div class="form-group mb-0">
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
                                             echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"remarks-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                            }
                                           }
                                         $pan_card_doc = $componentData['approved_doc'];
                                         }} 
                                      ?>
                                 
                                    </div>
                                 </li> 
                              </ul>
                              <div class="row" id="selected-vendor-docs-li"></div>
                            </div>
                          </div>
                        </div>
                        <!-- Not Required Fields -->
                        <div class="col-md-6">
                           
                          <!-- Assigned To Vendor -->
                          <div class="row mt-2">
                            <div class="col-md-3">
                              <p class="det">Assigned To Vendor</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control assigned_to_vendor" value="<?php echo $componentData['assigned_to_vendor']; ?>" id="assigned_to_vendor" type="text">
                              <div id="assigned_to_vendor-error">&nbsp;</div>
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
                              <input name="" class="fld form-control initiated_date mdate" readonly value="<?php echo $componentData['initiated_date']; ?>" id="initiated_date" type="text">
                              <div id="initiated_date-error">&nbsp;</div>
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
                              <input name="" class="fld form-control closure_date mdate" readonly value="<?php echo $componentData['closure_date']; ?>" id="closure_date" type="text">
                              <div id="closure_date-error">&nbsp;</div>
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
                              <input name="" class="fld form-control progress_remarks" value="<?php echo $componentData['progress_remarks']; ?>" id="progress_remarks" type="text">
                              <div id="progress_remarks-error">&nbsp;</div>
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
                              <input name="" class="fld form-control infuff_remarks" value="<?php echo $componentData['infuff_remarks']; ?>" id="infuff_remarks" type="text">
                              <div id="infuff_remarks-error">&nbsp;</div>
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
                              <input name="" class="fld form-control closure_remarks" value="<?php echo $componentData['closure_remarks']; ?>" id="closure_remarks" type="text">
                              <div id="closure_remarks-error">&nbsp;</div>
                            </div>
                          </div> 
                        </div>
                    </div>
                    <hr> 

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
                      <!-- <button id="submit-perminant-address" class="update-bt">Update</button> -->
                       <button class="update-bt" data-toggle="modal" data-target="#conformtion-pr-address" id="#update-conformtion">Update</button> 
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
<div id="conformtion-pr-address" class="modal fade">
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
                <button class="btn bg-blu float-right text-white" id="submit-perminant-address">Confirm</button>
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



<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/remark-permanent-address.js"></script>
