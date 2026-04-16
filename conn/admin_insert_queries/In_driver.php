<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $driver_name    = $_POST['driver_name'] ?? '';
    $mobile         = $_POST['mobile'] ?? '';
    $license_no     = $_POST['license_no'] ?? '';

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO drivers (
        driver_name,
        mobile,
        license_no,
        created_at
    ) VALUES (
        ?, ?, ?, NOW()
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "sss",
        $driver_name,
        $mobile,
        $license_no
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Driver saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
