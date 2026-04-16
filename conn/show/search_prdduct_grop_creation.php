<?php
include '../conn/db.php';

$products = [];
$sql = "SELECT * FROM products ORDER BY product_name";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $products[] = $row['product_name'];
    }
}