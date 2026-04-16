<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $type               = $_POST['type'] ?? '';
    $gp_no              = $_POST['gp_no'] ?? '';
    $gp_date            = $_POST['gp_date'] ?? null;
    $party_name         = $_POST['party_name'] ?? '';
    $vehicle_no         = $_POST['vehicle_no'] ?? '';

    $lr_no              = $_POST['lr_no'] ?? '';
    $gr_no              = $_POST['gr_no'] ?? '';

    $freight            = $_POST['freight'] ?? 0;
    $total_qty          = $_POST['total_qty'] ?? 0;
    $total_weight       = $_POST['total_weight'] ?? 0;
    $total_amount       = $_POST['total_amount'] ?? 0;

    $eway_bill_no       = $_POST['eway_bill_no'] ?? '';
    $delivery_staff     = $_POST['delivery_staff'] ?? '';
    $delivery_through   = $_POST['delivery_through'] ?? '';
    $pay_type           = $_POST['pay_type'] ?? '';

    $delivery_charges   = $_POST['delivery_charges'] ?? 0;
    $gatepass_charge    = $_POST['gatepass_charge'] ?? 0;
    $labour_charges     = $_POST['labour_charges'] ?? 0;
    $aoc                = $_POST['aoc'] ?? 0;
    $damage             = $_POST['damage'] ?? 0;

    $remarks            = $_POST['remarks'] ?? '';
    $status             = $_POST['status'] ?? 1;

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO gatepass (
        type,
        gp_no,
        gp_date,
        party_name,
        vehicle_no,
        lr_no,
        gr_no,
        freight,
        total_qty,
        total_weight,
        total_amount,
        eway_bill_no,
        delivery_staff,
        delivery_through,
        pay_type,
        delivery_charges,
        gatepass_charge,
        labour_charges,
        aoc,
        damage,
        remarks,
        status,
        created_at,
        updated_at
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?, NOW(), NOW()
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "sssssssddddssssddddssi",
        $type,
        $gp_no,
        $gp_date,
        $party_name,
        $vehicle_no,
        $lr_no,
        $gr_no,
        $freight,
        $total_qty,
        $total_weight,
        $total_amount,
        $eway_bill_no,
        $delivery_staff,
        $delivery_through,
        $pay_type,
        $delivery_charges,
        $gatepass_charge,
        $labour_charges,
        $aoc,
        $damage,
        $remarks,
        $status
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Gatepass saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
