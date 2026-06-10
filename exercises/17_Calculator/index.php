<?php
$expression = '';
$result = null;
$message = '';
$history = [];
$logFile = __DIR__ . '/calculator_history.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $expression = trim($_POST['expression'] ?? '');

    if ($expression === '') {
        $message = 'Моля въведете математически израз, например 12+8 или 5*3.';
    } else {
        $cleanExpression = preg_replace('/\s+/', '', $expression);

        if (preg_match('/^[0-9\.\+\-\*\/\%\(\)]+$/', $cleanExpression)) {
            set_error_handler(function () {
                throw new RuntimeException('Невалиден израз или деление на нула.');
            });

            try {
                @eval('$resultValue = ' . $cleanExpression . ';');
                restore_error_handler();

                if (!isset($resultValue) || is_nan($resultValue) || is_infinite($resultValue)) {
                    throw new RuntimeException('Невалиден израз или деление на нула.');
                }

                $result = $resultValue;
                $message = 'Резултатът е изчислен успешно.';
                $entry = date('Y-m-d H:i:s') . ' | ' . $cleanExpression . ' = ' . $result . PHP_EOL;
                file_put_contents($logFile, $entry, FILE_APPEND | LOCK_EX);
            } catch (Throwable $ex) {
                restore_error_handler();
                $message = 'Грешка: ' . $ex->getMessage();
            }
        } else {
            $message = 'Изразът може да съдържа само цифри, +, -, *, /, %, точка и скоби.';
        }
    }
}

if (file_exists($logFile)) {
    $lines = array_filter(array_map('trim', file($logFile)));
    $history = array_reverse($lines);
}

function esc($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Упражнение 17 — КАЛКУЛАТОР</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at top left, #3a3b77 0%, #120d2f 48%, #090514 100%);
            color: #f5f7ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .calculator-page {
            width: min(1120px, calc(100% - 32px));
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 24px;
            padding: 24px;
        }

        .panel {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 28px;
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.35);
            overflow: hidden;
            backdrop-filter: blur(14px);
        }

        .panel header {
            padding: 40px;
            background: linear-gradient(135deg, rgba(103, 103, 255, 0.95), rgba(59, 130, 246, 0.92));
        }

        .panel header h1 {
            margin: 0;
            font-size: 2rem;
            letter-spacing: 0.04em;
        }

        .panel header p {
            margin: 8px 0 0;
            color: rgba(245, 247, 255, 0.8);
            line-height: 1.5;
        }

        .panel .content {
            padding: 40px;
        }

        .screen {
            width: 100%;
            padding: 18px 22px;
            border-radius: 22px;
            background: rgba(0, 0, 0, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.14);
            color: #f5f7ff;
            font-size: 1.35rem;
            margin-bottom: 18px;
            min-height: 3.8rem;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            overflow-wrap: anywhere;
        }

        .calculator-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .calculator-grid button,
        .calculator-grid input[type="submit"] {
            border: none;
            border-radius: 18px;
            padding: 18px;
            font-size: 1.1rem;
            font-weight: 700;
            color: #0d0e1a;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            background: linear-gradient(180deg, #ebf0ff 0%, #d8e3ff 100%);
            box-shadow: 0 14px 24px rgba(0, 0, 0, 0.12);
        }

        .calculator-grid button:hover,
        .calculator-grid input[type="submit"]:hover {
            transform: translateY(-2px);
        }

        .operator {
            background: linear-gradient(180deg, #4f46e5 0%, #4338ca 100%);
            color: #fff;
        }

        .equal {
            background: linear-gradient(180deg, #ec4899 0%, #db2777 100%);
            color: #fff;
        }

        .clear {
            background: linear-gradient(180deg, #f97316 0%, #ea580c 100%);
            color: #fff;
        }

        .input-block {
            margin-bottom: 18px;
        }

        .input-block label {
            display: block;
            margin-bottom: 8px;
            color: rgba(245, 247, 255, 0.8);
            font-weight: 600;
        }

        .input-block input[type="text"] {
            width: 100%;
            padding: 18px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            font-size: 1rem;
            overflow-wrap: anywhere;
        }

        .message {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
        }

        .message strong {
            color: #f8fafc;
        }

        .result-box {
            margin-top: 12px;
            padding: 18px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #dbeafe;
            font-size: 1.1rem;
            overflow-wrap: anywhere;
        }

        .history {
            margin-top: 18px;
        }

        .history h2 {
            margin-bottom: 14px;
            font-size: 1.15rem;
        }

        .history-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .history-list li {
            margin-bottom: 10px;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #dbeafe;
            font-family: 'Consolas', 'Courier New', monospace;
        }

        .side-panel {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .side-panel article {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 22px;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .side-panel article h2 {
            margin-top: 0;
            margin-bottom: 12px;
            font-size: 1.2rem;
        }

        .side-panel article p {
            line-height: 1.7;
            color: #dbeafe;
        }

        .note {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.75);
            margin-top: 14px;
        }

        @media (max-width: 980px) {
            .calculator-page {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .calculator-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

            .panel header h1 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <div class="calculator-page">
        <section class="panel">
            <header>
                <h1>Калкулатор</h1>
                <p>Въведете математически израз и натиснете =. Резултатът се записва във файл.</p>
            </header>
            <div class="content">
                <?php if ($message): ?>
                    <div class="message"><strong><?php echo esc($message); ?></strong></div>
                <?php endif; ?>

                <form method="post" action="">
                    <div class="input-block">
                        <label for="expression">Математически израз</label>
                        <input type="text" id="expression" name="expression" value="<?php echo esc($expression); ?>" placeholder="Пр. 12+5*3" autocomplete="off">
                    </div>
                    
                    <div class="calculator-grid">
                        <button type="button" onclick="appendValue('(')">(</button>
                        <button type="button" onclick="appendValue(')')">)</button>
                        <button type="button" class="operator" onclick="appendValue('%')">%</button>
                        <button type="button" class="clear" onclick="clearInput()">AC</button>
                        <button type="button" onclick="appendValue('7')">7</button>
                        <button type="button" onclick="appendValue('8')">8</button>
                        <button type="button" onclick="appendValue('9')">9</button>
                        <button type="button" class="operator" onclick="appendValue('/')">÷</button>
                        <button type="button" onclick="appendValue('4')">4</button>
                        <button type="button" onclick="appendValue('5')">5</button>
                        <button type="button" onclick="appendValue('6')">6</button>
                        <button type="button" class="operator" onclick="appendValue('*')">×</button>
                        <button type="button" onclick="appendValue('1')">1</button>
                        <button type="button" onclick="appendValue('2')">2</button>
                        <button type="button" onclick="appendValue('3')">3</button>
                        <button type="button" class="operator" onclick="appendValue('-')">−</button>
                        <button type="button" onclick="appendValue('0')">0</button>
                        <button type="button" onclick="appendValue('.')">.</button>
                        <input type="submit" class="equal" value="=" title="Изчисли">
                        <button type="button" class="operator" onclick="appendValue('+')">+</button>
                    </div>

                    <?php if ($result !== null): ?>
                        <div class="result-box">Резултат: <strong><?php echo esc($result); ?></strong></div>
                    <?php endif; ?>
                </form>

                <div class="history">
                    <h2>Последни изрази</h2>
                    <?php if (count($history) === 0): ?>
                        <p class="note">Няма запазени изрази все още. Първо направете изчисление.</p>
                    <?php else: ?>
                        <ul class="history-list">
                            <?php foreach ($history as $item): ?>
                                <li><?php echo esc($item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <aside class="side-panel">
            <article>
                <h2>Как работи</h2>
                <p>Този калкулатор приема математически изрази с числа, точки, скоби и оператори: <strong>+, -, *, /, %</strong>.</p>
                <p>При изпращане на формата PHP обработва израза, изчислява резултата и добавя запис във файла <code>calculator_history.txt</code>.</p>
            </article>

            <article>
                <h2>Файл с история</h2>
                <p>Всеки въведен и изчислен израз се съхранява във файл, за да може да се проследяват последните операции.</p>
                <p class="note">Файлът се намира в папката на упражнението и се обновява автоматично след всяко натискане на =.</p>
            </article>
        </aside>
    </div>

    <script>
        function appendValue(value) {
            const input = document.getElementById('expression');
            input.value += value;
            document.querySelector('.screen').textContent = input.value || 'Готов за изчисление';
            input.focus();
        }

        function clearInput() {
            const input = document.getElementById('expression');
            input.value = '';
            document.querySelector('.screen').textContent = 'Готов за изчисление';
            input.focus();
        }
    </script>
</body>
</html>
