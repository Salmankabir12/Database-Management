<?php
include '../config/db.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit;
}

$patient_id = $_SESSION['patient_id'];
$sql = "SELECT * FROM appointment WHERE patient_id = $patient_id ORDER BY appointment_date DESC";
$appointments = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard - Healthcare System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include '../common/navbar.php'; ?>
    <div class="container mt-5">
        <h2>Welcome, <?php echo $_SESSION['patient_name']; ?>!</h2>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Book Appointment</h5>
                        <p>Schedule a new appointment with a doctor.</p>
                        <a href="book_appointment.php" class="btn btn-primary">Book Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Doctor List</h5>
                        <p>View available doctors and their specializations.</p>
                        <a href="doctor_list.php" class="btn btn-primary">View Doctors</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Medical History</h5>
                        <p>View your past medical records.</p>
                        <a href="view_medical_history.php" class="btn btn-primary">View History</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5>My Appointments</h5>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $appointments->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['appointment_date']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5>My Queue Status</h5>
                        <a href="my_queue.php" class="btn btn-info">View Queue</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="../actions/logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>
    <?php include '../common/footer.php'; ?>