<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("db.php");

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

/* =========================
   APPOINTMENTS
========================= */
$sql = "SELECT a.*, 
d.first_name as doctor, 
b.branch_name,
t.start_time, t.end_time, 
q.queue_number

FROM appointment a
JOIN doctor d ON a.doctor_id = d.doctor_id
JOIN branch b ON a.branch_id = b.branch_id
JOIN timeslot t ON a.slot_id = t.slot_id
LEFT JOIN queue q ON a.appointment_id = q.appointment_id

WHERE a.patient_id = ?
ORDER BY a.appointment_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$appointments = $stmt->get_result();


/* =========================
   MEDICAL HISTORY (FIXED)
========================= */
$history_sql = "
SELECT m.*, d.first_name as doctor
FROM medical_history m
JOIN doctor d ON m.doctor_id = d.doctor_id
WHERE m.patient_id=?
ORDER BY m.visit_date DESC
";

$stmt2 = $conn->prepare($history_sql);
$stmt2->bind_param("i", $patient_id);
$stmt2->execute();
$history = $stmt2->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Patient Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
<div class="container-fluid">

<a class="navbar-brand fw-bold" href="#">Healthcare System</a>

<div>
<a href="book_appointment.php" class="btn btn-light btn-sm me-2">Book</a>

<a href="my_queue.php" class="btn btn-outline-light btn-sm me-2">My Queue</a>
<a href="queue_status.php" class="btn btn-warning btn-sm me-2">Queue Status</a>
<a href="doctor_list.php" class="btn btn-info btn-sm me-2">Doctors</a>
<a href="logout.php" class="btn btn-danger btn-sm">Logout</a>

</div>

</div>
</nav>

<div class="container mt-5">

<!-- =========================
     APPOINTMENTS
========================= -->
<h2 class="text-primary mb-4">My Appointments</h2>

<table class="table table-bordered table-striped shadow">
<tr class="table-primary">
<th>#</th>
<th>Doctor</th>
<th>Branch</th>
<th>Date</th>
<th>Time</th>
<th>Token</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$serial = 1;
while($row = $appointments->fetch_assoc()){
?>
<tr>

<td><?= $serial++ ?></td>

<td><?= htmlspecialchars($row['doctor']) ?></td>

<td><?= htmlspecialchars($row['branch_name']) ?></td>

<td><?= $row['appointment_date'] ?></td>

<td><?= $row['start_time']." - ".$row['end_time'] ?></td>

<td>
<?= $row['queue_number'] 
    ? "Token #".$row['queue_number'] 
    : "Not assigned"; ?>
</td>

<td>
<span class="badge bg-<?php 
echo ($row['appointment_status']=='Pending')?'warning':
     (($row['appointment_status']=='Completed')?'success':'secondary'); ?>">
<?= $row['appointment_status']; ?>
</span>
</td>

<td>
<?php
if ($row['appointment_status'] == 'Pending') {
echo "<a class='btn btn-sm btn-danger' 
href='cancel_appointment.php?id=".$row['appointment_id']."'
onclick=\"return confirm('Cancel appointment?')\">
Cancel</a>";
} else {
echo "<span class='text-muted'>N/A</span>";
}
?>
</td>

</tr>
<?php } ?>
</table>


<!-- =========================
     MEDICAL HISTORY (NEW)
========================= -->
<h2 class="text-success mt-5 mb-4">My Medical History</h2>

<?php if ($history->num_rows > 0) { ?>

<table class="table table-bordered table-striped shadow">
<tr class="table-success">
<th>Date</th>
<th>Doctor</th>
<th>Diagnosis</th>
<th>Medicine</th>
<th>Tests</th>
</tr>

<?php while($row = $history->fetch_assoc()) { ?>
<tr>
<td><?= $row['visit_date'] ?></td>
<td><?= htmlspecialchars($row['doctor']) ?></td>
<td><?= htmlspecialchars($row['diagnosis']) ?></td>
<td><?= htmlspecialchars($row['prescribed_medicine']) ?></td>
<td><?= htmlspecialchars($row['recommended_tests']) ?></td>
</tr>
<?php } ?>

</table>

<?php } else { ?>

<div class="alert alert-info shadow">
No medical history found yet.
</div>

<?php } ?>

</div>

</body>
</html>