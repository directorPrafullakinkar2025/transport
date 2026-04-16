<?php        
include '../conn/db.php';

$document_registration = [];
$sql = "SELECT * FROM document_registration ORDER BY doc_no";
$res = mysqli_query($conn, $sql);

if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
$document_registration[] = $row['doc_no'];
    }
}