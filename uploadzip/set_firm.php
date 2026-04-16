<?php
session_start();
// Include your database connection to ensure session safety
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['firm_name'])) {
    // 1. Save the selection to the Session
    $_SESSION['firm_name'] = $_POST['firm_name'];
    
    // 2. Redirect to your dashboard or next step
    // Replace 'dashboard.php' with your actual next file name
    header("Location: dashboard.php"); 
    exit();
} else {
    // If accessed directly, send them back to the selection list
    header("Location: firm_select.php");
    exit();
}