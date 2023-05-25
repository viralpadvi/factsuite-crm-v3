<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-verify-otp';
   }
</script>

<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="icon" href="<?php echo base_url()?>assets/images/fs-icon-transparent.png">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
<title>Factsuite - Candidate</title>
 <!-- jQuery -->
<!-- <script src="<?php //echo base_url()?>assets/plugins/jquery/jquery.min.js"></script> -->
<script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script> 
<!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/toastr/toastr.min.css">
<script>
  var base_url = "<?php echo $this->config->item('my_base_url')?>";
  var img_base_url = "<?php echo base_url()?>";
</script>


</head>
<body>
   <!-- <div class="for-mobile">
      <div class="container only-for-desktop-txt-div">
         <h1>This platform currently supports login from a web browser only. Please use a Desktop browser to fill the form.</h1>
      </div>
   </div>  -->
<div class="for-desktop">
<div class="otp-lft mb-non">
  <div class="otp-bnr"><img src="<?php echo base_url(); ?>assets/images/otp-banner.png" /></div>
  <div class="otp-txt">
     <h1>Get Started</h1> 
    <p style="font-size: 17px;">We thank you for trusting FactSuite for your verification needs. In our endeavour to help you make 
    better decisions, we serve you with a CRM platform that furnishes you with ample features and 
    functionalities. The platform boasts a robust build with essential features placed strategically on its 
    interface for easy and seamless navigation.</p>
  </div>
</div>
<div class="otp-rgt">
   <div class="otp-logo">
     <a href="#"><img src="<?php echo base_url(); ?>assets/images/FactSuite-logo.png" /></a>
   </div>
   <div class="otp-sign">
     <h1>Please enter the OTP sent to your phone number</h1>
     <!-- <span>An password send to your phone numebr</span> -->
   </div>
   <div class="otp-frm">
      <div class="input-group">
      <label>Password</label>
         <div class="row">
            <div class="col-md-3">
               <input type="text" class="sign-fld form-control" id="otp1" maxlength="1" onkeyup="moveOnMax(this,'otp2')" autofocus >
            </div>
            <div class="col-md-3">
               <input type="text" class="sign-fld form-control" id="otp2" maxlength="1" onkeyup="moveOnMax(this,'otp3')" >
            </div>
            <div class="col-md-3">
               <input type="text" class="sign-fld form-control" id="otp3" maxlength="1" onkeyup="moveOnMax(this,'otp4')" >
            </div>
            <div class="col-md-3">
               <input type="text" class="sign-fld form-control" id="otp4" maxlength="1" onkeyup="moveOnMax(this,'otp1')" >
            </div>
            <div class="col-sm-6">
               <?php $show_1 = 0;
               if ($show_1 == 1) { ?>
                  <div class="otp-resend"><a href="javascript:void(0)">Resend OTP</a></div>
               <?php } ?>
            </div>

            <div class="col-sm-6">
               <div class="otp-sec" id="otp-sec"></div>
               <!-- Resend OTP in <span id="sec-time">5 sec</span> -->
            </div>
         </div>
         <div>
           <span id="invelid-otp-error" class="text-danger"></span>
         </div>
      </div>
      <a href="javascript:void(0)" id="sign-in-btn" class="otp-btn">Sign in</a>
      <div class="clr"></div>
   </div>
</div>
<div class="clr"></div>

<script src="<?php echo base_url(); ?>assets/custom-js/login/candidate-otp.js"></script>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS --> 
<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/toastr/toastr.min.js"></script>

</div>
</body>
</html>