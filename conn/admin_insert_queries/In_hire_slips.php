<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $slip_no          = $_POST['slip_no'] ?? '';
    $vehicle_no       = $_POST['vehicle_no'] ?? '';
    $load_station     = $_POST['load_station'] ?? '';
    $destination      = $_POST['destination'] ?? '';
    $lr_no            = $_POST['lr_no'] ?? '';
    $lr_date          = $_POST['lr_date'] ?? null;
    $ewb_no           = $_POST['ewb_no'] ?? '';
    $ewb_date         = $_POST['ewb_date'] ?? null;

    $product_name     = $_POST['product_name'] ?? '';
    $qty              = $_POST['qty'] ?? 0;
    $unit             = $_POST['unit'] ?? '';
    $charge_weight    = $_POST['charge_weight'] ?? 0;
    $actual_weight    = $_POST['actual_weight'] ?? 0;
    $rate_pmt         = $_POST['rate_pmt'] ?? 0;

    $freight          = $_POST['freight'] ?? 0;
    $net_amount       = $_POST['net_amount'] ?? 0;

    $party_name       = $_POST['party_name'] ?? '';
    $transporter      = $_POST['transporter'] ?? '';
    $supplier_name    = $_POST['supplier_name'] ?? '';

    $advance_type     = $_POST['advance_type'] ?? '';
    $bank_name        = $_POST['bank_name'] ?? '';
    $diesel_qty       = $_POST['diesel_qty'] ?? 0;
    $diesel_rate      = $_POST['diesel_rate'] ?? 0;
    $advance_amount   = $_POST['advance_amount'] ?? 0;

    $tds_percent      = $_POST['tds_percent'] ?? 0;
    $tds_amount       = $_POST['tds_amount'] ?? 0;
    $commission_percent = $_POST['commission_percent'] ?? 0;
    $commission_amount  = $_POST['commission_amount'] ?? 0;

    $odc_amount       = $_POST['odc_amount'] ?? 0;
    $ld_charge        = $_POST['ld_charge'] ?? 0;
    $shortage_amount  = $_POST['shortage_amount'] ?? 0;

    $fine_slip        = $_POST['fine_slip'] ?? '';
    $remarks          = $_POST['remarks'] ?? '';
    $slip_status      = $_POST['slip_status'] ?? 'Open';

    /* ========= OPTIONAL AUTO CALCULATIONS ========= */
    if ($freight == 0 && $rate_pmt > 0) {
        $freight = $rate_pmt * max($charge_weight, $actual_weight);
    }
    if ($tds_amount == 0 && $tds_percent > 0) {
        $tds_amount = ($freight * $tds_percent) / 100;
    }
    if ($commission_amount == 0 && $commission_percent > 0) {
        $commission_amount = ($freight * $commission_percent) / 100;
    }
    if ($net_amount == 0) {
        $net_amount = $freight
            - $advance_amount
            - $tds_amount
            - $commission_amount
            - $shortage_amount
            - $ld_charge
            - $odc_amount;
    }

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO hire_slips (
        slip_no, vehicle_no, load_station, destination,
        lr_no, lr_date, ewb_no, ewb_date,
        product_name, qty, unit, charge_weight, actual_weight, rate_pmt,
        freight, net_amount,
        party_name, transporter, supplier_name,
        advance_type, bank_name, diesel_qty, diesel_rate, advance_amount,
        tds_percent, tds_amount, commission_percent, commission_amount,
        odc_amount, ld_charge, shortage_amount,
        fine_slip, remarks, slip_status
    ) VALUES (
        ?, ?, ?, ?,
        ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?,
        ?, ?,
        ?, ?, ?,
        ?, ?, ?, ?, ?,
        ?, ?, ?, ?,
        ?, ?, ?,
        ?, ?, ?
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "sssssssssidddd ddssss ssdd dddddd ddds s",
        $slip_no,
        $vehicle_no,
        $load_station,
        $destination,
        $lr_no,
        $lr_date,
        $ewb_no,
        $ewb_date,
        $product_name,
        $qty,
        $unit,
        $charge_weight,
        $actual_weight,
        $rate_pmt,
        $freight,
        $net_amount,
        $party_name,
        $transporter,
        $supplier_name,
        $advance_type,
        $bank_name,
        $diesel_qty,
        $diesel_rate,
        $advance_amount,
        $tds_percent,
        $tds_amount,
        $commission_percent,
        $commission_amount,
        $odc_amount,
        $ld_charge,
        $shortage_amount,
        $fine_slip,
        $remarks,
        $slip_status
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Hire slip saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
?>