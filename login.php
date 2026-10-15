<?php
session_start();
$conn = new mysqli("localhost", "root", "", "finance_management");

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password, role, status FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if ($user['status'] === 'BLOCKED') {
            $error = "Account is suspended by administrator.";
        } else if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['role'];

            $log = $conn->prepare("INSERT INTO audit_logs (action, user_email) VALUES ('User Logged In', ?)");
            $log->bind_param("s", $email);
            $log->execute();

            header("Location: " . ($user['role'] === 'ADMIN' ? "admin/index.php" : "dashboard.php"));
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — FinanceGuard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-box">
        <h2>Sign In</h2>
        <?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email (admin@example.com)" required>
            <input type="password" name="password" placeholder="Password (admin123)" required>
            <button type="submit" class="btn primary">Login</button>
        </form>
    </div>
</body>
</html>
