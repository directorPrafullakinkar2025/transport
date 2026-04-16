<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $party_name = $_POST['party_name'] ?? '';
    $party_type = $_POST['party_type'] ?? '';
    $mobile     = $_POST['mobile'] ?? '';
    $gst_no     = $_POST['gst_no'] ?? '';
    $address    = $_POST['address'] ?? '';

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO parties (
        party_name,
        party_type,
        mobile,
        gst_no,
        address
    ) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "sssss",
        $party_name,
        $party_type,
        $mobile,
        $gst_no,
        $address
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Party saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
