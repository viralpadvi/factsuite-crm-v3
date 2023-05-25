<?php 
use Dompdf\Dompdf;
$pdf = new DOMPDF();
 
$data = $this->outPutQcModel->getSingleAssignedCaseDetails($candidate_id);

$html_tr ='';
foreach ($data as $key => $value) {
    $status = '';
    $verify ='';
    if ($value['component_status'] == '0') {
 
        $status = '<span class="text-warning">Pending<span>'; 
        $verify ='<span class="text-warning">Verified Not Clear<span>';
    }else if ($value['component_status'] == '1') {
         
        $status = '<span class="text-info">Form Filled<span>'; 
        $verify ='<span class="text-info">Verified Not Clear<span>';
    }else if ($value['component_status'] == '2') {
         
        $status = '<span class="text-success">Completed<span>'; 
        $verify ='<span class="text-success">Verified Clear<span>';
    }else if ($value['component_status'] == '3') {
         
        $status = '<span class="text-danger">Insufficiency<span>'; 
        $verify ='<span class="text-danger">Verified Not Clear<span>';
    }else if ($value['component_status'] == '4') {
       
        $status = '<span class="text-success">Approved<span>'; 
        $verify ='<span class="text-success">Verified Clear<span>';
    }else{

        $status = '<span class="text-success">Already approved<span>'; 
        $verify ='<span class="text-success">Verified Clear<span>';
    }
$html_tr .='<tr>';
$html_tr .='<td style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;" width="40%" >'.$value['component_name'].'</td>';
// $html_tr .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"  width="20%" >BE</td>';
$html_tr .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;text-align:center;"  width="30%" >'.$status.'</td>';
$html_tr .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold; font-size: 18px;text-align:center;"  width="30%"  >'.$verify.'</td>';
$html_tr .='</tr>';
}

$html = '';
$html .='<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">';
$html .= "<style>
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
left: 10px;
top: 10%;
}
</style>";
$html .='<style>  @page { margin: 0in; }';
$html .='</head>';
$html .='<body>';
/*$html .='<img style="display: block; margin-left: auto;margin-right: auto; width: 20%; margin-top: 50px;" src="./imgae/FactSuite-logo.png" alt="" srcset="">';*/
$html .='<p style="text-align: center; font-size: 30px; color: #100F0F; font-weight: bold; margin-top: 10px; margin-bottom: 0px;">
Employee Background Verification <br> Final Report</p>
<small style="float: right; font-size: 15px; font-weight: normal; margin-top: -20px; margin-right: 11%;">Page 1</small> 
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
<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">'.$html_tr.'
</tbody>
</table>
</div>
<div style="margin-top: 70px; margin-right:80px; margin-left: 80px;">
<p style="font-size:13px; font-weight: bold; color: #1A1919;">Disclaimer: <small style="font-size:13px; font-weight: normal;" >- QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.</small> </p>
</div>
</body>
</html>';
 
$pdf->loadHtml($html,'UTF-8');
$pdf->set_paper('a3', 'portrait');// or landscape
$pdf->render();
$pdf->stream("invoice.pdf");
?>
<!-- <tr>
<td style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;" width="30%" >Highest Education</td>
<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"  width="20%" >BE</td>
<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"  width="25%" >Completed</td>
<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold; font-size: 18px;"  width="25%"  >Verified Clear</td>
</tr>
<tr>
<td style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;"  width="30%" >Last Employment</td>
<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"  width="20%" >Ramco System Limited</td>
<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"  width="25%" >Completed</td>
<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold; font-size: 18px;"   width="25%" >Verified Clear</td>
</tr>
<tr>
<td style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;"  width="30%" >Global Database</td>
<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"  width="20%" >Global Database</td>
<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 18px; color: #381653;"  width="25%" >Completed</td>
<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold; font-size: 18px;"   width="25%" >Verified Clear</td>
</tr>
<tr>
<td style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 18px;"  width="30%" >Document Check</td>
<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;"  width="20%" >PAN Card</td>
<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 18px; color: #381653;"  width="25%" >Completed</td>
<td style="color: #1F7705; padding-bottom: 10px 0px; font-weight: bold; font-size: 18px;"   width="25%" >Verified Clear</td>
</tr> -->