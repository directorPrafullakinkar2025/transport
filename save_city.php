<?php
require_once 'db.php';

$state = mysqli_real_escape_string($conn,$_POST['state_name']);
$city  = mysqli_real_escape_string($conn,$_POST['city_name']);

mysqli_query($conn,"
INSERT INTO city_master(state_name,city_name)
VALUES('$state','$city')
");

$city_id = mysqli_insert_id($conn);

echo json_encode([
"status"=>"success",
"city_id"=>$city_id,
"city_name"=>$city
]);