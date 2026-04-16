<?php
include '../conn/db.php';

$product = [];
$sql = "SELECT * FROM product ORDER BY product_name";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $product[] = $row['product_name'];
    }
}