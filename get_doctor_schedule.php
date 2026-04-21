<?php
include("db.php");

$doctor_id = $_GET['doctor_id'];

$sql = "SELECT ds.*, b.branch_name
FROM doctor_schedule ds
JOIN branch b ON ds.branch_id = b.branch_id
WHERE ds.doctor_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){
$data[] = $row;
}

echo json_encode($data);
?>