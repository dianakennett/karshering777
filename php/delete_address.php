<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$address_id = $_POST['address_id'];

$sql = "DELETE FROM addresses WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $address_id, $user_id);
$stmt->execute();

header("Location: ../profile.php#addresses");
exit();
?>