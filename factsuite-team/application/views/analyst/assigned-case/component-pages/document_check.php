<?php 
  $candidateId =  isset($componentData['candidate_id'])?$componentData['candidate_id']:"0";
  $candidateName =  $componentData['first_name']." ".$componentData['last_name'];
  $candidateClinetName =  isset($componentData['client_name'])?$componentData['client_name']:"abc";
  $code =  isset($componentData['country_code'])?$componentData['country_code']:"+91";
  $candidatePhoneNumber =  $code.' '.isset($componentData['phone_number'])?$componentData['phone_number']:"1234567890";
  $candidatePackageName =  isset($componentData['package_name'])?$componentData['package_name']:"2";
  $candidateEmail =  isset($componentData['email_id'])?$componentData['email_id']:"2";
  $php_code_selected_datetime_format = explode(' ',$selected_datetime_format['php_code']);
  $candidateDob =  isset($componentData['date_of_birth'])?date($php_code_selected_datetime_format[0],strtotime($componentData['date_of_birth'])):"-";
  $document_check_id =  isset($componentData['document_check_id'])?$componentData['document_check_id']:"0";
  $candidateFatherName =  isset($componentData['father_name'])?$componentData['father_name']:"No data Found"; 
  $candidateEmployeeId =  isset($componentData['employee_id'])?$componentData['employee_id']:"No data Found";
  $priority =  isset($componentData['priority'])?$componentData['priority']:"0";
  $candidate_address =  isset($componentData['candidate_addresss'])?$componentData['candidate_addresss']:"-";
  $nationality =  isset($componentData['nationality'])?$componentData['nationality']:"-";
  $candidate_state =  isset($componentData['candidate_state'])?$componentData['candidate_state']:"-";
  $candidate_city =  isset($componentData['candidate_city'])?$componentData['candidate_city']:"-";
  $candidate_pincode =  isset($componentData['candidate_pincode'])?$componentData['candidate_pincode']:"000000";
$remarks = isset($componentData['remark'])?$componentData['remark']:"NA";
if (empty($remarks)) {
  $remarks ="NA";
}
  $backLink = '';
  $userRole = '';
  $userID = '';
$outputQCStatus = '';
 
                      // for ($i=0; $i < $count ; $i++) { 

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
  	$backLink = 'factsuite-am/view-all-case-list';
    // $backLink = 'factsuite-am/view-case-detail/'.$candidateId;
    $inputqcUser = $this->session->userdata('logged-in-am');
    $userID =$inputqcUser['team_id'];
    $userRole =$inputqcUser['role'];
    // $courtRecordStatus = $componentData['analyst_status'];
  }else if($this->session->userdata('logged-in-insuffanalyst')){ 
    $backLink = 'factsuite-analyst/assigned-insuff-component-list';
    $inputqcUser = $this->session->userdata('logged-in-insuffanalyst');
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
<input type="hidden" value="<?php echo $component_id?> " id="component_id" name="component_id">
<input type="hidden" value="<?php echo $componentData['candidate_id']?>" id="candidate_id_hidden"name="">
<input type="hidden" value="<?php echo $userID?> " id="userID" name="userID">
<input type="hidden" value="<?php echo $userRole ?>" id="userRole" name="userRole">
 <input type="hidden" value="<?php echo $index ?>" id="componentIndex" name="componentIndex">
  <input type="hidden" value="<?php echo $priority ?>" id="priority" name="priority">
  <input type="hidden" value="<?php echo $document_check_id ?>" id="document_check_id" name="document_check_id">

  <input type="hidden" id="selected-hidden-candidate-id" value="<?php echo $candidateIdLink;?>">
  <input type="hidden" id="selected-hidden-component-id" value="<?php echo $component_id;?>">
  <input type="hidden" id="selected-hidden-component-index" value="<?php echo $index;?>">
  <input type="hidden" id="selected-hidden-user-component-form-filled-id" value="<?php echo $document_check_id;?>">
  <input type="hidden" value="<?php echo $candidateId?>" id="candidate_id_hidden" name="">
  
<div class="pg-cnt">
    <div id="FS-candidate-cnt" class="FS-candidate-cnt-analyst">
         <!-- <h3>Case Detail</h3> -->
          
          <a class="btn bg-blu btn-submit-cancel" id="back-btn" href="<?php echo $this->config->item('my_base_url').$backLink?>" ><span class="text-white"><i class="fas fa-angle-left"></i>&nbsp;Back</span></a>

          <h3 class="mt-3">Document Check Details</h3>
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
                  <?php 
                    // print_r($componentData);
                    // exit();
                    $documentType = json_decode($componentData['documentType'],true);
                    $passport_doc = explode(",",$componentData['passport_doc']); 
                    $pan_card_doc = explode(",",$componentData['pan_card_doc']);
                    $adhar_doc = explode(",",$componentData['adhar_doc']); 
                    $voter_doc = explode(",",$componentData['voter_doc']); 
                    $ssn_doc = explode(",",$componentData['ssn_doc']); 

                    $address = json_decode($componentData['remark_address'],true);
										$city = json_decode($componentData['remark_city'],true);
										$state = json_decode($componentData['remark_state'],true);
										$pincode = json_decode($componentData['remark_pin_code'],true);
										$in_progress_remark = json_decode($componentData['in_progress_remarks'],true);
										$verification_remarks = json_decode($componentData['verification_remarks'],true);
										$insuff_remarks = json_decode($componentData['insuff_remarks'] ,true);
										$insuff_closure_remarks = json_decode($componentData['insuff_closure_remarks'] ,true);
										$approved_doc = json_decode($componentData['approved_doc'],true);
										$form_values = json_decode($componentData['form_values']);
										$form_values = json_decode($form_values,true);
										$ouputqc_comment = json_decode($componentData['ouputqc_comment'],true);
										$verified_date = json_decode($componentData['verified_date'],true);
										// print_r($form_values['document_check'][$index]);
                    // $dob = json_decode($componentData['dob'],true); 
                    // $code = json_decode($componentData['code'],true); 
                    // $mobile_number = json_decode($componentData['mobile_number'],true); 
                    // echo "<br>";
                    // print_r($pan_card_doc);
                    // echo "pan_card_doc : ".$componentData['pan_number'];
                    $documentNUmber = $form_values['document_check'][$index];
               //      $index = array_search($index,$form_values['document_check']);
			          		// print_r($index);
			            //   $documentNUmber = $form_values['document_check'][$index];
			            //   print_r($documentNUmber);
                    if(count($documentType) > 0){
                    	if ($documentNUmber == '1') { ?>
                    		<div>
			                    <h3 class="permt mt-4">PAN Card Document Details</h3> 
			                    <div class="row mt-4">
					              <div class="col-md-2 lft-p-det">
					               <p>PAN card number</p>
					              </div>
					              <div class="col-md-1 pr-0">
					                 <p>:</p>
					              </div>
					              <div class="col-md-4 ryt-p pl-0">
					                	<p><?php if($componentData['pan_number'] != 'undefined'){echo $componentData['pan_number'];}?></p>
					              </div> 
					            </div>
			                    <div class="row mt-3"> 
		                          	<div class="col-md-6">
			                       		<div class="row mt-2">
			                       			<div class="col-md-3 lft-p-det">
			                       				<p>PAN card</p>
			                       			</div> 
			                       		</div> 
			                       	</div> 
		                      	</div>
		                      	<div class="row mt-3">
		                      		<?php 
		                      		foreach ($pan_card_doc as $key => $value) { 
		                      			$ext = pathinfo($value, PATHINFO_EXTENSION);
		                      			$url = base_url()."../uploads/pan-docs/".$value;
		                      			
		                      			if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){
		                      		?>
		                      		
		                      		<div class="col-md-4">
		                      			<!-- <div class="pg-frm-hd"><?php //echo $documentType[$i]?></div> -->
		                      				<div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">
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
			                      				<div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">
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
		                      				<!-- <div class="row mt-2"> -->
				                       			<div class="col-md-6 lft-p-det">
				                       				<p>No files available.</p>
				                       			</div> 
			                       			<!-- </div>  -->
		                      		<?php 	
		                      			}
		                      		}
		                      		?>	 
		                    </div>
		                  	<hr>
	                    <?php } 

	                   		if ($documentNUmber == '2') { ?>
	                    	<div>
			                    <h3 class="permt mt-4">Adhar Card Document Details</h3>
			                    <div class="row mt-4">
					              <div class="col-md-2 lft-p-det">
					               <p>Adhar card number</p>
					              </div>
					              <div class="col-md-1 pr-0">
					                 <p>:</p>
					              </div>
					              <div class="col-md-4 ryt-p pl-0">
					                 <p><?php if($componentData['aadhar_number'] != 'undefined'){echo $componentData['aadhar_number'];}?></p>
					              </div> 
					            </div>
			                    <div class="row mt-3"> 
		                          	<div class="col-md-6">
			                       		<div class="row mt-2">
			                       			<div class="col-md-3 lft-p-det">
			                       				<p>Document Copy</p>
			                       			</div> 
			                       		</div> 
			                       	</div> 
		                      	</div>
		                      	<div class="row mt-3">
		                      		<?php 
		                      		foreach ($adhar_doc as $key => $value) { 
		                      			$url = base_url()."../uploads/aadhar-docs/".$value;
		                      			$ext = pathinfo($value, PATHINFO_EXTENSION);
		                      			if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){	


		                      		?>
		                      		
		                      			<div class="col-md-4">
		                      			<!-- <div class="pg-frm-hd"><?php //echo $documentType[$i]?></div> -->
		                      				<div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">
		                      					<div class="image-selected-div">
		                      						<ul class="p-0 mb-0">
		                      							<li class="image-selected-name pb-0"><?php echo $value ?></li>
		                      							<li class="image-name-delete pb-0">
		                      								<a id="docs_modal_file" onclick="view_document_modal('<?php echo $url?>')" class="image-name-delete-a">
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
			                      				<div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">
			                      					<div class="image-selected-div">
			                      						<ul class="p-0 mb-0">
			                      							<li class="image-selected-name pb-0"><?php echo $value ?></li>
			                      							<li class="image-name-delete pb-0">
			                      								<a download id="docs_modal_file" href="<?php echo  $url?>" class="image-name-delete-a">
			                      									<i class="fa fa-arrow-down text-primary"></i>
			                      								</a>
			                      								<a target="_blank" id="docs_modal_file" href="<?php echo  $url?>" class="image-name-delete-a">
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
		                      		?>
		                      	<!-- </div> -->
		                    </div>
		                    <hr>
		                     
	                    <?php }


	                     	if ($documentNUmber == '3') { ?>
	                    	<div>
			                    <h3 class="permt mt-4">Passport  Document Details</h3>
			                    <div class="row mt-4">
					              <div class="col-md-2 lft-p-det">
					               <p>Passport number</p>
					              </div>
					              <div class="col-md-1 pr-0">
					                 <p>:</p>
					              </div>
					              <div class="col-md-4 ryt-p pl-0">
					                	<p><?php if($componentData['passport_number'] != 'undefined'){echo $componentData['passport_number'];}?></p>
					              </div> 
					            </div>
			                    <div class="row mt-3"> 
		                          	<div class="col-md-6">
			                       		<div class="row mt-2">
			                       			<div class="col-md-3 lft-p-det">
			                       				<p>Passport</p>
			                       			</div> 
			                       		</div> 
			                       	</div> 
		                      	</div>
		                      	<div class="row mt-3">
		                      		<?php 
		                      		foreach ($passport_doc as $key => $value) { 
		                      			$url = base_url()."../uploads/proof-docs/".$value;
		                      			$ext = pathinfo($value, PATHINFO_EXTENSION);
		                      			if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){

		                      		?>
		                      		
		                      		<div class="col-md-4">
		                      			<!-- <div class="pg-frm-hd"><?php //echo $documentType[$i]?></div> -->
		                      				<div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">
		                      					<div class="image-selected-div">
		                      						<ul class="p-0 mb-0">
		                      							<li class="image-selected-name pb-0"><?php echo $value ?></li>
		                      							<li class="image-name-delete pb-0">
		                      								<a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_document_modal('<?php echo $url?>')" class="image-name-delete-a">
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
			                      				<div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">
			                      					<div class="image-selected-div">
			                      						<ul class="p-0 mb-0">
			                      							<li class="image-selected-name pb-0"><?php echo $value ?></li>
			                      							<li class="image-name-delete pb-0">
			                      								<a download id="docs_modal_file'+data.component_data.candidate_id+'" href="<?php echo  $url?>"  class="image-name-delete-a">
			                      									<i class="fa fa-arrow-down text-primary"></i>
			                      								</a>
			                      									<a target="_blank" id="docs_modal_file'+data.component_data.candidate_id+'" href="<?php echo  $url?>"  class="image-name-delete-a">
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
		                      		?>
		                      	<!-- </div> -->
		                    </div>	

		                    <hr>
	                    <?php }
                    }else{ ?>

                    <?php 
                	} 

                	 // print_r($form_values['document_check'][$index]);
                	?>


                		<?php

	                     	if ($documentNUmber == '4') { ?>
	                    	<div>
			                    <h3 class="permt mt-4">Voter Document Details</h3>
			                    <div class="row mt-4">
					              <div class="col-md-2 lft-p-det">
					               <p>Voter number</p>
					              </div>
					              <div class="col-md-1 pr-0">
					                 <p>:</p>
					              </div>
					              <div class="col-md-4 ryt-p pl-0">
					                	<p><?php if($componentData['voter_id'] != 'undefined'){echo $componentData['voter_id'];}?></p>
					              </div> 
					            </div>
			                    <div class="row mt-3"> 
		                          	<div class="col-md-6">
			                       		<div class="row mt-2">
			                       			<div class="col-md-3 lft-p-det">
			                       				<p>Voter</p>
			                       			</div> 
			                       		</div> 
			                       	</div> 
		                      	</div>
		                      	<div class="row mt-3">
		                      		<?php 
		                      		foreach ($voter_doc as $key => $value) { 
		                      			$url = base_url()."../uploads/voter-docs/".$value;
		                      			$ext = pathinfo($value, PATHINFO_EXTENSION);
		                      			if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){

		                      		?>
		                      		
		                      		<div class="col-md-4">
		                      			<!-- <div class="pg-frm-hd"><?php //echo $documentType[$i]?></div> -->
		                      				<div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">
		                      					<div class="image-selected-div">
		                      						<ul class="p-0 mb-0">
		                      							<li class="image-selected-name pb-0"><?php echo $value ?></li>
		                      							<li class="image-name-delete pb-0">
		                      								<a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_document_modal('<?php echo $url?>')" class="image-name-delete-a">
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
			                      				<div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">
			                      					<div class="image-selected-div">
			                      						<ul class="p-0 mb-0">
			                      							<li class="image-selected-name pb-0"><?php echo $value ?></li>
			                      							<li class="image-name-delete pb-0">
			                      								<a download id="docs_modal_file'+data.component_data.candidate_id+'" href="<?php echo  $url?>"  class="image-name-delete-a">
			                      									<i class="fa fa-arrow-down text-primary"></i>
			                      								</a>
			                      									<a target="_blank" id="docs_modal_file'+data.component_data.candidate_id+'" href="<?php echo  $url?>"  class="image-name-delete-a">
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
		                      		?>
		                      	<!-- </div> -->
		                    </div>	

		                    <hr>
	                    <?php } 


                	 // print_r($form_values['document_check'][$index]);
                	?>
                	

                		<?php

	                     	if ($documentNUmber == '5') { ?>
	                    	<div>
			                    <h3 class="permt mt-4">SSN Card Document Details</h3>
			                    <div class="row mt-4">
					              <div class="col-md-2 lft-p-det">
					               <p>SSN Card number</p>
					              </div>
					              <div class="col-md-1 pr-0">
					                 <p>:</p>
					              </div>
					              <div class="col-md-4 ryt-p pl-0">
					                	<p><?php if($componentData['ssn_number'] != 'undefined'){echo $componentData['ssn_number'];}?></p>
					              </div> 
					            </div>
			                    <div class="row mt-3"> 
		                          	<div class="col-md-6">
			                       		<div class="row mt-2">
			                       			<div class="col-md-3 lft-p-det">
			                       				<p>SSN Card</p>
			                       			</div> 
			                       		</div> 
			                       	</div> 
		                      	</div>
		                      	<div class="row mt-3">
		                      		<?php 
		                      		foreach ($ssn_doc as $key => $value) { 
		                      			$url = base_url()."../uploads/ssn_doc/".$value;
		                      			$ext = pathinfo($value, PATHINFO_EXTENSION);
		                      			if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){

		                      		?>
		                      		
		                      		<div class="col-md-4">
		                      			<!-- <div class="pg-frm-hd"><?php //echo $documentType[$i]?></div> -->
		                      				<div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">
		                      					<div class="image-selected-div">
		                      						<ul class="p-0 mb-0">
		                      							<li class="image-selected-name pb-0"><?php echo $value ?></li>
		                      							<li class="image-name-delete pb-0">
		                      								<a id="docs_modal_file'+data.component_data.candidate_id+'" onclick="view_document_modal('<?php echo $url?>')" class="image-name-delete-a">
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
			                      				<div class="col-md-12 mt-3 pl-0 pr-0" id="file_vendor_documents_0">
			                      					<div class="image-selected-div">
			                      						<ul class="p-0 mb-0">
			                      							<li class="image-selected-name pb-0"><?php echo $value ?></li>
			                      							<li class="image-name-delete pb-0">
			                      								<a download id="docs_modal_file'+data.component_data.candidate_id+'" href="<?php echo  $url?>"  class="image-name-delete-a">
			                      									<i class="fa fa-arrow-down text-primary"></i>
			                      								</a>
			                      									<a target="_blank" id="docs_modal_file'+data.component_data.candidate_id+'" href="<?php echo  $url?>"  class="image-name-delete-a">
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
		                      		?>
		                      	<!-- </div> -->
		                    </div>	

		                    <hr>
	                    <?php } 


                	 // print_r($form_values['document_check'][$index]);
                	?>
                	

                    		<h3 class="permt mt-4">Document Check Verification Details</h3>
		                    <div class="row mt-3"> 
		                        <div class="col-md-6 d-none">
		                          <div class="row mt-2 d-none">
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
		                                rows="3" ><?php echo isset($address[$index]['remark_address'])?$address[$index]['remark_address']:""?></textarea>
		                              <div id="address-error"></div>
		                            </div>
		                          </div>		                          
		                          <div class="row mt-2 d-none">
		                            <div class="col-md-3">
		                              <p class="det">State</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <!-- <input name="state" class="fld form-control state" id="state" value="<?php echo isset($state[$index]['remark_state'])?$state[$index]['remark_state']:""?>" type="text"> -->
		                              <?php //echo "remark_state:=".$state[$index]['remark_state'];?>
		                              <select class="fld form-control state" id="state" onchange="getCitySingle(this.id)">
		                                <?php

		                               		$city_id = '';
		                                  $state = $state[$index]['remark_state'];
		                                  if($state == '' && $stateName == null){
		                                     $state = 'Karnataka';
		                                  } 
		                                  foreach ($states as $keyState => $value) {
		                                    if($state == $value['name']){
		                                      echo '<option data-id="'.$value['id'].'" selected value="'.$value['name'].'">'.$value['name'].'</option>';
		                                      $city_id = $value['id'];
		                                    }else{
		                                      echo '<option data-id="'.$value['id'].'" value="'.$value['name'].'">'.$value['name'].'</option>';
		                                    }
		                                  }
		                                ?> 
                              		</select>
		                              <div id="state-error"></div>
		                            </div>
		                          </div>
		                          <div class="row mt-2 d-none">
		                            <div class="col-md-3">
		                              <p class="det">City</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <!-- <input name="city" value="<?php echo isset($city[$index]['remark_city'])?$city[$index]['remark_city']:""?>" class="fld form-control city" id="city" type="text"> -->
		                              <select class="fld form-control city select2" onchange="valid_city()" id="city">
		                                <?php 
		                                  $get_city = isset($city[$index]['remark_city'])?$city[$index]['remark_city']:''; 
		                                  $cities = $this->componentModel->get_all_cities($city_id);
		                                  foreach ($cities as $key2 => $val) {
		                                     if ($get_city == $val['name']) { 
		                                        echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
		                                     }else{
		                                        echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
		                                     }
		                                  }
		                                ?>
		                              </select>
		                              <div id="city-error"></div>
		                            </div>
		                          </div>
		                          <div class="row mt-2 d-none">
		                            <div class="col-md-3">
		                              <p class="det">Pin-Code</p>
		                            </div>
		                            <div class="col-md-2 pr-0">
		                              <p>:</p>
		                            </div>
		                            <div class="col-md-7">
		                              <input name="pincode" class="fld form-control pincode" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="pincode"  onblur="valid_pincode('pincode')"  onkeyup="valid_pincode('pincode')"  value="<?php echo isset($pincode[$index]['remark_pin_code'])?$pincode[$index]['remark_pin_code']:""?>" type="text">
		                              <div id="pincode-error"></div>
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
                                  <textarea name="insuff_remarks" class="fld form-control insuff_remarks" id="insuff_remarks"><?php echo isset($insuff_remarks[$index]['insuff_remarks'])?$insuff_remarks[$index]['insuff_remarks']:""?></textarea>
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
                                  <textarea name="in_progress_remark" class="fld form-control in_progress_remark" id="in_progress_remark"><?php echo isset($in_progress_remark[$index]['in_progress_remarks'])?$in_progress_remark[$index]['in_progress_remarks']:""?></textarea>
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
                                  <textarea name="verification_remarks" class="fld form-control verification_remark" id="verification_remarks"><?php echo isset($verification_remarks[$index]['verification_remarks'])?$verification_remarks[$index]['verification_remarks']:""?></textarea> 
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
									$verified = isset($verified_date[$index]['verified_date'])?$verified_date[$index]['verified_date']:'';
									if($verified == 'Invalid Date' || $verified == 'Invalid date' || $verified == 'invalid Date'){
									
									$verified ='';

									}

                  $verified = $this->utilModel->get_date($verified);

                                if (strtolower($verified) !='na' && strtolower($verified) !='01-01-1970') {}else{
                                   $verified ='';
                                }
								?>
                              <input name="" class="fld form-control mdate verified_date" value="<?php echo $verified; ?>" id="verified_date<?php echo ""; ?>" type="text">
                              <div id="verified_date-error<?php echo ""; ?>">&nbsp;</div>
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
                                  <textarea name="insuff_closer_remark" class="fld form-control insuff_closer_remark" id="insuff_closer_remark" ><?php echo isset($insuff_closure_remarks[$index]['insuff_closure_remarks'])?$insuff_closure_remarks[$index]['insuff_closure_remarks']:""?></textarea>
		                            </div>
		                          </div>
		                        </div>
		                        <div class="col-md-6">
		                            <div class="add-vendor-bx2">
		                              <h3 class="m-0">&nbsp;</h3>
		                              <ul>
		                                 <li class="vendor-wdt2">
		                                    <p class="lft-p-det">Verification Proof Upload Section</p>
		                                    <div class="form-group mb-0">
		                                      <input type="file" id="client-documents" name="client-documents[]" multiple="multiple">
		                                      <label class="btn upload-btn" for="client-documents">Upload</label>
		                                    </div>
		                                    <div id="client-upoad-docs-error-msg-div"><?php
		                               $aadhar = '';
		                                 if (isset($approved_doc[$index])) {
		                                 if (!in_array('no-file',$approved_doc[$index])) {
		                                   foreach ($approved_doc[$index] as $key => $value) {
		                                   	  if ($value !='') {
		                                   	  	$url = base_url()."../uploads/remarks-docs/".$value;
		                                     		echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a> <a href='{$url}' download >  <i class='fa fa-download'></i></a> </span></div>";
		                                 		}
		                                   }
		                                 $aadhar = $approved_doc[$index];
		                                 }} 
		                                 ?></div>
		                                 </li> 
		                              </ul>
		                              <div class="row" id="selected-vendor-docs-li"></div>
		                           </div>
		                          </div>
		                    </div>  
                   
                  <div class="row mt-2">
                    <div class="col-md-6"> 

                      
                      <?php
                      	$analyst_status = explode(",", $componentData['analyst_status']);
                        $analyst_status = isset($analyst_status[$index])?$analyst_status[$index]:'';

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
                         
                        // echo 'remarks_updateed_by_role:'.$remarks_updateed_by_role .': analyst_status: '. $analyst_status;

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
                        <option class="text-capitalize" <?php echo $insuffStatus ?> value="3">Insufficiency</option>
                        <?php 
                          if($userRole != 'insuff analyst'){  ?>
                            <option class="text-capitalize" <?php echo $verifiedclearStatus ?> value="4">Verified Clear</option>
                            <option class="text-capitalize" <?php echo $stopcheckStatus ?> value="5">Stop Check</option> 
                            <option class="text-capitalize" <?php echo $utv ?> value="6">Unable to Verify</option> 
                            <option class="text-capitalize" <?php echo $vd ?> value="7">Verified Discrepancy</option> 
                            <option class="text-capitalize" <?php echo $cc ?> value="8">Client Clarification</option> 
                            <option class="text-capitalize" <?php echo $ci ?> value="9">Closed Insufficiency</option>
                        <?php } else { ?>
                             <option class="text-capitalize" <?php echo $ni ?> value="11">Not Insufficient</option>
                        <?php }
                        
                          if($analyst_status == '10'){
                            echo '<option selected value="10">QC Error</option>';
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
                          rows="3" ><?php echo isset($ouputqc_comment[$index]['ouputQcComment'])?$ouputqc_comment[$index]['ouputQcComment']:'' ?></textarea>
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
        <button class="btn bg-blu text-white" data-dismiss="modal" id="doc-cancle">Close</button>
        <button class="btn bg-blu float-right text-white" id="submit-doc-data">Confirm</button>
        <div class="clr">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- View Images -->
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

 

<?php
  include APPPATH.'views/analyst/assigned-case/component-pages/view_image_model.php';
?>

<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/remark-documentcheck.js"></script> 

<script src="<?php echo base_url() ?>assets/custom-js/analyst/remarks/commonImageView.js"></script>s
<script>
 // load_case(<?php //echo $candidate_id;?>);
// function view_document_modal(url){ 
//     // var image = $('#docs_modal_file'+documentName).data('view_docs');
//     $('#view-image').attr("src",url);

//     let html = '';
     
//     html += '<a download class="btn bg-blu text-white" href="'+url+'">'
//     html += '<i class="fa fa-download" aria-hidden="true"> Dwonload Document</i>'
//     html += '</a>';

//     $('#setupDownloadBtn').html(html)
//     $('#view_image_modal').modal('show');
// }

</script>

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