<?php
session_start();
include("db.php");

/* 🔐 CHECK LOGIN */
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

/* =========================
   FETCH DOCTORS (UPDATED)
========================= */
$sql = "SELECT doctor_id, first_name, email, phone, specialization, qualification, experience_years FROM doctor";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Doctor List</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
<div class="container-fluid">

<a class="navbar-brand fw-bold" href="#">Healthcare System</a>

<div>
<a href="patient_dashboard.php" class="btn btn-light btn-sm me-2">Dashboard</a>
<a href="book_appointment.php" class="btn btn-outline-light btn-sm me-2">Book</a>
<a href="doctor_list.php" class="btn btn-warning btn-sm me-2">Doctors</a>
<a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>

</div>
</nav>

<div class="container mt-5">

<h2 class="text-primary mb-4">Available Doctors</h2>

<?php if ($result->num_rows > 0) { ?>

<table class="table table-bordered table-striped shadow">
<tr class="table-primary">
<th>#</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Specialization</th>
<th>Qualification</th>
<th>Experience</th>
</tr>

<?php 
$i = 1;
while($row = $result->fetch_assoc()) { 
?>
<tr>

<td><?= $i++ ?></td>

<td><?= htmlspecialchars($row['first_name']) ?></td>

<td><?= htmlspecialchars($row['email']) ?></td>

<td><?= htmlspecialchars($row['phone'] ?? 'N/A') ?></td>

<td><?= htmlspecialchars($row['specialization']) ?></td>

<td><?= htmlspecialchars($row['qualification'] ?? 'N/A') ?></td>

<td>
<?= $row['experience_years'] !== null 
    ? htmlspecialchars($row['experience_years']) . " years" 
    : "N/A" ?>
</td>

</tr>
<?php } ?>

</table>

<?php } else { ?>

<div class="alert alert-info">No doctors available.</div>

<?php } ?>

<!-- 🔥 SINGLE BOOK BUTTON -->
<div class="text-center mt-4">
<a href="book_appointment.php" class="btn btn-success btn-lg">
Book Appointment
</a>
</div>

</div>

</body>
</html>