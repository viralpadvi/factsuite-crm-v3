 
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt">
        <!--View Client Content-->
         <!--   <div class="view-client-bx">
           <ul>
              <li class="wdt-1">
                 <div class="view-client-txt">Name: <span class="green-txt">Ashish K</span></div>
              </li>
              <li class="wdt-1">
                 <div class="view-client-txt">Client: <span class="orange-txt">Riyatsa</span></div>
              </li>
              <li class="wdt-1">
                 <div class="view-client-txt">Industry: <span class="red-txt">Service</span></div>
              </li>
              <li class="wdt-1">
                 <div class="view-client-txt">State: <span class="green-txt">Karnataka</span></div>
              </li>
              <li class="wdt-2">
                 <div class="view-client-txt">Email: <span class="red-txt2">riyatsa@riyatsa.com</span></div>
              </li>
              <li class="wdt-3">
                 <div class="view-client-btn"><a href="#">View / Edit</a></div>
              </li>
              <li class="wdt-4">
                 <div class="view-client-icon"><a href="#"><img src="images/delete.png" /></a></div>
              </li>
           </ul>
        </div>
  -->
        <div class="table-responsive mt-3" id="">
          <table class="table-fixed table table-striped">
            <thead class="table-fixed-thead thead-bd-color">
              <tr> 
                  <th>Sr No.</th>
                  <th>Send Credentials to Multiple SPOC</th>
                  <th>SPOC Name</th> 
                  <th>SPOC Email id</th> 
                  <th class="text-center">Send Credentials to SPOC</th>
              </tr>
            </thead>
            <tbody class="table-fixed-tbody tbody-datatable">
               <?php foreach ($client_spoc_list as $key => $value) { ?>
                  <tr>
                     <td><?php echo $key+1;?></td>
                     <td class="text-center"><input type="checkbox" class="send-credentials-to-multiple-spoc-id" id="spoc-id-<?php echo $value['spoc_id'];?>" name="send-credentials-to-multiple-spoc-id[]" value="<?php echo $value['spoc_id'];?>"></td>
                     <td><?php echo $value['spoc_name'];?></td>
                     <td><?php echo $value['spoc_email_id'];?></td>
                     <td class="text-center" id="send-credentials-to-client-spoc-<?php echo $value['spoc_id'];?>"><a onclick="send_credentials_to_spoc(<?php echo $value['spoc_id'];?>)" href="javascript:void(0)" class="text-dark">Send</a></td>
                     </tr>
               <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
               <div id="send-credentials-to-multiple-client-spoc-error-msg-div"></div>
               <button id="send-credentials-to-multiple-client-spoc" class="btn bg-blu btn-submit-cancel text-white">Send Credentials</button>    
            </div>
         </div>
        <!--View Client Content-->
     </div>
  </div>
</section>
<!--Content-->
<script type="text/javascript">
   var request_page = 'add-edit-client';
</script>
<script src="<?php echo base_url(); ?>assets/custom-js/admin/client/client-spoc.js"></script>