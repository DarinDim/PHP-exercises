 <div style="background: linear-gradient(45deg, #a18cd1, #fbc2eb, #f6d365); padding: 50px 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    
    <div style="max-width: 500px; 
                margin: 0 auto; 
                background-color: rgba(255, 255, 255, 0.9); 
                border: 1px solid rgba(255, 255, 255, 0.4); 
                border-radius: 40px; 
                padding: 40px; 
                box-shadow: 0 15px 35px rgba(0,0,0,0.15);
                text-align: center;">
        
        <h2 style="color: #1e40af; margin-bottom: 10px; font-size: 28px; letter-spacing: 0.5px;">
            Ново съобщение
        </h2>
        
        <div style="height: 3px; width: 60px; background: #2563eb; margin: 0 auto 30px auto; border-radius: 10px;"></div>

        <div style="text-align: left; background: rgba(255, 255, 255, 0.5); padding: 20px; border-radius: 20px; border: 1px solid #eee;">
            <p style="margin: 10px 0; color: #555;">
                <strong style="color: #1e40af;">Име:</strong> 
                <span style="color: #333;"><?php echo htmlspecialchars($_POST['name'] ?? 'N/A'); ?></span>
            </p>
            <p style="margin: 10px 0; color: #555;">
                <strong style="color: #1e40af;">Имейл:</strong> 
                <span style="color: #333;"><?php echo htmlspecialchars($_POST['email'] ?? 'N/A'); ?></span>
            </p>
            
            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed #ccc;">
                <strong style="display: block; margin-bottom: 10px; color: #1e40af;">Съобщение:</strong>
                <p style="color: #444; line-height: 1.6; font-style: italic; background: #fff; padding: 15px; border-radius: 10px;">
                    "<?php echo nl2br(htmlspecialchars($_POST['message'] ?? 'Няма съобщение')); ?>"
                </p>
            </div>
        </div>

        <a href="mailto:<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" 
           style="display: inline-block; 
                  margin-top: 30px; 
                  padding: 15px 35px; 
                  background: linear-gradient(135deg, #2563eb, #1d4ed8); 
                  color: #ffffff; 
                  text-decoration: none; 
                  border-radius: 20px; 
                  font-weight: bold; 
                  box-shadow: 0 5px 15px rgba(37,99,235,0.3);">
            Отговори директно
        </a>

        <p style="margin-top: 30px; font-size: 12px; color: #888;">
            Това писмо е генерирано автоматично от вашата система.
        </p>
    </div>
</div>
 <!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPMailer Template</title>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        /* Твоят оригинален CSS тук */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Comfortaa', cursive; }
        
        body {
            margin: 0; min-height: 100vh;
            background: linear-gradient(45deg, #a18cd1, #fbc2eb, #f6d365, #a18cd1);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            display: flex; flex-direction: column;
            overflow-x: hidden;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        main { flex: 1; display: flex; justify-content: center; align-items: center; padding: 30px 15px; }

        .level-card {
            width: 450px; max-width: 95%;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 40px;
            padding: 50px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            color: #ffffff;
            text-align: center;
            animation: cardFadeIn 0.8s ease-out;
        }

        @keyframes cardFadeIn {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        h2 { color: #1e40af; margin-bottom: 20px; font-size: 2em; }

        input, textarea {
            width: 100%; padding: 15px; margin: 10px 0;
            border-radius: 15px; border: 2px solid rgba(255,255,255,0.3);
            background: rgba(255, 255, 255, 0.4);
            color: #333; font-size: 1em; transition: all 0.3s ease;
        }

        input:focus, textarea:focus {
            background: rgba(0, 0, 0, 0.7);
            color: #fff; border-color: #2563eb; outline: none;
            backdrop-filter: blur(10px);
        }

        button {
            width: 100%; padding: 15px; margin-top: 20px;
            border-radius: 20px; border: none;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white; font-weight: 700; cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(37,99,235,0.4); }
    </style>
</head>
<body>

<main>
    <div class="level-card">
        <h2>Свържете се с нас</h2>
        <form action="send_email.php" method="POST">
            <input type="text" name="name" placeholder="Вашето име" required>
            <input type="email" name="email" placeholder="Вашият Имейл" required>
            <textarea name="message" rows="4" placeholder="Вашето съобщение" style="border-radius:15px; padding:15px; width:100%; border:none;"></textarea>
            <button type="submit">Изпрати запитването</button>
        </form>
    </div>
</main>

</body>
</html>