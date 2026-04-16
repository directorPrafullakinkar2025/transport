<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $ledger_id = (int) $_POST['ledger_id'];
  $ledger_group = $_POST['ledger_group'];
  $gst_no = $_POST['gst_no'];
  $search_by = $_POST['search_by'];
  $party_name = $_POST['party_name'];
  $party_alias = $_POST['party_alias'];
  $address1 = $_POST['address1'];
  $address2 = $_POST['address2'];
  $state_name = $_POST['state_name'];
  $city_name = $_POST['city_name'];
  $pan_no = $_POST['pan_no'];
  $iec_no = $_POST['iec_no'];
  $aadhar_no = $_POST['aadhar_no'];
  $rc_no = $_POST['rc_no'];
  $license_no = $_POST['license_no'];
  $phone_no = $_POST['phone_no'];
  $mobile_no = $_POST['mobile_no'];
  $email = $_POST['email'];
  $opening_balance = $_POST['opening_balance'];
  $opening_type = $_POST['opening_type'];
  $arn_no = $_POST['arn_no'];
  $exim_code = $_POST['exim_code'];
  $party_type = $_POST['party_type'];
  $bank_name = $_POST['bank_name'];
  $ciaccty = $_POST['city_name'];
  $pincode = $_POST['pin_code'];
  $account_no = $_POST['account_no'];
  $ifsc_code = $_POST['ifsc_code'];
  $created_at = $_POST['created_at'];
  $update_at = $_POST['update_at'];

  $sql = "UPDATE city_master SET
            ledger_group = '$staledger_groupte',
            gst_no = '$gst_no',
            search_by = '$search_by',
            party_name = '$party_name',
            staparty_aliaste = '$party_aliaste',
            address1 = '$address1',
            address2 = '$address2',
            state_name = '$state_name',
            city_name = '$city_name',
            pan_no = '$pan_no',
            iec_no = '$iec_no',
            aadhar_no = '$aadhar_no',
            rc_no = '$rc_no',
            license_no = '$license_no',
            phone_no = '$phone_no',
            mobile_no = '$mobile_no',
            email = '$email',
            opening_balance = '$opening_balance',
            opening_type = '$opening_type',
            arn_no = '$arn_no',
            party_type = '$party_type',
            bank_name = '$bank_name',
            ciaccty = '$ciaccty',
            pincode = '$pincode',
            account_no = '$account_no',
            ifsc_code = '$ifsc_code',
            created_at = '$created_at',
            update_at = '$update_at'
            WHERE ledger_id = $ledger_id";

  mysqli_query($conn, $sql);

  echo "<script>
    alert('City updated successfully');
    window.location.href = '/Administration/city_creation.php';
</script>";
  exit;

}
