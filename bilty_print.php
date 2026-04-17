
<?php
session_start();
require_once "db.php";
// Get LR ID from URL
$lr_id = $_GET['lr_id'] ?? '';

// Fetch your data from the database using $lr_id here
// $row = mysqli_query(...)


// 1. Get the ID and Type from the URL
$lr_id = isset($_GET['lr_id']) ? $_GET['lr_id'] : '';
$type  = isset($_GET['type']) ? $_GET['type'] : 'consignor';

// 2. Convert "driver" to "DRIVER COPY" for the display
$headerTitle = strtoupper($type) . " COPY";

// 3. Your existing Database Query to fetch LR details
// $result = mysqli_query($conn, "SELECT * FROM lr_entry WHERE lr_id = '$lr_id'");
// $data = mysqli_fetch_assoc($result);

// /* ================= LR ID ================= */
$lr_id = $_GET['lr_id'] ?? '';

if (!$lr_id) {
    die("Error: No LR selected.");
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
    f.grand_total, 
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
    created_at,
    lot_no,
    pr_no,
    pm_no,
    agent_name
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
        body { font-family: Arial; font-size: 12px;margin:0;padding:0; }
        .header { text-align: center; }
        .box { border:1px solid #000; padding:8px; margin-bottom:10px; }
        table { width:100%; border-collapse: collapse; }
        table, th, td { border:1px solid #000; }
        th, td { padding:5px; text-align:left; }
        @page {size: A4 landscape;margin: 5mm;/* adjust as needed */}
        * {box-sizing: border-box;}
        .page {width: 210mm;height: 297mm;page-break-after: always;}
         /* Avoid breaking inside important sections */
    .no-break {page-break-inside: avoid;}
    </style>
</head>
<body>
<?php
$copies = ['CONSIGNOR COPY', 'CONSIGNEE COPY', 'DRIVER COPY', 'OFFICE COPY'];

foreach ($copies as $copyTitle) {
?>
    <!-- <div class="print-container">
        <div class="copy-label"><?php echo $copyTitle; ?></div>
        
        <table class="bilty-table">
            </table>
    </div> -->
    
    <div class="page-break"></div>

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
           <div style="width:50%; height:150px; border:1px solid #000; padding:6px; box-sizing:border-box; font-family:Arial; line-height:1.2;">

    <!-- CAUTION -->
    <div style="font-weight:bold; font-size:14px; text-align:center;">
        CAUTION
    </div>

    <div style="font-size:12px; text-align:justify; margin-top:2px;">
        The consignment will not be detained, delivered, re-routed, or re-booked without the consignee bank's written permission and will be delivered only at the destination.
    </div>

    <hr style="margin:4px 0;">

    <!-- CONSIGNMENT NOTE -->
    <div style="font-weight:bold; font-size:14px; text-align:center;">
        CONSIGNMENT NOTE
    </div>

    <!-- LR DETAILS -->
    <!-- LR DETAILS CENTER -->
<div style="text-align:center; font-weight:bold; font-size:13px; margin-top:6px; line-height:1.4;">
    
    <div>
        LR No: <?php echo $data['lr_id']; ?>
    </div>

    <div style="margin-top:3px;">
        Date: <?php echo $data['lr_date']; ?>
    </div>

</div>

</div>

            <!-- CONSIGNOR COPY -->
            <div style="width:50%;height:150px;border:1px solid #000;">
                <div style="text-align:center;">
<!-- change heading on printing -->
                    <div class="header-container">
    <div class="copy-indicator">
        <?php echo $copyTitle; ?>
    </div>
</div>
                    <hr>

                    <div style="font-weight:bold;font-size:11px;">AT OWNER'S RISK</div>
                    <hr>

                    <div style="font-weight:bold;font-size:11px;">INSURANCE</div>
                    <hr>

                    <span style="line-height:1.0;">
                        The Consigner has Stated that:
                        He has not insured Consignment OR 
                        He has insured Consignment
                    </span>

                    <hr>

                    <div>
                        <div style="text-align:left;">Company :</div>

                        <div style="display:flex; justify-content:space-between;">
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

    <div style="flex: 2; border: 1px solid black; border-top: none; padding: 8px; min-height: 150px; box-sizing: border-box; line-height:1.2;">

        <div style="font-weight:bold; font-size:13px;">Consignor's Name And Address :</div>
        <hr style="margin:3px 0;">

        <div style="font-weight:bold; font-size:13px; margin-top:3px;">
            <?php echo $data['consignor_name']; ?>
        </div>

        <div style="font-size:13px; margin-top:2px;">
            <?php echo $data['consignor_addr']; ?>
            <span style="float:right;">GST No: <?php echo $data['gst_no']; ?></span>
        </div>

        <hr style="margin:4px 0;">

        <div style="font-weight:bold; font-size:13px;">Consignee's Name And Address :</div>
        <hr style="margin:3px 0;">

        <div style="font-weight:bold; font-size:13px; margin-top:3px;">
            <?php echo $data['consignee_name']; ?>
        </div>

        <div style="font-size:13px; margin-top:2px;">
            <?php echo $data['consignee_addr']; ?>
            <span style="float:right;">GST No: <?php echo $data['gst_no']; ?></span>
        </div>

    </div>
</div>

    </div>

    <!-- ================= RIGHT SIDE (UNCHANGED) ================= -->
    <div style="width:33%; height:300px; font-family: Arial, sans-serif;">

        <div style="width:100%;box-sizing:border-box; border:1px solid #000;">

            <span style="font-weight:bold; font-size:12px;">GST No: <?php echo $data['gst_no']; ?></span><br>
            <span style="font-weight:bold; font-size:12px;">PAN No: <?php echo $data['pan_no']; ?></span>

            <hr>

          <span style="display:block; font-weight:bold; font-size:13px; text-align:center;">
    NOTICE
</span>

            <span style="font-weight:bold; font-size:11px; text-align: justify;line-height:1.2;">
                The consignment covered by this set Special Lorry Receipt Fromshall be stored at the 
                Destinnstiounser the control of the Transport Operator and shall be Delivered to ro of the 
                Consignee Bank's whose Name is mentioned in the Lorry Receipt if it will Under no Circumstances be Delivered To any one 
                withOut the written Authority from the Consignee Bank's of its order endoresed on the Consignee Copy or on a Seperate Latter of Authority.
            </span>

            <hr>

<div style="font-size:12px; font-weight:bold; line-height:1.2;">

    <div>
        Vehicle No. : <?php echo $data['vehicle_number']; ?>
    </div>

    <div>
        Vehicle Type :
    </div>

    <hr>

    <div >
        Transport Mode: <?php echo $data['transport_mode']; ?>
    </div>

    <hr>

    <div >
        From: <?php echo $data['from_city']; ?>
    </div>

    <hr>

    <div >
        To: <?php echo $data['to_city']; ?>
    </div>

    <hr>

    <div>
        LR Type: <?php echo $data['booking_type']; ?>
    </div>

</div>

        </div>
    </div>

</div>

<!-- CLOSE TOP ROW -->
</div>

<!-- ================= LAST ROW (8 COLUMNS) ================= -->
<div style="display:flex; width:100%; border:1px solid #000; border-bottom:none; font-family:Arial; text-align:center; font-weight:bold; background-color:#f2f2f2;">
    <div style="flex:0.8; border-right:1px solid #000; padding:8px;">PACKAGES</div>
    <div style="flex:2; border-right:1px solid #000; padding:8px;">DESCRIPTION</div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;">LOT NO</div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;">PR NO</div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;">PM NO</div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;">ACTUAL WT</div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;">CHARGED WT</div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;">UNIT</div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;">RATE</div>
    <div style="flex:1; padding:8px;">FREIGHT</div>
</div>

<?php foreach ($products as $p) { ?>
<div style="display:flex; width:100%; border:1px solid #000; border-top:none; font-family:Arial; text-align:center;">
    <div style="flex:0.8; border-right:1px solid #000; padding:8px;"><?php echo $p['qty']; ?></div>
    <div style="flex:2; border-right:1px solid #000; padding:8px; text-align:left;"><?php echo $p['description']; ?></div>
    
    <div style="flex:1; border-right:1px solid #000; padding:8px;"><?php echo $p['lot_no']; ?></div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;"><?php echo $p['pr_no']; ?></div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;"><?php echo $p['pm_no']; ?></div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;"><?php echo $p['actual_wt']; ?></div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;"><?php echo $p['charge_wt']; ?></div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;"><?php echo $p['unit']; ?></div>
    <div style="flex:1; border-right:1px solid #000; padding:8px;"><?php echo $p['rate']; ?></div>
    <div style="flex:1; padding:8px;"><?php echo $data['freight']; ?></div>
</div>
<?php } ?>

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
        <div style="width:100%; border:1px solid #000; height:90px;">

            <div style="padding:5px;">
                <!-- You can add content here -->

                <div>If POD is not received within 30 days of Material Delivery Date, <span style="margin-left: 400px;"> Signature Of Booking Cleaerk</span>
                     Rs. 50 per day is charged as penalty.</div>
                <div><b>No responsibility For Leakage & Breakage</b></div><br>
                <div><b>Note : -</b></div>

            </div>
 
        </div>
 
    </div>

</div>

</div>
    <?php
}
?>
</body>
</html>