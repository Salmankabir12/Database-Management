<?php
include("db.php");

$name = "Dr. John";
$email = "doctor@gmail.com";
$password = password_hash("123456", PASSWORD_DEFAULT);

$sql = "INSERT INTO doctor (first_name, email, password)
VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $password);
$stmt->execute();

echo "Doctor created!";
?>