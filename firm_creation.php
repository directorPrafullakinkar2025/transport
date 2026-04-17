
<?php require_once 'db.php'; 
include_once "sidebar.php";
require_once  'state_names.php';
require_once  'city_names.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Firm Creation</title>
<link rel="stylesheet" href="css/layout.css">
</head>
<body>

<div class="page-container" style="margin-left: 240px;">

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

