<?php

$name = '';
$email = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (!preg_match('/^[A-Za-z\- ]{3,50}$/u', $name)) {
        $errors['name'] = 'Името трябва да съдържа само букви и да е между 3 и 50 символа.';
    }

    if (!preg_match('/^[\w\.-]+@[\w\.-]+\.[A-Za-z]{2,6}$/', $email)) {
        $errors['email'] = 'Невалиден имейл формат.';
    }
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Упражнение 15 - Форма с Regex Валидация</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f4f4;
            padding: 30px 20px;
        }

        .form-container {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background: #667eea;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 1em;
            margin-top: 20px;
        }

        .error {
            color: #d8000c;
            font-size: 0.9em;
            margin-top: 4px;
        }

        .success {
            color: #155724;
            background: #d4edda;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Форма с Regex Валидация</h1>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)): ?>
            <div class="success">
                Формата е изпратена успешно!<br>
                Име: <?= htmlspecialchars($name) ?><br>
                Имейл: <?= htmlspecialchars($email) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <label for="name">Име</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
            <?php if (isset($errors['name'])): ?>
                <div class="error"><?= $errors['name'] ?></div>
            <?php endif; ?>

            <label for="email">Имейл</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            <?php if (isset($errors['email'])): ?>
                <div class="error"><?= $errors['email'] ?></div>
            <?php endif; ?>

            <input type="submit" value="Изпрати">
        </form>
    </div>
</body>
</html>
