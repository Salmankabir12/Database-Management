<?php
session_start();
include("db.php");

/* SECURITY: allow only logged-in users */
if (!isset($_SESSION['doctor_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

/* GET DATA */
$id = $_GET['id'] ?? null;
$status = $_GET['status'] ?? null;

if (!$id || !$status) {
    die("Invalid request");
}

/* VALID STATUSES */
$allowed = ['Confirmed', 'Ongoing', 'Completed'];

if (!in_array($status, $allowed)) {
    die("Invalid status");
}

/* UPDATE APPOINTMENT */
$stmt = $conn->prepare("
UPDATE appointment 
SET appointment_status=? 
WHERE appointment_id=?
");
$stmt->bind_param("si", $status, $id);
$stmt->execute();

/* UPDATE QUEUE */
if ($status == 'Ongoing') {
    $stmt = $conn->prepare("
    UPDATE queue 
    SET queue_status='Serving' 
    WHERE appointment_id=?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

if ($status == 'Completed') {
    $stmt = $conn->prepare("
    UPDATE queue 
    SET queue_status='Done' 
    WHERE appointment_id=?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

/* ✅ SIMPLE FIX: ALWAYS RETURN BACK */
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    header("Location: doctor_dashboard.php");
}

exit();
?>