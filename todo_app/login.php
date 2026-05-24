<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['id'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid login!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">

<div class="bg"></div>

<div class="login-wrapper">

    <div class="login-card">

        <h1>Welcome Back</h1>
        <p>Login to continue to your dashboard</p>

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
                <span onclick="togglePassword()">👁</span>
            </div>

            <button type="submit" name="login">Sign In</button>

        </form>

        <p class="switch">
            No account? <a href="register.php">Create one</a>
        </p>

    </div>

</div>

<script>
function togglePassword() {
    const pass = document.getElementById("password");
    pass.type = pass.type === "password" ? "text" : "password";
}
</script>

</body>
</html>