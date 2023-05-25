<?php 
 
  $candidateId = '';
  $componentId = '';
  $assignedComponent = '';
  $assignedQCErrorComponent = ''; 
  $process = ''; 
  $progress_active ='';
  $completed_active ='';
  $escalatory_cases_active = ''; 
   $vendor_active ='';
  if(isset($candidateIdLink) && isset($componentIdLink)){
    $candidateId = '/'.$candidateIdLink;
    $componentId = '/'.$componentIdLink;
  } 


  
 if (strtolower(uri_string()) == 'factsuite-analyst/assigned-case-list' || strtolower(uri_string()) == 'factsuite-analyst/component-detail'.$candidateId.$componentId) {
    $assignedComponent = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-analyst/qcerror-case-list' || strtolower(uri_string()) == 'factsuite-analyst/qcerror-view-case-detail'.$candidateId.$componentId) {
     $assignedQCErrorComponent = 'active'; 
  }  else if (strtolower(uri_string()) == 'factsuite-analyst/escalatory-cases' || strtolower(uri_string()) == 'factsuite-analyst/qcerror-view-case-detail'.$candidateId.$componentId) {
     $escalatory_cases_active = 'active';
  }  else if (strtolower(uri_string()) == 'factsuite-analyst/assigned-progress-case-list' ) {
     $progress_active = 'active';
  }  else if (strtolower(uri_string()) == 'factsuite-analyst/assigned-completed-case-list') {
     $completed_active = 'active';
  }   else if (strtolower(uri_string()) == 'factsuite-analyst/assigned-vendor-case-list') {
     $vendor_active = 'active';
  } else { 
    $assignedComponent = 'active';
  }
?>


<!--Content-->
<section id="pg-hdr">
    <div class="container-fluid">
      <div class="pg-hdr-mn">
          <div id="FS-candidate-mn" class="add-team add-team-2 w-100">
            <ul class="nav nav-tabs nav-justified">
               <li class="nav-item">
                  <a class="nav-link <?php echo $assignedComponent;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/assigned-case-list">New Components </a>
                </li>
                 <li class="nav-item">
                  <a class="nav-link <?php echo $progress_active;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/assigned-progress-case-list">In-Progress Cases</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php echo $completed_active;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/assigned-completed-case-list">Completed Cases</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php echo $assignedQCErrorComponent; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/qcerror-case-list">QC Error </a>
                  <!-- <span id="QC-error-number" class="text-right ml-8 error-notification"><?php echo isset($toatladata)?$toatladata:'0'?></span> --> 
                </li> 
                
                <li class="nav-item">
                  <a class="nav-link <?php echo $escalatory_cases_active;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/escalatory-cases">Priority Cases</a>
                </li>  
                <li class="nav-item">
                  <a class="nav-link <?php echo $vendor_active;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/assigned-vendor-case-list">Vendor Cases</a>
                </li>               
            </ul>
          </div>
        </div>
    </div>
</section>

<section id="pg-cntr">
  <div class="pg-hdr">
     <!--Nav Tabs-->
     <!-- <div id="FS-candidate-mn" class="add-team">
        <ul class="nav nav-tabs nav-justified">
            <li class="nav-item">
              <a class="nav-link <?php echo $assignedComponent;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/assigned-case-list">Input Queue&nbsp;Component</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo $assignedQCErrorComponent; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/qcerror-case-list">QC&nbsp;Error&nbsp;Component<span id="QC-error-number" class="text-right ml-8 error-notification"><?php echo isset($toatladata)?$toatladata:'0'?></span></a>
            </li>  
            
        </ul>
     </div> -->
     <!--Nav Tabs-->
  </div>
<?php $analystUser = $this->session->userdata('logged-in-analyst');?>
<script>
  setInterval(function() {  
    CountQcErrorNotification(<?php echo $analystUser['team_id']; ?>)
  }, 10000); //

function CountQcErrorNotification(team_id){

  $.ajax({
    type: "POST",
      url: base_url+"analyst/getQcErrorComponentAna",
      data:{
        team_id:team_id
      },
      dataType: "json",
      success: function(data){ 
        $('#QC-error-number').html(data.length);
      }
    })
}
</script>