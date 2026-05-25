<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$car_id = $_POST['car_id'];

$sql = "INSERT IGNORE INTO favorites (user_id, car_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $car_id);
$stmt->execute();

header("Location: ../cars.php");
exit();
