<?php
session_start();
include("db.php");

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];
$doctor_name = $_SESSION['doctor_name'] ?? "Doctor";

/* =========================
   APPOINTMENTS
========================= */
$sql = "SELECT a.*, 
p.first_name as patient, 
b.branch_name, 
t.start_time, t.end_time,
q.queue_number

FROM appointment a
JOIN patient p ON a.patient_id = p.patient_id
JOIN branch b ON a.branch_id = b.branch_id
JOIN timeslot t ON a.slot_id = t.slot_id
LEFT JOIN queue q ON a.appointment_id = q.appointment_id

WHERE a.doctor_id = ?
AND a.appointment_date >= CURDATE()

ORDER BY a.appointment_date ASC, t.start_time ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Doctor Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
<div class="container-fluid">

<a class="navbar-brand fw-bold" href="#">Healthcare System</a>

<div>
<a href="doctor_dashboard.php" class="btn btn-light btn-sm me-2">Dashboard</a>
<a href="add_medical_history.php" class="btn btn-warning btn-sm me-2">Add History</a>
<a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>

</div>
</nav>

<div class="container mt-4">

<!-- WELCOME -->
<h3 class="text-success">Welcome, Dr. <?= htmlspecialchars($doctor_name) ?></h3>
<h2 class="text-primary mt-3 mb-4">Appointments (Today & Upcoming)</h2>

<table class="table table-bordered table-striped shadow">
<tr class="table-primary">
<th>#</th>
<th>Patient</th>
<th>Branch</th>
<th>Date</th>
<th>Time</th>
<th>Token</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$i = 1;

while($row = $result->fetch_assoc()){
?>
<tr>

<td><?php echo $i++; ?></td>
<td><?php echo htmlspecialchars($row['patient']); ?></td>
<td><?php echo htmlspecialchars($row['branch_name']); ?></td>
<td><?php echo $row['appointment_date']; ?></td>
<td><?php echo $row['start_time']." - ".$row['end_time']; ?></td>

<td>
<?php echo $row['queue_number'] ? "Token #".$row['queue_number'] : "N/A"; ?>
</td>

<td>
<span class="badge bg-<?php
echo ($row['appointment_status']=='Pending') ? 'warning' :
     (($row['appointment_status']=='Confirmed') ? 'primary' :
     (($row['appointment_status']=='Ongoing') ? 'info' :
     (($row['appointment_status']=='Completed') ? 'success' : 'secondary')));
?>">
<?php echo $row['appointment_status']; ?>
</span>
</td>

<td>
<?php
if ($row['appointment_status'] == 'Pending') {
    echo "<span class='text-muted'>Waiting for admin</span>";
}
elseif ($row['appointment_status'] == 'Confirmed') {
    echo "<a class='btn btn-success btn-sm'
    href='update_status.php?id=".$row['appointment_id']."&status=Ongoing&source=doctor'>
    Start</a>";
}
elseif ($row['appointment_status'] == 'Ongoing') {
    echo "<a class='btn btn-primary btn-sm'
    href='update_status.php?id=".$row['appointment_id']."&status=Completed&source=doctor'>
    Complete</a>";
}
else {
    echo "<span class='text-muted'>Done</span>";
}
?>
</td>

</tr>
<?php } ?>

</table>

<!-- =========================
     MY QUEUE
========================= -->

<hr>
<h3 class="text-primary mt-5">My Queue</h3>

<?php
$q = $conn->prepare("
SELECT q.queue_number, q.queue_status,
p.first_name as patient,
a.appointment_date
FROM queue q
JOIN appointment a ON q.appointment_id = a.appointment_id
JOIN patient p ON a.patient_id = p.patient_id
WHERE a.doctor_id=?
ORDER BY a.appointment_date ASC, q.queue_number ASC
");

$q->bind_param("i", $doctor_id);
$q->execute();
$res = $q->get_result();
?>

<table class="table table-bordered shadow mt-3">
<tr class="table-dark">
<th>Token</th>
<th>Patient</th>
<th>Date</th>
<th>Status</th>
</tr>

<?php while($row = $res->fetch_assoc()) { ?>
<tr>
<td>Token #<?= $row['queue_number'] ?></td>
<td><?= htmlspecialchars($row['patient']) ?></td>
<td><?= $row['appointment_date'] ?></td>
<td>
<span class="badge bg-<?=
$row['queue_status']=='Waiting' ? 'warning' :
($row['queue_status']=='Serving' ? 'primary' :
($row['queue_status']=='Done' ? 'success' : 'secondary'))
?>">
<?= $row['queue_status'] ?>
</span>
</td>
</tr>
<?php } ?>

</table>

</div>

</body>
</html>