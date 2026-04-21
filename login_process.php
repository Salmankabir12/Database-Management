<?php
session_start();
include("db.php");

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// ✅ VALIDATION
if (empty($email) || empty($password)) {
    echo "<div class='alert alert-danger'>All fields are required!</div>";
    exit();
}

// ✅ CHECK USER
$sql = "SELECT * FROM patient WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // 🔐 PASSWORD VERIFY (already correct ✔)
    if (password_verify($password, $row['password'])) {

        $_SESSION['patient_id'] = $row['patient_id'];
        $_SESSION['patient_name'] = $row['first_name'];

        header("Location: patient_dashboard.php");
        exit();

    } else {
        echo "<div class='alert alert-danger'>Incorrect password!</div>";
    }

} else {
    echo "<div class='alert alert-danger'>Email not found!</div>";
}

$stmt->close();
$conn->close();
?>