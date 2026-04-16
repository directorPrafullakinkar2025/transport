<?php
session_start();
require_once "db.php";

/* ================= LR ID ================= */
$lr_id = 'LR-2026-0003'; 

if (!$lr_id) {
    die("Error: No LR selected for printing.");
}

/* ================= HEADER + FIRM DATA ================= */
$sqlHeader = "SELECT 
    l.*, 
    
    fc.city_name AS from_city, 
    tc.city_name AS to_city,

    p1.party_name AS consignor_name, 
    p1.address_one AS consignor_addr,

    p2.party_name AS consignee_name, 
    p2.address_one AS consignee_addr,

    v.vehicle_number,

    f.freight, f.hamali, f.pre_bhadha, f.bilty_charge, 
    f.collection_charges, f.cpc, f.other_charge, 
    f.grand_total, f.lot_no, f.pr_no, f.pm_no, 
    f.freight_type, f.booking_type, f.delivery_type, f.remarks,

    -- All Firm Table Fields
    fm.firm_id, fm.firm_name, fm.alias, fm.address1 AS firm_address1, 
    fm.address2 AS firm_address2, fm.city AS firm_city, fm.state AS firm_state, 
    fm.phone AS firm_phone, fm.mobile AS firm_mobile, fm.gst_no, 
    fm.pan_no, fm.email, fm.mailing_id, fm.cin_number, fm.mesme_number, 
    fm.bank_name, fm.account_number, fm.branch_name, fm.ifsc_code, 
    fm.jurisdiction, fm.financial_year, fm.logo, fm.seal,
    fm.cgst AS firm_cgst, fm.sgst AS firm_sgst, fm.igst AS firm_igst

FROM lr_entry l

LEFT JOIN city_master fc ON l.from_city = fc.city_id
LEFT JOIN city_master tc ON l.to_city = tc.city_id
LEFT JOIN party_master p1 ON l.consignor = p1.party_id
LEFT JOIN party_master p2 ON l.consignee = p2.party_id
LEFT JOIN vehicle_master v ON l.vehicle_no = v.vehicle_id
LEFT JOIN freight_gst_details f ON l.lr_id = f.lr_id
LEFT JOIN firms fm ON l.firm_id = fm.firm_id

WHERE l.lr_id = '$lr_id'";

$resHeader = mysqli_query($conn, $sqlHeader);

if (!$resHeader) {
    die("Query Error: " . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($resHeader);

if (!$data) {
    die("Error: Data not found for LR: " . htmlspecialchars($lr_id));
}


/* ================= PRODUCT DATA ================= */
$sqlProducts = "SELECT 
    product_id,
    lr_id,
    product_name,
    group_name,
    description,
    qty,
    actual_wt,
    charge_wt,
    unit,
    rate,
    rate_type,
    amount,
    length,
    width,
    height,
    created_at
FROM product_details 
WHERE lr_id = '$lr_id'";

$resProducts = mysqli_query($conn, $sqlProducts);

if (!$resProducts) {
    die("Product Query Error: " . mysqli_error($conn));
}

$products = [];
$total_qty = 0;
$total_weight = 0;
$total_amount = 0;

while ($row = mysqli_fetch_assoc($resProducts)) {

    // Handle NULL values safely
    $row['qty'] = (float)($row['qty'] ?? 0);
    $row['actual_wt'] = (float)($row['actual_wt'] ?? 0);
    $row['charge_wt'] = (float)($row['charge_wt'] ?? 0);
    $row['rate'] = (float)($row['rate'] ?? 0);
    $row['amount'] = (float)($row['amount'] ?? 0);

    $products[] = $row;

    // Totals
    $total_qty += $row['qty'];
    $total_weight += $row['actual_wt'];
    $total_amount += $row['amount'];
}
/* ================= INVOICE DATA ================= */
$sqlInvoice = "SELECT 
    invoice_id,
    lr_id,
    invoice_no,
    invoice_date,
    value_of_goods,
    eway_bill_no,
    ewb_exp_date,
    created_at
FROM party_invoice_details
WHERE lr_id = '$lr_id'";

$resInvoice = mysqli_query($conn, $sqlInvoice);

if (!$resInvoice) {
    die("Invoice Query Error: " . mysqli_error($conn));
}

$invoices = [];
$total_invoice_value = 0;

while ($row = mysqli_fetch_assoc($resInvoice)) {

    // Handle NULL safely
    $row['value_of_goods'] = (float)($row['value_of_goods'] ?? 0);

    $invoices[] = $row;

    // Total
    $total_invoice_value += $row['value_of_goods'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>LR Print</title>
    <style>
        body { font-family: Arial; font-size: 12px; }
        .header { text-align: center; }
        .box { border:1px solid #000; padding:8px; margin-bottom:10px; }
        table { width:100%; border-collapse: collapse; }
        table, th, td { border:1px solid #000; }
        th, td { padding:5px; text-align:left; }
    </style>
</head>
<body>

<!-- ================= FIRM HEADER ================= -->

<div class="header" style="position:relative; border-bottom:1px solid #000; padding-bottom:10px; min-height:50px;">

    <!-- LOGO LEFT -->
    <div style="position:absolute; left:10px; top:10px; width:60px; height:60px;">
        <?php if (!empty($data['logo'])) { ?>
            <img src="uploads/<?php echo $data['logo']; ?>" 
                 style="width:100%; height:100%; object-fit:contain;">
        <?php } ?>
    </div>

    <!-- CENTER CONTENT (SHIFTED RIGHT) -->
    <div style="text-align:center; padding-left:80px;padding-top:20px;">
        <h2 style="margin:0;"><?php echo $data['firm_name']; ?></h2>

        <p style="margin:2px 0;">
            Email: <?php echo $data['email']; ?> ,
            Mobile No.: <?php echo $data['firm_mobile']; ?>
        </p>
    </div>

</div>


<div style="display:flex; gap:6px; width:100%;">

    <!-- ================= LEFT SIDE ================= -->
    <div style="display:flex; gap:6px; width:100%;">

    <!-- ================= LEFT SIDE ================= -->
    <div style="width:67%; display:flex; flex-direction:column;">

        <!-- ===== TOP SECTION ===== -->
        <div style="display:flex; gap:6px;">

            <!-- Left Box -->
            <div style="width:50%;height:230px;border:1px solid #000;">
                <p style="font-weight:bold;font-size:15px;text-align:center;">CAUTION:</p>
                <p style="line-height:1.5;">
                    The Consingment will not be detained delivered re-routed or re-booked without consignee bank's written permission will be delivery the destination.
                </p>
                <hr>

                <p style="font-weight:bold;font-size:15px;text-align:center;">CONSIGNMENT NOTE</p>

                <p style="font-weight:bold;font-size:15px;">
                    <span style="margin-left:120px;"> LR No: <span style="margin-left:10px;"><?php echo $data['lr_id']; ?></span></span>
                </p>

                <p style="font-weight:bold;font-size:15px;">
                    <span style="margin-left:120px;">Date: <span style="margin-left:10px;"><?php echo $data['lr_date']; ?></span></span>
                </p>
            </div>

            <!-- CONSIGNOR COPY -->
            <div style="width:50%;height:230px;border:1px solid #000;">
                <div style="text-align:center;">

                    <div style="font-weight:bold;font-size:18px;">CONSIGNOR COPY</div>
                    <hr>

                    <div style="font-weight:bold;font-size:18px;">AT OWNER'S RISK</div>
                    <hr>

                    <div style="font-weight:bold;font-size:18px;">INSURANCE</div>
                    <hr>

                    <p style="line-height:1.5;">
                        The Consigner has Stated that:<br>
                        He has not insured Consignment OR <br>
                        He has insured Consignment
                    </p>

                    <hr>

                    <div>
                        <div>Company :</div>

                        <div style="display:flex; justify-content:space-between; width:300px; margin:0 auto;">
                            <span>Policy No. :</span>
                            <span>
                                Amount: ₹ <?php echo number_format($total_amount, 2); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ===== ✅ YOUR NEW CODE (UNCHANGED) ===== -->
        <div style="display: flex; width: 100%; font-family: Arial, sans-serif; border-top: none;">

            <div style="flex: 2; border: 1px solid black; border-top: none; padding: 10px; min-height: 150px; box-sizing: border-box;">
                <span style="font-weight:bold; font-size:13px; text-decoration: underline;">Consignor's Name And Address :</span>
                <hr>                
                <p style="font-weight:bold; font-size: 13px; margin-top: 5px; line-height: 1.0;">
                    <?php echo $data['consignor_name']; ?><br>
                <p style="font-size: 13px; margin-top: 5px; line-height: 1.4;"></p>
                    <?php echo $data['consignor_addr']; ?><span style="font-size:13px;margin-left:65%;">GST No: <?php echo $data['gst_no']; ?></span>
                </p>
                <hr>
                <span style="font-weight:bold; font-size:13px; text-decoration: underline;">Consignee's Name And Address :</span>
                <hr>
                <p style="font-weight:bold; font-size: 13px; margin-top: 5px; line-height: 1.0;">
                    <?php echo $data['consignee_name']; ?><br>
                 <p style="font-size: 13px; margin-top: 5px; line-height: 1.4;"></p>  
                    <?php echo $data['consignee_addr']; ?><span style="font-size:13px;margin-left:65%;">GST No: <?php echo $data['gst_no']; ?></span>
                </p>
                
            </div>
        </div>

    </div>

    <!-- ================= RIGHT SIDE (UNCHANGED) ================= -->
    <div style="width:33%; height:350px; font-family: Arial, sans-serif;">

        <div style="width:100%;box-sizing:border-box; padding:5px;line-height:1.5;border:1px solid #000;">

            <span style="font-weight:bold; font-size:12px;">GST No: <?php echo $data['gst_no']; ?></span><br>
            <span style="font-weight:bold; font-size:12px;">PAN No: <?php echo $data['pan_no']; ?></span>

            <hr>

            <p style="font-weight:bold; font-size:13px; text-align:center;">NOTICE</p>

            <span style="font-weight:bold; font-size:11px; text-align: justify;">
                The consignment covered by this set Special Lorry Receipt Fromshall be stored at the 
                Destinnstiounser the control of the Transport Operator and shall be Delivered to ro of the 
                Consignee Bank's whose Name is mentioned in the Lorry Receipt if it will Under no Circumstances be Delivered To any one 
                withOut the written Authority from the Consignee Bank's of its order endoresed on the Consignee Copy or on a Seperate Latter of Authority.
            </span>

            <hr>

            <span style="font-weight:bold; font-size:15px;">
                Vehicle No. : <?php echo $data['vehicle_number']; ?>
            </span>
            <br>

            <span style="font-weight:bold; font-size:15px;">
                Vehicle Type :
            </span>

            <hr>

            <span style="font-weight:bold; font-size:15px;">
                Transport Mode: <?php echo $data['transport_mode']; ?>
            </span>

            <hr>

            <span style="font-weight:bold; font-size:15px;">
                From: <?php echo $data['from_city']; ?>
            </span>

            <hr>

            <span style="font-weight:bold; font-size:15px;">
                To: <?php echo $data['to_city']; ?>
            </span>

            <hr>

            <span style="font-weight:bold; font-size:15px;">
                LR Type: <?php echo $data['booking_type']; ?>
            </span>

        </div>
    </div>

</div>

<!-- CLOSE TOP ROW -->
</div>

<!-- ================= LAST ROW (8 COLUMNS) ================= -->
<div style="display:flex; width:100%; border:1px solid #000;  font-family:Arial; text-align:center;">

    <div style="flex:1; border-right:1px solid #000; padding:8px;">PAKAGES</div>
    <div style="flex:2; border-right:1px solid #000; padding:8px;">DESCRIPTION (Said To Coatation)</div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;">ACTUAL WT</div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;">CHARGED WT</div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;">UNIT</div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;">RATE</div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;">FREIGHT</div>
</div>
<div style="display:flex; width:100%; border:1px solid #000;  font-family:Arial; text-align:center;">
    <?php foreach ($products as $p) { ?>
   <div style="flex:1; border-right:1px solid #000; padding:8px;"><?php echo $p['qty']; ?></div>
    <div style="flex:2; border-right:1px solid #000; padding:8px;"><?php echo $p['description']; ?></div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;"><?php echo $p['actual_wt']; ?></div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;"><?php echo $p['charge_wt']; ?></div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;"><?php echo $p['unit']; ?></div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;"><?php echo $p['rate']; ?></div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;"><?php echo $data['freight']; ?></div>
<?php } ?>
    </div>

<div style="display:flex;  width:100%; font-size:12px;">

    <!-- ================= COLUMN 1: INVOICE ================= -->
    <div style="width:50%; border:1px solid #000;">

        <!-- Header -->
        <div style="display:flex; background:#f2f2f2; border-bottom:1px solid #000;text-align:center;">
            <div style="flex:1; padding:4px; border-right:1px solid #000;"><b>Inv No</b></div>
            <div style="flex:1; padding:4px; border-right:1px solid #000;"><b>Date</b></div>
            <div style="flex:1; padding:4px; border-right:1px solid #000;"><b>Value</b></div>
            <div style="flex:2; padding:4px; border-right:1px solid #000;"><b>EWay Bill</b></div>
            <div style="flex:1; padding:4px;"><b>Exp Date</b></div>
        </div>

        <!-- Data -->
        <?php foreach ($invoices as $inv) { ?>
        <div style="display:flex; border-bottom:1px solid #000;text-align:center;">
            <div style="flex:1; padding:4px; border-right:1px solid #000;"><?php echo $inv['invoice_no']; ?></div>
            <div style="flex:1; padding:4px; border-right:1px solid #000;"><?php echo $inv['invoice_date']; ?></div>
            <div style="flex:1; padding:4px; border-right:1px solid #000;"><?php echo number_format($inv['value_of_goods'],2); ?></div>
            <div style="flex:2; padding:4px; border-right:1px solid #000;"><?php echo $inv['eway_bill_no']; ?></div>
            <div style="flex:1; padding:4px;"><?php echo $inv['ewb_exp_date']; ?></div>
        </div>
        <?php } ?>

    </div>


    <!-- ================= COLUMN 2: DIMENSIONS ================= -->
    <div style="width:40%; border:1px solid #000;">

        <div style="text-align:center; background:#f2f2f2; padding:4px; border-bottom:1px solid #000;">
            <b>Dimensions</b>
        </div>

        <!-- Header -->
        <div style="display:flex; border-bottom:1px solid #000;text-align:center;">
            <div style="flex:1; padding:4px; border-right:1px solid #000;"><b>LENGHT</b></div>
            <div style="flex:1; padding:4px; border-right:1px solid #000;"><b>WIDTH</b></div>
            <div style="flex:1; padding:4px;"><b>HEIGHT</b></div>
        </div>

        <!-- Data -->
        <?php foreach ($products as $p) { ?>
        <div style="display:flex; border-bottom:1px solid #000;text-align:center;">
            <div style="flex:1; padding:4px; border-right:1px solid #000;"><?php echo $p['length']; ?></div>
            <div style="flex:1; padding:4px; border-right:1px solid #000;"><?php echo $p['width']; ?></div>
            <div style="flex:1; padding:4px;"><?php echo $p['height']; ?></div>
        </div>
        <?php } ?>

    </div>


    <div style="width:30%; border:1px solid #000; font-size:12px;">

    <div style="padding:0;">

        <!-- Row -->
        <div style="display:flex; border-bottom:1px solid #000;">
            <div style="width:60%; padding:5px; border-right:1px solid #000;">Freight</div>
            <div style="width:40%; padding:5px; text-align:right;"><?php echo $data['freight']; ?></div>
        </div>

        <div style="display:flex; border-bottom:1px solid #000;">
            <div style="width:60%; padding:5px; border-right:1px solid #000;">Hamali</div>
            <div style="width:40%; padding:5px; text-align:right;"><?php echo $data['hamali']; ?></div>
        </div>

        <div style="display:flex; border-bottom:1px solid #000;">
            <div style="width:60%; padding:5px; border-right:1px solid #000;">Pre Bhadha</div>
            <div style="width:40%; padding:5px; text-align:right;"><?php echo $data['pre_bhadha']; ?></div>
        </div>

        <div style="display:flex; border-bottom:1px solid #000;">
            <div style="width:60%; padding:5px; border-right:1px solid #000;">Bilty</div>
            <div style="width:40%; padding:5px; text-align:right;"><?php echo $data['bilty_charge']; ?></div>
        </div>

        <div style="display:flex; border-bottom:1px solid #000;">
            <div style="width:60%; padding:5px; border-right:1px solid #000;">Other</div>
            <div style="width:40%; padding:5px; text-align:right;"><?php echo $data['other_charge']; ?></div>
        </div>

        <!-- Total -->
        <div style="display:flex; font-weight:bold;">
            <div style="width:60%; padding:5px; border-right:1px solid #000;">Total</div>
            <div style="width:40%; padding:5px; text-align:right;"><?php echo $data['grand_total']; ?></div>
        </div>

    </div>
</div>
</div>
  <!-- ================= BOTTOM ROW ================= -->
    <div style="display:flex; gap:6px; margin-top:6px;">

        <!-- BLANK UNDER INVOICE -->
        <div style="width:41%; border:1px solid #000; height:80px;">
            <!-- Blank Space -->
        </div>

        <!-- COMBINED BOX (DIMENSIONS + CHARGES WIDTH) -->
        <div style="width:100%; border:1px solid #000; height:80px;">

            <div style="padding:5px;">
                <!-- You can add content here -->

                <div><b>If POD is not received within 30 days of Material Delivery Date, <span style="margin-left: 400px;"> Signature Of Booking Cleaerk</span>
                    <br> Rs. 50 per day is charged as penalty.</b></div>
                <div><b>No responsibility For Leakage & Breakage</b></div><br>
                <div><b>Note : -</b></div>

            </div>

        </div>

    </div>

</div>
</div>
</body>
</html>