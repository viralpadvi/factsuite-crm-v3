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
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mobile/css/style.css">
<title>Fact Suite - Candidate</title>
</head>
<body>
<section id="hm">
   <div class="otp-lft">
      <div class="otp-bnr"><img src="<?php echo base_url(); ?>assets/mobile/images/otp-banner.png"></div>
      <div class="otp-txt">
      <h1>Get Started</h1>
      But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happin No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.
      </div>
      <a href="<?php echo $this->config->item('my_base_url')?>m-sign-in" class="otp-btn">Sign in</a>
   </div>
</section>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.4.1.slim.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mobile/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mobile/js/bootstrap.min.js"></script>
</body>
</html>