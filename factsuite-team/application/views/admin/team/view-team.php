 <?php 
      $teams = array();
     if ($this->session->userdata('logged-in-admin')) {
  $user = $this->session->userdata('logged-in-admin');

  if ($user['role'] !='admin') {
    $roles = $this->db->where('role_name',$user['role'])->get('roles')->row_array();
    if ($roles['role_action'] !='' && $roles['role_action'] !=null) {
      $role_action = json_decode($roles['role_action'],true); 
      $teams = isset($role_action['team'])?$role_action['team']:array();  


    }
  }
} 
    ?>
<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
         <div id="FS-candidate-mn" class="add-team w-75">
           <ul class="nav nav-tabs nav-justified"> 
                 <?php 
                if (in_array($user['role'], ['admin','csm']) || in_array(1, $team)) {  
               ?>
               <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->config->item('my_base_url').'factsuite-admin/add-team'; ?>">Add Team Member</a>
               </li>
               <?php 
            }
                if (in_array($user['role'], ['admin','csm']) || in_array(2, $teams) || in_array(3, $teams)) {  
               ?>
               <li class="nav-item">
                  <a class="nav-link active" href="<?php echo $this->config->item('my_base_url').'factsuite-admin/view-team'; ?>">View Team</a>
               </li>
            <?php } ?>  
                
              <li class="nav-item d-none">
                 <a class="nav-link" href="team-analytics.html">Analytics</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="<?php echo $this->config->item('my_base_url').'role'; ?>">Role</a>
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
                 <a class="nav-link" href="<?php //echo $this->config->item('my_base_url').'factsuite-admin/add-team ?>">Add Team</a>
              </li>
              <li class="nav-item">
                 <a class="nav-link active" href="#">View Team</a>
              </li>
              <li class="nav-item d-none">
                 <a class="nav-link" href="team-analytics.html">Analytics</a>
              </li>
           </ul>
        </div> -->
     <!--Nav Tabs-->
  </div>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt">
         <div class="table-responsive mt-5" id="">
            <table class=" table-fixed datatable table table-striped">
               <thead class="table-fixed-thead thead-bd-color">
                 <tr>
                   <th>Sr No.</th> 
                   <th>Emp Id</th> 
                   <th>Name</th> 
                   <th>Email ID</th> 
                   <th>Phone Number</th> 
                   <th>Role</th> 
                   <th>Reporting Manager</th>  
                   <th>Edit/Delete</th>  
                   <th>Change Password</th>  
                 </tr>
               </thead>
               <tbody class="table-fixed-tbody tbody-datatable" id="get-team-data-1"> 
                  <?php 
                  $i = 1;
                  if (count($team) > 0) {
                     foreach ($team as $key => $value) {
                        ?>
                     <tr id="tr_<?php echo $value['team_id']; ?>"> 
                     <td><?php echo $i++; ?></td>
                     <td id="team_id_<?php echo $value['team_id']; ?>"><?php echo $value['team_id']; ?></td>
                     <td class="text-capitalize" id="first_name_<?php echo $value['team_id']; ?>"><?php echo $value['first_name'].' '.$value['last_name']; ?></td>
                     <td id="team_employee_email_<?php echo $value['team_id']; ?>"><?php echo $value['team_employee_email']; ?></td>
                     <td id="contact_no_<?php echo $value['team_id']; ?>"><?php echo $value['contact_no']; ?></td>
                     <td id="role_<?php echo $value['team_id']; ?>"><?php echo $value['role']; ?></td>
                     <td id="reporting_manager_<?php echo $value['reporting_manager']; ?>"><?php echo $value['reporting_manager']; ?></td>
                     <?php 
                        if ( (in_array($user['role'], ['admin','csm']) || in_array(2, $team)) && $value['role'] !='admin') { 
                     ?>
                     <td><a onclick="view_edit_team(<?php echo $value['team_id']; ?>)" href="#"><i class="fa fa-pencil"></i></a></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="remove_team_field(<?php echo $value['team_id']; ?>)" href="#" class=" ml-1 " ><i class="fa fa-trash text-danger"></i></a></td>
                  <?php 
                     }else{
                        echo "<td></td>";
                     }

                     if (!in_array($value['role'], ['admin'])) {    

                  ?>
                     <td><a onclick="view_change_team_password(<?php echo $value['team_id']; ?>)" href="#"><i class="fa fa-eye"></i></a></div></td>
                     </tr>

                        <?php 
                        }else{
                        echo "<td></td>";
                        }

                     }
                  }
                  ?>
               </tbody>
            </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>
</section>
<!--Content-->


  <!-- Delete  Modal Starts -->
  <div class="modal fade" id="edit-team-view">
    <div class="modal-dialog modal-dialog-centered  modal-xl">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
                 <div id="FS-candidate-cnt">
        <!--Add Team Content-->
        <div class="add-team-bx">
           <h3>Team Details</h3>
           <ul>
              <li>
                 <label>First Name</label>
                 <input type="hidden" id="team_id" >
                 <input type="text" class="fld form-control"  id="first-name" >
                 <div id="first-name-error">&nbsp;</div>
              </li>
              <li>
                 <label>Last Name</label>
                 <input type="text" class="fld form-control" id="last-name" >
                 <div id="last-name-error">&nbsp;</div>
              </li>
              <li>
                 <label>Email Address</label>
                 <input type="text" class="fld form-control" id="email-id" >
                 <div id="email-id-error">&nbsp;</div>
              </li>
              <li>
                 <label>Phone Number</label>
                 <input type="text" class="fld form-control" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="contact-no">
                 <div id="contact-no-error">&nbsp;</div>
              </li>
              <li class="d-none">
                 <label>Username</label>
                 <input type="text" class="fld form-control" id="user-name" autocomplete="off" >
                  <div id="user-name-error">&nbsp;</div>
              </li>
              <li class="d-none">
                 <label>Password</label>
                 <input type="password" class="fld form-control" id="team-password" autocomplete="off" >
                 <div id="new-password-error-msg-div">&nbsp;</div>
              </li>
              <li class="d-none">
                 <label>Confirm Password</label>
                 <input type="password" class="fld form-control" id="confirm-team-password" autocomplete="off" >
                 <div id="new-confirm-password-error-msg-div">&nbsp;</div>
              </li>
              <li>
                 <label>Role</label>
                 <select class="fld form-control" id="role">
                    <option value="">Select Role</option>
                    <?php
                    foreach ($role as $key => $roles) {
                      echo "<option value='".strtolower($roles['role_name'])."'>{$roles['role_name']}</option>";
                    }
                    ?>
                 </select>
                 <div id="role-error">&nbsp;</div>
              </li>
              <li>
                 <label>Reporting Manager</label>
                 <select class="fld form-control" id="report-manager">  
                 </select>
                 <div id="report-manager-error">&nbsp;</div>
              </li>

               <li>
                 <label>Approval List</label>
                 <select class="fld form-control" id="approval-list" >
                    <option value="">Approval List</option>
                    <?php 
                      foreach ($approval as $key => $val) {
                        echo "<option class='text-capitalize' value='".strtolower($val['id'])."'>{$val['name']}</option>";
                      }
                    ?>
                 </select>
                 <div id="approval-list-error">&nbsp;</div>
              </li>
              <li>
                 <label>Approver</label>
                 <select class="fld form-control" id="approval">
                    <option value="0">None</option>
                    <option value="1">Approver</option>
                     
                 </select>
                 <div id="approver-error">&nbsp;</div>
              </li>
           </ul>
           </div>


           <div class="add-team-bx" id="access-level">
           <h3>Approval Level Permissions</h3>
           <ul>
              <li class="approval_level_of" id="approval_level_of1" style="display:none;">
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input approval-level" name="approval-level" value="1" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Level 1</label>
                 </div>
              </li>
              <li class="approval_level_of" id="approval_level_of2" style="display:none;">
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input approval-level" name="approval-level" value="2" id="customCheck2">
                    <label class="custom-control-label" for="customCheck2">Level 2</label>
                 </div>
              </li>
              <li class="approval_level_of" id="approval_level_of3" style="display:none;">
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input approval-level" name="approval-level" value="3" id="customCheck3">
                    <label class="custom-control-label" for="customCheck3">Level 3</label>
                 </div>
              </li>
             
           </ul>
        </div>

           <div class="row add-team-bx" id="segment-list-div"></div>
        <div class="add-team-bx" id="team-skill-div">
           <h3>Skill</h3>
           <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" class="custom-control-input" name="customCheck" id="CheckAll">
                  <label class="custom-control-label" for="CheckAll"><strong>Select All</strong></label>
               </div>
           <ul id="team-skills-list">
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input skills" value="Address Chack" name="customCheck" id="customCheck8">
                    <label class="custom-control-label" for="customCheck8">Address Chack</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input skills" value="Court Chack" name="customCheck" id="customCheck9">
                    <label class="custom-control-label" for="customCheck9">Court Check</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input skills" value="Criminal Chack" name="customCheck" id="customCheck10">
                    <label class="custom-control-label" for="customCheck10">Criminal Check</label>
                 </div>
              </li>
           </ul>
           <div id="skill-error"></div>
        </div>
        <div class="add_team" id="error-team"></div>
        <div class="sbt-btns">
           <a href="#" data-dismiss="modal" class="bg-gry btn-submit-cancel">Cancel</a> <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu btn-submit-cancel">Submit</a>
        </div>
        <!--Add Team Content-->
     </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Delete Modal Ends -->

   <!-- Delete Modal Starts -->
  <div class="modal fade" id="remove-team-view">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-body modal-body-delete-coupon">
          <div class="row">
            <div class="col-md-8">
              <input type="hidden" id="remove_team_id">
              <h4 class="modal-title-delete-product-category">Are you sure you want to delete this team member?</h4>
            </div>
            <div class="col-md-4"> 
            <div class="sbt-btns">
             <a href="#" data-dismiss="modal" class="bg-gry mb-1 btn-submit-cancel">Cancel</a> 
             <a href="#" id="team-submit-btn" onclick="delete_team()" class="bg-blu btn-submit-cancel">Delete</a>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Delete Modal Ends -->
 


   <!-- Delete Modal Starts -->
  <div class="modal fade" id="team-change-pass-div">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-body modal-body-delete-coupon">
         <h6>Change Password</h6>
          <div class="row">
              <input type="hidden" id="selected_team_id">
              <div class="col-md-12 form-group">
                  <input type="password" id="new-password" class="form-control sign-fld mb-0" placeholder="New Password">
                  <div class="text-left" id="new-password-error-msg-div"></div>
               </div>
               <div class="col-md-12 form-group">
                  <input type="password" id="verify-new-password" class="form-control sign-fld mb-0" placeholder="Verify New Password">
                  <div class="text-left" id="verify-new-password-error-msg-div"></div>
               </div>
            <div class="col-md-12"> 
            <div class="sbt-btns">
             <a href="#" data-dismiss="modal" class="bg-gry mb-1 btn-submit-cancel">Cancel</a> 
             <a href="#" id="save-password-btn" class="bg-blu btn-submit-cancel">Update</a>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Delete Modal Ends -->
 
<script>
   var component_config_name = "<?php echo $this->config->item('show_component_name'); ?>";
</script>
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/team/view-team.js"></script>
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/team/edit-team.js"></script>
