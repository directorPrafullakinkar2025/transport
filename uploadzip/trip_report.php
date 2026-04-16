<?php
require_once "db.php";

$sql = "SELECT 
l.lr_id,
l.lr_date,
fc.city_name AS from_city,
tc.city_name AS to_city,
v.vehicle_number,

f.weight,
f.rate,
f.mill_freight,
f.agent_commission,
f.gadi_bhada,
f.profit

FROM lr_entry l

LEFT JOIN city_master fc ON l.from_city = fc.city_id
LEFT JOIN city_master tc ON l.to_city = tc.city_id
LEFT JOIN vehicle_master v ON l.vehicle_no = v.vehicle_id
LEFT JOIN freight_gst_details f ON l.lr_id = f.lr_id

ORDER BY l.lr_date DESC";

$res = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>

<title>Trip Profit Report</title>

<style>

body{
font-family:Arial;
background:#f2f2f2;
padding:20px;
}

table{
width:100%;
border-collapse:collapse;
background:white;
}

th,td{
border:1px solid #ccc;
padding:8px;
font-size:12px;
text-align:center;
}

th{
background:#333;
color:white;
}

.profit{
font-weight:bold;
color:green;
}

</style>

</head>

<body>
<?php
$sqlProfit = "SELECT SUM(profit) as total_profit FROM freight_gst_details";
$resProfit = mysqli_query($conn,$sqlProfit);
$dataProfit = mysqli_fetch_assoc($resProfit);
?>

<h3>Total Profit : ₹ <?php echo $dataProfit['total_profit']; ?></h3>
<h2>Transport Trip Profit Report</h2>

<table>

<tr>

<th>LR No</th>
<th>Date</th>
<th>Vehicle</th>
<th>From</th>
<th>To</th>
<th>Weight</th>
<th>Rate</th>
<th>Mill Freight</th>
<th>Agent</th>
<th>Gadi Bhada</th>
<th>Profit</th>

</tr>

<?php while($row = mysqli_fetch_assoc($res)){ ?>

<tr>

<td><?php echo $row['lr_id']; ?></td>
<td><?php echo $row['lr_date']; ?></td>
<td><?php echo $row['vehicle_number']; ?></td>
<td><?php echo $row['from_city']; ?></td>
<td><?php echo $row['to_city']; ?></td>
<td><?php echo $row['weight']; ?></td>
<td><?php echo $row['rate']; ?></td>
<td><?php echo $row['mill_freight']; ?></td>
<td><?php echo $row['agent_commission']; ?></td>
<td><?php echo $row['gadi_bhada']; ?></td>
<td class="profit"><?php echo $row['profit']; ?></td>

</tr>

<?php } ?>

</table>

</body>
</html>