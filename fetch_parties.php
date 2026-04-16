<?php
require_once 'db.php';

$q = mysqli_query($conn,"SELECT * FROM party_master ORDER BY party_name ASC");

echo '<option value="">Select Party</option>';

while($row = mysqli_fetch_assoc($q)){
echo '<option value="'.$row['party_id'].'">'.$row['party_name'].'</option>';
}
?>