
   <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/jquery.mCustomScrollbar.min.css">
   <div class="pg-cnt">
      <div id="FS-candidate-cnt" class="FS-candidate-cnt-analyst"> 
         <h3>View Ready For Billing Cases</h3>
         <div class="table-responsive mt-3">
            <div class="row mb-3">
               <div class="col-md-2">
                  <input type="checkbox" name="bulk-check-cases" id="bulk-check-cases">
                  <label for="bulk-check-cases">Check All</label>
                  <select class="w-50" id="filter-cases-number"></select>
               </div>
               <div class="col-md-2">
                  <select class="form-control custom-iput-1 select2" multiple="" id="filter-cases-client-list"></select>
               </div>
               <div class="col-md-2">
                  <select id="action-status" class="form-control custom-iput-1"></select>
               </div>
               <div class="col-md-4">
                  <input class="form-control custom-iput-1" id="filter-input" type="text" placeholder="Search..">
               </div>
               <div class="col-md-2">
                  <button class="send-btn mt-0 mr-0 btn-filter-search" id="all-case-filter-btn" onclick="get_all_cases('filter_input')">Search</button>
               </div>
              
                <div class="col-md-4 mt-3">
                <span class="product-details-span-light">Type Of Data</span>
                <select class="form-control input-txt" required name="type-cases" id="type-cases">
                  <!-- <option selected value="">Select Duration</option> -->
                  <option value="">Select Type</option>
                  <option value="0">Web</option>
                  <option value="1">CRM</option> 
                </select>
              </div>
               <div class="col-md-2"></div> 
               <div class="col-md-6 mt-3" id="duration-date"> 
                <div class="row">
                  <div class="col-md-6">
                    <span class="product-details-span-light">Start Date</span>
                    <input class="form-control input-txt mdates" type="text" name="from" id="from" value="">
                  </div>
                  <div class="col-md-6">
                    <span class="product-details-span-light">End Date</span>
                    <input class="form-control input-txt mdates" type="text" name="to" id="to" value="">
                  </div>
                </div>
              </div>
            </div>
            <table class="table-fixed table table-striped">
               <thead class="table-fixed-thead thead-bd-color">
                  <tr>
                     <th>Select</th> 
                     <th>Sr No.</th>
                     <th>Case Id</th>
                     <th>Candidate Name</th>
                     <th>Client Name</th>
                     <th>Start date</th>
                     <th>Completed Date</th>
                     <th>Total&nbsp;Amount</th>
                     <th>Verification Status</th>
                     <th>View Details</th>
                  </tr>
               </thead>
               <tbody class="table-fixed-tbody tbody-datatable" id="get-case-data"></tbody>
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

<script src="<?php echo base_url() ?>assets/custom-js/finance/view-all-completed-cases.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
  $("#content-5, #content-6").mCustomScrollbar({
    theme: "dark-thin"
  });

</script>