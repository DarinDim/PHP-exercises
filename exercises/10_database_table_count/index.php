<?php
// Конфигурация на базата данни
$dbConfig = [
    'host' => '127.0.0.1',
    'dbname' => 'test',
    'user' => 'root',
    'pass' => '',
    'charset' => 'utf8mb4',
];

function h($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$data = [];
$errors = [];

// Обработка на POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table_name = trim($_POST['table_name'] ?? '');
    
    if ($table_name === '') {
        $errors[] = 'Моля въведете име на таблица.';
    } else {
        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
        try {
            $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);

            // Проверяваме дали таблицата съществува
            $checkTableSql = "SHOW TABLES LIKE :table";
            $stmt = $pdo->prepare($checkTableSql);
            $stmt->execute([':table' => $table_name]);
            
            if (!$stmt->fetch()) {
                $errors[] = 'Таблица със име "' . h($table_name) . '" не съществува.';
            } else {
                // Зареждаме всички редове от таблицата
                $sql = "SELECT * FROM " . $pdo->quote($table_name);
                $stmt = $pdo->query($sql);
                $rows = $stmt->fetchAll();

                // Съчетаваме дублираните редове и броим срещанията
                $countedRows = [];
                foreach ($rows as $row) {
                    $rowString = json_encode($row);
                    if (!isset($countedRows[$rowString])) {
                        $countedRows[$rowString] = [
                            'data' => $row,
                            'count' => 0
                        ];
                    }
                    $countedRows[$rowString]['count']++;
                }

                $data = array_values($countedRows);
            }

        } catch (PDOException $ex) {
            $errors[] = 'Грешка при свързване с базата данни: ' . h($ex->getMessage());
        }
    }
}
?>
<!doctype html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Брой срещания на записи</title>
    <style>
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            max-width:900px; 
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
            margin-bottom: 20px;
        }
        label { 
            display:block; 
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type=text] { 
            width:100%; 
            padding:10px; 
            box-sizing:border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        input[type=text]:focus {
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
        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #0078d7;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
        }
        tr:hover {
            background: #f9f9f9;
        }
        .count-badge {
            display: inline-block;
            background: #0078d7;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: bold;
            min-width: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Брой срещания на записи в таблица</h1>

    <form method="post">
        <label>Въведете име на таблица:
            <input type="text" name="table_name" placeholder="Пример: users, products и т.н." required>
        </label>
        <button type="submit">Покажи данни</button>
    </form>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <strong>Възникнаха грешки:</strong>
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?php echo $err; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($data)): ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Брой срещания</th>
                        <th>Данни на записа</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $item): ?>
                        <tr>
                            <td>
                                <span class="count-badge"><?php echo $item['count']; ?></span>
                            </td>
                            <td>
                                <pre><?php echo h(json_encode($item['data'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)); ?></pre>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <hr>
    <h3>Инструкции</h3>
    <ul>
        <li>Променете DB настройките в началото на файла: <code>$dbConfig</code>.</li>
        <li>Въведете име на съществуваща таблица в базата данни.</li>
        <li>Ще видите всички редове от таблицата с брой на срещанията за всяка уникална комбинация от данни.</li>
    </ul>

</body>
</html>
