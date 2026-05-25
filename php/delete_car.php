<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit("Нет доступа");
}

$car_id = $_POST['car_id'];

$stmt = $conn->prepare("DELETE FROM cars WHERE id = ?");
$stmt->bind_param("i", $car_id);
$stmt->execute();

header("Location: ../cars.php");
exit();
