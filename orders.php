<?php
session_start();
require 'php/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "
SELECT 
    bookings.*,
    cars.name AS car_name,
    cars.image AS car_image
FROM bookings
LEFT JOIN cars ON bookings.car_id = cars.id
WHERE bookings.user_id = ?
ORDER BY bookings.created_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Заказы | Novodrive</title>
    <link rel="stylesheet" href="css/style.css"><meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <div class="wrapper">

        <header class="site-header">
            <div class="container">
                <a href="index.php" class="logo">
                    <img src="img/logotp4.png" alt="Новодрайв">
                </a>

                <nav class="menu">
                    <ul>
                        <li><a href="index.php">Главная</a></li>
                        <li><a href="tariffs.php">Тарифы</a></li>
                        <li><a href="cars.php">Автомобили</a></li>
                        <li class="active"><a href="orders.php">Заказы</a></li>

                        <li class="profile dropdown">
                            <a href="profile.php" class="profile-btn">
                                <?php echo htmlspecialchars(trim(($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? '')) ?: ($_SESSION['login'] ?? 'Профиль')); ?>
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

        <main class="orders-page">
            <h1>Мои заказы</h1>

            <div class="orders-list">

                <?php if ($orders->num_rows > 0): ?>
                    <?php while ($order = $orders->fetch_assoc()): ?>

                        <div class="order-card">

                            <div class="order-left">
                                <?php if (!empty($order['car_image'])): ?>
                                    <img src="<?php echo $order['car_image']; ?>" alt="car">
                                <?php endif; ?>

                                <div>
                                    <h3><?php echo htmlspecialchars($order['car_name'] ?? 'Автомобиль'); ?></h3>

                                    <p>
                                        Адрес взятия:
                                        <?php echo htmlspecialchars($order['start_address']); ?>
                                    </p>

                                    <p>
                                        Адрес возврата:
                                        <?php echo htmlspecialchars($order['return_address']); ?>
                                    </p>
                                    <p>
                                        С <?php echo $order['date_from']; ?> <?php echo $order['time_from']; ?>
                                        до <?php echo $order['date_to']; ?> <?php echo $order['time_to']; ?>
                                    </p>
                                    <p>Тариф: <?php echo htmlspecialchars($order['tariff']); ?></p>
                                </div>
                            </div>

                            <div class="order-right">
                                <span class="order-status status-<?php echo mb_strtolower($order['status']); ?>">
                                    <?php echo $order['status']; ?>
                                </span>

                                <?php if ($order['status'] === 'Активен'): ?>
                                    <form action="php/cancel_booking.php" method="POST" onsubmit="return confirm('Вы уверены, что хотите отменить бронь?');">
                                        <input type="hidden" name="booking_id" value="<?php echo $order['id']; ?>">
                                        <button type="submit" class="cancel-btn">Отменить</button>
                                    </form>

                                    <form action="php/complete_booking.php" method="POST">
                                        <input type="hidden" name="booking_id" value="<?php echo $order['id']; ?>">
                                        <button type="submit" class="complete-btn">Завершить</button>
                                    </form>
                                <?php endif; ?>
                            </div>

                        </div>

                    <?php endwhile; ?>
                <?php else: ?>

                    <div class="order-card">
                        <p>У вас пока нет заказов</p>
                    </div>

                <?php endif; ?>

            </div>
        </main>
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