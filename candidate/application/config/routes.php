<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'main_Candidate_Controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['logout'] = 'CandidateLogin/logout';

$route['factsuite-candidate/sign-in'] = 'main_Candidate_Controller/sign_in_otp';
$route['m-verification-steps'] = $route['(:any)/m-verification-steps'] = $route['factsuite-candidate/m-verification-steps'] = 'main_Candidate_Controller/m_verification_steps';
$route['(:any)/candidate-information'] = $route['factsuite-candidate/candidate-information'] = 'main_Candidate_Controller/candidate_form_fill_data';
$route['(:any)/send-otp-to-email-id'] = $route['factsuite-candidate/send-otp-to-email-id'] = 'Candidate/send_otp_to_email_id';
$route['(:any)/validate-to-email-id'] = $route['factsuite-candidate/validate-to-email-id'] = 'Candidate/validate_to_email_id';

$route['(:any)/candidate-address'] = $route['factsuite-candidate/candidate-address'] = 'main_Candidate_Controller/address_details';
$route['(:any)/candidate-present-address'] = $route['factsuite-candidate/candidate-present-address'] = 'main_Candidate_Controller/present_address_details';
$route['(:any)/candidate-education'] = $route['factsuite-candidate/candidate-education'] = 'main_Candidate_Controller/education_details';
$route['(:any)/candidate-employment'] = $route['factsuite-candidate/candidate-employment'] = 'main_Candidate_Controller/employment_details';
$route['(:any)/candidate-previos-employment'] = $route['factsuite-candidate/candidate-previos-employment'] = 'main_Candidate_Controller/previous_employment_details';
$route['(:any)/candidate-reference'] = $route['factsuite-candidate/candidate-reference'] = 'main_Candidate_Controller/reference';
$route['(:any)/candidate-signature'] = $route['factsuite-candidate/candidate-signature'] = 'main_Candidate_Controller/signature';
$route['(:any)/candidate-court-record'] = $route['factsuite-candidate/candidate-court-record'] = 'main_Candidate_Controller/court_record';
/**/
$route['(:any)/candidate-criminal-check'] = $route['factsuite-candidate/candidate-criminal-check'] = 'main_Candidate_Controller/criminal_check';
$route['(:any)/candidate-document-check'] = $route['factsuite-candidate/candidate-document-check'] = 'main_Candidate_Controller/document_check';
$route['(:any)/candidate-drug-test'] = $route['factsuite-candidate/candidate-drug-test'] = 'main_Candidate_Controller/drug_test'; 
$route['(:any)/candidate-global-database'] = $route['factsuite-candidate/candidate-global-database'] = 'main_Candidate_Controller/global_database'; 
$route['(:any)/candidate-previous-address'] = $route['factsuite-candidate/candidate-previous-address'] = 'main_Candidate_Controller/previous_address_details'; 

/*new candidate*/
$route['(:any)/candidate-driving-licence'] = $route['factsuite-candidate/candidate-driving-licence'] = 'main_Candidate_Controller/candidate_driving_licence'; 
$route['(:any)/candidate-cv-check'] = $route['factsuite-candidate/candidate-cv-check'] = 'main_Candidate_Controller/candidate_cv_check'; 
$route['(:any)/candidate-credit-cibil'] = $route['factsuite-candidate/candidate-credit-cibil'] = 'main_Candidate_Controller/candidate_credit_cibil'; 
$route['(:any)/candidate-bankruptcy'] = $route['factsuite-candidate/candidate-bankruptcy'] = 'main_Candidate_Controller/candidate_bankruptcy'; 
$route['(:any)/candidate-landload-reference'] = $route['factsuite-candidate/candidate-landload-reference'] = 'main_Candidate_Controller/candidate_landload_reference'; 
$route['(:any)/candidate-social-media'] = $route['factsuite-candidate/candidate-social-media'] = 'main_Candidate_Controller/candidate_social_media'; 
$route['(:any)/candidate-employment-gap-form'] = $route['factsuite-candidate/candidate-employment-gap-form'] = 'candidate/update_candidate_gap'; 
$route['(:any)/candidate-employment-gap'] = $route['factsuite-candidate/candidate-employment-gap'] = 'main_Candidate_Controller/candidate_employee_gap_check'; 
$route['(:any)/candidate-additional'] = $route['factsuite-candidate/candidate-additional'] = 'main_Candidate_Controller/candidate_additional'; 
$route['(:any)/candidate-civil-check'] = $route['factsuite-candidate/candidate-civil-check'] = 'main_Candidate_Controller/civil_check'; 
 
$route['candidate/resend-otp'] = 'CandidateLogin/resend_otp';
// new components 
$route['(:any)/candidate-sex-offender'] = $route['factsuite-candidate/candidate-sex-offender'] = 'main_Candidate_Controller/candidate_sex_offender'; 
$route['(:any)/candidate-politically-exposed'] = $route['factsuite-candidate/candidate-politically-exposed'] = 'main_Candidate_Controller/candidate_politically_exposed'; 
$route['(:any)/candidate-india-civil-litigation'] = $route['factsuite-candidate/candidate-india-civil-litigation'] = 'main_Candidate_Controller/candidate_india_civil_litigation'; 
$route['(:any)/candidate-mca'] = $route['factsuite-candidate/candidate-mca'] = 'main_Candidate_Controller/candidate_mca'; 
$route['(:any)/candidate-gsa'] = $route['factsuite-candidate/candidate-gsa'] = 'main_Candidate_Controller/candidate_gsa'; 
$route['(:any)/candidate-oig'] = $route['factsuite-candidate/candidate-oig'] = 'main_Candidate_Controller/candidate_oig'; 
$route['(:any)/candidate-right-to-work'] = $route['factsuite-candidate/candidate-right-to-work'] = 'main_Candidate_Controller/candidate_right_to_work'; 
$route['(:any)/candidate-nric'] = $route['factsuite-candidate/candidate-nric'] = 'main_Candidate_Controller/candidate_nric'; 


// Mobile Version Links
$route['m-index'] = 'main_Candidate_Controller/m_index';
$route['m-get-started'] = 'main_Candidate_Controller/m_get_started';
$route['m-sign-in'] = 'main_Candidate_Controller/m_sign_in';
$route['m-verify-otp'] = 'main_Candidate_Controller/m_verify_otp';
$route['m-component-list'] = 'main_Candidate_Controller/m_component_list';
$route['m-candidate-information-step-1'] = 'main_Mobile_Candidate_Controller/m_candidate_information_step_1';
$route['factsuite-candidate/check-candidate-email-id'] = 'candidate_Util/check_candidate_email_id';
$route['m-factsuite-candidate/update-candidate-1-details'] = 'main_Mobile_Candidate_Controller/update_candidate_1_details';
$route['m-criminal-check'] = 'main_Mobile_Candidate_Controller/m_criminal_check';
$route['m-document-check'] = 'main_Mobile_Candidate_Controller/m_document_check';
$route['m-drug-test'] = 'main_Mobile_Candidate_Controller/m_drug_test';
$route['m-global-database'] = 'main_Mobile_Candidate_Controller/m_gloal_database';
$route['m-driving-licence'] = 'main_Mobile_Candidate_Controller/m_driving_licence';
$route['m-current-employment-1'] = 'main_Mobile_Candidate_Controller/m_current_employment_1';
$route['m-factsuite-candidate/update-current-employment-1-details'] = 'main_Mobile_Candidate_Controller/update_current_employment_1_details';
$route['m-current-employment-2'] = 'main_Mobile_Candidate_Controller/m_current_employment_2';
$route['m-factsuite-candidate/update-current-employment-2-details'] = 'main_Mobile_Candidate_Controller/update_current_employment_2_details';
$route['m-previous-employment-1'] = 'main_Mobile_Candidate_Controller/m_previous_employment_1';
$route['m-factsuite-candidate/update-previous-employment-1-details'] = 'main_Mobile_Candidate_Controller/update_previous_employment_1_details';
$route['m-previous-employment-2'] = 'main_Mobile_Candidate_Controller/m_previous_employment_2';
$route['m-factsuite-candidate/update-previous-employment-2-details'] = 'main_Mobile_Candidate_Controller/update_previous_employment_2_details';
$route['m-bankruptcy'] = 'main_Mobile_Candidate_Controller/m_bankruptcy';
$route['m-factsuite-candidate/update-bankruptcy-details'] = 'main_Mobile_Candidate_Controller/update_bankruptcy_details';
$route['m-present-address-1'] = 'main_Mobile_Candidate_Controller/m_present_address_1';
$route['m-factsuite-candidate/update-present-address-1-details'] = 'main_Mobile_Candidate_Controller/update_present_address_1_details';
$route['m-present-address-2'] = 'main_Mobile_Candidate_Controller/m_present_address_2';
$route['m-factsuite-candidate/update-present-address-2-details'] = 'main_Mobile_Candidate_Controller/update_present_address_2_details';
$route['m-reference'] = 'main_Mobile_Candidate_Controller/m_reference';
$route['m-factsuite-candidate/update-reference-details'] = 'main_Mobile_Candidate_Controller/update_reference_details';
$route['m-previous-address-1'] = 'main_Mobile_Candidate_Controller/m_previous_address_1';
$route['m-factsuite-candidate/update-previous-address-1-details'] = 'main_Mobile_Candidate_Controller/update_previous_address_1_details';
$route['m-previous-address-2'] = 'main_Mobile_Candidate_Controller/m_previous_address_2';
$route['m-factsuite-candidate/update-previous-address-2-details'] = 'main_Mobile_Candidate_Controller/update_previous_address_2_details';
$route['m-court-record-1'] = 'main_Mobile_Candidate_Controller/m_court_record_1';
$route['m-factsuite-candidate/update-court-record-1-details'] = 'main_Mobile_Candidate_Controller/update_court_record_1_details';
$route['m-court-record-2'] = 'main_Mobile_Candidate_Controller/m_court_record_2';
$route['m-factsuite-candidate/update-court-record-2-details'] = 'main_Mobile_Candidate_Controller/update_court_record_2_details';
$route['m-social-media'] = 'main_Mobile_Candidate_Controller/m_social_media';
$route['m-factsuite-candidate/update-social-media-details'] = 'main_Mobile_Candidate_Controller/update_social_media_details';
$route['m-credit-cibil'] = 'main_Mobile_Candidate_Controller/m_credit_cibil';
$route['m-factsuite-candidate/update-credit-cibil-details'] = 'main_Mobile_Candidate_Controller/update_credit_cibil_details';
$route['m-cv-check'] = 'main_Mobile_Candidate_Controller/m_cv_check';
$route['m-factsuite-candidate/update-cv-check'] = 'main_Mobile_Candidate_Controller/update_cv_check';
$route['m-landlord-reference'] = 'main_Mobile_Candidate_Controller/m_landlord_reference';
$route['m-factsuite-candidate/update-landlord-reference-details'] = 'main_Mobile_Candidate_Controller/update_landlord_reference_details';
$route['m-education-1'] = 'main_Mobile_Candidate_Controller/m_education_1';
$route['m-factsuite-candidate/update-education-1-details'] = 'main_Mobile_Candidate_Controller/update_education_1_details';
$route['m-education-2'] = 'main_Mobile_Candidate_Controller/m_education_2';
$route['m-factsuite-candidate/update-education-2-details'] = 'main_Mobile_Candidate_Controller/update_education_2_details';
$route['m-consent-form'] = 'main_Mobile_Candidate_Controller/m_consent_form';
$route['m-permanent-address-1'] = 'main_Mobile_Candidate_Controller/m_permanent_address_1';
$route['m-factsuite-candidate/update-permanent-address-1-details'] = 'main_Mobile_Candidate_Controller/update_permanent_address_1_details';
$route['m-permanent-address-2'] = 'main_Mobile_Candidate_Controller/m_permanent_address_2';
$route['m-factsuite-candidate/update-permanent-address-2-details'] = 'main_Mobile_Candidate_Controller/update_permanent_address_2_details';
$route['m-candidate-civil-check'] = 'main_Mobile_Candidate_Controller/civil_check';

$route['m-employment-gap'] = 'main_Mobile_Candidate_Controller/employment_gap';

$route['m-additional'] = 'main_Mobile_Candidate_Controller/candidate_additional'; 

/* candidate pincode validation */
$route['is-pincode-valid/(:any)'] = 'Candidate/get_candidate_pincode_validation/$1';


/*new components */
$route['m-sex-offender'] = 'main_Mobile_Candidate_Controller/candidate_sex_offender'; 
$route['m-politically-exposed'] = 'main_Mobile_Candidate_Controller/candidate_politically_exposed'; 
$route['m-india-civil-litigation'] = 'main_Mobile_Candidate_Controller/candidate_india_civil_litigation'; 
$route['m-mca'] = 'main_Mobile_Candidate_Controller/candidate_mca'; 
$route['m-gsa'] = 'main_Mobile_Candidate_Controller/candidate_gsa'; 
$route['m-oig'] = 'main_Mobile_Candidate_Controller/candidate_oig'; 
$route['m-right-to-work'] = 'main_Mobile_Candidate_Controller/candidate_right_to_work'; 
$route['m-nric'] = 'main_Mobile_Candidate_Controller/candidate_nric'; 


