<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $voucher_no     = $_POST['voucher_no'] ?? '';
    $voucher_type   = $_POST['voucher_type'] ?? '';     // Payment / Receipt / Journal
    $party_id       = $_POST['party_id'] ?? 0;
    $amount         = $_POST['amount'] ?? 0;
    $tds            = $_POST['tds'] ?? 0;
    $net_amount     = $_POST['net_amount'] ?? 0;
    $payment_mode   = $_POST['payment_mode'] ?? '';     // Cash / Bank / UPI
    $cheque_no      = $_POST['cheque_no'] ?? null;
    $voucher_date   = $_POST['voucher_date'] ?? date('Y-m-d');

    /* ========= AUTO CALCULATION (OPTIONAL) ========= */
    if ($net_amount == 0) {
        $net_amount = $amount - $tds;
    }

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO vouchers (
        voucher_no,
        voucher_type,
        party_id,
        amount,
        tds,
        net_amount,
        payment_mode,
        cheque_no,
        voucher_date
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "ssiddidss",
        $voucher_no,
        $voucher_type,
        $party_id,
        $amount,
        $tds,
        $net_amount,
        $payment_mode,
        $cheque_no,
        $voucher_date
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Voucher saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
?>