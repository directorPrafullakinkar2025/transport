<?php

session_start();
require_once 'db.php';
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}
$firmName = $_SESSION['firm_name'] ?? "No Firm Selected";
// Cache disable
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");



if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all firms
$sql = "SELECT firm_id, firm_name, alias, address1, address2, financial_year, city FROM firms";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Firm Selection</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #fff;
}

/* TOP HEADER */
.top-title {
    text-align: center;
    color: red;
    font-weight: bold;
    padding: 15px;
}

.header-bar {
    display: grid;
    grid-template-columns: 1fr 2fr 1fr;
    border-top: 1px solid #000;
    border-bottom: 1px solid #000;
    align-items: center;
}

.header-box {
    padding: 15px;
    border-right: 1px solid #000;
}

.header-box:last-child {
    border-right: none;
}

.center-text {
    text-align: center;
    color: red;
    font-weight: bold;
}

.right-text {
    text-align: right;
    color: red;
    font-weight: bold;
}

.signout {
    font-size: 12px;
    color: blue;
    text-decoration: underline;
    cursor: pointer;
}

/* TABLE */
.table-container {
    padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: #00d6b4;
    color: #003b3b;
}

th, td {
    padding: 10px;
    font-size: 14px;
    text-align: left;
}

tbody tr:nth-child(even) {
    background: #eef0ff;
}

.select-btn {
    font-size: 18px;
    cursor: pointer;
    color: green;
}
</style>
</head>

<body>

<div class="top-title">Transport Software Training Video</div>

<div class="header-bar">
    <div class="header-box">
        <img src="logo.png" alt="Logo" width="60">
    </div>

    <div class="header-box center-text">
        Please Select Firm / Branch
    </div>

    <div class="header-box right-text">
        User - <span id="userName">No Firm Selected</span><br>
       <a href="logout.php" class="signout">SIGN OUT</a>
    </div>
</div>

<div class="table-container">
<table>
    <thead>
        <tr>
            <th>S.No.</th>
            <th>Firm Name</th>
            <th>Firm Short</th>
            <th>Address</th>
            <th>Financial Year</th>
            <th>City</th>
            <th>Select</th>
        </tr>
    </thead>
        <tbody>
        <?php while($firm = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $firm['firm_id'] ?></td>
            <td><?= htmlspecialchars($firm['firm_name']) ?></td>
            <td><?= htmlspecialchars($firm['alias']) ?></td>
            <td><?= htmlspecialchars($firm['address1']) ?></td>
            <td><?= htmlspecialchars($firm['address2']) ?></td>
            <td><?= htmlspecialchars($firm['financial_year']) ?></td>
            <td><?= htmlspecialchars($firm['city']) ?></td>
            <td>
                
    <form method="post" action="set_firm.php">
        <input type="hidden" name="firm_name" value="<?= htmlspecialchars($firm['firm_name']) ?>">
        <button type="submit" class="select-btn">☝️ Select</button>
    </form>
</td>



            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>
<script>
// Select all buttons
const buttons = document.querySelectorAll('.select-btn');
const userNameSpan = document.getElementById('userName');

// Update header when a button is clicked
buttons.forEach(btn => {
    btn.addEventListener('click', () => {
        const firmName = btn.getAttribute('data-name');
        userNameSpan.textContent = firmName;
    });
});
</script>

</body>
</html>
