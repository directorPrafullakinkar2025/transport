<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $bill_no        = $_POST['bill_no'] ?? '';
    $bill_date      = $_POST['bill_date'] ?? date('Y-m-d');
    $due_date       = $_POST['due_date'] ?? null;
    $broker_owner   = $_POST['broker_owner'] ?? '';
    $remarks        = $_POST['remarks'] ?? '';

    $hamali                 = $_POST['hamali'] ?? 0;
    $hamali_details         = $_POST['hamali_details'] ?? '';
    $rto_challan            = $_POST['rto_challan'] ?? 0;
    $rto_details            = $_POST['rto_details'] ?? '';
    $detention              = $_POST['detention'] ?? 0;
    $detention_details      = $_POST['detention_details'] ?? '';
    $extra_delivery         = $_POST['extra_delivery'] ?? 0;
    $extra_delivery_details = $_POST['extra_delivery_details'] ?? '';
    $others                 = $_POST['others'] ?? 0;
    $other_details          = $_POST['other_details'] ?? '';

    $vehicle_type   = $_POST['vehicle_type'] ?? '';

    $total_amount   = $_POST['total_amount'] ?? 0;
    $advance        = $_POST['advance'] ?? 0;
    $net_total      = $_POST['net_total'] ?? 0;
    $grand_total    = $_POST['grand_total'] ?? 0;

    $apply_gst      = $_POST['apply_gst'] ?? 0;   // 1 = Yes, 0 = No
    $cgst_amount    = $_POST['cgst_amount'] ?? 0;
    $sgst_amount    = $_POST['sgst_amount'] ?? 0;
    $igst_amount    = $_POST['igst_amount'] ?? 0;

    $balance_amount = $_POST['balance_amount'] ?? 0;
    $bill_status    = $_POST['bill_status'] ?? 'Open';

    /* ========= OPTIONAL AUTO CALCULATIONS ========= */
    if ($total_amount == 0) {
        $total_amount =
            $hamali +
            $rto_challan +
            $detention +
            $extra_delivery +
            $others;
    }

    if ($net_total == 0) {
        $net_total = $total_amount;
    }

    if ($apply_gst && $grand_total == 0) {
        $grand_total = $net_total + $cgst_amount + $sgst_amount + $igst_amount;
    } elseif (!$apply_gst) {
        $grand_total = $net_total;
    }

    if ($balance_amount == 0) {
        $balance_amount = $grand_total - $advance;
    }

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO bills (
        bill_no,
        bill_date,
        due_date,
        broker_owner,
        remarks,
        hamali,
        hamali_details,
        rto_challan,
        rto_details,
        detention,
        detention_details,
        extra_delivery,
        extra_delivery_details,
        others,
        other_details,
        vehicle_type,
        total_amount,
        advance,
        net_total,
        grand_total,
        apply_gst,
        cgst_amount,
        sgst_amount,
        igst_amount,
        balance_amount,
        bill_status
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "sssssd sdsdsdsdss ddddidd dds",
        $bill_no,
        $bill_date,
        $due_date,
        $broker_owner,
        $remarks,
        $hamali,
        $hamali_details,
        $rto_challan,
        $rto_details,
        $detention,
        $detention_details,
        $extra_delivery,
        $extra_delivery_details,
        $others,
        $other_details,
        $vehicle_type,
        $total_amount,
        $advance,
        $net_total,
        $grand_total,
        $apply_gst,
        $cgst_amount,
        $sgst_amount,
        $igst_amount,
        $balance_amount,
        $bill_status
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Bill saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
?>