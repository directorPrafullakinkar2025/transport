<?php 
require_once 'db.php'; 
require_once 'state_names.php';
require_once 'city_names.php';

// Mock firms array for table logic - Replace this with your actual DB fetch
$firms = []; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firm Creation Module</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg: #f8fafc;
            --card: #ffffff;
            --border: #e2e8f0;
            --sidebar-width: 240px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            margin: 0;
            color: #1e293b;
        }

        /* Responsive Container */
        .page-container {
            margin-left: var(--sidebar-width);
            padding: 30px;
            transition: 0.3s ease;
        }

        .container-card {
            background: var(--card);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        h2 {
            margin-top: 0;
            font-size: 1.5rem;
            color: #0f172a;
            border-left: 4px solid var(--primary);
            padding-left: 15px;
            margin-bottom: 25px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 16px;
            border-radius: 6px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            transition: 0.2s;
        }

        .btn-new { background: var(--success); }
        .btn-save { background: var(--primary); }
        .btn-update { background: var(--warning); }
        .btn-show { background: #6366f1; }
        .btn:hover { opacity: 0.9; transform: translateY(-1px); }

        /* Form Grid */
        .grid-layout {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .form-group { display: flex; flex-direction: column; }
        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 6px;
        }

        input, select {
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
            transition: 0.2s;
        }

        input:focus, select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Upload Box */
        .upload-wrapper { display: flex; align-items: center; gap: 15px; }
        .upload-box {
            flex: 1;
            border: 2px dashed var(--border);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            background: #f1f5f9;
            font-size: 13px;
        }

        /* Table */
        .table-box { overflow-x: auto; border-radius: 8px; border: 1px solid var(--border); }
        table { width: 100%; border-collapse: collapse; background: white; }
        th { background: #f8fafc; padding: 12px; text-align: left; font-size: 13px; color: var(--secondary); }
        td { padding: 12px; border-top: 1px solid var(--border); font-size: 14px; }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .page-container { margin-left: 0; padding: 15px; }
            .grid-layout { grid-template-columns: 1fr; }
            .action-buttons .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

<?php include 'sidebar.php' ?>

<div class="page-container">
    <div class="container-card">
        <h2>Firm Creation Module</h2>

        <div class="action-buttons">
            <button type="button" class="btn btn-new" onclick="showFirmInput()">➕ New</button>
            <button class="btn btn-save" onclick="document.getElementById('firmForm').submit()">💾 Save</button>
            <button class="btn btn-update">🔄 Update</button>
            <button class="btn btn-show" onclick="showFirmDropdown()">👁 Show</button>
        </div>

        <form id="firmForm" method="post" action="in_firms.php" enctype="multipart/form-data">
            <div class="grid-layout">
                
                <div class="form-group" id="firm-field">
                    <label id="firm-label">Firm Name *</label>
                    <div id="firm-input-container">
                        <input type="text" name="firm_name" required placeholder="Enter Firm Name">
                    </div>
                </div>

                <div class="form-group">
                    <label>Alias</label>
                    <input type="text" name="alias" placeholder="Short Name">
                </div>

                <div class="form-group">
                    <label>Unit</label>
                    <input type="text" name="unit">
                </div>

                <div class="form-group">
                    <label>Financial Year *</label>
                    <input type="text" name="financial_year" value="2024-2025">
                </div>

                <div class="form-group">
                    <label>Address (1)</label>
                    <input type="text" name="address1">
                </div>

                <div class="form-group">
                    <label>Address (2)</label>
                    <input type="text" name="address2">
                </div>

                <div class="form-group">
                    <label>State Name *</label>
                    <select name="state" id="state" required>
                        <option value="">Select State</option>
                        <?php foreach ($stateCities as $state => $cities): ?>
                            <option value="<?= $state ?>"><?= $state ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>City Name *</label>
                    <select name="city" id="city" required>
                        <option value="">Select City</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Mobile No.</label>
                    <input type="text" name="mobile" placeholder="+91 ...">
                </div>

                <div class="form-group">
                    <label>GST No.</label>
                    <input type="text" name="gst_no" placeholder="27XXXXX...">
                </div>

                <div class="form-group">
                    <label>PAN No.</label>
                    <input type="text" name="pan_no">
                </div>

                <div class="form-group">
                    <label>E-Mail</label>
                    <input type="email" name="email">
                </div>

                <div class="form-group">
                    <label>Logo Upload</label>
                    <div class="upload-wrapper">
                        <div class="upload-box" onclick="document.getElementById('logoInput').click()">
                            Click to Upload Logo
                            <input type="file" name="logo" id="logoInput" accept="image/*" style="display:none;">
                        </div>
                        <img id="logoPreview" style="display:none; width:50px; height:50px; object-fit:cover; border-radius:4px;">
                    </div>
                </div>

                <div class="form-group">
                    <label>Seal Upload</label>
                    <div class="upload-wrapper">
                        <div class="upload-box" onclick="document.getElementById('sealInput').click()">
                            Click to Upload Seal
                            <input type="file" name="seal" id="sealInput" accept="image/*" style="display:none;">
                        </div>
                        <img id="sealPreview" style="display:none; width:50px; height:50px; object-fit:cover; border-radius:4px;">
                    </div>
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <button type="submit" name="save_firm" class="btn btn-save" style="padding: 12px 30px;">Submit Firm</button>
                <button type="reset" class="btn" style="background: var(--secondary); padding: 12px 30px;">Clear Form</button>
            </div>
        </form>
    </div>

    <div class="container-card">
        <div class="table-box">
            <table>
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Firm Details</th>
                        <th>City / State</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($firms)): ?>
                        <tr><td colspan="5" style="text-align:center; color:var(--secondary);">No firms found.</td></tr>
                    <?php else: ?>
                        <?php $i = 1; foreach ($firms as $firm): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td>
                                <strong><?= htmlspecialchars($firm['name']) ?></strong><br>
                                <small style="color:var(--secondary)">FY: <?= htmlspecialchars($firm['year']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($firm['city']) ?>, <?= htmlspecialchars($firm['state']) ?></td>
                            <td><?= htmlspecialchars($firm['phone']) ?></td>
                            <td>
                                <button class="btn btn-save" style="padding:4px 8px; font-size:12px;">Edit</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Toggle Firm Field between Input and Select
function showFirmDropdown() {
    const container = document.getElementById('firm-input-container');
    container.innerHTML = `<select name="firm_name" style="width:100%"><option>Loading Firms...</option></select>`;
    // You would typically trigger an AJAX call here to populate the select
}

function showFirmInput() {
    const container = document.getElementById('firm-input-container');
    container.innerHTML = `<input type="text" name="firm_name" required placeholder="Enter Firm Name">`;
}

// File Preview Logic
function setupPreview(inputId, previewId) {
    document.getElementById(inputId).addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(previewId);
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
}

setupPreview('logoInput', 'logoPreview');
setupPreview('sealInput', 'sealPreview');

// State/City Logic Pass
const stateCities = <?= json_encode($stateCities) ?>;
</script>

<script src="js/city_dropdown.js"></script>
</body>
</html>