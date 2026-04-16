
function showFirmDropdown() {
    document.getElementById("firm-field").innerHTML = `
        <label>Firm *</label>
        <select name="firm_name" required>
            <option value="">Select Firm</option>
            <?php foreach ($firms as $firm): ?>
                <option value="<?= htmlspecialchars($firm) ?>">
                    <?= htmlspecialchars($firm) ?>
                </option>
            <?php endforeach; ?>
        </select>
    `;
}

function showFirmInput() {
    document.getElementById("firm-field").innerHTML = `
        <label>Firm *</label>
        <input type="text" name="firm_name" placeholder="Enter New Firm Name" required>
    `;
}

