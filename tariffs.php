<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novodrive</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="wrapper">

        <header class="site-header">
            <div class="container">
                <div class="logo"><a href="index.php">НОВОДРАЙВ</a></div>
                <nav class="menu">
                    <ul>
                        <li><a href="index.php">Главная</a></li>
                        <li class="active"><a href="tariffs.html">Тарифы</a></li>
                        <li><a href="info.php">О нас</a></li>
                        <li class="profile dropdown">
                            <a href="profile.php" class="profile-btn">
                                <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?>
                                <img src="img/ix_user-profile-filled.png" alt="person">
                            </a>

                            <div class="dropdown-menu">
                                <a href="profile.php">Профиль</a>
                                <a href="php/logout.php">Выйти</a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="tariff-hero">
            <div class="container">
                <h1>Выберите тариф по душе и ситуации</h1>
                <p>Любой автомобиль под Ваши предпочтения, любой тариф под Вашу ситуацию</p>
            </div>
        </div>
        <div class="tariff-slider">

            <div class="tariff-tabs">
                <button class="tab active" data-slide="0">Фикс</button>
                <button class="tab" data-slide="1">Поминутно</button>
                <button class="tab" data-slide="2">Свой тариф</button>
                <button class="tab" data-slide="3">Подписка</button>
            </div>

            <div class="slides">

                <div class="slide active slide1">
                    <div class="slide-content">
                        <h2>Фиксированная цена поездки.<br>Без сюрпризов.</h2>

                        <a href="cars.php" class="choose-btn">
                            Выбрать авто →
                        </a>
                    </div>

                    <div class="cars">
                        <div>Mini<br><span>от 135 ₽</span></div>
                        <div>Mini+<br><span>от 155 ₽</span></div>
                        <div>Optimal<br><span>от 145 ₽</span></div>
                        <div>Business<br><span>от 150 ₽</span></div>
                    </div>
                </div>

                <div class="slide slide2">
                    <div class="slide-content">
                        <h2>Платите только за время.<br>Гибкий формат поездок.</h2>

                        <a href="cars.php" class="choose-btn">
                            Выбрать авто →
                        </a>
                    </div>

                    <div class="cars">
                        <div>Mini<br><span>от 7 ₽/мин</span></div>
                        <div>Mini+<br><span>от 8 ₽/мин</span></div>
                        <div>Optimal<br><span>от 7 ₽/мин</span></div>
                        <div>Business<br><span>от 10 ₽/мин</span></div>
                    </div>
                </div>

                <div class="slide slide3">
                    <div class="slide-content">
                        <h2>Соберите свой тариф.<br>Платите только за нужное.</h2>

                        <a href="cars.php" class="choose-btn">
                            Выбрать авто →
                        </a>
                    </div>

                    <div class="cars">
                        <div>Mini<br><span>от 120 ₽</span></div>
                        <div>Mini+<br><span>от 140 ₽</span></div>
                        <div>Optimal<br><span>от 135 ₽</span></div>
                        <div>Business<br><span>от 145 ₽</span></div>
                    </div>
                </div>

                <div class="slide slide4">
                    <div class="slide-content">
                        <h2>Подписка на поездки.<br>Экономия каждый месяц.</h2>

                        <a href="cars.php" class="choose-btn">
                            Выбрать авто →
                        </a>
                    </div>

                    <div class="cars">
                        <div>Mini<br><span>от 3000 ₽/мес</span></div>
                        <div>Mini+<br><span>от 3500 ₽/мес</span></div>
                        <div>Optimal<br><span>от 3300 ₽/мес</span></div>
                        <div>Business<br><span>от 4000 ₽/мес</span></div>
                    </div>
                </div>

            </div>
        </div>

        <script>
            const tabs = document.querySelectorAll('.tab');
            const slides = document.querySelectorAll('.slide');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    slides.forEach(s => s.classList.remove('active'));

                    tab.classList.add('active');
                    slides[tab.dataset.slide].classList.add('active');
                });
            });
        </script>
        <footer class="footer">
            <div class="footer-container">

                <div class="footer-left">
                    <h3>НОВОДРАЙВ</h3>
                    <p>Удобный сервис каршеринга для города</p>
                </div>

                <div class="footer-center">
                    <ul>
                        <li><a href="index.php">Главная</a></li>
                        <li><a href="tariffs.php">Тарифы</a></li>
                        <li><a href="info.php">О нас</a></li>
                    </ul>
                </div>

                <div class="footer-right">
                    <p>+7 (999) 123-45-67</p>
                    <p>✉ info@novodrive.ru</p>
                </div>

            </div>

            <div class="footer-bottom">
                <p>© 2026 Новодрайв. Все права защищены.</p>
            </div>
        </footer>
</body>

</html>