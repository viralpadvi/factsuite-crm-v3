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
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


// Common utilities
$route['factsuite-inputqc/get-country-code-list'] ='Custom_Util/get_country_code_list';
$route['factsuite-admin/get-all-segments'] ='Custom_Util/get_all_segments';
$route['factsuite-inputqc/get-client-cost-center-list'] ='InputQc/get_single_client_cost_centers';

// CornJob Links
$route['factsuite-admin/trigger-client-auomated-reminders'] ='CronJobs/client_auomated_reminders';


/*admin module*/
$route['factsuite-admin/admin-logout'] ='Logout/admin_logout';
$route['factsuite-admin/home-page'] ='Admin_Main_Controller';
$route['factsuite-admin/login-logs'] ='Admin_Main_Controller/login_logs';
$route['factsuite-admin/dashboard'] ='Admin_Main_Controller/dashboard';
$route['factsuite-admin/receival-analytics'] ='Admin_Main_Controller/receivals_analytics';
$route['factsuite-admin/total-closure-cases-analytics'] ='Admin_Main_Controller/total_closure_cases_analytics';
$route['factsuite-admin/add-view-cities'] ='Admin_Main_Controller/add_city';
$route['factsuite-admin/process-guidline'] ='Process_Guidline/process_guidline';

$route['factsuite-admin/schedule-reporting-time'] ='Admin_Main_Controller/schedule_report_date_time';
$route['factsuite-admin/change-client-access'] ='Client/client_access_status';
$route['factsuite-admin/email-templates'] ='Admin_Main_Controller/email_templates';
$route['factsuite-admin/url-branding'] ='Admin_Main_Controller/url_branding';
$route['factsuite-admin/get-insuff-email-template-for-client'] ='Client/get_selected_insuff_email_template_for_client';
$route['factsuite-admin/get-client-spoc-list'] ='Client/get_client_spoc_list';
$route['factsuite-admin/send-credentials-to-client-spoc'] ='Client/send_credentials_to_client_spoc';

$route['factsuite-admin/email-sms-reminders'] ='Admin_Main_Controller/sms_email_reminder';
$route['factsuite-admin/view-email-sms-reminders'] ='Admin_Main_Controller/view_sms_email_reminder';
$route['factsuite-admin/edit-email-sms-reminders'] ='Admin_Main_Controller/edit_sms_email_reminder';


// CSM
$route['factsuite-csm/component'] ='CSM/component';
$route['factsuite-csm/add-view-cities'] ='CSM/add_city';
$route['factsuite-csm/client-mandate'] ='Mandate';
$route['factsuite-csm/dashboard'] ='CSM/dashboard';





// Factsuite Admin Team
$route['factsuite-admin/add-team'] ='Admin_Main_Controller/add_team';
$route['factsuite-admin/view-team'] ='Admin_Main_Controller/view_team';
$route['factsuite-admin/edit-team/(:any)'] ='Admin_Main_Controller/edit_team/$1';

// Factsuite Admin Vendor
$route['factsuite-admin/add-new-vendor'] ='Admin_Main_Controller/add_new_vendor';
$route['factsuite-admin/view-all-active-vendor'] ='Admin_Main_Controller/view_all_active_vendor';
$route['factsuite-admin/view-all-inactive-vendor'] ='Admin_Main_Controller/view_all_inactive_vendor';
$route['factsuite-admin/view-all-vendor'] ='Admin_Main_Controller/view_all_vendor';

// Factsuite client
$route['factsuite-admin/add-new-client'] = 'Admin_Main_Controller/add_client';
$route['factsuite-admin/add-new-client-select-packages'] = 'Admin_Main_Controller/add_client_select_package';
$route['factsuite-admin/add-client-component-packages'] = 'Admin_Main_Controller/add_client_package_component';
$route['factsuite-admin/add-client-alacarte-component'] = 'Admin_Main_Controller/add_client_alacarte_component';
$route['factsuite-admin/add-client-tat-component'] = 'Client/add_client_tat_view';
$route['factsuite-admin/send-credentials-to-client-spoc-page'] = 'Client/send_credentials_to_client_spoc_page';
$route['factsuite-admin/view-all-client'] = 'Admin_Main_Controller/view_client';
$route['factsuite-admin/edit-client/(:any)'] = 'Admin_Main_Controller/edit_client/$1';
$route['factsuite-admin/edit-select-package-component-client/(:any)'] = 'Admin_Main_Controller/edit_select_package_client/$1';
$route['factsuite-admin/edit-client-component-packages/(:any)'] = 'Admin_Main_Controller/edit_client_component_packages/$1';
$route['factsuite-admin/edit-client-alacarte-component/(:any)'] = 'Admin_Main_Controller/edit_client_alacarte_component/$1';
$route['factsuite-admin/consent-form-report-logo'] = 'Client/consent_form_report_logo';
$route['factsuite-admin/change-candidate-notification-status'] = 'Client/change_candidate_notification_status';
$route['factsuite-admin/get-all-form-fields'] = 'Custom_Util/get_all_form_fields';
$route['factsuite-admin/get-all-email-templates'] = 'Custom_Util/get_all_email_templates';


$route['factsuite-admin/get-all-client-type'] = 'Custom_Util/get_all_client_type';
$route['factsuite-admin/get-all-clients'] = 'Custom_Util/get_all_clients';
$route['factsuite-admin/get-all-clients-for-email-templates'] = 'Custom_Util/get_all_clients_for_email_templates';
$route['factsuite-admin/get-all-rule-cirteria'] = 'Custom_Util/get_all_rule_cirteria';
$route['factsuite-admin/get-all-remaining-days-rules'] = 'Custom_Util/get_all_remaining_days_rules';
$route['factsuite-admin/get-all-case-priorities'] = 'Custom_Util/get_all_case_priorities';

// admin candidate case export
$route['factsuite-admin/candidate-case-export'] = 'Admin_Main_Controller/export_excel';
$route['factsuite-admin/outputqc-candidate-case-export'] = 'Admin_Main_Controller/output_export_excel';
$route['factsuite-admin/inputqc-candidate-case-export'] = 'Admin_Main_Controller/inputqc_export_excel';
$route['factsuite-admin/component-error-log-export'] = 'Admin_Main_Controller/error_log_export_excel';
$route['factsuite-admin/export-cases-allotted-to-vendor'] = 'Admin_Main_Controller/export_cases_allotted_to_vendor';
$route['factsuite-admin/export-cases-assigned-to-vendor'] = 'dump_Component/export_cases_assigned_to_vendor';


$route['factsuite-admin/get-new-cases-count'] = 'AdminViewAllCase/get_new_cases_count';
$route['factsuite-admin/get-role-list'] = 'Admin_Main_Controller/get_role_list';
$route['factsuite-admin/check-selected-team-member-role'] = 'Admin_Main_Controller/check_selected_team_member_role';
$route['factsuite-admin/bulk-assign-cases-to-team-member'] = 'Admin_Main_Controller/bulk_assign_cases_to_team_member';

$route['factsuite-admin/detete-case-permanently'] = 'Delete_Case/detete_case_permanently';

//
$route['factsuite-admin/form-request'] = 'Admin_Main_Controller/requested_form';

$route['factsuite-admin/get-ticket-priority-list'] ='Custom_Util/get_ticket_priority_list';
$route['factsuite-admin/get-ticket-classification-list'] ='Custom_Util/get_ticket_classification_list';

// Admin Component Error Log Starts
$route['factsuite-admin/raise-new-error'] ='Common_User_Filled_Details_Component_Error/raise_new_error';
$route['factsuite-admin/get-all-error-log'] ='Common_User_Filled_Details_Component_Error/get_all_error_log';
$route['factsuite-admin/get-single-error-details'] ='Common_User_Filled_Details_Component_Error/get_single_error_details';
$route['factsuite-admin/add-new-error-comment'] ='Common_User_Filled_Details_Component_Error/add_new_error_comment';
$route['factsuite-admin/get-error-single-comment'] ='Common_User_Filled_Details_Component_Error/get_error_single_comment';
$route['factsuite-admin/get-single-error-all-comments'] ='Common_User_Filled_Details_Component_Error/get_single_error_all_comments';
// Admin Component Error Log Ends


// Admin BGV case reports
$route['factsuite-admin/check-generated-report-log'] = 'Admin_Genarated_Bgv_Report/check_generated_report_log';
$route['factsuite-admin/download-bgv-reports/(:any)'] = 'Custom_Util/download_bgv_reports/$1';

$route['factsuite-admin/get-custom-filter-number-list'] = 'Custom_Util/get_custom_filter_number_list';

$route['factsuite-admin/static-loa-pdf'] = 'Custom_Util/static_loa_pdf';
$route['factsuite-admin/candidate-loa-pdf/(:any)'] = 'Custom_Util/final_loa_pdf/$1';


// Analyst Component Client Clarifications Log Starts
$route['factsuite-admin/raise-new-client-clarification'] ='Common_User_Filled_Details_Component_Client_Clarifications/raise_new_client_clarification';
$route['factsuite-admin/get-all-client-clarifications'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_all_client_clarifications';
$route['factsuite-admin/get-single-client-clarification-details'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_single_client_clarification_details';
$route['factsuite-admin/get-single-client-clarifications-all-comments'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_single_client_clarifications_all_comments';
$route['factsuite-admin/add-new-client-clarification-comment'] ='Common_User_Filled_Details_Component_Client_Clarifications/add_new_client_clarification_comment';
$route['factsuite-admin/get-client-clarification-single-comment'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_client_clarification_single_comment';
$route['factsuite-admin/get-single-client-clarifications-all-comments'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_single_client_clarifications_all_comments';
$route['factsuite-admin/update-client-clarification-status'] ='Common_User_Filled_Details_Component_Client_Clarifications/update_client_clarification_status';
// Analyst Component Client Clarifications Log Ends


// Admin Priority Rules Starts
$route['factsuite-admin/priority-rules'] ='Admin_Priority_Rules/priority_rules';
$route['factsuite-admin/add-new-rule'] = 'Admin_Priority_Rules/add_new_rule';
$route['factsuite-admin/get-all-rules'] = 'Admin_Priority_Rules/get_all_rules';
$route['factsuite-admin/change-rule-status'] = 'Admin_Priority_Rules/change_rule_status';
$route['factsuite-admin/get-single-rule-details'] = 'Admin_Priority_Rules/get_single_rule_details';
$route['factsuite-admin/update-rule'] = 'Admin_Priority_Rules/update_rule';
// Admin Priority Rules Ends

// Admin Set Email client notifications Starts
$route['factsuite-admin/client-email-notifications'] ='Client/client_email_notifications';
$route['factsuite-admin/get-all-case-type'] = 'Custom_Util/get_all_case_type';
$route['factsuite-admin/add-new-client-notification-rule'] = 'Client/add_new_client_notification_rule';
$route['factsuite-admin/get-all-client-notification-rules'] = 'Client/get_all_client_notification_rule';
$route['factsuite-admin/change-client-notification-status'] = 'Client/change_client_notification_status';
$route['factsuite-admin/get-single-client-notification-rule-details'] = 'Client/get_single_client_notification_rule_details';
$route['factsuite-admin/update-client-notification-rule'] = 'Client/update_client_notification_rule';

// Admin Set Email client notifications Ends
//common mandate

//process guidline 

$route['factsuite-analyst/view-process-guidline'] = 'analyst/view_process';
$route['factsuite-specialist/view-process-guidline'] = 'specialist/view_process';

$route['factsuite-inputqc/inputqc-mandate'] = 'mandate/client_mandate';
$route['factsuite-analyst/analyst-mandate'] = 'mandate/client_mandate';
$route['factsuite-specialist/specialist-mandate'] = 'mandate/client_mandate';
$route['factsuite-outputqc/outputqc-mandate'] = 'mandate/client_mandate';
$route['factsuite-outputqc/outputqc-mandate'] = 'mandate/client_mandate';
$route['factsuite-am/client-mandate'] = 'mandate/client_mandate';

//dynamic fields
$route['factsuite-inputqc/dynamic-fields'] = 'dynamicFields/dynamic_fields';
$route['factsuite-analyst/dynamic-fields'] = 'dynamicFields/dynamic_fields';
$route['factsuite-specialist/dynamic-fields'] = 'dynamicFields/dynamic_fields';
$route['factsuite-outputqc/dynamic-fields'] = 'dynamicFields/dynamic_fields';


$route['factsuite-admin/education-dynamic-fields'] = 'dynamicFields/index';
$route['factsuite-admin/employee-dynamic-fields'] = 'dynamicFields/employee_fields';
 
$route['factsuite-inputqc/employee-fields'] = 'dynamicFields/employee_dynamic_fields';
$route['factsuite-analyst/employee-fields'] = 'dynamicFields/employee_dynamic_fields';
$route['factsuite-specialist/employee-fields'] = 'dynamicFields/employee_dynamic_fields';
$route['factsuite-outputqc/employee-fields'] = 'dynamicFields/employee_dynamic_fields';





// inputQC Module 


$route['factsuite-inputqc/inputqc-logout'] = 'logout/inoutqc_logout';
$route['factsuite-inputqc/add-new-case'] = 'inputQc';
$route['factsuite-inputqc/edit-case/(:any)'] = 'inputQc/edit_case/$1';
$route['factsuite-inputqc/re-edit-case/(:any)'] = 'inputQc/re_edit_case/$1';
$route['factsuite-inputqc/resume-case/(:any)'] = 'inputQc/resume_pending_case/$1';

$route['factsuite-inputqc/view-all-case-list'] = 'inputQc/viewAllCaseList';
$route['factsuite-inputqc/view-case-detail/(:any)'] = 'inputQc/single_case/$1';
$route['factsuite-inputqc/assigned-case-list'] = 'inputQc/assignedCaseList';
$route['factsuite-inputqc/assigned-view-case-detail/(:any)'] = 'inputQc/assignedSingleCase/$1';
$route['factsuite-inputqc/pending-case-list'] = 'inputQc/pendingCaseList';
$route['factsuite-inputqc/completed-case-list'] = 'inputQc/completedCaseList';
$route['factsuite-inputqc/candidate-case-export'] = 'inputQc/export_inputqc_excel';
$route['factsuite-inputqc/bulk-cases'] = 'inputQc/viewbulkcases';
$route['factsuite-am/bulk-cases'] = 'am/viewbulkcases';

// FS Admin Ticketing System Starts
$route['factsuite-admin/raise-ticket'] ='Ticketing_System_FS_Team/raise_ticket_admin';
$route['factsuite-admin/all-tickets'] ='Ticketing_System_FS_Team/all_tickets_admin';
$route['factsuite-admin/get-all-tickets'] ='Ticketing_System_FS_Team/get_all_tickets';
$route['factsuite-admin/get-roles-list'] ='Ticketing_System_FS_Team/get_roles_list';
$route['factsuite-admin/get-roles-person-list'] ='Ticketing_System_FS_Team/get_roles_person_list';
$route['factsuite-admin/tickets-assigned-to-me'] ='Ticketing_System_FS_Team/tickets_assigned_to_me_admin';
$route['factsuite-admin/raise-new-ticket'] ='Ticketing_System_FS_Team/raise_new_ticket';
$route['factsuite-admin/get-all-raised-tickets'] ='Ticketing_System_FS_Team/get_all_raised_tickets';
$route['factsuite-admin/get-all-assigned-tickets'] ='Ticketing_System_FS_Team/get_all_assigned_tickets';
$route['factsuite-admin/get-ticket-details'] ='Ticketing_System_FS_Team/get_ticket_details';
$route['factsuite-admin/update-ticket-status'] ='Ticketing_System_FS_Team/update_ticket_status';
$route['factsuite-admin/add-new-ticket-comment'] ='Ticketing_System_FS_Team/add_new_ticket_comment';
$route['factsuite-admin/get-ticket-single-comment'] ='Ticketing_System_FS_Team/get_ticket_single_comment';
$route['factsuite-admin/get-single-ticket-all-comments'] ='Ticketing_System_FS_Team/get_single_ticket_all_comments';
$route['factsuite-admin/get-ticket-notifications'] ='Ticketing_System_FS_Team/get_ticket_notifications';

// Analyst Ticketing System
$route['factsuite-analyst/raise-ticket'] = 'Ticketing_System_FS_Team/raise_ticket_analyst';
$route['factsuite-analyst/get-ticket-priority-list'] ='Custom_Util/get_ticket_priority_list';
$route['factsuite-analyst/get-ticket-classification-list'] ='Custom_Util/get_ticket_classification_list';
$route['factsuite-analyst/tickets-assigned-to-me'] ='Ticketing_System_FS_Team/tickets_assigned_to_me_analyst';
$route['factsuite-analyst/raise-new-ticket'] ='Ticketing_System_FS_Team/raise_new_ticket';
$route['factsuite-analyst/get-all-raised-tickets'] ='Ticketing_System_FS_Team/get_all_raised_tickets';
$route['factsuite-analyst/get-all-assigned-tickets'] ='Ticketing_System_FS_Team/get_all_assigned_tickets';
$route['factsuite-analyst/get-ticket-details'] ='Ticketing_System_FS_Team/get_ticket_details';
$route['factsuite-analyst/get-single-ticket-all-comments'] ='Ticketing_System_FS_Team/get_single_ticket_all_comments';
$route['factsuite-analyst/add-new-ticket-comment'] ='Ticketing_System_FS_Team/add_new_ticket_comment';
$route['factsuite-analyst/get-ticket-single-comment'] ='Ticketing_System_FS_Team/get_ticket_single_comment';
$route['factsuite-analyst/update-ticket-status'] ='Ticketing_System_FS_Team/update_ticket_status';
$route['factsuite-analyst/get-roles-list'] ='Ticketing_System_FS_Team/get_roles_list';
$route['factsuite-analyst/get-roles-person-list'] ='Ticketing_System_FS_Team/get_roles_person_list';
$route['factsuite-analyst/get-ticket-notifications'] ='Ticketing_System_FS_Team/get_ticket_notifications';

// InputQC Ticketing System
$route['factsuite-inputqc/raise-ticket'] = 'Ticketing_System_FS_Team/raise_ticket_input_qc';
$route['factsuite-inputqc/tickets-assigned-to-me'] = 'Ticketing_System_FS_Team/tickets_assigned_to_me_inputqc';
$route['factsuite-inputqc/get-ticket-priority-list'] ='Custom_Util/get_ticket_priority_list';
$route['factsuite-inputqc/get-ticket-classification-list'] ='Custom_Util/get_ticket_classification_list';
$route['factsuite-inputqc/raise-new-ticket'] ='Ticketing_System_FS_Team/raise_new_ticket';
$route['factsuite-inputqc/get-all-raised-tickets'] ='Ticketing_System_FS_Team/get_all_raised_tickets';
$route['factsuite-inputqc/get-all-assigned-tickets'] ='Ticketing_System_FS_Team/get_all_assigned_tickets';
$route['factsuite-inputqc/get-ticket-details'] ='Ticketing_System_FS_Team/get_ticket_details';
$route['factsuite-inputqc/get-single-ticket-all-comments'] ='Ticketing_System_FS_Team/get_single_ticket_all_comments';
$route['factsuite-inputqc/add-new-ticket-comment'] ='Ticketing_System_FS_Team/add_new_ticket_comment';
$route['factsuite-inputqc/get-ticket-single-comment'] ='Ticketing_System_FS_Team/get_ticket_single_comment';
$route['factsuite-inputqc/update-ticket-status'] ='Ticketing_System_FS_Team/update_ticket_status';
$route['factsuite-inputqc/get-roles-list'] ='Ticketing_System_FS_Team/get_roles_list';
$route['factsuite-inputqc/get-roles-person-list'] ='Ticketing_System_FS_Team/get_roles_person_list';
$route['factsuite-inputqc/get-ticket-notifications'] ='Ticketing_System_FS_Team/get_ticket_notifications';


/*anaalyst and specialyst assignments*/
$route['factsuite-analyst/assigned-vendor-case-list'] = 'analyst/assignedCasevendorList';
$route['factsuite-specialist/assigned-vendor-case-list'] = 'specialist/assignedCasevendorList';
// Specialist Ticketing System
$route['factsuite-specialist/raise-ticket'] = 'Ticketing_System_FS_Team/raise_ticket_specialist';
$route['factsuite-specialist/tickets-assigned-to-me'] = 'Ticketing_System_FS_Team/tickets_assigned_to_me_specialist';
$route['factsuite-specialist/get-ticket-priority-list'] ='Custom_Util/get_ticket_priority_list';
$route['factsuite-specialist/get-ticket-classification-list'] ='Custom_Util/get_ticket_classification_list';
$route['factsuite-specialist/raise-new-ticket'] ='Ticketing_System_FS_Team/raise_new_ticket';
$route['factsuite-specialist/get-all-raised-tickets'] ='Ticketing_System_FS_Team/get_all_raised_tickets';
$route['factsuite-specialist/get-all-assigned-tickets'] ='Ticketing_System_FS_Team/get_all_assigned_tickets';
$route['factsuite-specialist/get-ticket-details'] ='Ticketing_System_FS_Team/get_ticket_details';
$route['factsuite-specialist/get-single-ticket-all-comments'] ='Ticketing_System_FS_Team/get_single_ticket_all_comments';
$route['factsuite-specialist/add-new-ticket-comment'] ='Ticketing_System_FS_Team/add_new_ticket_comment';
$route['factsuite-specialist/get-ticket-single-comment'] ='Ticketing_System_FS_Team/get_ticket_single_comment';
$route['factsuite-specialist/update-ticket-status'] ='Ticketing_System_FS_Team/update_ticket_status';
$route['factsuite-specialist/get-roles-list'] ='Ticketing_System_FS_Team/get_roles_list';
$route['factsuite-specialist/get-roles-person-list'] ='Ticketing_System_FS_Team/get_roles_person_list';
$route['factsuite-specialist/get-ticket-notifications'] ='Ticketing_System_FS_Team/get_ticket_notifications';

// OutputQC Ticketing System
$route['factsuite-outputqc/raise-ticket'] = 'Ticketing_System_FS_Team/raise_ticket_outputqc';
$route['factsuite-outputqc/tickets-assigned-to-me'] = 'Ticketing_System_FS_Team/tickets_assigned_to_me_outputqc';
$route['factsuite-outputqc/get-ticket-priority-list'] ='Custom_Util/get_ticket_priority_list';
$route['factsuite-outputqc/get-ticket-classification-list'] ='Custom_Util/get_ticket_classification_list';
$route['factsuite-outputqc/raise-new-ticket'] ='Ticketing_System_FS_Team/raise_new_ticket';
$route['factsuite-outputqc/get-all-raised-tickets'] ='Ticketing_System_FS_Team/get_all_raised_tickets';
$route['factsuite-outputqc/get-all-assigned-tickets'] ='Ticketing_System_FS_Team/get_all_assigned_tickets';
$route['factsuite-outputqc/get-ticket-details'] ='Ticketing_System_FS_Team/get_ticket_details';
$route['factsuite-outputqc/get-single-ticket-all-comments'] ='Ticketing_System_FS_Team/get_single_ticket_all_comments';
$route['factsuite-outputqc/add-new-ticket-comment'] ='Ticketing_System_FS_Team/add_new_ticket_comment';
$route['factsuite-outputqc/get-ticket-single-comment'] ='Ticketing_System_FS_Team/get_ticket_single_comment';
$route['factsuite-outputqc/update-ticket-status'] ='Ticketing_System_FS_Team/update_ticket_status';
$route['factsuite-outputqc/get-roles-list'] ='Ticketing_System_FS_Team/get_roles_list';
$route['factsuite-outputqc/get-roles-person-list'] ='Ticketing_System_FS_Team/get_roles_person_list';
$route['factsuite-outputqc/get-ticket-notifications'] ='Ticketing_System_FS_Team/get_ticket_notifications';

// Finance Ticketing System
$route['factsuite-finance/raise-ticket'] = 'Ticketing_System_FS_Team/raise_ticket_finance';
$route['factsuite-finance/tickets-assigned-to-me'] = 'Ticketing_System_FS_Team/tickets_assigned_to_me_finance';
$route['factsuite-finance/get-ticket-priority-list'] ='Custom_Util/get_ticket_priority_list';
$route['factsuite-finance/get-ticket-classification-list'] ='Custom_Util/get_ticket_classification_list';
$route['factsuite-finance/raise-new-ticket'] ='Ticketing_System_FS_Team/raise_new_ticket';
$route['factsuite-finance/get-all-raised-tickets'] ='Ticketing_System_FS_Team/get_all_raised_tickets';
$route['factsuite-finance/get-all-assigned-tickets'] ='Ticketing_System_FS_Team/get_all_assigned_tickets';
$route['factsuite-finance/get-ticket-details'] ='Ticketing_System_FS_Team/get_ticket_details';
$route['factsuite-finance/get-single-ticket-all-comments'] ='Ticketing_System_FS_Team/get_single_ticket_all_comments';
$route['factsuite-finance/add-new-ticket-comment'] ='Ticketing_System_FS_Team/add_new_ticket_comment';
$route['factsuite-finance/get-ticket-single-comment'] ='Ticketing_System_FS_Team/get_ticket_single_comment';
$route['factsuite-finance/update-ticket-status'] ='Ticketing_System_FS_Team/update_ticket_status';
$route['factsuite-finance/get-roles-list'] ='Ticketing_System_FS_Team/get_roles_list';
$route['factsuite-finance/get-roles-person-list'] ='Ticketing_System_FS_Team/get_roles_person_list';
$route['factsuite-finance/get-ticket-notifications'] ='Ticketing_System_FS_Team/get_ticket_notifications';

// CSM Ticketing System
$route['factsuite-csm/raise-ticket'] = 'Ticketing_System_FS_Team/raise_ticket_csm';
$route['factsuite-csm/tickets-assigned-to-me'] = 'Ticketing_System_FS_Team/tickets_assigned_to_me_csm';
$route['factsuite-csm/get-ticket-priority-list'] ='Custom_Util/get_ticket_priority_list';
$route['factsuite-csm/get-ticket-classification-list'] ='Custom_Util/get_ticket_classification_list';
$route['factsuite-csm/raise-new-ticket'] ='Ticketing_System_FS_Team/raise_new_ticket';
$route['factsuite-csm/get-all-raised-tickets'] ='Ticketing_System_FS_Team/get_all_raised_tickets';
$route['factsuite-csm/get-all-assigned-tickets'] ='Ticketing_System_FS_Team/get_all_assigned_tickets';
$route['factsuite-csm/get-ticket-details'] ='Ticketing_System_FS_Team/get_ticket_details';
$route['factsuite-csm/get-single-ticket-all-comments'] ='Ticketing_System_FS_Team/get_single_ticket_all_comments';
$route['factsuite-csm/add-new-ticket-comment'] ='Ticketing_System_FS_Team/add_new_ticket_comment';
$route['factsuite-csm/get-ticket-single-comment'] ='Ticketing_System_FS_Team/get_ticket_single_comment';
$route['factsuite-csm/update-ticket-status'] ='Ticketing_System_FS_Team/update_ticket_status';
$route['factsuite-csm/get-roles-list'] ='Ticketing_System_FS_Team/get_roles_list';
$route['factsuite-csm/get-roles-person-list'] ='Ticketing_System_FS_Team/get_roles_person_list';
$route['factsuite-csm/get-ticket-notifications'] ='Ticketing_System_FS_Team/get_ticket_notifications';

// AM Ticketing System
$route['factsuite-am/raise-ticket'] = 'Ticketing_System_FS_Team/raise_ticket_am';
$route['factsuite-am/tickets-assigned-to-me'] = 'Ticketing_System_FS_Team/tickets_assigned_to_me_am';
$route['factsuite-am/get-ticket-priority-list'] ='Custom_Util/get_ticket_priority_list';
$route['factsuite-am/get-ticket-classification-list'] ='Custom_Util/get_ticket_classification_list';
$route['factsuite-am/raise-new-ticket'] ='Ticketing_System_FS_Team/raise_new_ticket';
$route['factsuite-am/get-all-raised-tickets'] ='Ticketing_System_FS_Team/get_all_raised_tickets';
$route['factsuite-am/get-all-assigned-tickets'] ='Ticketing_System_FS_Team/get_all_assigned_tickets';
$route['factsuite-am/get-ticket-details'] ='Ticketing_System_FS_Team/get_ticket_details';
$route['factsuite-am/get-single-ticket-all-comments'] ='Ticketing_System_FS_Team/get_single_ticket_all_comments';
$route['factsuite-am/add-new-ticket-comment'] ='Ticketing_System_FS_Team/add_new_ticket_comment';
$route['factsuite-am/get-ticket-single-comment'] ='Ticketing_System_FS_Team/get_ticket_single_comment';
$route['factsuite-am/update-ticket-status'] ='Ticketing_System_FS_Team/update_ticket_status';
$route['factsuite-am/get-roles-list'] ='Ticketing_System_FS_Team/get_roles_list';
$route['factsuite-am/get-roles-person-list'] ='Ticketing_System_FS_Team/get_roles_person_list';
$route['factsuite-am/get-ticket-notifications'] ='Ticketing_System_FS_Team/get_ticket_notifications';

// Tech Support
$route['factsuite-tech-support/tech-support-logout'] = 'Logout/tech_support_logout';
// Tech Support Team Raise Tickets
$route['factsuite-tech-support/raise-ticket'] = 'Ticketing_System_FS_Team/raise_ticket_tech_support';
$route['factsuite-tech-support/tickets-assigned-to-me'] = 'Ticketing_System_FS_Team/tickets_assigned_to_me_tech_support';
$route['factsuite-tech-support/get-ticket-priority-list'] ='Custom_Util/get_ticket_priority_list';
$route['factsuite-tech-support/get-ticket-classification-list'] ='Custom_Util/get_ticket_classification_list';
$route['factsuite-tech-support/raise-new-ticket'] ='Ticketing_System_FS_Team/raise_new_ticket';
$route['factsuite-tech-support/get-all-raised-tickets'] ='Ticketing_System_FS_Team/get_all_raised_tickets';
$route['factsuite-tech-support/get-all-assigned-tickets'] ='Ticketing_System_FS_Team/get_all_assigned_tickets';
$route['factsuite-tech-support/get-ticket-details'] ='Ticketing_System_FS_Team/get_ticket_details';
$route['factsuite-tech-support/get-single-ticket-all-comments'] ='Ticketing_System_FS_Team/get_single_ticket_all_comments';
$route['factsuite-tech-support/add-new-ticket-comment'] ='Ticketing_System_FS_Team/add_new_ticket_comment';
$route['factsuite-tech-support/get-ticket-single-comment'] ='Ticketing_System_FS_Team/get_ticket_single_comment';
$route['factsuite-tech-support/update-ticket-status'] ='Ticketing_System_FS_Team/update_ticket_status';
$route['factsuite-tech-support/get-roles-list'] ='Ticketing_System_FS_Team/get_roles_list';
$route['factsuite-tech-support/get-roles-person-list'] ='Ticketing_System_FS_Team/get_roles_person_list';
$route['factsuite-tech-support/get-ticket-notifications'] ='Ticketing_System_FS_Team/get_ticket_notifications';


// Escalatory Notifications
$route['factsuite-csm/get-escalatory-cases-notifications'] ='Escalatory_Notifications_FS_Team/get_escalatory_cases_notifications';
$route['factsuite-am/get-escalatory-cases-notifications'] ='Escalatory_Notifications_FS_Team/get_escalatory_cases_notifications';

//admin view all cases 
$route['factsuite-admin/view-all-case-list'] = 'adminViewAllCase';
$route['factsuite-admin/view-case-detail/(:any)'] = 'adminViewAllCase/singleCase/$1';
$route['factsuite-admin/factsuite-alacarte'] = 'Admin_Main_Controller/alacarte';
$route['factsuite-admin/factsuite-bgv-interim-cases'] = 'Admin_Main_Controller/bgv_interim_case';
$route['factsuite-admin/factsuite-bgv-completed-cases'] = 'Admin_Main_Controller/bgv_completed_case';


// analyst module
$route['factsuite-analyst/analyst-logout'] = 'logout/analyst_logout';
$route['factsuite-analyst/assigned-case-list'] = 'analyst/assignedCaseList';
$route['factsuite-analyst/assigned-progress-case-list'] = 'analyst/assignedCaseProgressList';
$route['factsuite-analyst/assigned-completed-case-list'] = 'analyst/assignedCaseCompletedList';
$route['factsuite-analyst/assigned-insuff-component-list'] = 'analyst/assignedInsuffComponentList';
$route['factsuite-analyst/qcerror-case-list'] = 'analyst/assignedQcErrorComponentList';
$route['factsuite-analyst/component-detail/(:any)/(:any)/(:any)'] = 'analyst/singleComponentDetail/$1/$2/$3';
$route['factsuite-analyst/candidate-case-export'] = 'Analyst/export_excel';

$route['factsuite-am/component-detail/(:any)/(:any)/(:any)'] = 'am/singleComponentDetails/$1/$2/$3';

$route['factsuite-analyst/get-ticket-priority-list'] ='Custom_Util/get_ticket_priority_list';
$route['factsuite-analyst/get-ticket-classification-list'] ='Custom_Util/get_ticket_classification_list';

// Analyst Component Error Log Starts
$route['factsuite-analyst/raise-new-error'] ='Common_User_Filled_Details_Component_Error/raise_new_error';
$route['factsuite-analyst/get-all-error-log'] ='Common_User_Filled_Details_Component_Error/get_all_error_log';
$route['factsuite-analyst/get-single-error-details'] ='Common_User_Filled_Details_Component_Error/get_single_error_details';
$route['factsuite-analyst/add-new-error-comment'] ='Common_User_Filled_Details_Component_Error/add_new_error_comment';
$route['factsuite-analyst/get-error-single-comment'] ='Common_User_Filled_Details_Component_Error/get_error_single_comment';
$route['factsuite-analyst/get-single-error-all-comments'] ='Common_User_Filled_Details_Component_Error/get_single_error_all_comments';
// Analyst Component Error Log Ends

// Analyst Component Client Clarifications Log Starts
$route['factsuite-analyst/raise-new-client-clarification'] ='Common_User_Filled_Details_Component_Client_Clarifications/raise_new_client_clarification';
$route['factsuite-analyst/get-all-client-clarifications'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_all_client_clarifications';
$route['factsuite-analyst/get-single-client-clarification-details'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_single_client_clarification_details';
$route['factsuite-analyst/get-single-client-clarifications-all-comments'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_single_client_clarifications_all_comments';
$route['factsuite-analyst/add-new-client-clarification-comment'] ='Common_User_Filled_Details_Component_Client_Clarifications/add_new_client_clarification_comment';
$route['factsuite-analyst/get-client-clarification-single-comment'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_client_clarification_single_comment';
$route['factsuite-analyst/get-single-client-clarifications-all-comments'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_single_client_clarifications_all_comments';
$route['factsuite-analyst/update-client-clarification-status'] ='Common_User_Filled_Details_Component_Client_Clarifications/update_client_clarification_status';
$route['factsuite-analyst/get-new-client-clarification-comments-notifications'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_new_client_clarification_comments_notifications';
// Analyst Component Client Clarifications Log Ends

// Specialist Component Client Clarifications Log Starts
$route['factsuite-specialist/raise-new-client-clarification'] ='Common_User_Filled_Details_Component_Client_Clarifications/raise_new_client_clarification';
$route['factsuite-specialist/get-all-client-clarifications'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_all_client_clarifications';
$route['factsuite-specialist/get-single-client-clarification-details'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_single_client_clarification_details';
$route['factsuite-specialist/get-single-client-clarifications-all-comments'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_single_client_clarifications_all_comments';
$route['factsuite-specialist/add-new-client-clarification-comment'] ='Common_User_Filled_Details_Component_Client_Clarifications/add_new_client_clarification_comment';
$route['factsuite-specialist/get-client-clarification-single-comment'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_client_clarification_single_comment';
$route['factsuite-specialist/get-single-client-clarifications-all-comments'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_single_client_clarifications_all_comments';
$route['factsuite-specialist/update-client-clarification-status'] ='Common_User_Filled_Details_Component_Client_Clarifications/update_client_clarification_status';
$route['factsuite-specialist/get-new-client-clarification-comments-notifications'] ='Common_User_Filled_Details_Component_Client_Clarifications/get_new_client_clarification_comments_notifications';
// Specialist Component Client Clarifications Log Ends


// Analyst Escalatory Cases
$route['factsuite-analyst/escalatory-cases'] = 'analyst/escalatory_cases';
$route['factsuite-analyst/get-all-priority-cases'] = 'analyst/get_all_priority_cases';
$route['factsuite-analyst/get-new-priority-cases-count'] = 'analyst/get_new_priority_cases_count';


// Analyst Common
$route['factsuite-analyst/get-custom-filter-number-list'] ='Custom_Util/get_custom_filter_number_list';

// Admin Factsuite Website Services
$route['factsuite-admin/add-website-services'] = 'Admin_Main_Controller/add_new_website_service';
$route['factsuite-admin/all-website-services'] = 'Admin_Main_Controller/all_website_service';
$route['factsuite-admin/check-new-service-name'] = 'Admin_Fs_Website_Services/check_new_service_name';
$route['factsuite-admin/add-new-service'] = 'Admin_Fs_Website_Services/add_new_service';
$route['factsuite-admin/get-all-services'] = 'Admin_Fs_Website_Services/get_all_services';
$route['factsuite-admin/change-factsuite-website-service-status'] = 'Admin_Fs_Website_Services/change_factsuite_website_service_status';
$route['factsuite-admin/delete-factsuite-website-service'] = 'Admin_Fs_Website_Services/delete_factsuite_website_service';
$route['factsuite-admin/get-single-factsuite-website-service'] = 'Admin_Fs_Website_Services/get_single_factsuite_website_service';
$route['factsuite-admin/check-update-service-name'] = 'Admin_Fs_Website_Services/check_update_service_name';
$route['factsuite-admin/update-factsuite-website-service'] = 'Admin_Fs_Website_Services/update_factsuite_website_service';
$route['factsuite-admin/delete-factsuite-service-benefit'] = 'Admin_Fs_Website_Services/delete_factsuite_service_benefit';
$route['factsuite-admin/update-factsuite-website-service-sorting'] = 'Admin_Fs_Website_Services/update_factsuite_website_service_sorting';


// Admin Main Website Service Package
$route['factsuite-admin/add-website-package'] = 'Admin_Main_Controller/add_website_package';
$route['factsuite-admin/add-new-website-package'] = 'Admin_Fs_Website_Service_Packages/add_new_website_package';
$route['factsuite-admin/add-website-package-component-details'] = 'Admin_Main_Controller/add_website_package_component_details';
$route['factsuite-admin/get-selected-component-details-for-website-package'] = 'Admin_Fs_Website_Service_Packages/get_selected_component_details_for_website_package';
$route['factsuite-admin/add-new-component-details-for-website-package'] = 'Admin_Fs_Website_Service_Packages/add_new_component_details_for_website_package';
$route['factsuite-admin/add-website-package-alacarte-component-details'] = 'Admin_Main_Controller/add_website_package_alacarte_component_details';
$route['factsuite-admin/add-new-alacarte-component-details-for-website-package'] = 'Admin_Fs_Website_Service_Packages/add_new_alacarte_component_details_for_website_package';
$route['factsuite-admin/all-website-packages'] = 'Admin_Main_Controller/all_website_packages';
$route['factsuite-admin/get-all-website-service-packages'] = 'Admin_Fs_Website_Service_Packages/get_all_website_service_packages';
$route['factsuite-admin/change-factsuite-website-service-package-status'] = 'Admin_Fs_Website_Service_Packages/change_factsuite_website_service_package_status';
$route['factsuite-admin/delete-factsuite-website-service-package'] = 'Admin_Fs_Website_Service_Packages/delete_factsuite_website_service_package';
$route['factsuite-admin/update-factsuite-website-service-package-sorting'] = 'Admin_Fs_Website_Service_Packages/update_factsuite_website_service_package_sorting';
$route['factsuite-admin/get-single-factsuite-website-service-package'] = 'Admin_Fs_Website_Service_Packages/get_single_factsuite_website_service_package';
$route['factsuite-admin/update-website-package-details'] = 'Admin_Fs_Website_Service_Packages/update_website_package_details';
$route['factsuite-admin/get-single-factsuite-website-service-package-component-details'] = 'Admin_Fs_Website_Service_Packages/get_single_factsuite_website_service_package_component_details';
$route['factsuite-admin/edit-website-package-details'] = 'Admin_Main_Controller/edit_website_package_details';
$route['factsuite-admin/edit-website-package-components'] = 'Admin_Main_Controller/edit_website_package_components';
$route['factsuite-admin/edit-website-package-alacarte-component-details'] = 'Admin_Main_Controller/edit_website_package_alacarte_component_details';


// outputqc

// inputQC Modulefactsuite-outputqc/home-page

$route['factsuite-outputqc/outputqc-logout'] = 'logout/outputqc_logout';
$route['factsuite-outputqc/add-new-case'] = 'outPutQc';
$route['factsuite-outputqc/view-all-case-list'] = 'outPutQc/viewAllCaseList';
$route['factsuite-outputqc/view-case-detail/(:any)/(:any)'] = 'outPutQc/single_case/$1/$2';
$route['factsuite-outputqc/assigned-case-list'] = 'outPutQc/assignedCaseList';
$route['factsuite-outputqc/assigned-view-case-detail/(:any)'] = 'outPutQc/assignedSingleCase/$1';
$route['factsuite-outputqc/pending-case-list'] = 'outPutQc/pendingCaseList';
$route['factsuite-outputqc/completed-case-list'] = 'outPutQc/completedCaseList';
$route['factsuite-outputqc/component-detail/(:any)/(:any)'] = 'outPutQc/singleComponentDetail/$1/$2';
$route['factsuite-outputqc/candidate-case-export'] = 'outPutQc/export_outputqc_excel';
$route['factsuite-outputqc/assigned-completed-case-list'] = 'outPutQc/assignedCompletedCaseList';
$route['factsuite-outputqc/assigned-error-case-list'] = 'outPutQc/assignedErrorCaseList';

//FS Finance Starts
$route['factsuite-finance/assigned-all-case-list'] = 'finance/assignedCaseList';
$route['factsuite-finance/view-all-case-list'] = 'finance/viewAllCaseList';
// $route['factsuite-finance/view-case-detail/(:any)/(:any)'] = 'finance/single_case/$1/$2';
$route['factsuite-finance/assigned-case-list'] = 'finance/assignedCaseList';
$route['factsuite-finance/assigned-view-case-detail/(:any)'] = 'finance/assignedSingleCase/$1';
$route['factsuite-finance/pending-case-list'] = 'finance/pendingCaseList';
$route['factsuite-finance/completed-case-list'] = 'finance/completedCaseList';
$route['factsuite-finance/component-detail/(:any)/(:any)'] = 'finance/singleComponentDetail/$1/$2';
$route['factsuite-finance/candidate-case-export'] = 'finance/export_outputqc_excel';
$route['factsuite-finance/assigned-completed-case-list'] = 'finance/assignedCompletedCaseList';
$route['factsuite-finance/assigned-error-case-list'] = 'finance/assignedErrorCaseList';
$route['factsuite-finance/get-all-cases'] ='Finance_Cases/get_all_cases';
$route['factsuite-finance/view-completed-case-list'] ='finance/view_completed_cases';
$route['factsuite-finance/get-all-completed-cases'] ='Finance_Cases/get_all_completed_cases';
$route['factsuite-finance/view-case-details/(:any)'] = 'finance/single_case/$1';
$route['factsuite-finance/get-custom-filter-number-list'] ='Custom_Util/get_custom_filter_number_list';
$route['factsuite-finance/get-new-cases-count'] ='Finance_Cases/get_new_cases_count';
$route['factsuite-finance/get-custom-actions-list'] ='Custom_Util/get_custom_actions_list';
$route['factsuite-finance/get-all-clients'] ='Custom_Util/get_all_clients';
$route['factsuite-finance/get-all-partially-builled-cases'] ='Finance_Cases/get_all_partially_builled_cases';
$route['factsuite-finance/get-all-saved-summary'] ='Finance_Cases/get_all_saved_summary';
$route['factsuite-finance/get-new-cases-summary-count'] ='Finance_Cases/get_new_cases_summary_count';


/*finance*/
$route['factsuite-finance/get-finance-bills'] ='Finance/request_finance_bill';
$route['factsuite-finance/get-finance-status'] ='Finance/request_finance_status';
$route['factsuite-finance/get-finance-status-and-price'] ='Finance/request_finance_status_price';
$route['factsuite-finance/save-finance-case-summary'] ='Finance/save_finance_case_summary';
$route['factsuite-finance/requiest-finance-case-summary'] ='Finance/request_finance_summary';
$route['factsuite-finance/save-selected-finance-case-summary/(:any)'] ='Finance/selected_request_finance_summary/$1';
$route['factsuite-finance/save-selected-finance-case-summary-value/(:any)'] ='Finance/save_selected_finance_case_summary_value/$1';
$route['factsuite-finance/partially-billed-cases'] ='Finance/assignedInprogressCaseList';
// FS Finance Ends

// Specialist
$route['factsuite-specialist/view-all-component-list'] = 'specialist/assignedCaseList';
$route['factsuite-specialist/assigned-progress-case-list'] = 'specialist/assignedCaseProgressList';
$route['factsuite-specialist/assigned-completed-case-list'] = 'specialist/assignedCaseCompletedList';
$route['factsuite-specialist/view-case-detail/(:any)'] = 'specialist/singleCase/$1';
$route['factsuite-specialist/component-detail/(:any)/(:any)/(:any)'] = 'specialist/singleComponentDetail/$1/$2/$3';
$route['factsuite-specialist/specialist-logout'] = 'logout/specialist_logout';
$route['factsuite-specialist/qcerror-case-list'] = 'specialist/assignedQcErrorComponentList'; 
$route['factsuite-analyst/candidate-case-export'] = 'specialist/export_excel';
// Am
$route['factsuite-am/view-all-case-list'] = 'am';
$route['factsuite-am/view-all-completed-case-list'] = 'am/completed_cases';
$route['factsuite-am/view-all-insuff-case-list'] = 'am/insuff_cases';
$route['factsuite-am/view-case-detail/(:any)'] = 'am/singleCase/$1';
$route['factsuite-am/component-detail/(:any)/(:any)'] = 'am/singleComponentDetail/$1/$2';
$route['factsuite-am/am-logout'] = 'logout/am_logout';
$route['factsuite-am/qcerror-case-list'] = 'am/assignedQcErrorComponentList'; 
$route['factsuite-am/candidate-case-export'] = 'am/export_excel';

// Am
$route['factsuite-csm/view-all-case-list'] = 'CSM';
$route['factsuite-csm/view-case-detail/(:any)'] = 'CSM/singleCase/$1';
$route['factsuite-csm/component-detail/(:any)/(:any)'] = 'CSM/singleComponentDetail/$1/$2';
$route['factsuite-csm/csm-logout'] = 'logout/csm_logout';
$route['factsuite-csm/qcerror-case-list'] = 'CSM/assignedQcErrorComponentList'; 

 
// pdf / preview / download

$route['factsuite-admin/interim-report-preview/(:any)'] ='Admin_Main_Controller/preview_interim_report/$1';
$route['factsuite-admin/interim-report-pdf-download/(:any)'] ='Admin_Main_Controller/interim_pdf/$1';

/*holiday*/
$route['factsuite-admin/holidays'] ='Admin_Main_Controller/holiday';
/* form builder */
$route['factsuite-admin/form-builder'] ='Admin_Main_Controller/drag_and_drop';
$route['factsuite-admin/view-form-builder'] ='Admin_Main_Controller/view_drag_and_drop';
$route['factsuite-admin/edit-form-builder/(:any)'] ='Admin_Main_Controller/edit_form_builder/$1';
/*Internal chat*/
$route['factsuite-admin/internal-chat'] ='Admin_Main_Controller/internal_chat';
$route['factsuite-inputqc/internal-chat'] ='InputQc/internal_chat';
$route['factsuite-analyst/internal-chat'] ='analyst/internal_chat';
$route['factsuite-insuff-analyst/internal-chat'] ='analyst/internal_chat';
$route['factsuite-specialist/internal-chat'] ='specialist/internal_chat';
$route['factsuite-csm/internal-chat'] ='CSM/internal_chat';
$route['factsuite-am/internal-chat'] ='am/internal_chat';
$route['factsuite-outputqc/internal-chat'] ='outPutQc/internal_chat';
$route['factsuite-finance/internal-chat'] ='finance/internal_chat';

/* admin time zone */
$route['factsuite-admin/timezone'] ='Admin_Main_Controller/add_timezone';
$route['factsuite-admin/nomenclature'] ='Admin_Main_Controller/nomenclature';
// $route['factsuite-insuff-analyst/internal-chat'] ='InputQc/internal_chat';


/*Finance edit client*/
$route['factsuite-finance/dashboard'] = 'Finance/dashboard';
$route['factsuite-finance/view-all-client'] = 'Finance/view_client';
$route['factsuite-finance/edit-client/(:any)'] = 'Finance/edit_client/$1';
$route['factsuite-finance/edit-select-package-component-client/(:any)'] = 'Finance/edit_select_package_client/$1';
$route['factsuite-finance/edit-client-component-packages/(:any)'] = 'Finance/edit_client_component_packages/$1';
$route['factsuite-finance/edit-client-alacarte-component/(:any)'] = 'Finance/edit_client_alacarte_component/$1';


// CRON Job Links
$route['factsuite-admin/trigger-candidate-schedule-reporting'] = 'cronJobs/trigger_candidate_schedule_reporting';


/*Approval Mechanisms Link*/
$route['factsuite-csm/client-adding-deletion-approval-mechanism'] = 'Approval_Mechanisms/client_adding_deletion';
$route['factsuite-csm/client-adding-approval-mechanism-rate'] = 'Approval_Mechanisms/client_adding_rate';
$route['factsuite-analyst/client-approval-mechanism'] = 'analyst/client_approval';
$route['factsuite-specialist/client-approval-mechanism'] = 'specialist/client_approval';
$route['factsuite-admin/approval-mechanism'] = 'Admin_Main_Controller/approval_mechanism';
$route['factsuite-admin/admin-approval-mechanism'] = 'Admin_Main_Controller/admin_approval_mechanism';
$route['factsuite-am/approval-mechanism'] = 'am/approval_mechanism';

$route['factsuite-admin/approval-level-mechanism'] = 'Approval_Mechanisms/admin_approver_levels';
$route['factsuite-csm/approval-level-mechanism'] = 'Approval_Mechanisms/csm_approver_levels';
$route['factsuite-am/approval-level-mechanism'] = 'Approval_Mechanisms/am_approver_levels';
$route['factsuite-finance/approval-mechanism'] = 'Approval_Mechanisms/approval_finance_view';
$route['factsuite-admin/approval-mechanism-setting'] = 'Admin_Main_Controller/admin_list_of_approval';
