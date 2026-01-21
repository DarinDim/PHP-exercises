<?php
class RegistrationData {
    public $name;
    public $email;
    public $age;
    public $city;
    public $gender;

    public function __construct($name, $email, $age, $city, $gender) {
        $this->name = htmlspecialchars($name);
        $this->email = htmlspecialchars($email);
        $this->age = htmlspecialchars($age);
        $this->city = htmlspecialchars($city);
        $this->gender = htmlspecialchars($gender);
    }

    public function display() {
        echo "<div class='result'>";
        echo "<h2>Въведени данни:</h2>";
        echo "<p><strong>Име:</strong> $this->name</p>";
        echo "<p><strong>Имейл:</strong> $this->email</p>";
        echo "<p><strong>Възраст:</strong> $this->age</p>";
        echo "<p><strong>Град:</strong> $this->city</p>";
        echo "<p><strong>Пол:</strong> $this->gender</p>";
        echo "</div>";
    }
}

$name = $email = $age = $city = $gender = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $age = $_POST["age"] ?? "";
    $city = $_POST["city"] ?? "";
    $gender = $_POST["gender"] ?? "";

    $data = new RegistrationData($name, $email, $age, $city, $gender);
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f8f8f8; 
            padding: 20px;
        }
        form {
            background: #fff;
            padding: 24px;
            border-radius: 8px;
            max-width: 400px;
            margin: 40px auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        label { 
            display: block; 
            margin-bottom: 6px; 
            font-weight: bold; 
        }
        input[type="text"], input[type="email"], input[type="number"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #bbb;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border 0.2s;
            font-size: 16px;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="number"]:focus, select:focus {
            border: 1.5px solid #0078d7;
            outline: none;
        }
        input[type="submit"] {
            background: #0078d7;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            width: 100%;
        }
        input[type="submit"]:hover {
            background: #005a9e;
        }
        .result {
            background: #e6ffe6;
            border: 1px solid #b2ffb2;
            padding: 18px;
            margin: 24px auto;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .result p {
            margin: 10px 0;
        }
        h1 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Регистрационна форма</h1>
    <form method="post">
        <label for="name">Име:</label>
        <input type="text" id="name" name="name" required value="<?= htmlspecialchars($name) ?>">

        <label for="email">Имейл:</label>
        <input type="email" id="email" name="email" required value="<?= htmlspecialchars($email) ?>">

        <label for="age">Възраст:</label>
        <input type="number" id="age" name="age" min="1" max="120" required value="<?= htmlspecialchars($age) ?>">

        <label for="city">Град:</label>
        <input type="text" id="city" name="city" required value="<?= htmlspecialchars($city) ?>">

        <label for="gender">Пол:</label>
        <select id="gender" name="gender" required>
            <option value="">Изберете</option>
            <option value="Мъж" <?= $gender=="Мъж" ? "selected" : "" ?>>Мъж</option>
            <option value="Жена" <?= $gender=="Жена" ? "selected" : "" ?>>Жена</option>
            <option value="Друго" <?= $gender=="Друго" ? "selected" : "" ?>>Друго</option>
        </select>

        <input type="submit" value="Регистрация">
    </form>

    <?php
    if (isset($data)) {
        $data->display();
    }
    ?>
</body>
</html>
