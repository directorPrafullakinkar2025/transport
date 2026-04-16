<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $job_head_name   = $_POST['job_head_name'] ?? '';
    $gst_percent     = $_POST['gst_percent'] ?? 0;
    $hsn_code        = $_POST['hsn_code'] ?? '';
    $show_reminder   = $_POST['show_reminder'] ?? 0;
    $description     = $_POST['description'] ?? '';
    $status          = $_POST['status'] ?? 1;

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO job_heads (
        job_head_name,
        gst_percent,
        hsn_code,
        show_reminder,
        description,
        status
    ) VALUES (
        ?, ?, ?, ?, ?, ?
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "sdsisi",
        $job_head_name,
        $gst_percent,
        $hsn_code,
        $show_reminder,
        $description,
        $status
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Job head saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
