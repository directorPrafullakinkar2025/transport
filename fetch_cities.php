<?php
require_once 'db.php';

$q = mysqli_query($conn,"SELECT * FROM city_master ORDER BY city_name ASC");

echo '<option value="">Select City</option>';

while($row = mysqli_fetch_assoc($q)){
echo '<option value="'.$row['city_id'].'">'.$row['city_name'].'</option>';
}
?>