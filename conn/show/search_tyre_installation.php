<?php
include '../conn/db.php';

$unit_master = [];
$sql = "SELECT * FROM unit_master ORDER BY unit_name";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $unit_master[] = $row['unit_name'];
    }
}