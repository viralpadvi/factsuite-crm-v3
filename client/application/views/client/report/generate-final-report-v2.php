<?php

use Dompdf\Dompdf;
$pdf = new DOMPDF();


$canvas = $pdf->get_canvas();
$page_numbers = $canvas->page_text(0, 0, "{PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

$fs_invoice_logo_path = base_url().'assets/client/images/FactSuite-logo.png';
$fs_invoice_logo_type = pathinfo($fs_invoice_logo_path, PATHINFO_EXTENSION);
$fs_invoice_logo_data = file_get_contents($fs_invoice_logo_path);
$fs_invoice_logo_base64 = 'data:image/' . $fs_invoice_logo_type . ';base64,' . base64_encode($fs_invoice_logo_data);

$tick_mark_img_path = base_url().'assets/client/images/marks/check16px.png';
$tick_mark_img_type = pathinfo($tick_mark_img_path, PATHINFO_EXTENSION);
$tick_mark_img_data = file_get_contents($tick_mark_img_path);
$tick_mark_img_base64 = 'data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data);
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';

// $sample_attachment_img_path = 'assets/client/images/marks/sample-pdf-attachment.png';
// $sample_attachment_img_type = pathinfo($sample_attachment_img_path, PATHINFO_EXTENSION);
// $sample_attachment_img_data = file_get_contents($sample_attachment_img_path);
// $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);


  function get_date($date){ 
    if ($date !='' && $date !=null && $date !='undefined' && $date !='-') { 
        $dates = str_replace('/','-', $date);
         return  date("d-m-Y", strtotime($dates));
    }

     return  'NA';
  }

   function get_year($date){ 
    if ($date !='' && $date !=null && $date !='undefined' && $date !='-') { 
        $dates = str_replace('/','-', $date);
         return  date("Y", strtotime($dates));
    }

     return  'NA';
  }


$form_values = json_decode($candidate[0]['candidaetData']['form_values'],true);
$form_values = json_decode($form_values,true); 
$data = $this->caseModel->getSingleAssignedCaseDetails($candidate_id);
$logo =  'data:image/jpg;base64,'.base64_encode(file_get_contents(base_url().'assets/client/images/FactSuite-logo.png'));
 
$file_name_final = $candidate[0]['candidaetData']['candidate_id'].'-'.trim(strtolower($candidate[0]['candidaetData']['first_name'])).'_'.trim(strtolower($candidate[0]['candidaetData']['last_name'])).'-'.'final-report.pdf';
// $candidate_final_name = $candidate[0]['candidaetData']['first_name'].' '.$candidate[0]['candidaetData']['last_name'];
$title = isset($candidate[0]['candidaetData']['title'])?ucfirst($candidate[0]['candidaetData']['title']):'';
$candidate_final_name = $title.' '.$candidate[0]['candidaetData']['first_name'].' '.$candidate[0]['candidaetData']['last_name'];
$employee = 'NA';
$tv_or_ebgv = isset($data[0]['tv_or_ebgv'])?$data[0]['tv_or_ebgv']:'0';
if ($candidate[0]['candidaetData']['employee_id'] !='') {
   $employee = $candidate[0]['candidaetData']['employee_id'];
}

$html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Background Verification Report</title>
    <style type="text/css">
        @import url("https://fonts.googleapis.com/css2?family=Poppins&display=swap");

        body {
            font-family: "Poppins", sans-serif;
            width: 95%;
        }

        @page {
            width: 95%;
            margin: 70px 25px; 
        }
        
        .page-break {
            page-break-after: always;
        }
        

        header {
            position: fixed;
            top: -70px;
            left: 0px;
            right: 0px;
            margin-bottom: -30px;
            height: 160px;
            display: block;
        }

        footer {
            position: fixed;
            left: 0px;
            right: 0px;
            height: 50px;
            bottom: 0px;
            margin-bottom: -50px;
        }

        .container-fluid {
            width: 100%;
        }

        .w-100 {
            width: 100%;
        }

        .table {
            width: 100%;
        }

        .fs-invoice-logo-td {
            text-align: center;
        }

        .fs-invoice-logo-td img {
            width: 30%;
            margin-bottom: 60px;
            padding: 30px 50px;
        }

        .row::after {
            content: "";
            clear: both;
        }

        .w-50 {
            width: 50%;
            float: left;
        }

        .text-right {
            text-align: right
        }

        .text-center {
            text-align: center;
        }

        .verification-report-main-header {
            font-weight: 700;
            font-size: 32px;
            color: #5A3C81;
            padding: 50px 0;
        }

        .bg-gray {
            background: #F9F9F9;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            padding: 20px;
        }

        .info-div-txt {
            font-weight: 700;
            font-size: 25px;
            color: #11181C;
        }

        .report-details-td {
            font-weight: 400;
            font-size: 18px;
            color: #262626;
            padding: 10px 0;
        }

        .report-details-td-2 {
            font-weight: 700;
        }

        .report-details-td-1 {
            padding-top: 25px;
        }

        .hr {
            color: #262626;
            opacity: 0.3;
        }

        .report-details-width-1 {
            width: 60%;
        }

        .report-details-width-2 {
            width: 40%;
        }

        .margin-1 {
            margin-top: 40px
        }

        .copyright-ftr-txt {
            font-weight: bold;
            font-size: 12px;
            text-align: center;
            color: #262626;
        }

        .ftr-tbl-txt-1 {
            font-weight: 700;
            font-size: 12px;
            color: #262626;
        }

        .ftr-tbl-txt-1:before  { 
                content: "*Subject to disclaimer"; 
        }

        .ftr-tbl-txt-steps {
            font-weight: 700;
            font-size: 12px;
            color: #5A3C81;
            text-align: right; 
        }

        .info-div-txt-2 {
            margin-bottom: 20px;
        }

        .classification-red,
        .classification-verified-discrepancy {
             
            border: 0px solid;
            border-radius: 24px;
            padding: 5px 20px;
            color: #FFFFFF;
            display: block;
            text-align: center;
            margin: 0 0 0 10px;
            font-size: 15px;
        }

        .margin-right-1 {
            margin-right: 15px;
        }

        .classification-and-report-result-txt {
            padding: 5px 0;
            font-weight: 700;
            font-size: 15px;
            color: #262626;
        }

        .border-vr-1 {
            opacity: 0.3;
            color: #000000;
            transform: rotate(180deg);
            margin: 0 15px 0 0;
            height: 40px;
        }

        .report-details-td-3 {
            font-weight: 700;
            font-size: 25px;
            color: #11181C;
        }

        .report-details-td-4 {
            font-size: 20px;
            color: #262626;
        }

        .table-2 {
            width: 100%;
            margin-top: 15px;
        }

        .table-2 tr th {
            background: #5A3C81;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 15px;
            text-align: left;
            padding: 10px 7px;
        }

        .table-2 tr td {
            padding: 12px 7px;
            // border-bottom: 1px solid #F1F3F5;
            border-collapse: collapse;
            color: #11181C;
        }

        .table-2 tr th:first-child {
            border-radius: 4px 0 0 4px;
        }

        .table-2 tr th:last-child {
            border-radius: 0 4px 4px 0;
        }

        .component-status {
            font-weight: 400;
            font-size: 15px;
        }

        .text-green {
            color: #16B109;
        }

        .text-red {
            color: #F8163E;
        }

        .component-status-result {
            font-weight: 400;
            font-size: 15px;
        }

        .sr-no {
            width: 5%;
        }

        .tick-mark-img {
            height: 25px;
            width: 25px;
            padding-left: 20px;
        }

        .font-weight-bold {
            font-weight: 700;
        }

        .component-attachment-img {
            width: 80%;
        }

        .end-of-report-txt {
            font-weight: 700;
            font-size: 18px;
            text-transform: uppercase;
            color: #262626;
            text-align: center;
        }

        

        .disclaimer-txt {
            margin-top: 20px;
            font-size: 12px;
            color: #262626;
        }

        .disclaimer-txt span {
            display: block;
            font-weight: 700;
        }

        .ftr-tbl-txt-steps:after { 
             content: "Page " counter(page)"/_PG";
        }
    </style>
</head>
<body>
    <header>
        <div class="container-fluid">
            <table class="table">
                <tr>
                    <td class="fs-invoice-logo-td">
                        <img src="'.$fs_invoice_logo_base64.'">
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <table class="table">
            <tr> 
             <td class="ftr-tbl-txt-1"></td>
                <td  class="ftr-tbl-txt-steps"> </td> 
            </tr>
        </table>
        <hr>
        <p class="copyright-ftr-txt">www.factsuite.com • Factsuite ©  '.date("Y").' All Rights reserved</p>
    </footer>

    <main>
        <div class="container-fluid">
            <table class="table text-center">
                <tr>
                    <td class="verification-report-main-header">&nbsp;&nbsp;&nbsp;&nbsp;Background Verification Report</td>
                </tr>
            </table>
        </div>

   <div class="container-fluid bg-gray">
            <div class="info-div-txt">Case Details</div>
            <table class="table" cellspacing="0">
                <tr>
                    <td class="report-details-td report-details-td-1 report-details-width-1">Case ID</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">'.$candidate[0]['candidaetData']['candidate_id'].'</td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr"></td>
                </tr>


                 <tr>
                    <td class="report-details-td report-details-td-1">Client Name</td>
                    <td class="report-details-td report-details-td-2">'.ucwords($data[0]['client_name']).'</td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr"></td>
                </tr>


                <tr>
                    <td class="report-details-td report-details-width-1">Requested Date</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">'.get_date($candidate[0]['candidaetData']['case_submitted_date']).'</td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr"></td>
                </tr>
                <tr>
                    <td class="report-details-td report-details-width-1">Completed Date</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">'.get_date($candidate[0]['candidaetData']['report_generated_date']).'</td>
                </tr>';
                
             if ($tv_or_ebgv !='1') {
                 $html .='<tr>
                    <td colspan="2"><hr class="hr"></td>
                </tr>
                <tr>
                    <td class="report-details-td report-details-width-1">Date of Joining</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">'.get_date($candidate[0]['candidaetData']['date_of_joining']).'</td>
                </tr>';
                    
                }

                
            $html .='</table>
        </div>';


$html .='<div class="container-fluid margin-1 bg-gray">
            <div class="info-div-txt">Personal Details</div>
            <table class="table" cellspacing="0">
                
                <tr>
                    <td class="report-details-td report-details-td-1 report-details-width-1">Candidate Name</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">'.ucwords($candidate_final_name).'</td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr"></td>
                </tr>
                <tr>
                    <td class="report-details-td report-details-width-1">Date of Birth</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">'.get_date($candidate[0]['candidaetData']['date_of_birth']).'</td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr"></td>
                </tr>';

                   if ($tv_or_ebgv !='1') {
            $html .='<tr>
                    <td class="report-details-td report-details-width-1">Employee Id</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">'.$employee.'</td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr"></td>
                </tr>';
            }
                
               $html .=' <tr>
                    <td class="report-details-td report-details-width-1">Father’s Name</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">Mr. '.ucwords($candidate[0]['candidaetData']['father_name']).'</td>
                </tr>
            </table>
        </div>

       
        <div class="page-break"></div>';

 
 
$form_analyst_status = array();
if (count($candidate_status) > 0) { 
    foreach ($candidate_status as $kc => $comp) {
        array_push($form_analyst_status, isset($comp['analyst_status'])?$comp['analyst_status']:0);

    }
}
$report_type = "Final Report";
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$text_status = "GREEN REPORT";
$overoll = 'Completed';
if (array_intersect(['1','0'], $form_analyst_status)) {
    $overoll = 'In-Progress';
}
if (in_array('7', $form_analyst_status)) {
    $verifiy_img = "Verified Discrepancy";
    // $verifiy_img = '<img height="400%" src="'.base_url().'assets/client/images/marks/7.png" >';
   $color_code = '#e20404';
    $bgcolor_code = '#f77474'; 
    $green_img = base_url().'assets/client/images/marks/red.png';
    $text_status = "RED REPORT";
}else if(array_intersect(['6','9'], $form_analyst_status)){
     if (in_array('6',$form_analyst_status)) {
        $verifiy_img = "Unable to Verify";
        // $verifiy_img = '<img height="400%" src="'.base_url().'assets/client/images/marks/04.png" >';
    }else if (in_array('9',$form_analyst_status)) { 
     $verifiy_img = "Closed insufficiency";
      // $verifiy_img = '<img height="400%" src="'.base_url().'assets/client/images/marks/09.png" >';
    }else{
       $verifiy_img = "Unable to Verify";
       // $verifiy_img = '<img height="400%" src="'.base_url().'assets/client/images/marks/04.png" >';  
    }
    $color_code = '#FF8C00';
    $bgcolor_code = '#FFD4AE';
    $green_img = base_url().'assets/client/images/marks/orange.png';
    $text_status = "ORANGE REPORT";
}else if(array_intersect(['4'], $form_analyst_status)){
    $verifiy_img = "Verified Clear";
    // $verifiy_img = '<img height="400%" src="'.base_url().'assets/client/images/marks/07.png" >';  
     $color_code = '#1F7705';
    $bgcolor_code = '#C5FCB4';  
    $text_status = "GREEN REPORT";
}else if(array_intersect(['5'], $form_analyst_status)){
    $verifiy_img = "Stop Check";
    // $verifiy_img = '<img height="400%" src="'.base_url().'assets/client/images/marks/05.png" >';
     $color_code = '#FF8C00';
    $bgcolor_code = '#FFD4AE';
    $green_img = base_url().'assets/client/images/marks/orange.png';
    $text_status = "ORANGE REPORT";
}else if(in_array('0', $form_analyst_status)){
    // $color_code = '#1F7705';

     $color_code = '#FFFF00';
    // $bgcolor_code = '#FAFAD2';  
    $bgcolor_code = '#FFD4AE';
    $green_img = base_url().'assets/client/images/marks/yellow.png';
    $text_status = "YELLOW REPORT";
    $report_type = "Interim Report";
}else if(array_intersect(['8','1','3'], $form_analyst_status)){
      $color_code = '#009fff';
    $bgcolor_code = '#62c4ff';
    $text_status = "BLUE REPORT";
     // $report_type = "Intrim Report";
    $green_img = base_url().'assets/client/images/marks/blue.png';
} 
 $candidate_final_name = $candidate[0]['candidaetData']['first_name'].' '.$candidate[0]['candidaetData']['last_name'];

$verification_service_name = 'Employee Background Verification';
if ($candidate[0]['candidaetData']['candidate_details_added_from'] == 0) {
    $factsuite_main_website = $this->load_Database_Model->load_database();
    $website_purchased_package_details = $factsuite_main_website->where('cart_id',$candidate[0]['candidaetData']['package_name'])->get('package_cart')->row_array();
    $verification_service_name = json_decode($website_purchased_package_details['package_cart_details'],true)['service_name'];
}



$html .='<div class="container-fluid margin-1 bg-gray">
            <div class="info-div-txt info-div-txt-2">Verification Result</div>
            <table cellspacing="0">
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td class="classification-and-report-result-txt">
                                    Report Classification:
                                </td>
                                <td class="report-details-td">
                                    <span class="classification-red margin-right-1" style="background : '.$color_code.'">'.$text_status.'</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table>
                            <tr>
                                <td><hr class="border-vr-1"></td>
                                <td class="classification-and-report-result-txt">
                                    Report Result:
                                </td>
                                <td class="report-details-td">
                                    <span class="classification-verified-discrepancy margin-right-1" style="background : '.$color_code.'" >'.$verifiy_img.'</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>';



$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">Executive Summary</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Overall status: <span >'.$overoll.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th width="60%">Component Type</th>
                    <th>Status</th>
                    <th>Result</th>
                </tr>';


     
    $component_get = array();
    $components_array = array();
    $sl = 1;
                       
     foreach ($candidate_status as $key1 => $value1) {
        $status = 'Completed';
        $verify ='';
         $vstatus = isset($value1['analyst_status'])?$value1['analyst_status']:'0';
        if ( $vstatus == '0') { 
            $status = '<span style="color:black;">In-Progress</span>'; 
            $verify ='<span style="color:black;">In-Progress</span>';
        }else if ( $vstatus == '1') {
             
            $status = '<span style="color:black;">In-Progress</span>'; 
            $verify ='<span style="color:black;">In-Progress</span>';
        }else if ( $vstatus == '2') {
             
            $status = '<span style="color:green;">Completed</span>'; 
            $verify ='<span style="color:green;">Verified Clear</span>';
        }else if ( $vstatus == '3') {
             
            $status = '<span style="color:black;">Completed</span>'; 
            $verify ='<span style="color:black;">Insufficiency</span>';
        }else if ( $vstatus == '4') {
           
            $status = '<span style="color:green;">Completed</span>'; 
            $verify ='<span style="color:green;">Verified Clear</span>';
        }else if ( $vstatus == '5') {
           
            $status = '<span style="color:orange;">Stop Check</span>'; 
            $verify ='<span style="color:orange;">Stop Check</span>';
        }else if ($vstatus == '6') {
           
            $status = '<span style="color:green;">Completed</span>'; 
            $verify ='<span style="color:orange;">Unable to Verify</span>';
        }else if ($vstatus == '7') {
           
            $status = '<span style="color:green;">Completed</span>'; 
            $verify ='<span style="color:red;">Verified Discrepancy</span>';
        }else if ($vstatus == '8') {
           
            $status = '<span style="color:green;">Completed</span>'; 
            $verify ='<span style="color:green;">Verified Clear</span>';
        }else if ($vstatus == '9') {
           
            $status = '<span style="color:green;">Completed</span>'; 
            $verify ='<span style="color:orange;">Closed Insufficiency</span>';

        }else if ( $vstatus == '10') {
           
            $status = '<span style="color:black;">Completed</span>'; 
            $verify ='<span style="color:black;">QC-error</span>';
        }else{

            $status = '<span style="color:green;">Completed</span>'; 
            $verify ='<span style="color:green;">Verified Clear</span>';
        }
 
    if (!isset($_GET['components'])) { 
    if (in_array($value1['component_id'],[1,2,3,4,7,10,11,12,27])) {
        
      $component_name = $value1['component_name'].' '.$value1['formNumber'];
        if ($value1['component_name'] =='Criminal Status') {
           $component_name = 'Criminal History '.$value1['formNumber'];
        }

        if ($value1['component_id'] == '3'  || $value1['component_id'] == '27') {
            $component_name = isset($value1['value_type'])?$value1['value_type']:'';
        }else if($value1['component_id'] == '7'){
             $educ = isset($value1['value_type'])?$value1['value_type']:'';

             $component_name = 'Education - '.$educ;
        }
    }else{
      $component_name = $value1['component_name'];  
    }
      if ($value1['component_name'] =='Adverse Media/Media Database Check') {
           $component_name = 'Adverse Media/Database Check ';
      }
        if ($value1['component_name'] =='Health Checkup Check') {
           $component_name = 'Health Checkup ';
      }
    }else{
        $component_name = isset($component_get[$key1])?$component_get[$key1]:$value1['component_name'];
    }
    $row['id'] = $value1['component_id'].'_'.$value1['formNumber'];
    $row['component_name'] = $component_name;
    array_push($components_array,$row);
     
     if ($sl==14) {
       $html .='</table></div>';
       $html .='<div class="page-break"></div>';
       $html .='<div class="container-fluid margin-1 bg-gray"> 
            <table class="table-2" cellspacing="0" > ';
                
     }
    
    $html .='<tr >';
     $html .='<td class="sr-no">'.($sl++).'</td>';
    $html .='<td  width="60%">';
    $html .=$component_name;
    $html .='</td>'; 
    $html .='<td><span class="component-status text-green">';
    $html .= $status;   
    $html .='</span></td>';
    $html .='<td><span class="component-status-result text-green">'; 
    $html .=$verify; 
    $html .='</span></td>';
    $html .='</tr>';

    } 



                /*<tr>
                    <td class="sr-no">1.</td>
                    <td>Criminal History 1</td>
                    <td><span class="component-status text-green">Completed</span></td>
                    <td><span class="component-status-result text-green">Verified Clear</span></td>
                </tr>
                <tr>
                    <td class="sr-no">2.</td>
                    <td>Court Record</td>
                    <td><span class="component-status text-green">Completed</span></td>
                    <td><span class="component-status-result text-red">Unable to Verify</span></td>
                </tr>*/
            $html .='</table>
        </div>';





if (isset($table['criminal_checks']['criminal_check_id'])) {

    // print_r($table['criminal_checks']); 
     $address = json_decode($table['criminal_checks']['address'],true); 
     $re_address = json_decode($table['criminal_checks']['remark_address'],true); 
     $states = json_decode($table['criminal_checks']['state'],true);
     $re_states = json_decode($table['criminal_checks']['remark_state'],true);
     $pin_code = json_decode($table['criminal_checks']['pin_code'],true);
     $re_pin_code = json_decode($table['criminal_checks']['remark_pin_code'],true);
     $city = json_decode($table['criminal_checks']['city'],true); 
     $re_city = json_decode($table['criminal_checks']['remark_city'],true); 
     $verification_remarks = json_decode($table['criminal_checks']['verification_remarks'],true); 
     $verified_date = json_decode($table['criminal_checks']['verified_date'],true);  
      $analyst_status = explode(',',$table['criminal_checks']['analyst_status']); 

      $remark_period_of_stay = json_decode($table['criminal_checks']['remark_period_of_stay'],true); 
      $remark_gender = json_decode($table['criminal_checks']['remark_gender'],true);
 
    $approved_doc = json_decode($table['criminal_checks']['approved_doc'],true);

    
$remarks ='';
$x = 0;
$in = 1;
foreach ($address as $key => $value) { 

    $color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status[$key])?$analyst_status[$key]:0; 
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
            $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
        $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
$index = array_search('1_'.$in,array_column($components_array, 'id'));
 $in++; 
 $html .='<div class="page-break"></div>';
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';


                 $remarks = isset($verification_remarks[$key]['verification_remarks'])?$verification_remarks[$key]['verification_remarks']:''; 
            $city_sub = isset($city[$key]['city'])?$city[$key]['city']:"-";
            $re_city_sub = isset($re_city[$key]['city'])?$re_city[$key]['city']:"-";
            $address_sub = isset($value['address'])?$value['address']:"-";
            $re_address_sub = isset($re_address[$key]['address'])?$re_address[$key]['address']:"-";
            $state_sub = isset($states[$key]['state'])?$states[$key]['state']:"-";
            $re_state_sub = isset($re_states[$key]['state'])?$re_states[$key]['state']:"-";
            $pincode_sub = isset($pin_code[$key]['pincode'])?$pin_code[$key]['pincode']:"-";
            $re_pincode_sub = isset($re_pin_code[$key]['pincode'])?$re_pin_code[$key]['pincode']:"-";
            $remark_period_of_stay_r = isset($remark_period_of_stay[$key]['remark_period_of_stay'])?$remark_period_of_stay[$key]['remark_period_of_stay']:"-";
            $remark_genders = isset($remark_gender[$key]['remark_gender'])?$remark_gender[$key]['remark_gender']:"-";
            $remark_gender_r = '-';
            if ($remark_genders == '1') {
              $remark_gender_r = 'Female';
            }else if($remark_genders == '0'){
               $remark_gender_r = 'Male'; 
            }
            $remark_gender_r =  $candidate[0]['candidaetData']['gender'];


            $verified_dates = isset($verified_date[$key]['verified_date'])?$verified_date[$key]['verified_date']:"";
            $Address_title_name = "Address";
            $City_title_name = "City";
            $State_title_name = "State";
            $Pincode_title_name = "Pincode";

            $address_img = $check16px;
            $states_img = $check16px;
            $pin_code_img = $check16px;
            $city_img = $check16px;

             if (strtolower($address_sub) != strtolower($re_address_sub)) {
                 // $address_img = $re_address_sub; 
             }
            if (strtolower($state_sub) ==strtolower($re_state_sub)) {
                // $states_img =  $re_state_sub;
                // $state_sub = $re_state_sub;
            }
            if (strtolower($pincode_sub) != strtolower($re_pincode_sub)) {
                // $pin_code_img =  $re_pincode_sub;
                // $pincode_sub = $re_pincode_sub;
            }
            if (strtolower($city_sub) !=strtolower($re_city_sub)) {
                // $city_img = $re_city_sub;
                // $city_sub = $re_city_sub;
            }

         // $checks_stay = $check16px;
            $checks_stay = '';
            if (trim($remark_period_of_stay_r) =='-') {
                $checks_stay = '';
            }

           $html .='<tr><td class="sr-no">1.</td>';
            $html .='<td>'.$Address_title_name.'</td>';
            $html .='<td colspan="2">'.$address_sub.'</td>'; 
            $html .='<td  >'.$address_img.'</td>';
            $html .='</tr>';

            $html .='<tr><td class="sr-no">2.</td>';
            $html .='<td>'.$City_title_name.'</td>
            <td colspan="2">'.$city_sub.'</td>'; 
            $html .='<td  >'.$city_img.'</td>';
            $html .='</tr>';

           $html .='<tr><td class="sr-no">3.</td>';
            $html .='<td >'.$State_title_name.'</td>';
            $html .='<td colspan="2">'.$state_sub.'</td>'; 
            $html .='<td style="color: '.$color_code.';" >'.$states_img.'</td>';
            $html .='</tr>';

           $html .='<tr><td class="sr-no">4.</td>';
            $html .='<td >'.$Pincode_title_name.'</td>';
            $html .='<td colspan="2">'. $pincode_sub.'</td>'; 
            $html .='<td   style="color: '.$color_code.'; " >'.$pin_code_img.'</td>';
            $html .='</tr>';

           $html .='<tr><td class="sr-no">5.</td>';
            $html .='<td >Duration of Stay</td>';
            $html .='<td colspan="2">'. $remark_period_of_stay_r.'</td>'; 
            $html .='<td   style="color: '.$color_code.'; " >'.$checks_stay.'</td>';
            $html .='</tr>';

           $html .='<tr><td class="sr-no">6.</td>';
            $html .='<td >Gender</td>';
            $html .='<td colspan="2">'. $remark_gender_r.'</td>'; 
            $html .='<td   style="color: '.$color_code.'; " ></td>';
            $html .='</tr>';

     
           $html .='<tr><td class="sr-no">7.</td>';
            $html .='<td >Verified Date</td>';
            $html .='<td colspan="2">'.get_date($verified_dates).'</td>'; 
            $html .='<td style="color: '.$color_code.'; "></td>';
            $html .='</tr>';

            $html .='<tr><td class="sr-no">8.</td>';
            $html .='<td >Verification Remarks </td>';
            $html .='<td colspan="2">'. $remarks.'</td>'; 
            $html .='<td   style="color: '.$color_code.'; " ></td>';
            $html .='</tr>';

                $html .='
            </table>
        </div>';

$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';

if (isset($approved_doc[$key])) { 
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) {
     

    $max = 0;
     foreach ($approved_doc[$key] as $key1 => $value){ 
 $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
 
            } 
     }
    }
 }
    /*end for each*/



    }
    }
    }

    /*End Of the criminal check*/




if (isset($table['court_records']['court_records_id'])) {
 


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
      $analyst_status = explode(',',$table['court_records']['analyst_status']); 
  $approved_doc = json_decode($table['court_records']['approved_doc'],true); 
  $verified_date = json_decode($table['court_records']['verified_date'],true); 
  $v =0;
  $in =1;
     foreach ($address as $key => $value) { 
 

$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status[$key])?$analyst_status[$key]:0;
$font_color = '#FFFFFF';
 
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
            $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
 
$index = array_search('2_'.$in,array_column($components_array, 'id'));
 $in++; 
 $html .='<div class="page-break"></div>';
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';


                 $remarks = isset($verification_remarks[$key]['verification_remarks'])?$verification_remarks[$key]['verification_remarks']:''; 
            $city_sub = isset($city[$key]['city'])?$city[$key]['city']:"-";
            $re_city_sub = isset($re_city[$key]['city'])?$re_city[$key]['city']:"-";
            $address_sub = isset($value['address'])?$value['address']:"-";
            $re_address_sub = isset($re_address[$key]['address'])?$re_address[$key]['address']:"-";
            $state_sub = isset($states[$key]['state'])?$states[$key]['state']:"-";
            $re_state_sub = isset($re_states[$key]['state'])?$re_states[$key]['state']:"-";
            $pincode_sub = isset($pin_code[$key]['pincode'])?$pin_code[$key]['pincode']:"-";
            $re_pincode_sub = isset($re_pin_code[$key]['pincode'])?$re_pin_code[$key]['pincode']:"-";

            $verified_dates = isset($verified_date[$key]['verified_date'])?$verified_date[$key]['verified_date']:"";
            $Address_title_name = "Address";
            $City_title_name = "City";
            $State_title_name = "State";
            $Pincode_title_name = "Pincode";

            $address_img = $check16px;
            $states_img = $check16px;
            $pin_code_img = $check16px;
            $city_img = $check16px;

             if (strtolower($address_sub) != strtolower($re_address_sub)) {
                 // $address_img = $re_address_sub; 
             }
            if (strtolower($state_sub) ==strtolower($re_state_sub)) {
                // $states_img =  $re_state_sub;
                // $state_sub = $re_state_sub;
            }
            if (strtolower($pincode_sub) != strtolower($re_pincode_sub)) {
                // $pin_code_img =  $re_pincode_sub;
                // $pincode_sub = $re_pincode_sub;
            }
            if (strtolower($city_sub) !=strtolower($re_city_sub)) {
                // $city_img = $re_city_sub;
                // $city_sub = $re_city_sub;
            }

           $html .='<tr><td class="sr-no">1.</td>';
            $html .='<td>'.$Address_title_name.'</td>';
            $html .='<td colspan="2">'.$address_sub.'</td>'; 
            $html .='<td  >'.$address_img.'</td>';
            $html .='</tr>';

            $html .='<tr><td class="sr-no">2.</td>';
            $html .='<td>'.$City_title_name.'</td>
            <td colspan="2">'.$city_sub.'</td>'; 
            $html .='<td  >'.$city_img.'</td>';
            $html .='</tr>';

           $html .='<tr><td class="sr-no">3.</td>';
            $html .='<td >'.$State_title_name.'</td>';
            $html .='<td colspan="2">'.$state_sub.'</td>'; 
            $html .='<td style="color: '.$color_code.';" >'.$states_img.'</td>';
            $html .='</tr>';

           $html .='<tr><td class="sr-no">4.</td>';
            $html .='<td >'.$Pincode_title_name.'</td>';
            $html .='<td colspan="2">'. $pincode_sub.'</td>'; 
            $html .='<td   style="color: '.$color_code.'; " >'.$pin_code_img.'</td>';
            $html .='</tr>';

            $html .='<tr><td class="sr-no">5.</td>';
            $html .='<td >Verified Date</td>';
            $html .='<td colspan="2">'.get_date($verified_dates).'</td>'; 
            $html .='<td style="color: '.$color_code.'; "></td>';
            $html .='</tr>';

            $html .='<tr><td class="sr-no">6.</td>';
            $html .='<td >Verification Remarks </td>';
            $html .='<td colspan="2">'. $remarks.'</td>'; 
            $html .='<td   style="color: '.$color_code.'; " ></td>';
            $html .='</tr>';

                $html .='
            </table>
        </div>';

$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';

if (isset($approved_doc[$key])) { 
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) {
     

    $max = 0;
     foreach ($approved_doc[$key] as $key1 => $value){ 
  $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';

 
            } 
     }
    }
 }
    /*end for each*/



    }
    }
    }

    /*End Of the court check*/





if (isset($table['document_check']['document_check_id'])) {  

$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = explode(',', isset($table['document_check']['analyst_status'])?$table['document_check']['analyst_status']:0);
$font_color = '#FFFFFF';
 $approved_doc = json_decode($table['document_check']['approved_doc'],true);
 $verified_date = json_decode($table['document_check']['verified_date'],true);

if (isset($form_values['document_check'])) {
    $a =0;
    $in = 1;
     foreach ($form_values['document_check'] as $key => $v) { 

        $check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
        if ( $analyst[$key] == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst[$key] == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst[$key] == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst[$key] == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst[$key] == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst[$key] == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst[$key] == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst[$key] == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst[$key] == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst[$key] == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst[$key] == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

     // $check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$verified_dates = isset($verified_date[$key]['verified_date'])?$verified_date[$key]['verified_date']:'';
$doc_display = '';
$type_name = "";

$index = array_search('3_'.$in,array_column($components_array, 'id'));
 
if ($v =='2') { 
    $type_name = isset($components_array[$index]['component_name'] )?$components_array[$index]['component_name']:"Aadhar Card";
$aadhar_number = isset($table['document_check']['aadhar_number'])?$table['document_check']['aadhar_number']:'';
$html .='<div class="page-break"></div>';
 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';

                

$doc_display ='';
$doc_display .='<tr>';
$doc_display .='<td >1</td>';
$doc_display .='<td >Aadhar Number</td>';
$doc_display .='<td colspan="2">'.$aadhar_number.'</td>'; 
$doc_display .='<td style="color: '.$color_code.';"  >'.$check16px.'</td>';
$doc_display .='</tr>';
                
 $html .= $doc_display;

$html .='<tr>';
$html .='<td >2</td>'; 
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>'; 
$html .='<td style="color: '.$color_code.';"  ></td>';
$html .='</tr>';
  
$html .='</table>';
$html .='</div>';  




 
}
 

  // $check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
if ($v =='1') { 
    $type_name = isset($components_array[$index]['component_name'] )?$components_array[$index]['component_name']:"Pan Card";
$pan_number = isset($table['document_check']['pan_number'])?$table['document_check']['pan_number']:'';
$html .='<div class="page-break"></div>';
 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';

                

$doc_display ='';
$doc_display .='<tr>';
$doc_display .='<td >1</td>';
$doc_display .='<td >Pan Card</td>';
$doc_display .='<td colspan="2">'.$pan_number.'</td>'; 
$doc_display .='<td style="color: '.$color_code.';"  >'.$check16px.'</td>';
$doc_display .='</tr>';
                
 $html .= $doc_display;

$html .='<tr>';
$html .='<td >2</td>'; 
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>'; 
$html .='<td style="color: '.$color_code.';"  > </td>';
$html .='</tr>';
  
$html .='</table>';
$html .='</div>';  


 
}
 
 
if ($v == '3') { 
    $type_name = isset($components_array[$index]['component_name'] )?$components_array[$index]['component_name']:"Passport";
$passport_number = isset($table['document_check']['passport_number'])?$table['document_check']['passport_number']:'';
$html .='<div class="page-break"></div>';
 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';

                

$doc_display ='';
$doc_display .='<tr>';
$doc_display .='<td >1</td>';
$doc_display .='<td >Passport</td>';
$doc_display .='<td colspan="2">'.$passport_number.'</td>'; 
$doc_display .='<td style="color: '.$color_code.';"  >'.$check16px.'</td>';
$doc_display .='</tr>';
                
 $html .= $doc_display;

$html .='<tr>';
$html .='<td >2</td>'; 
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>'; 
$html .='<td style="color: '.$color_code.';"  > </td>';
$html .='</tr>';
  
$html .='</table>';
$html .='</div>';  


 
}

 
if ($v == '4') { 
    $type_name = isset($components_array[$index]['component_name'] )?$components_array[$index]['component_name']:"Voter ID Card";
$voter_id = isset($table['document_check']['voter_id'])?$table['document_check']['voter_id']:'';

$html .='<div class="page-break"></div>';
 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';

                

$doc_display ='';
$doc_display .='<tr>';
$doc_display .='<td >1</td>';
$doc_display .='<td >Voter ID Number</td>';
$doc_display .='<td colspan="2">'.$voter_id.'</td>'; 
$doc_display .='<td style="color: '.$color_code.';"  >'.$check16px.'</td>';
$doc_display .='</tr>';
                
 $html .= $doc_display;

$html .='<tr>';
$html .='<td >2</td>'; 
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>'; 
$html .='<td style="color: '.$color_code.';"  > </td>';
$html .='</tr>';
  
$html .='</table>';
$html .='</div>';  

 
}

 
if ($v == '5') { 
    $type_name = isset($components_array[$index]['component_name'] )?$components_array[$index]['component_name']:"SSN Card";
$ssn_number = isset($table['document_check']['ssn_number'])?$table['document_check']['ssn_number']:'';

$html .='<div class="page-break"></div>';
 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';


$doc_display ='';
$doc_display .='<tr>';
$doc_display .='<td >1</td>'; 
$doc_display .='<td >SSN Number</td>';
$doc_display .='<td colspan="2">'.$ssn_number.'</td>'; 
$doc_display .='<td style="color: '.$color_code.';"  >'.$check16px.'</td>';
$doc_display .='</tr>';
                
 $html .= $doc_display;

$html .='<tr>';
$html .='<td >2</td>'; 
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>'; 
$html .='<td style="color: '.$color_code.';"  > </td>';
$html .='</tr>';
  
$html .='</table>';
$html .='</div>';  

 
}

if (!in_array($analyst[$key],[0,1,5])) {

 
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';
$in++;



if ($v == '2') { 
if (isset($approved_doc[$key])) { 
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) {
     

$max = 0;
 foreach ($approved_doc[$key] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';  
                    if (isset($details[1])) {
                       if (intval($details[1]) > 780) {
                          $height = 'height="780"';
                       }
                    }
                $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        
        } 
 }
/*end for each*/

}
}
/*end if*/

}

/*end aadhar*/


if ($v == '1') { 
if (isset($approved_doc[$key])) { 
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) {
     

$max = 0;
 foreach ($approved_doc[$key] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
         $details = getimagesize($url); 
                     $height ='';  
                    if (isset($details[1])) {
                       if (intval($details[1]) > 780) {
                          $height = 'height="780"';
                       }
                    }
                $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
         
 
        } 
 }
/*end for each*/

}
}
/*end if*/
}
/*end pan*/


if ($v == '3') { 
if (isset($approved_doc[$key])) { 
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) { 
$max = 0;
 foreach ($approved_doc[$key] as $key1 => $value){ 
   $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
         $details = getimagesize($url); 
                     $height ='';  
                    if (isset($details[1])) {
                       if (intval($details[1]) > 780) {
                          $height = 'height="780"';
                       }
                    }
               $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/
}

/*end passport*/

/*voter id*/


if ($v == '4') { 
if (isset($approved_doc[$key])) { 
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) { 
$max = 0;
 foreach ($approved_doc[$key] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
         $details = getimagesize($url); 
                     $height ='';  
                    if (isset($details[1])) {
                       if (intval($details[1]) > 780) {
                          $height = 'height="780"';
                       }
                    }
                $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/
}

if ($v == '5') { 
if (isset($approved_doc[$key])) { 
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) { 
$max = 0;
 foreach ($approved_doc[$key] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
         $details = getimagesize($url); 
                     $height ='';  
                    if (isset($details[1])) {
                       if (intval($details[1]) > 780) {
                          $height = 'height="780"';
                       }
                    }

                $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/
}

}

} 

  
}

}



/*End of the Document */

/* Drug Test  */


if (isset($table['drugtest']['drugtest_id'])) {

 
   $candidate_name = json_decode($table['drugtest']['candidate_name'],true);
    $father_name = json_decode($table['drugtest']['father__name'],true);
    $dob = json_decode($table['drugtest']['dob'],true);
    $address = json_decode($table['drugtest']['address'],true);
    $remark_address = json_decode($table['drugtest']['remark_address'],true);
    $mobile_number = json_decode($table['drugtest']['mobile_number'],true); 
    $codes = json_decode($table['drugtest']['code'],true); 
    $verified_date = json_decode($table['drugtest']['verified_date'],true); 
    $verification_remarks = json_decode($table['drugtest']['verification_remarks'],true);
    // print_r($table['drugtest']);
     $analyst_status = explode(',',$table['drugtest']['analyst_status']); 
   $approved_doc = json_decode($table['drugtest']['approved_doc'],true); 
   $drug = $this->db->where_in('drug_test_type_id',$form_values['drug_test'])->get('drug_test_type')->result_array();
$a=0;
$in = 1;
foreach ($candidate_name as $key => $value) { 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
    // $html .='<br pagebreak="true" />';

$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status[$key])?$analyst_status[$key]:0; 
$font_color = '#FFFFFF';
 
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) { 
$index = array_search('4_'.$in,array_column($components_array, 'id'));
 $in++;
 $html .='<div class="page-break"></div>';
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
 $vremark = '';
    $candidate = $value['candidate_name']; 
    $father =  isset($father_name[$key]['father_name'])?$father_name[$key]['father_name']:'-'; 
    $birth = isset($dob[$key]['dob'])?$dob[$key]['dob']:'-';
    $contact = isset($mobile_number[$key]['mobile_number'])?$mobile_number[$key]['mobile_number']:'-';
    $addresss = isset($address[$key]['address'])?$address[$key]['address']:'-';
    $remark_addresss = isset($remark_addresss[$key]['address'])?$remark_addresss[$key]['address']:'-';
    $vremark = isset($verification_remarks[$key]['verification_remarks'])?$verification_remarks[$key]['verification_remarks']:'-';
    $verified_dates = isset($verified_date[$key]['verified_date'])?$verified_date[$key]['verified_date']:'-';

    $address_img = $check16px;
    if (strtolower($addresss) != strtolower($remark_addresss)) {
       $address_img = $remark_addresss;

    }
 
$html .='<tr>';
$html .='<td >1</td>';
$html .='<td >Drug Panel</td>';
$html .='<td colspan="2">'.$drug[$key]['drug_test_type_name'].'</td>';

$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td >2</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';

$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td >3</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$vremark.'</td>';

$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
 
$html .='</table>';

$html .='</div>';

$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';
 
if (isset($approved_doc[$key])) { 
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) {
     

$max = 0;
 foreach ($approved_doc[$key] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';  
                    if (isset($details[1])) {
                       if (intval($details[1]) > 650) {
                          $height = 'height="780"';
                       }
                    }
                $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

 }

}

}

/*end Drug*/

/* Global Database  */


 
if (isset($table['globaldatabase']['globaldatabase_id'])) {  

 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['globaldatabase']['analyst_status'])?$table['globaldatabase']['analyst_status']:0;
$font_color = '#FFFFFF';
 
   if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
  
$in = 1;
$index = array_search('5_'.$in,array_column($components_array, 'id'));
 $in++;
 
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
 
$name =  isset($table['globaldatabase']['candidate_name'])?$table['globaldatabase']['candidate_name']:'-'; 
$father =  isset($table['globaldatabase']['father_name'])?$table['globaldatabase']['father_name']:'-'; 
$dob =  isset($table['globaldatabase']['dob'])?$table['globaldatabase']['dob']:'-'; 
 
$html .='<tr>';
$html .='<td>1</td>'; 
$html .='<td >Verified Date</td>'; 
$html .='<td colspan="2">'.get_date($table['globaldatabase']['verified_date']).'</td>'; 
$html .='<td ></td>';
$html .='</tr>';

$html .='<tr>'; 
$html .='<td>2</td>'; 
$html .='<td  >Verification Remarks </td>';
$html .='<td colspan="2">'.$table['globaldatabase']['verification_remarks'].'</td>';
$html .='<td ></td>';
$html .='</tr>';
 
 
$html .='</table>';
 
$html .='</div>';
 $html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';


$approved_doc = explode(',', $table['globaldatabase']['approved_doc']);
if (isset($approved_doc)) { 
    if (count($approved_doc) > 0 && !in_array('no-file',$approved_doc)) {
     

$max = 0;
 foreach ($approved_doc as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

}
  
}

/*End of the Global Database*/


/* Current Employment  */



if (isset($table['current_employment']['current_emp_id'])) {


 $check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['current_employment']['analyst_status'])?$table['current_employment']['analyst_status']:0;
$font_color = '#FFFFFF';
 
   if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
$in = 1;
$index = array_search('6_'.$in,array_column($components_array, 'id'));
 $in++;
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
 


$start = isset($table['current_employment']['joining_date'])?$table['current_employment']['joining_date']:'-';
$end = isset($table['current_employment']['relieving_date'])?$table['current_employment']['relieving_date']:'-'; 

$start_end = get_date($start).' - '.get_date($end);

 $desigination = isset($table['current_employment']['desigination'])?$table['current_employment']['desigination']:'-';  
 $department = isset($table['current_employment']['department'])?$table['current_employment']['department']:'-';  
 $employee_id = isset($table['current_employment']['employee_id'])?$table['current_employment']['employee_id']:'-'; 
 $company =  isset($table['current_employment']['company_name'])?$table['current_employment']['company_name']:'-';
 $addr =  isset($table['current_employment']['address'])?$table['current_employment']['address']:'-'; 
 $ctc =  isset($table['current_employment']['annual_ctc'])?$table['current_employment']['annual_ctc']:'-';
 $leave = isset($table['current_employment']['reason_for_leaving'])?$table['current_employment']['reason_for_leaving']:'-';
 $leaves = isset($table['current_employment']['remark_reason_for_leaving'])?$table['current_employment']['remark_reason_for_leaving']:'-';
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

 $remark_eligible_for_re_hire = isset($table['current_employment']['remark_eligible_for_re_hire'])?$table['current_employment']['remark_eligible_for_re_hire']:''; 
 $remark_attendance_punctuality = isset($table['current_employment']['remark_attendance_punctuality'])?$table['current_employment']['remark_attendance_punctuality']:''; 
 $remark_job_performance = isset($table['current_employment']['remark_job_performance'])?$table['current_employment']['remark_job_performance']:'-'; 
 $remark_exit_status = isset($table['current_employment']['remark_exit_status'])?$table['current_employment']['remark_exit_status']:'-'; 
 $remark_disciplinary_issues = isset($table['current_employment']['remark_disciplinary_issues'])?$table['current_employment']['remark_disciplinary_issues']:'-'; 

 $desigination_img = $check16px;
 if (strtolower($desigination) != strtolower($remarks_designation)) {
  $desigination_img =  $remarks_designation;
 }

$department_img = $check16px;
 if (strtolower($department) != strtolower($remark_department)) {
  $department_img = $remark_department;
 }

 $ctc_img = $check16px;
 if (strtolower($ctc) != strtolower($remark_salary_lakhs)) {
  $ctc_img =  $remark_salary_lakhs;
 }

 $hr_name_img = $check16px;
 if (strtolower($hr_name) != strtolower($remark_hr_name)) {
  $hr_name_img = $remark_hr_name;
 }


 $hr_contact_img = $check16px;
 if (strtolower($hr_contact) != strtolower($remark_hr_phone_no)) {
  $hr_contact_img = $remark_hr_phone_no;
 }

$remark_date_of_joining = isset($table['current_employment']['remark_date_of_joining'])?$table['current_employment']['remark_date_of_joining']:'-'; 
 $remark_date_of_relieving = isset($table['current_employment']['remark_date_of_relieving'])?$table['current_employment']['remark_date_of_relieving']:'-'; 
 // $start_end
 $start_end_r = $remark_date_of_joining .'-'.$remark_date_of_relieving; 
 $start_end_rs = $check16px;
 if (str_replace(' ','',trim(strtolower($start_end))) != str_replace(' ','',trim(strtolower($start_end_r)))) {
  $start_end_rs = $start_end_r;
 }


$remarks_emp_id = isset($table['current_employment']['remarks_emp_id'])?$table['current_employment']['remarks_emp_id']:'-'; 
 $remarks_emp = $check16px;
 if (trim(strtolower($employee_id)) != trim(strtolower($remarks_emp_id))) {
  $remarks_emp = $remarks_emp_id;
 }


$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Designation</td>';
$html .='<td colspan="2">'.$desigination.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$desigination_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Department</td>';
$html .='<td colspan="2">'.$department.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$department_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >Employee ID</td>';
$html .='<td colspan="2">'.$employee_id.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$remarks_emp.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>4</td>';
$html .='<td >Company Name</td>';
$html .='<td colspan="2">'.$company.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>5</td>';
$html .='<td >Currency Of Salary</td>';
$html .='<td colspan="2">'.$remark_currency.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>6</td>';
$html .='<td >Annual CTC</td>';
$html .='<td colspan="2">'.$ctc.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$ctc_img.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td>7</td>';
$html .='<td >Reason For Leaving</td>';
$html .='<td colspan="2">'.$leaves.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>8</td>';
$html .='<td >Joining - Relieving Date</td>';
$html .='<td colspan="2">'.$start_end.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$start_end_rs.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>9</td>';
$html .='<td >Reporting Manager Name</td>';
$html .='<td colspan="2">'.$remark_hr_name.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>10</td>';
$html .='<td >Reporting Manager Designation</td>';
$html .='<td colspan="2">'.$remarks_designation.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>11</td>';
$html .='<td >Eligible for rehire</td>';
$html .='<td colspan="2">'.$remark_eligible_for_re_hire.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>12</td>';
$html .='<td >Attendance</td>';
$html .='<td colspan="2">'.$remark_attendance_punctuality.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>13</td>';
$html .='<td >Job Performance</td>';
$html .='<td colspan="2">'.$remark_job_performance.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';


$html .='</table></div>';
$html .='<div class="page-break"></div>';
$html .='<div class="container-fluid margin-1 bg-gray"> 
            <table class="table-2" cellspacing="0" > ';
                
$html .='<tr>';
$html .='<td>14</td>';
$html .='<td >Exit formalities</td>';
$html .='<td colspan="2">'.$remark_exit_status.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>15</td>';
$html .='<td >Disciplinary issues</td>';
$html .='<td colspan="2">'.$remark_disciplinary_issues.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';


 
$html .='<tr>';
$html .='<td>16</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($table['current_employment']['verified_date']).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
/**/
$html .='<tr>';
$html .='<td>17</td>'; 
$html .='<td >Verification Remarks</td>';
$html .='<td colspan="2">'.$verification_remarks.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
 
$html .='</table>'; 

$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';

$approved_doc = explode(',', $table['current_employment']['approved_doc']);
if (isset($approved_doc)) { 
    if (count($approved_doc) > 0 && !in_array('no-file',$approved_doc)) {
     

$max = 0;
 foreach ($approved_doc as $key1 => $value){ 
   $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';

        } 
 }
/*end for each*/

}
}
/*end if*/
}
 
}
/*End Of the Current Employment*/

/* Highest Education */



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
            $remark_roll_no = json_decode($table['education_details']['remark_roll_no'],true);
            $remark_type_of_dgree = json_decode($table['education_details']['remark_type_of_dgree'],true);
            $remark_institute_name = json_decode($table['education_details']['remark_institute_name'],true);
            $remark_university_name = json_decode($table['education_details']['remark_university_name'],true);
            $remark_year_of_graduation = json_decode($table['education_details']['remark_year_of_graduation'],true);
            $approved_doc = json_decode($table['education_details']['approved_doc'],true);
            $remark_verifier_designation = json_decode($table['education_details']['remark_verifier_designation'],true);
            $verified_date = json_decode($table['education_details']['verified_date'],true);
            $analyst_status = explode(',',$table['education_details']['analyst_status']); 
            $approved_doc = array();
            if ($table['education_details']['approved_doc'] !='') { 
                $approved_doc = json_decode($table['education_details']['approved_doc'],true);
            }
$in = 1;
foreach ($type_of_degree as $key => $value) { 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status[$key])?$analyst_status[$key]:0;
$font_color = '#FFFFFF';
 
       if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
 

$index = array_search('7_'.$in,array_column($components_array, 'id'));
 $in++;
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
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
$verifier_designation = isset($remark_verifier_designation[$key]['verifier_designation'])?$remark_verifier_designation[$key]['verifier_designation']:'';
$verified_dates = isset($verified_date[$key]['verified_date'])?$verified_date[$key]['verified_date']:'';
$start_end = $start;
$roll_img = $check16px;
if (strtolower($roll) != strtolower($remark_rollno)) {
  $roll_img =  $remark_rollno;
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


 
$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Type Of Qualification</td>';
$html .='<td colspan="2">'.$type_of_degree_edu.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$type_of_degree_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Major</td>';
$html .='<td colspan="2">'.$edu_major.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >University / Board</td>';
$html .='<td colspan="2">'.$university_board_edu.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$university_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>4</td>';
$html .='<td >School / College</td>';
$html .='<td colspan="2">'.$college_school_edu.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$college_school_img.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>5</td>';
$html .='<td >Year Of Passing</td>';
$html .='<td colspan="2">'.get_year($end).'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr> ';
$html .='<tr>';
$html .='<td>6</td>';
$html .='<td >Course Type</td>';
$html .='<td colspan="2">'.$course.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr> ';
$html .='<tr>';
$html .='<td>7</td>';
$html .='<td >Roll Number</td>';
$html .='<td colspan="2">'.$roll.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$roll_img.'</td>';
$html .='</tr>  '; 
  
$html .='<tr>';
$html .='<td>8</td>';
$html .='<td >Verifier\'s Name</td>';
$html .='<td colspan="2">'.$vname.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>  '; 
  
$html .='<tr>';
$html .='<td>9</td>';
$html .='<td >Verifier\'s Designation</td>';
$html .='<td colspan="2">'.$verifier_designation.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>  '; 
 
$html .='<tr>';
$html .='<td>10</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>11</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remarks.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>  '; 
  
  
$html .='</table>';

 
$html .='</div>';

/*end loop*/

$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';


if (isset($approved_doc[$key])) { 
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) {
     

$max = 0;
 foreach ($approved_doc[$key] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

// end if
}

}
 
}

/*End Education */

/* Present Address */


if (isset($table['present_address']['present_address_id'])) { 

$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['present_address']['analyst_status'])?$table['present_address']['analyst_status']:0;
$font_color = '#FFFFFF';
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
 
$in = 1;
$index = array_search('8_'.$in,array_column($components_array, 'id'));
 $in++;     
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';


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

$start_end = get_date($start).' - '.get_date($end);

 
 $city_img = $check16px;
if (strtolower($city) != strtolower($remarks_city)) {
    // $city_img = $remarks_city;
}

 $pin_code_img = $check16px;
if (strtolower($pin_code) != strtolower($remarks_pincode)) {
    // $pin_code_img = $remarks_pincode;
}

 $state_img = $check16px;
if (strtolower($state) != strtolower($remarks_state)) {
    // $state_img = $remarks_state;
}

$relationship_img = $check16px;
if (strtolower($relationship) != strtolower($remark_relationship)) {
    $relationship_img = $remark_relationship;
}



$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Flat / Door No</td>';
$html .='<td colspan="2">'.$flat_no.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Street / Road</td>';
$html .='<td colspan="2">'.$street.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >Area</td>';
$html .='<td colspan="2">'.$area.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>4</td>';
$html .='<td >City / Town</td>';
$html .='<td colspan="2">'.$city.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$city_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>5</td>';
$html .='<td >Pin Code</td>';
$html .='<td colspan="2">'.$pin_code.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$pin_code_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>6</td>';
$html .='<td >State</td>';
$html .='<td colspan="2">'.$state.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$state_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>7</td>';
$html .='<td >Nearest Landmark</td>';
$html .='<td colspan="2">'.$nearest_landmark.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>8</td>';
$html .='<td >Duration Of Stay</td>';
$html .='<td colspan="2">'.$start_end.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$period_of_stay.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>9</td>';
$html .='<td >Property Type</td>';
$html .='<td colspan="2">'.$property_type.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
 

$html .='<tr>';
$html .='<td>10</td>';
$html .='<td >Staying with</td>';
$html .='<td colspan="2">'.$staying_with.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>11</td>';
$html .='<td >Address Remarks</td>';
$html .='<td colspan="2">'.$remarks_address.'</td>';
$html .='<td style="color: '.$color_code.'; " > </td>';
$html .='</tr>';

 $html .='</table></div>';
       $html .='<div class="page-break"></div>';
       $html .='<div class="container-fluid margin-1 bg-gray"> 
            <table class="table-2" cellspacing="0" > ';
$html .='<tr>';
$html .='<td>12</td>';
$html .='<td >Verifier\'s Name</td>';
$html .='<td colspan="2">'.$verifier_name.'</td>';
$html .='<td style="color: '.$color_code.'; " > </td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td>13</td>';
$html .='<td >Verifier\'s Relationship</td>';
$html .='<td colspan="2">'.$remark_relationship.'</td>';
$html .='<td style="color: '.$color_code.'; " > </td>';
$html .='</tr>';


 
$html .='<tr>';
$html .='<td>14</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($table['present_address']['verified_date']).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>15</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remarks.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
  

$html .='</table>';
 
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>'; 

$approved_doc = explode(',', $table['present_address']['approved_doc']);
if (isset($approved_doc)) { 
    if (count($approved_doc) > 0 && !in_array('no-file',$approved_doc)) {
     

$max = 0;
 foreach ($approved_doc as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/
 
 }
  
}
/*End of the present address*/

/* Permanent Address  */


if (isset($table['permanent_address']['permanent_address_id'])) {

$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['permanent_address']['analyst_status'])?$table['permanent_address']['analyst_status']:0;
$font_color = '#FFFFFF';
 

    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
  
$in = 1; 
$index = array_search('9_'.$in,array_column($components_array, 'id'));
 $in++;     
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';

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

$start_end = get_date($start).' - '.get_date($end);
 $city_img = $check16px;
if (strtolower($city) != strtolower($remarks_city)) {
    // $city_img = $remarks_city;
}

 $pin_code_img = $check16px;
if (strtolower($pin_code) != strtolower($remarks_pincode)) {
    // $pin_code_img = $remarks_pincode;
}

 $state_img = $check16px;
if (strtolower($state) != strtolower($remarks_state)) {
    // $state_img = $remarks_state;
}

$relationship_img = $check16px;
if (strtolower($relationship) != strtolower($remark_relationship)) {
    $relationship_img = $remark_relationship;
}



$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Flat / Door No</td>';
$html .='<td colspan="2">'.$flat_no.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Street / Road</td>';
$html .='<td colspan="2">'.$street.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >Area</td>';
$html .='<td colspan="2">'.$area.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>4</td>';
$html .='<td >City / Town</td>';
$html .='<td colspan="2">'.$city.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$city_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>5</td>';
$html .='<td >Pin Code</td>';
$html .='<td colspan="2">'.$pin_code.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$pin_code_img.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>6</td>';
$html .='<td >State</td>';
$html .='<td colspan="2">'.$state.'</td>';
$html .='<td style="color:'.$color_code.'; " >'.$state_img.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td>7</td>';
$html .='<td >Nearest Landmark</td>';
$html .='<td colspan="2">'.$nearest_landmark.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>8</td>';
$html .='<td >Duration Of Stay</td>';
$html .='<td colspan="2">'.$start_end.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$period_of_stay.'</td>';
$html .='</tr>';
 

$html .='<tr>';
$html .='<td>9</td>';
$html .='<td >Property Type</td>';
$html .='<td colspan="2">'.$property_type.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

 
$html .='<tr>';
$html .='<td>10</td>';
$html .='<td >Staying with</td>';
$html .='<td colspan="2">'.$staying_with.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>11</td>';
$html .='<td >Address Remarks</td>';
$html .='<td colspan="2">'.$remarks_address.'</td>';
$html .='<td style="color: '.$color_code.'; " > </td>';
$html .='</tr>';

 $html .='</table></div>';
       $html .='<div class="page-break"></div>';
       $html .='<div class="container-fluid margin-1 bg-gray"> 
            <table class="table-2" cellspacing="0" > ';
$html .='<tr>';
$html .='<td>12</td>';
$html .='<td >Verifier\'s Name</td>';
$html .='<td colspan="2">'.$verifier_name.'</td>';
$html .='<td style="color:'.$color_code.'; " > </td>';
$html .='</tr>';
 

$html .='<tr>';
$html .='<td>13</td>';
$html .='<td >Verifier\'s Relationship</td>';
$html .='<td colspan="2">'.$remark_relationship.'</td>';
$html .='<td style="color:'.$color_code.';" > </td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>14</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($table['permanent_address']['verified_date']).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>15</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remarks.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
  
$html .='</table>';
 
$html .='</div>';
 $html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';
 

$approved_doc = explode(',', $table['permanent_address']['approved_doc']);
if (isset($approved_doc)) { 
    if (count($approved_doc) > 0 && !in_array('no-file',$approved_doc)) {
     

$max = 0;
 foreach ($approved_doc as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/ 
}

}

/*End of the permanant addresss*/

/* Previous Employment  */



if (isset($table['previous_employment']['previous_emp_id'])) {


$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
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
          $approved_doc = json_decode($table['previous_employment']['approved_doc'],true);
          $remarks_emp_id = json_decode($table['previous_employment']['remarks_emp_id'],true);



 $remark_date_of_relieving = json_decode($table['previous_employment']['remark_date_of_relieving'],true);//isset($table['current_employment']['remark_date_of_relieving'])?$table['current_employment']['remark_date_of_relieving']:'-'; 
 $remarks_designation = json_decode($table['previous_employment']['remarks_designation'],true);//isset($table['current_employment']['remarks_designation'])?$table['current_employment']['remarks_designation']:'-'; 
 $remark_date_of_joining = json_decode($table['previous_employment']['remark_date_of_joining'],true);//isset($table['current_employment']['remark_date_of_joining'])?$table['current_employment']['remark_date_of_joining']:'-'; 
 $remark_salary_lakhs = json_decode($table['previous_employment']['remark_salary_lakhs'],true);//isset($table['current_employment']['remark_salary_lakhs'])?$table['current_employment']['remark_salary_lakhs']:'-'; 
 $remark_salary_type = json_decode($table['previous_employment']['remark_salary_type'],true);//isset($table['current_employment']['remark_salary_type'])?$table['current_employment']['remark_salary_type']:'-'; 
 $remark_currency = json_decode($table['previous_employment']['remark_currency'],true);//isset($table['current_employment']['remark_currency'])?$table['current_employment']['remark_currency']:'-'; 
 $remark_hr_name = json_decode($table['previous_employment']['remark_hr_name'],true);//isset($table['current_employment']['remark_hr_name'])?$table['current_employment']['remark_hr_name']:'-';  
 $remark_hr_email = json_decode($table['previous_employment']['remark_hr_email'],true);//isset($table['current_employment']['remark_hr_email'])?$table['current_employment']['remark_hr_email']:'-'; 
 $verification_remarks = json_decode($table['previous_employment']['verification_remarks'],true);
 $remark_hr_phone_no = json_decode($table['previous_employment']['remark_hr_phone_no'],true);
 //isset($table['current_employment']['verification_remarks'])?$table['current_employment']['verification_remarks']:'-'; 
 $analyst_status = explode(',',$table['previous_employment']['analyst_status']);

 $remark_eligible_for_re_hires = json_decode($table['previous_employment']['remark_eligible_for_re_hire'],true);
 $remark_exit_statuss = json_decode($table['previous_employment']['remark_exit_status'],true); 
 $remark_attendance_punctualitys = json_decode($table['previous_employment']['remark_attendance_punctuality'],true); 
 $remark_job_performances = json_decode($table['previous_employment']['remark_job_performance'],true); 
 $remark_disciplinary_issuess = json_decode($table['previous_employment']['remark_disciplinary_issues'],true); 
 $verified_date = json_decode($table['previous_employment']['verified_date'],true); 
 $remark_reason_for_leaving = json_decode($table['previous_employment']['remark_reason_for_leaving'],true); 
  $a =0; 
  $in = 1;
foreach ($desigination as $prev => $val) { 



$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
  $analyst = isset($analyst_status[$prev])?$analyst_status[$prev]:0; 
$font_color = '#FFFFFF';
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
  
$index = array_search('10_'.$in,array_column($components_array, 'id'));
 $in++;    
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';



    $remark_hr_nam = isset($remark_hr_name[$prev]['remark_hr_name'])?$remark_hr_name[$prev]['remark_hr_name']:'-';
    $verification_remark = isset($verification_remarks[$prev]['verification_remarks'])?$verification_remarks[$prev]['verification_remarks']:'-';
              

$start = isset($joining_date[$prev]['joining_date'])?$joining_date[$prev]['joining_date']:'-';
$end = isset($relieving_date[$prev]['relieving_date'])?$relieving_date[$prev]['relieving_date']:'-';

$start_end = get_date($start).' - '.get_date($end);

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
// $remark_exit_statuss = isset($remark_exit_status[$prev]['remark_exit_status'])?$remark_exit_status[$prev]['remark_exit_status']:"-";
$remarks_designations = isset($remarks_designation[$prev]['remarks_designation'])?$remarks_designation[$prev]['remarks_designation']:"-";
$remark_date_of_joinings = isset($remark_date_of_joining[$prev]['remark_date_of_joining'])?$remark_date_of_joining[$prev]['remark_date_of_joining']:"-";
$remark_salary_lakhss = isset($remark_salary_lakhs[$prev]['remark_salary_lakhs'])?$remark_salary_lakhs[$prev]['remark_salary_lakhs']:"-";
$remark_salary_types = isset($remark_salary_type[$prev]['remark_salary_type'])?$remark_salary_type[$prev]['remark_salary_type']:"-";
$remark_currencys = isset($remark_currency[$prev]['currency'])?$remark_currency[$prev]['currency']:"-";
// $remark_eligible_for_re_hires = isset($remark_eligible_for_re_hire[$prev]['remark_eligible_for_re_hire'])?$remark_eligible_for_re_hire[$prev]['remark_eligible_for_re_hire']:"-";
$remark_hr_names = isset($remark_hr_name[$prev]['remark_hr_name'])?$remark_hr_name[$prev]['remark_hr_name']:"-";
$remark_hr_emails = isset($remark_hr_email[$prev]['remark_hr_email'])?$remark_hr_email[$prev]['remark_hr_email']:"-";
$remark_hr_phone_nos = isset($remark_hr_phone_no[$prev]['remark_hr_phone_no'])?$remark_hr_phone_no[$prev]['remark_hr_phone_no']:"-";


$remark_eligible_for_re_hire = isset($remark_eligible_for_re_hires[$prev]['remark_eligible_for_re_hire'])?$remark_eligible_for_re_hires[$prev]['remark_eligible_for_re_hire']:'';
$remark_attendance_punctuality = isset($remark_attendance_punctualitys[$prev]['remark_attendance_punctuality'])?$remark_attendance_punctualitys[$prev]['remark_attendance_punctuality']:'';
$remark_job_performance = isset($remark_job_performances[$prev]['remark_job_performance'])?$remark_job_performances[$prev]['remark_job_performance']:'';
$remark_exit_status = isset($remark_exit_statuss[$prev]['remark_exit_status'])?$remark_exit_statuss[$prev]['remark_exit_status']:'';
$remark_disciplinary_issues = isset($remark_disciplinary_issuess[$prev]['remark_disciplinary_issues'])?$remark_disciplinary_issuess[$prev]['remark_disciplinary_issues']:'';
$verified_dates = isset($verified_date[$prev]['verified_date'])?$verified_date[$prev]['verified_date']:'';
$remark_reason_for_leavings = isset($remark_reason_for_leaving[$prev]['remark_reason_for_leaving'])?$remark_reason_for_leaving[$prev]['remark_reason_for_leaving']:'';



$desigination_img = $check16px;
 if (strtolower($desigination) != strtolower($remarks_designations)) {
  $desigination_img = $remarks_designations;
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
 
 // $start_end
 $start_end_r = $remark_date_of_joinings .'-'.$remark_date_of_relievings; 
 $start_end_rs = $check16px;
 if (str_replace(' ','',trim(strtolower($start_end))) != str_replace(' ','',trim(strtolower($start_end_r)))) {
  $start_end_rs = $start_end_r;
 }

 $remarks_emp_ids = isset($remarks_emp_id[$prev]['remarks_emp_id'])?$remarks_emp_id[$prev]['remarks_emp_id']:'';

 $remarks_emp = $check16px;
 if (trim(strtolower($employee_id)) != trim(strtolower($remarks_emp_ids))) {
  $remarks_emp = $remarks_emp_ids;
 }

$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Designation</td>';
$html .='<td colspan="2">'.$desigination.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$desigination_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Department</td>';
$html .='<td colspan="2">'.$department.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$desigination_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >Employee ID</td>';
$html .='<td colspan="2">'.$employee_id.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$remarks_emp.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>4</td>';
$html .='<td >Company Name</td>';
$html .='<td colspan="2">'.$company.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>5</td>';
$html .='<td >Currency Of Salary</td>';
$html .='<td colspan="2">'.$remark_currencys.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>6</td>';
$html .='<td >Annual CTC</td>';
$html .='<td colspan="2">'.$ctc.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$ctc_img.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td>7</td>';
$html .='<td >Reason For Leaving</td>';
$html .='<td colspan="2">'.$remark_reason_for_leavings.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>8</td>';
$html .='<td >Joining - Relieving Date</td>';
$html .='<td colspan="2">'.$start_end.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$start_end_rs.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>9</td>';
$html .='<td >Reporting Manager Name</td>';
$html .='<td colspan="2">'.$remark_hr_names.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>10</td>';
$html .='<td >Reporting Manager Designation</td>';
$html .='<td colspan="2">'.$remarks_designations.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>11</td>';
$html .='<td >Eligible for rehire</td>';
$html .='<td colspan="2">'.$remark_eligible_for_re_hire.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>12</td>';
$html .='<td >Attendance</td>';
$html .='<td colspan="2">'.$remark_attendance_punctuality.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>13</td>';
$html .='<td >Job Performance</td>';
$html .='<td colspan="2">'.$remark_job_performance.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

 
$html .='</table></div>';
$html .='<div class="page-break"></div>';
$html .='<div class="container-fluid margin-1 bg-gray"> 
            <table class="table-2" cellspacing="0" > ';
 
 
$html .='<tr>';
$html .='<td>14</td>';
$html .='<td >Exit formalities</td>';
$html .='<td colspan="2">'.$remark_exit_status.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>15</td>';
$html .='<td >Disciplinary issues</td>';
$html .='<td colspan="2">'.$remark_disciplinary_issues.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
   

$html .='<tr>';
$html .='<td>16</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
/**/
$html .='<tr>';
$html .='<td>17</td>';
$html .='<td >Verification Remarks</td>';
$html .='<td colspan="2">'.$verification_remark.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
 
$html .='</table>';

 
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';



if (isset($approved_doc[$prev])) { 
    if (count($approved_doc[$prev]) > 0 && !in_array('no-file',$approved_doc[$prev])) {
     

$max = 0;
 foreach ($approved_doc[$prev] as $key1 => $value){ 
   $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

}     
 }

}

/* end of the previous employment */


/* Reference */



if (isset($table['reference']['reference_id'])) {



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
              $analyst_status = explode(',',$table['reference']['analyst_status']);
$approved_doc = json_decode($table['reference']['approved_doc'],true);
$verified_date = json_decode($table['reference']['verified_date'],true);
$a=0;
$in = 1;
foreach ($company_name as $refer => $referval) { 

 $check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status[$refer])?$analyst_status[$refer]:0; 
$font_color = '#FFFFFF';
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
 
$index = array_search('11_'.$in,array_column($components_array, 'id'));
 $in++;      
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';

$verification_remark = isset($verification_remarks[$refer]['verification_remarks'])?$verification_remarks[$refer]['verification_remarks']:'-';
$verified_dates = isset($verified_date[$refer]['verified_date'])?$verified_date[$refer]['verified_date']:'-';
$names = isset($name[$refer])?$name[$refer]:"-";
$company_names = isset($company_name[$refer])?$company_name[$refer]:"-";
$designations = isset($designation[$refer])?$designation[$refer]:"-";
$contact_numbers = isset($contact_number[$refer])?$contact_number[$refer]:"-";
$email_ids = isset($email_id[$refer])?$email_id[$refer]:"-";
$years_of_associations = isset($years_of_association[$refer])?$years_of_association[$refer]:"-";

$contact_start_times =isset($contact_start_time[$refer])?$contact_start_time[$refer]:"-";
$contact_end_times =isset($contact_end_time[$refer])?$contact_end_time[$refer]:"-";

$start_end =  $contact_start_times." - ".$contact_end_times;
$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Verifier Name</td>';
$html .='<td colspan="2">'.$names.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Company Name</td>';
$html .='<td colspan="2">'.$company_names.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >Designation</td>';
$html .='<td colspan="2">'.$designations.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>4</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>5</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remark.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';


$html .='
</table>';
  
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';
 
if (isset($approved_doc[$refer])) { 
    if (count($approved_doc[$refer]) > 0 && !in_array('no-file',$approved_doc[$refer])) {
     

$max = 0;
 foreach ($approved_doc[$refer] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/
} 

} 

}

/*End Reference*/


/* Previous Address */


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
$analyst_status = explode(',',$table['previous_address']['analyst_status']); 
$approved_doc = json_decode($table['previous_address']['approved_doc'],true);
$verified_date = json_decode($table['previous_address']['verified_date'],true);

 $a=0;
 $in = 1;
 foreach ($flat_no as $flat_key => $value) { 
 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status[$flat_key])?$analyst_status[$flat_key]:0;
$font_color = '#FFFFFF';
   if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
 
$index = array_search('12_'.$in,array_column($components_array, 'id'));
 $in++;     
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
             
$verification_remark ='';
                // echo json_encode($flat_no);
    // $verification_remark = isset($verification_remarks[$flat_key]['verification_remarks'])?$verification_remarks[$flat_key]['verification_remarks']:'-';

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
$start_end = get_date($start).' - '.get_date($end);

$remarks_addresss = isset($remarks_address[$flat_key]['address'])?$remarks_address[$flat_key]['address']:'-';
$remarks_citys = isset($remarks_city[$flat_key]['pincode'])?$remarks_city[$flat_key]['pincode']:'-';
$remarks_pincodes = isset($remarks_pincode[$flat_key]['city'])?$remarks_pincode[$flat_key]['city']:'-';
$remarks_states = isset($remarks_state[$flat_key]['state'])?$remarks_state[$flat_key]['state']:'-';
$staying_withs = isset($staying_with[$flat_key]['staying_with'])?$staying_with[$flat_key]['staying_with']:'-';
$period_of_stays = isset($period_of_stay[$flat_key]['period_of_stay'])?$period_of_stay[$flat_key]['period_of_stay']:'-';
$property_types = isset($property_type[$flat_key]['property_type'])?$property_type[$flat_key]['property_type']:'-';
$verifier_names = isset($verifier_name[$flat_key]['verifier_name'])?$verifier_name[$flat_key]['verifier_name']:'-';
$remark_relationships = isset($remark_relationship[$flat_key]['relationship'])?$remark_relationship[$flat_key]['relationship']:'-';
$verification_remark = isset($verification_remarks[$flat_key]['verification_remarks'])?$verification_remarks[$flat_key]['verification_remarks']:'-';
$verified_dates = isset($verified_date[$flat_key]['verified_date'])?$verified_date[$flat_key]['verified_date']:'-';

 $city_img = $check16px;
if (strtolower($city) != strtolower($remarks_citys)) {
    // $city_img = $remarks_citys;
}

 $pin_code_img = $check16px;
if (strtolower($pin_code) != strtolower($remarks_pincodes)) {
    // $pin_code_img = $remarks_pincodes;
}

 $state_img = $check16px;
if (strtolower($state) != strtolower($remarks_states)) {
    // $state_img = $remarks_states;
}

$relationship_img = $check16px;
if (strtolower($relationship) != strtolower($remark_relationships)) {
    $relationship_img = $remark_relationships;
}




$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Flat / Door No</td>';
$html .='<td colspan="2">'.$flat_no.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Street / Road</td>';
$html .='<td colspan="2">'.$street.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >Area</td>';
$html .='<td colspan="2">'.$area.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>4</td>';
$html .='<td >City / Town</td>';
$html .='<td colspan="2">'.$city.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$city_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td>5</td>';
$html .='<td >Pin Code</td>';
$html .='<td colspan="2">'.$pin_code.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$pin_code_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>6</td>';
$html .='<td >State</td>';
$html .='<td colspan="2">'.$state.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$state_img.'</td>';
$html .='</tr>';

 
$html .='<tr>';
$html .='<td>7</td>';
$html .='<td >Nearest Landmark</td>';
$html .='<td colspan="2">'.$nearest_landmark.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>8</td>';
$html .='<td >Duration Of Stay</td>';
$html .='<td colspan="2">'.$start_end.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$period_of_stays.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>9</td>';
$html .='<td >Property Type</td>';
$html .='<td colspan="2">'.$property_types.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td>10</td>';
$html .='<td >Staying with</td>';
$html .='<td colspan="2">'.$staying_withs.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
 

$html .='<tr>';
$html .='<td>11</td>';
$html .='<td >Address Remarks</td>';
$html .='<td colspan="2">'.$remarks_addresss.'</td>';
$html .='<td style="color: '.$color_code.'; " > </td>';
$html .='</tr>';

 $html .='</table></div>';
       $html .='<div class="page-break"></div>';
       $html .='<div class="container-fluid margin-1 bg-gray"> 
            <table class="table-2" cellspacing="0" > ';
$html .='<tr>';
$html .='<td>12</td>';
$html .='<td >Verifier\'s Name</td>';
$html .='<td colspan="2">'.$verifier_names.'</td>';
$html .='<td style="color: '.$color_code.'; " > </td>';
$html .='</tr>';
 

$html .='<tr>';
$html .='<td>13</td>';
$html .='<td >Verifier\'s Relationship</td>';
$html .='<td colspan="2">'.$remark_relationships.'</td>';
$html .='<td style="color: '.$color_code.'; " > </td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>14</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>15</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remark.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
 
$html .='</table>';
 
$html .='</div>';
 
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';

if (isset($approved_doc[$key])) { 
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) {
     

$max = 0;
 foreach ($approved_doc[$key] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/
}
 }

}

/*previous address*/


/* Directorship Check */



if (isset($table['directorship_check']['directorship_check_id'])) {

 
    // print_r($table['reference']['verification_remarks']);
    $remark_country = json_decode($table['directorship_check']['remark_country'],true); 
     $verification_remarks = json_decode($table['directorship_check']['verification_remarks'],true);
     $verified_date = json_decode($table['directorship_check']['verified_date'],true);
      $analyst_status = explode(',',$table['directorship_check']['analyst_status']); 
$approved_doc = json_decode($table['directorship_check']['approved_doc'],true);
$in = 1;
foreach ($remark_country as $crn => $crnum) { 

    $check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
 
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status[$crn])?$analyst_status[$crn]:0;
$font_color = '#FFFFFF';
     if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
 
$index = array_search('14_'.$in,array_column($components_array, 'id'));
 $in++;    
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';

$remark_countrys = isset($remark_country[$crn]['country'])?$remark_country[$crn]['country']:''; 
$verification_remark = isset($verification_remarks[$crn]['verification_remarks'])?$verification_remarks[$crn]['verification_remarks']:'';
$verified_dates = isset($verified_date[$crn]['verified_date'])?$verified_date[$crn]['verified_date']:'';

$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Country</td>';
$html .='<td colspan="2">'.$remark_countrys.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';



$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remark.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .='
</table>';
 
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';
 
if (isset($approved_doc[$crn])) { 
    if (count($approved_doc[$crn]) > 0 && !in_array('no-file',$approved_doc[$crn])) {
     

$max = 0;
 foreach ($approved_doc[$crn] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/
 
} 

} 

}

/*End directorship*/


/* Global Sanctions/ AML  */




if (isset($table['global_sanctions_aml']['global_sanctions_aml_id'])) {

 
    // print_r($table['reference']['verification_remarks']);
    $remark_country = json_decode($table['global_sanctions_aml']['remark_country'],true); 
     $verification_remarks = json_decode($table['global_sanctions_aml']['verification_remarks'],true);
      $analyst_status = explode(',',$table['global_sanctions_aml']['analyst_status']); 

$approved_doc = json_decode($table['global_sanctions_aml']['approved_doc'],true);
$verified_date = json_decode($table['global_sanctions_aml']['verified_date'],true);
$in = 1;
foreach ($remark_country as $crn => $crnum) { 
 $check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status[$crn])?$analyst_status[$crn]:0;
$font_color = '#FFFFFF';
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
   

$index = array_search('15_'.$in,array_column($components_array, 'id'));
 $in++;     
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';

$remark_countrys = isset($remark_country[$crn]['country'])?$remark_country[$crn]['country']:''; 
$verification_remark = isset($verification_remarks[$crn]['verification_remarks'])?$verification_remarks[$crn]['verification_remarks']:'';
$verified_dates = isset($verified_date[$crn]['verified_date'])?$verified_date[$crn]['verified_date']:'';

$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Country</td>';
$html .='<td colspan="2">'.$remark_countrys.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>'; 

$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remark.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .='
</table>';

  
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';
 
if (isset($approved_doc[$crn])) { 
    if (count($approved_doc[$crn]) > 0 && !in_array('no-file',$approved_doc[$crn])) {
     

$max = 0;
 foreach ($approved_doc[$crn] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/
 
} 

} 

}

/*End sa*/

/* Driving License  */

 


if (isset($table['driving_licence']['licence_id'])) {
 
    // print_r($table['reference']['verification_remarks']);
    $licence_number = $table['driving_licence']['licence_number']; 
    $analyst_status = $table['driving_licence']['analyst_status']; 
    $verification_remarks = json_decode($table['driving_licence']['verification_remarks'],true);
    $verification_remark = isset($verification_remarks[0]['verification_remarks'])?$verification_remarks[0]['verification_remarks']:'';
    $dl_dates = json_decode($table['driving_licence']['verified_date'],true);
    $dl_date = isset($dl_dates[0]['verified_date'])?$dl_dates[0]['verified_date']:'';
 $check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />'; 
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status)?$analyst_status:0;
$font_color = '#FFFFFF';
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
  $in = 1; 
$index = array_search('16_'.$in,array_column($components_array, 'id'));
 $in++;
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';

  
$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >License Number</td>';
$html .='<td colspan="2">'.$licence_number.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

 


$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($dl_date).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
// 
$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remark.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .=' 
</table>';
 
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';
 

$approved_doc = json_decode($table['driving_licence']['approved_doc'],true);
if (isset($approved_doc[0])) { 
    if (count($approved_doc[0]) > 0 && !in_array('no-file',$approved_doc[0])) {
     

$max = 0;
 foreach ($approved_doc[0] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/
 
 }

} 

/*End DL*/

/* Credit / Cibil Check */




if (isset($table['credit_cibil']['credit_id'])) {

 
    // print_r($table['reference']['verification_remarks']);
    $credit_number = json_decode($table['credit_cibil']['credit_number'],true);
    $document_type = json_decode($table['credit_cibil']['document_type'],true); 
    $analyst_status = explode(',',$table['credit_cibil']['analyst_status']); 
    $verification_remarks = json_decode($table['credit_cibil']['verification_remarks'],true);
 $approved_doc = json_decode($table['credit_cibil']['approved_doc'],true);
 $verified_date = json_decode($table['credit_cibil']['verified_date'],true);
 $in = 1;
foreach ($credit_number as $crn => $crnum) { 
 $check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status[$crn])?$analyst_status[$crn]:0;
$font_color = '#FFFFFF';
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
 
$index = array_search('17_'.$in,array_column($components_array, 'id'));
 $in++;    
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';


$verification_remark = isset($verification_remarks[$crn]['verification_remarks'])?$verification_remarks[$crn]['verification_remarks']:'';
$credit_numbers = isset($credit_number[$crn]['credit_cibil_number'])?$credit_number[$crn]['credit_cibil_number']:"";
$document_types = isset($document_type[$crn]['document_type'])?$document_type[$crn]['document_type']:""; 
$verified_dates = isset($verified_date[$crn]['verified_date'])?$verified_date[$crn]['verified_date']:""; 

$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Credit Number</td>';
$html .='<td colspan="2">'.$credit_numbers.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Document Type</td>';
$html .='<td colspan="2">'.$document_types.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
 

$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>4</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remark.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';



$html .=' 
</table>';
 
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';
 
if (isset($approved_doc[$crn])) { 
    if (count($approved_doc[$crn]) > 0 && !in_array('no-file',$approved_doc[$crn])) {
     

$max = 0;
 foreach ($approved_doc[$crn] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/
 
} 

} 

}
/*End of the credit / cibil */

/* Bankruptcy Check  */



if (isset($table['bankruptcy']['bankruptcy_id'])) {


    // print_r($table['reference']['verification_remarks']);
    $bankruptcy_number = json_decode($table['bankruptcy']['bankruptcy_number'],true);
    $document_type = json_decode($table['bankruptcy']['document_type'],true); 
    $analyst_status = explode(',',$table['bankruptcy']['analyst_status']); 
    $verification_remarks = json_decode($table['bankruptcy']['verification_remarks'],true);
   $approved_doc = json_decode($table['bankruptcy']['approved_doc'],true);
   $verified_date = json_decode($table['bankruptcy']['verified_date'],true);
   $in = 1;
foreach ($bankruptcy_number as $crn => $crnum) { 

$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />'; 
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status[$crn])?$analyst_status[$crn]:0;
$font_color = '#FFFFFF';
   if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
      
 
$index = array_search('18_'.$in,array_column($components_array, 'id'));
 $in++;     
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';

$verification_remark = isset($verification_remarks[$crn]['verification_remarks'])?$verification_remarks[$crn]['verification_remarks']:'';
$bankruptcy_numbers = isset($bankruptcy_number[$crn]['bankruptcy_number'])?$bankruptcy_number[$crn]['bankruptcy_number']:"";
$document_types = isset($document_type[$crn]['document_type'])?$document_type[$crn]['document_type']:""; 
$verified_dates = isset($verified_date[$crn]['verified_date'])?$verified_date[$crn]['verified_date']:""; 

$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Document Number</td>';
$html .='<td colspan="2">'.$bankruptcy_numbers.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Document Type</td>';
$html .='<td colspan="2">'.$document_types.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
 


$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>4</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remark.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .=' 
</table>';
 
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>'; 


if (isset($approved_doc[$crn])) { 
    if (count($approved_doc[$crn]) > 0 && !in_array('no-file',$approved_doc[$crn])) {
     

$max = 0;
 foreach ($approved_doc[$crn] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/
 
} 

} 

}

/*End of the bancruptcy*/

/* Adverse Media/Database Check  */


if (isset($table['adverse_database_media_check']['adverse_database_media_check_id'])) {
  
    $remark_country = $table['adverse_database_media_check']['remark_country']; 
    $candidate_name = $file_name_final; 
    $verification_remarks = json_decode($table['adverse_database_media_check']['verification_remarks'],true);
    $verified_date = json_decode($table['adverse_database_media_check']['verified_date'],true);
 
 $verification_remark = isset($verification_remarks[0]['verification_remarks'])?$verification_remarks[0]['verification_remarks']:'';
 $verified_dates = isset($verified_date[0]['verified_date'])?$verified_date[0]['verified_date']:'';
 
$analyst = isset($analyst_status)?$analyst_status:0;
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$font_color = '#FFFFFF';
   if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'In-progress';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
  
$in = 1;
$index = array_search('19_'.$in,array_column($components_array, 'id'));
 $in++;     
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';



$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remark.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';


$html .=' 
</table>';
  
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>'; 


$approved_doc = json_decode($table['adverse_database_media_check']['approved_doc'],true);
if (isset($approved_doc[0])) { 
    if (count($approved_doc[0]) > 0 && !in_array('no-file',$approved_doc[0])) {
     

$max = 0;
 foreach ($approved_doc[0] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/
 }

} 

/*End of the edv. / media check*/

/* CV Check  */



if (isset($table['cv_check']['cv_id'])) {


   // print_r($table['reference']['verification_remarks']);
    $contect_number = $table['cv_check']['contect_number'];
    $full_name = $table['cv_check']['full_name'];
    $address = $table['cv_check']['address'];
    $education_detail = $table['cv_check']['education_detail']; 
    $analyst_status =  $table['cv_check']['analyst_status']; 
    $verification_remarks = json_decode($table['cv_check']['verification_remarks'],true);
    $verified_date = json_decode($table['cv_check']['verified_date'],true);
 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />'; 
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status)?$analyst_status:0;
$font_color = '#FFFFFF';
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
if (isset($_GET['cv'])) {
    $cv = $_GET['cv'];
}else{
     $cv =' CV Check ';
} 
$in = 1;
$index = array_search('20_'.$in,array_column($components_array, 'id'));
 $in++;
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
 
$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Name</td>';
$html .='<td colspan="2">'.$full_name.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Contact Number</td>';
$html .='<td colspan="2">'.$contect_number.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >Address</td>';
$html .='<td colspan="2">'.$address.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td>4</td>';
$html .='<td >Education Details</td>';
$html .='<td colspan="2">'.$education_detail.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

  $verification_remark = isset($verification_remarks[0]['verification_remarks'])?$verification_remarks[0]['verification_remarks']:'';
  $verified_dates = isset($verified_date[0]['verified_date'])?$verified_date[0]['verified_date']:'';


$html .='<tr>';
$html .='<td>5</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
// 
$html .='<tr>';
$html .='<td>6</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remark.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .=' 
</table>';

  
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>'; 

$approved_doc = json_decode($table['cv_check']['approved_doc'],true);
if (isset($approved_doc[0])) { 
    if (count($approved_doc[0]) > 0 && !in_array('no-file',$approved_doc[0])) {
     

$max = 0;
 foreach ($approved_doc[0] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/
 
 }

} 

 /*End CV check */

 /* Health Checkup */


if (isset($table['health_checkup']['health_checkup_id'])) {
  
    $remark_country = json_decode($table['health_checkup']['remark_country'],true); 
    // $candidate_name = $candidate_data[0]['candidateData']['first_name'].' '.$candidate_data[0]['candidateData']['last_name']; 
    $verification_remarks = json_decode($table['health_checkup']['verification_remarks'],true);
    $verified_date = json_decode($table['health_checkup']['verified_date'],true);
    $analyst_status = $table['health_checkup']['analyst_status'];
 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />'; 
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status)?$analyst_status:0;
$font_color = '#FFFFFF';
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
   
 $html .='<br pagebreak="true" />';
 if (isset($_GET['health'])) {
    $health = $_GET['health'];
}else{
     $health =' Health Checkup ';
}  

$in =1;
$index = array_search('21_'.$in,array_column($components_array, 'id'));
 $in++;   
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';

$remark_countrys = isset($remark_country[0]['country'])?$remark_country[0]['country']:''; 
$verification_remark = isset($verification_remarks[0]['verification_remarks'])?$verification_remarks[0]['verification_remarks']:'';
$verified_dates = isset($verified_date[0]['verified_date'])?$verified_date[0]['verified_date']:'';
 
$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Country</td>';
$html .='<td colspan="2">'.$remark_countrys.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';



$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remark.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .=' 
</table>';
 
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>'; 


$approved_doc = json_decode($table['health_checkup']['approved_doc'],true);
if (isset($approved_doc[0])) { 
    if (count($approved_doc[0]) > 0 && !in_array('no-file',$approved_doc[0])) {
     

$max = 0;
 foreach ($approved_doc[0] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

} 

}

/*END health check*/

/* Employement Gap check  */


if (isset($table['employment_gap_check']['gap_id'])) {
  
    $company_list = $table['employment_gap_check']['company_list']; 
    $start_date = $table['employment_gap_check']['start_date']; 
    $end_date = $table['employment_gap_check']['end_date']; 
    $candidate_name = $candidate_final_name; 
    $verification_remarks = $table['employment_gap_check']['verification_remarks'];
    $analyst_status = $table['employment_gap_check']['analyst_status'];
    $verified_dates = $table['employment_gap_check']['verified_date'];
 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />'; 
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status)?$analyst_status:0;
$font_color = '#FFFFFF';
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
  
$in = 1;
$index = array_search('22_'.$in,array_column($components_array, 'id'));
 $in++;     
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
 
$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Candidate Name</td>';
$html .='<td colspan="2">'.$candidate_name.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Company List</td>';
$html .='<td colspan="2">'.$company_list.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

 
$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >Start Date</td>';
$html .='<td colspan="2">'.$start_date.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

 
$html .='<tr>';
$html .='<td>4</td>';
$html .='<td >End Date</td>';
$html .='<td colspan="2">'.$end_date.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';



$html .='<tr>';
$html .='<td>5</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>6</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remarks.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .=' 
</table>';
 
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>'; 
 
 
$approved_doc = json_decode($table['employment_gap_check']['approved_doc'],true);
if (isset($approved_doc[0])) { 
    if (count($approved_doc[0]) > 0 && !in_array('no-file',$approved_doc[0])) {
     

$max = 0;
 foreach ($approved_doc[0] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

} 

}
/*End of the gap check*/


/* new components */

/* Previous Landlord Reference Check  */


if (isset($table['landload_reference']['landload_id'])) {
  
    $landlord_name = json_decode($table['landload_reference']['landlord_name'],true);  
    $case_contact_no = json_decode($table['landload_reference']['case_contact_no'],true); 

    $tenancy_period = json_decode($table['landload_reference']['tenancy_period'],true);  
    $any_pets = json_decode($table['landload_reference']['any_pets'],true);  
    $monthly_rental_amount = json_decode($table['landload_reference']['monthly_rental_amount'],true);  
    $occupants_property = json_decode($table['landload_reference']['occupants_property'],true);  
    $tenant_consistently_pay_rent_on_time = json_decode($table['landload_reference']['tenant_consistently_pay_rent_on_time'],true);  
    $utility_bills_paid_on_time = json_decode($table['landload_reference']['utility_bills_paid_on_time'],true);  
    $rental_property = json_decode($table['landload_reference']['rental_property'],true);  
    $maintenance_issues = json_decode($table['landload_reference']['maintenance_issues'],true);  
    $tenant_leave = json_decode($table['landload_reference']['tenant_leave'],true);  
    $tenant_rent_again = json_decode($table['landload_reference']['tenant_rent_again'],true);  
    $complaints_from_neighbors = json_decode($table['landload_reference']['complaints_from_neighbors'],true);  
    $food_preference = json_decode($table['landload_reference']['food_preference'],true);  
    $spare_time = json_decode($table['landload_reference']['spare_time'],true);  

    $overall_character = json_decode($table['landload_reference']['overall_character'],true); 

    $candidate_name = $file_name_final; 
    $verification_remarks = json_decode($table['landload_reference']['verification_remarks'],true);
    $analyst_status = explode(',', $table['landload_reference']['analyst_status']);
    $verified_dates = json_decode($table['landload_reference']['verified_date'],true);
 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />'; 
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status)?$analyst_status:0;
$in = 1;
foreach ($analyst as $an => $analyst_value) { 
$font_color = '#FFFFFF';
    if ( $analyst_value == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst_value == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst_value == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst_value == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst_value == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst_value == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst_value == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst_value == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst_value == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst_value == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst_value == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

   

$landload = isset($landlord_name[$an]['landlord_name'])?$landlord_name[$an]['landlord_name']:'';
$remark = isset($verification_remarks[$an]['verification_remarks'])?$verification_remarks[$an]['verification_remarks']:'';
$number = isset($case_contact_no[$an]['case_contact_no'])?$case_contact_no[$an]['case_contact_no']:'';

$tenancy_perio = isset($tenancy_period[$an]['tenancy_period'])?$tenancy_period[$an]['tenancy_period']:'';
$monthly_rental_amoun = isset($monthly_rental_amount[$an]['monthly_rental_amount'])?$monthly_rental_amount[$an]['monthly_rental_amount']:'';
$occupants_propert = isset($occupants_property[$an]['occupants_property'])?$occupants_property[$an]['occupants_property']:'';
$tenant_consistently_pay_rent_on_tim = isset($tenant_consistently_pay_rent_on_time[$an]['tenant_consistently_pay_rent_on_time'])?$tenant_consistently_pay_rent_on_time[$an]['tenant_consistently_pay_rent_on_time']:'';
$utility_bills_paid_on_tim = isset($utility_bills_paid_on_time[$an]['utility_bills_paid_on_time'])?$utility_bills_paid_on_time[$an]['utility_bills_paid_on_time']:'';
$rental_propert = isset($rental_property[$an]['rental_property'])?$rental_property[$an]['rental_property']:'';
$maintenance_issue = isset($maintenance_issues[$an]['maintenance_issues'])?$maintenance_issues[$an]['maintenance_issues']:'';
$tenant_leav = isset($tenant_leave[$an]['tenant_leave'])?$tenant_leave[$an]['tenant_leave']:'';
$tenant_rent_agai = isset($tenant_rent_again[$an]['tenant_rent_again'])?$tenant_rent_again[$an]['tenant_rent_again']:'';
$complaints_from_neighbor = isset($complaints_from_neighbors[$an]['complaints_from_neighbors'])?$complaints_from_neighbors[$an]['complaints_from_neighbors']:'';
$food_preferenc = isset($food_preference[$an]['food_preference'])?$food_preference[$an]['food_preference']:'';
$spare_tim = isset($spare_time[$an]['spare_time'])?$spare_time[$an]['spare_time']:'';
$overall_characte = isset($overall_character[$an]['overall_character'])?$overall_character[$an]['overall_character']:'';

$tenant_pets = isset($any_pets[$an]['any_pets'])?$any_pets[$an]['any_pets']:'';
$verified_date = isset($verified_dates[$an]['verified_date'])?$verified_dates[$an]['verified_date']:'';

if (!in_array($analyst_value,[0,1,5])) {
  
$index = array_search('23_'.$in,array_column($components_array, 'id'));
 $in++;     
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
 
$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Landlord Name</td>';
$html .='<td colspan="2">'.$landload.'</td>'; 
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Landlord Contact Number</td>';
$html .='<td colspan="2">'.$number.'</td>'; 
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

/*new*/
$html .='<tr>';
$html .='<td>3</td>';
$html .='<td >How long was the tenancy?</td>';
$html .='<td colspan="2">'.$tenancy_perio.'</td>'; 
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>4</td>';
$html .='<td >What was the Monthly rental amount?</td>';
$html .='<td colspan="2">'.$monthly_rental_amoun.'</td>'; 
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>5</td>';
$html .='<td >Who were the occupants of the property ?</td>';
$html .='<td colspan="2">'.$occupants_propert.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>6</td>';
$html .='<td >Did the tenant consistently pay rent on time?</td>';
$html .='<td colspan="2">'.$tenant_consistently_pay_rent_on_tim.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>7</td>';
$html .='<td >Was the utility bills paid on time?</td>';
$html .='<td colspan="2">'.$utility_bills_paid_on_tim.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>8</td>';
$html .='<td >Did the tenant maintain the rental property well?</td>';
$html .='<td colspan="2">'.$rental_propert.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>9</td>';
$html .='<td >Were there any major damages or maintenance issues?</td>';
$html .='<td colspan="2">'.$maintenance_issue.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>10</td>';
$html .='<td >Why did the tenant leave?</td>';
$html .='<td colspan="2">'.$tenant_leav.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>11</td>';
$html .='<td >Would you rent to this tenant again?</td>';
$html .='<td colspan="2">'.$tenant_rent_agai.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td>12</td>';
$html .='<td >Did the tenant have any pets?</td>';
$html .='<td colspan="2">'.$tenant_pets.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';


$html .='</table></div>';
$html .='<div class="page-break"></div>';
$html .='<div class="container-fluid margin-1 bg-gray"> 
            <table class="table-2" cellspacing="0" > ';
    

$html .='<tr>';
$html .='<td>13</td>';
$html .='<td >Were there any complaints from neighbors or other tenants?</td>';
$html .='<td colspan="2">'.$complaints_from_neighbor.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>14</td>';
$html .='<td >What was the food preference of the Tenant?</td>';
$html .='<td colspan="2">'.$food_preferenc.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>15</td>';
$html .='<td >How did the tenant spend their spare time?</td>';
$html .='<td colspan="2">'.$spare_tim.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>16</td>';
$html .='<td >Describe the tenant’s overall character</td>';
$html .='<td colspan="2">'.$overall_characte.'</td>';
$html .='<td style="color: '.$color_code.'; " >'.$check16px.'</td>';
$html .='</tr>';
 

$html .='<tr>';
$html .='<td>17</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_date).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>18</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2" >'.$remark.'</td>'; 
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .=' 
</table>';
 
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>'; 
 
 
$approved_doc = json_decode($table['landload_reference']['approved_doc'],true);
if (isset($approved_doc[0])) { 
    if (count($approved_doc[0]) > 0 && !in_array('no-file',$approved_doc[0])) {
     

$max = 0;
 foreach ($approved_doc[0] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
}
/*end if*/

} 

}
/*end of the landlord*/

/* Covid-19 Check  */


if (isset($table['covid_19']['covid_id'])) {
   
    $remark_country = json_decode($table['covid_19']['remark_country'],true); 
    // $candidate_name = $file_name_final; 
    $verification_remarks = json_decode($table['covid_19']['verification_remarks'],true);
    $verified_date = json_decode($table['covid_19']['verified_date'],true);
    $analyst_status = $table['covid_19']['analyst_status'];
 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />'; 
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status)?$analyst_status:0;
$font_color = '#FFFFFF';
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
 
$index = array_search('24_'.$in,array_column($components_array, 'id'));
 $in++;      
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">Covid-19 Check</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';

$remark_countrys = isset($remark_country[0]['country'])?$remark_country[0]['country']:''; 
$verification_remark = isset($verification_remarks[0]['verification_remarks'])?$verification_remarks[0]['verification_remarks']:'';
$verified_dates = isset($verified_date[0]['verified_date'])?$verified_date[0]['verified_date']:'';
 
$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remark.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';

$html .=' 
</table>';
 
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>'; 

$approved_doc = json_decode($table['covid_19']['approved_doc'],true);
if (isset($approved_doc[0])) { 
    if (count($approved_doc[0]) > 0 && !in_array('no-file',$approved_doc[0])) {
     

$max = 0;
 foreach ($approved_doc[0] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

} 

}
/*End of the covid*/

/* social media check */

 


if (isset($table['social_media']['social_id'])) {
  
    $company_list = isset($table['social_media']['company_list'])?$table['social_media']['company_list']:'NA'; 
    $start_date = isset($table['social_media']['start_date'])?$table['social_media']['start_date']:'NA'; 
    $end_date = isset($table['social_media']['end_date'])?$table['social_media']['end_date']:'NA'; 
    $candidate_name = $file_name_final; 
    $verification_remarks = isset($table['social_media']['verification_remarks'])?$table['social_media']['verification_remarks']:'NA';
    $analyst_status = isset($table['social_media']['analyst_status'])?$table['social_media']['analyst_status']:'NA';
    $verified_dates = isset($table['social_media']['verified_date'])?$table['social_media']['verified_date']:'NA';
 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />'; 
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status)?$analyst_status:0;
$font_color = '#FFFFFF';
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
 
$in = 1; 
$index = array_search('25_'.$in,array_column($components_array, 'id'));
 $in++;      
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
 // $html .= $doc_display;
// $verification_remarks

$html .='<tr>';
$html .='<td>1</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td>2</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'.$verification_remarks.'</td>';
$html .='<td style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
  
$html .='</table>'; 
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>'; 
 
$approved_doc = explode(',',$table['social_media']['approved_doc']);
if (isset($approved_doc)) { 
    if (count($approved_doc) > 0 && !in_array('no-file',$approved_doc)) {
     

$max = 0;
 foreach ($approved_doc as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

} 

}

/*End of social*/


/* civil */
 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';

if (isset($table['civil_check']['civil_check_id'])) {

    // print_r($table['criminal_checks']); 
     $address = json_decode($table['civil_check']['address'],true); 
     $re_address = json_decode($table['civil_check']['remark_address'],true); 
     $states = json_decode($table['civil_check']['state'],true);
     $re_states = json_decode($table['civil_check']['remark_state'],true);
     $pin_code = json_decode($table['civil_check']['pin_code'],true);
     $re_pin_code = json_decode($table['civil_check']['remark_pin_code'],true);
     $city = json_decode($table['civil_check']['city'],true); 
     $re_city = json_decode($table['civil_check']['remark_city'],true); 
     $verification_remarks = json_decode($table['civil_check']['verification_remarks'],true); 
     $verified_date = json_decode($table['civil_check']['verified_date'],true); 
      $analyst_status = explode(',',$table['civil_check']['analyst_status']); 
 
    $approved_doc = json_decode($table['civil_check']['approved_doc'],true);

    
$remarks ='';
$x = 0;
$in = 1;
foreach ($address as $key => $value) { 

    $color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status[$key])?$analyst_status[$key]:0; 
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
            $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
        $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
$index = array_search('26_'.$in,array_column($components_array, 'id'));
 $in++;
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
 
$remarks = isset($verification_remarks[$key]['verification_remarks'])?$verification_remarks[$key]['verification_remarks']:''; 
 $city_sub = isset($city[$key]['city'])?$city[$key]['city']:"-";
 $re_city_sub = isset($re_city[$key]['city'])?$re_city[$key]['city']:"-";
 $address_sub = isset($value['address'])?$value['address']:"-";
 $re_address_sub = isset($re_address[$key]['address'])?$re_address[$key]['address']:"-";
 $state_sub = isset($states[$key]['state'])?$states[$key]['state']:"-";
 $re_state_sub = isset($re_states[$key]['state'])?$re_states[$key]['state']:"-";
 $pincode_sub = isset($pin_code[$key]['pincode'])?$pin_code[$key]['pincode']:"-";
 $re_pincode_sub = isset($re_pin_code[$key]['pincode'])?$re_pin_code[$key]['pincode']:"-";

 $verified_dates = isset($verified_date[$key]['verified_date'])?$verified_date[$key]['verified_date']:"";
 $Address_title_name = "Address";
 $City_title_name = "City";
 $State_title_name = "State";
 $Pincode_title_name = "Pincode";

  $address_img = $check16px;
    $states_img = $check16px;
    $pin_code_img = $check16px;
    $city_img = $check16px;

         if (strtolower($address_sub) != strtolower($re_address_sub)) {
             // $address_img = $re_address_sub; 
         }
        if (strtolower($state_sub) ==strtolower($re_state_sub)) {
            // $states_img =  $re_state_sub;
            // $state_sub = $re_state_sub;
        }
        if (strtolower($pincode_sub) != strtolower($re_pincode_sub)) {
            // $pin_code_img =  $re_pincode_sub;
            // $pincode_sub = $re_pincode_sub;
        }
        if (strtolower($city_sub) !=strtolower($re_city_sub)) {
            // $city_img = $re_city_sub;
            // $city_sub = $re_city_sub;
        }
 
$html .='<tr>';
$html .='<td >1</td>';
$html .='<td  >'.$Address_title_name.'</td>';
$html .='<td  colspan="2">'.$address_sub.'</td>';
$html .='<td  style="color: '.$color_code.'; " >'.$address_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td >2</td>';
$html .='<td  >'.$City_title_name.'</td>
<td  colspan="2">'.$city_sub.'</td>';
$html .='<td  style="color: '.$color_code.'; " >'.$city_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td >3</td>';
$html .='<td  >'.$State_title_name.'</td>';
$html .='<td  colspan="2">'.$state_sub.'</td>';
$html .='<td  style="color: '.$color_code.'; " >'.$states_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td  >4</td>';
$html .='<td   >'.$Pincode_title_name.'</td>';
$html .='<td colspan="2">'. $pincode_sub.'</td>';
$html .='<td   style="color: '.$color_code.'; " >'.$pin_code_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td >5</td>';
$html .='<td >Verified Date</td>';
$html .='<td colspan="2">'.get_date($verified_dates).'</td>';
$html .='<td style="color: '.$color_code.'; "></td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td  >6</td>';
$html .='<td >Verification Remarks </td>';
$html .='<td colspan="2">'. $remarks.'</td>';
$html .='<td  style="color: '.$color_code.'; " ></td>';
$html .='</tr>';
  
$html .='</table>';
 
$html .='</div>';
$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';

if (isset($approved_doc[$key])) { 
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) {
     

$max = 0;
 foreach ($approved_doc[$key] as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
 /*end if*/
}
} 

 }
 

/*End of the Civil*/


/*Right To Work */



if (isset($table['right_to_work']['right_to_work_id'])) {
 


    // print_r($table['court_records']);
     $document_number = json_decode($table['right_to_work']['document_number'],true);  
     $verification_remarks = json_decode($table['right_to_work']['verification_remarks'],true); 
      $analyst_status = explode(',',$table['right_to_work']['analyst_status']); 
  $approved_doc = json_decode($table['right_to_work']['approved_doc'],true); 
  $verified_date = json_decode($table['right_to_work']['verified_date'],true); 
  $v =0;
  $in =1;
     foreach ($document_number as $key => $value) { 
 

$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($analyst_status[$key])?$analyst_status[$key]:0;
$font_color = '#FFFFFF';
 
    if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
            $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
 
$index = array_search('27_'.$in,array_column($components_array, 'id'));
 $in++; 
 $html .='<div class="page-break"></div>';
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th width="40%;">Details</th> 
                    <th>Result</th>
                </tr>';


                 $document_numbers = isset($document_number[$key]['document_number'])?$document_number[$key]['document_number']:''; 
                 $remarks = isset($verification_remarks[$key]['verification_remarks'])?$verification_remarks[$key]['verification_remarks']:''; 
             
            $verified_dates = isset($verified_date[$key]['verified_date'])?$verified_date[$key]['verified_date']:"";
            

           $html .='<tr><td class="sr-no">1.</td>';
            $html .='<td>Passport/Aadhar/Voter id/SSN</td>';
            $html .='<td width="40%;">'.$document_numbers.'</td>'; 
            $html .='<td>'.$check16px.'</td>';
            $html .='</tr>';
 
            $html .='<tr><td class="sr-no">2.</td>';
            $html .='<td>Verified Date</td>';
            $html .='<td width="40%;">'.get_date($verified_dates).'</td>'; 
            $html .='<td style="color: '.$color_code.'; "></td>';
            $html .='</tr>';

            $html .='<tr><td class="sr-no">3.</td>';
            $html .='<td>Verification Remarks </td>';
            $html .='<td width="40%;">'. $remarks.'</td>'; 
            $html .='<td style="color: '.$color_code.'; " ></td>';
            $html .='</tr>';

                $html .='
            </table>
        </div>';

$html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';

if (isset($approved_doc[$key])) { 
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) {
     

    $max = 0;
     foreach ($approved_doc[$key] as $key1 => $value){ 
  $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';

 
            } 
     }
    }
 }
    /*end for each*/



    }
    }
    }

    /*End Of the court check*/



/* Sex Offender  */


 
if (isset($table['sex_offender']['sex_offender_id'])) {  

 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['sex_offender']['analyst_status'])?$table['sex_offender']['analyst_status']:0;
$font_color = '#FFFFFF';
 
   if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
  
$in = 1;
$index = array_search('28_'.$in,array_column($components_array, 'id'));
 $in++;
 
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
  
$html .='<tr>';
$html .='<td>1</td>'; 
$html .='<td >Verified Date</td>'; 
$html .='<td colspan="2">'.get_date($table['sex_offender']['verified_date']).'</td>'; 
$html .='<td ></td>';
$html .='</tr>';

$html .='<tr>'; 
$html .='<td>2</td>'; 
$html .='<td  >Verification Remarks </td>';
$html .='<td colspan="2">'.$table['sex_offender']['verification_remarks'].'</td>';
$html .='<td ></td>';
$html .='</tr>';
 
 
$html .='</table>';
 
$html .='</div>';
 $html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';


$approved_doc = explode(',', $table['sex_offender']['approved_doc']);
if (isset($approved_doc)) { 
    if (count($approved_doc) > 0 && !in_array('no-file',$approved_doc)) {
     

$max = 0;
 foreach ($approved_doc as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

}
  
}

/*End of the Sex Offender*/

/* Politically Exposed Person  */


 
if (isset($table['politically_exposed']['politically_exposed_id'])) {  

 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['politically_exposed']['analyst_status'])?$table['politically_exposed']['analyst_status']:0;
$font_color = '#FFFFFF';
 
   if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
  
$in = 1;
$index = array_search('29_'.$in,array_column($components_array, 'id'));
 $in++;
 
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
 
 
$html .='<tr>';
$html .='<td>1</td>'; 
$html .='<td >Verified Date</td>'; 
$html .='<td colspan="2">'.get_date($table['politically_exposed']['verified_date']).'</td>'; 
$html .='<td ></td>';
$html .='</tr>';

$html .='<tr>'; 
$html .='<td>2</td>'; 
$html .='<td  >Verification Remarks </td>';
$html .='<td colspan="2">'.$table['politically_exposed']['verification_remarks'].'</td>';
$html .='<td ></td>';
$html .='</tr>';
 
 
$html .='</table>';
 
$html .='</div>';
 $html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';


$approved_doc = explode(',', $table['politically_exposed']['approved_doc']);
if (isset($approved_doc)) { 
    if (count($approved_doc) > 0 && !in_array('no-file',$approved_doc)) {
     

$max = 0;
 foreach ($approved_doc as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

}
  
}

/*End of the Politically Exposed Person*/
/* india_civil_litigation  */


 
if (isset($table['india_civil_litigation']['india_civil_litigation_id'])) {  

 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['india_civil_litigation']['analyst_status'])?$table['india_civil_litigation']['analyst_status']:0;
$font_color = '#FFFFFF';
 
   if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
  
$in = 1;
$index = array_search('30_'.$in,array_column($components_array, 'id'));
 $in++;
 
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
  
$html .='<tr>';
$html .='<td>1</td>'; 
$html .='<td >Verified Date</td>'; 
$html .='<td colspan="2">'.get_date($table['india_civil_litigation']['verified_date']).'</td>'; 
$html .='<td ></td>';
$html .='</tr>';

$html .='<tr>'; 
$html .='<td>2</td>'; 
$html .='<td  >Verification Remarks </td>';
$html .='<td colspan="2">'.$table['india_civil_litigation']['verification_remarks'].'</td>';
$html .='<td ></td>';
$html .='</tr>';
 
 
$html .='</table>';
 
$html .='</div>';
 $html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';


$approved_doc = explode(',', $table['india_civil_litigation']['approved_doc']);
if (isset($approved_doc)) { 
    if (count($approved_doc) > 0 && !in_array('no-file',$approved_doc)) {
     

$max = 0;
 foreach ($approved_doc as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

}
  
}

/*End of the india_civil_litigation*/
/* mca  */


 
if (isset($table['mca']['mca_id'])) {  

 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['mca']['analyst_status'])?$table['mca']['analyst_status']:0;
$font_color = '#FFFFFF';
 
   if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
  
$in = 1;
$index = array_search('31_'.$in,array_column($components_array, 'id'));
 $in++;
 
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
 
 
$html .='<tr>';
$html .='<td>1</td>'; 
$html .='<td >MCA</td>'; 
$html .='<td colspan="2">'.get_date($table['mca']['organization_name']).'</td>'; 
$html .='<td ></td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>2</td>'; 
$html .='<td >Verified Date</td>'; 
$html .='<td colspan="2">'.get_date($table['mca']['verified_date']).'</td>'; 
$html .='<td ></td>';
$html .='</tr>';

$html .='<tr>'; 
$html .='<td>3</td>'; 
$html .='<td  >Verification Remarks </td>';
$html .='<td colspan="2">'.$table['mca']['verification_remarks'].'</td>';
$html .='<td ></td>';
$html .='</tr>';
 
 
$html .='</table>';
 
$html .='</div>';
 $html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';


$approved_doc = explode(',', $table['mca']['approved_doc']);
if (isset($approved_doc)) { 
    if (count($approved_doc) > 0 && !in_array('no-file',$approved_doc)) {
     

$max = 0;
 foreach ($approved_doc as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

}
  
}

/*End of the mca*/

/* nric  */


 
if (isset($table['nric']['nric_id'])) {  

 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['nric']['analyst_status'])?$table['nric']['analyst_status']:0;
$font_color = '#FFFFFF';
 
   if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
  
$in = 1;
$index = array_search('32_'.$in,array_column($components_array, 'id'));
 $in++;
 
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
  
$html .='<tr>';
$html .='<td>1</td>'; 
$html .='<td >NRIC Number</td>'; 
$html .='<td colspan="2">'.get_date($table['nric']['nric_number']).'</td>'; 
$html .='<td ></td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>1</td>'; 
$html .='<td >Verified Date</td>'; 
$html .='<td colspan="2">'.get_date($table['nric']['verified_date']).'</td>'; 
$html .='<td ></td>';
$html .='</tr>';

$html .='<tr>'; 
$html .='<td>2</td>'; 
$html .='<td  >Verification Remarks </td>';
$html .='<td colspan="2">'.$table['nric']['verification_remarks'].'</td>';
$html .='<td ></td>';
$html .='</tr>';
 
 
$html .='</table>';
 
$html .='</div>';
 $html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';


$approved_doc = explode(',', $table['nric']['approved_doc']);
if (isset($approved_doc)) { 
    if (count($approved_doc) > 0 && !in_array('no-file',$approved_doc)) {
     

$max = 0;
 foreach ($approved_doc as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

}
  
}

/*End of the nric*/
/* gsa  */


 
if (isset($table['gsa']['gsa_id'])) {  

 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['gsa']['analyst_status'])?$table['gsa']['analyst_status']:0;
$font_color = '#FFFFFF';
 
   if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
  
$in = 1;
$index = array_search('33_'.$in,array_column($components_array, 'id'));
 $in++;
 
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
  
$html .='<tr>';
$html .='<td>1</td>'; 
$html .='<td >Verified Date</td>'; 
$html .='<td colspan="2">'.get_date($table['gsa']['verified_date']).'</td>'; 
$html .='<td ></td>';
$html .='</tr>';

$html .='<tr>'; 
$html .='<td>2</td>'; 
$html .='<td  >Verification Remarks </td>';
$html .='<td colspan="2">'.$table['gsa']['verification_remarks'].'</td>';
$html .='<td ></td>';
$html .='</tr>';
 
 
$html .='</table>';
 
$html .='</div>';
 $html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';


$approved_doc = explode(',', $table['gsa']['approved_doc']);
if (isset($approved_doc)) { 
    if (count($approved_doc) > 0 && !in_array('no-file',$approved_doc)) {
     

$max = 0;
 foreach ($approved_doc as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

}
  
}

/*End of the gsa*/

/* oig  */


 
if (isset($table['oig']['oig_id'])) {  

 
$check16px = '<img class="tick-mark-img" src="data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data).'" />';
$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = isset($table['oig']['analyst_status'])?$table['oig']['analyst_status']:0;
$font_color = '#FFFFFF';
 
   if ( $analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    }else if ( $analyst == '2') {
          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
    }else if ( $analyst == '3') {
          
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
    }else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    }else if ( $analyst == '5') {
             $check16px = "NA";
           $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
    }else if ($analyst == '6') {
         $check16px = "NA";
       $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
    }else if ($analyst == '7') {
         $check16px = "X";
        $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        
    }else if ($analyst == '8') {
         $check16px = "NA";
        $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
    }else if ($analyst == '9') {
         $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
         

    }else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
          
    }else{
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
  
$in = 1;
$index = array_search('34_'.$in,array_column($components_array, 'id'));
 $in++;
 
$html .='<div class="page-break"></div>'; 
$html .='<div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">'.$components_array[$index]['component_name'].'</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Result : <span style="color:'.$color_code.'" class="report-details-td-2">'.$string_status.'</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2" cellspacing="0">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th colspan="2">Details</th> 
                    <th>Result</th>
                </tr>';
  
$html .='<tr>';
$html .='<td>1</td>'; 
$html .='<td >Verified Date</td>'; 
$html .='<td colspan="2">'.get_date($table['oig']['verified_date']).'</td>'; 
$html .='<td ></td>';
$html .='</tr>';

$html .='<tr>'; 
$html .='<td>2</td>'; 
$html .='<td  >Verification Remarks </td>';
$html .='<td colspan="2">'.$table['oig']['verification_remarks'].'</td>';
$html .='<td ></td>';
$html .='</tr>';
 
 
$html .='</table>';
 
$html .='</div>';
 $html .='<table class="table">
                <tr>
                    <td>
                        <span >*Note: Remainder of page intentionally left blank.</span>
                    </td>
                     
                </tr>
            </table>';


$approved_doc = explode(',', $table['oig']['approved_doc']);
if (isset($approved_doc)) { 
    if (count($approved_doc) > 0 && !in_array('no-file',$approved_doc)) {
     

$max = 0;
 foreach ($approved_doc as $key1 => $value){ 
    $sample_attachment_img_base64 = '';
        $url = base_url()."../uploads/remarks-docs/".$value;
        $info = @file_get_contents($url);
        $ext = pathinfo($value, PATHINFO_EXTENSION); 
        if(in_array(strtolower($ext), array('jpg','jpeg','png')) && $info !='' && $info !=null){
 $sample_attachment_img_type = pathinfo($url, PATHINFO_EXTENSION);
        $sample_attachment_img_data = file_get_contents($url);
        $sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);
         
        $details = getimagesize($url); 
                     $height ='';
                    if (isset($details[1])) {
                       if ($details[1] > 780) {
                          $height = 'height="780"';
                       }
                    }

            $html .='<div class="page-break"></div>';

            $html .='<div class="container-fluid margin-1">
                <div class="info-div-txt">Annexure '.(++$max).'</div>
                <div class="info-div-txt">&nbsp;</div>
                <div class="container-fluid bg-gray text-center mt-1">
                    <img '.$height.' class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
                </div>
            </div>';
        } 
 }
/*end for each*/

}
}
/*end if*/

}
  
}

/*End of the oig*/





        $html .='<div class="page-break"></div>
 
        <div class="container-fluid margin-1">
            <h1 class="end-of-report-txt">&nbsp;&nbsp;&nbsp;End of Report</h1>
            <p class="disclaimer-txt">
                <span>Disclaimer:</span>QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.
            </p>
        </div>
    </main>

 
</body>
</html>';
 /*echo $html;
 exit();*/
$pdf->loadHtml($html,'UTF-8');
$pdf->set_paper('a4', 'portrait');// or landscape
$pdf->render();
 $canvas = $pdf->getCanvas();
    $pdfa = $canvas->get_cpdf();

    foreach ($pdfa->objects as &$o) {
        if ($o['t'] === 'contents') {
            $o['c'] = str_replace('_PG', $canvas->get_page_count(), $o['c']);
        }
    }

 


 $output = $pdf->output();
// $file_name = $generate_pdf_details_variable['invoice_pdf_name'];
// $generated_pdf = file_put_contents('uploads/purchased-package-invoice/'.$file_name, $output);
$pdf->stream($file_name_final.".pdf", array("Attachment" => false));
$pdf->stream($file_name_final.".pdf");

 
exit(0);
?>