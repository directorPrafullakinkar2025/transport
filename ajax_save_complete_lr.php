<?php

require_once "db.php";
$firm_id = $_POST['firm_id'] ?? '';
$lr_id = $_POST['lr_id'];

parse_str($_POST['mainData'], $main);
parse_str($_POST['freightData'], $freight);

$products = json_decode($_POST['products'], true);
$invoices = json_decode($_POST['invoices'], true);


/* ================= SAVE LR ENTRY ================= */

mysqli_query($conn,"INSERT INTO lr_entry(
lr_id,
lr_date,
ref_lr_no,
pm,
from_city,
to_city,
consignor,
consignee,
cnsnr_address,
cnsgne_address,
cnsnr_gstin,
cnsgne_gstin,
billing_branch,
billed_to,
vehicle_no,
owner_name,
transport_mode,
transport_remark,
remarks,
delivery_at,
company_name,
policy_no,
insurance_amount,
lot_no,
pr_no,
pm_no,
agent_name,
bill_to,
account_type
) VALUES(
'$lr_id',
'".$main['lr_date']."',
'".$main['ref_lr_no']."',
'".$main['pm']."',
'".$main['from_city']."',
'".$main['to_city']."',
'".$main['consignor']."',
'".$main['consignee']."',
'".$main['cnsnr_address']."',
'".$main['cnsgne_address']."',
'".$main['cnsnr_gstin']."',
'".$main['cnsgne_gstin']."',
'".$main['billing_branch']."',
'".$main['billed_to']."',
'".$main['vehicle_no']."',
'".$main['owner_name']."',
'".$main['transport_mode']."',
'".$main['transport_remark']."',
'".$main['remarks']."',
'".$main['delivery_at']."',
'".$main['company_name']."',
'".$main['policy_no']."',
'".$main['insurance_amount']."',
'".$main['lot_no']."',
'".$main['pr_no']."',
'".$main['pm_no']."',
'".$main['agent_name']."',
'".$main['bill_to']."',
'".$main['account_type']."'
)");


/* ================= SAVE FREIGHT ================= */

mysqli_query($conn,"INSERT INTO freight_gst_details(
lr_id,
freight,
hamali,
pre_bhadha,
bilty_charge,
collection_charges,
cpc,
other_charge,
total
) VALUES(
'$lr_id',
'".$freight['freight']."',
'".$freight['hamali']."',
'".$freight['pre_bhadha']."',
'".$freight['bilty_charge']."',
'".$freight['collection_charges']."',
'".$freight['cpc']."',
'".$freight['other_charge']."',
'".$freight['total']."'
)");



/* ================= SAVE PRODUCTS ================= */

if(!empty($products)){

foreach($products as $p){

mysqli_query($conn,"INSERT INTO product_details(
lr_id,
product_name,
qty,
actual_wt,
charge_wt,
unit,
rate,
amount,
length,
width,
height
) VALUES(
'$lr_id',
'".$p['product_name']."',
'".$p['qty']."',
'".$p['actual_wt']."',
'".$p['charge_wt']."',
'".$p['unit']."',
'".$p['rate']."',
'".$p['amount']."',
'".$p['length']."',
'".$p['width']."',
'".$p['height']."'
)");

}

}



/* ================= SAVE INVOICES ================= */

if(!empty($invoices)){

foreach($invoices as $inv){

mysqli_query($conn,"INSERT INTO invoice_details(
lr_id,
invoice_no,
invoice_date,
value_of_goods,
eway_bill_no,
ewb_exp_date
) VALUES(
'$lr_id',
'".$inv['invoice_no']."',
'".$inv['invoice_date']."',
'".$inv['value_of_goods']."',
'".$inv['eway_bill_no']."',
'".$inv['ewb_exp_date']."'
)");

}

}

echo "success";

?>