<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $vehicle_doc_id = (int) $_POST['vehicle_doc_id'];
  $doc_no = $_POST['doc_no'];
  $company_name = $_POST['company_name'];
  $reg_status = $_POST['reg_status'];
  $remarks = $_POST['remarks'];
  $entry_date = $_POST['entry_date'];
  $vehicle_id = $_POST['vehicle_id'];
  $effective_date = $_POST['effectie_date'];
  $expiry_date = $_POST['expiry_date'];
  $state = $_POST['state'];
  $created_at =$_POST['created_at'];

  $sql = "UPDATE document_registeration SET
            state = '$state',
            doc_no = 'doc_no',
            company_name = '$company_name',
            reg_status = '$reg_status',
            remarks = '$remarks',
            entry_date = '$entry_date',
            vehicle_id = '$vehicle_id',
            effectie_date ='$effectie_date',
            state = '$state',
            created_at = '$created_at',
            WHERE vehicle_doc_id = $vehicle_doc_id";


  mysqli_query($conn, $sql);

  echo "<script>
    alert('City updated successfully');
    window.location.href = '/Administration/city_creation.php';
</script>";
  exit;

}
