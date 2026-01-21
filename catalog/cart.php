<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

// Initialize cart for this user
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'guest';
$cart_key = 'cart_' . $user_id;
if (!isset($_SESSION[$cart_key])) {
    $_SESSION[$cart_key] = [];
}

// Handle remove from cart
if (isset($_GET['remove'])) {
    $product_id = (int)$_GET['remove'];
    unset($_SESSION[$cart_key][$product_id]);
}

// Handle update quantities
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['qty'] as $product_id => $qty) {
        $qty = max(0, (int)$qty);
        if ($qty > 0) {
            $_SESSION[$cart_key][$product_id] = $qty;
        } else {
            unset($_SESSION[$cart_key][$product_id]);
        }
    }
}

// Handle clear cart
if (isset($_GET['clear'])) {
    $_SESSION[$cart_key] = [];
}

// Get cart products
$cartItems = [];
$total = 0;

if (!empty($_SESSION[$cart_key])) {
    $placeholders = implode(',', array_keys($_SESSION[$cart_key]));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($placeholders)");
    $products = $stmt->fetchAll();
    
    foreach ($products as $product) {
        $qty = $_SESSION[$cart_key][$product['id']];
        $subtotal = $product['price'] * $qty;
        $total += $subtotal;
        $cartItems[] = [
            'product' => $product,
            'qty' => $qty,
            'subtotal' => $subtotal
        ];
    }
}
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Количка</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .top-nav { background: #111827; color: white; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .top-nav a { color: white; text-decoration: none; }
        .cart-table { width: 100%; border-collapse: collapse; background: white; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .cart-table th { background: #f3f4f6; padding: 12px; text-align: left; font-weight: 600; }
        .cart-table td { padding: 12px; border-top: 1px solid #e5e7eb; }
        .cart-summary { background: white; padding: 20px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); max-width: 400px; margin-left: auto; margin-top: 20px; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .summary-total { border-top: 2px solid #e5e7eb; padding-top: 10px; font-weight: bold; font-size: 1.2rem; }
        .empty-cart { text-align: center; padding: 40px; }
        .qty-input { width: 60px; padding: 6px; border: 1px solid #ddd; border-radius: 4px; }
    </style>
</head>
<body>
<div class="top-nav">
    <div><strong><a href="index.php">← Каталог</a></strong></div>
    <div><a href="index.php">Назад</a></div>
</div>

<div class="container">
    <h1>Количка</h1>

    <?php if (empty($cartItems)): ?>
        <div class="empty-cart">
            <p style="font-size: 1.1rem; color: #666;">Количката е празна</p>
            <a class="btn add" href="index.php">Продължи пазаруване</a>
        </div>
    <?php else: ?>
        <form method="post">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Продукт</th>
                        <th>Цена</th>
                        <th>Количество</th>
                        <th>Сума</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['product']['name']) ?></td>
                            <td><?= number_format($item['product']['price'], 2) ?> лв.</td>
                            <td>
                                <input type="number" name="qty[<?= $item['product']['id'] ?>]" value="<?= $item['qty'] ?>" min="0" class="qty-input">
                            </td>
                            <td><?= number_format($item['subtotal'], 2) ?> лв.</td>
                            <td>
                                <a href="cart.php?remove=<?= $item['product']['id'] ?>" onclick="return confirm('Премахване?');">Премахни</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <div class="summary-row">
                    <span>Обща сума:</span>
                    <span><?= number_format($total, 2) ?> лв.</span>
                </div>
                <div style="margin-top: 20px;">
                    <button class="btn" type="submit" name="update_cart">Актуализирай количка</button>
                    <a class="btn add" href="checkout.php" style="display: block; text-align: center; margin-top: 10px;">Към касата</a>
                    <a class="btn" href="cart.php?clear=1" style="display: block; text-align: center; margin-top: 10px;">Изчисти количка</a>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>
</body>
</html>