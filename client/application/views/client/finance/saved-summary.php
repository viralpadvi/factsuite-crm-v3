 
   <section id="pg-cntr"> 
   <div class="pg-cnt">
      <div id="FS-candidate-cnt" class="FS-candidate-cnt"> 
         <h3>Saved Summaries</h3>
         <div class="table-responsive mt-3"> 
            <table class="table-fixed table table-striped datatable">
               <thead class="table-fixed-thead thead-bd-color">
                  <tr>
                     <!-- <th>Sr No.Case&nbsp;Id</th>  --> 
                     <th>Sr No.</th>   
                     <th>Client&nbsp;Name</th>  
                     <th>Created Date</th>  
                     <th>View&nbsp;Details</th>
                     <!-- <th>Actions</th> -->
                  </tr>
               </thead>
               <!-- id="get-case-data-1" -->
               <tbody class="table-fixed-tbody tbody-datatable " id="get-case-data">
                  <?php 
                     if (count($finance)) {
                       foreach ($finance as $key => $value) {
                        $status ='';
                        if ($value['finance_status']==1) {
                            $status ='checked';
                        }
                          echo '<tr>';
                          echo '<td>'.($key+1).'</td>';
                          echo '<td>'.$value['client'].'</td>';
                          echo '<td>'.$value['summary_created_date'].'</td>';
                          echo '<td><a href="'.$this->config->item('my_base_url').'factsuite-client/get-finance-bills?cases='.base64_encode($value['candidate_ids']).'&&flag=1&&id='.$value['summary_id'].'"><i class="fa fa-eye"></i></a></td>';
                            
                          echo '</tr>';
                       }
                     }
                  ?>
               </tbody>
            </table>
         </div>
         <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-2 text-center" id="load-more-btn-div"></div>
            <div class="col-md-5"></div>
         </div>
      </div>
   </div>
</section>
<!--Content-->

<script src="<?php echo base_url() ?>assets/custom-js/finance/save-finance-summary.js"></script>