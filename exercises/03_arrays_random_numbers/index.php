<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Array</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .form-group {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        input[type="number"] {
            padding: 8px;
            margin: 0 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 8px 16px;
            background: #0078d7;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .result {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .even { color: red; font-weight: bold; }
        .odd { color: black; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Масив със случайни числа</h1>
        <p>Четните числа се показват в <span class="even">красно</span>, нечетните в <span class="odd">черно</span></p>
        
        <div class="form-group">
            <form method="post">
                <label for="count">Брой на числата:</label>
                <input type="number" id="count" name="count" min="1" value="20" required>
                <button type="submit">Генериране</button>
            </form>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $count = intval($_POST['count'] ?? 20);
            if ($count < 1) $count = 1;
            if ($count > 1000) $count = 1000;
            
            // Создание на масив със случайни числа
            $numbers = [];
            for ($i = 0; $i < $count; $i++) {
                $numbers[] = rand(1, 100);
            }
            
            echo '<div class="result">';
            echo "<h2>Генериран масив ($count числа):</h2>";
            echo '<p>';
            foreach ($numbers as $num) {
                if ($num % 2 == 0) {
                    echo "<span class='even'>$num</span> ";
                } else {
                    echo "<span class='odd'>$num</span> ";
                }
            }
            echo '</p>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>
