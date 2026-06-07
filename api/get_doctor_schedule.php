<?php
include '../config/db.php';

header('Content-Type: application/json');

$doctor_id = $_GET['doctor_id'] ?? 0;
$date = $_GET['date'] ?? date('Y-m-d');

$day_of_week = date('l', strtotime($date));

$sql = "SELECT ds.*, t.start_time, t.end_time, b.branch_name 
        FROM doctor_schedule ds 
        JOIN timeslot t ON ds.timeslot_id = t.timeslot_id 
        JOIN branch b ON ds.branch_id = b.branch_id 
        WHERE ds.doctor_id = $doctor_id AND ds.day_of_week = '$day_of_week'";

$result = $conn->query($sql);
$schedule = [];

while ($row = $result->fetch_assoc()) {
    $schedule[] = $row;
}

echo json_encode($schedule);
?>