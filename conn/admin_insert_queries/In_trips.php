<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $trip_no     = $_POST['trip_no'] ?? '';
    $vehicle_id  = $_POST['vehicle_id'] ?? 0;
    $broker_id   = $_POST['broker_id'] ?? 0;
    $source      = $_POST['source'] ?? '';
    $destination = $_POST['destination'] ?? '';
    $rate        = $_POST['rate'] ?? 0;
    $freight     = $_POST['freight'] ?? 0;
    $advance     = $_POST['advance'] ?? 0;
    $balance     = $_POST['balance'] ?? 0;
    $trip_date   = $_POST['trip_date'] ?? date('Y-m-d');

    /* ========= OPTIONAL AUTO CALC ========= */
    if ($freight == 0 && $rate > 0) {
        $freight = $rate; // adjust if you calculate by KM/WT
    }
    if ($balance == 0) {
        $balance = $freight - $advance;
    }

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO trips (
        trip_no,
        vehicle_id,
        broker_id,
        source,
        destination,
        rate,
        freight,
        advance,
        balance,
        trip_date
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "siissdddds",
        $trip_no,
        $vehicle_id,
        $broker_id,
        $source,
        $destination,
        $rate,
        $freight,
        $advance,
        $balance,
        $trip_date
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Trip saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
?>