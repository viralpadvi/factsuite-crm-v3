<?php
/**
 * 
 */
class Approval_Mechanisms_Model extends CI_Model
{ 

    function __construct() {
      parent::__construct();
      $this->load->database();
      $this->load->helper('url');   
      $this->load->model('emailModel');  
      $this->load->model('utilModel');  

    }


    function get_approval_notification($user){  
            $where = "( approve_notification = 1 AND approved_by=".$user['team_id'].") OR ( level_one_notification = 1 AND level_one_id=".$user['team_id'].") OR ( level_two_notification = 1 AND level_two_id=".$user['team_id'].")";
        $this->db->where($where);
        return $this->db->select("approval_mechanism.*,team_employee.first_name  as team_name")->from('approval_mechanism')->join('team_employee','approval_mechanism.crated_by_request = team_employee.team_id','left')->order_by('approval_id','DESC')->get('')->result_array();
    }
 
    function create_approval_for_client(){
        $csm = $this->session->userdata('logged-in-csm');
        $client = $this->input->post('assigned_to_person_id');
        if ($this->input->post('type_of_approval') =='0') {
            $client = $this->input->post('client_master'); 
        }
            $client_data = array(
                'role_of_approval'=>$this->input->post('assigned_to_role'),
                'link_account'=>$client,
                'remarks'=>$this->input->post('description'),
                'type_of_action'=>$this->input->post('type_of_approval'), 
                'account_type'=>$this->input->post('client_type'), 
                'additional_remarks'=>$this->input->post('additional_remarks'),
                'user_name'=>$this->input->post('user_name'),
                'crated_by_request'=>$csm['team_id'],
                'created_by_role'=>$csm['role'],
                'level_one_notification'=>1,
                'number_of_list'=>1,
            );
            $clients = $this->db->where('client_id',$client)->get('tbl_client')->row_array();
              $team = $this->assign_new_approval(1,1);
            if ($team['status'] !='0') {
                $team['type'] = 1;
                $team['remarks'] = $this->input->post('description');
                $team['team_name'] = $csm['first_name'];
                $team['client_name'] = isset($clients['client_name'])?$clients['client_name']:'';
                $client_data['level_one_id'] = $team['team_id'];
                $client_data['level_one_role'] = $team['role'];
                    $this->send_client_add_remove_client($team);
            }
            if ($this->db->insert('approval_mechanism',$client_data)) { 
                return array('status'=>'1','msg'=>'success');
            }else{
                return array('status'=>'0','msg'=>'failed');
            } 
    }

    function approval_for_client_fee(){
        $csm = $this->session->userdata('logged-in-analyst');
        if ($this->session->userdata('logged-in-specialist')) {
           $csm =  $this->session->userdata('logged-in-specialist');
        }
            $client_data = array( 
                'case_id'=>$this->input->post('case_id'),
                'component_name'=>$this->input->post('component_name'),
                'amount'=>$this->input->post('amount'),
                'portal_name'=>$this->input->post('portal_name'),
                'link_account'=>$this->input->post('assigned_to_person_id'),
                'remarks'=>$this->input->post('description'),
                'additional_remarks'=>$this->input->post('additional_remarks'), 
                'component_id'=>$this->input->post('component_id'), 
                'index_number'=>$this->input->post('component_index'), 
                'currency'=>$this->input->post('currency'), 
                'type_of_action'=>'2',  
                'crated_by_request'=>$csm['team_id'],
                'created_by_role'=>$csm['role'],
                'level_one_notification'=>1,
                'number_of_list'=>3,
            );

              $team = $this->assign_new_approval(3,1);
            if ($team['status'] !='0') {
                 $team['case_id'] = $this->input->post('case_id');
                 $team['amount'] = $this->input->post('amount');
                 $team['team_name'] = $csm['first_name'];
                $team['client_name'] = isset($clients['client_name'])?$clients['client_name']:'';
                $client_data['level_one_id'] = $team['team_id'];
                $client_data['level_one_role'] = $team['role'];
                    $this->send_additional_fees($team);
            }
            if ($this->db->insert('approval_mechanism',$client_data)) {
                return array('status'=>'1','msg'=>'success');
            }else{
                return array('status'=>'0','msg'=>'failed');
            } 
    } 
 


 
    function approval_for_crm_user(){
        $csm = $this->session->userdata('logged-in-admin'); 
            $client_data = array( 
                'role_of_approval'=>$this->input->post('assigned_to_role'), 
                'remarks'=>$this->input->post('description'),
                'type_of_action'=>$this->input->post('type'), 
                'manager_name'=>$this->input->post('manager_name'), 
                'user_name'=>$this->input->post('user_name'), 
                'designation'=>$this->input->post('designation'), 
                'components'=>$this->input->post('components'), 
                'additional_remarks'=>$this->input->post('additional_remarks'), 
                'first_name'=>$this->input->post('first_name'), 
                'last_name'=>$this->input->post('last_name'), 
                'manager'=>$this->input->post('manager'), 
                'team_id'=>$this->input->post('team_id'), 
                'contact'=>$this->input->post('contact'), 
                'account_type'=>'crm', 
                'crated_by_request'=>$csm['team_id'],
                'created_by_role'=>$csm['role'],
                'level_one_notification'=>1,
                'number_of_list'=>4,
            );
             $team = $this->assign_new_approval(4,1);
            if ($team['status'] !='0') {
                if ($this->input->post('type') =='0') {
                    $team['type'] = 0;
                }
                 $team['emails'] = $this->input->post('user_name');
                 $team['first_name'] = $this->input->post('first_name');
                 $team['roles'] = $this->input->post('assigned_to_role');
                 $team['team_name'] = $csm['first_name'];
                $team['client_name'] = isset($clients['client_name'])?$clients['client_name']:'';
                $client_data['level_one_id'] = $team['team_id'];
                $client_data['level_one_role'] = $this->input->post('assigned_to_role');
                    $this->add_delete_crm_user($team);
            }
            
            if ($this->db->insert('approval_mechanism',$client_data)) {
                return array('status'=>'1','msg'=>'success');
            }else{
                return array('status'=>'0','msg'=>'failed');
            } 
    }
    function approval_for_am_user(){
        $csm = $this->session->userdata('logged-in-am'); 
            $client_data = array( 
                'role_of_approval'=>$this->input->post('assigned_to_role'), 
                'remarks'=>$this->input->post('description'),  
                'user_name'=>$this->input->post('user_name'), 
                'designation'=>$this->input->post('designation'), 
                'components'=>$this->input->post('components'), 
                'account_type'=>'am', 
                'crated_by_request'=>$csm['team_id'],
                'created_by_role'=>$csm['role'],
            );

            if ($this->db->insert('approval_mechanism',$client_data)) {
                return array('status'=>'1','msg'=>'success');
            }else{
                return array('status'=>'0','msg'=>'failed');
            } 
    }

    function approval_for_rate_user(){
        $csm = $this->session->userdata('logged-in-csm'); 
            $client_data = array(  
                'remarks'=>$this->input->post('description'),  
                'user_name'=>$this->input->post('user_name'),  
                'components'=>$this->input->post('components'), 
                'account_type'=>$this->input->post('client_type'), 
                'additional_remarks'=>$this->input->post('additional_remarks'), 
                'account_type'=>'client', 
                'type_of_action'=>'3', 
                'crated_by_request'=>$csm['team_id'],
                'created_by_role'=>$csm['role'],
                'level_one_notification'=>1,
                'number_of_list'=>2,
            );
            $team = $this->assign_new_approval(2,1);
            if ($team['status'] !='0') {
                $client_data['level_one_id'] = $team['team_id'];
                $client_data['level_one_role'] = $team['role'];
                // $this->all_mail_send($team);
            }

            if ($this->db->insert('approval_mechanism',$client_data)) {
                $approval_id = $this->db->insert_id();
                $this->send_mail_the_rate_creation($approval_id,1);
                return array('status'=>'1','msg'=>'success');
            }else{
                return array('status'=>'0','msg'=>'failed');
            } 
    }

    function get_approval_data($user){
        if ( ($this->session->userdata('logged-in-analyst') || $this->session->userdata('logged-in-specialist')) && $this->input->post('moduleName') !='analyst' && $this->input->post('moduleName') !='specialist') {
            $this->db->where_in('created_by_role',['analyst','specialist'])->where('component_id',$this->input->post('component_id'));
        } else if($this->input->post('list_of_approval')) {
                // $this->db->where('crated_by_request',$user['team_id']);
                $this->db->where('number_of_list',$this->input->post('list_of_approval'));
        } 
       /*if ($this->input->post('rate')=='1') {
               $this->db->where('type_of_action',3);
        }else*/ if($this->input->post('moduleName')=='admin'){
             $this->db->where('for_admin_notification',0);
        }else if($this->input->post('moduleName')=='csm'){
             $where = "( approve_notification = 1 OR level_one_notification = 1 OR level_two_notification =1 ) ";
             $this->db->where($where);
        }else if($this->input->post('moduleName')=='analyst'){
             $where = "( approve_notification = 1 OR level_one_notification = 1 OR level_two_notification =1 ) ";
             $this->db->where($where);
        }else if($this->input->post('moduleName')=='specialist'){
            $where = "( approve_notification = 1 OR level_one_notification = 1 OR level_two_notification =1 ) ";
             $this->db->where($where);
        }
        return $this->db->select("approval_mechanism.*,team_employee.first_name  as team_name")->from('approval_mechanism')->join('team_employee','approval_mechanism.crated_by_request = team_employee.team_id','left')->order_by('approval_id','DESC')->get('')->result_array();
    }

    function get_approvals_data(){ 
        return $this->db->where('approval_id',$this->input->post('approval_id'))->select("approval_mechanism.*,team_employee.first_name as team_name")->from('approval_mechanism')->join('team_employee','approval_mechanism.crated_by_request = team_employee.team_id','left')->order_by('approval_id','DESC')->get('')->row_array();
    }

    function update_approval_data($user){
        $csm = $user;  
            $client_data = array(     
                'approval_status'=>$this->input->post('status'),  
                'approve_remarks'=>$this->input->post('description'),  
                'approve_additional_remarks'=>$this->input->post('additional_remarks'), 
                'approve_reject_date'=>date('Y-m-d H:i:s'),  
                'approved_by'=>$csm['team_id'],
                'approved_by_role'=>$csm['role'],
                'approve_notification'=>2,
                'for_admin_notification'=>1,
            );
 
                $client_data['final_approval_status'] = $this->input->post('status');
            
            $this->manage_approval_action($this->input->post('approval_id'),3);
            if ($this->db->where('approval_id',$this->input->post('approval_id'))->update('approval_mechanism',$client_data)) {
                return array('status'=>'1','msg'=>'success');
            }else{
                return array('status'=>'0','msg'=>'failed');
            }  
    }


    function clear_the_notification($user){ 
            /*$client_data = array(     
                'for_admin_notification'=>1
            );*/


            

           $approver = $this->db->where('approval_id',$this->input->post('id'))->get('approval_mechanism')->row_array();


           if ($this->session->userdata('logged-in-admin')) {
                 $client_data['for_admin_notification'] = 2; 
            }
                if ($approver['approve_notification'] ==$user['team_id']) {
                   $client_data['approve_notification'] = 2;
                }
                if ($approver['level_one_id'] ==$user['team_id']) {
                   $client_data['level_one_notification'] = 2;
                }
                if ($approver['level_two_id'] ==$user['team_id']) {
                   $client_data['level_two_notification'] = 2;
                }


            if ($this->db->where('approval_id',$this->input->post('id'))->update('approval_mechanism',$client_data)) {
                return array('status'=>'1','msg'=>'success');
            }else{
                return array('status'=>'0','msg'=>'failed');
            }  
    }

    function manage_approval_action($approval_id,$r_status){
        $approval = $this->db->where('approval_id',$approval_id)->get('approval_mechanism')->row_array();
        $team = $this->db->where('team_id',$approval['crated_by_request'])->get('team_employee')->row_array();
        $sub ='';

        if ($approval['type_of_action'] =='1' && trim($approval['created_by_role']) =='csm') {
            $sub =' For Client Deletion';
           // $client = $this->db->where('client_id',$approval['link_account'])->get('tbl_client')->row_array();
           $client_array = array(
            'active_status'=>0
           );
           $spoc_array = array(
            'spoc_status'=>0
           );
           $status = "Rejected";
           if ($this->input->post('status') =='1') { 
            $status = "Accepted";
           $this->db->where('client_id',$approval['link_account'])->update('tbl_client',$client_array);
           $this->db->where('client_id',$approval['link_account'])->update('tbl_clientspocdetails',$spoc_array);
           }
           
        }else if($approval['type_of_action'] =='0' && trim($approval['created_by_role']) =='csm'){
              $sub =' For Client Deletion';
           // $client = $this->db->where('client_id',$approval['link_account'])->get('tbl_client')->row_array();
           $client_array = array(
            'active_status'=>1
           );
           $spoc_array = array(
            'spoc_status'=>1
           );
           $status = "Rejected";
           if ($this->input->post('status') =='1') { 
            $status = "Accepted";
           $this->db->where('client_id',$approval['link_account'])->update('tbl_client',$client_array);
           $this->db->where('client_id',$approval['link_account'])->update('tbl_clientspocdetails',$spoc_array);
           $this->send_credentials_to_client_spoc($approval['link_account']);
           }
        }else if($approval['type_of_action'] =='1' && trim($approval['created_by_role']) =='it administrator'){ 
            $sub =' For User Deletion';
           $team_array = array(
            'is_Active'=>0
           ); 
           $this->db->where('team_id',$approval['team_id'])->update('team_employee',$team_array);
        }else if($approval['type_of_action'] =='3' && trim($approval['created_by_role']) =='csm'){
          $client = $this->db->where('client_id',$approval['user_name'])->get('tbl_client')->row_array(); 
          if ($this->input->post('status') =='1') { 
              $component = json_decode($approval['components'],true); 
              $components = json_decode($client['package_components'],true); 
              if (count($components) > 0) {
                 for ($i=0; $i < count($components); $i++) { 
                    $keys = array_search($components[$i]['component_id'],array_column($component, 'component_id')); 
                    $component_price = isset($component[$keys]['form_value'])?$component[$keys]['form_value']:'-'; 
                    if ($component_price !='-') {
                       $components[$i]['component_price'] = $component_price;
                    }
                 }
              } 
              $this->db->where('client_id',$approval['user_name'])->get('tbl_client',array('package_components',json_encode($components)));

              
          }

        }else if($approval['type_of_action'] =='2' && $this->input->post('status') =='1'){
            $table = $this->utilModel->getComponent_or_PageName($approval['component_id']);
            $value = $this->db->where('candidate_id',$approval['case_id'])->get($table)->row_array();

            $array_value = array(
                'additional_fee'=>$this->updateArrayValueThroughIndex($approval['index_number'],$approval['amount'],$value['additional_fee']),
                'additional_currency'=>$this->updateArrayValueThroughIndex($approval['index_number'],$approval['currency'],$value['additional_currency']),
            );
           $this->db->where('candidate_id',$approval['case_id'])->update($table,$array_value);
        }else if($approval['type_of_action'] =='0' && trim($approval['created_by_role']) =='it administrator'  && $this->input->post('status') =='1'){
            $components =[0];
            if ($approval['components'] !='') {
               $components = json_decode($approval['components'],true);
            }
            $pass = rand();
            $team_array = array(
                'first_name' =>isset($approval['first_name'])?$approval['first_name']:'',
                'last_name' =>isset($approval['last_name'])?$approval['last_name']:'',
                'team_employee_email' =>isset($approval['user_name'])?$approval['user_name']:'',
                'contact_no ' =>isset($approval['contact'])?$approval['contact']:'',
                'skills' =>implode(',', $components),
                'reporting_manager' =>isset($approval['manager_name'])?$approval['manager_name']:'', 
                'role' =>isset($approval['role_of_approval'])?$approval['role_of_approval']:'', 
                'team_employee_password' =>md5($pass), 
            ); 
            $this->db->insert('team_employee',$team_array);



                $email_id = strtolower($approval['user_name']);
                // Send To User Starts
                $email_subject = 'Credentials';
 
                $teamMail = ''; 
                $teamMail .='<html> ';
                $teamMail .='<head>';
                $teamMail .='<style>';
                $teamMail .='table {';
                $teamMail .='  font-family: arial, sans-serif;';
                $teamMail .='  border-collapse: collapse;';
                $teamMail .='  width: 100%;';
                $teamMail .='}';

                $teamMail .='td, th {';
                $teamMail .='  border: 1px solid #dddddd;';
                $teamMail .='  text-align: left;';
                $teamMail .='  padding: 8px;';
                $teamMail .='}';

                $teamMail .='tr:nth-child(even) {';
                $teamMail .='  background-color: #dddddd;';
                $teamMail .='}';
                $teamMail .='</style>';
                $teamMail .='</head>';
                $teamMail .='<body> ';
                $teamMail .='<p>Dear '.$approval['first_name'].' '.$approval['last_name'].',</p>';
                $teamMail .='<p>Greetings from Factsuite!!</p>';
                $teamMail .='<p>Please find your Login Credentials to access the Factsuite CRM application, mentioned below- </p>';
                 
                $teamMail .='<table>';
                $teamMail .='<th>CRM Link</th>';
                $teamMail .='<th>UserName</th>';
                $teamMail .='<th>Password</th>';
                $teamMail .='<tr>';
                $teamMail .='<td>'.$this->config->item('main_url').'</td>';
                $teamMail .='<td>'.$email_id.'</td>';
                $teamMail .='<td>'.$pass.'</td>';
                $teamMail .='<tr>';
                $teamMail .='</table>';
                 
                $teamMail .='<p><b>Yours sincerely,<br>';
                $teamMail .='Team FactSuite</b></p>';
                $teamMail .='</body>';
                $teamMail .='</html>';

 
                $send_email_to_user = $this->emailModel->send_mail($email_id,$email_subject,$teamMail);
 
        }
    

      
    $title = "";
    if ($approval['number_of_list'] =='1') {
        $title = "Addition/ Deletion of Client";
    }else if ($approval['number_of_list'] =='2') {
        $title = "Client rate creation/ change";
    }else if ($approval['number_of_list'] =='3') {
        $title = "Additional Verification Fee";
    }else if ($approval['number_of_list'] =='4') {
        $title = "Addition/ Deletion of CRM users";
    }
 
    $ap_user = $this->get_approver();
        $status = "Rejected";
       if ($this->input->post('status') =='1') { 
        $status = "approved";
        } 

        $user = isset($ap_user['first_name'])?$ap_user['first_name']:'';

         $team_data = array();
        if (in_array($approval['number_of_list'],['2','3'])) {
             $where = array('role'=>'finance','approver_status'=>1,'is_Active',1);
         $teams = $this->db->where($where)->get('team_employee')->result_array();
         if ( ($teams) > 0) {
            foreach ($teams as $key => $value) {
                 array_push($team_data,array('name'=>$value['first_name'],'email'=>$value['team_employee_email']));
            }
         }
        }
         array_push($team_data,array('name'=>$team['first_name'],'email'=>$team['team_employee_email']));

         foreach ($team_data as $key => $val) { 

        $to = strtolower($val['email']);
           $subject = "Approver’s response";
           $body = "";
           $body .= "Dear ".$val['name'];
           $body .= "<p>Your request for (".$title."), Request ID :".$approval_id." has been ".$status.". </p> "; 
           if ($this->input->post('status') !='1') {

            $remarks ='';
            if ($this->input->post('description') !='') {
                $remarks =$this->input->post('description');
            }
            $add = '';
            if ($approval['approve_additional_remarks'] !='') {
                 $add = ' ( '.$approval['approve_additional_remarks'].' )';
            }else if($this->input->post('additional_remarks') !=''){

                 $add =' ( '.$this->input->post('additional_remarks').' )';
            }
            $body .= "<p>Remarks : ".$remarks.$add."</p>";
           }
           $body .= "<p>Best regards,</p>";
           $body .= "<p>".$user."</p>";
           $this->emailModel->send_mail($to,$subject,$body);

       }

    }

    function get_approver(){
        $user = $this->session->userdata('logged-in-admin');
        if($this->session->userdata('logged-in-admin')) {
                $user = $this->session->userdata('logged-in-admin');
            } else if($this->session->userdata('logged-in-inputqc')) {
                $user = $this->session->userdata('logged-in-inputqc');
            } else if($this->session->userdata('logged-in-analyst')) {
                $user = $this->session->userdata('logged-in-analyst');
            } else if($this->session->userdata('logged-in-insuffanalyst')) {
                $user = $this->session->userdata('logged-in-insuffanalyst');
            } else if($this->session->userdata('logged-in-outputqc')) {
                $user = $this->session->userdata('logged-in-outputqc');
            } else if($this->session->userdata('logged-in-specialist')) {
                $user = $this->session->userdata('logged-in-specialist');   
            } else if($this->session->userdata('logged-in-am')) {
                $user = $this->session->userdata('logged-in-am');   
            } else if($this->session->userdata('logged-in-finance')) {
                $user = $this->session->userdata('logged-in-finance');
            } else if($this->session->userdata('logged-in-csm')) {
                $user = $this->session->userdata('logged-in-csm');  
            } else if($this->session->userdata('logged-in-tech-support')) {
                $user = $this->session->userdata('logged-in-tech-support');
            }
        return $user;
    }


    function updateArrayValueThroughIndex($pos,$newValue,$oldString=''){ 
            if ($oldString !='') { 
            $value = explode(',',$oldString); 
            }else{
              $value = [0];  
            }
            $value[$pos] = $newValue; 
            $newString = implode(',',$value);
            return $newString;
    }


    function assign_new_approval($list_id,$level){
        $where = array(
            'is_Active'=>1,
            'approver_status'=>1,
            'approval_list'=>$list_id,
        );
        $condition = "approval_access_level REGEXP ".$level;
        $team = $this->db->where($where)->where($condition)->order_by('team_id','RANDOM')->get('team_employee')->row_array();
        if ($team !=null) { 
        return array('team_id'=>$team['team_id'],'role'=>$team['role'],'name'=>$team['first_name'],'email'=>$team['team_employee_email'],'status'=>1);
        }
        return array('status'=>0);
    }


    function get_approver_list($approval_id){
         $approval = $this->db->where('approval_id',$approval_id)->get('approval_mechanism')->row_array();
         
        if (in_array($approval['type_of_action'], ['1','0']) && trim($approval['created_by_role']) =='csm') {
           return '1';
        }else if(in_array($approval['type_of_action'], ['1','0']) && trim($approval['created_by_role']) =='it administrator'){ 
          return '4';
        }else if($approval['type_of_action'] =='3' && trim($approval['created_by_role']) =='csm'){ 
            return '2';
        }else if($approval['type_of_action'] =='2' && $this->input->post('status') =='1'){
            return '3';
        } 

        return 0;
    }


    function approval_one_level($user){
        $csm = $user; 
        $where = array(
            'approval_id'=>$this->input->post('approval_id'),
            'level_one_id'=>$csm['team_id']
        );
        $check_status = $this->db->where($where)->get('approval_mechanism')->row_array();
       if ($check_status ==null) {
          return array('status'=>'0','msg'=>'failed');
       }
            $client_data = array(     
                'level_one_status'=>$this->input->post('status'),  
                'approve_remarks'=>$this->input->post('description'), 
                'approve_additional_remarks'=>$this->input->post('additional_remarks'),    
                'level_one_date'=>date('Y-m-d H:i:s'),  
                // 'approved_by'=>$csm['team_id'],
                // 'approved_by_role'=>$csm['role'],
                // 'level_two_notification'=>1,

                'for_admin_notification'=>1,
            );
 
            $list_id = $this->get_approver_list($this->input->post('approval_id'));
            $level = $this->assign_new_approval($list_id,2);
            $details = $this->get_current_approval_details($check_status['number_of_list']);
            if ($this->input->post('status') =='1' && in_array($details['levels'],[2,3])) {
                $client_data['level_two_id'] = $level['team_id'];
                $client_data['level_two_role'] = $level['role'];
                 $client_data['level_two_notification'] = 1;
           
            $level['remarks'] = $check_status['remarks'];
            $level['approval_id'] = $check_status['approval_id'];
            if ($check_status['number_of_list'] == '1') {

                $clients = $this->db->where('client_id',$check_status['link_account'])->get('tbl_client')->row_array();
                    $level['client_name'] = isset($clients['client_name'])?$clients['client_name']:'';
                if ($check_status['type_of_action'] =='1') {
                    $level['type'] =1;
                } 
                    $level['team_name'] = $check_status['first_name']; 
                   $this->send_client_add_remove_client($level);  

            } else if($check_status['number_of_list'] == '3'){
                 $level['case_id'] = $check_status['case_id'];
                 $level['amount'] = $check_status['amount']; 
                $this->send_additional_fees($level); 
                $level['first_name'] = $check_status['first_name']; 
                $level['team_name'] = $check_status['first_name']; 
                $level['emails'] = $check_status['user_name']; 
                 // $this->add_delete_crm_user($level); 
            } else if($check_status['number_of_list'] == '4'){
                 $level['case_id'] = $check_status['case_id'];
                 $level['amount'] = $check_status['amount']; 
                // $this->send_additional_fees($level); 
                $level['first_name'] = $check_status['first_name']; 
                $level['team_name'] = $check_status['first_name']; 
                $level['emails'] = $check_status['user_name']; 
                $level['roles'] = $check_status['role_of_approval']; 
                if ($check_status['type_of_action'] == '0') {
                     $team['type'] = 0;
                }
                
                 $this->add_delete_crm_user($level); 
            }

        }

            if ($details['levels'] =='1' || $this->input->post('status') =='2') {
                $client_data['final_approval_status'] = $this->input->post('status');
                $client_data['approved_by_role'] = $csm['role'];
                $this->manage_approval_action($this->input->post('approval_id'),1);
            }



            if ($this->db->where('approval_id',$this->input->post('approval_id'))->update('approval_mechanism',$client_data)) {
                 if ($check_status['number_of_list'] == '2' && $details['levels'] =='2') {
                 $this->send_mail_the_rate_creation($this->input->post('approval_id'),2);
                    }
                return array('status'=>'1','msg'=>'success');
            }else{
                return array('status'=>'0','msg'=>'failed');
            }   
    }
 
    function approval_two_level($user){
        $csm = $user; 
        $where = array(
            'approval_id'=>$this->input->post('approval_id'),
            'level_two_id'=>$csm['team_id']
        );
       $check_status = $this->db->where($where)->get('approval_mechanism')->row_array();
       if ($check_status ==null) {
          return array('status'=>'0','msg'=>'failed');
       }
            $client_data = array(     
                'level_two_status'=>$this->input->post('status'),  
                'approve_remarks'=>$this->input->post('description'),    
                'approve_additional_remarks'=>$this->input->post('additional_remarks'),    
                'level_two_date'=>date('Y-m-d H:i:s'),  
                // 'approved_by'=>$csm['team_id'],
                // 'approved_by_role'=>$csm['role'], 
                'for_admin_notification'=>1,
            );
            
             $list_id = $this->get_approver_list($this->input->post('approval_id'));
            $level = $this->assign_new_approval($list_id,3);
            $details = $this->get_current_approval_details($check_status['number_of_list']);
            $level['team_name'] = $check_status['first_name']; 
            if ($this->input->post('status') =='1' && $details['levels'] =='3') {
                $client_data['approved_by'] = $level['team_id'];
                $client_data['approved_by_role'] = $level['role'];
                $client_data['approve_notification'] = 1;

           
 
            $level['remarks'] = $check_status['remarks'];
            $level['approval_id'] = $check_status['approval_id'];
            if ($check_status['number_of_list'] == '1') {
                $clients = $this->db->where('client_id',$check_status['link_account'])->get('tbl_client')->row_array();
                    $level['client_name'] = isset($clients['client_name'])?$clients['client_name']:'';
                if ($check_status['type_of_action'] =='1') {
                    $level['type'] =1;
                } 
                   $this->send_client_add_remove_client($level);  
            } else if($check_status['number_of_list'] == '3'){
                 $level['case_id'] = $check_status['case_id'];
                 $level['amount'] = $check_status['amount']; 
                $this->send_additional_fees($level); 
                $level['first_name'] = $check_status['first_name']; 
                $level['team_name'] = $check_status['first_name']; 
                $level['emails'] = $check_status['user_name']; 
                $level['roles'] = $check_status['role_of_approval']; 

                 // $this->add_delete_crm_user($level); 
            } else if($check_status['number_of_list'] == '4'){
                 $level['case_id'] = $check_status['case_id'];
                 $level['amount'] = $check_status['amount']; 
                // $this->send_additional_fees($level); 
                $level['first_name'] = $check_status['first_name']; 
                $level['team_name'] = $check_status['first_name']; 
                $level['emails'] = $check_status['user_name']; 
                $level['roles'] = $check_status['role_of_approval'];  
                  if ($check_status['type_of_action'] == '0') {
                     $team['type'] = 0;
                }
                 $this->add_delete_crm_user($level); 
            }

        }
            if ($details['levels'] =='2'  || $this->input->post('status') =='2') {
                $client_data['final_approval_status'] = $this->input->post('status');
                $client_data['approved_by_role'] = $csm['role'];
                // if ($this->input->post('status') =='1') { 
                $this->manage_approval_action($this->input->post('approval_id'),2);
                // }
            }

            if ($this->db->where('approval_id',$this->input->post('approval_id'))->update('approval_mechanism',$client_data)) {
                  if ($check_status['number_of_list'] == '2' && $details['levels'] =='3') {
                 $this->send_mail_the_rate_creation($this->input->post('approval_id'),3);
                    }
                return array('status'=>'1','msg'=>'success');
            }else{
                return array('status'=>'0','msg'=>'failed');
            }   
    }

    function get_current_approval_details($id){
        return $this->db->where('approve_id',$id)->get('list_of_approval')->row_array();
    }

 /*{  
        "id": 1,
        "name": "Addition/ Deletion of Client" 
    }, {  
        "id": 2,
        "name": "Client rate creation/ change" 
    }, {  
        "id": 3,
        "name": "Additional Verification Fee" 
    }, {  
        "id": 4,
        "name": "Addition/ Deletion of CRM users"
    }*/

   function get_list_of_the_approval($user){
         $approver_status = $user['approver_status'];

        if ($approver_status =='1') { 
        $approval_list = $user['approval_list'];
        $approval_access_level = $user['approval_access_level'];
       /* $list = 'type_of_action ="" AND created_by_role=""'; 
        if ($approval_list =='1') {
          $list = 'type_of_action IN(0,1) AND created_by_role="csm"'; 
        }else if($approval_list =='2'){
         $list = 'type_of_action IN(3) AND created_by_role="csm"';    
        }else if($approval_list =='3'){
          $list = 'type_of_action IN(2) AND (created_by_role="analyst" OR created_by_role="specialist")';   
        }else if($approval_list =='4'){
           $list = 'type_of_action IN(0,1) AND created_by_role="it administrator"';   
        }*/
        
        // $this->db->where($list);
        if ($approval_access_level !=null) {
            $approval_access_levels = explode(',', $approval_access_level);
        }

        $where = " ( level_one_id =".$user['team_id']." OR  level_two_id =".$user['team_id']." OR approved_by=".$user['team_id']." ) ";
        $this->db->where($where);

        return $this->db->select("approval_mechanism.*,team_employee.first_name  as team_name")->from('approval_mechanism')->join('team_employee','approval_mechanism.crated_by_request = team_employee.team_id','left')->order_by('approval_id','DESC')->get('')->result_array();

    }else{
        return array();
    }

    }


        function get_approval_data_for_finance($user){
         
               $this->db->where_in('type_of_action',[3,2]);
         
        return $this->db->select("approval_mechanism.*,team_employee.first_name  as team_name")->from('approval_mechanism')->join('team_employee','approval_mechanism.crated_by_request = team_employee.team_id','left')->order_by('approval_id','DESC')->get('')->result_array();
    }


        function send_credentials_to_client_spoc($client_id) {
        $get_client_spoc_details = $this->db->join('tbl_client AS T2', 'T1.client_id = T2.client_id')->where('T2.client_id',$client_id)->get('tbl_clientspocdetails AS T1')->result_array();
        // print_r($get_client_spoc_details);
        // exit();
        // Send To User Starts
        $client_email_subject = 'Login Credentials - Factsuite CRM';

        $client_email_message = '';
        $template = $this->db->where(array('template_type'=>'Client Registration','client_id'=>'0'))->get('email-templates')->row_array();

        foreach ($get_client_spoc_details as $key => $value) {
            $client_email_id = strtolower($value['spoc_email_id']);
            if ($template != '' && $template != null) {
                $client_email_message = str_replace("@client_name",$value['client_name'],$template['template_content']);
                $client_email_message = str_replace("@client_email_id",$client_email_id,$client_email_message);
                $client_email_message = str_replace("@link",$this->config->item('client_url'),$client_email_message);
                $client_email_message = str_replace("@otp_or_password",base64_decode($value['SPOC_Password']),$client_email_message); 
            } else {
                $client_email_message .= '<html> ';
                $client_email_message .= '<head>';
                $client_email_message .= '<style>';
                $client_email_message .= 'table {';
                $client_email_message .= 'font-family: arial, sans-serif;';
                $client_email_message .= 'border-collapse: collapse;';
                $client_email_message .= 'width: 100%;';
                $client_email_message .= '}';

                $client_email_message .= 'td, th {';
                $client_email_message .= 'border: 1px solid #dddddd;';
                $client_email_message .= 'text-align: left;';
                $client_email_message .= 'padding: 8px;';
                $client_email_message .= '}';

                $client_email_message .= 'tr:nth-child(even) {';
                $client_email_message .= 'background-color: #dddddd;';
                $client_email_message .= '}';
                $client_email_message .= '</style>';
                $client_email_message .= '</head>';
                $client_email_message .= '<body> ';
                $client_email_message .= '<p>Dear '.$value['client_name'].',</p>';
                $client_email_message .= '<p>Greetings from Factsuite!!</p>';
                $client_email_message .= '<p>At the outset we thank you for choosing Factsuite as your Employee Background Screening partner.</p>';
                $client_email_message .= '<p>We appreciate your business & hope to delight you with our efficient service offerings during our association.</p>';
                $client_email_message .= '<p>Please find the Login Credentials for your Factsuite CRM access, mentioned below- </p>';
                $client_email_message .= '<table>';
                $client_email_message .= '<th>CRM Link</th>';
                $client_email_message .= '<th>UserName</th>';
                $client_email_message .= '<th>Password</th>';
                $client_email_message .= '<tr>';
                $client_email_message .= '<td>'.$this->config->item('client_url').'</td>';
                $client_email_message .= '<td>'.$client_email_id.'</td>';
                $client_email_message .= '<td>'.base64_decode($value['SPOC_Password']).'</td>';
                $client_email_message .= '<tr>';
                $client_email_message .= '</table>';
                $client_email_message .= '<p><b>Yours sincerely,<br>';
                $client_email_message .= 'Team FactSuite</b></p>';
                $client_email_message .= '</body>';
                $client_email_message .= '</html>';
            }
            $send_email_to_user = $this->emailModel->send_mail($client_email_id,$client_email_subject,$client_email_message);
        }

        if ($send_email_to_user) {
            return array('status'=>'1','msg'=>'success');
        } else {
            return array('status'=>'0','msg'=>'failed');
        }
    }



    function send_mail_the_rate_creation($approval_id,$status){
        $approval = $this->db->where('approval_id',$approval_id)->get('approval_mechanism')->row_array();
        $team_id = 0;
        if ($status == '0') {
           $team_id = $approval['crated_by_request'];
        }else if($status == '1'){
            $team_id = $approval['level_one_id'];
        }else if($status == '2'){
            $team_id = $approval['level_two_id'];
        }else if($status == '3'){
            $team_id = $approval['approval_id'];
        }
        $team = $this->db->where('team_id',$team_id)->get('team_employee')->row_array();
        $team1 = $this->db->where('team_id',$approval['crated_by_request'])->get('team_employee')->row_array();
        $role = isset($team['role'])?$team['role']:'';
         
         $component = json_decode($approval['components'],true); 
        
          $link = base_url()."factsuite-admin/approval-level-mechanism";
         if (strtolower($role) =='csm') {
             $link = base_url()."factsuite-csm/approval-level-mechanism";
         }else if (strtolower($role) =='am') {
             $link = base_url()."factsuite-am/approval-level-mechanism";
         } 


          $where = array('role'=>'finance','approver_status'=>1,'is_Active',1);
         $teams = $this->db->where($where)->get('team_employee')->result_array();
         $team_data = array();
         if ( ($teams) > 0) {
            foreach ($teams as $key => $value) {
                 array_push($team_data,array('name'=>$value['first_name'],'email'=>$value['team_employee_email']));
            }
         }
         array_push($team_data,array('name'=>$team['first_name'],'email'=>$team['team_employee_email']));
             

         foreach ($team_data as $keys => $val) { 
        $client_email_subject = 'Client Rate creation/ change';
        $client_email_message ='';
        $client_email_message .= '<html> ';
        $client_email_message .= '<head>';
        $client_email_message .= '</head>';
        $client_email_message .= '<body>';
        $client_email_message .= 'Dear '.$val['name'].',';

        $client_email_message .= '<p>Request your approval for a price decrease of </p>';
        // $client_email_message .= $price_and_componenet;
         $price_and_componenet = '';
              if (count($component) > 0) {
                 for ($i=0; $i < count($component); $i++) {   
                    $component_price = isset($component[$i]['form_values'])?$component[$i]['form_values']:'-'; 
                    $component_name = isset($component[$i]['component_name'])?$component[$i]['component_name']:'-'; 
                    if ($component_price !='-') {
                       // $components[$i]['component_price'] = $component_price;
                       $client_email_message .= '<p>'.$component_price.' on our '.$component_name.'. </p>';
                    }
                 }
              } 
        // $client_email_message .= '<p>We have carefully evaluated the current market conditions and have found that this price change is necessary to maintain our profitability and continue to provide high-quality services to our customers.</p>';

        $client_email_message .= '<p>The new price will be effective from '.date('Y-m-d').' and will be communicated to our customers through our CRM. We believe that the proposed price increase is reasonable and competitive in the market.</p>';

        $client_email_message .= '<p> Link : '.$link.'</p>';

        $client_email_message .= '<p>'.$team1['first_name'].'</p>';

        $client_email_message .= '</body>';
        $client_email_message .= '<html>'; 
        // echo $client_email_message; 
         $send_email_to_user = $this->emailModel->send_mail($val['email'],$client_email_subject,$client_email_message);

     }


    }



    function get_assign_details(){
        $team = $this->db->where('team_id',$this->input->post('assign_to'))->get('team_employee')->row_array();
        return  array('team_id'=>$team['team_id'],'role'=>$team['role'],'name'=>$team['first_name'],'email'=>$team['team_employee_email'],'status'=>1);
    }

    function update_approval_assign(){
        $client_data =array();
        if ($this->input->post('level') =='1') {
              $client_data['level_one_id'] = $this->input->post('assign_to');
        }
        if ($this->input->post('level') =='2') {
              $client_data['level_two_id'] = $this->input->post('assign_to');
        }
        if ($this->input->post('level') =='3') {
              $client_data['approved_by'] = $this->input->post('assign_to');
        } 

        
        $check_status = $this->db->where('approval_id',$this->input->post('approval_id'))->get('approval_mechanism')->row_array();
         $list_id = $this->get_approver_list($this->input->post('approval_id'));
            $level = $this->get_assign_details();
            $details = $this->get_current_approval_details($check_status['number_of_list']);
            
            $level['remarks'] = $check_status['remarks'];
            $level['approval_id'] = $check_status['approval_id'];
            if ($check_status['number_of_list'] == '1') {

                $clients = $this->db->where('client_id',$check_status['link_account'])->get('tbl_client')->row_array();
                    $level['client_name'] = isset($clients['client_name'])?$clients['client_name']:'';
                if ($check_status['type_of_action'] =='1') {
                    $level['type'] =1;
                } 
                    $level['team_name'] = $check_status['first_name']; 
                   $this->send_client_add_remove_client($level);  

            } else if($check_status['number_of_list'] == '3'){
                 $level['case_id'] = $check_status['case_id'];
                 $level['amount'] = $check_status['amount']; 
                $this->send_additional_fees($level); 
                $level['first_name'] = $check_status['first_name']; 
                $level['team_name'] = $check_status['first_name']; 
                $level['emails'] = $check_status['user_name']; 
                 // $this->add_delete_crm_user($level); 
            } else if($check_status['number_of_list'] == '4'){
                 $level['case_id'] = $check_status['case_id'];
                 $level['amount'] = $check_status['amount']; 
                // $this->send_additional_fees($level); 
                $level['first_name'] = $check_status['first_name']; 
                $level['team_name'] = $check_status['first_name']; 
                $level['emails'] = $check_status['user_name']; 
                $level['roles'] = $check_status['role_of_approval']; 
                if ($check_status['type_of_action'] == '0') {
                     $team['type'] = 0;
                }
                
                 $this->add_delete_crm_user($level); 
            }else if($check_status['number_of_list'] == '2'){
                 $this->send_mail_the_rate_creation($this->input->post('approval_id'),$this->input->post('level'));
            }

           
            
        if ($this->db->where('approval_id',$this->input->post('approval_id'))->update('approval_mechanism',$client_data)) {
            return array('status'=>'1','msg'=>'success');
        }else{
            return array('status'=>'0','msg'=>'failed');
        } 
    }

    function update_approval_list_level(){ 
        $client_data['levels'] = $this->input->post('level'); 
        if ($this->db->where('approve_id',$this->input->post('approve_id'))->update('list_of_approval',$client_data)) {
            return array('status'=>'1','msg'=>'success');
        }else{
            return array('status'=>'0','msg'=>'failed');
        } 
    }


    function all_mail_send($array_data){

        $client_email_subject = "Approval Request";
        $client_email_message = "";
        $client_email_message .= "Dear ".$array_data['name'].',';
        $client_email_message .= "<p>Please Approve My Request.</p></br>";
        $client_email_message .= "Thanks.";

         $send_email_to_user = $this->emailModel->send_mail($array_data['email'],$client_email_subject,$client_email_message);
    }

    function send_client_add_remove_client($array_data){
         $client_email_message = "";
         $link = base_url()."factsuite-admin/approval-level-mechanism";
         if (strtolower($array_data['role']) =='csm') {
             $link = base_url()."factsuite-csm/approval-level-mechanism";
         }else if (strtolower($array_data['role']) =='am') {
             $link = base_url()."factsuite-am/approval-level-mechanism";
         }

        if (isset($array_data['type'])) {
           $client_email_subject = "Approval Request"; 
            $client_email_message .= "Dear  ".$array_data['name'].',';
            $client_email_message .= "<p>I am writing to request your approval for the deactivation of ".$array_data['client_name']." from our CRM system. The reason for this request is ".$array_data['remarks']."</p>";
            $client_email_message .= "<p>Link : ".$link."</p>";
            $client_email_message .= $array_data['team_name']; 
        }else{
            $client_email_subject = "Approval Request"; 
            $client_email_message .= "Dear  ".$array_data['name'].',';
            $client_email_message .= "<p>I am writing to request your approval for adding a new client to our CRM. For the new client, ".$array_data['client_name'].", We have already collected all the necessary information, including their contact details, company profile, and the services they are interested in. We are confident that we can provide them with the best solutions to their requirements.</p>";
            $client_email_message .= "<p>Link : ".$link."</p>";
         $client_email_message .= $array_data['team_name'];

        }
         $send_email_to_user = $this->emailModel->send_mail($array_data['email'],$client_email_subject,$client_email_message);
    }


    function send_additional_fees($array_data){
         $client_email_message = "";
         $link = base_url()."factsuite-admin/approval-level-mechanism";
         if (strtolower($array_data['role']) =='csm') {
             $link = base_url()."factsuite-csm/approval-level-mechanism";
         }else if (strtolower($array_data['role']) =='am') {
             $link = base_url()."factsuite-am/approval-level-mechanism";
         }
         $where = array('role'=>'finance','approver_status'=>1,'is_Active',1);
         $team = $this->db->where($where)->get('team_employee')->result_array();
         $team_data = array();
         if ( ($team) > 0) {
            foreach ($team as $key => $value) {
                 array_push($team_data,array('name'=>$value['first_name'],'email'=>$value['team_employee_email']));
            }
         }
         array_push($team_data,array('name'=>$array_data['name'],'email'=>$array_data['email']));
         
        foreach ($team_data as $keys => $val) { 
        $client_email_subject = " Additional Verification Fee"; 
        $client_email_message .= "Dear  ".$val['name'].',';
        $client_email_message .= "<p>Request your approval for including an additional verification fee for  ".$array_data['case_id']." .</p>";
         $client_email_message .= "<p>The Fee for this additional verification process is  ".$array_data['amount']."</p>"; 
        $client_email_message .= "<p>Link : ".$link."</p>";
         $client_email_message .= $array_data['team_name']; 
        $send_email_to_user = $this->emailModel->send_mail($val['email'],$client_email_subject,$client_email_message);
        }
    }


    function add_delete_crm_user($array_data){
         $client_email_message = "";
         $link = base_url()."factsuite-admin/approval-level-mechanism";
         if (strtolower($array_data['role']) =='csm') {
             $link = base_url()."factsuite-csm/approval-level-mechanism";
         }else if (strtolower($array_data['role']) =='am') {
             $link = base_url()."factsuite-am/approval-level-mechanism";
         }
        $client_email_message .= "Dear  ".$array_data['name'].',';

          if (isset($array_data['type'])) { 
            $client_email_subject = "Addition of CRM user"; 
              $client_email_message .= "<p>Request your approval for addition of a new user to our CRM system. .</p>"; 
            $client_email_message .= "<p>The details of the user are as follows: </p>";
            $client_email_message .= "<p>Name : ".$array_data['first_name']."</p>";
            $client_email_message .= "<p>Email : ".$array_data['emails']."</p>";
            $client_email_message .= "<p>Role : ".$array_data['roles']."</p>"; 
            $client_email_message .= "<p>Kindly approve the addition/ deletion of the user.</p>";
            $client_email_message .= "<p>Thank you in advance for your prompt attention to this matter.</p>";
          }else{
            $client_email_subject = "Deactivation of CRM user"; 
               $client_email_message .= "<p>Request your approval for Deactivation of a user to our CRM system. .</p>"; 
            $client_email_message .= "<p>The details of the user are as follows: </p>";
            $client_email_message .= "<p>Name : ".$array_data['first_name']."</p>";
            $client_email_message .= "<p>Email : ".$array_data['emails']."</p>";
            $client_email_message .= "<p>Role : ".$array_data['roles']."</p>"; 
            $client_email_message .= "<p>Reason : ".$array_data['remarks']."</p>";  

          }
      
        $client_email_message .= "<p>Link : ".$link."</p>";
         $client_email_message .= $array_data['team_name'];

        $send_email_to_user = $this->emailModel->send_mail($array_data['email'],$client_email_subject,$client_email_message);
    }

 
} 