<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

requireCustomer();

$customer_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
$stmt->execute(['id' => $customer_id]);
$customer = $stmt->fetch();

$stmt = $pdo->prepare('SELECT COUNT(*) as c FROM orders WHERE customer_id = :id');
$stmt->execute(['id' => $customer_id]);
$orderCount = $stmt->fetch()['c'];

$stmt = $pdo->prepare('SELECT SUM(total_price) as s FROM orders WHERE customer_id = :id');
$stmt->execute(['id' => $customer_id]);
$totalSpent = $stmt->fetch()['s'] ?? 0;
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Мой профил</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .top-nav { background: #111827; color: white; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .top-nav a { color: white; text-decoration: none; }
        .customer-container { max-width: 1000px; margin: 0 auto; }
        .customer-header { display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 20px; }
        .customer-nav { background: white; padding: 12px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px; }
        .customer-nav a { margin: 0 10px; color: #2563eb; text-decoration: none; }
        .customer-nav a.active { color: #ef4444; font-weight: bold; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-box { background: white; padding: 20px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .stat-box h3 { margin: 0 0 10px; color: #666; font-size: 0.9rem; text-transform: uppercase; }
        .stat-box .value { font-size: 2rem; font-weight: bold; color: #2563eb; }
    </style>
</head>
<body>
<div class="top-nav">
    <div><strong><a href="../index.php">← Каталог</a></strong></div>
    <div>
        <span>Вход: <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="logout.php" style="margin-left: 20px;">Изход</a>
    </div>
</div>

<div class="customer-container">
    <div class="customer-header">
        <h1>Мой профил</h1>
    </div>

    <nav class="customer-nav">
        <strong>Меню:</strong>
        <a href="dashboard.php" class="active">Профил</a>
        <a href="orders.php">Поръчките ми</a>
        <a href="../index.php">Каталог</a>
    </nav>

    <div class="stats-grid">
        <div class="stat-box">
            <h3>Потребителско име</h3>
            <div style="font-size: 1.1rem;"><?= htmlspecialchars($customer['username']) ?></div>
        </div>
        <div class="stat-box">
            <h3>Имейл</h3>
            <div style="font-size: 1.1rem;"><?= htmlspecialchars($customer['email']) ?></div>
        </div>
        <div class="stat-box">
            <h3>Мои поръчки</h3>
            <div class="value"><?= $orderCount ?></div>
        </div>
        <div class="stat-box">
            <h3>Общо потрошено</h3>
            <div class="value"><?= number_format($totalSpent, 2) ?> лв.</div>
        </div>
    </div>

    <div style="background: white; padding: 20px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <h2>Добре дошли!</h2>
        <p>Използвайте менюто по-горе, за да видите вашите поръчки или да продължите пазаруването.</p>
        <a class="btn add" href="../index.php">Към каталога</a>
    </div>
</div>
</body>
</html>