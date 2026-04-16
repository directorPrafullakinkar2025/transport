<?php
include '../conn/db.php';

$receipts_payment = [];
$sql = "SELECT * FROM receipts_payment ORDER BY voucher_no";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $receipts_payment[] = $row['voucher_no'];
    }
}