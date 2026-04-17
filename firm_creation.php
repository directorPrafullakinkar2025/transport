
<?php require_once 'db.php'; 
require_once  'state_names.php';
require_once  'city_names.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Firm Creation</title>
<style>
/* ===== BASE LAYOUT ===== */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f7f6;
}

.page-container {
    margin-left: 240px; /* Sidebar width */
    padding: 20px;
    transition: 0.3s;
    min-height: 100vh;
}

h2 {
    color: #333;
    border-bottom: 2px solid #ccc;
    padding-bottom: 10px;
}

/* ===== FORM GRID STRUCTURE ===== */
.form-box {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Default 2 columns */
    gap: 15px 25px; /* Vertical and Horizontal gap */
}

.grid-2 div {
    display: flex;
    flex-direction: column;
}

.grid-2 label {
    font-weight: bold;
    font-size: 13px;
    margin-bottom: 5px;
    color: #555;
}

.grid-2 input,
.grid-2 select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 14px;
}

/* ===== BUTTONS ===== */
.action-buttons {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.btn {
    padding: 10px 16px;
    font-size: 14px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    font-weight: bold;
    transition: background 0.2s;
}

.btn-new { background: #28a745; color: white; }
.btn-save { background: #007bff; color: white; }
.btn-update { background: #17a2b8; color: white; }
.btn-show { background: #6c757d; color: white; }

/* ===== TABLE & UPLOAD ===== */
.table-box {
    width: 100%;
    overflow-x: auto; /* Enables horizontal scroll for mobile */
    background: white;
    border-radius: 8px;
}

.table-box table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px; /* Ensures table doesn't squish too much */
}

.table-box th, .table-box td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
    font-size: 13px;
}

.table-box th { background-color: #f8f9fa; }

.upload-box {
    border: 2px dashed #bbb;
    padding: 15px;
    text-align: center;
    background: #fafafa;
    border-radius: 5px;
}

/* ================= RESPONSIVE MEDIA QUERIES ================= */

/* Tablets (up to 992px) */
@media (max-width: 992px) {
    .page-container {
        margin-left: 0; /* Sidebar usually collapses to hamburger here */
        padding: 15px;
    }
}

/* Mobile Devices (up to 768px) */
@media (max-width: 768px) {
    .grid-2 {
        grid-template-columns: 1fr; /* Stack inputs vertically */
        gap: 10px;
    }

    .action-buttons {
        flex-direction: row;
        justify-content: space-between;
    }

    .btn {
        flex: 1 1 45%; /* Buttons take half width on small screens */
        text-align: center;
    }

    .table-box th, .table-box td {
        font-size: 12px;
        padding: 8px;
    }
}

/* Very Small Devices (Phones up to 480px) */
@media (max-width: 480px) {
    .btn {
        flex: 1 1 100%; /* Buttons stack full width */
    }

    .form-box {
        padding: 10px;
    }

    h2 {
        font-size: 1.2rem;
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

