<?php
session_start();
include("db.php");

if (!isset($_SESSION['patient_id'])) {
header("Location: login.php");
exit();
}

$patient_id = $_SESSION['patient_id'];

$sql = "SELECT q.queue_number, q.queue_status,
a.appointment_date,
d.first_name as doctor
FROM queue q
JOIN appointment a ON q.appointment_id = a.appointment_id
JOIN doctor d ON a.doctor_id = d.doctor_id
WHERE a.patient_id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>My Queue</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<h2>My Queue</h2>

<table class="table table-bordered">
<tr class="table-primary">
<th>Doctor</th>
<th>Date</th>
<th>Token</th>
<th>Status</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
<td><?= $row['doctor'] ?></td>
<td><?= $row['appointment_date'] ?></td>
<td>Token #<?= $row['queue_number'] ?></td>
<td><?= $row['queue_status'] ?></td>
</tr>
<?php } ?>

</table>

</div>
</body>
</html>