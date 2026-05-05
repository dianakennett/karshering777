<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    exit("Нет доступа");
}

$id = $_SESSION['user_id'];

$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);

if (mb_strlen($first_name) < 2 || mb_strlen($last_name) < 2) {
    $_SESSION['message'] = "Имя и фамилия должны быть не короче 2 символов";
    header("Location: ../edit_profile.php");
    exit();
}

if (!preg_match("/^[А-Яа-яA-Za-zЁё\s-]+$/u", $first_name)) {
    $_SESSION['message'] = "Имя может содержать только буквы";
    header("Location: ../edit_profile.php");
    exit();
}

if (!preg_match("/^[А-Яа-яA-Za-zЁё\s-]+$/u", $last_name)) {
    $_SESSION['message'] = "Фамилия может содержать только буквы";
    header("Location: ../edit_profile.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = "Введите корректный email";
    header("Location: ../edit_profile.php");
    exit();
}

$sql = "UPDATE users SET first_name=?, last_name=?, email=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $first_name, $last_name, $email, $id);

if ($stmt->execute()) {
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['message'] = "Сохранено";

    header("Location: ../edit_profile.php");
    exit();
} else {
    $_SESSION['message'] = "Ошибка обновления";
    header("Location: ../edit_profile.php");
    exit();
}