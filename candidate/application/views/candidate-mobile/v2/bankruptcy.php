<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-bankruptcy';
   }
</script>
<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
				<?php  
            		$form_values = json_decode($user['form_values'],true);
             		$form_values = json_decode($form_values,true);
             		$credit = 1;
             		if (isset($form_values['bankruptcy_check'][0])?$form_values['bankruptcy_check'][0]:0 > 0) {
               			$credit = $form_values['bankruptcy_check'][0];
             		}
             		$bankruptcy = isset($table['bankruptcy'])?$table['bankruptcy']:'';
         		?>
         		<input type="hidden" name="bankruptcy_id" value="<?php echo  isset($bankruptcy['bankruptcy_id'])?$bankruptcy['bankruptcy_id']:''; ?>" id="bankruptcy_id">
				<div class="row content-div-content-row-1">
					<div class="col-12"><span class="input-main-hdr">Bankruptcy</span></div>
				</div>
				<?php 
          			$document_type = json_decode(isset($bankruptcy['document_type'])?$bankruptcy['document_type']:'-',true);
         			$bankruptcy_number = json_decode(isset($bankruptcy['bankruptcy_number'])?$bankruptcy['bankruptcy_number']:'-',true);
           			$bankruptcy_doc = json_decode(isset($bankruptcy['bankruptcy_doc'])?$bankruptcy['bankruptcy_doc']:'no-file',true);
         			for ($i=0; $i < $credit; $i++) {  
            			$doc_type = isset($document_type[$i]['document_type'])?$document_type[$i]['document_type']:'-';
            			$pan = '';
            			$nric = '';
            			if ($doc_type == 'Passport') {
              				$pan = 'selected';
            			} else if ($doc_type == 'NRIC') {
              				$nric = 'selected';
            			}
         			?>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
							<select class="sign-in-input-field document_type" required id="credit_type<?php echo $i; ?>" >
                 				<option value=""> Select Document Type</option>
                 				<option <?php echo $pan; ?> value="Passport">Passport</option>
                 				<option <?php echo $nric; ?> value="NRIC">NRIC</option> 
               				</select>
			            	<span class="input-field-txt">Document Type</span>
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
							<input type="text"class="sign-in-input-field bankruptcy" name="bankruptcy" id="bankruptcy<?php echo $i; ?>" value="<?php echo isset($bankruptcy_number[$i]['bankruptcy_number'])?$bankruptcy_number[$i]['bankruptcy_number']:''; ?>" required>
			            	<span class="input-field-txt">Document Number</span>
			            	<div id="bankruptcy-error<?php echo $i; ?>"></div>
			         	</div>
					</div>
				</div>
			<?php } ?>
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="add-document-check">
						Save & Continue
					</button>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-bankruptcy.js" ></script>