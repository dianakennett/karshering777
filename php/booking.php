<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$car_id = $_POST['car_id'];
$start_address = $_POST['start_address'];
$return_address = $_POST['return_address'];
$date_from = $_POST['date_from'];
$time_from = $_POST['time_from'];
$date_to = $_POST['date_to'];
$time_to = $_POST['time_to'];
$tariff = $_POST['tariff'];

$sql = "INSERT INTO bookings 
(user_id, car_id, start_address, return_address, date_from, time_from, date_to, time_to, tariff)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "iisssssss",
    $user_id,
    $car_id,
    $start_address,
    $return_address,
    $date_from,
    $time_from,
    $date_to,
    $time_to,
    $tariff
);

if ($stmt->execute()) {
?>

    <!DOCTYPE html>
    <html lang="ru">

    <head>
        <meta charset="UTF-8">
        <title>Бронирование успешно</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>

        <div class="success-page">

            <div class="success-card">

                <div class="success-icon">✓</div>

                <h1>Бронирование успешно создано!</h1>

                <p>
                    Ваш заказ отобразится во вкладке
                    <a href="../orders.php">«Заказы»</a>
                </p>

                <a href="../orders.php" class="success-btn">
                    Перейти к заказам
                </a>

            </div>

        </div>

    </body>

    </html>

<?php
    exit();
}
