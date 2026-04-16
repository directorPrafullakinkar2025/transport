<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $unit_name  = $_POST['unit_name'] ?? '';
    $unit_value = $_POST['unit_value'] ?? '';
    $status     = $_POST['status'] ?? 1;   // 1 = Active, 0 = Inactive

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO units (
        unit_name,
        unit_value,
        status
    ) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "ssi",
        $unit_name,
        $unit_value,
        $status
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Unit saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
?>