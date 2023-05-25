<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-landload-reference';
   }
</script>
<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
			<input type="hidden" name="" id="landload_id" value="<?php echo isset($table['landload_reference']['landload_id'])?$table['landload_reference']['landload_id']:''; ?>">
				<?php  
            		$form_values = json_decode($user['form_values'],true);
             		$form_values = json_decode($form_values,true);
               		$total_ref = count($form_values['previous_landlord_reference_check']);
               		$refrence = 1; 

             		if ($total_ref == 0) {
               			$total_ref = 1;
             		}

             		if (isset($table['landload_reference']['landload_id'])) {
			            $tenant_name = json_decode($table['landload_reference']['tenant_name'],true);
			            $case_contact_no = json_decode($table['landload_reference']['case_contact_no'],true);
			            $landlord_name = json_decode($table['landload_reference']['landlord_name'],true);
			         }

					for ($i=0; $i < $total_ref; $i++) {
         		?>
				<div class="row content-div-content-row-1">
					<div class="col-12"><span class="input-main-hdr">Landlord Name *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field landlord_name" required name="landlord_name" id="landlord_name<?php echo $i; ?>" onkeyup="valid_name(<?php echo $i; ?>)" value="<?php echo isset($landlord_name[$i]['landlord_name'])?$landlord_name[$i]['landlord_name']:''; ?>">
			            	<span class="input-field-txt">Landlord Name</span>
			            	<div id="landlord_name-error<?php echo $i; ?>"></div>
			         	</div>
					</div>
				</div>
				<div class="row content-div-content-row d-none">
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field tenant_name" required name="tenant_name" id="tenant_name" onkeyup="valid_name(<?php echo $i; ?>)" value="<?php echo isset($tenant_name[$i]['tenant_name'])?$tenant_name[$i]['tenant_name']:''; ?>">
			            	<span class="input-field-txt">Tenant Name</span>
			            	<div id="tenant_name-error"></div>
			         	</div>
					</div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12"><span class="input-main-hdr">Landlord Contact Number *</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field case_contact_no" required name="case_contact_no" id="case_contact_no<?php echo $i; ?>" onkeyup="valid_contact_no(<?php echo $i; ?>)" value="<?php echo isset($case_contact_no[$i]['case_contact_no'])?$case_contact_no[$i]['case_contact_no']:''; ?>">
			            	<span class="input-field-txt">Landlord Contact Number</span>
			            	<div id="case_contact_no-error<?php echo $i; ?>"></div>
			         	</div>
					</div>
				</div>
			<?php } ?>
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="add_reference_landload">
						Save & Continue
					</button>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/landload_reference.js" ></script>