<!-- 
include 'db.php';

$lr_no = $_POST['lr_no'];
$lr_date = $_POST['lr_date'];
$consignor = $_POST['consignor'];
$consignee = $_POST['consignee'];
$source_address = $_POST['source_address'];
$destination_address = $_POST['destination_address'];
$vehicle_no = $_POST['vehicle_no'];
$owner_name = $_POST['owner_name'];
$invoice_no = $_POST['invoice_no'];
$invoice_date = $_POST['invoice_date'];
$value_of_goods = $_POST['value_of_goods'];
$eway_bill_no = $_POST['eway_bill_no'];
$product_name = $_POST['product_name'];
$qty = $_POST['qty'];
$actual_weight = $_POST['actual_weight'];
$charge_weight = $_POST['charge_weight'];
$rate = $_POST['rate'];
$freight = $_POST['freight'];
$hamali = $_POST['hamali'];
$other_charge = $_POST['other_charge'];

$total = $freight + $hamali + $other_charge;

$sql = "INSERT INTO lr_booking 
(lr_no, lr_date, consignor, consignee, source_address, destination_address,
vehicle_no, owner_name, invoice_no, invoice_date, value_of_goods, eway_bill_no,
product_name, qty, actual_weight, charge_weight, rate, freight, hamali, other_charge, total)
VALUES 
('$lr_no','$lr_date','$consignor','$consignee','$source_address','$destination_address',
'$vehicle_no','$owner_name','$invoice_no','$invoice_date','$value_of_goods','$eway_bill_no',
'$product_name','$qty','$actual_weight','$charge_weight','$rate','$freight','$hamali','$other_charge','$total')";

if ($conn->query($sql) === TRUE) {
    echo "LR Saved Successfully!<br>";
    echo "<a href='print.php?id=".$conn->insert_id."' target='_blank'>Print LR</a>";
} else {
    echo "Error: " . $conn->error;
} -->


<?php
require_once 'db.php';

if(isset($_POST['save'])){

/* ---------------- LR ENTRY SAVE ---------------- */

$lr_no = $_POST['lr_no'];
$lr_date = date("Y-m-d", strtotime($_POST['lr_date']));
$from_location = $_POST['from_location'];
$to_location = $_POST['to_location'];

mysqli_query($pdo,"INSERT INTO lr_entry 
(lr_no, lr_date, from_location, to_location) 
VALUES 
('$lr_no','$lr_date','$from_location','$to_location')");

$lr_id = mysqli_insert_id($pdo);


/* ---------------- INVOICE DETAILS SAVE ---------------- */

if(!empty($_POST['invoice_no'])){

foreach($_POST['invoice_no'] as $key => $value){

$invoice_no = $_POST['invoice_no'][$key];
$invoice_date = $_POST['invoice_date'][$key];
$value_goods = $_POST['value_of_goods'][$key];
$eway_bill = $_POST['eway_bill_no'][$key];
$eway_exp = $_POST['eway_exp_date'][$key];

mysqli_query($pdo,"INSERT INTO party_invoice_details
(lr_id,invoice_no,invoice_date,value_of_goods,eway_bill_no,ewb_exp_date)
VALUES
('$lr_id','$invoice_no','$invoice_date','$value_goods','$eway_bill','$eway_exp')");

}

}


/* ---------------- PRODUCT DETAILS SAVE ---------------- */

if(!empty($_POST['product_name'])){

foreach($_POST['product_name'] as $key => $value){

$product = $_POST['product_name'][$key];
$desc = $_POST['description'][$key];
$qty = $_POST['qty'][$key];
$actual = $_POST['actual_wt'][$key];
$charge = $_POST['charge_wt'][$key];
$unit = $_POST['unit'][$key];
$rate = $_POST['rate'][$key];
$rate_type = $_POST['rate_type'][$key];
$amount = $_POST['amount'][$key];

mysqli_query($pdo,"INSERT INTO product_details
(lr_id,product_name,description,qty,actual_wt,charge_wt,unit,rate,rate_type,amount)
VALUES
('$lr_id','$product','$desc','$qty','$actual','$charge','$unit','$rate','$rate_type','$amount')");

}

}

echo "LR Saved Successfully";

}
?>