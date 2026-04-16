<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

/* ================= FORM SUBMIT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ========= FORM DATA ========= */
    $ledger_group     = $_POST['ledger_group'] ?? '';
    $gst_no           = $_POST['gst_no'] ?? '';
    $search_by        = $_POST['search_by'] ?? '';
    $party_name       = $_POST['party_name'] ?? '';
    $party_alias      = $_POST['party_alias'] ?? '';
    $address1         = $_POST['address1'] ?? '';
    $address2         = $_POST['address2'] ?? '';
    $state_name       = $_POST['state_name'] ?? '';
    $city_name        = $_POST['city_name'] ?? '';
    $pan_no           = $_POST['pan_no'] ?? '';
    $iec_no           = $_POST['iec_no'] ?? '';
    $aadhar_no        = $_POST['aadhar_no'] ?? '';
    $rc_no            = $_POST['rc_no'] ?? '';
    $license_no       = $_POST['license_no'] ?? '';
    $phone_no         = $_POST['phone_no'] ?? '';
    $mobile_no        = $_POST['mobile_no'] ?? '';
    $email            = $_POST['email'] ?? '';
    $opening_balance  = $_POST['opening_balance'] ?? 0;
    $opening_type     = $_POST['opening_type'] ?? 'Dr';
    $arn_no           = $_POST['arn_no'] ?? '';
    $exim_code        = $_POST['exim_code'] ?? '';
    $party_type       = $_POST['party_type'] ?? '';
    $bank_name        = $_POST['bank_name'] ?? '';
    $account_no       = $_POST['account_no'] ?? '';
    $branch_name      = $_POST['branch_name'] ?? '';
    $ifsc_code        = $_POST['ifsc_code'] ?? '';

    /* ================= SQL ================= */
    $sql = "INSERT INTO ledger_master (
        ledger_group,
        gst_no,
        search_by,
        party_name,
        party_alias,
        address1,
        address2,
        state_name,
        city_name,
        pan_no,
        iec_no,
        aadhar_no,
        rc_no,
        license_no,
        phone_no,
        mobile_no,
        email,
        opening_balance,
        opening_type,
        arn_no,
        exim_code,
        party_type,
        bank_name,
        account_no,
        branch_name,
        ifsc_code,
        created_at,
        updated_at
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW()
    )";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    /* ================= BIND PARAMETERS ================= */
    $stmt->bind_param(
        "sssssssssssssssssdssssssss",
        $ledger_group,
        $gst_no,
        $search_by,
        $party_name,
        $party_alias,
        $address1,
        $address2,
        $state_name,
        $city_name,
        $pan_no,
        $iec_no,
        $aadhar_no,
        $rc_no,
        $license_no,
        $phone_no,
        $mobile_no,
        $email,
        $opening_balance,
        $opening_type,
        $arn_no,
        $exim_code,
        $party_type,
        $bank_name,
        $account_no,
        $branch_name,
        $ifsc_code
    );

    /* ================= EXECUTE ================= */
       if ($stmt->execute()) {
        echo "<script>
            alert('Ledger added successfully');
            window.location.href = '/Administration/ledger_creation.php?success=1';
        </script>";
        exit;
    }
    else {
        die("Execute failed: " . $stmt->error);
    }

}


?>
