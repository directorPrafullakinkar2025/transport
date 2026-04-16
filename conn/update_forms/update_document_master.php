<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $document_id = (int) $_POST['document_id'];
  $document_name = $_POST['document_name'];
  $show_reminder = $_POST['show_reminder'];
  $description = $_POST['description'];
  $status = $_POST['status'];
  $created_at = $_POST['created_at'];

  $sql = "UPDATE document_master SET
            state = '$state',
            document_name = '$document_name',
            show_reminder = '$show_reminder',
            description = '$description',
            created_at = '$created_at'
            WHERE document_id = $document_id";

  mysqli_query($conn, $sql);

  echo "<script>
    alert('City updated successfully');
    window.location.href = '/Administration/city_creation.php';
</script>";
  exit;

}
