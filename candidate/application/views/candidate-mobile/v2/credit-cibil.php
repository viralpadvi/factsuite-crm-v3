<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-credit-cibil';
   }
</script> 
	<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
			<div class="row content-div-content-row-1">
				<div class="col-10"><span class="input-main-hdr">Name*</span></div>
				<div class="col-2 text-right">
					<img src="<?php echo base_url(); ?>assets/images/info-symbol.svg">
				</div>
			</div>
			 <?php $form_values = json_decode($user['form_values'],true);
            $form_values = json_decode($form_values,true);
            $credit = 1;
            if (isset($form_values['credit_\/ cibil check'][0])?$form_values['credit_\/ cibil check'][0]:0 > 0) {
           		$credit = $form_values['credit_\/ cibil check'][0];

	          	$credit_data =  isset($table['credit_cibil'])?$table['credit_cibil']:'';

	          	$document_type = json_decode(isset($credit_data['document_type'])?$credit_data['document_type']:'-',true);
	           	$credit_number = json_decode(isset($credit_data['credit_number'])?$credit_data['credit_number']:'-',true);
	           	$credit_cibil_doc = json_decode(isset($credit_data['credit_cibil_doc'])?$credit_data['credit_cibil_doc']:'no-file',true);
           }
         ?>
         <input type="hidden" name="credit_id" value="<?php echo  isset($credit_data['credit_id'])?$credit_data['credit_id']:''; ?>" id="credit_id">
         <?php for ($i=0; $i < $credit; $i++) {   
          	$doc_type = isset($document_type[$i]['document_type'])?$document_type[$i]['document_type']:'-';
         	$pan = '';
         	$pass = '';
         	$nric = '';
         	if ($doc_type == 'Pan Card') {
           		$pan = 'selected';
         	} else if ($doc_type == 'NRIC') {
           		$nric = 'selected';
         	} else if ($doc_type == 'Passport') {
           		$pass = 'selected';
         	}
      	?>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		            <select class="sign-in-input-field document_type" required id="document_type<?php echo $i; ?>">
							<option value=""> Select Document Type</option>
                 		<option <?php echo $pan; ?> value="Pan Card">Pan Card</option>
                 		<option <?php echo $nric; ?> value="NRIC">NRIC</option>
                 		<option  <?php echo $pass; ?> value="Passport">Passport</option>
						</select>
		            <span class="input-field-txt">Document Type*</span>
		            <div id="document_type-error<?php echo $i; ?>"></div>
		         </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Document Number*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		            <input type="text" class="sign-in-input-field credit_cibil_number" name="credit_cibil_number" id="credit_cibil_number<?php echo $i; ?>" value="<?php echo isset($credit_number[$i]['credit_cibil_number'])?$credit_number[$i]['credit_cibil_number']:''; ?>" required="">
		            <span class="input-field-txt">Enter document number*</span>
		            <div id="credit_cibil_number-error<?php echo $i; ?>"></div>
		         </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Country*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		         	<select class="sign-in-input-field" id="nationality" >
                     <option value="">Select Country</option>
                     <?php $c_id = '';
                      	foreach ($country as $key => $value) {
                      		if ($user['nationality'] == $value['name'] ) {
                           	$c_id = $value['id'];
                          		echo "<option selected data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                        	} else {
                          		if ($value['name'] =='India') {
                           		$c_id = $value['id'];
                            		echo "<option selected data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                          		}else{
                          			echo "<option  data-id='{$value['id']}' value='{$value['name']}' >{$value['name']}</option>";
                          		}
                        	}
                      	}
                     ?>
                  </select>
                  <span class="input-field-txt">Country*</span>
                  <div id="nationality-error"></div>
		         </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">State*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<?php if ($c_id !='') {
                  	$state = $this->candidateModel->get_all_states($c_id);  
                	}
                  $city_id ='';
               ?>
					<div class="input-wrap">
		            <select class="sign-in-input-field state" required onchange="valid_state()" id="state">
		               <option value="">Select State</option>
							<?php $get = isset($table['credit_cibil']['credit_state'])?$table['credit_cibil']['credit_state']:'';
                     $get_state = isset($table['credit_cibil']['credit_state'])?$table['credit_cibil']['credit_state']:'';
                     foreach ($state as $key1 => $val) {
                        if ($get == $val['name']) {
                          	$city_id = $val['id'];
                           echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                        } else {
                           if ($get_state == $val['name']) {
                           	$city_id = $val['id'];
                           }
                           echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                        }
                     } ?>
						</select>
		            <span class="input-field-txt">State*</span>
		            <div id="state-error"></div>
		        	</div>
				</div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		            <select class="sign-in-input-field" required id="city">
							<?php $get_city = isset($table['credit_cibil']['credit_city'])?$table['credit_cibil']['credit_city']:''; 
							 if ($get_city !='') { 
                     $cities = $this->candidateModel->get_all_cities($city_id);
                     foreach ($cities as $key2 => $val) {
                        if ($get_city == $val['name']) { 
                           echo "<option data-id='{$val['id']}' selected value='{$val['name']}' >{$val['name']}</option>";
                        } else {
                           echo "<option data-id='{$val['id']}' value='{$val['name']}' >{$val['name']}</option>";
                        }
                     }
                     } ?>
						</select>
		            <span class="input-field-txt">City/Town*</span>
		            <div id="city-error"></div>
		         </div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Pin Code*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
		            <input type="text" class="sign-in-input-field" id="pincode" value="<?php echo isset($table['credit_cibil']['credit_pincode'])?$table['credit_cibil']['credit_pincode']:''; ?>" required="">
		            <span class="input-field-txt">Enter Pin Code*</span>
		            <div id="pincode-error"></div>
		        	</div>
				</div>
			</div>
			<div class="row content-div-content-row-2">
				<div class="col-12"><span class="input-main-hdr">Permanent Address*</span></div>
			</div>
			<div class="row content-div-content-row">
				<div class="col-12">
					<div class="input-wrap">
						<textarea class="sign-in-input-field address" onkeyup="valid_address()" rows="4" id="address"><?php echo isset($table['credit_cibil']['credit_address'])?$table['credit_cibil']['credit_address']:''; ?></textarea>
		            <span class="input-field-txt">Enter Permanent Address*</span>
		            <div id="address-error"></div>
		        	</div>
				</div>
			</div>
			<?php } ?>
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="add-credit-cibil">
						Save & Continue
					</button>
				</div>
			</div>
		</div>
	</div>
 
 	<script> 
    	var candidate_info = <?php echo json_encode($user); ?>;
	</script>

	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-credit-cibil.js" ></script>