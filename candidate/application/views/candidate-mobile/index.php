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
<title>FactSuite - Candidate</title>

<link rel="icon" href="<?php echo base_url()?>assets/images/fs-icon-transparent.png">

<script>
  var base_url = "<?php echo $this->config->item('my_base_url')?>";
  var img_base_url = "<?php echo base_url()?>";
</script>

</head>
<body>
<div class="centered">
   <img src="<?php echo base_url(); ?>assets/mobile/images/FactSuite-logo.png" />
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.4.1.slim.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mobile/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mobile/js/bootstrap.min.js"></script>
<script>
    function pageRedirect() {
        window.location.replace(base_url+"m-get-started");
    }      
    setTimeout("pageRedirect()", 3000);
</script>
</body>
</html>