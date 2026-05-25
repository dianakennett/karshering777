<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit("Нет доступа");
}

$id = $_POST['id'];
$name = $_POST['name'];
$category = $_POST['category'];
$price = $_POST['price'];
$body_type = $_POST['body_type'];
$fuel = $_POST['fuel'];
$transmission = $_POST['transmission'];
$power = $_POST['power'];
$engine_volume = $_POST['engine_volume'];
$size = $_POST['size'];

if (!empty($_FILES['image']['name'])) {
    $uploadDir = "../img/cars/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $imageName = time() . "_" . basename($_FILES['image']['name']);
    $imagePath = "img/cars/" . $imageName;

    move_uploaded_file($_FILES['image']['tmp_name'], "../" . $imagePath);

    $sql = "UPDATE cars SET 
        name=?, category=?, price=?, body_type=?, fuel=?, transmission=?, power=?, engine_volume=?, size=?, image=?
        WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssi", $name, $category, $price, $body_type, $fuel, $transmission, $power, $engine_volume, $size, $imagePath, $id);
} else {
    $sql = "UPDATE cars SET 
        name=?, category=?, price=?, body_type=?, fuel=?, transmission=?, power=?, engine_volume=?, size=?
        WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $name, $category, $price, $body_type, $fuel, $transmission, $power, $engine_volume, $size, $id);
}

$stmt->execute();

header("Location: ../cars.php");
exit();
