<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $job_head_name = $_POST['job_head_name'] ?? '';
    $head_type     = $_POST['head_type'] ?? 'SALES';
    $status        = $_POST['status'] ?? 1;

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO job_head_master (
        job_head_name,
        head_type,
        status
    ) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "ssi",
        $job_head_name,
        $head_type,
        $status
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Head saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
?>
