   <!--Sidebar-->
   <div class="pg-side">
      <div class="pg-side-hd">
         <h3>Review</h3>
      </div>
      <div class="pg-side-bx">
         <div class="pg-side-txt">
            <h3><img src="<?php echo base_url(); ?>assets/images/email-icon.png" /> Email &amp; Phone</h3>
            <span>Email : <?php echo isset($user['email_id'])?$user['email_id']:''; ?></span>
            <span>Phone : +91 <?php echo isset($user['phone_number'])?$user['phone_number']:''; ?></span>
         </div>
      </div>
      <div class="pg-side-bx">
         <div class="pg-side-txt">
            <h3><img src="<?php echo base_url(); ?>assets/images/employee-icon.png" /> Personal Information</h3>
            <span>F Name : <?php echo isset($user['first_name'])?$user['first_name']:''; ?></span>
            <span>L Name : <?php echo isset($user['last_name'])?$user['last_name']:''; ?></span>
            <span>DOB : <?php echo isset($user['date_of_birth'])?$user['date_of_birth']:''; ?></span>
            <span>Gender : <?php echo isset($user['gender'])?$user['gender']:''; ?></span>
         </div>
      </div>
   </div>
   <!--Sidebar-->