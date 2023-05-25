<!--Content-->
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
<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
         <div id="FS-candidate-mn" class="add-team w-75">
            <ul class="nav nav-tabs nav-justified">
               <!-- <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->config->item('my_base_url').'role'; ?>">Role</a>
               </li> -->
               <?php 
                if (in_array($user['role'], ['admin','csm']) || in_array(1, $teams)) {  
               ?>
               <li class="nav-item">
                  <a class="nav-link active" href="#">Add Team Member</a>
               </li>
               <?php 
            }
                if (in_array($user['role'], ['admin','csm']) || in_array(2, $teams) || in_array(3, $teams)) {  
               ?>
               <li class="nav-item">
                  <a class="nav-link" href="<?php echo $this->config->item('my_base_url').'factsuite-admin/view-team'; ?>">View Team</a>
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
              <a class="nav-link active" href="#">Add Team</a>
           </li>
           <li class="nav-item">
              <a class="nav-link" href="<?php echo $this->config->item('my_base_url').'factsuite-admin/view-team'; ?>">View Team</a>
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
        <!--Add Team Content-->
        <div class="add-team-bx">
           <h3>Team Member Details</h3>
           <ul>
              <li>
                 <label>First Name</label>
                 <input type="text" class="fld form-control" id="first-name" >
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
                 <input type="text" class="fld form-control" id="useEDUCATIONALr-name" autocomplete="off" >
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
                        echo "<option class='text-capitalize' value='".strtolower($roles['role_name'])."'>{$roles['role_name']}</option>";
                      }
                    ?>
                 </select>
                 <div id="role-error">&nbsp;</div>
              </li>
              <li>
               
                 <label>Reporting Manager</label>
                 <select class="fld form-control" id="report-manager">
                  <?php
                  if (count($team) > 0) {
                     foreach ($team as $key => $value) {
                         echo "<option value='".$value['team_id']."'>".$value['first_name']." (".$value['role'].")</option>";
                      } 
                  }else{
                     echo "<option value=''>Not Available</option>";
                  }
                  ?>
                    
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
                 <select class="fld form-control" id="approver">
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
                    <input type="checkbox" class="custom-control-input approval-level" name="customCheck approval-level" value="1" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Level 1</label>
                 </div>
              </li>
              <li class="approval_level_of" id="approval_level_of2" style="display:none;">
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input approval-level" name="customCheck approval-level" value="2" id="customCheck2">
                    <label class="custom-control-label" for="customCheck2">Level 2</label>
                 </div>
              </li>
              <li class="approval_level_of" id="approval_level_of3" style="display:none;">
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input approval-level" name="customCheck approval-level" value="3" id="customCheck3">
                    <label class="custom-control-label" for="customCheck3">Level 3</label>
                 </div>
              </li>
             
           </ul>
        </div>

            <div class="row add-team-bx" id="segment-list-div"></div>
            
           <div class="add-team-bx d-none">
           <h3>Access Permissions</h3>
           <ul>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Team Lead</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck2">
                    <label class="custom-control-label" for="customCheck2">Data Entry</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck3">
                    <label class="custom-control-label" for="customCheck3">Supervisor</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck4">
                    <label class="custom-control-label" for="customCheck4">Field Verifier</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck5">
                    <label class="custom-control-label" for="customCheck5">General Manager</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck6">
                    <label class="custom-control-label" for="customCheck6">Address Check</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="customCheck" id="customCheck7">
                    <label class="custom-control-label" for="customCheck7">General Manager</label>
                 </div>
              </li>
           </ul>
        </div>
        <div class="add-team-bx" style="display: none;" id="team-skill-div">
           <h3>Skill</h3>
            <div class="custom-control custom-checkbox custom-control-inline mrg">
               <input type="checkbox" class="custom-control-input" name="customCheck" id="CheckAll">
               <label class="custom-control-label" for="CheckAll"><strong>Select All</strong></label>
            </div>
           <ul id="team-skills-list"><!-- 
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
              </li> -->
           </ul>
           <div id="skill-error"></div>
        </div>
        <div class="add_team" id="error-team"></div>
        <div class="sbt-btns">
           <a href="#" class="bg-gry btn-submit-cancel">Cancel</a> <button id="team-submit-btn" onclick="add_team()" class="bg-blu btn-submit-cancel">Submit</button>
        </div>
        <!--Add Team Content-->
     </div>
  </div>
</section>
<!--Content-->
<script>
   var component_config_name = "<?php echo $this->config->item('show_component_name'); ?>";
</script>
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/team/add-team.js"></script>
