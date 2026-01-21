<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

requireCustomer();

$customer_id = $_SESSION['user_id'];

// Get pagination
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 5;
$offset = ($page - 1) * $perPage;

// Count orders
$stmt = $pdo->prepare('SELECT COUNT(*) as c FROM orders WHERE customer_id = :id');
$stmt->execute(['id' => $customer_id]);
$totalOrders = $stmt->fetch()['c'];
$totalPages = ceil($totalOrders / $perPage);

// Get orders
$stmt = $pdo->prepare('SELECT * FROM orders WHERE customer_id = :id ORDER BY id DESC LIMIT :limit OFFSET :offset');
$stmt->bindValue(':id', $customer_id);
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
    <title>Моите поръчки</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .top-nav { background: #111827; color: white; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .top-nav a { color: white; text-decoration: none; }
        .customer-container { max-width: 1000px; margin: 0 auto; }
        .customer-nav { background: white; padding: 12px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px; }
        .customer-nav a { margin: 0 10px; color: #2563eb; text-decoration: none; }
        .customer-nav a.active { color: #ef4444; font-weight: bold; }
        .orders-table { width: 100%; border-collapse: collapse; background: white; border-radius: 6px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .orders-table th { background: #f3f4f6; padding: 12px; text-align: left; font-weight: 600; }
        .orders-table td { padding: 12px; border-top: 1px solid #e5e7eb; }
        .orders-table tr:hover { background: #f9fafb; }
        .status { padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; }
        .status.new { background: #fef3c7; color: #b45309; }
        .status.confirmed { background: #dbeafe; color: #0284c7; }
        .status.delivered { background: #dcfce7; color: #16a34a; }
        .pagination { display: flex; gap: 8px; margin-top: 20px; justify-content: center; }
        .pagination a, .pagination span { padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #2563eb; }
        .pagination .active { background: #2563eb; color: white; border-color: #2563eb; }
        .empty { text-align: center; padding: 40px; }
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
    <h1>Моите поръчки</h1>

    <nav class="customer-nav">
        <strong>Меню:</strong>
        <a href="dashboard.php">Профил</a>
        <a href="orders.php" class="active">Поръчките ми</a>
        <a href="../index.php">Каталог</a>
    </nav>

    <?php if (count($orders) === 0): ?>
        <div class="empty">
            <p style="font-size: 1.1rem; color: #666;">Няма направени поръчки</p>
            <a class="btn add" href="../index.php">Направи поръчка</a>
        </div>
    <?php else: ?>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Дата</th>
                    <th>Сума</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= $order['id'] ?></td>
                        <td><?= substr($order['created_at'], 0, 10) ?></td>
                        <td><?= number_format($order['total_price'], 2) ?> лв.</td>
                        <td><span class="status <?= htmlspecialchars($order['status']) ?>"><?= htmlspecialchars($order['status']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
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
    <?php endif; ?>
</div>
</body>
</html>