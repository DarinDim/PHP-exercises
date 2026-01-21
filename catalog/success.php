<?php
session_start();

$order_id = $_SESSION['order_id'] ?? null;
$order_total = $_SESSION['order_total'] ?? 0;
$order_name = $_SESSION['order_name'] ?? 'Гост';

// Clear session values
unset($_SESSION['order_id']);
unset($_SESSION['order_total']);
unset($_SESSION['order_name']);
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Успешна поръчка</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .success-container { max-width: 600px; margin: 0 auto; text-align: center; }
        .success-box { background: white; padding: 40px 20px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .success-icon { font-size: 3rem; margin-bottom: 20px; }
        .success-message { color: #16a34a; font-size: 1.2rem; margin-bottom: 10px; }
        .order-details { background: #f0fdf4; border: 1px solid #bbf7d0; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .detail-row { display: flex; justify-content: space-between; margin-bottom: 8px; }
    </style>
</head>
<body>
<div class="container">
    <div class="success-container">
        <div class="success-box">
            <div class="success-icon">✓</div>
            <div class="success-message">Поръчката е успешна!</div>
            
            <?php if ($order_id): ?>
                <div class="order-details">
                    <div class="detail-row">
                        <span>Номер на поръчка:</span>
                        <strong>#<?= $order_id ?></strong>
                    </div>
                    <div class="detail-row">
                        <span>Клиент:</span>
                        <strong><?= htmlspecialchars($order_name) ?></strong>
                    </div>
                    <div class="detail-row">
                        <span>Обща сума:</span>
                        <strong><?= number_format($order_total, 2) ?> лв.</strong>
                    </div>
                </div>
                <p style="color: #666; font-size: 0.9rem;">На вашия имейл ще получите потвърждение на поръчката.</p>
            <?php endif; ?>

            <div style="margin-top: 30px;">
                <a class="btn add" href="index.php">Продължи пазаруване</a>
                <p style="margin-top: 10px; color: #666;">
                    <small>Админ парола: <a href="login.php" style="color: #2563eb;">admin панел</a></small>
                </p>
            </div>
        </div>
    </div>
</div>
</body>
</html>