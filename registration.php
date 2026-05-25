<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php if (isset($_SESSION['error'])): ?>
    <div class="error-notification">
        <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']);
        ?>
    </div>
<?php endif; ?>
<div class="login-page">
    <video autoplay muted loop class="bg-video">
        <source src="img/video_2026-04-16_23-08-03.mp4" type="video/mp4">
    </video>

    <div class="login-card">
        <h2>РЕГИСТРАЦИЯ</h2>

      <form action="php/register.php" method="POST">

    <input type="text" name="first_name" placeholder="Имя" required value="<?php echo htmlspecialchars($_SESSION['old_first_name'] ?? ''); ?>">
    <input type="text" name="last_name" placeholder="Фамилия" required value="<?php echo htmlspecialchars($_SESSION['old_first_name'] ?? ''); ?>">
    <input type="email" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($_SESSION['old_first_name'] ?? ''); ?>"> 
    <input type="text" name="login" placeholder="Логин" required value="<?php echo htmlspecialchars($_SESSION['old_first_name'] ?? ''); ?>">
    <input type="password" name="password" placeholder="Пароль" required>
    <input type="password" name="password_repeat" placeholder="Повторите пароль" required>

    <button type="submit">Зарегистрироваться</button>

    </form>

        <p>Уже есть аккаунт?</p>
        <a href="login.php">Войти</a>
    </div>

</div>
<?php
unset($_SESSION['old_first_name']);
unset($_SESSION['old_last_name']);
unset($_SESSION['old_email']);
unset($_SESSION['old_login']);
?>
</body>
</html>