<?php
require_once __DIR__ . '/db.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '0');
    $category = trim($_POST['category'] ?? '');
    $image = trim($_POST['image'] ?? '');

    if ($name === '') {
        $errors[] = 'Името е задължително.';
    }
    if (!is_numeric($price)) {
        $errors[] = 'Невалидна цена.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, category, image) VALUES (:name, :desc, :price, :cat, :img)");
        $stmt->execute([
            'name' => $name,
            'desc' => $description,
            'price' => $price,
            'cat' => $category,
            'img' => $image,
        ]);
        header('Location: index.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Добави продукт</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container form-page">
    <h1>Добави продукт</h1>

    <?php if ($errors): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post">
        <label>Име
            <input name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </label>
        <label>Категория
            <input name="category" value="<?= htmlspecialchars($_POST['category'] ?? '') ?>">
        </label>
        <label>Цена (лв.)
            <input name="price" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>">
        </label>
        <label>Снимка (URL)
            <input name="image" value="<?= htmlspecialchars($_POST['image'] ?? '') ?>">
        </label>
        <label>Описание
            <textarea name="description"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </label>
        <div class="form-actions">
            <button class="btn" type="submit">Запази</button>
            <a class="btn" href="index.php">Отказ</a>
        </div>
    </form>
</div>
</body>
</html>