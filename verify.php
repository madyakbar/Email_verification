<?php
require 'db_config.php';

$message = '';

if(isset($_GET['token'])){
    $token = $_GET['token'];
    
    $sql = "SELECT * FROM users WHERE token=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            $sql = "UPDATE users SET is_verified=1 WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $row['id']);
            
            if ($stmt->execute()) {
                $message = "Email verification successful. You can now login.";
            } else {
                $message = "Error updating user record. Please try again later.";
            }
        } else {
            $message = "Invalid token.";
        }
    } else {
        $message = "Error executing database query.";
    }
} else {
    $message = "Token not provided.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js"></script>
</head>
<style type="text/css">
    body {
    font-family: Arial, sans-serif;
    text-align: center;
}

.card {
    width: 300px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f2f2f2;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
}

h1 {
    margin-top: 0;
}

.button_login {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

p {
    margin-bottom: 20px;
}

</style>
<body>
    <div class='card'>
    <h1>Email Verification</h1>
    <p><?php echo $message; ?></p>
    <a href="login.php" class="button_login">Login</a>
</div>
</body>
</html>
