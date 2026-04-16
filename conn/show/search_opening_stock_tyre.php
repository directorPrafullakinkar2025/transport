<?php        
include '../conn/db.php';

$opening_stock = [];
$sql = "SELECT * FROM opening_stock ORDER BY transcation_date";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
$opening_stock[] = $row['transcation_date'];
    }
}