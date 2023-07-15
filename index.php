<?php
session_start();
if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h1>Welcome to User Registration</h1>
    <a href="register.php">Register</a> | <a href="login.php">Login</a>
</body>
</html>
