<?php 
$data = $this->outPutQcModel->getSingleAssignedCaseDetails($candidate_id);  
$form_values = json_decode($candidate_data[0]['candidaetData']['form_values'],true);
$form_values = json_decode($form_values,true); 
$cancel =  base_url().'assets/admin/images/marks/cancel-16.png';
$check16px =  '<img src="'.base_url().'assets/admin/images/marks/check16px.png" >';
$green_img = base_url().'assets/admin/images/marks/green.png';
$verifiy_img = base_url().'assets/admin/images/marks/verify.png';



$form_analyst_status = array();
if (count($data) > 0) { 
    foreach ($data as $kc => $comp) {
        array_push($form_analyst_status, isset($comp['component_data']['analyst_status'])?$comp['component_data']['analyst_status']:0);
    }
}
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$text_status = "GREEN REPORT";
if (in_array('7', $form_analyst_status)) {
   $color_code = '#C50C0C';
    $bgcolor_code = '#eedcdc'; 
    $green_img = base_url().'assets/admin/images/marks/red.png';
    $text_status = "RED REPORT";
}else if(array_intersect(['6','9'], $form_analyst_status)){
    $color_code = '#1F7705';
    $bgcolor_code = '#FFD4AE';
    $green_img = base_url().'assets/admin/images/marks/orange.png';
    $text_status = "ORANGE REPORT";
}else if(in_array('0', $form_analyst_status)){
    // $color_code = '#1F7705';

     $color_code = '#FFFF00';
    // $bgcolor_code = '#FAFAD2';  
    $bgcolor_code = '#FFD4AE';
    $green_img = base_url().'assets/admin/images/marks/yellow.png';
    $text_status = "YELLOW REPORT";
}else{
  $color_code = '#1F7705';
    $bgcolor_code = '#C5FCB4';  
    $text_status = "GREEN REPORT";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>factsuite-report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css">
    <script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        body{font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto';}
        
        .border-left-green {
            display: inline-block;
            position: relative;
        }
        .border-left-green:before {
            content: '';
            border-left: 4px solid #1F7705;
            position: absolute;
            height: 80%;
            left: 25px;
            top: 10%;
        }

    </style>
</head>
<body>
    <img style="display: block; margin-left: auto;margin-right: auto; width: 20%; margin-top: 50px;" src="<?php echo base_url(); ?>assets/admin/images/FactSuite-logo.png" alt="" srcset=""> 
    <p style="text-align: center; font-size: 30px; color: #100F0F; font-weight: bold; margin-top: 10px; margin-bottom: 0px;">
        Employee Background Verification <br> Final Report</p>
    <!-- <small style="float: right; font-size: 15px; font-weight: normal; margin-top: -20px; margin-right: 11%;">Page 1</small>  -->
    <br>
    <hr style=" background-color:#381653; height: 1px; margin-right:80px; margin-left: 80px;">
    <div style="background-color: #F59E1D;margin-top: 40px; margin-right:80px; margin-left: 80px; " >
       <div style="padding:35px;">
           <div style="color: #FFFFFF; font-weight: bold; font-size: 20px;"> <i style="color: white; margin-right: 15px;" class="fa fa-address-card" aria-hidden="true"></i> Case Details</div>

         <table style="margin-top: 25px; color: #ffffff;
         border-collapse: collapse;
         width: 100%;">
             <tr>
                 <td style="padding-bottom: 15px; width: 17%; font-size: 18px;">Case Reference No.</td>
                 <td style="padding-bottom: 15px;">:</td>
                 <td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;"><?php echo $candidate_data[0]['candidaetData']['candidate_id'];?></td>
                 <td style="padding-bottom: 15px; width: 17%; font-size: 18px;" >Date Requested</td>
                 <td style="padding-bottom: 15px;">:</td>
                 <td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;"><?php echo $candidate_data[0]['candidaetData']['created_date']; ?></td>
             </tr>
             <tr>
                <td style="padding-bottom: 15px; width: 16%; font-size: 18px;">Name Of Client</td>
                <td style="padding-bottom: 15px;">:</td>
                <td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;">Collabera</td>
                <td style="padding-bottom: 15px; width: 17%; font-size: 18px;" >Date Completed</td>
                <td style="padding-bottom: 15px;">:</td>
                <td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;"><?php echo $candidate_data[0]['candidaetData']['updated_date']; ?></td>
             </tr>
             <tr>
                <td  style="padding-bottom: 15px; width: 16%; font-size: 18px;">Name Of Candidate</td>
                <td style="padding-bottom: 15px;">:</td>
                 <td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;"><?php echo $candidate_data[0]['candidaetData']['first_name'].' '.$candidate_data[0]['candidaetData']['last_name']; ?></td>
                 <td  style="padding-bottom: 15px; width: 16%; font-size: 18px;">Date Of Birth</td>
                 <td style="padding-bottom: 15px;">:</td>
                 <td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;"><?php echo $candidate_data[0]['candidaetData']['date_of_birth']; ?></td>
             </tr>
             <tr>
                 <td style="padding-bottom: 15px; width: 16%; font-size: 18px;">Employee ID</td>
                 <td style="padding-bottom: 15px;">:</td>
                 <td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;"><?php echo $candidate_data[0]['candidaetData']['employee_id']; ?></td>
                 <td style="padding-bottom: 15px; width: 16%; font-size: 18px;">Date of Joining</td>
                 <td style="padding-bottom: 15px;">:</td>
                 <td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;"><?php echo $candidate_data[0]['candidaetData']['date_of_joining']; ?></td>
             </tr>
            <tr>
                <td style="padding-bottom: 15px; width: 16%; font-size: 18px;">Father's Name</td>
                <td style="padding-bottom: 15px;">:</td>
                <td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;"><?php echo $candidate_data[0]['candidaetData']['father_name']; ?></td>
            </tr>
         </table>
       </div>
    </div>
    <div style="padding: 35px; background-color: <?php echo $bgcolor_code; ?>;margin-top: 5px; margin-right:80px; margin-left: 80px; " >
        <div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Result Definitions</div>

        <table style="margin-top: 28px; border-collapse: collapse;
        width: 100%;">
            <tr>
                <td><button style="background-color: <?php echo $color_code; ?>; border: none; border-radius: 50px; color: #FFFFFF; font-size: 20px; font-weight: bold; padding: 25px 50px;width: 65%; margin-left: 50px;" ><?php echo $text_status; ?></button> </td>
                <td><button style="background-color: #D2D4D1; border: none; border-radius: 50px; color: #100F0F; font-size: 20px; font-weight: bold; padding: 25px 50px;width: 65%;  margin-left: 70px;" >Verified Clear</button> </td>
            </tr>
        </table>
    </div>
    <div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3;margin-top: 5px; margin-right:80px; margin-left: 80px; " >
        <div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Executive Summary</div>
        
        <table style="margin-top: 25px;
        border-collapse: collapse;
        width: 100%;">
            <tr>
                <td style="padding-bottom: 15px; width: 15%; font-size: 18px; color: #100F0F;">Overall Status</td>
                <td style="padding-bottom: 15px;">:</td>
                <td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;">Completed</td>
            </tr>
        </table>
        <table style="margin-top: 25px; color: #ffffff;
        border-collapse: collapse;
        width: 100%;">
            <tr style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: bold;">
                <th style="padding: 12px 0px 12px 25px;">Component Type</th>
                <!-- <th>Component Detail</th> -->
                <th>Status</th>
                <th>Result</th>
            </tr>
            <tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">
                <?php 
                // print_r($data);
                foreach ($data as $key => $value) {
                    $status = '';
                    $verify ='';
                    $vstatus = isset($value['component_data']['analyst_status'])?$value['component_data']['analyst_status']:'0';
                    if ($vstatus == '0') { 
                             $status = '<span class="text-warning">Pending<span>'; 
                            $verify ='<span class="text-warning">Unable To Verify<span>';

                        }else if ($vstatus == '1') {
                             
                           $status = '<span class="text-info">Form Filled<span>'; 
                        $verify ='<span class="text-info">Unable To Verify<span>';

                        }else if ($vstatus == '2') {
                             
                            $status = '<span class="text-success">Approved<span>'; 
                        $verify ='<span class="text-success">Verified Clear<span>';
                        }else if ($vstatus == '3') {
                             
                            $status = '<span class="text-danger">Insufficiency<span>'; 
                        $verify ='<span class="text-danger">Unable To Verify<span>';
                        }else if ($vstatus == '4') {
                           
                            $status = '<span class="text-success">Approved<span>'; 
                        $verify ='<span class="text-success">Verified Clear<span>';
                        }else if ($vstatus == '5') {
                           
                            $status = '<span class="text-danger">Stop Checking</span>'; 
                            $verify ='<span class="text-danger">Unable To Verify</span>';
                        }else if ($vstatus == '6') {
                           
                            $status = '<span style="color:#FF8C00;">Unable to Verify</span>'; 
                            $verify ='<span style="color:#FF8C00;">Unable To Verify</span>';
                        }else if ($vstatus == '7') {
                           
                            $status = '<span style="color:red;">Verified Discrepancy</span>'; 
                            $verify ='<span style="color:red;">Unable To Verify</span>';
                        }else if ($vstatus == '8') {
                           
                            $status = 'Client clarification'; 
                            $verify ='Verified Clear';
                        }else if ($vstatus == '9') {
                           
                            $status = '<span style="color:#FF8C00;">Closed insufficiency</span>'; 
                            $verify ='<span style="color:#FF8C00;">Verified Clear</span>';

                        }else if ($vstatus == '10') {
                           
                            $status = 'QC-error'; 
                            $verify ='Verified Clear';
                        }else{

                            $status = 'Approved'; 
                            $verify ='Verified Clear';
                        } 
                ?>
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;"><?php echo $value['component_name']; ?></td>
                <!-- <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">BE</td> -->
                <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"><?php echo $status; ?></td>
                <td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold; font-size: 18px;" ><?php echo $verify; ?></td>
            </tr>
            <?php
                }
            ?>

<!-- 
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Last Employment</td>
                <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">Ramco System Limited</td>
                <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">Completed</td>
                <td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold; font-size: 18px;" >Verified Clear</td>
            </tr>
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Global Database</td>
                <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">Global Database</td>
                <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">Completed</td>
                <td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold; font-size: 18px;" >Verified Clear</td>
            </tr>
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Document Check</td>
                <td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">PAN Card</td>
                <td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">Completed</td>
                <td style="color: #1F7705; padding-bottom: 10px 0px; font-weight: bold; font-size: 18px;" >Verified Clear</td>
            </tr>
             -->
        </tbody>
        </table>
        <div style="margin-top: 40px; margin-right:80px; margin-left: 80px;text-align:center;">
            
         <a style="background-color:#1F7705; border: none; border-radius: 25px; color: #FFFFFF; font-size: 20px; font-weight: bold; padding: 25px 50px;float:center;" href="<?php echo $this->config->item('my_base_url').'outPutQc/pdf/'.$candidate_id; ?>">Download Report</a>
        </div>
    </div>


    <!-- above done -->

<?php
// print_r($table);

if (isset($table['criminal_checks']['criminal_check_id'])) {
    // print_r($table['criminal_checks']);

    $color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['criminal_checks']['analyst_status'])?$table['criminal_checks']['analyst_status']:0;
if ('7' == $analyst) {
   $color_code = '#C50C0C';
    $bgcolor_code = '#eedcdc'; 
    $string_status = 'Unable To Verify';
    $status = 'Verified Discrepancy';
    $green_img = base_url().'assets/admin/images/marks/red.png';
}else if(in_array($analyst,['6','9'])){
    $color_code = '#FF8C00';
    $bgcolor_code = '#FFD4AE';
    $string_status = 'Unable To Verify';
    $status = 'Unable to Verify';
    $green_img = base_url().'assets/admin/images/marks/orange.png';
}else if($analyst == '4'){
    $color_code = '#1F7705';
    $bgcolor_code = '#C5FCB4';
    $string_status = 'Verified Clear';
    $status = 'Completed';
}else{
    $color_code = '#FFFF00';
    $bgcolor_code = '#FAFAD2'; 
    $string_status = 'Verified Pending';
    $status = 'Pending';
}

     $address = json_decode($table['criminal_checks']['address'],true); 
     $re_address = json_decode($table['criminal_checks']['remark_address'],true); 
     $states = json_decode($table['criminal_checks']['state'],true);
     $re_states = json_decode($table['criminal_checks']['remark_state'],true);
     $pin_code = json_decode($table['criminal_checks']['pin_code'],true);
     $re_pin_code = json_decode($table['criminal_checks']['remark_pin_code'],true);
     $city = json_decode($table['criminal_checks']['city'],true); 
     $re_city = json_decode($table['criminal_checks']['remark_city'],true); 
     $verification_remarks = json_decode($table['criminal_checks']['verification_remarks'],true); 
    



   ?>
 <!--  -->

    <div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px; " >
        <div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Criminal Status</div>
        
        <table style="margin-top: 25px;
        border-collapse: collapse;
        width: 100%;">
            <tr>
                <td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>
                <td style="padding-bottom: 15px;">:</td>
                <td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;"><?php echo $status ?></td>
            </tr>
        </table>

        <?php 
         $remarks ='';
            foreach ($address as $key => $value) { 
                // $remarks = isset( $verification_remarks[$key][' verification_remarks']);

                $remarks = isset($verification_remarks[$key][' verification_remarks'])?$verification_remarks[$key][' verification_remarks']:'-'; 
             $city_sub = isset($city[$key]['city'])?$city[$key]['city']:"-";
             $re_city_sub = isset($re_city[$key]['city'])?$re_city[$key]['city']:"-";
             $address_sub = isset($value['address'])?$value['address']:"-";
             $re_address_sub = isset($re_address[$key]['address'])?$re_address[$key]['address']:"-";
             $state_sub = isset($states[$key]['state'])?$states[$key]['state']:"-";
             $re_state_sub = isset($re_states[$key]['state'])?$re_states[$key]['state']:"-";
             $pincode_sub = isset($pin_code[$key]['pincode'])?$pin_code[$key]['pincode']:"-";
             $re_pincode_sub = isset($re_pin_code[$key]['pincode'])?$re_pin_code[$key]['pincode']:"-";
             $Address_title_name = "Address";
             $City_title_name = "City";
             $State_title_name = "State";
             $Pincode_title_name = "Pincode";

              $address_img = $check16px;
                $states_img = $check16px;
                $pin_code_img = $check16px;
                $city_img = $check16px;

                     if (strtolower($address_sub) != strtolower($re_address_sub)) {
                         // $address_img = $cancel;
                         $address_img = $re_address_sub;
                        // echo strtolower($address_sub); 
                        // echo strtolower($re_address_sub);
                        // $address_sub = $re_address_sub;
                     }
                    if (strtolower($state_sub) !=strtolower($re_state_sub)) {
                        $states_img = $re_state_sub;
                        // $state_sub = $re_state_sub;
                    }
                    if (strtolower($pincode_sub) != strtolower($re_pincode_sub)) {
                        $pin_code_img = $re_pincode_sub;
                    }
                    if (strtolower($city_sub) !=strtolower($re_city_sub)) {
                        $city_img =  $re_city_sub;
                    }
        ?>

        <table style="margin-top: 25px; color: #ffffff;
        border-collapse: collapse;
        width: 100%;">
            <tr>
                <th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>
                <th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>
                <th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>
                <th style="background-color: <?php echo $color_code ?>; color: #ffffff; text-align: center; font-size: 18px; font-weight: normal;"><?php echo $string_status ?></th>
            </tr>
            <tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Address</td>
                <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"><?php echo $address_sub; ?></td>
                <td></td>
                <td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><?php echo $address_img; ?></i></td>
            </tr>
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">City</td>
                <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"><?php echo $city_sub; ?></td>
                <td></td>
                <td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><?php echo $city_img; ?></td>
            </tr>
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">State</td>
                <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"><?php echo $state_sub; ?></td>
                <td></td>
                <td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><?php echo $states_img; ?></td>
            </tr>
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Pincode</td>
                <td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;"><?php echo $pincode_sub; ?></td>
                <td></td>
                <td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><?php echo $pin_code_img; ?></td>
            </tr>
             
        </tbody>
        </table>

            <?php
                }
            ?>

        <table style="margin-top: 40px; margin-left: 25px;
        border-collapse: collapse;
        width: 100%;">
            <tr>
                <!-- <td style="padding-bottom: 20px;color: #171515; width: 16%; font-size: 18px;">Verifier's Name</td>
                <td style="padding-bottom: 20px; width: 3%;">:</td>
                <td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 20px;">Dr.M.Venkatesan</td> -->
                <td style="padding-bottom: 20px; color: #171515; width: 17%; font-size: 18px;" >Verifier's Remarks</td>
                <td style="padding-bottom: 20px; width: 3%;">:</td>
                <td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 20px;"><?php echo $remarks; ?></td>
            </tr>
           <tr>
               <td style="padding-bottom: 15px; color: #171515; width: 16%; font-size: 18px;">Verified Date</td>
               <td style="padding-bottom: 15px; width: 3%;">:</td>
               <td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 20px;"><?php echo $table['criminal_checks']['updated_date']; ?></td>
           </tr>
        </table>
    </div>
     <div style="margin-top: 70px; margin-right:80px; margin-left: 80px;">
        <p style="font-size:13px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
    </div>

    <!--  -->
   <?php
}

if (isset($table['court_records']['court_records_id'])) {


$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['court_records']['analyst_status'])?$table['court_records']['analyst_status']:0;
$font_color = '#FFFFFF';
if ('7' == $analyst) {
   $color_code = '#C50C0C';
    $bgcolor_code = '#eedcdc'; 
    $string_status = 'Unable To Verify';
    $status = 'Verified Discrepancy';
    $green_img = base_url().'assets/admin/images/marks/red.png';
}else if(in_array($analyst,['6','9'])){
    $color_code = '#FFD4AE';
    $bgcolor_code = '#FFD4AE';
    $string_status = 'Unable To Verify';
    $status = 'Unable to Verify';
    $green_img = base_url().'assets/admin/images/marks/orange.png';
}else if($analyst == '4'){
    $color_code = '#1F7705';
    $bgcolor_code = '#C5FCB4';
    $string_status = 'Verified Clear';
    $status = 'Completed';
}else{
    $color_code = '#FFFF00';
    $bgcolor_code = '#FAFAD2'; 
    $string_status = 'Verified Pending';
    $status = 'Pending';
    $font_color = '#000000';
}

    // print_r($table['court_records']);
        $address = json_decode($table['court_records']['address'],true); 
     $re_address = json_decode($table['court_records']['remark_address'],true); 
     $states = json_decode($table['court_records']['state'],true);
     $re_states = json_decode($table['court_records']['remark_state'],true);
     $pin_code = json_decode($table['court_records']['pin_code'],true);
     $re_pin_code = json_decode($table['court_records']['remark_pin_code'],true);
     $city = json_decode($table['court_records']['city'],true); 
     $re_city = json_decode($table['court_records']['remark_city'],true); 
     $verification_remarks = json_decode($table['court_records']['verification_remarks'],true); 
   ?>
 <!--  -->

    <div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px; " >
        <div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Court Record</div>
        
        <table style="margin-top: 25px;
        border-collapse: collapse;
        width: 100%;">
            <tr>
                <td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>
                <td style="padding-bottom: 15px;">:</td>
                <td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;"><?php echo $status; ?></td>
            </tr>
        </table>
            <?php 
            $verifier = '-';
            foreach ($address as $key => $value) { 
                $verifier = isset($verifier_name[$key]['verification_remarks'])?$verifier_name[$key]['verification_remarks']:'';

$verification_remark = '-';
$court_city = isset($city[$key]['city'])?$city[$key]['city']:'-'; 
$re_court_city = isset($re_city[$key]['city'])?$re_city[$key]['city']:'-'; 
$court_address = isset($value['address'])?$value['address']:'-'; 
$re_court_address = isset($re_address[$key]['address'])?$re_address[$key]['address']:'-'; 
$court_state = isset($states[$key]['state'])?$states[$key]['state']:'-';
$re_court_state = isset($re_states[$key]['state'])?$re_states[$key]['state']:'-';
$court_pincode = isset($pin_code[$key]['pincode'])?$pin_code[$key]['pincode']:'-'; 
$re_court_pincode = isset($re_pin_code[$key]['pincode'])?$re_pin_code[$key]['pincode']:'-'; 
$verification_remark = isset($verification_remarks[$key]['verification_remarks'])?$verification_remarks[$key]['verification_remarks']:'-';



  $address_img = $check16px;
    $states_img = $check16px;
    $pin_code_img = $check16px;
    $city_img = $check16px;

     if (strtolower($court_address) !=strtolower($re_court_address)) {
         $address_img =   $re_court_address;
     }
    if (strtolower($court_state) ==strtolower($re_court_state)) {
        $states_img = $re_court_state;
    }
    if (strtolower($court_pincode) ==strtolower($re_court_pincode)) {
        $pin_code_img = $re_court_pincode;
    }
    if (strtolower($court_city) ==strtolower($re_court_city)) {
        $city_img =  $re_court_city;
    }

        ?>
        <table style="margin-top: 25px; color: #ffffff;
        border-collapse: collapse;
        width: 100%;">
            <tr>
                <th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>
                <th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>
                <th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>
                <th style="background-color: <?php echo $color_code; ?>;color: <?php echo $font_color; ?>; text-align: center; font-size: 18px; font-weight: normal;"><?php echo $string_status; ?></th>
            </tr>
            <tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Address</td>
                <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"><?php echo $court_address; ?></td>
                <td></td>
                <td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><?php echo $address_img; ?></td>
            </tr>
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">City</td>
                <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"><?php echo $court_city; ?></td>
                <td></td>
                <td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><?php echo $city_img; ?></td>
            </tr>
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">State</td>
                <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"><?php echo $court_state; ?></td>
                <td></td>
                <td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><?php echo $states_img; ?></td>
            </tr>
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Pincode</td>
                <td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;"><?php echo $court_pincode; ?></td>
                <td></td>
                <td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><?php echo $pin_code_img; ?></i></td>
            </tr>
             
        </tbody>
        </table>
            <?php
                }
            ?>
        <table style="margin-top: 40px; margin-left: 25px;
        border-collapse: collapse;
        width: 100%;">
            <tr>
                <!-- <td style="padding-bottom: 20px;color: #171515; width: 16%; font-size: 18px;">Verifier's Name</td>
                <td style="padding-bottom: 20px; width: 3%;">:</td>
                <td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 20px;">Dr.M.Venkatesan</td> -->
                <td style="padding-bottom: 20px; color: #171515; width: 17%; font-size: 18px;" >Verifier's Remarks</td>
                <td style="padding-bottom: 20px; width: 3%;">:</td>
                <td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 20px;"><?php echo $verifier; ?></td>
            </tr>
           <tr>
               <td style="padding-bottom: 15px; color: #171515; width: 16%; font-size: 18px;">Verified Date</td>
               <td style="padding-bottom: 15px; width: 3%;">:</td>
               <td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 20px;"><?php echo $table['court_records']['updated_date']; ?></td>
           </tr>
        </table>
    </div>
     <div style="margin-top: 70px; margin-right:80px; margin-left: 80px;">
        <p style="font-size:13px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
    </div>

    <!--  -->
   <?php
}

if (isset($table['education_details']['education_details_id'])) {

 
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['education_details']['analyst_status'])?$table['education_details']['analyst_status']:0;
$font_color = '#FFFFFF';
if ('7' == $analyst) {
   $color_code = '#C50C0C';
    $bgcolor_code = '#eedcdc'; 
    $string_status = 'Unable To Verify';
    $status = 'Verified Discrepancy';
    $green_img = base_url().'assets/admin/images/marks/red.png';
}else if(in_array($analyst,['6','9'])){
    $color_code = '#FFD4AE';
    $bgcolor_code = '#FFD4AE';
    $string_status = 'Unable To Verify';
    $status = 'Unable to Verify';
    $green_img = base_url().'assets/admin/images/marks/orange.png';
}else if($analyst == '4'){
    $color_code = '#1F7705';
    $bgcolor_code = '#C5FCB4';
    $string_status = 'Verified Clear';
    $status = 'Completed';
}else{
    $color_code = '#FFFF00';
    $bgcolor_code = '#FAFAD2'; 
    $string_status = 'Verified Pending';
    $status = 'Pending';
    $font_color = '#000000';
}
    // print_r($table['education_details']);
    $type_of_degree = json_decode($table['education_details']['type_of_degree'],true);
            $major = json_decode($table['education_details']['major'],true);
            $university_board = json_decode($table['education_details']['university_board'],true);
            $college_school = json_decode($table['education_details']['college_school'],true);
            $address_of_college_school = json_decode($table['education_details']['address_of_college_school'],true);
            $course_start_date = json_decode($table['education_details']['course_start_date'],true);
            $course_end_date = json_decode($table['education_details']['course_end_date'],true);
            $type_of_course = json_decode($table['education_details']['type_of_course'],true);
            $registration_roll_number = json_decode($table['education_details']['registration_roll_number'],true);
            $verifier_name = json_decode($table['education_details']['remark_verifier_name'],true);
            $verification_remark = json_decode($table['education_details']['verification_remarks'],true);
            $remark_roll_no = json_decode($table['education_details']['remark_roll_no'],true);
            $remark_type_of_dgree = json_decode($table['education_details']['remark_type_of_dgree'],true);
            $remark_institute_name = json_decode($table['education_details']['remark_institute_name'],true);
            $remark_university_name = json_decode($table['education_details']['remark_university_name'],true);
            $remark_year_of_graduation = json_decode($table['education_details']['remark_year_of_graduation'],true);
            $approved_doc = json_decode($table['education_details']['approved_doc'],true);
            $approved_doc = array();
            if ($table['education_details']['approved_doc'] !='') { 
                $approved_doc = json_decode($table['education_details']['approved_doc'],true);
            }
           /* $type_of_degree = json_decode($table['education_details']['type_of_degree'],true);
            $major = json_decode($table['education_details']['major'],true);
            $university_board = json_decode($table['education_details']['university_board'],true);
            $college_school = json_decode($table['education_details']['college_school'],true);
            $address_of_college_school = json_decode($table['education_details']['address_of_college_school'],true);
            $course_start_date = json_decode($table['education_details']['course_start_date'],true);
            $course_end_date = json_decode($table['education_details']['course_end_date'],true);
            $type_of_course = json_decode($table['education_details']['type_of_course'],true);
            $registration_roll_number = json_decode($table['education_details']['registration_roll_number'],true);
            $verifier_name = json_decode($table['education_details']['remark_verifier_name'],true);
            $verification_remark = json_decode($table['education_details']['verification_remarks'],true);*/
   ?>
 <!--  -->

    <div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px; " >
        <div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i>  Education</div>
        
        <table style="margin-top: 25px;
        border-collapse: collapse;
        width: 100%;">
            <tr>
                <td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>
                <td style="padding-bottom: 15px;">:</td>
                <td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;"><?php echo $status; ?></td>
            </tr>
        </table>
       
             
             <?php 
             $vname = '';
             $verification_remarks ='';
                foreach ($type_of_degree as $key => $value) { 
                    // $vname = isset($verifier_name[$key]['verifier_name'])?$verifier_name[$key]['verifier_name']:'-';
                     // $verification_remarks = isset($verification_remark[$key]['verification_remarks'])?$verification_remark[$key]['verification_remarks']:'-';



        $vname = '';
        $verification_remarks ='';
        $vname = isset($verifier_name[$key]['verifier_name'])?$verifier_name[$key]['verifier_name']:'-';
        $verification_remarks = isset($verification_remark[$key]['verification_remarks'])?$verification_remark[$key]['verification_remarks']:'-';
        $type_of_degree_edu = $value['type_of_degree']; 
        $edu_major = isset($major[$key]['major'])?$major[$key]['major']:'-'; 
        $university_board_edu = isset($university_board[$key]['university_board'])?$university_board[$key]['university_board']:'-'; 
         $college_school_edu = isset($college_school[$key]['college_school'])?$college_school[$key]['college_school']:'-'; 
         $add = isset($address_of_college_school[$key]['address_of_college_school'])?$address_of_college_school[$key]['address_of_college_school']:'-';
         $start = isset($course_start_date[$key]['course_start_date'])?$course_start_date[$key]['course_start_date']:'-';
         $end = isset($course_end_date[$key]['course_end_date'])?$course_end_date[$key]['course_end_date']:'-';
         $course = isset($type_of_course[$key]['type_of_course'])?$type_of_course[$key]['type_of_course']:'-'; 
         $roll = isset($registration_roll_number[$key]['registration_roll_number'])?$registration_roll_number[$key]['registration_roll_number']:'-';


         $remark_rollno = isset($remark_roll_no[$key]['roll_number'])?$remark_roll_no[$key]['roll_number']:'-';
         $remark_type_dgree = isset($remark_type_of_dgree[$key]['type_of_degree'])?$remark_type_of_dgree[$key]['type_of_degree']:'-';
         $remark_institutename = isset($remark_institute_name[$key]['institute_name'])?$remark_institute_name[$key]['institute_name']:'-';
         $remark_universityname = isset($remark_university_name[$key]['university_name'])?$remark_university_name[$key]['university_name']:'-';
         $remark_year_ofgraduation = isset($remark_year_of_graduation[$key]['year_of_education'])?$remark_year_of_graduation[$key]['year_of_education']:'-';

        $start_end = $start.' - '.$end;
        $roll_img = $check16px;
        if (strtolower($roll) != strtolower($remark_rollno)) {
          $roll_img = $remark_rollno;
        }

        $type_of_degree_img = $check16px;
        if (strtolower($type_of_degree_edu) != strtolower($remark_type_dgree)) {
          $type_of_degree_img = $remark_type_dgree;
        }
        $university_img = $check16px;
        if (strtolower($university_board_edu) != strtolower($remark_universityname)) {
          $university_img = $remark_universityname;
        }
         $college_school_img = $check16px;
        if (strtolower($college_school_edu) != strtolower($remark_institutename )) {
          $college_school_img = $remark_institutename;   
        }


             ?>  

              <table style="margin-top: 25px; color: #ffffff;
        border-collapse: collapse;
        width: 100%;">
            <tr>
                <th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>
                <th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>
                <th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>
                <th style="background-color: <?php echo $color_code; ?>;color: <?php echo $font_color; ?>; text-align: center; font-size: 18px; font-weight: normal;"><?php echo $string_status; ?></th>
            </tr>
            <tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">



            
<?php
 $html = '';
    $html .='<tr>';
    $html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Type Of Qualification</td>';
    $html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$type_of_degree_edu.'</td>';
    $html .='<td></td>';
    $html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$type_of_degree_img.'</td>';
    $html .='</tr>';
    $html .='<tr>';
    $html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Major</td>';
    $html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$edu_major.'</td>';
    $html .='<td></td>';
    $html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
    $html .='</tr>';
    $html .='<tr>';
    $html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">University Board</td>';
    $html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$university_board_edu.'</td>';
    $html .='<td></td>';
    $html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$university_img.'</td>';
    $html .='</tr>';
    $html .='<tr>';
    $html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">School / College</td>';
    $html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$college_school_edu.'</td>';
    $html .='<td></td>';
    $html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$college_school_img.'</td>';
    $html .='</tr>';
    $html .='<tr>';
    $html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Address </td>';
    $html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$add.'</td>';
    $html .='<td></td>';
    $html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
    $html .='</tr> ';
    $html .='<tr>';
    $html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">DURATION OF COURSE</td>';
    $html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$start_end.'</td>';
    $html .='<td></td>';
    $html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
    $html .='</tr> ';
    $html .='<tr>';
    $html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Course Type</td>';
    $html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$course.'</td>';
    $html .='<td></td>';
    $html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
    $html .='</tr> ';
    $html .='<tr>';
    $html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Roll Number</td>';
    $html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$roll.'</td>';
    $html .='<td></td>';
    $html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$roll_img.'</td>';
    $html .='</tr>  '; 
    /*
    $html .='<tr>';
    $html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Roll Number</td>';
    $html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_rollno.'</td>';
    $html .='<td></td>';
    $html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
    $html .='</tr>  '; 

    $html .='<tr>';
    $html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Type Of Degree</td>';
    $html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_type_dgree.'</td>';
    $html .='<td></td>';
    $html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
    $html .='</tr>  '; 

    $html .='<tr>';
    $html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Institute Name</td>';
    $html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_institutename.'</td>';
    $html .='<td></td>';
    $html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
    $html .='</tr>  '; 
    */

    $html .='<tr>';
    $html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Years Of Education</td>';
    $html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_year_ofgraduation.'</td>';
    $html .='<td></td>';
    $html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
    $html .='</tr>  '; 

    /*
    $html .='<tr>';
    $html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark University Name</td>';
    $html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_universityname.'</td>';
    $html .='<td></td>';
    $html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
    $html .='</tr>  '; */
    $html .='</tbody>';
    $html .='</table>';

    echo $html;

                }
            ?>

        <table style="margin-top: 40px; margin-left: 25px;
        border-collapse: collapse;
        width: 100%;">
            <tr>
                <td style="padding-bottom: 20px;color: #171515; width: 16%; font-size: 18px;">Verifier's Name</td>
                <td style="padding-bottom: 20px; width: 3%;">:</td>
                <td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 20px;"><?php echo $vname; ?></td>
                <td style="padding-bottom: 20px; color: #171515; width: 17%; font-size: 18px;" >Verifier's Remarks</td>
                <td style="padding-bottom: 20px; width: 3%;">:</td>
                <td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 20px;">
                    <?php echo $verification_remarks; ?></td>
            </tr>
           <tr>
               <td style="padding-bottom: 15px; color: #171515; width: 16%; font-size: 18px;">Verified Date</td>
               <td style="padding-bottom: 15px; width: 3%;">:</td>
               <td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 20px;"><?php echo $table['education_details']['updated_date']; ?></td>
           </tr>
        </table>
    </div>

<?php

$html = '';
$all_marksheet = explode(',', $table['education_details']['all_sem_marksheet']);
if (!in_array('no-file', $all_marksheet) && count($all_marksheet) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center">All Sem Marksheet</h1>';

$max = 0;
 foreach ($all_marksheet as $key => $value) {
    $url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}


$convocation = explode(',', $table['education_details']['convocation']);
if (!in_array('no-file', $convocation) && count($convocation) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Convocation </h1>';

$max = 0;
 foreach ($convocation as $key => $value) {
    $url = base_url()."../uploads/convocation-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}


$marksheet_provisional_certificate = explode(',', $table['education_details']['marksheet_provisional_certificate']);
if (!in_array('no-file', $marksheet_provisional_certificate) && count($marksheet_provisional_certificate) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Convocation </h1>';

$max = 0;
 foreach ($marksheet_provisional_certificate as $key => $value) {
    $url = base_url()."../uploads/marksheet-certi-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}



$ten_twelve_mark_card_certificate = explode(',', $table['education_details']['ten_twelve_mark_card_certificate']);
if (!in_array('no-file', $ten_twelve_mark_card_certificate) && count($ten_twelve_mark_card_certificate) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Ten - Twelve Marksheet </h1>';

$max = 0;
 foreach ($ten_twelve_mark_card_certificate as $key => $value) {
    $url = base_url()."../uploads/ten-twelve-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}


// $ten_twelve_mark_card_certificate = explode(',', $table['education_details']['ten_twelve_mark_card_certificate']);
// echo json_encode($approved_doc);
if (count($approved_doc) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Remarks Documents </h1>';

$max = 0;
 foreach ($approved_doc as $key => $value){
     // print_r($value);
     if (is_array($value)) {
         
        foreach ($value as $key => $val) {
        
            $url = base_url()."../uploads/remarks-docs/".$val;
            $ext = pathinfo($val, PATHINFO_EXTENSION);
            if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

                $html .='<table style="margin-top: 25px;
                border-collapse: collapse;
                width: 100%;line-height:20px;">';
                $html .='<tr>'; 
                $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
                $html .='</tr>';
                $html .='</table>'; 
            $max++;
            }

        }

     }
 }

$html .='</div>';

}

echo $html;
    ?>
     <div style="margin-top: 70px; margin-right:80px; margin-left: 80px;">
        <p style="font-size:13px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
    </div>

    <!--  -->
   <?php
}

if (isset($table['current_employment']['current_emp_id'])) {
 $html ='';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['current_employment']['analyst_status'])?$table['current_employment']['analyst_status']:0;
$font_color = '#FFFFFF';
if ('7' == $analyst) {
   $color_code = '#C50C0C';
    $bgcolor_code = '#eedcdc'; 
    $string_status = 'Unable To Verify';
    $status = 'Verified Discrepancy';
    $green_img = base_url().'assets/admin/images/marks/red.png';
}else if(in_array($analyst,['6','9'])){
    $color_code = '#FFD4AE';
    $bgcolor_code = '#FFD4AE';
    $string_status = 'Unable To Verify';
    $status = 'Unable to Verify';
    $green_img = base_url().'assets/admin/images/marks/orange.png';
}else if($analyst == '4'){
    $color_code = '#1F7705';
    $bgcolor_code = '#C5FCB4';
    $string_status = 'Verified Clear';
    $status = 'Completed';
}else{
    $color_code = '#FFFF00';
    $bgcolor_code = '#FAFAD2'; 
    $string_status = 'Verified Pending';
    $status = 'Pending';
    $font_color = '#000000';
}

$html .='<br pagebreak="true" />';
    // print_r($table['current_employment']['verification_remarks']);
  
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px;" >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 18px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Current Employment</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 18px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 18px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';


$start = isset($table['current_employment']['joining_date'])?$table['current_employment']['joining_date']:'-';
$end = isset($table['current_employment']['relieving_date'])?$table['current_employment']['relieving_date']:'-'; 

$start_end = $start.' - '.$end;

 $desigination = isset($table['current_employment']['desigination'])?$table['current_employment']['desigination']:'-';  
 $department = isset($table['current_employment']['department'])?$table['current_employment']['department']:'-';  
 $employee_id = isset($table['current_employment']['employee_id'])?$table['current_employment']['employee_id']:'-'; 
 $company =  isset($table['current_employment']['company_name'])?$table['current_employment']['company_name']:'-';
 $addr =  isset($table['current_employment']['address'])?$table['current_employment']['address']:'-'; 
 $ctc =  isset($table['current_employment']['annual_ctc'])?$table['current_employment']['annual_ctc']:'-';
 $leave = isset($table['current_employment']['reason_for_leaving'])?$table['current_employment']['reason_for_leaving']:'-';
 $manager = isset($table['current_employment']['reporting_manager_name'])?$table['current_employment']['reporting_manager_name']:'-'; 
 $contact = isset($table['current_employment']['reporting_manager_contact_number'])?$table['current_employment']['reporting_manager_contact_number']:'-';  
 $designation =  isset($table['current_employment']['reporting_manager_desigination'])?$table['current_employment']['reporting_manager_desigination']:'-';  
 $hr_name = isset($table['current_employment']['hr_name'])?$table['current_employment']['hr_name']:'-';

 $hr_contact = isset($table['current_employment']['hr_contact_number'])?$table['current_employment']['hr_contact_number']:'-';

 $remark_date_of_relieving = isset($table['current_employment']['remark_date_of_relieving'])?$table['current_employment']['remark_date_of_relieving']:'-'; 
 $remark_exit_status = isset($table['current_employment']['remark_exit_status'])?$table['current_employment']['remark_exit_status']:'-'; 
 $remarks_designation = isset($table['current_employment']['remarks_designation'])?$table['current_employment']['remarks_designation']:'-'; 
 $remark_department = isset($table['current_employment']['remark_department'])?$table['current_employment']['remark_department']:'-'; 
 $remark_date_of_joining = isset($table['current_employment']['remark_date_of_joining'])?$table['current_employment']['remark_date_of_joining']:'-'; 
 $remark_salary_lakhs = isset($table['current_employment']['remark_salary_lakhs'])?$table['current_employment']['remark_salary_lakhs']:'-'; 
 $remark_salary_type = isset($table['current_employment']['remark_salary_type'])?$table['current_employment']['remark_salary_type']:'-'; 
 $remark_currency = isset($table['current_employment']['remark_currency'])?$table['current_employment']['remark_currency']:'-'; 
 $remark_eligible_for_re_hire = isset($table['current_employment']['remark_eligible_for_re_hire'])?$table['current_employment']['remark_eligible_for_re_hire']:'-'; 
 $remark_hr_name = isset($table['current_employment']['remark_hr_name'])?$table['current_employment']['remark_hr_name']:'-';  
 $remark_hr_email = isset($table['current_employment']['remark_hr_email'])?$table['current_employment']['remark_hr_email']:'-'; 
 $verification_remarks = isset($table['current_employment']['verification_remarks'])?$table['current_employment']['verification_remarks']:'-'; 
 $remark_hr_phone_no = isset($table['current_employment']['remark_hr_phone_no'])?$table['current_employment']['remark_hr_phone_no']:'-'; 
 $desigination_img = $check16px;
 if (strtolower($desigination) != strtolower($remarks_designation)) {
  $desigination_img = $remarks_designation;
 }

$department_img = $check16px;
 if (strtolower($department) != strtolower($remark_department)) {
  $department_img = $remark_department;
 }

 $ctc_img = $check16px;
 if (strtolower($ctc) != strtolower($remark_salary_lakhs)) {
  $ctc_img = $remark_salary_lakhs;
 }

 $hr_name_img = $check16px;
 if (strtolower($hr_name) != strtolower($remark_hr_name)) {
  $hr_name_img = $remark_hr_name;
 }


 $hr_contact_img = $check16px;
 if (strtolower($hr_contact) != strtolower($remark_hr_phone_no)) {
  $hr_contact_img = $remark_hr_phone_no;
 }


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Desigination</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$desigination.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$desigination_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Department</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$department.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$department_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Employee ID</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$employee_id.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Company Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$company.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Address</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$addr.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Annual CTC</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$ctc.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$ctc_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reason For Leaving</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$leave.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Joining - relieving Date</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reporting Manager Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$manager.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reporting Manager Designation</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$designation.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reporting Manager Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">HR Contact Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$hr_name.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$hr_name_img.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">HR Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$hr_contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$hr_contact_img.'</td>';
$html .='</tr>';



$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Date Of Relieving</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_date_of_relieving.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Exit Status</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_exit_status.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
/*
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remarks Designation</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remarks_designation.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
*/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Date Of Joining</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_date_of_joining.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Salary</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_salary_lakhs.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
*/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Salary Type</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_salary_type.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Currency</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_currency.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Eligible For Re-Hire</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_eligible_for_re_hire.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
/*
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark HR Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_hr_name.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
*/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark HR Email</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_hr_email.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Verification Remarks</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$verification_remarks.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';




     
$html .='</tbody>';
$html .='</table>';
$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
/*$html .='<tr>';
$html .='<td style="padding-bottom: 20px; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 18px;">'.$table['current_employment']['remark_hr_name'].'</td>';
$html .='<td style="padding-bottom: 20px;  width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 18px;">'.$table['current_employment']['verification_remarks'].'</td>';
$html .='</tr>';*/
$html .='<tr>';
$html .='<td style="padding-bottom: 15px;  width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 18px;">'.$table['current_employment']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';
echo $html;


$html ='';
$experience_relieving_letter = explode(',', $table['current_employment']['experience_relieving_letter']);
if (!in_array('no-file', $experience_relieving_letter) && count($experience_relieving_letter) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Experience Letter </h1>';

$max = 0;
 foreach ($experience_relieving_letter as $key => $value) {
    $url = base_url()."../uploads/experience_relieving_letter/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}


$last_month_pay_slip = explode(',', $table['current_employment']['last_month_pay_slip']);
if (!in_array('no-file', $last_month_pay_slip) && count($last_month_pay_slip) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Convocation </h1>';

$max = 0;
 foreach ($last_month_pay_slip as $key => $value) {
    $url = base_url()."../uploads/last_month_pay_slip/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}



$bank_statement_resigngation_acceptance = explode(',', $table['current_employment']['bank_statement_resigngation_acceptance']);
if (!in_array('no-file', $bank_statement_resigngation_acceptance) && count($bank_statement_resigngation_acceptance) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Bank Statement </h1>';

$max = 0;
 foreach ($bank_statement_resigngation_acceptance as $key => $value) {
    $url = base_url()."../uploads/bank_statement_resigngation_acceptance/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}


$approved_doc = explode(',', $table['current_employment']['approved_doc']);
if (count($approved_doc) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Remarks Documents </h1>';

$max = 0;
 foreach ($approved_doc as $key => $value){ 
    
        $url = base_url()."../uploads/remarks-docs/".$value;
        $ext = pathinfo($value, PATHINFO_EXTENSION);
        if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

            $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
            $html .='<tr>'; 
            $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
            $html .='</tr>';
            $html .='</table>'; 
        $max++;
        } 
 }

$html .='</div>';

}

echo $html;
?>
     <div style="margin-top: 70px; margin-right:80px; margin-left: 80px;">
        <p style="font-size:13px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
    </div>

    <!--  -->
   <?php
}

if (isset($table['document_check']['document_check_id'])) {  
    // print_r($table['document_check']['verification_remarks']);

 
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['document_check']['analyst_status'])?$table['document_check']['analyst_status']:0;
$font_color = '#FFFFFF';
if ('7' == $analyst) {
   $color_code = '#C50C0C';
    $bgcolor_code = '#eedcdc'; 
    $string_status = 'Unable To Verify';
    $status = 'Verified Discrepancy';
    $green_img = base_url().'assets/admin/images/marks/red.png';
}else if(in_array($analyst,['6','9'])){
    $color_code = '#FFD4AE';
    $bgcolor_code = '#FFD4AE';
    $string_status = 'Unable To Verify';
    $status = 'Unable to Verify';
    $green_img = base_url().'assets/admin/images/marks/orange.png';
}else if($analyst == '4'){
    $color_code = '#1F7705';
    $bgcolor_code = '#C5FCB4';
    $string_status = 'Verified Clear';
    $status = 'Completed';
}else{
    $color_code = '#FFFF00';
    $bgcolor_code = '#FAFAD2'; 
    $string_status = 'Verified Pending';
    $status = 'Pending';
    $font_color = '#000000';
}
   ?>
 <!--  -->

    <div style="padding: 35px 35px 45px 35px;background-color: <?php echo $color_code ?>;margin-top: 40px; margin-right:80px; margin-left: 80px; " >
        <div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Document Check</div>
        
        <table style="margin-top: 25px;
        border-collapse: collapse;
        width: 100%;">
            <tr>
                <td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>
                <td style="padding-bottom: 15px;">:</td>
                <td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;"><?php echo $status ?></td>
            </tr>
        </table>
        <table style="margin-top: 25px; color: #ffffff;
        border-collapse: collapse;
        width: 100%;">

            <tr>
                <th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>
                <th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>
                <th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>
                <th style="background-color: #1F7705;color: #ffffff; text-align: center; font-size: 18px; font-weight: normal;"><?php echo $string_status ?></th>
            </tr>
            <tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">

                <?php
                if (in_array(1, $form_values['document_check'])) { 
                ?>
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Aadhar Card</td>
                <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"><?php
                $aadhar = explode(',', isset($table['document_check']['adhar_doc'])?$table['document_check']['adhar_doc']:'');
                if (count($aadhar) > 0 && ! in_array('no-file', $aadhar)) {
                     foreach ($aadhar as $a => $adoc) {
                        $ext = pathinfo($adoc, PATHINFO_EXTENSION);
                        if (in_array($ext, array('jpg','jpeg','png'))) {   
                        echo "<div class='image-selected-div'><span>{$adoc}</span><a onclick='exist_view_image(\"{$adoc}\",\"aadhar-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                        }else{
                             echo "<div class='image-selected-div'><span>{$adoc}</span><a download href='".base_url()."aadhar-docs/{$adoc}' >  <i class='fa fa-arrow-down text-primary'></i></a></span></div>";
                        }
                     }
                }else{
                    echo "-";
                }
                ?></td>
                <td></td>
                <td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>
            </tr>
            <?php
            }
            ?>


            <?php
                if (in_array(2, $form_values['document_check'])) { 
                ?>
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Pan Card</td>
                <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"><?php
                $pancard = explode(',', isset($table['document_check']['pan_card_doc'])?$table['document_check']['pan_card_doc']:'');
                if (count($pancard) > 0 && ! in_array('no-file', $pancard)) {
                     foreach ($pancard as $pa => $pan) {
                        $ext = pathinfo($pan, PATHINFO_EXTENSION);
                        if (in_array($ext, array('jpg','jpeg','png'))) {   
                        echo "<div class='image-selected-div'><span>{$pan}</span><a onclick='exist_view_image(\"{$pan}\",\"pan-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                        }else{
                             echo "<div class='image-selected-div'><span>{$pan}</span><a download href='".base_url()."pan-docs/{$pan}' >  <i class='fa fa-arrow-down text-primary'></i></a></span></div>";
                        }
                     }
                }else{
                    echo "-";
                }
                ?></td>
                <td></td>
                <td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>
            </tr>
            <?php
            }
            ?>


            <?php
                if (in_array(3, $form_values['document_check'])) { 
                ?>
            <tr>
                <td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Passport</td>
                <td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"><?php
                $passport = explode(',', isset($table['document_check']['passport_doc'])?$table['document_check']['passport_doc']:'');
                if (count($passport) > 0 && ! in_array('no-file', $passport)) {
                     foreach ($passport as $pr => $pass) {
                        $ext = pathinfo($pass, PATHINFO_EXTENSION);
                        if (in_array($ext, array('jpg','jpeg','png'))) {   
                        echo "<div class='image-selected-div'><span>{$pass}</span><a onclick='exist_view_image(\"{$pass}\",\"proof-docs\")' >  <i class='fa fa-eye'></i></a></span></div>";
                        }else{
                             echo "<div class='image-selected-div'><span>{$pass}</span><a download href='".base_url()."proof-docs/{$pass}' >  <i class='fa fa-arrow-down text-primary'></i></a></span></div>";
                        }
                     }
                }else{
                    echo "-";
                }
                ?></td>
                <td></td>
                <td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>
            </tr>
            <?php
            }
            ?>
             
        </tbody>
        </table>
        <table style="margin-top: 40px; margin-left: 25px;
        border-collapse: collapse;
        width: 100%;">
            <tr>
                <?php 
                $verifier = json_decode($table['document_check']['verification_remarks'],true);
                ?>
               <!--  <td style="padding-bottom: 20px;color: #171515; width: 16%; font-size: 18px;">Verifier's Name</td>
                <td style="padding-bottom: 20px; width: 3%;">:</td>
                <td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 20px;">Dr.M.Venkatesan</td> -->
                <td style="padding-bottom: 20px; color: #171515; width: 17%; font-size: 18px;" >Verifier's Remarks</td>
                <td style="padding-bottom: 20px; width: 3%;">:</td>
                <td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 20px;"><?php echo isset($verifier['aadhar_verification_remarks'])?$verifier['aadhar_verification_remarks']:'-'; ?></td>
            </tr>
           <tr>
               <td style="padding-bottom: 15px; color: #171515; width: 16%; font-size: 18px;">Verified Date</td>
               <td style="padding-bottom: 15px; width: 3%;">:</td>
               <td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 20px;"><?php echo $table['document_check']['updated_date']; ?></td>
           </tr>
        </table>
    </div>
     <div style="margin-top: 70px; margin-right:80px; margin-left: 80px;">
        <p style="font-size:13px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
    </div>

    <!--  -->
   <?php
}

if (isset($table['drugtest']['drugtest_id'])) {

$html = '';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['drugtest']['analyst_status'])?$table['drugtest']['analyst_status']:0;
$font_color = '#FFFFFF';
if ('7' == $analyst) {
   $color_code = '#C50C0C';
    $bgcolor_code = '#eedcdc'; 
    $string_status = 'Unable To Verify';
    $status = 'Verified Discrepancy';
    $green_img = base_url().'assets/admin/images/marks/red.png';
}else if(in_array($analyst,['6','9'])){
    $color_code = '#FFD4AE';
    $bgcolor_code = '#FFD4AE';
    $string_status = 'Unable To Verify';
    $status = 'Unable to Verify';
    $green_img = base_url().'assets/admin/images/marks/orange.png';
}else if($analyst == '4'){
    $color_code = '#1F7705';
    $bgcolor_code = '#C5FCB4';
    $string_status = 'Verified Clear';
    $status = 'Completed';
}else{
    $color_code = '#FFFF00';
    $bgcolor_code = '#FAFAD2'; 
    $string_status = 'Verified Pending';
    $status = 'Pending';
    $font_color = '#000000';
}


    $html .='<br pagebreak="true" />';
   $candidate_name = json_decode($table['drugtest']['candidate_name'],true);
    $father_name = json_decode($table['drugtest']['father_name'],true);
    $dob = json_decode($table['drugtest']['dob'],true);
    $address = json_decode($table['drugtest']['address'],true);
    $remark_address = json_decode($table['drugtest']['remark_address'],true);
    $mobile_number = json_decode($table['drugtest']['mobile_number'],true); 
    $codes = json_decode($table['drugtest']['code'],true); 
    $verification_remarks = json_decode($table['drugtest']['verification_remarks'],true);
    // print_r($table['drugtest']);
   
   
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 18px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Drug Test</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 18px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';

foreach ($candidate_name as $key => $value) { 

$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 18px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';
 $vremark = '';
    $candidate = $value['candidate_name']; 
    $father =  isset($father_name[$key]['father_name'])?$father_name[$key]['father_name']:'-'; 
    $birth = isset($dob[$key]['dob'])?$dob[$key]['dob']:'-';
    $contact = isset($mobile_number[$key]['mobile_number'])?$mobile_number[$key]['mobile_number']:'-';
    $addresss = isset($address[$key]['address'])?$address[$key]['address']:'-';
    $remark_addresss = isset($remark_addresss[$key]['address'])?$remark_addresss[$key]['address']:'-';
    $vremark = isset($verification_remarks[$key]['verification_remarks'])?$verification_remarks[$key]['verification_remarks']:'-';
    $address_img = $check16px;
    if (strtolower($addresss) != strtolower($remark_addresss)) {
       $address_img = $remark_addresss;

    }
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Candidate Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$candidate.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Father\'s Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$father.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Date Of Birth</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$birth.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Contac Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Address</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$addresss.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$address_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$vremark.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='</tbody>';
$html .='</table>';

}

$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
// $html .='<tr>';
 /*$html .='<td style="padding-bottom: 20px; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 18px;"> </td>'; */
/*$html .='<td style="padding-bottom: 20px;  width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 18px;">'.$vremark.'</td>';
$html .='</tr>';*/
$html .='<tr>';
$html .='<td style="padding-bottom: 15px;  width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 18px;">'.$table['drugtest']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';
echo $html;
?>
     <div style="margin-top: 70px; margin-right:80px; margin-left: 80px;">
        <p style="font-size:13px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
    </div>

    <!--  -->
   <?php
}
 
 
if (isset($table['globaldatabase']['globaldatabase_id'])) {  

$html ='';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['globaldatabase']['analyst_status'])?$table['globaldatabase']['analyst_status']:0;
$font_color = '#FFFFFF';
if ('7' == $analyst) {
   $color_code = '#C50C0C';
    $bgcolor_code = '#eedcdc'; 
    $string_status = 'Unable To Verify';
    $status = 'Verified Discrepancy';
    $green_img = base_url().'assets/admin/images/marks/red.png';
}else if(in_array($analyst,['6','9'])){
    $color_code = '#FFD4AE';
    $bgcolor_code = '#FFD4AE';
    $string_status = 'Unable To Verify';
    $status = 'Unable to Verify';
    $green_img = base_url().'assets/admin/images/marks/orange.png';
}else if($analyst == '4'){
    $color_code = '#1F7705';
    $bgcolor_code = '#C5FCB4';
    $string_status = 'Verified Clear';
    $status = 'Completed';
}else{
    $color_code = '#FFFF00';
    $bgcolor_code = '#FAFAD2'; 
    $string_status = 'Verified Pending';
    $status = 'Pending';
    $font_color = '#000000';
}

// $html .='<br pagebreak="true" />';     
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 18px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Global Database</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 18px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 18px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';
$name =  isset($table['globaldatabase']['candidate_name'])?$table['globaldatabase']['candidate_name']:'-'; 
$qualification =  isset($table['globaldatabase']['father_name'])?$table['globaldatabase']['father_name']:'-'; 
$dob =  isset($table['globaldatabase']['dob'])?$table['globaldatabase']['dob']:'-'; 

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Candidate Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$name.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Qualification</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$qualification.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Date Of Birth</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$dob.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
 


$html .='</tbody>';
$html .='</table>';
$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
 /*$html .='<td style="padding-bottom: 20px; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 18px;"> </td>'; */
$html .='<td style="padding-bottom: 20px;  width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 18px;">'.$table['globaldatabase']['verification_remarks'].'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px;  width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 18px;">'.$table['globaldatabase']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';

echo $html;
?>
     <div style="margin-top: 70px; margin-right:80px; margin-left: 80px;">
        <p style="font-size:13px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
    </div>

    <!--  -->
   <?php
}

if (isset($table['permanent_address']['permanent_address_id'])) {

$html = '';

$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['permanent_address']['analyst_status'])?$table['permanent_address']['analyst_status']:0;
$font_color = '#FFFFFF';
if ('7' == $analyst) {
   $color_code = '#C50C0C';
    $bgcolor_code = '#eedcdc'; 
    $string_status = 'Unable To Verify';
    $status = 'Verified Discrepancy';
    $green_img = base_url().'assets/admin/images/marks/red.png';
}else if(in_array($analyst,['6','9'])){
    $color_code = '#FFD4AE';
    $bgcolor_code = '#FFD4AE';
    $string_status = 'Unable To Verify';
    $status = 'Unable to Verify';
    $green_img = base_url().'assets/admin/images/marks/orange.png';
}else if($analyst == '4'){
    $color_code = '#1F7705';
    $bgcolor_code = '#C5FCB4';
    $string_status = 'Verified Clear';
    $status = 'Completed';
}else{
    $color_code = '#FFFF00';
    $bgcolor_code = '#FAFAD2'; 
    $string_status = 'Verified Pending';
    $status = 'Pending';
    $font_color = '#000000';
}

$html .='<br pagebreak="true" />';     
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 18px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Permanent Address</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 18px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 18px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';

$flat_no =  isset($table['permanent_address']['flat_no'])?$table['permanent_address']['flat_no']:'-';
$street =  isset($table['permanent_address']['street'])?$table['permanent_address']['street']:'-';
$area =  isset($table['permanent_address']['area'])?$table['permanent_address']['area']:'-';
$city =  isset($table['permanent_address']['city'])?$table['permanent_address']['city']:'-';
$pin_code =  isset($table['permanent_address']['pin_code'])?$table['permanent_address']['pin_code']:'-';
$nearest_landmark =  isset($table['permanent_address']['nearest_landmark'])?$table['permanent_address']['nearest_landmark']:'-';
$state =  isset($table['permanent_address']['state'])?$table['permanent_address']['state']:'-'; 
$start = isset($table['permanent_address']['duration_of_stay_start'])?$table['permanent_address']['duration_of_stay_start']:'-';
$end =  isset($table['permanent_address']['duration_of_stay_end'])?$table['permanent_address']['duration_of_stay_end']:'-'; 
$person_mobile_number = isset($table['permanent_address']['contact_person_mobile_number'])?$table['permanent_address']['contact_person_mobile_number']:'-';
$person_name = isset($table['permanent_address']['contact_person_name'])?$table['permanent_address']['contact_person_name']:'-'; 
$relationship = isset($table['permanent_address']['contact_person_relationship'])?$table['permanent_address']['contact_person_relationship']:'-';
 
$remarks_address = isset($table['permanent_address']['remarks_address'])?$table['permanent_address']['remarks_address']:'-';
$remarks_city = isset($table['permanent_address']['remarks_city'])?$table['permanent_address']['remarks_city']:'-';
$remarks_pincode = isset($table['permanent_address']['remarks_pincode'])?$table['permanent_address']['remarks_pincode']:'-';

$remarks_state = isset($table['permanent_address']['remarks_state'])?$table['permanent_address']['remarks_state']:'-';
$staying_with = isset($table['permanent_address']['staying_with'])?$table['permanent_address']['staying_with']:'-';
$period_of_stay = isset($table['permanent_address']['period_of_stay'])?$table['permanent_address']['period_of_stay']:'-';

$property_type = isset($table['permanent_address']['property_type'])?$table['permanent_address']['property_type']:'-';

$verifier_name = isset($table['permanent_address']['verifier_name'])?$table['permanent_address']['verifier_name']:'-';

$remark_relationship = isset($table['permanent_address']['relationship'])?$table['permanent_address']['relationship']:'-';
$verification_remarks = isset($table['permanent_address']['verification_remarks'])?$table['permanent_address']['verification_remarks']:'-';

$start_end = $start.' - '.$end;
 $city_img = $check16px;
if (strtolower($city) != strtolower($remarks_city)) {
    $city_img = $remarks_city;
}

 $pin_code_img = $check16px;
if (strtolower($pin_code) != strtolower($remarks_pincode)) {
    $pin_code_img = $remarks_pincode;
}

 $state_img = $check16px;
if (strtolower($state) != strtolower($remarks_state)) {
    $state_img = $remarks_state;
}

$relationship_img = $check16px;
if (strtolower($relationship) != strtolower($remark_relationship)) {
    $relationship_img = $remark_relationship;
}



$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Flat No</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$flat_no.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Street / Road</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$street.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Area</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$area.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">City / Town</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$city.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$city_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Pin Code</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$pin_code.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$pin_code_img.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Nearest Landmark</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$nearest_landmark.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">State</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$state.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$state_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">DURATION OF STAY</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">CONTACT PERSON Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$person_mobile_number.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Person Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$person_name .'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Relationship</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$relationship.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$relationship_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remarks Address</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remarks_address.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
/*
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remarks City</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remarks_city.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remarks Pincode</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remarks_pincode.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remarks State</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remarks_state.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
*/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Stay with</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$staying_with.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Periods of stay</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$period_of_stay.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Property Type</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$property_type.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$verifier_name.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
/*
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Verifier\'s Relationship</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_relationship.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
*/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$verification_remarks.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

 
$html .='</tbody>';
$html .='</table>';
$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
// $html .='<tr>';
 /*$html .='<td style="padding-bottom: 20px; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 18px;"> </td>'; */
/*$html .='<td style="padding-bottom: 20px;  width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 18px;">'.$table['permanent_address']['verification_remarks'].'</td>';
$html .='</tr>';*/
$html .='<tr>';
$html .='<td style="padding-bottom: 15px;  width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 18px;">'.$table['permanent_address']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';

echo $html;


$rental_agreement = explode(',', $table['permanent_address']['rental_agreement']);
if (!in_array('no-file', $rental_agreement) && count($rental_agreement) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center">Rental Agreement</h1>';

$max = 0;
 foreach ($rental_agreement as $key => $value) {
    $url = base_url()."../uploads/rental-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}

$html ='';
$ration_card = explode(',', isset($table['permanent_address']['ration_card'])?$table['permanent_address']['ration_card']:'no-file');
if (!in_array('no-file', $ration_card) && count($ration_card) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Ration Card </h1>';

$max = 0;
 foreach ($ration_card as $key => $value) {
    $url = base_url()."../uploads/ration-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}


$gov_utility_bill = explode(',', isset($table['permanent_address']['gov_utility_bill'])?$table['permanent_address']['gov_utility_bill']:'no-file');
if (!in_array('no-file', $gov_utility_bill) && count($gov_utility_bill) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Goverment Utility Bill </h1>';

$max = 0;
 foreach ($gov_utility_bill as $key => $value) {
    $url = base_url()."../uploads/gov-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}

 

$approved_doc = explode(',', isset($table['permanent_address']['approved_doc'])?$table['permanent_address']['approved_doc']:'');
if (count($approved_doc) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Remarks Documents </h1>';

$max = 0;
 foreach ($approved_doc as $key => $value){
     // print_r($value);
     if (is_array($value)) {
         
        // foreach ($value as $key => $val) {
        
            $url = base_url()."../uploads/remarks-docs/".$value;
            $ext = pathinfo($value, PATHINFO_EXTENSION);
            if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

                $html .='<table style="margin-top: 25px;
                border-collapse: collapse;
                width: 100%;line-height:20px;">';
                $html .='<tr>'; 
                $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
                $html .='</tr>';
                $html .='</table>'; 
            $max++;
            }

        // }

     }
 }

$html .='</div>';

}
echo $html;
?>
     <div style="margin-top: 70px; margin-right:80px; margin-left: 80px;">
        <p style="font-size:13px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
    </div>

    <!--  -->
   <?php
}

if (isset($table['present_address']['present_address_id'])) {
$html ='';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['present_address']['analyst_status'])?$table['present_address']['analyst_status']:0;
$font_color = '#FFFFFF';
if ('7' == $analyst) {
   $color_code = '#C50C0C';
    $bgcolor_code = '#eedcdc'; 
    $string_status = 'Unable To Verify';
    $status = 'Verified Discrepancy';
    $green_img = base_url().'assets/admin/images/marks/red.png';
}else if(in_array($analyst,['6','9'])){
    $color_code = '#FFD4AE';
    $bgcolor_code = '#FFD4AE';
    $string_status = 'Unable To Verify';
    $status = 'Unable to Verify';
    $green_img = base_url().'assets/admin/images/marks/orange.png';
}else if($analyst == '4'){
    $color_code = '#1F7705';
    $bgcolor_code = '#C5FCB4';
    $string_status = 'Verified Clear';
    $status = 'Completed';
}else{
    $color_code = '#FFFF00';
    $bgcolor_code = '#FAFAD2'; 
    $string_status = 'Verified Pending';
    $status = 'Pending';
    $font_color = '#000000';
}

$html .='<br pagebreak="true" />';    
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 18px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Present Address</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 18px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 18px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';


$flat_no =  isset($table['present_address']['flat_no'])?$table['present_address']['flat_no']:'-';
$street =  isset($table['present_address']['street'])?$table['present_address']['street']:'-';
$area =  isset($table['present_address']['area'])?$table['present_address']['area']:'-';
$city =  isset($table['present_address']['city'])?$table['present_address']['city']:'-';
$pin_code =  isset($table['present_address']['pin_code'])?$table['present_address']['pin_code']:'-';
$nearest_landmark =  isset($table['present_address']['nearest_landmark'])?$table['present_address']['nearest_landmark']:'-';
$state =  isset($table['present_address']['state'])?$table['present_address']['state']:'-'; 
$start = isset($table['present_address']['duration_of_stay_start'])?$table['present_address']['duration_of_stay_start']:'-';
$end =  isset($table['present_address']['duration_of_stay_end'])?$table['present_address']['duration_of_stay_end']:'-'; 
$person_mobile_number = isset($table['present_address']['contact_person_mobile_number'])?$table['present_address']['contact_person_mobile_number']:'-';
$person_name = isset($table['present_address']['contact_person_name'])?$table['present_address']['contact_person_name']:'-'; 
$relationship = isset($table['present_address']['contact_person_relationship'])?$table['present_address']['contact_person_relationship']:'-';

$remarks_address = isset($table['present_address']['remarks_address'])?$table['present_address']['remarks_address']:'-';
$remarks_city = isset($table['present_address']['remarks_city'])?$table['present_address']['remarks_city']:'-';
$remarks_pincode = isset($table['present_address']['remarks_pincode'])?$table['present_address']['remarks_pincode']:'-';

$remarks_state = isset($table['present_address']['remarks_state'])?$table['present_address']['remarks_state']:'-';
$staying_with = isset($table['present_address']['staying_with'])?$table['present_address']['staying_with']:'-';
$period_of_stay = isset($table['present_address']['period_of_stay'])?$table['present_address']['period_of_stay']:'-';

$property_type = isset($table['present_address']['property_type'])?$table['present_address']['property_type']:'-';

$verifier_name = isset($table['present_address']['verifier_name'])?$table['present_address']['verifier_name']:'-';

$remark_relationship = isset($table['present_address']['relationship'])?$table['present_address']['relationship']:'-';
$verification_remarks = isset($table['present_address']['verification_remarks'])?$table['present_address']['verification_remarks']:'-';

$start_end = $start.' - '.$end;

 
 $city_img = $check16px;
if (strtolower($city) != strtolower($remarks_city)) {
    $city_img = $remarks_city;
}

 $pin_code_img = $check16px;
if (strtolower($pin_code) != strtolower($remarks_pincode)) {
    $pin_code_img = $remarks_pincode;
}

 $state_img = $check16px;
if (strtolower($state) != strtolower($remarks_state)) {
    $state_img = $remarks_state;
}

$relationship_img = $check16px;
if (strtolower($relationship) != strtolower($remark_relationship)) {
    $relationship_img = $remark_relationship;
}



$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Flat No</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$flat_no.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Street / Road</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$street.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Area</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$area.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">City / Town</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$city.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$city_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Pin Code</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$pin_code.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$pin_code_img.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Nearest Landmark</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$nearest_landmark.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">State</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$state.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$state_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">DURATION OF STAY</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">CONTACT PERSON Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$person_mobile_number.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Person Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$person_name .'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Relationship</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$relationship.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$relationship_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remarks Address</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remarks_address.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
/*
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remarks City</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remarks_city.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remarks Pincode</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remarks_pincode.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remarks State</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remarks_state.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
*/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Stay with</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$staying_with.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Periods of stay</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$period_of_stay.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Property Type</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$property_type.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$verifier_name.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
/*
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Verifier\'s Relationship</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_relationship.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
*/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$verification_remarks.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

 

$html .='</tbody>';
$html .='</table>';
$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
// $html .='<tr>';
 /*$html .='<td style="padding-bottom: 20px; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 18px;"> </td>'; */
/*$html .='<td style="padding-bottom: 20px;  width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 18px;">'.$table['present_address']['verification_remarks'].'</td>';
$html .='</tr>';*/
$html .='<tr>';
$html .='<td style="padding-bottom: 15px;  width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 18px;">'.$table['present_address']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';

echo $html;
$html ='';


$rental_agreement = explode(',', isset($table['present_address']['rental_agreement'])?$table['present_address']['rental_agreement']:'');
if (!in_array('no-file', $rental_agreement) && count($rental_agreement) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center">Rental Agreement</h1>';

$max = 0;
 foreach ($rental_agreement as $key => $value) {
    $url = base_url()."../uploads/rental-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}


$ration_card = explode(',', $table['present_address']['ration_card']);
if (!in_array('no-file', $ration_card) && count($ration_card) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Ration Card </h1>';

$max = 0;
 foreach ($ration_card as $key => $value) {
    $url = base_url()."../uploads/ration-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}


$gov_utility_bill = explode(',', $table['present_address']['gov_utility_bill']);
if (!in_array('no-file', $gov_utility_bill) && count($gov_utility_bill) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Goverment Utility </h1>';

$max = 0;
 foreach ($gov_utility_bill as $key => $value) {
    $url = base_url()."../uploads/gov-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}

 

$approved_doc = explode(',', $table['present_address']['approved_doc']);
if (count($approved_doc) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Remarks Documents </h1>';

$max = 0;
 foreach ($approved_doc as $key => $value){
     // print_r($value);
     if (is_array($value)) {
         
        // foreach ($value as $key => $val) {
        
            $url = base_url()."../uploads/remarks-docs/".$value;
            $ext = pathinfo($value, PATHINFO_EXTENSION);
            if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

                $html .='<table style="margin-top: 25px;
                border-collapse: collapse;
                width: 100%;line-height:20px;">';
                $html .='<tr>'; 
                $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
                $html .='</tr>';
                $html .='</table>'; 
            $max++;
            }

        // }

     }
 }

$html .='</div>';

}

echo $html;
?>
     <div style="margin-top: 70px; margin-right:80px; margin-left: 80px;">
        <p style="font-size:13px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
    </div>

    <!--  -->
   <?php
}

if (isset($table['previous_address']['previos_address_id'])) {

$html = '';

$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['previous_address']['analyst_status'])?$table['previous_address']['analyst_status']:0;
$font_color = '#FFFFFF';
if ('7' == $analyst) {
   $color_code = '#C50C0C';
    $bgcolor_code = '#eedcdc'; 
    $string_status = 'Unable To Verify';
    $status = 'Verified Discrepancy';
    $green_img = base_url().'assets/admin/images/marks/red.png';
}else if(in_array($analyst,['6','9'])){
    $color_code = '#FFD4AE';
    $bgcolor_code = '#FFD4AE';
    $string_status = 'Unable To Verify';
    $status = 'Unable to Verify';
    $green_img = base_url().'assets/admin/images/marks/orange.png';
}else if($analyst == '4'){
    $color_code = '#1F7705';
    $bgcolor_code = '#C5FCB4';
    $string_status = 'Verified Clear';
    $status = 'Completed';
}else{
    $color_code = '#FFFF00';
    $bgcolor_code = '#FAFAD2'; 
    $string_status = 'Verified Pending';
    $status = 'Pending';
    $font_color = '#000000';
}

 
   $contact_person_mobile_number = json_decode($table['previous_address']['contact_person_mobile_number'],true); 
          $flat_no = json_decode($table['previous_address']['flat_no'],true); 
          $street = json_decode($table['previous_address']['street'],true); 
          $area = json_decode($table['previous_address']['area'],true); 
          $city = json_decode($table['previous_address']['city'],true); 
          $pin_code = json_decode($table['previous_address']['pin_code'],true); 
          $nearest_landmark = json_decode($table['previous_address']['nearest_landmark'],true); 
          $states = json_decode($table['previous_address']['state'],true); 
          $relationship = json_decode($table['previous_address']['contact_person_relationship'],true); 
          $duration_of_stay_start = json_decode($table['previous_address']['duration_of_stay_start'],true); 
          $duration_of_stay_end = json_decode($table['previous_address']['duration_of_stay_end'],true); 
          $contact_person_name = json_decode($table['previous_address']['contact_person_name'],true);  
          $codes = json_decode($table['previous_address']['code'],true); 
          // $verification_remarks = json_decode($table['previous_address']['verification_remarks']);



$remarks_address = json_decode($table['previous_address']['remarks_address'],true);//isset($table['present_address']['remarks_address'])?$table['present_address']['remarks_address']:'-';
$remarks_city = json_decode($table['previous_address']['remarks_city'],true);//isset($table['present_address']['remarks_city'])?$table['present_address']['remarks_city']:'-';
$remarks_pincode = json_decode($table['previous_address']['remarks_pincode'],true);//isset($table['present_address']['remarks_pincode'])?$table['present_address']['remarks_pincode']:'-';

$remarks_state = json_decode($table['previous_address']['remarks_state'],true);//isset($table['present_address']['remarks_state'])?$table['present_address']['remarks_state']:'-';
$staying_with = json_decode($table['previous_address']['staying_with'],true);//isset($table['present_address']['staying_with'])?$table['present_address']['staying_with']:'-';
$period_of_stay = json_decode($table['previous_address']['period_of_stay'],true);//isset($table['present_address']['period_of_stay'])?$table['present_address']['period_of_stay']:'-';

$property_type = json_decode($table['previous_address']['property_type'],true);//isset($table['present_address']['property_type'])?$table['present_address']['property_type']:'-';

$verifier_name = json_decode($table['previous_address']['verifier_name'],true);//isset($table['present_address']['verifier_name'])?$table['present_address']['verifier_name']:'-';

$remark_relationship = json_decode($table['previous_address']['relationship'],true);//isset($table['present_address']['relationship'])?$table['present_address']['relationship']:'-';
$verification_remarks = json_decode($table['previous_address']['verification_remarks'],true);//isset($table['present_address']['verification_remarks'])?$table['present_address']['verification_remarks']:'-';
  

   
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';

$html .='<div style="color: #100F0F; font-weight: bold; font-size: 18px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Previous Address</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 18px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';

foreach ($flat_no as $flat_key => $value) { 

$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 18px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';
             
$verification_remark ='';
                // echo json_encode($flat_no);
    // $verification_remark = isset($verification_remarks[$flat_key]['verification_remarks'])?$verification_remarks[$flat_key]['verification_remarks']:'';

$flat_no =  isset($value['flat_no'])?$value['flat_no']:'-';
$street =  isset($street[$flat_key]['street'])?$street[$flat_key]['street']:'-';
$area =  isset($area[$flat_key]['area'])?$area[$flat_key]['area']:'-';
$city =  isset($city[$flat_key]['city'])?$city[$flat_key]['city']:'-';
$pin_code =  isset($pin_code[$flat_key]['pin_code'])?$pin_code[$flat_key]['pin_code']:'-';
$nearest_landmark =  isset($nearest_landmark[$flat_key]['nearest_landmark'])?$nearest_landmark[$flat_key]['nearest_landmark']:'-';
$state =  isset($state[$flat_key]['state'])?$state[$flat_key]['state']:'-';
$start = isset($duration_of_stay_start[$flat_key]['duration_of_stay_start'])?$duration_of_stay_start[$flat_key]['duration_of_stay_start']:'-';
$end =  isset($duration_of_stay_end[$flat_key]['duration_of_stay_end'])?$duration_of_stay_end[$flat_key]['duration_of_stay_end']:'-';
$person_mobile_number = isset($contact_person_mobile_number[$flat_key]['contact_person_mobile_number'])?$contact_person_mobile_number[$flat_key]['contact_person_mobile_number']:'-';
$person_name =  isset($contact_person_name[$flat_key]['contact_person_name'])?$contact_person_name[$flat_key]['contact_person_name']:'-';
$relationship = isset($contact_person_relationship[$flat_key]['contact_person_relationship'])?$contact_person_relationship[$flat_key]['contact_person_relationship']:'-'; 
$start_end = $start.' - '.$end;

$remarks_addresss = isset($remarks_address[$flat_key]['address'])?$remarks_address[$flat_key]['address']:'-';
$remarks_citys = isset($remarks_city[$flat_key]['pincode'])?$remarks_city[$flat_key]['pincode']:'-';
$remarks_pincodes = isset($remarks_pincode[$flat_key]['city'])?$remarks_pincode[$flat_key]['city']:'-';
$remarks_states = isset($remarks_state[$flat_key]['state'])?$remarks_state[$flat_key]['state']:'-';
$staying_withs = isset($staying_with[$flat_key]['staying_with'])?$staying_with[$flat_key]['staying_with']:'-';
$period_of_stays = isset($period_of_stay[$flat_key]['verification_remarks'])?$period_of_stay[$flat_key]['verification_remarks']:'-';
$property_types = isset($property_type[$flat_key]['period_of_stay'])?$property_type[$flat_key]['period_of_stay']:'-';
$verifier_names = isset($verifier_name[$flat_key]['verifier_name'])?$verifier_name[$flat_key]['verifier_name']:'-';
$remark_relationships = isset($remark_relationship[$flat_key]['relationship'])?$remark_relationship[$flat_key]['relationship']:'-';
$verification_remark = isset($verification_remarks[$flat_key]['verification_remarks'])?$verification_remarks[$flat_key]['verification_remarks']:'-';

 $city_img = $check16px;
if (strtolower($city) != strtolower($remarks_citys)) {
    $city_img =  $remarks_citys;
}

 $pin_code_img = $check16px;
if (strtolower($pin_code) != strtolower($remarks_pincodes)) {
    $pin_code_img = $remarks_pincodes;
}

 $state_img = $check16px;
if (strtolower($state) != strtolower($remarks_states)) {
    $state_img = $remarks_states;
}

$relationship_img = $check16px;
if (strtolower($relationship) != strtolower($remark_relationships)) {
    $relationship_img = $remark_relationships;
}




$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Flat No</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$flat_no.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Street / Road</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$street.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Area</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$area.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">City / Town</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$city.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$city_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Pin Code</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$pin_code.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$pin_code_img.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Nearest Landmark</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$nearest_landmark.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">State</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$state.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$state_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">DURATION OF STAY</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">CONTACT PERSON Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$person_mobile_number.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Person Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$person_name .'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Relationship</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$relationship.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$relationship_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remarks Address</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remarks_addresss.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
/*
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remarks City</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remarks_city.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remarks Pincode</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remarks_pincode.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remarks State</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remarks_state.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
*/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Stay with</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$staying_withs.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Periods of stay</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$period_of_stays.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Property Type</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$property_types.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$verifier_names.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
/*
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Verifier\'s Relationship</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_relationship.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
*/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$verification_remark.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='</tbody>';
$html .='</table>';

}

$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
// $html .='<tr>';
 /*$html .='<td style="padding-bottom: 20px; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 18px;"> </td>'; */
/*$html .='<td style="padding-bottom: 20px;  width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 18px;">'.$verification_remark.'</td>';
$html .='</tr>';*/
$html .='<tr>';
$html .='<td style="padding-bottom: 15px;  width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 18px;">'.$table['previous_address']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';

echo $html;
$html = '';


$rental_agreement = explode(',', $table['previous_address']['rental_agreement']);
if (!in_array('no-file', $rental_agreement) && count($rental_agreement) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center">Rental Agreement</h1>';

$max = 0;
 foreach ($rental_agreement as $key => $value) {
    $url = base_url()."../uploads/rental-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}


$ration_card = explode(',', $table['previous_address']['ration_card']);
if (!in_array('no-file', $ration_card) && count($ration_card) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Ration Card </h1>';

$max = 0;
 foreach ($ration_card as $key => $value) {
    $url = base_url()."../uploads/ration-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}


$gov_utility_bill = explode(',', $table['previous_address']['gov_utility_bill']);
if (!in_array('no-file', $gov_utility_bill) && count($gov_utility_bill) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Goverment Utility Bill </h1>';

$max = 0;
 foreach ($gov_utility_bill as $key => $value) {
    $url = base_url()."../uploads/gov-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}

 

$approved_doc = explode(',', $table['previous_address']['approved_doc']);
if (count($approved_doc) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Remarks Documents </h1>';

$max = 0;
 foreach ($approved_doc as $key => $value){
     // print_r($value);
     if (is_array($value)) {
         
        foreach ($value as $key => $val) {
        
            $url = base_url()."../uploads/remarks-docs/".$val;
            $ext = pathinfo($val, PATHINFO_EXTENSION);
            if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

                $html .='<table style="margin-top: 25px;
                border-collapse: collapse;
                width: 100%;line-height:20px;">';
                $html .='<tr>'; 
                $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
                $html .='</tr>';
                $html .='</table>'; 
            $max++;
            }

        }

     }
 }

$html .='</div>';

}

echo $html;
?>
    
 <div style="margin-top: 70px; margin-right:80px; margin-left: 80px;">
        <p style="font-size:13px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
    </div>
    <!--  -->
   <?php
}


if (isset($table['previous_employment']['previous_emp_id'])) {

$html = '';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['previous_employment']['analyst_status'])?$table['previous_employment']['analyst_status']:0;
$font_color = '#FFFFFF';
if ('7' == $analyst) {
   $color_code = '#C50C0C';
    $bgcolor_code = '#eedcdc'; 
    $string_status = 'Unable To Verify';
    $status = 'Verified Discrepancy';
    $green_img = base_url().'assets/admin/images/marks/red.png';
}else if(in_array($analyst,['6','9'])){
    $color_code = '#FFD4AE';
    $bgcolor_code = '#FFD4AE';
    $string_status = 'Unable To Verify';
    $status = 'Unable to Verify';
    $green_img = base_url().'assets/admin/images/marks/orange.png';
}else if($analyst == '4'){
    $color_code = '#1F7705';
    $bgcolor_code = '#C5FCB4';
    $string_status = 'Verified Clear';
    $status = 'Completed';
}else{
    $color_code = '#FFFF00';
    $bgcolor_code = '#FAFAD2'; 
    $string_status = 'Verified Pending';
    $status = 'Pending';
    $font_color = '#000000';
}

 
    $desigination = json_decode($table['previous_employment']['desigination'],true);
          $remark_department = json_decode($table['previous_employment']['remark_department'],true);
          $department = json_decode($table['previous_employment']['department'],true);
          $department = json_decode($table['previous_employment']['department'],true);
          $employee_id = json_decode($table['previous_employment']['employee_id'],true);
          $company_name = json_decode($table['previous_employment']['company_name'],true);
          $address = json_decode($table['previous_employment']['address'],true);
          $annual_ctc = json_decode($table['previous_employment']['annual_ctc'],true);
          $reason_for_leaving = json_decode($table['previous_employment']['reason_for_leaving'],true);
          $joining_date = json_decode($table['previous_employment']['joining_date'],true);
          $relieving_date = json_decode($table['previous_employment']['relieving_date'],true);
          $reporting_manager_name = json_decode($table['previous_employment']['reporting_manager_name'],true);
          $reporting_manager_desigination = json_decode($table['previous_employment']['reporting_manager_desigination'],true);
          $reporting_manager_contact_number = json_decode($table['previous_employment']['reporting_manager_contact_number'],true); 
          $hr_name = json_decode($table['previous_employment']['hr_name'],true);
          $hr_contact_number = json_decode($table['previous_employment']['hr_contact_number'],true);  
          $remark_hr_name = json_decode($table['previous_employment']['remark_hr_name'],true);
          $verification_remarks = json_decode($table['previous_employment']['verification_remarks'],true);



 $remark_date_of_relieving = json_decode($table['previous_employment']['remark_date_of_relieving'],true);//isset($table['current_employment']['remark_date_of_relieving'])?$table['current_employment']['remark_date_of_relieving']:'-'; 
 $remark_exit_status = json_decode($table['previous_employment']['remark_exit_status'],true);//isset($table['current_employment']['remark_exit_status'])?$table['current_employment']['remark_exit_status']:'-'; 
 $remarks_designation = json_decode($table['previous_employment']['remarks_designation'],true);//isset($table['current_employment']['remarks_designation'])?$table['current_employment']['remarks_designation']:'-'; 
 $remark_date_of_joining = json_decode($table['previous_employment']['remark_date_of_joining'],true);//isset($table['current_employment']['remark_date_of_joining'])?$table['current_employment']['remark_date_of_joining']:'-'; 
 $remark_salary_lakhs = json_decode($table['previous_employment']['remark_salary_lakhs'],true);//isset($table['current_employment']['remark_salary_lakhs'])?$table['current_employment']['remark_salary_lakhs']:'-'; 
 $remark_salary_type = json_decode($table['previous_employment']['remark_salary_type'],true);//isset($table['current_employment']['remark_salary_type'])?$table['current_employment']['remark_salary_type']:'-'; 
 $remark_currency = json_decode($table['previous_employment']['remark_currency'],true);//isset($table['current_employment']['remark_currency'])?$table['current_employment']['remark_currency']:'-'; 
 $remark_eligible_for_re_hire = json_decode($table['previous_employment']['remark_eligible_for_re_hire'],true);//isset($table['current_employment']['remark_eligible_for_re_hire'])?$table['current_employment']['remark_eligible_for_re_hire']:'-'; 
 $remark_hr_name = json_decode($table['previous_employment']['remark_hr_name'],true);//isset($table['current_employment']['remark_hr_name'])?$table['current_employment']['remark_hr_name']:'-';  
 $remark_hr_email = json_decode($table['previous_employment']['remark_hr_email'],true);//isset($table['current_employment']['remark_hr_email'])?$table['current_employment']['remark_hr_email']:'-'; 
 $verification_remarks = json_decode($table['previous_employment']['verification_remarks'],true);
 $remark_hr_phone_no = json_decode($table['previous_employment']['remark_hr_phone_no'],true);
 //isset($table['current_employment']['verification_remarks'])?$table['current_employment']['verification_remarks']:'-'; 
   
  
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 18px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Previous Employment</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 18px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';

 foreach ($desigination as $prev => $val) { 

$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 18px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';



    $remark_hr_nam = isset($remark_hr_name[$prev]['remark_hr_name'])?$remark_hr_name[$prev]['remark_hr_name']:'-';
    $verification_remark = isset($verification_remarks[$prev]['verification_remarks'])?$verification_remarks[$prev]['verification_remarks']:'-';
              

$start = isset($joining_date[$prev]['joining_date'])?$joining_date[$prev]['joining_date']:'-';
$end = isset($relieving_date[$prev]['relieving_date'])?$relieving_date[$prev]['relieving_date']:'-';

$start_end = $start.' - '.$end;

 $desigination = isset($desigination[$prev]['desigination'])?$desigination[$prev]['desigination']:'-'; 
 $department = isset($department[$prev]['department'])?$department[$prev]['department']:'-';
 $remark_department = isset($remark_department[$prev]['remark_department'])?$remark_department[$prev]['remark_department']:'-';
 $employee_id = isset($employee_id[$prev]['employee_id'])?$employee_id[$prev]['employee_id']:'-'; 
 $company =  isset($company_name[$prev]['company_name'])?$company_name[$prev]['company_name']:'-';

 $addr =  isset($address[$prev]['address'])?$address[$prev]['address']:'-';

 $ctc =  isset($annual_ctc[$prev]['annual_ctc'])?$annual_ctc[$prev]['annual_ctc']:'-';
 $leave = isset($reason_for_leaving[$prev]['reason_for_leaving'])?$reason_for_leaving[$prev]['reason_for_leaving']:'-';
 $manager = isset($reporting_manager_name[$prev]['reporting_manager_name'])?$reporting_manager_name[$prev]['reporting_manager_name']:'-';
 $contact = isset($reporting_manager_contact_number[$prev]['reporting_manager_contact_number'])?$reporting_manager_contact_number[$prev]['reporting_manager_contact_number']:'-';  
 $designation =  isset($reporting_manager_desigination[$prev]['reporting_manager_desigination'])?$reporting_manager_desigination[$prev]['reporting_manager_desigination']:'-'; 
 $hr_name = isset($hr_name[$prev]['hr_name'])?$hr_name[$prev]['hr_name']:'-';

 $hr_contact = isset($hr_contact_number[$prev]['hr_contact_number'])?$hr_contact_number[$prev]['hr_contact_number']:'-'; 

$remark_date_of_relievings = isset($remark_date_of_relieving[$prev]['remark_date_of_relieving'])?$remark_date_of_relieving[$prev]['remark_date_of_relieving']:"-";
$remark_exit_statuss = isset($remark_exit_status[$prev]['remark_exit_status'])?$remark_exit_status[$prev]['remark_exit_status']:"-";
$remarks_designations = isset($remarks_designation[$prev]['remarks_designation'])?$remarks_designation[$prev]['remarks_designation']:"-";
$remark_date_of_joinings = isset($remark_date_of_joining[$prev]['remark_date_of_joining'])?$remark_date_of_joining[$prev]['remark_date_of_joining']:"-";
$remark_salary_lakhss = isset($remark_salary_lakhs[$prev]['remark_salary_lakhs'])?$remark_salary_lakhs[$prev]['remark_salary_lakhs']:"-";
$remark_salary_types = isset($remark_salary_type[$prev]['remark_salary_type'])?$remark_salary_type[$prev]['remark_salary_type']:"-";
$remark_currencys = isset($remark_currency[$prev]['remark_currency'])?$remark_currency[$prev]['remark_currency']:"-";
$remark_eligible_for_re_hires = isset($remark_eligible_for_re_hire[$prev]['remark_eligible_for_re_hire'])?$remark_eligible_for_re_hire[$prev]['remark_eligible_for_re_hire']:"-";
$remark_hr_names = isset($remark_hr_name[$prev]['remark_hr_name'])?$remark_hr_name[$prev]['remark_hr_name']:"-";
$remark_hr_emails = isset($remark_hr_email[$prev]['remark_hr_email'])?$remark_hr_email[$prev]['remark_hr_email']:"-";
$remark_hr_phone_nos = isset($remark_hr_phone_no[$prev]['remark_hr_phone_no'])?$remark_hr_phone_no[$prev]['remark_hr_phone_no']:"-";

$desigination_img = $check16px;
 if (strtolower($desigination) != strtolower($remarks_designations)) {
  $desigination_img =  $remarks_designations;
 }

$department_img = $check16px;
 if (strtolower($department) != strtolower($remark_department)) {
  $department_img = $remark_department;
 }

 $ctc_img = $check16px;
 if (strtolower($ctc) != strtolower($remark_salary_lakhss)) {
  $ctc_img = $remark_salary_lakhss;
 }

 $hr_name_img = $check16px;
 if (strtolower($hr_name) != strtolower($remark_hr_names)) {
  $hr_name_img = $remark_hr_names;
 }


 $hr_contact_img = $check16px;
 if (strtolower($hr_contact) != strtolower($remark_hr_phone_nos)) {
  $hr_contact_img = $remark_hr_phone_nos;
 }


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Desigination</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$desigination.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$desigination_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Department</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$department.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$desigination_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Employee ID</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$employee_id.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Company Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$company.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Address</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$addr.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Annual CTC</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$ctc.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$ctc_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reason For Leaving</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$leave.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Joining - relieving Date</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reporting Manager Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$manager.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reporting Manager Designation</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$designation.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reporting Manager Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">HR Contact Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$hr_name.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$hr_name_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">HR Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$hr_contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$hr_contact_img.'</td>';
$html .='</tr>';
 


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Date Of Relieving</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_date_of_relievings.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Exit Status</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_exit_statuss.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remarks Designation</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remarks_designations.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
*/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Date Of Joining</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_date_of_joinings.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Salary</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_salary_lakhss.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
*/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Salary Type</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_salary_types.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Currency</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_currencys.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark Eligible For Re-Hire</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_eligible_for_re_hires.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark HR Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_hr_names.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';
*/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Remark HR Email</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$remark_hr_emails.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Verification Remarks</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$verification_remark.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='</tbody>';
$html .='</table>';

}     

$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
/*$html .='<tr>';
$html .='<td style="padding-bottom: 20px; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 18px;">'.$table['current_employment']['remark_hr_name'].'</td>';
$html .='<td style="padding-bottom: 20px;  width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 18px;">'.$table['current_employment']['verification_remarks'].'</td>';
$html .='</tr>';*/
$html .='<tr>';
$html .='<td style="padding-bottom: 15px;  width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 18px;">'.$table['previous_employment']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';

echo $html;

$html = '';


$appointment_letter = explode(',', $table['previous_employment']['appointment_letter']);
if (!in_array('no-file', $appointment_letter) && count($appointment_letter) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center">Appointment Letter</h1>';

$max = 0;
 foreach ($appointment_letter as $key => $value) {
    $url = base_url()."../uploads/appointment_letter/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}


$experience_relieving_letter = explode(',', $table['previous_employment']['experience_relieving_letter']);
if (!in_array('no-file', $experience_relieving_letter) && count($experience_relieving_letter) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Experience Letter </h1>';

$max = 0;
 foreach ($experience_relieving_letter as $key => $value) {
    $url = base_url()."../uploads/experience_relieving_letter/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}


$last_month_pay_slip = explode(',', $table['previous_employment']['last_month_pay_slip']);
if (!in_array('no-file', $last_month_pay_slip) && count($last_month_pay_slip) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Convocation </h1>';

$max = 0;
 foreach ($last_month_pay_slip as $key => $value) {
    $url = base_url()."../uploads/last_month_pay_slip/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}



$bank_statement_resigngation_acceptance = explode(',', $table['previous_employment']['bank_statement_resigngation_acceptance']);
if (!in_array('no-file', $bank_statement_resigngation_acceptance) && count($bank_statement_resigngation_acceptance) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Bank Statement </h1>';

$max = 0;
 foreach ($bank_statement_resigngation_acceptance as $key => $value) {
    $url = base_url()."../uploads/bank_statement_resigngation_acceptance/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

    $html .='<table style="margin-top: 25px;
    border-collapse: collapse;
    width: 100%;line-height:10px;">';
    $html .='<tr>'; 
    $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
    $html .='</tr>';
    $html .='</table>'; 
    $max++;
    }
 }

$html .='</div>';

}


$approved_doc = explode(',', $table['previous_employment']['approved_doc']);
if (count($approved_doc) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px; background-color: #e2e5f3; margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px;" >';
$html .='<h1 style="text-align:center"> Remarks Documents </h1>';

$max = 0;
 foreach ($approved_doc as $key => $value){ 
    
        $url = base_url()."../uploads/remarks-docs/".$value;
        $ext = pathinfo($value, PATHINFO_EXTENSION);
        if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){

            $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
            $html .='<tr>'; 
            $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;" width="100%" src="'.$url.'"></td>'; 
            $html .='</tr>';
            $html .='</table>'; 
        $max++;
        } 
 }

$html .='</div>';

}

echo $html;
?>

     <div style="margin-top: 70px; margin-right:80px; margin-left: 80px;">
        <p style="font-size:13px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
    </div>

    <!--  -->
   <?php
}

if (isset($table['reference']['reference_id'])) {
$html ='';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['reference']['analyst_status'])?$table['reference']['analyst_status']:0;
$font_color = '#FFFFFF';
if ('7' == $analyst) {
   $color_code = '#C50C0C';
    $bgcolor_code = '#eedcdc'; 
    $string_status = 'Unable To Verify';
    $status = 'Verified Discrepancy';
    $green_img = base_url().'assets/admin/images/marks/red.png';
}else if(in_array($analyst,['6','9'])){
    $color_code = '#1F7705';
    $bgcolor_code = '#FFD4AE';
    $string_status = 'Unable To Verify';
    $status = 'Unable to Verify';
    $green_img = base_url().'assets/admin/images/marks/orange.png';
}else if($analyst == '4'){
    $color_code = '#1F7705';
    $bgcolor_code = '#C5FCB4';
    $string_status = 'Verified Clear';
    $status = 'Completed';
}else{
    $color_code = '#FFFF00';
    $bgcolor_code = '#FAFAD2'; 
    $string_status = 'Verified Pending';
    $status = 'Pending';
    $font_color = '#000000';
}
 
    // print_r($table['reference']['verification_remarks']);
    $company_name = explode(',', $table['reference']['company_name']);
            $designation = explode(',', $table['reference']['designation']);
            $contact_number = explode(',', $table['reference']['contact_number']);
            $email_id = explode(',', $table['reference']['email_id']);
            $years_of_association = explode(',', $table['reference']['years_of_association']);
            $contact_start_time = explode(',', $table['reference']['contact_start_time']);
            $contact_end_time = explode(',', $table['reference']['contact_end_time']); 
            $name = explode(',',$table['reference']['name']);


            $verification_remarks = json_decode($table['reference']['verification_remarks'],true);
   
 
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 18px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Reference</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 18px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';

foreach ($company_name as $refer => $referval) { 

$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 18px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';

$verification_remark = isset($verification_remarks[$refer]['verification_remarks'])?$verification_remarks[$refer]['verification_remarks']:'';
$names = isset($name[$refer])?$name[$refer]:"";
$company_names = isset($company_name[$refer])?$company_name[$refer]:"";
$designations = isset($designation[$refer])?$designation[$refer]:"";
$contact_numbers = isset($contact_number[$refer])?$contact_number[$refer]:"";
$email_ids = isset($email_id[$refer])?$email_id[$refer]:"";
$years_of_associations = isset($years_of_association[$refer])?$years_of_association[$refer]:"";

$contact_start_times =isset($contact_start_time[$refer])?$contact_start_time[$refer]:"";
$contact_end_times =isset($contact_end_time[$refer])?$contact_end_time[$refer]:"";

$start_end =  $contact_start_times." - ".$contact_end_times;
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$names.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Company Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$company_names.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Designation</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$designations.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'. $contact_numbers.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Email ID</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$email_ids.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Years of Association</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$years_of_associations.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Preferred contact time</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >N/A</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$verification_remark.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 18px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='</tbody>
</table>';

} 

$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">'; 
/*$html .='<tr><td style="padding-bottom: 20px;  width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 18px;"><?php echo $verification_remark; ?></td>';
$html .='</tr>';*/
$html .='<tr>';
$html .='<td style="padding-bottom: 15px;  width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 18px;">'.$table['reference']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';

echo $html;

?>
     <div style="margin-top: 70px; margin-right:80px; margin-left: 80px;">
        <p style="font-size:13px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
    </div>

    <!--  -->
   <?php
}
?>
   
   
   
</body>
</html>


  <div class="modal fade " id="myModal-show" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <h4 class="modal-title">Thank you for Submitting the details</h4> -->
        </div>
        <div class="modal-body">
         <div id="view-img"></div>
        </div>
        <div class="modal-footer">
          <div class="header-mn text-center">
              <a href="" data-dismiss="modal" class="exit-btn float-center text-center">Close</a>
           </div>
        </div>
      </div>
    </div>
  </div>


<script type="text/javascript">
    var img_base_url = "<?php echo base_url(); ?>";
    function exist_view_image(image,path){ 
    $("#myModal-show").modal('show'); 
   $("#view-img").html("<img width='450px' src='"+img_base_url+'../uploads/'+path+'/'+image+"'>");
       
}


</script>