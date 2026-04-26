<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "novodrive");

if (!$connect) {
    die("Ошибка подключения к базе данных");
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$login = $_POST['login'];
$password = $_POST['password'];
$password_repeat = $_POST['password_repeat'];

if ($password !== $password_repeat) {
    $_SESSION['message'] = "Пароли не совпадают";
    header("Location: /registration.html");
    exit();
}

$check_user = mysqli_query($connect, "SELECT * FROM users WHERE login = '$login'");

if (mysqli_num_rows($check_user) > 0) {
    $_SESSION['message'] = "Такой логин уже существует";
    header("Location: /registration.html");
    exit();
}

$password = password_hash($password, PASSWORD_DEFAULT);

mysqli_query($connect, "
    INSERT INTO users (first_name, last_name, email, login, password)
    VALUES ('$first_name', '$last_name', '$email', '$login', '$password')
");

$_SESSION['message'] = "Регистрация прошла успешно";

header("Location: /login.html");