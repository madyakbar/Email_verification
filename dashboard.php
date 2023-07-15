<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

// Retrieve the username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<style type="text/css">
	body {
    font-family: Arial, sans-serif;
    background-image: url('jp.jpg');
}

h1 {
    text-align: center;
    margin-top: 50px;
}

p {
    text-align: center;
    margin-bottom: 20px;
}

a {
    display: block;
    text-align: center;
    margin-top: 20px;
    text-decoration: none;
    color: #4CAF50;
}

a:hover {
    text-decoration: underline;
}

</style>
<body>
    <h1>Welcome to User Dashboard, <?php echo $username; ?>!</h1>
    <p>You are logged in.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
