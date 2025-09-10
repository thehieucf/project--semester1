<?php
session_start();
require_once "../auth/db.php"; // file kết nối CSDL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            header("Location: ../index.html");
            exit();
        } else {
            $error = "Wrong password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
            background: rgba(255,255,255,0.95);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
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
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group mb-3">
            <label>Username</label>
            <input type="text" name="username" required class="form-control">
        </div>
        <div class="form-group mb-3">
            <label>Password</label>
            <input type="password" name="password" required class="form-control">
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <p class="text-center mt-3">Don’t have an account? <a href="register.php">Register</a></p>
    </form>
</div>
</body>
</html>
