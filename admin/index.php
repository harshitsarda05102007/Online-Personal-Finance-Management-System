<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
    header("Location: ../login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "", "finance_management");

$users = $conn->query("SELECT * FROM users");
$logs = $conn->query("SELECT * FROM audit_logs ORDER BY timestamp DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Audit Portal — FinanceGuard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <h3>Admin Guard</h3>
            <nav>
                <a href="../dashboard.php">User View</a>
                <a href="index.php" class="active">Security & Users</a>
                <a href="../login.php">Logout</a>
            </nav>
        </aside>
        <main class="content">
            <h2>User Management Directory</h2>
            <table>
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <?php while($u = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['name']); ?></td>
                        <td><?= htmlspecialchars($u['email']); ?></td>
                        <td><?= $u['role']; ?></td>
                        <td><?= $u['status']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h2>Security & Audit Trail</h2>
            <table>
                <thead>
                    <tr><th>Action</th><th>User</th><th>Timestamp</th></tr>
                </thead>
                <tbody>
                    <?php while($l = $logs->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($l['action']); ?></td>
                        <td><?= htmlspecialchars($l['user_email']); ?></td>
                        <td><?= $l['timestamp']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
