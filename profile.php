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
                        <li class="profile dropdown">
                            <a href="profile.php" class="profile-btn">
                                <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?>
                                <img src="img/ix_user-profile-filled.png" alt="person">
                            </a>

                            <div class="dropdown-menu">
                                <a href="php/logout.php">Выйти</a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="profile-page">
            <div class="profile-container">
                <img src="img/user.jpg" alt="avatar" class="profile-avatar">

                <div class="profile-info">
                    <div class="profile-top">
                        <h2><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></h2>
                        <span class="premium">Premium</span>
                    </div>
                    <a href="edit_profile.php" class="edit-btn">Редактировать</a>
                </div>
            </div>
        </div>

        <div class="favorites">

            <div class="fav-tabs">
                <span class="fav-tab active" data-tab="cars">Избранные авто</span>
                <span class="fav-tab" data-tab="addresses">Мои адреса</span>
                <span class="fav-tab" data-tab="subscriptions">Моя подписка</span>
                <span class="fav-tab" data-tab="subscriptions">Мои бронирования</span>
            </div>


            <div class="fav-list" id="cars">
                <div class="fav-item">
                    <span>Toyota Rav4</span>
                    <img src="img/maki_waste-basket.png" class="trash">
                </div>
                <div class="fav-item">
                    <span>Honda Corvus</span>
                    <img src="img/maki_waste-basket.png" class="trash">
                </div>
            </div>


            <div class="fav-list" id="addresses" style="display:none;">
                <div class="fav-item">
                    <span>Чулым, ул.Кооперативная, 9</span>
                    <img src="img/maki_waste-basket.png" class="trash">
                </div>
            </div>


            <div class="fav-list" id="subscriptions" style="display:none;">
                <div class="fav-item">
                    <span>Премиум тариф — активен</span>
                </div>
            </div>
        </div>
        <div class="favorites">
            <div class="fav-list">
                <?php if ($bookings && $bookings->num_rows > 0): ?>
                    <?php while ($booking = $bookings->fetch_assoc()): ?>
                        <div class="fav-item">
                            <span>
                                <?php echo $booking['car_name']; ?> —
                                <?php echo $booking['date_from']; ?>
                                <?php echo $booking['time_from']; ?>
                            </span>
                            <span><?php echo $booking['status']; ?></span>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="fav-item">
                        <span>У вас пока нет бронирований</span>
                    </div>
                <?php endif; ?>
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
                    <li><a href="#">Заказы</a></li>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li><a href="admin_cars.php">Админка</a></li>
                    <?php endif; ?>

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
    <script>
        const tabs = document.querySelectorAll('.fav-tab');
        const lists = document.querySelectorAll('.fav-list');

        tabs.forEach(tab => {
            tab.onclick = () => {
                tabs.forEach(t => t.classList.remove('active'));
                lists.forEach(l => l.style.display = 'none');

                tab.classList.add('active');

                const activeList = document.getElementById(tab.dataset.tab);
                activeList.style.display = 'flex';
            }
        });
    </script>
</body>

</html>