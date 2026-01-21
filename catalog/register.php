<?php
require_once __DIR__ . '/db.php';

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if ($username === '') $error = 'Потребителското име е задължително.';
    if ($email === '') $error = 'Имейлът е задължителен.';
    if ($password === '') $error = 'Паролата е задължителна.';
    if ($password !== $password_confirm) $error = 'Паролите не съвпадат.';
    if (strlen($password) < 6) $error = 'Паролата трябва да е поне 6 символа.';

    if (!$error) {
        // Check if username exists
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :u');
        $stmt->execute(['u' => $username]);
        if ($stmt->fetch()) {
            $error = 'Потребителското име е заето.';
        }

        // Check if email exists
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :e');
        $stmt->execute(['e' => $email]);
        if ($stmt->fetch()) {
            $error = 'Имейлът вече е регистриран.';
        }
    }

    if (!$error) {
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash, role) VALUES (:u, :e, :h, :r)');
        $stmt->execute([
            'u' => $username,
            'e' => $email,
            'h' => $hash,
            'r' => 'customer'
        ]);
        $success = true;
    }
}
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background: #f6f8fb; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 20px; }
        .register-box { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .register-box h1 { text-align: center; margin: 0 0 20px; font-size: 1.4rem; }
        .register-box label { display: block; margin-bottom: 10px; font-weight: 500; }
        .register-box input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .register-box button { width: 100%; padding: 10px; background: #10b981; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; }
        .register-box button:hover { background: #059669; }
        .error { background: #fee; color: #c00; padding: 10px; margin-bottom: 15px; border-radius: 6px; border: 1px solid #fcc; }
        .success { background: #efe; color: #0a0; padding: 15px; margin-bottom: 15px; border-radius: 6px; border: 1px solid #0f0; text-align: center; }
        .success a { color: #0066cc; text-decoration: none; display: block; margin-top: 10px; }
        .login-link { text-align: center; margin-top: 15px; }
        .login-link a { color: #2563eb; text-decoration: none; }
    </style>
</head>
<body>
    <div class="register-box">
        <h1>Регистрация</h1>

        <?php if ($success): ?>
            <div class="success">
                <p><strong>✓ Успешна регистрация!</strong></p>
                <p>Вашият акаунт е създаден успешно.</p>
                <a href="login.php">Влезте в системата</a>
            </div>
        <?php else: ?>
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post">
                <label>Потребителско име *
                    <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                </label>
                <label>Имейл *
                    <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </label>
                <label>Парола (мин. 6 символа) *
                    <input type="password" name="password" required>
                </label>
                <label>Потвърди парола *
                    <input type="password" name="password_confirm" required>
                </label>
                <button type="submit">Регистрирай се</button>
            </form>

            <div class="login-link">
                <p>Имате вече акаунт? <a href="login.php">Влезте тук</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>