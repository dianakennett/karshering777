<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit("Нет доступа");
}

$id = $_POST['id'];
$title = $_POST['title'];
$text = $_POST['text'];

if (!empty($_FILES['image']['name'])) {
    $imageName = time() . "_" . basename($_FILES['image']['name']);
    $imagePath = "img/news/" . $imageName;

    move_uploaded_file($_FILES['image']['tmp_name'], "../" . $imagePath);

    $stmt = $conn->prepare("UPDATE news SET title=?, text=?, image=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $text, $imagePath, $id);
} else {
    $stmt = $conn->prepare("UPDATE news SET title=?, text=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $text, $id);
}

$stmt->execute();

header("Location: ../index.php");
exit();
