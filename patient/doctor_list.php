<?php
include '../config/db.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit;
}

$doctors = $conn->query("SELECT * FROM doctor");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor List - Healthcare System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include '../common/navbar.php'; ?>
    <div class="container mt-5">
        <h2>Available Doctors</h2>
        <div class="row mt-4">
            <?php while ($row = $doctors->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5><?php echo $row['name']; ?></h5>
                        <p class="text-muted"><?php echo $row['specialization']; ?></p>
                        <p>Email: <?php echo $row['email']; ?></p>
                        <p>Phone: <?php echo $row['phone']; ?></p>
                        <a href="book_appointment.php?doctor_id=<?php echo $row['doctor_id']; ?>" class="btn btn-primary">Book Appointment</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <a href="patient_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
    <?php include '../common/footer.php'; ?>