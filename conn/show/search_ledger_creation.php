<?php
include '../conn/db.php';

$ledger_master = [];
$sql = "SELECT * FROM ledger_master ORDER BY ledger_group";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $ledger_master[] = $row['ledger_group'];
    }
}