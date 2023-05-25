<?php 
  extract($_GET);
  $all_reports_active = '';
  $insuff_report_active = '';
  $clear_insuff_report_active = '';

  if (strtolower(uri_string()) == 'factsuite-client/candidate-mis-report') {
    $all_reports_active = ' active';
  } else if(strtolower(uri_string()) == 'factsuite-client/candidate-mis-insuff-report') {
    $insuff_report_active = ' active';
  } else if(strtolower(uri_string()) == 'factsuite-client/candidate-clear-insuff-report') {
    $clear_insuff_report_active = ' active';
  } else  {
    $all_reports_active = ' active';
  }
?>
<!-- <h1 class="m-0 text-dark">Generate Report</h1> -->
      </div>
      <?php 
        $show = 0;
        if ($show == 1) { ?>
          <div class="col-sm-12 d-none">
            <ul class="nav nav-tabs custom-nav-tabs nav-justified" id="custom-tabs-three-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link<?php echo $all_reports_active;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-client/candidate-mis-report">All Reports</a>
              </li>
              <li class="nav-item">
                <a class="nav-link<?php echo $insuff_report_active;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-client/candidate-mis-insuff-report">Insuff Report</a>
              </li>
              <li class="nav-item">
                <a class="nav-link<?php echo $clear_insuff_report_active;?>" href="<?php echo $this->config->item('my_base_url')?>factsuite-client/candidate-clear-insuff-report">Insuff Clear Report</a>
              </li>
            </ul>
          </div>
      <?php } ?>
    </div>
  </div>
</div>