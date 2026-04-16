<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $bill_type          = $_POST['bill_type'] ?? '';
    $invoice_no         = $_POST['invoice_no'] ?? '';
    $reference_no       = $_POST['reference_no'] ?? '';
    $invoice_date       = $_POST['invoice_date'] ?? null;

    $invoice_type       = $_POST['invoice_type'] ?? '';
    $supplier_id        = $_POST['supplier_id'] ?? 0;
    $attender_name      = $_POST['attender_name'] ?? '';
    $attender_mobile    = $_POST['attender_mobile'] ?? '';

    $challan_no         = $_POST['challan_no'] ?? '';
    $challan_date       = $_POST['challan_date'] ?? null;
    $vehicle_id         = $_POST['vehicle_id'] ?? 0;
    $job_head_id        = $_POST['job_head_id'] ?? 0;

    $status             = $_POST['status'] ?? 1;

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO invoice_master (
        bill_type,
        invoice_no,
        reference_no,
        invoice_date,
        invoice_type,
        supplier_id,
        attender_name,
        attender_mobile,
        challan_no,
        challan_date,
        vehicle_id,
        job_head_id,
        status,
        created_at
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW()
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "sssssisissiiis",
        $bill_type,
        $invoice_no,
        $reference_no,
        $invoice_date,
        $invoice_type,
        $supplier_id,
        $attender_name,
        $attender_mobile,
        $challan_no,
        $challan_date,
        $vehicle_id,
        $job_head_id,
        $status
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Invoice saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
