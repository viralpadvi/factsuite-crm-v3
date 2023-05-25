<?php 
  $status_width = '16%';
  $sr_no_width = '4%';
  $candidate_name_width = '9%';
  $package_name_width = '10%';
  $employee_id_width = '7%';
  $tat_start_date_width = '7%';
  $tat_end_date_width = '7%';
  $tat_days_width = '5%';
  $actions_width = '25%';
  $candidate_login_id_width = '10%';

  $request_from = '';
  if (isset($request_from_page)) {
    if (strtolower($request_from_page) == 'all') {
      $request_from = '?request_from=all-cases';
    } else if (strtolower($request_from_page) == 'insuff') {
      $request_from = '?request_from=insuff-cases';
    } else if (strtolower($request_from_page) == 'client-clarification') {
      $request_from = '?request_from=client-clarification';
    }
  }
?>
<table class="table custom-table table-striped">
  <thead>
    <tr>
      <th style="width: <?php echo $sr_no_width;?>">Sr&nbsp;No.</th>
      <th style="width: <?php echo $candidate_name_width;?>">Candidate</th>
      <th style="width: <?php echo $candidate_name_width;?>">Mobile&nbsp;Number</th>
      <!-- <th style="width: <?php echo $candidate_login_id_width;?>">Login&nbsp;ID</th> -->
      <!-- <th style="width: <?php echo $sr_no_width;?>">OTP</th>  -->
      <th style="width: <?php echo $package_name_width;?>">Package</th>
      <th style="width: <?php echo $employee_id_width;?>">Employee&nbsp;ID</th>
      <th class="text-center" style="width: <?php echo $status_width;?>">Status</th>
      <th style="width: <?php echo $tat_start_date_width;?>">Start&nbsp;Date</th>
      <th style="width: <?php echo $tat_end_date_width;?>">End&nbsp;Date</th>
      <!-- <th style="width: <?php echo $tat_days_width;?>">TAT&nbsp;Days</th> -->
      <th style="width: <?php echo $actions_width;?>">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if (count($case_list) > 0) {
      foreach ($case_list as $key => $value) {
        $cases = $value['candidate'];
        $status = '';
        $d_none = '';
        $case_submitted_date_time = $cases['case_submitted_date'] ? $cases['case_submitted_date'] : '';
        $case_submitted_date = '';
        $report_generated_date_time = $cases['report_generated_date'] ? $cases['report_generated_date'] : '';
        $report_generated_date = '';
         $check = '';
        if ($cases['is_submitted'] == 0) {
          $status = '<span class="case-status case-pending">Pending</span>';
        }else if($cases['is_submitted'] == 3){
          $status = '<span class="case-status case-pending">Insufficiency</span>';
        } else if($cases['is_submitted'] == 1) {
          $status = '<span class="case-status case-in-progress">Inprogress</span>';
        } else {
          $check = 'true';
          $status = '<span class="case-status case-completed">Completed</span>';
        }

        if ($report_generated_date_time != '') {
          $report_generated_date = explode(' ', $report_generated_date_time);
          $report_generated_date = explode('-', $report_generated_date[0]);
          $report_generated_date = $report_generated_date[2].'/'.$report_generated_date[1].'/'.$report_generated_date[0];
        }

        if ($case_submitted_date_time != '') {
          $case_submitted_date = explode(' ', $case_submitted_date_time);
          $case_submitted_date = str_replace("-","/",$case_submitted_date[0]);
        }

        $priority = '';
        $tat_days_color = '';
        $tat_days = '';
        if($cases['priority'] == '0') {
          $priority = '<span class="text-info font-weight-bold">Low</span>';
          $tat_days_color = '<span class="text-info font-weight-bold">'.$cases['low_priority_days'].'</span>';
          $tat_days = $cases['low_priority_days'];
        } else if($cases['priority'] == '1') {
          $priority = '<span class="text-warning  font-weight-bold">Medium</span>';
          $tat_days_color = '<span class="text-warning font-weight-bold">'.$cases['medium_priority_days'].'</span>';
          $tat_days = $cases['medium_priority_days'];
        } else if($cases['priority'] == '2') {
          $tat_days = $cases['high_priority_days'];
        } ?>

        <tr>
        <td style="width: <?php echo $sr_no_width;?>">

          <?php
          if ($check =='true') {
           echo "<input type='checkbox' name='checkbox' class='all_checks_id' value='".$cases['candidate_id']."' > &nbsp;";
          }
           echo (++$last_number_id);?></td>
        <td class="text-capitalize" style="width: <?php echo $candidate_name_width;?>"><?php echo $cases['first_name'];?></td>
        <td style="width: <?php echo $candidate_name_width;?>"><?php echo $cases['phone_number'];?></td>
        <!-- <td style="width: '+candidate_login_id_width+';">'+cases.loginId+'</td> -->
        <!-- <td style="width: '+sr_no_width+';">'+cases.otp_password+'</td> -->
        <td style="width: <?php echo $package_name_width;?>"><?php echo $cases['pack_name'];?></td>
        <td style="width: <?php echo $employee_id_width;?>"><?php echo $cases['employee_id'];?></td>
        <td style="width: <?php echo $status_width;?>"><?php echo $status;?></td>
        <td style="width: <?php echo $tat_start_date_width;?>"><?php echo $value['case_submitted_date'];?></td>
        <td style="width: <?php echo $tat_end_date_width;?>"><?php echo $value['report_generated_date']?></td>
        <!-- <td style="width: <?php echo $tat_days_width;?>"><?php echo $value['left_tat_days']?></td> -->
        <td style="width: <?php echo $actions_width;?>">
          <a href="<?php echo $this->config->item('my_base_url');?>factsuite-client/view-single-case/<?php echo $cases['candidate_id'].$request_from;?>"><img src="<?php echo base_url();?>assets/client/assets-v2/dist/img/black-eye.svg"></a>
          <?php if ($cases['is_submitted'] != 2 && $cases['is_submitted'] != 1) { ?> 
            <a class="ml-3" href="javascript:void(0)" onclick="edit_candidate_details_modal(<?php echo $cases['candidate_id'];?>)"><i class="fa fa-pencil"></i></a>
          <?php }
          if ($cases['is_submitted'] != 2 && $cases['is_submitted'] != 1 && $cases['document_uploaded_by'] =='client') { ?>
            <a target="_blank" class="ml-3" href="<?php echo $this->config->item('my_base_url');?>cases/resume_pending_case/<?php echo $cases['candidate_id'];?>"><i class="fa fa-wpforms"></i></a>
          <?php } ?>
          </td>
        </tr>
    <?php }
    } else { ?>
      <tr><td colspan="9"><span class="d-block text-center">No Case Found.</span></td></tr>
    <?php } ?>
  </tbody>
</table>
<ul class="pagination">
  <?php echo $pagelinks; ?>
</ul>