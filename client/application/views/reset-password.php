<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="icon" href="<?php echo base_url()?>assets/images/fs-icon-transparent.png">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/client/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/client/css/style.css">
 <!-- jQuery -->
<script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>
 <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/toastr/toastr.min.css">
<title>Factsuite Client</title>
</head>
<body>
<div class="sign-lft">
  <div class="sign-bnr"><img src="<?php echo base_url(); ?>assets/client/images/otp-banner.png" /></div>
  <div class="sign-lft-txt">
     <h1>Get Started</h1> 
    <p style="font-size: 17px;">We thank you for trusting FactSuite for your verification needs. In our endeavour to help you make 
    better decisions, we serve you with a CRM platform that furnishes you with ample features and 
    functionalities. The platform boasts a robust build with essential features placed strategically on its 
    interface for easy and seamless navigation.</p>
   
  </div>
</div>
<div class="sign-rgt">
   <div class="sign-logo">
     <a href="#"><img src="<?php echo base_url(); ?>assets/client/images/FactSuite-logo.png" /></a>
   </div>
   <div class="sign-txt">
     <h1>Reset Password</h1>
   </div>
   <div class="sign-frm">
      
    <div class="col-md-12 form-group">
                  <input type="password" id="new-password" class="form-control sign-fld mb-0" placeholder="New Password">
                  <div class="text-left" id="new-password-error-msg-div"></div>
               </div>
               <div class="col-md-12 form-group">
                  <input type="password" id="verify-new-password" class="form-control sign-fld mb-0" placeholder="Verify New Password">
                  <div class="text-left" id="verify-new-password-error-msg-div"></div>
               </div>
               <div class="col-md-12 form-group">
                  <button class="sign-btn mt-0" id="save-password-btn">Save</button>
               </div>

   </div>
</div>
<div class="clr"></div>
<script>
  var base_url = "<?php echo $this->config->item('my_base_url')?>";
  var img_base_url = "<?php echo base_url()?>";
</script>

<script type="text/javascript">
   var email_id = '<?php echo $email_id;?>';
   var encoded_date = '<?php echo $encoded_date;?>';
</script>
<!-- custom-js -->
<script src="<?php echo base_url(); ?>assets/custom-js/login/reset-pasword.js"></script>
<script src="<?php echo base_url(); ?>assets/custom-js/common-validation.js"></script>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="<?php echo base_url(); ?>assets/admin/js/jquery-3.4.1.slim.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/client/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/client/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/toastr/toastr.min.js"></script>
<script>
</body>
</html>