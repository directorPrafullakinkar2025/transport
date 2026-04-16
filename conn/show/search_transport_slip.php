<?php
include '../conn/db.php';

$transport_slip = [];
$sql = "SELECT * FROM transport_slip ORDER BY slip_no";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $transport_slip[] = $row['slip_no'];
    }
}