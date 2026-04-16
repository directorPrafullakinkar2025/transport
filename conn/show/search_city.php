<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

$search = '';
$result = null;

if (!empty($_GET['search'])) {

    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $query = "SELECT * FROM city_master 
              WHERE city_name LIKE '%$search%'
              ORDER BY city_name";

} else {

    $query = "SELECT * FROM city_master 
              ORDER BY city_name";
}

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>