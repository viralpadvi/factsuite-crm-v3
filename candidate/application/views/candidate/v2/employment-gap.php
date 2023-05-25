 
					<input name="" class="fld form-control gap_id" value="<?php echo isset($table['employment_gap_check']['gap_id'])?$table['employment_gap_check']['gap_id']:''; ?>" id="gap_id" type="hidden">

					
<?php 

   $company_name = json_decode(isset($table['previous_employment']['company_name'])?$table['previous_employment']['company_name']:'',true);
   $start_date = json_decode(isset($table['previous_employment']['joining_date'])?$table['previous_employment']['joining_date']:'',true);
   $end_date = json_decode(isset($table['previous_employment']['relieving_date'])?$table['previous_employment']['relieving_date']:'',true);
    $curr_joining_date = isset($table['current_employment']['joining_date'])?$table['current_employment']['joining_date']:date('Y-m-d');
   $data = array();
  $end_d ='';
  
  if ($company_name !='' && $company_name !=null) {
   foreach ($company_name as $key => $value) { 
      $data[$key]['companyName']= $value['company_name'];
      $data[$key]['startDate']= $start_date[$key]['joining_date'];
      $data[$key]['endDate']= isset($end_date[$key]['relieving_date'])?$end_date[$key]['relieving_date']:date('d-m-Y');

    $end_d = isset($end_date[$key]['relieving_date'])?$end_date[$key]['relieving_date']:date('d-m-Y');
   }
}

    $reason_for_gap = json_decode(isset($table['employment_gap_check']['reason_for_gap'])?$table['employment_gap_check']['reason_for_gap']:'',true);
  /* uasort($data, function($a,$b){
      if($a['startDate']==$b['startDate']) return 0;
      return $a['startDate'] < $b['startDate']?1:-1;
      // return strcmp($a['startDate'], $b['startDate']);
   });*/
    
   $sortedArray = array();
   foreach ($data as $data_key => $data_value) {
      array_push($sortedArray,$data_value);
   }

   $gap = array();
 /*  for($i=1; $i<sizeof($sortedArray); $i++){
         // $gap[$i] = $data[$i-1]['endDate'] < $data[$i]['startDate'];

         $start_date = date_create($sortedArray[$i-1]['startDate']);
        $end_date = date_create($sortedArray[$i]['endDate']);
       
      $tenure_of_gap = date_diff($end_date,$start_date);
      $gap[$i]['daysGap'] = $tenure_of_gap->format("%a days");
   }*/

// $end = date_create($end_d);
// $start = date_create($curr_joining_date);

?>

 <?php  
            $num = 1;
            for ($n=0; $n < sizeof($sortedArray); $n++) { 
               $end_date = date('d-m-Y',strtotime(isset($sortedArray[$n+1]['startDate'])?$sortedArray[$n+1]['startDate']:$curr_joining_date));
            $start_date = date('d-m-Y',strtotime($sortedArray[$n]['endDate']));   
            ?>
					<h2 class="component-name">Employment <?php echo $num; ?> </h2>
					<div class="row">
						<div class="col-md-6">
							<div class="input-wrap">
				                 <input name="" required="" class="sign-in-input-field date-gap" value="<?php echo $start_date.' - '.$end_date; ?>" id="date-gap" name="">
				                <span class="input-field-txt">Gap Date Range </span> 
				            </div>
						</div>
						 <div class="col-md-6">
							<div class="input-wrap">
				                <input name="landlord_name"  required="" class="sign-in-input-field  reason_for_gap"   onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($reason_for_gap[$n]['reason_for_gap'])?$reason_for_gap[$n]['reason_for_gap']:''; ?>" id="reason_for_gap" type="text">
				                <span class="input-field-txt">Reason for Gap </span>
                   				<div id="name-error">&nbsp;</div>
				            </div>
						</div>
						 
					</div>

					<?php 
					$num++;
            }
         ?>

				 
					  
					<div class="row">
						<div class="col-md-12" id="warning-msg">&nbsp;</div>
						<!-- <div class="col-md-7"></div> -->
						<div class="col-md-5">
							<button   id="add-global-database" class="save-btn">Save &amp; Continue</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

 

<script> 
    var candidate_info = <?php echo json_encode($user); ?>;
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-gap-check.js" ></script>
