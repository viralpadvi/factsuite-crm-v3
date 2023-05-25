<?php extract($_GET); 
    $request_from = isset($request_from) ? $request_from : '';
    $redirect_page_name = 'view-all-case-list';
    if (strtolower($request_from) == 'all-cases') {
        $redirect_page_name = 'view-all-case-list';
    } else if (strtolower($request_from) == 'ready-for-billing-cases') {
       $redirect_page_name = 'view-completed-case-list';
    } else {
        $redirect_page_name = 'view-completed-case-list';
    }
?>
<div class="pg-cnt">
    <div id="FS-candidate-cnt" class="FS-candidate-cnt-admin">
        <input type="hidden" id="candidate-id">
        <a class="btn bg-blu btn-submit-cancel"
            href="<?php echo $this->config->item('my_base_url')?>factsuite-finance/<?php echo $redirect_page_name;?>">
            <span class="text-white">Back</span>
        </a>
        <h5 class="mt-3" style="color: #381653;">Personal Details</h5>
        <div class="row">
            <div class="col-md-4">
                <label class="font-weight-bold">Case ID: </label>&nbsp;<span id="caseId"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label class="font-weight-bold">Candidate Name: </label>&nbsp;<span id="candidateName">-</span>
            </div>
            <div class="col-md-4">
                <label class="font-weight-bold">Client Name: </label>&nbsp;<span id="clientName">-</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label class="font-weight-bold">Phone Number: </label>&nbsp;<span id="camdidatephoneNumber">-</span>
            </div>
            <div class="col-md-4">
                <label class="font-weight-bold">Package Name: </label>&nbsp;<span id="packageName">-</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label class="font-weight-bold">Email Id: </label>&nbsp;<span id="camdidateEmailId">-</span>
            </div>
            <div id="priority-div" class="col-md-4"></div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-2">
                <label class="font-weight-bold" for="">Payment Date: </label>
                <input id="payment-status-date" type="text" class="form-control" readonly>
            </div>
            <div class="col-md-4">
                <label class="font-weight-bold">Payment Status: </label>
                <div id="payment-status-span">
                    <!-- Drop-down comming through JS -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mt-2">
                <button type="submit" id="paymetn-status-action"
                    class="btn bg-blu btn-submit-cancel text-white" onClick="payment_status_confirm()">Submit</button>
            </div>
        </div>
        <hr>
        <h5 class="mt-3" style="color: #381653;">TAT Details</h5>
        <div class="row">
            <div class="col-md-4">
                <label class="font-weight-bold">TAT Status: </label>&nbsp;<span id="tatStatus"></span>
            </div>
            <div class="col-md-4">
                <label class="font-weight-bold">TAT Total Days: </label>&nbsp;<span id="tatTotalDays"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label class="font-weight-bold">Tat Start Date: </label>&nbsp;<span id="tatStartDays"></span>
            </div>
            <div class="col-md-4">
                <label class="font-weight-bold">Tat End Date: </label>&nbsp;<span id="tatEndDays"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label class="font-weight-bold">Tat Pause Date: </label>&nbsp;<span id="tatPauseDays"></span>
            </div>
            <div class="col-md-4">
                <label class="font-weight-bold">Tat Re-Start Date: </label>&nbsp;<span id="tatReStartDays"></span>
            </div>
        </div>
        <div class="table-responsive mt-3" id="">
            <table class="table table-striped">
                <thead class="thead-bd-color">
                    <tr>
                        <th>Sr No.</th>
                        <th>Component</th>
                        <th>Amount</th>
                        <th>Data Entry Status</th>
                        <th id="th-dynamic-statuss">Verification Status</th>
                        <th id="th-dynamic-status-insuff-name">Assigned&nbsp;to&nbsp;Insuff analyst</th>
                        <th id="th-dynamic-emp-insuff-analyst-name">Override Assignment Insuff analyst</th>
                        <th id="th-dynamic-status-analyst-name">Assigned&nbsp;to&nbsp;analyst/Specialist</th>
                        <th id="th-dynamic-emp-analyst-name">Assignment</th>
                        <th>Quality Check Status</th>
                    </tr>
                </thead>
                <tbody class="tbody-datatable" id="get-case-data"></tbody>
            </table>
        </div>
    </div>
</div>
</section>
<div id="payment_status_confirm_dialog" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-pending-bx">
                <!-- <h3 class="snd-mail-pop">Override Assingment</h3> -->
                <!-- <h4 id="componentNameInsuff" class="pa-pop">Raise Insufficiency</h4> -->
                <h4>Do you want to update paymnet status?</h4>
                <div id="btnOverrideDiv">

                </div>

                <div class="clr"></div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/custom-js/finance/view-single-case.js"></script>
<script>
load_case(<?php echo $candidate_id;?>);
</script>