<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthcare Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        .hero { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white; padding: 80px 0; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Healthcare System</a>
            <div class="navbar-nav ml-auto">
                <a class="nav-link" href="patient/register.php">Register</a>
                <a class="nav-link" href="patient/login.php">Patient Login</a>
                <a class="nav-link" href="doctor/doctor_login.php">Doctor Login</a>
                <a class="nav-link" href="admin/admin_login.php">Admin Login</a>
            </div>
        </div>
    </nav>
    
    <div class="hero text-center">
        <div class="container">
            <h1 class="display-4">Healthcare Management System</h1>
            <p class="lead">Book appointments, manage queues, and track medical history</p>
        </div>
    </div>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>For Patients</h5>
                        <p>Register, book appointments, and view your medical history.</p>
                        <a href="patient/register.php" class="btn btn-primary">Get Started</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>For Doctors</h5>
                        <p>Manage appointments and add medical records.</p>
                        <a href="doctor/doctor_login.php" class="btn btn-success">Doctor Portal</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>For Admins</h5>
                        <p>Confirm appointments and manage schedules.</p>
                        <a href="admin/admin_login.php" class="btn btn-dark">Admin Portal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="footer mt-5 py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">&copy; 2024 Healthcare Management System</span>
        </div>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>