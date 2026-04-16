<?php
require_once "db.php";

$year = date("Y");

/* get last LR number of this year */

$sql = "SELECT lr_id 
        FROM lr_entry 
        WHERE lr_id LIKE 'LR-$year-%' 
        ORDER BY lr_id DESC 
        LIMIT 1";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0){

$row = mysqli_fetch_assoc($result);

$last = $row['lr_id'];

$number = intval(substr($last,-4));

$newNumber = $number + 1;

}else{

$newNumber = 1;

}

$lr = "LR-$year-".str_pad($newNumber,4,"0",STR_PAD_LEFT);

echo $lr;