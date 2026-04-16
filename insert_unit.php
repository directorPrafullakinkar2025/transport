<?php
require_once "db.php";

$unit_name  = $_POST['unit_name'];
$unit_value = $_POST['unit_value'];

$sql = "INSERT INTO unit_master (unit_name, unit_value)
        VALUES ('$unit_name','$unit_value')";

if(mysqli_query($conn,$sql)){
    echo "success";
}
?>