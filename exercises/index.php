<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Упражнения - Начало</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 30px 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        h1 {
            color: white;
            text-align: center;
            margin-bottom: 50px;
            font-size: 2.5em;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .exercises-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .exercise-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .exercise-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-bottom: 4px solid #764ba2;
        }
        
        .card-number {
            display: inline-block;
            background: rgba(255,255,255,0.3);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .card-header h2 {
            font-size: 1.5em;
            margin-bottom: 5px;
        }
        
        .card-header p {
            font-size: 0.95em;
            opacity: 0.95;
        }
        
        .card-content {
            padding: 20px;
        }
        
        .card-content ul {
            list-style: none;
            margin-bottom: 15px;
        }
        
        .card-content li {
            padding: 5px 0;
            color: #555;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .card-content li:last-child {
            border-bottom: none;
        }
        
        .card-content li:before {
            content: "✓ ";
            color: #667eea;
            font-weight: bold;
            margin-right: 8px;
        }
        
        .card-footer {
            padding: 0 20px 20px 20px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: transform 0.2s, box-shadow 0.2s;
            text-align: center;
            width: 100%;
            border: none;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
        }
        
        .btn:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .footer {
            background: white;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            color: #555;
            line-height: 1.8;
        }
        
        .footer h3 {
            color: #667eea;
            margin-bottom: 15px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            margin-top: 10px;
            border-radius: 4px;
            font-size: 0.85em;
            font-weight: bold;
        }
        
        .status-complete {
            background: #d4edda;
            color: #155724;
        }
        
        .status-partial {
            background: #fff3cd;
            color: #856404;
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: 1.8em;
                margin-bottom: 30px;
            }
            
            .exercises-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📚 PHP Упражнения - Колекция</h1>
        
        <div class="exercises-grid">
            <!-- Упражнение 1 -->
            <div class="exercise-card">
                <div class="card-header">
                    <div class="card-number">Упражнение 1</div>
                    <h2>Числа: Четни и Нечетни</h2>
                    <p>Цикли и условия</p>
                </div>
                <div class="card-content">
                    <ul>
                        <li>Отпечатване на числа от 1 до 100</li>
                        <li>Четните числа са с друг цвят</li>
                        <li>HTML форма за избор на брой</li>
                        <li>Валидация на вход</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="01_numbers_even_odd/index.php" class="btn">Отворете упражнението</a>
                    <span class="status-badge status-complete">✓ Завършено</span>
                </div>
            </div>

            <!-- Упражнение 2 -->
            <div class="exercise-card">
                <div class="card-header">
                    <div class="card-number">Упражнение 2</div>
                    <h2>Квадрат с For цикли</h2>
                    <p>Вложени цикли</p>
                </div>
                <div class="card-content">
                    <ul>
                        <li>Два вложени for цикъла</li>
                        <li>Формула за размер на квадрата</li>
                        <li>Отпечатване на звезди</li>
                        <li>Интерактивна форма</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="02_square_with_loops/index.php" class="btn">Отворете упражнението</a>
                    <span class="status-badge status-complete">✓ Завършено</span>
                </div>
            </div>

            <!-- Упражнение 3 -->
            <div class="exercise-card">
                <div class="card-header">
                    <div class="card-number">Упражнение 3</div>
                    <h2>Масив със Случайни Числа</h2>
                    <p>Масиви и цветове</p>
                </div>
                <div class="card-content">
                    <ul>
                        <li>Генериране на масив със случайни числа</li>
                        <li>Четни числа в червено</li>
                        <li>Нечетни числа в черно</li>
                        <li>Динамично генериране</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="03_arrays_random_numbers/index.php" class="btn">Отворете упражнението</a>
                    <span class="status-badge status-complete">✓ Завършено</span>
                </div>
            </div>

            <!-- Упражнение 4 -->
            <div class="exercise-card">
                <div class="card-header">
                    <div class="card-number">Упражнение 4</div>
                    <h2>Div тагове със Цветове</h2>
                    <p>Масиви и стилове</p>
                </div>
                <div class="card-content">
                    <ul>
                        <li>Масив с имена на цветове</li>
                        <li>Div с цветен фон</li>
                        <li>Адаптивен цвят на текста</li>
                        <li>Разпознаване на тъмни цветове</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="04_arrays_colors_divs/index.php" class="btn">Отворете упражнението</a>
                    <span class="status-badge status-complete">✓ Завършено</span>
                </div>
            </div>

            <!-- Упражнение 5 -->
            <div class="exercise-card">
                <div class="card-header">
                    <div class="card-number">Упражнение 5</div>
                    <h2>Масив със Сесия</h2>
                    <p>PHP Sessions</p>
                </div>
                <div class="card-content">
                    <ul>
                        <li>Съхранение на данни в сесия</li>
                        <li>Добавяне на елементи в масив</li>
                        <li>Изтриване на елементи</li>
                        <li>Персистентност на данни</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="05_arrays_session/index.php" class="btn">Отворете упражнението</a>
                    <span class="status-badge status-complete">✓ Завършено</span>
                </div>
            </div>

            <!-- Упражнение 6 -->
            <div class="exercise-card">
                <div class="card-header">
                    <div class="card-number">Упражнение 6</div>
                    <h2>Клас и Обект</h2>
                    <p>Обектно-ориентирано програмиране</p>
                </div>
                <div class="card-content">
                    <ul>
                        <li>Дефиниране на клас със 3 атрибута</li>
                        <li>Getter и setter методи</li>
                        <li>Инстанциране на обект</li>
                        <li>Показване на данните на екрана</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="06_class_basic/index.php" class="btn">Отворете упражнението</a>
                    <span class="status-badge status-complete">✓ Завършено</span>
                </div>
            </div>

            <!-- Упражнение 7 -->
            <div class="exercise-card">
                <div class="card-header">
                    <div class="card-number">Упражнение 7</div>
                    <h2>Форма с Клас</h2>
                    <p>Класове + Форми + Стилове</p>
                </div>
                <div class="card-content">
                    <ul>
                        <li>Минимум 4 полета</li>
                        <li>Dropdown меню за пол</li>
                        <li>Модерен дизайн</li>
                        <li>Обработка на данни със клас</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="07_form_with_class/index.php" class="btn">Отворете упражнението</a>
                    <span class="status-badge status-complete">✓ Завършено</span>
                </div>
            </div>

            <!-- Упражнение 8 -->
            <div class="exercise-card">
                <div class="card-header">
                    <div class="card-number">Упражнение 8</div>
                    <h2>Галерия със Снимки</h2>
                    <p>Качване и преглед на изображения</p>
                </div>
                <div class="card-content">
                    <ul>
                        <li>Качване на JPG/PNG снимки</li>
                        <li>Показване на галерия</li>
                        <li>Опция за отваряне на снимка</li>
                        <li>Опция за изтегляне на снимка</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="08_gallery/index.php" class="btn">Отворете упражнението</a>
                    <span class="status-badge status-complete">✓ Завършено</span>
                </div>
            </div>

            <!-- Упражнение 9 -->
            <div class="exercise-card">
                <div class="card-header">
                    <div class="card-number">Упражнение 9</div>
                    <h2>Запис в База Данни</h2>
                    <p>PDO + Валидация</p>
                </div>
                <div class="card-content">
                    <ul>
                        <li>HTML форма с полета</li>
                        <li>Запис на данни в MySQL чрез PDO</li>
                        <li>Валидация на вход</li>
                        <li>CSRF защита</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="09_form_database/index.php" class="btn">Отворете упражнението</a>
                    <span class="status-badge status-complete">✓ Завършено</span>
                </div>
            </div>

            <!-- Упражнение 10 -->
            <div class="exercise-card">
                <div class="card-header">
                    <div class="card-number">Упражнение 10</div>
                    <h2>Брой Срещания</h2>
                    <p>Данни и статистика</p>
                </div>
                <div class="card-content">
                    <ul>
                        <li>Зареждане от произволна таблица</li>
                        <li>Намиране на дублирани редове</li>
                        <li>Брой на срещанията</li>
                        <li>Табличен преглед</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="10_database_table_count/index.php" class="btn">Отворете упражнението</a>
                    <span class="status-badge status-complete">✓ Завършено</span>
                </div>
            </div>

            <!-- Упражнение 11 -->
            <div class="exercise-card">
                <div class="card-header">
                    <div class="card-number">Упражнение 11</div>
                    <h2>Каталог на Продукти</h2>
                    <p>Пълна e-commerce система</p>
                </div>
                <div class="card-content">
                    <ul>
                        <li>Управление на продукти</li>
                        <li>Работа с категории</li>
                        <li>Кошница за пазаруване</li>
                        <li>Регистрация и логин</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="../catalog/index.php" class="btn">Отворете каталога</a>
                    <span class="status-badge status-partial">~ В папката /catalog</span>
                </div>
            </div>

            <!-- Упражнение 12 -->
            <div class="exercise-card">
                <div class="card-header">
                    <div class="card-number">Упражнение 12</div>
                    <h2>Администраторски Панел</h2>
                    <p>Управление на данни</p>
                </div>
                <div class="card-content">
                    <ul>
                        <li>Логин система</li>
                        <li>CRUD операции</li>
                        <li>Управление на продукти</li>
                        <li>Преглед на поръчки</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="../catalog/admin/index.php" class="btn">Отворете админа</a>
                    <span class="status-badge status-partial">~ В папката /catalog/admin</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <h3>📖 Информация</h3>
            <p>
                Това е колекция от PHP упражнения, които покриват основни концепции като:<br>
                <strong>Цикли, Условия, Масиви, Класове, Формуляри, База Данни, Галерия, Сесии</strong>
            </p>
            <p style="margin-top: 20px; font-size: 0.9em;">
                Всяко упражнение е обучително и демонстрира добри практики на PHP разработката.
            </p>
        </div>
    </div>
</body>
</html>
