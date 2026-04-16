<?php        
include '../conn/db.php';

$pod_uploads = [];
$sql = "SELECT * FROM pod_uploads ORDER BY pod_id";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
$pod_uploads[] = $row['pod_id'];
    }
}