
  <div class="pg-cnt">
     <div id="FS-candidate-cnt">
         <!-- <h3>Case Detail</h3> -->
          
          <a class="btn bg-blu btn-submit-cancel" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/assigned-case-list" ><span class="text-white">Back</span></a>

          <div class="row mt-4">
            <div class="col-md-4">
              <?php $candidateId=  isset($componentData['candidate_id'])?$componentData['candidate_id']:"2";?>
              <label class="font-weight-bold">Case ID: </label>&nbsp;<span id="caseId"><?php echo $candidateId;?></span>
            </div>
            
          </div>
          <div class="row">
            <div class="col-md-4">
              <?php $candidateName =  $componentData['first_name']." ".$componentData['last_name'];?>
              <label class="font-weight-bold">Candidate Name: </label>&nbsp;<span id="camdidateName"><?php echo $candidateName;?></span>
            </div>
            <div class="col-md-4">
              <?php $candidateClinetName =  isset($componentData['client_name'])?$componentData['client_name']:"2";?>
              <label class="font-weight-bold">Client Name: </label>&nbsp;<span id="clientName"><?php echo $candidateClinetName;?></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <?php $candidatePhoneNumber=  isset($componentData['phone_number'])?$componentData['phone_number']:"1234567890";?>
              <label class="font-weight-bold">Phone Number: </label>&nbsp;<span id="camdidatephoneNumber"><?php echo 
              $candidatePhoneNumber;?></span>
            </div>
            <div class="col-md-4">
              <?php $candidatePackageName =  isset($componentData['package_name'])?$componentData['package_name']:"2";?>
              <label class="font-weight-bold">Package Name: </label>&nbsp;<span id="packageName"><?php echo $candidatePackageName;?></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <?php $candidateEmail=  isset($componentData['email_id'])?$componentData['email_id']:"2";?>
              <label class="font-weight-bold">Email Id: </label>&nbsp;<span id="camdidateEmailId"><?php echo $candidateEmail;?></span>
            </div>
            <div class="col-md-4">
              <?php $candidateDob=  isset($componentData['date_of_birth'])?$componentData['date_of_birth']:"34-13-2050";?>
              <label class="font-weight-bold ">DOB(date of birth): </label>&nbsp;<span id="camdidateDob"><?php echo $candidateDob;?></span>
            </div>
            
          </div>
          <hr>
          <!-- <div class="table-responsive mt-3" id="">
          <table class="table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Component</th>  
                <th>Details</th>  
                <th>Component Status</th>  
                <th>Insufficiency</th>  
                <th>Approve</th>  
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-case-data"> 
            </tbody>
          </table>
        </div> -->
        <!--Content-->
          <section id="table-allcase">
             <div class="container">
               <div class="detail mb-5">
                   <div class="row hd">
                      <div class="col-md-6"><h6 class="hd-h6">Criminal Details</h6></div>
                      <!-- <div class="col-md-6"><a href="./allcase2.html"><button class="close-bt">Close</button></a></div> -->
                   </div>
                   <h3 class="permt mt-4">Address Details</h3>
                   <div class="row mt-3"> 
                      <div class="col-md-2 lft-p-det">
                        <p>Address</p>
                        <p>City/Town</p>
                        <p>Pin Code</p>
                        <p>State</p>
                      </div>
                      <div class="col-md-1 pr-0">
                          <p>:</p>
                          <p>:</p>
                          <p>:</p>
                          <p>:</p>
                     </div>
                     <div class="col-md-4 ryt-p pl-0">
                          <p>3430</p>
                          <p>159-e Gopal nagar,parvat patiya,surat -395010, G</p>
                          <p>Lane</p>
                          <p>MD</p>
                     </div>
                     <!-- <div class="col-md-2 lft-p">
                         <p>City Town</p>
                         <p>Pin Code</p>
                       </div>
                       <div class="col-md-1 pr-0">
                         <p>:</p>
                         <p>:</p>
                    </div>
                    <div class="col-md-2 ryt-p pl-0">
                     <p>surat</p>
                     <p>395010</p> -->
                </div>
                  </div>
                  <hr>
                  <h3 class="permt mt-3">Duration of Stay</h3>
                  <div class="row mt-3"> 
                     <div class="col-md-2 lft-p-det">
                       <p>Start Date</p>
                     </div>
                     <div class="col-md-1 pr-0">
                         <p>:</p>
                    </div>
                    <div class="col-md-4 ryt-p pl-0">
                         <p>2021-02-27</p>
                    </div>
                    <div class="col-md-2 lft-p">
                        <p>End Date</p>
                      </div>
                      <div class="col-md-1 pr-0">
                        <p>:</p>
                   </div>
                   <div class="col-md-2 ryt-p pl-0">
                    <p>2021-02-27</p>
               </div>
                 </div>
                 <hr>
                 <h3 class="permt mt-3">Contact Person</h3>
                 <div class="row mt-3"> 
                    <div class="col-md-2 lft-p-det">
                      <p>Name</p>
                      <p>Relationship</p>
                    </div>
                    <div class="col-md-1 pr-0">
                        <p>:</p>
                        <p>:</p>
                   </div>
                   <div class="col-md-4 ryt-p pl-0">
                        <p>Yash</p>
                        <p>Self</p>
                   </div>
                   <div class="col-md-2 lft-p">
                       <p>Phone Number</p>
                     </div>
                     <div class="col-md-1 pr-0">
                       <p>:</p>
                  </div>
                  <div class="col-md-2 ryt-p pl-0">
                   <p>+91 000 000 0000</p>
                 </div>
              </div>
                <hr>
                 <div class="row">
                     <div class="col-md-4">
                      <h3 class="permt mt-3">Rental agreement/ driving License</h3>
                     </div>
                     <div class="col-md-4">
                      <h3 class="permt mt-3">Upload ration card (optional)</h3>
                     </div>
                     <div class="col-md-4">
                      <h3 class="permt mt-3">upload government utility bill (optional)</h3>
                     </div>
                 </div>
               </div>
             </div>
          </section>
          <!--Content-->
     </div>
  </div>
</section>
<!--Content-->


<!-- Popup Content -->
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


<script src="<?php echo base_url() ?>assets/custom-js/inputqc/assigned-case/view-component-detail.js"></script>
<script>
 load_case(<?php echo $candidate_id;?>); 
</script>