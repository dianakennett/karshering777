<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$new_password_repeat = $_POST['new_password_repeat'];

if ($new_password !== $new_password_repeat) {
    $_SESSION['message'] = "Новые пароли не совпадают";
    header("Location: ../edit_profile.php");
    exit();
}

$stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user || !password_verify($old_password, $user['password'])) {
    $_SESSION['message'] = "Старый пароль введён неверно";
    header("Location: ../edit_profile.php");
    exit();
}

$new_hash = password_hash($new_password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->bind_param("si", $new_hash, $user_id);
$stmt->execute();

$_SESSION['message'] = "Пароль успешно изменён";
header("Location: ../edit_profile.php");
exit();
?>