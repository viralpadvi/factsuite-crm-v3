
   <div class="pg-cnt">
      <div id="FS-candidate-cnt" class="FS-candidate-cnt"> 
         <h3>View All Cases</h3>
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
                <div class="col-md-4 mt-1">
                <span class="product-details-span-light">Type Of Data</span>
                <select class="form-control input-txt" required name="type-cases" id="type-cases">
                  <!-- <option selected value="">Select Duration</option> -->
                  <option value="">Select Type</option>
                  <option value="0">Web</option>
                  <option value="1">CRM</option> 
                </select>
              </div>
               <div class="col-md-4 mt-1">
                <span class="product-details-span-light">Report Period</span>
                <select class="form-control input-txt" required name="duration" id="duration">
                  <!-- <option selected value="">Select Duration</option> -->
                  <option value="all">ALL</option>
                  <option value="today">Today</option>
                  <option value="week">Weekly</option>
                  <option value="month">Monthly</option>
                  <option value="year">Yearly</option>
                  <option value="between">Between Date</option>
                </select>
              </div>
               <div class="col-md-4 mt-1" id="duration-date" style="display: none;"> 
                <div class="row">
                  <div class="col-md-6">
                    <span class="product-details-span-light">Start Date</span>
                    <input class="form-control input-txt mdate" type="text" name="from" id="from" value="">
                  </div>
                  <div class="col-md-6">
                    <span class="product-details-span-light">End Date</span>
                    <input class="form-control input-txt mdate" type="text" name="to" id="to" value="">
                  </div>
                </div>
              </div>
            </div>
            <table class="table-fixed table table-striped">
               <thead class="table-fixed-thead thead-bd-color">
                  <tr>
                     <!-- <th>Sr No.Case&nbsp;Id</th>  -->
                     <th>Select</th> 
                     <th>Sr No.</th> 
                     <th>Case&nbsp;Id</th> 
                     <th>Candidate&nbsp;Name</th> 
                     <th>Client&nbsp;Name</th> 
                     <th>Start&nbsp;Date</th> 
                     <th>Total&nbsp;Amount</th>
                     <th>Verification Status</th> 
                     <th>View&nbsp;Details</th>
                     <!-- <th>Actions</th> -->
                  </tr>
               </thead>
               <!-- id="get-case-data-1" -->
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

<script src="<?php echo base_url() ?>assets/custom-js/finance/all-case.js"></script>
 <script>
    $('#duration').change(function(){
    var duration = $('#duration').val();
    if (duration == 'between') {
      $("#duration-date").show();
    } else {
      $("#duration-date").hide();
    }
});

$('#from').val('');
$('#to').val('');
  </script>
