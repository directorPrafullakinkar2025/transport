<?php
include '../conn/db.php';

$city_master = [];
$sql = "SELECT * FROM city_master ORDER BY city_id";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $city_master[] = $row['city_id'];
    }
}