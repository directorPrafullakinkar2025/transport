<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/conn/db.php'; // DB connection

$sql = "SELECT * FROM product_group ORDER BY product_group_id DESC";
$result = mysqli_query($conn, $sql);

$products = [];

while ($row = mysqli_fetch_assoc($result)) {

    $products[] = [
        $row['product_name'],      // 0
        $row['group_name'],        // 1
        $row['product_type'],      // 2
        $row['hsn_sac_code'],      // 3
        $row['gst_percent'],       // 4
        $row['class'],             // 5
        $row['division'],          // 6
        $row['lead_time']          // 7
    ];
}

return $products;
?>