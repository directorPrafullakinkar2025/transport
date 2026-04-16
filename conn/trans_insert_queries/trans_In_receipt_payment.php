<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FILE UPLOAD SETTINGS ================= */
$uploadDir = __DIR__ . "/uploads/pod/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $dc_no        = $_POST['dc_no'] ?? '';
    $lr_no        = $_POST['lr_no'] ?? '';
    $remarks      = $_POST['remarks'] ?? '';
    $upload_date  = $_POST['upload_date'] ?? date('Y-m-d');

    /* ========= FILE HANDLE ========= */
    $file_path = null;

    if (isset($_FILES['pod_file']) && $_FILES['pod_file']['error'] === UPLOAD_ERR_OK) {

        $fileTmp  = $_FILES['pod_file']['tmp_name'];
        $fileName = time() . "_" . basename($_FILES['pod_file']['name']);
        $target   = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmp, $target)) {
            // Store relative path in DB
            $file_path = "uploads/pod/" . $fileName;
        } else {
            die("File upload failed");
        }
    }

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO pod_entries (
        dc_no,
        lr_no,
        file_path,
        remarks,
        upload_date
    ) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "sssss",
        $dc_no,
        $lr_no,
        $file_path,
        $remarks,
        $upload_date
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>POD uploaded & saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}
?>