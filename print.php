<?php

session_start();
require_once "db.php";

$lr_id = $_SESSION['print_lr_id'] ?? null;

if (!$lr_id) {
    die("Error: No LR selected for printing. Please go back and click Print again.");
}

$sqlHeader = "SELECT 
    l.*, 
    l.firm_id, 
    fc.city_name AS from_city, tc.city_name AS to_city,
    p1.party_name AS consignor_name, p1.address_one AS consignor_addr,
    p2.party_name AS consignee_name, p2.address_one AS consignee_addr,
    v.vehicle_number,
    f.freight, f.hamali, f.pre_bhadha, f.bilty_charge, f.collection_charges, 
    f.cpc, f.other_charge, f.grand_total
FROM lr_entry l
LEFT JOIN city_master fc ON l.from_city = fc.city_id
LEFT JOIN city_master tc ON l.to_city = tc.city_id
LEFT JOIN party_master p1 ON l.consignor = p1.party_id
LEFT JOIN party_master p2 ON l.consignee = p2.party_id
LEFT JOIN vehicle_master v ON l.vehicle_no = v.vehicle_id
LEFT JOIN freight_gst_details f ON l.lr_id = f.lr_id
WHERE l.lr_id = '$lr_id'";

$resHeader = mysqli_query($conn, $sqlHeader);
$resHeader = mysqli_query($conn, $sqlHeader);

if (!$resHeader) {
    die("SQL Error: " . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($resHeader);

if (!$data) {
    die("Error: Data not found for LR: " . htmlspecialchars($lr_id));
}

$sqlProducts = "SELECT * FROM product_details WHERE lr_id = '$lr_id'";
$resProducts = mysqli_query($conn, $sqlProducts);
$products = [];
while($row = mysqli_fetch_assoc($resProducts)) {
    $products[] = $row;
}
/* ================= GET FIRM LOGO ================= */
$firm_id = $data['firm_id'] ?? '';

if(empty($firm_id)){
    die("Error: Firm ID not found in LR entry.");
}

$firmQuery = mysqli_query($conn, "
    SELECT firm_name, logo, seal 
    FROM firms 
    WHERE firm_id = '$firm_id'
");

if (!$firmQuery) {
    die("Firm query error: " . mysqli_error($conn));
}

$firmData = mysqli_fetch_assoc($firmQuery);

if (!$firmData) {
    die("Error: Firm not found for ID: " . htmlspecialchars($firm_id));
}

$firm_name = $firmData['firm_name'];
$firm_logo = $firmData['logo'];
$firm_seal = $firmData['seal'];
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
/* ================== for logo and seal================== */
.header img{
    object-fit: contain;
}
/*---------------logo and seal transperancy--------*/
img {
    opacity: 0.95;
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

<div style="display:flex; align-items:center; justify-content:space-between;">

    <div>
        <?php if(!empty($firm_logo)): ?>
            <img src="uploads/<?php echo $firm_logo; ?>" style="height:60px;">
        <?php endif; ?>
    </div>

    <div style="text-align:center; flex:1;">
        <div class="header"><?php echo $firm_name; ?></div>
        <div class="sub">CONSIGNMENT NOTE</div>
    </div>

    <div style="width:60px;"></div>

</div>

<br>

<div class="row">
<div><b>LR No :</b> <?php echo $data['lr_id']; ?></div>
<div><b>Date :</b> <?php echo date('d-m-Y', strtotime($data['lr_date'])); ?></div>
</div>

<div class="row">
<div><b>From :</b> <?php echo $data['from_city']; ?></div>
<div><b>To :</b> <?php echo $data['to_city']; ?></div>
</div>

<div class="row">
<div><b>Vehicle No :</b> <?php echo $data['vehicle_number'] ?? 'N/A'; ?></div>
<div><b>Agent :</b> <?php echo $data['agent_name'] ?? 'N/A'; ?></div>
</div>

<br>

<b>Consignor's Name & Address :</b><br>
<?php echo $data['consignor_name']; ?><br>
<?php echo $data['consignor_addr']; ?>

<br><br>

<b>Consignee's Name & Address :</b><br>
<?php echo $data['consignee_name']; ?><br>
<?php echo $data['consignee_addr']; ?>

<br><br>

<table>
<tr>
<th>CHARGED WT.</th>
<th>PACKAGES</th>
<th>DESCRIPTION (Said To Contain)</th>
<th>ACTUAL WT</th>
<th>FREIGHT</th>
</tr>

<?php foreach($products as $p){ ?>
<tr>
<td><?php echo number_format($p['charge_wt'],2); ?></td>
<td><?php echo $p['qty']; ?></td>
<td><?php echo $p['product_name']; ?></td>
<td><?php echo number_format($p['actual_wt'],2); ?></td>
<td><?php echo number_format($data['freight'],2); ?></td>
</tr>
<?php } ?>

</table>

<br>

<table>
<tr>
<td>Freight Rate</td>
<td><?php echo $data['rate'] ?? ''; ?></td>
<td>Other Charge</td>
<td><?php echo number_format($data['other_charge'],2); ?></td>
</tr>

<tr>
<td>C.P.C. Charge</td>
<td><?php echo number_format($data['cpc'],2); ?></td>
<td>Collection Charge</td>
<td><?php echo number_format($data['collection_charges'],2); ?></td>
</tr>

<tr>
<td>Bilty Charge</td>
<td><?php echo number_format($data['bilty_charge'],2); ?></td>
<td>Pre. Bhada</td>
<td><?php echo number_format($data['pre_bhadha'],2); ?></td>
</tr>

<tr>
<td>Hamali Charge</td>
<td><?php echo number_format($data['hamali'],2); ?></td>
<td><b>Grand Total</b></td>
<td><b><?php echo number_format($data['grand_total'],2); ?></b></td>
</tr>

</table>

<br>

<div class="small-text">
The Consignment Covered by This Set Special Lorry Receipt shall be Delivered 
Only To The Consignee Bank's whose Name is Mentioned in the Lorry Receipt.  
No Responsibility For Leakage & Breakage.
</div>

<br><br>

<div style="display:flex; justify-content:space-between; align-items:flex-end;">

    <div>
        Signature Of Booking Clerk
    </div>

    <div>
        <?php if(!empty($firm_seal)): ?>
            <img src="uploads/<?php echo $firm_seal; ?>" 
     style="height:80px; transform:rotate(-15deg); opacity:0.8;">
        <?php endif; ?>
    </div>

</div>

</div>

<?php } ?>

</div>

<script>
window.print();
</script>

</body>
</html>