<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

/* ================= PREPARED QUERY ================= */
$sql = "
    SELECT 
        firm_id,
        firm_name AS name,
        financial_year AS year,
        phone,
        city,
        state,
        CONCAT(address1, ' ', address2) AS address
    FROM firms
    ORDER BY firm_name
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

/* ================= EXECUTE ================= */
$stmt->execute();

/* ================= GET RESULT ================= */
$result = $stmt->get_result();

$firms = [];
while ($row = $result->fetch_assoc()) {
    $firms[] = $row;
}

$stmt->close();
$conn->close();
