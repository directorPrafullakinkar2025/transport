<?php
include '../conn/db.php';

$loading_challan = [];
$sql = "SELECT * FROM loading_challan ORDER BY challan_no";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $loading_challan[] = $row['challan_no'];
    }
}