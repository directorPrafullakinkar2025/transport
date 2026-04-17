<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
require_once "db.php";

$sql = "SELECT 
l.agent_name,
COUNT(l.lr_id) as total_trips,
SUM(f.agent_commission) as total_commission,
SUM(f.profit) as company_profit

FROM lr_entry l

LEFT JOIN freight_gst_details f ON l.lr_id = f.lr_id

GROUP BY l.agent_name
ORDER BY total_commission DESC";

$res = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>

<title>Agent Commission Report</title>

<style>
body{font-family:Arial;background:#f2f2f2;padding:20px;}
table{width:100%;border-collapse:collapse;background:white;}
th,td{border:1px solid #ccc;padding:8px;text-align:center;}
th{background:#111;color:white;}
</style>

</head>

<body>

<h2>Agent Commission Report</h2>

<table>

<tr>
<th>Agent Name</th>
<th>Total Trips</th>
<th>Total Commission</th>
<th>Company Profit</th>
</tr>

<?php while($row=mysqli_fetch_assoc($res)){ ?>

<tr>

<td><?php echo $row['agent_name']; ?></td>

<td><?php echo $row['total_trips']; ?></td>

<td><?php echo number_format($row['total_commission']); ?></td>

<td style="color:green;font-weight:bold;">
<?php echo number_format($row['company_profit']); ?>
</td>

</tr>

<?php } ?>

</table>

</body>
</html>