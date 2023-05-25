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
 
$client_name = '';
if (isset($_SESSION['logged-in-client'])) {
	echo  $client_name = $_SESSION['logged-in-client']['client_name'];
}
$route['default_controller'] = 'Main_Client_Controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['sidebar/sidebar-toggle'] = 'Main_Client_Controller/sidebar_toggle';

$route['factsuite-client/timezone'] = 'Main_Client_Controller/client_timezone';

$route['factsuite-client/get-country-code-list'] = 'Custom_Util/get_country_code_list';

/*route*/
$route['factsuite-client/login'] = 'Main_Client_Controller';
$route['factsuite-client/finance-summary'] = 'Main_Client_Controller/finance_summary';
$route['factsuite-client/get-finance-bills'] = 'Main_Client_Controller/finance_summary_cases';

$route['(:any)/home-page'] = $route['factsuite-client/home-page'] = 'Main_Client_Controller/home';
$route['(:any)/add-case'] = $route['factsuite-client/add-case'] = 'Main_Client_Controller/add_case';
$route['factsuite-client/edit-case/(:any)'] = 'Main_Client_Controller/edit_case/$1';
$route['(:any)/edit-case'] = $route['factsuite-client/edit-case'] = 'Main_Client_Controller/edit_case';
$route['(:any)/all-cases'] = $route['factsuite-client/all-cases'] = 'Main_Client_Controller/all_cases';
$route['(:any)/insuff-cases'] = $route['factsuite-client/insuff-cases'] = 'Main_Client_Controller/insuff_cases';
$route['(:any)/client-clarification-cases'] = $route['factsuite-client/client-clarification-cases'] = 'Main_Client_Controller/client_clarification_cases';
 $route['(:any)/completed-case'] = $route['factsuite-client/completed-case'] = 'Main_Client_Controller/completed_cases';
$route['factsuite-client/view-single-case/(:any)'] = 'Main_Client_Controller/single_case/$1';
$route['(:any)/view-single-case'] = $route['factsuite-client/view-single-case/'] = 'Main_Client_Controller/single_case/';
$route['viral/view-single-case/(:any)'] = $route['factsuite-client/view-single-case/(:any)'];
$route['factsuite-client/htmlGenrateReport/(:any)'] = 'Main_Client_Controller/htmlGenrateReport/$1';
$route['factsuite-client/get-single-case-details'] = 'Main_Client_Controller/get_single_case_details';

$route['factsuite-client/generate-pdf-report/(:any)'] = 'Main_Client_Controller/htmlGenratePDFReport/$1';
$route['factsuite-client/get-all-cases'] = 'Cases/get_all_cases_with_pagination';
$route['factsuite-client/get-all-cases/(:any)'] = 'Cases/get_all_cases_with_pagination/$1';



$route['factsuite-client/selected-report-cases/(:any)'] = 'Main_Client_Controller/selected_cases/$1';
$route['(:any)/selected-report-cases'] = $route['factsuite-client/selected-report-cases/'] = 'Main_Client_Controller/selected_cases/';
$route['factsuite-client/selected-status-cases/(:any)'] = 'Main_Client_Controller/status_wise_cases/$1';
$route['(:any)/selected-status-cases'] = $route['factsuite-client/selected-status-cases'] = 'Main_Client_Controller/status_wise_cases';

// API for Factsuite Website
$route['factsuite-client/api/create-new-candidate-case'] = 'Client_Api/insert_case_api';
$route['factsuite-client/api/update-candidate-case-details'] = 'Client_Api/update_case_api';
$route['factsuite-client/api/remove-candidate-case'] = 'Client_Api/remove_case_api';
$route['factsuite-client/api/get-current-client-details'] = 'Client_Api/get_client_details';
$route['factsuite-client/api/get-current-client-package'] = 'Client_Api/get_client_packages';
$route['factsuite-client/api/add-current-client-package'] = 'Client_Api/add_client_packages';
$route['factsuite-client/api/remove-current-client-package'] = 'Client_Api/remove_client_package';

$route['factsuite-client/api/get-component-list'] = 'Client_Api/get_client_components';
$route['factsuite-client/api/get-client-valid-access-token-key'] = 'Client_Api/get_access_token';
$route['factsuite-client/api/login-valid-client'] = 'Client_Api/valid_client_login';
$route['factsuite-client/api/candidate-change-priority'] = 'Client_Api/update_candidate_case_priority';

//finance
$route['factsuite-client/api/init-client-billing-payment'] = 'Client_Api/init_client_billing_payment';
$route['factsuite-client/api/get-client-billing-payment-list'] = 'Client_Api/get_client_billing_payment';
$route['factsuite-client/api/get-client-billing-payment-all-transactions'] = 'Client_Api/get_client_billing_payment_transactions';


/*forgot password*/
$route['factsuite-client/forgot-password'] = 'Main_Client_Controller/forgot_password';
$route['factsuite-client-forgot-password'] = 'Main_Client_Controller/verify_forgot_password_email_id';
$route['reset-password/(:any)/(:any)'] = 'Main_Client_Controller/reset_password/$1/$2';
$route['factsuite-client/reset-password'] = 'Main_Client_Controller/verify_and_reset_password';


$route['(:any)/bulk-upload'] = $route['factsuite-client/bulk-upload'] = 'Main_Client_Controller/bulk_upload';
$route['(:any)/view-bulk-upload'] = $route['factsuite-client/view-bulk-upload'] = 'Main_Client_Controller/bulk_upload_view';
$route['factsuite-client/get-all-bulk-uploads'] = 'Main_Client_Controller/get_all_bulk_uploads';
$route['(:any)/view-all-cases'] = $route['factsuite-client/view-all-cases'] = 'Main_Client_Controller/view_all_cases';



// client Ticketing System
$route['(:any)/raise-ticket'] =  $route['factsuite-client/raise-ticket'] = 'Ticketing_System_FS_Team/raise_ticket_client';
$route['(:any)/tickets-assigned-to-me'] = $route['factsuite-client/tickets-assigned-to-me'] = 'Ticketing_System_FS_Team/tickets_assigned_to_me_client';
$route['factsuite-client/get-ticket-priority-list'] ='Custom_Util/get_ticket_priority_list';
$route['factsuite-client/get-ticket-classification-list'] ='Custom_Util/get_ticket_classification_list';
$route['factsuite-client/raise-new-ticket'] ='Ticketing_System_FS_Team/raise_new_ticket';
$route['factsuite-client/get-all-raised-tickets'] ='Ticketing_System_FS_Team/get_all_raised_tickets';
$route['factsuite-client/get-all-assigned-tickets'] ='Ticketing_System_FS_Team/get_all_assigned_tickets';
$route['factsuite-client/get-ticket-details'] ='Ticketing_System_FS_Team/get_ticket_details';
$route['factsuite-client/get-single-ticket-all-comments'] ='Ticketing_System_FS_Team/get_single_ticket_all_comments';
$route['factsuite-client/add-new-ticket-comment'] ='Ticketing_System_FS_Team/add_new_ticket_comment';
$route['factsuite-client/get-ticket-single-comment'] ='Ticketing_System_FS_Team/get_ticket_single_comment';
$route['factsuite-client/update-ticket-status'] ='Ticketing_System_FS_Team/update_ticket_status';
$route['factsuite-client/get-roles-list'] ='Ticketing_System_FS_Team/get_roles_list';
$route['factsuite-client/get-roles-person-list'] ='Ticketing_System_FS_Team/get_roles_person_list';
$route['factsuite-client/get-ticket-notifications'] ='Ticketing_System_FS_Team/get_ticket_notifications';
$route['factsuite-client/ticket-raised-by-me-pagination'] ='ticketing_System_FS_Team/ticket_raised_by_me_pagination';
$route['factsuite-client/ticket-raised-by-me-pagination/(:any)'] ='ticketing_System_FS_Team/ticket_raised_by_me_pagination/$1';
$route['factsuite-client/ticket-assign-to-me-pagination'] ='ticketing_System_FS_Team/ticket_assign_to_me_pagination';
$route['factsuite-client/ticket-assign-to-me-pagination/(:any)'] ='ticketing_System_FS_Team/ticket_assign_to_me_pagination/$1';


/*MIS report*/
$route['(:any)/candidate-mis-report'] =  $route['factsuite-client/candidate-mis-report'] ='Main_Client_Controller/candidate_mis_report';
$route['(:any)/candidate-mis-insuff-report'] =  $route['factsuite-client/candidate-mis-insuff-report'] ='Main_Client_Controller/candidate_insuff_report';
$route['(:any)/candidate-clear-insuff-report'] =  $route['factsuite-client/candidate-clear-insuff-report'] ='Main_Client_Controller/candidate_clear_insuff_report';

// Client Clarifications
$route['factsuite-client/get-all-client-clarifications'] = 'Common_User_Filled_Details_Component_Client_Clarifications/get_all_client_clarifications';
$route['factsuite-client/get-single-client-clarification-details'] = 'Common_User_Filled_Details_Component_Client_Clarifications/get_single_client_clarification_details';
$route['factsuite-client/get-single-client-clarifications-all-comments'] = 'Common_User_Filled_Details_Component_Client_Clarifications/get_single_client_clarifications_all_comments';
$route['factsuite-client/add-new-client-clarification-comment'] = 'Common_User_Filled_Details_Component_Client_Clarifications/add_new_client_clarification_comment';
$route['factsuite-client/get-client-clarification-single-comment'] = 'Common_User_Filled_Details_Component_Client_Clarifications/get_client_clarification_single_comment';

// Documentation
$route['factsuite-client/documentation'] = 'Main_Client_Controller/documentation';


$route['factsuite-client-analytics/get-status-wise-case-summary-details'] = 'client_Analytics/get_status_wise_case_summary_details';