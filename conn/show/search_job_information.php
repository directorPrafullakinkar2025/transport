<?php
include '../conn/db.php';

$job_information = [];
$sql = "SELECT * FROM job_information ORDER BY job_date";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $job_information[] = $row['job_date'];
    }
}