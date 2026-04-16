<?php
require_once "db.php";

$id = $_GET['id'];

$res = mysqli_query($conn, "SELECT * FROM lr_entry WHERE lr_id='$id'");
$data = mysqli_fetch_assoc($res);
?>

<h2>LR Tracking</h2>
<p>LR No: <?php echo $id; ?></p>
<p>Status: In Transit</p>
<p>Vehicle: <?php echo $data['vehicle_no']; ?></p>