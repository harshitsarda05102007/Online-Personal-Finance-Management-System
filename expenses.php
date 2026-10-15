<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "", "finance_management");
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_expense'])) {
    $stmt = $conn->prepare("INSERT INTO expenses (user_id, title, category, amount, date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issds", $user_id, $_POST['title'], $_POST['category'], $_POST['amount'], $_POST['date']);
    $stmt->execute();
    header("Location: expenses.php");
    exit();
}

$expenses = $conn->query("SELECT * FROM expenses WHERE user_id = $user_id ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses Ledger — FinanceGuard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <h3>FinanceGuard</h3>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="expenses.php" class="active">Expenses</a>
                <a href="login.php">Logout</a>
            </nav>
        </aside>
        <main class="content">
            <h2>Add New Expense</h2>
            <form method="POST" class="expense-form">
                <input type="text" name="title" placeholder="Expense Title" required>
                <select name="category">
                    <option value="Food">Food</option>
                    <option value="Fitness">Fitness</option>
                    <option value="Bills">Bills</option>
                    <option value="Travel">Travel</option>
                </select>
                <input type="number" step="0.01" name="amount" placeholder="Amount (₹)" required>
                <input type="date" name="date" required>
                <button type="submit" name="add_expense" class="btn primary">Add Entry</button>
            </form>

            <h2>All Expense Entries</h2>
            <table>
                <thead>
                    <tr><th>Title</th><th>Category</th><th>Amount</th><th>Date</th></tr>
                </thead>
                <tbody>
                    <?php while($row = $expenses->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']); ?></td>
                        <td><?= $row['category']; ?></td>
                        <td>₹<?= number_format($row['amount'], 2); ?></td>
                        <td><?= $row['date']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
