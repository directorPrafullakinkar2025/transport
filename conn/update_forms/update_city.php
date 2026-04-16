<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $id = (int) $_POST['city_id'];
  $state = $_POST['state'];
  $city = $_POST['city_name'];
  $pincode = $_POST['pin_code'];
  $std_code = $_POST['std_code'];
  $office_type = $_POST['office_type'];

  $sql = "UPDATE city_master SET
            state = '$state',
            city_name = '$city',
            pin_code = '$pincode',
            std_code = '$std_code',
            office_type = '$office_type'
            WHERE city_id = $id";

  mysqli_query($conn, $sql);

  echo "<script>
    alert('City updated successfully');
    window.location.href = '/Administration/city_creation.php';
</script>";
  exit;

}
