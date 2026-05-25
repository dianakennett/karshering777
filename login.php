<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="login-page">
        <video autoplay muted loop class="bg-video">
            <source src="img/video_2026-04-16_23-08-03.mp4" type="video/mp4">
        </video>
        <div class="login-card">
            <h2>ВХОД</h2>
            <form action="php/login.php" method="POST">
                <input type="text" name="login" placeholder="Логин" required value="<?php echo $_SESSION['old_login'] ?? ''; ?>">
                <input type="password" name="password" placeholder="Пароль" required>
                <button type="submit">Войти</button>
            </form>
            <p>Нет аккаунта?</p>
            <a href="registration.php">Зарегистрируйтесь!</a>
        </div>

    </div>
<?php unset($_SESSION['old_login']); ?>
</body>
<?php if (isset($_SESSION['error'])): ?>
    <div class="error-notification">
        <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        ?>
    </div>
<?php endif; ?>
</html>