<?php
require_once "db.php";

$id = $_POST['id'];

mysqli_query($conn,"DELETE FROM product_details WHERE product_id='$id'");

echo "success";
?>