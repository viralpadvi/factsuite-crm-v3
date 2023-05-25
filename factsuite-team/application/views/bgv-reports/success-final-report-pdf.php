<?php
    $candidate_details = json_decode($generated_report_details['candidate_details'],true);
    // print_r($generated_report_details);

    $candidate_id = $candidate_details['candidate_id'];
    $table = json_decode($generated_report_details['component_details'],true);
    $candidate_status = json_decode($generated_report_details['component_status'],true);
    // print_r($candidate_status)
    $client_details = $this->db->where('client_id',$candidate_details['client_id'])->get('tbl_client')->row_array();
    // exit();
  
    function get_date($date) {
        return date("d-m-Y", strtotime($date));
    }

    $form_values = json_decode($candidate_details['form_values'],true); 
    // $data = $this->outPutQcModel->getSingleAssignedCaseDetails($generated_report_details['candidate_id']);
    $logo =  'data:image/jpg;base64,'.base64_encode(file_get_contents(base_url().'assets/admin/images/FactSuite-logo.png'));
    $cancel =  base_url().'assets/admin/images/marks/cancel-16.png';
    $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
    $green_img = base_url().'assets/admin/images/marks/green.png';
    $verifiy_img = '<img height="400%" src="'.base_url().'assets/admin/images/marks/verify.png" >';
    $file_name_final = $generated_report_details['candidate_id'].'-'.trim(strtolower($candidate_details['first_name'])).'_'.trim(strtolower($candidate_details['last_name'])).'-'.'V'.$generated_report_details['report_generated_version'].'.pdf';
    class MYPDF extends TCPDF {
        function Footer() {
            // Position at 15 mm from bottom
            $this->SetY(-25);
            // Set font
            $this->SetFont('helvetica', '', 7);
            // Page number

            $this->Cell(0, 10,' Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            $this->Ln(07);
            $this->SetFillColor(255, 255, 255);
            $this->MultiCell(190, 80, 'Disclaimer: - QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. ur reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.', 0, '', 1, 1, '', '', true);
        }
    }

 

    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setPrintHeader(false);
    // $pdf->setPrintFooter(false);
    // set header and footer fonts
    // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    // $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    $pdf->SetFont('helvetica', '', 9);
    $pdf->AddPage();
    ob_start();
    /*
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $pdf->setFont('Helvetica', '', 14, '', true); 
    */
    // print_r($data);
    /*echo '<img style="display: block; margin-left: auto;margin-right: auto; width: 20%; margin-top: 50px;" src="'.$logo.'" alt="" srcset="">';*/
    $html_tr ='';
    // exit();
     
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
        $verifiy_img = "<h3 style='color:white;background-color:red;'>Verified Discrepancy</h3>";
        $verifiy_img = '<img height="400%" src="'.base_url().'assets/admin/images/marks/7.png" >';
        $color_code = '#e20404';
        $bgcolor_code = '#f77474'; 
        $green_img = base_url().'assets/admin/images/marks/red.png';
        $text_status = "RED REPORT";
    } else if(array_intersect(['6','9'], $form_analyst_status)) {
         if (in_array('6',$form_analyst_status)) {
            $verifiy_img = "<h3 style='color:white;background-color:#FF8C00;'>Unable to Verify</h3>";
            $verifiy_img = '<img height="400%" src="'.base_url().'assets/admin/images/marks/04.png" >';
        } else if (in_array('9',$form_analyst_status)) { 
            $verifiy_img = "<h3 style='color:white;background-color:#FF8C00;'>Closed insufficiency</h3>";
            $verifiy_img = '<img height="400%" src="'.base_url().'assets/admin/images/marks/09.png" >';
        } else {
            $verifiy_img = "<h3 style='color:white;background-color:#FF8C00;'>Unable to Verify</h3>";
            $verifiy_img = '<img height="400%" src="'.base_url().'assets/admin/images/marks/04.png" >';  
        }
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $green_img = base_url().'assets/admin/images/marks/orange.png';
        $text_status = "ORANGE REPORT";
    } else if(array_intersect(['4'], $form_analyst_status)) {
        $verifiy_img = "<h3 style='color:white;background-color:green;'>Verified Clear</h3>";
        $verifiy_img = '<img height="400%" src="'.base_url().'assets/admin/images/marks/07.png" >';  
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';  
        $text_status = "GREEN REPORT";
    } else if(array_intersect(['5'], $form_analyst_status)) {
        $verifiy_img = "<h3 style='color:white;background-color:#FF8C00;'>Stop Check</h3>";
        $verifiy_img = '<img height="400%" src="'.base_url().'assets/client/images/marks/05.png" >';
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $green_img = base_url().'assets/admin/images/marks/orange.png';
        $text_status = "ORANGE REPORT";
    } else if(in_array('0', $form_analyst_status)) {
        // $color_code = '#1F7705';
        $color_code = '#FFFF00';
        // $bgcolor_code = '#FAFAD2';  
        $bgcolor_code = '#FFD4AE';
        $green_img = base_url().'assets/admin/images/marks/yellow.png';
        $text_status = "YELLOW REPORT";
        $report_type = "Intrim Report";
    } else if(array_intersect(['8','1','3'], $form_analyst_status)) {
        $color_code = '#009fff';
        $bgcolor_code = '#62c4ff';
        $text_status = "BLUE REPORT";
        // $report_type = "Intrim Report";
        $green_img = base_url().'assets/admin/images/marks/blue.png';
    }
    $candidate_final_name = $candidate_details['first_name'].' '.$candidate_details['last_name'];
 
$html ='</head>';
$html .='<body>';
 
 
$html .='<div align="center"><img style="" width="200px" src="'.base_url().'assets/admin/images/FactSuite-logo.png" alt="" srcset="">';
$html .='<p style="font-size: 14px; color: #100F0F; font-weight: bold;  margin-bottom: 0px;">
Employee Background Verification <br> '.$report_type.'</p><hr style=" color:#381653; height: 1px; margin-right:80px; margin-left: 80px;"></div>';
 

$html .='<div style="background-color: #F59E1D;margin-top: 40px; margin-right:85px; margin-left: 85px; " >
<div style="padding:50px;line-height:20px;">
<div style="color: #FFFFFF; font-weight: bold; font-size: 12px;"> Case Details</div>

<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;">
<tr>
<td style="padding-bottom: 15px;  font-size: 10px;" width="23%" >Case ID No.</td>
<td style="padding-bottom: 15px;" width="2%">:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px;" width="25%" >'.$candidate_details['candidate_id'].'</td>
<td style="padding-bottom: 15px; font-size: 10px;" width="23%" >Date Requested</td>
<td style="padding-bottom: 15px;" width="2%" >:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px;" width="25%" >'.get_date($candidate_details['created_date']).'</td>
</tr>
<tr>
<td style="padding-bottom: 15px; font-size: 10px;" width="23%">Name Of Client</td>
<td style="padding-bottom: 15px;" width="2%">:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px;" width="25%">'.ucwords($client_details['client_name']).'</td>
<td style="padding-bottom: 15px; font-size: 10px;"  width="23%" >Date Completed</td>
<td style="padding-bottom: 15px;" width="2%">:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px;" width="25%" >'.get_date($candidate_details['updated_date']).'</td>
</tr>
<tr>
<td  style="padding-bottom: 15px; font-size: 10px;" width="23%" >Name Of Candidate</td>
<td style="padding-bottom: 15px;" width="2%" >:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px;" width="25%" >'.ucwords($candidate_final_name).'</td>
<td  style="padding-bottom: 15px; font-size: 10px;" width="23%" >Date Of Birth</td>
<td style="padding-bottom: 15px;" width="2%" >:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px;" width="25%" >'.get_date($candidate_details['date_of_birth']).'</td>
</tr>
<tr>
<td style="padding-bottom: 15px; font-size: 10px;" width="23%">Employee ID</td>
<td style="padding-bottom: 15px;" width="2%">:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px;" width="25%">'.$candidate_details['employee_id'].'</td>
<td style="padding-bottom: 15px; font-size: 10px;" width="23%">Date of Joining</td>
<td style="padding-bottom: 15px;" width="2%">:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px;" width="25%">'.get_date($candidate_details['date_of_joining']).'</td>
</tr>
<tr>
<td style="padding-bottom: 15px; width: 23%; font-size: 10px;">Father\'s Name</td>
<td style="padding-bottom: 15px;" width="2%" >:</td>
<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px;" width="25%" >'.ucwords($candidate_details['father_name']).'</td>
</tr>
</table>
</div>
</div>
<div style="padding: 35px; background-color:'.$bgcolor_code.' ;margin-top: 5px; margin-right:80px; margin-left: 80px;line-height:10px; " >
<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Result Definitions<br/></div> 

<table style="margin-top: 28px; border-collapse: collapse;
width: 100%;line-height:10px;">
<tr>
<td  style="text-align:center"><img height="400%" src="'.$green_img.'" ></td>
<td style="text-align:center;margin-top:15px">'.$verifiy_img.'</td>
</tr>
</table>
</div>
<div style="padding: 35px; background-color: #e2e5f3;margin-top: 5px; margin-right:80px; margin-left: 80px;line-height:18px; " >
<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Executive Summary</div>

<table style="margin-top: 5px;
border-collapse: collapse;
width: 100%;">
<tr>
<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Overall Status</td>
<td style="padding-bottom: 15px; width: 2%;">:</td>
<td style="padding-bottom: 15px; width: 20%; font-weight: bold; font-size: 10px; color: #381653;">'.$overoll.'</td>
<td></td>
</tr>
</table>
<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">
<tr style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: bold;">
<th style="padding: 12px 0px 12px 25px;" width="40%" >Component Type</th> 
<th width="30%">Status</th>
<th width="30%">Result</th>
</tr>
<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">'; 

foreach ($candidate_status as $key1 => $value1) {
    $status = 'Completed';
    $verify ='';
    $vstatus = isset($value1['analyst_status']) ? $value1['analyst_status'] : '0';
    if ( $vstatus == '0') { 
        $status = '<span style="color:black;">In-Progress</span>'; 
        $verify ='<span style="color:black;">In-Progress</span>';
    } else if ( $vstatus == '1') {
        $status = '<span style="color:black;">In-Progress</span>'; 
        $verify ='<span style="color:black;">In-Progress</span>';
    } else if ( $vstatus == '2') {   
        $status = '<span style="color:green;">Completed</span>'; 
        $verify ='<span style="color:green;">Verified Clear</span>';
    } else if ( $vstatus == '3') {
        $status = '<span style="color:black;">Completed</span>'; 
        $verify ='<span style="color:black;">Insufficiency</span>';
    } else if ( $vstatus == '4') { 
        $status = '<span style="color:green;">Completed</span>'; 
        $verify ='<span style="color:green;">Verified Clear</span>';
    } else if ( $vstatus == '5') {
        $status = '<span style="color:orange;">Stop Check</span>'; 
        $verify ='<span style="color:orange;">Stop Check</span>';
    } else if ($vstatus == '6') {
        $status = '<span style="color:green;">Completed</span>'; 
        $verify ='<span style="color:orange;">Unable to Verify</span>';
    } else if ($vstatus == '7') { 
        $status = '<span style="color:green;">Completed</span>'; 
        $verify ='<span style="color:red;">Verified Discrepancy</span>';
    } else if ($vstatus == '8') { 
        $status = '<span style="color:green;">Completed</span>'; 
        $verify ='<span style="color:green;">Verified Clear</span>';
    } else if ($vstatus == '9') { 
        $status = '<span style="color:green;">Completed</span>'; 
        $verify ='<span style="color:orange;">Closed Insufficiency</span>';
    } else if ( $vstatus == '10') { 
        $status = '<span style="color:black;">Completed</span>'; 
        $verify ='<span style="color:black;">QC-error</span>';
    } else {
        $status = '<span style="color:green;">Completed</span>'; 
        $verify ='<span style="color:green;">Verified Clear</span>';
    }

    /*0-pending, 
    1-filled Form(in progress), 
    2-completed, 
    3-insufficiency, 
    4-approve(Verified Clear), 
    5-stop, 
    6-Unable to Verify, 
    7-Verified Discrepancy, - red 
    8-Client clarification, 
    9-Closed insufficiency
    10-QC-error*/
    /*
    in_array([1,2,3,4,7,10,11,12]);
    */
    $component_name = '';
if (in_array($value1['component_id'],[1,2,3,4,7,10,11,12])) {
    $component_name = $value1['component_name'].' '.$value1['formNumber'];
    if ($value1['component_name'] =='Criminal Status') {
       $component_name = 'Criminal History '.$value1['formNumber'];
    }

    if ($value1['component_id'] == '7') {
        $component_name = 'Highest Education ('.$value1['value_type'].' )';
    }
} else {
  $component_name = $value1['component_name'];  
}
if ($value1['component_name'] =='Adverse Media/Media Database Check') {
    $component_name = 'Adverse Media/Database Check ';
}
if ($value1['component_name'] =='Health Checkup Check') {
    $component_name = 'Health Checkup ';
}

$html .='<tr style="margin-top:20px;">';

$html .='<td style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;"  >';
$html .=$component_name;
$html .='</td>'; 
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;text-align:left;"  width="30%" >';
$html .= $status;   
$html .='</td>';
$html .='<td style="color: #1F7705; padding-bottom: 5px 0px; font-weight: bold; font-size: 10px;text-align:left;"  width="30%"  >'; 
$html .=$verify; 
$html .='</td><td width="0%"></td>';
$html .='</tr>';

}   

$html .='</tbody>
</table>
</div>';

/* criminal history */

$html_criminal ='';
$check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';

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
    $analyst_status = explode(',',$table['criminal_checks']['analyst_status']);
    $approved_doc = json_decode($table['criminal_checks']['approved_doc'],true);

    
$remarks ='';
foreach ($address as $key => $value) {
    $color_code = '#1F7705';
    $bgcolor_code = '#1F7705';
    $string_status = 'Verified Clear';
    $status = 'Completed';
    $analyst = isset($analyst_status[$key])?$analyst_status[$key]:0; 
    if ($analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ($analyst == '1') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ($analyst == '2') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ($analyst == '3') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb';
        $string_status = 'Insufficiency';
        $status = 'Completed';
    } else if ($analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ($analyst == '5') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Stop Check';
        $status = 'Completed';
    } else if ($analyst == '6') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Unable to Verify';
        $status = 'Completed'; 
    } else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
        $bgcolor_code = '#ec0000';
        $string_status = 'Verified Discrepancy';
        $status = 'Completed';
    } else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Client Clarification';
        $status = 'Completed';  
    } else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';  
    } else if ($analyst == '10') {
        $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';      
    } else {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
 
$html_criminal .='<br pagebreak="true" />';

$html_criminal .='<br><div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 100px; margin-right:80px; margin-left: 80px; line-height:20px; " >';
$html_criminal .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;line-height:30px;"> Criminal History '. ($key+1) .'</div>';

$html_criminal .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html_criminal .='<tr>';
$html_criminal .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;line-height:30px;">Status</td>';
$html_criminal .='<td style="padding-bottom: 15px;line-height:30px;width:2%;">:</td>';
$html_criminal .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;line-height:30px;">'.$status.'</td>';
$html_criminal .='</tr>';
$html_criminal .='</table>';
$html_criminal .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html_criminal .='<tr>';
$html_criminal .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px; ">Particulars</th>';
$html_criminal .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; "> Details</th>';
$html_criminal .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html_criminal .='<th width="25%" style="background-color: '.$color_code.'; color: #ffffff; text-align: center; font-size: 10px; font-weight: normal; padding: 12px;  ">'.$string_status.' </th>';
$html_criminal .='</tr>';

$html_criminal .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';
 
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
        $address_img = $re_address_sub; 
    }

    if (strtolower($state_sub) ==strtolower($re_state_sub)) {
        $states_img =  $re_state_sub;
        // $state_sub = $re_state_sub;
    }

    if (strtolower($pincode_sub) != strtolower($re_pincode_sub)) {
        $pin_code_img =  $re_pincode_sub;
        // $pincode_sub = $re_pincode_sub;
    }

    if (strtolower($city_sub) !=strtolower($re_city_sub)) {
        $city_img = $re_city_sub;
        // $city_sub = $re_city_sub;
    }
 
$html_criminal .='<tr>';
$html_criminal .='<td width="35%" class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; font-weight: bold; font-size: 10px;line-height:30px;">'.$Address_title_name.'</td>';
$html_criminal .='<td width="30%" style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;line-height:20px;">'.$address_sub.'</td>';
$html_criminal .='<td width="10%"></td>';
$html_criminal .='<td width="25%" style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;line-height:30px;" >'.$address_img.'</td>';
$html_criminal .='</tr>';

$html_criminal .='<tr>';
$html_criminal .='<td width="35%" class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; font-weight: bold; font-size: 10px;line-height:30px;">'.$City_title_name.'</td>
<td width="30%" style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;line-height:30px;">'.$city_sub.'</td>';
$html_criminal .='<td width="10%"></td>';
$html_criminal .='<td width="25%" style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;line-height:30px;" >'.$city_img.'</td>';
$html_criminal .='</tr>';

$html_criminal .='<tr>';
$html_criminal .='<td width="35%" class="border-left-green" style="line-height:30px;padding: 10px 0px 10px 40px;color: #381653; font-weight: bold; font-size: 10px;">'.$State_title_name.'</td>';
$html_criminal .='<td width="30%" style="line-height:30px;padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$state_sub.'</td>';
$html_criminal .='<td width="10%"></td>';
$html_criminal .='<td width="25%" style="line-height:30px;color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$states_img.'</td>';
$html_criminal .='</tr>';

$html_criminal .='<tr>';
$html_criminal .='<td width="35%"  class="border-left-green" style="line-height:30px;padding: 10px 0px 10px 40px;color: #381653; font-weight: bold; font-size: 10px;">'.$Pincode_title_name.'</td>';
$html_criminal .='<td width="30%"  style="line-height:30px;padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'. $pincode_sub.'</td>';
$html_criminal .='<td width="10%" ></td>';
$html_criminal .='<td width="25%"  style="line-height:30px;color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$pin_code_img.'</td>';
$html_criminal .='</tr>';

$html_criminal .='<tr>';
$html_criminal .='<td width="35%"  class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; font-weight: bold; font-size: 10px;line-height:30px;">Verification Remarks </td>';
$html_criminal .='<td width="30%"  style="line-height:30px;padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'. $remarks.'</td>';
$html_criminal .='<td width="10%" ></td>';
$html_criminal .='<td width="25%"  style="line-height:30px;color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html_criminal .='</tr>';
 
$html_criminal .='<tr>';
$html_criminal .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;">Verified Date</td>';
$html_criminal .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['criminal_checks']['updated_date']).'</td>';
$html_criminal .='<td style="padding-bottom: 15px;"></td>';
$html_criminal .='<td style="line-height:30px;color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;">'.$check16px.'</td>';
$html_criminal .='</tr>';


$html_criminal .='</tbody>';
$html_criminal .='</table>';
/*$html_criminal .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';


$html_criminal .='</table>';*/
$html_criminal .='</div>';
 
if (isset($approved_doc[$key])) { 
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) {
     
$html_criminal .='<br pagebreak="true" />';
$html_criminal .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html_criminal .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[$key] as $key1 => $value) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key1 !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html_criminal .='<table style="margin-top: 25px;
        border-collapse: collapse;
        width: 100%;line-height:20px;">';
        $html_criminal .='<tr>'; 
        $html_criminal .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html_criminal .='</tr>';
        $html_criminal .='</table>'; 
        $max++;
    } 
}
/*end for each*/
$html_criminal .='</div>';

}
}
 /*end if*/
}
} 

 }

$html .=$html_criminal;


/* Court Record  */


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
    foreach ($address as $key => $value) {
        $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
        $html .='<br pagebreak="true" />';
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
        } else if ( $analyst == '1') {
             $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb'; 
            $string_status = 'Verified Pending';
            $status = 'In-Progress';
        } else if ( $analyst == '2') {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst == '3') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
        } else if ( $analyst == '4') {
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
        } else if ($analyst == '6') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
        } else if ($analyst == '7') {
            $check16px = "X";
            $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        } else if ($analyst == '8') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
        } else if ($analyst == '9') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Closed insufficiency';
            $status = 'Completed';
        } else if ( $analyst == '10') {
            $color_code = 'none';
            $bgcolor_code = 'none';
            $string_status = 'QC-error';
            $status = 'Completed';  
        } else {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed'; 
        } 

if (!in_array($analyst,[0,1,5])) {

$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 50px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;line-height:30px;"> Court Record '. ($key+1) .'</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';



$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';

$verification_remark = '';
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
        $address_img = $re_court_address;
    }

    if (strtolower($court_state) !=strtolower($re_court_state)) {
        $states_img = $re_court_state;
    }

    if (strtolower($court_pincode) !=strtolower($re_court_pincode)) {
        $pin_code_img = $re_court_pincode;
    }

    if (strtolower($court_city) !=strtolower($re_court_city)) {
        $city_img = $re_court_city;
    }

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Address</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$court_address.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$address_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">City</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$court_city.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$city_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">State</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$court_state.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$states_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Pincode</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$court_pincode.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$pin_code_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td  class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; font-weight: bold; font-size: 10px;line-height:30px;">Verification Remarks </td>';
$html .='<td style="line-height:30px;padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'. $verification_remark.'</td>';
$html .='<td ></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['court_records']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='</tbody>';
$html .='</table>';
 
/*
$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">'; 
$html .='</table>';*/
$html .='</div>'; 

if (isset($approved_doc[$key])) { 
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) {
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[$key] as $key1 => $value) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key1 !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    } 
}

$html .='</div>';
}

}
/*end if*/
}

}
} 


/* Document Check  */

$check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
if (isset($table['document_check']['document_check_id'])) {  

$color_code = '#1F7705';
$bgcolor_code = '#1F7705';
$string_status = 'Verified Clear';
$status = 'Completed';
$analyst = explode(',', isset($table['document_check']['analyst_status'])?$table['document_check']['analyst_status']:0);
$font_color = '#FFFFFF';
$approved_doc = json_decode($table['document_check']['approved_doc'],true);

if (isset($form_values['document_check'])) {
    foreach ($form_values['document_check'] as $key => $v) {
        $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
        if ( $analyst[$key] == '0') { 
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb'; 
            $string_status = 'Verified Pending';
            $status = 'In-Progress';
        } else if ( $analyst[$key] == '1') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb'; 
            $string_status = 'Verified Pending';
            $status = 'In-Progress';
        } else if ( $analyst[$key] == '2') {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst[$key] == '3') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
        } else if ( $analyst[$key] == '4') {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst[$key] == '5') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
        } else if ($analyst[$key] == '6') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
        } else if ($analyst[$key] == '7') {
            $check16px = "X";
            $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed';
        } else if ($analyst[$key] == '8') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
        } else if ($analyst[$key] == '9') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Closed insufficiency';
            $status = 'Completed';
        } else if ( $analyst[$key] == '10') {
            $color_code = 'none';
            $bgcolor_code = 'none';
            $string_status = 'QC-error';
            $status = 'Completed';
        } else {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed'; 
        }

$doc_display = '';

if ($v =='2') { 
$aadhar_number = isset($table['document_check']['aadhar_number'])?$table['document_check']['aadhar_number']:'';
$doc_display .='<tr>';
$doc_display .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Aadhar Number</td>';
$doc_display .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$aadhar_number.'</td>';
$doc_display .='<td></td>';
$doc_display .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$doc_display .='</tr>';
 
}
 

 
if ($v =='1') { 
$pan_number = isset($table['document_check']['pan_number'])?$table['document_check']['pan_number']:'';
$doc_display .='<tr>';
$doc_display .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Pan Card</td>';
$doc_display .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$pan_number.'</td>';
$doc_display .='<td></td>';
$doc_display .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$doc_display .='</tr>';
 
}
 
 
if ($v == '3') { 
$passport_number = isset($table['document_check']['passport_number'])?$table['document_check']['passport_number']:'';
$doc_display .='<tr>';
$doc_display .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Passport</td>';
$doc_display .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$passport_number.'</td>';
$doc_display .='<td></td>';
$doc_display .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$doc_display .='</tr>';
 
}


if (!in_array($analyst[$key],[0,1,5])) {

$html .='<br pagebreak="true" />';
  

$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Documents Check '. ($key+1) .'</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; font-size: 10px; color: #100F0F;width:15%;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%; color: #100F0F;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;width:83%;">'.$status.'</td>';
// $html .='<td style="padding-bottom: 15px; color: #381653;width:83%;"></td>'; 
$html .='</tr>';
$html .='</table>';

$verification_remarks = json_decode($table['document_check']['verification_remarks'],true);
 
 $html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">'; 
 $html .= $doc_display;

$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['document_check']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
 
$html .='</tbody>';
$html .='</table>';
$html .='</div>';
$html .='</div>';
 


if ($v == '2') { 
if (isset($approved_doc[$key]) && count($approved_doc[$key]) > 0 && !in_array('no-file', $approved_doc[$key])) { 
$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center">Annexure</h1>';

$max = 0;
foreach ($approved_doc[$key] as $key => $value) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))){
        if ($key !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    } 
}

$html .='</div>';

}

}

/*end aadhar*/


if ($v == '1') { 
if (isset($approved_doc[$key]) && count($approved_doc[$key]) > 0 && !in_array('no-file', $approved_doc[$key])) { 
$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center">Annexure </h1>';

$max = 0;
foreach ($approved_doc[$key] as $key => $value) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))){
        if ($key !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    } 
}

$html .='</div>';

}

}
/*end pan*/


if ($v == '3') { 
if (isset($approved_doc[$key]) && count($approved_doc[$key]) > 0 && !in_array('no-file', $approved_doc[$key])) { 
$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center">Annexure </h1>';

$max = 0;
foreach ($approved_doc[$key] as $key => $value) {    
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))){
        if ($key !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    } 
}

$html .='</div>';

}

}

/*end passport*/

}

}
$html .='</div>';

  
}

}


/* Drug Test  */


if (isset($table['drugtest']['drugtest_id'])) {
    $candidate_name = json_decode($table['drugtest']['candidate_name'],true);
    $father_name = json_decode($table['drugtest']['father__name'],true);
    $dob = json_decode($table['drugtest']['dob'],true);
    $address = json_decode($table['drugtest']['address'],true);
    $remark_address = json_decode($table['drugtest']['remark_address'],true);
    $mobile_number = json_decode($table['drugtest']['mobile_number'],true); 
    $codes = json_decode($table['drugtest']['code'],true); 
    $verification_remarks = json_decode($table['drugtest']['verification_remarks'],true);
    // print_r($table['drugtest']);
    $analyst_status = explode(',',$table['drugtest']['analyst_status']); 
    $approved_doc = json_decode($table['drugtest']['approved_doc'],true); 
    $drug = $this->db->where_in('drug_test_type_id',$form_value['drug_test'])->get('drug_test_type')->result_array();

foreach ($candidate_name as $key => $value) { 
    $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
    $html .='<br pagebreak="true" />';

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
    } else if ( $analyst == '1') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ( $analyst == '2') {    
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '3') {  
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb';
        $string_status = 'Insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '5') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Stop Check';
        $status = 'Completed';
    } else if ($analyst == '6') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Unable to Verify';
        $status = 'Completed'; 
    } else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
        $bgcolor_code = '#ec0000';
        $string_status = 'Verified Discrepancy';
        $status = 'Completed';
    } else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Client Clarification';
        $status = 'Completed';  
    } else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '10') {
        $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
    } else {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
   
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px; line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Drug Test '. ($key+1) .'</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';


$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>'; 
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
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
/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Candidate Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$candidate.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Father\'s Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$father.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Date Of Birth</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$birth.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Address</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$addresss.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$address_img.'</td>';
$html .='</tr>';*/

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Drug Panel</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$drug[$key]['drug_test_type_name'].'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$vremark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['drugtest']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='</tbody>';
$html .='</table>';


/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
 
$html .='</table>';*/
$html .='</div>';
 

if (isset($approved_doc[$key])) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
        if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) {
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[$key] as $key1 => $value) {
    // print_r($value);
    // if (is_array($value)) {     
    // foreach ($value as $key => $val) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key1 !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
                border-collapse: collapse;
                width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    // }
    // }

    }
}

$html .='</div>';

}
}

 }

}

}

/* Global Database  */


 
if (isset($table['globaldatabase']['globaldatabase_id'])) {
    $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
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
    } else if ( $analyst == '1') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ( $analyst == '2') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '3') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb';
        $string_status = 'Insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '4') {
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
    } else if ($analyst == '6') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Unable to Verify';
        $status = 'Completed'; 
    } else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
        $bgcolor_code = '#ec0000';
        $string_status = 'Verified Discrepancy';
        $status = 'Completed';
    } else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Client Clarification';
        $status = 'Completed';  
    } else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '10') {
        $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
    } else {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    }

if (!in_array($analyst,[0,1,5])) {

$html .='<br pagebreak="true" />';     
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Global Database</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';
$name =  isset($table['globaldatabase']['candidate_name'])?$table['globaldatabase']['candidate_name']:'-'; 
$father =  isset($table['globaldatabase']['father_name'])?$table['globaldatabase']['father_name']:'-'; 
$dob =  isset($table['globaldatabase']['dob'])?$table['globaldatabase']['dob']:'-'; 

/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Candidate Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$name.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Father Name</td>'; 
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$father.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Date Of Birth</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$dob.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';*/

$html .='<tr>'; 
$html .='<td style="padding-bottom: 20px; color:#381653; font-weight: bold; font-size: 10px;" >Verification Remarks </td>';
$html .='<td style="padding-bottom: 20px; font-weight: bold; color: #381653; font-size: 10px;">'.$table['globaldatabase']['verification_remarks'].'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;">Verified Date</td>'; 
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['globaldatabase']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='</tbody>';
$html .='</table>';
/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='</table>';*/
$html .='</div>';

$approved_doc = explode(',', $table['globaldatabase']['approved_doc']);
if (count($approved_doc) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc as $key => $value) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    } 
}

$html .='</div>';

}

}
  
}


/* Current Employment  */
if (isset($table['current_employment']['current_emp_id'])) {
    $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
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
    } else if ( $analyst == '1') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ( $analyst == '2') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '3') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb';
        $string_status = 'Insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '5') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Stop Check';
        $status = 'Completed';
    } else if ($analyst == '6') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Unable to Verify';
        $status = 'Completed'; 
    } else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
        $bgcolor_code = '#ec0000';
        $string_status = 'Verified Discrepancy';
        $status = 'Completed';
    } else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Client Clarification';
        $status = 'Completed';  
    } else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '10') {
       $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';    
    } else {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {

$html .='<br pagebreak="true" />';
    // print_r($table['current_employment']['verification_remarks']);
  
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px;" >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Current Employment</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';


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


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Designation</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$desigination.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$desigination_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Department</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$department.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$department_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Employee ID</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$employee_id.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Company Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$company.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Address</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$addr.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';*/

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Currency Of Salary</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_currency.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Annual CTC</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$ctc.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$ctc_img.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Reason For Leaving</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$leave.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Joining - Relieving Date</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Reporting Manager Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$manager.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Reporting Manager Designation</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$designation.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
/*
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Reporting Manager Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">HR Contact Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$hr_name.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$hr_name_img.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">HR Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$hr_contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$hr_contact_img.'</td>';
$html .='</tr>';



$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark Date Of Relieving</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_date_of_relieving.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark Exit Status</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_exit_status.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >N / A</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark Date Of Joining</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_date_of_joining.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark Salary Type</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_salary_type.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark Currency</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_currency.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark Eligible For Re-Hire</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_eligible_for_re_hire.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark HR Email</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_hr_email.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';*/

/**/

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Eligible for rehire</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_eligible_for_re_hire.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Attendance</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_attendance_punctuality.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Job Performance</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_job_performance.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Exit formalities</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_exit_status.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Disciplinary issues</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_disciplinary_issues.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
 

/**/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remarks.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['current_employment']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='</tbody>';
$html .='</table>';
/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">'; 
$html .='</table>';*/
$html .='</div>';
 
$approved_doc = explode(',', $table['current_employment']['approved_doc']);
if (count($approved_doc) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc as $key => $value) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    } 
 }

$html .='</div>';

} 
}
 
}

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
    $analyst_status = explode(',',$table['education_details']['analyst_status']); 
    $approved_doc = array();
    if ($table['education_details']['approved_doc'] !='') { 
        $approved_doc = json_decode($table['education_details']['approved_doc'],true);
    }

foreach ($type_of_degree as $key => $value) { 
    $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
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
    } else if ( $analyst == '1') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ( $analyst == '2') {    
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '3') {    
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb';
        $string_status = 'Insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '5') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Stop Check';
        $status = 'Completed';
    } else if ($analyst == '6') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Unable to Verify';
        $status = 'Completed'; 
    } else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
        $bgcolor_code = '#ec0000';
        $string_status = 'Verified Discrepancy';
        $status = 'Completed';
    } else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Client Clarification';
        $status = 'Completed';  
    } else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '10') {
        $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
    } else {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {

$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Highest Education ( '.$value['type_of_degree'].' ) </div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';



$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';
           
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
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Type Of Qualification</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$type_of_degree_edu.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$type_of_degree_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Major</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$edu_major.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">University / Board</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$university_board_edu.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$university_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">School / College</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$college_school_edu.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$college_school_img.'</td>';
$html .='</tr>';

/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Address </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$add.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr> ';
*/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Year Of Passing</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.get_date($start_end).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr> ';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Course Type</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$course.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr> ';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Roll Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$roll.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$roll_img.'</td>';
$html .='</tr>  '; 
 /*
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark Years Of Education</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_year_ofgraduation.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>  '; 
  */
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remarks.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>  '; 
  
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$vname.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>  '; 
  
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verifier\'s Designation</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verifier_designation.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>  '; 
 
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['education_details']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='</tbody>';
$html .='</table>';
/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='</table>';*/
$html .='</div>';

/*end loop*/

if (isset($approved_doc[$key])) {
    if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) {
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[$key] as $key1 => $value) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key1 !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    }
}

$html .='</div>';
}
}

// end if
}

}
 
}


/* Present Address */
if (isset($table['present_address']['present_address_id'])) {
    $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
    $color_code = '#1F7705';
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
    } else if ( $analyst == '1') {
         $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ( $analyst == '2') {    
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '3') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb';
        $string_status = 'Insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '4') {
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
     } else if ($analyst == '6') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Unable to Verify';
        $status = 'Completed'; 
    } else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
        $bgcolor_code = '#ec0000';
        $string_status = 'Verified Discrepancy';
        $status = 'Completed';
    } else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Client Clarification';
        $status = 'Completed';
    } else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '10') {
        $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';
    } else {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
$html .='<br pagebreak="true" />';    
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Present Address</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
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

$start_end = get_date($start).' - '.get_date($end);

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
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Flat / Door No</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$flat_no.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Street / Road</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$street.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Area</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$area.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">City / Town</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$city.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$city_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Pin Code</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$pin_code.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$pin_code_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">State</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$state.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$state_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Nearest Landmark</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$nearest_landmark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Duration Of Stay</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Property Type</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$property_type.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Contact Person Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$person_mobile_number.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Person Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$person_name .'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';*/

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Staying with</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$staying_with.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Period of Stay</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$period_of_stay.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>'; */


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Address Remarks</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remarks_address.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verifier_name.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verifier\'s Relationship</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$relationship.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$relationship_img.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remarks.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

 
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['previous_address']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
  

$html .='</tbody>';
$html .='</table>';
/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
 
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;width:16%;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.$table['present_address']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';*/
$html .='</div>';
 

$approved_doc = explode(',', $table['present_address']['approved_doc']);
if (count($approved_doc) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc as $key => $value) {
    // if (is_array($value)) {
    // foreach ($value as $key => $val) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/) {
        if ($key !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
        // }
        // }
    }
}

$html .='</div>';

}
 
 }
  
}


/* Permanent Address  */
if (isset($table['permanent_address']['permanent_address_id'])) {
    $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
    $color_code = '#1F7705';
    $bgcolor_code = '#1F7705';
    $string_status = 'Verified Clear';
    $status = 'Completed';
    $analyst = isset($table['permanent_address']['analyst_status'])?$table['permanent_address']['analyst_status']:0;
    $font_color = '#FFFFFF';
    /*if ('7' == $analyst) {
       $color_code = '#e20404';
        $bgcolor_code = '#f77474'; 
        $string_status = 'Unable To Verify';
        $status = 'Verified Discrepancy';
        $green_img = base_url().'assets/admin/images/marks/red.png';
    } else if(in_array($analyst,['6','9'])) {
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Unable To Verify';
        $status = 'Unable to Verify';
        $green_img = base_url().'assets/admin/images/marks/orange.png';
    } else if($analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else {
        $color_code = '#FFFF00';
        $bgcolor_code = '#FAFAD2'; 
        $string_status = 'Verified Pending';
        $status = 'Pending';
        $font_color = '#000000';
    }*/

    if ($analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ($analyst == '1') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ($analyst == '2') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '3') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb';
        $string_status = 'Insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '5') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Stop Check';
        $status = 'Completed';
    } else if ($analyst == '6') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Unable to Verify';
        $status = 'Completed'; 
    } else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
        $bgcolor_code = '#ec0000';
        $string_status = 'Verified Discrepancy';
        $status = 'Completed';
    } else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Client Clarification';
        $status = 'Completed';  
    } else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '10') {
        $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';
    } else {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {

$html .='<br pagebreak="true" />';     
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Permanent Address</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';
$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
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

$start_end = get_date($start).' - '.get_date($end);
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
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Flat / Door No</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$flat_no.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Street / Road</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$street.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Area</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$area.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">City / Town</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$city.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$city_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Pin Code</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$pin_code.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$pin_code_img.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">State</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$state.'</td>';
$html .='<td></td>';
$html .='<td style="color:'.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$state_img.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Nearest Landmark</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$nearest_landmark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Duration Of Stay</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Contact Person Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$person_mobile_number.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Person Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$person_name .'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';*/


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Property Type</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$property_type.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Staying with</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$staying_with.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Address Remarks</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remarks_address.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Period of Stay</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$period_of_stay.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';*/

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verifier_name.'</td>';
$html .='<td></td>';
$html .='<td style="color:'.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
 

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verifier\'s Relationship</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$relationship.'</td>';
$html .='<td></td>';
$html .='<td style="color:'.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$relationship_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remarks.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['permanent_address']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

 
$html .='</tbody>';
$html .='</table>';
/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">'; 
$html .='</table>';*/
$html .='</div>';

$approved_doc = explode(',', $table['permanent_address']['approved_doc']);
if (count($approved_doc) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc as $key => $value) {
    // print_r($value);
    // if (is_array($value)) {     
    // foreach ($value as $key => $val) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/) {
        if ($key !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
        // }
        // }
    }
}

$html .='</div>';

} 
}

}

/* Previous Employment  */



if (isset($table['previous_employment']['previous_emp_id'])) {
    $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
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
   
foreach ($desigination as $prev => $val) {
    $color_code = '#1F7705';
    $bgcolor_code = '#1F7705';
    $string_status = 'Verified Clear';
    $status = 'Completed';
    $analyst = isset($analyst_status[$prev])?$analyst_status[$prev]:0; 
    $font_color = '#FFFFFF';
    if ($analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ($analyst == '1') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ( $analyst == '2') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '3') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb';
        $string_status = 'Insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '5') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Stop Check';
        $status = 'Completed';
    } else if ($analyst == '6') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Unable to Verify';
        $status = 'Completed'; 
    } else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
        $bgcolor_code = '#ec0000';
        $string_status = 'Verified Discrepancy';
        $status = 'Completed';
    } else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Client Clarification';
        $status = 'Completed';  
    } else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '10') {
        $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
    } else {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    }

if (!in_array($analyst,[0,1,5])) {

$html .='<br pagebreak="true" />';
 
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Previous Employment '.($prev+1).'</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';


$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';

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

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Designation</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$desigination.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$desigination_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Department</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$department.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$desigination_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Employee ID</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$employee_id.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Company Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$company.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Address</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$addr.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';*/

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Currency Of Salary</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_currencys.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Annual CTC</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$ctc.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$ctc_img.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Reason For Leaving</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$leave.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Joining - Relieving Date</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Reporting Manager Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$manager.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Reporting Manager Designation</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$designation.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
/*
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Reporting Manager Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">HR Contact Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$hr_name.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$hr_name_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">HR Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$hr_contact.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$hr_contact_img.'</td>';
$html .='</tr>';
 


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark Date Of Relieving</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_date_of_relievings.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark Exit Status</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_exit_statuss.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark Date Of Joining</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_date_of_joinings.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark Salary Type</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_salary_types.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark Currency</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_currencys.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark Eligible For Re-Hire</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_eligible_for_re_hires.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Remark HR Email</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_hr_emails.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';*/

/**/

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Eligible for rehire</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_eligible_for_re_hire.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Attendance</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_attendance_punctuality.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Job Performance</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_job_performance.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Exit formalities</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_exit_status.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Disciplinary issues</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_disciplinary_issues.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
 
/**/
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['previous_employment']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='</tbody>';
$html .='</table>';


/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
 
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;width:16%;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.$table['previous_employment']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';*/
$html .='</div>';




if (isset($approved_doc[$prev])) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
        if (count($approved_doc[$prev]) > 0 && !in_array('no-file',$approved_doc[$prev])) {
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[$prev] as $key1 => $value) {
    // print_r($value);
    // if (is_array($value)) {
         
    // foreach ($value as $key => $val) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key1 !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
        // }
        // }

    }
}

$html .='</div>';
}
}

}     
 }

}

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

    foreach ($company_name as $refer => $referval) {
        $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
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
        } else if ( $analyst == '1') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb'; 
            $string_status = 'Verified Pending';
            $status = 'In-Progress';
        } else if ( $analyst == '2') {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst == '3') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
        } else if ( $analyst == '4') {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst == '5') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
        } else if ($analyst == '6') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
        } else if ($analyst == '7') {
            $check16px = "X";
            $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed';        
        } else if ($analyst == '8') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
        } else if ($analyst == '9') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Closed insufficiency';
            $status = 'Completed';
        } else if ( $analyst == '10') {
            $color_code = 'none';
            $bgcolor_code = 'none';
            $string_status = 'QC-error';
            $status = 'Completed';
        } else {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed'; 
        }

if (!in_array($analyst,[0,1,5])) {
   
 $html .='<br pagebreak="true" />';
 
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Reference '.($refer+1).'</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';



$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';

$verification_remark = isset($verification_remarks[$refer]['verification_remarks'])?$verification_remarks[$refer]['verification_remarks']:'-';
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
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verifier Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$names.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Company Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$company_names.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Designation</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$designations.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Contact Number</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'. $contact_numbers.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Email ID</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$email_ids.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Years of Association</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$years_of_associations.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Preferred contact time</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';*/

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['reference']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='</tbody>
</table>';
 
$html .='</div>';
$html .='</div>';
 
if (isset($approved_doc[$refer])) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
        if (count($approved_doc[$refer]) > 0 && !in_array('no-file',$approved_doc[$refer])) {
$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[$refer] as $key1 => $value) { 
    // if (is_array($value)) {
    // foreach ($value as $key => $val) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key1 !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
        // }

        // }
    }
}

$html .='</div>';

}
} 
} 

} 

}

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

    foreach ($flat_no as $flat_key => $value) {
        $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
        $color_code = '#1F7705';
        $bgcolor_code = '#1F7705';
        $string_status = 'Verified Clear';
        $status = 'Completed';
        $analyst = isset($analyst_status[$flat_key])?$analyst_status[$flat_key]:0;
        $font_color = '#FFFFFF';
        if ($analyst == '0') { 
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb'; 
            $string_status = 'Verified Pending';
            $status = 'In-Progress';
        } else if ( $analyst == '1') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb'; 
            $string_status = 'Verified Pending';
            $status = 'In-Progress';
        } else if ( $analyst == '2') {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst == '3') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
        } else if ( $analyst == '4') {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst == '5') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
        } else if ($analyst == '6') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
        } else if ($analyst == '7') {
            $check16px = "X";
            $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed';
        } else if ($analyst == '8') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
        } else if ($analyst == '9') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Closed insufficiency';
            $status = 'Completed';  
        } else if ( $analyst == '10') {
            $color_code = 'none';
            $bgcolor_code = 'none';
            $string_status = 'QC-error';
            $status = 'Completed';
        } else {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed'; 
        }

if (!in_array($analyst,[0,1,5])) {
$html .='<br pagebreak="true" />';
   
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';

$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Previous Address '.($flat_key+1).'</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';


$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';
             
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
$period_of_stays = isset($period_of_stay[$flat_key]['verification_remarks'])?$period_of_stay[$flat_key]['verification_remarks']:'-';
$property_types = isset($property_type[$flat_key]['period_of_stay'])?$property_type[$flat_key]['period_of_stay']:'-';
$verifier_names = isset($verifier_name[$flat_key]['verifier_name'])?$verifier_name[$flat_key]['verifier_name']:'-';
$remark_relationships = isset($remark_relationship[$flat_key]['relationship'])?$remark_relationship[$flat_key]['relationship']:'-';
$verification_remark = isset($verification_remarks[$flat_key]['verification_remarks'])?$verification_remarks[$flat_key]['verification_remarks']:'-';

$city_img = $check16px;
if (strtolower($city) != strtolower($remarks_citys)) {
    $city_img = $remarks_citys;
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
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Flat / Door No</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$flat_no.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Street / Road</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$street.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Area</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$area.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">City / Town</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$city.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$city_img.'</td>';
$html .='</tr>';
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Pin Code</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$pin_code.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$pin_code_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">State</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$state.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$state_img.'</td>';
$html .='</tr>';

 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Nearest Landmark</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$nearest_landmark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Duration Of Stay</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$start_end.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Property Type</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$property_types.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Staying with</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$staying_withs.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Period of Stay</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$period_of_stays.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
*/


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Address Remarks</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remarks_addresss.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verifier\'s Name</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verifier_names.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
 

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verifier\'s Relationship</td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$relationship.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$relationship_img.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['previous_address']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='</tbody>';
$html .='</table>';


/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">';
 
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;width:16%;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.$table['previous_address']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';*/
$html .='</div>';
 

if (isset($approved_doc[$key])) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
if (count($approved_doc[$key]) > 0 && !in_array('no-file',$approved_doc[$key])) {
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[$key] as $key1 => $value) {
    // print_r($value);
    // if (is_array($value)) {
         
    // foreach ($value as $key => $val) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key1 !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
        // }
        // }
    }
}

$html .='</div>';

}
}
}
 }

}

/* Directorship Check */



if (isset($table['directorship_check']['directorship_check_id'])) {
    // print_r($table['reference']['verification_remarks']);
    $remark_country = json_decode($table['directorship_check']['remark_country'],true); 
    $verification_remarks = json_decode($table['directorship_check']['verification_remarks'],true);
    $analyst_status = explode(',',$table['directorship_check']['analyst_status']); 
    $approved_doc = json_decode($table['directorship_check']['approved_doc'],true);

    foreach ($remark_country as $crn => $crnum) { 
        $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
        $html .='<br pagebreak="true" />';
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
        } else if ( $analyst == '1') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb'; 
            $string_status = 'Verified Pending';
            $status = 'In-Progress';
        } else if ( $analyst == '2') {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst == '3') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
        } else if ( $analyst == '4') {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst == '5') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
        } else if ($analyst == '6') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
        } else if ($analyst == '7') {
            $check16px = "X";
            $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed'; 
        } else if ($analyst == '8') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
        } else if ($analyst == '9') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Closed insufficiency';
            $status = 'Completed';
        } else if ( $analyst == '10') {
            $color_code = 'none';
            $bgcolor_code = 'none';
            $string_status = 'QC-error';
            $status = 'Completed';
        } else {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed'; 
        }

if (!in_array($analyst,[0,1,5])) {
   
 
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Directorship Check</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';



$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';

$remark_countrys = isset($remark_country[$crn]['country'])?$remark_country[$crn]['country']:''; 
$verification_remark = isset($verification_remarks[$crn]['verification_remarks'])?$verification_remarks[$crn]['verification_remarks']:'';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Country</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_countrys.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['directorship_check']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='</tbody>
</table>';


/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">'; 
 
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;width:16%;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.$table['directorship_check']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';*/
$html .='</div>';
$html .='</div>';
 
if (isset($approved_doc[$crn])) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
if (count($approved_doc[$crn]) > 0 && !in_array('no-file',$approved_doc[$crn])) {
$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[$crn] as $key => $value) {    
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    } 
}

$html .='</div>';
}
}
 
} 

} 

}


/* Global Sanctions/ AML  */
if (isset($table['global_sanctions_aml']['global_sanctions_aml_id'])) {
    // print_r($table['reference']['verification_remarks']);
    $remark_country = json_decode($table['global_sanctions_aml']['remark_country'],true); 
    $verification_remarks = json_decode($table['global_sanctions_aml']['verification_remarks'],true);
    $analyst_status = explode(',',$table['global_sanctions_aml']['analyst_status']);
    $approved_doc = json_decode($table['global_sanctions_aml']['approved_doc'],true);
    foreach ($remark_country as $crn => $crnum) { 
        $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
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
        } else if ( $analyst == '1') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb'; 
            $string_status = 'Verified Pending';
            $status = 'In-Progress';
        } else if ( $analyst == '2') {          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst == '3') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
        } else if ( $analyst == '4') {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst == '5') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
        } else if ($analyst == '6') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
        } else if ($analyst == '7') {
            $check16px = "X";
            $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed';        
        } else if ($analyst == '8') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
        } else if ($analyst == '9') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Closed insufficiency';
            $status = 'Completed';  
        } else if ( $analyst == '10') {
            $color_code = 'none';
            $bgcolor_code = 'none';
            $string_status = 'QC-error';
            $status = 'Completed';          
        } else {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed'; 
        }

if (!in_array($analyst,[0,1,5])) {
  
$html .='<br pagebreak="true" />'; 
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Global Sanctions/ AML</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';



$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';

$remark_countrys = isset($remark_country[$crn]['country'])?$remark_country[$crn]['country']:''; 
$verification_remark = isset($verification_remarks[$crn]['verification_remarks'])?$verification_remarks[$crn]['verification_remarks']:'';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Country</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_countrys.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['global_sanctions_aml']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='</tbody>
</table>';


/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">'; 
 
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;width:16%;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.$table['global_sanctions_aml']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';*/
$html .='</div>';
$html .='</div>';
 
if (isset($approved_doc[$crn])) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
if (count($approved_doc[$crn]) > 0 && !in_array('no-file',$approved_doc[$crn])) {
$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[$crn] as $key => $value) {    
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    } 
}

$html .='</div>';
}
}
 
} 

} 

}

/* Driving License  */
if (isset($table['driving_licence']['licence_id'])) {
    // print_r($table['reference']['verification_remarks']);
    $licence_number = $table['driving_licence']['licence_number']; 
    $analyst_status = $table['driving_licence']['analyst_status']; 
    $verification_remarks = $table['driving_licence']['verification_remarks'];
    $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >'; 
    $color_code = '#1F7705';
    $bgcolor_code = '#1F7705';
    $string_status = 'Verified Clear';
    $status = 'Completed';
    $analyst = isset($analyst_status)?$analyst_status:0;
    $font_color = '#FFFFFF';
    if ($analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ($analyst == '1') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ($analyst == '2') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '3') {    
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb';
        $string_status = 'Insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '5') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Stop Check';
        $status = 'Completed';
    } else if ($analyst == '6') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Unable to Verify';
        $status = 'Completed'; 
    } else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
        $bgcolor_code = '#ec0000';
        $string_status = 'Verified Discrepancy';
        $status = 'Completed';
    } else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Client Clarification';
        $status = 'Completed';  
    } else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '10') {
        $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
    } else {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
   
 $html .='<br pagebreak="true" />';   
 
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Driving License</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';



$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';
  
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">License Number</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$licence_number.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

 
// 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['driving_licence']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='</tbody>
</table>';


/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">'; 
 
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;width:16%;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.$table['driving_licence']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';*/
$html .='</div>';
$html .='</div>';
 

$approved_doc = json_decode($table['driving_licence']['approved_doc'],true);
if (count($approved_doc[0]) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
if (count($approved_doc[0]) > 0 && !in_array('no-file',$approved_doc[0])) {
$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[0] as $key => $value) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    } 
}

$html .='</div>';
}
}
 
 }

} 



/* Credit / Cibil Check */
if (isset($table['credit_cibil']['credit_id'])) {
    // print_r($table['reference']['verification_remarks']);
    $credit_number = json_decode($table['credit_cibil']['credit_number'],true);
    $document_type = json_decode($table['credit_cibil']['document_type'],true); 
    $analyst_status = explode(',',$table['credit_cibil']['analyst_status']); 
    $verification_remarks = json_decode($table['credit_cibil']['verification_remarks'],true);
    $approved_doc = json_decode($table['credit_cibil']['approved_doc'],true);
    foreach ($credit_number as $crn => $crnum) { 
        $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
        $color_code = '#1F7705';
        $bgcolor_code = '#1F7705';
        $string_status = 'Verified Clear';
        $status = 'Completed';
        $analyst = isset($analyst_status[$crn])?$analyst_status[$crn]:0;
        $font_color = '#FFFFFF';
        if ($analyst == '0') { 
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb'; 
            $string_status = 'Verified Pending';
            $status = 'In-Progress';
        } else if ( $analyst == '1') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb'; 
            $string_status = 'Verified Pending';
            $status = 'In-Progress';
        } else if ( $analyst == '2') {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst == '3') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
        } else if ( $analyst == '4') {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst == '5') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
        } else if ($analyst == '6') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
        } else if ($analyst == '7') {
            $check16px = "X";
            $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed';        
        } else if ($analyst == '8') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
        } else if ($analyst == '9') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Closed insufficiency';
            $status = 'Completed';
        } else if ( $analyst == '10') {
            $color_code = 'none';
            $bgcolor_code = 'none';
            $string_status = 'QC-error';
            $status = 'Completed';
        } else {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed'; 
        }

if (!in_array($analyst,[0,1,5])) {

 $html .='<br pagebreak="true" />';  
 
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Credit / Cibil Check</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';



$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';


$verification_remark = isset($verification_remarks[$crn]['verification_remarks'])?$verification_remarks[$crn]['verification_remarks']:'';
$credit_numbers = isset($credit_number[$crn]['credit_cibil_number'])?$credit_number[$crn]['credit_cibil_number']:"";
$document_types = isset($document_type[$crn]['document_type'])?$document_type[$crn]['document_type']:""; 

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Credit Number</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$credit_numbers.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Document Type</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$document_types.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
 

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['credit_cibil']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='</tbody>
</table>';


/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">'; 
 
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;width:16%;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.$table['credit_cibil']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';*/
$html .='</div>';
$html .='</div>';
 
if (isset($approved_doc[$crn])) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
if (count($approved_doc[$crn]) > 0 && !in_array('no-file',$approved_doc[$crn])) {
$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[$crn] as $key1 => $value){
    // print_r($value);
    // if (is_array($value)) {     
    // foreach ($value as $key => $val) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key1 !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
        // }
        // }
    }
}

$html .='</div>';
}
}
 
} 

} 

}

/* Bankruptcy Check  */
if (isset($table['bankruptcy']['bankruptcy_id'])) {
    // print_r($table['reference']['verification_remarks']);
    $bankruptcy_number = json_decode($table['bankruptcy']['bankruptcy_number'],true);
    $document_type = json_decode($table['bankruptcy']['document_type'],true); 
    $analyst_status = explode(',',$table['bankruptcy']['analyst_status']); 
    $verification_remarks = json_decode($table['bankruptcy']['verification_remarks'],true);
    $approved_doc = json_decode($table['bankruptcy']['approved_doc'],true);
    foreach ($bankruptcy_number as $crn => $crnum) { 
        $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >'; 
        $color_code = '#1F7705';
        $bgcolor_code = '#1F7705';
        $string_status = 'Verified Clear';
        $status = 'Completed';
        $analyst = isset($analyst_status[$crn])?$analyst_status[$crn]:0;
        $font_color = '#FFFFFF';
        if ($analyst == '0') { 
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb'; 
            $string_status = 'Verified Pending';
            $status = 'In-Progress';
        } else if ($analyst == '1') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb'; 
            $string_status = 'Verified Pending';
            $status = 'In-Progress';
        } else if ( $analyst == '2') {          
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst == '3') {
            $color_code = '#1bf1fb';
            $bgcolor_code = '#1b8efb';
            $string_status = 'Insufficiency';
            $status = 'Completed';
        } else if ( $analyst == '4') {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed';
        } else if ( $analyst == '5') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Stop Check';
            $status = 'Completed';
        } else if ($analyst == '6') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Unable to Verify';
            $status = 'Completed'; 
        } else if ($analyst == '7') {
            $check16px = "X";
            $color_code = 'red';
            $bgcolor_code = '#ec0000';
            $string_status = 'Verified Discrepancy';
            $status = 'Completed';        
        } else if ($analyst == '8') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Client Clarification';
            $status = 'Completed';  
        } else if ($analyst == '9') {
            $check16px = "NA";
            $color_code = '#FF8C00';
            $bgcolor_code = '#FFD4AE';
            $string_status = 'Closed insufficiency';
            $status = 'Completed';
        } else if ( $analyst == '10') {
            $color_code = 'none';
            $bgcolor_code = 'none';
            $string_status = 'QC-error';
            $status = 'Completed';
        } else {
            $color_code = '#1F7705';
            $bgcolor_code = '#C5FCB4';
            $string_status = 'Verified Clear';
            $status = 'Completed'; 
        } 

if (!in_array($analyst,[0,1,5])) {
      
$html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Bankruptcy</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';



$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';

$verification_remark = isset($verification_remarks[$crn]['verification_remarks'])?$verification_remarks[$crn]['verification_remarks']:'';
$bankruptcy_numbers = isset($bankruptcy_number[$crn]['bankruptcy_number'])?$bankruptcy_number[$crn]['bankruptcy_number']:"";
$document_types = isset($document_type[$crn]['document_type'])?$document_type[$crn]['document_type']:""; 

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Document Number</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$bankruptcy_numbers.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Document Type</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$document_types.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
 

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['bankruptcy']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='</tbody>
</table>';


/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">'; 
 
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;width:16%;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.$table['bankruptcy']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';*/
$html .='</div>';
$html .='</div>';
 


if (isset($approved_doc[$crn])) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
if (count($approved_doc[$crn]) > 0 && !in_array('no-file',$approved_doc[$crn])) {
$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[$crn] as $key1 => $value){
    // print_r($value);
    // if (is_array($value)) {     
    // foreach ($value as $key => $val) {    
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key1 !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
        // }
        // }
    }
}

$html .='</div>';
}
}
 
} 

} 

}


/* Adverse Media/Database Check  */
if (isset($table['adverse_database_media_check']['adverse_database_media_check_id'])) {
    $remark_country = $table['adverse_database_media_check']['remark_country']; 
    $candidate_name = $candidate_details['first_name'].' '.$candidate_details['last_name']; 
    $verification_remarks = json_decode($table['adverse_database_media_check']['verification_remarks'],true);
    $verification_remark = isset($verification_remarks[0]['verification_remarks'])?$verification_remarks[0]['verification_remarks']:'';
    $analyst = isset($analyst_status)?$analyst_status:0;
    $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >';
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
    } else if ( $analyst == '1') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ( $analyst == '2') {    
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '3') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb';
        $string_status = 'Insufficiency';
        $status = 'In-progress';
    } else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '5') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Stop Check';
        $status = 'Completed';
    } else if ($analyst == '6') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Unable to Verify';
        $status = 'Completed'; 
    } else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
        $bgcolor_code = '#ec0000';
        $string_status = 'Verified Discrepancy';
        $status = 'Completed'; 
    } else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Client Clarification';
        $status = 'Completed';  
    } else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '10') {
        $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';
    } else {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
  
$html .='<br pagebreak="true" />'; 

$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Adverse Media/Database Check</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';


$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';

$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';
/* $html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Candidate Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$candidate_final_name.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';*/


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['adverse_database_media_check']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='</tbody>
</table>';
 
$html .='</div>';
$html .='</div>';
 


$approved_doc = json_decode($table['adverse_database_media_check']['approved_doc'],true);
if (count($approved_doc[0]) > 0) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
if (count($approved_doc[0]) > 0 && !in_array('no-file',$approved_doc[0])) {
$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[0] as $key => $value) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    } 
}

$html .='</div>';

}
}
}

} 


/* CV Check  */
if (isset($table['cv_check']['cv_id'])) {
    // print_r($table['reference']['verification_remarks']);
    $contect_number = $table['cv_check']['contect_number'];
    $full_name = $table['cv_check']['full_name'];
    $address = $table['cv_check']['address'];
    $education_detail = $table['cv_check']['education_detail']; 
    $analyst_status =  $table['cv_check']['analyst_status']; 
    $verification_remarks = json_decode($table['cv_check']['verification_remarks'],true);
    $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >'; 
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
    } else if ( $analyst == '1') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ( $analyst == '2') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '3') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb';
        $string_status = 'Insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '5') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Stop Check';
        $status = 'Completed';
    } else if ($analyst == '6') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Unable to Verify';
        $status = 'Completed'; 
    } else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
        $bgcolor_code = '#ec0000';
        $string_status = 'Verified Discrepancy';
        $status = 'Completed';
    } else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Client Clarification';
        $status = 'Completed';  
    } else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '10') {
        $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';
    } else {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
    
$html .='<br pagebreak="true" />'; 
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> CV Check</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';



$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$full_name.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Contact Number</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$contect_number.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Address</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$address.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Education Details</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$education_detail.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';
  $verification_remark = isset($verification_remarks[0]['verification_remarks'])?$verification_remarks[0]['verification_remarks']:'';
// 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['cv_check']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='</tbody>
</table>';


/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">'; 
 
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;width:16%;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.$table['cv_check']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';*/
$html .='</div>';
$html .='</div>';
 

$approved_doc = json_decode($table['cv_check']['approved_doc'],true);
if (count($approved_doc[0]) > 0 && !in_array('no-file',$approved_doc[0])) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */

$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[0] as $key => $value) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    } 
}

$html .='</div>';

}
 
}

} 

 


/* Health Checkup */
if (isset($table['health_checkup']['health_checkup_id'])) {
    $remark_country = json_decode($table['health_checkup']['remark_country'],true); 
    // $candidate_name = $candidate_data[0]['candidaetData']['first_name'].' '.$candidate_data[0]['candidaetData']['last_name']; 
    $verification_remarks = json_decode($table['health_checkup']['verification_remarks'],true);
    $analyst_status = $table['health_checkup']['analyst_status'];

    $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >'; 
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
    } else if ( $analyst == '1') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ( $analyst == '2') {    
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '3') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb';
        $string_status = 'Insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '5') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Stop Check';
        $status = 'Completed';
    } else if ($analyst == '6') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Unable to Verify';
        $status = 'Completed'; 
    } else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
        $bgcolor_code = '#ec0000';
        $string_status = 'Verified Discrepancy';
        $status = 'Completed';
    } else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Client Clarification';
        $status = 'Completed';  
    } else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '10') {
        $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
    } else {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
   
 $html .='<br pagebreak="true" />';
 
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Health Checkup</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';



$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';

$remark_countrys = isset($remark_country[0]['country'])?$remark_country[0]['country']:''; 
$verification_remark = isset($verification_remarks[0]['verification_remarks'])?$verification_remarks[0]['verification_remarks']:'';

/*$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Candidate Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$candidate_final_name.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';*/


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Country</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$remark_countrys.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remark.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['health_checkup']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='</tbody>
</table>';


/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">'; 
 
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;width:16%;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.$table['health_checkup']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';*/
$html .='</div>';
$html .='</div>';
 


$approved_doc = json_decode($table['health_checkup']['approved_doc'],true);
if (count($approved_doc[0]) > 0 && !in_array('no-file',$approved_doc[0])) {
    /*$url = base_url()."../uploads/all-marksheet-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if('jpg' == $ext ||'jpeg' == $ext|| 'png' == $ext){ */
$html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[0] as $key => $value) {    
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    } 
}

$html .='</div>';

}

} 

}

/* Employement Gap check  */
if (isset($table['employment_gap_check']['gap_id'])) {
    $company_list = $table['employment_gap_check']['company_list']; 
    $start_date = $table['employment_gap_check']['start_date']; 
    $end_date = $table['employment_gap_check']['end_date']; 
    $candidate_name = $candidate_data[0]['candidaetData']['first_name'].' '.$candidate_data[0]['candidaetData']['last_name']; 
    $verification_remarks = $table['employment_gap_check']['verification_remarks'];
    $analyst_status = $table['employment_gap_check']['analyst_status'];
 
    $check16px =  '<img width="16px" src="'.base_url().'assets/admin/images/marks/check16px.png" >'; 
    $color_code = '#1F7705';
    $bgcolor_code = '#1F7705';
    $string_status = 'Verified Clear';
    $status = 'Completed';
    $analyst = isset($analyst_status)?$analyst_status:0;
    $font_color = '#FFFFFF';
    if ($analyst == '0') { 
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ( $analyst == '1') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb'; 
        $string_status = 'Verified Pending';
        $status = 'In-Progress';
    } else if ( $analyst == '2') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '3') {
        $color_code = '#1bf1fb';
        $bgcolor_code = '#1b8efb';
        $string_status = 'Insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '4') {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed';
    } else if ( $analyst == '5') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Stop Check';
        $status = 'Completed';
    } else if ($analyst == '6') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Unable to Verify';
        $status = 'Completed'; 
    } else if ($analyst == '7') {
        $check16px = "X";
        $color_code = 'red';
        $bgcolor_code = '#ec0000';
        $string_status = 'Verified Discrepancy';
        $status = 'Completed';
    } else if ($analyst == '8') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Client Clarification';
        $status = 'Completed';  
    } else if ($analyst == '9') {
        $check16px = "NA";
        $color_code = '#FF8C00';
        $bgcolor_code = '#FFD4AE';
        $string_status = 'Closed insufficiency';
        $status = 'Completed';
    } else if ( $analyst == '10') {
        $color_code = 'none';
        $bgcolor_code = 'none';
        $string_status = 'QC-error';
        $status = 'Completed';  
    } else {
        $color_code = '#1F7705';
        $bgcolor_code = '#C5FCB4';
        $string_status = 'Verified Clear';
        $status = 'Completed'; 
    } 

if (!in_array($analyst,[0,1,5])) {
 $html .='<br pagebreak="true" />';
$html .='<div style="padding: 35px 35px 45px 35px;background-color: #e2e5f3;margin-top: 40px; margin-right:80px; margin-left: 80px;line-height:20px; " >';
$html .='<div style="color: #100F0F; font-weight: bold; font-size: 10px;"> Employment Gap Check</div>';

$html .='<table style="margin-top: 25px;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<td style="padding-bottom: 15px; width: 15%; font-size: 10px; color: #100F0F;">Status</td>';
$html .='<td style="padding-bottom: 15px;width:2%;">:</td>';
$html .='<td style="padding-bottom: 15px; font-weight: bold; font-size: 10px; color: #381653;">'.$status.'</td>';
$html .='</tr>';
$html .='</table>';



$html .='<table style="margin-top: 25px; color: #ffffff;
border-collapse: collapse;
width: 100%;">';
$html .='<tr>';
$html .='<th width="35%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal; padding: 12px 0px 12px 25px;">Component Type</th>';
$html .='<th width="30%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Component Detail</th>';
$html .='<th width="10%" style="background-color: #F59E1D;color: #ffffff; text-align: left; font-size: 10px; font-weight: normal;">Result</th>';
$html .='<th width="25%" style="background-color: '.$color_code.';color: '.$font_color.'; text-align: center; font-size: 10px; font-weight: normal;">'.$string_status.'</th>';
$html .='</tr>';
$html .='<tbody style="padding: 10px; margin-top: 10px; background-color: #D2D4D1;">';
 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Candidate Name</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$candidate_name.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Company List</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$company_list.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Start Date</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$start_date.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">End Date</td>';
$html .='<td style="padding-bottom: 5px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$end_date.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

 
$html .='<tr>';
$html .='<td class="border-left-green" style="padding: 10px 0px 10px 40px;color: #381653; margin: 10px 0px 0px 0px; font-weight: bold; font-size: 10px;">Verification Remarks </td>';
$html .='<td style="padding-bottom: 10px 0px;font-weight: bold; font-size: 10px; color: #381653;">'.$verification_remarks.'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px; ">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.get_date($table['employment_gap_check']['updated_date']).'</td>';
$html .='<td></td>';
$html .='<td style="color: '.$color_code.'; padding-bottom: 5px 0px; font-weight: bold;text-align: center; font-size: 10px;" >'.$check16px.'</td>';
$html .='</tr>';

$html .='</tbody>
</table>';


/*$html .='<table style="margin-top: 40px; margin-left: 25px;
border-collapse: collapse;
width: 100%;">'; 
 
$html .='<tr>';
$html .='<td style="padding-bottom:15px;color: #381653; font-weight: bold; font-size: 10px;width:16%;">Verified Date</td>';
$html .='<td style="padding-bottom: 15px; width: 3%;">:</td>';
$html .='<td style="padding-bottom: 15px; color: #381653; font-weight: bold; font-size: 10px;">'.$table['employment_gap_check']['updated_date'].'</td>';
$html .='</tr>';
$html .='</table>';*/
$html .='</div>';
$html .='</div>';
 
 
 
$approved_doc = json_decode($table['employment_gap_check']['approved_doc'],true);
if (count($approved_doc[0]) > 0 && !in_array('no-file',$approved_doc[0])) {
  $html .='<br pagebreak="true" />'; 
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; background-color: #e2e5f3; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> Annexure </h1>';

$max = 0;
foreach ($approved_doc[0] as $key => $value) {
    $url = base_url()."../uploads/remarks-docs/".$value;
    $ext = pathinfo($value, PATHINFO_EXTENSION);
    if(in_array($ext, array('jpg','jpeg','png'))/* && $max < 2*/){
        if ($key !=0) {
            $html .='<br pagebreak="true" />';
        }
        $html .='<table style="margin-top: 25px;
            border-collapse: collapse;
            width: 100%;line-height:20px;">';
        $html .='<tr>'; 
        $html .='<td align="center" style="padding-bottom: 20px; font-size: 18px;width:100%"><img style=" display: block;margin-left: auto;margin-right: auto;border: 1px solid #555;" width="400px" src="'.$url.'"></td>'; 
        $html .='</tr>';
        $html .='</table>'; 
        $max++;
    } 
}

$html .='</div>';

}

} 

}

/*END REPORT*/
// $html .='<br pagebreak="true" />';
$html  .='<div style="padding: 10px 0px 10px 40px; height: auto; margin-top: 40px; margin-right:135px; margin-left: 135px; line-height:30px;" >';
$html .='<h1 style="text-align:center"> END OF THE REPORT </h1>'; 
$html .='</div>';
/**/


$html .='</body>
</html>'; 
// echo $html; 

$pdf->writeHTML($html, true, 0, true, 0);
$pdf->lastPage();
ob_end_clean();
$pdf->Output($file_name_final, 'I');