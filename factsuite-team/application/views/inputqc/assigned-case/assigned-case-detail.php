<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <div class="pg-cnt">
     <div id="FS-candidate-cnt"> 
          <div class="table-responsive mt-3" id="">
          <table class="datatable table table-striped">
            <thead class="thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>Component Name</th> 
                <th>Candidate Name</th> 
                <th>Client Name</th> 
                <th>Package Name</th> 
                <th>Phone Number</th>  
                <th>Email Id</th> 
                <th>Status</th> 
                <th>View Component Details</th>  
              </tr>
            </thead>
            <tbody class="tbody-datatable" id="get-case-data"> 
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
<div id="Gallery" class="modal fade">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body">
             <div id="gallery-slider" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                   <div class="carousel-item active">
                      <div class="gallery-slider-txt">
                         <span>Image 1</span>
                         <img src="images/no-image.jpg" />
                      </div>
                   </div>
                   <div class="carousel-item">
                      <div class="gallery-slider-txt">
                         <span>Image 2</span>
                         <img src="images/no-image.jpg" />
                      </div>
                   </div>
                   <div class="carousel-item">
                      <div class="gallery-slider-txt">
                         <span>Image 3</span>
                         <img src="images/no-image.jpg" />
                      </div>
                   </div>
                </div>
                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#gallery-slider" data-slide="prev">
                   <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#gallery-slider" data-slide="next">
                   <span class="carousel-control-next-icon"></span>
                </a>
             </div>
         </div>
      </div>
   </div>
</div>
<script src="<?php echo base_url() ?>assets/custom-js/inputqc/assigned-case/view-all-cases.js"></script>
<script>
  $('.carousel').carousel({
  interval: false,
});
</script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->