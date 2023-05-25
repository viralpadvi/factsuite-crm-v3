<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
          <div id="FS-candidate-mn" class="add-team">
           <!--  <ul class="nav nav-tabs nav-justified"> 
               <li class="nav-item">
                 <a class="nav-link" href="<?php echo $this->config->item('my_base_url').'factsuite-admin/add-team'; ?>">Add Team Member</a>
              </li>
              <li class="nav-item">
                 <a class="nav-link " href="#">View Team</a>
              </li>
              <li class="nav-item d-none">
                 <a class="nav-link" href="team-analytics.html">Analytics</a>
              </li>
              <li class="nav-item">
              <a class="nav-link active" href="<?php echo $this->config->item('my_base_url').'role'; ?>">Role</a>
           </li>
            </ul> -->
        </div>
      </div>
   </div>
</section>
<section id="pg-cntr">
  <div class="pg-hdr">
    
  </div>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
         <h3>Employment Database</h3>
         
        <div class="table-responsive" id="">
          <table class=" table table-striped" id="example1">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th>
                <?php 
                $count = 1;
                if (isset($fields['employment_fields'])) {
                  $explode = explode(',', $fields['employment_fields']);
                  $count = count($explode);
                  foreach ($explode as $key => $value) {
                    echo "<th>{$value}</th>";
                  }
                }
                ?>    
                <th>Created Date</th>  
                <th>Updated Date</th>  
              </tr>
              <input type="hidden" name="total_fields" value="<?php echo $count; ?>" id="total_fields">
              <input type="hidden" name="total_field_name" value="" id="total_field_name">
            </thead>
            <tbody class="tbody-datatable" id="get-field-data"> 
            </tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>
 
</section>
<!--Content-->
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/fields/employee-dynamic-view-fields.js"></script> 
