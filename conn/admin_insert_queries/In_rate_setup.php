<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $party_id        = $_POST['party_id'] ?? 0;
    $source          = $_POST['source'] ?? '';
    $destination     = $_POST['destination'] ?? '';
    $product         = $_POST['product'] ?? 0;     // product id or code
    $rate            = $_POST['rate'] ?? 0;

    $hamali          = $_POST['hamali'] ?? 0;
    $pre_bhada       = $_POST['pre_bhada'] ?? 0;
    $d_charge        = $_POST['d_charge'] ?? 0;
    $stationary      = $_POST['stationary'] ?? 0;
    $crossing        = $_POST['crossing'] ?? 0;

    $rate_type       = $_POST['rate_type'] ?? '';
    $hamali_type     = $_POST['hamali_type'] ?? '';
    $pre_bhada_type  = $_POST['pre_bhada_type'] ?? '';
    $d_charge_type   = $_POST['d_charge_type'] ?? '';
    $stationary_type = $_POST['stationary_type'] ?? '';
    $crossing_type   = $_POST['crossing_type'] ?? '';
    $party_type      = $_POST['party_type'] ?? '';

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO rate_setup (
        party_id,
        source,
        destination,
        product,
        rate,
        hamali,
        pre_bhada,
        d_charge,
        stationary,
        crossing,
        rate_type,
        hamali_type,
        pre_bhada_type,
        d_charge_type,
        stationary_type,
        crossing_type,
        party_type
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "issidddddssssssss",
        $party_id,
        $source,
        $destination,
        $product,
        $rate,
        $hamali,
        $pre_bhada,
        $d_charge,
        $stationary,
        $crossing,
        $rate_type,
        $hamali_type,
        $pre_bhada_type,
        $d_charge_type,
        $stationary_type,
        $crossing_type,
        $party_type
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Rate saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
?>