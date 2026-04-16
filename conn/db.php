<?php
/* =====================================
   DATABASE CONNECTION (PDO)
===================================== */

$host = "localhost";
$dbname = "transport_erp";   // ← CHANGE THIS
$username = "root";         // ← CHANGE IF NEEDED
$password = "";             // ← CHANGE IF NEEDED

$conn = mysqli_connect("localhost", "root", "", $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}