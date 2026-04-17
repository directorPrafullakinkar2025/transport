
<?php require_once 'db.php'; 
require_once  'state_names.php';
require_once  'city_names.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Firm Creation</title>
<style>
 /* ================= GLOBAL RESET ================= */
* {
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    margin: 0;
    background: #f2f5ff;
}
.form-box,
.table-box {
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
}
/* ================= FIXED TOPBAR ================= */
.topbar {
    height: 55px;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
}

/* ================= FIXED SIDEBAR ================= */
.sidebar {
    width: 240px;
    position: fixed;
    top: 55px;
    left: 0;
    bottom: 0;
    overflow-y: auto;
    z-index: 900;
    transition: left 0.3s ease;
}

/* ================= PAGE CONTENT ================= */
.page-container {
    margin-left: 240px;              /* SAME as sidebar width */
    margin-top: 55px;
    padding: 20px;
    width: calc(100% - 240px);       /* SAME as sidebar width */
    min-height: calc(100vh - 55px);
    background: #f2f5ff;
    transition: margin-left 0.3s ease;
}

/* ================= MAIN TITLE ================= */
.main h2 {
    margin: 0 0 15px;
    font-size: 20px;
    font-weight: bold;
}

/* ================= FORM BOX ================= */
.form-box {
    background: #fff;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 15px;
}

/* ================= DEFAULT GRID (4 COLUMN) ================= */
.grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}

/* ================= TWO COLUMN GRID (FOR FIRM CREATION) ================= */
.grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px 18px;
}

/* Full width field (Address etc.) */
.grid-2 .full {
    grid-column: span 2;
}

/* ================= FORM HEAD ================= */
.form-box h4 {
    margin: 0 0 12px;
    font-size: 13px;
    font-weight: bold;
    color: #fff;
    background: #e74c3c;
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
}

/* ================= INPUT ================= */
label {
    font-size: 13px;
    font-weight: bold;
    display: block;
    margin-bottom: 4px;
}

input,
select,
textarea {
    width: 100%;
    padding: 7px;
    font-size: 12px;
    border: 1px solid #cfd6e4;
    border-radius: 3px;
}

/* ================= TEXTBOX CURSOR (CARET) ================= */
input,
select,
textarea {
    caret-color: #2563eb;
    transition: border-color 0.2s ease, background-color 0.2s ease;
}

/* ================= ON FOCUS ================= */
input:focus,
select:focus,
textarea:focus {
    outline: 2px solid #22c55e;
    border-color: #22c55e;
    background-color: #f0fdf4;
    caret-color: #16a34a;
}


/* ================= LOST FOCUS ================= */
input:not(:focus),
select:not(:focus),
textarea:not(:focus) {
    border-color: #cfd6e4;
    background-color: #ffffff;
    caret-color: #2563eb;
}

/* ================= SEARCH ================= */
.search-row {
    margin-bottom: 10px;
}

.search-inline {
    display: flex;
    gap: 8px;
    align-items: center;
}

.search-inline input {
    width: 250px;
    max-width: 250px;
    padding: 8px;
}

/* ================= BUTTONS ================= */
button {
    padding: 9px 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
    transition: background-color 0.2s ease, transform 0.1s ease, box-shadow 0.1s ease;
}

button:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

button:active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(0,0,0,0.15);
}

/* Action Buttons */
.page-actions,
.action-buttons {
    display: flex;
    gap: 8px;
    align-items: center;
    margin-bottom: 12px;
}

.btn-new     { background:#2563eb; } /* Blue */
.btn-edit    { background:#8cda8c; }  /* comment says Orange */
.btn-delete  { background:#cab4ec; }  /* comment says Red */
.btn-show    { background:#0f766e; } /* Dark Teal */
.btn-print   { background:#15803d; } /* Green */
.btn-mail    { background:#facc15; color:#000; } /* Yellow */
.btn-search  { background:#1d4ed8; } /* Dark Blue */
.btn-save    { background:#16a34a; } /* Green */
.btn-update  { background:#7c3aed; } /* Purple */
.btn-verify  { background:#2563eb; } /* Blue */
/* ================= STRONG ACTION BUTTONS ================= */
.btn-save,
.btn-update,
.btn-new,
.btn-delete,
.btn-edit {
    opacity: 1 !important;
    filter: none !important;
    box-shadow: 0 4px 10px rgba(0,0,0,0.25);
}

/* ================= TABLE ================= */


.table-box {
    background: #fff;
    padding: 15px;
    border-radius: 5px;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #eee;
    padding: 8px;
    font-size: 12px;
    white-space: nowrap;
}

td {
    padding: 7px;
    font-size: 12px;
    border-bottom: 1px solid #ddd;
    white-space: nowrap;
}

/* Table inside form */
.form-box table th,
.form-box table td {
    border: 1px solid #ddd;
    padding: 6px;
    font-size: 11px;
}

.form-box table input,
.form-box table select {
    font-size: 11px;
    padding: 4px;
}

/* ================= FOOTER ================= */
.footer {
    margin-top: 15px;
    font-size: 11px;
    color: #666;
    text-align: center;
}
/* ================= upload section css ================= */
.upload-box {
    border: 2px dashed #aaa;
    padding: 15px;
    text-align: center;
    cursor: pointer;
    background: #fafafa;
    position: relative;
}

.upload-box:hover {
    border-color: #f68b1f;
}

.upload-box input {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}
/* ================= RESPONSIVE ================= */
@media (max-width: 1200px) {
    .grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .grid,
    .grid-2 {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 992px) {
    .sidebar {
        left: -240px;
    }
    .page-container {
        margin-left: 0;
        width: 100%;
    }
}
@media (max-width: 480px) {
    .search-inline {
        flex-direction: column;
        align-items: stretch;
    }
    .search-inline input {
        width: 100%;
        max-width: 100%;
    }
}        
</style>
</head>
<body>
<?php include 'sidebar.php' ?>
<h2>Firm Creation Module</h2>

<div class="action-buttons">
  <button type="button" class="btn btn-new" onclick="showFirmInput()">➕ New</button>
  <button class="btn btn-save">💾 Save</button>
  <button class="btn btn-update">🔄 Update</button>
<!-- following code is for show button , change into dropdown Firm Field -->
<button class="btn btn-show" onclick="showFirmDropdown()">👁 Show</button>
</div>

<!-- ================= FORM ================= -->
<div class="form-box">
<form method="post" action="in_firms.php" enctype="multipart/form-data">

<!-- convert texbox to dropdown for firm name search -->
<div class="grid-2">
<div id="firm-field">
    <label>Firm *</label>
    <input type="text" name="firm_name" required>
</div>
<!-- ----end -->


<div>
<label>Alias</label>
<input type="text" name="alias">
</div>

<div>
<label>Unit</label>
<input type="text" name="unit">
</div>

<div>
<label>Financial *</label>
<input type="text" name="financial_year" value="2024-2025">
</div>

<div>
<label>Address (1)</label>
<input type="text" name="address1">
</div>

<div>
<label>Address (2)</label>
<input type="text" name="address2">
</div>

<div>
<label>State Name *</label>
<select name="state" id="state" required>
  <option value="">Select State Name</option>
  <?php foreach ($stateCities as $state => $cities): ?>
    <option value="<?= $state ?>"><?= $state ?></option>
  <?php endforeach; ?>
</select>
</div>

<div>
<label>City Name *</label>
<select name="city" id="city" required>
  <option value="">Select City Name</option>
</select>
</div>

<div>
<label>Phone No.</label>
<input type="text" name="phone">
</div>

<div>
<label>Mobile No.</label>
<input type="text" name="mobile" placeholder="Enter Mobile No.">
</div>

<div>
<label>Website</label>
<input type="text" name="website" placeholder="Enter Your Website">
</div>

<div>
<label>GST No.</label>
<input type="text" name="gst_no">
</div>

<div>
<label>PAN No.</label>
<input type="text" name="pan_no">
</div>

<div>
<label>E-Mail</label>
<input type="email" name="email">
</div>

<div>
<label>Mailing ID</label>
<input type="email" name="mailing_id">
</div>

<div>
<label>Email Password</label>
<input type="password" name="email_password">
</div>

<div>
<label>CIN No.</label>
<input type="text" name="cin_number">
</div>

<div>
<label>MSME No</label>
<input type="text" name="mesme_number">
</div>

<div>
<label>Start Date</label>
<input type="date" value="2025-12-27">
</div>

<div>
<label>End Date</label>
<input type="date" value="2025-12-27">
</div>

<div>
<label>CGST %</label>
<input type="number">
</div>

<div>
<label>SGST %</label>
<input type="number">
</div>

<div>
<label>IGST %</label>
<input type="number">
</div>

<div>
<label>Bank Name</label>
<select>
  <option>Select Bank Name</option>
</select>
</div>

<div>
<label>Account No.</label>
<input type="text" name="account_number">
</div>

<div>
<label>Branch Name</label>
<input type="text" name="branch_name">
</div>

<div>
<label>IFSC Code</label>
<input type="text" name="ifsc_code">
</div>

<div>
<label>Jurisdiction</label>
<input type="text" name="jurisdiction">
</div>

<!-- LOGO -->
<div>
<label>Logo Upload</label>
<div class="upload-box" id="logoBox">
    Drag & Drop Logo or Click
    <input type="file" name="logo" id="logoInput" accept="image/*">
</div>
<img id="logoPreview" style="display:none; width:80px; margin-top:10px;">
</div>

<!-- SEAL -->
<div>
<label>Seal Upload</label>
<div class="upload-box" id="sealBox">
    Drag & Drop Seal or Click
    <input type="file" name="seal" id="sealInput" accept="image/*">
</div>
<img id="sealPreview" style="display:none; width:80px; margin-top:10px;">
</div>

<div>
<label>Is Finish</label>
<select>
  <option>No</option>
  <option>Yes</option>
</select>
</div>

</div>

<br>
<button type="submit" name="save_firm" style="background:blue; color:white;">Submit</button>
<button type="reset" style="background:blue; color:white;">Search</button>

</form>
</div>

<!-- ================= TABLE ================= -->
<div class="table-box">
<table>
<tr>
<th>S.No.</th>
<th>Firm Name</th>
<th>Phone</th>
<th>City</th>
<th>State</th>
<th>Address</th>
<th>Edit / Delete</th>
</tr>

<?php 
$firms = [];   // must be filled from DB
$i = 1;

foreach ($firms as $firm): ?>
<tr>
    <td><?= $i++ ?></td>
    <td>
        <b><?= htmlspecialchars($firm['name']) ?></b><br>
        <span class="small">
            Financial Year - <?= htmlspecialchars($firm['year']) ?>
        </span>
    </td>
    <td><?= htmlspecialchars($firm['phone']) ?></td>
    <td><?= htmlspecialchars($firm['city']) ?></td>
    <td><?= htmlspecialchars($firm['state']) ?></td>
    <td><?= htmlspecialchars($firm['address']) ?></td>
    <td class="actions">
        <button type="button">Select</button>
        <button type="button">Edit</button>
    </td>
</tr>
<?php endforeach; ?>


</table>
</div>
</div>
<script>
function handleFile(input, previewId) {
    const file = input.files[0];

    if (!file) return;

    // ✅ Size validation (2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert("File must be less than 2MB");
        input.value = "";
        return;
    }

    // ✅ Preview
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById(previewId);
        preview.src = e.target.result;
        preview.style.display = "block";
    };
    reader.readAsDataURL(file);
}

// Logo
document.getElementById("logoInput").addEventListener("change", function() {
    handleFile(this, "logoPreview");
});

// Seal
document.getElementById("sealInput").addEventListener("change", function() {
    handleFile(this, "sealPreview");
});
</script>
<script>
const stateCities = <?= json_encode($stateCities) ?>;
</script>

<script src="js/city_dropdown.js"></script>

<script src="conn/show/js/firm_name.js"></script>
</body>
</html>

