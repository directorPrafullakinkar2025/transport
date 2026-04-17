<?php
require_once "db.php";

$today = date("Y-m-d");
$thisMonth = date("Y-m");
$thisYear = date("Y");

// --- TODAY'S STATS ---
$sqlToday = "SELECT 
    COUNT(lr_id) as trips, 
    SUM(revenue_amount) as freight, 
    SUM(net_profit) as profit 
    FROM logistics_profit_analysis 
    WHERE lr_id IN (SELECT lr_id FROM lr_entry WHERE DATE(lr_date) = '$today')";
$resToday = mysqli_fetch_assoc(mysqli_query($conn, $sqlToday));

// --- MONTHLY STATS ---
$sqlMonth = "SELECT 
    SUM(revenue_amount) as m_freight, 
    SUM(net_profit) as m_profit 
    FROM logistics_profit_analysis 
    WHERE lr_id IN (SELECT lr_id FROM lr_entry WHERE DATE_FORMAT(lr_date, '%Y-%m') = '$thisMonth')";
$resMonth = mysqli_fetch_assoc(mysqli_query($conn, $sqlMonth));

// --- YEARLY STATS ---
$sqlYear = "SELECT 
    SUM(net_profit) as y_profit 
    FROM logistics_profit_analysis 
    WHERE lr_id IN (SELECT lr_id FROM lr_entry WHERE YEAR(lr_date) = '$thisYear')";
$resYear = mysqli_fetch_assoc(mysqli_query($conn, $sqlYear));

// --- TOP VEHICLE (Remains same) ---
$sqlVehicle = "SELECT v.vehicle_number, COUNT(l.lr_id) as trips
    FROM lr_entry l
    LEFT JOIN vehicle_master v ON l.vehicle_no = v.vehicle_id
    GROUP BY v.vehicle_number ORDER BY trips DESC LIMIT 1";
$dataVehicle = mysqli_fetch_assoc(mysqli_query($conn, $sqlVehicle));
// We fetch the data. If the profit table is empty, we use COALESCE to show 0 instead of NULL.
// Use this exact query
$query = "SELECT 
            COALESCE(SUM(revenue_amount), 0) as total_rev, 
            COALESCE(SUM(gadi_bhada), 0) as total_bhada, 
            COALESCE(SUM(agent_comm_1), 0) as total_comm1, 
            COALESCE(SUM(agent_comm_2), 0) as total_comm2,
            COALESCE(SUM(net_profit), 0) as total_profit
          FROM  logistics_profit_analysis"; 

$result = mysqli_query($conn, $query);

// Safety Check: If this still fails, your table name or column names are likely wrong
if (!$result) {
    echo "<div style='color:red; background:white; padding:10px;'>";
    echo "<strong>Database Error:</strong> " . mysqli_error($conn);
    echo "</div>";
    // Define variables as 0 so the page doesn't crash
    $revenue = 0; $expenses = 0; $profit = 0;
} else {
    $data = mysqli_fetch_assoc($result);
    $revenue = $data['total_rev'];
    $expenses = $data['total_bhada'] + $data['total_comm1'] + $data['total_comm2'];
    $profit = $data['total_profit'];
}
?>
<!DOCTYPE html>
<html>
<head>

<title>Transport Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
<style>
/* --- BASE STYLES --- */
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #eef1f7;
    padding: 20px;
    margin: 0;
}

h2 { color: #333; }

/* --- DASHBOARD GRID --- */
.dashboard {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Default: 4 columns for Desktop */
    gap: 20px;
    margin-bottom: 30px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    text-align: center;
}

.card h3 { margin: 0; font-size: 14px; color: #666; text-transform: uppercase; }
.card h1 { margin: 10px 0 0; font-size: 24px; }

/* Colors */
.green { color: #27ae60; }
.blue { color: #2980b9; }
.orange { color: #f39c12; }
.red { color: #e74c3c; }

/* Financial Performance Section (Flexbox) */
.profit-grid {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
}

/* --- RESPONSIVE MEDIA QUERIES --- */

/* For Tablets (Screens less than 992px) */
@media screen and (max-width: 992px) {
    .dashboard {
        grid-template-columns: repeat(2, 1fr); /* 2 columns instead of 4 */
    }
    .profit-grid {
        flex-wrap: wrap; /* Allow cards to wrap to next line */
    }
    .profit-grid .card {
        flex: 1 1 calc(45%); /* Takes half width */
    }
}

/* For Mobiles (Screens less than 600px) */
@media screen and (max-width: 600px) {
    body { padding: 10px; }
    
    .dashboard {
        grid-template-columns: 1fr; /* 1 column only */
    }
    
    .profit-grid .card {
        flex: 1 1 100%; /* Full width */
    }

    button {
        width: 100%;
        margin-bottom: 10px;
        padding: 12px;
    }

    table {
        font-size: 10px; /* Shrink table font for small screens */
    }
}

/* --- PRINT MEDIA QUERY (Optimized for A4) --- */
@media print {
    /* Hide UI elements */
    .no-print, button, .dashboard, .profit-grid {
        display: none !important;
    }
    
    body {
        background: white;
        padding: 0;
    }

    .print-area {
        display: block !important;
        width: 100%;
        box-shadow: none;
        margin: 0;
        padding: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    th, td {
        border: 1px solid #000 !important;
        padding: 8px;
    }

    h2 { margin-top: 0; }
}

/* On-screen style for print area */
.print-area {
    background: white;
    padding: 20px;
    margin-top: 30px;
    border-radius: 6px;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
}
</style>
</style>

</head>

<body>

<?php include 'sidebar.php'; ?>
<h2>Transport Dashboard</h2>

<div class="dashboard no-print">
    <div class="card">
        <h3>Trips Today</h3>
        <h1 class="blue"><?php echo $resToday['trips'] ?? 0; ?></h1>
    </div>

    <div class="card">
        <h3>Today's Profit</h3>
        <h1 class="green">₹ <?php echo number_format($resToday['profit'] ?? 0); ?></h1>
    </div>

    <div class="card">
        <h3>This Month (Profit)</h3>
        <h1 class="orange">₹ <?php echo number_format($resMonth['m_profit'] ?? 0); ?></h1>
    </div>

    <div class="card">
        <h3>This Year (Profit)</h3>
        <h1 class="red">₹ <?php echo number_format($resYear['y_profit'] ?? 0); ?></h1>
    </div>
</div>
<div class="main">
    <div class="title"><h2>Financial Performance Report</h2></div>

    <div class="profit-grid" style="display: flex; gap: 20px; margin-bottom: 30px;">
        <div class="card" style="flex: 1; background: #27ae60; color: white; padding: 20px; border-radius: 10px;">
            <div style="font-size: 0.9em;">TOTAL REVENUE</div>
            <div style="font-size: 1.8em; font-weight: bold;">₹ <?= number_format($revenue, 2) ?></div>
        </div>

        <div class="card" style="flex: 1; background: #e67e22; color: white; padding: 20px; border-radius: 10px;">
            <div style="font-size: 0.9em;">GADI BHADA + COMM</div>
            <div style="font-size: 1.8em; font-weight: bold;">₹ <?= number_format($expenses, 2) ?></div>
        </div>

        <div class="card" style="flex: 1; background: #2980b9; color: white; padding: 20px; border-radius: 10px;">
            <div style="font-size: 0.9em;">NET PROFIT</div>
            <div style="font-size: 1.8em; font-weight: bold;">₹ <?= number_format($profit, 2) ?></div>
        </div>
    </div>
    
    </div>
<br><br>

<div style="text-align:center">

<button onclick="window.location='trip_report.php'">Trip Report</button>

<button onclick="window.location='daily_profit_report.php'">Daily Report</button>

<button onclick="window.location='vehicle_profit_report.php'">Vehicle Report</button>

<button onclick="window.location='agent_commission_report.php'">Agent Report</button>

</div>
<div class="print-area">
    <h2 style="text-align:center;">Daily Transaction Report - <?php echo date('d-M-Y'); ?></h2>
    <table border="1" width="100%" cellpadding="10" style="border-collapse:collapse;">
        <thead>
            <tr style="background:#f2f2f2;">
                <th>LR No.</th>
                <th>Party Name</th>
                <th>Revenue</th>
                <th>Gadi Bhada</th>
                <th>Commissions</th>
                <th>Net Profit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $details = mysqli_query($conn, "SELECT l.lr_id, l.consignor, p.* FROM lr_entry l 
                JOIN logistics_profit_analysis p ON l.lr_id = p.lr_id 
                WHERE DATE(l.lr_date) = '$today'");
            while($row = mysqli_fetch_assoc($details)) {
                $total_comm = $row['agent_comm_1'] + $row['agent_comm_2'];
                echo "<tr>
                    <td>{$row['lr_id']}</td>
                    <td>{$row['consignor']}</td>
                    <td>₹ ".number_format($row['revenue_amount'])."</td>
                    <td>₹ ".number_format($row['gadi_bhada'])."</td>
                    <td>₹ ".number_format($total_comm)."</td>
                    <td style='color:green; font-weight:bold;'>₹ ".number_format($row['net_profit'])."</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div style="text-align:center; margin-top:20px;" class="no-print">
    <button onclick="window.print()" style="background:#444; color:#fff; padding:10px 20px;">🖨 Print A4 Report</button>
</div>
</body>
</html>