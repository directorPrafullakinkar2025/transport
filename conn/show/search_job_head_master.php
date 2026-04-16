<?php        
include '../conn/db.php';

$job_head_master = [];
$sql = "SELECT * FROM job_head_master ORDER BY job_head_name";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
$job_head_master[] = $row['job_head_name'];
    }
}