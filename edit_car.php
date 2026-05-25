<?php
session_start();
require 'php/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit("Нет доступа");
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$car = $stmt->get_result()->fetch_assoc();

if (!$car) {
    exit("Автомобиль не найден");
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Редактирование авто</title>
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
                        <li class="active"><a href="info.html">О нас</a></li>
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
        <div class="admin-page">
            <div class="admin-card">

                <h1>Редактирование автомобиля</h1>

                <form action="php/update_car.php" method="POST" enctype="multipart/form-data" class="admin-form">

                    <input type="hidden" name="id" value="<?php echo $car['id']; ?>">

                    <div class="admin-form-grid">
                        <input type="text" name="name" value="<?php echo htmlspecialchars($car['name']); ?>" required>
                        <input type="text" name="category" value="<?php echo htmlspecialchars($car['category']); ?>" required>
                        <input type="text" name="price" value="<?php echo htmlspecialchars($car['price']); ?>" required>

                        <input type="text" name="body_type" value="<?php echo htmlspecialchars($car['body_type']); ?>">
                        <input type="text" name="fuel" value="<?php echo htmlspecialchars($car['fuel']); ?>">
                        <input type="text" name="transmission" value="<?php echo htmlspecialchars($car['transmission']); ?>">

                        <input type="text" name="power" value="<?php echo htmlspecialchars($car['power']); ?>">
                        <input type="text" name="engine_volume" value="<?php echo htmlspecialchars($car['engine_volume']); ?>">
                        <input type="text" name="size" value="<?php echo htmlspecialchars($car['size']); ?>">
                    </div>

                    <label class="file-label">
                        Новое фото автомобиля
                        <input type="file" name="image" accept="image/*">
                    </label>

                    <button type="submit" class="admin-btn">Сохранить изменения</button>

                </form>

            </div>
        </div>
    </div>

</body>

</html>