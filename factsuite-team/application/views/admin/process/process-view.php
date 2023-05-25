<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
          <div id="FS-candidate-mn" class="add-team">
            
        </div>
      </div>
   </div>
</section>
<section id="pg-cntr">
  <div class="pg-hdr">
    
  </div>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
         <h3>Process Details</h3>
        <div class="sbt-btns">
          <a href="#" id="team-submit-btn" data-toggle="modal" data-target="#add_holiday"class="btn bg-blu btn-submit-cancel">Add Process</a>
        </div>
        <div class="table-responsive" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Component Name</th>
                <th>Process Name</th>    
                <th>Attachment</th>    
                <th>Action</th>    
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-team-data"> 
            </tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>

  <!-- Add role Modal Starts -->
  <div class="modal fade" id="add_holiday">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Add&nbsp;Process</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2">
               
              <div class="col-sm-6">
                <label class="product-details-span-light">Component Name</label> 
                <select class="fld" id="component_name">
                  <option value="">Select Component</option>
                  <?php 
                  if ($component) {
                    foreach ($component as $key => $value) {
                      echo "<option value='{$value['component_id']}'>{$value['fs_crm_component_name']}</option>";
                    }
                  }
                  ?>
                </select>
                <div id="component_name-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6">
                <label class="product-details-span-light">Process Name</label>
                <input type="text" class="fld" name="process_name" id="process_name" placeholder="Enter Process Name">
                <div id="process_name-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6">
                <label class="product-details-span-light">Process Attachment</label>
                <input type="file" class="fld" accept=".pdf" name="attachment" id="attachment" >
                <div id="attachment-error-msg-div"></div>  
              </div>
              
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-role-btn" name="edit-role-close-btn" onclick="addprocess()">Save</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Add role Modal Ends -->



  <!-- Edit role Modal Starts -->
   <div class="modal fade" id="edit_holiday">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">Edit Process</h4> 
        </div>
        <input type="hidden" name="edit_process_id" id="edit_process_id">
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content"> 
            
            <div class="row mt-2">
               
              <div class="col-sm-6">
                <label class="product-details-span-light">Component Name</label> 
                <select class="fld" id="edit_component_name">
                  <option value="">Select Component</option>
                  <?php 
                  if ($component) {
                    foreach ($component as $key => $value) {
                      echo "<option value='{$value['component_id']}'>{$value['component_name']}</option>";
                    }
                  }
                  ?>
                </select>
                <div id="component_name-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6">
                <label class="product-details-span-light">Process Name</label>
                <input type="text" class="fld" name="edit_process_name" id="edit_process_name" placeholder="Enter Process Name">
                <div id="process_name-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6">
                <label class="product-details-span-light">Process Attachment</label>
                <input type="file" class="fld" accept=".pdf" name="edit_attachment" id="edit_attachment" >
                <div id="attachment-error-msg-div"></div>  
              </div>
              
            </div>
             
          </div> 
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Close</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-role-btn" name="edit-role-close-btn" onclick="updateData()">Update</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Coupon Modal Ends -->

 

</section>
<!--Content-->
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/process/view-process.js"></script> 
