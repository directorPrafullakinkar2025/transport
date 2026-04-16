<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/fpdf.php';

session_start();

$lr_id = $_SESSION['print_lr_id'] ?? null;
if (!$lr_id) die("No LR selected");

/* ================= DATA ================= */
$sql = "SELECT 
l.*, 
fc.city_name AS from_city, tc.city_name AS to_city,
p1.party_name AS consignor_name, p1.address_one AS consignor_addr,
p2.party_name AS consignee_name, p2.address_one AS consignee_addr,
v.vehicle_number,
f.*
FROM lr_entry l
LEFT JOIN city_master fc ON l.from_city = fc.city_id
LEFT JOIN city_master tc ON l.to_city = tc.city_id
LEFT JOIN party_master p1 ON l.consignor = p1.party_id
LEFT JOIN party_master p2 ON l.consignee = p2.party_id
LEFT JOIN vehicle_master v ON l.vehicle_no = v.vehicle_id
LEFT JOIN freight_gst_details f ON l.lr_id = f.lr_id
WHERE l.lr_id='$lr_id'";

$res = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($res);

/* PRODUCTS */
$products = [];
$res2 = mysqli_query($conn,"SELECT * FROM product_details WHERE lr_id='$lr_id'");
while($r = mysqli_fetch_assoc($res2)) $products[] = $r;

/* ================= PDF ================= */
$pdf = new FPDF();
$pdf->SetAutoPageBreak(false);

/* 4 Copies */
$copies = ["CONSIGNEE COPY","CONSIGNOR COPY","DRIVER COPY","OFFICE COPY"];

foreach($copies as $copy){

    $pdf->AddPage();

    /* BORDER */
    $pdf->Rect(5,5,200,287);

    /* HEADER */
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,10,"CONSIGNMENT NOTE",0,1,'C');

    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,5,$copy,0,1,'R');

    /* BASIC INFO */
    $pdf->SetFont('Arial','',9);

    $pdf->SetXY(10,30);
    $pdf->Cell(80,5,"LR No: ".$data['lr_id']);

    $pdf->SetXY(120,30);
    $pdf->Cell(80,5,"Date: ".date('d-m-Y',strtotime($data['lr_date'])));

    $pdf->SetXY(10,40);
    $pdf->Cell(80,5,"From: ".$data['from_city']);

    $pdf->SetXY(120,40);
    $pdf->Cell(80,5,"To: ".$data['to_city']);

    $pdf->SetXY(10,50);
    $pdf->Cell(80,5,"Vehicle: ".$data['vehicle_number']);

    /* CONSIGNOR */
    $pdf->SetXY(10,60);
    $pdf->MultiCell(90,5,"Consignor:\n".$data['consignor_name']."\n".$data['consignor_addr']);

    /* CONSIGNEE */
    $pdf->SetXY(110,60);
    $pdf->MultiCell(90,5,"Consignee:\n".$data['consignee_name']."\n".$data['consignee_addr']);

    /* TABLE HEADER */
    $pdf->SetXY(10,100);
    $pdf->SetFont('Arial','B',9);

    $pdf->Cell(25,7,"CHG WT",1);
    $pdf->Cell(20,7,"PKG",1);
    $pdf->Cell(60,7,"DESCRIPTION",1);
    $pdf->Cell(25,7,"ACT WT",1);
    $pdf->Cell(30,7,"FREIGHT",1);

    /* TABLE DATA */
    $pdf->SetFont('Arial','',9);
    $y = 107;

    foreach($products as $p){

        $pdf->SetXY(10,$y);
        $pdf->Cell(25,6,$p['charge_wt'],1);

        $pdf->Cell(20,6,$p['qty'],1);

        $pdf->Cell(60,6,$p['product_name'],1);

        $pdf->Cell(25,6,$p['actual_wt'],1);

        $pdf->Cell(30,6,$data['freight'],1);

        $y += 6;
    }

    /* CHARGES */
    $pdf->SetXY(10,200);

    $pdf->Cell(50,6,"Freight: ".$data['freight'],1);
    $pdf->Cell(50,6,"Hamali: ".$data['hamali'],1);

    $pdf->Ln();

    $pdf->Cell(50,6,"Bilty: ".$data['bilty_charge'],1);
    $pdf->Cell(50,6,"Other: ".$data['other_charge'],1);

    $pdf->Ln();

    $pdf->Cell(100,8,"Grand Total: ".$data['grand_total'],1);

    /* FOOTER */
    $pdf->SetXY(10,250);
    $pdf->SetFont('Arial','',8);
    $pdf->MultiCell(0,4,"The consignment will be delivered only to consignee bank. No responsibility for leakage & breakage.");

    $pdf->SetXY(10,270);
    $pdf->Cell(80,5,"Signature");

    $pdf->SetXY(140,270);
    $pdf->Cell(50,5,"Seal");
}

/* OUTPUT */
$pdf->Output('I','LR_'.$lr_id.'.pdf');