<?php 
include("db.php");

function showError($msg) {
    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Registration Error</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body class='bg-light'>

        <div class='container mt-5'>
            <div class='alert alert-danger text-center shadow'>
                <h4>❌ Registration Failed</h4>
                <p>$msg</p>
                <a href='javascript:history.back()' class='btn btn-primary'>Go Back</a>
            </div>
        </div>

    </body>
    </html>
    ";
    exit();
}

$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$phone = trim($_POST['phone']);
$gender = $_POST['gender'];
$date_of_birth = $_POST['date_of_birth'];
$address = trim($_POST['address']);

// ✅ Required field validation
if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
    showError("All required fields must be filled!");
}

// ✅ Email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    showError("Invalid email format!");
}

// ✅ DOB validation
$today = date("Y-m-d");

if ($date_of_birth >= $today) {
    showError("Invalid Date of Birth! You must enter a past date.");
}

if (!strtotime($date_of_birth)) {
    showError("Invalid Date of Birth format!");
}

// ✅ Phone validation
if (!preg_match('/^[0-9]{11}$/', $phone)) {
    showError("Phone number must be exactly 11 digits!");
}

// ✅ Duplicate email check
$check_sql = "SELECT patient_id FROM patient WHERE email=?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    showError("Email already registered!");
}
$stmt->close();

// 🔐 Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// ✅ Insert
$sql = "INSERT INTO patient 
(first_name, last_name, email, password, phone, gender, date_of_birth, address)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssss",
    $first_name,
    $last_name,
    $email,
    $hashed_password,
    $phone,
    $gender,
    $date_of_birth,
    $address
);

if ($stmt->execute()) {
    echo "
    <div class='container mt-5'>
        <div class='alert alert-success text-center shadow'>
            <h4>✅ Registration Successful</h4>
            <a href='login.php' class='btn btn-success mt-2'>Go to Login</a>
        </div>
    </div>";
} else {
    showError($conn->error);
}

$stmt->close();
$conn->close();
?>