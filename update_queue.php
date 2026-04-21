<?php
session_start();
include("db.php");

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit();
}

$id = $_GET['id'];
$status = $_GET['status'];

$sql = "UPDATE queue SET queue_status=? WHERE queue_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id);
$stmt->execute();

header("Location: doctor_dashboard.php");
?>