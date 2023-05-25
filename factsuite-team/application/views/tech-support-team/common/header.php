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

<?php $userData = $this->session->userdata('logged-in-csm'); ?>
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
                  <li class="nav-item dropdown ml-1" title="Ticket Notification">
                     <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
                        <i class="fa fa-ticket noti-icon-color"></i>
                        <span id="ticket-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color"></span>
                     </a>
                     <div id="ticket-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll"></div>
                  </li>
                  
                  <li>
                     <a href="javascript:void(0)" class="candate"><span></span><?php echo isset($userData['first_name'])?$userData['first_name']:"Tech Support"?></a>
                  </li>
                  <li>
                     <a href="<?php echo $this->config->item('my_base_url')?>factsuite-tech-support/tech-support-logout" class="lg-out"><i class="fa fa-power-off" aria-hidden="true"></i></a>
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
</script>

<script>
   function get_ticket_notifications() {
      $.ajax({
         type: 'post',
         url: base_url+'factsuite-tech-support/get-ticket-notifications',
         data: {
            verify_tech_support_request : 1
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
                  html += '<a href="'+base_url+'factsuite-tech-support/tickets-assigned-to-me?tkt_id='+all_ticket_notifications[i].ticket_id+'" class="dropdown-item"><i class="fa fa-id-card-o noti-icon-color mr-2"></i>';
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

   // get_escalatory_cases_notifications();
   get_ticket_notifications();
   setInterval(function() {
      // get_escalatory_cases_notifications();
      get_ticket_notifications();
   },5000);
</script>