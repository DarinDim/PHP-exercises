<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username !== '' && $password !== '') {
    $stmt = $pdo->prepare('SELECT id, username, password_hash, role FROM users WHERE username = :u');
    $stmt->execute(['u' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header('Location: admin/dashboard.php');
        } else {
            header('Location: customer/dashboard.php');
        }
        exit;
    } else {
        $error = 'Грешно потребителско име или парола.';
    }
    } else {
        $error = 'Моля, попълнете всички полета.';
    }
}
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background: #f6f8fb; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 20px; }
        .login-container { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; width: 100%; max-width: 800px; }
        .login-box { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .login-box h2 { text-align: center; margin: 0 0 20px; font-size: 1.3rem; }
        .login-box label { display: block; margin-bottom: 10px; font-weight: 500; }
        .login-box input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .login-box button { width: 100%; padding: 10px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; }
        .login-box button:hover { background: #1d4ed8; }
        .error { background: #fee; color: #c00; padding: 10px; margin-bottom: 15px; border-radius: 6px; border: 1px solid #fcc; text-align: center; }
        .signup-link { text-align: center; margin-top: 15px; }
        .signup-link a { color: #2563eb; text-decoration: none; }
        .signup-link a:hover { text-decoration: underline; }
        .demo-creds { margin-top: 15px; font-size: 0.85rem; color: #666; padding: 10px; background: #f0f0f0; border-radius: 4px; }
        @media (max-width: 700px) { .login-container { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Админ вход</h2>
            <form method="post">
                <label>Потребителско име
                    <input type="text" name="username" autofocus>
                </label>
                <label>Парола
                    <input type="password" name="password">
                </label>
                <button type="submit">Вход (Админ)</button>
            </form>
            <div class="demo-creds">
                <strong>Demo админ:</strong><br>
                username: admin<br>
                password: admin123
            </div>
        </div>

        <div class="login-box">
            <h2>Клиент вход</h2>
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="post">
                <label>Потребителско име
                    <input type="text" name="username">
                </label>
                <label>Парола
                    <input type="password" name="password">
                </label>
                <button type="submit">Вход (Клиент)</button>
            </form>
            <div class="signup-link">
                <p>Нямате акаунт? <a href="register.php">Регистрирайте се</a></p>
            </div>
            <div class="demo-creds">
                <strong>Demo клиент:</strong><br>
                username: customer1<br>
                password: admin123
            </div>
        </div>
    </div>
</body>
</html>