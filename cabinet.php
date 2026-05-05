<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

require 'php/db.php';

$user_id = $_SESSION['user_id'];

$bookings = $conn->query("SELECT * FROM bookings WHERE user_id = $user_id ORDER BY created_at DESC");
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
                        <li><a href="#">Заказы</a></li>
                        <li class="profile">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="profile.php">
                                    <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?>
                                    <img src="img/ix_user-profile-filled.png" alt="person">
                                </a>
                            <?php else: ?>
                                <a href="login.html">
                                    Личный кабинет
                                    <img src="img/ix_user-profile-filled.png" alt="person">
                                </a>
                            <?php endif; ?>
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