<?php
include("db.php");

$doctor_id = $_GET['doctor_id'];
$date = $_GET['date'];

$day = date("l", strtotime($date));

$sql = "SELECT DISTINCT b.branch_id, b.branch_name
FROM doctor_schedule s
JOIN branch b ON s.branch_id = b.branch_id
WHERE s.doctor_id=? AND s.day_of_week=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $doctor_id, $day);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);