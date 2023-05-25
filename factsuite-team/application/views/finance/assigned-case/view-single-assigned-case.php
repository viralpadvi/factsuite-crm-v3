
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt">
         <!-- <h3>Case Detail</h3> -->
          <?php 
          $url = 'factsuite-outputqc/assigned-case-list';
          if ($status == '2') {
            $url = 'factsuite-outputqc/assigned-completed-case-list';
          }

          if (isset($_GET['flag'])) {
             $url = 'factsuite-outputqc/assigned-error-case-list'; 
          }
          ?>
          <a class="btn bg-blu btn-submit-cancel" href="<?php echo $this->config->item('my_base_url').$url; ?>" ><span class="text-white">Back</span></a>

          <div class="row mt-4">
            <div class="col-md-4">
              <label class="font-weight-bold">Case ID: </label>&nbsp;<span id="caseId">2</span>
            </div>
            
          </div>
          <div class="row">
            <div class="col-md-4">
              <label class="font-weight-bold">Candidate Name: </label>&nbsp;<span id="camdidateName">-</span>
            </div>
            <div class="col-md-4">
              <label class="font-weight-bold">Client Name: </label>&nbsp;<span id="clientName">Hindustan Unilever Ltd</span>
            </div>
          </div>
          <div class="row">
            <div id="priority-div" class="col-md-4">
               <!-- priority dropdown in JS -->
            </div> 
            <div class="col-md-4 d-none">
              <label class="font-weight-bold">Phone Number: </label>&nbsp;<span id="camdidatephoneNumber">1234567890</span>
            </div>
            <div class="col-md-4">
              <label class="font-weight-bold">Package Name: </label>&nbsp;<span id="packageName">Hindustan</span>
            </div>
          </div>
          <div class="row">           
            <div id="report-button" class="col-md-4">
              
            </div>
            <div class="col-md-4 d-none">
              <label class="font-weight-bold">Email Id: </label>&nbsp;<span id="camdidateEmailId">abc@gmail.com</span>
            </div>
            <div class="col-md-4">
                <label class="font-weight-bold">LOA &nbsp;&nbsp;&nbsp;<a target="_blank" href="<?php echo $this->config->item('my_base_url').'factsuite-admin/candidate-loa-pdf/'.md5($candidate_id); ?>"><i class="fa fa-file-pdf-o"></i></a></label>
            </div>

          </div>
          <div class="row">
            
          </div>
          <div class="table-responsive mt-3" id="">
          <table class="table table-striped datatable1">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Component Name</th>  
                <th>analyst Status</th>  
                <th>Component Status</th>  
                <th class="text-center">Component Details</th>  
                <!-- <th>Insufficiency</th>  --> 
                <!-- <th>View Component Detail</th>   -->
              </tr>
            </thead>
            <tbody id="get-case-data"></tbody>
          </table>
        </div>
     </div>
  </div>
</section>
<!--Content-->


<!-- Popup Content -->
<form>
<div id="sendMail" class="modal fade">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
             <h3 class="snd-mail-pop">Send Mail <img src="<?php echo base_url()?>assets/admin/images/email_open_100px.png" alt=""> </h3>
             <div class="row mt-3">
                 <div class="col-md-4">
                     <p class="pa-pop">Case ID : 1245DGT</p>
                 </div>
                 <div class="col-md-8">
                     <p  class="pa-pop">From : analyst@factsuite.com</p>
                 </div>
             </div>
             <textarea class="message">Message...</textarea>
             <div class="form-group w-100 mt-2">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
            </div>
                <button class="btn bg-blu btn-submit-cancel float-right text-white">Send</button>
             <div class="clr"></div>
          </div>
       </div>
    </div>
</div>
</form>
<!-- Popup Content -->

<!-- <div id="modalPending" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
             <h3 class="snd-mail-pop">Send Mail <img src="<?php echo base_url()?>assets/admin/images/email_open_100px.png" alt=""> </h3>
             <div class="row mt-3">
                 <div class="col-md-4">
                     <p class="pa-pop">Case ID : 1245DGT</p>
                 </div>
                 <div class="col-md-8">
                     <p  class="pa-pop">From : analyst@factsuite.com</p>
                 </div>
             </div>
             <textarea class="message">Message...</textarea>
             <div class="form-group w-100 mt-2">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
            </div>
                <button class="btn bg-blu btn-submit-cancel float-right text-white">Cancle</button>
                <button class="btn bg-blu btn-submit-cancel float-right text-white">Confirm</button>
             <div class="clr"></div>
          </div>
       </div>
    </div>
 </div> -->

<!-- Conformation popup -->
<div id="conformtion" class="modal fade">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-pending-bx">
        <h3 id="ask-quaction" class="snd-mail-pop">Do you want to Confirm?</h3>
        <!-- <div class="row mt-3">
          <div class="col-md-4">
            <p class="pa-pop">Case ID :  <?php //echo $componentData['candidate_id']?></p>
          </div>
          <div class="col-md-8">
            <p  class="pa-pop">Candidate Name : <?php //echo $candidateName = $componentData['first_name']." ".$componentData['last_name'];?></p>
          </div>
        </div> -->
        <p class="pa-pop text-warning" id="wait-message"></p>
        <div id="button-div">
          
        </div>
        
        <div class="clr">
        </div>
      </div>
    </div>
  </div>
</div>


<script src="<?php echo base_url() ?>assets/custom-js/outputqc/assigned-case/view-single-case.js"></script>
<script>
 load_case(<?php echo $candidate_id;?>); 
</script>