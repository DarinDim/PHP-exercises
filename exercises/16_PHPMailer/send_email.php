<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    $host = $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
    $username = $_ENV['MAIL_USERNAME'] ?? '';
    $password = $_ENV['MAIL_PASSWORD'] ?? '';
    $port = $_ENV['SMTP_PORT'] ?? 587;
    $secure = $_ENV['SMTP_SECURE'] ?? 'tls';
    $fromAddress = $_ENV['MAIL_FROM_ADDRESS'] ?? $username;
    $fromName = $_ENV['MAIL_FROM_NAME'] ?? 'Контактна Форма';
    $toAddress = $_ENV['MAIL_TO_ADDRESS'] ?? $username;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = $host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $username;
        $mail->Password   = $password;
        $mail->SMTPSecure = $secure === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = (int) $port;
        $mail->CharSet    = 'UTF-8';
    
        $mail->setFrom($fromAddress, $fromName);
        $mail->addAddress($toAddress);
        $mail->addReplyTo($email, $name);
        $mail->isHTML(true);
        $mail->Subject = 'Ново запитване от: ' . $name;
        
        $mail->Body    = '
        <div style="background: linear-gradient(45deg, #a18cd1, #fbc2eb, #f6d365); padding: 50px 20px; font-family: sans-serif;">
            <div style="max-width: 500px; margin: 0 auto; background-color: rgba(255, 255, 255, 0.9); border-radius: 40px; padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.15); text-align: center;">
                <h2 style="color: #1e40af; margin-bottom: 10px; font-size: 28px;">Ново съобщение</h2>
                <div style="height: 3px; width: 60px; background: #2563eb; margin: 0 auto 30px auto; border-radius: 10px;"></div>
                <div style="text-align: left; background: rgba(255, 255, 255, 0.5); padding: 20px; border-radius: 20px; border: 1px solid #eee;">
                    <p style="margin: 10px 0; color: #555;"><strong style="color: #1e40af;">Име:</strong> ' . $name . '</p>
                    <p style="margin: 10px 0; color: #555;"><strong style="color: #1e40af;">Имейл:</strong> ' . $email . '</p>
                    <div style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed #ccc;">
                        <strong style="display: block; margin-bottom: 10px; color: #1e40af;">Съобщение:</strong>
                        <p style="color: #444; line-height: 1.6; font-style: italic; background: #fff; padding: 15px; border-radius: 10px;">
                            "' . nl2br($message) . '"
                        </p>
                    </div>
                </div>
                <a href="mailto:' . $email . '" style="display: inline-block; margin-top: 30px; padding: 15px 35px; background: #2563eb; color: #ffffff; text-decoration: none; border-radius: 20px; font-weight: bold;">
                    Отговори директно
                </a>
            </div>
        </div>';

        $mail->send();
        echo "Съобщението е изпратено успешно!";
    } catch (Exception $e) {
        echo "Грешка при изпращане: {$mail->ErrorInfo}";
    }
}
?>