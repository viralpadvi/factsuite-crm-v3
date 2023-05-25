<?php 
 
  $candidateId = '';
  $componentId = '';
  $assignedComponent = '';
  $assignedQCErrorComponent = '';
  $process = '';
  $progress_active ='';
  $completed_active ='';
  $vendor_active = '';
  if(isset($candidateIdLink) && isset($componentIdLink)){
    $candidateId = '/'.$candidateIdLink;
    $componentId = '/'.$componentIdLink;
  } 


  
 if (strtolower(uri_string()) == 'factsuite-specialist/view-all-component-list' || strtolower(uri_string()) == 'factsuite-specialist/component-detail'.$candidateId.$componentId) {
    $assignedComponent = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-specialist/qcerror-case-list' || strtolower(uri_string()) == 'factsuite-specialist/qcerror-view-case-detail'.$candidateId.$componentId) {
     $assignedQCErrorComponent = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-specialist/view-process-guidline') {
     $process = 'active';
  }  else if (strtolower(uri_string()) == 'factsuite-specialist/assigned-progress-case-list' ) {
     $progress_active = 'active';
  }  else if (strtolower(uri_string()) == 'factsuite-specialist/assigned-completed-case-list') {
     $completed_active = 'active';
  }  else if (strtolower(uri_string()) == 'factsuite-specialist/assigned-vendor-case-list') {
     $vendor_active = 'active';
  }
  else {
    $assignedComponent = 'active';
  }
?>
<section id="pg-hdr">
    <div class="container-fluid">
      <div class="pg-hdr-mn">
          <div id="FS-candidate-mn" class="add-team w-100">
            <ul class="nav nav-tabs nav-justified">
                <li class="nav-item">
                  <a class="nav-link <?php echo $assignedComponent;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/view-all-component-list">New Components </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php echo $progress_active;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/assigned-progress-case-list">In-Progress Cases</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php echo $completed_active;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/assigned-completed-case-list">Completed Cases</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?php echo $assignedQCErrorComponent; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/qcerror-case-list">QC Error </a>
                  <!-- <span id="QC-error-number" class="text-right ml-8 error-notification"><?php echo isset($toatladata)?$toatladata:'0'?></span> -->
                </li> 
                <li class="nav-item">
                  <a class="nav-link <?php echo $vendor_active;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/assigned-vendor-case-list">Vendor Cases</a>
                </li>                
            </ul>
          </div>
        </div>
    </div>
</section>
<!--Content-->
<section id="pg-cntr">
  <div class="pg-hdr">
     <!--Nav Tabs-->
     <!-- <div id="FS-candidate-mn" class="add-team">
        <ul class="nav nav-tabs nav-justified">
            <li class="nav-item">
              <a class="nav-link <?php echo $assignedComponent;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/view-all-component-list">Input Queue&nbsp;Component</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo $assignedQCErrorComponent; ?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-specialist/qcerror-case-list">QC&nbsp;Error&nbsp;Component<span id="QC-error-number" class="text-right ml-8 error-notification"><?php echo isset($toatladata)?$toatladata:'0'?></span></a>
            </li>  
            
        </ul>
     </div> -->
     <!--Nav Tabs-->
  </div>
  <?php $analystUser = $this->session->userdata('logged-in-specialist');?>
<script>
  setInterval(function() {  
    CountQcErrorNotification(<?php echo $analystUser['team_id']; ?>)
  }, 10000); //

CountQcErrorNotification(<?php echo $analystUser['team_id']; ?>)
function CountQcErrorNotification(team_id){
  
  $.ajax({
    type: "POST",
      url: base_url+"analyst/getQcErrorComponentAna",
      data:{
        team_id:team_id
      },
      dataType: "json",
      success: function(data){ 
        // console.log(JSON.stringify(data))
        $('#QC-error-number').html(data.length);
      }
    })
}
</script>