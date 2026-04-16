<?php
include '../conn/db.php';

$delivery_gatepass = [];
$sql = "SELECT * FROM delivery_gatepass ORDER BY gp_no";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $delivery_gatepass[] = $row['gp_no'];
    }
}