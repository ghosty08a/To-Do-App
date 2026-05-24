<?php
session_start();
include 'config.php';

if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {

        // check if username exists
        $check = $conn->query("SELECT id FROM users WHERE username='$username'");
        
        if ($check->num_rows > 0) {
            $error = "Username already taken!";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $conn->query("INSERT INTO users (username, password) 
                          VALUES ('$username', '$hashedPassword')");

            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">

<div class="bg"></div>

<div class="login-wrapper">

    <div class="login-card">

        <h1>Create Account</h1>
        <p>Sign up to start using the system</p>

        <?php if (!empty($error)) { ?>
            <p style="color:red; font-size:13px;"><?php echo $error; ?></p>
        <?php } ?>

        <form method="POST">

            <div class="input-group">
                <input type="text" name="username" required>
                <label>Username</label>
            </div>

            <div class="input-group password-group">
                <input type="password" name="password" id="password" required>
                <label>Password</label>
                <span onclick="togglePassword('password')">👁</span>
            </div>

            <div class="input-group password-group">
                <input type="password" name="confirm_password" id="confirm_password" required>
                <label>Confirm Password</label>
                <span onclick="togglePassword('confirm_password')">👁</span>
            </div>

            <button type="submit" name="register">Create Account</button>

        </form>

        <p class="switch">
            Already have an account? <a href="login.php">Login</a>
        </p>

    </div>

</div>

<script>
function togglePassword(id) {
    const field = document.getElementById(id);
    field.type = field.type === "password" ? "text" : "password";
}
</script>

</body>
</html>