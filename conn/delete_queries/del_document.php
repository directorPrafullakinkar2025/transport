<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

$id = $_GET['id'];

$sql = "DELETE FROM document_master WHERE document_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../../document_master.php");
} else {
    echo "Error while deleting";
}
?>
