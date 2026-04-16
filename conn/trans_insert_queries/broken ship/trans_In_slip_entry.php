<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $lr_no                  = $_POST['lr_no'] ?? '';
    $lr_date                = $_POST['lr_date'] ?? null;
    $ref_lr_no              = $_POST['ref_lr_no'] ?? '';
    $pm                     = $_POST['pm'] ?? '';
    $source                 = $_POST['source'] ?? '';
    $destination            = $_POST['destination'] ?? '';

    $consignor_id           = $_POST['consignor_id'] ?? 0;
    $consignee_id           = $_POST['consignee_id'] ?? 0;
    $consignor_address      = $_POST['consignor_address'] ?? '';
    $consignee_address      = $_POST['consignee_address'] ?? '';

    $consignor_gstin        = $_POST['consignor_gstin'] ?? '';
    $consignee_gstin        = $_POST['consignee_gstin'] ?? '';

    $billing_branch         = $_POST['billing_branch'] ?? '';
    $billed_to              = $_POST['billed_to'] ?? '';

    $vehicle_no             = $_POST['vehicle_no'] ?? '';
    $owner_name             = $_POST['owner_name'] ?? '';
    $transport_mode         = $_POST['transport_mode'] ?? '';
    $transport_remark       = $_POST['transport_remark'] ?? '';
    $remarks                = $_POST['remarks'] ?? '';

    $delivery_at            = $_POST['delivery_at'] ?? '';
    $company_name           = $_POST['company_name'] ?? '';
    $policy_no              = $_POST['policy_no'] ?? '';

    $party_invoice_no       = $_POST['party_invoice_no'] ?? '';
    $party_invoice_date     = $_POST['party_invoice_date'] ?? null;

    $value_of_goods         = $_POST['value_of_goods'] ?? 0;
    $eway_bill_no           = $_POST['eway_bill_no'] ?? '';
    $ewb_expiry_date        = $_POST['ewb_expiry_date'] ?? null;

    $lr_type                = $_POST['lr_type'] ?? '';
    $print_freight          = $_POST['print_freight'] ?? 0;

    $freight                = $_POST['freight'] ?? 0;
    $hamali                 = $_POST['hamali'] ?? 0;
    $pre_bhada              = $_POST['pre_bhada'] ?? 0;
    $bilty_charge           = $_POST['bilty_charge'] ?? 0;
    $collection_charges     = $_POST['collection_charges'] ?? 0;
    $cpc                    = $_POST['cpc'] ?? 0;
    $other_charge           = $_POST['other_charge'] ?? 0;

    $total_amount           = $_POST['total_amount'] ?? 0;
    $apply_gst              = $_POST['apply_gst'] ?? 0;
    $cgst_amount            = $_POST['cgst_amount'] ?? 0;
    $sgst_amount            = $_POST['sgst_amount'] ?? 0;
    $igst_amount            = $_POST['igst_amount'] ?? 0;

    $advance_amount         = $_POST['advance_amount'] ?? 0;
    $grand_total            = $_POST['grand_total'] ?? 0;

    $url_name               = $_POST['url_name'] ?? '';
    $print_type             = $_POST['print_type'] ?? '';

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO lr (
        lr_no, lr_date, ref_lr_no, pm, source, destination,
        consignor_id, consignee_id, consignor_address, consignee_address,
        consignor_gstin, consignee_gstin, billing_branch, billed_to,
        vehicle_no, owner_name, transport_mode, transport_remark, remarks,
        delivery_at, company_name, policy_no, party_invoice_no, party_invoice_date,
        value_of_goods, eway_bill_no, ewb_expiry_date, lr_type, print_freight,
        freight, hamali, pre_bhada, bilty_charge, collection_charges, cpc,
        other_charge, total_amount, apply_gst, cgst_amount, sgst_amount,
        igst_amount, advance_amount, grand_total, url_name, print_type, created_at
    ) VALUES (
        ?,?,?,?,?,?,
        ?,?,?,?,?,?,
        ?,?,?,?,?,?,
        ?,?,?,?,?,?,
        ?,?,?,?,?,?,
        ?,?,?,?,?,?,
        ?,?,?,?,?,?,
        ?,?,NOW()
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "ssssssiidsssssissssssssssdsdssdssddddddds",
        $lr_no,
        $lr_date,
        $ref_lr_no,
        $pm,
        $source,
        $destination,
        $consignor_id,
        $consignee_id,
        $consignor_address,
        $consignee_address,
        $consignor_gstin,
        $consignee_gstin,
        $billing_branch,
        $billed_to,
        $vehicle_no,
        $owner_name,
        $transport_mode,
        $transport_remark,
        $remarks,
        $delivery_at,
        $company_name,
        $policy_no,
        $party_invoice_no,
        $party_invoice_date,
        $value_of_goods,
        $eway_bill_no,
        $ewb_expiry_date,
        $lr_type,
        $print_freight,
        $freight,
        $hamali,
        $pre_bhada,
        $bilty_charge,
        $collection_charges,
        $cpc,
        $other_charge,
        $total_amount,
        $apply_gst,
        $cgst_amount,
        $sgst_amount,
        $igst_amount,
        $advance_amount,
        $grand_total,
        $url_name,
        $print_type
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>LR saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
