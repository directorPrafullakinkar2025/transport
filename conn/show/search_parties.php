<?php
include '../conn/db.php';

$parties = [];
$sql = "SELECT * FROM parties ORDER BY party_name";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $parties[] = $row['party_name'];
    }
}