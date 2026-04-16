<?php
$conn = new mysqli("localhost", "root", "", "updated_transport_project");

$username = "tc100";
$password = password_hash("tc100", PASSWORD_DEFAULT);

$conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");

echo "User Created Successfully!";
?>