<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
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

require_once 'sidebar.php';

/* =========================================================
   3. FETCH CITY DATA
   ========================================================= */
$cityList = mysqli_query($conn, "SELECT * FROM city_master ORDER BY city_name ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Booking Entry</title>
    <!-- <link rel="stylesheet" href="/assets/css/layout.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        body{ margin:0; font-family: Arial, Helvetica, sans-serif; background:#eef1f7; }
        .page-container{ width:100%; }
        .action-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
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
    </style> 
</head>
<body>

<div class="page-container">
    <h2>Booking Entry</h2>

  User - <span><?= htmlspecialchars($firmName) ?></span>
    <div class="action-buttons">
        <button class="btn btn-new">New</button>
        <button class="btn btn-edit">Edit</button>
        <button class="btn btn-delete">Delete</button>

        <!-- whatsapp button -->
</div>

<form method="POST" action="save_lr.php" id="mainLRForm">

<input type="hidden" name="firm_id" value="<?php echo $_SESSION['firm_id'] ?? ''; ?>">
        <div class="form-box">
            <h4>LR Details</h4>
            <div class="grid">
                <div><label>LR No.</label><input type="text" name="lr_id" id="main_lr_id" readonly></div>
                <div><label>LR Date</label><input type="date" name="lr_date"></div>
                <div><label>Ref LR No.</label><input name="ref_lr_no" placeholder="Enter Ref LR No"></div>
                <div><label>P.M.</label><input name="pm" placeholder="Enter PM"></div>
                
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
                    <td><input id="Qty" name="qty[]"></td>
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
                    <td><input id="rate" name="rate[]"></td>
                    <td><select id="rate_type" name="rate_type[]"><option>Per Kg</option><option>Per Bag</option><option>Per Box</option><option>Fixed</option></select></td>
                    <td><input id="amount" name="amount[]"></td>
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
                <div><label>Freight</label><input name="freight" id="freight" value="0"></div>
                <div><label>Hamali</label><input name="hamali" value="0"></div>
                <div><label>Pre. Bhadha</label><input name="pre_bhadha" value="0"></div>
                <div><label>Bilty Charge</label><input name="bilty_charge" value="0"></div>
                <div><label>Colle. Charges</label><input name="collection_charges" value="0"></div>
                <div><label>C.P.C.</label><input name="cpc" value="0"></div>
                <div><label>Other Charge</label><input name="other_charge" value="0"></div>
                <div><label>Total</label><input name="total" id="total" value="0" readonly></div>
                <div>
                    <label>Apply GST</label>
                    <select name="apply_gst" id="apply_gst">
                        <option value="No">No</option>
                        <option value="Yes">Yes</option>
                    </select>
                </div>
                <div><label>CGST (2.5%)</label><input name="cgst" id="cgst" value="0" readonly></div>
                <div><label>SGST (2.5%)</label><input name="sgst" id="sgst" value="0" readonly></div>
                <div><label>IGST (5%)</label><input name="igst" id="igst" value="0" readonly></div>
                <div><label>Advance</label><input name="advance_amount" id="advance_amount" value="0"></div>
                <div><label>Grand Total</label><input name="grand_total" id="grand_total" value="0" readonly></div>
                <div><label>URL Name</label><input name="url_name"></div>
                <div><label>Print Type</label><select name="print_type"><option value="A4">A4</option><option value="A5">A5</option></select></div>
            </div>

<div class="bottom-toolbar">

    <!-- LEFT SIDE -->
    <div class="toolbar-left">

        <button type="submit" class="btn save-btn">💾 Save</button>

        <button type="button" class="btn print-btn"
            onclick="printReport($('#main_lr_id').val())">
            🖨 Print Current
        </button>

        <!-- DROPDOWN -->
<select id="print_lr_dropdown" class="toolbar-select" onchange="goToPrint(this.value)">
    <option value="">Search LR...</option>
    <?php
    $lrList = mysqli_query($conn,"
        SELECT lr_id, lr_date 
        FROM lr_entry
        ORDER BY lr_id DESC
    ");
    while($row = mysqli_fetch_assoc($lrList)){
        echo "<option value='".$row['lr_id']."'>
                ".$row['lr_id']." | ".$row['lr_date']."
              </option>";
    }
    ?>
</select>

        <button type="button" class="btn btn-print" onclick="printFromDropdown()">
            Print Selected
        </button>

        <!-- SEARCH BOX -->
        <!-- <div class="lr-select-box">
            <input type="text" id="lr_search" placeholder="🔍 LR No">
            <button type="button" onclick="printByInput()">Go</button>
        </div> -->

    </div>
    <select id="copy_type" class="toolbar-select">
    <option value="consignor">Consignor Copy</option>
    <option value="consignee">Consignee Copy</option>
    <option value="driver">Driver Copy</option>
    <option value="office">Office Copy</option>
</select>
<div class="whatsapp-container" style="margin-left:10px;">
    <button type="button" onclick="sendWhatsAppLR()" 
        style="background-color:#25D366;color:#fff;border:none;padding:6px 14px;border-radius:4px;cursor:pointer;">
        📲 WhatsApp
    </button>
</div>
    <!-- RIGHT SIDE -->
    <div class="toolbar-right">
        <button type="button" onclick="window.location='all_report.php'" class="btn btn-show">🏠 Dashboard</button>
        <button type="button" class="btn link-btn">🔗 Link</button>
        <button type="button" onclick="window.location='bilty_print1.php'" class="btn btn-show">📄 Bilty</button>
    </div>

</div>
</div>
        </form>
    </div>

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
    </div> -->
    </div>
<script>
function goToPrint(lr_id) {
    if (lr_id !== "") {
        window.location.href = "bilty_print1.php?lr_id=" + lr_id;
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

if(isSaving){
return;
}

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

/* ajax save */

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

/* ================= PRINT ================= */

function printReport(lrNumber){

if(!lrNumber){
alert("Invalid LR Number");
return;
}

$.post("set_print_session.php",{lr_no:lrNumber},function(res){

if(res.trim()=="success"){
window.open("print.php","_blank");
}

});

}

</script>
<!--stop change lr no on refresh page-->
<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>
<!-- // PRODUCT ITEM FUNCTIONS -->
<script>
let addingProduct = false;

function addItem(){

if(addingProduct){
return;
}

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
function updateSerialNumbers() {
    $("#item_table tbody tr").each(function(index) {
        $(this).find(".sno").html(index + 1);
    });
}

function clearProductFields(){
    $("#product_dropdown, #unit_dropdown").val("");
    $("#description, #Qty, #actual_weight, #charge_wt, #rate, #amount, #length, #width, #height, #edit_product_id").val("");
    $(".btn-add").text("➕ Add Item");
}

function deleteRow(btn,id){

if(confirm("Delete this item?")){

$.ajax({

url:"delete_product.php",
type:"POST",
data:{id:id},

success:function(res){

if(res.trim()=="success"){

$(btn).closest("tr").remove();
updateSerialNumbers();

}else{

alert("Delete Failed : " + res);

}

}

});

}

}

function editRow(btn){
    let row = $(btn).closest("tr");
    $("#product_dropdown").val(row.find("td:eq(1)").text());
    $("#Qty").val(row.find("td:eq(2)").text());
    $("#description").val(row.find("td:eq(3)").text());
    $("#actual_weight").val(row.find("td:eq(4)").text());
    $("#charge_wt").val(row.find("td:eq(5)").text());
    $("#unit_dropdown").val(row.find("td:eq(6)").text());
    $("#rate").val(row.find("td:eq(7)").text());
    $("#amount").val(row.find("td:eq(8)").text());
    $("#length").val(row.find("td:eq(9)").text());
    $("#width").val(row.find("td:eq(10)").text());
    $("#height").val(row.find("td:eq(11)").text());
    $("#edit_product_id").val($(btn).data("id"));
    $(btn).closest("tr").remove();
    $(".btn-add").text("💾 Update Item");
}

function openProductModal(){ document.getElementById("frmproductmodal").classList.add("show"); }
function closeProductModal(){ document.getElementById("frmproductmodal").classList.remove("show"); }
function openUnitModal(){ document.getElementById("unitModal").classList.add("show"); }
function closeUnitModal(){ document.getElementById("unitModal").classList.remove("show"); }
</script>
<script>

/* ================= MODAL CONTROLS ================= */

// PRODUCT
function openProductModal(){
    document.getElementById("frmproductmodal").classList.add("show");
}
function closeProductModal(){
    document.getElementById("frmproductmodal").classList.remove("show");
}

// UNIT
function openUnitModal(){
    document.getElementById("frmunitmodal").classList.add("show");
}
function closeUnitModal(){
    document.getElementById("frmunitmodal").classList.remove("show");
}

// CITY
function openCityModal(){
    document.getElementById("frmcitymodal").classList.add("show");
}
function closeCityModal(){
    document.getElementById("frmcitymodal").classList.remove("show");
}

// VEHICLE
function openVehicleModal(){
    document.getElementById("frmvehiclemodal").classList.add("show");
}
function closeVehicleModal(){
    document.getElementById("frmvehiclemodal").classList.remove("show");
}

// PARTY
function openPartyModal(){
    document.getElementById("frmpartymodal").classList.add("show");
}
function closePartyModal(){
    document.getElementById("frmpartymodal").classList.remove("show");
}

</script>
<script>
function printFromDropdown(){

let lr = $("#print_lr_dropdown").val();

if(!lr){
alert("Select LR Number");
return;
}

$.post("set_print_session.php",{lr_no:lr},function(res){

if(res.trim()=="success"){
window.open("bilty_print1.php","_blank");
}else{
alert("Invalid LR Number");
}

});

}
</script>
<!-- SEND WHATSAPP COPY SEPERATETLY -->
 <script>
function sendWhatsAppLR() {

    let lrNo = document.getElementById("lr_search").value || 
               document.getElementById("print_lr_dropdown").value;

    let copyType = document.getElementById("copy_type").value;

    if (!lrNo) {
        alert("Please enter or select LR No");
        return;
    }

    // Generate print URL (your existing print page)
    let printUrl = "bilty_print1.php?lr_id=" + lrNo + "&copy=" + copyType;

    // Message
    let message = "LR No: " + lrNo + "%0A" +
                  "Copy: " + copyType + "%0A" +
                  "Download/Print: " + window.location.origin + "/" + printUrl;

    // WhatsApp open
    let mobile = "<?php echo $whatsapp_mobile; ?>";

    let waUrl = "https://wa.me/" + mobile + "?text=" + message;

    window.open(waUrl, "_blank");
}
</script>
<!-- modal files attachment -->
<?php 
include 'frmcitymodal.php';
include 'frmvehiclecreation.php';
include 'frmpartymodal.php';
include 'frmproductmodal.php';
include 'frmunitmodal.php';
?>
</body>
</html>