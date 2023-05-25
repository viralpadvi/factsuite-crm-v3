 
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin"> 
        <h3>Component Form Request</h3>
          <div class="table-responsive mt-3" id="">
          <table class="table-fixed  datatable table table-striped">
            <thead class="table-fixed-thead thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Request form</th> 
                <th>Component Name</th> 
                <th>Client Name</th> 
                <th>Package Name</th> 
                <th>Requester Name</th>  
                <th>Status</th>   
              </tr>
            </thead>
            <tbody class="table-fixed-tbody tbody-datatable" id="get-case-data"> 
            </tbody>
          </table>
        </div>
     </div>
  </div>
</section>
<!--Content-->


<!-- Popup Content -->
<!-- <form> -->
<div id="SendMail" class="modal fade">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body">
            <div class="raise-issue-txt">
               <h3>Send Mail</h3>
               <ul>
                  <li>Case ID: <span>1245DGT</span></li>
                  <li>To: <span>finance@factsuite.com</span></li>
               </ul>
            </div>
            <div class="raise-issue-cnt">
               <textarea name="" cols="" rows="" class="fld2" placeholder="Message"></textarea>
               <div id="fls">
                  <div class="form-group files">
                     <label class="btn" for="file1"><a class="fl-btn">UPLOAD DOCUMENT</a></label>
                     <input id="file1" type="file" style="display:none;" class="form-control fl-btn-n" multiple>
                     <div class="file-name1"></div>
                  </div>
               </div>
               <div class="raise-issue-btn"><a href="#">Send</a></div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- </form> -->
<!-- Popup Content -->
 

<script src="<?php echo base_url() ?>assets/custom-js/admin/request/view-all-request.js"></script>  