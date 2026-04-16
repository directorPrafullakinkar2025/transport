<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $product_id = (int) $_POST['product_id'];
  $bill_type = $_POST['bill_type'];
  $invoice_no = $_POST['invoice_no'];
  $reference_no = $_POST['reference_no'];
  $invoice_date = $_POST['invoice_date'];
  $invoice_type = $_POST['invoice_type'];
  $buyer_id = $_POST['buyer_id'];
  $consignee_id = $_POST['consignee_id'];
  $transport_id = $_POST['transport_id'];
  $agent_id = $_POST['agent_id'];
  $transport_mode = $_POST['transport_mode'];
  $supply_date = $_POST['supply_date'];
  $supply_type = $_POST['supply_type'];
  $supply_place = $_POST['supply_place'];
  $challan_no = $_POST['challan_no'];
  $challan_date = $_POST['challan_date'];
  $order_no = $_POST['order_no'];
  $order_date = $_POST['order_date'];
  $location = $_POST['location'];
  $created_at = $_POST['created_at'];
  $updated = $_POST['updated'];
  $product_group_id = $_POST['product_group_id'];
  $product_id = $_POST['product_id'];
  $part_no = $_POST['part_no'];
  $description = $_POST['description'];
  $quantity = $_POST['quantity'];
  $unit = $_POST['unit'];
  $packages = $_POST['packages'];
  $weight_total_qty = $_POST['weight_total_qty'];
  $rate = $_POST['rate'];
  $rate_type = $_POST['rate_type'];
  $size = $_POST['size'];
  $total = $_POST['total'];
  $discount_percent = $_POST['discount_percent'];


  $sql = "UPDATE job_maintenance_servicing SET
            bill_type = '$bill_type',
            invoice_no = '$invoice_no',
            reference_no = '$pincoreference_no',
            invoice_date = '$invoice_date',
            invoice_type = '$invoice_type'
            buyer_id = '$buyer_id',
            consignee_id = '$consignee_id',
            transport_id = '$transport_id',
            agent_id = '$agent_id',
            supply_date = '$supply_date'
            transport_mode = '$transport_mode',
            supply_type = '$supply_type',
            supply_place = '$supply_place',
            challan_no = '$challan_no',
            challan_date = '$challan_date'
            order_no = '$order_no,
            order_date = '$order_date',
            location = '$location',
            created_at = '$created_at',
            updated = '$updated'
            product_group_id = '$product_group_id',
            product_id = '$product_id',
            part_no = '$part_no',
            description = '$description',
            quantity = '$quantity'
            unit = '$unit',
            packages = '$packages',
            weight_total_qty = '$weight_total_qty',
            rate = '$rate',
            rate_type = '$rate_type',
            size = '$size',
            total = '$total',
            rate = '$rate',
            discount_percent = '$discount_percent'
            WHERE product_id = $product_id";

  mysqli_query($conn, $sql);

  echo "<script>
    alert('City updated successfully');
    window.location.href = '/Administration/city_creation.php';
</script>";
  exit;

}
