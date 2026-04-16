<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $purchase_id = (int) $_POST['purchase_id'];
  $bill_no = $_POST['bill_no'];
  $reference_no = $_POST['reference_no'];
  $invoice_date = $_POST['invoice_date'];
  $invoice_type = $_POST['invoice_type'];
  $buyer_id = $_POST['buyer_id'];
  $consignee_id = $_POST['consignee_id'];
  $transport_id = $_POST['transport_id'];
  $agent_id = $_POST['agent_id'];
  $transport_mode = $_POST['transport_mode'];
  $supply_date = $_POST['supply_date'];
  $supply_place = $_POST['supply_place'];
  $supply_type = $_POST['supply_type'];
  $challan_no = $_POST['challan_no'];
  $challan_id = $_POST['challan_id'];
  $order_no = $_POST['order_no'];
  $order_date = $_POST['order_date'];
  $location = $_POST['location'];
  $created_at = $_POST['created_at'];
  $updated = $_POST['updated'];
  $product_group_id = $_POST['product_group_id'];
  $product_id = $_POST['product_id'];;
  $part_no = $_POST['part_no'];
  $description = $_POST['description'];
  $quantity = $_POST['quantity'];
  $unit = $_POST['unit'];
  $packages = $_POST['packages'];
  $weight_total_qty = $_POST['weight_total_qty'];
  $rate_type = $_POST['rate_type'];
  $size = $_POST['size'];
  $total = $_POST['total'];
  $discount_percent = $_POST['discount_percent'];

  $sql = "UPDATE city_master SET
            bill_no = '$bill_no',
            reference_no = '$reference_no',
            invoice_date = '$invoice_date',
            invoice_type = '$invoice_type',
            buyer_id = '$buyer_id',
            consignee_id = '$consignee_id',
            transport_id = '$transport_id',
            agent_id = '$agent_id',
            transport_mode = '$transport_mode',
            supply_date = '$supply_date',
            supply_place = '$supply_place',
            supply_type = '$supply_type',
            challan_no = '$challan_no',
            challan_id = '$challan_id',
            order_no = '$order_no',
            order_date = '$order_date',
            location = '$location',
            created_at = '$created_at',
            updated = '$updated',
            product_group_id = '$product_group_id',
            product_id = '$product_id',
            part_no = '$part_no',
            description = '$description',
            quantity = '$quantity',
            unit = '$unit',
            packages = '$packages',
            weight_total_qty = '$weight_total_qty',
            rate_type = '$rate_type',
            size = '$size',
            total = '$total',
            discount_percent = '$discount_percent'
            WHERE purchase_id = $purchase_id";

  mysqli_query($conn, $sql);

  echo "<script>
    alert('City updated successfully');
    window.location.href = '/Administration/city_creation.php';
</script>";
  exit;

}
