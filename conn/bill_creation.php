<?php
$sql = "INSERT INTO bills (
    bill_no, bill_date, due_date, party_name, lr_type, remarks, bill_status,
    total_qty, total_actual_weight, total_charge_weight, total_amount,
    hamali, pre_bhada, bilty_charge, collection_charges, door_delivery,
    apply_gst, cgst_percent, cgst_amount, sgst_percent, sgst_amount,
    igst_percent, igst_amount, grand_total, net_total, created_at, updated_at
) VALUES (
    ?,?,?,?,?,?,
    ?,?,?,?,?,?,
    ?,?,?,?,?,?,
    ?,?,?,?,?,?,
    ?,?,NOW(),NOW()
)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssiddiddididididdidd",
    $bill_no,
    $bill_date,
    $due_date,
    $party_name,
    $lr_type,
    $remarks,
    $bill_status,
    $total_qty,
    $total_actual_weight,
    $total_charge_weight,
    $total_amount,
    $hamali,
    $pre_bhada,
    $bilty_charge,
    $collection_charges,
    $door_delivery,
    $apply_gst,
    $cgst_percent,
    $cgst_amount,
    $sgst_percent,
    $sgst_amount,
    $igst_percent,
    $igst_amount,
    $grand_total,
    $net_total
);

$stmt->execute();
?>