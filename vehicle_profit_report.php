<?php
require_once "db.php";

$sql = "SELECT 
v.vehicle_number,
COUNT(l.lr_id) as total_trips,
SUM(f.mill_freight) as total_freight,
SUM(f.profit) as total_profit

FROM lr_entry l

LEFT JOIN vehicle_master v ON l.vehicle_no = v.vehicle_id
LEFT JOIN freight_gst_details f ON l.lr_id = f.lr_id

GROUP BY v.vehicle_number
ORDER BY total_profit DESC";

$res = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Vehicle Profit Report</title>

<style>
body{font-family:Arial;background:#f2f2f2;padding:20px;}
table{width:100%;border-collapse:collapse;background:white;}
th,td{border:1px solid #ccc;padding:8px;text-align:center;}
th{background:#444;color:white;}
</style>

</head>

<body>

<h2>Vehicle Wise Profit Report</h2>

<table>

<tr>
<th>Vehicle</th>
<th>Total Trips</th>
<th>Total Freight</th>
<th>Total Profit</th>
</tr>

<?php while($row=mysqli_fetch_assoc($res)){ ?>

<tr>

<td><?php echo $row['vehicle_number']; ?></td>

<td><?php echo $row['total_trips']; ?></td>

<td><?php echo number_format($row['total_freight']); ?></td>

<td style="color:green;font-weight:bold;">
<?php echo number_format($row['total_profit']); ?>
</td>

</tr>

<?php } ?>

</table>

</body>
</html>