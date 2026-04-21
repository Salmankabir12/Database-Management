<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$view = $_GET['view'] ?? 'appointments';
$search = $_GET['search'] ?? '';

/* =========================
   APPOINTMENTS
========================= */
$sql = "SELECT a.*, 
p.first_name as patient, 
d.first_name as doctor, 
b.branch_name, 
t.start_time, t.end_time
FROM appointment a
JOIN patient p ON a.patient_id=p.patient_id
JOIN doctor d ON a.doctor_id=d.doctor_id
JOIN branch b ON a.branch_id=b.branch_id
JOIN timeslot t ON a.slot_id=t.slot_id
ORDER BY a.appointment_date ASC, t.start_time ASC";

$result = $conn->query($sql);

/* =========================
   SCHEDULE
========================= */
$schedule_sql = "
SELECT ds.*, 
d.first_name as doctor_name,
b.branch_name
FROM doctor_schedule ds
JOIN doctor d ON ds.doctor_id = d.doctor_id
JOIN branch b ON ds.branch_id = b.branch_id
ORDER BY ds.day_of_week ASC, ds.start_time ASC
";
$schedule_result = $conn->query($schedule_sql);

/* =========================
   DOCTOR LIST + TOTAL APPOINTMENTS
========================= */
$doctor_sql = "
SELECT d.*,
(SELECT COUNT(*) 
 FROM appointment a 
 WHERE a.doctor_id = d.doctor_id) as total_appointments
FROM doctor d
ORDER BY d.first_name ASC
";
$doctor_result = $conn->query($doctor_sql);

/* =========================
   REPORT (GROUP BY)
========================= */
$report_sql = "
SELECT b.branch_name, COUNT(a.appointment_id) as total
FROM appointment a
JOIN branch b ON a.branch_id = b.branch_id
GROUP BY b.branch_name
";
$report_result = $conn->query($report_sql);

/* =========================
   SPECIALIZATION LIST (NEW)
========================= */
$spec_sql = "SELECT DISTINCT specialization FROM doctor";
$spec_result = $conn->query($spec_sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<div class="bg-primary text-white p-3 d-flex justify-content-between align-items-center shadow">

    <h4 class="m-0">Healthcare System</h4>

    <div>
        <a href="admin_dashboard.php" class="btn btn-light btn-sm">Dashboard</a>
        <a href="admin_dashboard.php?view=schedule" class="btn btn-warning btn-sm">Doctor Schedule</a>
        <a href="admin_dashboard.php?view=doctors" class="btn btn-info btn-sm">Doctors</a>
        <a href="admin_dashboard.php?view=search" class="btn btn-success btn-sm">Search Doctors</a>
        <a href="admin_dashboard.php?view=top" class="btn btn-dark btn-sm">Top Doctors</a>
        <a href="admin_dashboard.php?view=report" class="btn btn-success btn-sm">Reports</a>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>

</div>

<div class="container mt-4">

<?php if ($view == 'schedule') { ?>

<!-- ================= SCHEDULE ================= -->
<h2 class="text-primary mb-4">Doctor Schedule</h2>

<table class="table table-bordered table-striped shadow">
<tr class="table-dark">
    <th>#</th>
    <th>Doctor</th>
    <th>Branch</th>
    <th>Day</th>
    <th>Start Time</th>
    <th>End Time</th>
</tr>

<?php $i = 1; while($row = $schedule_result->fetch_assoc()) { ?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= $row['doctor_name'] ?></td>
    <td><?= $row['branch_name'] ?></td>
    <td><?= $row['day_of_week'] ?></td>
    <td><?= $row['start_time'] ?></td>
    <td><?= $row['end_time'] ?></td>
</tr>
<?php } ?>
</table>

<?php } elseif ($view == 'doctors') { ?>

<!-- ================= DOCTORS ================= -->
<h2 class="text-info mb-4">All Doctors</h2>

<table class="table table-bordered table-striped shadow">
<tr class="table-info">
    <th>#</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Specialization</th>
    <th>Qualification</th>
    <th>Experience</th>
    <th>Total Appointments</th>
</tr>

<?php $i = 1; while($row = $doctor_result->fetch_assoc()) { ?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= $row['first_name']." ".$row['last_name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['phone'] ?></td>
    <td><?= $row['specialization'] ?></td>
    <td><?= $row['qualification'] ?></td>
    <td><?= $row['experience_years']." yrs" ?></td>
    <td><?= $row['total_appointments'] ?></td>
</tr>
<?php } ?>
</table>

<?php } elseif ($view == 'report') { ?>

<!-- ================= REPORT ================= -->
<h2 class="text-success mb-4">Appointments per Branch</h2>

<table class="table table-bordered table-striped shadow">
<tr class="table-success">
    <th>Branch</th>
    <th>Total Appointments</th>
</tr>

<?php while($row = $report_result->fetch_assoc()) { ?>
<tr>
    <td><?= $row['branch_name'] ?></td>
    <td><?= $row['total'] ?></td>
</tr>
<?php } ?>
</table>

<?php } elseif ($view == 'search') { ?>

<!-- ================= SEARCH DOCTORS (DROPDOWN) ================= -->
<h2 class="text-success mb-4">Search Doctors</h2>

<form method="GET" class="mb-3">
    <input type="hidden" name="view" value="search">

    <select name="search" class="form-select">
        <option value="">Select Specialization</option>

        <?php while($row = $spec_result->fetch_assoc()) { ?>
            <option value="<?= $row['specialization'] ?>"
                <?= ($search == $row['specialization']) ? 'selected' : '' ?>>
                <?= $row['specialization'] ?>
            </option>
        <?php } ?>

    </select>

    <button class="btn btn-success mt-2">Search</button>
</form>

<table class="table table-bordered table-striped shadow">
<tr class="table-success">
    <th>Name</th>
    <th>Phone</th>
    <th>Specialization</th>
    <th>Experience</th>
</tr>

<?php
if (!empty($search)) {
    $sql = "SELECT * FROM doctor 
            WHERE specialization = '$search'";

    $res = $conn->query($sql);

    while($row = $res->fetch_assoc()) {
        echo "<tr>
        <td>{$row['first_name']} {$row['last_name']}</td>
        <td>{$row['phone']}</td>
        <td>{$row['specialization']}</td>
        <td>{$row['experience_years']} yrs</td>
        </tr>";
    }
}
?>
</table>

<?php } elseif ($view == 'top') { ?>

<!-- ================= TOP DOCTOR ================= -->
<h2 class="text-dark mb-4">Top Experienced Doctor</h2>

<?php
$sql = "SELECT * FROM doctor
WHERE experience_years = (
    SELECT MAX(experience_years) FROM doctor
)";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo "<div class='alert alert-info shadow'>
    <b>Dr. {$row['first_name']} {$row['last_name']}</b><br>
    Specialization: {$row['specialization']}<br>
    Experience: {$row['experience_years']} years<br>
    Phone: {$row['phone']}
    </div>";
}
?>

<?php } else { ?>

<!-- ================= APPOINTMENTS ================= -->
<h2 class="text-primary mb-4">All Appointments</h2>

<table class="table table-bordered table-striped shadow">
<tr class="table-primary">
    <th>#</th>
    <th>Patient</th>
    <th>Doctor</th>
    <th>Branch</th>
    <th>Date</th>
    <th>Time</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php $serial = 1; while($row = $result->fetch_assoc()) { 
$status = $row['appointment_status'];
?>
<tr>
    <td><?= $serial++ ?></td>
    <td><?= $row['patient'] ?></td>
    <td><?= $row['doctor'] ?></td>
    <td><?= $row['branch_name'] ?></td>
    <td><?= $row['appointment_date'] ?></td>
    <td><?= $row['start_time']." - ".$row['end_time'] ?></td>

    <td>
        <span class="badge bg-<?=
        ($status=='Pending') ? 'warning' :
        (($status=='Confirmed') ? 'primary' :
        (($status=='Completed') ? 'success' : 'secondary'))
        ?>">
        <?= $status ?>
        </span>
    </td>

    <td>
        <?php
        if ($status == "Pending") {
            echo "<a class='btn btn-success btn-sm'
            href='update_status.php?id=".$row['appointment_id']."&status=Confirmed'>
            Confirm</a>";
        }
        elseif ($status == "Confirmed") {
            echo "<span class='text-primary'>Confirmed</span>";
        }
        else {
            echo "<span class='text-muted'>No Action</span>";
        }
        ?>
    </td>
</tr>
<?php } ?>
</table>

<?php } ?>

</div>

</body>
</html>