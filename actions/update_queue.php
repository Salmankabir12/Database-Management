<?php
session_start();
include '../config/db.php';
if (!isset($_SESSION['doctor_id'])) { header("Location: ../doctor/doctor_login.php"); exit(); }
$id = $_GET['id'];
$status = $_GET['status'];
$stmt = $conn->prepare("UPDATE queue SET status=? WHERE queue_id=?");
$stmt->bind_param("si", $status, $id);
$stmt->execute();
header("Location: ../doctor/doctor_dashboard.php");
