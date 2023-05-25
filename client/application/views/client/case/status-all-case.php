<?php 
   $client_name = '';
   if ($this->session->userdata('logged-in-client')) {
      $client_name = $this->session->userdata('logged-in-client')['client_name'];
   }
   $client_name = trim(str_replace(' ','-',$client_name));
?>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
        <!--All Cases Content-->
             <!--  <div class="full-bx">
                 <div class="cases-tp">
                    <div class="cases-lft">
                       <div id="custom-search-input">
                          <div class="input-group">
                              <input type="text" class="search-query form-control" placeholder="Search" />
                              <span class="input-group-btn">
                                  <button type="button">
                                      <span class="fa fa-search"></span>
                                  </button>
                              </span>
                           </div>
                       </div>
                    </div>
                    <div class="cases-rgt">
                       <select name="" class="fld">
                          <option>All Cases</option>
                          <option>Completed</option>
                          <option>Check Status</option>
                          <option>Stopped</option>
                       </select>
                    </div>
                    <div class="clr"></div>
                 </div>
                 <div id="cases-bx">
                    <div class="cases-bx">
                       <h5>High Priority</h5>
                       <div class="cases-bx-lft">
                          <div class="cases-txt">
                             <ul>
                                <li>ID: <span class="blue-txt">1245869333</span></li>
                                <li>Name: <span class="green-txt">Ashish K</span></li>
                                <li>Client: <span class="orange-txt">Riyatsa</span></li>
                                <li>TAT: <span class="red-txt">8 Days</span></li>
                                <li>Status: <span class="green-txt">Completed</span></li>
                             </ul>
                          </div>
                          <div class="cases-txt2">
                             <ul>
                                <li>Email &amp; Phone Number</li>
                                <li>Permanent Address</li>
                                <li>Current Address</li>
                                <li>ID Details</li>
                                <li class="red-txt2 last"><strong>Dead Line 18 Feb 2020</strong></li>
                             </ul>
                          </div>
                       </div>
                       <div class="cases-bx-rgt">
                          <div class="cases-bx-rgt-txt">
                             <a class="mail-btn"  href="#SendMail" data-toggle="modal"><img src="images/email.png" />Send Mail</a>
                             <a class="down-btn" href="#"><i class="fa fa-arrow-down"></i>Download</a>
                          </div>
                       </div>
                       <div class="clr"></div>
                    </div>
                    <div class="cases-bx">
                       <div class="cases-bx-lft">
                          <div class="cases-txt">
                             <ul>
                                <li>ID: <span class="blue-txt">1245869333</span></li>
                                <li>Name: <span class="green-txt">Ashish K</span></li>
                                <li>Client: <span class="orange-txt">Riyatsa</span></li>
                                <li>TAT: <span class="red-txt">8 Days</span></li>
                                <li>Status: <span class="red-txt2">Stopped</span></li>
                             </ul>
                          </div>
                          <div class="cases-txt2">
                             <ul>
                                <li>Email &amp; Phone Number</li>
                                <li>Permanent Address</li>
                                <li>Current Address</li>
                                <li>ID Details</li>
                                <li class="red-txt2 last"><strong>Dead Line 18 Feb 2020</strong></li>
                             </ul>
                          </div>
                       </div>
                       <div class="cases-bx-rgt">
                          <div class="cases-bx-rgt-txt">
                             <a class="mail-btn"  href="#SendMail" data-toggle="modal"><img src="images/email.png" />Send Mail</a>
                             <a class="initiate-btn" href="#"><i class="fa fa-check"></i>Re-Initiate</a>
                          </div>
                       </div>
                       <div class="clr"></div>
                    </div>
                    <div class="cases-bx">
                       <h5>High Priority</h5>
                       <div class="cases-bx-lft">
                          <div class="cases-txt">
                             <ul>
                                <li>ID: <span class="blue-txt">1245869333</span></li>
                                <li>Name: <span class="green-txt">Ashish K</span></li>
                                <li>Client: <span class="orange-txt">Riyatsa</span></li>
                                <li>TAT: <span class="red-txt">8 Days</span></li>
                                <li>Status: <span class="orange-txt2">On Progress</span></li>
                             </ul>
                          </div>
                          <div class="cases-txt2">
                             <ul>
                                <li>Email &amp; Phone Number</li>
                                <li>Permanent Address</li>
                                <li>Current Address</li>
                                <li>ID Details</li>
                                <li class="red-txt2 last"><strong>Dead Line 18 Feb 2020</strong></li>
                             </ul>
                          </div>
                       </div>
                       <div class="cases-bx-rgt">
                          <div class="cases-bx-rgt-txt">
                             <a class="mail-btn"  href="#SendMail" data-toggle="modal"><img src="images/email.png" />Send Mail</a>
                             <a class="stop-btn" href="#"><i class="fa fa-stop"></i>Stop Check</a>
                          </div>
                       </div>
                       <div class="clr"></div>
                    </div>
                 </div>
              </div> -->
              <!--All Cases Content-->

            <h3><?php echo $title; ?></h3>
            <select class="form-control float-right col-md-3 mb-4" onchange="status_change()" id="status-change">
              <?php 
              $init ='';
              $progress ='';
              $insuff ='';
              $completed ='';
              if ($status == md5(0)) {
                 $init ='selected';
              }else if($status == md5(1)){
                  $progress ='selected';
              }else if($status == md5(3)){
                  $insuff ='selected';
              }else if($status == md5(2)){
                  $completed ='selected';
              }
              echo "<option value=''>Select Status</option>";
              echo "<option {$init} value='".md5(0)."'>Initiate</option>";
              echo "<option {$progress} value='".md5(1)."'>In-Progress</option>";
              echo "<option {$insuff} value='".md5(3)."'>Insuff</option>";
              echo "<option {$completed} value='".md5(2)."'>Completed</option>";
              ?>
            </select>
          <div class="table-responsive mt-3" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Case id</th>
                <th>Candidate Name</th> 
                <!-- <th>Client Name</th>  -->
                 
                <th>Package Name</th> 
                <th>Employee Id</th>  
                <!-- <th>Email Id</th>  -->
                <th>Verification Status</th> 
                <th>Action</th>  
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-case-data-1"> 
                <?php 
                 $i = 1; 
                    if (count($case) > 0) {
                        foreach ($case as $key => $value) {

                        $status = '';
                        if ($value['is_submitted'] == '0') {
                           $status = '<span class="text-warning">pending<span>';
                        }else if ($value['is_submitted'] == '1') {
                               $status = '<span class="text-info">in-progress<span>';
                           }else{
                               $status = '<span class="text-success">submitted<span>';
                           }
 
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $value['candidate_id']; ?></td>
                                <td><?php echo $value['first_name']; ?></td> 
                                <td><?php echo $value['pack_name']; ?></td>
                                <td><?php echo $value['employee_id']; ?></td>
                                <td><?php echo $status; ?></td>
                                <td> <a  href="<?php echo $this->config->item('my_base_url'); ?>factsuite-client/view-single-case/<?php echo $value['candidate_id']; ?>"><i class="fa fa-eye"></i></a> </td> 
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

<script src="<?php echo base_url() ?>assets/custom-js/case/view-case.js"></script>
<script>
   
   function status_change(){
      var case_status = $('#status-change').val();
      window.location.href =base_url+"<?php echo $client_name; ?>/selected-status-cases/?param="+case_status;
   }
</script>