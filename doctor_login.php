<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
<title>Doctor Login</title>

<style>
body{
    font-family:Arial;
    background:#f5f7fb;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

/* BOX */
.box{
    background:white;
    padding:40px;
    border-radius:15px;
    width:340px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    text-align:center;
}

/* TITLE */
h2{
    font-size:26px;
    margin-bottom:20px;
}

/* INPUTS */
input{
    width:100%;
    padding:12px;
    margin:10px 0;
    font-size:15px;
    border:1px solid #ccc;
    border-radius:6px;
}

/* BUTTON */
button{
    width:100%;
    padding:12px;
    background:#4d79ff;
    color:white;
    border:none;
    border-radius:6px;
    font-size:16px;
    cursor:pointer;
}

/* LINK */
a{
    display:block;
    margin-top:18px;
    text-decoration:none;
    color:#333;
    font-size:14px;
}

a:hover{
    text-decoration:underline;
}
</style>

</head>

<body>

<div class="box">

<h2>Doctor Login</h2>

<form method="POST" action="doctor_login_process.php">

<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>

<button type="submit">Login</button>

</form>

<a href="index.php">← Back to Portal</a>

</div>

</body>
</html>