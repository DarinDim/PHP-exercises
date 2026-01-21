<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

requireLogin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: products.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$stmt->execute(['id' => $id]);
$product = $stmt->fetch();
if (!$product) {
    header('Location: products.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '0');
    $category = trim($_POST['category'] ?? '');
    $stock = trim($_POST['stock'] ?? '10');
    $image = trim($_POST['image'] ?? '');

    if ($name === '') $errors[] = 'Название е задължително.';
    if (!is_numeric($price) || $price < 0) $errors[] = 'Невалидна цена.';
    if (!is_numeric($stock) || $stock < 0) $errors[] = 'Невалидна наличност.';

    if (empty($errors)) {
        $stmt = $pdo->prepare('UPDATE products SET name=:n, description=:d, price=:p, category=:c, stock=:s, image=:i WHERE id=:id');
        $stmt->execute(['n' => $name, 'd' => $description, 'p' => $price, 'c' => $category, 's' => $stock, 'i' => $image, 'id' => $id]);
        header('Location: products.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Редактирай продукт</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-container { max-width: 600px; margin: 0 auto; }
        .admin-form { background: white; padding: 20px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .form-group textarea { min-height: 100px; }
        .form-actions { display: flex; gap: 10px; margin-top: 20px; }
        .errors { background: #fee; border: 1px solid #fcc; color: #c00; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="admin-container">
    <h1>Редактирай продукт</h1>

    <?php if ($errors): ?>
        <div class="errors">
            <ul style="margin: 0; padding-left: 20px;">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" class="admin-form">
        <div class="form-group">
            <label>Име *
                <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? $product['name']) ?>" required>
            </label>
        </div>
        <div class="form-group">
            <label>Категория
                <input type="text" name="category" value="<?= htmlspecialchars($_POST['category'] ?? $product['category']) ?>">
            </label>
        </div>
        <div class="form-group">
            <label>Цена (лв.) *
                <input type="number" name="price" step="0.01" value="<?= htmlspecialchars($_POST['price'] ?? $product['price']) ?>" required>
            </label>
        </div>
        <div class="form-group">
            <label>Наличност
                <input type="number" name="stock" value="<?= htmlspecialchars($_POST['stock'] ?? $product['stock']) ?>">
            </label>
        </div>
        <div class="form-group">
            <label>Снимка (URL)
                <input type="url" name="image" value="<?= htmlspecialchars($_POST['image'] ?? $product['image']) ?>">
            </label>
        </div>
        <div class="form-group">
            <label>Описание
                <textarea name="description"><?= htmlspecialchars($_POST['description'] ?? $product['description']) ?></textarea>
            </label>
        </div>
        <div class="form-actions">
            <button class="btn" type="submit">Запази</button>
            <a class="btn" href="products.php">Отказ</a>
        </div>
    </form>
</div>
</body>
</html>