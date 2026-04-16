<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= DATABASE CONNECTION ================= */
$host = "localhost";
$user = "root";
$pass = "";
$db   = "transport_db";   // 🔴 change DB name if needed

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $entry_date        = $_POST['entry_date'] ?? date('Y-m-d');
    $product_group_id  = $_POST['product_group_id'] ?? 0;
    $product_id        = $_POST['product_id'] ?? 0;
    $part_no           = $_POST['part_no'] ?? '';
    $vehicle_id        = $_POST['vehicle_id'] ?? 0;
    $tyre_position     = $_POST['tyre_position'] ?? ''; // FL, FR, RL, RR, Stepney
    $install_km        = $_POST['install_km'] ?? 0;
    $uninstall_km      = $_POST['uninstall_km'] ?? null;
    $install_date      = $_POST['install_date'] ?? null;
    $uninstall_date    = $_POST['uninstall_date'] ?? null;
    $remarks           = $_POST['remarks'] ?? '';
    $status            = $_POST['status'] ?? 1; // 1=Installed/Active, 0=Removed

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO tyre_entries (
        entry_date,
        product_group_id,
        product_id,
        part_no,
        vehicle_id,
        tyre_position,
        install_km,
        uninstall_km,
        install_date,
        uninstall_date,
        remarks,
        status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "siisississsi",
        $entry_date,
        $product_group_id,
        $product_id,
        $part_no,
        $vehicle_id,
        $tyre_position,
        $install_km,
        $uninstall_km,
        $install_date,
        $uninstall_date,
        $remarks,
        $status
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Tyre entry saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
?>
