<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
<title>Patient Login</title>

<style>
body{
    font-family:Arial;
    background:#f5f7fb;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box{
    background:white;
    padding:40px;
    border-radius:15px;
    width:320px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    text-align:center;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
}

button{
    width:100%;
    padding:10px;
    background:#22c55e;
    color:white;
    border:none;
    border-radius:6px;
}

a{
    display:block;
    margin-top:12px;
    text-decoration:none;
    color:#333;
}
</style>

</head>

<body>

<div class="box">

<h2>Patient Login</h2>

<form method="POST" action="login_process.php">

<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>

<button type="submit">Login</button>

</form>

<!-- IMPORTANT FIX -->
<a href="register.php">Don't have an account? Register</a>
<a href="index.php">← Back to Portal</a>

</div>

</body>
</html>