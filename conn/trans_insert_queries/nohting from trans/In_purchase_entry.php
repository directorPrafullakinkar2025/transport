<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $bill_type              = $_POST['bill_type'] ?? '';
    $invoice_no             = $_POST['invoice_no'] ?? '';
    $reference_no           = $_POST['reference_no'] ?? '';
    $invoice_date           = $_POST['invoice_date'] ?? null;
    $invoice_type           = $_POST['invoice_type'] ?? '';

    $buyer_id               = $_POST['buyer_id'] ?? 0;
    $consignee_id           = $_POST['consignee_id'] ?? 0;
    $transport_id           = $_POST['transport_id'] ?? 0;
    $agent_id               = $_POST['agent_id'] ?? 0;
    $transport_mode         = $_POST['transport_mode'] ?? '';

    $supply_date            = $_POST['supply_date'] ?? null;
    $supply_place           = $_POST['supply_place'] ?? '';
    $supply_type            = $_POST['supply_type'] ?? '';

    $challan_no             = $_POST['challan_no'] ?? '';
    $challan_date           = $_POST['challan_date'] ?? null;
    $order_no               = $_POST['order_no'] ?? '';
    $order_date             = $_POST['order_date'] ?? null;
    $location               = $_POST['location'] ?? '';

    $product_group_id       = $_POST['product_group_id'] ?? 0;
    $product_id             = $_POST['product_id'] ?? 0;
    $part_no                = $_POST['part_no'] ?? '';
    $description            = $_POST['description'] ?? '';
    $quantity               = $_POST['quantity'] ?? 0;
    $unit                   = $_POST['unit'] ?? '';
    $packages               = $_POST['packages'] ?? 0;
    $weight_total_qty       = $_POST['weight_total_qty'] ?? 0;

    $rate                   = $_POST['rate'] ?? 0;
    $rate_type              = $_POST['rate_type'] ?? '';
    $size                   = $_POST['size'] ?? '';
    $total                  = $_POST['total'] ?? 0;

    $discount_percent       = $_POST['discount_percent'] ?? 0;
    $taxable_value          = $_POST['taxable_value'] ?? 0;
    $include_tax            = $_POST['include_tax'] ?? 0;
    $gst_percent            = $_POST['gst_percent'] ?? 0;

    $cgst_amount            = $_POST['cgst_amount'] ?? 0;
    $sgst_amount            = $_POST['sgst_amount'] ?? 0;
    $igst_amount            = $_POST['igst_amount'] ?? 0;

    $opening_km             = $_POST['opening_km'] ?? 0;
    $current_km             = $_POST['current_km'] ?? 0;
    $closing_km             = $_POST['closing_km'] ?? 0;
    $vehicle_no             = $_POST['vehicle_no'] ?? '';
    $driver_name            = $_POST['driver_name'] ?? '';

    $warranty_date          = $_POST['warranty_date'] ?? null;
    $warranty_days          = $_POST['warranty_days'] ?? 0;
    $avg_km                 = $_POST['avg_km'] ?? 0;
    $avg_cost               = $_POST['avg_cost'] ?? 0;

    $total_tax_amount       = $_POST['total_tax_amount'] ?? 0;
    $discount_amount        = $_POST['discount_amount'] ?? 0;
    $total_cgst_amount      = $_POST['total_cgst_amount'] ?? 0;
    $total_sgst_amount      = $_POST['total_sgst_amount'] ?? 0;
    $total_igst_amount      = $_POST['total_igst_amount'] ?? 0;
    $total_amount           = $_POST['total_amount'] ?? 0;

    $freight                = $_POST['freight'] ?? 0;
    $others                 = $_POST['others'] ?? 0;
    $tcs_percent            = $_POST['tcs_percent'] ?? 0;
    $tcs_amount             = $_POST['tcs_amount'] ?? 0;

    $grand_total            = $_POST['grand_total'] ?? 0;
    $advance_amount         = $_POST['advance_amount'] ?? 0;
    $balance_amount         = $_POST['balance_amount'] ?? 0;
    $narration              = $_POST['narration'] ?? '';

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO purchases (
        bill_type, invoice_no, reference_no, invoice_date, invoice_type,
        buyer_id, consignee_id, transport_id, agent_id, transport_mode,
        supply_date, supply_place, supply_type,
        challan_no, challan_date, order_no, order_date, location,
        product_group_id, product_id, part_no, description, quantity, unit,
        packages, weight_total_qty, rate, rate_type, size, total,
        discount_percent, taxable_value, include_tax, gst_percent,
        cgst_amount, sgst_amount, igst_amount,
        opening_km, current_km, closing_km, vehicle_no, driver_name,
        warranty_date, warranty_days, avg_km, avg_cost,
        total_tax_amount, discount_amount, total_cgst_amount,
        total_sgst_amount, total_igst_amount, total_amount,
        freight, others, tcs_percent, tcs_amount,
        grand_total, advance_amount, balance_amount, narration
    ) VALUES (
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,?,?,?,?,?,?
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "sssssi iiis sss ss ss ssi ssisd is dds ddd iii ss siii dddd dddd dddd ddd s",
        $bill_type, $invoice_no, $reference_no, $invoice_date, $invoice_type,
        $buyer_id, $consignee_id, $transport_id, $agent_id, $transport_mode,
        $supply_date, $supply_place, $supply_type,
        $challan_no, $challan_date, $order_no, $order_date, $location,
        $product_group_id, $product_id, $part_no, $description, $quantity, $unit,
        $packages, $weight_total_qty, $rate, $rate_type, $size, $total,
        $discount_percent, $taxable_value, $include_tax, $gst_percent,
        $cgst_amount, $sgst_amount, $igst_amount,
        $opening_km, $current_km, $closing_km, $vehicle_no, $driver_name,
        $warranty_date, $warranty_days, $avg_km, $avg_cost,
        $total_tax_amount, $discount_amount, $total_cgst_amount,
        $total_sgst_amount, $total_igst_amount, $total_amount,
        $freight, $others, $tcs_percent, $tcs_amount,
        $grand_total, $advance_amount, $balance_amount, $narration
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Purchase saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
