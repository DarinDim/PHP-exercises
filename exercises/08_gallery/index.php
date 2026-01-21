<?php
if ($_POST) {
    $f = $_FILES['picture'];
    $name = $f['name'];
    $tmp = $f['tmp_name'];
    $type = $f['type'];

    if ($f['error'] !== UPLOAD_ERR_OK) {
        echo "Грешка при качването.<br><br>";
    } elseif ($type !== "image/jpeg" && $type !== "image/png") {
        echo "Качете само JPG или PNG снимка.<br><br>";
    } else {
        if (!is_dir('images')) mkdir('images', 0755, true);
        $ext = $type === "image/png" ? '.png' : '.jpg';
        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($name, PATHINFO_FILENAME));
        $newName = time() . '_' . $cleanName . $ext;
        if (move_uploaded_file($tmp, "images/$newName")) {
            echo "Снимката е качена успешно: <a href='images/$newName' target='_blank'>$newName</a><br><br>";
        } else {
            echo "Неуспешно качване.<br><br>";
        }
    }
}

// Display gallery
$images = [];
if (is_dir('images')) {
    $images = array_diff(scandir('images'), ['.', '..']);
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерия със снимки</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .upload-form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        input[type="file"] {
            display: block;
            margin: 10px 0;
            padding: 10px;
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
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .gallery-item {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }
        .gallery-item-actions {
            padding: 15px;
            text-align: center;
        }
        .gallery-item-actions a {
            display: inline-block;
            margin: 5px;
            padding: 8px 15px;
            background: #0078d7;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .gallery-item-actions a:hover {
            background: #005a9e;
        }
        .delete-btn {
            background: #d9534f !important;
        }
        .delete-btn:hover {
            background: #c9302c !important;
        }
        .empty {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        h1 {
            color: #333;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Галерия със снимки</h1>
        
        <div class="upload-form">
            <h2>Качване на снимка</h2>
            <form method="post" enctype="multipart/form-data">
                <label for="picture">Изберете снимка за качване (JPG или PNG):</label>
                <input type="file" name="picture" id="picture" accept="image/jpeg,image/png" required>
                <button type="submit">Качи снимка</button>
            </form>
        </div>

        <h2>Галерия</h2>
        <?php if (empty($images)): ?>
            <div class="empty">
                <p>Нова галерия. Качете първата снимка по-горе!</p>
            </div>
        <?php else: ?>
            <div class="gallery">
                <?php foreach ($images as $image): ?>
                    <div class="gallery-item">
                        <img src="images/<?php echo urlencode($image); ?>" alt="<?php echo htmlspecialchars($image); ?>">
                        <div class="gallery-item-actions">
                            <a href="images/<?php echo urlencode($image); ?>" target="_blank">Отвори</a>
                            <a href="images/<?php echo urlencode($image); ?>" download class="download-btn">Изтегли</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
