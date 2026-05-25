<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare("DELETE FROM bookings WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM addresses WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();


$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

session_destroy();

header("Location: ../registration.php");
exit();
?>