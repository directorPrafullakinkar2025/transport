<?php
include '../conn/db.php';

$lr_entries = [];
$sql = "SELECT * FROM lr_entries ORDER BY lr_no";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $lr_entries[] = $row['lr_no'];
    }
}