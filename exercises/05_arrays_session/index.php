<?php
session_start();

// Инициализация на сесията ако не съществува
if (!isset($_SESSION['values_array'])) {
    $_SESSION['values_array'] = [];
}

// Добавяне на нова стойност
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['input_value'])) {
    $value = trim($_POST['input_value']);
    if (!empty($value)) {
        $_SESSION['values_array'][] = $value;
    }
}

// Изтриване на стойност (по индекс)
if (isset($_GET['delete'])) {
    $index = intval($_GET['delete']);
    if (isset($_SESSION['values_array'][$index])) {
        unset($_SESSION['values_array'][$index]);
        $_SESSION['values_array'] = array_values($_SESSION['values_array']); // Reindex
    }
}

// Изтриване на всичко
if (isset($_GET['clear'])) {
    $_SESSION['values_array'] = [];
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Array</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
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
        .array-list {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            margin: 20px 0;
        }
        .array-list h3 {
            margin-top: 0;
        }
        .list-item {
            background: white;
            padding: 10px;
            margin: 8px 0;
            border-left: 4px solid #0078d7;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .delete-btn {
            background: #d9534f;
            padding: 5px 10px;
            font-size: 12px;
        }
        .delete-btn:hover {
            background: #c9302c;
        }
        .clear-btn {
            background: #5cb85c;
            width: 100%;
            margin-top: 10px;
        }
        .clear-btn:hover {
            background: #4cae4c;
        }
        .empty-message {
            color: #999;
            font-style: italic;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Масив със сесия (PHP Session)</h1>
        <p>Добавяйте стойности в масива, които се запазват в сесията</p>
        
        <div class="form-group">
            <form method="post">
                <label for="input_value">Въведете стойност:</label>
                <input 
                    type="text" 
                    id="input_value" 
                    name="input_value" 
                    placeholder="Напр. Иван, град, продукт..." 
                    required
                >
                <button type="submit">Добави в масив</button>
            </form>
        </div>

        <div class="array-list">
            <h3>Масив (<?php echo count($_SESSION['values_array']); ?> елемента)</h3>
            
            <?php if (empty($_SESSION['values_array'])): ?>
                <p class="empty-message">Масивът е празен. Добавете стойност по-горе.</p>
            <?php else: ?>
                <?php foreach ($_SESSION['values_array'] as $index => $value): ?>
                    <div class="list-item">
                        <span><strong><?php echo ($index + 1); ?>.</strong> <?php echo htmlspecialchars($value); ?></span>
                        <a href="?delete=<?php echo $index; ?>" class="delete-btn" onclick="return confirm('Сигурни ли сте?')">Изтрий</a>
                    </div>
                <?php endforeach; ?>
                <a href="?clear=1" class="clear-btn" onclick="return confirm('Сигурни ли сте че искате да изтриете всичко?')">Изтрий всичко</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
