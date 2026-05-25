<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "Нет доступа";
    exit();
}

require 'db.php';

$name = $_POST['name'];
$category = $_POST['category'];
$price = $_POST['price'];
$body_type = $_POST['body_type'];
$fuel = $_POST['fuel'];
$transmission = $_POST['transmission'];
$power = $_POST['power'];
$engine_volume = $_POST['engine_volume'];
$size = $_POST['size'];

$imagePath = "";

if (!empty($_FILES['image']['name'])) {
    $imageName = time() . "_" . $_FILES['image']['name'];
    $imagePath = "img/cars/" . $imageName;

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../" . $imagePath
    );
}

$sql = "INSERT INTO cars 
(name, category, price, body_type, fuel, transmission, power, engine_volume, size, image)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssss",
    $name,
    $category,
    $price,
    $body_type,
    $fuel,
    $transmission,
    $power,
    $engine_volume,
    $size,
    $imagePath
);

if ($stmt->execute()) {
    header("Location: ../admin_cars.php");
    exit();
} else {
    echo "Ошибка добавления авто";
}
?>