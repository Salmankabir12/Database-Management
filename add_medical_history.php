<?php
session_start();
include("db.php");

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

$result = $conn->prepare("
SELECT DISTINCT p.patient_id, p.first_name
FROM appointment a
JOIN patient p ON a.patient_id = p.patient_id
WHERE a.doctor_id = ?
");
$result->bind_param("i", $doctor_id);
$result->execute();
$res = $result->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Medical History</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
<div class="container-fluid">

<a class="navbar-brand fw-bold">Healthcare System</a>

<div>
<a href="doctor_dashboard.php" class="btn btn-light btn-sm me-2">Dashboard</a>
<a href="add_medical_history.php" class="btn btn-warning btn-sm me-2">Add History</a>
<a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>

</div>
</nav>

<!-- CONTENT -->
<div class="container mt-5">

<div class="card shadow">
<div class="card-header bg-primary text-white">
<h5 class="mb-0">Add Medical History</h5>
</div>

<div class="card-body">

<form action="save_medical_history.php" method="POST">

<!-- PATIENT -->
<div class="mb-3">
<label class="form-label fw-bold">Select Patient</label>
<select name="patient_id" class="form-select" required>
<option value="">-- Choose Patient --</option>
<?php while($row = $res->fetch_assoc()) { ?>
<option value="<?php echo $row['patient_id']; ?>">
<?php echo htmlspecialchars($row['first_name']); ?>
</option>
<?php } ?>
</select>
</div>

<!-- DIAGNOSIS -->
<div class="mb-3">
<label class="form-label fw-bold">Diagnosis</label>
<textarea name="diagnosis" class="form-control" rows="3" required></textarea>
</div>

<!-- MEDICINE -->
<div class="mb-3">
<label class="form-label fw-bold">Prescribed Medicine</label>
<textarea name="medicine" class="form-control" rows="3"></textarea>
</div>

<!-- TESTS -->
<div class="mb-3">
<label class="form-label fw-bold">Recommended Tests</label>
<textarea name="tests" class="form-control" rows="3"></textarea>
</div>

<!-- BUTTON -->
<div class="d-flex justify-content-end">
<button type="submit" class="btn btn-success px-4">Save Record</button>
</div>

</form>

</div>
</div>

</div>

</body>
</html>