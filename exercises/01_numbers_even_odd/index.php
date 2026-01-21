<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Numbers</title>
</head>
<body>
    <h1>Нечетни и четни числа</h1>
    
    <form method="POST">
        <label for="count">Колко числа да се отпечатят:</label>
        <input type="number" id="count" name="count" min="1" value="100" required>
        <button type="submit">Отпечатай</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $count = isset($_POST['count']) ? intval($_POST['count']) : 100;
        
        if ($count < 1) {
            $count = 1;
        }
        if ($count > 10000) {
            $count = 10000; 
        }
        
        echo "<p><strong>Отпечатване на числа от 1 до $count:</strong></p>";
        
        for ($i = 1; $i <= $count; $i++) {
            if ($i % 2 == 0) {
                echo "<span style='color: red;'>$i</span> ";
                echo "<br>"; 
            } else {
                echo "<span style='color: black; background-color: red;'>$i</span> ";
            }
        }
    } else {
        echo "<p><strong>Отпечатване на числа от 1 до 100:</strong></p>";
        
        for ($i = 1; $i <= 100; $i++) {
            if ($i % 2 == 0) {
                echo "<span style='color: black;'>$i</span> ";
                echo "<br>"; 
            } else {
                echo "<span style='color: red;'>$i</span> ";
            }
        }
    }
    ?>
</body>
</html>
