<!DOCTYPE html>
<html>
<head>
    <title>Patient Registration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .register-card {
            max-width: 650px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            background: #fff;
        }

        .form-title {
            text-align: center;
            margin-bottom: 20px;
            color: #0d6efd;
            font-weight: bold;
        }

        /* BACK BUTTON */
        .back-btn {
            display: inline-block;
            margin-bottom: 15px;
            text-decoration: none;
            font-size: 14px;
            color: #0d6efd;
            font-weight: 500;
        }

        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="register-card">

    <!-- BACK TO PORTAL -->
    <a href="index.php" class="back-btn">← Back to Portal</a>

    <h2 class="form-title">Patient Registration</h2>

    <form action="register_process.php" method="POST">

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label">First Name *</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Last Name *</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>

        </div>

        <div class="mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password *</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control"
                       pattern="[0-9]{11}"
                       minlength="11"
                       maxlength="11"
                       title="Phone number must be exactly 11 digits"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

        </div>

        <div class="mb-3">
            <label class="form-label">Date of Birth *</label>
            <input type="date" name="date_of_birth" id="dob" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Register
        </button>

        <p class="text-center mt-3">
            Already have an account? <a href="login.php">Login</a>
        </p>

    </form>

</div>

<!-- BLOCK TODAY + FUTURE DATES -->
<script>
    const dob = document.getElementById("dob");

    const today = new Date();
    today.setHours(0,0,0,0);

    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');

    const maxDate = `${yyyy}-${mm}-${dd}`;

    dob.setAttribute("max", maxDate);
</script>

</body>
</html>