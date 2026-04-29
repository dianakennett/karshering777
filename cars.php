<?php
require 'php/db.php';
$cars = $conn->query("SELECT * FROM cars ORDER BY created_at DESC");
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
                    <li class="active"><a href="info.html">О нас</a></li>
                    <li class="profile">
                        <a href="login.html">Личный кабинет
                            <img src="img/ix_user-profile-filled.png" alt="person">
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="cars-page">

    <div class="cars-header">
        <h2>Доступные автомобили</h2>
        <button class="filter-btn">Фильтры</button>
    </div>

    <div class="cars-grid">

      <?php while ($car = $cars->fetch_assoc()): ?>
    <div class="car-card">
        <img src="<?php echo $car['image']; ?>" alt="car">

        <div class="car-info">
            <h3>
                <?php echo $car['name']; ?>
                <span class="tag"><?php echo $car['category']; ?></span>
            </h3>
            <p><?php echo $car['price']; ?></p>
        </div>

        <div class="car-hover">
            <p>Кузов: <?php echo $car['body_type']; ?></p>
            <p>Топливо: <?php echo $car['fuel']; ?></p>
            <p>КПП: <?php echo $car['transmission']; ?></p>
            <p>Мощность: <?php echo $car['power']; ?></p>
            <p>Объем: <?php echo $car['engine_volume']; ?></p>
            <p>Размер: <?php echo $car['size']; ?></p>
            <p>Статус: <?php echo $car['status']; ?></p>

           <a href="booking.php?car_id=<?php echo $car['id']; ?>" class="book-btn">
    Забронировать</a>
        </div>
    </div>
<?php endwhile; ?>

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