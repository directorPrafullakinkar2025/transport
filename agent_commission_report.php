<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
require_once "db.php";

$sql = "SELECT 
COUNT(lr_id) as total_trips,
SUM(net_profit) as company_profit,
SUM(agent_comm_1 + agent_comm_2) as total_commission
FROM logistics_profit_analysis";

$res = mysqli_query($conn,$sql);

if (!$res) {
    die("Query Error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($res);

echo "Total Trips: " . $row['total_trips'] . "<br>";
echo "Total Commission: " . $row['total_commission'] . "<br>";
echo "Company Profit: " . $row['company_profit'];
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