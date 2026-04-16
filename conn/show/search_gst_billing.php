<?php        
include '../conn/db.php';

$gst_invoices = [];
$sql = "SELECT * FROM gst_invoices ORDER BY invoice_no";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
$gst_invoices[] = $row['invoice_no'];
    }
}