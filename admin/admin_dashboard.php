<?php
include '../config/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$pending = $conn->query("SELECT a.*, p.name as patient_name, d.name as doctor_name, t.start_time 
                        FROM appointment a 
                        JOIN patient p ON a.patient_id = p.patient_id 
                        JOIN doctor d ON a.doctor_id = d.doctor_id 
                        JOIN timeslot t ON a.timeslot_id = t.timeslot_id 
                        WHERE a.status = 'Pending' 
                        ORDER BY a.appointment_date, t.start_time");

$confirmed = $conn->query("SELECT a.*, p.name as patient_name, d.name as doctor_name, t.start_time, b.branch_name 
                           FROM appointment a 
                           JOIN patient p ON a.patient_id = p.patient_id 
                           JOIN doctor d ON a.doctor_id = d.doctor_id 
                           JOIN timeslot t ON a.timeslot_id = t.timeslot_id 
                           JOIN branch b ON a.branch_id = b.branch_id 
                           WHERE a.status = 'Confirmed' 
                           ORDER BY a.appointment_date, t.start_time");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Healthcare System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Portal</a>
            <div class="navbar-nav ml-auto">
                <a class="nav-link" href="../actions/logout.php">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Admin Dashboard</h2>
        <h3 class="mt-4">Pending Appointments</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $pending->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['appointment_date']; ?></td>
                    <td><?php echo $row['start_time']; ?></td>
                    <td><?php echo $row['patient_name']; ?></td>
                    <td><?php echo $row['doctor_name']; ?></td>
                    <td>
                        <a href="../actions/update_status.php?id=<?php echo $row['appointment_id']; ?>&status=Confirmed" class="btn btn-sm btn-success">Confirm</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <h3 class="mt-4">Confirmed Appointments</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Branch</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $confirmed->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['appointment_date']; ?></td>
                    <td><?php echo $row['start_time']; ?></td>
                    <td><?php echo $row['patient_name']; ?></td>
                    <td><?php echo $row['doctor_name']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php include '../common/footer.php'; ?>