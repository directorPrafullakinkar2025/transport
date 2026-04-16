<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $party_id               = $_POST['party_id'] ?? 0;
    $source_city_id         = $_POST['source_city_id'] ?? 0;
    $destination_city_id    = $_POST['destination_city_id'] ?? 0;
    $product_id             = $_POST['product_id'] ?? 0;

    $rate                   = $_POST['rate'] ?? 0;
    $rate_type              = $_POST['rate_type'] ?? '';

    $hamali                 = $_POST['hamali'] ?? 0;
    $hamali_type            = $_POST['hamali_type'] ?? '';

    $pre_bhada              = $_POST['pre_bhada'] ?? 0;
    $pre_bhada_type         = $_POST['pre_bhada_type'] ?? '';

    $d_charge               = $_POST['d_charge'] ?? 0;
    $d_charge_type          = $_POST['d_charge_type'] ?? '';

    $stationary             = $_POST['stationary'] ?? 0;
    $stationary_type        = $_POST['stationary_type'] ?? '';

    $crossing               = $_POST['crossing'] ?? 0;
    $crossing_type          = $_POST['crossing_type'] ?? '';

    $party_type             = $_POST['party_type'] ?? '';
    $status                 = $_POST['status'] ?? 1;

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO rate_master (
        party_id,
        source_city_id,
        destination_city_id,
        product_id,
        rate,
        rate_type,
        hamali,
        hamali_type,
        pre_bhada,
        pre_bhada_type,
        d_charge,
        d_charge_type,
        stationary,
        stationary_type,
        crossing,
        crossing_type,
        party_type,
        status
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "iiiidsdssdssdssdsi",
        $party_id,
        $source_city_id,
        $destination_city_id,
        $product_id,
        $rate,
        $rate_type,
        $hamali,
        $hamali_type,
        $pre_bhada,
        $pre_bhada_type,
        $d_charge,
        $d_charge_type,
        $stationary,
        $stationary_type,
        $crossing,
        $crossing_type,
        $party_type,
        $status
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