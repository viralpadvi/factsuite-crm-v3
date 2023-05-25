
  <div class="pg-cnt">
     <div id="FS-candidate-cnt">
         <h3>Case Export</h3>
          <section class="content">
        <ul class="nav nav-tabs" role="tablist">  
            <li class="nav-item">
              <a class="nav-link active nav-link-product-tab" href="?/saleReport">Report</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-product-tab" href="?/BillReport" >Bill Report</a>
            </li>
          </ul>
      <div class="container">
        <div class="error-data"></div>
        <div class="row mt-3">
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <div class="payment-gst-container">
            <span class="d-block medium-text">Generate Report</span>
              <!-- <form autocomplete="off" action="?/SaleReport/daily_sale_report" method="POST"> -->
            <div class="row mt-3">
              <div class="col-md-12">
                <span class="product-details-span-light">Report For</span>
                <select class="form-control input-txt" name="table" id="table">
                  <option selected value="">Select Report For</option>
                  <option value="sales">Sales</option>
                  <option value="purchase">Purchase</option>
                  <option value="return">Purchase Return</option>
                  <option value="product">Product</option>
                  <option value="contact">Customer Contacts</option>
                  
                </select>
              </div>
              <div class="col-md-12 mt-3">
                <span class="product-details-span-light">Duration</span>
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
              <div class="col-md-12 mt-3" id="duration-date" style="display: none;">
                <span class="product-details-span-light d-block">Duration</span>
                <div class="row">
                  <div class="col-md-6">
                    <span class="product-details-span-light">From</span>
                    <input class="form-control input-txt mdate" type="text" name="from" id="from" value="">
                  </div>
                  <div class="col-md-6">
                    <span class="product-details-span-light">To</span>
                    <input class="form-control input-txt mdate" type="text" name="to" id="to" value="">
                  </div>
                </div>
              </div>
              <div class="col-md-12 mt-3 text-right">
                <button class="btn btn-add text-white" id="generate_report" name="generate_report">Generate</button>
              </div>
            </div>
          <!-- </form> -->
          </div>
        </div>
      </div>
    </section>    
        
     </div>
  </div>
</section>
<!--Content-->

 