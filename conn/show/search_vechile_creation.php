<?php
include '../conn/db.php';

$vechile = [];
$sql = "SELECT * FROM vechile ORDER BY owner_name";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $vechile[] = $row['owner_name
        
        
        
        
        
        
        '];
    }
}