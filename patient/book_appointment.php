<?php
include '../config/db.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit;
}

$doctors = $conn->query("SELECT * FROM doctor");
$branches = $conn->query("SELECT * FROM branch");
$timeslots = $conn->query("SELECT * FROM timeslot");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $branch_id = $_POST['branch_id'];
    $timeslot_id = $_POST['timeslot_id'];
    $appointment_date = $_POST['appointment_date'];

    $sql = "INSERT INTO appointment (patient_id, doctor_id, branch_id, timeslot_id, appointment_date, status) 
            VALUES (?, ?, ?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $patient_id = $_SESSION['patient_id'];
    $stmt->bind_param("iiiss", $patient_id, $doctor_id, $branch_id, $timeslot_id, $appointment_date);

    if ($stmt->execute()) {
        $appointment_id = $conn->insert_id;
        $token_result = $conn->query("SELECT MAX(token_number) as max_token FROM queue WHERE appointment_id IN (SELECT appointment_id FROM appointment WHERE appointment_date = '$appointment_date' AND doctor_id = $doctor_id)");
        $token_row = $token_result->fetch_assoc();
        $token_number = ($token_row['max_token'] ?? 0) + 1;

        $conn->query("INSERT INTO queue (appointment_id, token_number, status) VALUES ($appointment_id, $token_number, 'Waiting')");

        header("Location: view_appointment.php?success=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - Healthcare System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include '../common/navbar.php'; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Book Appointment</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label>Select Doctor</label>
                                <select name="doctor_id" class="form-control" required>
                                    <option value="">-- Select Doctor --</option>
                                    <?php while ($row = $doctors->fetch_assoc()): ?>
                                    <option value="<?php echo $row['doctor_id']; ?>">
                                        <?php echo $row['name'] . ' - ' . $row['specialization']; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Branch</label>
                                <select name="branch_id" class="form-control" required>
                                    <option value="">-- Select Branch --</option>
                                    <?php while ($row = $branches->fetch_assoc()): ?>
                                    <option value="<?php echo $row['branch_id']; ?>">
                                        <?php echo $row['branch_name']; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Date</label>
                                <input type="date" name="appointment_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Select Time Slot</label>
                                <select name="timeslot_id" class="form-control" required>
                                    <option value="">-- Select Time Slot --</option>
                                    <?php while ($row = $timeslots->fetch_assoc()): ?>
                                    <option value="<?php echo $row['timeslot_id']; ?>">
                                        <?php echo $row['start_time'] . ' - ' . $row['end_time']; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Book Appointment</button>
                            <a href="patient_dashboard.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../common/footer.php'; ?>