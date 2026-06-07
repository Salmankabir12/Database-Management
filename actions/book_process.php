<?php
session_start();
include '../config/db.php';
if (!isset($_SESSION['patient_id'])) { die("Login first"); }
$patient_id = $_SESSION['patient_id'];
$doctor_id = $_POST['doctor_id'];
$branch_id = $_POST['branch_id'];
$timeslot_id = $_POST['timeslot_id'];
$date = $_POST['appointment_date'];
$today = date("Y-m-d");
if ($date < $today) { die("Invalid date"); }
$dup = $conn->prepare("SELECT appointment_id FROM appointment WHERE patient_id=? AND doctor_id=? AND appointment_date=? AND timeslot_id=?");
$dup->bind_param("iisi", $patient_id, $doctor_id, $date, $timeslot_id);
$dup->execute(); $dup->store_result();
if ($dup->num_rows > 0) { die("You have already booked this doctor on this date and time slot!"); }
$dup->close();
$day = date("l", strtotime($date));
$check = $conn->prepare("SELECT * FROM doctor_schedule WHERE doctor_id=? AND branch_id=? AND day_of_week=?");
$check->bind_param("iis", $doctor_id, $branch_id, $day);
$check->execute();
if ($check->get_result()->num_rows == 0) { die("Doctor not available in selected branch/day"); }
$stmt = $conn->prepare("SELECT max_patients FROM timeslot WHERE timeslot_id=?");
$stmt->bind_param("i", $timeslot_id);
$stmt->execute();
$slot = $stmt->get_result()->fetch_assoc();
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointment WHERE timeslot_id=? AND doctor_id=? AND appointment_date=?");
$stmt->bind_param("iis", $timeslot_id, $doctor_id, $date);
$stmt->execute();
if ($stmt->get_result()->fetch_assoc()['total'] >= $slot['max_patients']) { die("Slot full"); }
$stmt = $conn->prepare("INSERT INTO appointment (patient_id, doctor_id, branch_id, timeslot_id, appointment_date, status) VALUES (?, ?, ?, ?, ?, 'Pending')");
$stmt->bind_param("iiiis", $patient_id, $doctor_id, $branch_id, $timeslot_id, $date);
$stmt->execute();
$appointment_id = $stmt->insert_id;
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM queue q JOIN appointment a ON q.appointment_id=a.appointment_id WHERE a.doctor_id=? AND a.appointment_date=?");
$stmt->bind_param("is", $doctor_id, $date);
$stmt->execute();
$token = $stmt->get_result()->fetch_assoc()['total'] + 1;
$stmt = $conn->prepare("INSERT INTO queue (appointment_id, branch_id, token_number, status) VALUES (?, ?, ?, 'Waiting')");
$stmt->bind_param("iii", $appointment_id, $branch_id, $token);
$stmt->execute();
echo "Booked successfully! Token: " . $token;
