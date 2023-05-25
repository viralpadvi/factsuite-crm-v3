<?php 
$client_name = '';
  if ($this->session->userdata('logged-in-client')) {

    $client_name = $this->session->userdata('logged-in-client')['client_name'];
  }
  
?> 
   <div class="pg-cnt">
      <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
         <div id="FS-allcandidates">   
            <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
              <li class="nav-item" role="presentation">
               <a class="nav-link active" href="<?php echo $this->config->item('my_base_url').$client_name;?>/bulk-upload" >Add Bulk Cases</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" href="<?php echo $this->config->item('my_base_url').$client_name;?>/view-bulk-upload" >View bulk</a>
              </li>
            </ul>
               <div >
                  <div class="add-client-bx">
                     <h3>Candidate Details</h3>
                     <div class="row">
                      
                        <div class="col-md-4"> 
                           <h3>Bulk Case</h3>
                           <input type="file" class="fld" name="excel_upload" id="add-bulk-upload-case" multiple>
                           <div class="file-name1"></div>
                           <div id="file1-error"></div>
                        </div>
                          <div class="col-md-4">
                           <h3>Number Of Candidate</h3>
                           <input type="number" class="fld" value="1" id="number-of-candidate">
                        </div>
                         <div class="col-md-4">
                           <h3>Client Remarks</h3>
                           <input type="text" class="fld" placeholder="Enter Remarks" id="client-remarks">
                        </div>
                     </div>
  
                     <div id="error-client"></div>
                     <div id="submit-button" class="sbt-btns">
                        <button type="button" onclick="add_bulk_cases()" class="btn bg-blu text-white ">Bulk Upload</button>  
                     </div>
                  </div>
               </div>
                
         </div>
      </div>
   </div>
</section>
<!--Content-->

 
<script src="<?php echo base_url() ?>assets/custom-js/case/add-case.js"></script>