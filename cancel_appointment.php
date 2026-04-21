<?php
session_start();
include("db.php");

// 🔐 Check login
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

// ✅ VALIDATION
if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>Invalid request!</div>";
    exit();
}

$id = $_GET['id'];
$patient_id = $_SESSION['patient_id'];

// 🔵 UPDATE APPOINTMENT
$sql = "UPDATE appointment
SET appointment_status='Cancelled'
WHERE appointment_id=? AND patient_id=?";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ii", $id, $patient_id);

    if ($stmt->execute()) {

        // 🔵 ALSO UPDATE QUEUE
        $q = "UPDATE queue SET queue_status='Cancelled' WHERE appointment_id=?";
        $stmt2 = $conn->prepare($q);
        $stmt2->bind_param("i", $id);
        $stmt2->execute();

        // ✅ SUCCESS REDIRECT
        header("Location: patient_dashboard.php");
        exit();

    } else {
        echo "<div class='alert alert-danger'>Cancel failed!</div>";
        exit();
    }

} else {
    echo "<div class='alert alert-danger'>Database error!</div>";
    exit();
}
?>