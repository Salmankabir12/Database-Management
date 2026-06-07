<?php
include '../config/db.php';
$name = "Admin"; $email = "admin@gmail.com"; $password = "admin123";
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO admin (name, email, password, role, admin_status) VALUES (?, ?, ?, 'manager', 'active')");
$stmt->bind_param("sss", $name, $email, $hashed_password);
echo $stmt->execute() ? "Admin created successfully!" : "Error: " . $conn->error;
$stmt->close(); $conn->close();
