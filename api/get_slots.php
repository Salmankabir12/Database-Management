<?php
include '../config/db.php';

header('Content-Type: application/json');

$doctor_id = $_GET['doctor_id'] ?? 0;
$branch_id = $_GET['branch_id'] ?? 0;
$date = $_GET['date'] ?? date('Y-m-d');

$result = $conn->query("SELECT * FROM timeslot");
$slots = [];

while ($row = $result->fetch_assoc()) {
    $check = $conn->query("SELECT COUNT(*) as cnt FROM appointment 
                          WHERE doctor_id = $doctor_id AND branch_id = $branch_id 
                          AND appointment_date = '$date' AND timeslot_id = " . $row['timeslot_id'] . " 
                          AND status != 'Cancelled'");
    $check_row = $check->fetch_assoc();
    
    $row['available'] = $check_row['cnt'] == 0;
    $slots[] = $row;
}

echo json_encode($slots);
?>