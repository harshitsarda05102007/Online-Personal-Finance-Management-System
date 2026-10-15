<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinanceGuard — Personal Finance Management</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="landing-container">
        <h1>FinanceGuard</h1>
        <p>Smart, Secure & Effortless Personal Expense Tracking</p>
        <div class="btn-group">
            <a href="login.php" class="btn primary">Login to Dashboard</a>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
