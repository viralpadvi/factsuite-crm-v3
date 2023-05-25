<section id="pg-hdr">
    <div class="container-fluid">
      <div class="pg-hdr-mn">
          <div id="FS-candidate-mn" class="add-team add-team-2">
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
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
         <h3>Process Guidelines</h3>
         
        <div class="table-responsive" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Component Name</th>    
                <th>Process Name</th>    
                <th>Attachment</th>   
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-team-data"> 
            </tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>

  
 

</section>
<!--Content-->
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/analyst/process/view-process.js"></script> 
