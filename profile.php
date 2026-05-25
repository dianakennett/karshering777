<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'php/db.php';

$user_id = $_SESSION['user_id'];

$userQuery = $conn->prepare("SELECT * FROM users WHERE id = ?");
$userQuery->bind_param("i", $user_id);
$userQuery->execute();
$user = $userQuery->get_result()->fetch_assoc();

$avatar = !empty($user['avatar']) ? $user['avatar'] : 'img/default-avatar.png';

$addresses = $conn->query("
    SELECT * FROM addresses 
    WHERE user_id = $user_id 
    ORDER BY created_at DESC
");

$bookings = $conn->query("
    SELECT * FROM bookings 
    WHERE user_id = $user_id 
    ORDER BY created_at DESC
");

$favorites = $conn->query("
    SELECT 
        favorites.id AS favorite_id,
        favorites.car_id,
        cars.name
    FROM favorites
    JOIN cars ON favorites.car_id = cars.id
    WHERE favorites.user_id = $user_id
    ORDER BY favorites.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novodrive</title>

    <link rel="stylesheet" href="css/style.css">

    <script src="https://api-maps.yandex.ru/2.1/?apikey=bd7e7193-dcd7-4c06-8e42-c7e8c1342c63&lang=ru_RU"></script>
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

        <img src="<?php echo htmlspecialchars($avatar); ?>" class="profile-avatar" alt="avatar">

        <div class="profile-info">

            <div class="profile-top">

                <h2>
                    <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?>
                </h2>

            </div>

            <a href="edit_profile.php" class="edit-btn">
                Редактировать
            </a>

        </div>

    </div>

</div>

<div class="favorites">

    <div class="fav-tabs">

        <span class="fav-tab active" data-tab="cars">
            Избранные авто
        </span>

        <span class="fav-tab" data-tab="addresses">
            Мои адреса
        </span>

    </div>

    <div class="fav-list" id="cars">

        <?php if ($favorites && $favorites->num_rows > 0): ?>

            <?php while ($fav = $favorites->fetch_assoc()): ?>

                <div class="fav-item">

                    <a href="booking.php?car_id=<?php echo htmlspecialchars($fav['car_id']); ?>" class="fav-car-link">

                        <?php echo htmlspecialchars($fav['name']); ?>

                    </a>

                    <form action="php/remove_favorite.php" method="POST">

                        <input 
                            type="hidden" 
                            name="car_id" 
                            value="<?php echo htmlspecialchars($fav['car_id']); ?>"
                        >

                        <button type="submit" class="trash-btn">

                            <img 
                                src="img/maki_waste-basket.png" 
                                class="trash" 
                                alt="Удалить"
                            >

                        </button>

                    </form>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="fav-item">
                <span>У вас пока нет избранных автомобилей</span>
            </div>

        <?php endif; ?>

    </div>

    <div class="fav-list" id="addresses" style="display:none;">

        <form action="php/add_address.php" method="POST" class="address-form">

            <input 
                type="text" 
                name="title" 
                placeholder="Название: Дом, Работа..." 
                required
            >

            <input 
                type="text" 
                id="profileAddressText" 
                name="address" 
                placeholder="Выберите адрес на карте" 
                required
            >

            <input type="hidden" id="profileLat" name="latitude">
            <input type="hidden" id="profileLng" name="longitude">

            <div id="profileMap"></div>

            <button type="submit">
                Добавить адрес
            </button>

        </form>

        <?php if ($addresses && $addresses->num_rows > 0): ?>

            <?php while ($addr = $addresses->fetch_assoc()): ?>

                <div class="fav-item">

                    <span>

                        <b>
                            <?php echo htmlspecialchars($addr['title']); ?>
                        </b>

                        <br>

                        <?php echo htmlspecialchars($addr['address']); ?>

                    </span>

                    <form action="php/delete_address.php" method="POST">

                        <input 
                            type="hidden" 
                            name="address_id" 
                            value="<?php echo $addr['id']; ?>"
                        >

                        <button type="submit" class="trash-btn">

                            <img 
                                src="img/maki_waste-basket.png" 
                                class="trash" 
                                alt="delete"
                            >

                        </button>

                    </form>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="fav-item">
                <span>У вас пока нет сохранённых адресов</span>
            </div>

        <?php endif; ?>

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

                    <li>
                        <a href="admin_cars.php">Админ-панель</a>
                    </li>

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

function openTab(tabName) {

    tabs.forEach(tab => tab.classList.remove('active'));
    lists.forEach(list => list.style.display = 'none');

    const activeTab = document.querySelector(`.fav-tab[data-tab="${tabName}"]`);
    const activeList = document.getElementById(tabName);

    if (activeTab && activeList) {

        activeTab.classList.add('active');
        activeList.style.display = 'flex';

    }
}

tabs.forEach(tab => {

    tab.addEventListener('click', () => {

        const tabName = tab.dataset.tab;

        window.location.hash = tabName;

        openTab(tabName);

    });

});

ymaps.ready(function() {

    const addressInput = document.getElementById("profileAddressText");
    const latInput = document.getElementById("profileLat");
    const lngInput = document.getElementById("profileLng");

    const map = new ymaps.Map("profileMap", {
        center: [55.030199, 82.920430],
        zoom: 13
    });

    let placemark;

    map.events.add("click", function(e) {

        const coords = e.get("coords");

        if (placemark) {
            map.geoObjects.remove(placemark);
        }

        placemark = new ymaps.Placemark(coords, {}, {
            preset: "islands#redIcon"
        });

        map.geoObjects.add(placemark);

        addressInput.value = "Определяем адрес...";

        latInput.value = coords[0];
        lngInput.value = coords[1];

        ymaps.geocode(coords, {
            results: 1
        }).then(function(res) {

            const geoObject = res.geoObjects.get(0);

            if (geoObject) {

                addressInput.value = geoObject.getAddressLine();

            } else {

                addressInput.value = "";

                alert("Адрес не найден. Выберите точку ближе к зданию или дороге.");

            }

        }).catch(function() {

            addressInput.value = "";

            alert("Не удалось определить адрес. Проверьте API-ключ Яндекс.Карт.");

        });

    });

});

const startTab = window.location.hash.replace('#', '') || 'cars';

openTab(startTab);

</script>

</body>
</html>