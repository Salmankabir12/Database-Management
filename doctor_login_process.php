<?php
session_start();
include("db.php");

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// ✅ BASIC VALIDATION
if (empty($email) || empty($password)) {
    echo "<div class='alert alert-danger'>All fields are required!</div>";
    exit();
}

$sql = "SELECT * FROM doctor WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {

    // 🔐 SECURE PASSWORD CHECK
    if (password_verify($password, $row['password'])) {

        $_SESSION['doctor_id'] = $row['doctor_id'];
        $_SESSION['doctor_name'] = $row['first_name'];

        header("Location: doctor_dashboard.php");
        exit();

    } else {
        echo "<div class='alert alert-danger'>Wrong password!</div>";
    }

} else {
    echo "<div class='alert alert-danger'>Doctor not found!</div>";
}
?>