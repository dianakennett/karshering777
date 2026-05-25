<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_POST['car_id'])) {
    header("Location: ../profile.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$car_id = $_POST['car_id'];

$sql = "DELETE FROM favorites WHERE car_id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $car_id, $user_id);
$stmt->execute();

header("Location: ../profile.php");
exit();
?>