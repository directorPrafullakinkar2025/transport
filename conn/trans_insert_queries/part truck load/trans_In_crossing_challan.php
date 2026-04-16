<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $doc_no             = $_POST['doc_no'] ?? '';
    $document_id        = $_POST['document_id'] ?? 0;
    $company_name       = $_POST['company_name'] ?? '';
    $reg_status         = $_POST['reg_status'] ?? '';
    $remarks            = $_POST['remarks'] ?? '';

    $entry_date         = $_POST['entry_date'] ?? null;
    $vehicle_id         = $_POST['vehicle_id'] ?? 0;
    $effective_date     = $_POST['effective_date'] ?? null;
    $expiry_date        = $_POST['expiry_date'] ?? null;

    $status             = $_POST['status'] ?? 1;

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO vehicle_documents (
        doc_no,
        document_id,
        company_name,
        reg_status,
        remarks,
        entry_date,
        vehicle_id,
        effective_date,
        expiry_date,
        status,
        created_at
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW()
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "sissssissi",
        $doc_no,
        $document_id,
        $company_name,
        $reg_status,
        $remarks,
        $entry_date,
        $vehicle_id,
        $effective_date,
        $expiry_date,
        $status
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Vehicle document saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
