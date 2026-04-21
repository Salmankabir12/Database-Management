<?php
session_start();
include("db.php");

if (!isset($_SESSION['doctor_id'])) {
    die("Unauthorized");
}

$doctor_id = $_SESSION['doctor_id'];

$patient_id = $_POST['patient_id'];
$diagnosis = $_POST['diagnosis'];
$medicine = $_POST['medicine'];
$tests = $_POST['tests'];

$date = date("Y-m-d");

// SECURITY CHECK: ensure doctor-patient relation
$check = $conn->prepare("
SELECT * FROM appointment
WHERE doctor_id=? AND patient_id=?
LIMIT 1
");

$check->bind_param("ii", $doctor_id, $patient_id);
$check->execute();

if ($check->get_result()->num_rows == 0) {
    die("You cannot add history for this patient");
}

$sql = "INSERT INTO medical_history
(patient_id, doctor_id, diagnosis, prescribed_medicine, recommended_tests, visit_date)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "iissss",
    $patient_id,
    $doctor_id,
    $diagnosis,
    $medicine,
    $tests,
    $date
);

$stmt->execute();

echo "Medical history saved successfully!";
?>