<?php        
include '../conn/db.php';

$job = [];
$sql = "SELECT * FROM job ORDER BY bill_type";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
$job[] = $row['bill_type'];
    }
}