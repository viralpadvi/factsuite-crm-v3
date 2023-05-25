
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt"> 
        <h3>View All Cases</h3>
          <div class="table-responsive mt-3" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Candidate Name</th> 
                <th>Client Name</th> 
                <th>BGV Package Name</th> 
                <th>Case Id</th>  
                <th>Phone Number</th>
                <th>Login ID</th>
                <th>OTP</th>
                <th>Case Status</th>
                <th>Action</th> 
                <!-- <th>View Progress</th> -->
                <!-- <th>View Details</th>     -->
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-case-data-1"> 
               <?php 
               $i = 1;
               if (count($case) > 0) {
                  foreach ($case as $key => $value) {

                           $status = '';
                        $classStatus = '';
                        $fontAwsom='';
                     if ($value['is_submitted'] == '0') {
                            // status = 'Pending';
                            $classStatus = 'pending';
                            $fontAwsom = '<i class="fa fa-check">';
                        $status = '<span class="text-warning">Pending</span>';
                     }else if ($value['is_submitted'] == '1') {
                            // status = 'Pending';
                            $classStatus = 'pending';
                            $fontAwsom = '<i class="fa fa-check">';
                            $status = '<span class="text-info">Form Filled</span>';
                        }else if ($value['is_submitted'] == '2') {
                            // status = 'Pending';
                            $classStatus = 'pending';
                            $fontAwsom = '<i class="fa fa-check">';
                            $status = '<span class="text-success">Completed</span>';
                        }else{
                            // status = 'Completed';
                             $classStatus = 'pending';
                            $fontAwsom = '<i class="fa fa-check">';
                            $status = '<span class="text-warning">Pending</span>';
                        }

          
                     ?>
               

         <tr id="tr_<?php echo $value['candidate_id']; ?>"> 
         <td><?php echo $i++; ?></td>
         <td id="first_name<?php echo $value['candidate_id']; ?>"><?php echo $value['first_name']; ?></td>
         <td id="client_name_<?php echo $value['candidate_id']; ?>"><?php echo $value['client_name']; ?></td>
         <td id="package_name<?php echo $value['candidate_id']; ?>"><?php echo $value['package_name']; ?></td>
         <td id="phone_number<?php echo $value['candidate_id']; ?>"><?php echo $value['candidate_id']; ?></td>
         <td id="phone_number<?php echo $value['candidate_id']; ?>"><?php echo $value['phone_number']; ?></td>
         <td id="phone_number<?php echo $value['candidate_id']; ?>"><?php echo $value['loginId']; ?></td>
         
         <td ><?php echo $value['otp_password']; ?></td>
            <td class="<?php echo $classStatus; ?>" id="status<?php echo $value['candidate_id']; ?>"><?php echo $status; ?></td>
         <?php 
               if (true) { 
            ?>
         <td class="<?php echo $classStatus; ?>" id="status<?php echo $value['candidate_id']; ?>"><a href="<?php echo $this->config->item('my_base_url');?>factsuite-inputqc/edit-case/<?php echo $value['candidate_id']; ?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="confirm_remove_case(<?php echo $value['candidate_id']; ?>)" href="#"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <?php 
               if (strtolower($value['document_uploaded_by'] == 'inputqc') && $value['is_submitted'] != 2 && $value['is_submitted'] != 1) { ?>
                 <a target="_blank" href="<?php echo $this->config->item('my_base_url');?>factsuite-inputqc/resume-case/<?php echo $value['candidate_id']; ?>"><i class="fa fa-wpforms"></i></a>
                 <?php
               }
            ?>
         </td> 
         <?php 
            }else{
               echo "<td></td>";
            }
         ?>
             
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


 <div id="remove-candidate" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
          <div class="modal-pending-bx"> 
              <h5 id="componentNameApprove" >Are you sure Do you want to remove this candidate?</h5>
              
              <div id="btn-remove-Div">
                    
              </div>
              <div class="clr"></div>
          </div>
       </div>
    </div>
 </div>


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

<script src="<?php echo base_url() ?>assets/custom-js/inputqc/case/view-all-cases.js"></script>