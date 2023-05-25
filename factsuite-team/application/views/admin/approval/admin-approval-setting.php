<section id="pg-cntr">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
        <h3>Admin Approval Mechanism</h3>
         
        <div class="table-responsive" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sl No.</th>    
                <th>List </th>  
                <th>Created&nbsp;Date</th>  
                <th>Action</th>  
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-all-tickets">
              <?php 
              if (count($approval) > 0) {
                $i = 1;
                foreach ($approval as $key => $value) {
                    $select ="";
                    $select .="<select class='form-control' onChange='change_value_of_the_level(".$value['approve_id'].",this)' >";
                     $select .="<option value=''>Select Level</option>";
                  for ($j=1; $j <= 3; $j++) { 
                    $selected ='';
                    if ($j == $value['levels']) {
                      $selected ='selected';
                    }
                     $select .="<option {$selected} value='{$j}'>Level {$j}</option>";
                  }
                  $select .="</select>"; 
                  ?>
                   <tr>
                    <th><?php echo ($i++) ?></th>    
                    <th><?php echo $value['name'] ?> </th>  
                    <th><?php echo $value['initiate_date'] ?></th>  
                    <th><?php echo $select; ?></th>  
                  </tr>
                  <?php 
                }
              }
              ?>
            </tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>
 
 
  <!-- Add New Ticket Modal Starts -->
  <div class="modal fade" id="accept-new-model">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Are you sure want to change the assign level for the current selection?</h4> 
        </div>
          
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white"  name="add-role-close-btn" data-dismiss="modal">Close</button>
          <button type="button" class="btn bg-blu btn-close text-white" id="accept-new-btn">Accept</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Add New Ticket Modal Ends -->
 
</section>
<!--Content-->

<!-- custom-js --> 
<script src="<?php echo base_url() ?>assets/custom-js/admin/approval/admin-approval-list.js"></script>