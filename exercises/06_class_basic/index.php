<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background: #0078d7;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #005a9e;
        }
        .fruit-attributes {
            background: #e6ffe6;
            border: 1px solid #b2ffb2;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .fruit-attributes span {
            font-weight: bold;
        }
        .fruit-attributes p {
            margin: 8px 0;
        }
        h3 {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Клас - Плод</h1>
   
        <?php

        class Fruit
        {
            private $name;
            private $colour;
            private $taste;

            public function __construct($name, $colour, $taste)
            {
                $this->name = $name;
                $this->colour = $colour;
                $this->taste = $taste;
            }

            public function setName($name)
            {
                $this->name = $name;
            }
            public function getName()
            {
                return $this->name;
            }
            public function setColour($colour)
            {
                $this->colour = $colour;
            }
            public function getColour()
            {
                return $this->colour;
            }
            public function setTaste($taste)
            {
                $this->taste = $taste;
            }
            public function getTaste()
            {
                return $this->taste;
            }
        }
        ?>
        
        <form method="post" action="">
            <label for="name">Име на плода:</label>
            <input type="text" id="name" name="name" required><br><br>
            <label for="colour">Цвят:</label>
            <input type="text" id="colour" name="colour" required><br><br>
            <label for="taste">Вкус:</label>
            <input type="text" id="taste" name="taste" required><br><br>
            <input type="submit" value="Отпечатай">
        </form>
        
        <?php
        if (isset($_POST['name']) && isset($_POST['colour']) && isset($_POST['taste'])) {
            $fruit = new Fruit($_POST['name'], $_POST['colour'], $_POST['taste']);
            echo "<h3>Атрибути на плода:</h3>";
            echo "<div class='fruit-attributes'>";
            echo "<p><span>Име:</span> " .  htmlspecialchars($fruit->getName()) . "</p>";
            echo "<p><span>Цвят:</span> " .  htmlspecialchars($fruit->getColour()) . "</p>";
            echo "<p><span>Вкус:</span> " .  htmlspecialchars($fruit->getTaste()) . "</p>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
