<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Debug: Check if the ID is actually being received
echo "Checking LR ID: " . htmlspecialchars($_GET['lr_id'] ?? 'MISSING');
?>
<?php
// $conn = new mysqli("localhost","root", "", "updated_transport_project");
$conn = new mysqli("localhost", "shreeinfotechsof", ",oSjcFMm,Rg;", "shreeinfotechsof_updated_transport_project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>