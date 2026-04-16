<?php
include '../conn/db.php';

$state_master = [];
$sql = "SELECT * FROM state_master ORDER BY state_name";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $state_master[] = $row['state_name'];
    }
}