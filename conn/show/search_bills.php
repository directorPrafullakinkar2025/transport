<?php
include '../conn/db.php';

$bilss = [];
$sql = "SELECT * FROM bills ORDER BY bill_no";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $bilss[] = $row['bill_no'];
    }
}