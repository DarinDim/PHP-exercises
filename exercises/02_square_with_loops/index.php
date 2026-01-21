<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Square with loops</title>
</head>
<body>
    <h1>Рисуване на квадрат с два for цикъла</h1>
    
    <form action="index.php" method="post">
        <label for="size">Дължина на страната на квадрата:</label>
        <input id="size" type="number" name="size" min="1" value="">
        <button type="submit" name="draw">Начертай квадрат</button>
    </form>
    <br>
    <?php
        $size = $_POST['size'] ?? 0;
        if ($size > 0) {
            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size; $j++) {
                    echo "* &nbsp;&nbsp;";
                }
                echo "<br>";
            }
        }
    ?>
</body>
</html>
