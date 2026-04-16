<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $challan_no         = $_POST['challan_no'] ?? '';
    $challan_date       = $_POST['challan_date'] ?? null;
    $transporter        = $_POST['transporter'] ?? '';
    $vehicle_no         = $_POST['vehicle_no'] ?? '';
    $driver_name        = $_POST['driver_name'] ?? '';

    $lr_no              = $_POST['lr_no'] ?? '';
    $gr_no              = $_POST['gr_no'] ?? '';
    $consignee          = $_POST['consignee'] ?? '';
    $source             = $_POST['source'] ?? '';
    $address_to         = $_POST['address_to'] ?? '';

    $license_no         = $_POST['license_no'] ?? '';
    $eway_bill_no       = $_POST['eway_bill_no'] ?? '';

    $freight            = $_POST['freight'] ?? 0;
    $pay_type           = $_POST['pay_type'] ?? '';

    $part_a_amount      = $_POST['part_a_amount'] ?? 0;
    $crossing_amount    = $_POST['crossing_amount'] ?? 0;
    $dc_percent         = $_POST['dc_percent'] ?? 0;
    $dc_amount          = $_POST['dc_amount'] ?? 0;

    $to_pay_amount      = $_POST['to_pay_amount'] ?? 0;
    $paid_amount        = $_POST['paid_amount'] ?? 0;
    $tbb_amount         = $_POST['tbb_amount'] ?? 0;
    $balance_amount     = $_POST['balance_amount'] ?? 0;

    $type               = $_POST['type'] ?? '';
    $status             = $_POST['status'] ?? 1;

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO challan (
        challan_no,
        challan_date,
        transporter,
        vehicle_no,
        driver_name,
        lr_no,
        gr_no,
        consignee,
        source,
        address_to,
        license_no,
        eway_bill_no,
        freight,
        pay_type,
        part_a_amount,
        crossing_amount,
        dc_percent,
        dc_amount,
        to_pay_amount,
        paid_amount,
        tbb_amount,
        balance_amount,
        type,
        status,
        created_at,
        updated_at
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW()
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "ssssssssssssdsddddddddssi",
        $challan_no,
        $challan_date,
        $transporter,
        $vehicle_no,
        $driver_name,
        $lr_no,
        $gr_no,
        $consignee,
        $source,
        $address_to,
        $license_no,
        $eway_bill_no,
        $freight,
        $pay_type,
        $part_a_amount,
        $crossing_amount,
        $dc_percent,
        $dc_amount,
        $to_pay_amount,
        $paid_amount,
        $tbb_amount,
        $balance_amount,
        $type,
        $status
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Challan saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();

