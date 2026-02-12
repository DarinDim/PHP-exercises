<?php
$heroes = [
    [
        "name" => "Батман",
        "description" => "Тъмният рицар на Готъм. Без свръхсили, но с изключителен интелект и технологии.",
        "image" => "images/batman.jpeg"
    ],
    [
        "name" => "Спайдърмен",
        "description" => "Притежава паяшки сили, свръхрефлекси и способност да се катери по стени.",
        "image" => "images/spiderman.webp"
    ],
    [
        "name" => "Железния човек",
        "description" => "Гений, милиардер и изобретател със свръхмодерен костюм.",
        "image" => "images/ironman.webp"
    ],
    [
        "name" => "Жената чудо",
        "description" => "Амазонска принцеса със свръхсила и магически оръжия.",
        "image" => "images/wonderwoman.png"
    ]
];
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Супергерои</title>
    <link rel="icon" href="images/B-favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Светът на Супергероите</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#">Начало</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Герои</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Контакти</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- CAROUSEL -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

        <div class="carousel-item active">
            <img src="images/header1.webp" class="d-block w-100" height="500">
        </div>

        <div class="carousel-item">
            <img src="images/header2.jpg" class="d-block w-100" height="500">
        </div>

        <div class="carousel-item">
            <img src="images/header3.jpg" class="d-block w-100" height="500">
        </div>

    </div>
</div>

<!-- HEROES SECTION -->
<div class="container my-5">
    <h2 class="text-center mb-4">Нашите Супергерои</h2>

    <div class="row">

        <?php foreach($heroes as $hero): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow">
                    <img src="<?php echo $hero['image']; ?>" class="card-img-top" height="300">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $hero['name']; ?></h5>
                        <p class="card-text"><?php echo $hero['description']; ?></p>
                        <a href="#" class="btn btn-primary">Виж повече</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<!-- Footer -->
<footer class="text-center text-lg-start bg-body-tertiary text-muted">
  <!-- Section: Social media -->
  <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
    <!-- Left -->
    <div class="me-5 d-none d-lg-block">
      <span>Следете ни в социалните мрежи:</span>
    </div>
    <!-- Left -->

    <!-- Right -->
    <div>
  <a href="" class="me-4 text-dark">
    <i class="fab fa-facebook-f"></i>
  </a>
  <a href="" class="me-4 text-dark">
    <i class="fab fa-twitter"></i>
  </a>
  <a href="" class="me-4 text-dark">
    <i class="fab fa-google"></i>
  </a>
  <a href="" class="me-4 text-dark">
    <i class="fab fa-instagram"></i>
  </a>
  <a href="" class="me-4 text-dark">
    <i class="fab fa-linkedin"></i>
  </a>
  <a href="" class="me-4 text-dark">
    <i class="fab fa-github"></i>
  </a>
</div>

    <!-- Right -->
  </section>
  <!-- Section: Social media -->

  <!-- Section: Links  -->
  <section class="">
    <div class="container text-center text-md-start mt-5">
      <!-- Grid row -->
      <div class="row mt-3">
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <!-- Content -->
          <h6 class="text-uppercase fw-bold mb-4">
            <i class="fas fa-gem me-3"></i>Дарин Димитров
          </h6>
          <p>
            Супергеройска промо страница. Страницата представя различни супергерои чрез карти и слайдшоу.
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Супер Герои
          </h6>
          <p>
            <a href="#!" class="text-reset">Батман</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Спайдърмен</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Иронман</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Жената Чудо</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
                Полезни линкове
          </h6>
          <p>
            <a href="#!" class="text-reset">Профил</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Настройки</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Поръчки</a>
          </p>
          <p>
            <a href="#!" class="text-reset">Помощ</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">Контакти</h6>
          <p><i class="fas fa-home me-3"></i> Ул. Перуша 4, Правец, България</p>
          <p>
            <i class="fas fa-envelope me-3"></i>
            22507@uktc-bg.com
          </p>
          <p><i class="fas fa-phone me-3"></i> + 088 123 456 789</p>
          <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
        </div>
        <!-- Grid column -->
      </div>
      <!-- Grid row -->
    </div>
  </section>
  <!-- Section: Links  -->

  <!-- Copyright -->
  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2026 Copyright:
    <a class="text-reset fw-bold" href="https://mdbootstrap.com/">MDBootstrap.com</a>
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->