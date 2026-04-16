<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // DEBUG: confirm data received
    print_r($_POST);
    // exit; // uncomment once confirmed

    $state_name      = trim($_POST['state_name']);
    $state_code      = trim($_POST['state_code']);
    $gst_state_code  = trim($_POST['gst_state_code']);

    $sql = "INSERT INTO state_master 
            (state_name, state_code, gst_state_code)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $state_name, $state_code, $gst_state_code);

    if ($stmt->execute()) {
        echo "✅ Data inserted successfully";
    } else {
        echo "❌ Execute failed: " . $stmt->error;
    }
}
