<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $product_name   = $_POST['product_name'] ?? '';
    $unit           = $_POST['unit'] ?? '';
    $product_type   = $_POST['product_type'] ?? '';
    $hsn_sac_code   = $_POST['hsn_sac_code'] ?? '';
    $gst_percent    = $_POST['gst_percent'] ?? 0;
    $class          = $_POST['class'] ?? '';
    $division       = $_POST['division'] ?? '';
    $lead_time      = $_POST['lead_time'] ?? 0;
    $group_name     = $_POST['group_name'] ?? '';
    $description    = $_POST['description'] ?? '';
    $status         = $_POST['status'] ?? 1;

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO product_groups (
        product_name,
        unit,
        product_type,
        hsn_sac_code,
        gst_percent,
        class,
        division,
        lead_time,
        group_name,
        description,
        status
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "ssssdsisssi",
        $product_name,
        $unit,
        $product_type,
        $hsn_sac_code,
        $gst_percent,
        $class,
        $division,
        $lead_time,
        $group_name,
        $description,
        $status
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Product saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
?>