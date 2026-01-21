<?php
session_start();

// --- Конфигурация на базата данни: попълнете според вашата среда ---
$dbConfig = [
    'host' => '127.0.0.1',
    'dbname' => 'test',        // промяна: името на базата данни
    'user' => 'root',
    'pass' => '',
    'charset' => 'utf8mb4',
];

// Няколко малки помощни функции
function h($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

// Генерираме CSRF токен за базова защита (не запазва от всичко, но е полезно)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}

$errors = [];
$success = '';
$values = ['name'=>'','email'=>'','age'=>'','comment'=>''];

// Обработка на POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // проверка на CSRF
    $postedToken = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'], $postedToken)) {
        $errors[] = 'Невалиден CSRF токен. Опитайте пак.';
    }

    // Задължителни/опционални полета
    $values['name'] = trim((string)($_POST['name'] ?? ''));
    $values['email'] = trim((string)($_POST['email'] ?? ''));
    $values['age'] = trim((string)($_POST['age'] ?? ''));
    $values['comment'] = trim((string)($_POST['comment'] ?? ''));

    if ($values['name'] === '') {
        $errors[] = 'Името е задължително.';
    }
    if ($values['email'] === '' || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Моля въведете валиден имейл.';
    }
    if ($values['age'] !== '') {
        if (!ctype_digit($values['age']) || (int)$values['age'] < 1 || (int)$values['age'] > 120) {
            $errors[] = 'Възрастта трябва да е число между 1 и 120.';
        }
    }

    // Ако няма валидационни грешки — опит за запис
    if (empty($errors)) {
        // Подготвяме връзка PDO
        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
        try {
            $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            // Създаваме таблицата ако не съществува (леко модифицирана схема, уникален email)
            $createSql = "CREATE TABLE IF NOT EXISTS submissions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(150) NOT NULL UNIQUE,
                age TINYINT NULL,
                comment TEXT NULL,
                ref_code VARCHAR(32) NOT NULL UNIQUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            $pdo->exec($createSql);

            // Подготовка за запис
            $insertSql = 'INSERT INTO submissions (name, email, age, comment, ref_code) VALUES (:name, :email, :age, :comment, :ref)';
            $stmt = $pdo->prepare($insertSql);

            // генерираме уникален референтен код (16 байта hex -> 32 chars). В редки случаи на колизия ще хвърлим повтор.
            $ref = bin2hex(random_bytes(16));

            // Преобразуваме възраст към NULL ако е празна
            $ageParam = $values['age'] === '' ? null : (int)$values['age'];

            try {
                $stmt->execute([
                    ':name' => $values['name'],
                    ':email' => $values['email'],
                    ':age' => $ageParam,
                    ':comment' => $values['comment'],
                    ':ref' => $ref,
                ]);

                $success = 'Данните бяха записани успешно. Референтен код: ' . h($ref);
                // Изчистваме стойностите в полетата след успешен запис
                $values = ['name'=>'','email'=>'','age'=>'','comment'=>''];
                // смяна на CSRF токена след успешен POST
                $_SESSION['csrf_token'] = bin2hex(random_bytes(16));

            } catch (PDOException $e) {
                // Проверяваме за дублиране на уникален индекс (email или ref_code)
                if ($e->errorInfo[1] ?? null) {
                    $errCode = $e->errorInfo[1];
                    // 1062 = duplicate entry
                    if ($errCode == 1062) {
                        // опитваме да определим кое поле е причина
                        if (stripos($e->getMessage(), 'email') !== false) {
                            $errors[] = 'Този имейл вече е използван (въведете друг или изтрийте стария запис).';
                        } else {
                            $errors[] = 'Възникна дублиране на ключ (опитайте отново).';
                        }
                    } else {
                        $errors[] = 'Грешка при записа: ' . h($e->getMessage());
                    }
                } else {
                    $errors[] = 'Грешка при записа: ' . h($e->getMessage());
                }
            }

        } catch (PDOException $ex) {
            $errors[] = 'Не може да се свърже с базата данни: ' . h($ex->getMessage());
        }
    }
}
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Форма за запис в база (PDO)</title>
    <style>
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            max-width:700px; 
            margin:24px auto; 
            padding:0 12px; 
            background: #f5f5f5;
        }
        h1 {
            color: #333;
        }
        form { 
            background:#fff; 
            padding:20px; 
            border-radius:8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        label { 
            display:block; 
            margin-top:12px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type=text], input[type=email], textarea { 
            width:100%; 
            padding:10px; 
            box-sizing:border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        input[type=text]:focus, input[type=email]:focus, textarea:focus {
            border: 1.5px solid #0078d7;
            outline: none;
        }
        button {
            background: #0078d7;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #005a9e;
        }
        .errors { 
            background:#ffe6e6; 
            border:1px solid #ffb3b3; 
            padding:12px; 
            border-radius:4px;
            margin-bottom: 15px;
        }
        .errors ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        .errors li {
            margin: 5px 0;
        }
        .success { 
            background:#e6ffe6; 
            border:1px solid #b3ffb3; 
            padding:12px; 
            border-radius:4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Форма за запис в база (PDO)</h1>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <strong>Възникнаха грешки:</strong>
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?php echo h($err); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success !== ''): ?>
        <div class="success"><?php echo h($success); ?></div>
    <?php endif; ?>

    <form method="post" novalidate>
        <input type="hidden" name="csrf_token" value="<?php echo h($_SESSION['csrf_token']); ?>">

        <label>Име (задължително)
            <input type="text" name="name" value="<?php echo h($values['name']); ?>" required>
        </label>

        <label>Имейл (задължително, уникален)
            <input type="email" name="email" value="<?php echo h($values['email']); ?>" required>
        </label>

        <label>Възраст (по избор)
            <input type="text" name="age" value="<?php echo h($values['age']); ?>" pattern="\d*">
        </label>

        <label>Коментар (по избор)
            <textarea name="comment" rows="4"><?php echo h($values['comment']); ?></textarea>
        </label>

        <p><button type="submit">Запази</button></p>
    </form>

    <hr>
    <h3>Инструкции</h3>
    <ul>
        <li>Променете DB настройките в началото на файла: <code>$dbConfig</code>.</li>
        <li>Файлът автоматично създава таблицата <code>submissions</code>, ако липсва.</li>
        <li>Имейлът е уникален (UNIQUE). Ако желаете да позволите многократни записи от един имейл, премахнете UNIQUE от схемата.</li>
    </ul>

</body>
</html>
