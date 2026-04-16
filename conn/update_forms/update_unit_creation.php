<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $unit_id = (int) $_POST['unit_id'];
  $unit_name = $_POST['unit_name'];
  $unit_value = $_POST['unit_value'];
  $status = $_POST['status'];
  $created_at = $_POST['created_at'];

  $sql = "UPDATE city_master SET
            unit_name = '$unit_name',
            unit_value = '$unit_value',
            status = '$status',
            created_at = '$created_at'
            WHERE unit_id = $unit_id";

  mysqli_query($conn, $sql);

  echo "<script>
    alert('City updated successfully');
    window.location.href = '/Administration/city_creation.php';
</script>";
  exit;

}