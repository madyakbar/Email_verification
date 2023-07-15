<?php
session_start();
if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
}

require 'db_config.php';

$message = '';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if($result->num_rows === 1){
        $row = $result->fetch_assoc();
        if($row['is_verified'] == 1){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username']; 
            header("Location: dashboard.php");
        } else {
            $message = "Please verify your email address.";
        }
    } else {
        $message = "Invalid email or password.";
    }
}

$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
      <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js"></script>
</head>
<style type="text/css">
    body {
    font-family: Arial, sans-serif;
    background-image: url('log1.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: stretch;
    font-family: Arial, sans-serif;
}

h1 {
    text-align: center;
}

form {
    width: 300px;
    margin: 0 auto;
}

input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
}

button[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

p {
    text-align: center;
}

a {
    text-align: center;
    margin-top: 10px;
    color: white;
    text-decoration: none;
    font-weight: bold;
    margin-left: 40%;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 10px;
    width: 100%;
    box-sizing: border-box;
}

a:hover {
    background-color: rgba(0, 0, 0, 0.7);
}


</style>
<script>
  function validateLoginForm() {
    var email = document.forms["loginForm"]["email"].value;
    var password = document.forms["loginForm"]["password"].value;
    
    if (email.trim() === "") {
      alert("Please enter your email.");
      return false;
    }
    
    if (password.trim() === "") {
      alert("Please enter your password.");
      return false;
    }
    
    return true;
  }
</script>

<body>
    <h1>User Login</h1>
<form method="POST" action="" onsubmit="return validateLoginForm()" name="loginForm">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit" name="login">Login</button>
    </form>
    <p><?php echo $message; ?></p>
    <a href="register.php">Don't have an account? Register here</a>
</body>
</html>
