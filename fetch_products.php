<?php
require_once 'db.php';

$q = mysqli_query($conn,"SELECT * FROM product_master ORDER BY product_name ASC");

echo '<option value="">Select Product</option>';

while($row = mysqli_fetch_assoc($q)){
echo '<option value="'.$row['product_name'].'">'.$row['product_name'].'</option>';
}
?>