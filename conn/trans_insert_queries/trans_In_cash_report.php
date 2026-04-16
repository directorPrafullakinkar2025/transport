<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $transaction_date       = $_POST['transaction_date'] ?? '';
    $product_group_id       = $_POST['product_group_id'] ?? 0;
    $product_id             = $_POST['product_id'] ?? 0;
    $part_no                = $_POST['part_no'] ?? '';
    $quantity               = $_POST['quantity'] ?? 0;
    $rate                   = $_POST['rate'] ?? 0;
    $warranty_expiry_date   = $_POST['warranty_expiry_date'] ?? null;
    $remarks                = $_POST['remarks'] ?? '';
    $status                 = $_POST['status'] ?? 1;

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO transactions (
        transaction_date,
        product_group_id,
        product_id,
        part_no,
        quantity,
        rate,
        warranty_expiry_date,
        remarks,
        status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "siisidsi",
        $transaction_date,
        $product_group_id,
        $product_id,
        $part_no,
        $quantity,
        $rate,
        $warranty_expiry_date,
        $remarks,
        $status
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Transaction saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
?>