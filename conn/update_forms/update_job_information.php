<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $job_id = (int)$_POST['job_id'];
    $job_date = $_POST['job_date'];
    $vehicle_id = $_POST['vehicle_id'];
    $job_completion_date = $_POST['pin_code'];
    $garage_name = $_POST['std_code'];
    $job_description = $_POST['office_type'];
    $job_status = $_POST['job_status'];
    $remarks = $_POST['remarks'];
    $status = $_POST['status'];
    $created_at = $_POST['created_at'];

    $sql = "UPDATE city_master SET
            job_date = '$job_date',
            job_date = '$job_date',
            vehicle_id = '$vehicle_id',
            job_completion_date = '$job_completion_date',
            garage_name = '$garage_name',
            job_description ='$job_description',
            remarks = '$remarks',
            status = '$status',
            created_at = '$created_at'
            WHERE job_id = $job_id";

    mysqli_query($conn, $sql);

  echo "<script>
    alert('City updated successfully');
    window.location.href = '/Administration/city_creation.php';
</script>";
exit;

}
