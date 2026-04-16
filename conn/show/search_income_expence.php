<?php
include '../conn/db.php';

$income_expence = [];
$sql = "SELECT * FROM income_expence ORDER BY head_name";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $income_expence[] = $row['head_name'];
    }
}