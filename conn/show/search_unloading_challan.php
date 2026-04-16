<?php
include '../conn/db.php';

$unloading_challan = [];
$sql = "SELECT * FROM unloading_challan ORDER BY arrival_no";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $unloading_challan[] = $row['arrival_no'];
    }
}