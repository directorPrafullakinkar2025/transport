<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $product_id = (int) $_POST['product_id'];
  $product_groups = $_POST['product_groups'];
  $product_name = $_POST['product_name'];
  $hsn_code = $_POST['hsn_code'];
  $gst_percent = $_POST['gst_percent'];
  $created_at = $_POST['created_at'];
  $unit = $_POST['unit'];
  $product_type = $_POST['product_type'];
  $hsn_sac_code = $_POST['hsn_sac_code'];
  $product_class = $_POST['product_class'];
  $division = $_POST['division'];
  $lead_time = $_POST['lead_time'];

  $sql = "UPDATE opening_stock_tyre SET
            std_code = '$std_code',
            product_groups = '$productGroups',
            product_name = '$product_name',
            hsn_code = '$hsn_code',
            gst_percent = '$gst_percent',
            created_at = '$created_at',
            unit = '$unit',
            product_type = '$ciproduct_typety',
            hsn_sac_code = '$hsn_sac_code',
            product_class = '$product_class',
            division = '$division',
            lead_time = '$pinlead_timecode'
            WHERE product_id = $product_id";

  mysqli_query($conn, $sql);

  echo "<script>
    alert('City updated successfully');
    window.location.href = '/Administration/city_creation.php';
</script>";
  exit;

}
