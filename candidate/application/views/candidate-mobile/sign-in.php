<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>';
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
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/style.css">

<script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>

<script>
  var base_url = "<?php echo $this->config->item('my_base_url')?>";
  var img_base_url = "<?php echo base_url()?>";
</script>

<title>Fact Suite - Candidate</title>
</head>
<body>
<section id="hm">
   <div class="">
      <div class="otp-logo"><img src="<?php echo base_url(); ?>assets/mobile/images/FactSuite-logo.png" /></div>
      <div class="otp-sign">
         <h1>Hello, Sign in here</h1>
         <span>Sign in to fill your E-Form Application</span>
      </div>
      <div class="otp-frm">
         <div class="input-group">
            <label>Mobile Number</label>
            <div class="input-group-prepend">
               <span class="input-group-text" id="basic-addon1"><img src="<?php echo base_url(); ?>assets/mobile/images/phone.png" /></span>
            </div>
            <input type="text" class="form-control otp-fld" oninput="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="contact-no" aria-describedby="basic-addon1" autofocus >
         </div>
         <div id="contact-no-error">&nbsp;</div>
         <a href="javascript:void(0)" id="sign-in-btn" class="otp-btn">Verify</a>
      </div>
   </div>
</section>

<script src="<?php echo base_url(); ?>assets/custom-js/login/candidate-login.js"></script>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.4.1.slim.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/mobile/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mobile/js/bootstrap.min.js"></script>
</body>
</html>