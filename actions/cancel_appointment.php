<?php
include '../config/db.php';

$appointment_id = $_GET['id'] ?? 0;

if ($appointment_id) {
    $conn->query("UPDATE appointment SET status = 'Cancelled' WHERE appointment_id = $appointment_id");
    $conn->query("UPDATE queue SET status = 'Done' WHERE appointment_id = $appointment_id");
}

if (isset($_SESSION['patient_id'])) {
    header("Location: ../patient/view_appointment.php");
} else {
    header("Location: ../index.php");
}
exit;
?>