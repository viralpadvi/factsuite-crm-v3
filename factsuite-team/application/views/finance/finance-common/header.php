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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<!-- plug -->
   <link rel="preconnect" href="https://fonts.gstatic.com">
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
   <!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css"> -->
     <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

   <!-- Jquery DatePicker -->
   <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

   <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
   <!-- Datepicker Css -->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <link href="<?php echo base_url()?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
   <?php $userData = $this->session->userdata('logged-in-finance');?>
   <title>Fact Suite - Finance</title>
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
            <li class="candate"><img src="<?php echo base_url(); ?>assets/admin/images/candidate.png"/>OutPutQc : <span class="text-capitalize"><?php echo $userData['first_name']?></span></li>
            <li><a href="<?php echo $this->config->item('my_base_url')?>factsuite-outputqc/outputqc-logout"><i class="fa fa-power-off"></i></li>
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
                     <a class="nav-link" href="<?php echo $this->config->item('my_base_url')?>factsuite-finance/internal-chat">
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

                  <li class="nav-item dropdown ml-1" title="New Case Notification">
                     <a class="nav-link" data-toggle="dropdown" href="#">
                      <i class="fa fa-id-card-o noti-icon-color"></i>
                      <span id="new-case-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a>
                     <div id="case-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll">                    
                     
                     <!--    <a href="#" class="dropdown-item">
                           <i class="fas fa-envelope mr-2"></i> 4 new messages
                        </a>
                        <div class="dropdown-divider"></div> -->
                         
                     </div>
                  </li>
                  <li class="nav-item dropdown ml-1" title="Qc Error Clear Notification">
                     <a class="nav-link" data-toggle="dropdown" href="#">
                      <i class="fa fa-id-badge noti-icon-color"></i>
                      <span id="qc-error-clear-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a>
                     <div id="qc-error-clear-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll">                    
                     
                        <!-- <a href="#" class="dropdown-item">
                           <i class="fas fa-envelope mr-2"></i> 4 new messages
                        </a>
                        <div class="dropdown-divider"></div> -->
                         
                     </div>
                  </li>
                  <li>
                     <a href="#" class="candate"><span></span><?php echo ucwords($userData['first_name'])?></a>
                  </li>
                  <li>
                     <a href="<?php echo $this->config->item('my_base_url')?>factsuite-outputqc/outputqc-logout" class="lg-out"><i class="fa fa-power-off" aria-hidden="true"></i></a>
                  </li>
                  
               </ul>
            </div>
         </div>
      </div>
   </div>
</header>
<!--Header-->
<script>
  var base_url = "<?php echo $this->config->item('my_base_url')?>";
  var img_base_url = "<?php echo base_url()?>";

  var team_id = "<?php echo $userData['team_id']?>"

  //  function getNewCaseNotification(){

  //     $.ajax({
  //        type:'post',
  //        url:base_url+'outPutQc/outPutQcNewCaseNotify',
  //        data:{
  //           value:'1',            
  //           id:team_id
  //        },
  //        dataType:'json',
  //        success:function(data){
  //           // console.log(JSON.stringify(data.length))
  //           var html = '';
  //           if(data.length > 0){
  //              $('#new-case-notification-count').html(data.length)
  //              for (var i = 0; i < data.length; i++) {
  //                 var new_case_added_notification = JSON.parse(data[i].new_case_added_notification)
  //                 // console.log(data[i].candidate_id)
  //                 // console.log(new_case_added_notification.admin)
  //                 // console.log(data[i].case_added_by_role)
  //                 caseAddedBy = '';
  //                 if(data[i].case_added_by_role == 'client'){
  //                    caseAddedBy = 'Client';
  //                 }else{
  //                    caseAddedBy = 'Data entry team';
  //                 }

  //                 html += '<a href="'+base_url+'factsuite-outputqc/assigned-view-case-detail/'+data[i].candidate_id+'" class="dropdown-item" target="_blank">'
  //                    html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>case id: '+data[i].candidate_id+' assigned.'
  //                 html +='</a>'
  //                 html +='<div class="dropdown-divider"></div>'
  //              }

  //              $('#case-notification-dropdown').html(html);
  //           }else{
  //              $('#new-case-notification-count').html(data.length)
  //              html += '<a href="#" class="dropdown-item">'
  //                 html += '<i class="fas fa-envelope mr-2"></i>No notfications found'
  //              html +='</a>'
  //              html +='<div class="dropdown-divider"></div>'
  //              $('#case-notification-dropdown').html(html);
  //           }


  //        },
  //        error:function(exception){
  //           console.log(JSON.stringify(exception))
  //        }
  //     });
  //  }

  //  function outPutQcClearComponentErrorNotify(){

  //     $.ajax({
  //        type:'post',
  //        url:base_url+'outPutQc/outPutQcClearComponentErrorNotify',
  //        data:{
  //           value:'0',            
  //           id:team_id
  //        },
  //        dataType:'json',
  //        success:function(data){
  //           // console.log(JSON.stringify(data))
  //           var html = '';
  //           if(data.length > 0){
  //              $('#qc-error-clear-notification-count').html(data.length)
  //              for (var i = 0; i < data.length; i++) {
                   

  //                 html += '<a href="'+base_url+'factsuite-outputqc/assigned-view-case-detail/'+data[i].case_id+'" class="dropdown-item" target="_blank">'
  //                    html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>case id: '+data[i].case_id+' assigned.'
  //                 html +='</a>'
  //                 html +='<div class="dropdown-divider"></div>'
  //              }

  //              $('#qc-error-clear-notification-dropdown').html(html);
  //           }else{
  //              $('#qc-error-clear-notification-count').html(data.length)
  //              html += '<a href="#" class="dropdown-item">'
  //                 html += '<i class="fas fa-envelope mr-2"></i>No notfications found'
  //              html +='</a>'
  //              html +='<div class="dropdown-divider"></div>'
  //              $('#qc-error-clear-notification-dropdown').html(html);
  //           }


  //        },
  //        error:function(exception){
  //           console.log(JSON.stringify(exception))
  //        }
  //     });
  //  }

  // getNewCaseNotification();
  // outPutQcClearComponentErrorNotify()

  // setInterval(function(){
  //  getNewCaseNotification();
  //  outPutQcClearComponentErrorNotify()
  // },3000)

   function get_ticket_notifications() {
      $.ajax({
         type: 'post',
         url: base_url+'factsuite-finance/get-ticket-notifications',
         data: {
            verify_finance_request : 1
         },
         dataType: 'json',
         success: function(data) {
            $('#ticket-notification-count').html(data.all_ticket_notifications.length);
            var html = '<span class="d-block text-center">No Notifications Found</span>';
            if (data.all_ticket_notifications.length > 0) {
               html = '';
               var all_ticket_notifications = data.all_ticket_notifications;

                  html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.all_ticket_notifications.length+' Notifications';
               html += '</a>';
               
               for (var i = 0; i < data.all_ticket_notifications.length; i++) {
                  html += '<a href="'+base_url+'factsuite-finance/tickets-assigned-to-me?tkt_id='+all_ticket_notifications[i].ticket_id+'" class="dropdown-item"><i class="fa fa-id-card-o noti-icon-color mr-2"></i>';
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
   setInterval(function() {
      get_chat_notifications();
      get_ticket_notifications();
   },3000);
</script>


