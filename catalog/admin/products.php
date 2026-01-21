<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

requireLogin();

// Get pagination parameters
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Count products
$countStmt = $pdo->query('SELECT COUNT(*) as count FROM products');
$totalProducts = $countStmt->fetch()['count'];
$totalPages = ceil($totalProducts / $perPage);

// Get products for current page
$stmt = $pdo->prepare('SELECT * FROM products ORDER BY id DESC LIMIT :limit OFFSET :offset');
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Админ - Продукти</title>
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
        .pagination { display: flex; gap: 8px; margin-top: 20px; justify-content: center; }
        .pagination a, .pagination span { padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #2563eb; }
        .pagination .active { background: #2563eb; color: white; border-color: #2563eb; }
    </style>
</head>
<body>
<div class="admin-container">
    <div class="admin-header">
        <h1>Админ панел - Продукти</h1>
        <div>
            <span>Вход: <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a class="btn" href="logout.php" style="margin-left: 10px;">Изход</a>
        </div>
    </div>

    <nav class="admin-nav">
        <strong>Меню:</strong>
        <a href="products.php" class="active">Продукти</a>
        <a href="categories.php">Категории</a>
        <a href="orders.php">Поръчки</a>
        <a href="dashboard.php">Начало</a>
    </nav>

    <div style="margin-bottom: 20px;">
        <a class="btn add" href="add-product.php">+ Добави продукт</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Име</th>
                <th>Категория</th>
                <th>Цена</th>
                <th>Наличност</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= htmlspecialchars($p['category']) ?></td>
                    <td><?= number_format($p['price'], 2) ?> лв.</td>
                    <td><?= $p['stock'] ?></td>
                    <td class="admin-actions">
                        <a class="btn btn-small" href="edit-product.php?id=<?= $p['id'] ?>">Редакция</a>
                        <form method="post" action="delete-product.php" style="display:inline;" onsubmit="return confirm('Сигурни ли сте?');">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <button class="btn btn-small danger" type="submit">Изтриване</button>
                        </form>
                    </td>
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
</div>
</body>
</html>