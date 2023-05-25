<?php extract($_GET);
$client_name = '';
if ($this->session->userdata('logged-in-client')) {
  $client_name = $this->session->userdata('logged-in-client')['client_name'];
}
$client_name = trim(str_replace(' ','-',$client_name));

$request_from = isset($request_from) ? $request_from : '';
$url = $this->config->item('my_base_url').$client_name.'/all-cases';
if ($request_from != '') {
  if (strtolower($request_from) == 'insuff-cases') {
    $url = $this->config->item('my_base_url').$client_name.'/insuff-cases';
  } else if (strtolower($request_from) == 'client-clarification') {
    $url = $this->config->item('my_base_url').$client_name.'/client-clarification-cases';
  }
}
?>
<h1 class="m-0 text-dark">
  <?php if(isset($param) && $param != '') {
    $url = $this->config->item('my_base_url').$client_name.'/selected-report-cases?param='.$param;
  } ?>
  <a class="pr-3" href="<?php echo $url;?>">
    <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/arrow-right.svg"></a>Case Details</h1>
          </div>
          <div class="col-sm-5">
            <div class="d-none">
              <select id="report-type" class="form-control account-type-dropdown">
                <option value="current">Current Report</option>
                <option value="green">Green Report</option>
                <option value="red">Red Report</option>
                <option value="orange">Orange Report</option>
              </select>
            </div>
          </div>
          <div class="col-sm-2 text-right">
            <a class="nav-link dropdown-toggle dropdown-toggle-without-caret btn custom-btn-1 text-white" href="Javascript:void(0)" id="download-report-dropdown-btn" data-toggle="dropdown">
              Download <img class="pl-2" src="<?php echo base_url(); ?>assets/client/assets-v2/dist/img/download.svg">
            </a>
            <div class="dropdown-menu" id="download-report-dropdown"></div>
            <!-- <div id="report-button-2"></div> -->
          </div>
        </div>
      </div>
    </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2">
          <label class="input-field-txt-2">Case ID</label>
          <div class="input-field input-field-2" id="caseId"></div>
        </div>
        <div class="col-md-3">
          <label class="input-field-txt-2">Candidate Name</label>
          <div class="input-field input-field-2 text-capitalize" id="camdidateName"></div>
        </div>
        <div class="col-md-4">
          <label class="input-field-txt-2">Employee Id</label>
          <div class="input-field input-field-2" id="clientName"></div>
        </div>
        <div class="col-md-3">
          <label class="input-field-txt-2">Phone Number</label>
          <div class="input-field input-field-2" id="camdidatephoneNumber"></div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-5">
          <label class="input-field-txt-2">Email Id</label>
          <div class="input-field input-field-2" id="camdidateEmailId"></div>
        </div>
        <div class="col-md-5">
          <label class="input-field-txt-2">Package Name</label>
          <div class="input-field input-field-2" id="packageName"></div>
        </div>
        <div id="priority-div-2" class="col-md-2"></div>
         <?php 
            if ($this->session->userdata('logged-in-client')) { 
               $user =  $this->session->userdata('logged-in-client');
               $access = isset($single_client['client_access'])?$single_client['client_access']:0;
               if ($access !=0) { 
          ?>
            <div class="col-md-4 text-left mt-4 d-none"> 
              <a class="btn custom-btn-1 text-white mt-2" href="<?php echo $this->config->item('my_base_url').'cases/get_zip/'.$candidate_id;?>">Download Candidates Docs <img class="pl-2" src="<?php echo base_url(); ?>assets/client/assets-v2/dist/img/download.svg"></a>
            </div>
          <?php } } ?>
      </div>
      <div class="row">
        <div class="table-responsive mt-3 col-md-12">
          <table class="table custom-table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Component</th>  
                <th class="text-center">Component Status</th>  
                <th class="text-center">View Details</th>
                <?php if (strtolower($request_from) == 'client-clarification') { ?>
                  <th class="text-center">View Client Clarifications</th>
                <?php } ?>
                <!-- <th>Insufficiency</th>  
                <th>Approve</th>   -->
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-case-data"></tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

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

<div id="modalPending" class="modal fade">
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

 <div id="modalInsuffi" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
             <h3 class="snd-mail-pop">Raise Insufficiency</h3>
             <h4 id="componentNameInsuff" class="pa-pop">Raise Insufficiency</h4>
             <textarea id="insuffMailDetail" class="message mt-3">Hi Ashish, 
                  We noticed that your Address details provided are not sufficient to process your Back Ground Check initiated by your employer.</textarea>
             <div class="form-group w-100 mt-2">
                <input type="text" class="fld" style="border:0;"
                id="candidateUrl"
                placeholder="Please click on the link to complete: http://localhost:8080/factsuitecrm/candidate/" 
                value="http://localhost:8080/factsuitecrm/candidate/" readonly="" disabled>
            </div>
                <div id="btnInsuffiDiv">
                  
                </div>
                
             <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>

 <div id="modalapprov" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx">
              <h3 class="snd-mail-pop">Approve</h3>
              <h4 id="componentNameApprove" class="pa-pop">Raise Insufficiency</h4>
              <textarea id="approve-comment" placeholder="Comment" class="message mt-1"></textarea>

              <div class="form-group w-100 mt-3">
                <label class="upload-btn-pop" for="file1">UPLOAD DOCUMENT</label>
                <input id="file1" type="file" style="display:none;" class="form-control">
                <div class="file-name1"></div>
              </div>
              <div id="btnApproveDiv">
                    
              </div>
              <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>
  <!-- Delete Testimonials Modal Starts -->
  <div class="modal fade" id="edit-team-view">
    <div class="modal-dialog modal-dialog-centered  modal-xl">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div id="FS-candidate-cnt">
      
      
             </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Delete Modal Ends -->

<!-- dynamic Component detail -->
<div id="componentModal" class="modal fade custom-modal custom-modal-component-details">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal-headding"></h4>
        <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/close-modal-symbol.svg"></button>
      </div>
      <div class="modal-body">
        <div class="raise-issue-cnt">
          <div id="component-detail"></div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="row modal-component-details-close-btn-div">
          <div class="col-md-12">
            <div class="pg-submit text-right">
              <button id="add_employments" data-dismiss="modal" class="btn btn-submit">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade custom-modal custom-modal-component-details" id="view_image_modal">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content modal-content-view-collection-category">
        <div class="modal-header border-0">
          <h4 class="modal-title">View Document</h4>
          <button type="button" class="close" data-dismiss="modal"><img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/close-modal-symbol.svg"></button>
        </div>
        <div class="modal-body modal-body-edit-coupon">
          <div class="row mt-2"> 
            <div class="col-md-3"></div>
            <div class="col-sm-6">
              <!-- <span>Sector Thumbnail Image: </span> -->
              <img class="w-100" id="view-image">
            </div> 
          </div>
          <!-- <div class="row p-5 mt-2">
              <div class="col-md-6" id="setupDownloadBtn"></div>
            </div> -->
        </div>
        <div class="modal-footer border-0">
          <div class="modal-footer">
            <div class="row modal-component-details-close-btn-div">
              <div class="col-md-12">
                <div class="pg-submit text-right">
                  <button id="add_employments" data-dismiss="modal" class="btn btn-submit">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Delete Testimonials Modal Starts -->
<div class="modal fade" id="edit-team-view">
  <div class="modal-dialog modal-dialog-centered  modal-xl">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div id="FS-candidate-cnt">
    
    
           </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Delete Modal Ends -->

<!-- dynamic Component detail -->
<div id="componentModal" class="modal fade">
   <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body">
            <div class="raise-issue-txt">
               <h3 id="modal-headding">Modal Heading</h3> 
            </div>
            <div class="raise-issue-cnt">
              <div id="component-detail">
                
              </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
  var access = '<?php echo $access;?>',
      request_from = '<?php echo $request_from;?>';
</script>
<script src="<?php echo base_url() ?>assets/custom-js/case/view-single-case.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/client-clarification/raise-clarification.js"></script>
<script src="<?php echo base_url() ?>assets/custom-js/client-clarification/all-clarifications.js"></script>

<?php extract($_GET); 
  if (isset($view_client_clarification) && $view_client_clarification != '') {
?>
  <script>
    view_clarification_details(<?php echo $view_client_clarification;?>);
  </script>
<?php } ?>

<script>
  load_case(<?php echo $candidate_id;?>); 
  var candidate_id = <?php echo $candidate_id;?>;
</script>