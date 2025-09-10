<?php
session_start();
require_once "../auth/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users(username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        header("Location: ../index.html");
        exit();
    } else {
        $error = "Username already exists!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
    body {
        /* background: url('../assets/img/hero/about.jpg') no-repeat center center/cover; */
        height: 100vh;
    }

    .auth-box {
        max-width: 420px;
        margin: 80px auto;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .auth-box h2 {
        text-align: center;
        margin-bottom: 20px;
        font-weight: 600;
    }
    </style>
</head>

<body>
    <div class="auth-box">
        <h2>Register</h2>
        <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group mb-3">
                <label>Username</label>
                <input type="text" name="username" required class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Email</label>
                <input type="email" name="email" required class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Password</label>
                <input type="password" name="password" required class="form-control">
            </div>
            <button type="submit" class="btn btn-success w-100">Register</button>
            <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>

</html>