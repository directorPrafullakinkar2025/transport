<?php
include '../conn/db.php';

$challans = [];
$sql = "SELECT * FROM challans ORDER BY challan_no";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $challans[] = $row['challan_no'];
    }
}