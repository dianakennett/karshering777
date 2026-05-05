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
                        <li class="active"><a href="index.php">Главная</a></li>
                        <li><a href="tariffs.php">Тарифы</a></li>
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

        <div class="hero-container">
            <div class="hero-info">
                <h1>Ваш личный автомобиль в любое время</h1>
            </div>

            <div class="hero-card">
                <div class="hero-left">
                    <h2>Срочно понадобился автомобиль, а своего нет?</h2>
                    <h3>Удобный сервис каршеринга поможет Вам в этом!</h3>

                    <a href="registration.html" class="btn">ЗАРЕГИСТРИРОВАТЬСЯ</a>

                    <p>*Пройдите регистрацию прямо сейчас и получите скидку в 50% на первую аренду</p>
                </div>

                <div class="hero-right">
                    <div class="circle"></div>
                    <img src="img/toyota.jpg" alt="car">
                </div>
            </div>
        </div>
        <div class="features">
            <div class="features-overlay">
                <div class="features-content">

                    <h2 class="features-title">Начало использования в три шага</h2>

                    <div class="steps">

                        <div class="step-card">
                            <img src="img/mdi_looks-one.png" class="step-icon" alt="1">
                            <p>
                                Зарегистрируйтесь. Введите данные паспорта, водительского удостоверения (категория B) и
                                привяжите банковскую карту.
                            </p>
                        </div>

                        <div class="step-card">
                            <img src="img/material-symbols_looks-two.png" class="step-icon" alt="2">
                            <p>
                                Начните бронирование. Выберите подходящий для Вас автомобиль, укажите дату и время.
                            </p>
                        </div>

                        <div class="step-card">
                            <img src="img/mdi_numeric-three-box.png" class="step-icon" alt="3">
                            <p>
                                Завершите поездку. В Ваших заказах нажмите кнопку «Завершить».
                            </p>
                        </div>

                    </div>

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