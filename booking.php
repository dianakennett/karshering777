<?php
session_start();
require 'php/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['car_id'])) {
    echo "Автомобиль не выбран";
    exit();
}
$user_id = $_SESSION['user_id'];

$addresses = $conn->query("
    SELECT * FROM addresses 
    WHERE user_id = $user_id 
    ORDER BY created_at DESC
");

$car_id = $_GET['car_id'];

$stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$car = $stmt->get_result()->fetch_assoc();


if (!$car) {
    echo "Автомобиль не найден";
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
              <a href="index.php" class="logo">
                    <img src="img/logotp4.png" alt="Новодрайв">
                </a>
                <nav class="menu">
                    <ul>
                        <li><a href="index.php">Главная</a></li>
                        <li><a href="tariffs.php">Тарифы</a></li>
                        <li class="active"><a href="info.php">О нас</a></li>
                        <li class="profile">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="profile.php">
                                    <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?>
                                    <img src="img/ix_user-profile-filled.png" alt="person">
                                </a>
                            <?php else: ?>
                                <a href="login.php">
                                    Личный кабинет
                                    <img src="img/ix_user-profile-filled.png" alt="person">
                                </a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="booking-page">

            <div class="booking-container">

                <div class="booking-gallery">
                    <img src="<?php echo htmlspecialchars($car['image']); ?>" class="main-img" alt="car">
                </div>

                <div class="booking-info">
                    <h2><?php echo htmlspecialchars($car['name']); ?></h2>
                    <p class="booking-price"><?php echo htmlspecialchars($car['price']); ?></p>

                    <form action="php/booking.php" method="POST" class="booking-form">
                        <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">

                        <label>Точка отправления</label>
                        <select name="start_address" required>
                            <option value="">Выберите адрес</option>

                            <?php while ($addr = $addresses->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($addr['address']); ?>">
                                    <?php echo htmlspecialchars($addr['title']); ?> — <?php echo htmlspecialchars($addr['address']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <?php
                        $addresses->data_seek(0);
                        ?>

                        <label>Точка возврата</label>
                        <select name="return_address" required>
                            <option value="">Выберите адрес</option>

                            <?php while ($addr = $addresses->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($addr['address']); ?>">
                                    <?php echo htmlspecialchars($addr['title']); ?> — <?php echo htmlspecialchars($addr['address']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <label>Взять</label>
                        <input type="date" name="date_from" required>
                        <input type="time" name="time_from" required>

                        <label>Вернуть</label>
                        <input type="date" name="date_to" required>
                        <input type="time" name="time_to" required>

                        <select name="tariff" required>
                            <option value="Фикс">Фикс</option>
                            <option value="Поминутный">Поминутный</option>
                            <option value="Свой тариф">Свой тариф</option>
                            <option value="Подписка">Подписка</option>
                        </select>
                        <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
                        <button type="submit" class="book-btn">Забронировать</button>

                    </form>
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
    <script>
        function changeImg(el) {
            document.getElementById('mainImage').src = el.src;
        }
    </script>
</body>

</html>