<?php
session_start();
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
                        <li class="active"><a href="index.php">Главная</a></li>
                        <li><a href="tariffs.php">Тарифы</a></li>
                        <li><a href="info.php">О нас</a></li>
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

        <div class="hero-container">
            <div class="hero-info">
                <h1>Ваш личный автомобиль в любое время</h1>
            </div>

            <div class="hero-card">
                <div class="hero-left">
                    <h2>Срочно понадобился автомобиль, а своего нет?</h2>
                    <h3>Удобный сервис каршеринга поможет Вам в этом!</h3>

                    <a href="registration.php" class="btn">ЗАРЕГИСТРИРОВАТЬСЯ</a>

                    <p>*Пройдите регистрацию прямо сейчас и получите скидку в 50% на первую аренду</p>
                </div>

                <div class="hero-right">
                    <div class="circle"></div>
                    <img src="img/toyota.jpg" alt="car">
                </div>
            </div>
        </div>

        <?php
        require 'php/db.php';

        $news = $conn->query("
    SELECT * FROM news
    ORDER BY created_at DESC
");
        ?>

        <section class="news-section">

            <div class="container">

                <h2 class="news-title">Новости и обновления</h2>

                <div class="news-slider">

                    <?php while ($item = $news->fetch_assoc()): ?>

                        <div class="news-card" onclick="openNewsModal(<?php echo $item['id']; ?>)">

                            <?php if (!empty($item['image'])): ?>
                                <div class="news-image">
                                    <img src="<?php echo $item['image']; ?>" alt="">
                                </div>
                            <?php endif; ?>

                            <div class="news-content">
                                <?php if (!empty($item['title'])): ?>
                                    <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                <?php endif; ?>

                                <?php if (!empty($item['text'])): ?>
                                    <p><?php echo mb_substr(htmlspecialchars($item['text']), 0, 160); ?>...</p>
                                <?php endif; ?>
                            </div>

                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <div class="news-admin-actions" onclick="event.stopPropagation();">
                                    <a href="edit_news.php?id=<?php echo $item['id']; ?>" class="news-edit-btn">✎</a>

                                    <form action="php/delete_news.php" method="POST" onsubmit="return confirm('Удалить новость?');">
                                        <input type="hidden" name="news_id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" class="news-delete-btn">✕</button>
                                    </form>
                                </div>
                            <?php endif; ?>

                        </div>

                        <div class="news-modal" id="newsModal<?php echo $item['id']; ?>">
                            <div class="news-modal-box">
                                <button class="close-news" onclick="closeNewsModal(<?php echo $item['id']; ?>)">×</button>

                                <?php if (!empty($item['image'])): ?>
                                    <img src="<?php echo $item['image']; ?>" alt="">
                                <?php endif; ?>

                                <h2><?php echo htmlspecialchars($item['title']); ?></h2>

                                <p><?php echo nl2br(htmlspecialchars($item['text'])); ?></p>
                            </div>
                        </div>

                    <?php endwhile; ?>

                </div>

            </div>

        </section>
        <div class="features">
            <div class="features-overlay">
                <div class="features-content">

                    <h2 class="features-title">Начало использования в три шага</h2>

                    <div class="steps">

                        <div class="step-card">
                            <img src="img/mdi_looks-one.png" class="step-icon" alt="1">
                            <p>
                                Зарегистрируйтесь. Введите данные аккаунта,добавьте адреса.
                            </p>
                        </div>

                        <div class="step-card">
                            <img src="img/material-symbols_looks-two.png" class="step-icon" alt="2">
                            <p>
                                Начните бронирование. Выберите подходящий для Вас автомобиль, укажите дату и время.
                            </p>
                        </div>

                        <div class="step-card">
                            <img src="img/mdi_numeric-three-box.png" class="step-icon" alt="3">
                            <p>
                                Завершите поездку. В Ваших заказах нажмите кнопку «Завершить».
                            </p>
                        </div>

                    </div>

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
        function openNewsModal(id) {
            document.getElementById('newsModal' + id).classList.add('active');
        }

        function closeNewsModal(id) {
            document.getElementById('newsModal' + id).classList.remove('active');
        }
    </script>
</body>

</html>