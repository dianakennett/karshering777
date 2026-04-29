<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$car_id = $_POST['car_id'];
$city = $_POST['city'];
$date_from = $_POST['date_from'];
$time_from = $_POST['time_from'];
$date_to = $_POST['date_to'];
$time_to = $_POST['time_to'];
$tariff = $_POST['tariff'];

$sql = "INSERT INTO bookings 
(user_id, car_id, city, date_from, time_from, date_to, time_to, tariff)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "iissssss",
    $user_id,
    $car_id,
    $city,
    $date_from,
    $time_from,
    $date_to,
    $time_to,
    $tariff
);

if ($stmt->execute()) {
    header("Location: ../cabinet.php");
    exit();
} else {
    echo "Ошибка бронирования";
}
?>