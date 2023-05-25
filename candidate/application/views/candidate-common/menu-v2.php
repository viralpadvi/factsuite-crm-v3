<?php $user = $this->session->userdata('logged-in-candidate');
	$component_ids = $this->session->userdata('component_ids');
  $count = count(explode(',', $component_ids));
  $component_id = explode(',', $component_ids);

  
  $social_active = $bankruptcy_active = $credit_active = $cv_active = $licence_active = $previous_address_active = $signature_active = $reference_active = $previous_active = $current_active = $global_active = $drug_active = $document_active = $criminal_active = $education_active = $court_active = $perminant_active = $present_active = $landload_active = 'javascript:void(0)';

  $next_active_url = 'javascript:void(0)';

  $null_url = 'javascript:void(0)';

  $check_uploaded_component_details_count = 0;

  $db_component_list = $this->db->get('components')->result_array();

  $client_name = '';
  $user_name = '';
  if ($this->session->userdata('logged-in-candidate')) {
    $client_name = strtolower(trim($user['first_name']).'-'.trim($user['last_name']));
    $client_name = preg_replace('/ /i','-',$client_name);
    $user_name = $user['first_name'].' '.$user['last_name'];
  } else {
    redirect(base_url());
  } 

  if($user['personal_information_form_filled_by_candidate_status'] == 1) {
    $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url($component_id[0]);
	} else {
		$next_active_url = $null_url;
	}
   $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url($component_id[0]);
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
  $aria_expanded = 'true';
  $component_list_div_show = ' show';
  $civil = '';
  $right_to_work = '';
  $sex_offender = '';
  $politically_exposed = '';
  $india_civil_litigation = '';
  $mca = '';
  $nric = '';
  $gsa = '';
  $oig = ''; 

  $page_name = '';

	if (strtolower(uri_string()) == 'factsuite-candidate/candidate-information' || strtolower(uri_string()) == $client_name.'/candidate-information') {
    $information = ' active';
    $aria_expanded = 'false';
    $component_list_div_show = '';
    $page_name = 'Personal Information';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-present-address' || strtolower(uri_string()) == $client_name.'/candidate-present-address') {
    $present = ' active';
    $page_name = 'Present Address Verification';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-address' || strtolower(uri_string()) == $client_name.'/candidate-address') {
    $perminant = ' active';
    $page_name = 'Permanent Address Verification';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-education' || strtolower(uri_string()) == $client_name.'/candidate-education') {
    $education = ' active';
    $page_name = 'Education Verification';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-court-record' || strtolower(uri_string()) == $client_name.'/candidate-court-record') {
    $court = ' active';
    $page_name = 'Court Record';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-criminal-check' || strtolower(uri_string()) == $client_name.'/candidate-criminal-check') {
    $criminal = ' active';
    $page_name = 'Criminal Background Verification';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-document-check' || strtolower(uri_string()) == $client_name.'/candidate-document-check') {
    $document = ' active';
    $page_name = 'Identity Verification';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-drug-test' || strtolower(uri_string()) == $client_name.'/candidate-drug-test') {
    $drug = ' active';
    $page_name = 'Drug Test';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-global-database' || strtolower(uri_string()) == $client_name.'/candidate-global-database') {
    $global = ' active';
    $page_name = 'Global Database Check';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-employment' || strtolower(uri_string()) == $client_name.'/candidate-employment') {
    $current = ' active';
    $page_name = 'Current Employment Verification';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-previos-employment' || strtolower(uri_string()) == $client_name.'/candidate-previos-employment') {
    $previous = ' active';
    $page_name = 'Previous Employment Verification';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-reference' || strtolower(uri_string()) == $client_name.'/candidate-reference') {
    $reference = ' active';
    $page_name = 'Reference Check';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-previous-address' || strtolower(uri_string()) == $client_name.'/candidate-previous-address') {
    $previous_address = ' active';
    $page_name = 'Previous Address Verification';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-driving-licence' || strtolower(uri_string()) == $client_name.'/candidate-driving-licence') {
    $licence = ' active';
    $page_name = 'Driving License';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-cv-check' || strtolower(uri_string()) == $client_name.'/candidate-cv-check') {
    $cv = ' active';
    $page_name = 'CV Check';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-credit-cibil' || strtolower(uri_string()) == $client_name.'/candidate-credit-cibil') {
    $credit = ' active';
    $page_name = 'Credit History Check';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-bankruptcy' || strtolower(uri_string()) == $client_name.'/candidate-bankruptcy') {
    $bankruptcy = ' active';
    $page_name = 'Bankruptcy Records Search';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-landload-reference' || strtolower(uri_string()) == $client_name.'/candidate-landload-reference') {
    $landload = ' active';
    $page_name = 'Previous Landlord Reference Check';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-social-media' || strtolower(uri_string()) == $client_name.'/candidate-social-media') {
    $social = ' active';
    $page_name = 'Social Media Check';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-employment-gap' || strtolower(uri_string()) == $client_name.'/candidate-employment-gap') {
    $gap = ' active';
    $page_name = 'Employee Gap Check';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-right-to-work' || strtolower(uri_string()) == $client_name.'/candidate-right-to-work') {
    $right_to_work = ' active';
    $page_name = 'Right To Work';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-sex-offender' || strtolower(uri_string()) == $client_name.'/candidate-sex-offender') {
    $sex_offender = ' active';
    $page_name = 'Sex Offender';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-politically-exposed' || strtolower(uri_string()) == $client_name.'/candidate-politically-exposed') {
    $politically_exposed = ' active';
    $page_name = 'Politically Exposed Person';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-india-civil-litigation' || strtolower(uri_string()) == $client_name.'/candidate-india-civil-litigation') {
    $india_civil_litigation = ' active';
    $page_name = 'India Civil Litigation';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-mca' || strtolower(uri_string()) == $client_name.'/candidate-mca') {
    $mca = ' active';
    $page_name = 'MCA';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-nric' || strtolower(uri_string()) == $client_name.'/candidate-nric') {
    $nric = ' active';
    $page_name = 'NRIC';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-gsa' || strtolower(uri_string()) == $client_name.'/candidate-gsa') {
    $gsa = ' active';
    $page_name = 'GSA';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-oig' || strtolower(uri_string()) == $client_name.'/candidate-oig') {
    $oig = ' active';
    $page_name = 'OIG';
  } else if(strtolower(uri_string()) == 'factsuite-candidate/candidate-additional' || strtolower(uri_string()) == $client_name.'/candidate-additional') {
    $additional = ' active';
    $page_name = 'Additional Document';
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-signature' || strtolower(uri_string()) == $client_name.'/candidate-signature') {
    $signature = ' active';
    $aria_expanded = 'false';
    $component_list_div_show = '';
    if ($candidate_details['document_uploaded_by'] == 'candidate') {
      $page_name = 'Consent Form';
    } else {
      $page_name = 'Consent Form';
      if ($client_details['signature'] =='1') { 
      $page_name = 'Upload LOA';
      }
    }
    $signature_active = $this->config->item('my_base_url').$client_name."/candidate-signature"; 
  } else if (strtolower(uri_string()) == 'factsuite-candidate/candidate-civil-check' || strtolower(uri_string()) == $client_name.'/candidate-civil-check') {
    $civil = ' active';
    $page_name = 'Civil litigation Check';
  } else {
   	$information = ' active';
   	$page_name = 'Personal Information';
  }
?> 
	<div class="container-fluid main-data-div">
		<div class="row">
			<div class="col-md-4">
				<div class="candidate-forms-main-div">
					<div class="welcome-candidate-div">
						<img src="<?php echo base_url(); ?>assets/images/desktop/welome-bg.svg">
						<div class="welcome-candidate-msg-div">
							<h2>Welcome <?php echo ucwords($user_name); ?>,</h2>
							<span>Please follow all the steps in order to complete the Employment Verification form.</span>
						</div>
					</div>
					<div class="container-fluid">
						<div class="row verification-steps-main-div">
							<!-- Add active at the next div if the user is on this page. Same for consent form And do not add active for the step 2 -->
							<div class="col-md-12 verification-step-main-div<?php echo $information;?>">
								<a href="<?php echo $this->config->item('my_base_url').$client_name; ?>/candidate-information">
									<div class="row">
										<div class="col-2 verification-type-logo">
											<img src="<?php echo base_url(); ?>assets/images/personal-info.svg">
										</div>
										<div class="col-8">
											<img src="<?php echo base_url(); ?>assets/images/verification-form-step-ribbon.svg">
											<span class="verification-step-name">Step 1</span>
											<span class="verification-step-type">Personal Information</span>
										</div>
										<div class="col-2 text-right">
											<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
										</div>
									</div>
								</a>
							</div>

							<!-- If active than add aria-expanded="true" after data-target and also add show in class of id="verification-component-list" -->
							<div class="col-md-12 verification-step-main-div" data-toggle="collapse" data-target="#verification-component-list" aria-expanded="<?php echo $aria_expanded;?>">
								<a href="javascript:void(0)">
									<div class="row">
										<div class="col-2 verification-type-logo">
											<img src="<?php echo base_url(); ?>assets/images/verification-form-logo.svg">
										</div>
										<div class="col-8">
											<img src="<?php echo base_url(); ?>assets/images/verification-form-step-ribbon.svg">
											<span class="verification-step-name">Step 2</span>
											<span class="verification-step-type">Verification form</span>
										</div>
										<div class="col-2 text-right">
											<img src="<?php echo base_url(); ?>assets/images/desktop/chevron-down.svg" class="chevron-down">
										</div>
									</div>
								</a>
							</div>
							<div id="verification-component-list" class="collapse verification-component-list<?php echo $component_list_div_show;?>">
								<div class="container-fluid">
								 

		<?php if (in_array('1',explode(',', $component_ids))) {
          $index = array_search('1',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('criminal_checks')->row_array();
          $next_active_url = $this->config->item('my_base_url').$client_name."/candidate-criminal-check";
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
 

				<a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $criminal;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 1) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>


      <?php
        if ($form_filled_or_not['count'] > 0) {
          $index = array_search(1,array_values(explode(',', $component_ids)))+1;
          $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
          $fa_check_html = '';
          $check_uploaded_component_details_count++;
        }
      ?>
      

				<a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $court;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 2) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>

      <?php
        if ($form_filled_or_not['count'] > 0) {
          $index = array_search(2,array_values(explode(',', $component_ids)))+1;
          $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
          $fa_check_html = '';
          $check_uploaded_component_details_count++;
        } ?>
      <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $document;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 3) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
      <?php if ($form_filled_or_not['count'] > 0) {
        	$index = array_search(3,array_values(explode(',', $component_ids)))+1;
        	$next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
       	} else {
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
          $fa_check_html = '';
          $check_uploaded_component_details_count++;
        }
      ?>
      <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $drug;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 4) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
      <?php if ($form_filled_or_not['count'] > 0) {
          $index = array_search(4,array_values(explode(',', $component_ids)))+1;
          $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
          $fa_check_html = '';
          $check_uploaded_component_details_count++;
       	} ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $global;?>">
				<div class="row">
					<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
					<div class="col-9"><span class="sidebar-component-name">
						<?php 
		            foreach ($db_component_list as $key => $value) {
		              if ($value['component_id'] == 5) {
		                echo $value[$this->config->item('show_component_name')];
		                break;
		              }
		             } ?> <?php echo $fa_check_html;?>
					</span></div>
					<div class="col-2 arrow-div">
						<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
					</div>
				</div>
			</a>
        <?php if ($form_filled_or_not['count'] > 0) {
          	$index = array_search(5,array_values(explode(',', $component_ids)))+1;
          	$next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $current;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 6) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(6,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
          <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $education;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 7) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(7,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $present;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 8) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(8,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $perminant;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 9) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(9,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $previous;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 10) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(10,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $reference;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 11) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(11,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $previous_address;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 12) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(12,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $licence;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 16) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(16,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
         <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $credit;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 17) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(17,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $bankruptcy;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 18) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
        <?php 
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(18,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $cv;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 20) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(20,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
          }  else {
            $next_active_url = $null_url;
          }
        } ?>


        <?php if (in_array('22',explode(',', $component_ids))) {
          $index = array_search('22',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('employment_gap_check')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $gap;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 22) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(22,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $landload;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 23) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(23,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $social;?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 25) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(25,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
          }  else {
            $next_active_url = $null_url;
          }
        }


            if (in_array('26',explode(',', $component_ids))) {
          $index = array_search('26',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('civil_check')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $civil;?>">
          <div class="row">
            <div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
            <div class="col-9"><span class="sidebar-component-name">
              <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 26) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                   } ?> <?php echo $fa_check_html;?>
            </span></div>
            <div class="col-2 arrow-div">
              <img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
            </div>
          </div>
        </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(26,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
          }  else {
            $next_active_url = $null_url;
          }
        }

            if (in_array('27',explode(',', $component_ids))) {
          $index = array_search('27',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('right_to_work')->row_array(); 
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $right_to_work;?>">
          <div class="row">
            <div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
            <div class="col-9"><span class="sidebar-component-name">
              <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 27) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                   } ?> <?php echo $fa_check_html;?>
            </span></div>
            <div class="col-2 arrow-div">
              <img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
            </div>
          </div>
        </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(27,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
          }  else {
            $next_active_url = $null_url;
          }
        } 



            if (in_array('28',explode(',', $component_ids))) {
          $index = array_search('28',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('sex_offender')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $sex_offender;?>">
          <div class="row">
            <div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
            <div class="col-9"><span class="sidebar-component-name">
              <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 28) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                   } ?> <?php echo $fa_check_html;?>
            </span></div>
            <div class="col-2 arrow-div">
              <img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
            </div>
          </div>
        </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(28,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
          }  else {
            $next_active_url = $null_url;
          }
        } 



            if (in_array('29',explode(',', $component_ids))) {
          $index = array_search('29',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('politically_exposed')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $politically_exposed;?>">
          <div class="row">
            <div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
            <div class="col-9"><span class="sidebar-component-name">
              <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 29) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                   } ?> <?php echo $fa_check_html;?>
            </span></div>
            <div class="col-2 arrow-div">
              <img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
            </div>
          </div>
        </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(29,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
          }  else {
            $next_active_url = $null_url;
          }
        } 



            if (in_array('30',explode(',', $component_ids))) {
          $index = array_search('30',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('india_civil_litigation')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $india_civil_litigation;?>">
          <div class="row">
            <div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
            <div class="col-9"><span class="sidebar-component-name">
              <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 30) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                   } ?> <?php echo $fa_check_html;?>
            </span></div>
            <div class="col-2 arrow-div">
              <img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
            </div>
          </div>
        </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(30,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
          }  else {
            $next_active_url = $null_url;
          }
        } 



            if (in_array('31',explode(',', $component_ids))) {
          $index = array_search('31',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('mca')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $mca;?>">
          <div class="row">
            <div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
            <div class="col-9"><span class="sidebar-component-name">
              <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 31) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                   } ?> <?php echo $fa_check_html;?>
            </span></div>
            <div class="col-2 arrow-div">
              <img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
            </div>
          </div>
        </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(31,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
          }  else {
            $next_active_url = $null_url;
          }
        } 



            if (in_array('32',explode(',', $component_ids))) {
          $index = array_search('32',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('nric')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $nric;?>">
          <div class="row">
            <div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
            <div class="col-9"><span class="sidebar-component-name">
              <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 32) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                   } ?> <?php echo $fa_check_html;?>
            </span></div>
            <div class="col-2 arrow-div">
              <img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
            </div>
          </div>
        </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(32,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
          }  else {
            $next_active_url = $null_url;
          }
        } 



            if (in_array('33',explode(',', $component_ids))) {
          $index = array_search('33',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('gsa')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $gsa;?>">
          <div class="row">
            <div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
            <div class="col-9"><span class="sidebar-component-name">
              <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 33) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                   } ?> <?php echo $fa_check_html;?>
            </span></div>
            <div class="col-2 arrow-div">
              <img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
            </div>
          </div>
        </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(33,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
          }  else {
            $next_active_url = $null_url;
          }
        } 



            if (in_array('34',explode(',', $component_ids))) {
          $index = array_search('34',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('oig')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <a href="<?php echo $next_active_url;?>" class="verification-component-div<?php echo $oig;?>">
          <div class="row">
            <div class="col-1 pr-0"><span class="verification-form-count"><?php echo $index+1; ?>.</span></div>
            <div class="col-9"><span class="sidebar-component-name">
              <?php 
                  foreach ($db_component_list as $key => $value) {
                    if ($value['component_id'] == 34) {
                      echo $value[$this->config->item('show_component_name')];
                      break;
                    }
                   } ?> <?php echo $fa_check_html;?>
            </span></div>
            <div class="col-2 arrow-div">
              <img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
            </div>
          </div>
        </a>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(34,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0);
          }  else {
            $next_active_url = $null_url;
          }
        } 



            $log = $this->db->where('client_id',$user['client_id'])->get('custom_logo')->row_array();
            // $counts = $index+1;
              if (isset($log['additional'])) {
                if ($log['additional'] == 1 && $user['additional_docs'] !=null && $user['additional_docs'] !='') {
                  $additional_link =  $this->config->item('my_base_url').$client_name.'/candidate-additional';
                  ?>
          
            <a href="<?php echo $additional_link; ?>" class="verification-component-div<?php echo $additional; ?>">
					<div class="row">
						<div class="col-1 pr-0"><span class="verification-form-count"><?php echo isset($index)?$index:0+1; ?>.</span></div>
						<div class="col-9"><span class="sidebar-component-name">
							Additional Documents
						</span></div>
						<div class="col-2 arrow-div">
							<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
						</div>
					</div>
				</a>
             <?php 
                }
              }
             ?> 




								</div>
							</div>

							<div class="col-md-12 verification-step-main-div<?php echo $signature;?>">
								<a href="<?php echo $signature_active;?>">
									<div class="row">
										<div class="col-2 verification-type-logo">
											<img src="<?php echo base_url(); ?>assets/images/consent-form-logo.svg">
										</div>
										<div class="col-8">
											<img src="<?php echo base_url(); ?>assets/images/verification-form-step-ribbon.svg">
											<span class="verification-step-name">Step 3</span>
											<span class="verification-step-type">Consent form</span>
										</div>
										<div class="col-2 text-right">
											<img src="<?php echo base_url(); ?>assets/images/desktop/arrow-right.svg" class="arrow-right">
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="candidate-form-fill-details-main-div content-div">
					<h2 class="component-name"><?php echo $page_name;?></h2>