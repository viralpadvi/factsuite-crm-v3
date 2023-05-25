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

          <h3 class="mt-3">Right To Work Detail</h3>
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
                  <input type="hidden" name="right_to_work_id" value="<?php echo $componentData['right_to_work_id']; ?>" id="right_to_work_id">
                  <?php 
                    // print_r($componentData);
                    $document_number = json_decode($componentData['document_number'],true);
                    $mobile_number = json_decode($componentData['mobile_number'],true); 
                    $first_name = json_decode($componentData['first_name'],true); 
                    $last_name = json_decode($componentData['last_name'],true); 
                    $dob = json_decode($componentData['dob'],true); 
                    $gender = json_decode($componentData['gender'],true); 
                    // $state = json_decode($componentData['state'],true); 
                    // echo "<br>address:".count($address);  
                    $remark_address= json_decode($componentData['remark_address'],true);//$this->input->post('address'),
                    $remark_pin_code= json_decode($componentData['remark_pin_code'],true);//$this->input->post('pincode'),
                    $remark_city= json_decode($componentData['remark_city'],true);//$this->input->post('city'),
                    $remark_state= json_decode($componentData['remark_state'],true);//$this->input->post('state'),
                    $insuff_remarks= json_decode($componentData['insuff_remarks'],true);//$this->input->post('insuff_remarks'),
                    $in_progress_remarks= json_decode($componentData['in_progress_remarks'],true);//$this->input->post('progress_remarks'),
                    $verification_remarks= json_decode($componentData['verification_remarks'],true);//$this->input->post('verification_remarks'),
                    $Insuff_closure_remarks= json_decode($componentData['insuff_closure_remarks'],true);
                    $approved_doc=  json_decode($componentData['approved_doc'],true);
                    $output_status=  explode(',',$componentData['output_status']);
                    $analyst_status=  explode(',',$componentData['analyst_status']); 
                    $ouputqc_comment = '';//json_decode($componentData['ouputqc_comment'],true);
                    //$this->input->post('closure_remarks'),
  
                    $verified_date = json_decode($componentData['verified_date'],true);
                     
                    $j=1;
                    $count = count($document_number);?>
                    <input type="hidden" name="addressCount" value="<?php echo $count; ?>" id="addressCount">
                    <?php for ($i=0; $i < $count ; $i++) {
                   
                     ?>
                    <div>
                      <h3 class="permt mt-4">Address Details <?php echo $j?></h3>
                     <div class="row mt-3"> 
                          <div class="col-md-2 lft-p-det">
                            <p>Document Number</p>
                            <p>Mobile Number</p>
                            <p>First Name</p>
                            <p>Last Name</p>
                            <p>Date Of Birth</p>
                            <p>Gender</p>
                          </div>
                          <div class="col-md-1 pr-0">
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                         </div>
                         <div class="col-md-4 ryt-p pl-0">
                            <p><?php echo isset($document_number[$i]['document_number'])?$document_number[$i]['document_number']:'No data found';?></p>
                            <p><?php echo isset($mobile_number[$i]['mobile_number'])?$mobile_number[$i]['mobile_number']:"No data found"?></p>
                            <p><?php echo isset($first_name[$i]['first_name'])?$first_name[$i]['first_name']:"No data found"?></p>
                            <p><?php echo isset($last_name[$i]['last_name'])?$last_name[$i]['last_name']:"No data found"?></p>
                            <p><?php echo isset($dob[$i]['dob'])?$dob[$i]['dob']:"No data found"?></p>
                            <p><?php echo isset($gender[$i]['gender'])?$gender[$i]['gender']:"No data found"?></p>
                         </div>
                      </div>
                    </div>
                    <h3 class="permt mt-4">Right To Work Verification Details <?php echo $j?></h3>
                      <div class="row mt-3"> 
                        <div class="col-md-6">
                          <div class="row mt-2 d-none">
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
                          <!-- State -->
                          <div class="row mt-2 d-none">
                            <div class="col-md-3">
                              <p class="det">State</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                             <!--  <input name="" class="fld form-control state" value="<?php echo isset($remark_state[$i]['state'])?$remark_state[$i]['state']:''; ?>" onkeyup="valid_state(<?php echo $j; ?>)" onblur="valid_state(<?php echo $j; ?>)" id="state<?php echo $j; ?>" type="text"> -->
                              <select  class="fld form-control country select2 state" id="state<?php echo $j; ?>" onchange="getCity(this.id,<?php echo $j; ?>)">
                                <option>Select State</option>
                                  <?php 
                                    $get_state = isset($remark_state[$i]['state'])?$remark_state[$i]['state']:'';
                                    foreach ($states as $key1 => $val) {
                                       if ($get_state == $val['name']) {
                                        $city_id =$val['id'];
                                          echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                                       }else{
                                          echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                                       }
                                    }
                                  ?>
                              </select>
                              <div id="state-error<?php echo $j; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <!-- city -->
                          <div class="row mt-2 d-none">
                            <div class="col-md-3">
                              <p class="det">City/Town</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                             <!--  <input name="" class="fld form-control city" value="<?php echo isset($remark_city[$i]['city'])?$remark_city[$i]['city']:''; ?>" onkeyup="valid_city(<?php echo $j; ?>)" onblur="valid_city(<?php echo $j; ?>)" id="city<?php echo $j; ?>" type="text"> -->
                              <select name=""  class="form-control fld select2 city" id="city<?php echo $j; ?>">
                                <?php  
                                  $cities = $this->clientModel->get_all_cities($city_id);
                                  $get_city = isset($remark_city[$i]['city'])?$remark_city[$i]['city']:'';
                                  foreach ($cities as $key2 => $cityVal) {
                                    if ($get_city == $cityVal['name']) {
                                      $city_id =$cityVal['id'];
                                      echo "<option data-id='{$cityVal['id']}' selected value='{$cityVal['name']}' >{$cityVal['name']}</option>";
                                    }else{
                                      echo "<option data-id='{$cityVal['id']}' value='{$cityVal['name']}' >{$cityVal['name']}</option>";
                                    } 
                                  }
                                ?>
                              </select>
                              <div id="city-error<?php echo $j; ?>">&nbsp;</div>
                            </div>
                          </div>
                         <!--  <div class="row mt-2">
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
                          </div> -->
                          <div class="row mt-2 d-none">
                            <div class="col-md-3">
                              <p class="det">Pin Code</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control pincode" value="<?php echo isset($remark_pin_code[$i]['pincode'])?$remark_pin_code[$i]['pincode']:''; ?>" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" onkeyup="valid_pincode(<?php echo $j; ?>)" onblur="valid_pincode(<?php echo $j; ?>)" id="pincode<?php echo $j; ?>" type="text">
                              <div id="pincode-error<?php echo $j; ?>">&nbsp;</div>
                            </div>
                          </div>

                          <div class="row mt-2 d-none">
                            <div class="col-md-3">
                              <p class="det">Period of Stay</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <input name="" class="fld form-control period-of-stay" value="<?php echo isset($remark_period_of_stay[$i]['remark_period_of_stay'])?$remark_period_of_stay[$i]['remark_period_of_stay']:''; ?>" id="period-of-stay<?php echo $j; ?>" type="text">
                              <div id="period-of-stay-error<?php echo $j; ?>">&nbsp;</div>
                            </div>
                          </div>

                          <div class="row mt-2 d-none">
                            <div class="col-md-3">
                              <p class="det">Gender</p>
                            </div>
                            <div class="col-md-2 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-7">
                              <select class="fld form-control gender" id="gender<?php echo $j; ?>">
                                <option value="">Select Gender</option>
                                <?php
                                $selected_gender = isset($remark_gender[$i]['remark_gender']) ? $remark_gender[$i]['remark_gender'] : '';
                                foreach (json_decode($gender_list,true) as $key_gender => $value_gender) { 
                                  if ($selected_gender != '' && strtolower($selected_gender) == strtolower($value_gender['id'])) { ?>
                                    <option selected value="<?php echo $value_gender['id']; ?>"><?php echo $value_gender['gender']; ?></option>
                                  <?php } else { ?>
                                    <option value="<?php echo $value_gender['id']; ?>"><?php echo $value_gender['gender']; ?></option>
                                <?php } } ?>
                              </select>
                              <div id="period-of-stay-error<?php echo $j; ?>">&nbsp;</div>
                            </div>
                          </div>
                          <!-- <div class="row mt-2">
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
                          </div> -->
                         <div class="row mt2">
                            <!-- Analyst Status: -->
                            
                            
                            <div class="add-vendor-bx2 d-none">
                              <h3 class="m-0">&nbsp;</h3>
                                <ul>
                                 <li class="vendor-wdt2">
                                    <p class="lft-p-det">Verification Proof Upload Section</p>
                                    <div class="form-group mb-0 ">
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
                                                  echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a> <a href='{$url}' download >  <i class='fa fa-download'></i></a></span></div>";
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
                           
                           <div class="row mt2">
                            <div class="add-vendor-bx2">
                              <h3 class="m-0">&nbsp;</h3>
                              <ul>
                                <li class="vendor-wdt2">
                                    <p class="lft-p-det">Verification Proof Upload Section</p>
                                    <div class="form-group mb-0 d-none">
                                      <input type="file" class="client-documents" id="client-documents" name="criminal-documents[]" multiple="multiple">
                                      <label class="btn upload-btn" for="client-documents">Upload</label>
                                    </div>
                                      <div id="criminal-upoad-docs-error-msg-div">
                                        <?php
                                          $pan_card_doc = '';
                                            if (isset($approved_doc[$i])) {
                                              if (!in_array('no-file',  $approved_doc[$i])) {
                                               foreach ($approved_doc[$i] as $key1 => $value) {
                                                  if ($value !='') {
                                                    $url = base_url()."../uploads/remarks-docs/".$value;
                                                    echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a> <a href='{$url}' download >  <i class='fa fa-download'></i></a></span></div>";
                                                  }
                                               }
                                                $pan_card_doc = $approved_doc[$i];
                                              }
                                            } 
                                        ?>
                                      </div>
                                </li> 
                              </ul>
                              <div class="row" id="selected-criminal-docs-li"></div>
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
                              <input name="" class="fld form-control insuff_remarks" value="<?php echo isset($insuff_remarks[$i]['insuff_remarks'])?$insuff_remarks[$i]['insuff_remarks']:''; ?>"  onkeyup="valid_insuff_remarks(<?php echo $j; ?>)" onblur="valid_insuff_remarks(<?php echo $j; ?>)" id="insuff_remarks<?php echo $j; ?>" type="text">
                              <div id="insuff_remarks-error<?php echo $j; ?>">&nbsp;</div>
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
                              <textarea class="fld form-control progress_remarks" onkeyup="valid_progress_remarks(<?php echo $j; ?>)" onblur="valid_progress_remarks(<?php echo $j; ?>)" id="progress_remarks<?php echo $j; ?>"><?php echo isset($in_progress_remarks[$i]['progress_remarks'])?$in_progress_remarks[$i]['progress_remarks']:''; ?></textarea>
                              <div id="progress_remarks-error<?php echo $j; ?>">&nbsp;</div>
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
                               <textarea class="fld form-control verification_remarks" onkeyup="valid_verification_remarks(<?php echo $j; ?>)" onblur="valid_verification_remarks(<?php echo $j; ?>)" id="verification_remarks<?php echo $j; ?>"><?php echo isset($verification_remarks[$i]['verification_remarks'])?$verification_remarks[$i]['verification_remarks']:''; ?></textarea>
                              <div id="verification_remarks-error<?php echo $j; ?>">&nbsp;</div>
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
                             <textarea class="fld form-control closure_remarks" onkeyup="valid_closure_remarks(<?php echo $j; ?>)" onblur="valid_closure_remarks(<?php echo $j; ?>)" id="closure_remarks<?php echo $j; ?>" ><?php echo isset($Insuff_closure_remarks[$i]['closure_remarks'])?$Insuff_closure_remarks[$i]['closure_remarks']:''; ?></textarea>
                              <div id="closure_remarks-error<?php echo $j; ?>">&nbsp;</div>
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
                                  if($output_status[$i] == 1){
                                    $approveOpStatus = 'selected';
                                  }else if($output_status[$i] == 2){
                                    $rejectOpStatus = 'selected';
                                  }else {
                                    $defaultOpStatus = 'selected'; 
                                  }
                              ?>
                              <select id="op_action_status" <?php echo $disabled; ?> name="carlist" class="sel-allcase output_status">
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


                   
                    
                 
                    
                </div>
                <!-- <hr> -->
                  <div class="row mt-2">
                    <div class="col-md-6">
                      
                    </div>
                    <div class="col-md-6 text-right">
                      <input type="hidden" value="<?php echo $componentData['candidate_id']?>" id="candidate_id_hidden"name="">
                      <a href="<?php echo $this->config->item('my_base_url').$backLink?>"><button class="close-bt">Close</button></a>
                      <!-- <button id="add-right-to-work" class="update-bt">Update</button> -->
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
                <button class="btn bg-blu text-white" data-dismiss="modal">Close</button>
                <button class="btn bg-blu float-right text-white" id="add-right-to-work">Confirm</button>
             <div class="clr"></div>
          </div>
       </div>
    </div>
</div>

<!-- Popup Content -->


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
<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/commonImageView.js"></script>

<script>
  var count = <?php echo $count; ?>
</script>
<script src="<?php echo base_url() ?>assets/custom-js/outputqc/remarks/remark-right-to-work.js"></script> 
<script src="<?php echo base_url() ?>assets/custom-js/outputqc/common/city.js"></script> 