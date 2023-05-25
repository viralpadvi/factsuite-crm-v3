<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
          <div id="FS-candidate-mn" class="add-team">
            <ul class="nav nav-tabs nav-justified"> 
               <li class="nav-item">
                 <a class="nav-link" href="<?php echo $this->config->item('my_base_url').'factsuite-admin/add-team'; ?>">Add Team Member</a>
              </li>
              <li class="nav-item">
                 <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'factsuite-admin/view-team'; ?>">View Team</a>
              </li>
              <li class="nav-item d-none">
                 <a class="nav-link" href="#">Analytics</a>
              </li>
              <li class="nav-item">
              <a class="nav-link active" href="<?php echo $this->config->item('my_base_url').'role'; ?>">Role</a>
           </li>
            </ul>
        </div>
      </div>
   </div>
</section>
<section id="pg-cntr">
  <div class="pg-hdr">
     <!--Nav Tabs-->
    <!--  <div id="FS-candidate-mn" class="add-team">
        <ul class="nav nav-tabs nav-justified"> 
           <li class="nav-item">
              <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'component'; ?>">Component</a>
           </li>
           <li class="nav-item">
              <a class="nav-link" href="<?php echo $this->config->item('my_base_url').'package'; ?>">Package</a>
           </li>
            <li class="nav-item">
              <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'factsuite-admin/factsuite-alacarte'; ?>">Alacarte</a>
           </li>
            <li class="nav-item">
              <a class="nav-link active" href="<?php echo $this->config->item('my_base_url').'role'; ?>">Role</a>
           </li>
        </ul>
     </div> -->
     <!--Nav Tabs-->
  </div>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt" >
         <h3>Role Details</h3>
        <div class="sbt-btns">
          <a href="#" id="team-submit-btn" data-toggle="modal" data-target="#add_role"class="btn bg-blu btn-submit-cancel">Create&nbsp;Role</a>
        </div>
        <div class="table-responsive" id="">
          <table class="datatable1 table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Role&nbsp;Name</th>  
                <th>Role&nbsp;Status</th>  
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
  <div class="modal fade" id="add_role">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Create&nbsp;Role</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2">
               
              <div class="col-sm-6">
                <label class="product-details-span-light">Role Name</label>
                <input type="text" class="fld" name="role_name" id="role_name" placeholder="Enter role Name">
                <div id="role-name-error-msg-div"></div>  
              </div>
              <div class="col-md-12 add-team-bx">
                <hr>
                <ul id="team-skills-list">
              <!--     <li><label>Dashboard</label></li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input dashboard" value="3" name="customCheck" id="dashboard">
                    <label class="custom-control-label" for="dashboard">View</label>
                 </div>
              </li> -->
              
           </ul>
              </div>
               <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>Client</label></li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input clients" name="customCheck" value="1" id="client1">
                    <label class="custom-control-label" for="client1">Add</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input clients" name="customCheck" value="2" id="client2">
                    <label class="custom-control-label" for="client2">Edit & View</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input clients"  name="customCheck" value="3" id="client3">
                    <label class="custom-control-label" for="client3">View Only</label>
                 </div>
              </li>
           </ul>
              </div>

        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>All Cases</label></li>
             
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input cases"  name="customCheck" value="3" id="cases">
                    <label class="custom-control-label" for="cases">View</label>
                 </div>
              </li>
           </ul>
              </div>

        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>MIS Report</label></li>
             
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input mis"  name="customCheck" value="3" id="mis">
                    <label class="custom-control-label" for="mis">View</label>
                 </div>
              </li>
           </ul>
              </div>

        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>Components</label></li>
               
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input component"  name="customCheck" value="3" id="component">
                    <label class="custom-control-label" for="component">View</label>
                 </div>
              </li>
           </ul>
        </div>

        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>BGV Reports</label></li>
               
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input bgv"  name="customCheck" value="3" id="bgv">
                    <label class="custom-control-label" for="bgv">View</label>
                 </div>
              </li>
           </ul>
        </div>

        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>FS Team</label></li>
               
               <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input teams" name="customCheck" value="1" id="team1">
                    <label class="custom-control-label" for="team1">Add</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input teams" name="customCheck" value="2" id="team2">
                    <label class="custom-control-label" for="team2">Edit & View</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input teams"  name="customCheck" value="3" id="team3">
                    <label class="custom-control-label" for="team3">View Only</label>
                 </div>
              </li>
           </ul>
        </div>

        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>Client Mandate</label></li>
               
               <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input mandate" name="customCheck" value="1" id="mandate1">
                    <label class="custom-control-label" for="mandate1">Add</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input mandate" name="customCheck" value="2" id="mandate2">
                    <label class="custom-control-label" for="mandate2">Edit & View</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input mandate"  name="customCheck" value="3" id="mandate3">
                    <label class="custom-control-label" for="mandate3">View Only</label>
                 </div>
              </li>
           </ul>
        </div>


        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>Tickets</label></li>
               
               <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input ticket" name="customCheck" value="1" id="ticket1">
                    <label class="custom-control-label" for="ticket1">Add & View</label>
                 </div>
              </li> 

              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input ticket"  name="customCheck" value="3" id="ticket3">
                    <label class="custom-control-label" for="ticket3">View</label>
                 </div>
              </li>
           </ul>
        </div>
 
        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>Education Database</label></li>
               
               <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input education" name="customCheck" value="1" id="education1">
                    <label class="custom-control-label" for="education1">Add & View</label>
                 </div>
              </li> 

              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input education"  name="customCheck" value="3" id="education3">
                    <label class="custom-control-label" for="education3">View</label>
                 </div>
              </li>
           </ul>
        </div>
 
        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>Employment Database</label></li>
               
               <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input employment" name="customCheck" value="1" id="employment1">
                    <label class="custom-control-label" for="employment1">Add & View</label>
                 </div>
              </li> 

              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input employment"  name="customCheck" value="3" id="employment3">
                    <label class="custom-control-label" for="employment3">View Only</label>
                 </div>
              </li>
           </ul>
        </div>
 
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-role-btn" name="edit-role-close-btn" onclick="addrole()">Save</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Add role Modal Ends -->


  <!-- Edit role Modal Starts -->
   <div class="modal fade" id="edit_role">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">EDIT&nbsp;ROLE</h4> 
        </div>
        <input type="hidden" name="edit_role_id" id="edit_role_id">
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content"> 
            <div class="row mt-12"> 
              <div class="col-sm-6">
                <label class="product-details-span-light">Role Name</label>
                <input type="text" class="fld" name="edit_role_name" id="edit_role_name" placeholder="Enter role Name">
                <div id="edit-role-name-error-msg-div"></div>  
              </div> 


                <div class="col-md-12 add-team-bx">
                <hr>
                <ul id="team-skills-list">
              <!--     <li><label>Dashboard</label></li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input dashboard" value="3" name="customCheck" id="dashboard">
                    <label class="custom-control-label" for="dashboard">View</label>
                 </div>
              </li> -->
              
           </ul>
              </div>
               <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>Client</label></li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-clients" name="customCheck" value="1" id="edit-client1">
                    <label class="custom-control-label" for="edit-client1">Add</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-clients" name="customCheck" value="2" id="edit-client2">
                    <label class="custom-control-label" for="edit-client2">Edit & View</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-clients"  name="customCheck" value="3" id="edit-client3">
                    <label class="custom-control-label" for="edit-client3">View Only</label>
                 </div>
              </li>
           </ul>
              </div>

        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>All Cases</label></li>
             
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-cases"  name="customCheck" value="3" id="edit-cases">
                    <label class="custom-control-label" for="edit-cases">View</label>
                 </div>
              </li>
           </ul>
              </div>

        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>MIS Report</label></li>
             
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-mis"  name="customCheck" value="3" id="edit-mis">
                    <label class="custom-control-label" for="edit-mis">View</label>
                 </div>
              </li>
           </ul>
              </div>

        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>Components</label></li>
               
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-component"  name="customCheck" value="3" id="edit-component">
                    <label class="custom-control-label" for="edit-component">View</label>
                 </div>
              </li>
           </ul>
        </div>

        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>BGV Reports</label></li>
               
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-bgv"  name="customCheck" value="3" id="edit-bgv">
                    <label class="custom-control-label" for="edit-bgv">View</label>
                 </div>
              </li>
           </ul>
        </div>

        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>FS Team</label></li>
               
               <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-teams" name="customCheck" value="1" id="edit-team1">
                    <label class="custom-control-label" for="edit-team1">Add</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-teams" name="customCheck" value="2" id="edit-team2">
                    <label class="custom-control-label" for="edit-team2">Edit & View</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-teams"  name="customCheck" value="3" id="edit-team3">
                    <label class="custom-control-label" for="edit-team3">View Only</label>
                 </div>
              </li>
           </ul>
        </div>

        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>Client Mandate</label></li>
               
               <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-mandate" name="customCheck" value="1" id="edit-mandate1">
                    <label class="custom-control-label" for="edit-mandate1">Add</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-mandate" name="customCheck" value="2" id="edit-mandate2">
                    <label class="custom-control-label" for="edit-mandate2">Edit & View</label>
                 </div>
              </li>
              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-mandate"  name="customCheck" value="3" id="edit-mandate3">
                    <label class="custom-control-label" for="edit-mandate3">View Only</label>
                 </div>
              </li>
           </ul>
        </div>


        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>Tickets</label></li>
               
               <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-ticket" name="customCheck" value="1" id="edit-ticket1">
                    <label class="custom-control-label" for="edit-ticket1">Add & View</label>
                 </div>
              </li> 

              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-ticket"  name="customCheck" value="3" id="edit-ticket3">
                    <label class="custom-control-label" for="edit-ticket3">View</label>
                 </div>
              </li>
           </ul>
        </div>
 
        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>Education Database</label></li>
               
               <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-education" name="customCheck" value="1" id="edit-education1">
                    <label class="custom-control-label" for="edit-education1">Add & View</label>
                 </div>
              </li> 

              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-education"  name="customCheck" value="3" id="edit-education3">
                    <label class="custom-control-label" for="edit-education3">View</label>
                 </div>
              </li>
           </ul>
        </div>
 
        <div class="col-md-12 add-team-bx">
                
                <ul id="team-skills-list">
                  <li><label>Employment Database</label></li>
               
               <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-employment" name="customCheck" value="1" id="edit-employment1">
                    <label class="custom-control-label" for="edit-employment1">Add & View</label>
                 </div>
              </li> 

              <li>
                 <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input edit-employment"  name="customCheck" value="3" id="edit-employment3">
                    <label class="custom-control-label" for="edit-employment3">View Only</label>
                 </div>
              </li>
           </ul>
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
<script src="<?php echo base_url(); ?>assets/custom-js/admin/role/view-role.js"></script> 
