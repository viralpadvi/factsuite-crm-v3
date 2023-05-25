<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-address';
   }
</script> 
	<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
			<div class="row content-div-content-row-1">
				<div class="col-12"><span class="input-main-hdr">House/Flat No. *</span></div> 
			</div>
			<div class="row content-div-content-row">
				  <input name="" class="fld form-control" value="<?php echo isset($table['permanent_address']['permanent_address_id'])?$table['permanent_address']['permanent_address_id']:''; ?>" id="permanent_address_id" type="hidden">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field " value="<?php echo isset($table['permanent_address']['flat_no'])?$table['permanent_address']['flat_no']:''; ?>" id="permenent-house-flat" type="text" required>
            		
		               <span class="input-field-txt">House/Flat No</span>
           				 <div id="permenent-house-flat-error"></div> 
		            </div>
				</div>
				 
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Street/Road *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field" value="<?php echo isset($table['permanent_address']['street'])?$table['permanent_address']['street']:''; ?>" id="permenent-street" type="text" required>
		                <span class="input-field-txt">Street/Road </span>
           				 <div id="permenent-street-error"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Area *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field" value="<?php echo isset($table['permanent_address']['area'])?$table['permanent_address']['area']:''; ?>" id="permenent-area" type="text" required>
		                <span class="input-field-txt">Area</span>
           				 <div id="permenent-area-error"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Pin Code  *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field" id="permenent-pincode" value="<?php echo isset($table['permanent_address']['pin_code'])?$table['permanent_address']['pin_code']:''; ?>" type="text">
		                <span class="input-field-txt">Pin Code</span>
		                <div id="permenent-pincode-error"></div>
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Nearest Landmark *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input type="text" class="sign-in-input-field" value="<?php echo isset($table['permanent_address']['nearest_landmark'])?$table['permanent_address']['nearest_landmark']:''; ?>" id="permenent-land-mark" type="text" required>
		                <span class="input-field-txt">Nearest Landmark</span>
		                <div id="permenent-land-mark-error"></div>
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Country*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap"> 
		                <select class="sign-in-input-field country" id="country" required>
		               <option selected value=''>Select Country</option>
		               <?php // $get_country = isset($table['permanent_address']['country'])?$table['permanent_address']['country']:'India';
		               $get_country = isset($table['permanent_address']['country'])?$table['permanent_address']['country']:'';
		               $c_id = '';
		               foreach ($country as $key1 => $val) {
		                  if ($get_country == $val['name']) {
		                     $c_id = $val['id'];
		                     echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
		                  } else {
		                     echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
		                  }
		               } ?>
		            </select> 
		                <span class="input-field-txt">Country</span>
		                <div id="country-error"></div>
		            </div>
				</div>
			</div>
			  
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">State *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <?php if ($c_id != '') {
               $state = $this->candidateModel->get_all_states($c_id);  
               }
               $city_id ='';
            ?>
            <select class="sign-in-input-field state" id="state" required>
               <option selected value=''>Select State</option>
               <?php $get_state = isset($table['permanent_address']['state'])?$table['permanent_address']['state']:'';
               $get = isset($table['permanent_address']['state'])?$table['permanent_address']['state']:'';
               foreach ($state as $key1 => $val) {
                  if ($get_state == $val['name']) {
                     $city_id = $val['id'];
                     echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                  } else {
                     if ($get == $val['name']) {
                        $city_id = $val['id'];
                     }
                     echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                  }
               } ?>
            </select> 
		                <span class="input-field-txt">State</span>
            			<div id="permenent-state-error"></div> 
		            </div>
				</div>
			</div>

			<!--  -->
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">City/Town *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <select class="sign-in-input-field permenent-city select2" id="permenent-city" required>
			               <option selected value=''>Select City/Town</option>
			               <?php $get_city = isset($table['permanent_address']['city'])?$table['permanent_address']['city']:'';
			                if ($get_city !='') { 
			               $cities = $this->candidateModel->get_all_cities($city_id);
			               foreach ($cities as $key2 => $val) {
			                  if ($get_city == $val['name']) { 
			                     echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
			                  } else {
			                     echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
			                  }}
			               } ?>
			            </select> 
		                <span class="input-field-txt">City/Town</span>
            			<div id="permenent-city-error"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Joining Date *</span></div> 
				 <?php
               $exploded_from_date = isset($table['permanent_address']['duration_of_stay_start'])?explode('-',$table['permanent_address']['duration_of_stay_start']):'';
            ?>
			</div>
			<div class="row content-div-content-row">
				<div class="col-6">
					<div class="input-wrap">
		                <select class="sign-in-input-field select2" id="duration-of-stay-from-month" required>
                     <option selected value=''>Select Month</option>
                     <?php 
                     $months = $this->config->item('month_names');
                     $num = 0;
                     for ($i = 1; $i < $this->config->item('duration_of_stay_end_month'); $i++) {
                        $selected = '';
                        if ($exploded_from_date != '') {
                           if ($exploded_from_date[1] == $i) {
                              $selected = 'selected';
                           }
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $i;?>"><?php echo $months[$num];?></option>
                     <?php $num++; } ?>
                  </select> 
		                <span class="input-field-txt">Select Month</span>
            			<div id="duration-of-stay-from-month-error"></div> 
		            </div>
				</div>
				<div class="col-6">
					<div class="input-wrap">
						<select class="sign-in-input-field select2" id="duration-of-stay-from-year" required>
                     <option selected value=''>Select Year</option>
                     <?php for($i = $this->config->item('current_year'); $i >= $this->config->item('duration_of_stay_start_year'); $i--) {
                        $selected = '';
                        if ($exploded_from_date[0] == $i) {
                           $selected = 'selected';
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $i;?>"><?php echo $i;?></option>
                     <?php } ?>
                  </select> 
                  <span class="input-field-txt">Year</span>
                  <div id="duration-of-stay-from-year-error"></div>
					</div>
				</div>

			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">To *</span></div>
				 <?php
               $exploded_to_date = isset($table['permanent_address']['duration_of_stay_end'])?explode('-',$table['permanent_address']['duration_of_stay_end']):'';
            ?>
			</div>
			<div class="row content-div-content-row">
				<div class="col-6">
					<div class="input-wrap">
		                <select class="sign-in-input-field select2" id="duration-of-stay-to-month" required>
                     <option selected value=''>Select Month</option>
                     <?php 
                     $num = 0;
                     for ($i = 1; $i < $this->config->item('duration_of_stay_end_month'); $i++) {
                        $selected = '';
                        if ($exploded_to_date != '') {
                           if ($exploded_to_date[1] == $i) {
                              $selected = 'selected';
                           }
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $i;?>"><?php echo $months[$num];?></option>
                     <?php $num++; } ?>
                  </select> 
		                <span class="input-field-txt">Month</span>
                  <div id="duration-of-stay-to-month-error"></div> 
		            </div>
				</div>

				<div class="col-6">
					<div class="input-wrap">
		                <select class="sign-in-input-field select2" id="duration-of-stay-to-year" required>
                     <option selected value=''>Select year</option>
                     <?php for($i = $this->config->item('current_year'); $i >= $this->config->item('duration_of_stay_start_year'); $i--) {
                        $selected = '';
                        if ($exploded_to_date[0] == $i) {
                           $selected = 'selected';
                        }
                     ?>
                        <option <?php echo $selected;?> value="<?php echo $i;?>"><?php echo $i;?></option>
                     <?php } ?>
                  </select> 
		                <span class="input-field-txt">Year</span>
            			<div id="duration-of-stay-to-year-error"></div>
		            </div>
				</div>

			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Contact Person Name *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field" id="permenent-name" value="<?php echo isset($table['permanent_address']['contact_person_name'])?$table['permanent_address']['contact_person_name']:''; ?>" type="text" required>
		                <span class="input-field-txt">Enter Contact Person Name</span>
            			<div id="permenent-name-error"></div> 
		            </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Relationship *</span></div>
				<?php
            $Self = '';
            $Parent = '';
            $Spouse = '';
            $Friend = '';
            $Relative = '';
            $House_Owner = '';
            $Neighbor = '';
            $Security_Guard = '';
            $Landlord = '';
            $Cousin = '';
            if (isset($table['permanent_address']['contact_person_relationship'])) {
               if ($table['permanent_address']['contact_person_relationship']=='Self') {
                  $Self = 'selected';
               } else if ($table['permanent_address']['contact_person_relationship']=='Parent') {
                  $Parent = 'selected';
               } else if ($table['permanent_address']['contact_person_relationship']=='Spouse') {
                  $Spouse = 'selected';
               } else if ($table['permanent_address']['contact_person_relationship']=='Friend') {
                  $Friend = 'selected';
               } else if ($table['permanent_address']['contact_person_relationship']=='Relative') {
                  $Relative = 'selected';
               } else if ($table['permanent_address']['contact_person_relationship']=='Neighbor') {
                  $Neighbor = 'selected';
               } else if ($table['permanent_address']['contact_person_relationship']=='Security Guard') {
                  $Security_Guard = 'selected';
               } else if ($table['permanent_address']['contact_person_relationship']=='Landlord') {
                  $Landlord = 'selected';
               } else if ($table['permanent_address']['contact_person_relationship']=='House Owner') {
                  $House_Owner = 'selected';
               } else if ($table['permanent_address']['contact_person_relationship']=='Cousin') {
                  $Cousin = 'selected';
               }
            } ?>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		                <select name="" class="sign-in-input-field" id="relationship" required>
			               <option value="">Select Relationship</option>
			               <option <?php echo $Self; ?> value="Self">Self</option>
			               <option <?php echo $Parent; ?> value="Parent">Parent</option>
			               <option <?php echo $Spouse; ?> value="Spouse">Spouse</option>
			               <option <?php echo $Friend; ?> value="Friend">Friend</option>
			               <option <?php echo $Relative; ?> value="Relative">Relative</option>
			               <option <?php echo $Neighbor; ?> value="Neighbor">Neighbor</option>
			               <option <?php echo $Security_Guard; ?> value="Security Guard">Security Guard</option>
			               <option <?php echo $Landlord; ?> value="Landlord">Landlord</option>
			               <option <?php echo $House_Owner; ?> value="House Owner">House Owner</option>
			               <option <?php echo $Cousin; ?> value="Cousin">Cousin</option>
			            </select>
		                <span class="input-field-txt">Select Relationship</span>
            		<div id="relationship-error"></div> 
		            </div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<!-- <div class="col-3"><span class="input-main-hdr">Country Code *</span></div> -->
				<div class="col-12"><span class="input-main-hdr">Mobile Number *</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-3">
					<div class="input-wrap">
		                <select class="sign-in-input-field code" id="code" required>
		                  <?php
		                  $ccode = isset($table['permanent_address']['code'])?$table['permanent_address']['code']:'';
		                  foreach ($code['countries'] as $key => $value) {
		                     if ($ccode==$value['code']) {
		                        echo "<option selected >{$value['code']}</option>";
		                     } else { 
		                        echo "<option>{$value['code']}</option>";
		                     }
		                  } ?>
		               </select>
		                <span class="input-field-txt">Code</span> 
		            </div>
				</div>
				<div class="col-9">
					<div class="input-wrap">
		                <input name="" class="sign-in-input-field" id="permenent-contact_no" value="<?php echo isset($table['permanent_address']['contact_person_mobile_number'])?$table['permanent_address']['contact_person_mobile_number']:''; ?>" type="text" required>
		                <span class="input-field-txt">Mobile Number</span> 
               		<div id="permenent-contact_no-error"></div>
		            </div>
				</div>
			</div>
 	
 			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Rental Agreement/ Driving License</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
            		<div class="row">
            			<div class="col-8">
            				<span class="custom-file-name file-name file-name1" id="">
            					<?php $rental_agreement = '';
                       			if (isset($table['permanent_address'])) {
                       				if (!in_array('no-file', explode(',', $table['permanent_address']['rental_agreement']))) {
                         				foreach (explode(',', $table['permanent_address']['rental_agreement']) as $key => $value) {
                           				if ($value !='') {
                             					 // <a id='remove_file_rental_documents{$key}' onclick='removeFile_documents({$key},\"rental\")' data-path='rental-docs' data-field='rental_agreement' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a>  
                                       echo "<div id='rental{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"rental-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/rental-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                           				}
                         				}
                         				$rental_agreement = $table['permanent_address']['rental_agreement'];
                       				}
                       			}
                       		?>
            				</span>
            				<input type="hidden" id="rental_agreement" value="<?php echo $rental_agreement; ?>">
            			</div>
            			<div class="col-4 custom-file-input-btn-div">
            				<div class="custom-file-input">
            				<input type="file" accept="image/*,application/pdf" id="file1" name="file1" class="input-file w-100"  multiple>
            				<button class="btn btn-file-upload" for="file1">
            					<img src="assets/images/paper-clip.png">
                    		Upload
                  		</button>
            			</div>
            			<div class="col-12">
            				<div id="file1-error"></div>
            			</div>
            		</div>
                </div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Upload Ration Card/ Aadhar Card</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
            		<div class="row">
            			<div class="col-8">
            				<span class="custom-file-name file-name file-name2" id="">
            					<?php $ration_card = '';
                       		if (isset($table['permanent_address'])) {
                       			if (!in_array('no-file', explode(',', $table['permanent_address']['ration_card']))) {
                         			foreach (explode(',', $table['permanent_address']['ration_card']) as $key => $value) { 
                           			if ($value !='') {
                            				// <a id='remove_file_ration_documents{$key}' onclick='removeFile_documents({$key},\"ration\")' data-path='ration-docs' data-field='ration_card' data-file='{$value}' class='image-name-delete-a'><i class='fa fa-times text-danger'></i></a> 
                                       echo "<div id='ration{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"ration-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/ration-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          				}
                         			}
                         			$ration_card = $table['permanent_address']['ration_card'];
                       			}
                       		} ?>
            				</span>
            				<input type="hidden" id="ration_card" value="<?php echo $ration_card; ?>">
            			</div>
            			<div class="col-4 custom-file-input-btn-div">
            				<div class="custom-file-input">
            				<input type="file" accept="image/*,application/pdf" id="file2" name="file2" class="input-file w-100"  multiple>
            				<button class="btn btn-file-upload" for="file2">
            					<img src="assets/images/paper-clip.png">
                    		Upload
                  		</button>
            			</div>
            			<div class="col-12">
            				<div id="file2-error"></div>
            			</div>
            		</div>
               </div>
				</div>
			</div>

			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Upload Government Utility Bill</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
            		<div class="row">
            			<div class="col-8">
            				<span class="custom-file-name file-name file-name3" id="">
            					<?php $gov_utility_bill = '';
                       		if (isset($table['permanent_address'])) {
                       			if (!in_array('no-file', explode(',', $table['permanent_address']['gov_utility_bill']))) {
                         			foreach (explode(',', $table['permanent_address']['gov_utility_bill']) as $key => $value) { 
                           			if ($value !='') {
                            				echo "<div id='gov{$key}'><span>{$value}<a onclick='exist_view_image(\"{$value}\",\"gov-docs\")' >  <i class='fa fa-eye'></i></a><a href='".base_url()."../uploads/gov-docs/".$value."' download ><i class='fa fa-download text-info'></i></a></span></div>";
                          				}
                         			}
                         			$gov_utility_bill = $table['permanent_address']['gov_utility_bill'];
                       			}
                       		} ?>
            				</span>
            			</div>
            			<div class="col-4 custom-file-input-btn-div">
            				<div class="custom-file-input">
            				<input type="file" accept="image/*,application/pdf" id="file3" name="file3" class="input-file w-100"  multiple>
            				<button class="btn btn-file-upload" for="file3">
            					<img src="assets/images/paper-clip.png">
                    		Upload
                  		</button>
            			</div>
            			<div class="col-12">
            				<div id="file3-error"></div>
            			</div>
            		</div>
               </div>
				</div>
			</div>
			
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="add_address">
						Save & Continue
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade view-document-modal" id="myModal-show" role="dialog">
	 	<div class="modal-dialog modal-md modal-dialog-centered">
	      <!-- modal-content-view-collection-category -->
	      <div class="modal-content">
	        	<div class="modal-header border-0">
	          	<h3 id="">View Document</h4>
	        	</div>
	        	<div class="modal-body modal-body-edit-coupon">
	          	<div class="row"> 
	         		<div class="col-md-12 text-center view-img" id="view-img"></div>
	    			</div>
	          	<div class="row mt-3">
	              	<div class="col-md-6" id="setupDownloadBtn"></div>
	              	<div id="view-edit-cancel-btn-div" class="col-md-6 text-right">
	                	<button class="btn btn-close-modal" data-dismiss="modal">Close</button>
	              	</div>
	            </div>
	        	</div>
	      </div>
	   </div>
	</div>
	<script> 
    	var candidate_info = <?php echo json_encode($user); ?>;
	</script>
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-address.js" ></script>