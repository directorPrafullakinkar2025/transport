<?php
require_once 'db.php';

$ledger_group = mysqli_real_escape_string($conn,$_POST['ledger_group']);
$party_name   = mysqli_real_escape_string($conn,$_POST['party_name']);
$address1     = mysqli_real_escape_string($conn,$_POST['address_one']);
$address2     = mysqli_real_escape_string($conn,$_POST['address_two']);
$state        = mysqli_real_escape_string($conn,$_POST['state_name']);
$city_id      = mysqli_real_escape_string($conn,$_POST['city_name']);
$mobile       = mysqli_real_escape_string($conn,$_POST['mobile_number']);

$query = mysqli_query($conn,"
INSERT INTO party_master
(ledger_group,party_name,address_one,address_two,state_name,city_name,mobile_number)
VALUES
('$ledger_group','$party_name','$address1','$address2','$state','$city_id','$mobile')
");

if(!$query){
    echo json_encode([
        "status"=>"error",
        "message"=>mysqli_error($conn)
    ]);
    exit;
}

$party_id = mysqli_insert_id($conn);

echo json_encode([
"status"=>"success",
"party_id"=>$party_id,
"party_name"=>$party_name
]);

?>