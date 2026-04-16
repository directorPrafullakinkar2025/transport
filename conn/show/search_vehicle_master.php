<?php
include '../conn/db.php';

$vehicle_master = [];
$sql = "SELECT * FROM vehicle_master ORDER BY owner_name";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $owner_name[] = $row['owner_name'];
    }
}