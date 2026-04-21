<?php
session_start();
include("db.php");

if (!isset($_SESSION['patient_id'])) {
    die("Login first");
}

$patient_id = $_SESSION['patient_id'];

$doctor_id = $_POST['doctor_id'];
$branch_id = $_POST['branch_id'];
$slot_id = $_POST['slot_id'];
$date = $_POST['appointment_date'];
$reason = $_POST['reason_for_visit'];

$today = date("Y-m-d");

if ($date < $today) {
    die("Invalid date");
}

/* ✅ NEW: PREVENT DUPLICATE BOOKING */
$dup = $conn->prepare("
SELECT appointment_id FROM appointment
WHERE patient_id=? AND doctor_id=? AND appointment_date=? AND slot_id=?
");
$dup->bind_param("iisi", $patient_id, $doctor_id, $date, $slot_id);
$dup->execute();
$dup->store_result();

if ($dup->num_rows > 0) {
    die("You have already booked this doctor on this date and time slot!");
}
$dup->close();

/* ✔ VALIDATE DOCTOR SCHEDULE EXISTS */
$day = date("l", strtotime($date));

$check = $conn->prepare("
SELECT * FROM doctor_schedule
WHERE doctor_id=? AND branch_id=? AND day_of_week=?
");
$check->bind_param("iis", $doctor_id, $branch_id, $day);
$check->execute();
$res = $check->get_result();

if ($res->num_rows == 0) {
    die("Doctor not available in selected branch/day");
}

/* SLOT CAPACITY CHECK */
$stmt = $conn->prepare("SELECT max_patients FROM timeslot WHERE slot_id=?");
$stmt->bind_param("i", $slot_id);
$stmt->execute();
$slot = $stmt->get_result()->fetch_assoc();

$stmt = $conn->prepare("
SELECT COUNT(*) as total 
FROM appointment 
WHERE slot_id=? AND doctor_id=? AND appointment_date=?
");
$stmt->bind_param("iis", $slot_id, $doctor_id, $date);
$stmt->execute();
$count = $stmt->get_result()->fetch_assoc()['total'];

if ($count >= $slot['max_patients']) {
    die("Slot full");
}

/* INSERT APPOINTMENT */
$stmt = $conn->prepare("
INSERT INTO appointment 
(patient_id, doctor_id, branch_id, slot_id, appointment_date, appointment_status, reason_for_visit)
VALUES (?, ?, ?, ?, ?, 'Pending', ?)
");

$stmt->bind_param("iiiiss",
    $patient_id,
    $doctor_id,
    $branch_id,
    $slot_id,
    $date,
    $reason
);

$stmt->execute();
$appointment_id = $stmt->insert_id;

/* QUEUE */
$stmt = $conn->prepare("
SELECT COUNT(*) as total 
FROM queue q
JOIN appointment a ON q.appointment_id=a.appointment_id
WHERE a.doctor_id=? AND a.appointment_date=?
");
$stmt->bind_param("is", $doctor_id, $date);
$stmt->execute();

$token = $stmt->get_result()->fetch_assoc()['total'] + 1;

$stmt = $conn->prepare("
INSERT INTO queue (appointment_id, branch_id, queue_number, queue_status)
VALUES (?, ?, ?, 'Waiting')
");
$stmt->bind_param("iii", $appointment_id, $branch_id, $token);
$stmt->execute();

echo "Booked successfully! Token: " . $token;
?>