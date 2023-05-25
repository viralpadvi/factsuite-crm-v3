<?php
$client_name = '';
if ($this->session->userdata('logged-in-client')) {
  $client_name = $this->session->userdata('logged-in-client')['client_name'];
}
$client_name = trim(str_replace(' ','-',$client_name));

$heading = 'All Cases';
$init = '';
$progress = '';
$insuff = '';
$completed = '';
$all_cases = '';
if ($status == md5(0)) {
  $init ='selected';
  $heading = 'Initiated Cases';
} else if($status == md5(1)) {
  $progress ='selected';
  $heading = 'Inprogress Cases';
} else if($status == md5(3)) {
  $insuff ='selected';
  $heading = 'Insuff Cases';
} else if($status == md5(2)) {
  $completed ='selected';
  $heading = 'Completed Cases';
} else if($status == md5(4)) {
  $all_cases = 'selected';
} else {
  $all_cases = 'selected';
}
?>
<h1 class="m-0 text-dark"><?php echo $heading; ?></h1>
          </div>
          <div class="col-sm-7 text-right">
            <select class="form-control float-right col-md-3 mb-4" onchange="status_change()" id="status-change">
              <?php
              echo "<option value=''>Report Type</option>";
              echo "<option {$all_cases} value='".md5(4)."'>All Cases</option>";
              echo "<option {$init} value='".md5(0)."'>Initiate</option>";
              echo "<option {$progress} value='".md5(1)."'>Inprogress</option>";
              echo "<option {$insuff} value='".md5(3)."'>Insuff</option>";
              echo "<option {$completed} value='".md5(2)."'>Completed</option>";
              ?>
            </select>
          </div>
        </div>
      </div>
    </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <section class="col-lg-12">
          <div class="card kpi-div">
            <div class="card-body">
              <div class="tab-content p-0">
                <div class="table-responsive">
                  <table class="table custom-table table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Case id</th>
                        <th>Candidate Name</th>
                        <th>Package Name</th>
                        <th>Employee ID</th>
                        <th class="pl-5">Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $i = 1; 
                        if (count($case) > 0) {
                          foreach ($case as $key => $value) {
                            $case_status = '';
                            if ($value['is_submitted'] == '0') {
                              $case_status = '<span class="case-status case-pending">Pending<span>';
                            } else if ($value['is_submitted'] == '1') {
                              $case_status = '<span class="case-status case-in-progress">Inprogress<span>';
                            } else {
                              $case_status = '<span class="case-status case-completed">Completed<span>';
                            } ?>
                            <tr>
                              <td><?php echo $i++; ?></td>
                              <td><?php echo $value['candidate_id']; ?></td>
                              <td><?php echo $value['first_name']; ?></td> 
                              <td><?php echo $value['pack_name']; ?></td>
                              <td><?php echo $value['employee_id']; ?></td>
                              <td><?php echo $case_status; ?></td>
                              <td>
                                <a href="<?php echo $this->config->item('my_base_url'); ?>factsuite-client/view-single-case/<?php echo $value['candidate_id'];?>?param=<?php echo $status;?>"><img src="<?php echo base_url();?>assets/client/assets-v2/dist/img/black-eye.svg"></a>
                              </td>
                            </tr>
                      <?php } } else { ?>
                        <tr>
                          <td colspan="7"><span class="d-block text-center">No Case Found</span></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </section>

<script src="<?php echo base_url() ?>assets/custom-js/case/view-case.js"></script>
<script>
   function status_change() {
    var case_status = $('#status-change').val();
    window.location.href = base_url+"<?php echo $client_name;?>/selected-status-cases/?param="+case_status;
   }
</script>