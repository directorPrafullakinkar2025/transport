<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $job_date              = $_POST['job_date'] ?? '';
    $vehicle_id            = $_POST['vehicle_id'] ?? 0;
    $job_completion_date   = $_POST['job_completion_date'] ?? null;
    $garage_name           = $_POST['garage_name'] ?? '';
    $job_description       = $_POST['job_description'] ?? '';
    $job_status            = $_POST['job_status'] ?? '';
    $remarks               = $_POST['remarks'] ?? '';
    $status                = $_POST['status'] ?? 1;

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO job_information (
        job_date,
        vehicle_id,
        job_completion_date,
        garage_name,
        job_description,
        job_status,
        remarks,
        status
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "sisssssi",
        $job_date,
        $vehicle_id,
        $job_completion_date,
        $garage_name,
        $job_description,
        $job_status,
        $remarks,
        $status
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Job saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();

