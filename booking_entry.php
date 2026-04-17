<?php
session_start();

require_once 'db.php';
$bilty_id="";
/* =========================================================
   1. FETCH FIRM DATA (Including all 31 Table Fields)
   ========================================================= */
$session_firm_id = $_SESSION['firm_id'] ?? null;
$firmData = null;

// Initialize default variables to avoid "Undefined variable" errors
$firmName = "No Firm Selected";
$mobile   = ""; 
$whatsapp_mobile = "";
$whatsapp_msg = "";

if ($session_firm_id) {
    // We select * to get all fields: bank_name, ifsc_code, pan_no, etc.
    $sql = "SELECT * FROM firms WHERE firm_id = '$session_firm_id'";
    $res = mysqli_query($conn, $sql);
    
    if ($res && mysqli_num_rows($res) > 0) {
        $firmData = mysqli_fetch_assoc($res);
        
        /* --- Mapped Variables from your Table Structure --- */
        $firmName    = $firmData['firm_name'] ?? "No Firm Name";
        $mobile      = $firmData['mobile'] ?? ""; 
        $firmEmail   = $firmData['email'] ?? "";
        $firmGst     = $firmData['gst_no'] ?? "";
        $firmPan     = $firmData['pan_no'] ?? "";
        $firmLogo    = $firmData['logo'] ?? "";
        $firmAddress = ($firmData['address1'] ?? '') . ' ' . ($firmData['address2'] ?? '');
        
        // Banking & Tax Info (Available for use anywhere on page)
        $bankName    = $firmData['bank_name'] ?? "";
        $accNumber   = $firmData['account_number'] ?? "";
        $ifscCode    = $firmData['ifsc_code'] ?? "";
        $cgst_rate   = $firmData['cgst'] ?? "0";
        $sgst_rate   = $firmData['sgst'] ?? "0";
        $igst_rate   = $firmData['igst'] ?? "0";

        /* --- 2. WhatsApp Logic --- */
        if (!empty($mobile)) {
            // Remove non-numeric characters for the API link
            $whatsapp_mobile = preg_replace('/[^0-9]/', '', $mobile);
            // Create a encoded message
            $whatsapp_msg = urlencode("Hello " . $firmName . ", inquiry from Booking Entry.");
        }
    }
}



/* =========================================================
   3. FETCH CITY DATA
   ========================================================= */
$cityList = mysqli_query($conn, "SELECT * FROM city_master ORDER BY city_name ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Booking Entry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="/assets/css/layout.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        body{ margin:0; font-family: Arial, Helvetica, sans-serif; background:#eef1f7; }
        .page-container{ width:100%; }
        .action-buttons {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 10px;
}
        .btn{ padding:6px 12px; border:none; border-radius:3px; font-size:12px; cursor:pointer; margin-left:5px; color:#fff; }
        .btn-new{background:#00a65a;} .btn-edit{background:#f39c12;} .btn-delete{background:#dd4b39;}
        .btn-show{background:#00c0ef;} .btn-print{background:#605ca8;} .btn-mail{background:#3c8dbc;}
        .btn-add{background:#2e86c1;color:#fff;}
        h2{ margin:10px 0; }
        .form-box{ background:#e6e6e6; padding:25px; margin-bottom:20px; border-radius:6px; position:relative; }
        .form-box h4{ display:inline-block; background:red; color:#fff; padding:4px 15px; border-radius:15px; font-size:13px; position:absolute; top:-12px; }
        .grid{ display:grid; grid-template-columns: repeat(4, 1fr); gap:15px 25px; margin-top:15px; }
        label{ font-size:12px; font-weight:bold; display:block; margin-bottom:5px; color:#333; }
        input, select{ width:100%; padding:7px; border:1px solid #c0c4c8; border-radius:3px; background:#f9fafb; font-size:12px; }
        input:focus, select:focus{ border-color:black; background:yellow; }
        .table-box{ overflow:auto; margin-top:15px; }
        table{ width:100%; border-collapse:collapse; font-size:12px; }
        th{ background:#f4f4f4; padding:6px; border:1px solid #ccc; }
        td{ border:1px solid #ccc; }
        .bottom-actions{ text-align:center; margin:25px 0; }
        .bottom-actions button{ padding:8px 25px; margin:5px; border:none; border-radius:3px; font-size:13px; cursor:pointer; color:#fff; }
        .save-btn{background:#00a65a;} .print-btn{background:#f39c12;} .link-btn{background:#ff851b;}
        .plus-btn{ width:18px; height:18px; padding:0; font-size:12px; font-weight:bold; border:none; border-radius:3px; background:#00c0ef; color:#fff; cursor:pointer; margin-left:5px; }
        .modal{ display:none; position:fixed; z-index:10000; inset:0; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; }
        .modal.show{ display:flex; }
        .modal-box{ background:#fff; padding:20px; width:450px; border-radius:6px; } --> */
.whatsapp-container {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 999;
}
         <!-- .btn-save{
background:#28a745; 
color:#fff;
border:none;
padding:8px 18px;
border-radius:4px;
cursor:pointer;
font-weight:bold;
}

.btn-save:hover{
background:#218838;
}
.bottom-toolbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:#fff;
    padding:10px 15px;
    border-radius:8px;
    box-shadow:0 2px 6px rgba(0,0,0,0.1);
    flex-wrap:wrap;
    gap:10px;
}

.toolbar-left, .toolbar-right{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
}

.toolbar-select{
    padding:6px;
    border:1px solid #ccc;
    border-radius:4px;
    min-width:120px;
}

.lr-select-box{
    display:flex;
    border:1px solid #ccc;
    border-radius:5px;
    overflow:hidden;
}

.lr-select-box input{
    border:none;
    padding:6px;
    outline:none;
    width:120px;
}

.lr-select-box button{
    border:none;
    background:#00c0ef;
    color:#fff;
    padding:6px 10px;
    cursor:pointer;
}
/* --- Media Queries for Responsive Design --- */

/* For Tablets and smaller laptops */
@media (max-width: 1024px) {
    .grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }
}

/* For Mobile Landscape and large phones */
@media (max-width: 768px) {
    .grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .form-box {
        padding: 15px;
    }
    
    .bottom-toolbar {
        flex-direction: column;
        align-items: stretch;
    }
    
    .toolbar-left {
        justify-content: center;
    }
}

/* For Small Mobile devices */
@media (max-width: 480px) {
    .grid {
        grid-template-columns: 1fr;
    }
    
    h2 {
        font-size: 18px;
        text-align: center;
    }
    
    .action-buttons {
        justify-content: center;
    }
    
    .btn {
        width: 100%;
        margin: 5px 0;
    }
    
    /* Ensures the + button stays aligned near the label */
    .plus-btn {
        float: right;
    }
    
    /* Makes tables scrollable on tiny screens */
    .table-box {
        -webkit-overflow-scrolling: touch;
    }
    
    .toolbar-select, #whatsapp_number {
        width: 100%;
    }
}
    </style> 
</head>
<body>
<?php include_once "sidebar.php" ?>
<div class="page-container">
    <h2>Booking Entry</h2>

  User - <span><?= htmlspecialchars($firmName) ?></span>
    <div class="action-buttons">
        <button class="btn btn-new">New</button>
        <button class="btn btn-edit">Edit</button>
        <button class="btn btn-delete">Delete</button>
</div>

<form method="POST" action="save_lr.php" id="mainLRForm">

<input type="hidden" name="firm_id" value="<?php echo $_SESSION['firm_id'] ?? ''; ?>">
        <div class="form-box">
            <h4>LR Details</h4>
            <div class="grid">
                <div><label>LR No.</label><input type="text" name="lr_id" id="main_lr_id" readonly></div>
                <div><label>LR Date</label><input type="date" name="lr_date"></div>
                <div><label>Ref LR No.</label><input name="ref_lr_no" placeholder="Enter Ref LR No"></div>
             
                
                <div><label>Lot No</label><input name="lot_no" placeholder="Enter Lot No"></div>
                <div><label>PR No</label><input name="pr_no" placeholder="Enter PR No"></div>
                <div><label>PM No</label><input name="pm_no" placeholder="Enter PM No"></div>
                <div><label>Agent Name</label><input name="agent_name" placeholder="Enter Agent Name"></div>

                <div>
                    <label>Account Type</label>
                    <select name="account_type">
                        <option value="Consignor">Consignor</option>
                        <option value="Consignee">Consignee</option>
                    </select>
                </div>

                <div><label>Bill To</label><input name="bill_to" placeholder="Enter Bill To"></div>
                <div>
                   <label>From <button type="button" class="plus-btn" onclick="openCityModal()">+</button></label>
                    <select name="from_city">
                        <option value="">Select City</option>
                        <?php 
                        $cityList1 = mysqli_query($conn,"SELECT * FROM city_master ORDER BY city_name ASC");
                        while($row = mysqli_fetch_assoc($cityList1)){ echo "<option value='".$row['city_id']."'>".$row['city_name']."</option>"; } 
                        ?>
                    </select>
                </div>

                <div>
                   <label>To <button type="button" class="plus-btn" onclick="openCityModal()">+</button></label>
                    <select name="to_city">
                        <option value="">Select City</option>
                        <?php 
                        $cityList2 = mysqli_query($conn,"SELECT * FROM city_master ORDER BY city_name ASC");
                        while($row = mysqli_fetch_assoc($cityList2)){ echo "<option value='".$row['city_id']."'>".$row['city_name']."</option>"; } 
                        ?>
                    </select>
                </div>

                <div>
                    <label>Consignor <button type="button" class="plus-btn" onclick="openPartyModal()">+</button></label>
                    <select name="consignor">
                        <option value="">Select Consignor</option>
                        <?php 
                        $partyList1 = mysqli_query($conn,"SELECT * FROM party_master ORDER BY party_name ASC");
                        while($row = mysqli_fetch_assoc($partyList1)){ echo "<option value='".$row['party_id']."'>".$row['party_name']."</option>"; } 
                        ?>
                    </select>
                </div>

                <div>
                    <label>Consignee <button type="button" class="plus-btn" onclick="openPartyModal()">+</button></label>
                    <select name="consignee">
                        <option value="">Select Consignee</option>
                        <?php 
                        $partyList2 = mysqli_query($conn,"SELECT * FROM party_master ORDER BY party_name ASC");
                        while($row = mysqli_fetch_assoc($partyList2)){ echo "<option value='".$row['party_id']."'>".$row['party_name']."</option>"; } 
                        ?>
                    </select>
                </div>

                <div><label>Cnsnr Address</label><input name="cnsnr_address"></div>
                <div><label>Cnsgne Address</label><input name="cnsgne_address"></div>
                <div><label>Cnsnr GSTIN</label><input name="cnsnr_gstin"></div>
                <div><label>Cnsgne GSTIN</label><input name="cnsgne_gstin"></div>
                <div><label>Billing Branch</label><input name="billing_branch"></div>
                
                <div>
                <label>Billed To <button type="button" class="plus-btn" onclick="openPartyModal()">+</button></label>
                <select name="billed_to">
                        <option value="">Select Party</option>
                        <?php 
                        $partyList = mysqli_query($conn,"SELECT * FROM party_master ORDER BY party_name ASC");
                        while($row = mysqli_fetch_assoc($partyList)){ echo "<option value='".$row['party_id']."'>".$row['party_name']."</option>"; } 
                        ?>
                    </select>
                </div>

                <div>
                    <label>Vehicle No <button type="button" class="plus-btn" onclick="openVehicleModal()">+</button></label>
                    <select name="vehicle_no">
                        <option value="">Select Vehicle</option>
                        <?php 
                        $vehicleList = mysqli_query($conn,"SELECT * FROM vehicle_master ORDER BY vehicle_number ASC");
                        while($row = mysqli_fetch_assoc($vehicleList)){ echo "<option value='".$row['vehicle_id']."'>".$row['vehicle_number']."</option>"; } 
                        ?>
                    </select>
                </div>

                <div><label>Owner Name</label><input name="owner_name"></div>
                <div><label>Transport Mode</label><select name="transport_mode"><option>By Road</option><option>By Air</option><option>By Train</option></select></div>
                <div><label>Transp. Remark</label><input name="transport_remark"></div>
                <div><label>Remarks</label><input name="remarks"></div>
                <div><label>Delivery At</label><input name="delivery_at"></div>
                <div><label>Company Name</label><input name="company_name"></div>
                <div><label>Policy No</label><input name="policy_no"></div>
                <div><label>Insurance Amount</label><input name="insurance_amount"></div>
            </div>
            <br>
<div style="text-align:center;">
    <button type="button" class="btn btn-edit">Edit</button>
</div>
        </div>
    </form>

    <div class="form-box">
        <h4>Party Invoice Details</h4>
        <form id="invoiceForm"> 
            <div class="grid">
                <div><label>Invoice No</label><input type="text" name="invoice_no" id="invoice_no" required></div>
                <div><label>Invoice Date</label><input type="date" name="invoice_date" id="invoice_date" required></div>
                <div><label>Value Of Goods</label><input type="text" name="value_of_goods" id="inv_value" required></div>
                <div><label>E-Way Bill No</label><input type="text" name="eway_bill_no" id="eway_bill"></div>
                <div><label>EWB Exp. Date</label><input type="date" name="ewb_exp_date" id="eway_exp"></div>
            </div>
            <div style="text-align:center; margin-top:10px;">
                <button type="submit" class="btn btn-save" id="saveInvoice">🧾 Add Invoice</button>
            </div>
        </form> 
        <br>
        <table border="1" id="invoice_table">
            <tr><th>SNo.</th><th>Inv. No.</th><th>Inv. Date</th><th>Inv. Value</th><th>EWay Bill</th><th>EWB Exp Date</th></tr>
        </table>
    </div>

    <div class="form-box">
        <h4>Product Details</h4>
        <div class="table-box">
            <table id="product_entry_table" border="1">
                <tr>
                    <th>PRODUCT <button type="button" class="plus-btn" onclick="openProductModal()">+</button></th>
                    <th>Description</th><th>QTY</th><th>ACTUAL WT</th><th>CHARGE WT</th>
                    <th>UNIT <button type="button" class="plus-btn" onclick="openUnitModal()">+</button></th>
                </tr>
                <tr>
                    <td>
                        <select id="product_dropdown" name="product_name[]">
                            <option value="">Select Product</option>
                            <?php 
                            $productList = mysqli_query($conn,"SELECT * FROM product_master ORDER BY id ASC");
                            while($row = mysqli_fetch_assoc($productList)){ echo "<option value='".$row['product_name']."'>".$row['product_name']."</option>"; } 
                            ?>
                        </select>
                        <input type="hidden" name="group_name[]" id="group_name">
                    </td>
                    <td><input id="description" name="description[]"></td>
                   <td><input id="Qty" name="qty[]" oninput="calculateRow(this)"></td>
                    <td><input id="actual_weight" name="actual_wt[]"></td>
                    <td><input id="charge_wt" name="charge_wt[]"></td>
                    <td>
                        <select id="unit_dropdown" name="unit_name[]">
                            <option value="">Select Unit</option>
                            <?php 
                            $unitList = mysqli_query($conn,"SELECT * FROM unit_master ORDER BY unit_id ASC");
                            while($row = mysqli_fetch_assoc($unitList)){ echo "<option value='".$row['unit_name']."'>".$row['unit_name']."</option>"; } 
                            ?>
                        </select>
                    </td>
                </tr>
                <tr><th>RATE</th><th>RATE TYPE</th><th>AMOUNT</th><th>LENGTH</th><th>WIDTH</th><th>HEIGHT</th></tr>
                <tr>
                    <td><input id="rate" name="rate[]" oninput="calculateRow(this)"></td>
                   <td><select id="rate_type" name="rate_type[]" onchange="calculateRow(this)"><option>Per Kg</option><option>Per Bag</option><option>Per Box</option><option>Fixed</option></select></td>
                    <td><input id="amount" name="amount[]" readonly></td>
                    <td><input id="length" name="length[]"></td>
                    <td><input id="width" name="width[]"></td>
                    <td><input id="height" name="height[]"></td>
                </tr>
            </table>
            <input type="hidden" id="edit_product_id" value="">
            <div style="text-align:center; margin-top:10px;">
                <button type="button" class="btn btn-add" onclick="addItem()">➕ Add Item</button>
            </div>
            <br>
            <table border="1" id="item_table">
                <thead><tr><th>SNo.</th><th>Product</th><th>Qty</th><th>Actual Weight</th><th>Charge Wt.</th><th>Unit</th><th>Rate</th><th>Amt.</th><th>Length</th><th>Width</th><th>Height</th><th>Action</th></tr></thead>
                <tbody></tbody>
            </table>
        </div>
    </div>


   
    <div class="form-box">
    <h4>Freight & GST Details</h4>
    <form id="freightForm">
        <div class="grid">
            <div><label>Freight</label><input type="number" name="freight" id="freight" value="0" oninput="calculateGrandTotal()"></div>
            <div><label>Hamali</label><input type="number" name="hamali" value="0" oninput="calculateGrandTotal()"></div>
            <div><label>Pre. Bhadha</label><input type="number" name="pre_bhadha" value="0" oninput="calculateGrandTotal()"></div>
            <div><label>Bilty Charge</label><input type="number" name="bilty_charge" value="0" oninput="calculateGrandTotal()"></div>
            <div><label>Colle. Charges</label><input type="number" name="collection_charges" value="0" oninput="calculateGrandTotal()"></div>
            <div><label>C.P.C.</label><input type="number" name="cpc" value="0" oninput="calculateGrandTotal()"></div>
            <div><label>Other Charge</label><input type="number" name="other_charge" value="0" oninput="calculateGrandTotal()"></div>
            <div><label>Total</label><input type="number" name="total" id="total" value="0" readonly style="background-color: #f9f9f9;"></div>
            
            <div>
                <label>Apply GST</label>
                <select name="apply_gst" id="apply_gst" onchange="calculateGrandTotal()">
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </div>
            
            <div><label>CGST (2.5%)</label><input type="number" name="cgst" id="cgst" value="0" readonly></div>
            <div><label>SGST (2.5%)</label><input type="number" name="sgst" id="sgst" value="0" readonly></div>
            <div><label>IGST (5%)</label><input type="number" name="igst" id="igst" value="0" readonly></div>
            <div><label>Advance</label><input type="number" name="advance_amount" id="advance_amount" value="0" oninput="calculateGrandTotal()"></div>
            
            <div style="background: #fff3e0; padding: 5px; border-radius: 4px;">
                <label><b>Grand Total</b></label>
                <input type="number" name="grand_total" id="grand_total" value="0" readonly style="font-weight: bold; border: 1px solid #ff9800;">
            </div>

        </div>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

        <h4>Logistics Profit Analysis</h4>
        <div class="grid">
            <div>
                <label>Gadi Bhada</label>
                <input type="number" id="gadi_bhada" name="gadi_bhada" oninput="calculateNetProfit()">
            </div>
            <div>
                <label>Agent Comm. 1</label>
                <input type="number" id="comm_1" name="comm_1" oninput="calculateNetProfit()">
            </div>
            <div>
                <label>Agent Comm. 2</label>
                <input type="number" id="comm_2" name="comm_2" oninput="calculateNetProfit()">
            </div>

            <div style="background: #e8f5e9; padding: 5px; border-radius: 4px;">
                <label><b>Net Profit</b></label>
                <input type="number" id="net_profit" name="net_profit" readonly style="font-weight: bold; color: #2e7d32; border: 1px solid #2e7d32;">
            </div>
        </div>
    </form>
</div>

<script>
/**
 * Call this function inside your calculateGrandTotal() logic 
 * to ensure profit updates when freight/GST changes.
 */
function calculateNetProfit() {
    // Uses Grand Total as the base revenue
    const grandTotal = parseFloat(document.getElementById('grand_total').value) || 0;
    
    const gadiBhada = parseFloat(document.getElementById('gadi_bhada').value) || 0;
    const comm1 = parseFloat(document.getElementById('comm_1').value) || 0;
    const comm2 = parseFloat(document.getElementById('comm_2').value) || 0;

    const netProfit = grandTotal - (gadiBhada + comm1 + comm2);
    document.getElementById('net_profit').value = netProfit.toFixed(2);
}
</script>

<div class="bottom-toolbar">
    <div class="toolbar-left" style="display: flex; gap: 10px; align-items: center;">
        
        <button type="submit" class="btn save-btn" name="save_lr">💾 Save</button>

<button type="button" class="btn print-btn" 
        onclick="window.open('bilty_print.php?lr_id=' + document.getElementById('shared_lr_dropdown').value, '_blank')">
    📄 Bilty
</button>
<button type="button" 
        onclick="window.open('all_report.php', '_blank')" 
        class="btn btn-show">
    🏠 Dashboard
</button>
        <span style="border-left: 1px solid #ccc; height: 25px; margin: 0 5px;"></span>

        <select id="shared_lr_dropdown" class="toolbar-select">
    <option value="">Select LR...</option>
    <?php
    $lrList = mysqli_query($conn,"SELECT lr_id FROM lr_entry ORDER BY lr_id DESC");
    while($row = mysqli_fetch_assoc($lrList)){
        echo "<option value='".$row['lr_id']."'>".$row['lr_id']."</option>";
    }
    ?>
</select>

<select id="copy_type" class="toolbar-select">
    <option value="consignor">Consignor Copy</option>
    <option value="consignee">Consignee Copy</option>
    <option value="driver">Driver Copy</option>
    <option value="office">Office Copy</option>
</select>

<input type="text" id="whatsapp_number" placeholder="Enter Phone">

<button type="button" onclick="sendWhatsAppLR()">📲 Send WhatsApp</button>
    </div>


</div>

<script>

    <!-- <div class="form-box">
        <h4>Transport Calculation</h4>
        <div class="grid">
            <div>
                <label>Weight (MT/Kg)</label>
                <input type="number" id="calc_weight" name="weight" placeholder="0">
            </div>
            <div>
                <label>Rate</label>
                <input type="number" id="calc_rate" name="rate" placeholder="0">
            </div>
            <div>
                <label>Mill Freight</label>
                <input type="number" id="mill_freight" name="mill_freight" readonly>
            </div>
            <div>
                <label>Agent Commission</label>
                <input type="number" id="agent_commission" name="agent_commission" value="0">
            </div>
            <div>
                <label>Gadi Bhada (Truck Hire)</label>
                <input type="number" id="gadi_bhada" name="gadi_bhada" value="0">
            </div>
            <div>
                <label>Profit</label>
                <input type="number" id="profit" name="profit" readonly>
            </div>
        </div>
    </div>
  
    </div>
<script>
function goToPrint(lr_id) {
    if (lr_id !== "") {
        window.location.href = "bilty_print.php?lr_id=" + lr_id;
    }
}
</script>

<script>
$(document).ready(function(){

    // ✅ Activate Select2 for LR dropdown
    $("#print_lr_dropdown").select2({
        placeholder: "Search LR...",
        allowClear: true,
        width: '200px'
    });

    /* ================= FREIGHT CALCULATION ================= */
    $("#calc_weight, #calc_rate, #agent_commission, #gadi_bhada").on("input", function(){
        let weight = parseFloat($("#calc_weight").val()) || 0;
        let rate = parseFloat($("#calc_rate").val()) || 0;
        let commission = parseFloat($("#agent_commission").val()) || 0;
        let gadi = parseFloat($("#gadi_bhada").val()) || 0;

        let millFreight = weight * rate;
        let profit = millFreight - commission - gadi;

        $("#mill_freight").val(millFreight.toFixed(2));
        $("#freight").val(millFreight.toFixed(2));
        $("#profit").val(profit.toFixed(2));
    });

    /* ================= INVOICE ADD ================= */
    $("#invoiceForm").submit(function(e){
        e.preventDefault();
        let lr = $("#main_lr_id").val().trim();
        if(!lr){
            alert("Enter LR Number First");
            return;
        }
        let form = $(this);
        let btn = $("#saveInvoice");
        btn.prop("disabled",true).text("Saving...");

        $.ajax({
            url:"insert_invoice.php",
            type:"POST",
            data:form.serialize()+"&lr_id="+lr,
            success:function(res){
                if(res.trim()=="Success"){
                    let row = `<tr>
                    <td>${$("#invoice_table tr").length}</td>
                    <td>${$("#invoice_no").val()}</td>
                    <td>${$("#invoice_date").val()}</td>
                    <td>${$("#inv_value").val()}</td>
                    <td>${$("#eway_bill").val()}</td>
                    <td>${$("#eway_exp").val()}</td>
                    </tr>`;
                    $("#invoice_table").append(row);
                    form[0].reset();
                    alert("Invoice Added");
                }else{
                    alert(res);
                }
            },
            complete:function(){
                btn.prop("disabled",false).html("🧾 Add Invoice");
            }
        });
    });

    /* ================= SAVE ALL DATA ================= */
    let isSaving = false;
    $("#freightForm").submit(function(e){
        e.preventDefault();
        if(isSaving){ return; }
        let lr = $("#main_lr_id").val().trim();
        if(!lr){
            alert("Enter LR Number First");
            return;
        }
        isSaving = true;
        let mainData = $("#mainLRForm").serialize();
        let freightData = $("#freightForm").serialize();

        /* collect products */
        let products = [];
        $("#item_table tbody tr").each(function(){
            let row = $(this);
            products.push({
                product_name: row.find("td:eq(1)").text(),
                qty: row.find("td:eq(2)").text(),
                actual_wt: row.find("td:eq(3)").text(),
                charge_wt: row.find("td:eq(4)").text(),
                unit: row.find("td:eq(5)").text(),
                rate: row.find("td:eq(6)").text(),
                amount: row.find("td:eq(7)").text(),
                length: row.find("td:eq(8)").text(),
                width: row.find("td:eq(9)").text(),
                height: row.find("td:eq(10)").text()
            });
        });

        /* collect invoices */
        let invoices = [];
        $("#invoice_table tr:gt(0)").each(function(){
            let row = $(this);
            invoices.push({
                invoice_no: row.find("td:eq(1)").text(),
                invoice_date: row.find("td:eq(2)").text(),
                value_of_goods: row.find("td:eq(3)").text(),
                eway_bill_no: row.find("td:eq(4)").text(),
                ewb_exp_date: row.find("td:eq(5)").text()
            });
        });

        $.ajax({
            url:"ajax_save_complete_lr.php",
            type:"POST",
            data:{
                lr_id:lr,
                mainData:mainData,
                freightData:freightData,
                products:JSON.stringify(products),
                invoices:JSON.stringify(invoices)
            },
            success:function(res){
                if(res.trim()=="success"){
                    alert("LR Saved Successfully");
                }else{
                    alert(res);
                }
                isSaving=false;
            },
            error:function(){
                alert("Error Saving Data");
                isSaving=false;
            }
        });
    });

    /* ================= FETCH LR DATA ================= */
    $("#main_lr_id").blur(function(){
        let lr = $(this).val();
        if(!lr) return;
        $.get("fetch_lr_details.php",{lr_no:lr},function(response){
            if(response.status=="success"){
                $.each(response.main_data,function(key,val){
                    $("[name='"+key+"']").val(val);
                });
                /* products */
                $("#item_table tbody").empty();
                $.each(response.products,function(i,p){
                    $("#item_table tbody").append(`
                    <tr>
                    <td class="sno">${i+1}</td>
                    <td>${p.product_name}</td>
                    <td>${p.qty}</td>
                    <td>${p.actual_wt}</td>
                    <td>${p.charge_wt}</td>
                    <td>${p.unit}</td>
                    <td>${p.rate}</td>
                    <td>${p.amount}</td>
                    <td>${p.length}</td>
                    <td>${p.width}</td>
                    <td>${p.height}</td>
                    <td>
                    <button onclick="editRow(this)" data-id="${p.product_id}">✏</button>
                    <button onclick="deleteRow(this,'${p.product_id}')">❌</button>
                    </td>
                    </tr>`);
                });

                /* invoices */
                $("#invoice_table tr:gt(0)").remove();
                $.each(response.invoices,function(i,inv){
                    $("#invoice_table").append(`
                    <tr>
                    <td>${i+1}</td>
                    <td>${inv.invoice_no}</td>
                    <td>${inv.invoice_date}</td>
                    <td>${inv.value_of_goods}</td>
                    <td>${inv.eway_bill_no}</td>
                    <td>${inv.ewb_exp_date}</td>
                    </tr>`);
                });
            }
        },"json");
    });

    /* ================= NEW BUTTON ================= */
    $(".btn-new").click(function(){
        if(confirm("Start New LR Entry?")){
            $("#mainLRForm")[0].reset();
            $("#freightForm")[0].reset();
            $("#item_table tbody").empty();
            $("#invoice_table tr:gt(0)").remove();
            $.get("generate_lr_number.php",function(data){
                $("#main_lr_id").val(data);
            });
        }
    });

    /* ================= DELETE LR ================= */
    $(".btn-delete").click(function(){
        let lr=$("#main_lr_id").val();
        if(!lr){
            alert("Enter LR Number");
            return;
        }
        if(!confirm("Delete Complete LR ?")) return;
        $.post("delete_complete_lr.php",{lr_id:lr},function(res){
            if(res.trim()=="success"){
                alert("LR Deleted");
                location.reload();
            }else{
                alert(res);
            }
        });
    });

    /* ================= EDIT MODE ================= */
    $(".btn-edit").click(function(){
        $("#mainLRForm input,#mainLRForm select").prop("disabled",false);
        $("#freightForm input,#freightForm select").prop("disabled",false);
        alert("Edit Mode Enabled");
    });

});
</script>

<script>
/* ================= PRODUCT FUNCTIONS ================= */
function updateSerialNumbers(){
    $("#item_table tbody tr").each(function(i){
        $(this).find(".sno").html(i+1);
    });
}

function clearProductFields(){
    $("#product_dropdown,#unit_dropdown").val("");
    $("#description,#Qty,#actual_weight,#charge_wt,#rate,#amount,#length,#width,#height,#edit_product_id").val("");
    $(".btn-add").text("➕ Add Item");
}

function deleteRow(btn,id){
    if(confirm("Delete this item?")){
        $.post("delete_product.php",{id:id},function(res){
            if(res.trim()=="success"){
                $(btn).closest("tr").remove();
                updateSerialNumbers();
            }else{
                alert(res);
            }
        });
    }
}

function editRow(btn){
    let row=$(btn).closest("tr");
    $("#product_dropdown").val(row.find("td:eq(1)").text());
    $("#Qty").val(row.find("td:eq(2)").text());
    $("#actual_weight").val(row.find("td:eq(3)").text());
    $("#charge_wt").val(row.find("td:eq(4)").text());
    $("#unit_dropdown").val(row.find("td:eq(5)").text());
    $("#rate").val(row.find("td:eq(6)").text());
    $("#amount").val(row.find("td:eq(7)").text());
    $("#length").val(row.find("td:eq(8)").text());
    $("#width").val(row.find("td:eq(9)").text());
    $("#height").val(row.find("td:eq(10)").text());
    $("#edit_product_id").val($(btn).data("id"));
    $(btn).closest("tr").remove();
    $(".btn-add").text("💾 Update Item");
}



<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>

<script>
let addingProduct = false;

function addItem(){
    if(addingProduct){ return; }
    addingProduct = true;
    let current_lr = $("#main_lr_id").val();

    if(!current_lr){
        alert("Please enter LR Number first");
        addingProduct=false;
        return;
    }

    let dataObj = {
        lr_id: current_lr,
        product_name: $("#product_dropdown").val(),
        group_name: $("#group_name").val(),
        description: $("#description").val(),
        qty: $("#Qty").val(),
        actual_wt: $("#actual_weight").val(),
        charge_wt: $("#charge_wt").val(),
        unit: $("#unit_dropdown").val(),
        rate: $("#rate").val(),
        rate_type: $("#rate_type").val(),
        amount: $("#amount").val(),
        length: $("#length").val(),
        width: $("#width").val(),
        height: $("#height").val(),
        id: $("#edit_product_id").val()
    };

    if(!dataObj.product_name || !dataObj.qty){
        alert("Select product and enter qty");
        addingProduct=false;
        return;
    }

    $.ajax({
        url:"product_details.php",
        type:"POST",
        data:dataObj,
        success:function(res){
            let returned_id = res.trim();
            let rowHtml = `<tr>
            <td class="sno"></td>
            <td>${dataObj.product_name}</td>
            <td>${dataObj.qty}</td>
            <td>${dataObj.actual_wt}</td>
            <td>${dataObj.charge_wt}</td>
            <td>${dataObj.unit}</td>
            <td>${dataObj.rate}</td>
            <td>${dataObj.amount}</td>
            <td>${dataObj.length}</td>
            <td>${dataObj.width}</td>
            <td>${dataObj.height}</td>
            <td>
            <button type="button" onclick="editRow(this)" data-id="${returned_id}">✏</button>
            <button type="button" onclick="deleteRow(this,'${returned_id}')">❌</button>
            </td>
            </tr>`;
            $("#item_table tbody").append(rowHtml);
            updateSerialNumbers();
            clearProductFields();
            addingProduct=false;
        }
    });
}

function openProductModal(){ document.getElementById("frmproductmodal").classList.add("show"); }
function closeProductModal(){ document.getElementById("frmproductmodal").classList.remove("show"); }
function openUnitModal(){ document.getElementById("unitModal").classList.add("show"); }
function closeUnitModal(){ document.getElementById("unitModal").classList.remove("show"); }
</script>

<script>
/* ================= MODAL CONTROLS ================= */
function openCityModal(){ document.getElementById("frmcitymodal").classList.add("show"); }
function closeCityModal(){ document.getElementById("frmcitymodal").classList.remove("show"); }
function openVehicleModal(){ document.getElementById("frmvehiclemodal").classList.add("show"); }
function closeVehicleModal(){ document.getElementById("frmvehiclemodal").classList.remove("show"); }
function openPartyModal(){ document.getElementById("frmpartymodal").classList.add("show"); }
function closePartyModal(){ document.getElementById("frmpartymodal").classList.remove("show"); }
</script>

<script>
function printFromDropdown() {
    const lrId = document.getElementById('print_lr_dropdown').value;
    const copyType = document.getElementById('copy_type').value;
    if (!lrId) {
        alert("Please select an LR first.");
        return;
    }
    window.open(`bilty_print.php?lr_id=${lrId}&type=${copyType}`, '_blank');
}
</script>

<?php 
include 'frmcitymodal.php';
include 'frmvehiclecreation.php';
include 'frmpartymodal.php';
include 'frmproductmodal.php';
include 'frmunitmodal.php';
?>

<script>
/* freight amount calculation */
function calculateRow(element) {
    const table = element.closest('#product_entry_table');
    const qty = parseFloat(table.querySelector('[name="qty[]"]').value) || 0;
    const rate = parseFloat(table.querySelector('[name="rate[]"]').value) || 0;
    const rateType = table.querySelector('[name="rate_type[]"]').value;
    
    let rowTotal = 0;
    if (rateType === "Fixed") {
        rowTotal = rate; 
    } else {
        rowTotal = qty * rate; 
    }

    table.querySelector('[name="amount[]"]').value = rowTotal.toFixed(2);
    document.getElementById('freight').value = rowTotal.toFixed(2);
    
    if(document.getElementById('freight')) {
        document.getElementById('freight').value = rowTotal.toFixed(2);
    }
    calculateNetProfit();
}
</script>

<script>
/* profit calculation */      
function calculateNetProfit() {
    const freight = parseFloat(document.getElementById('freight').value) || 0;
    const gadiBhada = parseFloat(document.getElementById('gadi_bhada').value) || 0;
    const comm1 = parseFloat(document.getElementById('comm_1').value) || 0;
    const comm2 = parseFloat(document.getElementById('comm_2').value) || 0;

    const profit = freight - (gadiBhada + comm1 + comm2);
    const profitField = document.getElementById('net_profit');
    profitField.value = profit.toFixed(2);
    profitField.style.color = profit < 0 ? "red" : "green";
}
</script>

<script>
// logistics calculation script
function calculateLogistics() {
    const qty = parseFloat(document.getElementById('calc_qty').value) || 0;
    const rate = parseFloat(document.getElementById('calc_unit_rate').value) || 0;
    const totalFreight = qty * rate;
    document.getElementById('freight_amt').value = totalFreight;
    
    if(document.getElementById('freight')) {
        document.getElementById('freight').value = totalFreight;
    }

    const bhada = parseFloat(document.getElementById('gadi_bhada').value) || 0;
    const c1 = parseFloat(document.getElementById('comm_1').value) || 0;
    const c2 = parseFloat(document.getElementById('comm_2').value) || 0;

    const profit = totalFreight - (bhada + c1 + c2);
    document.getElementById('net_profit').value = profit.toFixed(2);
}

document.addEventListener('input', function(e) {
    if(['calc_qty', 'calc_unit_rate', 'gadi_bhada', 'comm_1', 'comm_2'].includes(e.target.id)) {
        calculateLogistics();
    }
});

calculateLogistics();
</script>

<script>
/* freight and gst details */
function calculateGrandTotal() {
    const freight = parseFloat(document.getElementById('freight').value) || 0;
    const hamali = parseFloat(document.querySelector('[name="hamali"]').value) || 0;
    const preBhadha = parseFloat(document.querySelector('[name="pre_bhadha"]').value) || 0;
    const biltyCharge = parseFloat(document.querySelector('[name="bilty_charge"]').value) || 0;
    const collection = parseFloat(document.querySelector('[name="collection_charges"]').value) || 0;
    const cpc = parseFloat(document.querySelector('[name="cpc"]').value) || 0;
    const otherCharge = parseFloat(document.querySelector('[name="other_charge"]').value) || 0;

    const total = freight + hamali + preBhadha + biltyCharge + collection + cpc + otherCharge;
    document.getElementById('total').value = total.toFixed(2);

    const applyGst = document.getElementById('apply_gst').value;
    let cgst = 0, sgst = 0, igst = 0;

    if (applyGst === "Yes") {
        cgst = total * 0.025; 
        sgst = total * 0.025; 
        igst = total * 0.05;  
    }

    document.getElementById('cgst').value = cgst.toFixed(2);
    document.getElementById('sgst').value = sgst.toFixed(2);
    document.getElementById('igst').value = igst.toFixed(2);

    const advance = parseFloat(document.getElementById('advance_amount').value) || 0;
    const finalAmount = (total + cgst + sgst) - advance; 
    document.getElementById('grand_total').value = finalAmount.toFixed(2);
}

document.addEventListener('input', function(e) {
    const idsToWatch = ['freight', 'advance_amount', 'apply_gst'];
    const namesToWatch = ['hamali', 'pre_bhadha', 'bilty_charge', 'collection_charges', 'cpc', 'other_charge'];

    if (idsToWatch.includes(e.target.id) || namesToWatch.includes(e.target.name)) {
        calculateGrandTotal();
    }
});

window.onload = calculateGrandTotal;
</script>

<script>
function sendWhatsAppLR() {
    // 1. Get values using the exact IDs from your toolbar HTML
    const lrId = document.getElementById('shared_lr_dropdown').value;
    const copyType = document.getElementById('copy_type').value;
    const phoneInput = document.getElementById('whatsapp_number');

    // 2. Initial validation
    if (!lrId) {
        alert("Please select an LR from the dropdown first.");
        return;
    }

    if (!phoneInput || !phoneInput.value) {
        alert("Please enter a phone number.");
        return;
    }

    // 3. Clean the phone number (removes spaces, +, and dashes)
    let phone = phoneInput.value.replace(/\D/g, '');

    // 4. Check length (Assuming 10 digits + country code)
    if (phone.length < 10) {
        alert("Please enter a valid WhatsApp number (including country code).");
        return;
    }

    // 5. Construct the message and URL
    // Using bilty_print.php as per your 'Print' button logic
    const printUrl = window.location.origin + "/bilty_print.php?lr_id=" + lrId + "&type=" + copyType;

    const message = `${printUrl}`;

    // 6. Generate the API link and redirect
    const whatsappLink = `https://api.whatsapp.com/send?phone=${phone}&text=${encodeURIComponent(message)}`;
    
    window.open(whatsappLink, '_blank');
}
</script>

</body>
</html>