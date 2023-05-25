<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Factsuite</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?php echo base_url()?>assets/images/fs-icon-transparent.png">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <!-- Google Font: Rubik -->
  <link href='https://fonts.googleapis.com/css?family=Rubik' rel='stylesheet'>
  <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/toastr/toastr.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo base_url()?>assets/assets-v2/dist/css/login-v2.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <!-- <div class="col-md-1"></div> -->
      <div class="col-md-6">
        <div id="demo" class="carousel slide" data-ride="carousel">
          <!-- The slideshow -->
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="img-top-desc">Welcome To FactSuite</div>
              <div class="text-center">
                <img src="<?php echo base_url()?>assets/assets-v2/dist/img/login-carousel-img-1.png" alt="Factsuite">
              </div>
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-11">
                  <div class="img-btm-desc pl-2">One Stop Solution for All Your Authentication & Verification Needs</div>
                  <div class="learn-more-btn-div pl-2">
                    <a href="javascript:void(0)" class="learn-more-btn">Learn More</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="img-top-desc">Welcome To FactSuite</div>
              <div class="text-center">
                <img src="<?php echo base_url()?>assets/assets-v2/dist/img/login-carousel-img-1.png" alt="Factsuite">
              </div>
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-11">
                  <div class="img-btm-desc pl-2">One Stop Solution for All Your Authentication & Verification Needs</div>
                  <div class="learn-more-btn-div pl-2">
                    <a href="javascript:void(0)" class="learn-more-btn">Learn More</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="img-top-desc">Welcome To FactSuite</div>
              <div class="text-center">
                <img src="<?php echo base_url()?>assets/assets-v2/dist/img/login-carousel-img-1.png" alt="Factsuite">
              </div>
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-11">
                  <div class="img-btm-desc pl-2">One Stop Solution for All Your Authentication & Verification Needs</div>
                  <div class="learn-more-btn-div pl-2">
                    <a href="javascript:void(0)" class="learn-more-btn">Learn More</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="img-top-desc">Welcome To FactSuite</div>
              <div class="text-center">
                <img src="<?php echo base_url()?>assets/assets-v2/dist/img/login-carousel-img-1.png" alt="Factsuite">
              </div>
              <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-11">
                  <div class="img-btm-desc pl-2">One Stop Solution for All Your Authentication & Verification Needs</div>
                  <div class="learn-more-btn-div pl-2">
                    <a href="javascript:void(0)" class="learn-more-btn">Learn More</a>
                  </div>
                </div>
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
            <img src="<?php echo base_url()?>assets/assets-v2/dist/img/factsuite-logo.png" alt="Factsuite Logo">
            <img class="mt-3" src="<?php echo base_url()?>assets/assets-v2/dist/img/fs-slogan.png" alt="Factsuite Slogan">
            <!-- <span>Better Decisions, Made Easy</span> -->
          </div>
          <div id="login-ui-div">
            <div class="login-details-div">
              <input class="login-field" type="text" placeholder="Enter your Email ID" id="sign-in-email" autofocus>
              <div class="text-danger" id="login-email-error"></div>
            </div>
            <div class="login-details-div">
              <input class="login-field" type="password" placeholder="Enter your Password" id="sign-in-password">
              <div class="text-danger" id="login-password-error"></div>
              <div class="text-danger" id="login-error"></div>
            </div>
            <div class="row">
              <div class="col-md-6"></div>
              <div class="col-md-6 text-right">
                <a class="forgot-pswd-a" href="javascript:void(0)" id="forgot-password-toggle-btn">Forgot Password?</a>
              </div>
            </div>
            <div class="login-btn-div">
              <button class="login-btn" id="sign-in-btn">Login</button>
            </div>
          </div>
          <div id="forgot-password-ui-div" class="d-none">
            <div class="login-details-div">
              <input class="login-field" type="text" placeholder="Enter your Email ID" id="forgot-password-email-id">
              <div class="text-danger" id="forgot-password-email-id-error-msg-div"></div>
            </div>
            <div class="row">
              <div class="col-md-12 text-right">
                Remember your password? <a class="forgot-pswd-a" href="javascript:void(0)" id="sign-in-toggle-btn">Sign In</a>
              </div>
            </div>
            <div class="login-btn-div">
              <button class="login-btn" id="verify-email-btn">Submit</button>
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
    var base_url = "<?php echo $this->config->item('my_base_url')?>";
    var live_ui_version = "<?php echo $this->config->item('live_ui_version')?>";
    var img_base_url = "<?php echo base_url()?>";
  </script>
  <!-- custom-js -->
  <script src="<?php echo base_url();?>assets/custom-js/login/crm-login.js"></script>
  <script src="<?php echo base_url();?>assets/custom-js/login/forgot-password-v2.js"></script>
  <script src="<?php echo base_url()?>assets/plugins/toastr/toastr.min.js"></script>
</body>
</html>