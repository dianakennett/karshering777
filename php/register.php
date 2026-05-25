<?php
session_start();

require_once __DIR__ . '/db.php';

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных");
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$login = $_POST['login'];
$password = $_POST['password'];
$password_repeat = $_POST['password_repeat'];

$_SESSION['old_first_name'] = $first_name;
$_SESSION['old_last_name'] = $last_name;
$_SESSION['old_email'] = $email;
$_SESSION['old_login'] = $login;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Введите корректный email";
    header("Location: ../registration.php");
    exit();
}

if ($password !== $password_repeat) {
    $_SESSION['error'] = "Пароли не совпадают";
    header("Location: ../registration.php");
    exit();
}

$check_login = mysqli_query($conn, "SELECT * FROM users WHERE login = '$login'");

if (mysqli_num_rows($check_login) > 0) {
    $_SESSION['error'] = "Такой логин уже существует";
    header("Location: ../registration.php");
    exit();
}

$check_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

if (mysqli_num_rows($check_email) > 0) {
    $_SESSION['error'] = "Такой пользователь уже существует";
    header("Location: ../registration.php");
    exit();
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

mysqli_query($conn, "
    INSERT INTO users (first_name, last_name, email, login, password)
    VALUES ('$first_name', '$last_name', '$email', '$login', '$password_hash')
");

$_SESSION['success'] = "Регистрация прошла успешно";

header("Location: ../login.php");
exit();
?>