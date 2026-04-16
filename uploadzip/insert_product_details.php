<?php

require_once "db.php";

$lr_id = $_POST['lr_id'];

$product_name = $_POST['product_name'];
$description = $_POST['description'];
$qty = $_POST['qty'];
$actual_wt = $_POST['actual_wt'];
$charge_wt = $_POST['charge_wt'];
$unit = $_POST['unit_name'];
$rate = $_POST['rate'];
$rate_type = $_POST['rate_type'];
$amount = $_POST['amount'];
$length = $_POST['length'];
$width = $_POST['width'];
$height = $_POST['height'];

for($i=0; $i<count($product_name); $i++)
{

$sql = "INSERT INTO product_details
(lr_id,product_name,group_name,description,qty,actual_wt,charge_wt,unit,rate,rate_type,amount,length,width,height,created_at)

VALUES
(
'$lr_id',
'".$product_name[$i]."',
'',
'".$description[$i]."',
'".$qty[$i]."',
'".$actual_wt[$i]."',
'".$charge_wt[$i]."',
'".$unit[$i]."',
'".$rate[$i]."',
'".$rate_type[$i]."',
'".$amount[$i]."',
'".$length[$i]."',
'".$width[$i]."',
'".$height[$i]."',
NOW()
)";

mysqli_query($conn,$sql);

}

echo "Product Saved Successfully";

?>