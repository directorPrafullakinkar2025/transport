<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM city_master";
if ($search != '') {
    $search = mysqli_real_escape_string($conn, $search);
    $sql .= " WHERE city_name LIKE '%$search%'";
}

$result = mysqli_query($conn, $sql);
if ($result === false) {
    die("SQL ERROR: " . mysqli_error($conn));
}       