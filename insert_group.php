<?php
require_once 'db.php';

$group_id = mysqli_real_escape_string($conn,$_POST['group_id']);
$group_name = mysqli_real_escape_string($conn,$_POST['group_name']);



$query = mysqli_query($conn,"
INSERT INTO group_master
(group_id, group_name)
VALUES
('$group_id','$group_name')
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
"group_id"=>$group_id,
"group_name"=>$group_name
]);

?>