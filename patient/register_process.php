<?php
include '../config/db.php';
function showError($msg) { echo "<div class='container mt-5'><div class='alert alert-danger text-center shadow'><h4>Registration Failed</h4><p>$msg</p><a href='javascript:history.back()' class='btn btn-primary'>Go Back</a></div></div>"; exit(); }
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');
if (empty($name) || empty($email) || empty($password)) { showError("All required fields must be filled!"); }
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { showError("Invalid email format!"); }
$check_sql = "SELECT patient_id FROM patient WHERE email=?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("s", $email);
$stmt->execute(); $stmt->store_result();
if ($stmt->num_rows > 0) { showError("Email already registered!"); }
$stmt->close();
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO patient (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $address);
if ($stmt->execute()) { echo "<div class='container mt-5'><div class='alert alert-success text-center shadow'><h4>Registration Successful</h4><a href='login.php' class='btn btn-success mt-2'>Go to Login</a></div></div>"; }
else { showError($conn->error); }
$stmt->close();
$conn->close();
