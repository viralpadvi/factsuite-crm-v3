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
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/style-new.css">

 <!-- jQuery -->
<script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>

<!-- plug -->
 <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->  
  <!-- JQVMap -->
  <!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/jqvmap/jqvmap.min.css"> -->
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/toastr/toastr.min.css">
  <!-- Theme style --> 
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/summernote/summernote-bs4.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/select2/css/select2.min.css">

  <!-- Font Awesome FA -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Datatables -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  
  <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
  
  <!-- Datepicker Css -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?php echo base_url()?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

<?php $userData = $this->session->userdata('logged-in-am'); ?>
  <title>Fact Suite - Am</title>
</head>
<body>
<!--Header-->
<!-- <header>
   <div class="header-cntr">
      <div class="header-lft">
         <img src="<?php echo base_url(); ?>assets/admin/images/FactSuite-logo.png" />
      </div>
      <div class="header-rgt">
         <ul>
            <li><i class="fa fa-calendar"></i> <div id="FS-date"></div></li>
            <li><i class="fa fa-clock-o"></i> <div id="FS-time"></div></li>
            <li class="candate"><img src="<?php echo base_url(); ?>assets/admin/images/candidate.png"/>AM : <?php echo isset($userData['first_name'])?$userData['first_name']:"Am"?></li>
            <li><a href="<?php echo $this->config->item('my_base_url')?>factsuite-am/am-logout"><i class="fa fa-power-off"></i></li>
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

                  <li class="nav-item dropdown ml-1" title="Internal Chat">
                     <a class="nav-link" href="<?php echo $this->config->item('my_base_url')?>factsuite-am/internal-chat">
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
                  
                  <li class="nav-item dropdown ml-1" title="Escalatory Notification">
                     <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
                        <i class="fa fa-id-card-o noti-icon-color"></i>
                        <span id="escalatory-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color"></span>
                     </a>
                     <div id="escalatory-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll"></div>
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
                     <a href="#" class="candate"><span></span><?php echo isset($userData['first_name'])?$userData['first_name']:"Am"?></a>
                  </li>
                  <li>
                     <a href="<?php echo $this->config->item('my_base_url')?>factsuite-am/am-logout" class="lg-out"><i class="fa fa-power-off" aria-hidden="true"></i></a>
                  </li>
                  
               </ul>
            </div>
         </div>
      </div>
   </div>
</header>


<script type="text/javascript">
 var base_url = "<?php echo $this->config->item('my_base_url')?>";
  var img_base_url = "<?php echo base_url()?>";


   function getapproval_notification(){

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
                   
                  html += '<a href="'+base_url+'factsuite-am/approval-level-mechanism" onclick="clear_the_notification('+data[i].approval_id+')" class="dropdown-item" target="_blank">'
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>Approval id:'+data[i].approval_id+' added by '+data[i].team_name+' ('+data[i].created_by_role+')';
                 
                  // html +='<div class="dropdown-divider">'
                  html +='<br><span>Status 1: '+status_one+' </span><br>';
                  html +='<span>Status 2: '+status_two+' </span><br>';
                  html +='<span>Status 3: '+status+' </span>';
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

<!--Header-->
<script>
  var base_url = "<?php echo $this->config->item('my_base_url')?>";
  var img_base_url = "<?php echo base_url()?>";
</script>

<script>
   function get_escalatory_cases_notifications() {
      $.ajax({
         type: 'post',
         url: base_url+'factsuite-am/get-escalatory-cases-notifications',
         data: {
            verify_am_request : 1
         },
         dataType: 'json',
         success: function(data) {
            $('#escalatory-notification-count').html(data.all_escalatory_cases.length);
            var html = '<span class="d-block text-center">No Notifications Found</span>';
            if (data.all_escalatory_cases.length > 0) {
               html = '';
               var all_case = data.all_escalatory_cases;
               for (var i = 0; i < data.all_escalatory_cases.length; i++) {
                  html += '<a href="'+base_url+'factsuite-am/view-case-detail/'+all_case[i].candidate_id+'" class="dropdown-item"><i class="fa fa-id-card-o noti-icon-color mr-2"></i>';
                  html += 'Case id:'+all_case[i].candidate_id+' is Over TAT';
                  html += '</a>';
               }
            }
            $('#escalatory-notification-dropdown').html(html);
         }
      });
   }

   function get_ticket_notifications() {
      $.ajax({
         type: 'post',
         url: base_url+'factsuite-am/get-ticket-notifications',
         data: {
            verify_am_request : 1
         },
         dataType: 'json',
         success: function(data) {
            $('#ticket-notification-count').html(data.all_ticket_notifications.length);
            var html = '<span class="d-block text-center">No Notifications Found</span>';
            if (data.all_ticket_notifications.length > 0) {
               html = '';
               var all_ticket_notifications = data.all_ticket_notifications;
               for (var i = 0; i < data.all_ticket_notifications.length; i++) {
                  html += '<a href="'+base_url+'factsuite-am/tickets-assigned-to-me?tkt_id='+all_ticket_notifications[i].ticket_id+'" class="dropdown-item"><i class="fa fa-id-card-o noti-icon-color mr-2"></i>';
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


   get_ticket_notifications();
   get_escalatory_cases_notifications();
   setInterval(function() {
      get_ticket_notifications();
      get_escalatory_cases_notifications();
      get_chat_notifications();
       getapproval_notification();
   },2000);
</script>