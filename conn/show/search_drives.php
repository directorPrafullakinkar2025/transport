<?php
include '../conn/db.php';

$driver = [];
$sql = "SELECT * FROM drivr ORDER BY drive_name";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $driver[] = $row['drive_name'];
    }
}