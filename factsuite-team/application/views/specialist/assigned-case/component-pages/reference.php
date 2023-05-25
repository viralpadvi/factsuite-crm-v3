<?php 
  $candidateId =  isset($componentData['candidate_id'])?$componentData['candidate_id']:"2";
  $candidateName =  $componentData['first_name']." ".$componentData['last_name'];
  $candidateClinetName =  isset($componentData['client_name'])?$componentData['client_name']:"2";
  $candidatePhoneNumber =  isset($componentData['phone_number'])?$componentData['phone_number']:"1234567890";
  $candidatePackageName =  isset($componentData['package_name'])?$componentData['package_name']:"2";
  $candidateEmail =  isset($componentData['email_id'])?$componentData['email_id']:"2";
  $candidateDob =  isset($componentData['date_of_birth'])?$componentData['date_of_birth']:"34-13-2050";
  $analyst_status =  isset($componentData['analyst_status'])?$componentData['analyst_status']:"0";

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

          <h3 class="mt-3">Reference Detail</h3>
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
          <section id="componentData-allcase">
            <div class="container">
                <div class="detail mb-5">
                  <div class="row hd">
                  </div>
      <?php 
           
	      $j =1;
	        // print_r($componentData);
		    if (isset($componentData['name'])) {
            $company_name = explode(',', $componentData['company_name']);
            $designation = explode(',', $componentData['designation']);
            $contact_number = explode(',', $componentData['contact_number']);
            $email_id = explode(',', $componentData['email_id']);
            $years_of_association = explode(',', $componentData['years_of_association']);
            $contact_start_time = explode(',', $componentData['contact_start_time']);
            $contact_end_time = explode(',', $componentData['contact_end_time']); 
            $name = explode(',',$componentData['name']);
            
            $roles_responsibilities =json_decode($componentData['roles_responsibilities'],true);
             // explode(',',$componentData['roles_responsibilities']);
            $professional_strengths = json_decode($componentData['professional_strengths'],true);
            $attendance_punctuality = json_decode($componentData['attendance_punctuality'],true);
            $mode_exit = json_decode($componentData['mode_exit'],true);
            $communication_skills = json_decode($componentData['communication_skills'],true);
            // print_r($communication_skills);
            // explode(',',$componentData['communication_skills']);
            $work_attitude = json_decode($componentData['work_attitude'],true);
            $honesty_reliability = json_decode($componentData['honesty_reliability'],true);
            $target_orientation = json_decode($componentData['target_orientation'],true);
            $people_management = json_decode($componentData['people_management'],true);
            $projects_handled = json_decode($componentData['projects_handled'],true);
            $professional_weakness = json_decode($componentData['professional_weakness'],true);
            $accomplishments = json_decode($componentData['accomplishments'],true);
            $job_performance = json_decode($componentData['job_performance'],true);
            $integrity = json_decode($componentData['integrity'],true);
            $leadership_quality = json_decode($componentData['leadership_quality'],true);
            $pressure_handling_nature = json_decode($componentData['pressure_handling_nature'],true);
            $team_player = json_decode($componentData['team_player'],true);
            $additional_comments = json_decode($componentData['additional_comments'],true);
            $in_progress_remarks = json_decode($componentData['in_progress_remarks'],true);
            $insuff_remarks = json_decode($componentData['insuff_remarks'],true);
            $verification_remarks = json_decode($componentData['verification_remarks'],true);
            $insuff_closure_remarks = json_decode($componentData['insuff_closure_remarks'],true);
            $approved_doc = json_decode($componentData['approved_doc'],true);
            
                    // echo "<br>address:".count($address);  
                    $i=0;?>
                    <input type="hidden" value="<?php echo count($company_name) ?>" id="countOfCompanyName" name="countOfCompanyName">
                    <?php foreach ($company_name as $key => $value) { 
                    ?>
                   
                    <div>
                      <h3 class="permt mt-4">Reference Details <?php echo $i?></h3>
                      <div class="row mt-3"> 
                          <div class="col-md-2 lft-p-det">
                            <p>Name</p>
                            <p>Company Name</p>
                            <p>Designation</p>
                            <p>Contact Number</p>
                          
                          </div>
                          <div class="col-md-1 pr-0">
                              <p>:</p>
                              <p>:</p>
                              <p>:</p>
                              <p>:</p> 
                         </div>
                         <div class="col-md-3 ryt-p pl-0">
                            <p><?php echo isset($name[$key])?$name[$key]:'value not found';?></p>
                            <p><?php echo isset($value)?$value:'value not found';?></p>
                            <p><?php echo isset($designation[$key])?$designation[$key]:'value not found'?></p>
                            <p><?php echo isset($contact_number[$key])?$contact_number[$key]:'value not found'?></p> 
                           
                         </div>
                          <div class="col-md-2 lft-p-det">
                          	  <p>Email ID</p> 
                            <p>Years of Association</p>
                            <p>Preferred contact start</p>  
                          </div>
                          <div class="col-md-1 pr-0">
                              <p>:</p>
                              <p>:</p>
                              <p>:</p> 
                         </div>
                         <div class="col-md-3 ryt-p pl-0">
                         	 <p><?php echo isset($email_id[$key])?$email_id[$key]:'value not found'?></p>  
                            <p><?php echo isset($years_of_association[$key])?$years_of_association[$key]:'value not found';?></p>
                            <p><?php echo isset($contact_start_time[$key])?$contact_start_time[$key]:'value not found'?> TO <?php echo isset($contact_end_time[$key])?$contact_end_time[$key]:'value not found'?></p>  
                         </div>
                      </div>
                    </div>
                    <h3 class="permt mt-4">Reference verification information <?php echo $i?></h3>
                      <div class="row mt-3"> 
                        <div class="col-md-6">
                          <div class="row mt-2">
                            <div class="col-md-3">
                            <p>Role & Responsibilities</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8"> 
                              <textarea 
                                class="fld form-control role_responsibility"
                                id="role_responsibility<?php echo $i; ?>"
                                rows="3" ><?php echo isset($roles_responsibilities[$key]['role_responsibility'])?$roles_responsibilities[$key]['role_responsibility']:''?></textarea>
                  			      <div id="role_responsibility-error<?php echo $i;?>"></div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                            <p>Professional Strengths</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8"> 
                              <textarea 
                                class="fld form-control professional_strengths"
                                id="professional_strengths<?php echo $i; ?>"  
                                rows="3" ><?php echo isset($professional_strengths[$key]['professional_strengths'])?$professional_strengths[$key]['professional_strengths']:''?></textarea>
                  			      <div id="role-responsibility-error<?php echo $i;?>"></div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Attendance & Punctuality</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8"> 
                              <textarea 
                                class="fld form-control attendance"
                                id="attendance<?php echo $i; ?>"  
                                rows="3" ><?php echo isset($attendance_punctuality[$key]['attendance'])?$attendance_punctuality[$key]['attendance']:''?></textarea>
                  			      <div id="attendance-error<?php echo $i;?>"></div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Mode of Exit</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8"> 
                              <textarea 
                                class="fld form-control mode_of_exit"
                                id="mode_of_exit<?php echo $i; ?>"  
                                rows="3" ><?php echo isset($mode_exit[$key]['mode_of_exit'])?$mode_exit[$key]['mode_of_exit']:''?></textarea> 
                  			     <div id="mode_of_exit-error<?php echo $i;?>"></div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Communication Skills</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <?php
                                $zerocommunicationSelected='';
                                $onecommunicationSelected='';
                                $twocommunicationSelected='';
                                $threecommunicationSelected='';
                                $fourcommunicationSelected='';
                                $fivecommunicationSelected='';
                                $communication_skill = isset($communication_skills[$key]['communication'])?$communication_skills[$key]['communication']:"did_not_comment";
                                $comunication_did_not_comment = '';
                                if($communication_skill == '1'){
                                  $onecommunicationSelected='selected';
                                }else if($communication_skill == '2'){
                                  $twocommunicationSelected='selected';
                                }else if($communication_skill == '3'){
                                  $threecommunicationSelected='selected';
                                }else if($communication_skill == '4'){
                                  $fourcommunicationSelected='selected';
                                }else if($communication_skill == '5'){
                                  $fivecommunicationSelected='selected';
                                }else if($communication_skill == 'did_not_comment'){
                                  $comunication_did_not_comment='selected';
                                }else{
                                  $zerocommunicationSelected='selected';
                                }
                              ?>
                              <select class="fld form-control communication" id="communication<?php echo $i; ?>" >
                                <!-- <option <?php //echo $zerocommunicationSelected; ?> value="0">0</option> -->
                                <option <?php echo $onecommunicationSelected; ?> value="1" >1</option>
                                <option <?php echo $twocommunicationSelected; ?> value="2" >2</option>
                                <option <?php echo $threecommunicationSelected; ?> value="3" >3</option>
                                <option <?php echo $fourcommunicationSelected; ?> value="4" >4</option>
                                <option <?php echo $fivecommunicationSelected; ?> value="5" >5</option>
                                <option <?php echo $comunication_did_not_comment; ?> value="did_not_comment" >Did not Comment</option>
                              </select> 
                  			      <div id="communication-error<?php echo $i;?>"></div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Work Attitude</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <?php
                                $zerowork_attitudesSelected='';
                                $onework_attitudesSelected='';
                                $twowork_attitudesSelected='';
                                $threework_attitudesSelected='';
                                $fourwork_attitudesSelected='';
                                $fivework_attitudesSelected='';
                                $work_attitude_did_not_comment = '';
                                $work_attitudes = isset($work_attitude[$key]['attitude'])?$work_attitude[$key]['attitude'] :"did_not_comment";
                                if($work_attitudes == '1'){
                                  $onework_attitudesSelected='selected';
                                }else if($work_attitudes == '2'){
                                  $twowork_attitudesSelected='selected';
                                }else if($work_attitudes == '3'){
                                  $threework_attitudesSelected='selected';
                                }else if($work_attitudes == '4'){
                                  $fourwork_attitudesSelected='selected';
                                }else if($work_attitudes == '5'){
                                  $fivework_attitudesSelected='selected';
                                }else if($work_attitudes == 'did_not_comment'){
                                  $work_attitude_did_not_comment='selected';
                                }else{
                                  $zerowork_attitudesSelected='selected';
                                }

                                
                              ?>
                              <select class="fld form-control attitude" id="attitude<?php echo $i; ?>" >
                                <!-- <option <?php //echo $zerowork_attitudesSelected; ?> value="0">0</option> -->
                                <option <?php echo $onework_attitudesSelected; ?> value="1" >1</option>
                                <option <?php echo $twowork_attitudesSelected; ?> value="2" >2</option>
                                <option <?php echo $threework_attitudesSelected; ?> value="3" >3</option>
                                <option <?php echo $fourwork_attitudesSelected; ?> value="4" >4</option>
                                <option <?php echo $fivework_attitudesSelected; ?> value="5" >5</option>
                                <option <?php echo $work_attitude_did_not_comment; ?> value="did_not_comment" >Did not Comment</option>
                              </select> 
                              <div id="attitude-error<?php echo $i;?>"></div> 
                            </div>
                          </div>
                         <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Honesty & Reliability</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <?php
                                $zerohonesty_reliabilitySelected='';
                                $onehonesty_reliabilitySelected='';
                                $twohonesty_reliabilitySelected='';
                                $threehonesty_reliabilitySelected='';
                                $fourhonesty_reliabilitySelected='';
                                $fivehonesty_reliabilitySelected='';
                                $reliability_did_not_comment = '';
                                $honesty = isset($honesty_reliability[$key]['reliability'])?$honesty_reliability[$key]['reliability']:'did_not_comment';
                                if($honesty == '1'){
                                  $onehonesty_reliabilitySelected='selected';
                                }else if($honesty  == '2'){
                                  $twohonesty_reliabilitySelected='selected';
                                }else if($honesty  == '3'){
                                  $threehonesty_reliabilitySelected='selected';
                                }else if($honesty  == '4'){
                                  $fourhonesty_reliabilitySelected='selected';
                                }else if($honesty == '5'){
                                  $fivehonesty_reliabilitySelected='selected';
                                }else if($honesty == 'did_not_comment'){
                                  $reliability_did_not_comment='selected';
                                }else{
                                  $zeroattitudeSelected='selected';
                                }
                              ?>
                              <select class="fld form-control reliability" id="reliability<?php echo $i; ?>" >
                                <!-- <option <?php //echo $zerohonesty_reliabilitySelected; ?> value="0">0</option> -->
                                <option <?php echo $onehonesty_reliabilitySelected; ?> value="1" >1</option>
                                <option <?php echo $twohonesty_reliabilitySelected; ?> value="2" >2</option>
                                <option <?php echo $threehonesty_reliabilitySelected; ?> value="3" >3</option>
                                <option <?php echo $fourhonesty_reliabilitySelected; ?> value="4" >4</option>
                                <option <?php echo $fivehonesty_reliabilitySelected; ?> value="5" >5</option>
                                <option <?php echo $reliability_did_not_comment; ?> value="did_not_comment" >Did not Comment</option>
                              </select> 
                              <div id="reliability-error<?php echo $i;?>"></div>  
                            </div>
                          </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Target Orientation</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <?php
                                $zerotarget_orientationSelected='';
                                $onetarget_orientationSelected='';
                                $twotarget_orientationSelected='';
                                $threetarget_orientationeSelected='';
                                $fourtarget_orientationSelected='';
                                $fivetarget_orientationSelected='';
                                $target_orientation_did_not_comment = '' ;
                                $target = isset($target_orientation[$key]['orientation'])?$target_orientation[$key]['orientation']:'did_not_comment';

                                if($target== '1'){
                                  $onetarget_orientationSelected='selected';
                                }else if($target == '2'){
                                  $twotarget_orientationSelected='selected';
                                }else if($target == '3'){
                                  $threetarget_orientationeSelected='selected';
                                }else if($target == '4'){
                                  $fourtarget_orientationSelected='selected';
                                }else if($target == '5'){
                                  $fivetarget_orientationSelected='selected';
                                }else if($target == 'did_not_comment'){
                                  $target_orientation_did_not_comment='selected';
                                }else{
                                  $zerotarget_orientationSelected='selected';
                                }
                              ?>
                              <select class="fld form-control orientation" id="orientation<?php echo $i; ?>" >
                                <!-- <option <?php //echo $zerotarget_orientationSelected; ?> value="0">0</option> -->
                                <option <?php echo $onetarget_orientationSelected; ?> value="1" >1</option>
                                <option <?php echo $twotarget_orientationSelected; ?> value="2" >2</option>
                                <option <?php echo $threetarget_orientationeSelected; ?> value="3" >3</option>
                                <option <?php echo $fourtarget_orientationSelected; ?> value="4" >4</option>
                                <option <?php echo $fivetarget_orientationSelected; ?> value="5" >5</option>
                                <option <?php echo $target_orientation_did_not_comment; ?> value="did_not_comment" >Did not Comment</option>
                              </select> 
                              <div id="orientation-error<?php echo $i;?>"></div>   
                            </div>
                          </div>

                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>People Management</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <?php
                                $zeropeople_managementSelected='';
                                $onepeople_managementSelected='';
                                $twopeople_managementSelected='';
                                $threepeople_managementSelected='';
                                $fourpeople_managementSelected='';
                                $fivepeople_managementSelected='';
                                $people_mangement_did_not_comment = '' ;
                                $people = isset($people_management[$key]['management'])?$people_management[$key]['management']:'did_not_comment';

                                if($people == '1'){
                                  $onepeople_managementSelected='selected';
                                }else if($people == '2'){
                                  $twopeople_managementSelected='selected';
                                }else if($people == '3'){
                                  $threepeople_managementSelected='selected';
                                }else if($people == '4'){
                                  $fourpeople_managementSelected='selected';
                                }else if($people == '5'){
                                  $fivepeople_managementSelected='selected';
                                }else if($people == 'did_not_comment'){
                                  $people_mangement_did_not_comment='selected';
                                }else{
                                  $zeropeople_managementSelected='selected';
                                }
                              ?>
                              <select class="fld form-control management" id="management<?php echo $i; ?>" >
                                <!-- <option <?php //echo $zeropeople_managementSelected; ?> value="0">0</option> -->
                                <option <?php echo $onepeople_managementSelected; ?> value="1" >1</option>
                                <option <?php echo $twopeople_managementSelected; ?> value="2" >2</option>
                                <option <?php echo $threepeople_managementSelected; ?> value="3" >3</option>
                                <option <?php echo $fourpeople_managementSelected; ?> value="4" >4</option>
                                <option <?php echo $fivepeople_managementSelected; ?> value="5" >5</option>
                                <option <?php echo $people_mangement_did_not_comment; ?> value="did_not_comment" >Did not Comment</option>
                              </select> 
                              <div id="management-error<?php echo $i;?>"></div>    
                            </div>
                          </div>

                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>In Progress Remarks</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">  
                               <input name="" class="fld form-control progress_remarks" id="progress_remarks<?php echo $i; ?>" value="<?php echo isset($in_progress_remarks[$key]['progress_remarks'])?$in_progress_remarks[$key]['progress_remarks']:''?>"  type="text">
                               <div id="progress_remarks-error<?php echo $i;?>"></div>
                            </div>
                          </div>
                           <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Insuff Remarks</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                               
                               <input name="" class="fld form-control insuff_remarks" id="insuff_remarks<?php echo $i; ?>" value="<?php echo isset($insuff_remarks[$key]['insuff_remarks'])?$insuff_remarks[$key]['insuff_remarks']:''?>"  type="text">
                               <div id="insuff_remarks-error<?php echo $i;?>"></div>
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
                                 if (isset($approved_doc[$key])) {
                                 if (!in_array('no-file',$approved_doc[$key])) {
                                   foreach ($approved_doc[$key] as $key1 => $val) {
                                      if ($val !='') {
                                     echo "<div><span>{$val}</span><a onclick='exist_view_image(\"{$val}\",\"remarks-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                                    }
                                   }
                                 $pan_card_doc = $approved_doc[$key];
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
                            <p>Projects Handled</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <textarea 
                                class="fld form-control project_handled"
                                id="project_handled<?php echo $i; ?>"  
                                rows="3" ><?php echo isset($projects_handled[$key]['project_handled'])?$projects_handled[$key]['project_handled']:''?></textarea>
                              <div id="project_handled-error<?php echo $i;?>"></div>
                            
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                            <p>Professional Weakness</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8"> 
                              <textarea 
                                class="fld form-control professional-weakness"
                                id="professional-weakness<?php echo $i; ?>"  
                                rows="3" ><?php echo isset($professional_weakness[$key]['professional_weakness'])?$professional_weakness[$key]['professional_weakness']:''?></textarea>
                              <div id="professional-weakness-error<?php echo $i;?>"></div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Accomplishments</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <textarea 
                                class="fld form-control accomplishments"
                                id="accomplishments<?php echo $i; ?>"  
                                rows="3" ><?php echo isset($accomplishments[$key]['accomplishments'])?$accomplishments[$key]['accomplishments']:''?></textarea>
                              <div id="accomplishments-error<?php echo $i;?>"></div> 
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Job Performance</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <textarea 
                                class="fld form-control job_performance"
                                id="job_performance<?php echo $i; ?>"  
                                rows="3" ><?php echo isset($job_performance[$key]['job_performance'])?$job_performance[$key]['job_performance']:''?></textarea>
                              <div id="job_performance-error<?php echo $i;?>"></div>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Integrity</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <?php
                                $zerointegritySelected='';
                                $oneintegritySelected='';
                                $twointegritySelected='';
                                $threeintegritySelected='';
                                $fourintegritySelected='';
                                $fiveintegritySelected='';
                                $integrity_did_not_comment = '';

                                $integrities = isset($integrity[$key]['integrity'])?$integrity[$key]['integrity']:'did_not_comment';

                                if($integrities == '1'){
                                  $oneintegritySelected='selected';
                                }else if($integrities == '2'){
                                  $twointegritySelected='selected';
                                }else if($integrities == '3'){
                                  $threeintegritySelected='selected';
                                }else if($integrities == '4'){
                                  $fourintegritySelected='selected';
                                }else if($integrities == '5'){
                                  $fiveintegritySelected='selected';
                                }else if($integrities == 'did_not_comment'){
                                  $integrity_did_not_comment='selected';
                                }else{
                                  $zerointegritySelected='selected';
                                }
                              ?>
                              <select class="fld form-control integrity" id="integrity<?php echo $i; ?>" >
                                <!-- <option <?php //echo $zerointegritySelected; ?> value="NA">NA</option> -->
                                <option <?php echo $oneintegritySelected; ?> value="1" >1</option>
                                <option <?php echo $twointegritySelected; ?> value="2" >2</option>
                                <option <?php echo $threeintegritySelected; ?> value="3" >3</option>
                                <option <?php echo $fourintegritySelected; ?> value="4" >4</option>
                                <option <?php echo $fiveintegritySelected; ?> value="5" >5</option>
                                <option <?php echo $integrity_did_not_comment; ?> value="did_not_comment" >Did not Comment</option>
                              </select> 
                              <div id="integrity-error<?php echo $i;?>"></div>   
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Leadership Quality</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <?php
                                $zeroleadershipSelected='';
                                $oneleadershipSelected='';
                                $twoleadershipSelected='';
                                $threeleadershipSelected='';
                                $fourleadershipSelected='';
                                $fiveleadershipSelected='';
                                $leadership_did_not_comment = '';


                                $leadership = isset($leadership_quality[$key]['quality'])?$leadership_quality[$key]['quality']:'did_not_comment';

                                if($leadership == '1'){
                                  $oneleadershipSelected='selected';
                                }else if($leadership == '2'){
                                  $twoleadershipSelected='selected';
                                }else if($leadership == '3'){
                                  $threeleadershipSelected='selected';
                                }else if($leadership == '4'){
                                  $fourleadershipSelected='selected';
                                }else if($leadership == '5'){
                                  $fiveleadershipSelected='selected';
                                }else if($leadership == 'did_not_comment'){
                                  $leadership_did_not_comment='selected';
                                }else{
                                  $zeroleadershipSelected='selected';
                                }
                              ?>
                              <select class="fld form-control quality" id="quality<?php echo $i; ?>" >
                                <!-- <option <?php //echo $zeroleadershipSelected; ?> value="NA">NA</option> -->
                                <option <?php echo $oneleadershipSelected; ?> value="1" >1</option>
                                <option <?php echo $twoleadershipSelected; ?> value="2" >2</option>
                                <option <?php echo $threeleadershipSelected; ?> value="3" >3</option>
                                <option <?php echo $fourleadershipSelected; ?> value="4" >4</option>
                                <option <?php echo $fiveleadershipSelected; ?> value="5" >5</option>
                                <option <?php echo $leadership_did_not_comment; ?> value="did_not_comment" >Did not Comment</option>
                              </select> 
                              <div id="quality-error<?php echo $i;?>"></div>  
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Pressure Handling Nature</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <?php
                                $zeropressure_handling_natureSelected='selected';
                                $onepressure_handling_natureSelected='';
                                $twopressure_handling_natureSelected='';
                                $threepressure_handling_natureSelected='';
                                $fourpressure_handling_natureSelected='';
                                $fivepressure_handling_natureSelected='';
                                $pressure_handling_did_not_comment = '';

                                $pressure_handling= isset($pressure_handling_nature[$key]['pressure'])?$pressure_handling_nature[$key]['pressure']:'did_not_comment';

                                if($pressure_handling  == '1'){
                                  $onepressure_handling_natureSelected='selected';
                                }else if($pressure_handling  == '2'){
                                  $twopressure_handling_natureSelected='selected';
                                }else if($pressure_handling  == '3'){
                                  $threepressure_handling_natureSelected='selected';
                                }else if($pressure_handling  == '4'){
                                  $fourpressure_handling_natureSelected='selected';
                                }else if($pressure_handling == '5'){
                                  $fivepressure_handling_natureSelected='selected';
                                }else if($pressure_handling == 'did_not_comment'){
                                  $pressure_handling_did_not_comment='selected';
                                }else{
                                  $zeropressure_handling_natureSelected='selected';
                                }
                              ?>
                              <select class="fld form-control pressure" id="pressure<?php echo $i; ?>" >
                                <!-- <option <?php //echo $zeropressure_handling_natureSelected; ?> value="NA">NA</option> -->
                                <option <?php echo $onepressure_handling_natureSelected; ?> value="1" >1</option>
                                <option <?php echo $twopressure_handling_natureSelected; ?> value="2" >2</option>
                                <option <?php echo $threepressure_handling_natureSelected; ?> value="3" >3</option>
                                <option <?php echo $fourpressure_handling_natureSelected; ?> value="4" >4</option>
                                <option <?php echo $fivepressure_handling_natureSelected; ?> value="5" >5</option>
                                <option <?php echo $pressure_handling_did_not_comment; ?> value="did_not_comment" >Did not Comment</option>
                              </select> 
                              <div id="pressure-error<?php echo $i;?>"></div> 
                            </div>
                          </div>
                         <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Team Player </p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                              <?php
                                $zeroteam_playerSelected='selected';
                                $oneteam_playerSelected='';
                                $twoteam_playerSelected='';
                                $threeteam_playerSelected='';
                                $fourteam_playerSelected='';
                                $fiveteam_playerSelected='';
                                $Player_did_not_comment = '';
 
                                $player = isset($team_player[$key]['player'])?$team_player[$key]['player']:'did_not_comment';
                                if($player == '1'){
                                  $oneteam_playerSelected='selected';
                                }else if($player == '2'){
                                  $twoteam_playerSelected='selected';
                                }else if($player == '3'){
                                  $threeteam_playerSelected='selected';
                                }else if($player == '4'){
                                  $fourteam_playerSelected='selected';
                                }else if($player == '5'){
                                  $fiveteam_playerSelected='selected';
                                }else if($player == 'did_not_comment'){
                                  $Player_did_not_comment='selected';
                                }else{
                                  $zeroteam_playerSelected='selected';
                                }
                              ?>
                              <select class="fld form-control player" id="player<?php echo $i; ?>" >
                                <!-- <option <?php //echo $zeroteam_playerSelected; ?> value="NA">NA</option> -->
                                <option <?php echo $oneteam_playerSelected; ?> value="1" >1</option>
                                <option <?php echo $twoteam_playerSelected; ?> value="2" >2</option>
                                <option <?php echo $threeteam_playerSelected; ?> value="3" >3</option>
                                <option <?php echo $fourteam_playerSelected; ?> value="4" >4</option>
                                <option <?php echo $fiveteam_playerSelected; ?> value="5" >5</option>
                                <option <?php echo $Player_did_not_comment; ?> value="did_not_comment" >Did not Comment</option>
                              </select> 
                              <div id="player-error<?php echo $i;?>"></div>
                            </div>
                          </div>

                        <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Additional Comments</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
	                            <textarea 
                                class="fld form-control additional_comments"
                                id="additional_comments<?php echo $i; ?>"  
                                rows="3" ><?php echo isset($additional_comments[$key]['additional_comments'])?$additional_comments[$key]['additional_comments']:''?></textarea>
                              <div id="additional_comments-error<?php echo $i;?>"></div>
                            </div>
                          </div> 
                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Verification Remarks</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                             <input name="" class="fld form-control verification_remarks"  id="verification_remarks<?php echo $i; ?>" 
                             value="<?php echo isset($verification_remarks[$key]['verification_remarks'])?$verification_remarks[$key]['verification_remarks']:''?>"
                             onkeyup="varificationRemarks(<?php echo $i; ?>)"
                             type="text">
                  			     <div id="verification_remarks-error<?php echo $i;?>"></div>
                            </div>
                          </div>

                          <div class="row mt-2">
                            <div class="col-md-3">
                             <p>Insuff Closure Remarks</p>
                            </div>
                            <div class="col-md-1 pr-0">
                              <p>:</p>
                            </div>
                            <div class="col-md-8">
                                  <input name="" class="fld form-control closure_remarks"  id="closure_remarks<?php echo $i; ?>" 
                                  value="<?php echo isset($insuff_closure_remarks[$key]['closure_remarks'])?$insuff_closure_remarks[$key]['closure_remarks']:''?>" type="text">
                  			         <div id="closure_remarks-error<?php echo $i;?>"></div>
                            </div>
                          </div>
                           
                        </div>
                    </div>
                    <hr>
                  <?php 
                    $i++;
                    } 

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
                      <!-- id="submit-reference" -->
                      <button class="update-bt" data-toggle="modal" data-target="#conformtionReferance">Update</button></a>                       
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
<div id="conformtionReferance" class="modal fade">
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
        <button class="btn bg-blu float-right text-white" id="submit-reference-data">Confirm</button>
        <div class="clr">
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


<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/remark-reference.js"></script>