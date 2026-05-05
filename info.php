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
                        <li><a href="tariffs.php">Тарифы</a></li>
                        <li class="active"><a href="info.html">О нас</a></li>
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
        <div class="about-page">
            <div class="container">

                <h1 class="about-title">О компании НОВОДРАЙВ</h1>

                <p class="about-text">
                    NOVODRIVE — современный сервис каршеринга, который предоставляет удобный доступ к автомобилям в
                    любое время.
                    Мы работаем для того, чтобы сделать передвижение по городу простым, быстрым и доступным.
                </p>

                <div class="about-grid">

                    <div class="about-card">
                        <h3>📍 Местонахождение</h3>
                        <p>
                            Россия, г. Новосибирск<br>
                            ул. Красный проспект<br>

                        </p>
                    </div>

                    <div class="about-card">
                        <h3>📞 Контакты</h3>
                        <p>
                            Телефон: +7 (999) 123-45-67<br>
                            Email: info@novodrive.ru<br>
                            Поддержка: support@novodrive.ru
                        </p>
                    </div>

                    <div class="about-card">
                        <h3>⏰ Режим работы</h3>
                        <p>
                            Сервис: 24/7<br>
                            Поддержка: ежедневно с 08:00 до 23:00
                        </p>
                    </div>

                    <div class="about-card">
                        <h3>🚗 О сервисе</h3>
                        <p>
                            Более 500 автомобилей в городе.<br>
                            Регулярное обслуживание и страхование.<br>
                            Удобное бронирование через сайт.
                        </p>
                    </div>

                </div>

                <div class="about-advantages">
                    <h2>Почему нам можно доверять</h2>

                    <ul>
                        <li>✔ Официально зарегистрированная компания</li>
                        <li>✔ Прозрачные тарифы без скрытых платежей</li>
                        <li>✔ Все автомобили застрахованы</li>
                        <li>✔ Круглосуточный доступ к автомобилям</li>
                        <li>✔ Поддержка пользователей</li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="about-map">
            <div class="container">

                <h2 class="map-title">Мы на карте</h2>

                <div class="map-wrapper">
                    <iframe
                        src="https://yandex.ru/map-widget/v1/?ll=82.920430%2C55.030199&z=16&pt=82.920430,55.030199,pm2rdm">
                    </iframe>
                </div>

            </div>
        </div>
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
    </div>
</body>

</html>