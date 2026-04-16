<?php
include '../conn/db.php';

$vehicle_bills = [];
$sql = "SELECT * FROM vehicle_bills ORDER BY bill_no";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $vehicle_bills[] = $row['bill_no'];
    }
}