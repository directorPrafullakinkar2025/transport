<?php
require_once "db.php";

// Data from the first snippet
$lr_id = $_POST['lr_id'];
$weight = $_POST['weight'];
$rate = $_POST['rate'];
$mill_freight = $_POST['mill_freight'];
$agent = $_POST['agent_commission'];
$gadi = $_POST['gadi_bhada'];
$profit = $_POST['profit'];

// Data from the second snippet
$freight = $_POST['freight'];
$hamali = $_POST['hamali'];
$pre_bhadha = $_POST['pre_bhadha'];
$bilty_charge = $_POST['bilty_charge'];
$collection_charges = $_POST['collection_charges'];
$cpc = $_POST['cpc'];
$other_charge = $_POST['other_charge'];
$total = $_POST['total'];
$apply_gst = $_POST['apply_gst'];
$cgst = $_POST['cgst'];
$sgst = $_POST['sgst'];
$igst = $_POST['igst'];
$advance_amount = $_POST['advance_amount'];
$grand_total = $_POST['grand_total'];
$url_name = $_POST['url_name'];
$print_type = $_POST['print_type'];

// Combined SQL INSERT statement
$sql = "INSERT INTO freight_gst_details 
(lr_id, weight, rate, mill_freight, agent_commission, gadi_bhada, profit, freight, hamali, pre_bhadha, bilty_charge, collection_charges, cpc, other_charge, total, apply_gst, cgst, sgst, igst, advance_amount, grand_total, url_name, print_type, created_at) 
VALUES 
('$lr_id', '$weight', '$rate', '$mill_freight', '$agent', '$gadi', '$profit', '$freight', '$hamali', '$pre_bhadha', '$bilty_charge', '$collection_charges', '$cpc', '$other_charge', '$total', '$apply_gst', '$cgst', '$sgst', '$igst', '$advance_amount', '$grand_total', '$url_name', '$print_type', NOW())";

if(mysqli_query($conn, $sql)){
    echo "<script>
    alert('Transport Calculation & Freight Details Saved Successfully');
    window.location.href='index.php';
    </script>";
} else {
    echo "Error : " . mysqli_error($conn);
}
?>