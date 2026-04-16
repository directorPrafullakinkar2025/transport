<?php
include '../conn/db.php';

$bills = [];
$sql = "SELECT * FROM bills ORDER BY bill_no";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $bills[] = $row['party_id'];
    }
}