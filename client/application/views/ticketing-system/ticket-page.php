 <table class=" table table-striped">
    <thead class="thead-bd-color">
      <tr>
        <th>Sl No.</th>
        <th>Ticket&nbsp;Id</th>
        <th>Role</th>
        <th>Subject</th>
        <th>Created&nbsp;Date</th>
        <th>Status</th>
        <th class="text-center">Actions</th>
      </tr>
    </thead>
    <tbody class="tbody-datatable" id="get-all-tickets">
       <?php if (count($case_list) > 0) {
      foreach ($case_list as $key => $value) {
        
          $status = '';
                        $role = ''; 
                  for ($j = 0; $j < count($get_ticket_status_list); $j++) {
                    if ($get_ticket_status_list[$j]['id'] == $value['ticket_status']) {
                      $status = $get_ticket_status_list[$j]['status'];
                      
                    }
                  }

                    if($value['ticket_created_by_role'] == 'client') {
                        $role = 'client';
                    } else {
                        for ( $j = 0; $j < count($all_team_members); $j++) {
                            if ($value['ticket_created_by_role_id'] == $all_team_members[$j]['team_id']) {
                                $role = $all_team_members[$j]['role'];
                                 
                            }
                        }
                    }
       ?>

      <tr>
        <td><?php echo ++$last_number_id; ?></td>
        <td><?php echo isset($value['ticket_id'])?$value['ticket_id']:''; ?></td>
        <td><?php echo $role; ?></td>
        <td><?php echo isset($value['ticket_subject'])?$value['ticket_subject']:''; ?></td>
        <td><?php echo $this->utilModel->get_date_formate(isset($value['ticket_created_date'])?$value['ticket_created_date']:''); ?></td>
        <td><?php echo $status; ?></td>
        <td><a id="view_ticket_details_a<?php echo isset($value['ticket_id'])?$value['ticket_id']:''; ?>" href="javascript:void(0)" onclick="view_ticket_details(<?php echo isset($value['ticket_id'])?$value['ticket_id']:''; ?>)"><img src="<?php echo base_url(); ?>assets/client/assets-v2/dist/img/black-eye.svg"></a></td>
      </tr>
 
  <?php }
    } else { ?>
      <tr><td colspan="7"><span class="d-block text-center">No Ticket Found.</span></td></tr>
    <?php } ?>
    </tbody>
  </table>
  <ul class="pagination">
  <?php echo $pagelinks; ?>
</ul>