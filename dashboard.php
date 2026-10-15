<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "", "finance_management");
$user_id = $_SESSION['user_id'];

$res = $conn->query("SELECT SUM(amount) AS total FROM expenses WHERE user_id = $user_id");
$total = $res->fetch_assoc()['total'] ?? 0;

$expenses = $conn->query("SELECT * FROM expenses WHERE user_id = $user_id ORDER BY date DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — FinanceGuard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <h3>FinanceGuard</h3>
            <p>Welcome, <?= htmlspecialchars($_SESSION['name']); ?></p>
            <nav>
                <a href="dashboard.php" class="active">Dashboard</a>
                <a href="expenses.php">Expenses</a>
                <?php if($_SESSION['role'] === 'ADMIN'): ?><a href="admin/index.php">Admin Panel</a><?php endif; ?>
                <a href="login.php">Logout</a>
            </nav>
        </aside>
        <main class="content">
            <h2>Financial Overview</h2>
            <div class="cards-grid">
                <div class="card">
                    <h4>Total Outflow</h4>
                    <p class="stat-value">₹<?= number_format($total, 2); ?></p>
                </div>
                <div class="card">
                    <h4>Monthly Budget</h4>
                    <p class="stat-value">₹25,000.00</p>
                </div>
            </div>

            <div class="recent-table">
                <h3>Recent Transactions</h3>
                <table>
                    <thead>
                        <tr><th>Title</th><th>Category</th><th>Amount</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        <?php while($row = $expenses->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['title']); ?></td>
                            <td><span class="badge"><?= $row['category']; ?></span></td>
                            <td>₹<?= number_format($row['amount'], 2); ?></td>
                            <td><?= $row['date']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
