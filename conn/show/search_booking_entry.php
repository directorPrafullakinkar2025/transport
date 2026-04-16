<?php        
include '../conn/db.php';

$booking_entry = [];
$sql = "SELECT * FROM booking_entry ORDER BY lr_no";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
$booking_entry[] = $row['lr_no'];
    }
}