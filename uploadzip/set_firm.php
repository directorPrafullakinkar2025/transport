<?php
session_start();

if (isset($_POST['firm_name'])) {
    $_SESSION['firm_name'] = $_POST['firm_name'];
}

// redirect to next page (dashboard or home)
header("Location: dashboard.php");
exit();