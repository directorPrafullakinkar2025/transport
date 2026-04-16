<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $state_id = (int) $_POST['state_id'];
  $state_name = $_POST['state_name'];
  $state_code = $_POST['state_code'];
  $gst_state_code = $_POST['gst_state_code'];
  $status = $_POST['states'];
  $created_at = $_POST['created_at'];

  $sql = "UPDATE city_master SET
            state_name = '$ststate_nameate',
            state_code = '$state_code',
            gst_state_code = '$gst_state_code',
            status = '$states',
            created_at = '$created_at'
            WHERE state_id = $state_id";

  mysqli_query($conn, $sql);

  echo "<script>
    alert('City updated successfully');
    window.location.href = '/Administration/city_creation.php';
</script>";
  exit;

}
