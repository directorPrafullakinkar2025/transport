<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $head_id = (int) $_POST['head_id'];
  $job_head_name = $_POST['job_head_name'];
  $head_type = $_POST['head_type'];
  $status = $_POST['status'];
  $created_at = $_POST['created_at'];

  $sql = "UPDATE job_head_master SET
            job_head_name = '$head_name',
            head_type = '$head_type',
            status = '$status',
            created_at = '$created_at'
            WHERE head_id = $head_id";

  mysqli_query($conn, $sql);

  echo "<script>
    alert('City updated successfully');
    window.location.href = '/Administration/city_creation.php';
</script>";
  exit;

}
