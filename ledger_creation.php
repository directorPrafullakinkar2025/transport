<?php
require_once 'db.php';   // make sure this has $conn connection
require_once 'state_names.php';
require_once 'city_names.php';

if(isset($_POST['verify'])) {
    $gst = strtoupper(trim($_POST['gst_no']));

    // GST Regex Pattern
    $pattern = "/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/";

    if(preg_match($pattern, $gst)) {
        echo "<p style='color:green;'>Valid GST Format</p>";
    } else {
        echo "<p style='color:red;'>Invalid GST Number</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ledger Creation Module</title>
     <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/layout.css">
</head>

<body>

<div class="page-container">

    <h2>Ledger Creation Module</h2>
<form method="post" action="in_ledger_master.php">
                <div class="action-buttons">
                <button class="btn btn-new">➕ New</button>
                <button class="btn btn-save" type="submit">💾 Save</button>
                <button class="btn btn-update">🔄 Update</button>
             
                </div>


<div class="form-box">
  <div class="grid-2">

    <!-- ================= BASIC DETAILS ================= -->
    <div>
      <label>Ledger Group</label>
      <input type="text" name="ledger_group">
    </div>
<div>
  <label>GST No.</label>

  <input type="text"
         id="gst_no"
         name="gst_no"
         placeholder="Enter GST Number"
         class="uppercase"
         required>

  <div class="action-buttons">
    <button type="button"
            class="btn btn-verify"
            style="background-color: #2563eb;"
            onclick="verifyGST()">
      ✔ Verify
    </button>
  </div>

  <div id="result"></div>
</div>



      <!-- <input type="text" name="gst_no" placeholder="Enter GST No." class="uppercase">
    
        <button type="button" class="btn btn-verify" style="background-color: #2563eb;">✔ Verify</button>
     -->


    <div>
      <label>Search By</label>
      <select name="search_by">
        <option value="party_name">Party Name</option>
        <option value="party_alias">Party Alias</option>
      </select>
    </div>

    <div>
      <label>Party Name</label>
      <input type="text" name="party_name" placeholder="Enter Party Name">
    </div>

    <div>
      <label>Party Alias</label>
      <input type="text" name="party_alias" placeholder="Enter Party Alias Name">
    </div>

    <div>
      <label>Address (1)</label>
      <input type="text" name="address1" placeholder="Enter Address">
    </div>

    <div>
      <label>Address (2)</label>
      <input type="text" name="address2" placeholder="Enter Address">
    </div>

    <!-- ================= STATE / CITY ================= -->
    <div>
      <label>State Name *</label>
      <select name="state_name" id="state" required>
        <option value="">Select State Name</option>
        <?php foreach ($stateCities as $state => $cities): ?>
          <option value="<?= $state ?>"><?= $state ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label>City Name *</label>
      <select name="city_name" id="city" required>
        <option value="">Select City Name</option>
      </select>
    </div>

    <div>
      <label>PAN No.</label>
      <input type="text" name="pan_no">
    </div>

    <div>
      <label>IEC No.</label>
      <input type="text" name="iec_no">
    </div>

    <div>
      <label>Aadhar No.</label>
      <input type="text" name="aadhar_no">
    </div>

    <div>
      <label>R.C. No.</label>
      <input type="text" name="rc_no">
    </div>

    <div>
      <label>License No.</label>
      <input type="text" name="license_no">
    </div>

    <div>
      <label>Phone No.</label>
      <input type="text" name="phone_no">
    </div>

    <div>
      <label>Mobile No.</label>
      <input type="text" name="mobile_no">
    </div>

    <div>
      <label>E-Mail</label>
      <input type="email" name="email" placeholder="Enter E-Mail Address">
    </div>

    <div>
      <label>Opening Bal.</label>
      <input type="number" name="opening_balance" step="0.01" placeholder="Enter Opening Balance">
    </div>

    <div>
      <label>Opening Type</label>
      <select name="opening_type">
        <option value="DR">DR</option>
        <option value="CR">CR</option>
      </select>
    </div>

    <div>
      <label>ARN No.</label>
      <input type="text" name="arn_no">
    </div>

    <div>
      <label>Exim Code</label>
      <input type="text" name="exim_code">
    </div>

    <!-- ================= UPLOADS (optional – not stored yet) ================= -->
    <div class="full">
      <label>Documents Upload</label>
    </div>

    <div>
      <label>Pan Upload</label>
      <input type="file" name="pan_file">
    </div>

    <div>
      <label>Declaration Upload</label>
      <input type="file" name="declaration_file">
    </div>

    <div>
      <label>Aadhar Upload</label>
      <input type="file" name="aadhar_file">
    </div>

    <div>
      <label>GST Upload</label>
      <input type="file" name="gst_file">
    </div>

    <div>
      <label>Office Photo</label>
      <input type="file" name="office_photo">
    </div>

    <!-- ================= BANK DETAILS ================= -->
    <div class="full">
      <label>Broker Bank Details</label>
    </div>

    <div>
      <label>Bank Name</label>
      <input type="text" name="bank_name">
    </div>

    <div>
      <label>Account No.</label>
      <input type="text" name="account_no">
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
      <label>Party Type</label>
      <select name="party_type">
        <option value="">Select Party Type</option>
        <option value="Broker">Broker</option>
        <option value="Customer">Customer</option>
        <option value="Transporter">Transporter</option>
      </select>
    </div>

  </div>
</div>

            <br>
            <button type="submit" class="btn btn-search">🔍 Search</button>
            <button type="reset" class="btn btn-show">Search Party</button>

        </form>
    </div>

</div>
<script>
const stateCities = <?= json_encode($stateCities) ?>;
</script>
<script src="../js/city_dropdown.js"></script>

<script>
function verifyGST() {

    let gst = document.getElementById("gst_no").value;

    if(gst === "") {
        document.getElementById("result").innerHTML =
            "<span style='color:red;'>Please enter GST Number</span>";
        return;
    }

    fetch("verify_gst.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "gst_no=" + encodeURIComponent(gst)
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("result").innerHTML = data;
    });
}
</script>

</body>
</html>
