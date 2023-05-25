<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = link_base_url+'candidate-employment-gap';
   }
</script>
<div class="container-fluid content-bg-color">
		<div class="content-div">
			<div class="row"></div>
				<?php  
	            	$company_name = json_decode(isset($table['previous_employment']['company_name'])?$table['previous_employment']['company_name']:'',true);
	   				$start_date = json_decode(isset($table['previous_employment']['joining_date'])?$table['previous_employment']['joining_date']:'',true);
	   				$end_date = json_decode(isset($table['previous_employment']['relieving_date'])?$table['previous_employment']['relieving_date']:'',true);
	    			$curr_joining_date = isset($table['current_employment']['joining_date'])?$table['current_employment']['joining_date']:date('Y-m-d');
	   				$data = array();
	  				$end_d ='';

    				$reason_for_gap = json_decode(isset($table['employment_gap_check']['reason_for_gap'])?$table['employment_gap_check']['reason_for_gap']:'',true);

	  				if ($company_name !='' && $company_name !=null) {
   						foreach ($company_name as $key => $value) { 
					      	$data[$key]['companyName']= $value['company_name'];
					      	$data[$key]['startDate']= $start_date[$key]['joining_date'];
					      	$data[$key]['endDate']= isset($end_date[$key]['relieving_date'])?$end_date[$key]['relieving_date']:date('d-m-Y');
					    	$end_d = isset($end_date[$key]['relieving_date'])?$end_date[$key]['relieving_date']:date('d-m-Y');
   						}
					}

					$sortedArray = array();
   					foreach ($data as $data_key => $data_value) {
      					array_push($sortedArray,$data_value);
   					}
   					$gap = array();
         		?>
         		<input name="" class="fld form-control gap_id" value="<?php echo isset($table['employment_gap_check']['gap_id'])?$table['employment_gap_check']['gap_id']:''; ?>" id="gap_id" type="hidden">
				<div class="row content-div-content-row-1"></div>
				<?php 
          			$num = 1;
          			for ($n=0; $n < sizeof($sortedArray); $n++) { 
               			$end_date = date('d-m-Y',strtotime(isset($sortedArray[$n+1]['startDate'])?$sortedArray[$n+1]['startDate']:$curr_joining_date));
            			$start_date = date('d-m-Y',strtotime($sortedArray[$n]['endDate']));
         		?>
				<div class="row content-div-content-row">
					<div class="col-12">
						<span class="input-main-hdr">Employment <?php echo $num; ?></span>
					</div>
					<div class="col-12">
						<span class="input-main-hdr">Gap Date Range</span>
					</div>
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field date-gap" value="<?php echo $start_date.' - '.$end_date; ?>" id="date-gap" name="" readonly required>
			            	<span class="input-field-txt">Gap Date Range</span>
			         	</div>
					</div>
				</div>

				<div class="row content-div-content-row-2">
					<div class="col-12"><span class="input-main-hdr">Reason for Gap*</span></div>
				</div>
				<div class="row content-div-content-row">
					<div class="col-12">
						<div class="input-wrap">
							<input type="text" class="sign-in-input-field reason_for_gap" onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($reason_for_gap[$n]['reason_for_gap'])?$reason_for_gap[$n]['reason_for_gap']:''; ?>" id="reason_for_gap" required>
			            	<span class="input-field-txt">Reason for Gap</span>
			            	<div id="name-error"></div>
			         	</div>
					</div>
				</div>
			<?php $num++; } ?>
			<div class="row">
				<!-- disabled -->
				<div class="col-12">
					<button class="save-btn" id="add-global-database">
						Save & Continue
					</button>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-gap-check.js"></script>