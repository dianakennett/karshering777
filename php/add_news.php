<?php
session_start();
require 'db.php';

$title = $_POST['title'];
$text = $_POST['text'];

$image_path = '';

if (!empty($_FILES['image']['name'])) {

    $image_name = time() . '_' . $_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../img/news/" . $image_name
    );

    $image_path = "img/news/" . $image_name;
}

$stmt = $conn->prepare("
    INSERT INTO news (title, text, image)
    VALUES (?, ?, ?)
");

$stmt->bind_param("sss", $title, $text, $image_path);

$stmt->execute();

header("Location: ../admin_news.php");
exit();
