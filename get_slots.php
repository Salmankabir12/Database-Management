<?php
include("db.php");

$doctor_id = $_GET['doctor_id'];
$date = $_GET['date'];
$branch_id = $_GET['branch_id'];

$day = date("l", strtotime($date));

$sql = "SELECT t.slot_id, t.start_time, t.end_time, t.max_patients,
COUNT(a.appointment_id) as booked
FROM timeslot t
JOIN doctor_schedule s 
ON t.start_time >= s.start_time 
AND t.end_time <= s.end_time
LEFT JOIN appointment a
ON a.slot_id = t.slot_id
AND a.appointment_date = ?
AND a.doctor_id = ?
AND a.branch_id = ?
WHERE s.doctor_id = ?
AND s.branch_id = ?
AND s.day_of_week = ?
GROUP BY t.slot_id";

$stmt = $conn->prepare($sql);
$stmt->bind_param("siiiss", $date, $doctor_id, $branch_id, $doctor_id, $branch_id, $day);
$stmt->execute();

$result = $stmt->get_result();

$slots = [];

while($row = $result->fetch_assoc()){
    if ($row['booked'] < $row['max_patients']) {
        $slots[] = $row;
    }
}

echo json_encode($slots);