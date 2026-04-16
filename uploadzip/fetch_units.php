<?php
require_once 'db.php';

$q = mysqli_query($conn,"SELECT * FROM unit_master ORDER BY unit_name ASC");

echo '<option value="">Select Unit</option>';

while($row = mysqli_fetch_assoc($q)){
echo '<option value="'.$row['unit_name'].'">'.$row['unit_name'].'</option>';
}
?>