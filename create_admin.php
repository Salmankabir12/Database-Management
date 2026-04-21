<?php
include("db.php");

$name = "Admin";
$email = "admin@gmail.com";
$password = "admin123"; // you can change this

// 🔐 Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO admin (name, email, password, role, admin_status)
VALUES (?, ?, ?, 'manager', 'active')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $hashed_password);

if ($stmt->execute()) {
    echo "Admin created successfully!";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>