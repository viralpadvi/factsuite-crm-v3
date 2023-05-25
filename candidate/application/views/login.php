<script>
   if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'m-sign-in';
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
 <!-- jQuery -->
<script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>
<title>Factsuite - Candidate</title>
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
</div> -->
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
     <h1>Sign in</h1>
     <!-- <h1>Hello, Sign in here</h1> -->
     <span>Sign in to fill your E-Form Application</span>
   </div>
   <div class="otp-frm">
      <div class="input-group">
      <label>Mobile Number</label>
      <div class="input-group-prepend">
         <span class="input-group-text" id="basic-addon1"><img src="<?php echo base_url(); ?>assets/images/phone.png" /></span>
      </div>
      <input type="text" class="form-control otp-fld" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="contact-no" aria-describedby="basic-addon1" autofocus >
      </div>
      <div id="contact-no-error">&nbsp;</div>
      <a href="javascript:void(0)" id="sign-in-btn" class="otp-btn">Verify</a>
      <div class="clr"></div>
   </div>
</div>
<div class="clr"></div>
<script src="<?php echo base_url(); ?>assets/custom-js/login/candidate-login.js"></script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="js/jquery-3.4.1.slim.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
</div>
</body>
</html>