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
         <h3>Client Mandate Details</h3>
         <?php 
            $mandates = array();
           if ($this->session->userdata('logged-in-admin')) {
        $user = $this->session->userdata('logged-in-admin');

        if ($user['role'] !='admin') {
          $roles = $this->db->where('role_name',$user['role'])->get('roles')->row_array();
          if ($roles['role_action'] !='' && $roles['role_action'] !=null) {
            $role_action = json_decode($roles['role_action'],true); 
            $mandates = isset($role_action['mandate'])?$role_action['mandate']:array();  


          }
        }
      }else{
         $user = $this->session->userdata('logged-in-csm');
      }

        if (in_array($user['role'], ['admin','csm']) || in_array(1, $mandates)) {  
         ?>
        <div class="sbt-btns">
          <a href="#" id="team-submit-btn" data-toggle="modal" data-target="#add_mandate"class="btn bg-blu btn-submit-cancel">Add Client Mandate</a>
        </div>
        <?php 
          }
        ?>
        <div class="table-responsive" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Client&nbsp;Name</th>  
                <th>Package&nbsp;Name</th>  
                <th>Mandate&nbsp;Description</th>  
                <th>Special Instructions</th>  
                <th>Edit</th>  
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
  <div class="modal fade" id="add_mandate">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Create&nbsp;Client Mandate</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2">
               
              <div class="col-sm-6">
                <label class="product-details-span-light">Client Name</label>
                <select class="form-control" id="client_name">
                  <option value="">Select Client</option>
                  <?php 
                  foreach ($client as $key => $value) {
                    echo "<option value='{$value['client_id']}'>{$value['client_name']}</option>";
                  }
                  ?>
                </select>
                <div id="client-name-error-msg-div"></div>  
              </div>
              <div class="col-md-6">
                <label class="product-details-span-light">Package</label>
                <select class="form-control" id="package_id">
                   
                </select>
                <div id="package_id-error-msg-div"></div> 
                <input type="hidden" name="edit_package_id" id="edit_package_id"> 
              </div>
              <label>Components</label>
              <div class="row" id="components_ids">
                
              </div>
              <div class="col-md-12">
                <label class="product-details-span-light">Mandate Description</label>
                 
                <textarea class="fld ckeditor" name="mandate-description" id="mandate-description" placeholder="Mandate Description"></textarea>
              </div>
              <div class="col-md-12">
                <label class="product-details-span-light">Special Instructions</label>
                 
                <textarea class="fld ckeditor" name="mandate-instruction" id="mandate-instruction" placeholder="Mandate Instructions"></textarea>
              </div>
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-role-btn" name="edit-role-close-btn" onclick="add_mandate()">Save</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Add role Modal Ends -->


  <!-- Edit role Modal Starts -->
   <div class="modal fade" id="edit_mandate">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">Edit&nbsp;Client&nbsp;Mandate</h4> 
        </div>
        <input type="hidden" name="edit_mandate_id" id="edit_mandate_id">
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content row"> 
            
              <div class="col-sm-6">
                <label class="product-details-span-light">Client Name</label>
                <select class="form-control" id="edit-client_name">
                  <option value="">Select Client</option>
                  <?php 
                  foreach ($client as $key => $value) {
                    echo "<option value='{$value['client_id']}'>{$value['client_name']}</option>";
                  }
                  ?>
                </select>
                <div id="edit-client-name-error-msg-div"></div>  
              </div>
              <div class="col-md-6">
                <label class="product-details-span-light">Package</label>
                <select class="form-control" id="edit-package_id">
                   
                </select>
                <div id="package_id-error-msg-div"></div> 
                <input type="hidden" name="edit_new_package_id" id="edit_new_package_id"> 
              </div>
              <label>Components</label>
              <div class="row" id="edit_components_ids">
                
              </div>
              <div class="col-md-12">
                <label class="product-details-span-light">Mandate Description</label>
                 
                <textarea class="fld ckeditor" name="edit-mandate-description" id="edit-mandate-description" placeholder="Mandate Description"></textarea>
              </div>
              <div class="col-md-12">
                <label class="product-details-span-light">Special Instructions</label>
                 
                <textarea class="fld ckeditor" name="edit-mandate-instruction" id="edit-mandate-instruction" placeholder="Mandate Instructions"></textarea>
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
<script src="<?php echo base_url(); ?>assets/custom-js/admin/mandate/view-mandate.js"></script> 
