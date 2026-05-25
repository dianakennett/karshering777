<?php
session_start();
require 'php/db.php';
$where = [];

if (!empty($_GET['category'])) {
    $category = $conn->real_escape_string($_GET['category']);
    $where[] = "category LIKE '%$category%'";
}

if (!empty($_GET['body_type'])) {
    $body_type = $conn->real_escape_string($_GET['body_type']);
    $where[] = "body_type LIKE '%$body_type%'";
}

if (!empty($_GET['fuel'])) {
    $fuel = $conn->real_escape_string($_GET['fuel']);
    $where[] = "fuel LIKE '%$fuel%'";
}

if (!empty($_GET['transmission'])) {
    $transmission = $conn->real_escape_string($_GET['transmission']);
    $where[] = "transmission LIKE '%$transmission%'";
}

if (!empty($_GET['price_min'])) {
    $price_min = (int)$_GET['price_min'];
    $where[] = "CAST(price AS UNSIGNED) >= $price_min";
}

if (!empty($_GET['price_max'])) {
    $price_max = (int)$_GET['price_max'];
    $where[] = "CAST(price AS UNSIGNED) <= $price_max";
}

$sql = "SELECT * FROM cars";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY created_at DESC";

$cars = $conn->query($sql);
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
                        <li><a href="cars.php">Автомобили</a></li>
                        <li><a href="orders.php">Заказы</a></li>
                        <li class="profile dropdown">
                            <?php if (isset($_SESSION['user_id'])): ?>

                                <a href="profile.php" class="profile-btn">
                                    <?php
                                    echo htmlspecialchars(
                                        trim(($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? '')) ?: ($_SESSION['login'] ?? 'Профиль')
                                    );
                                    ?>
                                    <img src="img/ix_user-profile-filled.png" alt="person">
                                </a>

                                <div class="dropdown-menu">
                                    <a href="profile.php">Профиль</a>
                                    <a href="php/logout.php">Выйти</a>
                                </div>

                            <?php else: ?>

                                <a href="login.php" class="profile-btn">
                                    Личный кабинет
                                    <img src="img/ix_user-profile-filled.png" alt="person">
                                </a>

                            <?php endif; ?>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="cars-page">

            <div class="cars-header">
                <h2>Доступные автомобили</h2>
                <button class="filter-btn" id="openFilters">Фильтры</button>
            </div>
            <div class="filter-modal" id="filterModal">
                <div class="filter-box">
                    <button class="close-filter" id="closeFilters">×</button>

                    <h2>Фильтры</h2>

                    <form method="GET" action="cars.php" class="filter-form">

                        <input type="text" name="category" placeholder="Класс / категория">

                        <input type="text" name="body_type" placeholder="Тип кузова">

                        <select name="fuel">
                            <option value="">Топливо</option>
                            <option value="Бензин">Бензин</option>
                            <option value="Дизель">Дизель</option>
                            <option value="Электро">Электро</option>
                        </select>

                        <select name="transmission">
                            <option value="">Коробка передач</option>
                            <option value="АКПП">АКПП</option>
                            <option value="МКПП">МКПП</option>
                            <option value="Автомат">Автомат</option>
                        </select>

                        <div class="price-filter">
                            <input type="number" name="price_min" placeholder="Цена от">
                            <input type="number" name="price_max" placeholder="Цена до">
                        </div>

                        <button type="submit" class="apply-filter">Применить</button>

                        <a href="cars.php" class="reset-filter">Сбросить</a>

                    </form>
                </div>
            </div>
            <div class="cars-grid">

                <?php while ($car = $cars->fetch_assoc()): ?>
                    <div class="car-card">
                        <img src="/novodrive54/<?php echo htmlspecialchars($car['image']); ?>" alt="car">
                        <div class="car-info">
                            <h3>
                                <?php echo $car['name']; ?>
                                <span class="tag"><?php echo $car['category']; ?></span>
                            </h3>
                            <p><?php echo $car['price']; ?></p>
                        </div>

                        <div class="car-hover">
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <div class="car-admin-panel">
                                    <a href="edit_car.php?id=<?php echo $car['id']; ?>" class="admin-icon-btn edit-icon">✎</a>

                                    <form action="php/delete_car.php" method="POST" onsubmit="return confirm('Удалить автомобиль?');">
                                        <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                                        <button type="submit" class="admin-icon-btn delete-icon">✕</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                            <p>Кузов: <?php echo $car['body_type']; ?></p>
                            <p>Топливо: <?php echo $car['fuel']; ?></p>
                            <p>КПП: <?php echo $car['transmission']; ?></p>
                            <p>Мощность: <?php echo $car['power']; ?></p>
                            <p>Объем: <?php echo $car['engine_volume']; ?></p>
                            <p>Размер: <?php echo $car['size']; ?></p>
                            <p>Статус: <?php echo $car['status']; ?></p>

                            <div class="car-buttons">

                                <a href="booking.php?car_id=<?php echo $car['id']; ?>" class="book-btn">
                                    Забронировать
                                </a>

                                <form action="php/add_favorite.php" method="POST" class="favorite-form">
                                    <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">

                                    <button type="submit" class="favorite-btn">
                                         ♡ В избранное
                                    </button>
                                </form>

                            </div>
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
        const openFilters = document.getElementById('openFilters');
        const closeFilters = document.getElementById('closeFilters');
        const filterModal = document.getElementById('filterModal');

        openFilters.onclick = () => {
            filterModal.classList.add('active');
        };

        closeFilters.onclick = () => {
            filterModal.classList.remove('active');
        };

        filterModal.onclick = (e) => {
            if (e.target === filterModal) {
                filterModal.classList.remove('active');
            }
        };
    </script>
</body>

</html>