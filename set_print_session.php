<?php
session_start(); // Mandatory!

if (isset($_POST['lr_no'])) {
    $_SESSION['print_lr_id'] = $_POST['lr_no'];
    echo "success";
} else {
    echo "No ID received";
}
?>