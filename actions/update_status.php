<?php
include '../config/db.php';

$appointment_id = $_GET['id'] ?? 0;
$status = $_GET['status'] ?? '';

if ($appointment_id && $status) {
    $conn->query("UPDATE appointment SET status = '$status' WHERE appointment_id = $appointment_id");
    
    if ($status == 'Ongoing') {
        $conn->query("UPDATE queue SET status = 'Serving' WHERE appointment_id = $appointment_id");
    } elseif ($status == 'Completed') {
        $conn->query("UPDATE queue SET status = 'Done' WHERE appointment_id = $appointment_id");
    }
    
    if (isset($_SESSION['admin_id'])) {
        header("Location: ../admin/admin_dashboard.php");
    } elseif (isset($_SESSION['doctor_id'])) {
        header("Location: ../doctor/doctor_dashboard.php");
    } else {
        header("Location: ../index.php");
    }
} else {
    header("Location: ../index.php");
}
exit;
?>