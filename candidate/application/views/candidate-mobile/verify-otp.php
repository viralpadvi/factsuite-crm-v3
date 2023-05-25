<script>
   if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
      window.location = '<?php echo $this->config->item('my_base_url')?>'+'factsuite-candidate/sign-in';
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

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/toastr/toastr.min.css">

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
         <h1>Please enter the OTP</h1>
         <span>An OTP send to your phone number</span>
      </div>
      <div class="otp-frm">
         <div class="input-group text-center">
            <label>OTP</label>
            <div class="sign-bx">
               <div>
                  <input type="number" class="sign-fld" id="otp1" maxlength="1" onkeyup="moveOnMax(this,'otp2')" autofocus >
               </div>
               <div>
                  <input type="number" class="sign-fld" id="otp2" maxlength="1" onkeyup="moveOnMax(this,'otp3')" >
               </div>
               <div>
                  <input type="number" class="sign-fld" id="otp3" maxlength="1" onkeyup="moveOnMax(this,'otp4')" >
               </div>
               <div>
                  <input type="number" class="sign-fld" id="otp4" maxlength="1" onkeyup="moveOnMax(this,'otp5')" >
               </div>
            </div>
            <div id="invelid-otp-error"></div> 
            <div class="resend-bx">
               <div class="otp-sec" id="otp-sec"></div>
            </div>
         </div>
         <a href="javascript:void(0)" id="sign-in-btn" class="otp-btn">Submit</a>
      </div>
   </div>
</section>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="<?php echo base_url(); ?>assets/mobile/js/jquery-3.4.1.slim.min.js"></script> -->

<script src="<?php echo base_url(); ?>assets/custom-js/login/candidate-otp.js"></script>

<script src="<?php echo base_url(); ?>assets/mobile/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mobile/js/bootstrap.min.js"></script>

<script src="<?php echo base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/toastr/toastr.min.js"></script>

<script>
function moveOnMax(field,nextFieldID) {
   if(field.value.length >= field.maxLength) {
      document.getElementById(nextFieldID).focus();
   }
}
</script>
<script>
var timeLeft = time_on_first_page_load = 10;
var elem = document.getElementById('sec-time');
var timerId = setInterval(countdown, 1000);

function countdown() {
   if (timeLeft == 0) {
      clearTimeout(timerId);
      show_resend_otp_btn();
   } else {
      $('#otp-sec').html('Resend OTP in <span id="sec-time">'+timeLeft+' sec</span>');
      // elem.innerHTML = timeLeft + ' sec';
      timeLeft--;
   }
}

function show_resend_otp_btn() {
   $('#otp-sec').html('<div class="otp-resend text-right"><a href="javascript:void(0)" onclick="resend_otp()" id="resend-btn">Resend OTP</a></div>');
}

function resend_otp() {
   $('#resend-btn').removeAttr('onclick');
   $('#resend-btn').html('Resending the OTP');
   $.ajax({
      type: "POST",
      url: base_url+"candidate/resend-otp",
      data: {
         verify_candidate_request : 1
      },
      dataType: 'json',
      success: function(data) {
         if (data.status == '1') {
            toastr.success('OTP has been sent to the registered mail id and mobile number. Please enter the same OTP');
            time_on_first_page_load = timeLeft = time_on_first_page_load + 10;
            timerId = setInterval(countdown, 1000);
         } else {
            $('#resend-btn').html('Resend OTP');
            $('#resend-btn').attr('onclick','resend_otp()');
            toastr.error('Something went wrong while resending the OTP. Please try again.');   
         }
      }
   });
}
</script>
</body>
</html>