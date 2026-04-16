<?php
require_once "db.php";

if(isset($_POST['save_lr']))
{
    // --- Existing LR Fields ---
    $firm_id = $_POST['firm_id'];
    $lr_id = $_POST['lr_id'];
    $lr_date = $_POST['lr_date'];
    $ref_lr_no = $_POST['ref_lr_no'];
    $pm = $_POST['pm'];
    $from_city = $_POST['from_city'];
    $to_city = $_POST['to_city'];
    $consignor = $_POST['consignor'];
    $consignee = $_POST['consignee'];
    $cnsnr_address = $_POST['cnsnr_address'];
    $cnsgne_address = $_POST['cnsgne_address'];
    $cnsnr_gstin = $_POST['cnsnr_gstin'];
    $cnsgne_gstin = $_POST['cnsgne_gstin'];
    $billing_branch = $_POST['billing_branch'];
    $billed_to = $_POST['billed_to'];
    $vehicle_no = $_POST['vehicle_no'];
    $owner_name = $_POST['owner_name'];
    $transport_mode = $_POST['transport_mode'];
    $transport_remark = $_POST['transport_remark'];
    $remarks = $_POST['remarks'];
    $delivery_at = $_POST['delivery_at'];
    $company_name = $_POST['company_name'];
    $policy_no = $_POST['policy_no'];
    $insurance_amount = $_POST['insurance_amount'];

    // --- NEW: Profit Analysis Fields ---
    // Ensure these names match the 'name' attribute in your HTML inputs
    $freight_amount = $_POST['freight'] ?? 0;
    $gadi_bhada = $_POST['gadi_bhada'] ?? 0;
    $comm_1 = $_POST['comm_1'] ?? 0;
    $comm_2 = $_POST['comm_2'] ?? 0;
    $net_profit = $_POST['net_profit'] ?? 0;

    // 1. Insert into main LR table
    $sql = "INSERT INTO lr_entry(
        lr_id, lr_date, ref_lr_no, pm, from_city, to_city, consignor, consignee, 
        cnsnr_address, cnsgne_address, cnsnr_gstin, cnsgne_gstin, billing_branch, 
        billed_to, vehicle_no, owner_name, transport_mode, transport_remark, 
        remarks, delivery_at, company_name, policy_no, insurance_amount, firm_id
    ) VALUES (
        '$lr_id', '$lr_date', '$ref_lr_no', '$pm', '$from_city', '$to_city', 
        '$consignor', '$consignee', '$cnsnr_address', '$cnsgne_address', 
        '$cnsnr_gstin', '$cnsgne_gstin', '$billing_branch', '$billed_to', 
        '$vehicle_no', '$owner_name', '$transport_mode', '$transport_remark', 
        '$remarks', '$delivery_at', '$company_name', '$policy_no', 
        '$insurance_amount', '$firm_id'
    )";

    if(mysqli_query($conn, $sql)) {
        
        // 2. Insert into Profit Analysis table
        $sql_profit = "INSERT INTO logistics_profit_analysis (
            lr_id, freight_amount, gadi_bhada, agent_comm_1, agent_comm_2, net_profit
        ) VALUES (
            '$lr_id', '$freight_amount', '$gadi_bhada', '$comm_1', '$comm_2', '$net_profit'
        )";

        if(mysqli_query($conn, $sql_profit)) {
            echo "<script>
            alert('LR and Profit Data Saved Successfully');
            window.location.href='index.php';
            </script>";
        } else {
            echo "Profit Record Error: " . mysqli_error($conn);
        }
        
    } else {
        echo "LR Entry Error: " . mysqli_error($conn);
    }
}
?>