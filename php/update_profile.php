<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = "Некорректный email";
    header("Location: ../edit_profile.php");
    exit();
}

if (!empty($_FILES['avatar']['name'])) {
    $uploadDir = "../img/avatars/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES['avatar']['name']);
    $avatarPath = "img/avatars/" . $fileName;

    move_uploaded_file($_FILES['avatar']['tmp_name'], "../" . $avatarPath);

    $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, avatar = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $avatarPath, $user_id);
} else {
    $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $first_name, $last_name, $email, $user_id);
}

$stmt->execute();

$_SESSION['first_name'] = $first_name;
$_SESSION['last_name'] = $last_name;

$_SESSION['message'] = "Профиль обновлен!";

header("Location: ../edit_profile.php?success=1");
exit();
