<?php
$conn = new mysqli("localhost", "root", "", "novodrive");

if ($conn->connect_error) {
    die("Ошибка подключения");
}
?>