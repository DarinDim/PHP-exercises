<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

// Initialize cart for this user
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'guest';
$cart_key = 'cart_' . $user_id;
if (!isset($_SESSION[$cart_key])) {
    $_SESSION[$cart_key] = [];
}

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $qty = max(1, (int)($_POST['qty'] ?? 1));
    
    if (isset($_SESSION[$cart_key][$product_id])) {
        $_SESSION[$cart_key][$product_id] += $qty;
    } else {
        $_SESSION[$cart_key][$product_id] = $qty;
    }
}

// Handle remove from cart
if (isset($_GET['remove'])) {
    $product_id = (int)$_GET['remove'];
    unset($_SESSION[$cart_key][$product_id]);
}

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$term = '%' . $q . '%';

if ($q !== '') {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :t OR description LIKE :t OR category LIKE :t ORDER BY created_at DESC");
    $stmt->execute(['t' => $term]);
} else {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
}
$products = $stmt->fetchAll();

$cartCount = isset($_SESSION[$cart_key]) ? array_sum($_SESSION[$cart_key]) : 0;
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Каталог продукти</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .top-nav { background: #111827; color: white; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .top-nav a { color: white; text-decoration: none; }
        .cart-badge { background: #ef4444; color: white; padding: 2px 6px; border-radius: 20px; font-size: 0.85rem; margin-left: 8px; }
    </style>
</head>
<body>
<div class="top-nav">
    <div><strong>Каталог</strong></div>
    <div>
        <a href="cart.php"> Количка <?php if ($cartCount > 0): ?><span class="cart-badge"><?= $cartCount ?></span><?php endif; ?></a>
        <a href="login.php" style="margin-left: 20px;">Админ</a>
    </div>
</div>

<div class="container">
    <header>
        <h1>Каталог</h1>
        <p class="lead">Списък с продукти и услуги</p>
    </header>

    <div class="controls">
        <form method="get" class="search">
            <input type="search" name="q" placeholder="Търси продукт или категория..." value="<?= htmlspecialchars($q) ?>">
            <button type="submit">Търси</button>
        </form>
    </div>

    <?php if (count($products) === 0): ?>
        <p class="empty">Няма намерени продукти.</p>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($products as $p): ?>
                <article class="card">
                    <?php if (!empty($p['image'])): ?>
                        <div class="thumb"><img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>"></div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h2><?= htmlspecialchars($p['name']) ?></h2>
                        <p class="category"><?= htmlspecialchars($p['category']) ?></p>
                        <p class="desc"><?= nl2br(htmlspecialchars($p['description'])) ?></p>
                        <p class="price"><?= number_format($p['price'], 2) ?> лв.</p>
                        <p style="color: #666; font-size: 0.9rem;">Наличност: <?= $p['stock'] ?></p>
                        <?php if ($p['stock'] > 0): ?>
                            <form method="post" style="margin-top: 8px;">
                                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                <input type="number" name="qty" value="1" min="1" max="<?= $p['stock'] ?>" style="width: 50px; padding: 6px;">
                                <button class="btn" name="add_to_cart" type="submit">Добави в количка</button>
                            </form>
                        <?php else: ?>
                            <p style="color: #ef4444;">Няма в наличност</p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <footer>
        <p>Приложение на PHP + MySQL.</p>
    </footer>
</div>
</body>
</html>

