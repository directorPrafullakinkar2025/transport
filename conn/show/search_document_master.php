<?php
include '../conn/db.php';

$document_master = [];
$sql = "SELECT * FROM document_master ORDER BY document_name";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $document_master[] = $row['document_name'];
    }
}