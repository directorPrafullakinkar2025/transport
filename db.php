<?php
// $conn = new mysqli("localhost","root", "", "updated_transport_project");
$conn = new mysqli("localhost", "shreeinfotechsof", ",oSjcFMm,Rg;", "shreeinfotechsof_updated_transport_project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>