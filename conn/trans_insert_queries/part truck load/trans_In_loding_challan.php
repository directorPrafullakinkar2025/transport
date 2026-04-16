<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';
/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $firm_name          = $_POST['firm_name'] ?? '';
    $alias              = $_POST['alias'] ?? '';
    $address1           = $_POST['address1'] ?? '';
    $address2           = $_POST['address2'] ?? '';
    $city               = $_POST['city'] ?? '';
    $state              = $_POST['state'] ?? '';

    $phone              = $_POST['phone'] ?? '';
    $mobile             = $_POST['mobile'] ?? '';
    $gst_no             = $_POST['gst_no'] ?? '';
    $pan_no             = $_POST['pan_no'] ?? '';
    $email              = $_POST['email'] ?? '';

    $mailing_id         = $_POST['mailing_id'] ?? '';
    $email_password     = $_POST['email_password'] ?? '';
    $cin_number         = $_POST['cin_number'] ?? '';
    $mesme_number       = $_POST['mesme_number'] ?? '';

    $start_date         = $_POST['start_date'] ?? null;
    $end_date           = $_POST['end_date'] ?? null;

    $cgst               = $_POST['cgst'] ?? 0;
    $sgst               = $_POST['sgst'] ?? 0;
    $igst               = $_POST['igst'] ?? 0;

    $bank_name          = $_POST['bank_name'] ?? '';
    $account_number     = $_POST['account_number'] ?? '';
    $branch_name        = $_POST['branch_name'] ?? '';
    $ifsc_code          = $_POST['ifsc_code'] ?? '';

    $jurisdiction       = $_POST['jurisdiction'] ?? '';
    $isfinish           = $_POST['isfinish'] ?? 0;
    $financial_year     = $_POST['financial_year'] ?? '';

    /* ================= PREPARED STATEMENT ================= */
    $sql = "INSERT INTO firms (
        firm_name,
        alias,
        address1,
        address2,
        city,
        state,
        phone,
        mobile,
        gst_no,
        pan_no,
        email,
        mailing_id,
        email_password,
        cin_number,
        mesme_number,
        start_date,
        end_date,
        cgst,
        sgst,
        igst,
        bank_name,
        account_number,
        branch_name,
        ifsc_code,
        jurisdiction,
        isfinish,
        financial_year,
        created_at
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW()
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "ssssssssssssssssssddssssssis",
        $firm_name,
        $alias,
        $address1,
        $address2,
        $city,
        $state,
        $phone,
        $mobile,
        $gst_no,
        $pan_no,
        $email,
        $mailing_id,
        $email_password,
        $cin_number,
        $mesme_number,
        $start_date,
        $end_date,
        $cgst,
        $sgst,
        $igst,
        $bank_name,
        $account_number,
        $branch_name,
        $ifsc_code,
        $jurisdiction,
        $isfinish,
        $financial_year
    );

    /* ================= EXECUTE ================= */
    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Firm saved successfully</h3>";
    } else {
        echo "<h3 style='color:red'>Error: {$stmt->error}</h3>";
    }

    $stmt->close();
}

$conn->close();

if ($same_state) {
    $cgst = $total_tax / 2;
    $sgst = $total_tax / 2;
    $igst = 0;
} else {
    $cgst = 0;
    $sgst = 0;
    $igst = $total_tax;
}
?>

