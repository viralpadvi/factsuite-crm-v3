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
         <h3>Nomenclature Details</h3>
        <div class="sbt-btns">
          <a href="#" id="team-submit-btn" data-toggle="modal" data-target="#add_nomanclature"class="btn bg-blu btn-submit-cancel">Add Nomenclature</a>
        </div>
        <div class="table-responsive" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Client Name</th>    
                <th>Total Report</th>    
                <th>Green</th>    
                <th>Orange</th>    
                <th>Red</th>    
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
  <div class="modal fade" id="add_nomanclature">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon-1">Add&nbsp;Nomenclature</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2">
                 <div class="col-md-6">
            <label>Select Your Client</label>
            <select class="fld form-control" id="client_id">
               <option value="">Select Your Client</option>
               <option value="0">ALL</option>
               <?php
                  foreach ($clientInfo as $key => $value) {
                     $select = '';
                     if (isset($_GET['client_id'])) {
                        if ($_GET['client_id'] == $value['client_id']) { 
                       $select = 'selected';
                        }
                     }
                     echo '<option '.$select.' value="'.$value['client_id'].'">'.$value['client_name'].'</option>';
                  }
               ?>
            </select>             
            <div id="select-client-error">&nbsp;</div>                          
         </div> 
         <div class="col-sm-6"></div>


              <div class="col-sm-6">
                <label class="product-details-span-light">All Report</label>
                <!-- <input type="text" class="fld nomanclature" name="nomanclature" id="nomanclature" placeholder="Select Date"> -->
                <input type="text" class="fld" placeholder="All Report" id="add-all" name="">
                <div id="nomanclature-error-msg-div"></div>  
              </div>
               
              <div class="col-sm-6">
                <label class="product-details-span-light">Green Report</label> 
                <input type="text" id="green" placeholder="Green Report" class="fld" name="">
                <div id="clock-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6">
                <label class="product-details-span-light">Red Report</label> 
                <input type="text" id="red" placeholder="Red Report" class="fld" name="">
                <div id="time-type-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6">
                <label class="product-details-span-light">Orange Report</label> 
                <input type="text" id="orange" placeholder="Orange Report" class="fld" name="">
                <div id="time-formate-error-msg-div"></div>  
              </div>
              
            </div>
             
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-role-btn" name="edit-role-close-btn" onclick="addnomanclature()">Save</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Add role Modal Ends -->



  <!-- Edit role Modal Starts -->
   <div class="modal fade" id="edit_nomanclature">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">Edit Nomenclature</h4> 
        </div>
        <input type="hidden" name="nomenclature_id" id="nomenclature_id">
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content"> 
            <div class="row mt-2">
                 <div class="col-md-6">
            <label>Select Your Client</label>
            <select class="fld form-control" id="edit-client_id">
               <option value="">Select Your Client</option>
               <option value="0">ALL</option>
               <?php
                  foreach ($clientInfo as $key => $value) {
                     $select = '';
                     if (isset($_GET['client_id'])) {
                        if ($_GET['client_id'] == $value['client_id']) { 
                       $select = 'selected';
                        }
                     }
                     echo '<option '.$select.' value="'.$value['client_id'].'">'.$value['client_name'].'</option>';
                  }
               ?>
            </select>             
            <div id="select-client-error">&nbsp;</div>                          
         </div> 
         <div class="col-sm-6"></div>

              <div class="col-sm-6">
                <label class="product-details-span-light">All Report</label>
                <!-- <input type="text" class="fld nomanclature" name="nomanclature" id="nomanclature" placeholder="Select Date"> -->
                <input type="text" class="fld" placeholder="All Report" id="edit-all" name="">
                <div id="nomanclature-error-msg-div"></div>  
              </div>
               
              <div class="col-sm-6">
                <label class="product-details-span-light">Green Report</label> 
                <input type="text" id="edit-green" placeholder="Green Report" class="fld" name="">
                <div id="clock-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6">
                <label class="product-details-span-light">Red Report</label> 
                <input type="text" id="edit-red" placeholder="Red Report" class="fld" name="">
                <div id="time-type-error-msg-div"></div>  
              </div>
              
              <div class="col-sm-6">
                <label class="product-details-span-light">Orange Report</label> 
                <input type="text" id="edit-orange" placeholder="Orange Report" class="fld" name="">
                <div id="time-formate-error-msg-div"></div>  
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
<script src="<?php echo base_url(); ?>assets/custom-js/admin/color/add-color.js"></script> 
