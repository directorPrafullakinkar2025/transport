<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $arrival_no      = $_POST['arrival_no'] ?? '';
    $unloading_date  = $_POST['unloading_date'] ?? date('Y-m-d');
    $challan_id      = $_POST['challan_id'] ?? 0;
    $net_amount      = $_POST['net_amount'] ?? 0;
    $status          = $_POST['status'] ?? 1;   // 1 = Active, 0 = Cancelled

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO unload_entries (
        arrival_no,
        unloading_date,
        challan_id,
        net_amount,
        status
    ) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "ssidi",
        $arrival_no,
        $unloading_date,
        $challan_id,
        $net_amount,
        $status
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Unloading entry saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
?>