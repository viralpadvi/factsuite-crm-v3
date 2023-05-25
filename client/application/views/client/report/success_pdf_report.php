<?php 
use Dompdf\Dompdf;
$pdf = new DOMPDF(); 
$main_url = "http://localhost/factsuite-crm/";
$data = $this->caseModel->get_single_case_details($candidate_id);

$logo =  'data:image/jpg;base64,'.base64_encode(file_get_contents(base_url().'assets/client/images/FactSuite-logo.png'));
$cancel =  'data:image/jpg;base64,'.base64_encode(file_get_contents(base_url().'assets/client/images/marks/cancel-16.png'));
$check16px =  'data:image/jpg;base64,'.base64_encode(file_get_contents(base_url().'assets/client/images/marks/check16px.png'));

// print_r($data);
/*echo '<img style="display: block; margin-left: auto;margin-right: auto; width: 20%; margin-top: 50px;" src="'.$logo.'" alt="" srcset="">';*/
$html_tr ='';
// exit();
$html_loop ='';
$html_criminal ='';

if (isset($table['criminal_checks']['criminal_check_id'])) {
    // print_r($table['criminal_checks']); 
     $address = json_decode($table['criminal_checks']['address'],true); 
     $states = json_decode($table['criminal_checks']['state'],true);
     $pin_code = json_decode($table['criminal_checks']['pin_code'],true);
     $city = json_decode($table['criminal_checks']['city'],true); 
     $verification_remarks = json_decode($table['criminal_checks']['verification_remarks'],true); 
    

$remarks ='';
foreach ($address as $key => $value) { 
$remarks = isset($verification_remarks[$key][' verification_remarks'])?$verification_remarks[$key][' verification_remarks']:''; 
 $city_sub = isset($value['city'])?$value['city']:"-";
 $address_sub = isset($value['address'])?$value['address']:"-";
 $state_sub = isset($states[$key]['state'])?$states[$key]['state']:"-";
 $pincode_sub = isset($pin_code[$key]['pincode'])?$pin_code[$key]['pincode']:"-";
 $Address_title_name = "Address";
 $City_title_name = "City";
 $State_title_name = "State";
 $Pincode_title_name = "Pincode";

  $address_img = $check16px;
    $states_img = $check16px;
    $pin_code_img = $check16px;
    $city_img = $check16px;

         if ($address_sub =='-') {
             $address_img = $cancel;
         }
        if ($state_sub =='-') {
            $states_img = $cancel;
        }
        if ($pincode_sub =='-') {
            $pin_code_img = $cancel;
        }
        if ($city_sub =='-') {
            $city_img = $cancel;
        }

/* $cancel
$check16px*/

$html_loop .='<tr>';
$html_loop .='<td width="25%" class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; font-weight: bold; font-size: 18px;">'.$Address_title_name.'</td>';
$html_loop .='<td width="25%" style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$address_sub.'</td>';
$html_loop .='<td width="25%"></td>';
$html_loop .='<td width="25%" style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><img src="'.$address_img.'" ></td>';
$html_loop .='</tr>';
$html_loop .='<tr>';
$html_loop .='<td width="25%" class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; font-weight: bold; font-size: 18px;">'.$City_title_name.'</td>
<td width="25%" style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$city_sub.'</td>';
$html_loop .='<td width="25%"></td>';
$html_loop .='<td width="25%" style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><img src="'.$city_img.'" ></td>';
$html_loop .='</tr>';
$html_loop .='<tr>';
$html_loop .='<td width="25%" class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; font-weight: bold; font-size: 18px;">'.$State_title_name.'</td>';
$html_loop .='<td width="25%" style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$state_sub.'</td>';
$html_loop .='<td width="25%"></td>';
$html_loop .='<td width="25%" style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><img src="'.$states_img.'" ></td>';
$html_loop .='</tr>';
$html_loop .='<tr>';
$html_loop .='<td width="25%"  class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; font-weight: bold; font-size: 18px;">'.$Pincode_title_name.'</td>';
$html_loop .='<td width="25%"  style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'. $pincode_sub.'</td>';
$html_loop .='<td width="25%" ></td>';
$html_loop .='<td width="25%"  style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><img src="'.$pin_code_img.'" ></td>';
$html_loop .='</tr>';
 
} 
 
}

foreach ($data as $key1 => $value1) {
    $status = '';
    $verify ='';
    if ($value1['component_data']['analyst_status'] == '0') {
 
        $status = '<span class="text-warning">Pending</span>'; 
        $verify ='<span class="text-warning">Verified Not Clear</span>';
    }else if ($value1['component_data']['analyst_status'] == '1') {
         
        $status = '<span class="text-info">Form Filled</span>'; 
        $verify ='<span class="text-info">Verified Not Clear</span>';
    }else if ($value1['component_data']['analyst_status'] == '2') {
         
        $status = '<span class="text-success">Completed<span>'; 
        $verify ='<span class="text-success">Verified Clear</span>';
    }else if ($value1['component_data']['analyst_status'] == '3') {
         
        $status = '<span class="text-danger">Insufficiency</span>'; 
        $verify ='<span class="text-danger">Verified Not Clear</span>';
    }else if ($value1['component_data']['analyst_status'] == '4') {
       
        $status = '<span class="text-success">Approved</span>'; 
        $verify ='<span class="text-success">Verified Clear</span>';
    }else{

        $status = '<span class="text-success">Approved</span>'; 
        $verify ='<span class="text-success">Verified Clear</span>';
    }

$html_tr .='<tr>';
$html_tr .='<td style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;" width="40%" >'.$value1['component_name'].'</td>';
// $html_tr .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"  width="20%" >BE</td>';
$html_tr .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;text-align:center;"  width="30%" >'.$status.'</td>';
$html_tr .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold; font-size: 18px;text-align:center;"  width="30%"  >'.$verify.'</td>';
$html_tr .='</tr>';
}

$html = '';
$html .='<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">';
$html .= "<style>
body{font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto';}
/*
.border-left-green {
display: inline-block;
position: relative;
}
.border-left-green:before {
content: '';
border-left: 4px solid #1F7705;
position: absolute;
height: 80%;
left: 10px;
top: 10%;
}*/
 @page {
                 margin-top: 30px; /* create space for header */
        margin-bottom: 50px; /* create space for footer */
            }

            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 50px;

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 35px;
            }

            footer {
                position: fixed; 
                bottom: -50px; 
                left: 0px; 
                right: 0px;
                height: 100px;  
                padding-bottom: 20px;
            }
</style>"; 
$html .='</head>';
$html .='<body>';  
$html .='<footer>';
$html .='<div style="margin-top: 5px; margin-right:80px; margin-left: 80px;">
<p style="font-size:12px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
</div>';        
$html .='</footer><main>';


$html .='<table style="margin-top: 10px; color: #ffffff;
border-collapse: collapse;
width: 100%;"><tr><th width="38%"></th><th width="32%">'; 
$html .='<img style="display: block; margin-left: auto;margin-right: auto; width: 70%; margin-top: 5px;" src="'.$logo.'" alt="" srcset="">';
$html .='</th><th width="30%"></th></tr></table>';

$html .='<p style="text-align: center; font-size: 30px; color: #100F0F; font-weight: bold; margin-top: 45px; margin-bottom: 0px;">
Employee Background Verification <br> Final Report</p>
<small style="float: right; font-size: 15px; font-weight: normal; margin-top: -20px; margin-right: 11%;"></small> 
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
<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;">COLLABERA20200352212</td>
<td style="padding-bottom: 15px; width: 17%; font-size: 18px;" >Date Requested</td>
<td style="padding-bottom: 15px;">:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;">12-03-2020</td>
</tr>
<tr>
<td style="padding-bottom: 15px; width: 16%; font-size: 18px;">Name Of Client</td>
<td style="padding-bottom: 15px;">:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;">Collabera</td>
<td style="padding-bottom: 15px; width: 17%; font-size: 18px;" >Date Completed</td>
<td style="padding-bottom: 15px;">:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;">20-03-2020</td>
</tr>
<tr>
<td  style="padding-bottom: 15px; width: 16%; font-size: 18px;">Name Of Candidate</td>
<td style="padding-bottom: 15px;">:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;">'.$candidate[0]['candidaetData']['first_name'].' '.$candidate[0]['candidaetData']['last_name'].'</td>
<td  style="padding-bottom: 15px; width: 16%; font-size: 18px;">Date Of Birth</td>
<td style="padding-bottom: 15px;">:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;">16-08-1990</td>
</tr>
<tr>
<td style="padding-bottom: 15px; width: 16%; font-size: 18px;">Employee ID</td>
<td style="padding-bottom: 15px;">:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;">NA</td>
<td style="padding-bottom: 15px; width: 16%; font-size: 18px;">Date of Joining</td>
<td style="padding-bottom: 15px;">:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;">--</td>
</tr>
<tr>
<td style="padding-bottom: 15px; width: 16%; font-size: 18px;">Father\'s Name</td>
<td style="padding-bottom: 15px;">:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px;">'.$candidate[0]['candidaetData']['father_name'].'</td>
</tr>
</table>
</div>
</div>
<div style="padding: 35px; background-color: #C5FCB4;margin-top: 5px; margin-right:80px; margin-left: 80px; " >
<div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Result Definitions</div>

<table style="margin-top: 28px; border-collapse: collapse;
width: 100%;">
<tr>
<td><button style="background-color: #1F7705; border: none; border-radius: 35px; color: #FFFFFF; font-size: 20px; font-weight: bold; padding: 25px 50px;width: 65%; margin-left: 50px;" >GREEN REPORT</button> </td>
<td><button style="background-color: #D2D4D1; border: none; border-radius: 35px; color: #100F0F; font-size: 20px; font-weight: bold; padding: 25px 50px;width: 65%;  margin-left: 70px;" >Verified Clear</button> </td>
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
<th style="padding: 12px 0px 12px 25px;" width="40%" >Component Type</th> 
<th width="30%">Status</th>
<th width="30%">Result</th>
</tr>
<tbody style="padding: 10px; margin-top: 10px;  background-color: #D2D4D1;">'.$html_tr.'
</tbody>
</table> 
</div>';
 

if (isset($table['criminal_checks']['criminal_check_id'])) {
// $html_criminal .='<div style="page-break-after: always;"></div>';
$html_criminal .='<br><div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 100px; margin-right:80px; margin-left: 80px; " >';
$html_criminal .='<div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Criminal Status</div>';

$html_criminal .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html_criminal .='<tr>';
$html_criminal .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html_criminal .='<td style="padding-bottom: 15px;">:</td>';
$html_criminal .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;">Completed</td>';
$html_criminal .='</tr>';
$html_criminal .='</table>';
$html_criminal .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html_criminal .='<tr>';
$html_criminal .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html_criminal .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html_criminal .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html_criminal .='<th style="background-color: #1F7705;color: #ffffff; text-align: center; font-size: 18px; font-weight: normal;">Verified Clear</th>';
$html_criminal .='</tr>';
$html_criminal .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';

$html_criminal .=$html_loop;

$html_criminal .='</tbody>';
$html_criminal .='</table>';
$html_criminal .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
$html_criminal .='<tr>'; 
$html_criminal .='<td style="padding-bottom: 20px; color: #171515; width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html_criminal .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html_criminal .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 20px;">'.$remarks.'</td>';
$html_criminal .='</tr>';
$html_criminal .='<tr>';
$html_criminal .='<td style="padding-bottom: 15px; color: #171515; width: 16%; font-size: 18px;">Verified Date</td>';
$html_criminal .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html_criminal .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 20px;">'.$table['criminal_checks']['updated_date'].'</td>';
$html_criminal .='</tr>';
$html_criminal .='</table>';
$html_criminal .='</div>';
      
 /*
$html_criminal .='<div style="margin-top: 5px; margin-right:80px; margin-left: 80px;">
<p style="font-size:12px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
</div>';*/

}
/*echo $html_criminal;
exit();*/
$html .=$html_criminal;


if (isset($table['court_records']['court_records_id'])) {
    // print_r($table['court_records']);
    $address = json_decode($table['court_records']['address'],true); 
     $states = json_decode($table['court_records']['state'],true);
     $pin_code = json_decode($table['court_records']['pin_code'],true);
     $city = json_decode($table['court_records']['city'],true);
        $verification_remarks = json_decode($table['court_records']['verification_remarks'],true);
 
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Court Record</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;">Completed</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: #1F7705;color: #ffffff; text-align: center; font-size: 18px; font-weight: normal;">Verified Clear</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';

$verification_remark = '';
foreach ($address as $key => $value) { 
$court_city = isset($city[$key]['city'])?$city[$key]['city']:'-'; 
$court_address = isset($value['address'])?$value['address']:'-'; 
$court_state = isset($states[$key]['state'])?$states[$key]['state']:'-';
$court_pincode = isset($pin_code[$key]['pincode'])?$pin_code[$key]['pincode']:'-'; 
$verification_remark = isset($verification_remarks[$key]['verification_remarks'])?$verification_remarks[$key]['verification_remarks']:'-';

  $address_img = $check16px;
    $states_img = $check16px;
    $pin_code_img = $check16px;
    $city_img = $check16px;

     if ($court_address =='-') {
         $address_img = $cancel;
     }
    if ($court_state =='-') {
        $states_img = $cancel;
    }
    if ($court_pincode =='-') {
        $pin_code_img = $cancel;
    }
    if ($court_city =='-') {
        $city_img = $cancel;
    }

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Address</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$court_address.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><img src="'.$address_img.'" ></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">City</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$court_city.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><img src="'.$city_img.'" ></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">State</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$court_state.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><img src="'.$states_img.'" ></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Pincode</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$court_pincode.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><img src="'.$pin_code_img.'" ></td>';
$html .='</tr>';


} 


$html .='</tbody>';
$html .='</table>';
$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<!-- <td style="padding-bottom: 20px;color: #171515; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 20px;">Dr.M.Venkatesan</td> -->';
$html .='<td style="padding-bottom: 20px; color: #171515; width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 20px;">'.$verification_remark.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; color: #171515; width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 20px;">'.$table['court_records']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';
/*$html .='<div style="margin-top: 5px; margin-right:80px; margin-left: 80px;">
<p style="font-size:12px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small></p><p style="margin-top:10px;"></p>
</div>';*/
 
}



if (isset($table['education_details']['education_details_id'])) {
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
  
 
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Education</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;">Completed</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: #1F7705;color: #ffffff; text-align: center; font-size: 18px; font-weight: normal;">Verified Clear</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';

              
$vname = '';
$verification_remarks ='';
foreach ($type_of_degree as $key => $value) { 
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
 $roll = isset($registration_roll_number[$key]['registration_roll_number'])?$registration_roll_number[$key]['registration_roll_number']:'';

$start_end = $start.' - '.$end;

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Type Of Qualification</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$type_of_degree_edu.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Major</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$edu_major.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">University Board</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$university_board_edu.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">School / College</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$college_school_edu.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Address </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$add.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr> ';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">DURATION OF COURSE</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr> ';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Course Type</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$course.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr> ';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Roll Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$roll.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>  '; 

}
          

$html .='</tbody>';
$html .='</table>';
$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 20px;color: #171515; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 20px;">'.$vname.'</td>';
$html .='<td style="padding-bottom: 20px; color: #171515; width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 20px;">'.$verification_remarks.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; color: #171515; width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 20px;">'.$table['education_details']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';
/*$html .='<div style="margin-top: 5px; margin-right:80px; margin-left: 80px;">
<p style="font-size:12px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
</div>';*/
 
 
}



if (isset($table['current_employment']['current_emp_id'])) {
    // print_r($table['current_employment']['verification_remarks']);
  
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Current Employment</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;">Completed</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: #1F7705;color: #ffffff; text-align: center; font-size: 18px; font-weight: normal;">Verified Clear</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';


$start = isset($table['current_employment']['joining_date'])?$table['current_employment']['joining_date']:'';
$end = isset($table['current_employment']['relieving_date'])?$table['current_employment']['relieving_date']:''; 

$start_end = $start.' - '.$end;

 $desigination = isset($table['current_employment']['desigination'])?$table['current_employment']['desigination']:'';  
 $department = isset($table['current_employment']['department'])?$table['current_employment']['department']:'';  
 $employee_id = isset($table['current_employment']['employee_id'])?$table['current_employment']['employee_id']:''; 
 $company =  isset($table['current_employment']['company_name'])?$table['current_employment']['company_name']:'';
 $addr =  isset($table['current_employment']['address'])?$table['current_employment']['address']:''; 
 $ctc =  isset($table['current_employment']['annual_ctc'])?$table['current_employment']['annual_ctc']:'';
 $leave = isset($table['current_employment']['reason_for_leaving'])?$table['current_employment']['reason_for_leaving']:'';
 $manager = isset($table['current_employment']['reporting_manager_name'])?$table['current_employment']['reporting_manager_name']:''; 
 $contact = isset($table['current_employment']['reporting_manager_contact_number'])?$table['current_employment']['reporting_manager_contact_number']:'';  
 $designation =  isset($table['current_employment']['reporting_manager_desigination'])?$table['current_employment']['reporting_manager_desigination']:'';  
 $hr_name = isset($table['current_employment']['hr_name'])?$table['current_employment']['hr_name']:'';

 $hr_contact = isset($table['current_employment']['hr_contact_number'])?$table['current_employment']['hr_contact_number']:''; 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Desigination</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$desigination.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Department</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$department.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Employee ID</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$employee_id.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Company Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$company.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Address</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$addr.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Annual CTC</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$ctc.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reason For Leaving</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$leave.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Joining - relieving Date</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reporting Manager Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$manager.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reporting Manager Designation</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$designation.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reporting Manager Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">HR Contact Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$hr_name.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">HR Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$hr_contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';




     
$html .='</tbody>';
$html .='</table>';
$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 20px;color: #171515; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 20px;">'.$table['current_employment']['remark_hr_name'].'</td>';
$html .='<td style="padding-bottom: 20px; color: #171515; width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 20px;">'.$table['current_employment']['verification_remarks'].'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; color: #171515; width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 20px;">'.$table['current_employment']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';
/*$html .='<div style="margin-top: 5px; margin-right:80px; margin-left: 80px;">
<p style="font-size:12px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
</div>';*/

}



if (isset($table['drugtest']['drugtest_id'])) {
    $candidate_name = json_decode($table['drugtest']['candidate_name'],true);
    $father_name = json_decode($table['drugtest']['father_name'],true);
    $dob = json_decode($table['drugtest']['dob'],true);
    $address = json_decode($table['drugtest']['address'],true);
    $mobile_number = json_decode($table['drugtest']['mobile_number'],true); 
    $codes = json_decode($table['drugtest']['code'],true); 
    $verification_remarks = json_decode($table['drugtest']['verification_remarks'],true);
    // print_r($table['drugtest']);
   
   
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Drug Test</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;">Completed</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: #1F7705;color: #ffffff; text-align: center; font-size: 18px; font-weight: normal;">Verified Clear</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';
 $vremark = '';
foreach ($candidate_name as $key => $value) { 
    $candidate = $value['candidate_name']; 
    $father =  isset($father_name[$key]['father_name'])?$father_name[$key]['father_name']:'-'; 
    $birth = isset($dob[$key]['dob'])?$dob[$key]['dob']:'-';
    $contact = isset($mobile_number[$key]['mobile_number'])?$mobile_number[$key]['mobile_number']:'-';
    $addresss = isset($address[$key]['address'])?$address[$key]['address']:'-';
    $vremark = isset($verification_remarks[$key]['verification_remarks'])?$verification_remarks[$key]['verification_remarks']:'-';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Candidate Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$candidate.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Father\'s Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$father.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Date Of Birth</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$birth.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Contac Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Address</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$addresss.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';

}


$html .='</tbody>';
$html .='</table>';
$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
 /*$html .='<td style="padding-bottom: 20px;color: #171515; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 20px;"> </td>'; */
$html .='<td style="padding-bottom: 20px; color: #171515; width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 20px;">'.$vremark.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; color: #171515; width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 20px;">'.$table['drugtest']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';
/*$html .='<div style="margin-top: 5px; margin-right:80px; margin-left: 80px;">
<p style="font-size:12px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
</div>';*/
 
}



 
if (isset($table['globaldatabase']['globaldatabase_id'])) {  
     
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Global Database</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;">Completed</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: #1F7705;color: #ffffff; text-align: center; font-size: 18px; font-weight: normal;">Verified Clear</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';
$name =  isset($table['globaldatabase']['candidate_name'])?$table['globaldatabase']['candidate_name']:'-'; 
$qualification =  isset($table['globaldatabase']['father_name'])?$table['globaldatabase']['father_name']:'-'; 
$dob =  isset($table['globaldatabase']['dob'])?$table['globaldatabase']['dob']:'-'; 

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Candidate Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$name.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Qualification</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$qualification.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Date Of Birth</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$dob.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
 


$html .='</tbody>';
$html .='</table>';
$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
 /*$html .='<td style="padding-bottom: 20px;color: #171515; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 20px;"> </td>'; */
$html .='<td style="padding-bottom: 20px; color: #171515; width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 20px;">'.$table['globaldatabase']['verification_remarks'].'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; color: #171515; width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 20px;">'.$table['globaldatabase']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';
/*$html .='<div style="margin-top: 5px; margin-right:80px; margin-left: 80px;">
<p style="font-size:12px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
</div>';*/

  
}




if (isset($table['permanent_address']['permanent_address_id'])) {
     
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Permanent Address</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;">Completed</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: #1F7705;color: #ffffff; text-align: center; font-size: 18px; font-weight: normal;">Verified Clear</th>';
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
$start_end = $start.' - '.$end;
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Flat No</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$flat_no.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Street / Road</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$street.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Area</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$area.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">City / Town</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$city.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Pin Code</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$pin_code.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Nearest Landmark</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$nearest_landmark.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">State</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$state.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">DURATION OF STAY</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">CONTACT PERSON Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$person_mobile_number.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Select Relationship</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$person_name .'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Mobile Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$relationship.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';

 
$html .='</tbody>';
$html .='</table>';
$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
 /*$html .='<td style="padding-bottom: 20px;color: #171515; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 20px;"> </td>'; */
$html .='<td style="padding-bottom: 20px; color: #171515; width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 20px;">'.$table['permanent_address']['verification_remarks'].'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; color: #171515; width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 20px;">'.$table['permanent_address']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';
/*$html .='<div style="margin-top: 5px; margin-right:80px; margin-left: 80px;">
<p style="font-size:12px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
</div>';*/



}

if (isset($table['present_address']['present_address_id'])) { 
    
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Present Address</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;">Completed</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: #1F7705;color: #ffffff; text-align: center; font-size: 18px; font-weight: normal;">Verified Clear</th>';
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
$start_end = $start.' - '.$end;
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Flat No</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$flat_no.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Street / Road</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$street.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Area</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$area.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">City / Town</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$city.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Pin Code</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$pin_code.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Nearest Landmark</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$nearest_landmark.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">State</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$state.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">DURATION OF STAY</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">CONTACT PERSON Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$person_mobile_number.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Select Relationship</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$person_name .'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Mobile Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$relationship.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';



$html .='</tbody>';
$html .='</table>';
$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
 /*$html .='<td style="padding-bottom: 20px;color: #171515; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 20px;"> </td>'; */
$html .='<td style="padding-bottom: 20px; color: #171515; width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 20px;">'.$table['present_address']['verification_remarks'].'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; color: #171515; width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 20px;">'.$table['present_address']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';
/*$html .='<div style="margin-top: 5px; margin-right:80px; margin-left: 80px;">
<p style="font-size:12px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
</div>';*/


  
}


if (isset($table['previous_address']['previos_address_id'])) {

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
          $verification_remarks = json_decode($table['previous_address']['verification_remarks']);
  

   
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Previous Address</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;">Completed</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: #1F7705;color: #ffffff; text-align: center; font-size: 18px; font-weight: normal;">Verified Clear</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';

             
$verification_remark ='';
                // echo json_encode($flat_no);
foreach ($flat_no as $flat_key => $value) { 
    $verification_remark = isset($verification_remarks[$flat_key]['verification_remarks'])?$verification_remarks[$flat_key]['verification_remarks']:'';

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

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Flat No</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$flat_no.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Street / Road</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$street.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Area</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$area.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">City / Town</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$city.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Pin Code</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$pin_code.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Nearest Landmark</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$nearest_landmark.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">State</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$state.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">DURATION OF STAY</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">CONTACT PERSON Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$person_mobile_number.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Select Relationship</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$person_name .'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Mobile Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$relationship.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';


    }


$html .='</tbody>';
$html .='</table>';
$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
 /*$html .='<td style="padding-bottom: 20px;color: #171515; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 20px;"> </td>'; */
$html .='<td style="padding-bottom: 20px; color: #171515; width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 20px;">'.$verification_remark.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; color: #171515; width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 20px;">'.$table['previous_address']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';
/*$html .='<div style="margin-top: 5px; margin-right:80px; margin-left: 80px;">
<p style="font-size:12px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
</div>';*/

 
}



if (isset($table['previous_employment']['previous_emp_id'])) {
    // $html .='<div style="page-break-after: always;"></div>';

     $desigination = json_decode($table['previous_employment']['desigination'],true);
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
          $remark_hr_name = json_decode($table['current_employment']['remark_hr_name'],true);
          $verification_remarks = json_decode($table['current_employment']['verification_remarks'],true);
   
  
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 20px;"> <i style="color: #381653; margin-right: 15px;" class="fa fa-signal" aria-hidden="true"></i> Previous Employment</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 10%; font-size: 18px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 20px; color: #381653;">Completed</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Component Detail</th>';
$html .='<th style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 18px; font-weight: normal;">Result</th>';
$html .='<th style="background-color: #1F7705;color: #ffffff; text-align: center; font-size: 18px; font-weight: normal;">Verified Clear</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';


               
 foreach ($desigination as $prev => $val) { 

    $remark_hr_nam = isset($remark_hr_name[$prev]['remark_hr_name'])?$remark_hr_name[$prev]['remark_hr_name']:'';
    $verification_remark = isset($verification_remarks[$prev]['verification_remarks'])?$verification_remarks[$prev]['verification_remarks']:'';
              

$start = isset($joining_date[$prev]['joining_date'])?$joining_date[$prev]['joining_date']:'';
$end = isset($relieving_date[$prev]['relieving_date'])?$relieving_date[$prev]['relieving_date']:'';

$start_end = $start.' - '.$end;

 $desigination = isset($desigination[$prev]['desigination'])?$desigination[$prev]['desigination']:''; 
 $department = isset($department[$prev]['department'])?$department[$prev]['department']:'';
 $employee_id = isset($employee_id[$prev]['employee_id'])?$employee_id[$prev]['employee_id']:''; 
 $company =  isset($company_name[$prev]['company_name'])?$company_name[$prev]['company_name']:'';

 $addr =  isset($address[$prev]['address'])?$address[$prev]['address']:'';

 $ctc =  isset($annual_ctc[$prev]['annual_ctc'])?$annual_ctc[$prev]['annual_ctc']:'';
 $leave = isset($reason_for_leaving[$prev]['reason_for_leaving'])?$reason_for_leaving[$prev]['reason_for_leaving']:'';
 $manager = isset($reporting_manager_name[$prev]['reporting_manager_name'])?$reporting_manager_name[$prev]['reporting_manager_name']:'';
 $contact = isset($table['current_employment']['reporting_manager_contact_number'])?$table['current_employment']['reporting_manager_contact_number']:'';  
 $designation =  isset($reporting_manager_desigination[$prev]['reporting_manager_desigination'])?$reporting_manager_desigination[$prev]['reporting_manager_desigination']:''; 
 $hr_name = isset($hr_name[$prev]['hr_name'])?$hr_name[$prev]['hr_name']:'';

 $hr_contact = isset($hr_contact_number[$prev]['hr_contact_number'])?$hr_contact_number[$prev]['hr_contact_number']:''; 

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Desigination</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$desigination.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Department</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$department.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Employee ID</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$employee_id.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Company Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$company.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Address</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$addr.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Annual CTC</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$ctc.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reason For Leaving</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$leave.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Joining - relieving Date</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reporting Manager Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$manager.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reporting Manager Designation</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$designation.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">Reporting Manager Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">HR Contact Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$hr_name.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;">HR Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;">'.$hr_contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 20px;" ><i class="fa fa-check" aria-hidden="true"></i></td>';
$html .='</tr>';
 
            }
             

     
$html .='</tbody>';
$html .='</table>';
$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 20px;color: #171515; width: 16%; font-size: 18px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; color: #381653; font-weight: bold; font-size: 20px;">'.$table['current_employment']['remark_hr_name'].'</td>';
$html .='<td style="padding-bottom: 20px; color: #171515; width: 17%; font-size: 18px;" >Verifier\'s Remarks</td>';
$html .='<td style="padding-bottom: 20px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 20px;">'.$table['current_employment']['verification_remarks'].'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; color: #171515; width: 16%; font-size: 18px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 20px;">'.$table['current_employment']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';
$html .='</div>';
/*$html .='<div style="margin-top: 5px; margin-right:80px; margin-left: 80px;">
<p style="font-size:12px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
</div>';*/
$html .='<div style="page-break-after: always;"></div>';

$aadhar_img = explode(',', $table['document_check']['adhar_doc']); 
$img_a = 'data:image/jpg;base64,'.base64_encode(file_get_contents(base_url().'../uploads/aadhar-docs/'.$aadhar_img[0]));
$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 20px;color: #171515; font-size: 18px;width:20%"></td>';
$html .='<td align="center" style="padding-bottom: 20px;color: #171515; font-size: 18px;width:80%"><img width="80%" src="'.$img_a.'" ><br/><img width="80%" src="'.$img_a.'" ><img width="80%" src="'.$img_a.'" ><img width="80%" src="'.$img_a.'" ><br/><img width="80%" src="'.$img_a.'" ></td>';
$html .='<td style="padding-bottom: 20px;color: #171515; font-size: 18px;width:20%"></td>';
$html .='</tr>';
$html .='</table>';
 
}

 
$html .='</main></body>
        </html>'; 
$pdf->loadHtml($html,'UTF-8');
$pdf->set_paper('a3', 'portrait');// or landscape
$pdf->render();
$pdf->stream("invoice.pdf");
?>
 