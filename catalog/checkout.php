<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

// Initialize cart for this user
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'guest';
$cart_key = 'cart_' . $user_id;
if (!isset($_SESSION[$cart_key])) {
    $_SESSION[$cart_key] = [];
}

// Redirect if cart empty
if (empty($_SESSION[$cart_key])) {
    header('Location: cart.php');
    exit;
}

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($name === '') $error = 'Моля, въведете вашето име.';
    if ($email === '') $error = 'Моля, въведете вашия имейл.';
    if ($phone === '') $error = 'Моля, въведете вашия телефон.';

    if (!$error) {
        // Calculate total
        $placeholders = implode(',', array_keys($_SESSION[$cart_key]));
        $stmt = $pdo->query("SELECT id, price FROM products WHERE id IN ($placeholders)");
        $products = $stmt->fetchAll();
        
        $total = 0;
        foreach ($products as $product) {
            $qty = $_SESSION[$cart_key][$product['id']];
            $total += $product['price'] * $qty;
        }

        // Create order
        $stmt = $pdo->prepare('INSERT INTO orders (customer_id, customer_name, customer_email, customer_phone, total_price, status) VALUES (:cid, :n, :e, :p, :t, :s)');
        $stmt->execute([
            'cid' => isLoggedIn() ? $_SESSION['user_id'] : null,
            'n' => $name,
            'e' => $email,
            'p' => $phone,
            't' => $total,
            's' => 'new'
        ]);

        $order_id = $pdo->lastInsertId();

        // Insert order items
        foreach ($products as $product) {
            $qty = $_SESSION[$cart_key][$product['id']];
            $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:o, :p, :q, :pr)');
            $stmt->execute([
                'o' => $order_id,
                'p' => $product['id'],
                'q' => $qty,
                'pr' => $product['price']
            ]);
        }

        // Clear cart
        $_SESSION[$cart_key] = [];
        $_SESSION['order_id'] = $order_id;
        $_SESSION['order_total'] = $total;
        $_SESSION['order_name'] = $name;

        header('Location: success.php');
        exit;
    }
}

// Get cart total
$placeholders = implode(',', array_keys($_SESSION[$cart_key]));
$stmt = $pdo->query("SELECT id, price FROM products WHERE id IN ($placeholders)");
$products = $stmt->fetchAll();

$total = 0;
foreach ($products as $product) {
    $qty = $_SESSION[$cart_key][$product['id']];
    $total += $product['price'] * $qty;
}
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Каса</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .top-nav { background: #111827; color: white; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .top-nav a { color: white; text-decoration: none; }
        .checkout-container { max-width: 600px; margin: 0 auto; }
        .checkout-form { background: white; padding: 20px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .error { background: #fee; border: 1px solid #fcc; color: #c00; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .order-summary { background: #f9fafb; padding: 15px; border-radius: 6px; margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="top-nav">
    <div><strong><a href="index.php">← Каталог</a></strong></div>
    <div><a href="cart.php">Количка</a></div>
</div>

<div class="checkout-container">
    <h1>Каса</h1>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="order-summary">
        <strong>Обобщение на поръчката:</strong>
        <p style="margin: 10px 0 0 0; color: #666;">Брой артикули: <?= count($_SESSION[$cart_key]) ?></p>
        <p style="margin: 5px 0 0 0; color: #666;">Обща сума: <strong><?= number_format($total, 2) ?> лв.</strong></p>
    </div>

    <form method="post" class="checkout-form">
        <div class="form-group">
            <label>Име *
                <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
            </label>
        </div>
        <div class="form-group">
            <label>Имейл *
                <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </label>
        </div>
        <div class="form-group">
            <label>Телефон *
                <input type="tel" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required>
            </label>
        </div>
        <div style="display: flex; gap: 10px;">
            <button class="btn add" type="submit">Потвърди поръчка</button>
            <a class="btn" href="cart.php">Отказ</a>
        </div>
    </form>
</div>
</body>
</html>