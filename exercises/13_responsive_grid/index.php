<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Упражнение 13 - Responsive Grid със Bootstrap</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-header {
            color: white;
            text-align: center;
            margin-bottom: 50px;
            animation: slideDown 0.6s ease-out;
        }

        .page-header h1 {
            font-size: 2.5em;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .page-header p {
            font-size: 1.2em;
            opacity: 0.9;
            margin-bottom: 0;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .grid-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .grid-item {
            margin-bottom: 30px;
            animation: fadeInUp 0.6s ease-out backwards;
        }

        .grid-item:nth-child(1) { animation-delay: 0.1s; }
        .grid-item:nth-child(2) { animation-delay: 0.2s; }
        .grid-item:nth-child(3) { animation-delay: 0.3s; }
        .grid-item:nth-child(4) { animation-delay: 0.4s; }
        .grid-item:nth-child(5) { animation-delay: 0.5s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-12px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.25);
        }

        .card-img-container {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 250px;
        }

        .card-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .card:hover .card-img-container img {
            transform: scale(1.1);
        }

        .card-body {
            background: white;
            padding: 25px;
        }

        .card-title {
            color: #667eea;
            font-size: 1.3em;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .card-text {
            color: #666;
            font-size: 0.95em;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .badge-custom {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            margin-right: 8px;
            margin-bottom: 8px;
        }

        .section-title {
            color: white;
            font-size: 1.8em;
            font-weight: 600;
            margin-top: 40px;
            margin-bottom: 25px;
            text-align: center;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        .info-box {
            background: rgba(255,255,255,0.1);
            border-left: 4px solid white;
            padding: 20px;
            border-radius: 8px;
            color: white;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
        }

        .info-box strong {
            font-size: 1.1em;
            display: block;
            margin-bottom: 10px;
        }

        /* Responsive Design - Mobile First */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 1.8em;
            }

            .card {
                margin-bottom: 20px;
            }

            .section-title {
                font-size: 1.3em;
            }
        }

        /* Tablet screens */
        @media (min-width: 768px) and (max-width: 991px) {
            .grid-item {
                margin-bottom: 25px;
            }
        }

        /* Large screens */
        @media (min-width: 992px) {
            .grid-item {
                margin-bottom: 30px;
            }
        }

        footer {
            color: white;
            text-align: center;
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid rgba(255,255,255,0.2);
            font-size: 0.9em;
        }

        footer a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="page-header">
        <p>Responsive Grid със Bootstrap</p>
    </div>

    <div class="grid-container">
        <!-- Information Box -->
        <div class="info-box">
            <strong> За упражнението:</strong>
            Това упражнение демонстрира Bootstrap grid система с адаптивен дизайн.
            Преоразмерете браузъра, за да видите как колоните се преустройват автоматично!
        </div>

        <!-- First Row - 3 Columns -->
        <div class="section-title"> Първи ред - Три колони</div>
        <div class="row">
            <!-- Card 1 -->
            <div class="col-12 col-sm-6 col-md-6 grid-item">
                <div class="card">
                    <div class="card-img-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/61/HTML5_logo_and_wordmark.svg/1280px-HTML5_logo_and_wordmark.svg.png" alt="Технология 1">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"> HTML5</h5>
                        <p class="card-text">
                            HTML5 е последната версия на HTML с нови елементи и семантични тагове за по-добра структура на уеб страниците.
                        </p>
                        <span class="badge-custom">Web</span>
                        <span class="badge-custom">Frontend</span>
                        <div class="responsive-info">
                            На телефон: цял екран
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-12 col-sm-6 col-md-3 grid-item">
                <div class="card">
                    <div class="card-img-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d5/CSS3_logo_and_wordmark.svg/960px-CSS3_logo_and_wordmark.svg.png" alt="Технология 2">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"> CSS3</h5>
                        <p class="card-text">
                            CSS3 позволява стилизиране и анимации на уеб страниците с модерни техники като Flexbox и Grid.
                        </p>
                        <span class="badge-custom">Styling</span>
                        <span class="badge-custom">Design</span>
                        <div class="responsive-info">
                            На таблет: 1/2 екран
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-12 col-sm-6 col-md-3 grid-item">
                <div class="card">
                    <div class="card-img-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/99/Unofficial_JavaScript_logo_2.svg/1280px-Unofficial_JavaScript_logo_2.svg.png" alt="Технология 3">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"> JavaScript</h5>
                        <p class="card-text">
                            JavaScript е език за програмиране в браузъра, който прави уеб страниците интерактивни и динамични.
                        </p>
                        <span class="badge-custom">Interactive</span>
                        <span class="badge-custom">Backend</span>
                        <div class="responsive-info">
                            На компютър: 1/3 екран
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row - 2 Columns -->
        <div class="section-title"> Втори ред - Две колони</div>
        <div class="row">
            <!-- Card 4 -->
            <div class="col-12 col-sm-6 col-lg-5 grid-item">
                <div class="card">
                    <div class="card-img-container">
                        <img src="https://upload.wikimedia.org/wikipedia/mg/thumb/6/62/MySQL.svg/2560px-MySQL.svg.png" alt="Технология 4">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"> MySQL</h5>
                        <p class="card-text">
                            MySQL е релационна база данни, която се използва за съхранение и управление на данни в уеб приложенията.
                        </p>
                        <span class="badge-custom">Database</span>
                        <span class="badge-custom">Backend</span>
                        <div class="responsive-info">
                            На телефон: цял екран<br>
                            На компютър: 1/2 екран
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="col-12 col-sm-6 col-lg-7 grid-item">
                <div class="card">
                    <div class="card-img-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Bootstrap_logo.svg/1280px-Bootstrap_logo.svg.png" alt="Технология 5">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"> Bootstrap</h5>
                        <p class="card-text">
                            Bootstrap е популярен CSS framework, който позволява бързо и лесно създаване на адаптивни уеб дизайни. 
                            Включва готови компоненти, CSS класове и JavaScript функционалност.
                            С Bootstrap Grid система можете лесно да създавате responsive дизайни без да пишете много CSS код.
                        </p>
                        <span class="badge-custom">Framework</span>
                        <span class="badge-custom">Responsive</span>
                        <span class="badge-custom">CSS</span>
                        <div class="responsive-info">
                            На телефон: цял екран<br>
                            На компютър: по-голяма колона
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div style="text-align: center; margin-top: 50px;">
            <a href="../index.php" class="btn btn-light btn-lg" style="box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                ← Назад към упражненията
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p style="margin-top: 15px;">Упражнение 13 - Responsive Grid | Bootstrap 5 | <a href="https://getbootstrap.com" target="_blank">getbootstrap.com</a></p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
