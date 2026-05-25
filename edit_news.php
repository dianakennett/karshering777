<?php
session_start();
require 'php/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit("Нет доступа");
}

if (!isset($_GET['id'])) {
    exit("Новость не выбрана");
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$news = $stmt->get_result()->fetch_assoc();

if (!$news) {
    exit("Новость не найдена");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование новости</title>
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
                    <li><a href="cars.php">Автомобили</a></li>
                    <li><a href="admin_news.php">Новости</a></li>
                    <li><a href="profile.php">Профиль</a></li>
                </ul>
            </nav>

        </div>
    </header>

    <main class="edit-news-page">

        <div class="edit-news-card">

            <h1>Редактирование новости</h1>

            <?php if (!empty($news['image'])): ?>
                <img src="<?php echo htmlspecialchars($news['image']); ?>" class="current-news-img" alt="news">
            <?php endif; ?>

            <form action="php/update_news.php" method="POST" enctype="multipart/form-data" class="edit-news-form">

                <input type="hidden" name="id" value="<?php echo $news['id']; ?>">

                <input 
                    type="text" 
                    name="title" 
                    value="<?php echo htmlspecialchars($news['title']); ?>" 
                    placeholder="Заголовок новости"
                >

                <textarea name="text" placeholder="Текст новости"><?php echo htmlspecialchars($news['text']); ?></textarea>

                <label class="edit-news-file">
                    Новое изображение
                    <input type="file" name="image" accept="image/*">
                </label>

                <button type="submit">Сохранить изменения</button>

                <a href="index.php" class="back-news-btn">Вернуться на главную</a>

            </form>

        </div>

    </main>

</div>

</body>
</html>