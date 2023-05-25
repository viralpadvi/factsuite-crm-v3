<?php 
  // error_reporting(E_ERROR | E_WARNING | E_PARSE);
  $candidateId =  isset($componentData['candidate_id'])?$componentData['candidate_id']:"2";
  $candidateName =  $componentData['first_name']." ".$componentData['last_name'];
  $candidateClinetName =  isset($componentData['client_name'])?$componentData['client_name']:"2";
 $code =  isset($componentData['country_code'])?$componentData['country_code']:"+91";
  $candidatePhoneNumber =  $code.' '.isset($componentData['phone_number'])?$componentData['phone_number']:"1234567890";
  $candidatePackageName =  isset($componentData['package_name'])?$componentData['package_name']:"2";
  $candidateEmail =  isset($componentData['email_id'])?$componentData['email_id']:"2";
  $php_code_selected_datetime_format = explode(' ',$selected_datetime_format['php_code']);
  $candidateDob = isset($componentData['date_of_birth'])?date($php_code_selected_datetime_format[0],strtotime($componentData['date_of_birth'])):"-";
  $priority = $componentData['priority'];
  $candidateFatherName =  isset($componentData['father_name'])?$componentData['father_name']:"No data Found"; 
  $candidateEmployeeId =  isset($componentData['employee_id'])?$componentData['employee_id']:"No data Found";
  
   $candidate_address =  isset($componentData['candidate_addresss'])?$componentData['candidate_addresss']:"-";
  $nationality =  isset($componentData['nationality'])?$componentData['nationality']:"-";
  $candidate_state =  isset($componentData['candidate_state'])?$componentData['candidate_state']:"-";
  $candidate_city =  isset($componentData['candidate_city'])?$componentData['candidate_city']:"-";
  $candidate_pincode =  isset($componentData['candidate_pincode'])?$componentData['candidate_pincode']:"000000";

  $emp_gap_id =  isset($componentData['current_emp_id'])?$componentData['current_emp_id']:"0";
$remarks = isset($componentData['remark'])?$componentData['remark']:"";
  $courtRecordStatus = ''; 
if (empty($remarks)) {
  $remarks ="NA";
}
  $backLink = '';
  $userRole = '';
  $userID = '';

  $outputQCStatus = '';
 
  $inputqc_status_date = explode(',',isset($componentData['inputqc_status_date'])?$componentData['inputqc_status_date']:date('d-m-Y H:i:s'));
  $analyst_status_date = explode(',', isset($componentData['analyst_status_date'])?$componentData['analyst_status_date']:date('d-m-Y H:i:s'));

  $analyst_specialist_status_date = 'NA';
  $show_analyst_specialist_verification_days_taken = 'NA';
  $analyst_status_date_time = date('d-m-Y');
    $inputqc_status_date_time = isset($inputqc_status_date[$index])?$inputqc_status_date[$index]:date('d-m-Y H:i:s');
  if ($componentData['inputqc_status_date'] !='' && $componentData['inputqc_status_date'] !='NA' && $componentData['analyst_status_date'] != '' && $componentData['analyst_status_date'] != 'NA') {
      $analyst_specialist_status_date = isset($analyst_status_date[$index])?$analyst_status_date[$index]:date('d-m-Y H:i:s');
      $analyst_specialist_status_date_time_splitted = $analyst_specialist_status_date;
      if (!$this->utilModel->check_date_format($analyst_specialist_status_date_time_splitted,'Y-m-d')) {
          /* $analyst_specialist_status_date_splitted = explode('-',$analyst_specialist_status_date_time_splitted);
          $analyst_status_date_time = $analyst_specialist_status_date_splitted[1].'/'.$analyst_specialist_status_date_splitted[0].'/'.$analyst_specialist_status_date_splitted[2];*/
            $analyst_status_date_time = $analyst_specialist_status_date;
      } else {
          $analyst_status_date_time = $analyst_specialist_status_date_time_splitted;
      }
      $analyst_specialist_date_difference = date_diff(date_create($inputqc_status_date_time),date_create($analyst_status_date_time));
      $show_analyst_specialist_verification_days_taken = $analyst_specialist_date_difference->format("%a");
      if ($analyst_specialist_date_difference->format("%a") > 1) {
          $show_analyst_specialist_verification_days_taken .= ' days';
      } else {
          $show_analyst_specialist_verification_days_taken .= ' day';
      }
  }
                
  if($this->session->userdata('logged-in-outputqc')){
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
    // $courtRecordStatus = $analyst_status;
  }else if($this->session->userdata('logged-in-specialist')){ 
    $backLink = 'factsuite-specialist/view-all-component-list';
    $inputqcUser = $this->session->userdata('logged-in-specialist');
    $userID =$inputqcUser['team_id'];
    $userRole =$inputqcUser['role'];
    // $courtRecordStatus = $analyst_status;
  }else if($this->session->userdata('logged-in-am')){ 
    $backLink = 'factsuite-am/view-all-case-list';
    // $backLink = 'factsuite-am/view-case-detail/'.$candidateId;
    $inputqcUser = $this->session->userdata('logged-in-am');
    $userID =$inputqcUser['team_id'];
    $userRole =$inputqcUser['role'];
    // $courtRecordStatus = $analyst_status;
  }else if($this->session->userdata('logged-in-insuffanalyst')){ 
    $backLink = 'factsuite-analyst/assigned-insuff-component-list';
    $inputqcUser = $this->session->userdata('logged-in-insuffanalyst');
    $userID =$inputqcUser['team_id'];
    $userRole =$inputqcUser['role'];
    // $courtRecordStatus = $analyst_status;
  }else{
    echo "<script>$('#back-btn').addClass('d-none');</script>";
  }
$remarks_updateed_by_role = $userRole;
  if($remarks_updateed_by_role == '' || $remarks_updateed_by_role == 'null'){
    $remarks_updateed_by_role = 'pending';
  }

  	$company_name = json_decode(isset($previous_employment['company_name'])?$previous_employment['company_name']:'',true);
  $start_date = json_decode(isset($previous_employment['joining_date'])?$previous_employment['joining_date']:'',true);
	$reason_for_gap = json_decode(isset($componentData['reason_for_gap'])?$componentData['reason_for_gap']:'',true);
	$end_date = json_decode(isset($previous_employment['relieving_date'])?$previous_employment['relieving_date']:'',true);
	 $curr_joining_date = isset($current_employment['joining_date'])?$current_employment['joining_date']:date('Y-m-d');
	$data = array();
  $end_d ='';
  if ($company_name !='' && $company_name !=null) {
 
	foreach ($company_name as $key => $value) {
	 
		$data[$key]['companyName']= $value['company_name'];
		$data[$key]['startDate']= isset($start_date[$key]['joining_date'])?$start_date[$key]['joining_date']:date('d-m-Y');
		$data[$key]['endDate']= isset($end_date[$key]['relieving_date'])?$end_date[$key]['relieving_date']:date('d-m-Y');

    $end_d = isset($end_date[$key]['relieving_date'])?$end_date[$key]['relieving_date']:date('d-m-Y');
	}
}

	 
	uasort($data, function($a,$b){
		if($a['startDate']==$b['startDate']) return 0;
    	return $a['startDate'] < $b['startDate']?1:-1;
    	// return strcmp($a['startDate'], $b['startDate']);
	});
	 
	$sortedArray = array();
	foreach ($data as $data_key => $data_value) {
		array_push($sortedArray,$data_value);
	}

	$gap = array();
	for($i=1; $i<sizeof($sortedArray); $i++){
   		// $gap[$i] = $data[$i-1]['endDate'] < $data[$i]['startDate'];

   		$start_date = date_create($sortedArray[$i-1]['startDate']);
		  $end_date = date_create($sortedArray[$i]['endDate']);
		 
		$tenure_of_gap = date_diff($end_date,$start_date);
		$gap[$i]['daysGap'] = $tenure_of_gap->format("%a days");
	}

$end = date_create($end_d);
$start = date_create($curr_joining_date);

      $tenure_gap = date_diff($end,$start);
    $gaps = $tenure_gap->format("%a days");
// echo "<br>";
	// print_r($gap);
	// exit();
?>
<input type="hidden" value="<?php echo $component_id?> " id="component_id" name="component_id">
  <input type="hidden" value="<?php echo $userID?> " id="userID" name="userID">
  <input type="hidden" value="<?php echo $userRole ?>" id="userRole" name="userRole"> 
  <input type="hidden" value="<?php echo $priority ?>" id="priority" name="priority">
  <input type="hidden" name="componentIndex" value="<?php echo $index?>" id="componentIndex">
  
  <input type="hidden" id="selected-hidden-candidate-id" value="<?php echo $candidateIdLink;?>">
  <input type="hidden" id="selected-hidden-component-id" value="<?php echo $component_id;?>">
  <input type="hidden" id="selected-hidden-component-index" value="<?php echo $index;?>">
  <input type="hidden" id="selected-hidden-user-component-form-filled-id" value="<?php echo $emp_gap_id;?>">
  <input type="hidden" value="<?php echo $componentData['candidate_id']?>" id="candidate_id_hidden"name="">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-analyst">
         <!-- <h3><?php //echo $statusLink; ?></h3> -->
          
          <a class="btn bg-blu btn-submit-cancel" id="back-btn" href="<?php echo $this->config->item('my_base_url').$backLink?>" ><span class="text-white"><i class="fas fa-angle-left"></i>&nbsp;Back</span></a>

          <h3 class="mt-3">Employment Gap Detail </h3>
           
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
               <p>Internal TAT Day</p>
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
                 <p><?php echo $show_analyst_specialist_verification_days_taken;?></p>
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
                <?php                    
                   if($document_uploaded_by != 'candidate' && $is_submitted != 0 && $signature =='1'){
                    echo '<label class="font-weight-bold">LOA &nbsp;&nbsp;&nbsp;<a target="_blank" download href="'.$base_url.'uploads/doc_signs/'.$uploaded_loa.'"><i class="fa fa-download"></i></a></label>';
                  }else if($is_submitted != 0){
                ?>
                <label class="font-weight-bold">LOA &nbsp;&nbsp;&nbsp;<a target="_blank"
                        href="<?php echo $this->config->item('my_base_url').'factsuite-admin/candidate-loa-pdf/'.md5($candidateId); ?>"><i
                            class="fa fa-file-pdf-o"></i></a></label>
                <?php } ?>
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
                 <input type="hidden" name="gap_id" value="<?php echo $componentData['gap_id']; ?>" id="gap_id">
               
                  <?php 
                    // print_r($componentData);

                    // $cv_doc= json_decode($componentData['cv_doc'],true);
                    // $document_type= json_decode($componentData['document_type'],true);
                    // $credit_number= json_decode($componentData['credit_number'],true);
                    $remark_country= isset($componentData['remark_country'])?$componentData['remark_country']:'Data Not Found';
                    $insuff_remarks= isset($componentData['insuff_remarks'])?$componentData['insuff_remarks']:'Data Not Found';
                    $in_progress_remarks= isset($componentData['in_progress_remarks'])?$componentData['in_progress_remarks']:'Data Not Found';
                    $verification_remarks= isset($componentData['verification_remarks'])?$componentData['verification_remarks']:'Data Not Found';
                    $Insuff_closure_remarks= isset($componentData['Insuff_closure_remarks'])?$componentData['Insuff_closure_remarks']:'Data Not Found';
                    // $approved_doc= isset($componentData['approved_doc'])?$componentData['approved_doc']:'Data Not Found';
                    $approved_doc= json_decode($componentData['approved_doc'],true);
                    $ouputqc_comment = isset($componentData['ouputqc_comment'])?$componentData['ouputqc_comment']:'Data Not Found';
                    $analyst_status = isset($componentData['analyst_status'])?$componentData['analyst_status']:'0';

                    $verified_date = $componentData['verified_date'];//json_decode($componentData['verified_date'],true);
                    
                    $j=1;


                    // echo "<br>";

                    
                    // for ($i=0; $i < count($credit_number) ; $i++) { 
                      // $index = $i;
                      // print_r($document_type[$index]['document_type']);
                      // echo "<br>";
                      // print_r($credit_number[$index]['credit_cibil_number']);


                      // echo "<br>remark_country: ".$remark_country;
                      // echo "<br>insuff_remarks: ".$insuff_remarks;
                      // echo "<br>in_progress_remarks: ".$in_progress_remarks;
                      // echo "<br>verification_remarks: ".$verification_remarks;
                      // echo "<br>Insuff_closure_remarks: ".$Insuff_closure_remarks;
                      // echo "<br>ouputqc_comment: ".$ouputqc_comment;
                      // echo "<br>analyst_status: ".$analyst_status;
                    ?>
                   
                    <!--   -->
                    <!-- <div> -->
                      <h3 class="permt mt-4">Employment Gap Detail</h3> 
                      <div class="row mt-3"> 
                        <div class="ml-5 mr-5 table-responsive mt-3" id="">
        				          <table class="datatable table-striped">
        				            <thead class="thead-bd-color">
        				              <tr>
        				                <th>Sr No.</th> 
        				                <th>Company Name</th>  
        				                <th>Start to End Date</th>  
                                <th>Employment Gap Duration Date</th>  
        				                <th>Reason For Gap</th>  
        				                <th>Tenure Gap</th>  
        				              </tr>
        				            </thead>
        				            <tbody class="tbody-datatable" id="get-case-data"> 
        				            	<?php
        				            		$sr = 1;
        				            		$sortedArrayCount = count($sortedArray);
                                $ind = 0;
        				            		foreach ($sortedArray as $sortedArraykey => $sortedArrayvalue) {
                                  if ($sortedArraykey !=0) {
                                 $ra = isset($reason_for_gap[$ind]['reason_for_gap'])?$reason_for_gap[$ind]['reason_for_gap']:'';
                                    
        				            			// echo $sortedArray[$newStartDateKey]['endDate']."<br>";
        				            			$newStartDateKey = $sortedArraykey - 1;  
        				            			$newDate = '';
        				            			$newStartDate = '';
        				            			
        				            			if($newStartDateKey != -1 ){
        				            				$datetime = new DateTime($sortedArrayvalue['endDate']);
              											$datetime->modify('+1 day');
              											$newDate= $datetime->format('Y-M-d');
        				            			}

        				            			if($newStartDateKey != -1){
        				            				// echo $newStartDateKey;
        				            				$datetime = new DateTime($sortedArray[$newStartDateKey]['startDate']);
              											$datetime->modify('-1 day');
              											$newStartDate= $datetime->format('Y-M-d');
        				            			}
        										      
        				            			echo "<tr>";
              										echo "<td>".$sr++."</td> ";
              										echo "<td>".$sortedArrayvalue['companyName']."</td>  ";
                                  $startDateDatetime = new DateTime($sortedArrayvalue['startDate']);
                                  $startDateDatetime= $startDateDatetime->format('Y-M-d');
                                  $endDateDatetime = new DateTime($sortedArrayvalue['endDate']);
                                  $endDateDatetime= $endDateDatetime->format('Y-M-d');
              										echo "<td>".$startDateDatetime."&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp;  ".$endDateDatetime."</td>  ";
              										if($sortedArraykey != 0){
              											
                                    echo "<td>".$newDate."&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp; ".$newStartDate."</td>  ";
                                  
                                    echo "<td>".$ra."</td>  ";
                                    echo "<td>".$gap[$sortedArraykey]['daysGap']."</td>  ";
              										}else{

                                    $endDateDatetime = new DateTime($sortedArrayvalue['endDate']);
                                  $endDateDatetime= $endDateDatetime->format('Y-M-d');
                                  
                                    $first = date_create($sortedArrayvalue['endDate']);
                                    $second = date_create($curr_joining_date);
              											 $tenure = date_diff($first,$second);
                                   $daysGap = $tenure->format("%a days");
                                    echo "<td>-</td>  ";
                                  
                                   echo "<td>-</td>  ";
                                   // echo "<td>".$daysGap."</td>  ";
                                   $ind++;
              										}
              										echo "</tr>";
                                } 
        				            		} 
                                $ra = isset($reason_for_gap[$ind+1]['reason_for_gap'])?$reason_for_gap[$ind+1]['reason_for_gap']:'';

                                    $datetime = new DateTime($end_d);
                                    $datetime->modify('+1 day');
                                    $newDate= $datetime->format('Y-M-d'); 
                                    // echo $newStartDateKey;
                                    $datetime = new DateTime($curr_joining_date);
                                    $datetime->modify('-1 day');
                                    $newStartDate= $datetime->format('Y-M-d'); 


                                  $e = new DateTime($end_d);
                                  $endDateDate= $e->format('Y-M-d'); 
                                  $cur_emp = isset($current_employment['company_name'])?$current_employment['company_name']:'';
                                  echo "<tr>";
                                  echo "<td>".$sr++."</td> ";
                                  echo "<td>".$cur_emp."</td>  ";
                                   echo "<td>".$endDateDate." To ".$curr_joining_date."</td>  ";
                                   echo "<td>".$newDate."&nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;&nbsp; ".$newStartDate."</td>  ";
                                     echo "<td>".$ra."</td>";
                                    echo "<td>".$gaps."</td>  ";
                                  echo "</tr>";

                              
        				            	?>				            				           
        				            </tbody>
        				          </table>
				                </div> 
                      </div>
                       
                    <hr> 
                    <h3 class="permt mt-4">Employment Gap Check Verification Details <?php echo $j?></h3>
                      <div class="row mt-3"> 
                        <div class="col-md-6">
                          <!-- Country List -->
                          <div class="row">
                            <div class="col-md-3">
                              <label>Country List</label>
                            </div>
                            <div class="col-md-2">
                              <label>:</label>
                            </div>
                            <div class="col-md-6"> 
                              
                              <select class="select2 country" id="country" >
                               <?php
                                   
                                  foreach ($countries as $key => $value) {
                                    if($remark_country != '' || $remark_country != 'null'){
                                      if($value['name'] == $remark_country){
                                        echo '<option selected value="'.$value['name'].'">'.$value['name'].'</option>';
                                      }else{
                                        echo '<option value="'.$value['name'].'">'.$value['name'].'</option>';
                                      }
                                    }else{

                                      if($value['name'] == 'India'){
                                        echo '<option selected value="'.$value['name'].'">'.$value['name'].'</option>';
                                      }else{
                                        echo '<option value="'.$value['name'].'">'.$value['name'].'</option>';
                                      }     
                                    }
                                  }
                               ?>

                              </select>
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
                              
                                 <textarea class="fld form-control insuff_remarks"  
                                onkeyup="valid_insuff_remarks()" 
                                onblur="valid_insuff_remarks()" 
                                id="insuff_remarks" ><?php echo $insuff_remarks; ?></textarea>
                              <div id="insuff_remarks-error">&nbsp;</div>
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
                                <textarea class="fld form-control progress_remarks" onkeyup="valid_progress_remarks()" onblur="valid_progress_remarks()" 
                                id="progress_remarks"><?php echo $in_progress_remarks; ?></textarea>
                              <div id="progress_remarks-error">&nbsp;</div>
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
                              <textarea class="fld form-control verification_remarks" onkeyup="valid_verification_remarks()" onblur="valid_verification_remarks()" id="verification_remarks"><?php echo $verification_remarks; ?></textarea>
                              <div id="verification_remarks-error">&nbsp;</div>
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
                              <?php 
                                $verified = isset($verified_date)?$verified_date:'';
                                if($verified == 'Invalid Date' || $verified == 'Invalid date' || $verified == 'invalid Date'){
                                
                                $verified ='';

                                }

                                $verified = $this->utilModel->get_date($verified);

                                if (strtolower($verified) !='na' && strtolower($verified) !='01-01-1970') {}else{
                                   $verified ='';
                                }
                              ?>
                              <input name="" class="fld form-control mdate verified_date" value="<?php echo $verified; ?>" id="verified_date" type="text"> 
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
                              <textarea class="fld form-control closure_remarks"  onkeyup="valid_closure_remarks()" onblur="valid_closure_remarks()" id="closure_remarks"><?php echo $Insuff_closure_remarks; ?></textarea>
                              <div id="closure_remarks-error">&nbsp;</div>
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
                                      <input type="file" class="client-documents" id="client-documents" name="criminal-documents[]" multiple="multiple">
                                      <label class="btn upload-btn" for="client-documents">Upload</label>
                                    </div>
                                      <div id="criminal-upoad-docs-error-msg-div">
                                        <?php
                                          $pan_card_doc = '';
                                          if (isset($approved_doc[$index])) {
                                            if (!in_array('no-file',  $approved_doc[$index])) {
                                              foreach ($approved_doc[$index] as $key1 => $value) {
                                                if ($value !='') {
                                                  $url = base_url()."../uploads/remarks-docs/".$value;
                                                  echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a> <a href='{$url}' download >  <i class='fa fa-download'></i></a> </span></div>";   
                                                }
                                              }
                                              $pan_card_doc = $approved_doc[$index];
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
                          
                          
                        </div>
                    </div>
                    <hr>
                  <?php 
                    // $j++;
                    // } 
                  ?>
                  <div class="row mt-2">
                    <div class="col-md-6">

                      
                      <?php

                         
                          // print_r($analyst_status);
                          // echo  "<br>";
                          // $analyst_status = $analyst_status[$index];
                          // echo  "analyst_status: " . $analyst_status."<br>";
                        $defaultStatus = '';
                        $insuffStatus = '';
                        $verifiedclearStatus = '';
                        $stopcheckStatus = '';
                        $utv = '';
                        $vd = '';
                        $cc = '';
                        $ci ='';
                        $ni ='';
                        $disabled = '';
                        $disabledOP = '';
                        $progress ='';
                        if($analyst_status == 0){
                          $defaultStatus = 'selected';
                        }else if($analyst_status == 1){
                          $progress ='selected';
                        }else if($analyst_status == 3){
                          $insuffStatus = 'selected';
                        }else if($analyst_status == 4){
                          $verifiedclearStatus = 'selected';
                          // $disabled = 'disabled';
                        }else if($analyst_status == 5){
                          $stopcheckStatus = 'selected';
                        }else if($analyst_status == 6){
                          $utv = 'selected';
                        }else if($analyst_status == 7){
                          $vd = 'selected';
                        }else if($analyst_status == 8){
                          $cc = 'selected';
                        }else if($analyst_status == 9){
                          $ci = 'selected';
                        }else if($analyst_status == 11){
                          $ni = 'selected';
                        }
                        
                        $subTitle = '';
                        $selectOpStatusEnable = 'd-none';
                        if($outputQCStatus == 'disabled'){
                          $subTitle = 'Analyst component status';
                          $selectOpStatusEnable = '';
                        }else{
                          $subTitle = 'Select component status';
                        }
                         
                        $disabled = '';
                        if(($remarks_updateed_by_role == 'insuff analyst' || $remarks_updateed_by_role == 'insuff ana') && $analyst_status == 3){
                          // $disabled = 'disabled';
                        }

                      ?>
                      <p class="det"><?php echo $subTitle; ?></p>
                      <select id="action_status" <?php echo $disabled." ".$outputQCStatus; ?> name="carlist" class="sel-allcase">
                        <option class="text-capitalize" <?php echo $defaultStatus ?> value="0">Select your Action</option>
                        <?php                           
                          if($userRole != 'insuff analyst'){  ?>
                        <option class="text-capitalize" <?php echo $progress ?> value="1">In Progress</option>
                      <?php } ?>
                        <option class="text-capitalize" <?php echo $insuffStatus ?> value="3">Insufficient</option>
                        <?php 
                          if($userRole != 'insuff analyst'){  ?>
                            <option class="text-capitalize" <?php echo $verifiedclearStatus ?> value="4">Verified Clear</option>
                            <option class="text-capitalize" <?php echo $stopcheckStatus ?> value="5">Stop check</option> 
                            <option class="text-capitalize" <?php echo $utv ?> value="6">Unable to verify</option> 
                            <option class="text-capitalize" <?php echo $vd ?> value="7">Verified discrepancy</option> 
                            <option class="text-capitalize" <?php echo $cc ?> value="8">Client clarification</option> 
                            <option class="text-capitalize" <?php echo $ci ?> value="9">Closed Insufficiency</option>
                        <?php } else { ?>
                             <option class="text-capitalize" <?php echo $ni ?> value="11">Not Insufficient</option>
                        <?php }
                        
                          if($analyst_status == '10'){
                            echo '<option class="text-capitalize" selected value="10">QC Error</option>';
                          } 
                        ?>
                      </select>
                    </div>
                  </div>
                  <?php $data['vendor'] = $vendor;
                  $this->load->view('vendor/vendor-assign-to-component-form',$data); ?>
                  <div class="row d-none">
                    <div class="col-md-12 text-right">
                      <a class="btn bg-blu btn-submit mt-4" id="view-all-raised-error-log">
                        <span class="text-white">View Error Log</span>
                      </a>
                      <a class="btn bg-blu btn-submit mt-4" data-toggle="modal" data-target="#add-new-error-modal">
                        <span class="text-white">Raise Error</span>
                      </a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 text-right">
                      <a class="btn bg-blu btn-submit mt-4 d-none" data-toggle="modal" data-target="#add-new-client-clarification-modal">
                        <span class="text-white">Raise Client Clarifications</span>
                      </a>
                      <a class="btn bg-blu btn-submit mt-4" id="view-all-raised-client-clarification-log">
                        <span class="text-white">View Client Clarifications Log</span>
                      </a>
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
                  <?php 
                  if($analyst_status == '10'){?>
                    <div class="row mt-2"> 
                      <div class="col-md-6">
                        <p class="det">Qc Comment</p>
                        <textarea 
                          class="fld form-control ouputQcComment" 
                          id="ouputQcComment"  
                          rows="3" ><?php echo $ouputqc_comment ?></textarea>
                        <div id="address-error"></div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
                <hr>
                  <div class="row mt-2">
                    <div class="col-md-6">
                      
                    </div>
                    <div class="col-md-6 text-right">
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
<?php
  include APPPATH.'views/analyst/assigned-case/component-pages/view_image_model.php';
?>
<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/employment_gap_check.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/commonImageView.js"></script> 
<script type="text/javascript">
  phpData(<?php echo json_encode($componentData)?>)
</script>

<?php if ($this->session->userdata('logged-in-analyst')) { ?>
  <script src="<?php echo base_url() ?>assets/custom-js/analyst/component-error/raise-error.js"></script>
  <script src="<?php echo base_url() ?>assets/custom-js/analyst/component-error/all-errors.js"></script>

  <script src="<?php echo base_url() ?>assets/custom-js/analyst/client-clarification/raise-clarification.js"></script>
  <script src="<?php echo base_url() ?>assets/custom-js/analyst/client-clarification/all-clarifications.js"></script>
<?php } else if($this->session->userdata('logged-in-specialist')) { ?>
  <script src="<?php echo base_url() ?>assets/custom-js/specialist/component-error/raise-error.js"></script>
  <script src="<?php echo base_url() ?>assets/custom-js/specialist/component-error/all-errors.js"></script>

  <script src="<?php echo base_url() ?>assets/custom-js/specialist/client-clarification/raise-clarification.js"></script>
  <script src="<?php echo base_url() ?>assets/custom-js/specialist/client-clarification/all-clarifications.js"></script>
<?php } ?>

<?php extract($_GET); 
  if (isset($view_client_clarification) && $view_client_clarification != '') {
?>
  <script>
    view_clarification_details(<?php echo $view_client_clarification;?>);
  </script>
<?php } ?>