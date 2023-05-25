<?php 
  $db_component_list = $this->db->get('components')->result_array();

  $information = '';
  $present = '';
  $perminant = '';
  $court = '';
  $education = '';
  $criminal = '';
  $document = '';
  $drug = '';
  $global = '';
  $current ='';
  $previous = '';
  $reference ='';
  $signature = '';
  $previous_address = '';
  $licence = '';
  $cv = '';
  $credit = '';
  $bankruptcy = '';
  $social = ''; 
  $landload = '';
  $gap = '';
  $additional = '';
  $information_active = '';
  $present_active = '#';
  $perminant_active = '#';
  $court_active = '#';
  $education_active = '#';
  $criminal_active = '#';
  $document_active = '#';
  $drug_active = '#';
  $global_active = '#';
  $current_active ='#';
  $previous_active = '#';
  $reference_active ='#';
  $signature_active = '#';
  $previous_address_active = '#';
  $licence_active = '#';
  $cv_active = '#';
  $credit_active = '#';
  $bankruptcy_active = '#';
  $social_active = '#'; 
  $landload_active = '#';
  $gap_active = '#';
  $additional_active = '#';

  $client_name = '';
  if ($this->session->userdata('logged-in-candidate')) { 
    $client_name = strtolower(trim($user['first_name']).'-'.trim($user['last_name']));
  }else{
    redirect(base_url());
  } 
  if (strtolower(uri_string()) == 'factsuite-candidate/candidate-information' || strtolower(uri_string()) == $client_name.'/candidate-information') {
    $information = "active";
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-present-address' || strtolower(uri_string()) == $client_name.'/candidate-present-address') {
    $present = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-address' || strtolower(uri_string()) == $client_name.'/candidate-address') {
    $perminant = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-education' || strtolower(uri_string()) == $client_name.'/candidate-education') {
    $education = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-court-record' || strtolower(uri_string()) == $client_name.'/candidate-court-record') {
    $court = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-criminal-check' || strtolower(uri_string()) == $client_name.'/candidate-criminal-check') {
    $criminal = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-document-check' || strtolower(uri_string()) == $client_name.'/candidate-document-check') {
    $document = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-drug-test' || strtolower(uri_string()) == $client_name.'/candidate-drug-test') {
    $drug = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-global-database' || strtolower(uri_string()) == $client_name.'/candidate-global-database') {
    $global = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-employment' || strtolower(uri_string()) == $client_name.'/candidate-employment') {
    $current = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-previos-employment' || strtolower(uri_string()) == $client_name.'/candidate-previos-employment') {
    $previous = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-reference' || strtolower(uri_string()) == $client_name.'/candidate-reference') {
    $reference = 'active';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-signature' || strtolower(uri_string()) == $client_name.'/candidate-signature') {
    $signature = 'active';
    $signature_active = $this->config->item('my_base_url').$client_name."/candidate-signature"; 
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-previous-address' || strtolower(uri_string()) == $client_name.'/candidate-previous-address') {
    $previous_address = 'active';
  }else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-driving-licence' || strtolower(uri_string()) == $client_name.'/candidate-driving-licence'){
    $licence = 'active';
  }else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-cv-check' || strtolower(uri_string()) == $client_name.'/candidate-cv-check'){
    $cv = 'active';
  }else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-credit-cibil' || strtolower(uri_string()) == $client_name.'/candidate-credit-cibil'){
    $credit = 'active';
  }else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-bankruptcy' || strtolower(uri_string()) == $client_name.'/candidate-bankruptcy'){
    $bankruptcy = 'active';
  }else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-landload-reference' || strtolower(uri_string()) == $client_name.'/candidate-landload-reference'){
    $landload = 'active';
  }else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-social-media' || strtolower(uri_string()) == $client_name.'/candidate-social-media'){
    $social = 'active';
  }else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-employment-gap' || strtolower(uri_string()) == $client_name.'/candidate-employment-gap'){
    $gap = 'active';
  }else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-additional' || strtolower(uri_string()) == $client_name.'/candidate-additional'){
    $additional = 'active';
  }else {
   $information= 'active';
  }

  if ($is_submitted != '3') {
    $information = 'active';
  }
?>   

  


   <!--Page Menu-->
   <div class="pg-mn-cntr">
      <div class="pg-mn">
         <ul>
          <?php 
          if ($is_submitted !='3') { 
          ?>
            <li>
               <a href="<?php echo $this->config->item('my_base_url'); ?>factsuite-candidate/candidate-information" class="<?php echo $information; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
               <strong class="fa-stack-1x">1</strong></span>Personal Information</a>
            </li>
            <?php 
              }
            ?>

         <?php 
 
            if (in_array('1',explode(',', $component_ids))) {
              $index = array_search('1',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('criminal_checks')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $criminal = 'active';
                $criminal_active = $this->config->item('my_base_url').$client_name."/candidate-criminal-check";
              }
            ?>
              <li>
                <a class="<?php echo $criminal; ?>" href="<?php echo $criminal_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                  <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span> 
                  <?php 
                    foreach ($db_component_list as $key => $value) {
                      if ($value['component_id'] == 1) {
                        echo $value[$this->config->item('show_component_name')];
                        break;
                      }
                    }
                  ?>
                </a>
              </li>
            <?php } ?>

            <?php if (in_array('2',explode(',', $component_ids))) {
              $index = array_search('2',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('court_records')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $court = 'active';
                $court_active = $this->config->item('my_base_url').$client_name."/candidate-court-record";
              }
            ?>
              <li>
                <a class="<?php echo $court; ?>" href="<?php echo $court_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                  <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                  <?php 
                    foreach ($db_component_list as $key => $value) {
                      if ($value['component_id'] == 2) {
                        echo $value[$this->config->item('show_component_name')];
                        break;
                      }
                    }
                  ?>
                </a>
              </li>
            <?php } ?>

            <?php if (in_array('3',explode(',', $component_ids))) {
              $index = array_search('3',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('document_check')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $document = 'active';
                $document_active = $this->config->item('my_base_url').$client_name."/candidate-document-check";
              }
            ?>
            <li>
              <a class="<?php echo $document; ?>"   href="<?php echo $document_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 3) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>

            <?php if (in_array('4',explode(',', $component_ids))) {
              $index = array_search('4',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('drugtest')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $drug = 'active';
                $drug_active = $this->config->item('my_base_url').$client_name."/candidate-drug-test";
              }
            ?>
            <li>
              <a class="<?php echo $drug; ?>"  href="<?php echo $drug_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 4) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>

            <?php if (in_array('5',explode(',', $component_ids))) {
              $index = array_search('5',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('globaldatabase')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $global = 'active';
                $global_active = $this->config->item('my_base_url').$client_name."/candidate-global-database";
              }
            ?>
            <li>
              <a class="<?php echo $global; ?>" href="<?php echo $global_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 5) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>

            <?php if (in_array('6',explode(',', $component_ids))) {
              $index = array_search('6',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('current_employment')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $current = 'active';
                $current_active = $this->config->item('my_base_url').$client_name."/candidate-employment";
              }
            ?>
            <li>
              <a class="<?php echo $current; ?>" href="<?php echo $current_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 6) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?> 

            <?php if (in_array('7',explode(',', $component_ids))) {
              $index = array_search('7',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('education_details')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $education = 'active';
                $education_active = $this->config->item('my_base_url').$client_name."/candidate-education";
              }
            ?>
            <li>
              <a class="<?php echo $education; ?>"  href="<?php echo $education_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 7) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>


            <?php $count = count(explode(',', $component_ids));
            if (in_array('8',explode(',', $component_ids))) {
              $index = array_search('8',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('present_address')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $present = 'active';
                $present_active = $this->config->item('my_base_url').$client_name."/candidate-present-address";
              }
            ?>
            <li>
              <a class="<?php echo $present; ?>"  href="<?php echo $present_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 8) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>
          
            <?php if (in_array('9',explode(',', $component_ids))) {
              $index = array_search('9',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('permanent_address')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $perminant = 'active';
                $perminant_active = $this->config->item('my_base_url').$client_name."/candidate-address";
              }
            ?>
            <li>
              <a class="<?php echo $perminant; ?>"  href="<?php echo $perminant_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 9) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>
            
            <?php if (in_array('10',explode(',', $component_ids))) {
              $index = array_search('10',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('previous_employment')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $previous = 'active';
                $previous_active = $this->config->item('my_base_url').$client_name."/candidate-previos-employment";
              }
            ?>
            <li>
              <a class="<?php echo $previous; ?>" href="<?php echo $previous_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 10) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>
            
            <?php if (in_array('11',explode(',', $component_ids))) {
              $index = array_search('11',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('reference')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $reference = 'active';
                $reference_active = $this->config->item('my_base_url').$client_name."/candidate-reference";
              }
            ?>
            <li>
              <a class="<?php echo $reference; ?>" href="<?php echo $reference_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 11) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>
           
            <?php if (in_array(12,explode(',', $component_ids))) { 
              $index = array_search(12,array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('previous_address')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $previous_address = 'active';
                $previous_address_active = $this->config->item('my_base_url').$client_name."/candidate-previous-address";
              }
            ?>
            <li>
              <a class="<?php echo $previous_address; ?>" href="<?php echo $previous_address_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 12) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>

            <?php if (in_array('16',explode(',', $component_ids))) {
              $index = array_search('16',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('driving_licence')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $licence = 'active';
                $licence_active = $this->config->item('my_base_url').$client_name."/candidate-driving-licence";
              }
            ?>
            <li>
              <a class="<?php echo $licence; ?>" href="<?php echo $licence_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 16) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>

            <?php if (in_array('17',explode(',', $component_ids))) {
              $index = array_search('17',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('credit_cibil')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $credit = 'active';
                $credit_active = $this->config->item('my_base_url').$client_name."/candidate-credit-cibil";
              }
            ?>
            <li>
              <a class="<?php echo $credit; ?>" href="<?php echo $credit_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 17) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>

            <?php if (in_array('18',explode(',', $component_ids))) {
              $index = array_search('18',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('bankruptcy')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $bankruptcy = 'active';
                $bankruptcy_active = $this->config->item('my_base_url').$client_name."/candidate-bankruptcy";
              }
            ?>
            <li>
              <a class="<?php echo $bankruptcy; ?>" href="<?php echo $bankruptcy_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 18) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>

            <?php if (in_array('20',explode(',', $component_ids))) {
              $index = array_search('20',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('cv_check')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $cv = 'active';
                $cv_active = $this->config->item('my_base_url').$client_name."/candidate-cv-check";
              }
            ?>
            <li>
              <a class="<?php echo $cv; ?>" href="<?php echo $cv_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 20) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>

            <?php if (in_array('22',explode(',', $component_ids))) {
              $index = array_search('22',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('employment_gap_check')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $gap = 'active';
                $gap_active = $this->config->item('my_base_url').$client_name."/candidate-employment-gap";
              }
            ?>
            <li>
              <a class="<?php echo $gap; ?>" href="<?php echo $gap_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 22) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>

            <?php if (in_array('23',explode(',', $component_ids))) {
              $index = array_search('23',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('landload_reference')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $landload = 'active';
                $landload_active = $this->config->item('my_base_url').$client_name."/candidate-landload-reference";
              }
            ?>
            <li>
              <a class="<?php echo $landload; ?>" href="<?php echo $landload_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 23) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php } ?>

            <?php if (in_array('25',explode(',', $component_ids))) {
              $index = array_search('25',array_values(explode(',', $component_ids)));
              $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('social_media')->row_array();
              if ($form_filled_or_not['count'] > 0) {
                $social = 'active';
                $social_active = $this->config->item('my_base_url').$client_name."/candidate-social-media";
              }
            ?>
            <li>
              <a class="<?php echo $social; ?>" href="<?php echo $social_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
                <strong class="fa-stack-1x"><?php echo $index+2; ?></strong></span>
                <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 25) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                  }
                ?>
              </a>
            </li>
            <?php }
            $log = $this->db->where('client_id',$user['client_id'])->get('custom_logo')->row_array();
            $counts = $count+2;
              if (isset($log['additional'])) {
                if ($log['additional'] == 1 && $user['additional_docs'] !=null && $user['additional_docs'] !='') {
                  $additional = 'active';
                  $additional_active =  $this->config->item('my_base_url').$client_name.'/candidate-additional';
                  ?>
            <li>
              <a class="<?php echo $additional; ?>" href="<?php echo $additional_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $counts; ?></strong></span>Additional Documents</a>
            </li>
             <?php
             $counts = $count+3;
                }
              }
             ?>
 
            <li>
              <a class="<?php echo $signature; ?>" href="<?php echo $signature_active; ?>"><span class="fa-stack"><span class="fa fa-circle-o fa-stack-2x"></span>
              <strong class="fa-stack-1x"><?php echo $counts; ?></strong></span>Consent Form</a>
            </li>
            
           
         </ul>
      </div>
   </div>
   <!--Page Menu-->