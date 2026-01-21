<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

requireLogin();

// Get pagination parameters
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Count orders
$countStmt = $pdo->query('SELECT COUNT(*) as count FROM orders');
$totalOrders = $countStmt->fetch()['count'];
$totalPages = ceil($totalOrders / $perPage);

// Get orders for current page
$stmt = $pdo->prepare('SELECT * FROM orders ORDER BY id DESC LIMIT :limit OFFSET :offset');
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$orders = $stmt->fetchAll();
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Админ - Поръчки</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-container { max-width: 1200px; margin: 0 auto; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 20px; }
        .admin-nav { background: white; padding: 12px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px; }
        .admin-nav a { margin: 0 10px; color: #2563eb; text-decoration: none; }
        .admin-nav a.active { color: #ef4444; font-weight: bold; }
        .admin-table { width: 100%; border-collapse: collapse; background: white; border-radius: 6px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .admin-table th { background: #f3f4f6; padding: 12px; text-align: left; font-weight: 600; }
        .admin-table td { padding: 12px; border-top: 1px solid #e5e7eb; }
        .admin-table tr:hover { background: #f9fafb; }
        .pagination { display: flex; gap: 8px; margin-top: 20px; justify-content: center; }
        .pagination a, .pagination span { padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #2563eb; }
        .pagination .active { background: #2563eb; color: white; border-color: #2563eb; }
        .status { padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; }
        .status.new { background: #fef3c7; color: #b45309; }
        .status.confirmed { background: #dbeafe; color: #0284c7; }
        .status.delivered { background: #dcfce7; color: #16a34a; }
    </style>
</head>
<body>
<div class="admin-container">
    <div class="admin-header">
        <h1>Админ панел - Поръчки</h1>
        <div>
            <span>Вход: <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a class="btn" href="logout.php" style="margin-left: 10px;">Изход</a>
        </div>
    </div>

    <nav class="admin-nav">
        <strong>Меню:</strong>
        <a href="products.php">Продукти</a>
        <a href="categories.php">Категории</a>
        <a href="orders.php" class="active">Поръчки</a>
        <a href="dashboard.php">Начало</a>
    </nav>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Клиент</th>
                <th>Имейл</th>
                <th>Телефон</th>
                <th>Сума</th>
                <th>Статус</th>
                <th>Дата</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($orders) === 0): ?>
                <tr><td colspan="7" style="text-align: center; padding: 20px;">Няма поръчки</td></tr>
            <?php else: ?>
                <?php foreach ($orders as $o): ?>
                    <tr>
                        <td><?= $o['id'] ?></td>
                        <td><?= htmlspecialchars($o['customer_name']) ?></td>
                        <td><?= htmlspecialchars($o['customer_email']) ?></td>
                        <td><?= htmlspecialchars($o['customer_phone']) ?></td>
                        <td><?= number_format($o['total_price'], 2) ?> лв.</td>
                        <td><span class="status <?= htmlspecialchars($o['status']) ?>"><?= htmlspecialchars($o['status']) ?></span></td>
                        <td><?= substr($o['created_at'], 0, 10) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="active"><?= $i ?></span>
                <?php else: ?>
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>