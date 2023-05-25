<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/candidate-information';
   }
</script>
<?php $user = $this->session->userdata('logged-in-candidate');
  $count = count(explode(',', $component_ids));
  $component_id = explode(',', $component_ids);

  $social_active = $bankruptcy_active = $credit_active = $cv_active = $licence_active = $previous_address_active = $signature_active = $reference_active = $previous_active = $current_active = $global_active = $drug_active = $document_active = $criminal_active = $education_active = $court_active = $perminant_active = $present_active = $landload_active = 'javascript:void(0)';

  $next_active_url = 'javascript:void(0)';

  $null_url = 'javascript:void(0)';

  $check_uploaded_component_details_count = 0;

  $db_component_list = $this->db->get('components')->result_array();
?>
  <div class="steps">
    <div class="steps-bx">
      <div class="steps-hd">
        <h3>Employment Verification Form</h3>
        Please follow the Steps to Fill Your Form
      </div>
      <div class="steps-txt">
        <?php if ($is_submitted != '3') {
          $class = '';
          $fa_check_html = '';
          if($user['personal_information_form_filled_by_candidate_status'] == 1) {
            $class = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
          } else {
            $next_active_url = $null_url;
          }
        ?>
          <a class="<?php echo $class;?>" href="<?php echo $this->config->item('my_base_url');?>m-candidate-information-step-1">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x">1</strong>
            </span>
            Personal Information <?php echo $fa_check_html;?>
          </a>
        <?php
          if($user['personal_information_form_filled_by_candidate_status'] == 1) {
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url($component_id[0],'link-for-mobile');
          } else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('1',explode(',', $component_ids))) {
          $index = array_search('1',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('criminal_checks')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $class;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 1) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(1,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('2',explode(',', $component_ids))) {
          $index = array_search('2',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('court_records')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 2) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(2,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('3',explode(',', $component_ids))) {
          $index = array_search('3',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('document_check')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 3) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(3,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('4',explode(',', $component_ids))) {
          $index = array_search('4',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('drugtest')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 4) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(4,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('5',explode(',', $component_ids))) {
          $index = array_search('5',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('globaldatabase')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 5) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(5,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('6',explode(',', $component_ids))) {
          $index = array_search('6',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('current_employment')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 6) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(6,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('7',explode(',', $component_ids))) {
          $index = array_search('7',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('education_details')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 7) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(7,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('8',explode(',', $component_ids))) {
          $index = array_search('8',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('present_address')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
            <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
          </span>
          <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 8) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
        </a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(8,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('9',explode(',', $component_ids))) {
          $index = array_search('9',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('permanent_address')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2; ?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 9) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(9,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('10',explode(',', $component_ids))) {
          $index = array_search('10',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('previous_employment')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 10) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(10,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('11',explode(',', $component_ids))) {
          $index = array_search('11',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('reference')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 11) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(11,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array(12,explode(',', $component_ids))) { 
          $index = array_search(12,array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('previous_address')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 12) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(12,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('16',explode(',', $component_ids))) {
          $index = array_search('16',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('driving_licence')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 16) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(16,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('17',explode(',', $component_ids))) {
          $index = array_search('17',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('credit_cibil')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 17) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(17,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('18',explode(',', $component_ids))) {
          $index = array_search('18',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('bankruptcy')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 18) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(18,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('20',explode(',', $component_ids))) {
          $index = array_search('20',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('cv_check')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 20) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(20,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('23',explode(',', $component_ids))) {
          $index = array_search('23',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('landload_reference')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 23) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(23,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

        <?php if (in_array('25',explode(',', $component_ids))) {
          $index = array_search('25',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('social_media')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 25) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(25,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>



        <?php if (in_array('26',explode(',', $component_ids))) {
          $index = array_search('26',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('civil_check')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '<i class="fa fa-check float-right"></i>';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="<?php echo $active;?>">
            <span class="fa-stack">
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $index+2;?></strong>
            </span>
            <?php 
              foreach ($db_component_list as $key => $value) {
                if ($value['component_id'] == 26) {
                  echo $value[$this->config->item('show_component_name')];
                  break;
                }
              }
            ?> <?php echo $fa_check_html;?>
          </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(26,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>


        <?php if ($check_uploaded_component_details_count == $count) {
          $next_active_url = $this->config->item('my_base_url').'m-consent-form';
        } else {
          $next_active_url = $null_url;
        } ?>

        <a href="<?php echo $next_active_url;?>">
          <span class="fa-stack">
            <span class="fa fa-circle-o fa-stack-2x"></span>
            <strong class="fa-stack-1x"><?php echo $count+2; ?></strong>
          </span>Consent Form
        </a>
      </div>
    </div>
  </div>