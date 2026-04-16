<?php
if(empty($_POST['lr_id']) || $_POST['lr_id'] == 0){
    echo "InvalidLR";
    exit;
}
require_once 'db.php';

if(isset($_POST['invoice_no'])){
    $lr_id    = mysqli_real_escape_string($conn, $_POST['lr_id']);
    $inv_no   = mysqli_real_escape_string($conn, $_POST['invoice_no']);
    $inv_date = mysqli_real_escape_string($conn, $_POST['invoice_date']);
    $val      = mysqli_real_escape_string($conn, $_POST['value_of_goods']);
    $ewb      = mysqli_real_escape_string($conn, $_POST['eway_bill_no']);
    $ewb_exp  = mysqli_real_escape_string($conn, $_POST['ewb_exp_date']);

    // Now inserting the LR_ID to create the link
    $sql = "INSERT INTO party_invoice_details (lr_id, invoice_no, invoice_date, value_of_goods, eway_bill_no, ewb_exp_date) 
            VALUES ('$lr_id', '$inv_no', '$inv_date', '$val', '$ewb', '$ewb_exp')";

    if(mysqli_query($conn, $sql)){
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>