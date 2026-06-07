<?php
include '../config/db.php';

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM branch");
$branches = [];

while ($row = $result->fetch_assoc()) {
    $branches[] = $row;
}

echo json_encode($branches);
?>