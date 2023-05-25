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
  <policy domain="module" rights="read|write" pattern="{PS,PDF,XPS}" />
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
  
  <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
  
<!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> -->
   <?php 
      $userInfo = '';
      $role = '';
      $team_id = '';

      if($this->session->userdata('logged-in-analyst')){

         $analystUser = $this->session->userdata('logged-in-analyst');
         $userInfo ='Analyst: '.$analystUser['first_name'];
         $role = $analystUser['role'];
         $team_id = $analystUser['team_id'];

      }else if($this->session->userdata('logged-in-insuffanalyst')){ 

         $insuffanalystUser = $this->session->userdata('logged-in-insuffanalyst');
         $userInfo ='Insuff Analyst: '.$insuffanalystUser['first_name'];
         $role = $insuffanalystUser['role'];
         $team_id = $insuffanalystUser['team_id'];

      } 



   ?>


  <title>Fact Suite - Analyst</title>
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
            <li class="candate"><img src="<?php echo base_url(); ?>assets/admin/images/candidate.png"/><?php echo 
            $userInfo?></li>
            <li><a href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/analyst-logout"><i class="fa fa-power-off"></i></li>
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
         <div class="col-md-2"></div>
         <div class="col-md-7">
            <div class="hdr-mn">
               <ul>
                  <?php if (!$this->session->userdata('logged-in-insuffanalyst')) { ?>
                     <li class="nav-item dropdown ml-1" title="Client Clarification Comments">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                           <i class="fa fa-id-card-o noti-icon-color"></i>
                           <span id="new-clarification-comments-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                        </a>
                        <div id="clarification-comments-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll"></div>
                     </li>
                  <?php } ?>
                  <li class="nav-item dropdown ml-1" title="Internal Chat">
                     <a class="nav-link" href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/internal-chat">
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
                       <!--  <a href="#" class="dropdown-item">
                           <i class="fas fa-envelope mr-2"></i> 1 new messages
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
                 

                  <?php if (!$this->session->userdata('logged-in-insuffanalyst')) { ?>
                  <li class="nav-item dropdown ml-1 " title="Insuff Clear Notification">
                     <a class="nav-link" data-toggle="dropdown" href="#">
                      <i class="fa fa-id-card noti-icon-color"></i>
                      <span id="insuff-case-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a>
                     <div id="insuff-case-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll">   
                        <a href="#" class="dropdown-item">
                           <i class="fas fa-envelope mr-2"></i> 0 new messages
                        </a>
                        <div class="dropdown-divider"></div>
                          
                     </div>
                  </li>
                  <?php 
                     }
                  ?>
                  <li class="nav-item dropdown ml-1 d-none" title="Qc Error Notification" id="qc_error_notification">
                     <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-exclamation-triangle noti-icon-color"></i>
                        <span id="qc-error-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a>
                     <div id="qc-error-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll">   
                       <!--  <a href="#" class="dropdown-item">
                           <i class="fas fa-envelope mr-2"></i> 4 new messages
                        </a>
                        <div class="dropdown-divider"></div> -->
                          
                     </div>
                  </li>
                  <li>
                     <a href="#" class="candate"><span></span><?php echo $userInfo?></a>
                  </li>
                  <li>
                     <a href="<?php echo $this->config->item('my_base_url')?>factsuite-analyst/analyst-logout" class="lg-out"><i class="fa fa-power-off" aria-hidden="true"></i></a>
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
   var userRole = "<?php echo $role;?>";
   var team_id ="<?php echo $team_id?>";





   function clear_the_notification($id){
      $.ajax({
         type:'post',
         url:base_url+'Approval_Mechanisms/clear_the_notification',
         data:{
            value:'0',
            moduleName:'analyst',
            id:$id
         },
         dataType:'json',
         success:function(data){

         }
      });
   }


   function getapproval_notification(){

      $.ajax({
         type:'post',
         url:base_url+'Approval_Mechanisms/get_notification_for_admin',
         data:{
            value:'0',
            moduleName:'analyst'
         },
         dataType:'json',
         success:function(data){
            console.log('sdefrgtreyertyhrtyrty'+JSON.stringify(data.length))
            var html = '';
            if(data.length > 0){
               $('#new-approval-notification-count').html(data.length)
               var approve ='Approved';
               if (data.approval_status =='2') {
                  approve ='Rejected';
               }

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



                     var status_f = 'Pending';
                    if (data[i].final_approval_status =='1') {
                        status_f = 'Accepted';
                    }else if(data[i].final_approval_status =='2') {
                        status_f = 'Rejected';
                    }


                  html += '<a href="'+base_url+'factsuite-analyst/component-detail/'+data[i].case_id+'/'+data[i].component_id+'/'+data[i].index_number+'" onclick="clear_the_notification('+data[i].approval_id+')" class="dropdown-item" target="_blank">'
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>Approval id:'+data[i].approval_id+' Status : '+status_f+' ('+data[i].approved_by_role+')';

                 
                  // html +='<div class="dropdown-divider">'
                  html +='<br><span>Status 1: '+status_one+' </span><br>';
                  html +='<span>Status 2: '+status_two+' </span><br>';
                  html +='<span>Status 3: '+status+' </span>';
                  html +='<span>Final Status: '+status_f+' </span>';
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


   function get_clarification_comments_notification() {
      $.ajax({
         type:'post',
         url:base_url+'factsuite-analyst/get-new-client-clarification-comments-notifications',
         data : {
            verify_analyst_request : 1
         },
         dataType:'json',
         success:function(data) {
            var html = '';
            $('#new-clarification-comments-count').html(data.all_clarification_comments.length);
            if(data.all_clarification_comments.length > 0) {
               var all_clarification_comments = data.all_clarification_comments;

                   html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.all_clarification_comments.length+' Notifications';
               html += '</a>';

               for (var i = 0; i < all_clarification_comments.length; i++) {
                  html += '<a href="'+base_url+'factsuite-analyst/component-detail/'+all_clarification_comments[i].candidate_id+'/'+all_clarification_comments[i].component_id+'/'+all_clarification_comments[i].component_index+'?view_client_clarification='+all_clarification_comments[i].user_filled_details_component_client_clarification_id+'" class="dropdown-item">';
                  html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>New client clarification conmment is generated for ID : '+all_clarification_comments[i].user_filled_details_component_client_clarification_id;
                  html +='</a>';
                  html +='<div class="dropdown-divider"></div>';
               }
            } else {
               html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i>No Notification Found';
               html += '</a>';
               html += '<div class="dropdown-divider"></div>';
            }
            $('#clarification-comments-dropdown').html(html);
         }
      });
   }

   function getComponentErrorNotification(status){

      $.ajax({
         type:'post',
         url:base_url+'analyst/getAssignedComponentNotification',
         data:{
            value:status,            
            id:team_id, 
         },
         dataType:'json',
         success:function(data){
            // console.log(JSON.stringify(data.length))
            var html = '';
            if(data.length > 0){
               $('#qc-error-notification-count').html(data.length);

                html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.length+' Notifications';
               html += '</a>';

               for (var i = 0; i < data.length; i++) {                   

                  html += '<a href="'+base_url+'factsuite-analyst/component-detail/'+data[i].case_id+'/'+data[i].component_id+'/'+data[i].case_index+'" class="dropdown-item" target="_blank">'
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>Component : '+data[i].component_id+' assigned.'
                  html +='</a>'
                  html +='<div class="dropdown-divider"></div>'
               }

               $('#qc-error-notification-dropdown').html(html);
            }else{
               $('#qc-error-notification-count').html(data.length)
               html += '<a href="#" class="dropdown-item">'
                  html += '<i class="fas fa-envelope mr-2"></i>No Notifications Found'
               html +='</a>'
               html +='<div class="dropdown-divider"></div>'
               $('#qc-error-notification-dropdown').html(html);
            }


         },
         error:function(exception){
            console.log(JSON.stringify(exception))
         }
      });
   }


   function getNewCaseNotification(status){

      $.ajax({
         type:'post',
         url:base_url+'analyst/getAssignedComponentNotification',
         data:{
            value:status,            
            id:team_id, 
         },
         dataType:'json',
         success:function(data){
            // console.log(JSON.stringify(data.length))
            var html = '';
            if(data.length > 0){
               $('#new-case-notification-count').html(data.length);

                html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.length+' Notifications';
               html += '</a>';

               for (var i = 0; i < data.length; i++) {                   

                  html += '<a href="'+base_url+'factsuite-analyst/component-detail/'+data[i].case_id+'/'+data[i].component_id+'/'+data[i].case_index+'" class="dropdown-item" target="_blank">'
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>Case ID : '+data[i].case_id+' assigned.'
                  html +='</a>'
                  html +='<div class="dropdown-divider"></div>'
               }

               $('#case-notification-dropdown').html(html);
            }else{
               $('#new-case-notification-count').html(data.length)
               html += '<a href="#" class="dropdown-item">'
                  html += '<i class="fas fa-envelope mr-2"></i>No Notifications Found'
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


   function getInsuffCaseNotification(status){

      $.ajax({
         type:'post',
         url:base_url+'analyst/getAssignedComponentNotification',
         data:{
            value:status,            
            id:team_id, 
         },
         dataType:'json',
         success:function(data){
            // console.log(JSON.stringify(data.length))
            var html = '';
            if(data.length > 0){
               $('#insuff-case-notification-count').html(data.length);

                html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.length+' Notifications';
               html += '</a>';

               for (var i = 0; i < data.length; i++) {                   

                  html += '<a href="'+base_url+'factsuite-analyst/component-detail/'+data[i].case_id+'/'+data[i].component_id+'/'+data[i].case_index+'" class="dropdown-item" target="_blank">'
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>Case ID : '+data[i].case_id+' assigned.'
                  html +='</a>'
                  html +='<div class="dropdown-divider"></div>'
               }

               $('#insuff-case-notification-dropdown').html(html);
            }else{
               $('#insuff-case-notification-count').html(data.length)
               html += '<a href="#" class="dropdown-item">'
                  html += '<i class="fas fa-envelope mr-2"></i>No Notifications Found'
               html +='</a>'
               html +='<div class="dropdown-divider"></div>'
               $('#insuff-case-notification-dropdown').html(html);
            }


         },
         error:function(exception){
            console.log(JSON.stringify(exception))
         }
      });
   }

   function get_ticket_notifications() {
      $.ajax({
         type: 'post',
         url: base_url+'factsuite-analyst/get-ticket-notifications',
         data: {
            verify_analyst_request : 1
         },
         dataType: 'json',
         success: function(data) {
            $('#ticket-notification-count').html(data.all_ticket_notifications.length);
            var html = '<span class="d-block text-center">No Notifications Found</span>';
            if (data.all_ticket_notifications.length > 0) {
               html = '';
               var all_ticket_notifications = data.all_ticket_notifications;
               for (var i = 0; i < data.all_ticket_notifications.length; i++) {
                  html += '<a href="'+base_url+'factsuite-analyst/tickets-assigned-to-me?tkt_id='+all_ticket_notifications[i].ticket_id+'" class="dropdown-item"><i class="fa fa-id-card-o noti-icon-color mr-2"></i>';
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

   if(userRole != 'insuff analyst') {
      getNewCaseNotification('4');
      getComponentErrorNotification('10');
      getInsuffCaseNotification('11');
      $('#qc_error_notification').removeClass('d-none');
      get_clarification_comments_notification();
   } else {
      $('#qc_error_notification').addClass('d-none');
      getNewCaseNotification('3');
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
      if(userRole != 'insuff analyst'){
         getapproval_notification()
         getNewCaseNotification('4');
         getComponentErrorNotification('10');
         getInsuffCaseNotification('11');
         $('#qc_error_notification').removeClass('d-none');
         get_clarification_comments_notification();
      } else {
         $('#qc_error_notification').addClass('d-none');
         getNewCaseNotification('3');
      }
   },2000);

</script>