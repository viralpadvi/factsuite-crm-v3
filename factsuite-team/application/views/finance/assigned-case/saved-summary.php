<!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> -->

<div class="pg-cnt">
    <div id="FS-candidate-cnt" class="FS-candidate-cnt">
        <h3>Saved Summaries</h3>
        <div class="table-responsive mt-3">
            <div class="row mb-3">
                <div class="col-md-2">
                    <input type="checkbox" name="bulk-check-cases" id="bulk-check-cases">
                    <label for="bulk-check-cases">Check All</label>
                    <select class="w-50" id="filter-cases-number"></select>
                </div>
                <div class="col-md-2">
                    <select class="form-control custom-iput-1 select2" multiple=""
                        id="filter-cases-client-list"></select>
                </div>
                <div class="col-md-2">
                    <select id="action-status" class="form-control custom-iput-1">
                        <option value="">Select</option>
                        <option value="raise">Raise</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="row border p-2">
                        <div class="col-md-4">
                            <label for="">Payment Status</label></br>
                            <select id="payment-status" class="form-control custom-iput-1">
                                <option selected value="2">Select Payment Status</option>
                                <option value="0">Pending</option>
                                <option value="1">Clear</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Payment Date</label></br>
                            <input type="text" name="text" id="payment-datepicker" class="form-control custom-iput-1">
                        </div>
                        <div class="col-md-4">
                            <label for="">&nbsp;</label></br>
                            <button type="submit" id="paymetn-status-action"
                                class="btn bg-blu btn-submit-cancel text-white">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table-fixed table table-striped">
                <thead class="table-fixed-thead thead-bd-color">
                    <tr>
                        <th>Select</th>
                        <th>Sr No.</th>
                        <th>Client&nbsp;Name</th>
                        <th>Created Date</th>
                        <th>View&nbsp;Details</th>
                        <th>Actions</th>
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

<script src="<?php echo base_url() ?>assets/custom-js/finance/saved-finance-summary.js"></script>