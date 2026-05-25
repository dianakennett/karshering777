<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Добавление новостей</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="wrapper">

        <header class="site-header">

            <div class="container">

                <a href="index.php" class="logo">
                    <img src="img/logotp4.png" alt="logo">
                </a>

                <nav class="menu">
                    <ul>

                        <li>
                            <a href="index.php">Главная</a>
                        </li>

                        <li>
                            <a href="cars.php">Автомобили</a>
                        </li>

                        <li class="active">
                            <a href="admin_news.php">Новости</a>
                        </li>

                    </ul>
                </nav>

            </div>

        </header>

        <main class="admin-news-page">

            <div class="admin-news-card">

                <h1>Добавление новости</h1>

                <form
                    action="php/add_news.php"
                    method="POST"
                    enctype="multipart/form-data"
                    class="admin-news-form">

                    <input
                        type="text"
                        name="title"
                        placeholder="Заголовок новости">

                    <textarea
                        name="text"
                        placeholder="Текст новости"></textarea>

                    <div class="news-upload">

                        <label>
                            Изображение новости
                        </label>

                        <input
                            type="file"
                            name="image"
                            accept="image/*">

                    </div>

                    <button type="submit">
                        Опубликовать новость
                    </button>

                </form>

            </div>

        </main>

    </div>

</body>

</html>