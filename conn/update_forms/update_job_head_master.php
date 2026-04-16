<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $job_head_id = (int) $_POST['job_head_id'];
  $job_head_id = $_POST['job_head_name'];
  $gst_percent = $_POST['gst_percent'];
  $show_reminder = $_POST['show_remider'];
  $description = $_POST['description'];
  $status = $_POST['status'];
  $created_at = $_POST['created_at'];

  $sql = "UPDATE city_master SET
            job_head_name = '$job_head_name',
            gst_percent = '$gst_percent',
            show_remider = '$show_remider',
            description = '$description',
            status = '$status',
            created_at = '$created_at',
            WHERE job_head_id = $job_head_id";

  mysqli_query($conn, $sql);

  echo "<script>
    alert('City updated successfully');
    window.location.href = '/Administration/city_creation.php';
</script>";
  exit;

}
