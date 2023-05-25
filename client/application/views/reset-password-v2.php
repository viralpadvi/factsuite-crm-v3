<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Factsuite Client</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?php echo base_url()?>assets/images/fs-icon-transparent.png">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <!-- Google Font: Rubik -->
  <link href='https://fonts.googleapis.com/css?family=Rubik' rel='stylesheet'>
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/toastr/toastr.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/client/assets-v2/dist/css/login-v2.css">
  <style type="text/css">
    .logo-img-div {
      margin-bottom: 40px;
    }

    .reset-pswd-txt {
      color: #3d2580;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-5">
        <div id="demo" class="carousel slide" data-ride="carousel">
          <!-- The slideshow -->
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="img-top-desc">Welcome To Factsuite</div>
              <div class="text-center">
                <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/login-carousel-img-1.png" alt="Factsuite">
              </div>
              <div class="img-btm-desc">Keeping our ethos at the center of everything we do drives everything we do</div>
              <div class="learn-more-btn-div">
                <a href="javascript:void(0)" class="learn-more-btn">Learn More</a>
              </div>
            </div>
            <div class="carousel-item">
              <div class="img-top-desc">Welcome To Factsuite</div>
              <div class="text-center">
                <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/login-carousel-img-1.png" alt="Factsuite">
              </div>
              <div class="img-btm-desc">Keeping our ethos at the center of everything we do drives everything we do</div>
              <div class="learn-more-btn-div">
                <a href="javascript:void(0)" class="learn-more-btn">Learn More</a>
              </div>
            </div>
            <div class="carousel-item">
              <div class="img-top-desc">Welcome To Factsuite</div>
              <div class="text-center">
                <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/login-carousel-img-1.png" alt="Factsuite">
              </div>
              <div class="img-btm-desc">Keeping our ethos at the center of everything we do drives everything we do</div>
              <div class="learn-more-btn-div">
                <a href="javascript:void(0)" class="learn-more-btn">Learn More</a>
              </div>
            </div>
            <div class="carousel-item">
              <div class="img-top-desc">Welcome To Factsuite</div>
              <div class="text-center">
                <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/login-carousel-img-1.png" alt="Factsuite">
              </div>
              <div class="img-btm-desc">Keeping our ethos at the center of everything we do drives everything we do</div>
              <div class="learn-more-btn-div">
                <a href="javascript:void(0)" class="learn-more-btn">Learn More</a>
              </div>
            </div>
          </div>
          <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
            <li data-target="#demo" data-slide-to="3"></li>
          </ul>
        </div>
      </div>
      <div class="col-md-6">
        <div class="login-card">
          <div class="logo-img-div">
            <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/factsuite-logo.png" alt="Factsuite Logo">
            <img class="mt-3" src="<?php echo base_url()?>assets/client/assets-v2/dist/img/fs-slogan.png" alt="Factsuite Slogan">
          </div>
          <div id="login-ui-div">
            <h4 class="reset-pswd-txt">Reset Password</h4>
            <div class="login-details-div">
              <input class="login-field" type="password" placeholder="New Password" id="new-password">
              <div class="text-danger" id="new-password-error-msg-div"></div>
            </div>
            <div class="login-details-div">
              <input class="login-field" type="password" placeholder="Verify New Password" id="verify-new-password">
              <div class="text-danger" id="verify-new-password-error-msg-div"></div>
              <div class="text-danger" id="login-error"></div>
            </div>
            <div class="login-btn-div">
              <button class="login-btn" id="save-password-btn">Save</button>
            </div>
          </div>
          <div class="footer">
            Factsuite &copy; <?php echo date("Y");?>. All rights reserved.
          </div> 
        </div>
      </div>
    </div>
  </div>
  <!-- jQuery -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script> -->
  <script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/custom-js/common-validation.js"></script>
  <script>
    var base_url = "<?php echo $this->config->item('my_base_url')?>",
        live_ui_version = "<?php echo $this->config->item('live_ui_version')?>",
        img_base_url = "<?php echo base_url()?>",
        email_id = '<?php echo $email_id;?>',
        encoded_date = '<?php echo $encoded_date;?>';
  </script>
  <!-- custom-js -->
  <script src="<?php echo base_url(); ?>assets/custom-js/login/reset-pasword.js"></script>
  <script src="<?php echo base_url(); ?>assets/custom-js/common-validation.js"></script>
  <script src="<?php echo base_url()?>assets/plugins/toastr/toastr.min.js"></script>
</body>
</html>