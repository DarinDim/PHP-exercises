<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

requireLogin();

$stmt = $pdo->query('SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != "" ORDER BY category');
$categories = $stmt->fetchAll();
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Админ - Категории</title>
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
        .admin-actions { display: flex; gap: 8px; }
        .btn-small { padding: 6px 10px; font-size: 0.9rem; }
    </style>
</head>
<body>
<div class="admin-container">
    <div class="admin-header">
        <h1>Админ панел - Категории</h1>
        <div>
            <span>Вход: <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a class="btn" href="logout.php" style="margin-left: 10px;">Изход</a>
        </div>
    </div>

    <nav class="admin-nav">
        <strong>Меню:</strong>
        <a href="products.php">Продукти</a>
        <a href="categories.php" class="active">Категории</a>
        <a href="orders.php">Поръчки</a>
        <a href="dashboard.php">Начало</a>
    </nav>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Категория</th>
                <th>Брой продукти</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
                <?php 
                $count = $pdo->prepare('SELECT COUNT(*) as c FROM products WHERE category = ?');
                $count->execute([$cat['category']]);
                $catCount = $count->fetch()['c'];
                ?>
                <tr>
                    <td><?= htmlspecialchars($cat['category']) ?></td>
                    <td><?= $catCount ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>