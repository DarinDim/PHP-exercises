<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Color Divs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: orange;
        }
    </style>
</head>
<body>

    <form method="post" style="background: #fff3cd; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); max-width: 400px; margin: 40px auto;">
        <label for="elements" style="display: block; font-weight: bold; margin-bottom: 10px; color: #b85c00;">Введете цветове (разделени със запетайка):</label>
        <input 
            type="text" 
            name="elements" 
            id="elements" 
            placeholder="Пример: red, green, blue" 
            style="width: 100%; padding: 10px; border: 1px solid #ffa500; border-radius: 6px; margin-bottom: 15px; font-size: 16px;"
        >
        <button 
            type="submit" 
            style="background: #ffa500; color: white; border: none; padding: 10px 25px; border-radius: 6px; font-size: 16px; cursor: pointer;"
        >Отпечатай</button>
    </form>

    <?php
    // Функция за определяне на светлостта на цвета
    function isColorDark($color) {
        $color = strtolower(trim($color));
        
        // Списък на тъмните цветове
        $darkColors = ['black', 'navy', 'darkblue', 'darkgreen', 'maroon', 'darkred', 'darkgrey', 'grey', 'darkgray'];
        
        return in_array($color, $darkColors);
    }
    
    if (isset($_POST['elements']) && !empty($_POST['elements'])) {
        $input = $_POST['elements'];
        $colors = array_map('trim', explode(',', $input));

        foreach ($colors as $color) {
            if (!empty($color)) {
                $textColor = isColorDark($color) ? 'white' : 'black';
                echo "<div style='background-color: $color; color: $textColor; padding: 100px; margin: 50px; border-radius: 10px;'>Това е цвет: $color</div>";
            }
        }
    }
    ?>

</body>
</html>
