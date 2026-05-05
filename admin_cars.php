<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Доступ запрещён";
    exit();
}
require 'php/db.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админка | Novodrive</title>
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
                    <li><a href="cars.php">Автомобили</a></li>
                    <li><a href="profile.php">Профиль</a></li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                   <li><a href="admin_cars.php">Админка</a></li>
                       <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="admin-page">
        <div class="admin-card">

            <h1>Добавление автомобиля</h1>
            <p class="admin-subtitle">Заполните данные автомобиля для отображения на сайте</p>

            <form action="php/add_car.php" method="POST" enctype="multipart/form-data" class="admin-form">

                <div class="admin-form-grid">
                    <input type="text" name="name" placeholder="Название авто" required>
                    <input type="text" name="category" placeholder="Класс / категория" required>
                    <input type="text" name="price" placeholder="Цена" required>

                    <input type="text" name="body_type" placeholder="Тип кузова">
                    <input type="text" name="fuel" placeholder="Топливо">
                    <input type="text" name="transmission" placeholder="Коробка передач">

                    <input type="text" name="power" placeholder="Мощность">
                    <input type="text" name="engine_volume" placeholder="Объем двигателя">
                    <input type="text" name="size" placeholder="Размеры">
                </div>

                <label class="file-label">
                    Фото автомобиля
                    <input type="file" name="image" accept="image/*">
                </label>

                <button type="submit" class="admin-btn">Добавить авто</button>

            </form>

        </div>
    </main>

</div>

</body>
</html>