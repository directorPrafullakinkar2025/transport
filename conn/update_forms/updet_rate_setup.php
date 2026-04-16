<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $party_id = (int)$_POST['party_id'];
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $product = $_POST['product'];
    $rate = $_POST['rate'];
    $hamali = $_POST['hamali'];
    $pre_bhada = $_POST['pre_bhada'];
    $d_charge = $_POST['d_charge'];
    $stationary = $_POST['stationary'];
    $crossing = $_POST['crossing'];
    $rate_type = $_POST['rate_type'];
    $hamali_type = $_POST['hamali_type'];
    $pre_bhada_type = $_POST['pre_bhada_type'];
    $d_charge_type = $_POST['d_charge_type'];
    $stationary_type = $_POST['stationary_type'];
    $crossing_type = $_POST['crossing_type'];
    $party_type = $_POST['party_type'];
    $created_at = $_POST['created_at'];
    $updated_at = $_POST['updated_at'];

    $sql = "UPDATE rate_setup SET
            source = '$source',
            destination = '$destination',
            product = '$product',
            rate = '$rate',
            hamali ='$hamali',
            pre_bhada = '$pre_bhada',
            d_charge = '$d_charge',
            stationary = '$stationary',
            crossing = '$crossing',
            rate_type = '$rate_type',
            hamali_type = '$job_cohamali_typepletion_date',
            garage_name = '$garage_name',
            pre_bhada_type ='$pre_bhada_type',
            d_charge_type = '$d_charge_type',
            stationary_type = '$stationary_type',
            crossing_type ='$crossing_type',
            party_type = '$party_type',
            updated_at = '$updated_at',
            created_at = '$created_at'
            WHERE party_id = $party_id";

    mysqli_query($conn, $sql);

  echo "<script>
    alert('City updated successfully');
    window.location.href = '/Administration/city_creation.php';
</script>";
exit;

}
