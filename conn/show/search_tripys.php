<?php
include '../conn/db.php';

$tripys = [];
$sql = "SELECT * FROM vehicle_master ORDER BY trip_no";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $tripys[] = $row['trip_no'];
    }
}