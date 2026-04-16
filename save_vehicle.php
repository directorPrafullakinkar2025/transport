<?php
require_once 'db.php';

$owner_broker_name = mysqli_real_escape_string($conn,$_POST['owner_broker_name']);
$vehicle_number    = mysqli_real_escape_string($conn,$_POST['vehicle_number']);

$query = mysqli_query($conn,"
INSERT INTO vehicle_master
(owner_broker_name,vehicle_number)
VALUES
('$owner_broker_name','$vehicle_number')
");

if(!$query){
echo json_encode([
"status"=>"error",
"message"=>mysqli_error($conn)
]);
exit;
}

$vehicle_id = mysqli_insert_id($conn);

echo json_encode([
"status"=>"success",
"vehicle_id"=>$vehicle_id,
"owner_broker_name"=>$owner_broker_name,
"vehicle_number"=>$vehicle_number
]);
?>