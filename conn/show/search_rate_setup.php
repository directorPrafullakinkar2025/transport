<?php        
include '../conn/db.php';

$rate_setup = [];
$sql = "SELECT * FROM rate_setup ORDER BY party_id";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
$rate_setup[] = $row['party_id'];
    }
}