<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

requireLogin();
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Админ дашборд</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-container { max-width: 1200px; margin: 0 auto; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 20px; }
        .admin-nav { background: white; padding: 12px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px; }
        .admin-nav a { margin: 0 10px; color: #2563eb; text-decoration: none; }
        .admin-nav a.active { color: #ef4444; font-weight: bold; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-box { background: white; padding: 20px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .stat-box h3 { margin: 0 0 10px; color: #666; font-size: 0.9rem; text-transform: uppercase; }
        .stat-box .value { font-size: 2rem; font-weight: bold; color: #2563eb; }
    </style>
</head>
<body>
<div class="admin-container">
    <div class="admin-header">
        <h1>Админ панел</h1>
        <div>
            <span>Вход: <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a class="btn" href="logout.php" style="margin-left: 10px;">Изход</a>
        </div>
    </div>

    <nav class="admin-nav">
        <strong>Меню:</strong>
        <a href="dashboard.php" class="active">Начало</a>
        <a href="products.php">Продукти</a>
        <a href="categories.php">Категории</a>
        <a href="orders.php">Поръчки</a>
    </nav>

    <?php
    $prodCount = $pdo->query('SELECT COUNT(*) as c FROM products')->fetch()['c'];
    $orderCount = $pdo->query('SELECT COUNT(*) as c FROM orders')->fetch()['c'];
    $totalRevenue = $pdo->query('SELECT SUM(total_price) as s FROM orders')->fetch()['s'] ?? 0;
    ?>

    <div class="stats-grid">
        <div class="stat-box">
            <h3>Общо продукти</h3>
            <div class="value"><?= $prodCount ?></div>
        </div>
        <div class="stat-box">
            <h3>Поръчки</h3>
            <div class="value"><?= $orderCount ?></div>
        </div>
        <div class="stat-box">
            <h3>Приход</h3>
            <div class="value"><?= number_format($totalRevenue, 2) ?> лв.</div>
        </div>
    </div>

    <div style="background: white; padding: 20px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <h2>Добре дошли!</h2>
        <p>Използвайте менюто по-горе, за да управлявате продукти, категории и поръчки.</p>
    </div>
</div>
</body>
</html>