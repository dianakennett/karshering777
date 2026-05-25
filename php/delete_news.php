<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit("Нет доступа");
}

$news_id = $_POST['news_id'];

$stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
$stmt->bind_param("i", $news_id);
$stmt->execute();

header("Location: ../index.php");
exit();
