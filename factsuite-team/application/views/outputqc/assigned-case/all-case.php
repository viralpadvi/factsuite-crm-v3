
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt"> 
        <h3>View All Cases</h3>
          <div class="table-responsive mt-3" id="">
          <table class="table-fixed  datatable table table-striped">
            <thead class="table-fixed-thead thead-bd-color">
              <tr>
                <th>Case&nbsp;Id</th> 
                <th>Candidate&nbsp;Name</th> 
                <th>Client&nbsp;Name</th> 
               <!--  <th>Package&nbsp;Name</th> 
                <th>Phone&nbsp;Number</th>   -->
                <th>Email&nbsp;Id</th> 
                <th>Verification Status</th> 
                <!-- <th>View&nbsp;Details</th>    -->
                <th class="d-none">Report&nbsp;Genration</th>  
                <th>Report&nbsp;Download</th>  
              </tr>
            </thead>
            <tbody class="table-fixed-tbody tbody-datatable" id="get-case-data"> 
                <?php 
               if (count($case) > 0) {
                  foreach ($case as $key => $value) {

                       $status = ''; 
                        $classStatus = ''; 
                        $fontAwsom='';
            if ($value['is_submitted'] == '0') {
                // $status = 'Pending 
                $classStatus = 'pending';
                $fontAwsom = '<i class="fa fa-check">';
                $status = '<span class="text-warning">Not Initiated</span> ';
            }else if ($value['is_submitted'] == '1') {
                // $status = 'Pending 
                // $classStatus = 'pending'
                $fontAwsom = '<i class="fa fa-check">';
                $status = '<span class="text-info">In Progress</span> ';
            }else if ($value['is_submitted'] == '2') {
                // $status = 'Pending 
                // $classStatus = 'pending'
                $fontAwsom = '<i class="fa fa-check">';
                $status = '<span class="text-success">Completed</span>'; 
            }else{
                // $status = 'Completed 
                $classStatus = 'pending';
                $fontAwsom = '<i class="fa fa-check">';
                $status = '<span class="text-warning">Pending</span>'; 
            }
                     ?>
                    
 

             <tr id="tr_<?php echo $value['candidate_id']; ?>">   
             <td id="first_name<?php echo $value['candidate_id']; ?>"><?php echo $value['candidate_id']; ?></td> 
             <td id="first_name<?php echo $value['candidate_id']; ?>"><?php echo $value['first_name']; ?> </td> 
             <td id="client_name_<?php echo $value['candidate_id']; ?>"><?php echo $value['client_name']; ?></td> 
             <td id="email_id<?php echo $value['candidate_id']; ?>"><?php echo $value['email_id']; ?></td> 
             <td id="status<?php echo $value['candidate_id']; ?>"><?php echo $status; ?></td>
             <td class="text-center d-none" id="genrate_<?php echo $value['candidate_id']; ?>"><a id="genrate_report_<?php echo $value['candidate_id']; ?>"  href="<?php echo $this->config->item('my_base_url'); ?>factsuite-admin/interim-report-preview/<?php echo $value['candidate_id']; ?>"  class="insuf-btn"><i class="fa fa-file" aria-hidden="true"></i></a></td> 
             <td class="text-center" id="download_genrate_<?php echo $value['candidate_id']; ?>"><a id="download_genrate_report_<?php echo $value['candidate_id']; ?>"  href="<?php echo $this->config->item('my_base_url'); ?>factsuite-admin/interim-report-pdf-download/<?php echo $value['candidate_id']; ?>"  class="insuf-btn"><i class="fa fa-download" aria-hidden="true"></i></a></td> 
             </tr> 
 

                     <?php 
                  }
               }
               ?>
            </tbody>
          </table>
        </div>
     </div>
  </div>
</section>
<!--Content-->


<!-- Popup Content -->
<form>
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
</form>
<!-- Popup Content -->

<script src="<?php echo base_url() ?>assets/custom-js/outputqc/all-case-list/all-case.js"></script>