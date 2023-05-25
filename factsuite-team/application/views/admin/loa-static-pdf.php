<?php
use Dompdf\Dompdf;
$pdf = new DOMPDF();

$fs_invoice_logo_path = base_url().'assets/admin/images/FactSuite-logo.png';
$fs_invoice_logo_type = pathinfo($fs_invoice_logo_path, PATHINFO_EXTENSION);
$fs_invoice_logo_data = file_get_contents($fs_invoice_logo_path);
$fs_invoice_logo_base64 = 'data:image/' . $fs_invoice_logo_type . ';base64,' . base64_encode($fs_invoice_logo_data);


$candidate_signature_path = base_url().'../uploads/doc_signs/bbc329892ee7307e80772f1be6784bdb.png';
$candidate_signature_type = pathinfo($candidate_signature_path, PATHINFO_EXTENSION);
$candidate_signature_data = file_get_contents($candidate_signature_path);
$candidate_signature_base64 = 'data:image/' . $candidate_signature_type . ';base64,' . base64_encode($candidate_signature_data);

$html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice</title>
    <style type="text/css">
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto";
        }

        .container-fluid {
            width: 100%;
        }

        .w-100 {
            width: 100%;
        }

        .logo-img {
            width: 40%;
            margin-top: 30px
        }

        .border-main-div {
            width: 100%;
        }

        .table {
            width: 100%;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .consent-hdng {
            display: block;
            margin-top: 50px;
            text-decoration: underline;
            font-weight: bold;
            font-size: 20px;
        }

        .consent-para-div {
            width: 100%;
            margin: auto;
            margin-top: 70px;
        }

        .row::after {
            content: "";
            clear: both;
        }

        .w-50 {
            width: 50%;
        }

        .invoice-details {
            width: 100%;
            font-size: 15px;
        }

        .invoice-details tr td {
            padding-left: 5px;
        }

        .table {
            width: 100%;
        }

        .date-place-signature {
            margin-top: 100px;
        }

        .place-class {
            margin-top: 15px;
        }

        .text-right {
            text-align: right;
        }

        .candidate-signature-img {
            width: 100%;
        }

        

        .fs-invoice-logo-td img {
            width: 100%;
        }

        .row::after {
            content: "";
            clear: both;
        }

        .w-50 {
            width: 50%;
            float: left;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .border-right {
            border-right: 1px solid #000000;
        }

        .invoice-details {
            width: 100%;
            font-size: 15px;
        }

        .pt-0 {
            padding-top: 0px;
        }

        .pb-0 {
            padding-bottom: 0px;
        }

        .bill-to-hdr {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
            background: #cbcbcb;
        }

        .bill-to-txt {
            padding-left: 5px;
            font-weight: bold;  
            color: #272727;
            font-size: 15px;
        }

        .client-address-div {
            width: 100%;
            padding: 10px 0 15px 5px;
        }

        .client-hdr-comp-name {
            font-weight: bold;
            font-size: 15px;
        }

        .client-hdr-comp-address {
            font-size: 15px;
            width: 40%;
        }

        .invoice-details tr td {
            padding-left: 5px;
        }

        .purchased-package-service-details-div {
            margin-top: 15px;
            padding-left: 5px;
        }

        .purchased-package-service-name {
            font-weight: bold;
            margin-top: 15px;
        }

        .purchased-package-components-table {
            width: 98.5%;
            border-collapse: collapse;
        }

        .purchased-package-components-table,
        .purchased-package-components-table td,
        .purchased-package-components-table th {
            border: 1px solid;
        }

        .purchased-package-components-table thead th {
            text-align: left;
        }

        .total-amt-in-words-div {
            margin-top: 20px;
            padding-left: 5px;
            font-size: 15px;
        }

        .total-amt-in-words {
            font-weight: bold;
            font-style: italic;
        }

        .declaration-div {
            width: 92%;
            margin: auto;
            border: 1px solid #000000;
            padding-left: 5px;
            font-size: 15px;
            padding: 7px 5px;
        }

        .show-total-sub-total-and-grand-total-table tr {
            width: 98.5%;
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
        }

        .text-right {
            text-align: right
        }

        .grand-total-div {
            font-size: 17px;
        }

        .no-spacing-table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        .text-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="border-main-div">
        <div class="container-fluid text-center">
            <img class="logo-img" src="'.$fs_invoice_logo_base64.'">
        </div>
        <div class="border-top"></div>
        <div class="container-fluid text-center">
            <span class="consent-hdng">Employment Screening Consent</span>
        </div>
        <div class="container-fluid consent-para-div">
            <p>
               I,"Full Candidate Name Here", hereby authorize,"Client Name Here" and/or its agents (<span class="text-bold">FactSuite</span>) to make an independent investigation of my background, references, past employment, education, credit history, criminal or police records, and motor vehicle records including those maintained by both public and private organizations and all public records for the purpose of confirming the information contained on my Application and/or obtaining other information which may be material to my qualifications for service now and, if applicable, during the tenure of my employment or service with "Client Name Here"
            </p>
            <p>
                I release "Client Name Here" and its agents and any person or entity, which provides information pursuant to this authorization, from any and all liabilities, claims or law suits in regard to the information obtained from any and all of the above referenced sources used. The following is my true and complete legal name and all information is true and correct to the best of my knowledge.
            </p>
        </div>

        <div class="container-fluid row date-place-signature">
            <div class="w-50">
                <div>
                    Date: 09-06-2022
                </div>
                <div class="place-class">
                    Place: Bengaluru
                </div>
            </div>
            <div class="w-50">
                <div>Signature of Candidate</div>
                <img class="candidate-signature-img" src="'.$candidate_signature_base64.'">
            </div>
        </div>
    </div>
</body>
</html>';
 
$pdf->loadHtml($html,'UTF-8');
$pdf->set_paper('a4', 'portrait');// or landscape
$pdf->render();
$output = $pdf->output();
$file_name = 'candidate-loa.pdf';
$pdf->stream("candidate-loa.pdf", array("Attachment" => false));
// file_put_contents(base_url().'../uploads/candidate-loa/'.$file_name, $output);
// $pdf->stream("candidate-loa.pdf");
exit(0);
?>