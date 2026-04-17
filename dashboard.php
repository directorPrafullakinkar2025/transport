<?php
session_start();

// Check login
if (!isset($_SESSION['logged_in'])) {
    header("Location: index.php");
    exit();
}

$firmName = $_SESSION['firm_name'] ?? "No Firm Selected";

// Prevent cache
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Broker Slip Status</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    .header-box {
    padding: 15px;
    border-right: 1px solid #000;
}
.signout {
    font-size: 12px;
    color: blue;
    text-decoration: underline;
    cursor: pointer;
}
</style>
</head>

<body>

<div class="page-container">
   <div class="header-box right-text">
        User - <span id="userName">No Firm Selected</span><br>
       <a href="logout.php" class="signout">SIGN OUT</a>
    </div>
    User - <span><?= htmlspecialchars($firmName) ?></span>
<!-- ================= MAIN ================= -->
<div class="main">

    <div class="title">Transport Software Training Video</div>

    <div class="tiles">
        <div class="tile"><div class="icon blue">★</div><div class="tile-text">BOOKING</div></div>
        <div class="tile"><div class="icon green">⚑</div><div class="tile-text">LOADING CHALLAN</div></div>
        <div class="tile"><div class="icon gray">⚑</div><div class="tile-text">FREIGHT CHALLAN</div></div>
        <div class="tile"><div class="icon orange">⬇</div><div class="tile-text">CHALLAN PAYMENT</div></div>

        <div class="tile"><div class="icon orange">⚑</div><div class="tile-text">BROKER ENTRY PARTY</div></div>
        <div class="tile"><div class="icon gray">★</div><div class="tile-text">BROKER BILL</div></div>
        <div class="tile"><div class="icon yellow">★</div><div class="tile-text">RECEIPT</div></div>
        <div class="tile"><div class="icon orange">★</div><div class="tile-text">PENDING RECEIPT</div></div>

        <div class="tile"><div class="icon purple">⚑</div><div class="tile-text">BROKER ENTRY BROKER</div></div>
        <div class="tile"><div class="icon orange">⬇</div><div class="tile-text">PAYMENT</div></div>
        <div class="tile"><div class="icon gray"></div><div class="tile-text">BILL (PART TRUCK)</div></div>
        <div class="tile"><div class="icon gray"></div><div class="tile-text">BILL (FULL TRUCK)</div></div>
    </div>

    <!-- ================= REMINDERS ================= -->
    <div class="reminders">
        <div class="reminder-grid">

            <div>
                <h4>EWay Bill Extension Reminder</h4>
                <table>
                    <tr>
                        <th>S.No.</th>
                        <th>Bilty No</th>
                        <th>Bilty Date</th>
                        <th>EW Bill No</th>
                        <th>Expiry Date</th>
                    </tr>
                </table>
            </div>

            <div>
                <h4>RTO Paper (Renewal Reminder)</h4>
                <table>
                    <tr>
                        <th>S.No.</th>
                        <th>Document</th>
                        <th>Vehicle No</th>
                        <th>Company</th>
                        <th>Expiry Date</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- ================= END MAIN ================= -->
</div>
<div class="profit-grid">
    <div class="profit-card">
        <small>Total Revenue</small>
        <h2 class="revenue-text">₹ <?= number_format($revenue ?? 0, 2) ?></h2>
    </div>
    <div class="profit-card">
        <small>Total Net Profit</small>
        <h2 class="profit-text">₹ <?= number_format($profit ?? 0, 2) ?></h2>
    </div>
</div>
</body>
</html>