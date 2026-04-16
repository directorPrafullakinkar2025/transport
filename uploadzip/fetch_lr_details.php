<?php
require_once 'db.php';

if (isset($_GET['lr_no'])) {
    $lr_no = mysqli_real_escape_string($conn, $_GET['lr_no']);

    // 1. Fetch Main LR and Freight (1-to-1 relationship)
    $main_sql = "SELECT lr.*, fr.* FROM lr_entry lr 
                 LEFT JOIN freight_gst_details fr ON lr.lr_id = fr.lr_id 
                 WHERE lr.lr_id = '$lr_no' LIMIT 1";
    
    $main_res = mysqli_query($conn, $main_sql);

    if (mysqli_num_rows($main_res) > 0) {
        $response = ['status' => 'success'];
        $response['main_data'] = mysqli_fetch_assoc($main_res);

        // 2. Fetch Products (1-to-many)
        $prod_sql = "SELECT * FROM product_details WHERE lr_id = '$lr_no'";
        $prod_res = mysqli_query($conn, $prod_sql);
        $response['products'] = [];
        while($p = mysqli_fetch_assoc($prod_res)) {
            $response['products'][] = $p;
        }

        // 3. Fetch Invoices (Note: Ensure your party_invoice_details table has an lr_id column)
        // If it doesn't have lr_id, you'll need to add it to link them.
        $inv_sql = "SELECT * FROM party_invoice_details WHERE lr_id = '$lr_no'";
        $inv_res = mysqli_query($conn, $inv_sql);
        $response['invoices'] = [];
        while($i = mysqli_fetch_assoc($inv_res)) {
            $response['invoices'][] = $i;
        }

        echo json_encode($response);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'LR Not Found']);
    }
}
?>