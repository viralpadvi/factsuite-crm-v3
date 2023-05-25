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
         <h3>Education Database</h3>
         <?php 
            $educations = array();
           if ($this->session->userdata('logged-in-admin')) {
        $user = $this->session->userdata('logged-in-admin');

        if ($user['role'] !='admin') {
          $roles = $this->db->where('role_name',$user['role'])->get('roles')->row_array();
          if ($roles['role_action'] !='' && $roles['role_action'] !=null) {
            $role_action = json_decode($roles['role_action'],true); 
            $educations = isset($role_action['education'])?$role_action['education']:array();  


          }
        }
      }

        if (in_array($user['role'], ['admin','csm']) || in_array(1, $educations)) {  
         ?>
        <div class="sbt-btns row">
          <div class="col-md-4 text-left"> 
          <input type="file" class="fld" name="excel_upload" id="add-bulk-upload-case">
          </div>
          <div class="col-md-3 text-left">
            <button type="button" onclick="import_excel()" class="btn bg-blu btn-submit-cancel ml-0">Import Excel</button>
          </div>
          <div class="col-md-5">
             <a href="#" id="team-submit-btn" data-toggle="modal" data-target="#add_fields"class="btn bg-blu btn-submit-cancel">Create&nbsp;Field</a>
          <a href="#" id="team-submit-btn-values" data-toggle="modal" data-target="#add_field_value_model"class="btn bg-blu btn-submit-cancel">Add&nbsp;Values</a>
          </div>
         
        </div>

      <?php } ?>
        <div class="table-responsive" id="">
          <table class=" table table-striped" id="example1">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th>
                <?php 
                $count = 1;
                if (isset($fields['field_name'])) {
                  $explode = explode(',', $fields['field_name']);
                  $count = count($explode);
                  foreach ($explode as $key => $value) {
                    echo "<th>{$value}</th>";
                  }
                }
                ?>    
                <th>Created Date</th>  
                <th>Updated Date</th>  
                <th>Edit</th>  
              </tr>
              <input type="hidden" name="total_fields" value="<?php echo $count; ?>" id="total_fields">
              <input type="hidden" name="total_field_name" value="<?php echo isset($fields['field_name'])?$fields['field_name']:''; ?>" id="total_field_name">
            </thead>
            <tbody class="tbody-datatable" id="get-field-data"> 
            </tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>

  <!-- Add role Modal Starts -->
  <div class="modal fade" id="add_fields">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Create&nbsp;Field</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2">
               
              <div class="col-sm-6">
                <label class="product-details-span-light">Field Name</label>
                <input type="text" class="fld" name="field_name" id="field_name" placeholder="Enter Field Name">
                <div id="field-name-error-msg-div"></div>  
              </div>
              
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-field-btn" name="edit-field-close-btn" onclick="addfield()">Save</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Add role Modal Ends -->


  <!-- Add role Modal Starts -->
  <div class="modal fade" id="add_field_value_model">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Add Field Values</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2" id="add_field_values">
                
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-field-value-btn" name="edit-field-close-btn" onclick="addfieldvalues()">Save</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Add role Modal Ends -->


  <!-- Edit role Modal Starts -->
   <div class="modal fade" id="edit_field">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">Edit Field Values</h4> 
        </div>
        <input type="hidden" name="edit_dynamic_id" id="edit_dynamic_id">
         <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2" id="edit_field_values"> 
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
<script src="<?php echo base_url(); ?>assets/custom-js/admin/fields/view-fields.js"></script> 