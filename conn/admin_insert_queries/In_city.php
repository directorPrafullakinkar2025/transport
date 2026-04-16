<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $state       = trim($_POST['state'] ?? '');
    $city        = trim($_POST['city_name'] ?? '');
    $pincode     = trim($_POST['pin_code'] ?? '');
    $std_code    = trim($_POST['std_code'] ?? '');
    $officeType  = trim($_POST['office_type'] ?? '');

    if ($state === '' || $city === '') {
        die('Invalid input');
    }

    $sql = "INSERT INTO city_master
            (state, city_name, pin_code, std_code, office_type, status, created_at)
            VALUES (?, ?, ?, ?, ?, 1, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $state, $city, $pincode, $std_code, $officeType);

    if ($stmt->execute()) {
        echo "<script>
            alert('City added successfully');
            window.location.href = '/Administration/city_creation.php?success=1';
        </script>";
        exit;
    } else {
        die("Execute failed: " . $stmt->error);
    }
}
