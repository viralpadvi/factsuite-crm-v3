<script>
  if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    window.location = link_base_url+'candidate-information';
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

  if($user['personal_information_form_filled_by_candidate_status'] == 1) {
    $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url($component_id[0],'link-for-mobile');
	} else {
		$next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url($component_id[0],'link-for-mobile');
	}
?> 
<div class="container-fluid content-bg-color">
		<div class="container-fluid content-div">
			<div class="row"></div>
			<div class="row content-div-content-row-1">
				<?php if (in_array('1',explode(',', $component_ids))) {
          $index = array_search('1',array_values(explode(',', $component_ids)));
          $form_filled_or_not = $this->db->select('COUNT(*) AS count')->where('candidate_id',$user['candidate_id'])->get('criminal_checks')->row_array();
          $active = '';
          $fa_check_html = '';
          if ($form_filled_or_not['count'] > 0) {
            $active = 'active';
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>

       <div class="col-12">
				<div class="verification-form-component-link-div">
					<a href="<?php echo $next_active_url;?>">
						<div class="row">
							<div class="col-10"><span class="input-main-hdr">
								<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 1) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			             } ?> <?php echo $fa_check_html;?>
								</span>
							</div>
							<div class="col-2 text-right">
								<img src="<?php echo base_url(); ?>assets/images/chevron-right.svg">
							</div>
						</div>
					</a>
				</div>
			</div>

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
          $fa_check_html = '';
          $check_uploaded_component_details_count++;
        }
      ?>
      <div class="col-12">
				<div class="verification-form-component-link-div">
					<a href="<?php echo $next_active_url;?>">
						<div class="row">
							<div class="col-10"><span class="input-main-hdr">
								<?php foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 2) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			            }
			          ?> <?php echo $fa_check_html;?>
								</span>
							</div>
							<div class="col-2 text-right">
								<img src="<?php echo base_url(); ?>assets/images/chevron-right.svg">
							</div>
						</div>
					</a>
				</div>
			</div>

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
          $fa_check_html = '';
          $check_uploaded_component_details_count++;
        } ?>
      <div class="col-12">
				<div class="verification-form-component-link-div">
					<a href="<?php echo $next_active_url;?>">
						<div class="row">
							<div class="col-10"><span class="input-main-hdr">
								<?php 
			            foreach ($db_component_list as $key => $value) {
			              if ($value['component_id'] == 3) {
			                echo $value[$this->config->item('show_component_name')];
			                break;
			              }
			            } ?> <?php echo $fa_check_html;?>
								</span>
							</div>
							<div class="col-2 text-right">
								<img src="<?php echo base_url(); ?>assets/images/chevron-right.svg">
							</div>
						</div>
					</a>
				</div>
			</div>
      <?php if ($form_filled_or_not['count'] > 0) {
        	$index = array_search(3,array_values(explode(',', $component_ids)))+1;
        	$next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
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
      <div class="col-12">
				<div class="verification-form-component-link-div">
					<a href="<?php echo $next_active_url;?>">
						<div class="row">
							<div class="col-10"><span class="input-main-hdr">
								<?php foreach ($db_component_list as $key => $value) {
			            if ($value['component_id'] == 4) {
			              echo $value[$this->config->item('show_component_name')];
			              break;
			            }
			          } ?> <?php echo $fa_check_html;?>
								</span>
							</div>
							<div class="col-2 text-right">
								<img src="<?php echo base_url(); ?>assets/images/chevron-right.svg">
							</div>
						</div>
					</a>
				</div>
			</div>
      <?php if ($form_filled_or_not['count'] > 0) {
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
          $fa_check_html = '';
          $check_uploaded_component_details_count++;
       	} ?>
        <div class="col-12">
					<div class="verification-form-component-link-div">
						<a href="<?php echo $next_active_url;?>">
							<div class="row">
								<div class="col-10"><span class="input-main-hdr">
									<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 5) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              } ?> <?php echo $fa_check_html;?>
									</span>
								</div>
								<div class="col-2 text-right">
									<img src="<?php echo base_url(); ?>assets/images/chevron-right.svg">
								</div>
							</div>
						</a>
					</div>
				</div>
        <?php if ($form_filled_or_not['count'] > 0) {
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
        <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 6) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 7) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
         <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 8) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 9) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 10) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 11) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 12) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 16) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 17) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 18) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 20) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(20,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
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
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 22) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(22,array_values(explode(',', $component_ids)))+1;
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 23) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 25) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(26,array_values(explode(',', $component_ids)))+1;
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
            $fa_check_html = '';
            $check_uploaded_component_details_count++;
          }
        ?>
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 26) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(26,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>

      
        <?php if (in_array('27',explode(',', $component_ids))) {
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
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 27) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(27,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>


        <?php if (in_array('28',explode(',', $component_ids))) {
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
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 28) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(28,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>


        <?php if (in_array('29',explode(',', $component_ids))) {
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
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 29) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(29,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>


        <?php if (in_array('30',explode(',', $component_ids))) {
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
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 30) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(30,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>


        <?php if (in_array('31',explode(',', $component_ids))) {
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
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 31) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(31,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>


        <?php if (in_array('32',explode(',', $component_ids))) {
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
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 32) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(32,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>


        <?php if (in_array('33',explode(',', $component_ids))) {
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
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 33) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(33,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>


        <?php if (in_array('34',explode(',', $component_ids))) {
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
          <div class="col-12">
			<div class="verification-form-component-link-div">
				<a href="<?php echo $next_active_url;?>">
					<div class="row">
						<div class="col-10"><span class="input-main-hdr">
						<?php 
			              foreach ($db_component_list as $key => $value) {
			                if ($value['component_id'] == 34) {
			                  echo $value[$this->config->item('show_component_name')];
			                  break;
			                }
			              }
			            ?> <?php echo $fa_check_html;?>
						</span></div>
						<div class="col-2 text-right">
							<img src="assets/images/chevron-right.svg">
						</div>
					</div>
				</a>
			</div>
		</div>
        <?php
          if ($form_filled_or_not['count'] > 0) {
            $index = array_search(34,array_values(explode(',', $component_ids)))+1;
            $next_active_url = $this->config->item('my_base_url').$this->candidateModel->redirect_url(isset($component_id[$index])?$component_id[$index]:0,'link-for-mobile');
          }  else {
            $next_active_url = $null_url;
          }
        } ?>



				
				<div class="col-12 d-none">
					<div class="verification-form-component-link-div">
						<a href="previous-employment.php">
							<div class="row">
								<div class="col-10"><span class="input-main-hdr">Previous employment Verificaiton</span></div>
								<div class="col-2 text-right">
									<img src="assets/images/chevron-right.svg">
								</div>
							</div>
							<div class="row sub-component-1">
								<div class="col-12">
									<span class="sub-component-main-txt">10th ,CBSE</span>
									<span class="sub-component-small-txt">2015</span>
									<span class="sub-component-small-txt">JBM Public school, Delhi-201325</span>
								</div>
								<div class="col-12"><hr></div>
								<div class="col-12">
									<span class="sub-component-main-txt">12th ,CBSE</span>
									<span class="sub-component-small-txt">2017</span>
									<span class="sub-component-small-txt">JBM Public school, Delhi-201325</span>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
			
		</div>
	</div>