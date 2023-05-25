<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="Cache-Control" content="no-cache" />
   <meta http-equiv="Pragma" content="no-cache" />
   <meta http-equiv="Expires" content="0" />
<link rel="icon" href="<?php echo base_url()?>assets/images/fs-icon-transparent.png">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/style.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/style-new.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/style-b.css">
 <!-- jQuery -->
<!-- <script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script> -->

<!-- plug -->
  <!-- <link rel="preconnect" href="https://fonts.gstatic.com"> -->
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/fontawesome-free/css/all.min.css"> -->
  <!-- Ionicons -->  
  <!-- JQVMap -->
  <!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/jqvmap/jqvmap.min.css"> -->
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/toastr/toastr.min.css">
  <!-- Theme style --> 
  <!-- overlayScrollbars -->
  <!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"> -->
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- summernote -->
  <!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/summernote/summernote-bs4.css"> -->
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/select2/css/select2.min.css">

  <!-- Font Awesome FA -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

  <!-- Datatables -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  
  <!-- Datepicker Css -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?php echo base_url()?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

   <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/toastr/toastr.min.css">
  <!-- <script src="https://cdn.ckeditor.com/4.20.0/standard-all/ckeditor.js"></script> -->
  <script src="https://cdn.ckeditor.com/4.20.1/standard-all/ckeditor.js"></script>
</head>

  
  <!-- jQuery CSS/JS-->
  <script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.css"></script>
  <script src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.js"></script>
  
  <link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/wickedpicker.min.css">
  <title>Fact Suite - Admin</title>
</head>
<body>
   <?php 
                 $admin_details = $this->session->userdata('logged-in-admin');
                if ($this->session->userdata('time')) {
                   $time = $this->session->userdata('time');
                }else{
                   $time = $this->db->where('module',0)->get('timezones')->row_array();
                    $this->session->set_userdata('time',$time);
                }
                 $times = isset($time['timezone'])?$time['timezone']:"Asia/Kolkata";
                 date_default_timezone_set($times);
              ?>
<!--Header-->
<!-- <header>
   <div class="header-cntr">
      <div class="header-lft">
         <img src="<?php echo base_url(); ?>assets/admin/images/FactSuite-logo.png" />
      </div>
      <div class="header-rgt">
         <ul>
            <li>
              <i class="fa fa-calendar"></i>
              <div id="FS-date"></div>
            </li>
            <li>
              <i class="fa fa-clock-o"></i>
              <div id="FS-time"></div>
            </li>
            <li class="candate">
              
              <img src="<?php echo base_url(); ?>assets/admin/images/candidate.png"/>
              <?php echo $admin_details['first_name'];?>
            </li>
            <li>
              <a href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/admin-logout"><i class="fa fa-power-off"></i>
              </a>
            </li>
         </ul>
      </div>
      <div class="clr"></div>
   </div>
</header> -->
<header>
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-3">
            <div class="hdr-lg">
               <img src="<?php echo base_url(); ?>assets/admin/images/FactSuite-logo.png" />
            </div>
         </div>
         <div class="col-md-3"></div>
         <div class="col-md-6">
            <div class="hdr-mn">
               <ul>

                  <li class="nav-item dropdown ml-1 d-none" title="Internal Chat">
                     <a class="nav-link" href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/internal-chat">
                        <i class="fas fa-comment-alt noti-icon-color"></i>
                        <span id="chat-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a> 
                  </li>

                  <li class="nav-item dropdown ml-1" title="Ticket Notification">
                     <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
                        <i class="fa fa-ticket noti-icon-color"></i>
                        <span id="ticket-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color"></span>
                     </a>
                     <div id="ticket-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll"></div>
                  </li>

                  <li class="nav-item dropdown ml-1" title="Case Notification">
                     <a class="nav-link" data-toggle="dropdown" href="#">
                      <i class="fa fa-id-card-o noti-icon-color"></i>
                      <span id="new-case-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a>
                     <div id="case-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll">                    
                     
                        <!-- <a href="#" class="dropdown-item">
                           <i class="fas fa-envelope mr-2"></i> 4 new messages
                        </a>
                        <div class="dropdown-divider"></div> --> 
                        
                     </div>
                  </li>
                  <li class="nav-item dropdown ml-1" title="BGV Report Notification">
                     <a class="nav-link" data-toggle="dropdown" href="#">
                      <i class="fa fa-file-pdf-o noti-icon-color"></i>
                      <span id="bgv-report-notification-count"class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a>
                     <div id="bgv-report-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll">                    
                     
                        <!-- <a href="#" class="dropdown-item">
                           <i class="fas fa-envelope mr-2"></i> 4 new messages
                        </a>
                        <div class="dropdown-divider"></div>
                          -->
                     </div>
                  </li>
                  <li class="nav-item dropdown ml-1 d-none" title="Form Request Notification">
                     <a class="nav-link" data-toggle="dropdown" href="#">
                      <i class="fa fa-wpforms noti-icon-color"></i>
                      <span class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a>
                     <div id="form-request-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll">                    
                     
                        <!-- <a href="#" class="dropdown-item">
                           <i class="fas fa-envelope mr-2"></i> 4 new messages
                        </a>
                        <div class="dropdown-divider"></div> -->
                        
                     </div>
                  </li>
                  <li class="nav-item dropdown ml-1" title="Case Interim Notification">
                     <a class="nav-link" data-toggle="dropdown" href="#">
                      <i class="fa fa-wpforms noti-icon-color"></i>
                      <span id="case-interim-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a>
                     <div id="case-interim-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll">                    
                     
                        <!-- <a href="#" class="dropdown-item">
                           <i class="fas fa-envelope mr-2"></i> 4 new messages
                        </a>
                        <div class="dropdown-divider"></div> -->
                        
                     </div>
                  </li>   
                   <li class="nav-item dropdown ml-1" title="Approval Notification">
                     <a class="nav-link" data-toggle="dropdown" href="#">
                      <i class="fa fa-wpforms noti-icon-color"></i>
                      <span id="new-approval-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a>
                     <div id="new-approval-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll">                    
                     
                        <!-- <a href="#" class="dropdown-item">
                           <i class="fas fa-envelope mr-2"></i> 4 new messages
                        </a>
                        <div class="dropdown-divider"></div> -->
                        
                     </div>
                  </li>  

                  <li class="nav-item dropdown ml-1" title="Approval Notification">
                     <a class="nav-link" data-toggle="dropdown" href="#">
                      <i class="fa fa-wpforms noti-icon-color"></i>
                      <span id="new-approval-notification-count-new" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a>
                     <div id="new-approval-notification-dropdown-new" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll">                    
                     
                        <!-- <a href="#" class="dropdown-item">
                           <i class="fas fa-envelope mr-2"></i> 4 new messages
                        </a>
                        <div class="dropdown-divider"></div> -->
                        
                     </div>
                  </li>  
                              
                  <li>
                     <a href="#" class="candate"><span></span><?php 
                     if (isset($admin_details['first_name'])) {
                        echo ucwords($admin_details['first_name']);
                     }else{
                        redirect(base_url());
                     }
                  ?></a>
                  </li>

                  <li>
                     <a href="<?php echo $this->config->item('my_base_url')?>factsuite-admin/admin-logout" class="lg-out"><i class="fa fa-power-off" aria-hidden="true"></i></a>
                  </li>
                  
               </ul>
            </div>
         </div>
      </div>
   </div>
</header>
<!--Header-->
<<?php 
$admin = $this->session->userdata('logged-in-admin');
$sess = isset($admin['role'])?$admin['role']:'admin';
   if ($sess !='admin') { 
 ?>

<script type="text/javascript">
 var base_url = "<?php echo $this->config->item('my_base_url')?>";
  var img_base_url = "<?php echo base_url()?>";


   function getapproval_notification_new(){

      $.ajax({
         type:'post',
         url:base_url+'Approval_Mechanisms/get_approval_notification',
         data:{
            value:'0',
            moduleName:'admin'
         },
         dataType:'json', 
         success:function(data){
            // console.log(JSON.stringify(data.length))
            var html = '';
            if(data.length > 0){
               $('#new-approval-notification-count-new').html(data.length)

                html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.length+' Notifications';
               html += '</a>';
               for (var i = 0; i < data.length; i++) { 

                     var status_one = 'Pending';
                    if (data[i].level_one_status =='1') {
                        status_one = 'Accepted';
                    }else if(data[i].level_one_status =='2') {
                        status_one = 'Rejected';
                    }
                     
                     var status_two = 'Pending';
                    if (data[i].level_two_status =='1') {
                        status_two = 'Accepted';
                    }else if(data[i].level_two_status =='2') {
                        status_two = 'Rejected';
                    }
                     
                     var status = 'Pending';
                    if (data[i].approval_status =='1') {
                        status = 'Accepted';
                    }else if(data[i].approval_status =='2') {
                        status = 'Rejected';
                    }
                   

                     var status_final = 'Pending';
                    if (data[i].final_approval_status =='1') {
                        status_final = 'Accepted';
                    }else if(data[i].final_approval_status =='2') {
                        status_final = 'Rejected';
                    }
                   
                  html += '<a href="'+base_url+'factsuite-admin/approval-level-mechanism" onclick="clear_the_notification('+data[i].approval_id+')" class="dropdown-item" target="_blank">'
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>Approval id:'+data[i].approval_id+' added by '+data[i].team_name+' ('+data[i].created_by_role+')';
                 
                  // html +='<div class="dropdown-divider">'
                  html +='<br><span>Status 1: '+status_one+' </span><br>';
                  html +='<span>Status 2: '+status_two+' </span><br>';
                  html +='<span>Status 3: '+status+' </span><br>';
                  html +='<span>Final Status : '+status_final+' </span>';
                  // html +='</div>'
                   html +='</a>'
               }

               $('#new-approval-notification-dropdown-new').html(html);
            }else{
               $('#new-approval-notification-count-new').html(data.length)
               html += '<a href="#" class="dropdown-item">'
                  html += '<i class="fas fa-envelope mr-2"></i>No Notification Found'
               html +='</a>'
               html +='<div class="dropdown-divider"></div>'
               $('#new-approval-notification-dropdown-new').html(html);
            }


         },
         error:function(exception){
            console.log(JSON.stringify(exception))
         }
      });
   }

</script>
<?php 
}
?>

<script>
  var base_url = "<?php echo $this->config->item('my_base_url')?>";
  var img_base_url = "<?php echo base_url()?>";


   function getapproval_notification(){

      $.ajax({
         type:'post',
         url:base_url+'Approval_Mechanisms/get_notification_for_admin',
         data:{
            value:'0',
            moduleName:'admin'
         },
         dataType:'json', 
         success:function(data){
            // console.log(JSON.stringify(data.length))
            var html = '';
            if(data.length > 0){
               $('#new-approval-notification-count').html(data.length)

                html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.length+' Notifications';
               html += '</a>';
               for (var i = 0; i < data.length; i++) { 

                     var status_one = 'Pending';
                    if (data[i].level_one_status =='1') {
                        status_one = 'Accepted';
                    }else if(data[i].level_one_status =='2') {
                        status_one = 'Rejected';
                    }
                     
                     var status_two = 'Pending';
                    if (data[i].level_two_status =='1') {
                        status_two = 'Accepted';
                    }else if(data[i].level_two_status =='2') {
                        status_two = 'Rejected';
                    }
                     
                     var status = 'Pending';
                    if (data[i].approval_status =='1') {
                        status = 'Accepted';
                    }else if(data[i].approval_status =='2') {
                        status = 'Rejected';
                    }



                     var status_final = 'Pending';
                    if (data[i].final_approval_status =='1') {
                        status_final = 'Accepted';
                    }else if(data[i].final_approval_status =='2') {
                        status_final = 'Rejected';
                    }
                   
                   
                  html += '<a href="'+base_url+'factsuite-admin/admin-approval-mechanism" onclick="clear_the_notification('+data[i].approval_id+')" class="dropdown-item" target="_blank">'
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>Approval id:'+data[i].approval_id+' added by '+data[i].team_name+' ('+data[i].created_by_role+')';
                 
                  // html +='<div class="dropdown-divider">'
                  html +='<br><span>Status 1: '+status_one+' </span><br>';
                  html +='<span>Status 2: '+status_two+' </span><br>';
                  html +='<span>Status 3: '+status+' </span><br>';
                   html +='<span>Final Status : '+status_final+' </span>';
                  // html +='</div>'
                   html +='</a>'
               }

               $('#new-approval-notification-dropdown').html(html);
            }else{
               $('#new-approval-notification-count').html(data.length)
               html += '<a href="#" class="dropdown-item">'
                  html += '<i class="fas fa-envelope mr-2"></i>No Notification Found'
               html +='</a>'
               html +='<div class="dropdown-divider"></div>'
               $('#new-approval-notification-dropdown').html(html);
            }


         },
         error:function(exception){
            console.log(JSON.stringify(exception))
         }
      });
   }


   function clear_the_notification($id){
      $.ajax({
         type:'post',
         url:base_url+'Approval_Mechanisms/clear_the_notification',
         data:{
            value:'0',
            moduleName:'admin',
            id:$id
         },
         dataType:'json',
         success:function(data){

         }
      });
   }



   function getNewCaseNotification(){

      $.ajax({
         type:'post',
         url:base_url+'AdminViewAllCase/getNewAddedCaseNotification',
         data:{
            value:'0',
            moduleName:'admin'
         },
         dataType:'json',
         success:function(data){
            // console.log(JSON.stringify(data.length))
            var html = '';
            if(data.length > 0){
               $('#new-case-notification-count').html(data.length)

                html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.length+' Notifications';
               html += '</a>';
               for (var i = 0; i < data.length; i++) {
                  var new_case_added_notification = JSON.parse(data[i].new_case_added_notification)
                  // console.log(data[i].candidate_id)
                  // console.log(new_case_added_notification.admin)
                  // console.log(data[i].case_added_by_role)
                  caseAddedBy = '';
                  if(data[i].case_added_by_role == 'client'){
                     caseAddedBy = 'Client';
                  }else{
                     caseAddedBy = 'Data entry team';
                  }

                  html += '<a href="'+base_url+'factsuite-admin/view-case-detail/'+data[i].candidate_id+'" class="dropdown-item" target="_blank">'
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>case id: '+data[i].candidate_id+' added by '+caseAddedBy
                  html +='</a>'
                  html +='<div class="dropdown-divider"></div>'
               }

               $('#case-notification-dropdown').html(html);
            }else{
               $('#new-case-notification-count').html(data.length)
               html += '<a href="#" class="dropdown-item">'
                  html += '<i class="fas fa-envelope mr-2"></i>No Notification Found'
               html +='</a>'
               html +='<div class="dropdown-divider"></div>'
               $('#case-notification-dropdown').html(html);
            }


         },
         error:function(exception){
            console.log(JSON.stringify(exception))
         }
      });
   }


   function getCompletedCaseNotify(){

      $.ajax({
         type:'post',
         url:base_url+'AdminViewAllCase/completedCaseNotify',
         data:{
            value:'1'   
         },
         dataType:'json',
         success:function(data){
            // console.log(JSON.stringify(data.length))
            var html = '';
            if(data.length > 0){
               $('#bgv-report-notification-count').html(data.length)

                html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.length+' Notifications';
               html += '</a>';
               for (var i = 0; i < data.length; i++) {
                  // var new_case_added_notification = JSON.parse(data[i].new_case_added_notification)
                  // // console.log(data[i].candidate_id)
                  // // console.log(new_case_added_notification.admin)
                  // // console.log(data[i].case_added_by_role)
                  // caseAddedBy = '';
                  // if(data[i].case_added_by_role == 'client'){
                  //    caseAddedBy = 'Client';
                  // }else{
                  //    caseAddedBy = 'Data entry team';
                  // }

                  html += '<a href="'+base_url+'factsuite-admin/factsuite-bgv-completed-cases" class="dropdown-item" target="_blank">'
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>case id: '+data[i].candidate_id+' BGV Report is Generated'
                  html +='</a>'
                  html +='<div class="dropdown-divider"></div>'
               }

               $('#bgv-report-notification-dropdown').html(html);
            }else{
               $('#bgv-report-notification-count').html(data.length)
               html += '<a href="#" class="dropdown-item">'
                  html += '<i class="fas fa-envelope mr-2"></i>No Notification Found'
               html +='</a>'
               html +='<div class="dropdown-divider"></div>'
               $('#bgv-report-notification-dropdown').html(html);
            }


         },
         error:function(exception){
            console.log(JSON.stringify(exception))
         }
      });
   }

   function getInterimCaseNotify(){

      $.ajax({
         type:'post',
         url:base_url+'AdminViewAllCase/intrrimCaseNotify',
         data:{
            value:'1'   
         },
         dataType:'json',
         success:function(data){
            // console.log(JSON.stringify(data.length))
            var html = '';
            if(data.length > 0){
               $('#case-interim-notification-count').html(data.length)

                html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.length+' Notifications';
               html += '</a>';

               for (var i = 0; i < data.length; i++) {
                  // var new_case_added_notification = JSON.parse(data[i].new_case_added_notification)
                  // // console.log(data[i].candidate_id)
                  // // console.log(new_case_added_notification.admin)
                  // // console.log(data[i].case_added_by_role)
                  // caseAddedBy = '';
                  // if(data[i].case_added_by_role == 'client'){
                  //    caseAddedBy = 'Client';
                  // }else{
                  //    caseAddedBy = 'Data entry team';
                  // }

                  html += '<a href="'+base_url+'factsuite-admin/factsuite-bgv-interim-cases" class="dropdown-item" target="_blank">'
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>case id: '+data[i].candidate_id+' BGV Interim Report is Generated'
                  html +='</a>'
                  html +='<div class="dropdown-divider"></div>'
               }

               $('#case-interim-notification-dropdown').html(html);
            }else{
               $('#case-interim-notification-count').html(data.length)
               html += '<a href="#" class="dropdown-item">'
                  html += '<i class="fas fa-envelope mr-2"></i>No Notification Found'
               html +='</a>'
               html +='<div class="dropdown-divider"></div>'
               $('#case-interim-notification-dropdown').html(html);
            }


         },
         error:function(exception) {
            console.log(JSON.stringify(exception))
         }
      });
   }

   function get_ticket_notifications() {
      $.ajax({
         type: 'post',
         url: base_url+'factsuite-admin/get-ticket-notifications',
         data: {
            verify_admin_request : 1
         },
         dataType: 'json',
         success: function(data) {
            $('#ticket-notification-count').html(data.all_ticket_notifications.length);
            var html = '<span class="d-block text-center">No Notifications Found</span>';
            if (data.all_ticket_notifications.length > 0) {
               html = '';

                html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.all_ticket_notifications.length+' Notifications';
               html += '</a>';
               var all_ticket_notifications = data.all_ticket_notifications;
               for (var i = 0; i < data.all_ticket_notifications.length; i++) {
                  html += '<a href="'+base_url+'factsuite-admin/tickets-assigned-to-me?tkt_id='+all_ticket_notifications[i].ticket_id+'" class="dropdown-item"><i class="fa fa-id-card-o noti-icon-color mr-2"></i>';
                  if (all_ticket_notifications[i].notification_status_for_assigned_to == 0) {
                     html += 'A new ticket (id:'+all_ticket_notifications[i].ticket_id+') is Assigned to you';
                  } else if(all_ticket_notifications[i].notification_status_for_assigned_to == 2) {
                     html += 'Ticket id: '+all_ticket_notifications[i].ticket_id+' is Re-Opened';
                  }
                  html += '</a>';
               }
            }
            $('#ticket-notification-dropdown').html(html);
         }
      });
   }


   function get_chat_notifications() {
      $.ajax({
         type: 'post',
         url: base_url+'team/get_number_of_chats',
         data: {
            verify_admin_request : 1
         },
         dataType: 'json',
         success: function(data) {
            $('#chat-notification-count').html(data.length);  
         }
      });
   }

   /*getNewCaseNotification();
   getCompletedCaseNotify();
   getInterimCaseNotify();
   get_ticket_notifications();*/
  setInterval(function(){
   get_ticket_notifications();
   getNewCaseNotification();
   getCompletedCaseNotify();
   getInterimCaseNotify();
   // get_chat_notifications();
   getapproval_notification()
   getapproval_notification_new();
  },5000);

</script>


