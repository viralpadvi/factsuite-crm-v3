<?php 
   $admin_details = $this->session->userdata('logged-in-admin');
   $time = $this->db->where('module',0)->get('timezones')->row_array();
   $times = isset($time['timezone'])?$time['timezone']:"Asia/Kolkata";
   date_default_timezone_set($times);
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="icon" href="<?php echo base_url()?>assets/images/fs-icon-transparent.png">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Cache-Control" content="no-cache" />
   <meta http-equiv="Pragma" content="no-cache" />
   <meta http-equiv="Expires" content="0" />
  <title>Factsuite Client</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/assets-v2/plugins/fontawesome-free/css/all.min.css">
  <!-- Toastr -->
   <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/toastr/toastr.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/assets-v2/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/assets-v2/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/assets-v2/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/assets-v2/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/assets-v2/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/assets-v2/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/assets-v2/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Rubik -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/assets-v2/dist/css/custom-v2.css">

  <!-- jQuery -->
  <script src="<?php echo base_url()?>assets/assets-v2/plugins/jquery/jquery.min.js"></script>

   <!-- Font Awesome FA -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   <!-- Datatables -->
   <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  
   <!-- Datepicker Css -->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <link href="<?php echo base_url()?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
   <!-- jQuery CSS/JS-->
   <script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>
   <script src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.css"></script>
   <script src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.js"></script>

   <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/lib/duDatepicker.min.css">
   <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/lib/duDatepicker-theme.css">
   <?php 
   $sidebar_collapsed = '';
   if ($this->session->userdata('sidebar-toggle')) {
      $sidebar_collapsed = ' sidebar-collapse';
   } ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed<?php echo $sidebar_collapsed;?>">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link pl-0" data-widget="pushmenu" id="pushmenu" href="javascript:void(0)" role="button"><img src="<?php echo base_url()?>assets/assets-v2/dist/img/sidebar-toggler.png"></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <?php if ($client_result['notification_to_client_for_client_clarification_status'] == 1) {
         if (in_array(1, explode(',',$client_result['notification_to_client_for_client_clarification_types']))) { ?>
            <li class="nav-item dropdown ml-1" title="Client Clarification Notification">
               <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
                  <!-- <i class="fa fa-id-card-o noti-icon-color"></i> -->
                  <img src="<?php echo base_url()?>assets/assets-v2/dist/img/client-clarification-notification.svg">
                  <span id="new-clarification-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
               </a>
               <div id="clarification-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll"></div>
            </li>
      <?php } } ?>

      <li class="nav-item dropdown ml-1" title="Case Notification">
         <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
            <!-- <i class="fa fa-id-card-o noti-icon-color"></i> -->
            <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/case-notification.svg">
            <span id="new-case-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
         </a>
         <div id="case-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll"></div>
      </li>

      <li class="nav-item dropdown ml-1" title="BGV Report Notification">
         <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
            <!-- <i class="fa fa-file-pdf-o noti-icon-color"></i> -->
            <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/bgv-report-notification.svg">
            <span id="bgv-report-notification-count"class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
         </a>
         <div id="bgv-report-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll"></div>
      </li>

      <?php if ($client_result['notification_to_client_for_insuff_status'] == 1) {
         if (in_array(1, explode(',',$client_result['notification_to_client_for_insuff_types']))) { ?>
            <li class="nav-item dropdown ml-1" title="Insuff Case Notification" id="insuf_case_notification">
               <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
                  <!-- <i class="fa fa-exclamation-triangle noti-icon-color"></i> -->
                  <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/insuff-case-notification.svg">
                  <span id="insuff-case-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
               </a>
               <div id="insuff-case-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll"></div>
            </li>
      <?php } } ?>

      <li class="nav-item dropdown ml-1 d-none" title="Case Interim Notification">
         <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
            <!-- <i class="fa fa-wpforms noti-icon-color"></i> -->
            <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/case-interim-notification.svg">
            <span id="case-interim-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
         </a>
         <div id="case-interim-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll"></div>
      </li>

      <li class="nav-item ml-1">
         <a class="nav-link" href="<?php echo $this->config->item('my_base_url')?>logout/client_logout" class="lg-out"><i class="fa fa-power-off text-danger" aria-hidden="true"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <script>
  var base_url = "<?php echo $this->config->item('my_base_url')?>";
  var img_base_url = "<?php echo base_url()?>";

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

   getNewCaseNotification();
   getCompletedCaseNotify();
   getInterimCaseNotify();
   get_ticket_notifications();
  setInterval(function(){
   get_ticket_notifications();
   getNewCaseNotification();
   getCompletedCaseNotify();
   getInterimCaseNotify();
   get_chat_notifications();
  },2000);

</script>