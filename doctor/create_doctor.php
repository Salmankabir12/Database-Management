<?php
include '../config/db.php';
$name = "Dr. John"; $email = "doctor@gmail.com";
$password = password_hash("123456", PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO doctor (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $password);
$stmt->execute();
echo "Doctor created!";
