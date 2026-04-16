<?php
require_once "db.php";

$sql = "SELECT 
DATE(l.lr_date) as trip_date,
SUM(f.mill_freight) as total_freight,
SUM(f.agent_commission) as total_agent,
SUM(f.gadi_bhada) as total_gadi,
SUM(f.profit) as total_profit

FROM lr_entry l
LEFT JOIN freight_gst_details f ON l.lr_id = f.lr_id

GROUP BY DATE(l.lr_date)
ORDER BY trip_date DESC";

$res = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Daily Profit Report</title>

<style>
body{font-family:Arial;background:#f2f2f2;padding:20px;}
table{width:100%;border-collapse:collapse;background:white;}
th,td{border:1px solid #ccc;padding:8px;text-align:center;font-size:12px;}
th{background:#222;color:white;}
</style>
</head>

<body>

<h2>Daily Profit Report</h2>

<table>

<tr>
<th>Date</th>
<th>Total Freight</th>
<th>Agent Commission</th>
<th>Vehicle Bhadha</th>
<th>Profit</th>
</tr>

<?php while($row=mysqli_fetch_assoc($res)){ ?>

<tr>

<td><?php echo $row['trip_date']; ?></td>

<td><?php echo number_format($row['total_freight']); ?></td>

<td><?php echo number_format($row['total_agent']); ?></td>

<td><?php echo number_format($row['total_gadi']); ?></td>

<td style="color:green;font-weight:bold;">
<?php echo number_format($row['total_profit']); ?>
</td>

</tr>

<?php } ?>

</table>

</body>
</html>