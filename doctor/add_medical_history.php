<?php
include '../config/db.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit;
}

$doctor_id = $_SESSION['doctor_id'];
$sql = "SELECT a.appointment_id, p.name as patient_name, a.appointment_date 
        FROM appointment a 
        JOIN patient p ON a.patient_id = p.patient_id 
        WHERE a.doctor_id = $doctor_id AND a.status = 'Ongoing'";
$patients = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $diagnosis = $_POST['diagnosis'];
    $medicines = $_POST['medicines'];
    $tests = $_POST['tests'];
    $notes = $_POST['notes'];

    $apt_result = $conn->query("SELECT patient_id FROM appointment WHERE appointment_id = $appointment_id");
    $apt_row = $apt_result->fetch_assoc();
    $patient_id = $apt_row['patient_id'];

    $sql = "INSERT INTO medical_history (patient_id, doctor_id, appointment_id, diagnosis, medicines, tests, notes) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiissss", $patient_id, $doctor_id, $appointment_id, $diagnosis, $medicines, $tests, $notes);

    if ($stmt->execute()) {
        header("Location: doctor_dashboard.php?success=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medical History - Healthcare System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">Doctor Portal</a>
            <div class="navbar-nav ml-auto">
                <a class="nav-link" href="doctor_dashboard.php">Dashboard</a>
                <a class="nav-link" href="../actions/logout.php">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4>Add Medical History</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label>Select Patient (Ongoing Appointment)</label>
                                <select name="appointment_id" class="form-control" required>
                                    <option value="">-- Select Patient --</option>
                                    <?php while ($row = $patients->fetch_assoc()): ?>
                                    <option value="<?php echo $row['appointment_id']; ?>">
                                        <?php echo $row['patient_name'] . ' - ' . $row['appointment_date']; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Diagnosis</label>
                                <textarea name="diagnosis" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Medicines</label>
                                <textarea name="medicines" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Tests</label>
                                <textarea name="tests" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Notes</label>
                                <textarea name="notes" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Save Medical History</button>
                            <a href="doctor_dashboard.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../common/footer.php'; ?>