<?php

require 'send_email.php';

session_start();
if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
}

require 'db_config.php';

$message = '';

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $message = "Email already exists. Please use a different email.";
    } else {
        $token = bin2hex(random_bytes(50));
        
        $sql = "INSERT INTO users (username, email, password, token, is_verified) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $email, $password, $token, $is_verified);
        
        if($stmt->execute()){
            $to = $email;
            $subject = "Email Verification";
            $message = "
                <p>Thank you for registering on our website. Please click the link below to verify your email address:</p>
                <p><a href='http://localhost/user-registration/verify.php?token=".$token."'>Verify Email</a></p>
            ";

            if (sendEmail($to, $subject, $message)) {
                $message = "Registration successful. Please check your email for verification.";
            } else {
                $message = "Error sending email. Please try again later.";
            }
        }
    }
}

$conn->close();

?>


<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
      <link rel="stylesheet" href="style.css">
      <script src="script.js"></script>


</head>
<style type="text/css">
    body {
    background-image: url('reg.jpg');
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

input[type="text"],
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
    display: block;
    text-align: center;
    margin-top: 10px;
}

</style>
<script>
  function validateRegisterForm() {
    var username = document.forms["registerForm"]["username"].value;
    var email = document.forms["registerForm"]["email"].value;
    var password = document.forms["registerForm"]["password"].value;
    
    if (username.trim() === "") {
      alert("Please enter your username.");
      return false;
    }
    
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
    <h1>User Registration</h1>
<form method="POST" action="" onsubmit="return validateRegisterForm()" name="registerForm">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit" name="register">Register</button>
    </form>
    <p><?php echo $message; ?></p>
    <a href="login.php">Already have an account? Login here</a>
</body>
</html>
