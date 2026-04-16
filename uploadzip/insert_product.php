<?php
require_once "db.php";

$group_name = $_POST['group_name'];
$product_name = $_POST['product_name'];

$sql = "INSERT INTO product_master (group_name, product_name)
        VALUES ('$group_name','$product_name')";

if(mysqli_query($conn,$sql))
{
    echo "success";
}
else
{
    echo "error";
}
?>