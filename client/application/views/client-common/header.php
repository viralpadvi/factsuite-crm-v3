<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">

<link rel="icon" href="<?php echo base_url()?>assets/images/fs-icon-transparent.png">

<?php if ($this->config->item('live_ui_version') == 1) { ?>
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="<?php echo base_url(); ?>assets/client/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>assets/client/css/style.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>assets/client/css/style-new.css">
   <link rel="stylesheet" href="<?php echo base_url(); ?>assets/client/css/style-b.css">

   <!-- jQuery -->
   <script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>

   <!-- plug -->
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
  
   <!-- Datepicker Css -->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <link href="<?php echo base_url()?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
   <!-- jQuery CSS/JS-->
   <script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>
   <script src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.css"></script>
   <script src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.js"></script>
<?php } else { ?>

<?php } ?>
  
<?php $client_data  = $this->session->userdata('logged-in-client'); 
  // print_r($client_data);
?>
<title>Factsuite Client</title>
</head>
<body>
<!--Header-->
 
<!--Header-->
<header>
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-3">
            <div class="hdr-lg">
               <img src="<?php echo base_url(); ?>assets/client/images/FactSuite-logo.png" />
            </div>
         </div>
         <div class="col-md-3"></div>
         <div class="col-md-6">
            <div class="hdr-mn">
               <ul>
                  <!-- <li>
                     <a href="#" class="notify"> 
                        <i class="fa fa-bell-o" aria-hidden="true"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                     </a>
                  </li> -->

                  <li class="nav-item dropdown ml-1" title="Client Clarification Notification">
                     <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
                      <i class="fa fa-id-card-o noti-icon-color"></i>
                      <span id="new-clarification-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a>
                     <div id="clarification-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll"></div>
                  </li>

                  <li class="nav-item dropdown ml-1" title="Case Notification">
                     <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
                      <i class="fa fa-id-card-o noti-icon-color"></i>
                      <span id="new-case-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a>
                     <div id="case-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll"> <!-- <a href="#" class="dropdown-item">
                           <i class="fas fa-envelope mr-2"></i> 4 new messages
                        </a>
                        <div class="dropdown-divider"></div>
                        --> 
                     </div>
                  </li>
                  <li class="nav-item dropdown ml-1" title="BGV Report Notification">
                     <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
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

                  <li class="nav-item dropdown ml-1" title="Insuff Case Notification" id="insuf_case_notification">
                     <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
                        <i class="fa fa-exclamation-triangle noti-icon-color"></i>
                        <span id="insuff-case-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a>
                     <div id="insuff-case-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll">   
                        <!-- <a href="#" class="dropdown-item">
                           <i class="fas fa-envelope mr-2"></i> 4 new messages
                        </a>
                        <div class="dropdown-divider"></div> -->
                          
                     </div>
                  </li>

                  <li class="nav-item dropdown ml-1" title="Case Interim Notification">
                     <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
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
                  
                  <li class="nav-item dropdown ml-1 d-none" title="Case Finance Notification">
                     <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
                      <i class="fas fa-coins noti-icon-color"></i>
                      <span id="case-finance-notification-count" class="badge badge-warning navbar-badge form-request-noti-count-color">0</span>
                     </a>
                     <div id="case-finance-notification-dropdown" class="dropdown-menu dropdown-menu-lg dropdown-menu-right noti-dropdown-scroll">                    
                     
                        <!-- <a href="#" class="dropdown-item">
                           <i class="fas fa-envelope mr-2"></i> 4 new messages
                        </a>
                        <div class="dropdown-divider"></div> -->
                        
                     </div>
                  </li> 

                  <li>
                     <a href="#" class="candate"><span></span><?php echo $client_data['client_name']." (".isset($client_data['spoc_name'])?$client_data['spoc_name']:"Client".")";?></a>
                  </li>

                  <li>
                     <a href="<?php echo $this->config->item('my_base_url')?>logout/client_logout" class="lg-out"><i class="fa fa-power-off" aria-hidden="true"></i></a>
                  </li>
                  
               </ul>
            </div>
         </div>
      </div>
   </div>
</header>
<script>
   var base_url = "<?php echo $this->config->item('my_base_url')?>";
   var img_base_url = "<?php echo base_url()?>";
   var client_id = "<?php echo $client_data['client_id']?>";
   var candidate_url_for_redirecting_to_candidate_module = '<?php echo $this->config->item('candidate_url_for_redirecting_to_candidate_module');?>';


   function getNewClarificationNotification() {
      $.ajax({
         type:'post',
         url:base_url+'cases/getNewClarificationNotification',
         dataType:'json',
         success:function(data) {
            var html = '';
            $('#new-clarification-notification-count').html(data.length)
            if(data.length > 0) {
                html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.length+' Notifications';
               html += '</a>';
               for (var i = 0; i < data.length; i++) {
                  if (data[i].type == 1) {
                     html += '<a href="'+base_url+'factsuite-client/view-single-case/'+data[i].value['candidate_id']+'?view_client_clarification='+data[i].value['user_filled_details_component_client_clarification_id']+'" class="dropdown-item">';
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>New client clarification is generated ID : '+data[i].value['user_filled_details_component_client_clarification_id'];
                     html +='</a>';
                     html +='<div class="dropdown-divider"></div>';
                  } else if(data[i].type == 2) {
                     html += '<a href="'+base_url+'factsuite-client/view-single-case/'+data[i].value['candidate_id']+'?view_client_clarification='+data[i].value['user_filled_details_component_client_clarification_id']+'" class="dropdown-item">';
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>New client clarification comment is generated for ID : '+data[i].value['user_filled_details_component_client_clarification_id'];
                     html +='</a>';
                     html +='<div class="dropdown-divider"></div>';
                  }
               }
            } else {
               html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i>No Notification Found';
               html += '</a>';
               html += '<div class="dropdown-divider"></div>';
            }
            $('#clarification-notification-dropdown').html(html);
         }
      });
   }

   function get_clarification_comments_notification() {
      $.ajax({
         type:'post',
         url:base_url+'cases/get_new_clarification_comments',
         dataType:'json',
         success:function(data) {
            var html = '';
            $('#new-clarification-comments-count').html(data.length)
            if(data.length > 0) {
                html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.length+' Notifications';
               html += '</a>';
               for (var i = 0; i < data.length; i++) {
                  html += '<a href="'+base_url+'factsuite-client/view-single-case/'+data[i].candidate_id+'?view_client_clarification='+data[i].user_filled_details_component_client_clarification_id+'" class="dropdown-item">';
                  html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>New client clarification is generated for ID : '+data[i].user_filled_details_component_client_clarification_id;
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

   function completedCaseNotify(){

      $.ajax({
         type:'post',
         url:base_url+'cases/completedCaseNotify',
         data:{
            value:'1', 
            id:client_id, 
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

                  html += '<a href="'+base_url+'factsuite-client/view-single-case/'+data[i].candidate_id+'" class="dropdown-item" target="_blank">'
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>case id: '+data[i].candidate_id+' BGV Report is Generated'
                  html +='</a>'
                  html +='<div class="dropdown-divider"></div>'
               }

               $('#bgv-report-notification-dropdown').html(html);
            }else{
              $('#bgv-report-notification-count').html(data.length)
               html += '<a href="#" class="dropdown-item">'
                  html += '<i class="fas fa-envelope mr-2"></i>No Notifications found'
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

   function insuffCaseNotify(){

      $.ajax({
         type:'post',
         url:base_url+'cases/insuffCaseNotify',
         data:{
            value:'1', 
            id:client_id, 
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

                  html += '<a href="'+base_url+'factsuite-client/view-single-case/'+data[i].candidate_id+'" class="dropdown-item" target="_blank">'
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>case id: '+data[i].candidate_id+' Insuff raised'
                  html +='</a>'
                  html +='<div class="dropdown-divider"></div>'
               }

               $('#insuff-case-notification-dropdown').html(html);
            }else{
              $('#insuff-case-notification-count').html(data.length)
               html += '<a href="#" class="dropdown-item">'
                  html += '<i class="fas fa-envelope mr-2"></i>No Notifications found'
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

   function getInterimCaseNotify(){

      $.ajax({
         type:'post',
         url:base_url+'cases/intrrimCaseNotify',
         data:{
            value:'1',
            id:client_id  
         },
         dataType:'json',
         success:function(data){
            // console.log(JSON.stringify(data.length))
            var html = '';
            if(data.length > 0){
               $('#case-interim-notification-count').html(data.length);

                   html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.length+' Notifications';
               html += '</a>';

               for (var i = 0; i < data.length; i++) { 
                  html += '<a href="'+base_url+'factsuite-client/view-single-case/'+data[i].candidate_id+'" class="dropdown-item" target="_blank">'
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>case id: '+data[i].candidate_id+' BGV Interim Report is Generated'
                  html +='</a>'
                  html +='<div class="dropdown-divider"></div>'
               }

               $('#case-interim-notification-dropdown').html(html);
            }else{
               $('#case-interim-notification-count').html(data.length)
               html += '<a href="#" class="dropdown-item">'
                  html += '<i class="fas fa-envelope mr-2"></i>No Notifications found'
               html +='</a>'
               html +='<div class="dropdown-divider"></div>'
               $('#case-interim-notification-dropdown').html(html);
            }


         },
         error:function(exception){
            console.log(JSON.stringify(exception))
         }
      });
   }

   function getfinancesummarynotify(){

      $.ajax({
         type:'post',
         url:base_url+'cases/get_finance_notification',
         data:{
            value:'1',
            id:client_id  
         },
         dataType:'json',
         success:function(data){
            // console.log(JSON.stringify(data.length))
            var html = '';
            if(data.length > 0){
               $('#case-finance-notification-count').html(data.length);

                   html += '<a href="javascript:void(0)" class="dropdown-item">';
               html += '<i class="fas fa-envelope mr-2"></i> '+data.length+' Notifications';
               html += '</a>';
               
               for (var i = 0; i < data.length; i++) { 
                  html += '<a href="'+base_url+'factsuite-client/get-finance-bills?cases='+btoa(data[i].candidate_ids)+'&&id='+data[i].summary_id+'" class="dropdown-item" target="_blank">'
                     html += '<i class="fa fa-id-card-o noti-icon-color mr-2"></i>Summary: '+data[i].summary_id+' Summary Created'
                  html +='</a>'
                  html +='<div class="dropdown-divider"></div>'
               }

               $('#case-finance-notification-dropdown').html(html);
            }else{
               $('#case-finance-notification-count').html(data.length)
               html += '<a href="#" class="dropdown-item">'
                  html += '<i class="fas fa-envelope mr-2"></i>No Notifications found'
               html +='</a>'
               html +='<div class="dropdown-divider"></div>'
               $('#case-finance-notification-dropdown').html(html);
            }


         },
         error:function(exception){
            console.log(JSON.stringify(exception))
         }
      });
   }


  // getNewCaseNotification();
  // completedCaseNotify();
  // insuffCaseNotify();
  // getInterimCaseNotify();
  getNewClarificationNotification();
  setInterval(function() {
   // getNewCaseNotification();
   // completedCaseNotify();
   // insuffCaseNotify();
   // getInterimCaseNotify();
   getNewClarificationNotification();
  },2000);
</script>
