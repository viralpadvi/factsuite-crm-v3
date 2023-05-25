<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-global-database';
   }
</script>


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

   <!--Page Content-->
   <!-- <form> -->
   <div class="pg-cnt pt-3">
       <div class="pg-txt-cntr">
         <div class="pg-steps">Step <?php echo array_search('22',array_values(explode(',', $component_ids)))+2 ?>/<?php echo count(explode(',', $component_ids))+2;?></div>
         <h6 class="full-nam2">Employment Gap Check Details</h6>
         <!-- <div class="row"> -->
        <!--     <div class="col-md-8">
               <div class="pg-frm">
                  <label>Address</label>
                  <textarea class="fld form-control address" rows="4" id="address"></textarea>
               </div>
            </div>

            <div class="col-md-4">
               <div class="pg-frm">
                  <label>Pin Code</label>
                  <input name="" class="fld form-control pincode" id="pincode" type="text">
               </div>
            </div>

         </div> -->
         <div class="row">

                  <input name="" class="fld form-control gap_id" value="<?php echo isset($table['employment_gap_check']['gap_id'])?$table['employment_gap_check']['gap_id']:''; ?>" id="gap_id" type="hidden">
            <?php  
            $num = 1;
            for ($n=0; $n < sizeof($sortedArray); $n++) { 
               $end_date = date('d-m-Y',strtotime(isset($sortedArray[$n+1]['startDate'])?$sortedArray[$n+1]['startDate']:$curr_joining_date));
            $start_date = date('d-m-Y',strtotime($sortedArray[$n]['endDate']));   
            ?>
            <div class="col-md-12">
               <label>Employment <?php echo $num; ?> </label>
               <div class="pg-frm">
                  <label>Gap Date Range</label>
                  <input type="text" readonly class="form-control date-gap" value="<?php echo $start_date.' - '.$end_date; ?>" id="date-gap" name="">
                  <label>Reason for Gap</label>
                  <input name="" class="fld form-control reason_for_gap"   onblur="valid_name()" onkeyup="valid_name()" value="<?php echo isset($reason_for_gap[$n]['reason_for_gap'])?$reason_for_gap[$n]['reason_for_gap']:''; ?>" id="reason_for_gap" type="text">
                   <div id="name-error">&nbsp;</div>
               </div>
            </div>
            <?php 
            $num++;
         } ?>
            
         </div>
       
       
         
         <div class="row">
            <div class="col-md-12" id="warning-msg">&nbsp;</div>
            <div class="col-md-12">
               <div class="pg-submit">
                 <button id="add-global-database" class="pg-submit-btn">Save &amp; Continue</button> 
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- </form> -->
   <!--Page Content-->
   <div class="clr"></div>
</section>

<script src="<?php echo base_url(); ?>assets/custom-js/candidate/candidate-gap-check.js" ></script>
 