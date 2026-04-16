<?php
require_once 'db.php';

$lr_id = $_POST['lr_id'] ?? '';
$product_name = $_POST['product_name'] ?? '';
$group_name = $_POST['group_name'] ?? '';
$description = $_POST['description'] ?? '';
$qty = $_POST['qty'] ?? '';
$actual_wt = $_POST['actual_wt'] ?? '';
$charge_wt = $_POST['charge_wt'] ?? '';
$unit = $_POST['unit'] ?? '';
$rate = $_POST['rate'] ?? '';
$rate_type = $_POST['rate_type'] ?? '';
$amount = $_POST['amount'] ?? '';
$length = $_POST['length'] ?? '';
$width = $_POST['width'] ?? '';
$height = $_POST['height'] ?? '';

if (!empty($id)) {
    // UPDATE existing product
    $sql = "UPDATE product_details SET 
            lr_id = '$lr_id', 
            product_name = '$product', 
            qty = '$qty',
            actual_wt = '{$_POST['actualWt']}',
            charge_wt = '{$_POST['chargeWt']}',
            amount = '{$_POST['amount']}' 
            WHERE product_id = '$id'";
} else {
    // INSERT new product WITH the lr_id link
    $sql = "INSERT INTO product_details
(lr_id,product_name,group_name,description,qty,actual_wt,charge_wt,unit,rate,rate_type,amount,length,width,height)
VALUES('$lr_id','$product_name','$group_name','$description','$qty','$actual_wt','$charge_wt','$unit','$rate','$rate_type','$amount','$length','$width','$height')";
}
if (mysqli_query($conn, $sql)) {
    // Return the ID so the edit/delete buttons work immediately
    echo !empty($id) ? $id : mysqli_insert_id($conn);
} else {
    echo "Error: " . mysqli_error($conn);
}
?>