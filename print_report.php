<?php
require_once "db.php";

$lr_no = $_GET['lr_no'];

$sql = "SELECT * FROM lr_entry WHERE lr_id='$lr_no'";
$result = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
<title>LR Print</title>

<style>
body{
    font-family: Arial;
    font-size:11px;
}

.main-box{
    width:100%;
}

.lr-copy{
    border:1px solid #000;
    padding:8px;
    margin-bottom:20px;
}

.header{
    text-align:center;
    font-weight:bold;
    font-size:16px;
}

.sub{
    text-align:center;
    font-weight:bold;
}

.row{
    display:flex;
    justify-content:space-between;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:5px;
}

table td, table th{
    border:1px solid #000;
    padding:4px;
}

.small-text{
    font-size:9px;
}

.copy-title{
    text-align:right;
    font-weight:bold;
}

@media print{
    body{
        margin:0;
    }
}
</style>

</head>
<body>

<div class="main-box">

<?php
$copies = ["CONSIGNEE COPY","CONSIGNOR COPY","DRIVER COPY","OFFICE COPY"];
foreach($copies as $copy){
?>

<div class="lr-copy">

<div class="header">KRISHNA LOGISTICS</div>
<div class="sub">CONSIGNMENT NOTE</div>
<div class="copy-title"><?php echo $copy; ?></div>

<br>

<div class="row">
<div><b>LR No :</b></div>
<div><b>Date :</b></div>
</div>

<div class="row">
<div><b>From :</b></div>
<div><b>To :</b></div>
</div>

<div class="row">
<div><b>Vehicle No :</b></div>
<div><b>Vehicle Type :</b></div>
</div>

<br>

<b>Consignor's Name & Address :</b>
<br><br>

<b>Consignee's Name & Address :</b>
<br><br>

<table>
<tr>
<th>CHARGED WT.</th>
<th>PACKAGES</th>
<th>DESCRIPTION (Said To Contain)</th>
<th>ACTUAL WT</th>
<th>FREIGHT</th>
</tr>
<tr>
<td height="40"></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
</table>

<br>

<table>
<tr>
<td>Freight Rate</td>
<td></td>
<td>Other Charge</td>
<td></td>
</tr>
<tr>
<td>C.P.C. Charge</td>
<td></td>
<td>Collection Charge</td>
<td></td>
</tr>
<tr>
<td>Bilty Charge</td>
<td></td>
<td>Pre. Bhada</td>
<td></td>
</tr>
<tr>
<td>Hamali Charge</td>
<td></td>
<td><b>Grand Total</b></td>
<td></td>
</tr>
</table>

<br>

<div class="small-text">
The Consignment Covered by This Set Special Lorry Receipt shall be Delivered 
Only To The Consignee Bank's whose Name is Mentioned in the Lorry Receipt.  
No Responsibility For Leakage & Breakage.
</div>

<br><br>
Signature Of Booking Clerk

</div>

<?php } ?>

</div>

<script>
window.print();
</script>

</body>
</html>