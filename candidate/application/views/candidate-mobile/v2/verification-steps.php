<script>
   	if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      	window.location = link_base_url+'candidate-information';
   	}
</script>
<?php 
	$candidate_details = $this->session->userdata('logged-in-candidate');
	$count = count(explode(',', $component_ids));
  	$component_id = explode(',', $component_ids);

  	$consent_form_link =  'javascript:void(0)';

  	$check_uploaded_component_details_count = 0;

  	if (in_array('1',explode(',', $component_ids))) {
  		$form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('criminal_checks')->row_array();
  		if ($form_filled_or_not['count'] > 0) {
  			$check_uploaded_component_details_count++;
  		}
  	}

  	if (in_array('2',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('court_records')->row_array();
        if ($form_filled_or_not['count'] > 0) {
           	$check_uploaded_component_details_count++;
        }
    }

    if (in_array('3',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('document_check')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('4',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('drugtest')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('5',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('globaldatabase')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('6',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('current_employment')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('7',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('education_details')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('8',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('present_address')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('9',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('permanent_address')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('10',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('previous_employment')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('11',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('reference')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('12',explode(',', $component_ids))) { 
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('previous_address')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('16',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('driving_licence')->row_array();
        if ($form_filled_or_not['count'] > 0) {
           	$check_uploaded_component_details_count++;
        }
    }

    if (in_array('17',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('credit_cibil')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('18',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('bankruptcy')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('20',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('cv_check')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }


    if (in_array('22',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('employment_gap_check')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }



    if (in_array('23',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('landload_reference')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('25',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('social_media')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }


    if (in_array('26',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('civil_check')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('27',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('right_to_work')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('28',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('sex_offender')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('29',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('politically_exposed')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('30',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('india_civil_litigation')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('31',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('mca')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('32',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('nric')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('33',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('gsa')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    if (in_array('34',explode(',', $component_ids))) {
        $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('nric')->row_array();
        if ($form_filled_or_not['count'] > 0) {
            $check_uploaded_component_details_count++;
        }
    }

    $log = $this->db->where('client_id',$user['client_id'])->get('custom_logo')->row_array();
    $additional_document_count = 1;
    if (isset($log['additional']) && $log['additional'] == 1 && $user['additional_docs'] !=null && $user['additional_docs'] !='') {
    	$additional_document_count = 0;
    	$db_additional_docs = $this->db->select('additional_docs')->where('candidate_id',$candidate_details['candidate_id'])->get('candidate')->row_array();
    	if ($db_additional_docs['additional_docs'] != '' && $db_additional_docs['additional_docs'] != null) {
    		$additional_document_count = 1;
    	}

    }

    $verification_form_rick_mark_img = '';

    if ($check_uploaded_component_details_count == $count && $additional_document_count == 1) {
       	$consent_form_link = $this->config->item('my_base_url').'m-consent-form';
       	$verification_form_rick_mark_img = '<img src="'.base_url().'assets/images/verification-form-submitted-tick-mark.svg">';
    }
?>
<body>
	<!-- class="bg-black-body" -->
	<div id="bg-black" class="bg-black"></div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-6">
				<img src="<?php echo base_url(); ?>assets/images/factsuite-logo.svg" class="sign-in-fs-logo-img w-100">
			</div>
			<div class="col-6 text-right">
				<div class="dropdown dropdown-hdr-1">
					<button class="dropdown-hdr-btn dropdown-toggle" id="dropdown-hdr-btn" data-toggle="dropdown" aria-expanded="false">
						<img src="<?php echo base_url(); ?>assets/images/name-initial-bg.svg">
						<img src="<?php echo base_url(); ?>assets/images/hdr-name-initial-dropdown-chevron-down.svg">
						<span class="name-initial-hdr"><?php echo ucfirst(substr($candidate_details['first_name'], 0, 1));?></span>
					</button>
					<ul class="dropdown-menu" id="dropdown-menu">
				        <li>
				        	<a class="dropdown-support" href="javascript:void(0)" data-toggle="modal" data-target="#modal-support">
				        		<div class="row">
				        			<div class="col-8">
				        				<span>Support</span>
				        			</div>
				        			<div class="col-4">
				        				<img src="<?php echo base_url(); ?>assets/images/support-headphones.svg">
				        			</div>
				        		</div>
				        	</a>
				        </li>
				        <li>
				        	<a class="dropdown-signout" href="<?php echo $this->config->item('my_base_url')?>logout">
				        		<div class="row">
				        			<div class="col-8">
				        				<span>Sign Out</span>
				        			</div>
				        			<div class="col-4">
				        				<img src="<?php echo base_url(); ?>assets/images/signout.svg">
				        			</div>
				        		</div>
				        	</a>
				        </li>
				    </ul>
				</div>
			</div>
		</div>
	</div>
	<div class="container sign-in-bg bg-colored">
		<img src="<?php echo base_url(); ?>assets/images/verification-steps-bg.svg" class="sign-in-bg-img">
		<div class="greeting-candidate-div">
			<span class="greeting-candidate-main-txt">Welcome <?php echo ucfirst($candidate_details['first_name']);?>,</span>
			<span class="greeting-candidate-small-txt">Please Follow All the Steps In Order To Complete The Employment Verification Form</span>
		</div>
		<div class="enter-mobile-number-otp-div row">
			<div class="col-md-12 verification-step-main-div">
				<a href="<?php echo $this->config->item('my_base_url');?>m-candidate-information-step-1">
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
							<?php 
							$component_list_link = 'javascript:void(0)';
							if($candidate_details['personal_information_form_filled_by_candidate_status'] == 1) {
								$component_list_link = $this->config->item('my_base_url').'m-component-list';
							?>
								<img src="<?php echo base_url(); ?>assets/images/verification-form-submitted-tick-mark.svg">
							<?php } else {
								$personal_information_form_filled_by_candidate_status = $this->db->select('personal_information_form_filled_by_candidate_status')->where('candidate_id',$candidate_details['candidate_id'])->get('candidate')->row_array();

								if ($personal_information_form_filled_by_candidate_status['personal_information_form_filled_by_candidate_status'] == 1) {
									$component_list_link = $this->config->item('my_base_url').'m-component-list';
								?>
									<img src="<?php echo base_url(); ?>assets/images/verification-form-submitted-tick-mark.svg">
								<?php }
							} ?>
						</div>
					</div>
				</a>
			</div>

			<div class="col-md-12 verification-step-main-div">
				<a href="<?php echo $component_list_link;?>">
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
							<?php echo $verification_form_rick_mark_img;?>
						</div>
					</div>
				</a>
			</div>

			<div class="col-md-12 verification-step-main-div">
				<a href="<?php echo $consent_form_link;?>">
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
							<!-- <img src="<?php echo base_url(); ?>assets/images/verification-form-submitted-tick-mark.svg"> -->
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>