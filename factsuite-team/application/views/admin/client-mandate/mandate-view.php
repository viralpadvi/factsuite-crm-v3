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
         
        <div class="table-responsive" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Client&nbsp;Name</th>  
                <th>Package&nbsp;Name</th>  
                <th>Mandate&nbsp;Description</th> 
                <th>Special Instructions</th>   
                <th>View</th>  
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
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
              <div class="col-md-12">
                <label class="product-details-span-light">Mandate Description</label>
                 
                <textarea class="fld ckeditor" name="mandate-description" id="mandate-description" placeholder="Mandate Description"></textarea>
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
          <h4 class="modal-title-edit-coupon">View&nbsp;Mandate Description</h4> 
        </div> 
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content" id="mandate-description-view"> 
             
          </div> 
          <label>Components</label>
          <div class="row" id="mandate-component-view">
            
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-gry btn-close text-white" id="edit-role-close-btn" name="add-role-close-btn" data-dismiss="modal">Close</button>
          
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;role</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Coupon Modal Ends -->

</section>
<!--Content-->
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/mandate/all-view-mandate.js"></script> 
