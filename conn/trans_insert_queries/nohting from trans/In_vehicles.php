<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= UPLOAD DIRECTORY ================= */
$uploadDir = __DIR__ . "/uploads/vehicles/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/* ================= FILE UPLOAD FUNCTION ================= */
function uploadFile($inputName, $uploadDir) {
    if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
        $fileName = time() . "_" . basename($_FILES[$inputName]['name']);
        $target   = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $target)) {
            return "uploads/vehicles/" . $fileName; // relative path
        }
    }
    return null;
}

/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $owner_name   = $_POST['owner_name'] ?? '';
    $vehicle_no   = $_POST['vehicle_no'] ?? '';
    $chassis_no   = $_POST['chassis_no'] ?? '';
    $vehicle_type = $_POST['vehicle_type'] ?? '';
    $engine_no    = $_POST['engine_no'] ?? '';
    $permit_no    = $_POST['permit_no'] ?? '';
    $insurance_no = $_POST['insurance_no'] ?? '';

    /* ========= FILE UPLOADS ========= */
    $rc_upload             = uploadFile('rc_upload', $uploadDir);
    $fitness_upload        = uploadFile('fitness_upload', $uploadDir);
    $insurance_upload      = uploadFile('insurance_upload', $uploadDir);
    $vehicle_permit_upload = uploadFile('vehicle_permit_upload', $uploadDir);
    $state_tax_upload      = uploadFile('state_tax_upload', $uploadDir);
    $puc_upload            = uploadFile('puc_upload', $uploadDir);

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO vehicles (
        owner_name,
        vehicle_no,
        chassis_no,
        vehicle_type,
        engine_no,
        permit_no,
        insurance_no,
        rc_upload,
        fitness_upload,
        insurance_upload,
        vehicle_permit_upload,
        state_tax_upload,
        puc_upload
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "sssssssssssss",
        $owner_name,
        $vehicle_no,
        $chassis_no,
        $vehicle_type,
        $engine_no,
        $permit_no,
        $insurance_no,
        $rc_upload,
        $fitness_upload,
        $insurance_upload,
        $vehicle_permit_upload,
        $state_tax_upload,
        $puc_upload
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Vehicle saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();
?>
