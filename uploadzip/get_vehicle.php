<?php
require_once 'db.php';

$result = mysqli_query($conn,"SELECT * FROM vehicle_master ORDER BY vehicle_number ASC");

echo '<option value="">Select Vehicle</option>';

while($row = mysqli_fetch_assoc($result)){
echo '<option value="'.$row['vehicle_id'].'">'.$row['vehicle_number'].'</option>';
}
?>