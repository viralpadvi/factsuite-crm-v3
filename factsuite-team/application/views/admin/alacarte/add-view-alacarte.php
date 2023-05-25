<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      <div class="pg-hdr-mn">
          <div id="FS-candidate-mn" class="add-team">
            <ul class="nav nav-tabs nav-justified">
                
               <li class="nav-item">
                  <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'component'; ?>">Component</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'package'; ?>">Package</a>
               </li>
                <li class="nav-item d-none">
                  <a class="nav-link active" href="<?php echo $this->config->item('my_base_url').'factsuite-admin/factsuite-alacarte'; ?>">Alacarte</a>
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
              <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'component'; ?>">Component</a>
           </li>
           <li class="nav-item">
              <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'package'; ?>">Package</a>
           </li>
            <li class="nav-item">
              <a class="nav-link active" href="<?php echo $this->config->item('my_base_url').'factsuite-admin/factsuite-alacarte'; ?>">Alacarte</a>
           </li>
           <li class="nav-item">
              <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'role'; ?>">Role</a>
           </li>
        </ul>
     </div> -->
     <!--Nav Tabs-->
  </div>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt">
         <h3>Alacarte Details</h3>
        <div class="sbt-btns">
          <a href="#" id="team-submit-btn" data-toggle="modal" data-target="#add_alacarte"class="btn bg-blu btn-submit-cancel">ADD&nbsp;ALACARTE</a>
        </div>
        <div class="table-responsive mt-3" id="">
           <table class="table-fixed datatable table table-striped">
            <thead class="table-fixed-thead thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Alacarte&nbsp;Name</th> 
                <th>Alacarte&nbsp;Component&nbsp;Details</th>  
                <th>Alacarte&nbsp;Status</th>  
                <th>Action</th>  
              </tr>
            </thead>
            <tbody class="table-fixed-tbody  tbody-datatable" id="get-team-data"> 
            </tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>

  <!-- Add package Modal Starts -->
  <div class="modal fade" id="add_alacarte">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">ADD&nbsp;Alacarte</h4> 
        </div>
         
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-2">
               
              <div class="col-sm-6">
                <label class="product-details-span-light">Alacarte Name</label>
                <input type="text" class="fld" name="alacarte_name" id="alacarte_name" placeholder="Enter Alacarte Name">
                <div id="alacarte-name-error-msg-div"></div>  
              </div>
              
            </div>
            <div class="row mt-2">
              <div class="col-sm-12">
                <label class="product-details-span-light">Component List</label>
                  <div class="row">
                  <?php
                    $i =0;
                    
                    foreach ($components as $value) {
                     
                  ?> 
                  
                    <div class="col-md-4">
                      
                      <div class=" custom-control custom-checkbox custom-control-inline">
                        <input  type="checkbox" 
                                class="custom-control-input components" 
                                value="<?php echo $value['component_id']?>" 
                                name="componentCheck" 
                                id="componentCheck<?php echo $value['component_id']?>"
                                onclick = "GetSelected()">

                        <label class="custom-control-label" for="componentCheck<?php echo $value['component_id']?>">
                          <?php echo $value['component_name']?>
                        </label>
                      </div>
                    </div>
                    
                    
                  <?php
                      $i++;
                    }
                  ?>
                   </div>
                <div id="alacarte-price-error-msg-div"></div>  
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-blu btn-close text-white" id="edit-alacarte-close-btn" name="add-alacarte-close-btn" data-dismiss="modal">Close</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-alacarte-btn" name="edit-alacarte-close-btn" onclick="addAlacarte()">Save</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;package</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Add package Modal Ends -->


  <!-- Edit package Modal Starts -->
   <div class="modal fade" id="edit_alacarte">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-edit">
        <div class="modal-header border-0"> 
          <h4 class="modal-title-edit-coupon">EDIT&nbsp;alacarte</h4> 
        </div>
        <input type="hidden" name="edit_alacarte_id" id="edit_alacarte_id">
        <div class="modal-body modal-body-edit-coupon">
            <div class="tab-content">
             
            <div class="row mt-12">
               
              <div class="col-sm-6">
                <label class="product-details-span-light">Alacarte Name</label>
                <input type="text" class="fld" name="edit_alacarte_name" id="edit_alacarte_name" placeholder="Enter alacarte Name">
                <div id="edit-alacarte-name-error-msg-div"></div>  
              </div>
              
              
            </div>
            
             
          </div>
          <div class="row mt-2">
              <div class="col-sm-12">
                <label class="product-details-span-light">Component List</label>
                  <div class="row" id="componentCheckbox">
                    <div class="col-md-4">
                       
                    </div>
                   </div>
                <div id="alacarte-price-error-msg-div"></div>  
              </div>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn bg-blu btn-close text-white" id="edit-alacarte-close-btn" name="add-alacarte-close-btn" data-dismiss="modal">Close</button>
          <button type="button" class="btn bg-blu btn-close text-white" 
          id="add-alacarte-btn" name="edit-alacarte-close-btn" onclick="updateData()">Update</button>
         <!--  <a href="#" id="team-submit-btn" onclick="add_team()" class="bg-blu">ADD&nbsp;package</a> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Edit Coupon Modal Ends -->

</section>
<!--Content-->
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/admin/alacarte/view-alacarte.js"></script> 
