<?php
use Dompdf\Dompdf;
$pdf = new DOMPDF();

$fs_invoice_logo_path = 'assets/admin/images/FactSuite-logo.png';
$fs_invoice_logo_type = pathinfo($fs_invoice_logo_path, PATHINFO_EXTENSION);
$fs_invoice_logo_data = file_get_contents($fs_invoice_logo_path);
$fs_invoice_logo_base64 = 'data:image/' . $fs_invoice_logo_type . ';base64,' . base64_encode($fs_invoice_logo_data);

$tick_mark_img_path = 'assets/admin/images/marks/check16px.png';
$tick_mark_img_type = pathinfo($tick_mark_img_path, PATHINFO_EXTENSION);
$tick_mark_img_data = file_get_contents($tick_mark_img_path);
$tick_mark_img_base64 = 'data:image/' . $tick_mark_img_type . ';base64,' . base64_encode($tick_mark_img_data);

$sample_attachment_img_path = 'assets/admin/images/marks/sample-pdf-attachment.png';
$sample_attachment_img_type = pathinfo($sample_attachment_img_path, PATHINFO_EXTENSION);
$sample_attachment_img_data = file_get_contents($sample_attachment_img_path);
$sample_attachment_img_base64 = 'data:image/' . $sample_attachment_img_type . ';base64,' . base64_encode($sample_attachment_img_data);


$html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice</title>
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
            margin-bottom: -50px;
            height: 150px;
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
            margin-bottom: 30px;
            padding: 30px 0;
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
            font-size: 40px;
            color: #5A3C81;
            padding: 50px 0;
        }

        .bg-gray {
            // background: #F9F9F9;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            padding: 20px;
        }

        .info-div-txt {
            font-weight: 700; 
            color:#000; background-color:#dddddd; font-size:21px;
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
            width: 80%;
        }

        .report-details-width-2 {
            width: 20%;
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
            background: #D62049;
            border: 1px solid #F8163E;
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
            overflow: auto;
            border-collapse: collapse;
            border: none;
        }

        table,
        table tr,
        table tr th,
        table tr td {
            overflow: auto;
            border-collapse: collapse;
            border: none;
        }

        .table-2 tr th {
            background: #5A3C81;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 15px;
            text-align: left;
            padding: 10px 7px;
            border: 0px;
            content: "\00A0";
        }

        .table-2 tr td {
            padding: 12px 7px;
            border-bottom: 1px solid #F1F3F5;
            color: #11181C;
            border: 0px;
        }

        .no-left-radius {
            border-radius: 5px 0px 0px 5px;
        }

        .no-right-radius {
            border-radius: 0px 5px 5px 0px;
        }

        .all-radius {
            border-radius: 0.000000001px;
        }

        .component-status {
            font-weight: 700;
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
            font-size: 25px;
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

        .d-inline-block {
            display: inline-block;
        }

        .w-50 {
            width: 50%;
        }

        .p-2 {
            padding: 10px;
        }

        .bg-color-4 {
            background: #5A3C81;
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
                <td class="ftr-tbl-txt-1">*Subject to disclaimer</td>
                <td class="ftr-tbl-txt-steps">Step 1/3</td>
            </tr>
        </table>
        <hr>
        <p class="copyright-ftr-txt">www.factsuite.com • Factsuite @ '.date("Y").' All Rights reserved</p>
    </footer>

    <main>
        <div class="container-fluid">
            <table class="table text-center">
                <tr>
                    <td class="verification-report-main-header">Background Verification Report</td>
                </tr>
            </table>
        </div>

        <div class="container-fluid bg-gray">
            <div class="info-div-txt">Bill To</div>
            <table class="table" cellspacing="0">
                <tr>
                    <td class="report-details-td report-details-td-1 report-details-width-1">Case ID</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">07</td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr"></td>
                </tr>
                <tr>
                    <td class="report-details-td report-details-width-1">Requested Date</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">12/09/2022</td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr"></td>
                </tr>
                <tr>
                    <td class="report-details-td report-details-width-1">Completed Date</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">12/09/2022</td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr"></td>
                </tr>
                <tr>
                    <td class="report-details-td report-details-width-1">Date of Joining</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">12/09/2022</td>
                </tr>
            </table>
        </div>

        <div class="container-fluid margin-1 bg-gray">
            <div class="info-div-txt">Personal Details</div>
            <table class="table" cellspacing="0">
                <tr>
                    <td class="report-details-td report-details-td-1 report-details-width-1">Client Name</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">Riyatsa</td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr"></td>
                </tr>
                <tr>
                    <td class="report-details-td report-details-width-1">Candidate Name</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">Ruthwik K</td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr"></td>
                </tr>
                <tr>
                    <td class="report-details-td report-details-width-1">Date of Birth</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">12/09/2004</td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr"></td>
                </tr>
                <tr>
                    <td class="report-details-td report-details-width-1">Employee Id</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">122</td>
                </tr>
                <tr>
                    <td colspan="2"><hr class="hr"></td>
                </tr>
                <tr>
                    <td class="report-details-td report-details-width-1">Father’s Name</td>
                    <td class="report-details-td report-details-td-2 report-details-width-2">Kiran K</td>
                </tr>
            </table>
        </div>

        <div class="page-break"></div>

        <div class="container-fluid">
            <div class="d-inline-block w-50 p-2 bg-color-4">#</div>
            <div class="d-inline-block w-50 p-2 bg-color-4">Particulars</div>
            <div class="d-inline-block w-50 p-2 bg-color-4">Details</div>
            <div class="d-inline-block w-50 p-2 bg-color-4">Result</div>
            <div class="d-inline-block w-50 p-2 bg-color-4">Verified Clear</div>
        </div>

        <div class="container-fluid margin-1 bg-gray">
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
                                    <span class="classification-red margin-right-1">Red</span>
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
                                    <span class="classification-verified-discrepancy margin-right-1">Verified Discrepancy</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">Executive Summary</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Overall status: <span class="report-details-td-2">Completed</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2">
                <tr>
                    <th class="sr-no no-left-radius">#</th>
                    <th class="all-radius" style="width: 30%;">Component Type</th>
                    <th class="all-radius" style="width: 30%;">Status</th>
                    <th class="no-right-radius" style="width: 30%;">Result</th>
                </tr>
                <tr>
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
                </tr>
            </table>
        </div>

        <div class="container-fluid margin-1 bg-gray">
            <table class="table">
                <tr>
                    <td>
                        <span class="report-details-td-3">Criminal History 1</span>
                    </td>
                    <td class="text-right">
                        <span class="report-details-td-4 text-right">Overall status: <span class="report-details-td-2">Completed</span></span>
                    </td>
                </tr>
            </table>
            <table class="table-2">
                <tr>
                    <th class="sr-no">#</th>
                    <th>Particulars</th>
                    <th>Details</th>
                    <th>Result</th>
                    <th>Verified Clear</th>
                </tr>
                <tr>
                    <td class="sr-no">1.</td>
                    <td>Address</td>
                    <td class="font-weight-bold">Kashmir</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="sr-no">2.</td>
                    <td>City</td>
                    <td class="font-weight-bold"></td>
                    <td></td>
                    <td><span class="component-status-result text-green">Adityanagar</span></td>
                </tr>
                <tr>
                    <td class="sr-no">3.</td>
                    <td>State</td>
                    <td class="font-weight-bold">Karnataka</td>
                    <td></td>
                    <td><span class="component-status-result text-green">Karnataka</span></td>
                </tr>
                <tr>
                    <td class="sr-no">4.</td>
                    <td>Pincode</td>
                    <td class="font-weight-bold">562031</td>
                    <td></td>
                    <td><img class="tick-mark-img" src="'.$tick_mark_img_base64.'"></td>
                </tr>
                <tr>
                    <td class="sr-no">5.</td>
                    <td>Verified Date</td>
                    <td class="font-weight-bold">12/09/2022</td>
                    <td></td>
                    <td><img class="tick-mark-img" src="'.$tick_mark_img_base64.'"></td>
                </tr>
                <tr>
                    <td class="sr-no">6.</td>
                    <td>Verification Remarks</td>
                    <td class="font-weight-bold">Calender image uploaded</td>
                    <td></td>
                    <td><img class="tick-mark-img" src="'.$tick_mark_img_base64.'"></td>
                </tr>
                <tr>
                    <td class="sr-no">7.</td>
                    <td>Verification Remarks</td>
                    <td class="font-weight-bold">Friend</td>
                    <td></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;Self</td>
                </tr>
            </table>
        </div>

        <div class="page-break"></div>

        <div class="container-fluid margin-1">
            <div class="info-div-txt">Annexure 1</div>
            <div class="container-fluid bg-gray text-center">
                <img class="component-attachment-img" src="'.$sample_attachment_img_base64.'">
            </div>
        </div>
        <div class="container-fluid margin-1">
            <h1 class="end-of-report-txt">End of Report</h1>
            <p class="disclaimer-txt">
                <span>Disclaimer:</span>QuinPro Info Services Pvt Ltd makes no representation or warranties with respect to the contents of this document. Our reports and comments are confidential in nature and are meant only for the internal use of the client to make an assessment of the background of the applicant. They are not intended for publication or circulation or sharing with any other person including the applicant. Also, they are not to be reproduced or used for any other purpose, in whole or in part, without our prior written consent in each specific instance. We expressly disclaim all responsibility or liability for any costs, damages, losses, liabilities, expenses incurred by anyone as a result of circulation, publication, reproduction or use of our reports contrary to the provisions of this paragraph.
            </p>
        </div>
    </main>
</body>
</html>';
 
$pdf->loadHtml($html,'UTF-8');
$pdf->set_paper('a4', 'portrait');// or landscape
$pdf->render();
$output = $pdf->output();
// $file_name = $generate_pdf_details_variable['invoice_pdf_name'];
// $generated_pdf = file_put_contents('uploads/purchased-package-invoice/'.$file_name, $output);
$pdf->stream("invoice.pdf", array("Attachment" => false));
$pdf->stream("invoice.pdf");
exit(0);
?>