<?php
include '../conn/db.php';

$firms = [];
$sql = "SELECT firm_name FROM firms ORDER BY firm_name";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $firms[] = $row['firm_name'];
    }
}