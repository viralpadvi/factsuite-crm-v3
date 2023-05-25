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
<input type="hidden" value="<?php echo $componentData['candidate_id']?>" id="candidate_id_hidden"name="">
  <input type="hidden" value="<?php echo $userID?> " id="userID" name="userID">
  <input type="hidden" value="<?php echo $userRole ?>" id="userRole" name="userRole">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
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
                    // print_r($componentData['documentType']);
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
                    // $dob = json_decode($componentData['dob'],true); 
                    // $code = json_decode($componentData['code'],true); 
                    // $mobile_number = json_decode($componentData['mobile_number'],true); 
                    // echo "<br>";
                    // print_r($address[0]['remarks_address']);
                    // echo "pan_card_doc : ".$componentData['pan_number'];
                    $analyst_status=  explode(',',$componentData['analyst_status']);
                    $output_status=  explode(',',$componentData['output_status']);
                    $ouputQcComment = json_decode($componentData['ouputqc_comment'],true);
                    // $ouputQcComment = json_encode($ouputQcComment,true);
                    //  echo "<br>";
                    // print_r($ouputQcComment);
                    if(count($documentType) > 0){
                    	if (in_array('PAN Card', $documentType)) {
                    	$index =	array_search('PAN Card', $documentType);
                    	 ?>
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
		                      	<!-- </div> -->
		                    </div>
		                    <?php 
		                    	$positionPAN = array_search('PAN Card', $documentType);
		                    ?>
		                   <h3 class="permt mt-4">Document check Remark Verification Details</h3>
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
		                                id="pan-address"  
		                                rows="3" ><?php echo isset($address[$positionPAN]['remarks_address'])?$address[$positionPAN]['remarks_address']:""?></textarea>
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
		                              <input name="city" value="<?php echo isset($city[$positionPAN]['remarks_city'])?$city[$positionPAN]['remarks_city']:""?>" class="fld form-control city" id="pan-city" type="text">
		                              <div id="pan-city-error"></div>
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
		                              <input name="state" class="fld form-control state" id="pan-state" value="<?php echo isset($state[$positionPAN]['remarks_state'])?$state[$positionPAN]['remarks_state']:""?>" type="text">
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
		                              <input name="pincode" class="fld form-control pincode" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="pan-pincode" onblur="valid_pincode('pan-pincode')"  onkeyup="valid_pincode('pan-pincode')" value="<?php echo isset($pincode[$positionPAN]['remarks_pincode'])?$pincode[$positionPAN]['remarks_pincode']:""?>" type="text">
		                              <div id="pan-pincode-error"></div>
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
		                                    <p class="lft-p-det">Verification Pan Upload Section</p>
		                                    <div class="form-group mb-0 d-none">
		                                      <input type="file" id="pan-client-documents" name="client-documents[]" multiple="multiple">
		                                      <label class="btn upload-btn" for="pan-client-documents">Upload</label>
		                                    </div>
		                                    <div id="pan-client-upoad-docs-error-msg-div"><?php
		                               $pan_card_doc = '';
		                                 if (isset($approved_doc[$positionPAN])) {
		                                 if (!in_array('no-file', $approved_doc[$positionPAN])) {
		                                   foreach ($approved_doc[$positionPAN] as $key => $value) {
		                                   	  if ($value !='') {
		                                   	  	$url = base_url()."../uploads/remarks-docs/".$value;
		                                     // echo "<div><span>{$value}</span><a onclick='view_document_modal('".$url.")' >  <i class='fa fa-eye'></i></a></span></div>";

		                                   	  	?>

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

		                                   	  	<?php 

		                                 }
		                                   }
		                                 $pan_card_doc = $value;
		                                 }} 
		                                 ?></div>
		                                 </li> 
		                              </ul>
		                              <div class="row" id="pan-selected-vendor-docs-li"></div>
		                           </div>
		                          </div> 
		                    </div>  
		                   	<div class="row mt-2">
				                    <div class="col-md-6">
				                      <?php
				                        $analystStatus = '';
				                         $disabled = '';
				                        $an_status = isset($analyst_status[$positionPAN])?$analyst_status[$positionPAN]:'0';
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
				                          if($output_status[$positionPAN] == 1){
				                            $approveOpStatus = 'selected';
				                          }else if($output_status[$positionPAN] == 2){
				                            $rejectOpStatus = 'selected';
				                          }else {
				                            $defaultOpStatus = 'selected'; 
				                          }
				                      ?>
				                      <select id="op_action_status" <?php echo $disabled; ?> name="carlist" class="sel-allcase op_action_status">
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
				                        rows="3" ><?php echo isset($ouputQcComment[0]['ouputQcComment'])?$ouputQcComment[0]['ouputQcComment']:'' ?></textarea>
				                      <div id="address-error"></div>
				                    </div>
			                </div>
		                    
		                    <hr>


	                    <?php } 

	                    if (in_array('Aadhar Card', $documentType)) { ?>
	                    	<div>
			                    <h3 class="permt mt-4">Aadhar Card Document Details</h3>
			                    <div class="row mt-4">
					              <div class="col-md-2 lft-p-det">
					               <p>Aadhar Card number</p>
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
			                       				<p>Aadhar Card</p>
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
				                       			<div class="col-md-3 lft-p-det">
				                       				<p>No files available.</p>
				                       			</div> 
			                       			<!-- </div>  -->
		                      		<?php 	
		                      			}
		                      		}
		                      		?>
		                      	<!-- </div> -->
		                    </div>
		                    <?php 
		                    	$positionAdhar = array_search('Aadhar Card', $documentType);
		                    ?>
		                    <h3 class="permt mt-4">Document check Remark Verification Details</h3>
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
		                                id="aadhar-address"  
		                                rows="3" ><?php echo isset($address[$positionAdhar]['remarks_address'])?$address[$positionAdhar]['remarks_address']:""?></textarea>
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
		                              <input name="city" value="<?php echo isset($city[$positionAdhar]['remarks_city'])?$city[$positionAdhar]['remarks_city']:""?>" class="fld form-control city" id="aadhar-city" type="text">
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
		                              <input name="state" class="fld form-control state" id="aadhar-state" value="<?php echo isset($state[$positionAdhar]['remarks_state'])?$state[$positionAdhar]['remarks_state']:""?>" type="text">
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
		                              <input name="pincode" class="fld form-control pincode" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="aadhar-pincode"  onblur="valid_pincode('aadhar-pincode')"  onkeyup="valid_pincode('aadhar-pincode')"  value="<?php echo isset($pincode[$positionAdhar]['remarks_pincode'])?$pincode[$positionAdhar]['remarks_pincode']:""?>" type="text">
		                              <div id="aadhar-pincode-error"></div>
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
		                              <input name="insuff_remarks" class="fld form-control insuff_remarks" id="aadhar-insuff_remarks" value="<?php echo isset($insuff_remarks[$positionAdhar]['insuff_remarks'])?$insuff_remarks[$positionAdhar]['insuff_remarks']:""?>" type="text">
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
		                              <input name="in_progress_remark" class="fld form-control in_progress_remark" id="aadhar-in_progress_remark" value="<?php echo isset($in_progress_remark[$positionAdhar]['in_progress_remarks'])?$in_progress_remark[$positionAdhar]['in_progress_remarks']:""?>" type="text">
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
		                              <input name="verification_remarks" class="fld form-control verification_remarks" id="aadhar-verification_remarks" value="<?php echo isset($verification_remarks[$positionAdhar]['verification_remarks'])?$verification_remarks[$positionAdhar]['verification_remarks']:""?>" type="text">
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
		                              <input name="insuff_closer_remark" class="fld form-control insuff_closer_remark" id="aadhar-insuff_closer_remark"value="<?php echo isset($insuff_closure_remarks[$positionAdhar]['insuff_closure_remarks'])?$insuff_closure_remarks[$positionAdhar]['insuff_closure_remarks']:""?>" type="text">
		                            </div>
		                          </div>
		                        </div>

		                        <div class="col-md-6">
		                            <div class="add-vendor-bx2">
		                              <h3 class="m-0">&nbsp;</h3>
		                              <ul>
		                                 <li class="vendor-wdt2">
		                                    <p class="lft-p-det">Verification Aadhar Upload Section</p>
		                                    <div class="form-group mb-0 d-none">
		                                      <input type="file" id="aadhar-client-documents" name="client-documents[]" multiple="multiple">
		                                      <label class="btn upload-btn" for="aadhar-client-documents">Upload</label>
		                                    </div>
		                                    <div id="aadhar-client-upoad-docs-error-msg-div"><?php
		                               $aadhar = '';
		                                 if (isset($approved_doc[$positionAdhar])) {
		                                 if (!in_array('no-file', $approved_doc[$positionAdhar])) {
		                                   foreach ($approved_doc[$positionAdhar] as $key => $value) {
		                                   	  if ($value !='') {
		                                   	  	$url = base_url()."../uploads/remarks-docs/".$value;
		                                     // echo "<div><span>{$value}</span><a onclick='exist_view_image(\"{$value}\",\"remarks-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
		                                   	  	?>
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

		                      				<?php
		                                 		}
		                                   }
		                                 $aadhar = $approved_doc[$positionAdhar];
		                                 }} 
		                                 ?></div>
		                                 </li> 
		                              </ul>
		                              <div class="row" id="aadhar-selected-vendor-docs-li"></div>
		                           </div>
		                          </div>

		                    </div>  
		                   	<div class="row mt-2">
				                    <div class="col-md-6">
				                      <?php
				                        $analystStatus = '';
				                         $disabled = '';
				                        $an_status = isset($analyst_status[$positionAdhar])?$analyst_status[$positionAdhar]:'0';
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
				                          $analystStatus = '<span class="text-danger">Closed insufficiency<span>';
				                           $disabled = 'disabled';
				                        }else if($an_status == 10){
				                          $analystStatus = '<span class="text-danger">Qc Error<span>';
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
				                          if($output_status[$positionAdhar] == 1){
				                            $approveOpStatus = 'selected';
				                          }else if($output_status[$positionAdhar] == 2){
				                            $rejectOpStatus = 'selected';
				                          }else {
				                            $defaultOpStatus = 'selected'; 
				                          }
				                      ?>
				                      <select id="op_action_status" <?php echo $disabled; ?> name="carlist" class="sel-allcase op_action_status">
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
				                        rows="3" ><?php echo isset($ouputQcComment[1]['ouputQcComment'])?$ouputQcComment[1]['ouputQcComment']:'' ?></textarea>
				                      <div id="address-error"></div>
				                    </div>
			                </div>
		                     
		                    <hr>
	                    <?php }

	                     if (in_array('Passport', $documentType)) { ?>
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
		                    <?php 
		                    	$position = array_search('Passport', $documentType)
		                    ?>
		                    <h3 class="permt mt-4">Document check Remark Verification Details</h3>
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
		                                rows="3" ><?php echo isset($address[$position]['remarks_address'])?$address[$position]['remarks_address']:""?></textarea>
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
		                              <input name="city" value="<?php echo isset($city[$position]['remarks_city'])?$city[$position]['remarks_city']:""?>" class="fld form-control city" id="city" type="text">
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
		                              <input name="state" class="fld form-control state" id="state" value="<?php echo isset($state[$position]['remarks_state'])?$state[$position]['remarks_state']:""?>" type="text">
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
		                              <input name="pincode" class="fld form-control pincode" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="pincode"  onblur="valid_pincode('pincode')"  onkeyup="valid_pincode('pincode')"  value="<?php echo isset($pincode[$position]['remarks_pincode'])?$pincode[$position]['remarks_pincode']:""?>" type="text">
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
		                              <input name="insuff_remarks" class="fld form-control insuff_remarks" id="insuff_remarks" value="<?php echo isset($insuff_remarks[$position]['insuff_remarks'])?$insuff_remarks[$position]['insuff_remarks']:""?>" type="text">
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
		                              <input name="in_progress_remark" class="fld form-control in_progress_remark" id="in_progress_remark" value="<?php echo isset($in_progress_remark[$position]['in_progress_remarks'])?$in_progress_remark[$position]['in_progress_remarks']:""; ?>" type="text">
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
		                              <input name="verification_remarks" class="fld form-control verification_remarks" id="verification_remarks" value="<?php echo isset($verification_remarks[$position]['verification_remarks'])?$verification_remarks[$position]['verification_remarks']:""?>" type="text">
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
		                              <input name="insuff_closer_remark" class="fld form-control insuff_closer_remark" id="insuff_closer_remark"value="<?php echo isset($insuff_closure_remarks[$position]['insuff_closure_remarks'])?$insuff_closure_remarks[$position]['insuff_closure_remarks']:""?>" type="text">
		                            </div>
		                          </div>
		                        </div>
		                        <div class="col-md-6 ">
		                            <div class="add-vendor-bx2">
		                              <h3 class="m-0">&nbsp;</h3>
		                              <ul>
		                                 <li class="vendor-wdt2">
		                                    <p class="lft-p-det">Verification Proof Upload Section</p>
		                                    <div class="form-group mb-0 d-none">
		                                      <input type="file" id="client-documents" name="client-documents[]" multiple="multiple">
		                                      <label class="btn upload-btn" for="client-documents">Upload</label>
		                                    </div>
		                                    <div id="client-upoad-docs-error-msg-div"><?php
		                               $aadhar = '';
		                                 if (isset($approved_doc[$position])) {
		                                 if (!in_array('no-file', $approved_doc[$position])) {
		                                   foreach ($approved_doc[$position] as $key => $value) {
		                                   	  if ($value !='') {
		                                     		$url = base_url()."../uploads/remarks-docs/".$value;
		                                     		// echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a></span></div>";
		                                     		?>
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
		                                     		<?php 
		                                 		}
		                                   }
		                                 $aadhar = $approved_doc[$position];
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
				                        $analystStatus = '';
				                         $disabled = '';
				                        $an_status = isset($analyst_status[$position])?$analyst_status[$position]:'0';
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
				                          $analystStatus = '<span class="text-danger">Closed insufficiency<span>';
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
				                          if (isset($output_status[$position])) {
				                          	 
				                          if($output_status[$position] == 1){
				                            $approveOpStatus = 'selected';
				                          }else if($output_status[$position] == 2){
				                            $rejectOpStatus = 'selected';
				                          }else {
				                            $defaultOpStatus = 'selected'; 
				                          }
				                          }else{
				                          	$defaultOpStatus = 'selected'; 
				                          }
				                      ?>
				                      <select id="op_action_status" <?php echo $disabled; ?> name="carlist" class="sel-allcase op_action_status">
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
				                        rows="3" ><?php echo isset($ouputQcComment[2]['ouputQcComment'])?$ouputQcComment[2]['ouputQcComment']:'' ?></textarea>
				                      <div id="address-error"></div>
				                    </div>
			                </div>
		                    
		                    <hr>
	                    <?php }
                    }else{ ?>

                    <?php 
                	} 
                	?>
                    
                   

                   <!-- voter -->

                   <?php

	                     if (in_array('Voter ID', $documentType)) { ?>
	                    	<div>
			                    <h3 class="permt mt-4">Voter ID Document Details</h3>
			                    <div class="row mt-4">
					              <div class="col-md-2 lft-p-det">
					               <p>Voter ID number</p>
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
			                       				<p>Voter ID</p>
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
		                    <?php 
		                    	$position = array_search('Voter ID', $documentType)
		                    ?>
		                    <h3 class="permt mt-4">Document check Remark Verification Details</h3>
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
		                                rows="3" ><?php echo isset($address[$position]['remarks_address'])?$address[$position]['remarks_address']:""?></textarea>
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
		                              <input name="city" value="<?php echo isset($city[$position]['remarks_city'])?$city[$position]['remarks_city']:""?>" class="fld form-control city" id="city" type="text">
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
		                              <input name="state" class="fld form-control state" id="state" value="<?php echo isset($state[$position]['remarks_state'])?$state[$position]['remarks_state']:""?>" type="text">
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
		                              <input name="pincode" class="fld form-control pincode" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="pincode"  onblur="valid_pincode('pincode')"  onkeyup="valid_pincode('pincode')"  value="<?php echo isset($pincode[$position]['remarks_pincode'])?$pincode[$position]['remarks_pincode']:""?>" type="text">
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
		                              <input name="insuff_remarks" class="fld form-control insuff_remarks" id="insuff_remarks" value="<?php echo isset($insuff_remarks[$position]['insuff_remarks'])?$insuff_remarks[$position]['insuff_remarks']:""?>" type="text">
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
		                              <input name="in_progress_remark" class="fld form-control in_progress_remark" id="in_progress_remark" value="<?php echo isset($in_progress_remark[$position]['in_progress_remarks'])?$in_progress_remark[$position]['in_progress_remarks']:""; ?>" type="text">
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
		                              <input name="verification_remarks" class="fld form-control verification_remarks" id="verification_remarks" value="<?php echo isset($verification_remarks[$position]['verification_remarks'])?$verification_remarks[$position]['verification_remarks']:""?>" type="text">
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
		                              <input name="insuff_closer_remark" class="fld form-control insuff_closer_remark" id="insuff_closer_remark"value="<?php echo isset($insuff_closure_remarks[$position]['insuff_closure_remarks'])?$insuff_closure_remarks[$position]['insuff_closure_remarks']:""?>" type="text">
		                            </div>
		                          </div>
		                        </div>
		                        <div class="col-md-6 ">
		                            <div class="add-vendor-bx2">
		                              <h3 class="m-0">&nbsp;</h3>
		                              <ul>
		                                 <li class="vendor-wdt2">
		                                    <p class="lft-p-det">Verification Proof Upload Section</p>
		                                    <div class="form-group mb-0 d-none">
		                                      <input type="file" id="client-documents" name="client-documents[]" multiple="multiple">
		                                      <label class="btn upload-btn" for="client-documents">Upload</label>
		                                    </div>
		                                    <div id="client-upoad-docs-error-msg-div"><?php
		                               $aadhar = '';
		                                 if (isset($approved_doc[$position])) {
		                                 if (!in_array('no-file', $approved_doc[$position])) {
		                                   foreach ($approved_doc[$position] as $key => $value) {
		                                   	  if ($value !='') {
		                                     		$url = base_url()."../uploads/remarks-docs/".$value;
		                                     		// echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a></span></div>";
		                                     		?>
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
		                                     		<?php 
		                                 		}
		                                   }
		                                 $aadhar = $approved_doc[$position];
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
				                        $analystStatus = '';
				                         $disabled = '';
				                        $an_status = isset($analyst_status[$position])?$analyst_status[$position]:'0';
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
				                          $analystStatus = '<span class="text-danger">Closed insufficiency<span>';
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
				                          if (isset($output_status[$position])) {
				                          	 
				                          if($output_status[$position] == 1){
				                            $approveOpStatus = 'selected';
				                          }else if($output_status[$position] == 2){
				                            $rejectOpStatus = 'selected';
				                          }else {
				                            $defaultOpStatus = 'selected'; 
				                          }
				                          }else{
				                          	$defaultOpStatus = 'selected'; 
				                          }
				                      ?>
				                      <select id="op_action_status" <?php echo $disabled; ?> name="carlist" class="sel-allcase op_action_status">
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
				                        rows="3" ><?php echo isset($ouputQcComment[2]['ouputQcComment'])?$ouputQcComment[2]['ouputQcComment']:'' ?></textarea>
				                      <div id="address-error"></div>
				                    </div>
			                </div>
		                    
		                    <hr>
	                    <?php }
                    
                	?>
                    
                   





                   <!-- voter -->

                   <?php

	                     if (in_array('SSN', $documentType)) { ?>
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
			                       				<p>Voter ID</p>
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
		                    <?php 
		                    	$position = array_search('SSN', $documentType)
		                    ?>
		                    <h3 class="permt mt-4">Document check Remark Verification Details</h3>
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
		                                rows="3" ><?php echo isset($address[$position]['remarks_address'])?$address[$position]['remarks_address']:""?></textarea>
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
		                              <input name="city" value="<?php echo isset($city[$position]['remarks_city'])?$city[$position]['remarks_city']:""?>" class="fld form-control city" id="city" type="text">
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
		                              <input name="state" class="fld form-control state" id="state" value="<?php echo isset($state[$position]['remarks_state'])?$state[$position]['remarks_state']:""?>" type="text">
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
		                              <input name="pincode" class="fld form-control pincode" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="pincode"  onblur="valid_pincode('pincode')"  onkeyup="valid_pincode('pincode')"  value="<?php echo isset($pincode[$position]['remarks_pincode'])?$pincode[$position]['remarks_pincode']:""?>" type="text">
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
		                              <input name="insuff_remarks" class="fld form-control insuff_remarks" id="insuff_remarks" value="<?php echo isset($insuff_remarks[$position]['insuff_remarks'])?$insuff_remarks[$position]['insuff_remarks']:""?>" type="text">
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
		                              <input name="in_progress_remark" class="fld form-control in_progress_remark" id="in_progress_remark" value="<?php echo isset($in_progress_remark[$position]['in_progress_remarks'])?$in_progress_remark[$position]['in_progress_remarks']:""; ?>" type="text">
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
		                              <input name="verification_remarks" class="fld form-control verification_remarks" id="verification_remarks" value="<?php echo isset($verification_remarks[$position]['verification_remarks'])?$verification_remarks[$position]['verification_remarks']:""?>" type="text">
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
		                              <input name="insuff_closer_remark" class="fld form-control insuff_closer_remark" id="insuff_closer_remark"value="<?php echo isset($insuff_closure_remarks[$position]['insuff_closure_remarks'])?$insuff_closure_remarks[$position]['insuff_closure_remarks']:""?>" type="text">
		                            </div>
		                          </div>
		                        </div>
		                        <div class="col-md-6 ">
		                            <div class="add-vendor-bx2">
		                              <h3 class="m-0">&nbsp;</h3>
		                              <ul>
		                                 <li class="vendor-wdt2">
		                                    <p class="lft-p-det">Verification Proof Upload Section</p>
		                                    <div class="form-group mb-0 d-none">
		                                      <input type="file" id="client-documents" name="client-documents[]" multiple="multiple">
		                                      <label class="btn upload-btn" for="client-documents">Upload</label>
		                                    </div>
		                                    <div id="client-upoad-docs-error-msg-div"><?php
		                               $aadhar = '';
		                                 if (isset($approved_doc[$position])) {
		                                 if (!in_array('no-file', $approved_doc[$position])) {
		                                   foreach ($approved_doc[$position] as $key => $value) {
		                                   	  if ($value !='') {
		                                     		$url = base_url()."../uploads/remarks-docs/".$value;
		                                     		// echo "<div class='image-selected-div'><span>{$value}</span><a onclick='view_document_modal(\"{$url}\")' >  <i class='fa fa-eye'></i></a></span></div>";
		                                     		?>
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
		                                     		<?php 
		                                 		}
		                                   }
		                                 $aadhar = $approved_doc[$position];
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
				                        $analystStatus = '';
				                         $disabled = '';
				                        $an_status = isset($analyst_status[$position])?$analyst_status[$position]:'0';
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
				                          $analystStatus = '<span class="text-danger">Closed insufficiency<span>';
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
				                          if (isset($output_status[$position])) {
				                          	 
				                          if($output_status[$position] == 1){
				                            $approveOpStatus = 'selected';
				                          }else if($output_status[$position] == 2){
				                            $rejectOpStatus = 'selected';
				                          }else {
				                            $defaultOpStatus = 'selected'; 
				                          }
				                          }else{
				                          	$defaultOpStatus = 'selected'; 
				                          }
				                      ?>
				                      <select id="op_action_status" <?php echo $disabled; ?> name="carlist" class="sel-allcase op_action_status">
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
				                        rows="3" ><?php echo isset($ouputQcComment[2]['ouputQcComment'])?$ouputQcComment[2]['ouputQcComment']:'' ?></textarea>
				                      <div id="address-error"></div>
				                    </div>
			                </div>
		                    
		                    <hr>
	                    <?php }
                    
                	?>
                    

                  <!-- <div class="row mt-2">
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
                  </div> -->
                </div>
                <!-- <hr> -->
                  <div class="row mt-2">
                    <div class="col-md-6">
                      
                    </div>
                    <div class="col-md-6 text-right">
                      <input type="hidden" value="<?php echo $candidateId?>" id="candidate_id_hidden" name="">
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

<script src="<?php echo base_url() ?>assets/custom-js/outputqc/remarks/remark-documentcheck.js"></script> 
<script>
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

</script>