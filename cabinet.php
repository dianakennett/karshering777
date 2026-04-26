<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
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
            <div class="logo"><a href="index.html">НОВОДРАЙВ</a></div>
            <nav class="menu">
                <ul>
                    <li><a href="index.html">Главная</a></li>
                    <li><a href="tariffs.html">Тарифы</a></li>
                     <li><a href="#">Заказы</a></li>
                    <li class="profile">
                        <a href="profile.html">Имя Фамилия
                            <img src="img/ix_user-profile-filled.png" alt="person">
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
     <footer class="footer">
        <div class="footer-container">

            <div class="footer-left">
                <h3>НОВОДРАЙВ</h3>
                <p>Удобный сервис каршеринга для города</p>
            </div>

            <div class="footer-center">
                <ul>
                    <li><a href="#">Главная</a></li>
                    <li><a href="#">Тарифы</a></li>
                    <li><a href="#">О нас</a></li>
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