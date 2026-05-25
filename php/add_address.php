<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$title = trim($_POST['title']);
$address = trim($_POST['address']);
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
if (
    empty($address) ||
    preg_match('/^\d+\.\d+,\s*\d+\.\d+$/', $address)
) {
    $_SESSION['message'] = "Выберите адрес на карте, а не координаты";
    header("Location: ../profile.php#addresses");
    exit();
}
$sql = "INSERT INTO addresses (user_id, title, address, latitude, longitude) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $user_id, $title, $address, $latitude, $longitude);
$stmt->execute();

header("Location: ../profile.php#addresses");
exit();
?>