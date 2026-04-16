<?php

require_once "db.php";

$lr = $_POST['lr_id'];

/* DELETE FROM ALL TABLES */

mysqli_query($conn,"DELETE FROM lr_entry WHERE lr_id='$lr'");
mysqli_query($conn,"DELETE FROM product_details WHERE lr_id='$lr'");
mysqli_query($conn,"DELETE FROM party_invoice_details WHERE lr_id='$lr'");
mysqli_query($conn,"DELETE FROM freight_gst_details WHERE lr_id='$lr'");

echo "success";