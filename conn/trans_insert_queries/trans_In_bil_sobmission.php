<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $lr_no          = $_POST['lr_no'] ?? '';
    $lr_date        = $_POST['lr_date'] ?? '';
    $consignor_id   = $_POST['consignor_id'] ?? 0;
    $consignee_id   = $_POST['consignee_id'] ?? 0;
    $source         = $_POST['source'] ?? '';
    $destination    = $_POST['destination'] ?? '';
    $qty            = $_POST['qty'] ?? 0;
    $actual_weight  = $_POST['actual_weight'] ?? 0;
    $charge_weight  = $_POST['charge_weight'] ?? 0;
    $freight        = $_POST['freight'] ?? 0;
    $vehicle_id     = $_POST['vehicle_id'] ?? 0;

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO lr_entries (
        lr_no,
        lr_date,
        consignor_id,
        consignee_id,
        source,
        destination,
        qty,
        actual_weight,
        charge_weight,
        freight,
        vehicle_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "ssisssiddii",
        $lr_no,
        $lr_date,
        $consignor_id,
        $consignee_id,
        $source,
        $destination,
        $qty,
        $actual_weight,
        $charge_weight,
        $freight,
        $vehicle_id
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>LR saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
?>
